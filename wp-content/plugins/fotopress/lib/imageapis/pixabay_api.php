<?php
define( 'WPBEAUTIFY_PIXABAY_URL', 'https://pixabay.com/api/' );


function wpbeautify_pixabay_imagesearch( $search_term, $license='', $page=1, $results_per_page=36, $offset=0, $attribution_required=0, $imgtype=0, $only_modifiables = 0 ) {
	// no images with attribution required here, so return
	if ( $attribution_required == 2 ) return 0;
	$is_hires = 0;

	$image_settings = wpbeautify_get_image_settings();
	$wpbeautify_sites = $image_settings['image_sites'];

	// global $wpbeautify_sites;
	//$pixabay_username = WPBEAUTIFY_PIXABAY_USER/*$wpbeautify_sites['pixabay']['details']['username']*/;
	// var_dump($wpbeautify_sites['pixabay']['details']);
	// die();
	if ( isset($wpbeautify_sites['pixabay']['details']['hires']) && ( $wpbeautify_sites['pixabay']['details']['hires'] == '1' || $wpbeautify_sites['pixabay']['details']['hires'] == 1 ) ) {
			$is_hires = 1;
			$pixabay_key = WPBEAUTIFY_PIXABAY_APIKEY;
	}

	else if( isset( $wpbeautify_sites['pixabay']['details']['ownkey'] ) && $wpbeautify_sites['pixabay']['details']['ownkey'] && isset( $wpbeautify_sites['pixabay']['details']['api_key'] ) && $wpbeautify_sites['pixabay']['details']['api_key']) {
		$pixabay_key = $wpbeautify_sites['pixabay']['details']['api_key'];
		if ( isset($wpbeautify_sites['pixabay']['details']['hires']) && ( $wpbeautify_sites['pixabay']['details']['hires'] == '1' || $wpbeautify_sites['pixabay']['details']['hires'] == 1 ) )
			$is_hires = 1;
	}
	else {
		$pixabay_key = WPBEAUTIFY_PIXABAY_APIKEY/*$wpbeautify_sites['pixabay']['details']['api_key']*/;
		$is_hires = 0;
	}
	$search_term = str_replace( ' ', '+', $search_term );

	if ( $offset ) {
		if ( $page > 1 ) $page--;
	}

	if ( $imgtype == 2 )
		$image_type = 'photo';
	else if ( $imgtype == 1 )
		$image_type = 'clipart';
	else
		$image_type = 'all';

		$req_args = array(
			/*'username' => $pixabay_username,*/
			'key' => $pixabay_key,
			'search_term' => $search_term,
			'image_type' => $image_type,
			'per_page' => $results_per_page,
			'page' => $page
		);



	if ( $is_hires )
		$req_args = array_merge( $req_args, array( 'response_group' => 'high_resolution' ) );

// var_dump($wpbeautify_sites['pixabay']['details']);die();
	if ( !$offset ) {
		$response = wp_remote_get( add_query_arg( $req_args, WPBEAUTIFY_PIXABAY_URL ) );
		if ($is_hires) {
			$error_code = wpbeautify_pixabay_check_hires($response);
			if ($error_code) {
				echo $error_code;
				return;
			}
		}
		if ( is_wp_error( $response ) ) {
			return 0;
		} else {
			return wpbeautify_pixabay_togeneric ( json_decode( $response['body'] ), $is_hires, $offset, $results_per_page );
		}
	}
	else {
		$response = wp_remote_get( add_query_arg( $req_args, WPBEAUTIFY_PIXABAY_URL ) );
		if ($is_hires) {
			$error_code = wpbeautify_pixabay_check_hires($response);
			if ($error_code) {
				echo $error_code;
				return;
			}
		}
		if ( is_wp_error( $response ) ) {
			return 0;
		} else {
			$arr1 = wpbeautify_pixabay_togeneric ( json_decode( $response['body'] ), $is_hires, $offset, $results_per_page );
			$req_args['page']++;
			$response = wp_remote_get( add_query_arg( $req_args, WPBEAUTIFY_PIXABAY_URL ) );
			if ( is_wp_error( $response ) ) {
				return 0;
			} else {
				$arr2 = wpbeautify_pixabay_togeneric ( json_decode( $response['body'] ), $is_hires, $offset, $results_per_page );
				$return_object = new stdClass();
				$return_object->total_images = $arr1->total_images; // + $arr2->total_images;
				$max_page = ( floor( $arr1->total_images / $results_per_page )+1 );
				if ( $req_args['page'] < $max_page )
					$return_object->images = array_merge( $arr1->images, $arr2->images );
				else
					$return_object->images = $arr1->images;

				$return_object->images = array_slice( $return_object->images, $offset, $results_per_page );
				$return_object->images_in_group = count( $return_object->images );
				return $return_object;
			}
		}

	}
}

/*
	Object definition

total_images = num
images {
	thumbnail_url = url
	fullsize_url = url
	width = number
	height = number
	attribution = true/false
	author_name = name
	authour_url = url
}
*/

function wpbeautify_pixabay_togeneric( $images, $is_hires=0, $offset=0, $results_per_page=0 ) {
	$return_object = new stdClass();
	// var_dump($images);
	// exit(0);
	if ( !$images ) return 0;
	$return_object->total_images = $images->totalHits;
	$return_object->images = array();

	if ( !is_array( $images->hits ) ) return 0;
	foreach ( $images->hits as $hit ) {
		// var_dump($hit); exit(0);
		$image = new stdClass();
		// var_dump($hit);
		// exit(0);
		$image->thumbnail_url = $hit->previewURL;
		if ( $is_hires ) {
			$image->fullsize_url = $hit->imageURL;
			$image->width = $hit->imageWidth;
			$image->height = $hit->imageHeight;
		}
		else {
			$image->fullsize_url = $hit->webformatURL;
			$image->width = $hit->webformatWidth;
			$image->height = $hit->webformatHeight;
		}
		$image->attribution = false;
		$image->author_name = null;
		$image->author_url = null;
        $image->modifiable = true;
		$image->license_type = 9;

		if ( isset( $image->tags ) )
			$image->title = isset( $hit->tags ) ? $hit->tags : 'Pixabay Image '.$hit->id;
		else
			$image->title = 'Pixabay Image '.$hit->id;
        $image->original_url = $hit->pageURL;

		$return_object->images[] = $image;
	}

	$return_object->images_in_group = count( $return_object->images );

	return $return_object;
}

function tsfpix_pixabay_testapikey( $username, $apikey ) {
	$req_args = array(
		'username' => $username,
		'key' => $apikey,
		'search_term' => 'test',
		'image_type' => 'photo',
		'per_page' => 10,
		'page' => 1
	);

	$response = wp_remote_get( add_query_arg( $req_args, WPBEAUTIFY_PIXABAY_URL ) );
	if ( is_wp_error( $response ) ) {
		return 0;
	} else {
		$results = json_decode( $response['body'] );
		if ($results)
			return 1;
		return 0;
	}
}

function  wpbeautify_pixabay_check_hires($response) {
	if (isset($response['response']['code']) && $response['response']['code'] == 403)
		return $response['body'];
	return 0;
}
?>
