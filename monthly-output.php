<div class='masjidnow-monthly-container'>

  <div class='masjidnow-month'>March 2013</div>

  <table class='masjidnow-salah-timings'>
    <tr>
      <th>Mar/Day</th>
      <th>Fajr</th>
      <th>Dhuhr</th>
      <th>Asr</th>
      <th>Maghrib</th>
      <th>Isha</th>
    </tr>
    
    <?php for($i =0; $i < count($timings); $i++) {
      $timing = $timings[$i]->salah_timing;
      $classes = "";
      if($timing->day == $date_time_now->format("d"))
      {
        $classes .= " masjidnow-active";
      }
    ?>
      <tr class="<?php echo($classes) ?>">
        <td><?php echo($timing->day); ?></td>
        <td><?php echo($timing->fajr); ?></td>
        <td><?php echo($timing->dhuhr); ?></td>
        <td><?php echo($timing->asr); ?></td>
        <td><?php echo($timing->maghrib); ?></td>
        <td><?php echo($timing->isha); ?></td>
      </tr>
    <?php } ?>
    
  </table>
  
</div>
