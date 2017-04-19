<?php
define( 'WPBEAUTIFY_EUROPEANA_URL', 'http://europeana.eu/api/v2/search.json' );

function wpbeautify_europeana_imagesearch( $search_term, $license='', $page=1, $results_per_page=36, $offset=0, $attribution_required=0, $imgtype=0, $only_modifiables = 0 ) {
	// no images with attribution required here, so return
	return 0;
	if ( $attribution_required == 2 ) return 0;
	$is_hires = 0;

	$image_settings = wpbeautify_get_image_settings();
	$wpbeautify_sites = $image_settings['image_sites'];

	// global $wpbeautify_sites;
	// $europeana_username = $wpbeautify_sites['europeana']['details']['username'];
	// $europeana_key = $wpbeautify_sites['europeana']['details']['api_key'];
	$search_term = str_replace( ' ', '+', $search_term );

	if ( $offset ) {
		if ( $page > 1 ) $page--;
	}
	$start = $page * $results_per_page;

	if ( $imgtype == 2 )
	 	$image_type = 'TYPE:IMAGE';
	else if ( $imgtype == 1 )
	 	$image_type = 'TYPE:CLIPART';
	// else
	// 	$image_type = 'all';

		$req_args = array(
			// 'username' => $europeana_username,
			// 'query' => $europeana_key,
			'query' => $search_term,
			'qf' => $image_type,
			'rows' => $results_per_page,
			'start' => $start,
			'wskey' => 'sMvHfPr2m',
			'profile' => 'standard+portal+minimal'
		);

	if ( !$offset ) {
		$response = wp_remote_get( add_query_arg( $req_args, WPBEAUTIFY_EUROPEANA_URL ) );
		// var_dump($response);
		if ( is_wp_error( $response ) ) {
			return 0;
		} else {
			return wpbeautify_europeana_togeneric ( json_decode( $response['body'] ), $is_hires, $offset, $results_per_page );
		}
	}
	else {
		$response = wp_remote_get( add_query_arg( $req_args, WPBEAUTIFY_EUROPEANA_URL ) );
		if ( is_wp_error( $response ) ) {
			return 0;
		} else {
			$arr1 = wpbeautify_europeana_togeneric ( json_decode( $response['body'] ), $is_hires, $offset, $results_per_page );
			$req_args['page']++;
			$response = wp_remote_get( add_query_arg( $req_args, WPBEAUTIFY_EUROPEANA_URL ) );
			if ( is_wp_error( $response ) ) {
				return 0;
			} else {
				$arr2 = wpbeautify_europeana_togeneric ( json_decode( $response['body'] ), $is_hires, $offset, $results_per_page );
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

function wpbeautify_europeana_togeneric( $images, $is_hires=0, $offset=0, $results_per_page=0 ) {
	$return_object = new stdClass();
	 // var_dump($images);
	 // exit(0);
	if ( !$images ) return 0;
	$return_object->total_images = $images->totalResults;
	$return_object->images = array();

	if ( !is_array( $images->items ) ) return 0;
	foreach ( $images->items as $hit ) {
		 // var_dump($hit); exit(0);
		$image = new stdClass();
		// var_dump($hit);
		// exit(0);
		$image->thumbnail_url = $hit->edmPreview[0];
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

		// if ( isset( $image->tags ) )
		// 	$image->title = isset( $hit->tags ) ? $hit->tags : 'Europeana Image '.$hit->id;
		// else
		// 	$image->title = 'Europeana Image '.$hit->id;
		$image->title = $hit->title[0];
        $image->original_url = $hit->edmIsShownAt;

		$return_object->images[] = $image;
	}

	$return_object->images_in_group = count( $return_object->images );

	return $return_object;
}

function tsfpix_europeana_testapikey( $username, $apikey ) {
	$req_args = array(
		'username' => $username,
		'key' => $apikey,
		'search_term' => 'test',
		'image_type' => 'photo',
		'per_page' => 10,
		'page' => 1
	);

	$response = wp_remote_get( add_query_arg( $req_args, WPBEAUTIFY_EUROPEANA_URL ) );
	if ( is_wp_error( $response ) ) {
		return 0;
	} else {
		$results = json_decode( $response['body'] );
		if ($results)
			return 1;
		return 0;
	}
}

?>
