<?php
 /*
    Plugin Name: FotoPress
    Plugin URI: http://www.wpfotopress.com
    Description: Complete Image Editor plugin inside your WordPress. Finds free images online.
    Author: Raul Mellado
    Version: 1.61
    Author URI: http://www.raulmellado.com
 */

// Constants
define( 'WPBEAUTIFY_VERSION', '1.61' );
if (!isset($wp_version))
    global $wp_version;
define( 'WPBEAUTIFY_WPVERSION', $wp_version );

define( 'WPBEAUTIFY_PLUGIN_NAME', dirname(plugin_basename(__FILE__) ));
define( 'WPBEAUTIFY_DIR', plugin_dir_path( __FILE__ ) );
define( 'WPBEAUTIFY_URL', plugins_url( WPBEAUTIFY_PLUGIN_NAME ) );

/********************/

require WPBEAUTIFY_DIR.'/lib/utils.php';
if (is_admin())
	require WPBEAUTIFY_DIR.'/lib/ui.php';

require WPBEAUTIFY_DIR.'/lib/images.php';
require WPBEAUTIFY_DIR.'/lib/imageapis/imageapis.php';

    require WPBEAUTIFY_DIR.'/lib/fonts.php';
if ( ckala_is_pro() ) {
    require WPBEAUTIFY_DIR.'/lib/video.php';
    add_action( 'wp_enqueue_scripts', 'wpbeautify_front_styles' );
}

require WPBEAUTIFY_DIR.'/lib/social/social_apis.php';


function wpbeautify_front_styles()
{
    if (is_admin()) return;
    wp_register_style('wpbeautify_front', WPBEAUTIFY_URL . '/css/wpbeautify-front.css');
    wp_enqueue_style( 'wpbeautify_front' );
}

/* Automatic Updates */
require WPBEAUTIFY_DIR.'/lib/plugin-updates/plugin-update-checker.php';
$wpbeautify_update_checker = new PluginUpdateChecker_3_1(
    ( ckala_is_pro() ? 'http://fotopress.s3.amazonaws.com/plugin-updates/2-pro/info_fotopress2.json' : 'http://fotopress.s3.amazonaws.com/plugin-updates/1-std/info_fotopress1.json' ),
    WPBEAUTIFY_DIR.WPBEAUTIFY_PLUGIN_NAME.'.php'
);

?>