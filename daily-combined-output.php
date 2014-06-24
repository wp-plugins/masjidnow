<?php
$row_count = 0;
?>
<?php 
  //if(!empty($title))
  //{
  //  echo($before_title . $title . $after_title);
  //}
?>     


<script type="text/javascript">
  WPMasjidNowWidget.saveTimings(<?php echo(json_encode($response["raw"]->masjid)) ?>);
</script>

<div class="masjidnow-container <?php echo($theme); ?>">

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
  <?php if($show_adhan) { ?>
  <tr class='masjidnow-salah-row'>
    <td class='masjidnow-salah-name masjidnow-dhuhr'>Sunrise</td>
    <?php if($show_adhan) { ?>
      <td class='masjidnow-salah-time-adhan masjidnow-sunrise'><?php echo($adhan_times["sunrise"]); ?></td>
    <?php } ?>
    <?php if($show_iqamah) { ?>
      <td><!-- Empty but necessary --></td>
    <?php } ?>
  </tr>
  <?php } ?>
  <tr class='masjidnow-salah-row'>
    <td class='masjidnow-salah-name masjidnow-dhuhr'>Dhuhr</td>
    <?php if($show_adhan) { ?>
      <td class='masjidnow-salah-time-adhan masjidnow-dhuhr'><?php echo($adhan_times["dhuhr"]); ?></td>
    <?php } ?>
    <?php if($show_iqamah) { ?>
      <td class='masjidnow-salah-time-iqamah masjidnow-dhuhr'><?php echo($iqamah_times["dhuhr"]); ?></td>
    <?php } ?>
  </tr>
  <tr class='masjidnow-salah-row'>
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
  <tr class='masjidnow-salah-row'>
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
      <a href='<?php echo($masjid_url)?>#mobile_instructions' title="Get iqamah timings for <?php echo($location_name)?> on Android "><img src='<?php echo(plugins_url( "img\ic_android.png", __FILE__ )); ?>' height=30></a>
    </div>
    <div class='masjidnow-alt-icon'>
      <a href='<?php echo($masjid_url)?>#mobile_instructions' title="Get iqamah timings for <?php echo($location_name)?> on iOS"><img src='<?php echo(plugins_url( "img\ic_ios.png", __FILE__ )); ?>' height=30></a>
    </div>
  </div>
 </div>

</div>
