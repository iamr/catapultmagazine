<?php
define('WPBEAUTIFY_MEMES_URL', 'https://canvakala.s3.amazonaws.com/memes/');
add_action( 'wp_ajax_wpbeautify_get_memes', 'wpbeautify_print_memes' );

function wpbeautify_print_memes() {
    $memes = array();
    for ($i=1;$i<25;$i++) {
        // $img_url = WPBEAUTIFY_URL.'/assets/images/memes/'.$i.'.jpg';
        $img_url = WPBEAUTIFY_MEMES_URL.$i.'.jpg';
        $image=array();
        $image['original_url'] = $img_url;
        $image['title'] = 'Meme '.$i;
        $image['thumbnail_url'] = $img_url;
        $image['fullsize_url'] = $img_url;
        $image['image_source'] = 'memes';
        $image['width'] = 0;
        $image['height'] = 0;

        $memes[] = $image;
    }
    wpbeautify_print_social_images(array(count($memes), $memes));
    exit();
}   
?>