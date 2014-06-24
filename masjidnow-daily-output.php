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

$iqamah_date_str = "Iqamah timings for ".$api_helper->get_iqamah_date_str("D M j, Y");

$show_iqamah = $this->should_show_iqamah($api_helper);
$show_adhan = $this->should_show_adhan($instance);
$show_monthly_info = $this->should_show_monthly_info($instance);
$row_count = 0;

$is_timings_old = false;
$iqamah_date_time = $api_helper->get_iqamah_date();
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
   
  <?php echo($this->get_salah_row_start_tag($row_count++)) ?>
    <td class='masjidnow-salah-name masjidnow-fajr'>Fajr</td>
    <?php if($show_adhan) { ?>
      <td class='masjidnow-salah-time-adhan masjidnow-fajr'><?php echo($adhan_times["fajr"]); ?></td>
    <?php } ?>    
    <?php if($show_iqamah) { ?>
      <td class='masjidnow-salah-time-iqamah masjidnow-fajr'><?php echo($iqamah_times["fajr"]); ?></td>
    <?php } ?>
  </tr>
  <?php if($show_adhan) { ?>
  <?php echo($this->get_salah_row_start_tag($row_count++)) ?>
    <td class='masjidnow-salah-name masjidnow-dhuhr'>Sunrise</td>
    <?php if($show_adhan) { ?>
      <td class='masjidnow-salah-time-adhan masjidnow-sunrise'><?php echo($adhan_times["sunrise"]); ?></td>
    <?php } ?>
    <?php if($show_iqamah) { ?>
      <td><!-- Empty but necessary --></td>
    <?php } ?>
  </tr>
  <?php } ?>
  <?php echo($this->get_salah_row_start_tag($row_count++)) ?>
    <td class='masjidnow-salah-name masjidnow-dhuhr'>Dhuhr</td>
    <?php if($show_adhan) { ?>
      <td class='masjidnow-salah-time-adhan masjidnow-dhuhr'><?php echo($adhan_times["dhuhr"]); ?></td>
    <?php } ?>
    <?php if($show_iqamah) { ?>
      <td class='masjidnow-salah-time-iqamah masjidnow-dhuhr'><?php echo($iqamah_times["dhuhr"]); ?></td>
    <?php } ?>
  </tr>
  <?php echo($this->get_salah_row_start_tag($row_count++)) ?>
    <td class='masjidnow-salah-name masjidnow-asr'>Asr</td>
    <?php if($show_adhan) { ?>
      <td class='masjidnow-salah-time-adhan masjidnow-asr'><?php echo($adhan_times["asr"]); ?></td>
    <?php } ?>
    <?php if($show_iqamah) { ?>
      <td class='masjidnow-salah-time-iqamah masjidnow-asr'><?php echo($iqamah_times["asr"]); ?></td>
    <?php } ?>
  </tr>
  <?php echo($this->get_salah_row_start_tag($row_count++)) ?>
    <td class='masjidnow-salah-name masjidnow-maghrib'>Maghrib</td>
    <?php if($show_adhan) { ?>
      <td class='masjidnow-salah-time-adhan masjidnow-maghrib'><?php echo($adhan_times["maghrib"]); ?></td>
    <?php } ?>
    <?php if($show_iqamah) { ?>
      <td class='masjidnow-salah-time-iqamah masjidnow-maghrib'><?php echo($iqamah_times["maghrib"]); ?></td>
    <?php } ?>
  </tr>
  <?php echo($this->get_salah_row_start_tag($row_count++)) ?>
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
     <?php if($is_timings_old) { ?>
      <?php echo($iqamah_date_str) ?> <br/>
     <?php } ?>
   </div>
 <?php } ?>
 
 <?php if($show_iqamah && $show_monthly_info) { ?>
 
  <div class='monthly-info'>
    <?php echo $monthly_info ?>
  </div>
 
 <?php } ?>
 
 <div class='masjidnow-masjid-name'>
  <?php echo($location_name); ?>
 </div>
 
 <div class='masjidnow-daily-footer'>
  <span class='masjidnow-alt-instructions'>Get these timings on:</span>
  <div class='masjidnow-alt-icons'>
    <div class='masjidnow-alt-icon'>
      <a href='http://www.masjidnow.com<?php echo($masjid_url)?>#mobile_instructions'><img src='<?php echo(plugins_url( "img\ic_android.png", __FILE__ )); ?>' height=30></a>
    </div>
    <div class='masjidnow-alt-icon'>
      <a href='http://www.masjidnow.com<?php echo($masjid_url)?>#mobile_instructions'><img src='<?php echo(plugins_url( "img\ic_ios.png", __FILE__ )); ?>' height=30></a>
    </div>
  </div>
 </div>

</div>
