<?php
/*
Plugin Name: Verify Google Webmaster Tools
Plugin URI: http://wordpress.org/extend/plugins/verify-google-webmaster-tools/
Description: Adds <a href="http://www.google.com/webmasters/">Google Webmaster Tools</a> verification meta-tag.
Version: 2.0
Author: Matt Clegg
Author URI: http://mattclegg.com
Thanks: Audrius Dobilinskas (http://onlineads.lt/author/audrius)
*/

if (!defined('gwebmasters_default')) {
	define('gwebmasters_default', 'Paste your Google Webmaster Tools verification code here');
}

function options_page_google_webmaster_tools() {
  include(WP_PLUGIN_DIR.'/verify-google-webmaster-tools/options.php');  
}

function google_webmaster_tools() {
	$gwebmasters_code = get_option('gwebmasters_code');
	if($gwebmasters_code !== gwebmasters_default) {
		echo $gwebmasters_code;
	}
}

register_activation_hook(__FILE__, function() {
	add_option('gwebmasters_code', gwebmasters_default);
});

register_deactivation_hook(__FILE__, function() {
	delete_option('gwebmasters_code');
});

if (is_admin()) {
	add_action('admin_init', function() {
		register_setting('google_webmaster_tools', 'gwebmasters_code');
	});
	add_action('admin_menu', function() {
		add_options_page('Google Webmaster Tools', 'Google Webmaster Tools', 'manage_options', 'google_webmaster_tools', 'options_page_google_webmaster_tools');
	});
} else {
	add_action('wp_head', 'google_webmaster_tools');
}