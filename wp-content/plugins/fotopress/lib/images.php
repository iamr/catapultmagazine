<?php

define( 'WPBEAUTIFY_IMAGES_PER_PAGE', 36 );
define( 'WPBEAUTIFY_PIXABAY_USER', 'canvakala' );
// define( 'WPBEAUTIFY_PIXABAY_APIKEY', '6044be6baadf1959c312' );
define( 'WPBEAUTIFY_PIXABAY_APIKEY', '1260271-c62621822e9870b3968a53ac3' );


$wpbtfy_social_sizes = array(
  array(
    'name' => 'Facebook',
    'sizes' => array(
      array('fbprofile', 'Profile Photo', 180, 180),
      array('fbcover', 'Cover Image', 851, 315),
      array('fbsharedimg', 'Shared Image', 1200, 900),
      array('fbsharedimg', 'Shared Link', 1200, 627)
      )
    ),
  array(
    'name' => 'Twitter',
    'sizes' => array(
      array('twprofile', 'Profile Photo', 400, 400),
      array('twcover', 'Header Photo', 1500, 500),
      array('twstream', 'In-stream Photo', 506, 253)
      )
    ),
  array(
    'name' => 'Google +',
    'sizes' => array(
      array('gplusprofile', 'Profile Photo', 250, 250),
      array('gpluscover', 'Cover Image', 1080, 608)
      )
    ),
  array(
    'name' => 'Pinterest',
    'sizes' => array(
      array('pintprofile', 'Profile Photo', 165, 165),
      array('pintpin', 'Pin', 735, 1102),
      array('pintcover', 'Board Cover', 222, 150)
      )
    ),
  array(
    'name' => 'Instagram',
    'sizes' => array(
      array('instprofile', 'Profile Photo', 110, 110),
      array('instphoto', 'Photo', 640, 640)
      )
    ),
  array(
    'name' => 'Kindle',
    'sizes' => array(
      array('kindcover', 'Kindle Cover', 1563, 2500)
      )
    ),
  array(
    'name' => 'Web Banners',
    'sizes' => array(
      array('webbaner1', 'Full banner', 468, 60),
      array('webbaner2', 'Vertical banner', 120, 240),
      array('webbaner3', 'Medium Rectangle', 300, 250),
      array('webbaner4', 'Side skyscraper', 160, 600),
      array('webbaner5', 'Large rectangle', 336, 280),
      array('webbaner6', 'Skyscraper', 120, 600)
      )
    ),
  );

/* WP Option structure */

/********************
wp_beautify_image_options = array()
	image_sites = array()
		pixabay = array('username' => 'xx', 'api_key' => 'xx')
		flickr = array('api_key' => 'xx')
	social_sites = array()
		dropbox = array('app_id' => 'xx')
		facebook = array('app_id' => 'xx')
	watermark
		xxx
********************/
function wpbeautify_get_default_image_settings() {
	$options = array(
		'image_sites' => array(
			'pixabay' => array('id' => 'pixabay', 'name' => 'Pixabay', 'used' => 1, 'order' => 0, 'details' => array('username' => WPBEAUTIFY_PIXABAY_USER, 'api_key' => WPBEAUTIFY_PIXABAY_APIKEY, 'validapi' => 1, 'hires' => 0, 'ownkey' => 0)),
			'flickr' => array('id' => 'flickr', 'name' => 'Flickr', 'used' => 0, 'order' => 1, 'details' => array('api_key' => '', 'validapi' => '')),
			'openclipart' => array('id' => 'openclipart', 'name' => 'Openclipart', 'used' => 0, 'order' => 2, 'details' => array()),
			'iamcc' => array('id' => 'iamcc', 'name' => 'Instagram', 'used' => 0, 'order' => 3, 'details' => array())
		),
		'social_sites' => array(
			'dropbox' => array('app_id' => ''),
      'facebook' => array('app_id' => '', 'app_secret' => ''),
      'googledrive' => array('client_id' => '', 'api_key' => ''),
      'pinterest' => array('username' => ''),
      'flickr' => array('api_key' => '', 'username' => ''),
      'instagram' => array('api_key' => '', 'api_secret' => ''),
			'twitter' => array('api_key' => '', 'api_secret' => '', 'token' => '', 'token_secret' => '')
		),
		'watermark' => array(
			'watermark_type' => 'text',
			'watermark_text' => 'Watermark Text',
			'watermark_font' => 'Arial.ttf',
			'watermark_text_size' => '30',
			'watermark_text_color' => '000000',
			'watermark_image_url' => 'http://',
			'watermark_position' => 'bottom_right',
			'watermark_offset_x' => '0',
			'watermark_offset_y' => '0'
		),
    'video' => array(
      'logo_position' => '',
      'logo_img_url' => '',
      'transparency' => '0'
      )
	);
	return $options;
}

// $watermark_settings = array();


function wpbeautify_get_image_settings() {
	// delete_option('wp_beautify_image_options' );
	return get_site_option('wp_beautify_image_options', wpbeautify_get_default_image_settings());
}

function wpbeautify_set_image_settings($options) {
	return update_site_option('wp_beautify_image_options', $options, true);
}



// empieza codigo tabs
// add_filter( 'media_upload_tabs', 'wpbeautify_upload_tab' );
/*else
	add_filter('media_upload_tabs', 'wpbeautify_notactive_upload_tab');*/

function wpbeautify_upload_tab( $tabs ) {
	$tabs['wpbeautifytab'] = 'FotoPress Editor';
	return $tabs;
}



function media_upload_wpbeautifytab_fn() {
	wp_iframe( 'media_wpbeautify_search' );
}

/*function media_upload_wpbeautify_notactivetab_fn() {
    wp_iframe( 'media_wpbeautify_notactive_search' );
}

add_action('media_upload_wpbeautify_notactivetab', 'media_upload_wpbeautify_notactivetab_fn');*/

// add_action( 'media_upload_wpbeautifytab', 'media_upload_wpbeautifytab_fn' );


function media_wpbeautify_search() {
?>
	<p style="padding:100px">should I add anything here???</p>
<?php
}


function wpbeautify_search_button_media( $context ) {
	global $post_ID;

	$img = wpbeautify_URL.'/img/images.png';

	//our popup's title
	$title = 'Search Free Images';

	//append the icon
	$media_upload_button = "<a id='wpbeautify_add_image' class='thickbox' title='{$title}' href='#TB_inline?width=670&height=420&inlineId=popup_container'><img src='{$img}' /></a>";

	//$media_upload_button = '<a id="wpbeautify_add_image" title="Insert Free Image" href="' . site_url() . '/wp-content/plugins/wpseopix/flickr_images_upload.php?post_id=' . $post_ID . '&tab=wpbeautify_pop&paged=1&TB_iframe=1&width=640&height=584" class="thickbox"><img alt="Search And Insert Flickr Image" src="'.wpbeautify_URL.'/img/images.png"></a>';
	return $context.$media_upload_button;
}


// acaba código tabs

// add button
add_action('media_buttons','wpbeautify_add_sc_select',11);
function wpbeautify_add_sc_select(){
	echo '<a title="FotoPress" data-editor="content" class="button" id="wpbeautify-editor-button" href="#"><img src="'.WPBEAUTIFY_URL.'/img/icons/logo.png"> FotoPress</a>';
}

// add popup to footer

add_action( 'admin_menu', 'myplugin_setup_options' );

function myplugin_setup_options(){
	add_action( 'admin_footer-post.php','myplugin_admin_footer' );
	add_action( 'admin_footer-post-new.php','myplugin_admin_footer' );

	add_action( "admin_print_scripts-post.php", 'wpbeautify_admin_scripts_image' );
	add_action( "admin_print_scripts-post-new.php", 'wpbeautify_admin_scripts_image' );
	add_action( "admin_print_styles-post.php", 'wpbeautify_admin_style_image' );
	add_action( "admin_print_styles-post-new.php", 'wpbeautify_admin_style_image' );

}

