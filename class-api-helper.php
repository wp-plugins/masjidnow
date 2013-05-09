<?php

namespace MasjidNow;

class APIHelper{

  const BASE_URL = "http://www.masjidnow.com/api/v2/salah_timings/";
  const PATH_DAILY = "daily.json?";
  const PATH_MONTHLY = "monthly.json?";
  const PARAM_MASJID_ID = "masjid_id";

  private $masjid_id;
  private $response;
  private $date_time_now;
  private $pray_time_settings;
  private $location;

  private $adhan_timings;
  private $iqamah_timings;
  private $masjid_exists;

  function __construct($masjid_id, $date_time_now, $pray_time_settings, $location){
    $this->response = null;
    $this->masjid_id = $masjid_id;
    $this->date_time_now = $date_time_now;
    $this->pray_time_settings = $pray_time_settings;
    $this->location = $location;
    $this->masjid_exists = false;
    $this->iqamah_timings = null;
    $this->adhan_timings = null;
  }

  function get_timings()
  {
    $adhan_timings = null;
    $iqamah_timings = null;
    $response = null;
    
    if(isset($this->masjid_id))
    {
      $response = $this->get_cached_response();
      if($response == null || !$this->has_today_timing($response))
      {
        //cache miss, so make api request
        $response = $this->download_timings($this->masjid_id);
      }
      
      $this->response = $response;
      
      if($response != null)
      {
        $this->masjid_exists = true;
      }
      
      $adhan_timings = $this->get_adhan_timing($response);
      $iqamah_timings = $this->get_iqamah_timing($response);
    }
    else
    {
      //force calculated timings
      $adhan_timings = $this->get_adhan_timing(null);
    }
    
    $this->iqamah_timings = $iqamah_timings;
    $this->adhan_timings = $adhan_timings;
    
    
    return array(
      "adhan_timings" => $adhan_timings,
      "iqamah_timings" => $iqamah_timings,
      "raw" => $response
    );
  }
  
  function get_monthly_timings(){
    $adhan_timings = null;
    $iqamah_timings = null;
    $response = null;
    
    if(isset($this->masjid_id))
    {
      $response = $this->get_cached_response();
      if($response == null || !$this->has_today_timing($response))
      {
        //cache miss, so make api request
        $response = $this->download_timings($this->masjid_id);
      }
      
      $this->response = $response;
      
      if($response != null)
      {
        $this->masjid_exists = true;
      }
      
      if($response != null && isset($response->masjid) && isset($response->masjid->salah_timings))
      {
        $iqamah_timings = $response->masjid->salah_timings;
      }
      else
      {
        $iqamah_timings = null;
      }
    }
    
    return array(
      "iqamah_timings" => $iqamah_timings,
      "raw" => $response
    );
  }
  
  function does_masjid_exist()
  {
    return $this->masjid_exists;
  }
  
  function get_cached_response()
  {
    return null;
  }

  function download_timings($masjid_id)
  {
    $url = $this->get_monthly_timings_url($masjid_id);
    $response = @file_get_contents($url);
    if($response !== false)
    {
      $response = json_decode($response);
      return $response;
    }
    else
    {
      return null;
    }
  }
  
  function get_iqamah_timing($response)
  {
    if($response != null && isset($response->masjid) && isset($response->masjid->salah_timings))
    {
      $salah_timing = $this->get_closest_timing($this->date_time_now, $response->masjid->salah_timings);
      $iqamah_timings = array(
        "fajr" => $salah_timing->fajr,
        "dhuhr" => $salah_timing->dhuhr,
        "asr" => $salah_timing->asr,
        "maghrib" => $salah_timing->maghrib,
        "isha" => $salah_timing->isha,
        "month" => $salah_timing->month - 1,
        "day" => $salah_timing->day,
        "year" => $salah_timing->year,
      );
    }
    else
    {
      $iqamah_timings = array(
        "fajr" => "---",
        "dhuhr" => "---",
        "asr" => "---",
        "maghrib" => "---",
        "isha" => "---",
        "month" => $this->date_time_now->format("m"),
        "day" => $this->date_time_now->format("d"),
        "year" => $this->date_time_now->format("Y"),
      );
    }
    return $iqamah_timings;
  }
  
