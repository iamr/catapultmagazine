<?php

// define('CANVAKALA_EXTRAS_URL', 'http://localhost/test/imgs');
define('CANVAKALA_YOUZIGN_URL', 'https://www.youzign.com/api/designs');

add_action( 'wp_ajax_wpbeautify_get_youzign', 'wpbeautify_get_youzign_images' );
// add_action( 'wp_ajax_wpbeautify_extras_browse_album_pics', 'wpbeautify_extras_browse_album_pics' );

// add_action( 'wp_ajax_wpbeautify_get_extras', 'wpbeautify_print_extras' );

function wpbeautify_get_youzign_images() {
    $page = isset($_POST['page']) ? $_POST['page'] : 0;
    $album_photos = wpbeautify_youzign_get_photos_in_album(0, $page, WPBEAUTIFY_IMAGES_PER_PAGE);
    wpbeautify_print_social_images($album_photos, $page, WPBEAUTIFY_IMAGES_PER_PAGE);
    exit(0);
}

/*function wpbeautify_extras_browse_albums() {
    $albums = wpbeautify_get_extras_albums();
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    if ($page) $page--;
    wpbeautify_print_photo_album($albums, 'extras', $page, 36);
    exit(0);
}




function wpbeautify_get_extras_albums() {

    $response = wp_remote_get( CANVAKALA_EXTRAS_URL.'/dirs.json' );
    if( is_array($response) ) {
      // $header = $response['headers']; // array of http header lines
      $body = $response['body']; // use the content
    }
    $remote_albums = json_decode($body);

    $albums = array();
    foreach($remote_albums as $album_n)
    {
        // if (!$i++) continue;

        // echo $match . '<br>';
        // $folder = rtrim($match, '/');
        $album = array(
            'id' => $album_n,
            'name' => $album_n,
            'thumb' => WPBEAUTIFY_URL.'/img/icons/folder.png',
            'count' => 0
        );
        $albums[] = $album;
    }


    // echo $str_ret;
    return $albums;

}


function wpbeautify_get_text($filename)
{
    $fp_load = fopen("$filename", "rb");
    if ( $fp_load )
    {
        while ( !feof($fp_load) )
        {
            $content .= fgets($fp_load, 8192);
        }
        fclose($fp_load);
    return $content;
    }
}
*/

function wpbeautify_youzign_get_photos_in_album($album_id, $page=0, $results_per_page=WPBEAUTIFY_IMAGES_PER_PAGE) {

        if ($page) $page--;
        $start_index = $page*$results_per_page;

        $image_settings = wpbeautify_get_image_settings();
        $key = $image_settings['social_sites']['youzign']['api_key'];
        $token = $image_settings['social_sites']['youzign']['token'];


        $api_params = array(
            'key' => $key,
            'token' => $token,
        );

        $request = wp_remote_post( CANVAKALA_YOUZIGN_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

        if ( ! is_wp_error( $request ) ) {
            $request = json_decode( wp_remote_retrieve_body( $request ), true );
        } else {
            $request = false;
        }

        if (!$request) return 0;
          // var_dump($request);
        $total_imgs = count ($request);
        $request = array_slice($request, $start_index, $results_per_page);
        $photos_ret = array();
        foreach($request as $image) {
                $photo_arr = array(
                    'image_source' => 'youzign',
                    'thumbnail_url' => $image['image_sizes']['thumbnail'][0],
                    'fullsize_url' => $image['image_src'][0],
                    'width' => $image['image_src'][1],
                    'height' => $image['image_src'][2],
                    'title' => $image['title'],
                    'original_url' => $image['link']
                );
                $photos_ret[] = $photo_arr;
                $total_imgs++;
            }
    return array($total_imgs, $photos_ret);


}
?>