<?php
    // use DirkGroenen\Pinterest\Pinterest;

// http://pinterestapi.co.uk/
// con esto obtengo boards
// con estos, pines de un board: http://pinterest.com/janew/delicious.rss

add_action( 'wp_ajax_wpbeautify_pinterest_browse_albums', 'wpbeautify_pinterest_browse_albums' );
add_action( 'wp_ajax_wpbeautify_pinterest_browse_album_pics', 'wpbeautify_pinterest_browse_album_pics' );

function wpbeautify_pinterest_get_photos_in_album($board_id, $page=0, $results_per_page=WPBEAUTIFY_IMAGES_PER_PAGE) {

    $image_settings = wpbeautify_get_image_settings();
    $username = $image_settings['social_sites']['pinterest']['username'];
	if( $board_id )
        $uri = 'http://www.pinterest.com/'.$username.'/'.$board_id.'.rss';
    else
        $uri = 'http://www.pinterest.com/'.$username.'/feed.rss';

	$rss = fetch_feed( $uri );
	if($rss instanceof WP_Error) return 0;
	$rss->set_timeout(60);

    if ($page) $page--;

// Figure out how many total items there are.
	$maxitems = $rss->get_item_quantity();
    $start_index = $page*$results_per_page;
// Build an array of all the items, starting with element 0 (first element).
        $rss_items = $rss->get_items($start_index, $results_per_page);
// $content = '';
        $images = array();
        foreach ( $rss_items as $item ) {
                $image=array();
	// $content .= '<a href="'.$item->get_permalink().'"';
                // var_dump($item->get_permalink());
                // var_dump($item->get_title());
	// $item->get_title()
                $image['original_url'] = $item->get_permalink();
                $image['title'] = $item->get_title();
    if ($thumb = $item->get_item_tags(SIMPLEPIE_NAMESPACE_MEDIARSS, 'thumbnail') ) {
// var_dump($thumb);

          $thumb = $thumb[0]['attribs']['']['url'];
          $image['thumbnail_url'] = $thumb;
		//$content .= '<img src="'.$thumb.'"';
		$content .= ' alt="'.$item->get_title().'"/>';
	}  else {
		// var_dump($item->get_content());
        preg_match('/src="([^"]*)"/', $item->get_content(), $matches);
		$src = $matches[1];
		$largesrc = str_replace('/192x/', '/736x/', $src);
                        // var_dump($matches);

		if ($matches) {
                        $image['thumbnail_url'] = $src;
                        $image['fullsize_url'] = $largesrc;
		  // $content .= '<img src="'.$largesrc.'"';
		// $content .= ' alt="'.$item->get_title().'"/>';
                } else {
		  // $content .= "thumbnail not available";
                        $image['thumbnail_url'] = '';
                        $image['fullsize_url'] = '';
                }
        }
        $image['image_source'] = 'pinterest';
        $image['width'] = '0';
        $image['height'] = '0';
        $images[]= $image;
}
// echo $content;
	// var_dump($rss_items);
return array($maxitems, $images);
}


function wpbeautify_get_pinterest_albums( $page=0 ) {
    wpbeautify_check_social_auth('pinterest');

    $image_settings = wpbeautify_get_image_settings();
    $username = $image_settings['social_sites']['pinterest']['username'];
    // if ()
    // var_dump($page);

    /*
    $req_args = array(
        'page'           => $page
    );

    // echo 'http://pinterestapi.co.uk/'.$wpbeautify_sites['pinterest']['username'].'/boards';
    $response = wp_remote_get( 'http://pinterestapi.co.uk/'.$username.'/boards' );
     // var_dump($response);
    if ( is_wp_error( $response ) ) {
        return 0;
    } else {
        $albums = json_decode( $response['body'] );
        if (!$albums) return 0;
        $albums = $albums->body;

        $albums_arr = array();

        foreach ($albums as $photoset) {
            $board_url = explode('/',$photoset->href);
            $id = $board_url[2];
            $album = array(
                'id' => $id,
                'name' => $photoset->name,
                'thumb' =>  $photoset->src,
                'count' => -1
                );
            $albums_arr[] = $album;

        }
        // echo $str_ret;

    }*/

    // return $albums_arr;

}

function wpbeautify_print_pinterest_images($page=0, $results_per_page=36) {
    $images = wpbeautify_get_pinterest_images();
    return wpbeautify_print_social_images($images, $page, $results_per_page);
}

function wpbeautify_pinterest_browse_albums() {
    if( 0 ) {
        $albums = wpbeautify_get_pinterest_albums();
        wpbeautify_print_photo_album($albums, 'pinterest', 0, WPBEAUTIFY_IMAGES_PER_PAGE);
    }
    else {
        wpbeautify_pinterest_browse_album_pics( false );
    }
    exit(0);
}

function wpbeautify_pinterest_browse_album_pics( $album = true ) {
    if( $album )
        $album_id = $_POST['album_id'];
    else
        $album = false;
    $page = isset($_POST['page']) ? $_POST['page'] : 0;
    $album_photos = wpbeautify_pinterest_get_photos_in_album( $album, $page, WPBEAUTIFY_IMAGES_PER_PAGE );
    wpbeautify_print_social_images($album_photos, $page, WPBEAUTIFY_IMAGES_PER_PAGE);
    exit(0);

    /*$album_photos = wpbeautify_pinterest_get_photos_in_album($_POST['album_id']);
    $page = 0;
    $results_per_page = 36;
    wpbeautify_print_social_images($album_photos, $page, $results_per_page);*/
    exit(0);
}


?>