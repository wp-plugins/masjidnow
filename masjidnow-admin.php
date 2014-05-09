<div class="wrapper">
    
    <p>
      <strong>General Settings</strong>
    </p>
    
    <p>
    <label for="<?php echo $this->get_field_id('title'); ?>">Title</label><br/>
    <input class="widefat" 
      id="<?php echo $this->get_field_id('title'); ?>"
      name="<?php echo $this->get_field_name('title'); ?>"
      type="text"
      value="<?php echo esc_attr($title); ?>" />
    </p>
    
    <p>
    <label for="<?php echo $this->get_field_id('masjid-id'); ?>">Masjid ID:</label> <br/>
    <input class="widefat" 
      id="<?php echo $this->get_field_id('masjid-id'); ?>" 
      name="<?php echo $this->get_field_name('masjid-id'); ?>" 
      type="text" 
      value="<?php echo esc_attr($masjid_id); ?>" />
    </p>
      
      
    <p style="font-size:11px;">The masjid id can be found by looking at the end of the masjid's URL from masjidnow.com. 
    <br/> ex. http://masjidnow.com/masjids/5299 has a masjid id of 5299.</p>
    
    <p>
    <input 
      id="<?php echo $this->get_field_id('show-adhan'); ?>" 
      name="<?php echo $this->get_field_name('show-adhan'); ?>" 
      type="checkbox"
      <?php echo($user_show_adhan ? "checked" : ""); ?> 
    />
    <label for="<?php echo $this->get_field_id('show-adhan'); ?>">Show Adhan Column</label>
    
    </p>
    
    <p>
    <input 
      id="<?php echo $this->get_field_id('show-monthly-info'); ?>" 
      name="<?php echo $this->get_field_name('show-monthly-info'); ?>" 
      type="checkbox"
      <?php echo($user_show_monthly_info ? "checked" : ""); ?> 
    />
    <label for="<?php echo $this->get_field_id('show-monthly-info'); ?>">Show Monthly Info (ex. Jummah times)</label>
    
    </p>
      
    <p>  
    <label for="<?php echo $this->get_field_id('theme'); ?>">Widget Theme:</label> <br/>
    <select class="widefat" 
      id="<?php echo $this->get_field_id('theme'); ?>" 
      name="<?php echo $this->get_field_name('theme'); ?>" 
      type="text" 
      value="<?php echo esc_attr($masjid_id);?>">
      <?php 
      for($i = 0; $i < count(MasjidNow_Widget::$THEME_NAMES); $i++){ ?>
        <option value="<?php echo(MasjidNow_Widget::$THEME_NAMES[$i]); ?>"
          <?php echo(($theme == MasjidNow_Widget::$THEME_NAMES[$i]) ? "selected" : ""); ?> >
          <?php echo(MasjidNow_Widget::$THEME_DESCS[$i]);?>
        </option>
      <?php 
      }
      ?>
    </select>
    </p>
    
    <hr style="margin-top:20px; margin-bottom:20px;"/>
    
    <strong>Salah Times Calculations</strong>
    <p style="font-size:11px;">
      These settings only take effect if you don't have salah timings uploaded to MasjidNow.com.<br/>
      If you have timings uploaded, you must change your settings from our website.
    </p>
    <p>
    <label for="<?php echo $this->get_field_id('latitude'); ?>">Latitude, Longitude</label> <br/>
    <input class="widefat" style="width:100px" 
      id="<?php echo $this->get_field_id('latitude'); ?>" 
      name="<?php echo $this->get_field_name('latitude'); ?>" 
      type="text"
      placeholder="Latitude (ex. 42.123123)"
      value="<?php echo esc_attr($latitude); ?>" />
    <input class="widefat" style="width:100px" 
      id="<?php echo $this->get_field_id('longitude'); ?>" 
      name="<?php echo $this->get_field_name('longitude'); ?>" 
      type="text"
      placeholder="Longitude (ex. -82.123123)"
      value="<?php echo esc_attr($longitude); ?>" />
    
    </p>
    
    <p>
    <label for="<?php echo $this->get_field_id('time-zone-id'); ?>">Time Zone:</label> <br/>
    <select class="widefat" 
      id="<?php echo $this->get_field_id('time-zone-id'); ?>" 
      name="<?php echo $this->get_field_name('time-zone-id'); ?>" 
      type="text">
      <?php 
      foreach(MasjidNowTimeZoneNames::$TIME_ZONES as $timeZoneKey => $timeZoneVal){ ?>
        <option value="<?php echo($timeZoneVal); ?>"
          <?= ($timeZoneVal == $time_zone_id) ? "selected": ""?>>
          <?= $timeZoneKey ?>
        </option>
      <?php
      }
      ?>
    </select>
    
    </p>
    
    <p>
    <label for="<?php echo $this->get_field_id('pray-time-calc-method'); ?>">Calculation Method:</label> <br/>
    <select class="widefat" 
      id="<?php echo $this->get_field_id('pray-time-calc-method'); ?>" 
      name="<?php echo $this->get_field_name('pray-time-calc-method'); ?>" 
      type="text">
      <?php 
      foreach(PrayTime::$CALC_METHODS as $methodKey => $methodVal){ ?>
        <option value="<?= $methodVal?>"
          <?= ($methodVal == $pray_time_calc_method) ? "selected": ""?>>
          <?= $methodKey ?>
        </option>
      <?php
      }
      ?>
    </select>
    </p>
    
    <p>
    <label for="<?php echo $this->get_field_id('pray-time-asr-juristic'); ?>">Calculation Method:</label> <br/>
    <select class="widefat" 
      id="<?php echo $this->get_field_id('pray-time-asr-juristic'); ?>" 
      name="<?php echo $this->get_field_name('pray-time-asr-juristic'); ?>" 
      type="text">
      <?php 
      foreach(PrayTime::$ASR_JURISTICS as $juristicKey => $juristicVal){ ?>
        <option value="<?php echo($juristicVal); ?>"
          <?= ($juristicVal == $pray_time_asr_juristic) ? "selected": ""?>>
          <?= $juristicKey ?>
        </option>
      <?php
      }
      ?>
    </select>
    
    </p>
    
    
    
    
 
</div>