function myplugin_admin_footer(){
	$image_settings = wpbeautify_get_image_settings();

/*  echo '<div id="wpbeautify_image_editor" title="WP Beautify Image Editor" style="display:none">
<p>This is the default dialog which is useful for displaying information. The dialog window can be moved, resized and closed with the x icon.</p>
</div>';*/
?>
<script>
      window.___gcfg = {
        parsetags: 'explicit'
      };
    </script>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<?php  if ( isset( $image_settings['social_sites']['googledrive']['api_key'] ) && !empty( $image_settings['social_sites']['googledrive']['api_key'] ) ) { ?>
  <script>
    function wpbtfy_gdrive_init_picker() {
      var wpbtfy_picker = new FilePicker({
        apiKey: '<?php echo $image_settings['social_sites']['googledrive']['api_key'];?>',
        clientId: '<?php echo $image_settings['social_sites']['googledrive']['client_id'];?>',
        buttonEl: document.getElementById('wpbtfy_gdrive_pick'),
        onSelect: function(file) {
          /*console.log('file');
          console.log(file);*/
          // alert('Selected ' + file.title);
        }
      });
    }
  </script>
  <script src="https://www.google.com/jsapi?key=<?php echo $image_settings['social_sites']['googledrive']['api_key'];?>"></script>
  <script src="https://apis.google.com/js/client.js?onload=wpbtfy_gdrive_init_picker"></script>
<?php } ?>
<!-- Modal -->

<div class="bootstrap-wpbtfy-wpadmin wpbtfy-image-modal">
<div class="jquery_wmodal" id="wpbeautify-loading-modal" style="display: none">
   <img src="<?php echo WPBEAUTIFY_URL;?>/img/ajax-loader.gif"> Working ...
</div>
<div class="jquery_wmodal" id="wpbeautify-facebook-modal" style="display: none">
   <h3><i class="fa fa-facebook"></i> Share on Facebook:</h3>
   <h5>Select:</h5>
   <select class="form-control" id="wpbeautify-fb-share-type">
   		<option value="1">On your timeline (as link)</option>
   		<option value="2">To your albums</option>
   </select>
   <div id="wpbeautify-fbshare-link-group">
   <h5>Link:</h5>
   <input type="text" class="form-control" id="wpbeautify-fb-share-link" value="<?php echo site_url();?>" /> <br/>
   </div>
   <h5>Text:</h5>
   <textarea class="form-control" rows="3" id="wpbeautify-fb-share-text"></textarea> <br/>

   <a href="#close" rel="modal:close" class="btn pull-right">Close</a>
   <button id="wpbeautify-fb-do-share" class="btn btn-primary pull-right"><i class="fa fa-facebook"></i> Share </button>
</div>

<div class="jquery_wmodal" id="wpbeautify-pinterest-modal" style="display: none">
   <h3><i class="fa fa-pinterest"></i> Pin Image:</h3>
   <h5>URL:</h5>
   <input type="text" class="form-control" id="wpbeautify-pinterest-share-link" value="<?php echo site_url();?>" /> <br/>
   <h5>Text:</h5>
   <textarea class="form-control" rows="3" id="wpbeautify-pinterest-share-text"></textarea> <br/>

   <a href="#close" rel="modal:close" class="btn pull-right">Close</a>
   <button id="wpbeautify-pinterest-do-share" class="btn btn-primary pull-right"><i class="fa fa-pinterest"></i> Pin it! </button>
</div>

<div class="jquery_wmodal" id="wpbeautify-googleplus-modal" style="display: none">
   <h3><i class="fa fa-google-plus"></i> Share on Google +:</h3>
   <h5>Album:</h5>
   <select class="form-control" id="wpbeautify-gplus-albums">
   </select>
<!--    <select class="form-control" id="wpbeautify-gplus-share-type">
   		<option value="1">On your timeline (as link)</option>
   		<option value="2">To your albums</option>
   </select> -->
<!--    <div id="wpbeautify-gplusshare-link-group">
   <h5>Link:</h5>
   <input type="text" class="form-control" id="wpbeautify-gplus-share-link" value="<?php echo site_url();?>" /> <br/>
   </div> -->
   <h5>Text:</h5>
   <textarea class="form-control" rows="3" id="wpbeautify-gplus-share-text"></textarea> <br/>

   <a href="#close" rel="modal:close" class="btn pull-right">Close</a>
   <button id="wpbeautify-googleplus-do-share" class="btn btn-primary pull-right"><i class="fa fa-google-plus"></i> Share </button>
</div>

<div class="jquery_wmodal" id="wpbeautify-twitter-modal" style="display: none">
   <h3><i class="fa fa-twitter"></i> Share on Twitter:</h3>
   <h5>Text:</h5>
   <textarea class="form-control" rows="3" id="wpbeautify-twitter-share-text"></textarea> <br/>

   <a href="#close" rel="modal:close" class="btn pull-right">Close</a>
   <button id="wpbeautify-twitter-do-share" class="btn btn-primary pull-right"><i class="fa fa-twitter"></i> Share </button>
</div>

<div class="jquery_wmodal" id="wpbeautify-gdrive-modal" style="display: none">
   <h3><i class="fa fa-google"></i> Save to Google Drive:</h3>
  <div id="wpbtfy-savetodrive-div"></div>   <a href="#close" rel="modal:close" class="btn pull-right">Close</a>
   <!-- <button id="wpbeautify-gdrive-do-share" class="btn btn-primary pull-right"><i class="fa fa-twitter"></i> Share </button> -->
</div>

<div class="modal fade" id="wpbtfyModal" tabindex="-1" role="dialog" aria-labelledby="wpbtfyModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" style="margin-left:20px" aria-label="Close" id="do-close-fpress-main">&times;</button>

		<div class="pull-right">
      <button type="button" class="btn btn-success wpbtfy-btn-action" id="wpbeautify-insert-image"><span class="glyphicon glyphicon-import"></span> Insert Image</button>
      <button type="button" class="btn btn-info wpbtfy-btn-action" id="wpbeautify-download-image"><span class="glyphicon glyphicon-download"></span> Download Image</button>
      
      <?php if (ckala_is_pro()) { ?>
      <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
          Other Actions <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
          <li><a href="#" id="wpbeautify_save_to_wp_gallery" class="wpbtfy-btn-action"><i class="fa fa-th"></i> Save to WP Gallery</a></li>
          <li class="divider"></li>
          <li><a href="#" id="wpbeautify_share_fb" class="wpbtfy-btn-action"><i class="fa fa-facebook"></i> Share on Facebook</a></li>
          <li><a href="#" id="wpbeautify_share_pinterest" class="wpbtfy-btn-action"><i class="fa fa-pinterest"></i> Pin It</a></li>
          <li><a href="#" id="wpbeautify_share_googleplus" class="wpbtfy-btn-action"><i class="fa fa-google-plus"></i> Share on Google+</a></li>
          <li><a href="#" id="wpbeautify_share_twitter" class="wpbtfy-btn-action"><i class="fa fa-twitter"></i> Tweet</a></li>
          <li class="divider"></li>
          <li><a href="#" id="wpbeautify_save_dropbox" class="wpbtfy-btn-action"><i class="fa fa-dropbox"></i> Save to Dropbox</a></li>
          <li><a href="#" id="wpbeautify_save_gdrive" class="wpbtfy-btn-action"><i class="fa fa-google"></i> Save to Google Drive</a></li>

          <!-- <li><a href="#" id="wpbeautify_share_flickr" class="wpbtfy-btn-action"><i class="fa fa-flickr"></i> Upload to Flickr</a></li> -->
        </ul>
      </div>
      <?php } else { ?>
        <button type="button" class="btn btn-default wpbtfy-btn-action" id="wpbeautify_save_to_wp_gallery"><i class="fa fa-th"></i> Save to WP Gallery</button>
      <?php } ?>
	</div>
        <h4 class="modal-title" id="wpbtfyModalLabel"><img src="<?php echo WPBEAUTIFY_URL; ?>/img/logo_sm.png"></i> FotoPress Image Editor</h4>
      </div>
      <div class="modal-body">

       <div class="col-md-10 col-sm-8 main-popup-content">
<ul class="nav nav-tabs" id="wpbtfy-tabs">
  <li id="wpbtfy_image_selector_tab" class="active"><a href="#image-selector" data-toggle="tab"><i class="fa fa-check-square-o"></i> 1. Image Selector</a></li>
  <li id="wpbtfy_image_editor_tab" class="disabled"><a title="Please select an image first" href="#image-editor" data-toggle="tab"><i class="fa fa-edit"></i> 2. Image Editor</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content" id="image_selector_tab">
	<div class="tab-pane active" id="image-selector">
		<br/>

<div class="row" style="margin-right:0">
  <div class="col-md-12">
<!-- Nav tabs -->
<ul class="nav nav-pills" id="wpbtfy-tabs-img-sites">
  <li class="active"><a href="#wpbtfy-src-freeimg" data-toggle="tab" id="wpbtfy_selector_first_tab"><span class="glyphicon glyphicon-search"></span> Search Free Images</a></li>
  <li><a href="#wpbtfy-src-upload" data-toggle="tab" ><span class="glyphicon glyphicon-upload"></span> Upload</a></li>
  <li><a href="#wpbtfy-src-wp" data-toggle="tab"><span class="glyphicon glyphicon-picture"></span> WP Gallery</a></li>
  <li><a href="#wpbtfy-src-url" data-toggle="tab"><span class="glyphicon glyphicon-link"></span> URL</a></li>
  <?php if ( ckala_is_pro() ) { ?>
  <li><a href="#wpbtfy-src-extra" data-toggle="tab" ><span class="fa fa-file-image-o"></span> Image Pack</a></li>
  <li><a href="#wpbtfy-src-memes" data-toggle="tab"><i class="fa fa-smile-o"></i> Memes</a></li>

<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
      <i class="fa fa-users"></i> Social Networks <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" style="z-index:99999999">
  <li><a href="#wpbtfy-src-facebook" data-toggle="tab"><i class="fa fa-facebook"></i> Facebook</a></li>
  <li><a href="#wpbtfy-src-instagram" data-toggle="tab"><i class="fa fa-instagram"></i> Instagram</a></li>
  <li><a href="#wpbtfy-src-pinterest" data-toggle="tab"><i class="fa fa-pinterest"></i> Pinterest</a></li>
  <li><a href="#wpbtfy-src-flickr" data-toggle="tab"><i class="fa fa-flickr"></i> Flickr</a></li>
  <li><a href="#wpbtfy-src-googleplus" data-toggle="tab"><i class="fa fa-google-plus"></i> Google Drive</a></li>
  <li role="presentation" class="divider"></li>
  <li><a href="#wpbtfy-src-dropbox" data-toggle="tab"><i class="fa fa-dropbox"></i> Dropbox</a></li>

    </ul>
  </li>
  <li><a href="#wpbtfy-src-background" data-toggle="tab"><i class="fa fa-square"></i> Background</a></li>
  <?php } ?>
  <li><a href="#wpbtfy-src-youzign" data-toggle="tab"><img src="<?php echo WPBEAUTIFY_URL;?>/img/icons/youzign-logo-small.png" /> Youzign</a></li>

</ul>

<!-- Tab panes -->
<div class="tab-content" id="wpbtfy-tabs-img-sites-content">
  <div class="tab-pane active" id="wpbtfy-src-freeimg">
    <?php wpbeautify_freesearch_box(); ?>
  </div>
  <div class="tab-pane" id="wpbtfy-src-upload">
	<?php wpbeautify_upload_box(); ?>
  </div>
  <div class="tab-pane" id="wpbtfy-src-wp">
  	<p  class="centered_panel">
  	<button id="wpbeautify_imagesel_wp" class="btn add-media btn-success"> Click here</button> to select an image from the WordPress Gallery
  	</p>
  	<div id="wpbeautify_wpimage_results" style="" class="social_image_results" data-site-type="wpimage"></div>

  </div>
  <div class="tab-pane" id="wpbtfy-src-url">
  <p style="padding-top:30px">
  	<?php wpbeautify_selurl_box(); ?>
  	</p>
  </div>

  <div class="tab-pane" id="wpbtfy-src-extra">

  <p class="centered_panel social_panel_info" id="extras_panel_info"><button type="button" class="btn btn-success" id="wpbeautify_extras_browse_albums"><i class="fa fa-folder-o"></i> Click here</button> to browse our HD Image Pack</p>
    <div id="wpbeautify_extras_albumname" class="wpbeautify_album_name"></div>

    <div id="wpbeautify_extras_results" class="social_image_results" data-site-type="extras"></div>

<!--
      <p  id="wpbeautify_extra_msg1" class="centered_panel">
        <button id="wpbeautify_imagesel_extras" class="btn btn-success"><i class="fa fa-folder-o"></i> Click here</button> to browse our HD Image Pack
      </p>

        <p style="padding:30px;display:none" id="wpbeautify_extra_msg2">
        Select an image from the list and click "Edit Image" on the right<br/>
      </p>
        <div id="wpbeautify_extra_results" class="social_image_results" data-site-type="extra"></div>-->
  </div>

  <div class="tab-pane" id="wpbtfy-src-dropbox">
  	<p  class="centered_panel">
  	<?php if (!empty($image_settings['social_sites']['dropbox']['app_id'])) { ?>
		<button id="wpbeautify_imagesel_dropbox" class="btn btn-success"><i class="fa fa-folder-o"></i> Click here</button> to select an image from your Dropbox folder
		<br/>
		<div id="wpbeautify_dropbox_loading" class="wpbeautify-loading"></div>
		<br/>
  		<div id="wpbeautify_dropbox_results" style="display:none" class="social_image_results" data-site-type="dropbox"></div>

		<?php } else { ?>
			<p class="centered_panel">Please enter your Dropbox App ID in the <a target="_blank" href="<?php echo admin_url('admin.php?page=fotopress-images');?>">settings page</a> </p>
		<?php } ?>

	</p>
  </div>

    <div class="tab-pane" id="wpbtfy-src-youzign">
      <?php if (!empty($image_settings['social_sites']['youzign']['api_key'])) { ?>

      <p class="centered_panel social_panel_info" id="youzign_panel_info"><button type="button" class="btn btn-success" id="wpbeautify_youzign_browse_images"><i class="fa fa-folder-o"></i> Click here</button> to browse your Youzign Designs</p>
        <!-- <div id="wpbeautify_youzign_albumname" class="wpbeautify_album_name"></div> -->
        <p class="centered_panel"  id="wpbeautify_youzign_msg1"><a target="_blank" href="http://www.youzign.com">Get your Youzign account here</a></p>

        <div id="wpbeautify_youzign_results" class="social_image_results" data-site-type="youzign"></div>

      <?php } else { ?>
        <p class="centered_panel">Please enter your Youzign API Details in the <a target="_blank" href="<?php echo admin_url('admin.php?page=fotopress-images');?>">settings page</a> </p>
        <p class="centered_panel"  id="wpbeautify_youzign_msg1"><a target="_blank" href="http://www.youzign.com">Get your Youzign account here</a></p>
      <?php } ?>

    </div>

  <div class="tab-pane" id="wpbtfy-src-memes">
	  <p  id="wpbeautify_meme_msg1" class="centered_panel">
	  	<button id="wpbeautify_imagesel_memes" class="btn btn-success"><i class="fa fa-folder-o"></i> Click here</button> to browse popular meme backgrounds
	  </p>

	  	<p style="padding:30px;display:none" id="wpbeautify_meme_msg2">
			Select an image from the list and click "Edit Image" on the right<!--   <button id="wpbeautify_edit_meme" class="btn btn-success" disabled="disabled" style="text-align:center"> Create Meme</button> --><br/>
		</p>
  		<div id="wpbeautify_meme_results" class="social_image_results" data-site-type="meme"></div>

  </div>
  <div class="tab-pane" id="wpbtfy-src-facebook">
<!--      	<p style="padding:30px">
  		Select an image from your Facebook Albums
  	</p>  -->
  	<p class="centered_panel social_panel_info" id="facebook_panel_info"><button type="button" class="btn btn-success" id="wpbeautify_facebook_browse_albums"><i class="fa fa-folder-o"></i> Click here</button> to browse your Facebook albums</p>
  		<div id="wpbeautify_facebook_albumname" class="wpbeautify_album_name"></div>

  		<div id="wpbeautify_facebook_results" class="social_image_results" data-site-type="facebook"></div>

  	<p style="padding:30px">
		<?php
		/*$albums = wpbeautify_fb_get_albums(1);*/
		// var_dump($albums);
		?>
	</p>
  </div>
  <div class="tab-pane" id="wpbtfy-src-instagram">

  	<p class="centered_panel social_panel_info" id="instagram_panel_info"><button type="button" class="btn btn-success" id="wpbeautify_instagram_browse_pics"><i class="fa fa-folder-o"></i> Click here</button> to browse your Instagram Photos</p>

  		<div id="wpbeautify_instagram_results" class="social_image_results" data-site-type="instagram"></div>


  </div>
  <div class="tab-pane" id="wpbtfy-src-pinterest">

  	<p class="centered_panel social_panel_info" id="pinterest_panel_info"><button type="button" class="btn btn-success" id="wpbeautify_pinterest_browse_albums"><i class="fa fa-folder-o"></i> Click here</button> to browse your Pinterest Pins</p>
  		<div id="wpbeautify_pinterest_albumname" class="wpbeautify_album_name"></div>

  		<div id="wpbeautify_pinterest_results" class="social_image_results" data-site-type="pinterest"></div>

		<?php /*wpbeautify_print_pinterest_images();*/?>
  </div>
  <div class="tab-pane" id="wpbtfy-src-flickr">
<!--    	<p style="padding:30px">
		Select an image from your Flickr Albums
	</p>  -->
	<p class="centered_panel social_panel_info" id="flickr_panel_info"><button type="button" class="btn btn-success" id="wpbeautify_flickr_browse_albums"><i class="fa fa-folder-o"></i> Click here</button> to browse your Flickr albums</p>
  		<div id="wpbeautify_flickr_albumname" class="wpbeautify_album_name"></div>
			<div id="wpbeautify_flickr_results" class="social_image_results" data-site-type="flickr"></div>
  </div>
  <div class="tab-pane" id="wpbtfy-src-googleplus">
<!--      	<p style="padding:30px">
  		Select an image from your Google + / Picasa Albums
  	</p>  -->
  	<p class="centered_panel social_panel_info" id="googleplus_panel_info">
    <?php  if ( isset( $image_settings['social_sites']['googledrive']['api_key'] ) && !empty( $image_settings['social_sites']['googledrive']['api_key'] ) ) { ?>
      <button type="button" class="btn btn-success" id="wpbtfy_gdrive_pick"><i class="fa fa-folder-o"></i> Click here</button> to browse your Google Drive albums
      <?php } else { ?>
        You need to enter your Google Drive Api Key and Client ID. Please go to FotoPress > Images to configure this first.
      <?php } ?>
      <div id="wpbeautify_googledrive_loading" class="wpbeautify-loading"></div>
    <canvas id="wpbtfy-drive-test-canvas"  style="display:none" />
    </canvas>
    <img id="wpbtfy-drive-test" style="display:none"/>

      </p> <!-- wpbeautify_googleplus_browse_albums -->
  		<!-- <div id="wpbeautify_googleplus_albumname" class="wpbeautify_album_name"></div> -->
  		<div id="wpbeautify_googledrive_results" class="social_image_results" data-site-type="googleplus"></div>

  </div>

    <div class="tab-pane" id="wpbtfy-src-background">
<br/><br/>
              <div class="well" style="width:300px;margin:0 auto;">
                  <div class="form-group">
                    <label for="text-field">Background Color</label>
                          <div class="input-group">
                      <input type="text" id="simple-bg-color" class="form-control wpbtfy-colorpicker" value="#ffffff">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="text-field">Image Size</label>
                          <div class="input-group">
                          <?php wpbtfy_predefined_image_sizes_select('wpbeautify_plainbg'); ?>
                    </div>
                  </div>

                  <div class="form-group">
                          <div class="input-group">
                            <button class="btn btn-success" id="simple-bg-color-select">Select</button>
                    </div>
                  </div>

              </div>
    </div>

</div> <!-- wpbtfy-tabs-img-sites-content -->
</div>


</div>
<!-- 		<button id="wpbeautify_imagesel_upload" class="btn"> Upload Image</button>
		<button id="wpbeautify_imagesel_wp" class="btn add-media"> WP Images</button>
		<button id="wpbeautify_imagesel_url" class="btn"> Enter URL</button>
		<button id="wpbeautify_imagesel_free" class="btn"> Search Free Images</button>
		<button id="wpbeautify_imagesel_facebook" class="btn"> Facebook</button>
		<button id="wpbeautify_imagesel_instagram" class="btn"> Instagram</button>
		<button id="wpbeautify_imagesel_flickr" class="btn"> Flickr</button>
		<button id="wpbeautify_imagesel_google+" class="btn"> Google +</button>

		<br/>
		<div id="wpbeautify_selimg_upload" class="wpbtfy_selimg_method">
		</div>

		<div id="wpbeautify_selimg_url" class="wpbtfy_selimg_method" style="display:none">

		</div>
 -->
		<?php
			$image_settings = wpbeautify_get_image_settings();
			$dropbox_key = $image_settings['social_sites']['dropbox']['app_id'];
			if (!$dropbox_key) $dropbox_key = '';
		?>

		<script type="text/javascript" src="https://www.dropbox.com/static/api/2/dropins.js" id="dropboxjs" data-app-key="<?php echo $dropbox_key; ?>"></script>

		<div id="dropbox_chooser_1"></div>
	</div> <!-- tab 1 -->

	<div class="tab-pane" id="image-editor">
		<br/>
		<div class="row">
			<div class="col-md-3" id="wpbeautify_sidebar">
				<div class="wpbtfy-left-panel" id="wpbtfy-panel-general">
					<p>On the right, you will find different buttons to edit your image </p>
				</div>
				<div class="wpbtfy-left-panel" id="wpbtfy-panel-crop" style="display:none">
					<p> Select the part of the image to crop and click the button below</p>
          <p style="text-align:center">
					<button type="button" class="btn btn-primary" id="wpbtfy-button-start-crop"> <span class="glyphicon glyphicon-ok"></span> Start Crop</button>
          <button type="button" class="btn btn-success" id="wpbtfy-button-do-crop" style="display:none"> <i class="fa fa-scissors"></i> Crop</button>
					<button type="button" class="btn btn-danger" id="wpbtfy-button-cancel-crop" style="display:none"> <span class="glyphicon glyphicon-remove"></span> Cancel</button>
          </p>
					<br/><br/>
          Standard Image Sizes<br/>
           <div class="input-group input-group-sm col-xs-8">
           <?php wpbtfy_predefined_image_sizes_select('wpbeautify_img_predefined_crop'); ?>
          </div><br/>
										New height<br/>
										 <div class="input-group input-group-sm col-xs-8">
					  <input id="img-new-height-crop" type="text" class="form-control" value="" disabled="disabled">
					  <span class="input-group-addon">px</span>
					</div><br/><br/>
										New width<br/>
										 	<div class="input-group input-group-sm col-xs-8">
					  <input id="img-new-width-crop" type="text" class="form-control" value="" disabled="disabled">
					  <span class="input-group-addon">px</span>
					</div>

<!--  x <input id="img-tx" type="text"  value=""><br/>
 left <input id="img-tleft" type="text"  value=""><br/>
					<input type="button" id="hacer-test" value="aqui"> -->
				</div>
				<div class="wpbtfy-left-panel" id="wpbtfy-panel-resize" style="display:none">
					<b>Original height:</b> <span id="img-original-height"></span> px<br/>
					<b>Original width:</b> <span id="img-original-width"></span> px<br/><br/>

					<button type="button" class="btn btn-primary btn-sm" id="wpbtfy-button-restore-size"> <span class="glyphicon glyphicon-chevron-left"></span> Restore original size</button><br/><br/>

          Standard Image Sizes<br/>
           <div class="input-group input-group-sm col-xs-8">
           <?php wpbtfy_predefined_image_sizes_select('wpbeautify_img_predefined_resize'); ?>
          </div><br/>

					New height<br/>
					 <div class="input-group input-group-sm col-xs-8">
					  <input id="img-new-height" type="text" class="form-control numbersOnlyw">
					  <span class="input-group-addon">px</span>
					</div><br/>
										New width<br/>
										 	<div class="input-group input-group-sm col-xs-8">
					  <input id="img-new-width" type="text" class="form-control numbersOnlyw">
					  <span class="input-group-addon">px</span>
					</div>
					<br/><br/>

					<br/>
										<div style="display:block"><input id="image-size-slider-vert" type="text" data-slider-min="-200" data-slider-max="200" data-slider-step="10" data-slider-value="0" data-slider-orientation="vertical" /></div>
										<div style="padding-left:15px"><input  id="image-size-slider-hor" type="text" data-slider-min="-200" data-slider-max="200" data-slider-step="10" data-slider-value="0" data-slider-orientation="horizontal" style="width:100%" /></div>
					<div class="checkbox">
					  <label>
					    <input type="checkbox" value="1" checked id="wpbeautify_resize_keep_proportion">
					   Keep original proportion
					  </label>
					</div>

					<button type="button" class="btn btn-primary btn-sm" id="wpbtfy-button-flip-horizontal" style="margin-bottom: 20px"> <i class="fa fa-arrows-h"></i> Flip horizontally</button>
					<button type="button" class="btn btn-primary btn-sm" id="wpbtfy-button-flip-vertical" style="margin-bottom: 20px"> <i class="fa fa-arrows-v"></i> Flip vertically</button>

				</div>
				<div class="wpbtfy-left-panel" id="wpbtfy-panel-predefined-effects" style="display:none">

					<?php wpbeautify_auto_effects_panel();?>


				</div>
				<div class="wpbtfy-left-panel" id="wpbtfy-panel-manual-effects" style="display:none">
					<button type="button" class="btn btn-sm btn-info wpbeautify_restore_original_img" >Restore Original</button> <br/>
					<BR/>
					<?php wpbeautify_manual_effects_panel();?>
<!--					Brightness <input class="manual-effect-filter" id="man-brightness-filter" data-effect="brightness" type="text" data-slider-min="-100" data-slider-max="100" data-slider-step="1" data-slider-value="0" />
					Contrast <input class="manual-effect-filter" id="man-contrast-filter" data-effect="contrast" type="text" data-slider-min="-100" data-slider-max="100" data-slider-step="1" data-slider-value="0" />
-->

				</div>
				<div class="wpbtfy-left-panel" id="wpbtfy-panel-add-border" style="display:none">
				<div class="well">

						<div class="form-group">
							<label for="text-field">Border color</label>
            				<div class="input-group">
								<input type="text" id="border-color" class="form-control wpbtfy-colorpicker" value="#ff0000">
							</div>
						</div>

						<div class="form-group">
						    <div class="row">
						        <div class="col-lg-8">
									<label for="text-field">Border Width</label>
						            <div class="input-group">
						                <input type="text" class="form-control wpbtfy-spinner" id="wpbeautify_border_width" value="5" />
						            </div>
						        </div>
						    </div>
						</div>

						<div class="form-group">
							<label for="text-field">Border style</label>
            				<div class="input-group">
								<select class="form-control" id="wpbeautify_border_style">
									<option value="normal">Normal</option>
									<option value="dotted">· · · · · ·</option>
									<option value="dashed">- - - - - - </option>
									<option value="dashed2">-- -- --</option>
									<option value="dashed3">--- --- ---</option>
									<option value="mixed"> - · - · - · </option>
								</select>
							</div>
						</div>
          <button type="button" class="btn btn-primary" id="wpbtfy-button-do-border"> <span class="glyphicon glyphicon-ok"></span> Apply</button>

				</div>
					<button type="button" class="btn btn-danger" id="wpbtfy-button-remove-border"> <span class="glyphicon glyphicon-remove"></span> Remove border</button>


				</div>
				<div class="wpbtfy-left-panel" id="wpbtfy-panel-add-text" style="display:none">

					<div class="wpbeautify_current_texts" id="wpbeautify_current_texts">

					</div>
					<button type="button" class="btn btn-primary" id="wpbtfy-button-add-text"> <span class="glyphicon glyphicon-plus"></span> Add Text</button>

				</div>

        <div class="wpbtfy-left-panel" id="wpbtfy-panel-add-image" style="display:none">
          <h6 style="display:inline-block">Image Search</h6>
          <button type="button" class="btn btn-sm btn-primary pull-right" id="wpbtfy-image-layer-insert-image" disabled="disabled"><i class="fa fa-share"></i> Insert Image</button>
          <div class="form-group" style="display:inline">
            <div class="input-group">
              <input type="text" class="form-control" id="wpbtfy-search-layer-imgs-keyword" placeholder="Enter search term">
              <span class="input-group-btn">
                <button type="button" class="btn btn-info" id="wpbtfy-image-layer-do-search"><span class="glyphicon glyphicon-search"></span></button>
              </span>
              </div>
            </div>

          <div id="wpbtfy_free_imgs_layer_div">

          </div>
            Or <button class="btn btn-sm add-media btn-success" id="wpbeautify_imagesel_wp2"> Click here</button> to upload your own image
        </div>

				<div class="wpbtfy-left-panel form-horizontal" id="wpbtfy-panel-add-shape" style="display:none">
					<p> Tip: you can set the shape transparency by editing the "Fill" field</p>
					<!-- <p> Press Space while drawing to move the shape</p> -->
					<div class="well">


					<div class="form-group">
						<label for="" class="col-sm-3 control-label">Shape</label>
						<div class="col-sm-9">
							<select id="wpbeautify-shape-type" class="form-control">
								<option value="rectangle">Rectangle</option>
								<option value="rectangle-round">Rectangle (round)</option>
								<option value="circle">Circle</option>
								<option value="ellipse">Ellipse</option>
								<option value="line">Line</option>

								<!--<option value="Polygon">Triangle</option>
								<option value="arc">Arc</option>
								<option value="wedge">Wedge</option>
								<option value="ring">Ring</option>
								-->
								<option value="star">Star</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="text-field" class="col-sm-3 control-label">Line</label>
        				<div class="col-sm-9">
							<input type="text" id="shape-line-color" class="form-control wpbtfy-colorpicker" value="#ff0000">
						</div>
					</div>

					<div class="form-group">
						<label for="text-field" class="col-sm-3 control-label">Fill</label>
        				<div class="col-sm-9">
							<input type="text" id="shape-fill-color" class="form-control wpbtfy-colorpicker-opacity" value="#ffffff" data-opacity>
						</div>
					</div>

					<div class="form-group">
						<label for="text-field" class="col-sm-3 control-label">Line Width</label>
        				<div class="col-sm-9">
        				    <div class="row">
        				        <div class="col-lg-8">
        				            <div class="input-group">
        				                <input type="text" class="form-control wpbtfy-spinner" id="wpbeautify_shape_border_width" value="5" />
        				            </div>
        				        </div>
        				    </div>
						</div>
					</div>

					<div class="form-group">
						<label for="text-field" class="col-sm-3 control-label">Border style</label>
        				<div class="col-sm-9">
        					<select class="form-control" id="wpbeautify_shape_border_style">
								<option value="normal">Normal</option>
								<option value="dotted">· · · · · ·</option>
								<option value="dashed">- - - - - - </option>
								<option value="dashed2">-- -- --</option>
								<option value="dashed3">--- --- ---</option>
								<option value="mixed"> - · - · - · </option>
							</select>
						</div>
					</div>

							<button type="button" class="btn btn-danger btn-sm" id="wpbtfy-button-remove-shapes"> <span class="glyphicon glyphicon-remove"></span> Delete All</button>
							<button type="button" class="btn btn-info btn-sm" id="wpbtfy-button-start-drawing-shape"> <span class="glyphicon glyphicon-pencil"></span> Start Drawing</button>

							<div class="clear"></div>
					</div>
					<div id="current_shapes">

					</div>

				</div>
				<div class="wpbtfy-left-panel" id="wpbtfy-panel-draw" style="display:none">

				<p>Select line options, click on "Start Drawing" and then use your mouse to paint over the image.</p>
					<div class="well">
							<div class="form-group">
								<label for="text-field">Line color</label>
	            				<div class="input-group">
									<input type="text" id="wpbeautify_freedraw_line_color" class="form-control wpbtfy-colorpicker" value="#ffffff">
								</div>
							</div>

							<div class="form-group">
							    <div class="row">
							        <div class="col-lg-8">
										<label for="text-field">Line Width</label>
							            <div class="input-group">
							                <input type="text" class="form-control wpbtfy-spinner" id="wpbeautify_freedraw_line_width" value="5" />
							            </div>
							        </div>
							    </div>
							</div>


							<button type="button" class="btn btn-danger btn-sm" id="wpbtfy-button-remove-freedraw"> <span class="glyphicon glyphicon-remove"></span> Delete All</button>
							<button type="button" class="btn btn-info btn-sm" id="wpbtfy-button-start-freedraw"> <span class="glyphicon glyphicon-pencil"></span> Start Drawing</button>

							<div class="clear"></div>
					</div>


				</div>

        <div class="wpbtfy-left-panel" id="wpbtfy-panel-layers" style="display:none">
            <b>Layers</b><br/><br/>
            <div id="wpbtfy-layers">
              <!--<div class="wpbtfy-layer" data-layer-id="1">
                <div class="layer-icon">
                  <i class="fa fa-font"></i>
                </div>
                <div class="layer-txt">
                  Lorem Ipsum...
                </div>
                <div class="layer-actions">
                  <i class="fa fa-arrow-down wpbtfy-layer-action wpbtfy-layer-down"></i>
                  <i class="fa fa-arrow-up wpbtfy-layer-action wpbtfy-layer-up"></i>
                  <i class="fa fa-remove wpbtfy-layer-action wpbtfy-layer-remove"></i>
                </div>
                <div class="clear"></div>
              </div>-->
            </div> <!-- layers -->

        </div>


			</div>
			<div class="col-md-9" id="wpbeautify_mainbody">
				<div class="image-toolbox-bar">
					<button type="button" class="btn btn-default btn-sm" id="wpbtfy-button-crop"> <i class="fa fa-crop"></i> Crop</button>
					<button type="button" class="btn btn-default btn-sm" id="wpbtfy-button-resize"> <span class="glyphicon glyphicon-resize-full"></span> Resize</button>
					<button type="button" class="btn btn-default btn-sm" id="wpbtfy-button-effects-predefined"> <span class="glyphicon glyphicon-th"></span> Effects </button>
					<button type="button" class="btn btn-default btn-sm" id="wpbtfy-button-effects-manual"> <span class="glyphicon glyphicon-cog"></span> Effects (manual) </button>
					<button type="button" class="btn btn-default btn-sm" id="wpbtfy-button-border"> <i class="fa fa-square-o"></i> Border </button>
          <button type="button" class="btn btn-default btn-sm" id="wpbtfy-button-text"> <span class="glyphicon glyphicon-font"></span> Text </button>
					<button type="button" class="btn btn-default btn-sm" id="wpbtfy-button-newimage"> <span class="glyphicon glyphicon-picture"></span> Image </button>
					<button type="button" class="btn btn-default btn-sm" id="wpbtfy-button-shapes"> <span class="glyphicon glyphicon-stop"></span> Add Shape </button>
          <button type="button" class="btn btn-default btn-sm" id="wpbtfy-button-draw"> <span class="glyphicon glyphicon-pencil"></span> Draw </button>
					<button type="button" class="btn btn-default btn-sm" id="wpbtfy-button-layers"> <span class="fa fa-bars"></span> Layers </button>
				</div>
				<div id="wpbeautify-stage">
				</div>
			</div>
		</div>
	</div>
</div> <!-- tab content -->


</div>
	<!-- right side -->
	<div class="col-md-2 col-sm-4" id="wpbeautify_right_sidebar" style="display:none">
  <div class="wpb-inner-rel">
  <div class="wpb-inner-scroll">
		<h4>Image Information</h4>
		<div class="attachment-info">
			<div class="thumbnail-2">

					<img id="wpbeautify_preview_img" src="" style="" />

			</div>
			<div class="details">
				<div class="filename"></div>
				<!--<div class="uploaded">January 31, 2013</div>-->
						<div id="wpbeautify_img_dimensions" class="dimensions"></div>
						<div id="wpbeautify_img_source" class="dimensions"><a target="_blank" title="View Original Image" id="wpbeautify_img_source_link" href="#"></a></div>
						<div id="wpbeautify_img_name" class="dimensions"></div>
				<div class="compat-meta">

				</div>
			</div>
			<div style="clear:both"></div>
			<div><span id="wpbeautify_needs_attribution" style="display:none">Image needs Attribution!</span></div>
		</div>
		<p style="text-align:center">
			<button  id="btn-edit-image-main" class="btn btn-success btn-sm wpbeautify_edit_img" style="text-align:center;display:none"><i class="fa fa-edit"></i>  Edit Image</button><br/> <!-- display:none; -->
		</p>
		<div>

		<div role="form">
		  <div class="form-group">
		    <label for="wpbeautify_file_name">File name</label>
		    <div class="input-group">
		      <input type="text" class="form-control input-sm" id="wpbeautify_file_name" value="">
		      <span class="input-group-addon" id="wpbeautify_file_extension">.jpg</span>
		    </div>
		  </div>

		  <div class="form-group">
		    <label for="wpbeautify_img_title">Title</label>
		    <input type="text" class="form-control input-sm" id="wpbeautify_img_title" placeholder="Enter image title">
		  </div>

		  <div class="form-group">
		    <label for="wpbeautify_img_caption">Caption</label>
		    <textarea class="form-control input-sm" id="wpbeautify_img_caption" placeholder=""></textarea>
		  </div>

		  <div class="form-group">
		    <label for="wpbeautify_img_alt">Alt text</label>
		    <input type="text" class="form-control input-sm" id="wpbeautify_img_alt" placeholder="Enter image alt text">
		  </div>

		  <div class="form-group">
		    <label for="wpbeautify_img_description">Description</label>
		    <textarea class="form-control input-sm" id="wpbeautify_img_description" placeholder=""></textarea>
		  </div>
  <?php if ( ckala_is_pro() ) { ?>

		  <div class="checkbox">
		      <label>
		        <input type="checkbox" id="wpbeautify_img_watermark"> Apply watermark
		      </label>
		    </div>
		</div>
  <?php } ?>
		<div role="form">
		  <div class="form-group">
		    <label for="exampleInputEmail1">Alignment</label>
		    <select data-user-setting="align" data-setting="align" class="alignment form-control input-sm" id="wpbeautify_img_alignment">

		    	<option value="left">
		    		Left					</option>
		    	<option value="center">
		    		Center					</option>
		    	<option value="right">
		    		Right					</option>
		    	<option selected="" value="none">
		    		None					</option>
		    </select>
		  </div>

		  <div class="form-group">
		    <label for="exampleInputEmail1">Link to</label>
		    <select data-user-setting="urlbutton" data-setting="link" class="link-to form-control input-sm" id="wpbeautify_link_to">

		    	<option value="custom">
		    		Custom URL					</option>
		    	<option selected="" value="file">
		    		Media File					</option>
		    	<option value="post">
		    		Attachment Page					</option>
		    	<option value="none">
		    		None					</option>
		    </select>
		    <input type="text" data-setting="linkUrl" class="form-control link-to-custom input-sm" readonly="" id="wpbeautify_link_to_url">
		  </div>

		  <div class="form-group">
		    <label for="exampleInputEmail1">Image Size</label>
		    <select data-user-setting="imgsize" data-setting="size" name="wpbeautify_image_size" id="wpbeautify_image_size" class="size form-control input-sm">

		    			<option value="thumbnail">
		    				Thumbnail - 150 x 150
		    			</option>
		    			<option value="medium">
		    				Medium
		    			</option>
		    			<option selected="selected" value="full">
		    				Full Size
		    			</option>

		    					</select>
		  </div>

		</div>

		</div>

    </div> <!-- inner rel -->
    </div> <!-- inner for scroll -->
	</div>
	<!-- / right side -->

      </div> <!-- modal body -->
      <!-- <div class="modal-footer"> -->

        <!-- <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button> -->
      <!-- </div> -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div><!-- /.modal -->
<?php
}


