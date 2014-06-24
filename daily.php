<?php

function MasjidNowDaily_getCombinedOutput($attrs)
{
  extract( shortcode_atts( array(
    'masjid_id' => null,
    'month' => null,
    'show_adhan' => false,
    'show_monthly_info' => false
  ), $attrs ) );
  
  $shortcode = "masjidnow_daily";
 
  $outputTemplateFile = "daily-combined-output.php"; 
  
  // need to do two seperate initializers because 
  // setting one to the other will make them reference the same object
  $date_time_now = new DateTime("now", new DateTimeZone(get_option('timezone_string')));
  $date_time = new DateTime("now", new DateTimeZone(get_option('timezone_string')));
  
  
  $api_helper = new MasjidNow_APIHelper($masjid_id, $date_time, null, null);
  
  if(!empty($masjid_id))
  {
    $response = $api_helper->get_timings();
    $location_name = $response["raw"]->masjid->name;
    $show_iqamah = $api_helper->does_masjid_exist();
    // $show_adhan is defined in shortcode
    $iqamah_date_time = $api_helper->get_iqamah_date();
    $iqamah_date_str = "Iqamah timings for ".$api_helper->get_iqamah_date_str("D M j, Y");

    $is_timings_old = false;
    if($iqamah_date_time)
    {
      $today_date_time = new DateTime();
      $ms_diff = $today_date_time->format('U') - $iqamah_date_time->format('U');
      $days_diff = $ms_diff / (60*60*24);
      if ($days_diff >= 1) {
          $is_timings_old = true;
      } 
      // ********* THIS WAY REQUIRES PHP 5.3+ ****************
      //$diff = $iqamah_date_time->diff(new DateTime());
      //if ($diff->format('%a') > '0') {
      //    $is_timings_old = true;
      //} 
    }
    
    $adhan_times = $response["adhan_timings"];
    $iqamah_times = $response["iqamah_timings"];
    $masjid_path = $response["url"];
    $masjid_url = "http://www.masjidnow.com$masjid_path";
    $monthly_info = $response["monthly_info"];
    $url = $response["url"];
    
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


?>