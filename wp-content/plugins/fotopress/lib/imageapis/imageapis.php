<?php

add_action( 'wp_ajax_wpbeautify_search_free_image', 'wpbeautify_search_free_image' );
add_action( 'wp_ajax_wpbeautify_insert_image', 'wpbeautify_insert_image' );
add_action( 'wp_ajax_wpbeautify_download_image', 'wpbeautify_download_image' );


function wpbeautify_search_free_image() {
	@ini_set( 'max_execution_time', '480' );

	$keyword = $_POST['keyword'];
	$page = isset( $_POST['page'] ) ? $_POST['page'] : 1;
	$results_per_page=36;

	// include_once WPBEAUTIFY_DIR.'/lib/imageapis.php';

	// extra options
	$attribution = ( $_POST['attribution'] == 'true' ) ? 1 : 0;
	$noattribution = ( $_POST['noattribution'] == 'true' ) ? 1 : 0;
	$modifiables = ( $_POST['only_modifiables'] == 'true' ) ? 1 : 0;

	$photo = ( $_POST['photo'] == 'true' ) ? 1 : 0;
	$clipart = ( $_POST['clipart'] == 'true' ) ? 1 : 0;

	$is_small = ( isset($_POST['is_small']) && $_POST['is_small'] == 'true' ) ? 1 : 0;


	if ( !$photo && !$clipart ) {
		echo '<p class="wpbeautify_padded">You must select at least one image type (photo/clipart)</p>';
		exit( 0 );
	}
	if ( !$attribution && !$noattribution ) {
		echo '<p class="wpbeautify_padded">You must select at least one attribution type (with/without attribution)</p>';
		exit( 0 );
	}

	$extra_args = array();

	if ( !$attribution || !$noattribution ) {
		if ( $attribution )
			$extra_args['attribution'] = true;
		else if ( $noattribution )
			$extra_args['noattribution'] = true;
	}

	if ($modifiables)
		$extra_args['modifiables'] = true;
	else
		$extra_args['modifiables'] = false;

	if ( !$photo || !$clipart ) {
		if ( $photo )
			$extra_args['photo'] = true;
		else if ( $clipart )
			$extra_args['clipart'] = true;
	}

	if ( isset( $_POST['sites'] ) )
		$extra_args['sites'] = $_POST['sites'];


	$all_res = wpbeautify_image_search( $keyword, 0, $results_per_page, $page, $extra_args );

	if ( !$all_res ) {
		exit( 0 );
	}
	$total_images = $all_res->total_results;
	$str_ret = wpbeautify_paint_pagination( $page, $total_images, $results_per_page, $is_small );
	$str_ret .=  '<div class = "wpbeautify_attachments_container" style="" class="wpbeautify-attachments">';
	$str_ret .=  '<ul class="attachments-view-wpbeautify" style="margin-top:0px;">';

	echo $str_ret;

	// go through all results
	$current_n_results = 0;
	foreach ( $all_res->image_groups as $res ) {

		if ( !is_array( $res->images ) ) {
			echo 'No results';
			exit( 0 );
		}

		//var_dump($res);
		$counter = 1;
		foreach ( $res->images as $image ) {
?>
			<li class="wpbeautify-attachment">
				<div class="wpbeautify-attachment-preview">
						<div class="wpbeautify-thumbnail">
							<div class="centered">
								<img class="wpbeautify_thumb wpbeautify_thumb_<?php echo $res->image_source;?>" src="<?php echo $image->thumbnail_url;?>"
									data-width="<?php echo $image->width;?>"
									data-height="<?php echo $image->height;?>"
									data-url="<?php echo $image->fullsize_url;?>"
									data-author_name="<?php echo $image->author_name;?>"
									data-author_url="<?php echo $image->author_url;?>"
									data-attribution="<?php echo $image->attribution ? 1 : 0; ?>"
									data-modifiable="<?php echo $image->modifiable ? 1 : 0; ?>"
									data-license="<?php echo $image->license_type;?>"
									data-origin="<?php echo $res->image_source;?>"
									data-original-url="<?php echo $image->original_url;?>"
									title="<?php echo $image->title;?>"
									/>
							</div>
						</div>
						<a title="Deselect" href="#" class="check"><div class="media-modal-icon"></div></a>
				</div>
			</li>

	<?php
			if ( ++$current_n_results >= $results_per_page ) break 2;
		}
	}



	echo '</ul><div style="clear:both;"></div></div>';

	exit( 0 );
}

