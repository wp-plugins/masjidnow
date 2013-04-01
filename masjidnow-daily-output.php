<?php


$pray_time_high_lats_method = 1; //Midnight
$pray_time_time_format = 1; //time12


$date_time_now = new DateTime("now", $date_time_zone);

$masjid_name = $salah_timings->masjid_name;

$pray_time = new PrayTime($pray_time_calc_method);
$pray_time->setAsrMethod($pray_time_asr_juristic);
$pray_time->setHighLatsMethod($pray_time_high_lats_method);
$pray_time->setTimeFormat($pray_time_time_format);

$now_millis = $date_time_now->getTimestamp();
//gives timezone offset in seconds, we need to convert to hours
$time_zone = $date_time_now->getOffset()/3600;


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

$iqamah_times = array(
  "fajr" => $salah_timings->fajr,
  "dhuhr" => $salah_timings->dhuhr,
  "asr" => $salah_timings->asr,
  "maghrib" => $salah_timings->maghrib,
  "isha" => $salah_timings->isha,
);

$iqamah_date_str = $salah_timings->month."/".$salah_timings->day."/".$salah_timings->year; 
?>

<div class="masjidnow-container <?php echo($theme);?>">

 <div class='masjidnow-masjid-name'>Iqamah Timings for <br/><?php echo($masjid_name); ?></div>
 <table class='masjidnow-salah-timings-table'>
  
  <tr>
    <th></th>
    <th>Adhan</th>
    <th>Iqamah</th>
  </tr>
   
  <tr class='masjid-salah-row'>
    <td class='masjidnow-salah-name masjidnow-fajr'>Fajr</td>
    <td class='masjidnow-salah-time-adhan masjidnow-fajr'><?php echo($adhan_times["fajr"]); ?></td>
    <td class='masjidnow-salah-time-iqamah masjidnow-fajr'><?php echo($iqamah_times["fajr"]); ?></td>
  </tr>
  <tr class='masjid-salah-row masjid-salah-row-alt'>
    <td class='masjidnow-salah-name masjidnow-dhuhr'>Sunrise</td>
    <td class='masjidnow-salah-time-adhan masjidnow-sunrise'><?php echo($adhan_times["sunrise"]); ?></td>
    <td><!-- Empty but necessary --></td>
  </tr>
  <tr class='masjid-salah-row'>
    <td class='masjidnow-salah-name masjidnow-dhuhr'>Dhuhr</td>
    <td class='masjidnow-salah-time-adhan masjidnow-dhuhr'><?php echo($adhan_times["dhuhr"]); ?></td>
    <td class='masjidnow-salah-time-iqamah masjidnow-dhuhr'><?php echo($iqamah_times["dhuhr"]); ?></td>
  </tr>
  <tr class='masjid-salah-row masjid-salah-row-alt'>
    <td class='masjidnow-salah-name masjidnow-asr'>Asr</td>
    <td class='masjidnow-salah-time-adhan masjidnow-asr'><?php echo($adhan_times["asr"]); ?></td>
    <td class='masjidnow-salah-time-iqamah masjidnow-asr'><?php echo($iqamah_times["asr"]); ?></td>
  </tr>
  <tr class='masjid-salah-row'>
    <td class='masjidnow-salah-name masjidnow-maghrib'>Maghrib</td>
    <td class='masjidnow-salah-time-adhan masjidnow-maghrib'><?php echo($adhan_times["maghrib"]); ?></td>
    <td class='masjidnow-salah-time-iqamah masjidnow-maghrib'><?php echo($iqamah_times["maghrib"]); ?></td>
  </tr>
  <tr class='masjid-salah-row masjid-salah-row-alt'>
    <td class='masjidnow-salah-name masjidnow-isha'>Isha</td>
    <td class='masjidnow-salah-time-adhan masjidnow-isha'><?php echo($adhan_times["isha"]); ?></td>
    <td class='masjidnow-salah-time-iqamah masjidnow-isha'><?php echo($iqamah_times["isha"]); ?></td>
  </tr>
 </table>
 
 <div class='masjidnow-date'>
   Iqamah timings from <?php echo($iqamah_date_str) ?> <br/>
   Salah timings from <?php echo($date_time_now->format("D j M,  Y")) ?>
 </div>
 
</div>
