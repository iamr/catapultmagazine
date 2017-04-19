<?php

function wpbeautify_get_default_video_settings() {
	$default_settings = wpbeautify_get_default_image_settings();
	return $default_settings['video'];
}

function wpbeautify_add_inline_video_css() {
	$image_settings = wpbeautify_get_image_settings();
	if (isset($image_settings['video']))
		$video_settings = $image_settings['video'];	
	else
		$video_settings = wpbeautify_get_default_video_settings();
	$img_css_str = '';
	$str_ret = '<style>';
	if ($video_settings['logo_img_url']) {
		if (!$video_settings['logo_img_url']) 
			$position = 'top_right';
		else
			$position = $video_settings['logo_position'];
		$default_offset = 15;

		switch ($position) {
			case 'top_right':
				$pos_str = 'top:'.$default_offset.'px;right:'.$default_offset.'px;';
				break;
			case 'top_left':
				$pos_str = 'top:'.$default_offset.'px;left:'.$default_offset.'px;';
				break;
			case 'bottom_right':
				$pos_str = 'bottom:'.$default_offset.'px;right:'.$default_offset.'px;';
				break;
			case 'bottom_left':
				$pos_str = 'bottom:'.$default_offset.'px;left:'.$default_offset.'px;';
				break;
			default:
			$pos_str = 'top:'.$default_offset.'px;right:'.$default_offset.'px;';
			break;			
		}

		$transparency = absint($video_settings['transparency']);

		if ($transparency) {
			$opacity = (100 - $transparency) / 100;
			$img_css_str = '.wpbeautify-video-logo {opacity:'.$opacity.'}';
		}

		$str_ret .= '.mejs-container .mejs-layers .mejs-logo-button {'.$pos_str .'} '.$img_css_str;
	}
	$str_ret .= '</style>';
	echo $str_ret;
}

add_action( 'wp_print_styles', 'wpbeautify_add_inline_video_css' );

function wpbeautify_enqueue_video() {
    wp_register_script( 'wpbeautify-mediaelement',
		WPBEAUTIFY_URL . '/js/mediaelement/mediaelement-and-player.min.js',
		array( 'jquery' ) );
	wp_enqueue_script( 'wpbeautify-mediaelement');

    wp_register_script( 'wpbeautify-wp-mediaelement',
		WPBEAUTIFY_URL . '/js/mediaelement/wp-mediaelement.js',
		array( 'jquery' ) );

    // wp_register_script('froogaloop', 'http://a.vimeocdn.com/js/froogaloop2.min.js');
    // wp_enqueue_script('froogaloop');

    $image_settings = wpbeautify_get_image_settings();
    
    if (isset($image_settings['video']))
    	$video_settings = $image_settings['video'];	
    else
    	$video_settings = wpbeautify_get_default_video_settings();
// var_dump($video_settings);
    $els_array = array( 'logo_url' =>  $video_settings['logo_img_url']);
    wp_localize_script( 'wpbeautify-wp-mediaelement', 'wpbeautify_video', $els_array );

	wp_enqueue_script( 'wpbeautify-wp-mediaelement');

	    wp_register_style( 'wpbeautify-mediaelement',
			WPBEAUTIFY_URL . '/js/mediaelement/mediaelementplayer.min.css' );
		wp_enqueue_style( 'wpbeautify-mediaelement');

	     wp_register_style( 'wpbeautify-video-skins',
		 	WPBEAUTIFY_URL . '/assets/video/skins/skins.css');
		 wp_enqueue_style( 'wpbeautify-video-skins');
}

add_action( 'wp_enqueue_scripts', 'wpbeautify_enqueue_video' );

add_filter('wp_enqueue_scripts', 'wpbeautify_clear_scripts', 100);

function wpbeautify_clear_scripts() {
	wp_deregister_script( 'wp-mediaelement' );
	wp_deregister_script( 'mediaelement' );
	wp_deregister_style( 'mediaelement' );
	wp_deregister_style( 'wp-mediaelement' );
}

// add_filter('wp_print_styles', 'wpbeautify_clear_styles', 100);

function wpbeautify_clear_styles() {
	wp_dequeue_style( 'mediaelement' );
	wp_dequeue_style( 'wp-mediaelement' );
}