function wpbeautify_admin_scripts_image() {
  global $wpbtfy_social_sizes;
	wp_register_script( 'wpbeautify_admin_js', WPBEAUTIFY_URL . '/js/wpbeautify-admin.js', array('jquery'), WPBEAUTIFY_VERSION);
	wp_enqueue_script( 'wpbeautify_admin_js');

// var_dump( wpbeautify_get_current_fonts_array());
// wp_die();
  if (ckala_is_pro())
    $google_enabled_fonts = wpbeautify_get_current_fonts_array();
  else
    $google_enabled_fonts = array(
      'Alex Brush',
      'Abril Fatface',
      'Amaranth',
      'Bevan',
      'Covered By Your Grace',
      'Fjord',
      'Gravitas One',
      'Indie Flower',
      'Josefin Sans',
      'Jura',
      'League Gothic',
      'Lobster',
      'Merriweather',
      'Montserrat',
      'Playfair Display',
      'Signika',
      'Shadows Into Light',
      'Pacifico'
      );


  wp_dequeue_script('toggles');
  wp_dequeue_script('chart');

  $image_settings = wpbeautify_get_image_settings();
  $wpbeautify_sites = $image_settings['image_sites'];

  // 'details' => array('api_key' => '', 'validapi' => ''
  if ( empty( $wpbeautify_sites['flickr']['details']['api_key'] ) || ( $wpbeautify_sites['flickr']['details']['validapi'] != 1 ) )
    $flickr_msg = '<p  style="text-align:center;padding-top:10px">If you would like to get even more image results, make sure  to request a free API Key from Flickr. More info 
    <a target="_blank" href="http://www.wpbeautify.com/imnews/flickr-faq-info">here</a>.</p>';
  else
    $flickr_msg = '';
  if( !ckala_is_pro() )
    $pro_msg = '<p style="width: 50%;margin: 0 auto;text-align:center ">Need more Images? Upgrade to <a style="text-decoration:underline;font-weight:bold" href="http://wpfotopress.com/sales/oto1.html" target="_blank">FotoPress Pro</a> to get 10 Image Sources, Import Images from Social Networks; Dropbox/Google Drive Integration plus many other cool features! <a style="text-decoration:underline" href="http://wpfotopress.com/sales/oto1.html" target="_blank">Click here to get it</a> </p>';
  else
    $pro_msg = '';
	wp_localize_script( 'wpbeautify_admin_js', 'wpbeautify_vars',
    array(
      'admin_url' => admin_url(),
      'wpbeautify_plugin_url' => WPBEAUTIFY_URL,
      'google_fonts' => $google_enabled_fonts,
      'image_sizes' => $wpbtfy_social_sizes,
      'noflickr' => '<p style="text-align:center;padding-top:40px">Choose from thousands of Royalty Free Images</p>'.$flickr_msg.$pro_msg
      ) );

	wp_register_script( 'wpbeautify_imageeditor_js', WPBEAUTIFY_URL . '/js/wpbeautify-image-editor.js', array('jquery'), WPBEAUTIFY_VERSION);
	wp_enqueue_script( 'wpbeautify_imageeditor_js');

  if (!wp_script_is('vc_bootstrap_js')) {
	 wp_register_script( 'wpbeautify_bootstrap_js', WPBEAUTIFY_URL . '/assets/ui/js/bootstrap.min.js', array('jquery'), WPBEAUTIFY_VERSION);
	 wp_enqueue_script( 'wpbeautify_bootstrap_js');
  }

	wp_register_script( 'wpbeautify_bootstrap_switch_js', WPBEAUTIFY_URL . '/assets/ui/js/bootstrap-switch.min.js', array('jquery'), WPBEAUTIFY_VERSION);
	wp_enqueue_script( 'wpbeautify_bootstrap_switch_js');

	wp_register_script( 'wpbeautify_bootstrap_slider_js', WPBEAUTIFY_URL . '/assets/ui/js/bootstrap-slider.min.js', array('jquery'), WPBEAUTIFY_VERSION);
	wp_enqueue_script( 'wpbeautify_bootstrap_slider_js');

	wp_register_script( 'wpbeautify_bootstrap_select_js', WPBEAUTIFY_URL . '/assets/ui/js/bootstrap-multiselect.js', array('jquery'), WPBEAUTIFY_VERSION);
	wp_enqueue_script( 'wpbeautify_bootstrap_select_js');

	wp_register_script( 'wpbeautify_bootstrap_minicolors_js', WPBEAUTIFY_URL . '/assets/ui/js/jquery.minicolors.min.js', array('jquery'), WPBEAUTIFY_VERSION);
	wp_enqueue_script( 'wpbeautify_bootstrap_minicolors_js');

	wp_register_script( 'wpbeautify_jquery_modal', WPBEAUTIFY_URL . '/assets/ui/js/jquery.modal.js', array('jquery'), WPBEAUTIFY_VERSION);
	wp_enqueue_script( 'wpbeautify_jquery_modal');

	wp_register_script( 'wpbeautify_bootstrap_spinedit_js', WPBEAUTIFY_URL . '/assets/ui/js/bootstrap-spinedit.js', array('jquery'), WPBEAUTIFY_VERSION);
	wp_enqueue_script( 'wpbeautify_bootstrap_spinedit_js');

  // wp_register_script( 'wpbeautify_kineticjs_js', WPBEAUTIFY_URL . '/js/kinetic-v5.0.1.min.js');gt
	// wp_register_script( 'wpbeautify_kineticjs_js', WPBEAUTIFY_URL . '/js/kinetic-v5.1.0.min.js', array('jquery'), WPBEAUTIFY_VERSION);
	// wp_enqueue_script( 'wpbeautify_kineticjs_js');

  wp_register_script( 'wpbeautify_konva_js', WPBEAUTIFY_URL . '/js/konva.min.js', array('jquery'), WPBEAUTIFY_VERSION);
  wp_enqueue_script( 'wpbeautify_konva_js');


	wp_register_script( 'wpbeautify_jsmanipulate_js', WPBEAUTIFY_URL . '/js/jquery.jsmanipulate.comb.min.js', array('jquery'), WPBEAUTIFY_VERSION);
	wp_enqueue_script( 'wpbeautify_jsmanipulate_js');


	// wp_enqueue_script( 'jquery-ui-dialog' );
}


