=== Plugin Name ===
Contributors: yaj786
Donate link: 
Tags: masjidnow, iqamah, prayer, salah, islam, masjid, mosque, salat
Requires at least: 3.5.1
Tested up to: 3.8.3
Stable tag: 1.3.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Provides the ability to display daily and monthly adhan and iqamah timings from MasjidNow.com. Local adhan times calculation available if necessary.

== Description ==

Provides a widget for displaying daily iqamah timings from MasjidNow.com for any mosque that has uploaded it's timings there.
The timings are displayed along-side adhan timings which can be adjusted from the plugin's settings if necessary.

Also provides a shortcode for displaying the monthly iqamah timings table.

ATTENTION: You must clear the cache after updating the masjid's salah timings. This is necessary evil that will speed up the plugin by almost 1000x. You
can do this by going the MasjidNow Settings page and clicking "Clear Cache".

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the `masjidnow` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

To use the daily timings sidebar widget:

1. Place the `MasjidNow Daily Iqamah Timings` widget in the correct area through the `Appearance` > `Widgets` menu in WordPress.
2. Change the widget's settings to your preference, then press save.

To show the monthly timings table anywhere on your site:

1. Place the shortcode [masjidnow_monthly masjid_id=XXXX], replacing XXXX with your mosque's MasjidNow.com id. This can be found at the end of the MasjidNow.com url for your mosque.
For example, http://masjidnow.com/masjids/5312 has a masjid_id of 5312. Simple!

To show the adhan timings schedule instead of the iqamah timings schedule, simply change the short code to [masjidnow_monthly_adhan masjid_id=XXXX].

== Frequently Asked Questions ==

= Why is the widget displaying "Please set your website's timezone..." when I have already set it? =

Unfortunately, due to the way that WordPress provides timezone information, you must set the timezone option to a "named" timezone. For example, instead of choosing "UTC-4", you must choose something like "New York". 

= Why is my widget or shortcode showing outdated or old timings? =

The timings that are being displayed have been saved to your WordPress installation (aka "cached") so that it doesn't have to connect to the MasjidNow database everytime that your page is loaded.
This ensures that timings are displayed quickly and don't slow down your website.

To clear these cached timings, go to your WordPress Admin panel, and click Settings > MasjidNow Settings on the left hand side. Then click the button labeled "Clear Cache". Your timings will then be updated
from the MasjidNow website.

= I have a question that isn't listed here, what should I do? =

Email me through the contact form at masjidnow.com

== Changelog ==

= 1.3.1 =
* Fixed bug with mobile app icon links.

= 1.3.0 =
* Added ability to display monthly info underneath the daily timings widget. Be sure to check the correct checkbox on the widget settings.

= 1.2.1 =
* Fixed bug where widget would crash if there was no valid time zone set for the WordPress site.

= 1.2.0 =
* Added caching of timings. Performance should increase by ~1000x, but YOU MUST CLEAR THE PLUGIN CACHE EVERY TIME YOU UPDATE THE TIMINGS ON MASJIDNOW.COM. 

= 1.1.2 =
* Fixed bug where adhan timings table columns were off by one.

= 1.1.1 =
* Added ability to show different months with shortcodes. Add month=XX to the shortcode to have the timings for that month display. For example, [masjidnow_monthly masjid_id=XXXX month=12] for December timings.

= 1.1.0 =
* Added monthly adhan timings shortcode. Just use [masjidnow_monthly_adhan masjid_id=XXXX] to display the adhan timings for your mosque.

= 1.0.6 =
* Fixed bug in monthly timings where the month displayed was always "March 2013"

= 1.0.5 =
* Timings are now available if user clicks to a new month

= 1.0.4 =
* Fixed bug where widget wouldn't display on some servers (used <? on one line vs <?php)

= 1.0.3 =
* Removed additional dependencies on PHP 5.3+ by removing reference to DateTime::diff 

= 1.0.2 =
* Changed style of widget to properly accomodate small sidebars.

= 1.0.1 =
* Switched to using wp_remote_get instead of file_get_contents which may cause issues on some WordPress installations.

= 1.0.0 =
* Added mobile app download links.
* Changed iqamah timings date to only show if timings were old.
* Added support for PHP 5 (previous support was PHP 5.3)

= 0.9.11 =
* Fixed bug where widget couldn't go in the past if a month was incomplete.

= 0.9.10 =
* Included updated file from fix in 0.9.9

= 0.9.9 =
* Fixed bug where iqamah timings date would show "No timings available" regardless of availability.

= 0.9.8 =
* Added ability to display monthly timings table.

= 0.9.7 =
* Added ability to only display iqamah timings, instead of both iqamah and adhan timings.
* Fixed bug where initial iqamah and adhan timings were showing the timings from the last day of the month instead of the correct day's.

= 0.9.6 =
* Added ability to change date.

= 0.9.5 =
* Removed border and changed some stylings.
* Fixed bugs with old adhan timings being shown.

= 0.9.4 =
* Removed width requirement on container. Widget can now fit into smaller areas.
* Added ability to set the header.

= 0.9.3 =
* Upgraded to using masjidnow.com API V2. Adhan timings are now retrieved from the MasjidNow server instead of through calculations, unless necessary.
* Widget can be used without having a masjid connected to it. (Will get around to fixing how it looks when there is no masjid connected.)

= 0.9.2 =
* Fixed incorrect calculated salah times due to wrong lat/lon being used.

= 0.9.1 =
* Added ability to show calculated prayer timings.

= 0.9 =
* No difference, simply a version bump.

= 0.1 =
* Right now, the widget only displays the latest timings.
