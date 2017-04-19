<?php

add_action( 'wp_ajax_wpbeautify_googleplus_browse_albums', 'wpbeautify_googleplus_browse_albums' );
add_action( 'wp_ajax_wpbeautify_googleplus_browse_album_pics', 'wpbeautify_googleplus_browse_album_pics' );

add_action( 'wp_ajax_wpbeautify_googleplus_get_album_list', 'wpbeautify_googleplus_get_album_list' );


function wpbeautify_googleplus_get_album_list() {
    $albums = wpbeautify_get_googleplus_albums();
    $str_ret = '';
    if ($albums) {
        foreach ($albums as $album) {
            $str_ret .= '<option value="'.$album['id'].'">'.$album['name'].'</option>';
        }
    }
    echo $str_ret;
    exit(0);
}

function wpbeautify_get_googleplus_albums() {

    // $image_settings = wpbeautify_get_image_settings();
    // $wpbeautify_sites = $image_settings['social_sites'];
    // $username = $wpbeautify_sites['googleplus']['username'];
    wpbeautify_check_social_auth('googleplus');

    $username = 'default';
    $file = "http://picasaweb.google.com/data/feed/api/user/" . $username . "?kind=album&thumbsize=140c";


    $array_ret = googleplus_doCurlExec($file);
    // var_dump($array_ret);
    $str_ret = '';
    $albums = array();
    foreach ($array_ret as $field) {

                   switch ($field["tag"]) {

                        case "MEDIA:THUMBNAIL":
                            $thumb = trim($field["attributes"]["URL"] . "\n");
                            break;
                        case "MEDIA:DESCRIPTION":
                            if (isset($field["value"]))
                                $desc = trim($field["value"] . "\n");
                            else
                                $desc = '';
                            break;
                                    case "MEDIA:TITLE":
                                            $title = trim($field["value"]);
                                            break;
                                    case "LINK":
                            if ($field["attributes"]["REL"] == "alternate") {
                                                $href = trim($field["attributes"]["HREF"]);
                            }
                                            break;
                                    case "GPHOTO:NUMPHOTOS":
                                            $num = trim($field["value"]);
                                            break;
                        case "GPHOTO:LOCATION":
                            if (isset($field["value"]))
                                        $loc = trim($field["value"]);
                                else
                                    $loc = '';
                                            break;
                        #case "PUBLISHED":
                                    #        $published = trim($val["value"]);
                        #   $published = substr($published,0,10);
                                    #        break;
                        case "GPHOTO:TIMESTAMP":
                            $epoch = $field["value"];
                            break;
                        case "GPHOTO:ACCESS":
                            $access = trim($field["value"]);
                            if ($access == "protected") { $daccess = "Private"; }
                            else { $daccess = "Public"; }
                            break;
                        case "GPHOTO:NAME":
                            $picasa_name = trim($field["value"]);
                            break;
                            case "GPHOTO:ID":
                                $album_id = trim($field["value"]);
                                break;

                   }


            if (isset($thumb) && isset($title) && isset($href) && isset($num) && isset($epoch)) {
                $album = array(
                    'id' => $album_id,
                    'name' => $title,
                    'thumb' => $thumb,
                    'count' => $num
                    );
                $albums[] = $album;
                unset($thumb);
                unset($title);
            }
    }

    // echo $str_ret;
    return $albums;

}