function wpbeautify_admin_style_image() {
	wp_register_style('wpbeautify_admin_style', WPBEAUTIFY_URL . '/css/wpbeautify-admin.css', array(), WPBEAUTIFY_VERSION);
  	wp_enqueue_style('wpbeautify_admin_style');

	wp_register_style('wpbeautify_bootstrap_css', WPBEAUTIFY_URL . '/assets/ui/css/bootstrap-wpadmin.css', array(), WPBEAUTIFY_VERSION);
  	wp_enqueue_style('wpbeautify_bootstrap_css');

	wp_register_style('wpbeautify_bootstrap_switch_css', WPBEAUTIFY_URL . '/assets/ui/css/bootstrap-switch.min.css', array(), WPBEAUTIFY_VERSION);
  	wp_enqueue_style('wpbeautify_bootstrap_switch_css');

	wp_register_style('wpbeautify_bootstrap_slider_css', WPBEAUTIFY_URL . '/assets/ui/css/bootstrap-slider.min.css', array(), WPBEAUTIFY_VERSION);
  	wp_enqueue_style('wpbeautify_bootstrap_slider_css');

	wp_register_style('wpbeautify_bootstrap_select_css', WPBEAUTIFY_URL . '/assets/ui/css/bootstrap-multiselect.css', array(), WPBEAUTIFY_VERSION);
  	wp_enqueue_style('wpbeautify_bootstrap_select_css');

	wp_register_style('wpbeautify_bootstrap_minicolors_css', WPBEAUTIFY_URL . '/assets/ui/css/jquery.minicolors.css', array(), WPBEAUTIFY_VERSION);
  	wp_enqueue_style('wpbeautify_bootstrap_minicolors_css');

	wp_register_style('wpbeautify_bootstrap_spinedit_css', WPBEAUTIFY_URL . '/assets/ui/css/bootstrap-spinedit.css', array(), WPBEAUTIFY_VERSION);
  	wp_enqueue_style('wpbeautify_bootstrap_spinedit_css');

	wp_register_style('wpbeautify_font_awesome_css', '//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css', array(), WPBEAUTIFY_VERSION);
  	wp_enqueue_style('wpbeautify_font_awesome_css');

}
/*
add_action('admin_footer', function()
{
    ?>
    <script type="text/javascript">
        // or without jQuery: http://stackoverflow.com/q/799981
        jQuery(document).ready( function($) {
            _wpMediaViewsL10n.insertIntoPost = 'Gotchya!';
        });
    </script>
    <?php
});*/


