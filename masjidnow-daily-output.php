<?php


$pray_time_high_lats_method = 1; //Midnight
$pray_time_time_format = 1; //time12

$date_time_now = new DateTime("now", $date_time_zone);
  
$adhan_times = array(
  "fajr" => "",
  "sunrise" => "",
  "dhuhr" => "",
  "asr" => "",
  "maghrib" => "",
  "sunset" => "",
  "isha" => "",
);

$iqamah_times = array(
  "fajr" => "",
  "dhuhr" => "",
  "asr" => "",
  "maghrib" => "",
  "isha" => "",
);

$iqamah_date_str = "";

$api_iqamah_timings_exist = $response && isset($response->masjid) && isset($response->masjid->salah_timings);

$response_valid = $response != NULL;
$masjid_exists = $response != NULL && isset($response->masjid);

$should_calculate_adhan = true;

//figure out if we should calculate the adhan timings
if($api_iqamah_timings_exist)
{
  for($i =0; $i < count($response->masjid->salah_timings); $i++)
  {
    $timing = $response->masjid->salah_timings[$i]->salah_timing;
    $month = $date_time_now->format("m");
    $day = $date_time_now->format("d");
    if($timing->month == $month && $timing->day == $day)
    {
      $should_calculate_adhan = false;
    }
  }
}

if($masjid_exists)
{
  $masjid_name = $response->masjid->name;
}
else
{
  if(isset($masjid_id))
  {
    $masjid_name = "Masjid with id $masjid_id Not Found";
  }
  else
  {
    $masjid_name = "$latitude, $longitude";
  }
}

if($should_calculate_adhan)
{
  
  $now_millis = $date_time_now->getTimestamp();
  //gives timezone offset in seconds, we need to convert to hours
  $time_zone = $date_time_now->getOffset()/3600;
  $pray_time = new PrayTime($pray_time_calc_method);
  $pray_time->setAsrMethod($pray_time_asr_juristic);
  $pray_time->setHighLatsMethod($pray_time_high_lats_method);
  $pray_time->setTimeFormat($pray_time_time_format);
  $calculated_times = $pray_time->getPrayerTimes($now_millis, $latitude, $longitude, $time_zone);
  $adhan_times = array(
    "fajr" => $calculated_times[0],
    "sunrise" => $calculated_times[1],
    "dhuhr" => $calculated_times[2],
    "asr" => $calculated_times[3],
    "maghrib" => $calculated_times[4],
    "sunset" => $calculated_times[5],
    "isha" => $calculated_times[6],
  );
}
else if(!$should_calculate_adhan && $api_iqamah_timings_exist)
{
  $masjid = $response->masjid;
  $salah_timings = $masjid->salah_timings;
  $salah_timing = $this->get_closest_timing($date_time_now, $salah_timings); 
  
  $adhan_times = array(
      "fajr" => $salah_timing->fajr_adhan,
      "sunrise" => $salah_timing->sunrise_adhan,
      "dhuhr" => $salah_timing->dhuhr_adhan,
      "asr" =>$salah_timing->asr_adhan,
      "maghrib" => $salah_timing->maghrib_adhan,
      "isha" => $salah_timing->isha_adhan
    );
}



if($api_iqamah_timings_exist)
{
  $masjid = $response->masjid;
  $masjid_name = $masjid->name;
  if(isset($masjid->salah_timings))
  {   
    $iqamah_times = array(
      "fajr" => $salah_timing->fajr,
      "dhuhr" => $salah_timing->dhuhr,
      "asr" => $salah_timing->asr,
      "maghrib" => $salah_timing->maghrib,
      "isha" => $salah_timing->isha,
    );
    
    $iqamah_date_time = new DateTime($salah_timing->year."-".$salah_timing->month."-".$salah_timing->day);
    $iqamah_date_str = $iqamah_date_time->format("D M j, Y");
  }  

}


//$iqamah_date_str = $salah_timings->month."/".$salah_timings->day."/".$salah_timings->year; 
?>
<?php 
  if(!empty($title))
  {
    echo($before_title . $title . $after_title);
  }
?>     

