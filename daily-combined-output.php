<script type="text/javascript">
  WPMasjidNowWidget.saveTimings(<?php echo(json_encode($response["raw"]->masjid)) ?>);
</script>

<style>
  
  .masjidnow-container{
      background-color: <?php echo($bg_color) ?>;
      color: <?php echo $primary_color?>;
  }
  
  .masjidnow-container a{
      color: <?php echo $primary_color ?>;
  }
  
  .masjidnow-left-arrow{
    border-right-color: <?php echo $primary_color ?>;
  }
  
  .masjidnow-right-arrow{
    border-left-color: <?php echo $primary_color ?>;
  }
  
  .masjidnow-daily-footer{
    color: <?php echo $primary_color?>;
  }
</style>

<div class="masjidnow-container">

  <?php if($show_iqamah) { ?>
  <div class="masjidnow-prev-day">
    <div class="masjidnow-left-arrow"></div>
  </div>
  <div class="masjidnow-next-day">
    <div class="masjidnow-right-arrow"></div>
  </div>
  <?php } ?>
 <div class='masjidnow-date'>
  <?php echo($date_time_now->format("D M j, Y"))?> <br/>
  <?php echo($hijri_date_str) ?>
 </div>

 <table class='masjidnow-salah-timings-table'>
  <?php $row_count = 0; ?>
  <tr>
    <th></th>
    <?php if($show_adhan) { ?>
      <th>Adhan</th>
    <?php } ?>
    <?php if($show_iqamah) { ?>
      <th>Iqamah</th>
    <?php } ?>
  </tr>
   
  <?php echo(get_salah_row_start_tag($row_count++, $secondary_color)) ?>
    <td class='masjidnow-salah-name masjidnow-fajr'><?php echo($prayer_names["fajr"]) ?></td>
    <?php if($show_adhan) { ?>
      <td class='masjidnow-salah-time-adhan masjidnow-fajr'><?php echo($adhan_times["fajr"]); ?></td>
    <?php } ?>    
    <?php if($show_iqamah) { ?>
      <td class='masjidnow-salah-time-iqamah masjidnow-fajr'><?php echo($iqamah_times["fajr"]); ?></td>
    <?php } ?>
  </tr>
  <?php if($show_adhan) { ?>
  <?php echo(get_salah_row_start_tag($row_count++, $secondary_color)) ?>
    <td class='masjidnow-salah-name masjidnow-sunrise'><?php echo($prayer_names["sunrise"]) ?></td>
    <?php if($show_adhan) { ?>
      <td class='masjidnow-salah-time-adhan masjidnow-sunrise'><?php echo($adhan_times["sunrise"]); ?></td>
    <?php } ?>
    <?php if($show_iqamah) { ?>
      <td><!-- Empty but necessary --></td>
    <?php } ?>
  </tr>
  <?php } ?>
  <?php echo(get_salah_row_start_tag($row_count++, $secondary_color)) ?>
    <td class='masjidnow-salah-name masjidnow-dhuhr'><?php echo($prayer_names["dhuhr"]) ?></td>
    <?php if($show_adhan) { ?>
      <td class='masjidnow-salah-time-adhan masjidnow-dhuhr'><?php echo($adhan_times["dhuhr"]); ?></td>
    <?php } ?>
    <?php if($show_iqamah) { ?>
      <td class='masjidnow-salah-time-iqamah masjidnow-dhuhr'><?php echo($iqamah_times["dhuhr"]); ?></td>
    <?php } ?>
  </tr>
  <?php echo(get_salah_row_start_tag($row_count++, $secondary_color)) ?>
    <td class='masjidnow-salah-name masjidnow-asr'><?php echo($prayer_names["asr"]) ?></td>
    <?php if($show_adhan) { ?>
      <td class='masjidnow-salah-time-adhan masjidnow-asr'><?php echo($adhan_times["asr"]); ?></td>
    <?php } ?>
    <?php if($show_iqamah) { ?>
      <td class='masjidnow-salah-time-iqamah masjidnow-asr'><?php echo($iqamah_times["asr"]); ?></td>
    <?php } ?>
  </tr>
  <?php echo(get_salah_row_start_tag($row_count++, $secondary_color)) ?>
    <td class='masjidnow-salah-name masjidnow-maghrib'><?php echo($prayer_names["maghrib"]) ?></td>
    <?php if($show_adhan) { ?>
      <td class='masjidnow-salah-time-adhan masjidnow-maghrib'><?php echo($adhan_times["maghrib"]); ?></td>
    <?php } ?>
    <?php if($show_iqamah) { ?>
      <td class='masjidnow-salah-time-iqamah masjidnow-maghrib'><?php echo($iqamah_times["maghrib"]); ?></td>
    <?php } ?>
  </tr>
  <?php echo(get_salah_row_start_tag($row_count++, $secondary_color)) ?>
    <td class='masjidnow-salah-name masjidnow-isha'><?php echo($prayer_names["isha"]) ?></td>
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
 
 <?php if($show_name == 'on') { ?>

   <div class='masjidnow-masjid-name'>
    <?php echo($location_name); ?>
   </div>

 <?php } ?>
 
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