  function get_iqamah_date($format)
  {
    if(isset($this->iqamah_timings))
    {
      $iqamah_timings = $this->iqamah_timings;
      $day = $iqamah_timings["day"];
      $month = $iqamah_timings["month"] + 1;
      $year = $iqamah_timings["year"];
      $iqamah_date_time = new \DateTime("$year-$month-$day");
      return $iqamah_date_time->format($format);
    }
    else
    {
      return "No iqamah timings available for this date.";
    }
  }
    
  function get_closest_timing($date_time, $salah_timings)
  {
    $day = $date_time->format('d');
    $month = $date_time->format('m');
    $year = $date_time->format('Y');
    $timing = $salah_timings[0];
    //assumes the salah timings array is sorted, lowest month and day first and increasing
    for($i =0; $i < count($salah_timings); $i++)
    {
      $timing = $salah_timings[$i]->salah_timing;
      if($timing->day >= $day && $timing->month >= $month)
      {
        return $timing;
      }
    }
    
    return $timing;
  }
  
  function get_monthly_timings_url($masjid_id)
  {
    return self::BASE_URL.self::PATH_MONTHLY.self::PARAM_MASJID_ID."=".$masjid_id;
  }
  
  function get_daily_timings_url($masjid_id)
  {
    return self::BASE_URL.self::PATH_DAILY.self::PARAM_MASJID_ID."=".$masjid_id;
  }
  
  function get_adhan_timing($response)
  {
    if($this->response_has_adhan($response))
    {
      //get the timings
      return $this->extract_adhan_timing($response);
    }
    else
    {
      //we have to calculate the timings locally
      return $this->calculate_local_timing();
    }
  }
  
  function extract_adhan_timing($response)
  {
    for($i =0; $i < count($response->masjid->salah_timings); $i++)
    {
      $timing = $response->masjid->salah_timings[$i]->salah_timing;
      $month = $this->date_time_now->format("m");
      $day = $this->date_time_now->format("d");
      if($timing->month == $month && $timing->day == $day)
      {
        $adhan_timing = array(
          "fajr" => $timing->fajr_adhan,
          "sunrise" => $timing->sunrise_adhan,
          "dhuhr" => $timing->dhuhr_adhan,
          "asr" => $timing->asr_adhan,
          "maghrib" => $timing->maghrib_adhan,
          "isha" => $timing->isha_adhan,
        );
        return $adhan_timing;
      }
    }
  }
  
  function calculate_local_timing()
  {
    $location = $this->location;
    //gives timezone offset in seconds, we need to convert to hours
    $time_zone = $this->date_time_now->getOffset()/3600;
    $pray_time = PrayTimeHelper::get_pray_time($this->pray_time_settings);
    $now_millis = $this->date_time_now->getTimestamp();
    $pray_time->getPrayerTimes($now_millis, $location["latitude"], $location["longitude"], $time_zone);
    $calculated_timings = $pray_time->getPrayerTimes($now_millis, $location["latitude"], $location["longitude"], $time_zone);
    $adhan_timings = array(
      "fajr" => $calculated_timings[0],
      "sunrise" => $calculated_timings[1],
      "dhuhr" => $calculated_timings[2],
      "asr" => $calculated_timings[3],
      "maghrib" => $calculated_timings[4],
      //"sunset" => $calculated_timings[5],
      "isha" => $calculated_timings[6],
    );
    return $adhan_timings;
  }
  
  function response_has_adhan($response)
  {
    if($response && isset($response->masjid) && isset($response->masjid->salah_timings))
    {  
      for($i =0; $i < count($response->masjid->salah_timings); $i++)
      {
        $timing = $response->masjid->salah_timings[$i]->salah_timing;
        $month = $this->date_time_now->format("m");
        $day = $this->date_time_now->format("d");
        if($timing->month == $month && $timing->day == $day)
        {
          return true;
        }
      }
    }
  }

}

?>
