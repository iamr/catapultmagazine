<?php

add_action( 'wp_ajax_wpbeautify_flickr_browse_albums', 'wpbeautify_flickr_browse_albums' );
add_action( 'wp_ajax_wpbeautify_flickr_browse_album_pics', 'wpbeautify_flickr_browse_album_pics' );


function wpbeautify_print_flickr_images($page=0, $results_per_page=36) {
    return wpbeautify_get_flickr_albums();
    // return wpbeautify_print_social_images($page, $results_per_page);
}


function wpbeautify_get_flickr_albums() {
    wpbeautify_check_social_auth('flickr');

    $image_settings = wpbeautify_get_image_settings();
    $wpbeautify_sites = $image_settings['image_sites'];

    /* 1st, get calling user id */
    $req_args = array(
        'api_key'        => $wpbeautify_sites['flickr']['details']['api_key'],
        'method'         => 'flickr.urls.lookupUser',
        // 'url'            => 'https://www.flickr.com/photos/jekaphotography/',
        'url'            => 'https://www.flickr.com/photos/'.$wpbeautify_sites['flickr']['details']['username'].'/',
        'format'         => 'php_serial'
    );


    $response = wp_remote_get( add_query_arg( $req_args, 'https://api.flickr.com/services/rest/' ) );
    $user_details = unserialize( $response['body'] );
  // var_dump($user_details);
    if (isset($user_details['user']['id']))
        $user_id = $user_details['user']['id'];

    $results_per_page = 30;
    $page = 0;
    $albums = array();

        //TODO: LICENSE: http://www.flickr.com/services/api/flickr.photos.licenses.getInfo.html
        $req_args = array(
            'per_page'       => $results_per_page,
            'page'           => $page,
           'user_id' => $user_id,
            'primary_photo_extras' => 'url_sq',
            'api_key'        => $wpbeautify_sites['flickr']['details']['api_key'],
            'method'         => 'flickr.photosets.getList',
            'format'         => 'php_serial'
        );

        $response = wp_remote_get( add_query_arg( $req_args, 'https://api.flickr.com/services/rest/' ) );
        // var_dump($response);
        if ( is_wp_error( $response ) ) {
            return 0;
        } else {
            // return wpbeautify_flickr_togeneric ( , $offset, $results_per_page );
            $photosets = unserialize( $response['body'] );
             // var_dump($photosets);
            // $str_ret = '';
            // $photosets_ret = 
            if ($photosets && isset($photosets['photosets'])) {
                foreach ($photosets['photosets']['photoset'] as $photoset) {

                    $album = array(
                        'id' => $photoset['id'],
                        'name' => $photoset['title']['_content'],
                        'thumb' =>  $photoset['primary_photo_extras']['url_sq'],
                        'count' => $photoset['photos']
                        );
                    $albums[] = $album;                

                }
            }
        }
        return $albums;
}