// include js
/*add_action('admin_enqueue_scripts', function($page){

  // check if this your page here with the upload form!
  if(($page !== 'post.php') || (get_post_type() !== 'post'))
    return;

  wp_enqueue_script('plupload-all');
});
*/


// so here's the actual uploader
// most of the code comes from media.php and handlers.js
function wpbeautify_upload_box(){ ?>
   <div id="wpbtfy-plupload-upload-ui" class="hide-if-no-js" style="max-width: 440px;margin-top:25px;margin-left:auto;margin-right:auto">
     <div id="wpbeautify-drag-drop-area">
       <div class="drag-drop-inside" style="margin-top:45px">
        <p class="drag-drop-info"><?php _e('Drop file here'); ?></p>
        <p><?php _ex('or', 'Uploader: Drop image here - or - Select File'); ?></p>
        <p class="drag-drop-buttons"><input id="wpbtfy-plupload-browse-button" type="button" value="<?php esc_attr_e('Select Files'); ?>" class="btn btn-success" /></p>
      </div>
     </div>
     <div id="wpbeautify-uploader-progress" style="display:none">
	     <div class="progress progress-striped active">
	       <div id="wpbeautify-upload-progressbar" class="progress-bar"  role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
	        60%
	       </div>
	     </div>
     </div>
     <br/>
     <div id="wpbeautify-uploader-info" style="display:none">
     	<div class="alert alert-success"> <span class="glyphicon glyphicon-ok"></span> File uploaded  &nbsp;&nbsp;&nbsp;<button class="btn btn-success wpbeautify_edit_img_uploaded" style="text-align:center"> <span class="glyphicon glyphicon-pencil"></span> Edit Image</button></div>
     </div>
  </div>

  <?php

  $plupload_init = array(
    'runtimes'            => 'html5,silverlight,flash,html4',
    'browse_button'       => 'wpbtfy-plupload-browse-button',
    'container'           => 'wpbtfy-plupload-upload-ui',
    'drop_element'        => 'wpbeautify-drag-drop-area',
    'file_data_name'      => 'async-upload',
    'multiple_queues'     => true,
    'max_file_size'       => wp_max_upload_size().'b',
    'url'                 => admin_url('admin-ajax.php'),
    'flash_swf_url'       => includes_url('js/plupload/plupload.flash.swf'),
    'silverlight_xap_url' => includes_url('js/plupload/plupload.silverlight.xap'),
    'filters'             => array(array('title' => __('Allowed Files'), 'extensions' => '*'), 'max_file_size' => wp_max_upload_size().'b'),
    'multipart'           => true,
    'urlstream_upload'    => true,

    // additional post data to send to our ajax hook
    'multipart_params'    => array(
      '_ajax_nonce' => wp_create_nonce('wpbeautify-upload'),
      'action'      => 'wpbeautify_gallery_upload',            // the ajax action name
    ),
  );

  // we should probably not apply this filter, plugins may expect wp's media uploader...
  $plupload_init = apply_filters('plupload_init', $plupload_init); ?>

  <script type="text/javascript">

    jQuery(document).ready(function($){

      // create the uploader and pass the config from above
      var uploader = new plupload.Uploader(<?php echo json_encode($plupload_init); ?>);

      // checks if browser supports drag and drop upload, makes some css adjustments if necessary
      uploader.bind('Init', function(up){
        var uploaddiv = $('#wpbtfy-plupload-upload-ui');

        if(up.features.dragdrop){
          uploaddiv.addClass('drag-drop');
            $('#wpbeautify-drag-drop-area')
              .bind('dragover.wp-uploader', function(){ uploaddiv.addClass('drag-over'); })
              .bind('dragleave.wp-uploader, drop.wp-uploader', function(){ uploaddiv.removeClass('drag-over'); });

        }else{
          uploaddiv.removeClass('drag-drop');
          $('#wpbeautify-drag-drop-area').unbind('.wp-uploader');

        }
      });

      uploader.init();

      // a file was added in the queue
      uploader.bind('FilesAdded', function(up, files){
        var hundredmb = 100 * 1024 * 1024, max = parseInt(up.settings.max_file_size, 10);
        jQuery('#wpbeautify-drag-drop-area').hide();
        plupload.each(files, function(file){
          if (max > hundredmb && file.size > hundredmb && up.runtime != 'html5'){
            // file size error?

          }else{

            // a file was added, you may want to update your DOM here...
             // console.log(file);


          }
			   jQuery('#btn-edit-image-main').show();
         wpbeautify_enable_actions(1);

        });

        up.refresh();
        up.start();
      });

      // a file was uploaded
      uploader.bind('FileUploaded', function(up, file, response) {

        // this is your ajax response, update the DOM with it or something...
         // console.log(file);
         wpbeautify_img_just_selected = response.response;
        jQuery('#wpbeautify_preview_img').attr('src', response.response)

        file_name = wpbeautify_get_file_name_from_url(response.response);
        jQuery('#wpbeautify_file_name').val(file_name[0]);
        jQuery('#wpbeautify_img_title').val(file_name[0]);

        jQuery('#wpbeautify_file_extension').html('.'+file_name[1]);

        jQuery('#wpbeautify_file_extension').html('.'+extension);
    	wpbeautify_enable_editor()
    	wpbeautify_set_up_stage(response.response);
    	jQuery('#wpbeautify-upload-progressbar').hide();
    	jQuery('#wpbeautify-drag-drop-area').show();
    	jQuery('#wpbeautify-uploader-info').show();

      });

uploader.bind('UploadProgress', function(up, file) {
    var progressBarValue = up.total.percent;
    jQuery('#wpbeautify-upload-progressbar').width(progressBarValue+ "%");
    jQuery('#wpbeautify-upload-progressbar').text(progressBarValue + "%");
});

    });

  </script>
  <?php
}