function wpbeautify_googleplus_get_photos_in_album($album_id, $page=0, $results_per_page=WPBEAUTIFY_IMAGES_PER_PAGE) {

        // $image_settings = wpbeautify_get_image_settings();
        // $wpbeautify_sites = $image_settings['social_sites'];
        // $username = $wpbeautify_sites['googleplus']['username'];
        $username = 'default';

        if ($page) $page--;
        $start_index = $page*$results_per_page + 1;
        $file = "http://picasaweb.google.com/data/feed/api/user/" . $username . "/albumid/".$album_id.'?start-index='.$start_index.'&max-results='.$results_per_page;
// echo $file;
        // $results_per_page = 30;
        // $page = 0;

        $array_ret = googleplus_doCurlExec($file);
          // var_dump($array_ret);
          $total_imgs = 0;
        // $str_ret = '';
        $photos_ret = array();
        foreach ($array_ret as $field) {
                   switch ($field["tag"]) {

            case "MEDIA:THUMBNAIL":
                $thumb = trim($field["attributes"]["URL"] . "\n");
                break;

                case "MEDIA:CONTENT":
                    $image_fullsize_url = trim($field["attributes"]["URL"] . "\n");
                    break;

            case "MEDIA:DESCRIPTION":
                if (isset($field["value"]))
                    $desc = trim($field["value"] . "\n");
                else
                    $desc = '';
                break;
                        case "MEDIA:TITLE":
                                $title = trim($field["value"]);
                                break;
                        case "LINK":
                if ($field["attributes"]["REL"] == "alternate") {
                                    $href = trim($field["attributes"]["HREF"]);
                }
                                break;
                        case "GPHOTO:NUMPHOTOS":
                                $total_imgs = trim($field["value"]);
                                break;
            case "GPHOTO:LOCATION":
                if (isset($field["value"]))
                            $loc = trim($field["value"]);
                    else
                        $loc = '';
                                break;
            #case "PUBLISHED":
                        #        $published = trim($val["value"]);
            #   $published = substr($published,0,10);
                        #        break;
            case "GPHOTO:TIMESTAMP":
                $epoch = $field["value"];
                break;
            case "GPHOTO:ACCESS":
                $access = trim($field["value"]);
                if ($access == "protected") { $daccess = "Private"; }
                else { $daccess = "Public"; }
                break;
            case "GPHOTO:NAME":
                $picasa_name = trim($field["value"]);
                break;
                case "GPHOTO:ID":
                    $album_id = trim($field["value"]);
                    break;

            case "GPHOTO:HEIGHT":
                $image_height = trim($field["value"]);
                break;

                case "GPHOTO:WIDTH":
                    $image_width = trim($field["value"]);
                    break;
                    /*case "GPHOTO:NUMPHOTOS":
                        $total_imgs = trim($field["value"]);
                        break;*/


        }

        if (isset($thumb) && isset($title) && isset($href) && isset($total_imgs) && isset($epoch)) {

            $cover_img = $thumb;
            $name = $title;
            $id = $album_id;

            $photo_arr = array(
                'image_source' => 'googleplus',
                'thumbnail_url' => $thumb,
                'fullsize_url' => $image_fullsize_url,
                'width' => $image_width,
                'height' => $image_height,
                'title' => $title,
                'original_url' => 'pendiente'
            );
            $photos_ret[] = $photo_arr;

            // echo 'got album!';
            // echo '<img src="'.$thumb.'" />';
            unset($thumb);
            unset($title);
        }

}

// var_dump($total_imgs);
    return array($total_imgs, $photos_ret);
        //TODO: LICENSE: http://www.googleplus.com/services/api/googleplus.photos.licenses.getInfo.html
        $req_args = array(
            'per_page'       => $results_per_page,
            'page'           => $page,
            'photoset_id' => $album_id,
            'extras' =>     'url_t,url_o,url_l,url_m', /*url_sq, ,o_dims */
            'api_key'        => $wpbeautify_sites['googleplus']['details']['api_key'],
            'method'         => 'googleplus.photosets.getPhotos',
            'format'         => 'php_serial'
        );

        $response = wp_remote_get( add_query_arg( $req_args, 'http://api.googleplus.com/services/rest/' ) );
        // var_dump($response);
        if ( is_wp_error( $response ) ) {
            return 0;
        } else {
            // var_dump($response['body']);
            // return wpbeautify_googleplus_togeneric ( , $offset, $results_per_page );
            $photos = unserialize( $response['body'] );
            $photos_ret = array();

            // var_dump($photos['photoset']/*['photo']*/);
            foreach ($photos['photoset']['photo'] as $photo) {
                // var_dump($photo);
                if ( isset( $photo['url_o'] ) ) {
                    $image_fullsize_url = $photo['url_o'];
                    $image_width = $photo['width_o'];
                    $image_height = $photo['height_o'];
                }
                else if ( isset( $photo['url_l'] ) ) {
                        $image_fullsize_url = $photo['url_l'];
                        $image_width = $photo['width_l'];
                        $image_height = $photo['height_l'];
                    }
                else {
                    $image_fullsize_url = $photo['url_m'];
                    $image_width = $photo['width_m'];
                    $image_height = $photo['height_m'];
                }

                $photo_arr = array(
                    'image_source' => 'googleplus',
                    'thumbnail_url' => $photo['url_t'],
                    'fullsize_url' => $image_fullsize_url,
                    'width' => $image_width,
                    'height' => $image_height,
                    'title' => $photo['title'],
                    'original_url' => 'pendiente'
                );
                $photos_ret[] = $photo_arr;
            }
            return $photos_ret;
            // var_dump($photos['photoset']['photo']);
            // $photosets_ret =
/*            foreach ($photosets['photosets']['photoset'] as $photoset) {
                $cover_img = $photoset['primary_photo_extras']['url_sq'];
                $name = $photoset['title']['_content'];
                $id = $photoset['id'];
                echo '<img src="'.$cover_img.'" /><br/>'.$name.'<br/>';
            }*/
            // var_dump();
        }
}

