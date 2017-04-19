<?php
define( 'WPBEAUTIFY_OPENCLIPART_URL', 'http://openclipart.org/api/search/' );

function wpbeautify_openclipart_imagesearch($search_term, $license, $page=1, $results_per_page=36, $offset=0, $attribution_required=0, $imgtype=0, $only_modifiables = 0) {
	// no images with attribution required here, so return
	if ($attribution_required == 2) return 0;
	if ($imgtype == 2) return 0;

	$search_term = str_replace(' ', '+', $search_term);

	$start_page = floor(($results_per_page * $page) / 20);
	$start_page = 1;


	$req_args = array(
		'query' => $search_term,
		//'per_page' => 20,
		'page' => $start_page
	);

	// simular paginación a base de varias llamadas
	$flag_break = 0;
	$temp_results = array();

	while (!$flag_break) {
		try {
			$response = @simplexml_load_file(add_query_arg($req_args, WPBEAUTIFY_OPENCLIPART_URL));
			// var_dump(add_query_arg($req_args, WPBEAUTIFY_OPENCLIPART_URL));
			// var_dump($response);
		} catch (Exception $e) { }

		if( is_wp_error( $response ) ) {
		   return 0;
		} else {
			$new_result = wpbeautify_openclipart_togeneric ($response);
			$temp_results[] = $new_result;
		}

		$req_args['page']++;
		if (!$new_result || $new_result->total_images == 0)
			$flag_break = 1;

	}
	if ($offset) $page--;
	$objeto =  wpbeautify_join_arrays($temp_results, $page, $results_per_page, $offset);
	return $objeto;
}



function wpbeautify_openclipart_togeneric ($images, $offset=0) {
	if (!$images) return 0;

	$return_object = new stdClass();
	$return_object->total_images = count($images->channel->item);
	$return_object->images = array();

	$i=0;
	foreach ($images->channel->item as $hit) {
		if ($i++ < $offset) continue;
		$image = new stdClass();
		$attrs = $hit->enclosure->attributes();
		$filename = tsfpix_replace_extension(basename($attrs['url']), 'png');

		$image->thumbnail_url = 'http://openclipart.org/image/110px/svg_to_png/'.$filename;
		$image->fullsize_url = 'http://openclipart.org/image/800px/svg_to_png/'.$filename;
		$image->width = 800;
		$image->height = 800;
		$image->attribution = false;
		$image->author_name = null;
		$image->author_url = null;
		$image->license_type = 9;
        $image->title = wp_kses($hit->title, array());
        $image->original_url = $hit->link;
        $image->modifiable = true;


		$return_object->images[] = $image;
	}
	$return_object->images_in_group = count($return_object->images);
	return $return_object;
}

function tsfpix_replace_extension($filename, $new_extension) {
    $info = pathinfo($filename);
    return $info['filename'] . '.' . $new_extension;
}

?> 