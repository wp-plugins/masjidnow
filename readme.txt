=== Plugin Name ===
Contributors: yaj786
Donate link: 
Tags: masjidnow, iqamah, salah, islam, masjid, mosque, salat, prayer
Requires at least: 3.5.1
Tested up to: 3.5.1
Stable tag: 0.9.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Provides a widget for displaying daily iqamah timings from MasjidNow.com for any mosque that has uploaded it's timings there, as well as calculated prayer times for an area.

== Description ==

Provides a widget for displaying daily iqamah timings from MasjidNow.com for any mosque that has uploaded it's timings there.
The timings are displayed along-side calculated timings which can be adjusted from the plugin's settings.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the `masjidnow` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place the `MasjidNow Daily Iqamah Timings` widget in the correct area through the `Appearance` > `Widgets` menu in WordPress.
4. Change the widget's settings to your preference, then press save.

== Frequently Asked Questions ==

= I have a question, what should I do? =

Email me through the contact form at masjidnow.com

== Changelog ==

= 0.9.6 =
* Added ability to change date.

= 0.9.5 =
* Removed border and changed some stylings.
* Fixed bugs with old adhan timings being shown.

= 0.9.4 =
* Removed width requirement on container. Widget can now fit into smaller areas.
* Added ability to set the header.

= 0.9.3 =
* Upgraded to using masjidnow.com API V2. Adhan timings are now gotten from the MasjidNow server instead of through calculations, unless necessary.
* Widget can be used without having a masjid connected to it. (Will get around to fixing how it looks when there is no masjid connected.)

= 0.9.2 =
* Fixed incorrect calculated salah times due to wrong lat/lon being used.

= 0.9.1 =
* Added ability to show calculated prayer timings.

= 0.9 =
* No difference, simply a version bump.

= 0.1 =
* Right now, the widget only displays the latest timings.
