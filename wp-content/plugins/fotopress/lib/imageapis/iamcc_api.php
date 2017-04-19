<?php
define( 'WPBEAUTIFY_IAMCC_URL', 'http://i-am-cc.org/api/instagram_photo/' );

//http://i-am-cc.org/api/instagram_photo/?caption__contains=raul&tags__contains=lagarrotxa&format=json
//http://i-am-cc.org/about-api/


function wpbeautify_iamcc_imagesearch($search_term, $license, $page=1, $results_per_page=36, $offset=0, $attribution_required=0, $imgtype=0, $only_modifiables = 0) {
	if ($imgtype == 1) return 0; // only cliparts

	$search_term = str_replace(' ', '+', $search_term);

	if ($offset) {
		if ($page > 1) $page--;
	}

	$req_args = array(
		'format' => 'json',
		'caption__contains' => $search_term,
		'limit' => $results_per_page,
		'offset' => $results_per_page*($page-1) + $offset
	);


	if ($attribution_required == 1) $req_args['license_info__license'] = 'CC0';
		$response = wp_remote_get( add_query_arg($req_args, WPBEAUTIFY_IAMCC_URL) );
	if( is_wp_error( $response ) )
	   return 0;
	else
		return wpbeautify_iamcc_togeneric (json_decode($response['body']), $offset, $results_per_page, $attribution_required, $only_modifiables);
}

function wpbeautify_get_headers_curl($url)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,            $url);
    curl_setopt($ch, CURLOPT_HEADER,         true);
    curl_setopt($ch, CURLOPT_NOBODY,         true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT,        10);

    $r = @curl_exec($ch);
    return curl_getinfo($ch, CURLINFO_HTTP_CODE);

}

function wpbeautify_url_exists($url){
     if ((strpos($url,  "http")) === false) $url =  "http:// " . $url;
     $res = @wpbeautify_get_headers_curl($url);
     if ($res == 200) return true;
     return false;
}


function wpbeautify_iamcc_togeneric ($images, $offset=0, $results_per_page=0, $attribution_required=0, $only_modifiables=0) {
	if (!$images) return 0;

	$return_object = new stdClass();
	$return_object->total_images = $images->meta->total_count;
	$return_object->images = array();

	if (!is_array($images->objects)) return 0;
	foreach ($images->objects as $hit) {
//		if (!wpbeautify_url_exists($hit->image_standard_resolution)) continue;
// var_dump($hit);
		$link = $hit->link;
		// $parts = strrpos( $link, '/', -2 );
		$parts = explode( '/', $link );
		$ig_id = $parts[count($parts)-2];
		// var_dump($ig_id);
		$args = array( 'timeout' => 10 );
		$instagram_photo = wp_remote_get( 'https://api.instagram.com/oembed?url=http://instagram.com/p/'.$ig_id.'/', $args );
		$ig_data = json_decode($instagram_photo['body']);
		// var_dump($ig_data);
		$full_url = $ig_data->thumbnail_url;
		$full_url = substr( $full_url, 0, strpos( $full_url, '.jpg') + 4 );
		// die();
		// var_dump($full_url);
		// die();
		$image = new stdClass();
		$image->thumbnail_url = /*$hit->image_thumbnail*/$full_url;
		$image->fullsize_url = /*$hit->image_standard_resolution*/$full_url;
		$image->width = /*654*/$ig_data->thumbnail_width;
		$image->height = $ig_data->thumbnail_height;

		$image->license_type = wpbeautify_get_license_id_from_short( $hit->license_info->license );
		if ($image->license_type > 6) {
        	if ($attribution_required == 2) // only with attribution
        		continue;
			$image->attribution = false;
		}
		else {
			$image->attribution = true;
		}
		if ($only_modifiables) {
			if (($image->license_type == 3) || ($image->license_type == 6))
				continue;
		}
		$image->modifiable = true;

		if (($image->license_type == 3) || ($image->license_type == 6))
			$image->modifiable = false;

		if (isset($hit->license_info->full_name) && !empty($hit->license_info->full_name))
			$image->author_name = $hit->license_info->full_name;
		else
			$image->author_name = $hit->license_info->instagram_username;

		$image->author_url = $hit->link;

        $image->title = $hit->caption;
        $image->original_url = /*$hit->link*/'http://i-am-cc.org/instagram/'.$hit->license_info->instagram_username.'/'.$hit->id;

		$return_object->images[] = $image;
	}
	$return_object->images_in_group = count($return_object->images);

	return $return_object;
}

?>