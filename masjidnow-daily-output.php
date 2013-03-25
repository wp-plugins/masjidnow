<?php

$masjid_name = $salah_timings->masjid_name;
$fajr = $salah_timings->fajr;
$dhuhr = $salah_timings->dhuhr;
$asr = $salah_timings->asr;
$maghrib = $salah_timings->maghrib;
$isha = $salah_timings->isha;

$date = $salah_timings->month."/".$salah_timings->day."/".$salah_timings->year; 
?>

<div class="masjidnow-container <?php echo($theme);?>">

 <div class='masjidnow-masjid-name'>Iqamah Timings for <br/><?php echo($masjid_name); ?></div>
 <table class='masjidnow-salah-timings-table'>
  <tr class='masjid-salah-row'>
    <td class='masjidnow-salah-name masjidnow-fajr'>Fajr</td>
    <td class='masjidnow-salah-time masjidnow-fajr'><?php echo($fajr); ?></td>
  </tr>
  <tr class='masjid-salah-row masjid-salah-row-alt'>
    <td class='masjidnow-salah-name masjidnow-dhuhr'>Dhuhr</td>
    <td class='masjidnow-salah-time masjidnow-dhuhr'><?php echo($dhuhr); ?></td>
  </tr>
  <tr class='masjid-salah-row'>
    <td class='masjidnow-salah-name masjidnow-asr'>Asr</td>
    <td class='masjidnow-salah-time masjidnow-asr'><?php echo($asr); ?></td>
  </tr>
  <tr class='masjid-salah-row masjid-salah-row-alt'>
    <td class='masjidnow-salah-name masjidnow-maghrib'>Maghrib</td>
    <td class='masjidnow-salah-time masjidnow-maghrib'><?php echo($maghrib); ?></td>
  </tr>
  <tr class='masjid-salah-row'>
    <td class='masjidnow-salah-name masjidnow-isha'>Isha</td>
    <td class='masjidnow-salah-time masjidnow-isha'><?php echo($isha); ?></td>
  </tr>
 </table>
 
 <div class='masjidnow-date'>From <?php echo($date) ?></div>
 
</div>
