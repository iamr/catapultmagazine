<?php

// define('CANVAKALA_EXTRAS_URL', 'http://localhost/test/imgs');
define('CANVAKALA_EXTRAS_URL', 'http://canvakala.s3.amazonaws.com/imagepack');

add_action( 'wp_ajax_wpbeautify_extras_browse_albums', 'wpbeautify_extras_browse_albums' );
add_action( 'wp_ajax_wpbeautify_extras_browse_album_pics', 'wpbeautify_extras_browse_album_pics' );

// add_action( 'wp_ajax_wpbeautify_get_extras', 'wpbeautify_print_extras' );


function wpbeautify_extras_browse_albums() {
    $albums = wpbeautify_get_extras_albums();
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    if ($page) $page--;
    wpbeautify_print_photo_album($albums, 'extras', $page, 36);
    exit(0);
}

function wpbeautify_extras_browse_album_pics() {
    $page = isset($_POST['page']) ? $_POST['page'] : 0;
    $album_photos = wpbeautify_extras_get_photos_in_album($_POST['album_id'], $page, WPBEAUTIFY_IMAGES_PER_PAGE);
    wpbeautify_print_social_images($album_photos, $page, WPBEAUTIFY_IMAGES_PER_PAGE);
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
    if ($remote_albums) {
        foreach($remote_albums as $album_n)
        {
            $album = array(
                'id' => $album_n,
                'name' => $album_n,
                'thumb' => WPBEAUTIFY_URL.'/img/icons/folder.png',
                'count' => 0
            );
            $albums[] = $album;
        }
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


function wpbeautify_extras_get_photos_in_album($album_id, $page=0, $results_per_page=WPBEAUTIFY_IMAGES_PER_PAGE) {

        if ($page) $page--;
        $start_index = $page*$results_per_page + 1;

          // var_dump($array_ret);
          $total_imgs = 0;
        $photos_ret = array();

            /*$cover_img = $thumb;
            $name = $title;
            $id = $album_id;*/


            // $html = file_get_contents($url);

            // $count = preg_match_all('/<td><a href="([^"]+)">[^<]*<\/a><\/td>/i', $html, $files);
            // $count = preg_match_all('/<a href="([-\w\d.]+\.(jpeg|png|gif))"/', $html, $files);

            $matches = array();

// var_dump($matches[2]);
            // foreach($matches[2] as $match)

// var_dump($files);
// var_dump($url);
            // for ($i = 0; $i < $count; ++$i) {

                // echo "File: " . $files[1][$i] . "<br />\n";
            $i=0;
            $url = CANVAKALA_EXTRAS_URL.'/'.$album_id;
            $response = wp_remote_get( $url.'/props.json' );
            if( is_array($response) ) {
              // $header = $response['headers']; // array of http header lines
              $body = $response['body']; // use the content
            }
            $images = json_decode($body);
        $total_imgs = count($images);
        $images = array_slice($images, $start_index, $results_per_page);
    foreach($images as $match) {
        if ($match->name == 'props.json')  continue;
                $photo_arr = array(
                    'image_source' => 'extras',
                    'thumbnail_url' => $url.'/thumbs/'.$match->name,
                    'fullsize_url' => urlencode($url.'/'.$match->name),
                    'width' => $match->width,
                    'height' => $match->height,
                    'title' => $match->name,
                    'original_url' => $url.'/'.$match->name
                );
                $photos_ret[] = $photo_arr;
                // $total_imgs++;
            }
    return array($total_imgs, $photos_ret);


}

?>