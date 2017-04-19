<?php

add_action( 'wp_ajax_wpbeautify_instagram_browse_pics', 'wpbeautify_instagram_browse_pics' );

function wpbeautify_instagram_get_auth() {
  if ( !class_exists( 'Instagram' ) )
    require WPBEAUTIFY_DIR.'/lib/social/instagram_api/Instagram.php';
    // require_once WPBEAUTIFY_DIR.'/lib/social/instagram_api/instagram.class.php';
    $image_settings = wpbeautify_get_image_settings();

    $image_settings['social_sites']['instagram']['api_key'] = $_POST['instagram_api_key'];
    $image_settings['social_sites']['instagram']['api_secret'] = $_POST['instagram_api_secret'];

    wpbeautify_set_image_settings($image_settings);
    
    $instagram = new Instagram(array(
      'apiKey'      => $image_settings['social_sites']['instagram']['api_key'],
      'apiSecret'   => $image_settings['social_sites']['instagram']['api_secret'],
      'apiCallback' => admin_url('/admin.php?page=fotopress-images&auth=instagram' )
    ));

    // create login URL
    $loginUrl = $instagram->getLoginUrl();
    header("Location: $loginUrl");
}

function wpbeautify_instagram_store_token($code) {
  if ( !class_exists( 'Instagram' ) )
    require WPBEAUTIFY_DIR.'/lib/social/instagram_api/Instagram.php';
    // require_once WPBEAUTIFY_DIR.'/lib/social/instagram_api/instagram.class.php';
    $image_settings = wpbeautify_get_image_settings();

    $instagram = new Instagram(array(
      'apiKey'      => $image_settings['social_sites']['instagram']['api_key'],
      'apiSecret'   => $image_settings['social_sites']['instagram']['api_secret'],
      'apiCallback' => admin_url('/admin.php?page=fotopress-images&auth=instagram' )
    ));


              // receive OAuth token object
              $data = $instagram->getOAuthToken($code);
             $username = $data->user->username;
              
              // store user access token
              $instagram->setAccessToken($data);
              return $data;

          }

function wpbeautify_instagram_get_images($page=0, $results_per_page=WPBEAUTIFY_IMAGES_PER_PAGE) {
    wpbeautify_check_social_auth('instagram');
    if ( !class_exists( 'Instagram' ) )
      require WPBEAUTIFY_DIR.'/lib/social/instagram_api/Instagram.php';
    // use MetzWeb\Instagram\Instagram;

    // require_once WPBEAUTIFY_DIR.'/lib/social/instagram_api/instagram.class.php';
    $image_settings = wpbeautify_get_image_settings();

    $instagram = new Instagram(array(
      'apiKey'      => $image_settings['social_sites']['instagram']['api_key'],
      'apiSecret'   => $image_settings['social_sites']['instagram']['api_secret'],
      'apiCallback' => admin_url('/admin.php?page=fotopress-images&auth=instagram' )
    ));    
    $image_settings = wpbeautify_get_image_settings();
    $token = $image_settings['social_sites']['instagram']['token'];
    // var_dump($token);
    // die();
    $instagram->setAccessToken($token);
    $result = $instagram->getUserMedia();
    $images = array();
    foreach ($result->data as $item) {
// var_dump($item);

      if ($item->type != 'image') continue;
          // var_dump($item);
        $image=array();
        $image['original_url'] = $item->link;
        if ( isset($item->caption) && !empty( $item->caption ) && isset($item->caption->text ) )
          $image['title'] = $item->caption->text;
        else
          $image['title'] = /*basename($item->images->standard_resolution->url)*/'';
        $image['thumbnail_url'] = $item->images->thumbnail->url;
        if ( ($pos = strpos($item->images->standard_resolution->url, '?ig_cache_key')) !== false) {
          $img_url = substr( $item->images->standard_resolution->url, 0, $pos );
        }
        else
          $img_url = $item->images->standard_resolution->url;
        // var_dump($img_url);
        // $break = explode( '?ig_cache_key', $item->images->standard_resolution->url);
        $image['fullsize_url'] = $img_url;
        $image['image_source'] = 'instagram';
        $image['width'] = $item->images->standard_resolution->width;
        $image['height'] = $item->images->standard_resolution->height;
        $images[]= $image; 
    }
    
    if ($page) $page--;

    $total_imgs = count($images);
    $start_index = $page*$results_per_page;

    $sliced_imgs = array_slice($images, $start_index, $results_per_page);
    return array($total_imgs, $sliced_imgs);
 
}

function wpbeautify_print_instagram_images($page=0, $results_per_page=36) {
    return wpbeautify_get_instagram_albums();
    // return wpbeautify_print_social_images($page, $results_per_page);
}

function wpbeautify_instagram_browse_albums() {
    wpbeautify_get_instagram_albums();
    exit(0);
}

function wpbeautify_instagram_browse_pics() {
  $page = isset($_POST['page']) ? $_POST['page'] : 0;
  $album_photos = wpbeautify_instagram_get_images($page, WPBEAUTIFY_IMAGES_PER_PAGE);
  wpbeautify_print_social_images($album_photos, $page, WPBEAUTIFY_IMAGES_PER_PAGE);
  exit(0);
}
?>