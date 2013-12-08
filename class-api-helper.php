<?php

class MasjidNow_APIHelper{

  const BASE_URL = "http://www.masjidnow.com/api/v2/salah_timings/";
  const PATH_DAILY = "daily.json?";
  const PATH_MONTHLY = "monthly.json?";
  const PARAM_MASJID_ID = "masjid_id";
  const PARAM_MONTH = "month";

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
    $date_time_now = new DateTime("now", new DateTimeZone(get_option('timezone_string')));
    $month = $date_time_now->format("n");
    if(isset($this->masjid_id))
    {
      $response = $this->get_cached_timings($month);
      if($response == null)
      {
        //cache miss, so make api request
        $response = $this->download_timings($this->masjid_id, $month);
      }
      
      $this->response = $response;
      
      if($response != null)
      {
        $this->masjid_exists = true;
        $this->cache_timings($response, $month);
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
  
  function get_monthly_timings($month){
    $adhan_timings = null;
    $iqamah_timings = null;
    $response = null;
    
    if(isset($this->masjid_id))
    {
      $response = $this->get_cached_timings($month);
      if($response == null)
      {
        //cache miss, so make api request
        $response = $this->download_timings($this->masjid_id, $month);
      }
      
      $this->response = $response;
      
      if($response != null)
      {
        $this->masjid_exists = true;
        $this->cache_timings($response, $month);
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
      "salah_timings" => $iqamah_timings,
      "raw" => $response
    );
  }
  
  function does_masjid_exist()
  {
    return $this->masjid_exists;
  }
  
  function get_cache_key($month)
  {
    $cache_option_key = "masjidnow-cached-api-response-$month";
    return $cache_option_key;
  }
  
  function get_cache_timestamp_key($month)
  {
    $option_key = "masjidnow-cached-api-response-$month-timestamp";
    return $option_key;
  }
  
  function cache_timings($response, $month)
  {
    if($response != null)
    {
      update_option($this->get_cache_key($month), $response);
      update_option($this->get_cache_timestamp_key($month), time());
    }
  }
  
  function get_cached_timings($month)
  {
    $cache_option_key = $this->get_cache_key($month);
    $cache_timestamp_option_key = $this->get_cache_timestamp_key($month);
    $cached_response = get_option($cache_option_key, null);
    
    if($cached_response == null)
    {
      return null;
    }
    
    //firstly, discard if older than 15 days
    $cached_timestamp = get_option($cache_timestamp_option_key, 0);
    if(time() - $cached_timestamp > 15*24*3600)
    {
      //echo("Invalidating cache because it is too old!");
      $this->invalidate_cache($month);
      return null;
    }
    
    //now check if the stored response has the actual timings wanted
    if($this->has_requested_timing($cached_response, $month))
    {
      //echo("response was cached at ".$cached_timestamp);
      //echo("returning cached response.");
      return $cached_response;
    }
    else
    {
      //echo("cached response does not have timing");
      $this->invalidate_cache($month);
      return null;
    }
  }
  
  function invalidate_cache($month)
  {
    delete_option($this->get_cache_key);
    delete_option($this->get_cache_timestamp_key);
  }
  
  function has_requested_timing($response, $month, $day = null)
  {
    $date_time_now = new DateTime("now");
    if($day == null)
    {
      $day = $date_time_now->format("d");
    }
    $date_time = new DateTime($date_time_now->format("y")."-".$month."-".$day);
    
    if($response != null && isset($response->masjid) && isset($response->masjid->salah_timings))
    {
      $salah_timing = $this->get_closest_timing($date_time, $response->masjid->salah_timings);
      if($salah_timing != null)
      {
        return true;
      }
    }
    
    return false;
  }

  function download_timings($masjid_id, $month)
  {
    $url = $this->get_monthly_timings_url($masjid_id, $month);
    $args = array(
      'method'      =>    'GET',
      'timeout'     =>    5,
      'redirection' =>    5,
      'httpversion' =>    '1.0',
      'blocking'    =>    true,
      'headers'     =>    array(),
      'body'        =>    null,
      'cookies'     =>    array()
    );
    $response = wp_remote_get( $url, $args );
    if( is_wp_error( $response ) || $response["body"] == "") {
       $error_message = $response->get_error_message();
       echo "<!-- MasjidNow Widget: Something went wrong: $error_message -->";
       return null;
    } else {
      $response = json_decode($response["body"]);
      return $response;
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
  
  function get_iqamah_date()
  {
    if(isset($this->iqamah_timings))
    {
      $iqamah_timings = $this->iqamah_timings;
      $day = $iqamah_timings["day"];
      $month = $iqamah_timings["month"] + 1;
      $year = $iqamah_timings["year"];
      $iqamah_date_time = new DateTime("$year-$month-$day");
      return $iqamah_date_time;
    }
    else
    {
      return null;
    }
  }
  
  function get_iqamah_date_str($format)
  {
    $date = $this->get_iqamah_date();
    if($date)
    {
        return $date->format($format);
    }
    return "No iqamah timings available for this date.";
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
  
  function get_monthly_timings_url($masjid_id, $month)
  {
    $url = self::BASE_URL.self::PATH_MONTHLY.self::PARAM_MASJID_ID."=".$masjid_id."&".self::PARAM_MONTH."=".$month;
    //echo("Using url $url");
    return $url;
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
    $pray_time = MasjidNow_PrayTimeHelper::get_pray_time($this->pray_time_settings);
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
