<?php


/* Activation & Deactivation */
register_activation_hook(  __FILE__, 'wpbeautify_activate');
register_deactivation_hook(  __FILE__, 'wpbeautify_deactivate');
/*****************************/


function wpbeautify_check_upgrade_db() {
	if ( !get_option('wpbeautify_version', 0))  {
		// we assume we are on 1.0
		update_option('wpbeautify_version', WPBEAUTIFY_VERSION);
	}
	else {
		//do nothing for now
	}

}
add_action('admin_init', 'wpbeautify_check_upgrade_db');


function wpbeautify_activate()
{
	return;
}

function wpbeautify_deactivate() {
}

add_filter( 'plugin_action_links_' . WPBEAUTIFY_PLUGIN_NAME.'/'.WPBEAUTIFY_PLUGIN_NAME.'.php', 'wpbeautify_add_plugin_action_links' );
function wpbeautify_add_plugin_action_links( $links ) {
	$fpress_options = array(
			'Support' => '<a target="_blank" href="http://support.kudosinteractive.com">Support</a>'
	);
	if( !ckala_is_pro() ) {
		$fpress_options = array_merge( $fpress_options, 
			array(
							'Upgrade to Pro' => '<a target="_blank" href="http://wpfotopress.com/sales/oto1.html" style="font-weight:bold;color:red">Upgrade to FotoPress Pro!</a>'
				)
			);
	}
	else {
		$fpress_options = array_merge( $fpress_options, 
			array(
							'Reseller' => '<a target="_blank" href="http://wpfotopress.com/sales/reseller/" style="color:#00FF00">Resellers License</a>'
				)
			);
	}
	return array_merge(
		$links,
		$fpress_options
	);
}

function wpbeautify_listify_pagination($pagination_array, $extra_class='') {
	// var_dump($pagination_array);
	$str_ret = '<ul class="pagination '.$extra_class.'" style="margin:0">';
	 // var_dump($pagination_array);
	if ($pagination_array) {
		foreach ($pagination_array as $pagination_item) {
			if (strpos($pagination_item,'current') !== false)
				$str_ret .= '<li class="active">'.$pagination_item.'</li>';
			else
				$str_ret .= '<li>'.$pagination_item.'</li>';
		}
	}
	$str_ret .= '</ul>';
	return $str_ret;
}


/**
    * Remove a value from a array
    * @param string $val
    * @param array $arr
    * @return array $array_remval
    */
    function wpbeautify_array_removal($val, &$arr)
    {
          $array_remval = $arr;
          for($x=0;$x<count($array_remval);$x++)
          {
              $i=array_search($val,$array_remval);
              if (is_numeric($i)) {
                  $array_temp  = array_slice($array_remval, 0, $i );
                $array_temp2 = array_slice($array_remval, $i+1, count($array_remval)-1 );
                $array_remval = array_merge($array_temp, $array_temp2);
              }
          }
          return $array_remval;
    }

function wpbeautify_site_url() {
  $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ||
    $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
  $domainName = $_SERVER['HTTP_HOST'];
  return $protocol.$domainName;
}

function fotopress_upgrade_pro() {
?>
<div class="row">
	<div class="col-lg-12">
		<div class="alert alert-success alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  <i class="fa fa-star"></i> Upgrade to <a style="text-decoration:underline" href="http://wpfotopress.com/sales/oto1.html" target="_blank">FotoPress Pro</a> and get 10 Image Sources, Video Branding, Images from 6 Social Networks, Google Drive/Dropbox Integration, 700+ Fonts, Special Font effects and more! <a style="text-decoration:underline" href="http://wpfotopress.com/sales/oto1.html" target="_blank">Click here to get it</a>
		</div>
	</div>
</div>
<?php
}
define( 'CANVAKALA_IS_PRO', 1 );

function ckala_is_pro() {
	return false;
}
?>