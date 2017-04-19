<?php
define( 'WPBEAUTIFY_FLICKR_URL', 'https://api.flickr.com/services/rest/' );

function wpbeautify_flickr_imagesearch( $search_term, $license, $page=1, $results_per_page=36, $offset=0, $attribution_required=0, $imgtype=0, $only_modifiables = 0 ) {
    // global $wpbeautify_sites;
    $search_term = str_replace( ' ', '+', $search_term );

    $image_settings = wpbeautify_get_image_settings();
    $wpbeautify_sites = $image_settings['image_sites'];

    if ( isset( $wpbeautify_sites['flickr']['details']['onlynoattribution'] ) && $wpbeautify_sites['flickr']['details']['onlynoattribution'] == 1 )
        $flickr_licenses = '7,8';
    else {
        if ($only_modifiables)
            $flickr_licenses = '2,4,5,7,8';
        else
            $flickr_licenses = '2,3,4,5,6,7,8';
    }

    if ( $attribution_required == 2 ) {
        if ($only_modifiables)
            $flickr_licenses = '2,4,5';
        else
            $flickr_licenses = '2,3,4,5,6';
    }
    else if ( $attribution_required == 1 )
        $flickr_licenses = '7,8';

// var_dump($flickr_licenses);
    // if ($only_modifiables)
//        $flickr_licenses = array_diff($flickr_licenses, array(3,6));
    if ( $offset )
        if ( $page > 1 ) $page--;

    if ( $imgtype == 2 )
        $content_type = 1;
    else if ( $imgtype == 1 )
        $content_type = 3;
    else
        $content_type = 7;

        //TODO: LICENSE: http://www.flickr.com/services/api/flickr.photos.licenses.getInfo.html
        $req_args = array(
            'per_page'       => $results_per_page,
            'page'           => $page,
            'safe_search'    => 1,
            'content_type'   =>  $content_type, // Search for photos only 1: photos, 3: cliparts
            'privacy_filter' => 1, // Search for public photos
            'sort'           => 'relevance',
            'license'        => $flickr_licenses,
            'text'           => $search_term,
            'media'           => 'photos',
            'api_key'        => $wpbeautify_sites['flickr']['details']['api_key'],
            'method'         => 'flickr.photos.search',
            'format'         => 'php_serial',
            'extras'        => 'owner_name,license,url_t,url_o,url_l,url_m,path_alias'
        );

    // @TODO: investigar iscommons = 1
    //http://www.flickr.com/services/api/flickr.photos.search.html

    if ( !$offset ) {
        $response = wp_remote_get( add_query_arg( $req_args, WPBEAUTIFY_FLICKR_URL ) );
        // var_dump($response);
        if ( is_wp_error( $response ) ) {
            return 0;
        } else {
            // var_dump($response['body']);
            return wpbeautify_flickr_togeneric ( unserialize( $response['body'] ), $offset, $results_per_page );
        }
    }
    else {
        $response = wp_remote_get( add_query_arg( $req_args, WPBEAUTIFY_FLICKR_URL ) );
        if ( is_wp_error( $response ) ) {
            return 0;
        } else {
            $arr1 = wpbeautify_flickr_togeneric ( unserialize( $response['body'] ), $offset, $results_per_page );
            $req_args['page']++;
            $response = wp_remote_get( add_query_arg( $req_args, WPBEAUTIFY_FLICKR_URL ) );
            if ( is_wp_error( $response ) ) {
                return 0;
            } else {
                $arr2 = wpbeautify_flickr_togeneric ( unserialize( $response['body'] ), $offset, $results_per_page );
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
function wpbeautify_flickr_getimgsizes( $photo_id ) {
    $req_args = array(
        'photo_id'  => $photo_id,
        'api_key'   => '6295b7f50b317aadabbcf3e46e138fa5',
        'method'    => 'flickr.photos.getSizes',
        'format'    => 'php_serial'
    );

    $response = wp_remote_get( add_query_arg( $req_args, WPBEAUTIFY_FLICKR_URL ) );
    if ( is_wp_error( $response ) ) {
        echo 'Something went wrong!';
        return 0;
    }
    // TODO, si hay error, response es un WP_Error, y unserialize da error
    $rsp_obj = unserialize( $response['body'] );
    $sizes = $rsp_obj['sizes']['size'];
    while ( $size = array_shift( $sizes ) ) {
        if ( $size['label'] == 'Thumbnail' ) {
            $thumb_img = $size['source'];
        } // TODO: A veces Medium no es available!!!; use PICKAPIC_DEFAULT_FLICKR_IMG_SIZE instead.
        elseif ( $size['label'] == 'Medium' ) {
            $full_img = array( $size['source'], array( $size['width'], $size['height'] ) );
        }
        elseif ( $size['label'] == 'Original' ) {
            $full_img = array( $size['source'], array( $size['width'], $size['height'] ) );
        }
    }
    return array( $thumb_img, $full_img );
}

function wpbeautify_flickr_extrainfo( $photo_id ) {
    $req_args = array(
        'photo_id'  => $photo_id,
        'api_key'   => '6295b7f50b317aadabbcf3e46e138fa5',
        'method'    => 'flickr.photos.getInfo',
        'format'    => 'php_serial'
    );

    // http://www.flickr.com/services/api/flickr.photos.getSizes.html
    $response = wp_remote_get( add_query_arg( $req_args, WPBEAUTIFY_FLICKR_URL ) );
    if ( is_wp_error( $response ) ) {
        echo 'Something went wrong!';
        return 0;
    }
    // TODO, si hay error, response es un WP_Error, y unserialize da error
    $rsp_obj = unserialize( $response['body'] );
    return $rsp_obj;
}

function wpbeautify_flickr_authorinfo( $photo_id ) {
    $req_args = array(
        'user_id'  => $photo_id,
        'api_key'   => '6295b7f50b317aadabbcf3e46e138fa5',
        'method'    => 'flickr.urls.getUserProfile',
        'format'    => 'php_serial'
    );

    $response = wp_remote_get( add_query_arg( $req_args, WPBEAUTIFY_FLICKR_URL ) );
    if ( is_wp_error( $response ) ) {
        echo 'Something went wrong!';
        return 0;
    }
    // TODO, si hay error, response es un WP_Error, y unserialize da error
    $rsp_obj = unserialize( $response['body'] );
    return $rsp_obj;
}
*/

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

function wpbeautify_flickr_togeneric( $images, $offset=0, $results_per_page=0 ) {
    $return_object = new stdClass();
    $return_object->total_images = $images['photos']['total'];
    $return_object->images = array();
 // var_dump($images['photos']['photo']);

    if ( !is_array( $images['photos']['photo'] ) ) return 0;
    foreach ( $images['photos']['photo'] as $hit ) {

        $image = new stdClass();
        $image->thumbnail_url = $hit['url_t'];
        if ( isset( $hit['url_o'] ) ) {
            $image->fullsize_url = $hit['url_o'];
            $image->width = $hit['width_o'];
            $image->height = $hit['height_o'];
        }
        else if ( isset( $hit['url_l'] ) ) {
                $image->fullsize_url = $hit['url_l'];
                $image->width = $hit['width_l'];
                $image->height = $hit['height_l'];
            }
        else {
            $image->fullsize_url = $hit['url_m'];
            $image->width = $hit['width_m'];
            $image->height = $hit['height_m'];
        }

        $image->license_type = $hit['license'];

        $image->author_url = null;
        if ( $hit['license'] < 7 ) {
            $image->attribution = true; // TODO: review attribution policy in Flickr
            $image->author_url = 'http://www.flickr.com/people/'.$hit['pathalias'];
        }
        else
            $image->attribution = false; // TODO: review attribution policy in Flickr

        $image->modifiable = false;
        $array_modifiables = array(2,4,5,7,8);
        if (in_array($hit['license'], $array_modifiables ))
            $image->modifiable = true;

        $image->author_name =  $hit['ownername'];
        $image->title = $hit['title'];
        $image->original_url = 'http://flickr.com/photo.gne?id='.$hit['id'];
        $return_object->images[] = $image;
    }
    $return_object->images_in_group = count( $return_object->images );

    return $return_object;
}

function tsfpix_flickr_testapikey( $apikey ) {
    $req_args = array(
        'per_page'       => 10,
        'page'           => 1,
        'safe_search'    => 1,
        'content_type'   => 1,
        'privacy_filter' => 1, // Search for public photos
        'sort'           => 'relevance',
        'text'           => 'test',
        'media'          => 'photos',
        'api_key'        => $apikey,
        'method'         => 'flickr.photos.search',
        'format'         => 'php_serial',
    );

    $response = wp_remote_get( add_query_arg( $req_args, WPBEAUTIFY_FLICKR_URL ) );
    if ( is_wp_error( $response ) ) {
        return 0;
    } else {
        $results = unserialize( $response['body'] );
        if ( !$results )
            return 0;
        if ( $results['stat'] != 'ok' )
            return 0;
        return 1;
    }
}
?>
