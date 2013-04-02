<div class="wrapper">
    
    <h3>General Settings</h3>
    
    <label for="<?php echo $this->get_field_id('masjid-id'); ?>"><strong>Masjid ID:</strong></label> <br/>
    <input class="widefat" 
      id="<?php echo $this->get_field_id('masjid-id'); ?>" 
      name="<?php echo $this->get_field_name('masjid-id'); ?>" 
      type="text" 
      value="<?php echo esc_attr($masjid_id); ?>" />
      
      
      
    <p>The masjid id can be found by looking at the end of the masjid's URL from masjidnow.com. 
    <br/> For example, Adam Community Center's MasjidNow page has a url of
    <br/><em> http://masjidnow.com/masjids/5299 </em>
    <br/> The masjid id in this case would be 5299.</p>
      
    <label for="<?php echo $this->get_field_id('theme'); ?>"><strong>Theme:</strong></label> <br/>
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
    
    <hr style="margin-top:20px; margin-bottom:20px;"/>
    
    <h3>Salah Times Calculations</h3>
    <p>
      These settings only take effect if you don't have salah timings uploaded to MasjidNow.com! <br/>
      If you have timings uploaded, you can change your settings from our website.
    </p>
    <p>
    <label for="<?php echo $this->get_field_id('latitude'); ?>"><strong>Latitude, Longitude</strong></label> <br/>
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
    <label for="<?php echo $this->get_field_id('time-zone-id'); ?>"><strong>Time Zone:</strong></label> <br/>
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
    <label for="<?php echo $this->get_field_id('pray-time-calc-method'); ?>"><strong>Calculation Method:</strong></label> <br/>
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
    <label for="<?php echo $this->get_field_id('pray-time-asr-juristic'); ?>"><strong>Calculation Method:</strong></label> <br/>
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
