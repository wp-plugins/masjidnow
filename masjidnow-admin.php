<div class="wrapper">
    
    <label for="<?php echo $this->get_field_id('masjid-id'); ?>"><strong>Masjid ID:</strong></label> <br/>
    <input class="widefat" 
      id="<?php echo $this->get_field_id('masjid-id'); ?>" 
      name="<?php echo $this->get_field_name('masjid-id'); ?>" 
      type="text" 
      value="<?php echo esc_attr($masjid_id); ?>" />
      
    <label for="<?php echo $this->get_field_id('theme'); ?>"><strong>Masjid ID:</strong></label> <br/>
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
    
      
    <p>The masjid id can be found by looking at the end of the masjid's URL from masjidnow.com. 
    <br/> For example, Adam Community Center's MasjidNow page has a url of
    <br/><em> http://masjidnow.com/masjids/5299 </em>
    <br/> The masjid id in this case would be 5299.</p>
    
    
 
</div>
