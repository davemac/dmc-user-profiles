=== DMC User Profiles ===
Contributors: davemac
Donate link: 
Tags: 
Requires at least: 3.5.1
Tested up to: 3.9
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Extends WordPress user profiles and displays as a styled profile box.

== Description ==

This plugin puts the following field in the user profile:

* Twitter handle (no @)
* LinkedIn
* Phone
* Mobile

This plugin gives theme developers a new function:

dmc_user_profile_box()

This function, which would usually be called at the bottom of a single post, displaying the following information:

* gravatar
* link to author's Twitter user page, if user field value exists
* link to author's LinkedIn page, if user field value exists
* link to the author's website, if user field value exists
* author's name
* author's description
* author's phone, if user field value exists
* author's mobile, if user field value exists
* link to other posts by the author

== Installation ==

This section describes how to install the plugin and get it working.

= Using The WordPress Dashboard =

This plugin supports the [GitHub Updater](https://github.com/afragen/github-updater) plugin, so if you install that, this plugin becomes automatically updateable direct from GitHub. Any submission to WP.org repo will make this redundant.

1. Navigate to [dmc-user-profiles on GitHub](https://github.com/davemac/dmc-user-profiles)
2. Clone the repository in GitHub to your wp-content/plugins folder
4. Activate the plugin on the Plugin dashboard

= Uploading in WordPress Dashboard =

1. Navigate to [dmc-user-profiles on GitHub](https://github.com/davemac/dmc-user-profiles)
2. Click 'Download Zip'
3. Navigate to the 'Add New' in the plugins dashboard
4. Navigate to the 'Upload' area
5. Select `dmc-user-profiles-master.zip` from your computer
6. Click 'Install Now'
7. Activate the plugin in the Plugin dashboard

= Using FTP =

1. Navigate to [dmc-user-profiles on GitHub](https://github.com/davemac/dmc-user-profiles)
2. Click 'Download Zip'
2. Extract the `dmc-user-profiles-master.zip` directory to your computer
3. Upload the `dmc-user-profiles` directory to the `/wp-content/plugins/` directory
4. Activate the plugin in the Plugin dashboard

== Frequently Asked Questions ==

= Can I override the default style for the author profile box?

Yes, by overwriting the styles in style.css in your theme.

== Screenshots ==

There are no screenshots currently available.

== Changelog ==

= 0.0.6 =
* Add Advanced Custom Fields
* Add option on user profile page to hide profile box

= 0.0.5 =
* Update Boilerplate code

= 0.0.4 =
* Update README.txt

= 0.0.3 =
* Intial commit

== Upgrade Notice ==


== Updates ==

This plugin supports the [GitHub Updater](https://github.com/afragen/github-updater) plugin, so if you install that, this plugin becomes automatically updateable direct from GitHub. This plugin is not hosted on the wp.org plugin respository.

