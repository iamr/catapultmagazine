<?php
// https://developers.facebook.com/docs/facebook-login/access-tokens/#extending

add_action( 'wp_ajax_wpbeautify_facebook_browse_albums', 'wpbeautify_facebook_browse_albums' );
add_action( 'wp_ajax_wpbeautify_facebook_browse_album_pics', 'wpbeautify_facebook_browse_album_pics' );

function wpbeautify_fb_get_albums($do_redirect=0) {
    wpbeautify_check_social_auth('facebook');

	require_once WPBEAUTIFY_DIR.'/lib/social/facebook_sdk/facebook.php';
	$image_settings = wpbeautify_get_image_settings();

	$facebook = new Facebook(array(
		'appId'  => $image_settings['social_sites']['facebook']['app_id'],
		'secret' => $image_settings['social_sites']['facebook']['app_secret'],
		'cookie' => true,
	));
	
		$access_token = $image_settings['social_sites']['facebook']['token'];

	$albums = array();
	if ($access_token)
		$facebook->setAccessToken($access_token);

	$user = $facebook->getUser();
	  // var_dump($user);
	if ($user) {
		if (empty($access_token))
			$access_token = $facebook->getAccessToken();
		try {
			$user_albums = $facebook->api('/me/albums');
			// var_dump($user_albums);
			if(!empty($user_albums['data'])) {
				foreach($user_albums['data'] as $album) {
					$temp = array();
					$temp['id'] = $album['id'];
					$temp['name'] = $album['name'];
					$temp['thumb'] = "https://graph.facebook.com/{$album['id']}/picture?type=album&access_token={$access_token}";
					$temp['count'] = (!empty($album['count'])) ? $album['count']:0;
					$albums[] = $temp;
				}
			}
		} catch (FacebookApiException $e) {
			// error_log($e);
			 // var_dump($e);
			$user = null;
		}
	}
	return $albums;

/*	$str_ret = '';
	// $photosets_ret = 
	foreach ($albums as $photoset) {
	    $cover_img = $photoset['thumb'];
	    $name = $photoset['name'];
	    $id = $photoset['id'];
	    $count = $photoset['count'];
	    $str_ret .= '<div class="wpbtfy_album"><a class="wpbeautify_pics_in_album facebook" data-album-id="'.$id.'" href="#">';
	    $str_ret .= '<img src="'.$cover_img.'" /><br/>'.$name.' ('.$count.')</a>';
	    $str_ret .= '</div>';

	    // wpbeautify_get_photos_in_album($id);
	}
	echo $str_ret;*/

	if ($user) {
		$logoutUrl = $facebook->getLogoutUrl();
	} else {
		$loginUrl = $facebook->getLoginUrl(array(
			'scope' => 'user_photos'
		));
		if ($do_redirect)
			header("Location: $loginUrl");		
	}

	// return $albums;
}

function wpbeautify_facebook_get_photos_in_album($album_id, $page=0, $results_per_page=WPBEAUTIFY_IMAGES_PER_PAGE) {
	require_once WPBEAUTIFY_DIR.'/lib/social/facebook_sdk/facebook.php';
	$image_settings = wpbeautify_get_image_settings();
	
	$facebook = new Facebook(array(
		'appId'  => $image_settings['social_sites']['facebook']['app_id'],
		'secret' => $image_settings['social_sites']['facebook']['app_secret'],
		'cookie' => true,
	));	

		$access_token = $image_settings['social_sites']['facebook']['token'];

	$albums = array();
	if ($access_token)
		$facebook->setAccessToken($access_token);

	$user = $facebook->getUser();

    if ($page) $page--;

    $start_index = $page*$results_per_page;

	if ($user) {
		try {
			$logoutUrl = $facebook->getLogoutUrl();
			// echo "hola";
			$params = array();
			$params['offset'] = $start_index;
			$params['limit'] =$results_per_page;
			$params['fields'] = 'name,source,images,height,width,link,picture';
			$params = http_build_query($params, null, '&');

			$album_photos = $facebook->api("/{$album_id}/photos?$params"); /**/
			// var_dump($album_photos);
				// echo "b";

			if( isset($album_photos['paging']) ) {
				if( isset($album_photos['paging']['next']) ) {
					$next_url = parse_url($album_photos['paging']['next'], PHP_URL_QUERY) . "&id=" . $album_id;
				}
				if( isset($album_photos['paging']['previous']) ) {
					$pre_url = parse_url($album_photos['paging']['previous'], PHP_URL_QUERY) . "&id=" . $album_id;
				}
			}
			$photos = array();
			if(!empty($album_photos['data'])) {
				foreach($album_photos['data'] as $photo) {
					// var_dump($photo);
					$temp = array();
					$temp['id'] = $photo['id'];
					$temp['width'] = $photo['width'];
					$temp['height'] = $photo['height'];
					$temp['title'] = (isset($photo['name'])) ? $photo['name']:'';
					$temp['fullsize_url'] = $photo['images'][0]['source'];
					$temp['source'] = $photo['source'];
					$temp['thumbnail_url'] = $photo['picture'];
					$temp['original_url'] = $photo['link'];
					$temp['image_source'] = 'facebook';
					$photos[] = $temp;
				}
			}
			return array(5, $photos);
		} catch (FacebookApiException $e) {
			error_log($e);
			$user = null;
		}
	} else {
		header("Location: index.php");
	}	
}