function wpbeautify_remove_youtube_oembed() {
	wp_oembed_remove_provider('#https?://(www\.)?youtube\.com/watch.*#i');
	wp_oembed_remove_provider('#http://((m|www)\.)?youtube\.com/watch.*#i');
	wp_oembed_remove_provider('#https://((m|www)\.)?youtube\.com/watch.*#i');
	wp_oembed_remove_provider('#http://youtu\.be/.*#i');
	wp_oembed_remove_provider('#https://youtu\.be/.*#i');
}

function wpbeautify_remove_vimeo_oembed() {
	wp_oembed_remove_provider('#https?://(www\.)?vimeo\.com/.*#i');
}

add_shortcode('fotopress-video', 'wpbeautify_video_shortcode2');


/**
 * The Video shortcode.
 *
 * This implements the functionality of the Video Shortcode for displaying
 * WordPress mp4s in a post.
 *
 * @since 3.6.0
 *
 * @param array  $attr    Attributes of the shortcode.
 * @param string $content Optional. Shortcode content.
 * @return string HTML content to display video.
 */
function wpbeautify_video_shortcode2( $attr, $content = '' ) {
	global $content_width;
	$post_id = get_post() ? get_the_ID() : 0;

	static $instances = 0;
	$instances++;

	/**
	 * Override the default video shortcode.
	 *
	 * @since 3.7.0
	 *
	 * @param null              Empty variable to be replaced with shortcode markup.
	 * @param array  $attr      Attributes of the shortcode.
	 * @param string $content   Shortcode content.
	 * @param int    $instances Unique numeric ID of this video shortcode instance.
	 */
	$html = apply_filters( 'wp_video_shortcode_override', '', $attr, $content, $instances );
	if ( '' !== $html )
		return $html;

	$video = null;

	$default_types = wp_get_video_extensions();
	$defaults_atts = array(
		'src'      => '',
		'skin'      => '',
		'hidelogo'      => '',
		'youtube'      => '',
		'vimeo'      => '',
		'poster'   => '',
		'loop'     => '',
		'autoplay' => '',
		'preload'  => 'metadata',
		'height'   => 360,
		'width'    => empty( $content_width ) ? 640 : $content_width,
	);

	foreach ( $default_types as $type )
		$defaults_atts[$type] = '';

	$atts = shortcode_atts( $defaults_atts, $attr, 'video' );
	extract( $atts );


	if ( is_admin() ) {
		// shrink the video so it isn't huge in the admin
		if ( $width > $defaults_atts['width'] ) {
			$height = round( ( $height * $defaults_atts['width'] ) / $width );
			$width = $defaults_atts['width'];
		}
	} else {
		// if the video is bigger than the theme
		if ( ! empty( $content_width ) && $width > $content_width ) {
			$height = round( ( $height * $content_width ) / $width );
			$width = $content_width;
		}
	}

	
/*
	$w = $width;
	$h = $height;
	if ( is_admin() && $width > 600 )
		$w = 600;
	elseif ( ! is_admin() && $w > $defaults_atts['width'] )
		$w = $defaults_atts['width'];

	if ( $w < $width )
		$height = round( ( $h * $w ) / $width );

	$width = $w;
*/
	$primary = false;
	$is_web_video = 0;
	if ( ! empty( $src ) ) {
		$type = wp_check_filetype( $src, wp_get_mime_types() );
		// var_dump($type);
		if (strpos($src, 'youtube.com') !== false) {
			// youtube video
			$is_web_video = 1;
			wpbeautify_remove_youtube_oembed();
		}
		else if (strpos($src, 'youtu.be') !== false) {
			// youtube video
			$is_web_video = 1;
			wpbeautify_remove_youtube_oembed();
		}
		else if (strpos($src, 'vimeo.com') !== false) {
			// youtube video
			$is_web_video = 2;
			// wpbeautify_remove_vimeo_oembed();
		}		
		else if ( ! in_array( strtolower( $type['ext'] ), $default_types ) )
			return sprintf( '<a class="wp-embedded-video" href="%s">%s</a>', esc_url( $src ), esc_html( $src ) );
		$primary = true;
		array_unshift( $default_types, 'src' );
	} else {
		foreach ( $default_types as $ext ) {
			if ( ! empty( $$ext ) ) {
				$type = wp_check_filetype( $$ext, wp_get_mime_types() );
				if ( strtolower( $type['ext'] ) === $ext )
					$primary = true;
			}
		}
	}

	if ( ! $primary ) {
		$videos = get_attached_media( 'video', $post_id );
		if ( empty( $videos ) )
			return;

		$video = reset( $videos );
		$src = wp_get_attachment_url( $video->ID );
		if ( empty( $src ) )
			return;

		array_unshift( $default_types, 'src' );
	}

	$library = apply_filters( 'wp_video_shortcode_library', 'mediaelement' );
	if ( 'mediaelement' === $library && did_action( 'init' ) ) {
		wp_enqueue_style( 'wp-mediaelement' );
		wp_enqueue_script( 'wp-mediaelement' );
	}

	if ($skin) {
		$extra_class = ' mejs-wpbeautify mejs-'.$skin;
		$extra_class .= ' wpbtfy-volume-horizontal';
	}
	else
		$extra_class = ' mejs-wpbeautify';

	if ($hidelogo) {
		$extra_class .= ' nologo';
	}
	
	$atts = array(
		'class'    => apply_filters( 'wp_video_shortcode_class', 'wp-video-shortcode' ).$extra_class,
		'id'       => sprintf( 'video-%d-%d', $post_id, $instances ),
		'width'    => absint( $width ),
		'height'   => absint( $height ),
		'poster'   => esc_url( $poster ),
		'loop'     => $loop,
		'autoplay' => $autoplay,
		'preload'  => $preload,
		'style' => 'width:100%;height:100%'
	);

	// These ones should just be omitted altogether if they are blank
	foreach ( array( 'poster', 'loop', 'autoplay', 'preload' ) as $a ) {
		if ( empty( $atts[$a] ) )
			unset( $atts[$a] );
	}

	$attr_strings = array();
	foreach ( $atts as $k => $v ) {
		$attr_strings[] = $k . '="' . esc_attr( $v ) . '"';
	}

	$html = '';
	if ( 'mediaelement' === $library && 1 === $instances )
		$html .= "<!--[if lt IE 9]><script>document.createElement('video');</script><![endif]-->\n";
	$html .= sprintf( '<video %s controls="controls">', join( ' ', $attr_strings ) );

	$fileurl = '';
	$source = '<source type="%s" src="%s" />';
	foreach ( $default_types as $fallback ) {
		if ( ! empty( $$fallback ) ) {
			if ( empty( $fileurl ) )
				$fileurl = $$fallback;
			$type = wp_check_filetype( $$fallback, wp_get_mime_types() );
			// m4v sometimes shows up as video/mpeg which collides with mp4
			if ( 'm4v' === $type['ext'] )
				$type['type'] = 'video/m4v';
			if ($is_web_video == 1)
				$type['type'] = 'video/youtube';
			else if ($is_web_video == 2)
				$type['type'] = 'video/vimeo';

			$html .= sprintf( $source, $type['type'], esc_url( $$fallback ) );
		}
	}
	if ( 'mediaelement' === $library )
		$html .= wp_mediaelement_fallback( $fileurl );
	$html .= '</video>';

	$html = sprintf( '<div style="width: %dpx; max-width: 100%%;" class="wp-video">%s</div>', $width, $html );
	return apply_filters( 'wp_video_shortcode', $html, $atts, $video, $post_id, $library );
}


/* Editor Button */

/* TinyMCE Shortcode Generator */
function wpbeautify_video_js_button() {
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
		return;
	if ( get_user_option('rich_editing') == 'true' ) {
		add_filter('mce_external_plugins', 'wpbeautify_video_js_mce_plugin');
		add_filter('mce_buttons', 'wpbeautify_register_video_js_button');
	}
}
 add_action('init', 'wpbeautify_video_js_button');

function wpbeautify_register_video_js_button($buttons) {
	array_push($buttons, "|", "wpbeautifyvideo");
	$options = get_site_option('wpbeautifyvideo_options');
	echo('<div style="display:none"><input type="hidden" id="wpbeautifyvideo-autoplay-default" value="' . $options['wpbeautifyvideo_autoplay'] . '"><input type="hidden" id="wpbeautifyvideo-preload-default" value="' . $options['wpbeautifyvideo_preload'] . '"></div>'); 
	return $buttons;
}

function wpbeautify_video_js_mce_plugin($plugin_array) {
	$plugin_array['wpbeautifyvideo'] = WPBEAUTIFY_URL.'/js/mce-video-button.js';
	return $plugin_array;
}

?>