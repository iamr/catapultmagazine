<?php
define( 'WPBEAUTIFY_OOKABOO_URL', 'http://api.ookaboo.com/api1/lookup_picture' );
define( 'WPBEAUTIFY_OOKABOO_WIKIPEDIA_URL', 'http://en.wikipedia.org/wiki/' );
define( 'WPBEAUTIFY_OOKABOO_DBPEDIA_URL', 'http://dbpedia.org/page/' );

function wpbeautify_ookaboo_imagesearch($search_term, $license, $page=1, $results_per_page=12, $offset=0, $attribution_required=0, $imgtype=0) {
	return 0;
    global $wpbeautify_sites_internal;

	$search_term = str_replace(' ', '_', ucwords($search_term));

// http://en.wikipedia.org/wiki/Pokhara)
// http://dbpedia.org/page/Tunis

	$req_args = array(
		'api_key' => $wpbeautify_sites_internal['ookaboo']['details']['apikey'],
		'query_uri' => WPBEAUTIFY_OOKABOO_WIKIPEDIA_URL.$search_term
	);

/*$db_results = 0;
$wiki_results = 0;*/

	//if (isset ($wpbeautify_sites_internal['ookaboo']['details']['usewikipedia']) && $wpbeautify_sites_internal['ookaboo']['details']['usewikipedia']) {
		//$req_args['query_uri'] = WPBEAUTIFY_OOKABOO_WIKIPEDIA_URL.$search_term;
		$response = wp_remote_get( add_query_arg($req_args, WPBEAUTIFY_OOKABOO_URL) );
	//var_dump($response);
		if( is_wp_error( $response ) ) {
		   return 0;
		} else {
			return wpbeautify_ookaboo_togeneric (json_decode($response['body']), $attribution_required);
		}
	//}
	
	/*if (isset ($wpbeautify_sites_internal['ookaboo']['details']['usedbpedia']) && $wpbeautify_sites_internal['ookaboo']['details']['usedbpedia']) {
		$req_args['query_uri'] = WPBEAUTIFY_OOKABOO_DBPEDIA_URL.$search_term;
		$response = wp_remote_get( add_query_arg($req_args, WPBEAUTIFY_OOKABOO_URL) );
		if( is_wp_error( $response ) ) {
		   echo 'Something went wrong!';
		} else {
			$db_results = wpbeautify_ookaboo_togeneric (json_decode($response['body']));
		}
	}*/
//	return wpbeautify_join_arrays(array($wiki_results, $db_results),  $page, $results_per_page, $offset);

}

function tsfpix_ookaboo_get_images ($images) {
	foreach ($images as $image) {
		if ($image->size_code == 'l')
			$large_image = $image;
		else if ($image->size_code == 't')
			$thumbnail = $image;			
	}	

	return array ($thumbnail->img_uri, array($large_image->img_uri, $large_image->width, $large_image->height));
}
// Todo: hacer dos llamadas, la paginación la tengo que hacer you a manubrio

function wpbeautify_ookaboo_togeneric ($images, $attribution_required=0) {
    global $wpbeautify_sites_internal;

//var_dump($images->result->pictures); exit(0);
//var_dump($images->result->pictures); exit(0);	
	if (!isset($images->result->pictures)) return 0;
	$return_object = new stdClass();

	$return_object->total_images = count($images->result->pictures);
	$return_object->images = array();

	//if (!is_array($images->channel)) return 0;
	foreach ($images->result->pictures as $hit) {
		$image = new stdClass();
	  // var_dump($hit);
	  // exit(0);

	  	$ookaboo_images = tsfpix_ookaboo_get_images ($hit->images);

		$image->thumbnail_url = $ookaboo_images[0];
		$image->fullsize_url = $ookaboo_images[1][0];

		$image->width = $ookaboo_images[1][1];
		$image->height = $ookaboo_images[1][2];

		if ((isset($hit->sources) && !empty($hit->sources)))
			$image->author_name =  $hit->sources[0]->title;
		else $image->author_name = '';
		$image->author_url = $hit->ookaboo_uri;
		$image->license_type = tsfpix_ookaboo_license_to_int($hit->license); // TODO: Extraer de $hit->license (cc-by/2.0)
//        var_dump($image->license_type);
        if (empty($hit->license) || ($image->license_type == -1)) break;
        if (isset($wpbeautify_sites_internal['ookaboo']['details']['onlynoattribution']) && $wpbeautify_sites_internal['ookaboo']['details']['onlynoattribution'] == 1)
        	if ($image->license_type != 9)
        		continue;

        if ($image->license_type == 9) { // no attribution required
        	if ($attribution_required == 2) // only with attribution
        		continue;
        	$image->attribution = false;
        }
        else {
        	if ($attribution_required == 1) // only with no attribution
        		continue;
        	$image->attribution = true;
        }


        $image->title = '';
 //       echo  $image->license_type.' '.$hit->license .' '. $wpbeautify_sites_internal['ookaboo']['details']['onlynoattribution'].'<br/>';
		$return_object->images[] = $image;
	}
	$return_object->images_in_group = count($return_object->images);
//var_dump($return_object);
	return $return_object;
}

function tsfpix_ookaboo_license_to_int($license_string) {
	if ($license_string == 'pd')
		return 9;
	else if (strpos($license_string, 'cc-by/') !== false)
		return 4;
	else if (strpos($license_string, 'cc-by-sa/') !== false)
		return 5;
	return -1;
}

?> 