// handle uploaded file here
add_action('wp_ajax_wpbeautify_gallery_upload', 'wpbeautify_ajax_uploadfile_fn');

function wpbeautify_ajax_uploadfile_fn (){

  check_ajax_referer('wpbeautify-upload');

  // you can use WP's wp_handle_upload() function:
  $file = $_FILES['async-upload'];
  $status = wp_handle_upload($file, array('test_form'=>true, 'action' => 'wpbeautify_gallery_upload'));

  // and output the results or something...
/*  echo 'Uploaded to: '.$status['url'];

  //Adds file as attachment to WordPress
  echo "\n Attachment ID: " .wp_insert_attachment( array(
     'post_mime_type' => $status['type'],
     'post_title' => preg_replace('/\.[^.]+$/', '', basename($file['name'])),
     'post_content' => '',
     'post_status' => 'inherit'
  ), $status['file']);*/
	echo $status['url'];
  exit;
}

function wpbeautify_selurl_box() {
?>
	<div class="row">
	<div class="col-lg-1">
	</div>
	  <div class="col-lg-8">
	    <div class="input-group">
	      <input type="text" class="form-control" placeholder="Enter image url here" id="wpbeautify-image-by-url-url">
	      <span class="input-group-btn">
	        <button class="btn btn-info" type="button" id="wpbeautify-download-image-by-url"><span class="glyphicon glyphicon-download-alt"></span> Download Image</button>
	      </span>
	    </div><!-- /input-group -->
	      <span class="help-block">Ex: http://lorempixel.com/output/nightlife-q-c-640-480-3.jpg</span>

	      <div id="wpbeautify_selurl_loading">


	      </div>
	      <br/>
	      <div id="wpbeautify_selurl_loaded" style="display:none">
	      	<div id="wpbeautify-uploader-info" >
	      		<div class="alert alert-success"> <span class="glyphicon glyphicon-ok"></span> File downloaded!  &nbsp;&nbsp;&nbsp;<button class="btn btn-success wpbeautify_edit_img_uploaded" style="text-align:center"> <span class="glyphicon glyphicon-pencil"></span> Edit Image</button></div>
	      	</div>
	      </div>

	  </div><!-- /.col-lg-6 -->
	  <br/>

	</div><!-- /.row -->

<?php
}


function wpbeautify_freesearch_box() {
?>
<br/>
	<div class="row">
<!-- 	<div class="col-lg-1">
	</div> -->
	  <div class="col-lg-12">
		<div class="form-inline" role="form">
		  <div class="form-group" style="display:inline">
			    <div class="input-group col-xs-4" style="float:left;margin-right:10px">
			      <input type="text" class="form-control" placeholder="Enter search term" id="wpbtfy-search-free-imgs-keyword">
			      <span class="input-group-btn">
			        <button class="btn btn-info" type="button" id="wpbtfy-search-free-imgs-btn"><span class="glyphicon glyphicon-search"></span> Search</button>
			      </span>
			    </div><!-- /input-group -->

		  </div>
		  <div class="form-group">
			<select class="form-control wpbeautify_multiselect" id="wpbeautify_freeimg_type">
			  <option value="any">Any type of image</option>
			  <option value="photo">Photo</option>
			  <option value="clipart">Clipart</option>
			</select>
		  </div>

		    <div class="form-group">
		  	<select class="form-control wpbeautify_multiselect" id="wpbeautify_attribution_required">
		  	  <option value="any">Any attribution</option>
		  	  <option value="attribution">Attribution required</option>
		  	  <option value="noattribution">No Attribution required</option>
		  	</select>
		    </div>

		  <div class="form-group">
		<select class="wpbeautify_multiselect" multiple="multiple" id="wpbeautify_freeimg_sources">
			<?php
			// $all_sites = get_option( 'wpbeautify_image_sites' );
			$image_settings = wpbeautify_get_image_settings();
			$wpbeautify_sites = $image_settings['image_sites'];

			foreach ( $wpbeautify_sites as $site ) {
				//var_dump($site);
				$site_name = $site['name'];

				$isdisabled = ( isset( $site['details']['validapi'] ) && ( $site['details']['validapi'] != 1 ) ) ? ' disabled="disabled" ' : '';
				if ( $isdisabled == '' )
					$ischecked = ( isset( $site['used'] ) && ( $site['used'] != true ) ) ? '' : ' selected ';
				else
					$ischecked = '';
				echo '<option '.$ischecked.$isdisabled.' value="'.$site['id'].'">'.$site_name.'</option>';
				// id="wpbeautify_site_'.$site['id'].'" name="wpbeautify_site"
			}
			?>

		</select>
		  </div>
		<div class="checkbox">
		  <label>
		    <input type="checkbox" value="1" id="only_ok_modify">
		    Images can be modified
		  </label>
		</div>
		<!-- <button class="btn btn-success" type="button" id="wpbtfy-use-free-imgs-btn" disabled="disabled"><span class="glyphicon glyphicon-pencil"></span> Edit</button> -->

		</div>
</div>
	</div><!-- /.row -->

	<div class="row">
		<div id="wpbtfy_free_imgs_div" style="padding: 30px">
			Please enter search term

		</div>
	</div>

<?php
}


// handle uploaded file here
add_action('wp_ajax_wpbeautify_external_upload', 'wpbeautify_ajax_uploadexternal_fn');

function wpbeautify_ajax_uploadexternal_fn (){
	@ini_set( 'max_execution_time', '580' );

  // check_ajax_referer('wpbeautify-upload');

  // you can use WP's wp_handle_upload() function:
  $file = urldecode($_POST['url']);
  if (!$file) return;
// echo $file.'<br/>';
  $force_file_name =   isset($_POST['file_name']) ? $_POST['file_name'] : false;
  $content_sent =   isset($_POST['content_sent']) ? $_POST['content_sent'] : false;

/*
  if ($force_file_name) {
  // var_dump($file);
  // var_dump($cookies);
  $get = wp_remote_get( $file, array( 'headers' => array( 'Authorization' => 'Bearer '.$key ) ) );
}
else*/
// var_dump($file);
if ($force_file_name)
  $tmp_filename = str_replace('%', '-', $force_file_name);
else {
  $tmp_filename = str_replace('%', '-', basename($file));

}
 // var_dump($tmp_filename);

if ($content_sent) {

  if ( !class_exists( 'WP_Http' ) )
    include_once ABSPATH . WPINC. '/class-http.php';

  $image_data =isset($_POST['file_contents']) ? $_POST['file_contents'] : 0;

  // $image_type = isset ($_POST['mimeType'] ) ? $_POST['mimeType'] : 'image/png';

  // if ($image_type == 'image/png')
    $filteredData=substr( $image_data, strpos( $image_data, "," )+1 );

  $unencodedData=base64_decode( $filteredData );

// echo '<img src="'.$image_data.'" /> ';
// echo $tmp_filename;

  $mirror = wp_upload_bits($tmp_filename, null, $unencodedData);
}
else {
  // echo "file = $file - ";
  // echo "fileencoded = ".urlencode($file)." - ";
  // echo "filedecoded = ".urldecode($file)." - ";
 $get = wp_remote_get(esc_url_raw($file), array('timeout' => 65));
 $mirror = wp_upload_bits($tmp_filename, '', wp_remote_retrieve_body($get));
}
// $mirror = wp_upload_bits('testrmi.jpg', '', wp_remote_retrieve_body($get));
// var_dump($get);
echo $mirror['url'];
  // var_dump($mirror['url']);
  // $status = wp_handle_upload($file, array('test_form'=>false));

  // and output the results or something...
/*  echo 'Uploaded to: '.$status['url'];

  //Adds file as attachment to WordPress
  echo "\n Attachment ID: " .wp_insert_attachment( array(
     'post_mime_type' => $status['type'],
     'post_title' => preg_replace('/\.[^.]+$/', '', basename($file['name'])),
     'post_content' => '',
     'post_status' => 'inherit'
  ), $status['file']);*/
	// echo $status['url'];
  exit;
}