<?php
  if($api_iqamah_timings_exist)
  {
  ?>
      <script type="text/javascript">
        WPMasjidNowWidget.saveTimings(<?php echo(json_encode($response->masjid)) ?>);
      </script>
  <?php
  }
?>
 
<div class="masjidnow-container <?php echo($theme);?>">

  <div class="masjidnow-prev-day"></div>
  <div class="masjidnow-next-day"></div>

 <div class='masjidnow-date'>
  <?php echo($date_time_now->format("D M j, Y"))?>
 </div>

 <table class='masjidnow-salah-timings-table'>
  
  <tr>
    <th></th>
    <th>Adhan</th>
    <?php if($api_iqamah_timings_exist) { ?>
      <th>Iqamah</th>
    <?php } ?>
  </tr>
   
  <tr class='masjidnow-salah-row'>
    <td class='masjidnow-salah-name masjidnow-fajr'>Fajr</td>
    <td class='masjidnow-salah-time-adhan masjidnow-fajr'><?php echo($adhan_times["fajr"]); ?></td>
    <?php if($api_iqamah_timings_exist) { ?>
      <td class='masjidnow-salah-time-iqamah masjidnow-fajr'><?php echo($iqamah_times["fajr"]); ?></td>
    <?php } ?>
  </tr>
  <tr class='masjidnow-salah-row masjid-salah-row-alt'>
    <td class='masjidnow-salah-name masjidnow-dhuhr'>Sunrise</td>
    <td class='masjidnow-salah-time-adhan masjidnow-sunrise'><?php echo($adhan_times["sunrise"]); ?></td>
    <?php if($api_iqamah_timings_exist) { ?>
      <td><!-- Empty but necessary --></td>
    <?php } ?>
  </tr>
  <tr class='masjidnow-salah-row'>
    <td class='masjidnow-salah-name masjidnow-dhuhr'>Dhuhr</td>
    <td class='masjidnow-salah-time-adhan masjidnow-dhuhr'><?php echo($adhan_times["dhuhr"]); ?></td>
    <?php if($api_iqamah_timings_exist) { ?>
      <td class='masjidnow-salah-time-iqamah masjidnow-dhuhr'><?php echo($iqamah_times["dhuhr"]); ?></td>
    <?php } ?>
  </tr>
  <tr class='masjidnow-salah-row masjid-salah-row-alt'>
    <td class='masjidnow-salah-name masjidnow-asr'>Asr</td>
    <td class='masjidnow-salah-time-adhan masjidnow-asr'><?php echo($adhan_times["asr"]); ?></td>
    <?php if($api_iqamah_timings_exist) { ?>
      <td class='masjidnow-salah-time-iqamah masjidnow-asr'><?php echo($iqamah_times["asr"]); ?></td>
    <?php } ?>
  </tr>
  <tr class='masjidnow-salah-row'>
    <td class='masjidnow-salah-name masjidnow-maghrib'>Maghrib</td>
    <td class='masjidnow-salah-time-adhan masjidnow-maghrib'><?php echo($adhan_times["maghrib"]); ?></td>
    <?php if($api_iqamah_timings_exist) { ?>
      <td class='masjidnow-salah-time-iqamah masjidnow-maghrib'><?php echo($iqamah_times["maghrib"]); ?></td>
    <?php } ?>
  </tr>
  <tr class='masjidnow-salah-row masjid-salah-row-alt'>
    <td class='masjidnow-salah-name masjidnow-isha'>Isha</td>
    <td class='masjidnow-salah-time-adhan masjidnow-isha'><?php echo($adhan_times["isha"]); ?></td>
    <?php if($api_iqamah_timings_exist) { ?>
      <td class='masjidnow-salah-time-iqamah masjidnow-isha'><?php echo($iqamah_times["isha"]); ?></td>
    <?php } ?>
  </tr>
 </table>
 
 <div class='masjidnow-iqamah-date'>
   Iqamah timings for <?php echo($iqamah_date_str) ?> <br/>
 </div>
 
 <div class='masjidnow-masjid-name'>
  <?php echo($masjid_name); ?>
 </div>
 
</div>