/*
<img class="wpbeautify_thumb wpbeautify_thumb_<?php echo $image['image_source'];?>" src="<?php echo $image['thumbnail_url'];?>"
    data-width="<?php echo $image['width'];?>"
    data-height="<?php echo $image['height'];?>"
    data-url="<?php echo $image['fullsize_url'];?>"
    data-origin="<?php echo $image['image_source'];?>"
    data-original-url="<?php echo $image['original_url'];?>"
    title="<?php echo $image['title'];?>"*/

function wpbeautify_googleplus_browse_albums() {
    $albums = wpbeautify_get_googleplus_albums();
    wpbeautify_print_photo_album($albums, 'googleplus', 0, 36);
    exit(0);
}

function wpbeautify_googleplus_browse_album_pics() {

    $page = isset($_POST['page']) ? $_POST['page'] : 0;
    $album_photos = wpbeautify_googleplus_get_photos_in_album($_POST['album_id'], $page, WPBEAUTIFY_IMAGES_PER_PAGE);
    wpbeautify_print_social_images($album_photos, $page, WPBEAUTIFY_IMAGES_PER_PAGE);
    exit(0);
}


function googleplus_doCurlExec($file) {

    $PUBLIC_ONLY = 0;
    #----------------------------------------------------------------------------
    # Curl code to store XML data from PWA in a variable
    #----------------------------------------------------------------------------
    $ch = curl_init();
    $timeout = 0; // set to zero for no timeout
    curl_setopt($ch, CURLOPT_URL, $file);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

    # Display only public albums if PUBLIC_ONLY=TRUE in config.php
    // if ($PUBLIC_ONLY == "FALSE") {

    $image_settings = wpbeautify_get_image_settings();
    $token = $image_settings['social_sites']['googleplus']['token'];

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
         'Authorization: AuthSub token="' . $token . '"'
    ));

    $addressData = curl_exec($ch);
    curl_close($ch);

    #----------------------------------------------------------------------------
    # Parse the XML data into an array
    #----------------------------------------------------------------------------
    $p = xml_parser_create();
    xml_parse_into_struct($p, $addressData, $vals, $index);
    xml_parser_free($p);

    return ($vals);

}

function wpbeautify_share_img_googleplus($type=1, $text, $album, $image_url, $filename) {
        $image_data = file_get_contents($image_url);

        $xml = $image_data;

        unset($image_data);

        $image_settings = wpbeautify_get_image_settings();
        $token = $image_settings['social_sites']['googleplus']['token'];
        $filetype = wp_check_filetype( basename( $image_url ), null );

        $header  =  array("Content-Type: ".$filetype['type'], "Content-Length:".strlen($xml), "Slug: $filename", "Authorization: AuthSub token=" .$token);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"http://picasaweb.google.com/data/feed/api/user/default/albumid/".$album);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        $http_result = curl_exec($ch);
        curl_close ($ch);
        // echo $http_result;
        return;
}


function wpbeautify_remote_file_size($url){
    # Get all header information
    $data = get_headers($url, true);
    # Look up validity
    if (isset($data['Content-Length']))
        # Return file size
        return (int) $data['Content-Length'];
}
?>