function wpbeautify_manual_effects_panel() {
	$wpbeautify_manual_effects = Array(
		Array('Blur', 'blur', 0, 100, 0),
		Array('Brightness', 'brightness', -100, 100, 0),
		Array('Contrast', 'contrast', -100, 100, 0 ),
		Array('Diffusion', 'diffusion', 0, 100, 0),
		Array('Exposure', 'exposure', 0, 100, 20),
		Array('Gamma', 'gamma', -100, 100, 0),
		Array('Hue', 'hue', -100, 100, 0),
		Array('Noise', 'noise', 0, 100, 0),
		Array('Oil Painting', 'oil-painting', 0, 100, 0),
		Array('Opacity', 'opacity', 0, 100, 100),
		Array('Pixelation', 'pixelation', 0, 100, 0),
		Array('Posterize', 'posterize', 0, 100, 0),
		Array('Saturation', 'saturation', -100, 100, 0),
		Array('Vignette', 'vignette', 0, 100, 0),
		Array('Red', 'red', 0, 100, 50),
		Array('Green', 'green', 0, 100, 50),
		Array('Blue', 'blue', 0, 100, 50),
	);
// TO-DO: RGBA
	foreach ($wpbeautify_manual_effects as $effect) {
	?>
	<?php echo $effect[0];?><br/>
  <div class="row" style="margin-left:0"><div class="col-sm-10"><input class="manual-effect-filter" data-effect="<?php echo $effect[1];?>" type="text" data-slider-min="<?php echo $effect[2];?>" data-slider-max="<?php echo $effect[3];?>" data-slider-step="1" data-slider-value="<?php echo $effect[4];?>" data-original-value="<?php echo $effect[4];?>" /></div>
	<div class="col-sm-2" style="padding-left:2px"><button class="btn btn-xs wpbeautify-effect-restore" style="margin-left:12px"><span class="glyphicon glyphicon-repeat"></span></button></div></div>
	<?php
	}
}

function wpbeautify_auto_effects_panel() {
	$wpbeautify_auto_effects = Array(
		Array('Black and White', 'black-and-white', '1bn.jpg'),
		Array('Grayscale', 'grayscale', '2grey.jpg'),
		Array('Sepia', 'sepia', '3sepia.jpg'),
		Array('Bump', 'bump', '4bump.jpg'),
		Array('Circle Smear', 'circle-smear', '5circle.jpg'),
		Array('Edge detection', 'edge-detection', '6edge.jpg'),
		Array('Emboss', 'emboss', '7emboss.jpg'),
		Array('Sawtooth Ripples', 'sawtooth-ripples', '8saw.jpg'),
		Array('Sine Ripples', 'sine-ripples', '9sine.jpg'),
		// Artistic
		Array('1960', '1960', '10a1.jpg'),
		Array('Vintage', 'vintage', '10a2.jpg'),
		Array('Dark', 'sincity', '10a3.jpg'),
		Array('Old School', 'lomo', '10a4.jpg'),
		Array('Reddish', 'love', '10a5.jpg'),
		Array('Sunset', 'sunrise', '10a6.jpg'),
		Array('Grungy', 'grungy', '10a7.jpg'),
		Array('Pinhole', 'pinhole', '10a8.jpg'),
		Array('Lighten up', 'crossprocess', '10a9.jpg'),
		Array('Sharpen', 'clarity', '10a10.jpg')
	);
	$i=0;
	?>
	<button type="button" class="btn btn-sm btn-info wpbeautify_restore_original_img" >Restore Original</button> <br/><br/>
	<?php
	foreach ($wpbeautify_auto_effects as $effect) {
	?>
		<div class="wpbtfy_effect">
			<img class="auto-effect-filter" src="<?php echo WPBEAUTIFY_URL;?>/img/effects/<?php echo $effect[2];?>" data-effect="<?php echo $effect[1];?>" />
			<span><?php echo $effect[0];?></span>
		</div>
	<?php
		if ($i++ == 8) {
			echo '<h4>Artistic</h4>';
		}
	}

}

function wpbeautify_font_family_select($el_name='', $value='', $el_class='', $extra=0) {
	$current_fonts = array(
    array('Arial', 'Arial'),
		array('Comic Sans MS', 'Comic Sans'),
		array('Georgia', 'Georgia'),
		array('Impact', 'Impact'),
		array('Times New Roman', 'Times New Roman'),
		array('Verdana', 'Verdana')
	);

	$str_ret = '<select name="'.$el_name.'" class="'.$el_class.' form-control">';
	if ($extra)
		$str_ret .= '<option value="0">Select font...</option>';

	if ($current_fonts) {
		foreach ($current_fonts as $font) {
			$str_ret .= '<option style="font-family:'.$font[0].'" value="'.$font[0].'" '.selected($font[0], $value, false).'>'.$font[1].'</option>';
		}
	}
	$str_ret .= '</select>';
	return $str_ret;
}

add_action('wp_ajax_wpbeautify_save_image', 'wpbeautify_save_image_fn');

function wpbeautify_save_image_fn() {
	@ini_set( 'max_execution_time', '480' );
	$post_ID = $_POST['post_id'];
	$file_name = empty( $_POST['file_name'] ) ? 'file.jpg' : $_POST['file_name'];
	// var_dump($file_name);
	if ($file_name == '.jpg') $file_name = 'file.jpg';
	else if ($file_name == '.png') $file_name = 'file.png';
	else if ($file_name == '.gif') $file_name = 'file.gif';

	$download = empty( $_POST['download'] ) ? '0' : $_POST['download'];

		$alt_txt = empty( $_POST['image_alt'] ) ? '' : $_POST['image_alt'];
		$title_txt = empty( $_POST['image_title'] ) ? '' : $_POST['image_title'];
		$link_to = isset( $_POST['link_to'] ) ? $_POST['link_to'] : 'file';
		$caption_txt = empty( $_POST['image_caption'] ) ? '' : stripslashes( $_POST['image_caption'] );
		$img_align = isset( $_POST['image_alignment'] ) ? $_POST['image_alignment'] : 'none';
		$image_size = isset( $_POST['image_size'] ) ? $_POST['image_size'] : 'full';

	/*	$alignment_txt = 'align-none';
		$image_size = 'full';*/

		$alignment_txt = 'align'.$img_align;
		$image_size = $image_size;

		$size_txt = 'size-'.$image_size;

		// $selected_image = $_POST['image_url'];
		// $keyword = $_POST['keyword'];

		$ret = wpbeautify_create_image( $post_ID, $file_name );
		if ( !$ret ) exit( 0 );

		// thumbnail, medium, large (large no está en 2011!) TODO, asegurarse que todo va bien
		$uploads = wp_upload_dir();
		$full_size_url = $uploads['baseurl'].'/'.$ret[1]['file'];

		switch ( $image_size ) {
			case 'thumbnail':
			case 'small':
			case 'medium':
			case 'large':
				$img_file_name = $ret[1]['sizes'][$image_size]['file'];
				$img_height = $ret[1]['sizes'][$image_size]['height'];
				$img_width = $ret[1]['sizes'][$image_size]['width'];
				$img_file_name = $uploads['url'].'/'.$img_file_name;
				break;
			default:
				$img_file_name = $full_size_url;
				$img_height = $ret[1]['height'];
				$img_width = $ret[1]['width'];
				break;
		}

		switch ( $link_to ) {
			case 'custom':
				$a_start = '<a href="'.$_POST['link_to_url'].'">';
				$a_end = '</a>';
				break;
			case 'file':
				$a_start = '<a href="'.$full_size_url.'">';
				$a_end = '</a>';
				break;
			case 'post':
				$a_start = '<a href="'.home_url( '/' ).'?attachment_id='.$ret[2].'">';
				$a_end = '</a>';
				break;
			default:
				$a_start = '';
				$a_end = '';
				break;
		}

		if ( !empty ( $caption_txt ) ) {
			$str_ret = '[caption id="attachment_'.$ret[2].'" align="'.$alignment_txt.'" width="'.$img_width.'"]'.
				$a_start.
				'<img src="'.$img_file_name.'" alt="'.$alt_txt.'" width="'.$img_width.'" height="'.$img_height.'" class="'.$size_txt.' wp-image-'.$ret[2].'" />'.
				$a_end.$caption_txt.
				'[/caption]';
		}
		else {
			$str_ret =  $a_start.
				'<img src="'.$img_file_name.'" alt="'.$alt_txt.'" width="'.$img_width.'" height="'.$img_height.'" class="'.$alignment_txt.' '.$size_txt.' wp-image-'.$ret[2].'" />'.
				$a_end;
		}

		if ($download) {
      echo $img_file_name;
			// var_dump( $img_file_name);
		}
		else
			echo $str_ret;
		exit( 0 );
}


function wpbeautify_create_image( $post_ID, $file_name ) {

	$post = get_post( $post_ID );
	if ( empty( $post ) )
		return false;

	if ( !class_exists( 'WP_Http' ) )
		include_once ABSPATH . WPINC. '/class-http.php';

	$image_data =isset($_POST['data']) ? $_POST['data'] : 0;

	$image_type = isset ($_POST['mimeType'] ) ? $_POST['mimeType'] : 'image/png';

	// if ($image_type == 'image/png')
		$filteredData=substr( $image_data, strpos( $image_data, "," )+1 );
	// else
	// 	$filteredData = $image_data;
		//if ($image_type == 'image/jpeg')
		//$filteredData = str_replace(' ','+',$filteredData);

	$unencodedData=base64_decode( $filteredData );

	if (isset($_POST['from_url']) && ($_POST['from_url'] == 1))
		$attachment = wp_upload_bits( $file_name, null, file_get_contents($_POST['image_url']) );
	else
		$attachment = wp_upload_bits( $file_name, null, $unencodedData );

	if ( !empty( $attachment['error'] ) )
		return false;

	$filetype = wp_check_filetype( basename( $attachment['file'] ), null );

	$watermark = isset( $_POST['watermark'] ) ? $_POST['watermark'] : 'false';
	if ($watermark == 'true') $watermark = 1; else $watermark = 0;

	$wp_upload_dir = wp_upload_dir();

	if ($watermark) {
		$file_path = basename( $attachment['file'] );
		$full_path = $wp_upload_dir['path'] . '/' . $file_path;
		wpbeautify_do_watermark($full_path, $filetype['type']);
	}

	$caption_txt = empty( $_POST['image_caption'] ) ? '' : stripslashes( $_POST['image_caption'] );
	$title_txt = empty( $_POST['image_title'] ) ? preg_replace( '/\.[^.]+$/', '', basename( $attachment['file'] ) ) : $_POST['image_title'];
	$description_txt = empty( $_POST['image_description'] ) ? '' : $_POST['image_description'];

	$postinfo = array(
		'guid' => $wp_upload_dir['url'] . '/' . basename( $attachment['file'] ),
		'post_mime_type' => $filetype['type'],
		'post_title'  => $title_txt,
		'post_content'  => $description_txt,
		'post_excerpt'  => $caption_txt,
		'post_status'  => 'inherit'
	);

	$filename = $attachment['file'];
	$attach_id = wp_insert_attachment( $postinfo, $filename, $post_ID );

	if ( !function_exists( 'wp_generate_attachment_data' ) )
		require_once ABSPATH . "wp-admin" . '/includes/image.php';
	$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
	wp_update_attachment_metadata( $attach_id,  $attach_data );

	// TODO: use this??? http://codex.wordpress.org/Function_Reference/media_handle_sideload
	if ( !$attach_data ) return false;
	return array( $attachment['url'], $attach_data, $attach_id, $attachment['file'] );
}

