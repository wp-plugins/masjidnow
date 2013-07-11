<?php

function MasjidNowMonthly_getOutput($attrs)
{
  extract( shortcode_atts( array(
    'masjid_id' => null,
  ), $attrs ) );
  
  $date_time_now = new DateTime("now", new DateTimeZone(get_option('timezone_string')));
  
  if(!empty($masjid_id))
  {
    $timings = MasjidNowMonthly_get_timings($masjid_id, $date_time_now, null, null);
    ob_start();
    include("monthly-output.php");
    $output_string = ob_get_contents();
    ob_end_clean();
    return $output_string;
  }
  else
  {
    return "ERROR! Please set the masjid_id by adding it to the end of the shortcode. (ie. [masjidnow_monthly masjid_id=1234])";
  }
  
}

function MasjidNowMonthly_get_timings($masjid_id, $date_time_now)
{
  $api_helper = new MasjidNow_APIHelper($masjid_id, $date_time_now, null, null);
  $timings = $api_helper->get_monthly_timings();
  return $timings["iqamah_timings"];
}

?>
