<?php
if( !defined( 'ABSPATH') && !defined('WP_UNINSTALL_PLUGIN') )
    exit();

global $wpdb;

// delete options
$myplugin_options = array('wp_beautify_image_options', 'wp_beautify_font_options', 'wpbeautify_sites_in_order', 'wpbeautify_version', 'wpbeautifyvideo_options');
foreach($myplugin_options as $myplugin_option) {
	delete_option($myplugin_option);
}

?>