function wpbeautify_facebook_do_auth() {
	require_once WPBEAUTIFY_DIR.'/lib/social/facebook_sdk/facebook.php';

	$image_settings = wpbeautify_get_image_settings();

	if (isset($_POST['facebook_app_id'])) {
		$image_settings['social_sites']['facebook']['app_id'] = $_POST['facebook_app_id'];
		$image_settings['social_sites']['facebook']['app_secret'] = $_POST['facebook_app_secret'];
		wpbeautify_set_image_settings($image_settings);

	}

	$facebook = new Facebook(array(
		'appId'  => $image_settings['social_sites']['facebook']['app_id'],
		'secret' => $image_settings['social_sites']['facebook']['app_secret'],
		'cookie' => true
	));
	

	$user = $facebook->getUser();
	 // var_dump($user);
	if ($user) {
		$access_token = $facebook->getAccessToken();
		$facebook->setExtendedAccessToken($access_token);

// var_dump($access_token);
// die();
		// $image_settings = wpbeautify_get_image_settings();

		$image_settings['social_sites']['facebook']['token'] = $access_token;
		wpbeautify_set_image_settings($image_settings);

	}
	else {
		$loginUrl = $facebook->getLoginUrl(array(
			'scope'			=> 'email,user_photos', /*publish_stream,*/'publish_actions',
			'redirect_uri'	=> admin_url('/admin.php?page=fotopress-images&auth=facebook'),
		));
		wp_redirect($loginUrl);
		exit();
	}
}

function wpbeautify_facebook_deauthorize() {
	require_once WPBEAUTIFY_DIR.'/lib/social/facebook_sdk/facebook.php';

	$image_settings = wpbeautify_get_image_settings();

	$image_settings['social_sites']['instagram']['app_id'] = $_POST['facebook_app_id'];
	$image_settings['social_sites']['instagram']['app_secret'] = $_POST['facebook_app_secret'];

	wpbeautify_set_image_settings($image_settings);

	$facebook = new Facebook(array(
		'appId'  => $image_settings['social_sites']['facebook']['app_id'],
		'secret' => $image_settings['social_sites']['facebook']['app_secret'],
		'cookie' => true,
	));

	$user_id = $facebook->getUser();
    $access_token=$facebook->getAccessToken();
    $result = $facebook->api(array(
            'method' => 'auth.revokeAuthorization',
            'uid' =>$user_id,
            'access_token'=>$access_token
    ));	
}

function wpbeautify_update_fb_token() {

}


add_action('init', 'wp_beautify_facebook_auth');
function wp_beautify_facebook_auth() {
	if (isset($_POST['wpbeautify_fb_authorize']) && ($_POST['wpbeautify_fb_authorize'] == '1')) {
	// die();

		wpbeautify_facebook_do_auth();
	}
	else if (isset($_POST['wpbeautify_fb_authorize']) && ($_POST['wpbeautify_fb_authorize'] == '2')) {
		wpbeautify_facebook_deauthorize();
	}
	else if (isset($_POST['wpbeautify_flickr_authorize']) && ($_POST['wpbeautify_flickr_authorize'] == '1')) {
		wpbeautify_flickr_authorize();
	}
	else if (isset($_POST['wpbeautify_instagram_authorize']) && ($_POST['wpbeautify_instagram_authorize'] == '1')) {
		$albums = wpbeautify_instagram_get_auth();
	}
}

function wpbeautify_facebook_browse_albums() {
    $albums = wpbeautify_fb_get_albums();
    wpbeautify_print_photo_album($albums, 'facebook', 0, 36);
    exit(0);
}


function wpbeautify_facebook_browse_album_pics() {
	$page = isset($_POST['page']) ? $_POST['page'] : 0;
	$album_photos = wpbeautify_facebook_get_photos_in_album($_POST['album_id'], $page, WPBEAUTIFY_IMAGES_PER_PAGE);
	wpbeautify_print_social_images($album_photos, $page, WPBEAUTIFY_IMAGES_PER_PAGE);
	exit(0);

	/*
	$album_photos = wpbeautify_fb_get_album_photos($_POST['album_id']);
	 // var_dump($album_photos);
	$page = 0;
	$results_per_page = 36;
	wpbeautify_print_social_images($album_photos, $page, $results_per_page);
	exit(0);*/

}

function wpbeautify_share_img_facebook($type, $text, $link, $image_url) {
	require_once WPBEAUTIFY_DIR.'/lib/social/facebook_sdk/facebook.php';
	$image_settings = wpbeautify_get_image_settings();
	
	$facebook = new Facebook(array(
		'appId'  => $image_settings['social_sites']['facebook']['app_id'],
		'secret' => $image_settings['social_sites']['facebook']['app_secret'],
		'cookie' => true,
		'fileUpload' => true
	));	
	$user = $facebook->getUser();
			// var_dump($user);

	if ($user) {
		try {
			if ($type == 1) {
				// upload to timeline as link
				$status = $facebook->api('/me/feed', 'POST', array(
					'message' => $text,
					'source' => $image_url,
					'link' => $link
					)
				);
			}
			else if ($type == 2) {
				// upload as image
				// $filetype = wp_check_filetype( basename( $image_url ), null );
				$ret_obj = $facebook->api('/me/photos', 'POST', array(
                     'url' => $image_url,
                     'message' => $text
                     )
                  );
			}
		} catch (FacebookApiException $e) {
			// error_log($e);
			// var_dump($e);
			$user = null;
		}
	}

	return;

}
?>