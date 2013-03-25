<?php
/*
Plugin Name: MasjidNow
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: A simple widget for adding your mosque's prayer times (from MasjidNow.com) to your website.
Version: 0.9beta
Author: Yousuf Jukaku
Author URI: http://masjidnow.com
License: GPL2
*/



class MasjidNow_Widget extends WP_Widget
{
  
  const BASE_URL = "http://www.masjidnow.com/api/salah_timings/daily.json?masjid_id=";
  
  const THEME_PREFIX = "masjidnow-theme-";
  
  /** @const */
  private static $THEME_NAMES = array("default", "blue");
  /** @const */
  private static $THEME_DESCS = array("Default (gray)", "Blue");
  
  function MasjidNow_Widget()
  {
    $widget_ops = array('classname' => 'MasjidNow_Widget', 'description' => 'MasjidNow Daily Iqamah Timings');
    $this->WP_Widget('MasjidNow_Widget', 'MasjidNow Daily Iqamah Timings', $widget_ops);
    $this->add_stylesheet();
  }
 
  function form($instance)
  {
    $instance = wp_parse_args((array) $instance, array( 'masjid-id' => '', 'theme' => 'default' ));
    $masjid_id = $instance['masjid-id'];
    $theme = $instance['theme'];
    
    include 'masjidnow-admin.php';
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['masjid-id'] = $new_instance['masjid-id'];
    $instance['theme'] = $new_instance['theme'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    add_action( 'wp_enqueue_scripts', 'add_stylesheet' );
  
    echo $before_widget;
    $masjid_id = empty($instance['masjid-id']) ? '' : apply_filters('widget_title', $instance['masjid-id']);  
    $theme = empty($instance['theme']) ? 'default' : apply_filters('widget_title', $instance['theme']);    
    $theme = self::THEME_PREFIX.$theme;
 
    if (!empty($masjid_id))
    {
      // Do Your Widgety Stuff Here...
      $salah_timings = $this->get_daily_timings($masjid_id);
      if($salah_timings == NULL)
      {
        $error = "Error. Masjid with id $masjid_id does not have salah timings on MasjidNow.com.";
        $this->output_error($error, $theme);
      }
      else
      {
        include("masjidnow-daily-output.php");
      }
    }
    
    echo $after_widget;
  }
  
  function output_error($error, $theme)
  {
    echo("<div class='masjidnow-container $theme'>");
    echo($error);
    echo("</div>");
  }
  
  function get_daily_timings($masjid_id)
  {
    $url = self::BASE_URL.$masjid_id;
    $response = @file_get_contents($url);
    if($response !== FALSE)
    {
      $salah_timings = json_decode($response);
    
      if($salah_timings == NULL)
      {
        return NULL;
      }
      else
      {
        $salah_timings = $salah_timings->salah_timing;
        return $salah_timings;
      }
    }
    else
    {
      return NULL;
    }
  }
  
  
  function add_stylesheet() {
      // Respects SSL, Style.css is relative to the current file
      wp_register_style( 'masjidnow-style', plugins_url('masjidnow.css', __FILE__) );
      wp_enqueue_style( 'masjidnow-style' );
  }
  
  function get_theme_names()
  {
    return self::THEME_NAMES;
  }
  
  function get_theme_descs()
  {
    return self::THEME_DESCS;
  }
  
}

add_action( 'widgets_init', create_function('', 'return register_widget("MasjidNow_Widget");') );

?>
