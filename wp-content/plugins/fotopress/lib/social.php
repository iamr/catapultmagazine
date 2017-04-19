<?php

add_filter('the_content', 'wpbeautify_show_share_btns');

function wpbeautify_show_share_btns($content) {

$social_content = '<div class="wpbtfy-social-button-container">

	<!-- Facebook -->
	<div class="wpbtfy-social social-fb"><a href="http://www.facebook.com/sharer/sharer.php?u='.get_the_title().'"><img src="'.WPBEAUTIFY_URL.'/assets/social-media/1/facebook.png"  class="wpbtfy_share_img" /></a>
	</div>

	<!-- Twitter -->
	<div class="wpbtfy-social social-twitter"><a href="http://twitter.com/home?status='.get_the_title().'"><img src="'.WPBEAUTIFY_URL.'/assets/social-media/1/twitter.png"  class="wpbtfy_share_img" /></a>
	</div>

	<!-- Google Plus -->
	<div class="wpbtfy-social social-gplus"><a href="https://plus.google.com/share?url='.get_permalink().'"><img src="'.WPBEAUTIFY_URL.'/assets/social-media/1/googleplus.png"  class="wpbtfy_share_img" /></a>

	</div>

	<!-- LinkedIN -->
	<div class="wpbtfy-social social-linkedin"><a href="http://www.linkedin.com/shareArticle?mini=true&url='.get_permalink().'&title='.get_the_title().'&summary=&source="><img src="'.WPBEAUTIFY_URL.'/assets/social-media/1/linkedin.png"  class="wpbtfy_share_img" /></a>
	</div>
</div>';
	return $content.$social_content;
	}

function wpbeautify_frontend_css() {
 
    //wp_enqueue_script('jquery');
 
    wp_register_style( 'wpbeautify-css', WPBEAUTIFY_URL . '/css/wpbeautify-front.css','','', 'screen' );
    wp_enqueue_style( 'wpbeautify-css' );
 
}

if (!is_admin())
	add_action( 'wp_enqueue_scripts', 'wpbeautify_frontend_css' );


?>