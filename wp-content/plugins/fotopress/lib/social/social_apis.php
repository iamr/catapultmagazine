<?php

add_action( 'wp_ajax_wpbeautify_get_fb_albums', 'wpbeautify_get_fb_albums' );

if ( ckala_is_pro() ) {
    include_once WPBEAUTIFY_DIR.'/lib/social/facebook.php';
    include_once WPBEAUTIFY_DIR.'/lib/social/pinterest.php';
    include_once WPBEAUTIFY_DIR.'/lib/social/flickr.php';
    include_once WPBEAUTIFY_DIR.'/lib/social/instagram.php';
    include_once WPBEAUTIFY_DIR.'/lib/social/googleplus.php';
    include_once WPBEAUTIFY_DIR.'/lib/social/twitter.php';
    include_once WPBEAUTIFY_DIR.'/lib/social/memes.php';
    include_once WPBEAUTIFY_DIR.'/lib/social/extras.php';
}
include_once WPBEAUTIFY_DIR.'/lib/social/youzign.php';

function wpbeautify_print_social_images($images, $page=0, $results_per_page=36) {
    if (!$images || !$images[0] || !$images[1])
    	return 'No images found';
    $total_imgs = $images[0];
    $images = $images[1];

/*    $start_img = $page*$results_per_page;
    $end_img = (($start_img+$results_per_page) > $total_imgs ?  $total_imgs : ($start_img+$results_per_page) );
*/
    $str_ret = '';
    $str_ret = wpbeautify_paint_pagination( $page, $total_imgs, $results_per_page );
    $str_ret .=  '<div class = "wpbeautify_attachments_container" style="" class="wpbeautify-attachments">';
    $str_ret .=  '<ul class="attachments-view-wpbeautify" style="margin-top:0px;">';

    echo $str_ret;
    // go through all results
    $current_n_results = 0;
/*     for ($i=$start_img;$i<$end_img;$i++) {
        $image = $images[$i];*/
       foreach ($images as $image) {
?>
            <li class="wpbeautify-attachment">
                <div class="wpbeautify-attachment-preview">
                        <div class="wpbeautify-thumbnail">
                            <div class="centered">
                                <img class="wpbeautify_thumb wpbeautify_thumb_<?php echo $image['image_source'];?>" src="<?php echo $image['thumbnail_url'];?>"
                                    data-width="<?php echo $image['width'];?>"
                                    data-height="<?php echo $image['height'];?>"
                                    data-url="<?php echo $image['fullsize_url'];?>"
                                    data-origin="<?php echo $image['image_source'];?>"
                                    data-original-url="<?php echo $image['original_url'];?>"
                                    title="<?php echo $image['title'];?>" 
                                    data-source="social-image"

                                    />
                            </div>
                        </div>
                        <a title="Deselect" href="#" class="check"><div class="media-modal-icon"></div></a>
                </div>
            </li>

    <?php
    }
    echo '</ul><div style="clear:both;"></div></div>';    
}

function wpbeautify_print_photo_album($albums, $type='', $page=0, $results_per_page=36) {
	if (!$albums)
		return 'No albums found';
// var_dump($page);
    $start_album = $page*$results_per_page;
    $total_albums = count($albums);
    $end_album = (($start_album+$results_per_page) > $total_albums ?  $total_albums : ($start_album+$results_per_page) );

    $str_ret = '';
    $str_ret = wpbeautify_paint_pagination( ++$page, $total_albums, $results_per_page, false, 'wpbtfy-albums' );
    $str_ret .=  '<div class = "wpbeautify_attachments_container" style="" class="wpbeautify-attachments">';
    $str_ret .=  '<ul class="attachments-view-wpbeautify" style="margin-top:0px;">';

    // echo $str_ret;
    // go through all results
    $current_n_results = 0;
    for ($i=$start_album;$i<$end_album;$i++) {
        $album = $albums[$i];
        if (isset($album['count']) && ($album['count'] != -1) && ($album['count'] != 0)) {
        	if ($album['count'] == 1) $txt = 'image'; else $txt = 'images';
        	$album_name = $album['name'].' ('.$album['count'].' '.$txt.')';
        }
        else
        	$album_name = $album['name'];
        $str_ret .= '<li class="wpbtfy_album"><a class="wpbeautify_pics_in_album '.$type.'" data-album-id="'.$album['id'].'" data-album-name="'.htmlspecialchars($album['name'], ENT_QUOTES, "UTF-8")/*htmlentities($album['name'])*/.'" href="#">';
        $str_ret .= '<img src="'.$album['thumb'].'" />';
        $str_ret .= '<span class="album_name">'.$album_name.'</span></a>';
        $str_ret .= '</li>';
    }
    $str_ret .= '</ul><div style="clear:both;"></div></div>'; 	
    echo $str_ret;
}

    
function wpbeautify_check_social_auth($site) {
    $image_settings = wpbeautify_get_image_settings();
    $str_error = '';
    switch ($site) {
        case 'facebook':
            if (empty($image_settings['social_sites']['facebook']['token']))
                $str_error = 'Please authorize your Facebook App first <a target="_blank" href="'.admin_url('/admin.php?page=fotopress-images').'">here</a>';
            break;
        case 'instagram':
            if (empty($image_settings['social_sites']['instagram']['token']))
                $str_error = 'Please authorize your Instagram account first <a target="_blank" href="'.admin_url('/admin.php?page=fotopress-images').'">here</a>';
            break;
        case 'pinterest':
            if (empty($image_settings['social_sites']['pinterest']['username']))
                $str_error = 'Please enter your Pinterest unsername first <a target="_blank" href="'.admin_url('/admin.php?page=fotopress-images').'">here</a>';
            break;
        case 'flickr':
            if (!$image_settings['image_sites']['flickr']['details']['validapi'])
                $str_error = 'Please enter your Flickr API details first <a target="_blank" href="'.admin_url('/admin.php?page=fotopress-images').'">here</a>';
            break;
        case 'googleplus':
            if (empty($image_settings['social_sites']['googleplus']['token']))
                $str_error = 'Please authorize your Google+ account first <a target="_blank" href="'.admin_url('/admin.php?page=fotopress-images').'">here</a>';
            break;
        default:
            break;
    }
    if (!empty($str_error)) {
        echo '<p class="centered_panel social_panel_info">'.$str_error.'</p>';
        exit(0);
    }
}
?>