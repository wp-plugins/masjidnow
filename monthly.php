<?php

function MasjidNowMonthly_getOutput($attrs, $iqamah)
{
  $defaults = array(
    'masjid_id' => null,
    'month' => null,
    'title' => ($iqamah ? "Iqamah Timings" : "Adhan Timings")
  );
  extract( shortcode_atts( $defaults, $attrs ) );
 
  $prayer_names = get_option("masjidnow-prayer-names", array(
    "fajr" => "Fajr",
    "sunrise" => "Sunrise",
    "dhuhr" => "Dhuhr",
    "asr" => "Asr",
    "maghrib" => "Maghrib",
    "isha" => "Isha"
  ));
 
  $shortcode = $iqamah ? "masjidnow_monthly" : "masjidnow_monthly_adhan";
  $outputTemplateFile = $iqamah ? "monthly-iqamah-output.php" : "monthly-adhan-output.php"; 
  
  // need to do two seperate initializers because 
  // setting one to the other will make them reference the same object
  $date_time_now = new DateTime("now", new DateTimeZone(get_option('timezone_string')));
  $date_time = new DateTime("now", new DateTimeZone(get_option('timezone_string')));
  
  if(isset($month))
  {
    $month = intval($month);
    if($month != $date_time_now->format("n"))
    {
      $date_time->setDate($date_time_now->format("Y"), $month , 1);
    }
  }
  
  if(!is_null($masjid_id))
  {
    $timings = MasjidNowMonthly_get_timings($masjid_id, $date_time, null, null);
    ob_start();
    include($outputTemplateFile);
    $output_string = ob_get_contents();
    ob_end_clean();
    return $output_string;
  }
  else
  {
    return "ERROR! Please set the masjid_id by adding it to the end of the shortcode. (ie. [$shortcode masjid_id=1234])";
  }
}

function MasjidNowMonthly_getIqamahOutput($attrs)
{
  return MasjidNowMonthly_getOutput($attrs, true);  
}

function MasjidNowMonthly_getAdhanOutput($attrs)
{
  return MasjidNowMonthly_getOutput($attrs, false);
}

function MasjidNowMonthly_get_timings($masjid_id, $date_time)
{
  $api_helper = new MasjidNow_APIHelper($masjid_id, $date_time, null, null);
  $timings = $api_helper->get_monthly_timings($date_time->format("n"));
  return $timings["salah_timings"];
}

?>