/* WATERMARKING */

function wpbeautify_do_watermark($file_path, $mime_type) {
	if (!$file_path || !$mime_type) return 0;
	$image_settings = wpbeautify_get_image_settings();
	$watermark_settings = $image_settings['watermark'];
	// $watermark_settings = get_option( 'wpbeautify_watermark_settings');

	$image = wpbeautify_get_image_resource($file_path, $mime_type);
	if (!$image) return;
	if (!$watermark_settings) return;
	if ($watermark_settings['watermark_type'] == 'image') {
		// Load the stamp and the photo to apply the watermark to

		//$image = wpbeautify_do_image_watermark($image, $file_path, $watermark_settings);
	    list($source_width, $source_height, $source_type) = getimagesize($file_path);

	    if ($source_type === NULL) {
	        return false;
	    }
		$filetype = wp_check_filetype( $watermark_settings['watermark_image_url'] , null );
		if (!$filetype) return;
		$overlay_gd_image = wpbeautify_get_image_resource ($watermark_settings['watermark_image_url'], $filetype['type']);
	    // $overlay_gd_image = imagecreatefrompng($watermark_settings['watermark_image_url']);
	    $overlay_width = imagesx($overlay_gd_image);
	    $overlay_height = imagesy($overlay_gd_image);

		$offset = wpbeautify_calculate_offset_image($image, $source_width, $source_height, $overlay_width, $overlay_height, $watermark_settings);

/*imagealphablending($image, 1);
imagealphablending($overlay_gd_image, 1);*/

	    //imagecopymerge(
	     imagecopy(

	        $image,
	        $overlay_gd_image,
	        /*$source_width - $overlay_width*/$offset['x'],
	        /*$source_height - $overlay_height*/$offset['y'],
	        0,
	        0,
	        $overlay_width,
	        $overlay_height/*,
	        50*/
	    );
	}
	else {
		$color  = wpbeautify_allocate_hex($image, $watermark_settings['watermark_text_color']);
		$offset = wpbeautify_calculate_offset($image, $watermark_settings);
		$font_path = WPBEAUTIFY_DIR.'/assets/fonts/'.$watermark_settings['watermark_font'];
		// Add the text to image
		imagettftext($image, $watermark_settings['watermark_text_size'], 0, $offset['x'], $offset['y'], $color, $font_path, $watermark_settings['watermark_text']);
	}

	wpbeautify_save_image_file($image, $mime_type, $file_path);
}


	function wpbeautify_getImageSize($image) {
		return array(
			'x' => imagesx($image),
			'y' => imagesy($image)
		);
	}

	function wpbeautify_calculateBBox($watermark_settings) {
		// http://ruquay.com/sandbox/imagettf/
		$font_path = WPBEAUTIFY_DIR.'/assets/fonts/'.$watermark_settings['watermark_font'];


		$bbox = imagettfbbox(
			$watermark_settings['watermark_text_size'],
			0,
			$font_path,
			$watermark_settings['watermark_text']
		);

		$bbox = array(
			'bottom_left'  => array(
				'x' => $bbox[0],
				'y' => $bbox[1]
			),
			'bottom_right' => array(
				'x' => $bbox[2],
				'y' => $bbox[3]
			),
			'top_right'    => array(
				'x' => $bbox[4],
				'y' => $bbox[5]
			),
			'top_left'     => array(
				'x' => $bbox[6],
				'y' => $bbox[7]
			)
		);

		$bbox['width']  = $bbox['top_right']['x'] - $bbox['top_left']['x'];
		$bbox['height'] = $bbox['bottom_left']['y'] - $bbox['top_left']['y'];

		return $bbox;
	}

function wpbeautify_calculate_offset_image($image, $source_width, $source_height, $overlay_width, $overlay_height, $watermark_settings) {
	$offset = array('x' => 0,'y' => 0);

	/*$isize  = wpbeautify_getImageSize($image);
	$bbox   = wpbeautify_calculateBBox($watermark_settings);*/

	list($ypos, $xpos) = explode('_', $watermark_settings['watermark_position']);

	switch($xpos) {
		default:
		case 'left':
			$offset['x'] = $watermark_settings['watermark_offset_x'];
			break;
		case 'center':
			$offset['x'] = ($source_width / 2) - ($overlay_width / 2) + $watermark_settings['watermark_offset_x'];
			break;
		case 'right':
			$offset['x'] = $source_width - $overlay_width - $watermark_settings['watermark_offset_x'];
			break;
	}

	switch($ypos) {
		default:
		case 'top':
			$offset['y'] = $watermark_settings['watermark_offset_y'];
			break;
		case 'middle':
			$offset['y'] = ($source_height / 2) - ($overlay_height / 2) + $watermark_settings['watermark_offset_y'];
			break;
		case 'bottom':
			$offset['y'] = $source_height - $overlay_height - $watermark_settings['watermark_offset_y'];
			break;
	}

	return $offset;
}

function wpbeautify_calculate_offset($image, $watermark_settings) {
	$offset = array('x' => 0,'y' => 0);

	$isize  = wpbeautify_getImageSize($image);
	$bbox   = wpbeautify_calculateBBox($watermark_settings);

	list($ypos, $xpos) = explode('_', $watermark_settings['watermark_position']);

	switch($xpos) {
		default:
		case 'left':
			$offset['x'] = 0 - $bbox['top_left']['x'] + $watermark_settings['watermark_offset_x'];
			break;
		case 'center':
			$offset['x'] = ($isize['x'] / 2) - ($bbox['top_right']['x'] / 2) + $watermark_settings['watermark_offset_x'];
			break;
		case 'right':
			$offset['x'] = $isize['x'] - $bbox['bottom_right']['x'] - $watermark_settings['watermark_offset_x'];
			break;
	}

	switch($ypos) {
		default:
		case 'top':
			$offset['y'] = 0 - $bbox['top_left']['y'] + $watermark_settings['watermark_offset_y'];
			break;
		case 'middle':
			$offset['y'] = ($isize['y'] / 2) - ($bbox['top_right']['y'] / 2) + $watermark_settings['watermark_offset_y'];
			break;
		case 'bottom':
			$offset['y'] = $isize['y'] - $bbox['bottom_right']['y'] - $watermark_settings['watermark_offset_y'];
			break;
	}

	return $offset;
}


	function wpbeautify_allocate_hex($image, $hexstr) {
		$int = hexdec($hexstr);

		return imagecolorallocate($image,
			0xFF & ($int >> 0x10),
			0xFF & ($int >> 0x8),
			0xFF & $int
		);
	}


function wpbeautify_get_image_resource($filepath, $mime_type) {
	switch ( $mime_type ) {
		case 'image/jpeg':
			return imagecreatefromjpeg($filepath);
		case 'image/png':
			return imagecreatefrompng($filepath);
		case 'image/gif':
			return imagecreatefromgif($filepath);
		default:
			return false;
	}
}

function wpbeautify_save_image_file($image, $mime_type, $filepath) {
	switch ( $mime_type ) {
		case 'image/jpeg':
			return imagejpeg($image, $filepath, apply_filters( 'jpeg_quality', 90 ));
		case 'image/png':
			return imagepng($image, $filepath);
		case 'image/gif':
			return imagegif($image, $filepath);
		default:
			return false;
	}
}

// Download Image

function wpbeautify_download_image() {
	@ini_set( 'max_execution_time', '480' );
	$photo_name = empty( $_POST['file_name'] ) ? 'default.jpg' : $_POST['file_name'];
	$photo_url = $_POST['image_url'];
	$image_size = $_POST['image_size'];
	$watermark = isset( $_POST['watermark'] ) ? $_POST['watermark'] : 'false';
	if ($watermark == 'true') $watermark = 1; else $watermark = 0;


	if ( !class_exists( 'WP_Http' ) )
		include_once ABSPATH . WPINC. '/class-http.php';

	$photo = new WP_Http();
	$photo = $photo->request( $photo_url );
	if ( is_wp_error( $photo ) ) return false;
	if ( $photo['response']['code'] != 200 )
		return false;

	$attachment = wp_upload_bits( $photo_name, null, $photo['body'] );
	if ( !empty( $attachment['error'] ) )
		return false;

	$filetype = wp_check_filetype( basename( $attachment['file'] ), null );
	$filename = $attachment['file'];
		 //var_dump($attachment);

	$wp_upload_dir = wp_upload_dir();

	$file_path = basename( $attachment['file'] );
	$full_path = $wp_upload_dir['path'] . '/' . $file_path;

	if ($watermark) {
		wpbeautify_do_watermark($full_path, $filetype['type']);
	}

	if ($image_size != 'full') {
		$filename = wpbeautify_resize_image($full_path, $photo_name, $image_size);
	}

	echo $filename;
	exit ( 0 );
}

function wpbeautify_template_redirect() {
	if ( isset( $_GET['wpbeautify_file_export'] ) ) {
		if ( !$_POST['wpbeautify_file_url'] ) return;
		if ( !$_POST['wpbeautify_file_name'] ) return;
		$image = wp_get_image_editor( $_POST['wpbeautify_file_url'] );
		// var_dump($image);
		if ( ! is_wp_error( $image ) ) {

			$filetype = wp_check_filetype( $_POST['wpbeautify_file_url'] , null );

			header( "Content-type: ".$filetype['type'], true, 200 );
			header( "Pragma: no-cache" );
			header( "Expires: 0" );
			header( 'Content-Disposition: attachment; filename="'.$_POST['wpbeautify_file_name'].'"' );
			$image->stream();
		}
		exit();
	}
/*
	else if ( isset( $_GET['wpbeautify_file_export_attribution'] ) ) {
			header( 'Content-type: text/plain' );
			header( "Pragma: no-cache" );
			header( "Expires: 0" );
			header( 'Content-Disposition: attachment; filename="'.$_POST['wpbeautify_file_name'].'"' );
			echo $_POST['wpbeautify_caption'];
			exit();
		}*/
	return;
}
add_action( 'admin_init', 'wpbeautify_template_redirect' );

add_action('wp_ajax_wpbeautify_share_img_fb', 'wpbeautify_share_img_fb');
add_action('wp_ajax_wpbeautify_share_img_twitter', 'wpbeautify_share_img_twitter_ajax');
add_action('wp_ajax_wpbeautify_share_img_googleplus', 'wpbeautify_share_img_gplus');

function wpbeautify_share_img_fb() {
	wpbeautify_share_img_facebook($_POST['type'], $_POST['text'], $_POST['link'], $_POST['image_url']);
	exit(0);
}

function wpbeautify_share_img_gplus() {
	wpbeautify_share_img_googleplus(1, $_POST['text'], $_POST['album'], $_POST['image_url'],  $_POST['image_name']);
	exit(0);
}

function wpbeautify_share_img_twitter_ajax() {
  wpbeautify_share_img_twitter($_POST['text'], $_POST['image_url']);
  exit(0);
}

function wpbtfy_predefined_image_sizes_select( $name ) {
  global $wpbtfy_social_sizes;
?>
 <select class="form-control" id="<?php echo $name; ?>">
  <option value="0">Select...</option>
  <?php
    $str_ret = '';
    foreach( $wpbtfy_social_sizes as $type ) {
      $str_ret .= '<optgroup label="'.$type['name'].'">';

      foreach ($type['sizes'] as $size) {
        $str_ret .= '<option value="'.$size[0].'">'.$size[1].' ('.$size[2].' x '.$size[3].')'.'</option>';
      }

      $str_ret .= '<optgroup>';
    }
    echo $str_ret;
  ?>
 </select>
<?php
}
?>