<div class='masjidnow-monthly-container'>

  <div class='masjidnow-month'><?php echo($date_time->format("F Y")) ?> | Adhan Timings</div>

  <table class='masjidnow-adhan-timings'>
    <tr>
      <th><?php echo($date_time->format("M")) ?>/Day</th>
      <th>Fajr</th>
      <th>Sunrise</th>
      <th>Dhuhr</th>
      <th>Asr</th>
      <th>Maghrib</th>
      <th>Isha</th>
    </tr>
    
    <?php for($i =0; $i < count($timings); $i++) {
      $timing = $timings[$i]->salah_timing;
      $classes = "";
      $date_str = $timing->year."-".$timing->month."-".$timing->day;
      if($timing->day == $date_time_now->format("d") &&
          $timing->month == $date_time_now->format("m"))
      {
        $classes .= " masjidnow-active";
      }
      $date_out_obj = new DateTime($date_str);
      $date_out = $date_out_obj->format("d D");
    ?>
      <tr class="<?php echo($classes) ?>">
        <td><?php echo($date_out); ?></td>
        <td><?php echo($timing->fajr_adhan); ?></td>
        <td><?php echo($timing->sunrise_adhan); ?></td>
        <td><?php echo($timing->dhuhr_adhan); ?></td>
        <td><?php echo($timing->asr_adhan); ?></td>
        <td><?php echo($timing->maghrib_adhan); ?></td>
        <td><?php echo($timing->isha_adhan); ?></td>
      </tr>
    <?php } ?>
    
  </table>
  
</div>