<?php
/*
Plugin Name: MasjidNow
Plugin URI: http://wordpress.org/extend/plugins/masjidnow/
Description: A simple widget for adding your mosque's prayer times (from MasjidNow.com) to your website.
Version: 1.1.2
Author: Yousuf Jukaku
Author URI: http://masjidnow.com
License: GPL2
*/

require_once("libs/PrayTime.php");
include("libs/MasjidNowTimeZoneNames.php");
include("class-praytime-helper.php");
include("class-api-helper.php");
include("monthly.php");


class MasjidNow_Widget extends WP_Widget
{
  
  
  
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
    $this->add_javascript();
  }
 
  function form($instance)
  {
    $instance = wp_parse_args((array) $instance, array( 
        'title' => '',
        'masjid-id' => '',
        'show-adhan' => false,
        'theme' => 'default',
        'time-zone-id' => "America/New_York",
        'pray-time-calc-method' => 2,
        'latitude' => 42.5,
        'longitude' => -83,
        'pray-time-asr-juristic' => 0
      )
    );
    $title = $instance['title'];
    $masjid_id = $instance['masjid-id'];
    $user_show_adhan = $instance['show-adhan'];
    $theme = $instance['theme'];
    $time_zone_id = $instance['time-zone-id'];
    $latitude = $instance['latitude'];
    $longitude = $instance['longitude'];
    $pray_time_calc_method = $instance['pray-time-calc-method'];
    $pray_time_asr_juristic = $instance['pray-time-asr-juristic'];
    
    include 'masjidnow-admin.php';
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    
    $instance['title'] = $new_instance['title'];
    $instance['masjid-id'] = $new_instance['masjid-id'];
    $instance['show-adhan'] = $new_instance['show-adhan'];
    $instance['theme'] = $new_instance['theme'];
    $instance['time-zone-id'] = $new_instance['time-zone-id'];
    $instance['latitude'] = $new_instance['latitude'];
    $instance['longitude'] = $new_instance['longitude'];
    $instance['pray-time-calc-method'] = $new_instance['pray-time-calc-method'];
    $instance['pray-time-asr-juristic'] = $new_instance['pray-time-asr-juristic'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    add_action( 'wp_enqueue_scripts', 'add_stylesheet' );
  
    echo $before_widget;
    $title = empty($instance['title']) ? NULL : apply_filters('widget_title', $instance['title']); 
    $masjid_id = empty($instance['masjid-id']) ? NULL : $instance['masjid-id'];  
    $theme = empty($instance['theme']) ? 'default' : $instance['theme'];    
    $theme = self::THEME_PREFIX.$theme;
       
    $location = MasjidNow_PrayTimeHelper::get_location($instance);
    
    // Do Your Widgety Stuff Here...

    
    //wordpress changes this elsewhere, so save it and reset it at the end of the function.
    $original_time_zone_id = date_default_timezone_get();
    $time_zone_id = $location["time_zone_id"];
    date_default_timezone_set($time_zone_id);
    $date_time_zone = new DateTimeZone($time_zone_id);
    $date_time_now = new DateTime("now", $date_time_zone);

    $pray_time_settings = MasjidNow_PrayTimeHelper::get_pray_time_settings_from_widget($instance); 
    $api_helper = new MasjidNow_ApiHelper($masjid_id, $date_time_now, $pray_time_settings, $location);
    $response = $api_helper->get_timings();
    $adhan_times = $response["adhan_timings"];
    $iqamah_times = $response["iqamah_timings"];
    
    include("masjidnow-daily-output.php");
    
    date_default_timezone_set($original_time_zone_id);
    
    echo $after_widget;
  }
  
  function should_show_iqamah($api_helper)
  {
    return $api_helper->does_masjid_exist();
  }
  
  function should_show_adhan($instance)
  {
    return empty($instance['show-adhan']) ? false : $instance['show-adhan'];
  }

  function get_salah_row_start_tag($count)
  {
    if($count % 2 != 0)
    {
      return "<tr class='masjidnow-salah-row masjid-salah-row-alt'>";
    }
    else
    {
      return "<tr class='masjidnow-salah-row'>";
    }
  }
  
  function add_stylesheet() {
      // Respects SSL, Style.css is relative to the current file
      wp_register_style( 'masjidnow-style', plugins_url('masjidnow.css', __FILE__) );
      wp_enqueue_style( 'masjidnow-style' );
  }
  
  function add_javascript() {
      // Respects SSL, Style.css is relative to the current file
      wp_register_script( 'masjidnow-js', plugins_url('js/WPMasjidNowWidget.js', __FILE__) );
      wp_enqueue_script('masjidnow-js');
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

add_shortcode("masjidnow_monthly", "MasjidNowMonthly_getIqamahOutput");
add_shortcode("masjidnow_monthly_adhan", "MasjidNowMonthly_getAdhanOutput");
?>
