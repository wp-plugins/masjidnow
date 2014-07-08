<div class='masjidnow-monthly-container'>

  <div class='masjidnow-month'><?php echo($date_time->format("F Y")) ?> | Iqamah Timings</div>

  <table class='masjidnow-iqamah-timings'>
    <tr>
      <th><?php echo($date_time->format("M")) ?>/Day</th>
      <th><?php echo($prayer_names["fajr"]) ?></th>
      <th><?php echo($prayer_names["dhuhr"]) ?></th>
      <th><?php echo($prayer_names["asr"]) ?></th>
      <th><?php echo($prayer_names["maghrib"]) ?></th>
      <th><?php echo($prayer_names["isha"]) ?></th>
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
        <td><?php echo($timing->fajr); ?></td>
        <td><?php echo($timing->dhuhr); ?></td>
        <td><?php echo($timing->asr); ?></td>
        <td><?php echo($timing->maghrib); ?></td>
        <td><?php echo($timing->isha); ?></td>
      </tr>
    <?php } ?>
    
  </table>
  
</div>