function wpbeautify_flickr_get_photos_in_album($album_id, $page=0, $results_per_page=WPBEAUTIFY_IMAGES_PER_PAGE) {
    $image_settings = wpbeautify_get_image_settings();
    $wpbeautify_sites = $image_settings['image_sites'];

    // if ($page) $page--;

    /*$results_per_page = 30;
    $page = 0;*/
        //TODO: LICENSE: http://www.flickr.com/services/api/flickr.photos.licenses.getInfo.html
        $req_args = array(
            'per_page'       => $results_per_page,
            'page'           => $page,
            'photoset_id' => $album_id,
            'extras' =>     'url_t,url_o,url_l,url_m', /*url_sq, ,o_dims */
            'api_key'        => $wpbeautify_sites['flickr']['details']['api_key'],
            'method'         => 'flickr.photosets.getPhotos',
            'format'         => 'php_serial'
        );

        $response = wp_remote_get( add_query_arg( $req_args, 'https://api.flickr.com/services/rest/' ) );
         // var_dump($response);
        if ( is_wp_error( $response ) ) {
            return 0;
        } else {
            // var_dump($response['body']);
            // return wpbeautify_flickr_togeneric ( , $offset, $results_per_page );
            $photos = unserialize( $response['body'] );
            $photos_ret = array();
            $total_photos = $photos['photoset']['total'];
                  
              // var_dump($photos/*['photo']*/);
            foreach ($photos['photoset']['photo'] as $photo) {
                // var_dump($photo);
                if ( isset( $photo['url_o'] ) ) {
                    $image_fullsize_url = $photo['url_o'];
                    $image_width = $photo['width_o'];
                    $image_height = $photo['height_o'];
                }
                else if ( isset( $photo['url_l'] ) ) {
                        $image_fullsize_url = $photo['url_l'];
                        $image_width = $photo['width_l'];
                        $image_height = $photo['height_l'];
                    }
                else {
                    $image_fullsize_url = $photo['url_m'];
                    $image_width = $photo['width_m'];
                    $image_height = $photo['height_m'];
                }

                $photo_arr = array(
                    'image_source' => 'flickr',
                    'thumbnail_url' => $photo['url_t'],
                    'fullsize_url' => $image_fullsize_url,
                    'width' => $image_width,
                    'height' => $image_height,
                    'title' => $photo['title'],
                    'original_url' => 'pendiente'
                );
                $photos_ret[] = $photo_arr;
            }
            return array($total_photos, $photos_ret);
            // var_dump($photos['photoset']['photo']);
            // $photosets_ret = 
/*            foreach ($photosets['photosets']['photoset'] as $photoset) {
                $cover_img = $photoset['primary_photo_extras']['url_sq'];
                $name = $photoset['title']['_content'];
                $id = $photoset['id'];
                echo '<img src="'.$cover_img.'" /><br/>'.$name.'<br/>';
            }*/
            // var_dump();
        }
}

/*
<img class="wpbeautify_thumb wpbeautify_thumb_<?php echo $image['image_source'];?>" src="<?php echo $image['thumbnail_url'];?>"
    data-width="<?php echo $image['width'];?>"
    data-height="<?php echo $image['height'];?>"
    data-url="<?php echo $image['fullsize_url'];?>"
    data-origin="<?php echo $image['image_source'];?>"
    data-original-url="<?php echo $image['original_url'];?>"
    title="<?php echo $image['title'];?>"*/

function wpbeautify_flickr_browse_albums() {
    $albums = wpbeautify_get_flickr_albums();
    wpbeautify_print_photo_album($albums, 'flickr', 0, 36);    
    exit(0);
}

function wpbeautify_flickr_browse_album_pics() {
    $page = isset($_POST['page']) ? $_POST['page'] : 0;
    $album_photos = wpbeautify_flickr_get_photos_in_album($_POST['album_id'], $page, WPBEAUTIFY_IMAGES_PER_PAGE);
    wpbeautify_print_social_images($album_photos, $page, WPBEAUTIFY_IMAGES_PER_PAGE);
    exit(0);
}

function wpbeautify_flickr_authorize() {
    require_once WPBEAUTIFY_DIR.'/lib/social/flickr_api/Flickr.php';
    // use \DPZ\Flickr;

    $image_settings = wpbeautify_get_image_settings();

    $callback = admin_url('/admin.php?page=fotopress-images&auth=flickr');
    var_dump($image_settings['social_sites']['flickr']);
    die();
    $flickr = new Flickr($image_settings['social_sites']['flickr']['api_key'], $image_settings['social_sites']['flickr']['api_secret'], $callback);

    if (!$flickr->authenticate('write'))
    {
        die("Hmm, something went wrong...\n");
    }

    // $image_settings['social_sites']['flickr']['api_key'] = $_POST['facebook_app_id'];
    // $image_settings['social_sites']['flickr']['api_secret'] = $_POST['facebook_app_secret'];
    // 'Flickr' => array(
    //     'key' => 'YOUR APP KEY',
    //     'secret' => 'YOUR APP SECRET'
    // )
}

function wpbeautify_flickr_do_auth() {
    $image_settings = wpbeautify_get_image_settings();
    
}

?>