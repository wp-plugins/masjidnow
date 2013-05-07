<?php

$iqamah_date_str = "";

$masjid_exists = $api_helper->does_masjid_exist();


if($masjid_exists)
{
  $location_name = $response["raw"]->masjid->name;
}
else
{
  if(isset($masjid_id))
  {
    $location_name = "Masjid with id $masjid_id Not Found";
  }
  else
  {
    $location_name = $location["latitude"].", ".$location["longitude"];
  }
}

$iqamah_date_str = "Iqamah timings for ".$api_helper->get_iqamah_date("D M j, Y");

$show_iqamah = $this->should_show_iqamah($api_helper);
$show_adhan = $this->should_show_adhan($instance);

//$iqamah_date_str = $salah_timings->month."/".$salah_timings->day."/".$salah_timings->year; 
?>
<?php 
  if(!empty($title))
  {
    echo($before_title . $title . $after_title);
  }
?>     

  <div>
  </div>

<?php
  if($response["raw"] && $response["raw"]->masjid)
  {
  ?>
      <script type="text/javascript">
        WPMasjidNowWidget.saveTimings(<?php echo(json_encode($response["raw"]->masjid)) ?>);
      </script>
  <?php
  }
?>
 
<div class="masjidnow-container <?php echo($theme);?>">

  <?php if($show_iqamah) { ?>
  <div class="masjidnow-prev-day"></div>
  <div class="masjidnow-next-day"></div>
  <?php } ?>
 <div class='masjidnow-date'>
  <?php echo($date_time_now->format("D M j, Y"))?>
 </div>

 <table class='masjidnow-salah-timings-table'>
  
  <tr>
    <th></th>
    <?php if($show_adhan) { ?>
      <th>Adhan</th>
    <?php } ?>
    <?php if($show_iqamah) { ?>
      <th>Iqamah</th>
    <?php } ?>
  </tr>
   
  <tr class='masjidnow-salah-row'>
    <td class='masjidnow-salah-name masjidnow-fajr'>Fajr</td>
    <?php if($show_adhan) { ?>
      <td class='masjidnow-salah-time-adhan masjidnow-fajr'><?php echo($adhan_times["fajr"]); ?></td>
    <?php } ?>    
    <?php if($show_iqamah) { ?>
      <td class='masjidnow-salah-time-iqamah masjidnow-fajr'><?php echo($iqamah_times["fajr"]); ?></td>
    <?php } ?>
  </tr>
  <tr class='masjidnow-salah-row masjid-salah-row-alt'>
    <td class='masjidnow-salah-name masjidnow-dhuhr'>Sunrise</td>
    <?php if($show_adhan) { ?>
      <td class='masjidnow-salah-time-adhan masjidnow-sunrise'><?php echo($adhan_times["sunrise"]); ?></td>
    <?php } ?>
    <?php if($show_iqamah) { ?>
      <td><!-- Empty but necessary --></td>
    <?php } ?>
  </tr>
  <tr class='masjidnow-salah-row'>
    <td class='masjidnow-salah-name masjidnow-dhuhr'>Dhuhr</td>
    <?php if($show_adhan) { ?>
      <td class='masjidnow-salah-time-adhan masjidnow-dhuhr'><?php echo($adhan_times["dhuhr"]); ?></td>
    <?php } ?>
    <?php if($show_iqamah) { ?>
      <td class='masjidnow-salah-time-iqamah masjidnow-dhuhr'><?php echo($iqamah_times["dhuhr"]); ?></td>
    <?php } ?>
  </tr>
  <tr class='masjidnow-salah-row masjid-salah-row-alt'>
    <td class='masjidnow-salah-name masjidnow-asr'>Asr</td>
    <?php if($show_adhan) { ?>
      <td class='masjidnow-salah-time-adhan masjidnow-asr'><?php echo($adhan_times["asr"]); ?></td>
    <?php } ?>
    <?php if($show_iqamah) { ?>
      <td class='masjidnow-salah-time-iqamah masjidnow-asr'><?php echo($iqamah_times["asr"]); ?></td>
    <?php } ?>
  </tr>
  <tr class='masjidnow-salah-row'>
    <td class='masjidnow-salah-name masjidnow-maghrib'>Maghrib</td>
    <?php if($show_adhan) { ?>
      <td class='masjidnow-salah-time-adhan masjidnow-maghrib'><?php echo($adhan_times["maghrib"]); ?></td>
    <?php } ?>
    <?php if($show_iqamah) { ?>
      <td class='masjidnow-salah-time-iqamah masjidnow-maghrib'><?php echo($iqamah_times["maghrib"]); ?></td>
    <?php } ?>
  </tr>
  <tr class='masjidnow-salah-row masjid-salah-row-alt'>
    <td class='masjidnow-salah-name masjidnow-isha'>Isha</td>
    <?php if($show_adhan) { ?>
      <td class='masjidnow-salah-time-adhan masjidnow-isha'><?php echo($adhan_times["isha"]); ?></td>
    <?php } ?>
    <?php if($show_iqamah) { ?>
      <td class='masjidnow-salah-time-iqamah masjidnow-isha'><?php echo($iqamah_times["isha"]); ?></td>
    <?php } ?>
  </tr>
 </table>
 
 <?php if($show_iqamah) { ?>
   <div class='masjidnow-iqamah-date'>
     <?php echo($iqamah_date_str) ?> <br/>
   </div>
 <?php } ?>
 
 <div class='masjidnow-masjid-name'>
  <?php echo($location_name); ?>
 </div>

</div>