function wpbeautify_paint_pagination( $current_page, $total_results, $results_per_page, $is_small = false, $extra_class = '' ) {
	$total_pages = ceil( $total_results / $results_per_page );
	$str_ret = '';
	if (!$total_pages || $total_pages == 1) return '';

	// $str_ret .= '<div class="tablenav" style=""><div class="tablenav-pages" style="float:left"> <b>Total :</b> '.$total_results.' results &nbsp;&nbsp;&nbsp;&nbsp;';
	$str_ret .= '<div class="row '.$extra_class.'" style="" id="wpbeautify_free_img_pagination"><div class="col-md-6"> <b>Total :</b> '.$total_results.' results ';
	if (!$is_small)
		$str_ret .= '&nbsp;&nbsp;&nbsp;&nbsp;';

	if ( $total_pages )
		$str_ret .= '<span class="displaying-num">Showing page '.($current_page ? $current_page : 1).' of  '.$total_pages.'</span></div>';


    $page_links = paginate_links( array(
            'base' =>  '#',
            'format' => '',
            'end_size' => 2,
            'mid_size' => 3,
            'prev_text' => __( '&laquo;', 'aag' ),
            'next_text' => __( '&raquo;', 'aag' ),
            'total' => $total_pages,
            'current' => ($current_page ? $current_page : 1),
            'type' => 'array'
        ) );

/*	if ( $current_page > 1 )
		$str_ret .= '<a id="wpbeautify_prev" href="#" class="prev page-numbers">&laquo; Prev</a>&nbsp;&nbsp;&nbsp;';

	if ( $current_page < $total_pages )
		$str_ret .= '&nbsp;&nbsp;&nbsp;<a id="wpbeautify_next" href="#" class="next page-numbers">Next &raquo;</a> ';*/

	if ($is_small) {
		$str_ret .= '<div class="col-md-6"><a href="#" class="small-navi-prev">< Prev</a> &nbsp;&nbsp;&nbsp;<a href="#" class="small-navi-next">Next ></a></div>';
	}
	else
		$str_ret .= '<div class="col-md-6">'. wpbeautify_listify_pagination($page_links, 'pull-right') . '</div>';
	$str_ret .= '</div></div>';
	return $str_ret;
}


function wpbeautify_get_licenses() {
	$licenses = array();
	$licenses[0] = array( 'id' => 0, 'short' => '', 'name' => 'All Rights Reserved', 'url' => '' );
	$licenses[1] = array( 'id' => 1, 'short' => 'CC BY-NC-SA', 'name' => 'Attribution-NonCommercial-ShareAlike License', 'url' => 'http://creativecommons.org/licenses/by-nc-sa/2.0/' );
	$licenses[2] = array( 'id' => 2, 'short' => 'CC BY-NC', 'name' => 'Attribution-NonCommercial License', 'url' => 'http://creativecommons.org/licenses/by-nc/2.0/' );
	$licenses[3] = array( 'id' => 3, 'short' => 'CC BY-NC-ND', 'name' => 'Attribution-NonCommercial-NoDerivs License', 'url' => 'http://creativecommons.org/licenses/by-nc-nd/2.0/' );
	$licenses[4] = array( 'id' => 4, 'short' => 'CC BY', 'name' => 'Attribution License', 'url' => 'http://creativecommons.org/licenses/by/2.0/' );
	$licenses[5] = array( 'id' => 5, 'short' => 'CC BY-SA', 'name' => 'Attribution-ShareAlike License', 'url' => 'http://creativecommons.org/licenses/by-sa/2.0/' );
	$licenses[6] = array( 'id' => 6, 'short' => 'CC BY-ND', 'name' => 'Attribution-NoDerivs License', 'url' => 'http://creativecommons.org/licenses/by-nd/2.0/' );
	$licenses[7] = array( 'id' => 7, 'short' => '', 'name' => 'No known copyright restrictions', 'url' => 'http://www.23hq.com/commons/usage/' );
	$licenses[8] = array( 'id' => 8, 'short' => '', 'name' => 'United States Government Work', 'url' => 'http://www.usa.gov/copyright.shtml' );
	$licenses[9] = array( 'id' => 9, 'short' => 'CC0', 'name' => 'Public Domain Dedication', 'url' => 'http://creativecommons.org/publicdomain/zero/1.0/deed.en' );

	return $licenses;
}

function wpbeautify_get_license_id_from_short( $short ) {
	foreach ( $licenses = wpbeautify_get_licenses() as $license ) {
		if ( str_replace( ' ', '-', wpbeautify_tolower( $license['short'] ) ) == str_replace( ' ', '-', wpbeautify_tolower( $short ) ) )
			return $license['id'];
	}
}

global $wpbeautify_sites_internal;
$wpbeautify_sites_internal = get_site_option( 'wpbeautify_image_sites', 0 );

function wpbeautify_tolower( $string ) {
	if ( function_exists( 'mb_strtolower' ) )
		return mb_strtolower( $string );
	else
		return strtolower( $string );
}

function wpbeautify_image_search( $search_term, $license='', $results_per_page=36, $page=1, $options=array() ) {

	@ini_set( 'max_execution_time', '480' );
	$apis_used = get_site_option( 'wpbeautify_sites_in_order', 0 );
	$search_term = wpbeautify_tolower( $search_term );

	if ( isset( $options['sites'] ) ) {
		$apis_used = $options['sites'];
		if ( $apis_used == '0' ) {
			echo '<p class="wpbeautify_padded">You must select at least one site to search</p>';
			return 0;
		}
	}

	if ( !is_array( $apis_used ) ) return 0;
	$total_images  = new stdClass();
	$total_images->total_results = 0;
	$total_images->image_groups = array();

	$current_images = 0;
	$is_first_look = 1;
	$is_first_checked = 1;

	$page_needed = $page; // TODO: revisar
	$remaining_needed = $results_per_page;
	$image_offset = 0;
	$original_page = $page;
	$total_shown = 0;

	if ( isset( $options['attribution'] ) )
		$attribution = 2;
	else if ( isset( $options['noattribution'] ) )
		$attribution = 1;
	else
		$attribution = 0;

	if ( isset( $options['modifiables'] ) &&  ( $options['modifiables'] == 1 ) )
		$modifiables = 1;
	else
		$modifiables = 0;

	if ( isset( $options['photo'] ) )
		$imgtype = 2;
	else if ( isset( $options['clipart'] ) )
			$imgtype = 1;
	else
		$imgtype = 0;

			foreach ( $apis_used as $current_api ) {
				$include_file = WPBEAUTIFY_DIR.'/lib/imageapis/'.$current_api.'_api.php';
				if (!is_file ($include_file)) continue;
				include_once $include_file;
				$function_to_call = 'wpbeautify_'.$current_api.'_imagesearch';
				//$images = wpbeautify_pixabay_imagesearch($search_term, $license, 1, $results_per_page);
				$images = $function_to_call( $search_term, $license, 1, $results_per_page, 0, $attribution, $imgtype, $modifiables );

				if ( !$images ) continue;

				$total_images->total_results += $images->total_images;
				if ( $remaining_needed < 1 ) {
					// I've got all the images I need, return
					$images->image_source = $current_api;
					$total_images->image_groups[] = $images;
					$is_first_look = 0;
					$is_first_checked = 0;
					continue;
				}

				if ( $page == 1 ) {
					// I am being asked for the first page, so I can show all my results here
					$images->image_source = $current_api;
					$total_images->image_groups[] = $images;
					$current_images += $images->images_in_group;
					$remaining_needed = $results_per_page-$current_images;
					$is_first_look = 0;
					$is_first_checked = 0;
					continue;
				}
				else {
					// We are not asked for the first page, so it gets a bit more complex
					if ( $is_first_look ) {
						// This is the first site I query for this time
						if ( $images->total_images > ( ( $page-1 ) * $results_per_page ) ) {
							$images = $function_to_call( $search_term, $license, $page, $results_per_page, 0, $attribution, $imgtype, $modifiables );
							if ( !$images ) continue;
							$images->image_source = $current_api;
							$total_images->image_groups[] = $images;
							$current_images += $images->images_in_group;
							$remaining_needed = $results_per_page-$current_images;
							$is_first_look = 0;
							$is_first_checked = 0;
							continue;
						}
						else {
							$is_first_look = 0;
							$total_shown += $images->total_images;
							continue;
						}

					}
					else {
						if ( $is_first_checked ) {
							// ok, aquí sé que estoy en la segunda iteración (al menos) !!!
							$current_shown_rdos = ( $page-1 )*$results_per_page;  // 10 en este caso
							$total_shown = $total_shown; // otros rdos, 9 en este caso
							$total_shown_this_group = $current_shown_rdos - $total_shown;
							$page_needed = ceil( $total_shown_this_group / $results_per_page )+1;
							$offset = $total_shown_this_group % $results_per_page;
						}
						else {
							// el sitio anterior devolvió cosas, luego la page needed = 1
							$page_needed = 1;
							$offset = 0;
						}
						$images = $function_to_call( $search_term, $license, $page_needed, $results_per_page, $offset, $attribution, $imgtype, $modifiables );
						if ( !$images ) continue;
						$images->image_source = $current_api;
						$total_images->image_groups[] = $images;
						$current_images += $images->images_in_group;
						$remaining_needed = $results_per_page-$current_images;
						continue;
					}
				}
				continue;
			}
		return $total_images;
}

function wpbeautify_count_current_images( $total_images ) {
	$total_count = 0;
	foreach ( $total_images as $image_group ) {
		$total_count += $image_group->total_images;
	}
	return $total_count;
}
/*
	Object definition

total_images = num
image_source = string
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

function wpbeautify_debug_image_object( $images ) {
	if ( 1 ) return;
	foreach ( $images->image_groups as $image_type ) {
		echo '<b>'.$image_type->image_source. '</b><br/>';
		echo "total total = ".$image_type->total_images. '<br/>';
		echo "total en el grupo = ".count( $image_type->images ). '<br/>';
	}

}

function wpbeautify_join_arrays( $temp_results, $page, $results_per_page, $offset ) {
	$return_object = new stdClass();
	$cont = 0;
	$images = array();
	foreach ( $temp_results as $result ) {
		if ( !$result ) continue;
		$cont += count( $result->images );
		$images = array_merge( $images, $result->images );
	}
	$elem_offset = ( $page-1 )*$results_per_page;
	$total = $results_per_page;

	$images = array_slice( $images, $elem_offset+$offset, $total );
	$return_object->total_images = $cont;
	$return_object->images_in_group = count( $images );
	$return_object->images = $images;

	return $return_object;
}

?>
