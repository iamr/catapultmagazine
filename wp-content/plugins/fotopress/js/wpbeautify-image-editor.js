var current_custom_effects = new Array();
var wpbtfy_orig_send_to_editor = false;
var global_width = 0;
var global_height = 0;
var original_width = 0;
var original_height = 0;
var global_stage = 0;
var global_img_object = 0;
var painting_shapes = 0;
/*var shapes_layer = 0;*/
var free_drawing_layer = 0;
// var text_layer = 0;
var wpbeautify_img_just_selected = '';
var wpbeautify_final_image_url = '';

var border_layer;
// Free Image Search
var wpbeautify_free_img_page;
wpbeautify_free_img_page = 1;

var wpbeautify_extras_album_page
wpbeautify_extras_album_page = 1;

var wpbeautify_layer_img_page;
wpbeautify_layer_img_page = 1;
var wpbeautify_layer_img_just_selected = '';

// Image Border
var wpbeautify_img_border;
wpbeautify_img_border = 0;
var img_canvas = 0;
var img_layer = 0;

var current_img_url = '';

var wpbtfy_layers = new Array();
// var wpbtfy_anchors = new Array();

var wpbtfy_loading_txt = '<div class="wpbeautify-loading" style="display:block"></div>';
var wpbtfy_edit_img_txt = '<button class="btn btn-success wpbeautify_edit_img_uploaded" style="text-align:center"> <span class="glyphicon glyphicon-pencil"></span> Edit Image</button>';
var wpbtfy_loaded_txt = '<div class="wpbeautify-uploader-info" ><div class="alert alert-success"> <span class="glyphicon glyphicon-ok"></span> File downloaded!  &nbsp;&nbsp;&nbsp;'+wpbtfy_edit_img_txt+'</div></div>';

var wpbeautify_is_edition = 0;

var current_zindex = 0;

function wpbeautify_loading_div_content(name) {
	return '<div id="'+name+'" class="wpbeautify-loading" style="display:block"></div>';
}

jQuery( document ).ready(function(  ) {

	
	// console.log(wpbtfy_orig_send_to_editor)

	wpbeautify_initialize_effects();
	 // wpbeautify_set_modal_height();
		jQuery('#wpbtfyModal').on('shown.bs.modal', wpbeautify_set_modal_height);
		jQuery('#wpbtfyModal').on('shown.bs.modal', wpbeautify_set_backdrop_class);

		jQuery('#wpbtfyModal').on('shown.bs.modal', function() {
		    jQuery(document).off('focusin.modal');
		});

	jQuery(window).resize(function () { wpbeautify_set_modal_height(); });


  jQuery('#hacer-test').on("click", function(e) {
		img_layer.x(jQuery('#img-tx').val());

		current_crop = global_img_object.crop();
		 global_img_object.crop({
		  x: jQuery('#img-tleft').val(),
		  y: current_crop.y,
		  width: current_crop.width,
		  height: current_crop.height
		})
		 img_layer.draw();
	});

	 // rmi353, no permitir esto!
	jQuery("#wpbtfy-tabs a[data-toggle=tab]").on("click", function(e) {
	 if (jQuery(this).parent().hasClass("disabled")) {
		e.preventDefault();
		return false;
	 }
	});

	jQuery('#do-close-fpress-main').click(function( e ){
		e.preventDefault();
		// console.log('xx')
		jQuery('#wpbtfyModal').modal('hide')
		// wpbeautify_reset_popup();
		// jQuery('#wpbtfyModal').modal({'backdrop' : 'static'});
	});
  // esto es sólo para tener una img precargada, borrar
	// wpbeautify_set_up_stage('http://localhost/wordpress/wp-content/uploads/2014/03/example2_1200.jpg')
	// wpbeautify_set_up_stage('http://localhost/wordpress/wp-content/uploads/2014/02/2013-12-23-13.29.56-Kopia.jpg')

	// $('li.disabled > a:link').on('click', function(e) {
	//   e.preventDefault();
	// });
	// jQuery('dropdown-menu').on('click', 'li.disabled > a', function(e) {

	 // jQuery('li.disabled > a').on('click', function(e) {

	// jQuery("li.disabled a").click(function(e) {
		 // console.log('aaa')
	  // e.preventDefault();
	  // return false;
	// });

	// open Img editor popup
	jQuery('#wpbeautify-editor-button').click(function(e ){
		e.preventDefault();
		wpbeautify_reset_popup();
		jQuery('#wpbtfyModal').modal({'backdrop' : 'static'});
	});

	// display editor
	jQuery(document).on('click', '.wpbeautify_edit_img', function(e) {
		wpbeatify_show_loading_modal();
/*		imgurl = jQuery('#wpbtfy-tabs-img-sites-content .tab-pane.active .wpbeautify-attachment.selected').find('img').attr('data-url');
		if (imgurl) {
			wpbeautify_download_external_img(imgurl, wpbeautify_freeimage_finished);
		}*/
// console.log(wpbeautify_img_just_selected)
		if (wpbeautify_img_just_selected) {
			wpbeautify_download_external_img(wpbeautify_img_just_selected, wpbeautify_freeimage_finished);
		}
	});

	jQuery(document).on('click', '.wpbeautify_edit_img_uploaded', function(e) {
		wpbeatify_show_loading_modal();

		if (wpbeautify_img_just_selected) {
			wpbeautify_download_external_img(wpbeautify_img_just_selected, wpbeautify_freeimage_finished);
		}
	});


	jQuery(document).on('change', '#wpbeautify_link_to', function(e) {
		select_value = jQuery('#wpbeautify_link_to').val();
		url_el = jQuery('#wpbeautify_link_to_url');
		switch (select_value) {
			case 'custom':
				url_el.val('http://');
				url_el.show();
				url_el.removeAttr('readonly');
				break;
			case 'file':
				url_el.val('Link to image file');
				url_el.show();
				url_el.attr('readonly', 'readonly');
				break;
			case 'post':
				url_el.val('Link to attachment page');
				url_el.show();
				url_el.attr('readonly', 'readonly');
				break;
			case 'none':
				url_el.val('');
				url_el.hide();
				break;
		}
	});


	/* 1: Image Selectors */

	/* 1.1. Upload Image */

	/* 1.2. WP Image Selector */
/*	var _custom_media = true,
	_orig_send_attachment = wp.media.editor.send.attachment;

	jQuery('#wpbeautify_imagesel_wp').click(function(e) {
		e.preventDefault();
		var send_attachment_bkp = wp.media.editor.send.attachment;
		var button = jQuery(this);
		_custom_media = true;

		wp.media.editor.send.attachment = function(props, attachment){
		 	if ( _custom_media ) {
		 		console.log('aa')
				wpbeautify_image_selected(attachment.url)
				wpbeautify_img_just_selected = attachment.url
				file_name = wpbeautify_get_file_name_from_url(attachment.url);
				wpbeautify_update_fileext(file_name[0], file_name[1]);
				jQuery('#wpbeautify_img_title').val(attachment.title);
				jQuery('#wpbeautify_img_alt').val(attachment.alt);
				jQuery('#wpbeautify_img_caption').val(attachment.caption);
				jQuery('#wpbeautify_img_description').val(attachment.description);

			    jQuery('#wpbeautify_preview_img').attr('src', attachment.url);
			    jQuery('#wpbeautify_img_dimensions').html(attachment.width+' x '+attachment.height);
				jQuery('#wpbeautify_img_source_link').html('WP Images');
				jQuery('#wpbeautify_img_source_link').attr('href', attachment.url);

				attachment_txt = '<div style="text-align:center"><img style="width:110px" src="'+attachment.url+'" /><br/><br/>'+
				'<span><b>Title</b>: '+attachment.title+'</span><br/>'+
				'<span><b>File Name</b>: '+attachment.filename+'</span><br/>'+
				'<span><b>Uploaded on </b>: '+attachment.dateFormatted+'</span><br/>'+
				'<button class="btn btn-success wpbeautify_edit_img_uploaded" style="text-align:center"> <span class="glyphicon glyphicon-pencil"></span> Edit Image</button>'+
				'</div>';
				jQuery('#wpbeautify_wpimage_results').html(attachment_txt) // here
				jQuery('#btn-edit-image-main').show();
         		wpbeautify_enable_actions(1);

				wpbeautify_enable_editor()
				wp.media.editor.send.attachment = send_attachment_bkp;
				_custom_media = false;
			} else {
		 		console.log('bb')

				return _orig_send_attachment.apply( this, [props, attachment] );
			};
		}

		wp.media.editor.open(button);
		return false;
	});


	jQuery('.add_media').on('click', function(){
		_custom_media = false;
	});
*/


var custom_uploader;
jQuery('#wpbeautify_imagesel_wp').click(function(e) {
    var button = jQuery(this);
    custom_uploader = wp.media.frames.file_frame = wp.media({
        title: 'Select Image',
        /*library: {
            author: userSettings.uid // specific user-posted attachment
        },*/
        button: {
            text: 'Select Image'
        },
        multiple: false
    });

    //When a file is selected, grab the URL and set it as the text field's value
    custom_uploader.on('select', function() {
        attachment = custom_uploader.state().get('selection').first().toJSON();
        // console.log(attachment.url);
        // console.log(attachment.id); // use them the way you want

        				wpbeautify_image_selected(attachment.url)
        				wpbeautify_img_just_selected = attachment.url
        				file_name = wpbeautify_get_file_name_from_url(attachment.url);
        				wpbeautify_update_fileext(file_name[0], file_name[1]);
        				jQuery('#wpbeautify_img_title').val(attachment.title);
        				jQuery('#wpbeautify_img_alt').val(attachment.alt);
        				jQuery('#wpbeautify_img_caption').val(attachment.caption);
        				jQuery('#wpbeautify_img_description').val(attachment.description);

        			    jQuery('#wpbeautify_preview_img').attr('src', attachment.url);
        			    jQuery('#wpbeautify_img_dimensions').html(attachment.width+' x '+attachment.height);
        				jQuery('#wpbeautify_img_source_link').html('WP Images');
        				jQuery('#wpbeautify_img_source_link').attr('href', attachment.url);

        				attachment_txt = '<div style="text-align:center"><img style="width:110px" src="'+attachment.url+'" /><br/><br/>'+
        				'<span><b>Title</b>: '+attachment.title+'</span><br/>'+
        				'<span><b>File Name</b>: '+attachment.filename+'</span><br/>'+
        				'<span><b>Uploaded on </b>: '+attachment.dateFormatted+'</span><br/>'+
        				'<button class="btn btn-success wpbeautify_edit_img_uploaded" style="text-align:center"> <span class="glyphicon glyphicon-pencil"></span> Edit Image</button>'+
        				'</div>';
        				jQuery('#wpbeautify_wpimage_results').html(attachment_txt) // here
        				jQuery('#btn-edit-image-main').show();
                 		wpbeautify_enable_actions(1);
    });

    //Open the uploader dialog
    // Set post id
    wp.media.model.settings.post.id = jQuery('#post_ID').val();
    custom_uploader.open();
});

	/* 1.3. External URL */

	jQuery('#wpbeautify-download-image-by-url').click(function(e){
		imgurl = jQuery(this).parent().prev().val();
		if (imgurl== '')
			return;

		jQuery('#wpbeautify_selurl_loading').html(wpbtfy_loading_txt);
		jQuery('#wpbeautify_selurl_loading').show();

		wpbeautify_download_external_img(imgurl, wpbeautify_urldl_finished, 0, 0, 0, 1);
		// wpbeautify_download_external_img(imgurl, callback, force_file_name, js_download, file_content, update_sidebar)
	});

	/* 1.4. Search Free Images */

	jQuery('#wpbeautify_freeimg_sources').multiselect({
		includeSelectAllOption: true,
		selectAllText: 'Select All',
		selectAllValue : 'all-sites'
	});

	jQuery('#wpbtfy-search-free-imgs-btn').click(function(e){
		if(jQuery.trim(jQuery('#wpbtfy-search-free-imgs-keyword').val()).length) {
			jQuery('#wpbtfy-search-free-imgs-keyword').parent().removeClass('has-error');
			jQuery('#wpbtfy-search-free-imgs-keyword').prop('placeholder', 'Enter Search Term');
			wpbeautify_free_img_page = 1;
			wpbeautify_do_image_search();
		}
		else {
			// empty search
			jQuery('#wpbtfy-search-free-imgs-keyword').parent().addClass('has-error');
			jQuery('#wpbtfy-search-free-imgs-keyword').prop('placeholder', 'Search term cannot be empty');
			return;
		}
	});

	jQuery(document).on('keypress', '#wpbtfy-search-free-imgs-keyword', function(e) {
		code = ( e.keyCode ? e.keyCode : e.which );
		if ( 13 == code ) {
			wpbeautify_free_img_page = 1;
			wpbeautify_do_image_search();
		}
	});

	jQuery(document).on('click', '#wpbtfy-src-freeimg #wpbeautify_free_img_pagination .pagination li a', function(e) {
		 e.preventDefault;
		 this_el = jQuery(this)
		if (this_el.hasClass('prev'))
			wpbeautify_free_img_page --;
		else if (this_el.hasClass('next'))
			wpbeautify_free_img_page ++;
		else
			wpbeautify_free_img_page = parseInt(this_el.html().replace(',','').replace(' ',''));
		wpbeautify_do_image_search();
	});

	jQuery(document).on('click', '.social_image_results #wpbeautify_free_img_pagination .pagination li a', function(e) {
		e.preventDefault;
		this_el = jQuery(this)
		img_type = this_el.closest('.social_image_results').attr('data-site-type');
		if (img_type == 'extras')
			return;

		if (this_el.hasClass('prev'))
			page = 'prev';
		else if (this_el.hasClass('next'))
			page = 'next';
		else
			page = parseInt(this_el.html().replace(',','').replace(' ',''));
		wpbeautify_social_pagination(img_type, page)
	});


	jQuery(document).on('click', '#wpbtfy-tabs-img-sites-content .wpbeautify-attachment', function(e) {
		wpbeautify_is_edition = 0;
		jQuery('#wpbeautify_right_sidebar').show();

		this_el = jQuery(this)
		if (this_el.hasClass('selected')) {
			jQuery('#wpbtfy-tabs-img-sites-content .wpbeautify-attachment').removeClass('selected')
			this_el.removeClass('selected')
			jQuery('#wpbtfy-use-free-imgs-btn').attr('disabled', 'disabled')
		}
		else {
			jQuery('#wpbtfy-tabs-img-sites-content .wpbeautify-attachment').removeClass('selected')
			this_el.addClass('selected');
			jQuery('#wpbtfy-use-free-imgs-btn').removeAttr("disabled")
			jQuery('#wpbeautify_edit_meme').removeAttr("disabled")

			wpbeautify_thumbnail_clicked(this_el);
			wpbeautify_enable_actions(1);
			// console.log(this_el.find('img').attr('data-source'))
			if (this_el.find('img').attr('data-source') == 'social-image') {
				// console.log('social')
				wpbeautify_social_thumbnail_clicked(this_el);
			}
		}
	});



	jQuery('#wpbtfy-use-free-imgs-btn').click(function(e){
		// (NO MODIFIABLE WARNING!)
		is_modifiable = jQuery('#wpbtfy_free_imgs_div .wpbeautify-attachment.selected').find('img').attr('data-modifiable');
		if (is_modifiable != '1') {
			if (!confirm('Please note that the license of this image does not any kind of editing to the image. Are you sure you want to do this?'))
				return;
		}
		imgurl = jQuery('#wpbtfy_free_imgs_div .wpbeautify-attachment.selected').find('img').attr('data-url');
		jQuery("#wpbtfy_free_imgs_div").html(wpbeautify_loading_div_content('wpbeautify_freeimg_loading'))
		jQuery('#wpbtfy-use-free-imgs-btn').attr('disabled', 'disabled')
		wpbeautify_download_external_img(imgurl, wpbeautify_freeimage_finished);
	});


	/* 1.5. Dropbox */

	jQuery('#wpbeautify_imagesel_dropbox').click(function(e ){
		jQuery('#wpbeautify_dropbox_results').hide();
		options = {
			// Required. Called when a user selects an item in the Chooser.
			success: function(files) {
				jQuery('#wpbeautify_dropbox_loading').show();
				// console.log(files[0]);
				wpbeautify_download_external_img(files[0].link, dropbox_show_image_results);
				wpbtfy_set_sidebar_vals (files[0].name, false, 'Dropbox')
				jQuery('#wpbeautify_dropbox_results').html('<div style="text-align:center"><img style="width:110px" src="'+files[0].thumbnailLink+'" /><br/><span>'+files[0].name+'</span><br/>'+wpbtfy_edit_img_txt+'</div>');
			},
			cancel: function() {
			},
			linkType: "direct", // or "direct"
			multiselect: false, // or true
			extensions: ['images'],
		};
		Dropbox.choose(options);
	});




	/* 1.6. Extra Backgrounds */

	jQuery('#wpbeautify_imagesel_extras').click(function(e){
		wpbeautify_browse_extras();
	});

	jQuery('#wpbeautify_edit_extra').click(function(e){
		// wpbeautify_browse_flickr_albums();
		imgurl = jQuery('#wpbtfy-src-extra .wpbeautify-attachment.selected').find('img').attr('data-url');
		old_content = jQuery("#wpbeautify_extra_results").html();
		jQuery("#wpbeautify_extra_results").html('<div class="wpbeautify_freeimg_loading" class="wpbeautify-loading" style="display:block"></div>')

		// jQuery("#wpbtfy_free_imgs_div").html('<div id="wpbeautify_freeimg_loading" class="wpbeautify-loading" style="display:block"></div>')
		// jQuery('#wpbtfy-use-free-imgs-btn').attr('disabled', 'disabled')
		wpbeautify_download_external_img(imgurl);
		jQuery('#wpbtfy-tabs a:last').tab('show');
		jQuery('#wpbtfy-button-text').click();
		jQuery("#wpbeautify_extra_results").html(old_content);
		// jQuery('#wpbtfy-button-add-text').click();

	});


	jQuery(document).on('click', '#wpbtfy-src-extra #wpbeautify_free_img_pagination .pagination li a', function(e) {
		 e.preventDefault;
		 this_el = jQuery(this)

		 // 2 opciones, album o imagen
		 is_album = this_el.closest('#wpbeautify_free_img_pagination').hasClass('wpbtfy-albums');
		 // console.log('pagi extra')
		 if (!is_album) {
		 	if (this_el.hasClass('prev'))
		 		page = 'prev';
		 	else if (this_el.hasClass('next'))
		 		page = 'next';
		 	else
		 		page = parseInt(this_el.html().replace(',','').replace(' ',''));
		 	wpbeautify_social_pagination(img_type, page)
		 }
		else {


		if (this_el.hasClass('prev'))
			wpbeautify_extras_album_page --;
		else if (this_el.hasClass('next'))
			wpbeautify_extras_album_page ++;
		else
			wpbeautify_extras_album_page = parseInt(this_el.html().replace(',','').replace(' ',''));

		// puede ser paginación de album, o de imágenes!

		wpbeautify_browse_extras_albums();
	}
		// wpbeautify_do_image_search();
	});


	/* 1.6 Youzign */

	/*jQuery('#wpbeautify_imagesel_youzign').click(function(e){
		wpbeautify_browse_youzign();
	});

	jQuery('#wpbeautify_edit_youzign').click(function(e){
		// wpbeautify_browse_flickr_albums();
		imgurl = jQuery('#wpbtfy-src-youzign .wpbeautify-attachment.selected').find('img').attr('data-url');
		old_content = jQuery("#wpbeautify_youzign_results").html();
		jQuery("#wpbeautify_youzign_results").html('<div class="wpbeautify_freeimg_loading" class="wpbeautify-loading" style="display:block"></div>')

		// jQuery("#wpbtfy_free_imgs_div").html('<div id="wpbeautify_freeimg_loading" class="wpbeautify-loading" style="display:block"></div>')
		// jQuery('#wpbtfy-use-free-imgs-btn').attr('disabled', 'disabled')
		wpbeautify_download_external_img(imgurl);
		jQuery('#wpbtfy-tabs a:last').tab('show');
		jQuery('#wpbtfy-button-text').click();
		jQuery("#wpbeautify_youzign_results").html(old_content);
		// jQuery('#wpbtfy-button-add-text').click();

	});*/


	jQuery('#wpbeautify_youzign_browse_images').click(function(e){
		jQuery('#youzign_panel_info').hide();
		wpbeautify_browse_youzign( 0 );
	});

	/*jQuery(document).on('click', '.wpbeautify_pics_in_album.youzign', function(e) {
		e.preventDefault();
		current_album = jQuery(this).attr('data-album-id')
		current_album_name = jQuery(this).attr('data-album-name')
		wpbeautify_social_current_pages['youzign'][0] = current_album;
		wpbeautify_social_current_pages['youzign'][3] = current_album_name;
		wpbeautify_browse_youzign_album_pics(current_album, 1, current_album_name);
	});*/

	// wpbeautify_youzign_browse_images
	/* 1.6. Meme Backgrounds */

	jQuery('#wpbeautify_imagesel_memes').click(function(e){
		wpbeautify_browse_memes();
	});

	jQuery('#wpbeautify_edit_meme').click(function(e){
		// wpbeautify_browse_flickr_albums();
		imgurl = jQuery('#wpbtfy-src-memes .wpbeautify-attachment.selected').find('img').attr('data-url');
		old_content = jQuery("#wpbeautify_meme_results").html();
		jQuery("#wpbeautify_meme_results").html('<div class="wpbeautify_freeimg_loading" class="wpbeautify-loading" style="display:block"></div>')

		// jQuery("#wpbtfy_free_imgs_div").html('<div id="wpbeautify_freeimg_loading" class="wpbeautify-loading" style="display:block"></div>')
		// jQuery('#wpbtfy-use-free-imgs-btn').attr('disabled', 'disabled')
		wpbeautify_download_external_img(imgurl);
		jQuery('#wpbtfy-tabs a:last').tab('show');
		jQuery('#wpbtfy-button-text').click();
		jQuery("#wpbeautify_meme_results").html(old_content);
		// jQuery('#wpbtfy-button-add-text').click();

	});


	/* 1.7. Social Sites */
	// TO-DO



	jQuery(document).on('click', '.back_all_albums', function(e) {
		e.preventDefault();
		site = jQuery(this).attr('data-site')
		switch (site) {
			case 'facebook':
				wpbeautify_browse_facebook_albums();
				break;
			case 'pinterest':
				wpbeautify_browse_pinterest_albums();
				break;
			case 'instagram':
				wpbeautify_browse_instagram_albums();
				break;
			case 'flickr':
				wpbeautify_browse_flickr_albums();
				break;
			case 'googleplus':
				wpbeautify_browse_googleplus_albums();
				break;
			case 'extras':
				wpbeautify_browse_extras_albums();
				break;
			default:
				break;
		}
	});


	jQuery('#wpbeautify_flickr_browse_albums').click(function(e){
		jQuery('#flickr_panel_info').hide();
		wpbeautify_browse_flickr_albums();
	});

	jQuery(document).on('click', '.wpbeautify_pics_in_album.flickr', function(e) {
		e.preventDefault();
		current_album = jQuery(this).attr('data-album-id')
		current_album_name = jQuery(this).attr('data-album-name')
		wpbeautify_social_current_pages['flickr'][0] = current_album;
		wpbeautify_social_current_pages['flickr'][3] = current_album_name;
		wpbeautify_browse_flickr_album_pics(current_album, 1, current_album_name);
		// wpbeautify_browse_flickr_album_pics(jQuery(this).attr('data-album-id'));
	});

	jQuery('#wpbeautify_googleplus_browse_albums').click(function(e){
		jQuery('#googleplus_panel_info').hide();
		wpbeautify_browse_googleplus_albums();
	});

	jQuery(document).on('click', '.wpbeautify_pics_in_album.googleplus', function(e) {
		e.preventDefault();
		current_album = jQuery(this).attr('data-album-id')
		current_album_name = jQuery(this).attr('data-album-name')
		wpbeautify_social_current_pages['googleplus'][0] = current_album;
		wpbeautify_social_current_pages['googleplus'][3] = current_album_name;
		wpbeautify_browse_googleplus_album_pics(current_album, 1, current_album_name);
	});

	jQuery('#wpbeautify_extras_browse_albums').click(function(e){
		jQuery('#extras_panel_info').hide();
		wpbeautify_browse_extras_albums();
	});

	jQuery(document).on('click', '.wpbeautify_pics_in_album.extras', function(e) {
		e.preventDefault();
		current_album = jQuery(this).attr('data-album-id')
		current_album_name = jQuery(this).attr('data-album-name')
		wpbeautify_social_current_pages['extras'][0] = current_album;
		wpbeautify_social_current_pages['extras'][3] = current_album_name;
		wpbeautify_browse_extras_album_pics(current_album, 1, current_album_name);
	});


	jQuery('#wpbeautify_facebook_browse_albums').click(function(e){
		jQuery('#facebook_panel_info').hide();
		wpbeautify_browse_facebook_albums();
	});

	jQuery(document).on('click', '.wpbeautify_pics_in_album.facebook', function(e) {
		e.preventDefault();
		current_album = jQuery(this).attr('data-album-id')
		current_album_name = jQuery(this).attr('data-album-name')
		wpbeautify_social_current_pages['facebook'][0] = current_album;
		wpbeautify_social_current_pages['facebook'][3] = current_album_name;
		wpbeautify_browse_facebook_album_pics(current_album, 1, current_album_name);
	});

	jQuery('#wpbeautify_pinterest_browse_albums').click(function(e){
		jQuery('#pinterest_panel_info').hide();
		wpbeautify_browse_pinterest_albums();
	});

	jQuery(document).on('click', '.wpbeautify_pics_in_album.pinterest', function(e) {
		e.preventDefault();
		current_album = jQuery(this).attr('data-album-id')
		current_album_name = jQuery(this).attr('data-album-name')
		wpbeautify_social_current_pages['pinterest'][0] = current_album;
		wpbeautify_social_current_pages['pinterest'][3] = current_album_name;
		wpbeautify_browse_pinterest_album_pics(current_album, 1, current_album_name);
	});

	jQuery('#wpbeautify_instagram_browse_pics').click(function(e){
		jQuery('#instagram_panel_info').hide();
		wpbeautify_browse_instagram_pics(1);
	});


	/* 1.8 Plan Backgrounds */


	jQuery('#simple-bg-color-select').click(function(e){
		color = jQuery('#simple-bg-color').val();
		wpbtfy_set_bg_color( color );
	});

	/* 2: Image Editor */

	/* 2.1. Cropping */

	jQuery('#wpbtfy-button-crop').click(function(e){
		jQuery('.wpbtfy-left-panel').hide();
		jQuery('#wpbtfy-panel-crop').show();

/*		var frost = new Konva.Rect({
			x: 0,
			y: 0,
			width: global_width,
			height: global_height,
			fill: "white",
			opacity: 0.70
		});
		img_layer.add(frost);
		img_layer.draw();*/
	});

	jQuery('#wpbtfy-button-start-crop').click(function(e){
		wpbeautify_start_crop();
	});


	jQuery('#wpbtfy-button-do-crop').click(function(e){
		wpbeautify_do_crop();
	});

	jQuery('#wpbtfy-button-cancel-crop').click(function(e){
		wpbeautify_cancel_crop();
	});

	jQuery('#wpbeautify_img_predefined_crop').change(function(e){
		size = jQuery(this).val();
		if (size && (size != 0))
			wpbtfy_crop_image_predefined( size );
	});

	/* 2.2. Resizing */

	jQuery('#wpbtfy-button-resize').click(function(e){
		jQuery('.wpbtfy-left-panel').hide();
		jQuery('#wpbtfy-panel-resize').show();
	});

	jQuery('#wpbeautify_img_predefined_resize').change(function(e){
		size = jQuery(this).val();
		if (size && (size != 0))
			wpbtfy_resize_image_predefined( size );
	});

	/*jQuery('#image-size-slider-hor').sliderstrap({
		formater: function(value) {
			return value+'%';
		}
	}).on('click', DispatchSlide);;*/

	jQuery('#image-size-slider-vert').sliderstrap({
		formater: function(value) {
			return value+'%';
		},
		reversed : true
	}).on('slideStart', function(event) {
   		wpbeautify_dispatch_slide(event, jQuery(this))
	});

	// .on('slideStart', wpbeautify_dispatch_slide(e));

	jQuery('#image-size-slider-hor').sliderstrap({
		formater: function(value) {
			return value+'%';
		}/*,
		reversed : true*/
	}).on('slideStart', function(event) {
   		wpbeautify_dispatch_slide(event, jQuery(this))
	});

	jQuery("#image-size-slider-vert").on('slide', function(slideEvt) {
		if (slideEvt.value < 0)
			var proportion = 1/(1-slideEvt.value/100)
		else
			var proportion = 1+slideEvt.value/100

		if (jQuery('#wpbeautify_resize_keep_proportion').is(':checked')) {
			// do both ways, update hor too
			jQuery("#image-size-slider-hor").sliderstrap('setValue', slideEvt.value);
			resize_image_proportion(1, proportion);
		}

		resize_image_proportion(2, proportion);
	});

	jQuery("#image-size-slider-hor").on('slide', function(slideEvt) {
		if (slideEvt.value < 0)
			var proportion = 1/(1-slideEvt.value/100)
		else
			var proportion = 1+slideEvt.value/100

		if (jQuery('#wpbeautify_resize_keep_proportion').is(':checked')) {
			// do both ways, update hor too
			jQuery("#image-size-slider-vert").sliderstrap('setValue', slideEvt.value);
			resize_image_proportion(2, proportion);
		}

		resize_image_proportion(1, proportion);
	});

	jQuery( "#img-new-width" ).keyup(function() {
		resize_image_size(jQuery(this).val(), 0, jQuery('#wpbeautify_resize_keep_proportion').is(':checked'), 1)
	});

	jQuery( "#img-new-height" ).keyup(function() {
		resize_image_size(0, jQuery(this).val(), jQuery('#wpbeautify_resize_keep_proportion').is(':checked'), 2)
	});


	jQuery('#wpbtfy-button-restore-size').click(function(e){
		resize_image_size(original_width, original_height, 0, 0, 1)
		jQuery("#image-size-slider-hor").sliderstrap('setValue', 0);
		jQuery("#image-size-slider-vert").sliderstrap('setValue', 0);

	});

	jQuery('#wpbtfy-button-flip-horizontal').click(function(e){
		wpbeautify_flip_img('horizontal');
	});

	jQuery('#wpbtfy-button-flip-vertical').click(function(e){
		wpbeautify_flip_img('vertical');
	});

	/* 2.3. Predefined Effects */

	jQuery('#wpbtfy-button-effects-predefined').click(function(e){
		jQuery('.wpbtfy-left-panel').hide();
		jQuery('#wpbtfy-panel-predefined-effects').show();
	});

	jQuery('.auto-effect-filter').click(function(e){
		effect = jQuery(this).attr('data-effect');
		wpbeautify_apply_auto_effect(effect);
		jQuery('.auto-effect-filter').removeClass('img_selected');
		jQuery(this).addClass('img_selected');
	})

	jQuery('.wpbeautify_restore_original_img').click(function(e){
		wpbeautify_restore_original_img()
	})



	/* 2.4. Manual Effects */

	jQuery('#wpbtfy-button-effects-manual').click(function(e){
		jQuery('.wpbtfy-left-panel').hide();
		jQuery('#wpbtfy-panel-manual-effects').show();
	});

	jQuery('.manual-effect-filter').sliderstrap({
		formater: function(value) {
			return value+'%';
		}
	}).on('slideStart', function(event) {
   		wpbeautify_dispatch_slide(event, jQuery(this))
	});;


	jQuery("input.manual-effect-filter").on('slide', function(slideEvt) {
		effect = jQuery(this).attr('data-effect');
		wpbeautify_apply_effect(effect, slideEvt.value);
	});

	/*jQuery("input.manual-effect-filter").on('slideChange', function(slideEvt) {
		effect = jQuery(this).attr('data-effect');
		wpbeautify_apply_effect(effect, slideEvt.value);
	});*/

	jQuery('.wpbeautify-effect-restore').click(function(e){
		effect = jQuery(this).parent().prev().find('.manual-effect-filter')
		val = effect.attr('data-original-value');

		effect_name = effect.attr('data-effect');
		effect.sliderstrap('setValue', parseInt(val))
		// console.log(val)
		// effect.trigger('slide')
		wpbeautify_apply_effect(effect_name, parseInt(val));
		wpbeautify_reset_effect(effect_name);

	});


	/* 2.5. Borders */

	jQuery('#wpbtfy-button-border').click(function(e){
		jQuery('.wpbtfy-left-panel').hide();
		jQuery('#wpbtfy-panel-add-border').show();
	});

	jQuery('#wpbtfy-button-do-border').click(function(e){
		wpbeautify_apply_border();
	});

	jQuery('#wpbtfy-button-remove-border').click(function(e){
		wpbeautify_remove_border();
	});


	/* 2.6. Add Text */

	jQuery('#wpbtfy-button-text').click(function(e){
		jQuery('.wpbtfy-left-panel').hide();
		jQuery('#wpbtfy-panel-add-text').show();
	});

	jQuery('#wpbtfy-button-add-text').click(function(e){
		wpbeautify_add_text();
	});

	jQuery(document).on('click', '.wpbeautify_delete_text', function(e) {
		text_id = jQuery(this).closest('.wpbeautify_current_text').find('.wpbeautify_text_id').val();
		wpbeautify_delete_text(text_id);
		wpbeautify_remove_text_layer(text_id);
	});

	jQuery(document).on('change', '.wpbeautify_text_setting', function(e) {
		text_id = jQuery(this).closest('.wpbeautify_current_text').find('.wpbeautify_text_id').val();
		wpbeautify_update_text(text_id);
	});

	jQuery(document).on('keyup', '.wpbeautify_text_content', function(e) {
		text_id = jQuery(this).closest('.wpbeautify_current_text').find('.wpbeautify_text_id').val();
		wpbeautify_update_text(text_id);
	});

	jQuery(document).on('click', '.wpbtfy-text-alignment', function(e) {
		if (jQuery(this).hasClass('btn-info')) return;

		text_id = jQuery(this).closest('.wpbeautify_current_text').find('.wpbeautify_text_id').val();
		jQuery('#wpbeautify_text_'+text_id+' .wpbtfy-text-alignment').removeClass('btn-info');
		jQuery(this).addClass('btn-info');
		wpbeautify_update_text(text_id);
	});

	jQuery(document).on('click', '.wpbtfy-text-style', function(e) {
		text_id = jQuery(this).closest('.wpbeautify_current_text').find('.wpbeautify_text_id').val();
		// jQuery('#wpbeautify_text_'+text_id+' .wpbtfy-text-alignment').removeClass('btn-info');
		jQuery(this).toggleClass('btn-info');
		wpbeautify_update_text(text_id);
	});


	/* 2.7. Add Images */

	jQuery('#wpbtfy-button-newimage').click(function(e){
		jQuery('.wpbtfy-left-panel').hide();
		jQuery('#wpbtfy-panel-add-image').show();
	});

	jQuery('#wpbtfy-image-layer-do-search').click(function(e){
		wpbeautify_do_image_search_layers();
	});

	jQuery(document).on('click', '.small-navi-prev', function(e) {
		e.preventDefault();
		if (wpbeautify_layer_img_page) {
			wpbeautify_layer_img_page--;
			wpbeautify_do_image_search_layers();
		}
	});

	jQuery(document).on('click', '.small-navi-next', function(e) {
		e.preventDefault();
		wpbeautify_layer_img_page++;
		wpbeautify_do_image_search_layers();
	});


	jQuery(document).on('click', '#wpbtfy_free_imgs_layer_div .wpbeautify-attachment', function(e) {
		// wpbeautify_is_edition = 0;
		// jQuery('#wpbeautify_right_sidebar').show();

		this_el = jQuery(this)
		if (this_el.hasClass('selected')) {
			jQuery('#wpbtfy_free_imgs_layer_div .wpbeautify-attachment').removeClass('selected')
			this_el.removeClass('selected')
			jQuery('#wpbtfy-image-layer-insert-image').attr('disabled', 'disabled')
		}
		else {
			jQuery('#wpbtfy_free_imgs_layer_div .wpbeautify-attachment').removeClass('selected')
			this_el.addClass('selected');
			// jQuery('#wpbtfy-use-free-imgs-btn').removeAttr("disabled")
			// jQuery('#wpbeautify_edit_meme').removeAttr("disabled")

			// wpbeautify_thumbnail_clicked(this_el);
/*			wpbeautify_enable_actions(1);
			// console.log(this_el.find('img').attr('data-source'))*/
			wpbeautify_layer_img_just_selected = this_el.find('img').attr('data-url');
				// wpbeautify_social_thumbnail_clicked(this_el);
			jQuery("#wpbtfy-image-layer-insert-image").removeAttr("disabled")
		}
	});

	jQuery('#wpbtfy-image-layer-insert-image').click(function(e){
		wpbeautify_insert_image_layer();
	});


	jQuery(document).on('keypress', '#wpbtfy-search-layer-imgs-keyword', function(e) {
		code = ( e.keyCode ? e.keyCode : e.which );
		if ( 13 == code ) {
			wpbeautify_layer_img_page = 1;
			wpbeautify_do_image_search_layers();
		}
	});


	var custom_uploader2;
	jQuery('#wpbeautify_imagesel_wp2').click(function(e) {
	    var button = jQuery(this);
	    custom_uploader2 = wp.media.frames.file_frame = wp.media({
	        title: 'Select Image',
	        /*library: {
	            author: userSettings.uid // specific user-posted attachment
	        },*/
	        button: {
	            text: 'Insert Image'
	        },
	        multiple: false
	    });

	    //When a file is selected, grab the URL and set it as the text field's value
	    custom_uploader2.on('select', function() {
	        attachment = custom_uploader2.state().get('selection').first().toJSON();
			wpbeautify_insert_image_layer( attachment.url );

	        // console.log(attachment.url);
	        // console.log(attachment.id); // use them the way you want

	        				/*wpbeautify_image_selected(attachment.url)
	        				wpbeautify_img_just_selected = attachment.url
	        				file_name = wpbeautify_get_file_name_from_url(attachment.url);
	        				wpbeautify_update_fileext(file_name[0], file_name[1]);
	        				jQuery('#wpbeautify_img_title').val(attachment.title);
	        				jQuery('#wpbeautify_img_alt').val(attachment.alt);
	        				jQuery('#wpbeautify_img_caption').val(attachment.caption);
	        				jQuery('#wpbeautify_img_description').val(attachment.description);

	        			    jQuery('#wpbeautify_preview_img').attr('src', attachment.url);
	        			    jQuery('#wpbeautify_img_dimensions').html(attachment.width+' x '+attachment.height);
	        				jQuery('#wpbeautify_img_source_link').html('WP Images');
	        				jQuery('#wpbeautify_img_source_link').attr('href', attachment.url);

	        				attachment_txt = '<div style="text-align:center"><img style="width:110px" src="'+attachment.url+'" /><br/><br/>'+
	        				'<span><b>Title</b>: '+attachment.title+'</span><br/>'+
	        				'<span><b>File Name</b>: '+attachment.filename+'</span><br/>'+
	        				'<span><b>Uploaded on </b>: '+attachment.dateFormatted+'</span><br/>'+
	        				'<button class="btn btn-success wpbeautify_edit_img_uploaded" style="text-align:center"> <span class="glyphicon glyphicon-pencil"></span> Edit Image</button>'+
	        				'</div>';
	        				jQuery('#wpbeautify_wpimage_results').html(attachment_txt) // here
	        				jQuery('#btn-edit-image-main').show();
	                 		wpbeautify_enable_actions(1);*/
	    });

	    //Open the uploader dialog
	    // Set post id
	    wp.media.model.settings.post.id = jQuery('#post_ID').val();
	    custom_uploader2.open();
	});
	/* 2.7. Shapes */

	jQuery('#wpbtfy-button-shapes').click(function(e){
		jQuery('.wpbtfy-left-panel').hide();
		jQuery('#wpbtfy-panel-add-shape').show();
	});

	jQuery('#wpbtfy-button-start-drawing-shape').click(function(e){
		// wpbeautify_add_circle();
		wpbeautify_start_drawing_shape();
	});

	jQuery('#wpbtfy-button-remove-shapes').click(function(e){
		// wpbeautify_add_circle();
		wpbeautify_clear_shapes();
	});


	/* 2.8. Free Painting */

	jQuery('#wpbtfy-button-draw').click(function(e){
		jQuery('.wpbtfy-left-panel').hide();
		jQuery('#wpbtfy-panel-draw').show();
	});

	jQuery('#wpbtfy-button-start-freedraw').click(function(e){
		// wpbeautify_add_circle();
		wpbeautify_start_drawing_freedraw();
	});

	jQuery('#wpbtfy-button-remove-freedraw').click(function(e){
		// wpbeautify_add_circle();
		wpbeautify_clear_freedraw();
	});

	/* 2.9. Layers */

	jQuery('#wpbtfy-button-layers').click(function(e){
		jQuery('.wpbtfy-left-panel').hide();
		jQuery('#wpbtfy-panel-layers').show();
	});

	jQuery(document).on('click', '.wpbtfy-layer-remove', function(e) {
		wpbtfy_remove_layer( jQuery( this ).closest( '.wpbtfy-layer' ).attr( 'data-layer-id' ) );
	});

	jQuery(document).on('click', '.wpbtfy-layer-up', function(e) {
		this_layer = jQuery( this ).closest( '.wpbtfy-layer' )
		wpbtfy_layer_zindex( this_layer.attr( 'data-layer-id' ), 'up' );

		this_layer.after(this_layer.prev());
	});

	jQuery(document).on('click', '.wpbtfy-layer-down', function(e) {
		this_layer = jQuery( this ).closest( '.wpbtfy-layer' )
		wpbtfy_layer_zindex( this_layer.attr( 'data-layer-id' ), 'down' );
		this_layer.before(this_layer.next());

	});


	/* 3: General */

	jQuery('#wpbeautify-insert-image').click(function(e) {
	  // insert image into post
	  wpbeautify_insert_image(0,!wpbeautify_is_edition);
	});

	jQuery('#wpbeautify-download-image').click(function(e) {
	  // insert image into post
	  wpbeautify_insert_image(1,!wpbeautify_is_edition);
	});

	jQuery('#wpbeautify_save_to_wp_gallery').click(function(e) {
		if (jQuery(this).parent().hasClass('disabled'))
			return false;
		e.preventDefault();
		wpbeautify_insert_image(-1,!wpbeautify_is_edition);

		if (wp.media.frame && wp.media.frame != 'undefined') {
			// wp.media.frame.views._views[".media-frame-content"][0].views._views[""][1].collection.props.set({ignore:(+(new Date()))})
			/*if(wp.media.frame.content.get()!==null){
				console.log('a')
			   wp.media.frame.content.get().collection.props.set({ignore: (+ new Date())});
			   wp.media.frame.content.get().options.selection.reset();
			}else{
				console.log('b')

			   wp.media.frame.library.props.set({ignore: (+ new Date())});
			}*/
		}
/*

console.log(wp.media.editor)
console.log(wp.media.editor.get(wpActiveEditor))
console.log(wp.media.editor.get(wpActiveEditor).views)
		// wp.media.editor.get(wpActiveEditor).views._views[".media-frame-content"][0].views._views[""][1].collection.props.set({ignore:(+(new Date()))})

		if (wp.media.frame)
			wp.media.frame.content.get('gallery').collection.props.set({ignore: (+ new Date())});*/
	});


	/* Share on Social networks */

	jQuery('#wpbeautify_share_flickr').click(function(e) {
		if (jQuery(this).parent().hasClass('disabled'))
			return false;
		e.preventDefault();

		//http://www.stirring-interactive.com/blog/tweet-images-using-twitter-api/
		alert('Under construction');
	});

	jQuery('#wpbeautify-fb-do-share').click(function(e) {
		wpbeautify_insert_image(-1,!wpbeautify_is_edition, wp_beautify_do_fb_share);
	});

	jQuery('#wpbeautify_share_fb').click(function(e) {
		if (jQuery(this).parent().hasClass('disabled'))
			return false;
		// e.preventDefault();

		jQuery('#wpbeautify-facebook-modal').themodal({
			fadeDuration: 250,
			fadeDelay: 0.80,
			escapeClose: true,
			  clickClose: false,
			  showClose: true
		});
	});
	jQuery('#wpbeautify-fb-share-type').change(function(e) {
		this_val = jQuery(this).val();
		if (this_val == 1) {
			// timeline
			jQuery('#wpbeautify-fbshare-link-group').show();
		}
		else
			jQuery('#wpbeautify-fbshare-link-group').hide();

	});

	jQuery('#wpbeautify_share_pinterest').click(function(e) {
		if (jQuery(this).parent().hasClass('disabled'))
			return false;
		e.preventDefault();

		jQuery('#wpbeautify-pinterest-modal').themodal({
			fadeDuration: 250,
			fadeDelay: 0.80,
			escapeClose: true,
			  clickClose: false,
			  showClose: true
		});
	});

	jQuery('#wpbeautify-pinterest-do-share').click(function(e) {
		wpbeautify_insert_image(-1,!wpbeautify_is_edition, wp_beautify_do_pinterest_share);
	});

	jQuery('#wpbeautify_share_googleplus').click(function(e) {
		wpbeautify_load_gplus_albums();
		if (jQuery(this).parent().hasClass('disabled'))
			return false;
		e.preventDefault();
		// alert('Under construction');
		// return;
		jQuery('#wpbeautify-googleplus-modal').themodal({
			fadeDuration: 250,
			fadeDelay: 0.80,
			escapeClose: true,
			  clickClose: false,
			  showClose: true
		});
	});

	jQuery('#wpbeautify-googleplus-do-share').click(function(e) {
		wpbeautify_insert_image(-1,!wpbeautify_is_edition, wp_beautify_do_googleplus_share);
	});


	jQuery('#wpbeautify-twitter-do-share').click(function(e) {
		wpbeautify_insert_image(-1,!wpbeautify_is_edition, wp_beautify_do_twitter_share);
	});

	jQuery('#wpbeautify_share_twitter').click(function(e) {
		if (jQuery(this).parent().hasClass('disabled'))
			return false;
		// e.preventDefault();

		jQuery('#wpbeautify-twitter-modal').themodal({
			fadeDuration: 250,
			fadeDelay: 0.80,
			escapeClose: true,
			  clickClose: false,
			  showClose: true
		});
	});

	jQuery('#wpbeautify_save_dropbox').click(function(e) {
		e.preventDefault();
		if (jQuery(this).parent().hasClass('disabled'))
			return false;
		wpbeautify_insert_image(-1,!wpbeautify_is_edition, wp_beautify_do_dropbox_save);
	});

	jQuery('#wpbeautify_save_gdrive').click(function(e) {
		e.preventDefault();
		if (jQuery(this).parent().hasClass('disabled'))
			return false;

		wpbeautify_insert_image(-1,!wpbeautify_is_edition, wp_beautify_do_gdrive_save);



		// wpbeautify_insert_image(-1,!wpbeautify_is_edition, wp_beautify_do_googledrive_save);
	});


	jQuery('.numbersOnlyw').keydown(function(event) {
	                // Allow special chars + arrows 
	                if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 
	                    || event.keyCode == 27 || event.keyCode == 13 
	                    || (event.keyCode == 65 && event.ctrlKey === true) 
	                    || (event.keyCode >= 35 && event.keyCode <= 39)){
	                        return;
	                }else {
	                    // If it's not a number stop the keypress
	                    if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
	                        event.preventDefault(); 
	                    }   
	                }
	            });
	

	jQuery('#wpbeautify-gdrive-do-share').click(function(e) {
	});

	if (jQuery('#sample-permalink').length > 0) {
		// wpost_current_url = jQuery('#sample-permalink').html()
		// wpost_current_url = jQuery('#sample-permalink').html()
		//wpost_current_url = jQuery('<div/>').text(jQuery('#sample-permalink').html()).html();
		el_str = jQuery('#sample-permalink').html();
		wpost_current_url = el_str.substr(0, el_str.indexOf('<'))+ jQuery('#editable-post-name').html();
/*console.log(jQuery('#sample-permalink').first().html())
console.log( jQuery('#editable-post-name').html())
		wpost_current_url = jQuery('#sample-permalink').first().html() + jQuery('#editable-post-name').html()*/
		share_txt = jQuery('#title').val()+' - '+wpost_current_url;
	}
	else {
		wpost_current_url = ''
		share_txt = jQuery('#title').val()
	}
	jQuery('#wpbeautify-fb-share-link').val(wpost_current_url);
	jQuery('#wpbeautify-pinterest-share-link').val(wpost_current_url);
	jQuery('#wpbeautify-twitter-share-text').val(share_txt);
	// General Inicializations
	jQuery('.wpbeautify_multiselect').multiselect({});
	jQuery('.wpbtfy-colorpicker').minicolors();
	jQuery('.wpbtfy-colorpicker-opacity').minicolors({opacity: true});
	jQuery('.wpbtfy-spinner').spinedit();
}); // end document.ready


// var imgk;

function wpbeautify_set_backdrop_class() {
	jQuery('.modal-backdrop.fade.in').addClass('wpbtfy');
}

function wpbeautify_set_modal_height() {
	// var min_height = 200;
	header_height = jQuery('#wpbtfyModal .modal-header').height();
	// footer_height = jQuery('#wpbtfyModal .modal-footer').height();
	footer_height = 0/*header_height*/;
	var win_height = jQuery(window).height();
/*	if (win_height < min_height)
		modal_height = win_height;
	else
		modal_height = win_height*0.9;*/


	modal_height = win_height - footer_height - header_height - 75;

	// console.log('header: '+header_height)
	// console.log('footer: '+footer_height)
	// console.log('window: '+win_height)
	// console.log('body: '+modal_height)

	jQuery('#wpbtfyModal .modal-body').css('height', modal_height);
	jQuery('#wpbtfyModal .main-popup-content').css('height', (modal_height-25));
	  // jQuery('#wpbtfyModal #wpbeautify-stage').css('max-width', jQuery('.image-toolbox-bar').width()); // rmi353
	  // jQuery('#wpbtfyModal #wpbeautify-stage').css('max-width', 300); // rmi353

	 // sidebar
	 sidebar_height = jQuery('#wpbtfyModal .modal-body').height() - jQuery('#wpbtfy-tabs').height() /* - 40*/;
	 jQuery('#wpbeautify_sidebar').css('height', sidebar_height);
	 jQuery('#image-selector').css('height', sidebar_height + 20);
	 jQuery('#wpbeautify_right_sidebar').css('height', sidebar_height + jQuery('#wpbtfy-tabs').height() + 20);
	 jQuery('#wpbeautify-stage').css('height', sidebar_height-jQuery('.image-toolbox-bar').height()-54 /*-40*/);


	// jQuery('#wpbtfyModal .modal-body').css('overflow-y', 'auto');
	// : auto;
}


/* EDITOR: change size */
/* orientation: 0: both 1: horizontal, 2: vertical */
function resize_image_proportion(orientation, proportion) {
	if (!orientation || orientation == 1) {
		// horizontal
		new_width = wpbeautify_removeDecimals(original_width*proportion)
		global_width = new_width

		global_img_object.width(new_width);
		wpbeautify_resize_border(new_width, 0);
		global_stage.width(new_width);
		if (img_layer.scaleX() == -1) {
			img_layer.x(global_width);
			img_layer.draw();
		}
		jQuery('#img-new-width').val(new_width)
	}
	if (!orientation || orientation == 2) {
		// vertical
		new_height = wpbeautify_removeDecimals(original_height*proportion)
		global_height = new_height

		global_img_object.height(new_height);
		wpbeautify_resize_border(0, new_height);
		global_stage.height(new_height);
		if (img_layer.scaleY() == -1) {
			img_layer.y(global_height);
			img_layer.draw();
		}
		jQuery('#img-new-height').val(new_height)
	}
}

/* triggered: 1: width, 2: height */
function resize_image_size(width, height, keep_ratio, triggered, force_orig) {
	new_height = height
	new_width = width
	if (triggered == 1 && keep_ratio) {
		// need to update height value
		if (original_width) {
			var proportion = new_width/original_width
			new_height = wpbeautify_removeDecimals(original_height*proportion)
			jQuery('#img-new-height').val(new_height)
			global_height = new_height
			// console.log(triggered)
			// console.log(global_width)
			// console.log(global_height)
		}
	}
	else if (triggered == 2 && keep_ratio) {
		// need to update height value
		if (original_height) {
			var proportion = new_height/original_height
			new_width = wpbeautify_removeDecimals(original_width*proportion)
			jQuery('#img-new-width').val(new_width)
			global_width = new_width
		}
	}
	else if (!triggered) {
		jQuery('#img-new-height').val(new_height)
		jQuery('#img-new-width').val(new_width)
	}
	if (new_width) {
		global_img_object.width(new_width);
		global_stage.width(new_width);
		if (img_layer.scaleX() == -1) {
			img_layer.x(global_width);
			img_layer.draw();
		}
	}
	if (new_height) {
		global_img_object.height(new_height);
		global_stage.height(new_height);
		if (img_layer.scaleY() == -1) {
			img_layer.y(global_height);
			img_layer.draw();
		}
	}

	if (force_orig) {
		img_layer.scaleX(1)
		img_layer.scaleY(1)
		img_layer.x(0);
		img_layer.y(0);
		img_layer.draw();
	}

	global_width = new_width
	global_height = new_height
	wpbeautify_resize_border(new_width, new_height);
// console.log('New width = '+new_width+' y new height = '+new_height)
// console.log('global width = '+global_width+' y global height = '+global_height)
	// TO-DO: adjust sliders value too
}

function wpbeautify_resize_border(width, height) {
	border_width = parseInt(jQuery('#wpbeautify_border_width').val());

	if (border_layer) {
		if (width && wpbeautify_img_border)
			wpbeautify_img_border.width(width-border_width);
		if (height && wpbeautify_img_border)
			wpbeautify_img_border.height(height-border_width);
	}
	if (border_layer)
		border_layer.draw();
}

function wpbtfy_resize_image_predefined( size ) {
	// console.log(size)
	tamano = wpbtfy_get_size_from_label( size );
	resize_image_size(tamano[0], tamano[1], true, 0);
}
/*
	direction: horizontal/vertical
*/
function wpbeautify_flip_img(direction) {
	// global_img_object

	if (direction == 'horizontal') {
		xscale = img_layer.scaleX() * (-1);

		if (xscale < 0)
			newxpos = /*img_layer.x() +*/ global_width;
		else
			newxpos = 0;

		img_layer.x(newxpos)
		img_layer.scaleX(xscale);
	}
	else if (direction == 'vertical') {
		yscale = img_layer.scaleY() * (-1);

		if (yscale < 0)
			newypos = /*img_layer.y() +*/ global_height;
		else
			newypos = 0;

		img_layer.y(newypos)
		img_layer.scaleY(yscale);
	}
	img_layer.draw();
}


function wpbeautify_apply_auto_effect(effect) {
	wpbeautify_restore_effects_bar();
	wpbeautify_initialize_effects();

	var canvas = img_canvas
	var context = canvas.getContext("2d");

	// if (wpbeautify_previous_effect == 'effect') {
	var img=new Image();
	img.crossOrigin="anonymous";
	// img.src = current_img_url+'?t='+Math.random();
	img.src = current_img_url;
	img.onload = function() {
	context.drawImage(img,0,0);
	// }
	wpbeautify_previous_effect = effect;
	//Get data for the entire image
	var data = context.getImageData(0,0,canvas.width, canvas.height)

	switch (effect) {
		case 'black-and-white':
			JSManipulate.threshold.filter(data, {threshold: 127});
			break;
		case 'grayscale':
			JSManipulate.grayscale.filter(data);
			break;
		case 'sepia':
			JSManipulate.sepia.filter(data, {amount: 10});
			break;
		case 'bump':
			JSManipulate.bump.filter(data);
			break;
		case 'circle-smear':
			JSManipulate.circlesmear.filter(data);
			break;
		case 'cross-smear':
			JSManipulate.crosssmear.filter(data);
			break;
		case 'edge-detection':
			JSManipulate.edge.filter(data);
			break;
		case 'emboss':
			JSManipulate.emboss.filter(data);
			break;
		case 'oil-painting':
			JSManipulate.oil.filter(data);
			break;

		case 'sawtooth-ripples':
			JSManipulate.sawtoothripple.filter(data);
			break;
		case 'sine-ripples':
			JSManipulate.sineripple.filter(data);
			break;
		case 'sparkle':
			JSManipulate.bump.filter(data);
			break;

		// Custom Color Filters
		case '1960':
			JSManipulate.saturation.filter(data, {amount: 0.7});
			JSManipulate.contrast.filter(data, {amount: 1.3});
			JSManipulate.exposure.filter(data, {exposure: 2});
			break;

		case 'vintage':
			JSManipulate.grayscale.filter(data);
			JSManipulate.contrast.filter(data, {amount: 1.3});
			JSManipulate.noise.filter(data, {amount: 1.3});
			JSManipulate.sepia.filter(data, {amount: 1.3});
			JSManipulate.rgbadjust.filter(data, {red: 1.08, green:1.02, blue:1.04});
			JSManipulate.gamma.filter(data, {amount: 0.87});
			JSManipulate.vignette.filter(data, {amount: 0.5});
			break;

		case 'lomo':
			JSManipulate.brightness.filter(data, {amount: 0.15});
			JSManipulate.exposure.filter(data, {exposure: 1.15});
			JSManipulate.saturation.filter(data, {amount: 0.8});
			JSManipulate.gamma.filter(data, {amount: 0.8});
			JSManipulate.vignette.filter(data, {amount: 0.5});

			break;

			case 'clarity':
			JSManipulate.contrast.filter(data, {amount: 2});

				JSManipulate.sharpen.filter(data);
				JSManipulate.vignette.filter(data, {amount: 0.45});

				break;


			case 'sincity':
			JSManipulate.contrast.filter(data, {amount: 2});
			JSManipulate.brightness.filter(data, {amount: 0.15});
			JSManipulate.exposure.filter(data, {exposure: 1.10});
			JSManipulate.posterize.filter(data, {levels: 6});
			JSManipulate.grayscale.filter(data);
				break;

			case 'love':
			JSManipulate.brightness.filter(data, {amount: 0.5});
			JSManipulate.exposure.filter(data, {exposure: 1.08});
			JSManipulate.contrast.filter(data, {amount: 1.84});
			JSManipulate.gamma.filter(data, {amount: 0.3});

				break;


		case 'sunrise':
			JSManipulate.exposure.filter(data, {exposure: 1.035});
			JSManipulate.saturation.filter(data, {amount: 0.95});
			JSManipulate.sepia.filter(data, {amount: 10});
			JSManipulate.rgbadjust.filter(data, {red: 1.08, green:1, blue:1.08});

			JSManipulate.contrast.filter(data, {amount: 1.85});
			 JSManipulate.gamma.filter(data, {amount: 1.2});
			JSManipulate.vignette.filter(data, {amount: 0.55});

			break;

		case 'grungy':
			 JSManipulate.gamma.filter(data, {amount: 1.5});

			JSManipulate.saturation.filter(data, {amount: 0.4});
			JSManipulate.contrast.filter(data, {amount: 1.5});
			JSManipulate.noise.filter(data, {amount: 5});

			JSManipulate.vignette.filter(data, {amount: 0.5});

			break;

		case 'pinhole':
			JSManipulate.grayscale.filter(data);
			JSManipulate.sepia.filter(data, {amount: 1});
			JSManipulate.exposure.filter(data, {exposure: 1.1});
			JSManipulate.contrast.filter(data, {amount: 1.15});
			JSManipulate.vignette.filter(data, {amount: 0.6});

			break;

		case 'crossprocess':
			JSManipulate.exposure.filter(data, {exposure: 1.2});
			// JSManipulate.sepia.filter(data, {amount: 7});
			JSManipulate.rgbadjust.filter(data, {red: 1.03, green:1, blue:1.08});
			JSManipulate.contrast.filter(data, {amount: 1.15});
			JSManipulate.saturation.filter(data, {amount: 1.7});
			 JSManipulate.gamma.filter(data, {amount: 1.5});
			break;

		default:
			break;
	}
	context.putImageData(data,0,0);
	// img_canvas.draw();
	img_layer.draw();
}
}

function wpbeautify_reset_effect(effect_name) {
	wpbeautify_initialize_effects(effect_name);
}


function wpbeautify_initialize_effects(effect_name) {
	if (!effect_name) effect_name = 0;

	if (!effect_name || effect_name == 'blur') {
		current_custom_effects.blur = new Array();
		current_custom_effects.blur.started = 0;
		current_custom_effects.blur.value = 0;
	}

	if (!effect_name || effect_name == 'blur') {
		current_custom_effects.brightness = new Array();
		current_custom_effects.brightness.started = 0;
		current_custom_effects.brightness.value = 0;
	}

	if (!effect_name || effect_name == 'contrast') {
		current_custom_effects.contrast = new Array();
		current_custom_effects.contrast.started = 0;
		current_custom_effects.contrast.value = 0;
	}

	if (!effect_name || effect_name == 'diffusion') {
		current_custom_effects.diffusion = new Array();
		current_custom_effects.diffusion.started = 0;
		current_custom_effects.diffusion.value = 0;
	}

	if (!effect_name || effect_name == 'exposure') {
		current_custom_effects.exposure = new Array();
		current_custom_effects.exposure.started = 0;
		current_custom_effects.exposure.value = 1;
	}

	if (!effect_name || effect_name == 'gamma') {
		current_custom_effects.gamma = new Array();
		current_custom_effects.gamma.started = 0;
		current_custom_effects.gamma.value = 0;
	}

	if (!effect_name || effect_name == 'hue') {
		current_custom_effects.hue = new Array();
		current_custom_effects.hue.started = 0;
		current_custom_effects.hue.value = 0;
	}

	if (!effect_name || effect_name == 'noise') {
		current_custom_effects.noise = new Array();
		current_custom_effects.noise.started = 0;
		current_custom_effects.noise.value = 0;
	}

	if (!effect_name || effect_name == 'oilpainting') {
		current_custom_effects.oilpainting = new Array();
		current_custom_effects.oilpainting.started = 0;
		current_custom_effects.oilpainting.value = 0;
	}

	if (!effect_name || effect_name == 'opacity') {
		current_custom_effects.opacity = new Array();
		current_custom_effects.opacity.started = 0;
		current_custom_effects.opacity.value = 0;
	}

	if (!effect_name || effect_name == 'pixelation') {
		current_custom_effects.pixelation = new Array();
		current_custom_effects.pixelation.started = 0;
		current_custom_effects.pixelation.value = 0;
	}

	if (!effect_name || effect_name == 'posterize') {
		current_custom_effects.posterize = new Array();
		current_custom_effects.posterize.started = 0;
		current_custom_effects.posterize.value = 0;
	}

	if (!effect_name || effect_name == 'saturation') {
		current_custom_effects.saturation = new Array();
		current_custom_effects.saturation.started = 0;
		current_custom_effects.saturation.value = 0;
	}

	if (!effect_name || effect_name == 'vignette') {
		current_custom_effects.vignette = new Array();
		current_custom_effects.vignette.started = 0;
		current_custom_effects.vignette.value = 0;
	}

	if (!effect_name || effect_name == 'red') {
		current_custom_effects.red = new Array();
		current_custom_effects.red.started = 0;
		current_custom_effects.red.value = 1;
	}

	if (!effect_name || effect_name == 'green') {
		current_custom_effects.green = new Array();
		current_custom_effects.green.started = 0;
		current_custom_effects.green.value = 1;
	}

	if (!effect_name || effect_name == 'blue') {
		current_custom_effects.blue = new Array();
		current_custom_effects.blue.started = 0;
		current_custom_effects.blue.value = 1;
	}
	// reset vars to original values
}

function wpbeautify_restore_effects_bar() {
	jQuery('.manual-effect-filter').each(function( index ) {
		this_el = jQuery(this);
		val = jQuery(this).attr('data-original-value');
		this_el.sliderstrap('setValue', parseInt(val))
	});
}

var wpbeautify_previous_effect = '';
function wpbeautify_apply_effect(effect, value) {
	var canvas = img_canvas
	var context = canvas.getContext("2d");

	// if (wpbeautify_previous_effect == 'effect') {
	var img=new Image();
	img.crossOrigin="anonymous";
	img.src = current_img_url;
	img.onload = function() {

	context.drawImage(img,0,0);
	// }
	// wpbeautify_previous_effect = effect;
	//Get data for the entire image
	var data = context.getImageData(0,0,canvas.width, canvas.height)

	switch (effect) {
		case 'blur':
			amount = value/10

			current_custom_effects.blur.started = 1;
			current_custom_effects.blur.value = amount;

			// JSManipulate.blur.filter(data, {amount: amount});
			break;
		case 'brightness':
			amount = value/100

			current_custom_effects.brightness.started = 1;
			current_custom_effects.brightness.value = amount;

			// JSManipulate.brightness.filter(data, {amount: amount});
			break;
		case 'contrast':
			amount = (value+100)/100
			current_custom_effects.contrast.started = 1;
			current_custom_effects.contrast.value = amount;
			break;
		case 'diffusion':
			amount = value //(value+100)/100
			current_custom_effects.diffusion.started = 1;
			current_custom_effects.diffusion.value = amount;
			break;
		case 'exposure':
			amount = value/20 //(value+100)/100
			current_custom_effects.exposure.started = 1;
			current_custom_effects.exposure.value = amount;

			break;
		case 'gamma':
			amount = (value+100)/100 //(value+100)/100
			current_custom_effects.gamma.started = 1;
			current_custom_effects.gamma.value = amount;
			break;

		case 'hue':
			amount = value/100 //(value+100)/100
			current_custom_effects.hue.started = 1;
			current_custom_effects.hue.value = amount;
			break;
		case 'noise':
			amount = value //(value+100)/100
			current_custom_effects.noise.started = 1;
			current_custom_effects.noise.value = amount;
			break;

		case 'oil-painting':
			amount = value/20 //(value+100)/100
			current_custom_effects.oilpainting.started = 1;
			current_custom_effects.oilpainting.value = amount;

			break;
		case 'opacity':
			amount = value/100 //(value+100)/100
			current_custom_effects.opacity.started = 1;
			current_custom_effects.opacity.value = amount;
			break;
		case 'pixelation':
			amount = value/2 //(value+100)/100
			current_custom_effects.pixelation.started = 1;
			current_custom_effects.pixelation.value = amount;

			break;
		case 'posterize':
			amount = value/3 //(value+100)/100
			current_custom_effects.posterize.started = 1;
			current_custom_effects.posterize.value = amount;
			break;
		case 'saturation':
			amount = (value+100)/100 //(value+100)/100
			current_custom_effects.saturation.started = 1;
			current_custom_effects.saturation.value = amount;
			break;
		case 'vignette':
			amount = (value+100)/200 //(value+100)/100
			current_custom_effects.vignette.started = 1;
			current_custom_effects.vignette.value = amount;
			break;

		case 'red':
			amount = (value*2) / 100 //(value+100)/100
			current_custom_effects.red.started = 1;
			current_custom_effects.red.value = amount;
			// JSManipulate.rgbadjust.filter(data, {red: 1, green:1, blue:1});
			break;
		case 'green':
			amount = (value*2) / 100 //(value+100)/100
			current_custom_effects.green.started = 1;
			current_custom_effects.green.value = amount;
			break;
		case 'blue':
			amount = (value*2) / 100 //(value+100)/100
			current_custom_effects.blue.started = 1;
			current_custom_effects.blue.value = amount;
			break;
		default:
			break;
	}

	if (current_custom_effects.blur.started)
		JSManipulate.blur.filter(data, {amount: current_custom_effects.blur.value});

	if (current_custom_effects.brightness.started)
		JSManipulate.brightness.filter(data, {amount:  current_custom_effects.brightness.value});

	if (current_custom_effects.contrast.started)
		JSManipulate.contrast.filter(data, {amount:  current_custom_effects.contrast.value});

	if (current_custom_effects.diffusion.started)
		JSManipulate.diffusion.filter(data, {scale: current_custom_effects.diffusion.value});

	if (current_custom_effects.exposure.started && (current_custom_effects.exposure.value != 1))
		JSManipulate.exposure.filter(data, {exposure: current_custom_effects.exposure.value});
		// JSManipulate.exposure.filter(data, {exposure: 1});

	if (current_custom_effects.gamma.started)
		JSManipulate.gamma.filter(data, {amount: current_custom_effects.gamma.value});

	if (current_custom_effects.hue.started)
		JSManipulate.hue.filter(data, {amount: current_custom_effects.hue.value});

	if (current_custom_effects.noise.started)
		JSManipulate.noise.filter(data, {amount: current_custom_effects.noise.value});

	if (current_custom_effects.oilpainting.started)
			JSManipulate.oil.filter(data, {range: current_custom_effects.oilpainting.value});

	if (current_custom_effects.opacity.started)
			JSManipulate.opacity.filter(data, {amount: current_custom_effects.opacity.value});

	if (current_custom_effects.pixelation.started && (current_custom_effects.pixelation.value > 3))
			JSManipulate.pixelate.filter(data, {size: current_custom_effects.pixelation.value});

	if (current_custom_effects.posterize.started)
			JSManipulate.posterize.filter(data, {levels: current_custom_effects.posterize.value});

	if (current_custom_effects.saturation.started)
			JSManipulate.saturation.filter(data, {amount: current_custom_effects.saturation.value});

	if (current_custom_effects.vignette.started)
			JSManipulate.vignette.filter(data, {amount: current_custom_effects.vignette.value});

	if (current_custom_effects.red.started || current_custom_effects.green.started || current_custom_effects.blue.started)
			JSManipulate.rgbadjust.filter(data, {red: current_custom_effects.red.value, green:current_custom_effects.green.value, blue:current_custom_effects.blue.value});




	//Now finally put the data back into the context, which will render
	//the manipulated image on the page.
	context.putImageData(data,0,0);
	img_layer.draw();
}
	return;
}

function wpbeautify_restore_original_img() {
	var canvas = img_canvas
	var context = canvas.getContext("2d");
// console.log('restaura')

wpbeautify_restore_effects_bar();
wpbeautify_initialize_effects();

jQuery('.auto-effect-filter').removeClass('img_selected')
	// if (wpbeautify_previous_effect == 'effect') {
		var img=new Image();
		img.crossOrigin="anonymous";
		img.src = current_img_url;
	img.onload = function() {

		context.drawImage(img,0,0);
	// }
	//Get data for the entire image
	var data = context.getImageData(0,0,canvas.width, canvas.height)
	context.putImageData(data,0,0);
	img_layer.draw();
}
}

function wpbeautify_dash_to_num(style, line_width) {
	switch (style) {
		case 'normal':
			return  0;
			break;
		case 'dashed':
			return Array(line_width, line_width*2);
		case 'dashed2':
			return Array(line_width*2, line_width);
		case 'dashed3':
			return Array(line_width*3, line_width);
		case 'mixed':
			return Array(line_width*2, 30, 1, 30);
		case 'dotted':
			return Array(1, line_width*2);
		default:
			return 0;
	}
}

function wpbeautify_linejoin_to_num(style) {
	switch (style) {
		case 'normal':
			return 'square';
		case 'dashed':
			return 'square';
		case 'dashed2':
			return 'butt';
		case 'dashed3':
			return 'butt';
		case 'mixed':
			return 'round';
		case 'dotted':
			return 'round';
		default:
			return 'square';
	}
}

function wpbeautify_apply_border() {
	border_width = parseInt(jQuery('#wpbeautify_border_width').val());
	border_color = jQuery('#border-color').val();
	dash_style = jQuery('#wpbeautify_border_style').val();
	  // console.log(dash_style);
	if (!wpbeautify_img_border) {
		border_layer = new Konva.Layer()
		wpbeautify_img_border = new Konva.Rect({
			x: border_width/2,
			y: border_width/2,
			width: global_width-border_width,
			height: global_height-border_width,
			fill: 'transparent',
			stroke: border_color,
			strokeWidth: border_width,
			lineCap : wpbeautify_linejoin_to_num(dash_style),
			dash : wpbeautify_dash_to_num(dash_style, border_width)/*,
			cornerRadius: 30*/
		});
		border_layer.add(wpbeautify_img_border);
		global_stage.add(border_layer)
		border_layer.setZIndex(3000);
		border_layer.setListening(false)
	}
	else {
		wpbeautify_img_border.stroke(border_color)
		wpbeautify_img_border.strokeWidth(border_width)
		wpbeautify_img_border.lineCap(wpbeautify_linejoin_to_num(dash_style))
		wpbeautify_img_border.dash(wpbeautify_dash_to_num(dash_style, border_width))
		wpbeautify_img_border.x(border_width/2)
		wpbeautify_img_border.y(border_width/2)
		border_layer.setZIndex(3000);

		/*wpbeautify_img_border.width(global_width-border_width)
		wpbeautify_img_border.height(global_height-border_width)*/
		wpbeautify_resize_border(global_width/*-border_width*/, global_height/*-border_width*/)
	}
	wpbeautify_img_border.visible(true)

	border_layer.draw()
}

function wpbeautify_remove_border() {
	wpbeautify_img_border.visible(false)
	border_layer.draw()
}

function wpbeautify_border_to_top() {
	border_layer.setZIndex(3000);
	border_layer.draw()
}


function wpbeautify_thumbnail_clicked(this_attachment) {
	jQuery('#btn-edit-image-main').show();
    keyword = jQuery('#wpbtfy-search-free-imgs-keyword').val()

    // Highlight the newly selected image
    this_image = this_attachment.find('img');
    this_image_width = this_image.attr('data-width');
    this_image_height = this_image.attr('data-height');

    img_title = this_image.attr('title')
    jQuery('#wpbeautify_img_title').val(img_title);

    jQuery('#wpbeautify_preview_img').attr('src', this_image.attr('src'));
	wpbeautify_img_just_selected = this_image.attr('data-url')

    if (this_image_width != '0' && this_image_height != '0')
    	jQuery('#wpbeautify_img_dimensions').html(this_image_width+' x '+this_image_height);
    else jQuery('#wpbeautify_img_dimensions').html('');
	jQuery('#wpbeautify_img_source_link').html(this_image.attr('data-origin'));
	jQuery('#wpbeautify_img_source_link').attr('href', this_image.attr('data-original-url'));

	jQuery('#wpbeautify_file_name').val(keyword);

	jQuery('#wpbeautify_img_name').html(this_image.attr('title'));
	if (this_image.attr('data-attribution') == '1') {
		jQuery("#wpbeautify_needs_attribution").show();
		license = wpbeautify_licenses[this_image.attr('data-license')];
		jQuery("#wpbeautify_img_caption").val(license[1]+' by <a rel="nofollow" href="'+this_image.attr('data-author_url')+'" target="_blank">'+this_image.attr('data-author_name')+'</a>'); // HERE!!
	}
	else {
		jQuery("#wpbeautify_img_caption").val('');
		jQuery("#wpbeautify_needs_attribution").hide();
	}
	file_ext = this_image.attr('data-url').split('.').pop();
	jQuery('#wpbeautify_file_extension').html('.'+file_ext);

	if (this_image_width > this_image_height) {
		// horizontal
		medium_width = 300;
		medium_height = Math.floor((300 / this_image_width) * this_image_height);
	} else {
		medium_height = 300;
		medium_width = Math.floor((300 / this_image_height) * this_image_width);
	}

	jQuery('#wpbeautify_image_size option:nth-child(2)').html('Medium - '+medium_width+' x '+medium_height)
	jQuery('#wpbeautify_image_size option:nth-child(3)').html('Full Size - '+this_image_width+' x '+this_image_height)


}

function wpbeautify_social_thumbnail_clicked(this_attachment) {
    this_image = this_attachment.find('img');
	wpbeautify_img_just_selected = this_image.attr('data-url')

	file_details = wpbeautify_get_file_name_from_url(this_image.attr('data-url'))
	// console.log(file_details)
	jQuery('#wpbeautify_file_name').val(file_details[0]);
	img_title = this_image.attr('title')
	jQuery('#wpbeautify_img_title').val(img_title);
	jQuery('#wpbeautify_img_alt').val(img_title);
}

function wpbeautify_do_image_search () {
	sites_selected = jQuery('#wpbeautify_freeimg_sources option:selected');
	sites_to_query = new Array();

	// console.log(sites_selected)

	jQuery.each(sites_selected, function(i, val) {
		this_el = jQuery(this);
		if (this_el.val() != 'all-sites')
			sites_to_query.push(this_el.val());
	});
	if (sites_to_query.length == 0) sites_to_query = 0;

	type_photo = 'true';
	type_clipart = 'true';

	img_type = jQuery('#wpbeautify_freeimg_type').val();
	if (img_type == 'photo')
		type_clipart = 0;
	if (img_type == 'clipart')
		type_photo = 0;

	yes_attribution = 'true';
	no_attribution = 'true';

	attr_type = jQuery('#wpbeautify_attribution_required').val();
	if (attr_type == 'attribution')
		no_attribution = 'false'
	else if (attr_type == 'noattribution')
		yes_attribution = 'false'

	jQuery("#wpbtfy_free_imgs_div").html('<div id="wpbeautify_freeimg_loading" class="wpbeautify-loading" style="display:block"></div>')

	var data = {
		action: 'wpbeautify_search_free_image',
		keyword : jQuery('#wpbtfy-search-free-imgs-keyword').val(),
		page : wpbeautify_free_img_page,
		attribution : yes_attribution,
		noattribution : no_attribution,
		only_modifiables : jQuery('#only_ok_modify').is(':checked'),
		photo : type_photo,
		clipart : type_clipart,
		sites : sites_to_query,
		is_small : false
	};

	jQuery.post(ajaxurl, data, function(response) {
		jQuery("#wpbtfy_free_imgs_div").html(response);
		jQuery("#wpbtfy_free_imgs_div").show();
	});
}

function wpbeautify_get_file_name_from_url(imgurl) {
	if (!imgurl) return 0;
	http_pos = imgurl.lastIndexOf('%2F')
	if (http_pos != -1) {
		// image is a full url
		// file_name = imgurl.split('/').pop();
		imgurl = imgurl.split('%2F').pop();

	}
	file_name = imgurl.split('/').pop();

	dot_position = file_name.lastIndexOf('.')
	name = file_name.substring(0, dot_position)
	extension = file_name.substring(dot_position+1)
	var name_decoded = unescape(name);
	return new Array(name_decoded, extension);
}

function wpbeautify_update_fileext(filename, extension) {
	// console.log('kk')
	jQuery('#wpbeautify_file_name').val(filename);
	jQuery('#wpbeautify_file_extension').html('.'+extension);
}
/* Downloads an external image into wp */
function wpbeautify_download_external_img(imgurl, callback, force_file_name, js_download, file_content, update_sidebar) {
	var data = {
		action: 'wpbeautify_external_upload',
		url : imgurl
	};

	if (force_file_name)
		data.file_name = force_file_name;

	if (js_download) {
		data.content_sent = 1;
		data.file_contents = file_content;
	}

	jQuery.post(ajaxurl, data, function(response) {
			wpbeautify_set_up_stage(response);
			wpbeautify_img_just_selected = response
			jQuery('#wpbeautify_preview_img').attr('src', response)
			if (force_file_name)
				file_name = force_file_name;
			else
				file_name = wpbeautify_get_file_name_from_url(imgurl);
			if (update_sidebar)
				wpbeautify_update_fileext(file_name[0], file_name[1]); // rmi353, acabo de cambiar
			// jQuery('#wpbeautify_img_title').val(file_name[0]);
			// jQuery('#wpbeautify_img_caption').val('');

			wpbeautify_hide_loading()
			wpbeautify_enable_editor()
			if (callback)
				callback();
	});
}

function wpbeautify_urldl_finished() {
	jQuery('#wpbeautify_selurl_loading').hide();
	jQuery('#wpbeautify_selurl_loaded').show();
	jQuery('#btn-edit-image-main').show();
    wpbeautify_enable_actions(1);
}

function wpbeautify_freeimage_finished() {
	// jQuery('#wpbtfy_free_imgs_div').html(wpbtfy_loaded_txt);
	wpbeatify_hide_loading_modal();
	jQuery('#wpbtfy-tabs a:last').tab('show');
}

function wpbeautify_hide_loading() {
	jQuery('.wpbeautify-loading').hide();
}

function wpbeautify_roundToTwo(num) {
	return +(Math.round(num + "e+2")  + "e-2");
}

function wpbeautify_removeDecimals(num) {
	return /*parseInt*/Math.round(num);
}


function wpbeautify_enable_editor() {
	jQuery('#wpbtfy_image_editor_tab').removeClass('disabled');
}

function wpbeautify_reset_popup() {

	/*if (!wpbtfy_orig_send_to_editor)
		wpbtfy_orig_send_to_editor = parent.window.send_to_editor;*/

	wpbeautify_is_edition = 0;
	jQuery('#wpbeautify_right_sidebar').hide();
	jQuery('#wpbtfy-tabs a:first').tab('show');


	jQuery('#wpbtfy_selector_first_tab').tab('show')
	if (!jQuery('#wpbtfy_image_editor_tab').hasClass('disabled'))
		jQuery('#wpbtfy_image_editor_tab').addClass('disabled')

	jQuery('.wpbtfy-left-panel').hide();
	jQuery('#wpbtfy-panel-general').show();
	jQuery('#wpbeautify_preview_img').attr('src', '');
	jQuery('#wpbeautify-uploader-info').hide();
	jQuery('#wpbeautify_wpimage_results').html('');
	jQuery('#wpbeautify-image-by-url-url').val('');
	jQuery('#wpbeautify_selurl_loaded').hide();
	jQuery('#wpbtfy-search-free-imgs-keyword').val('');
	jQuery('#wpbtfy_free_imgs_div').html(wpbeautify_vars.noflickr);
	jQuery('#wpbtfy-use-free-imgs-btn').attr('disabled', 'disabled')
	jQuery('#wpbeautify_dropbox_results').hide();
	jQuery('#wpbeautify_meme_results').html('');
	jQuery('#wpbeautify_extra_results').html('');
	jQuery('#wpbeautify_youzign_results').html('');
	jQuery('#wpbeautify_meme_msg2').hide();
	jQuery('#wpbeautify_meme_msg1').show();
	jQuery('#wpbeautify_extra_msg2').hide();
	jQuery('#wpbeautify_extra_msg1').show();
	jQuery('#wpbeautify_youzign_msg2').hide();
	jQuery('#wpbeautify_youzign_msg1').show();

	/* Social */
	jQuery('.wpbeautify_album_name').html('');
	jQuery('.social_image_results').html('')
	jQuery('.social_panel_info').show();

	/* Sidebar */
	jQuery('#wpbeautify_img_dimensions').html('')
	jQuery('#wpbeautify_img_source_link').html('')
	jQuery('#wpbeautify_img_name').html('')
	jQuery('#wpbeautify_needs_attribution').hide()
	jQuery('#wpbeautify_file_name').val('')
	jQuery('#wpbeautify_file_extension').html('.')
	jQuery('#wpbeautify_img_title').val('')
	jQuery('#wpbeautify_img_caption').val('')
	jQuery('#wpbeautify_img_description').val('')
	jQuery('#wpbeautify_img_alt').val('')

	wpbeautify_enable_actions(false);

	/* Editor */
	jQuery('#wpbeautify_current_texts').html('')
	jQuery('.auto-effect-filter').removeClass('img_selected')

	wpbeautify_restore_effects_bar();
	wpbeautify_initialize_effects();

	jQuery('#wpbtfy-search-layer-imgs-keyword').val('')
	jQuery('#wpbtfy_free_imgs_layer_div').html('');
	jQuery('#wpbtfy-image-layer-insert-image').attr('disabled', 'disabled')

	jQuery("#image-size-slider-hor").sliderstrap('setValue', 0);
	jQuery("#image-size-slider-vert").sliderstrap('setValue', 0);
	jQuery("#wpbeautify_resize_keep_proportion").attr('checked', true);

	jQuery("#wpbeautify_img_predefined_resize").val(0);
	jQuery("#wpbeautify_img_predefined_crop").val(0);
	// to-do: reset canvas!

}

function wpbeautify_image_selected(url) {
	wpbeautify_set_up_stage(url);
/*	var img = new Image();
	img.onload = function() {
		global_width = this.width
		global_height = this.height
		original_width = global_width
		original_height = global_height
		wpbeautify_add_image2canvas(url, this.width, this.height)
	}
	img.src = url;*/
	jQuery('#wpbeautify_preview_img').attr('src', url)

	file_ext = url.split('.').pop();
	jQuery('#wpbeautify_file_extension').html('.'+file_ext);

	// jQuery('#wpbeautify_edit_img').show();
}

 /* Set up the whole stage */
/*
	Layers:
		Image
		Border
		Text
		Shapes
		Free drawing

*/



function wpbeautify_set_up_stage(imageurl, callback, bg_color, force_width, force_height) {
	if (!bg_color)
		bg_color = false;
// console.log(imageurl)
wpbeautify_is_edition = 1;
	jQuery('#wpbeautify_right_sidebar').show();
	// if I have an image url, I already know the width/height; otherwise initialise to 300x300
	current_img_url = imageurl;

	global_stage = new Konva.Stage({
		container: 'wpbeautify-stage',
		width: 300,
		height: 300
	});
	// global_stage = stage
	img_layer = new Konva.Layer();
	global_stage.add(img_layer);

	border_layer = new Konva.Layer();
	global_stage.add(border_layer);

	/*text_layer = new Konva.Layer();
	global_stage.add(text_layer);*/

/*	shapes_layer = new Konva.Layer();
	global_stage.add(shapes_layer);*/
	// wpbeautify_setup_shapes_layer()

	// wpbeautify_setup_freedraw_layer();



	if (imageurl) {
		// create an offscreen canvas
		var canvas=document.createElement("canvas");
		img_canvas = canvas
		var ctx=canvas.getContext("2d");

		// load the image
		var img=new Image();
		// global_img_object = img;
		// img.onload=start;
		img.crossOrigin="anonymous";
		img.src = imageurl;
		// function start(){
		img.onload = function() {
			global_stage.width(img.width);
			global_stage.height(img.height);

			global_height = img.height
			global_width = img.width
			original_width = img.width
			original_height = img.height
			wpbeautify_update_canvas_size(global_height, global_width);
			canvas.width=img.width;
			canvas.height=img.height;
			ctx.drawImage(img,0,0);

			jQuery('#img-original-height').html(global_height)
			jQuery('#img-original-width').html(global_width)

			jQuery('#img-new-height').val(global_height)
			jQuery('#img-new-width').val(global_width)

			jQuery("#image-size-slider-hor").sliderstrap('setValue', 0);
			jQuery("#image-size-slider-vert").sliderstrap('setValue', 0);


			// create a new Konva.Image
			// The image source is the offscreen canvas
			global_img_object = new Konva.Image({
				x:0,
			  	y:0,
			  	image:canvas,
			  	draggable: false
			});
			img_layer.add(global_img_object);
			img_layer.draw();
			if (callback)
				callback();
		}
	}
	else if (bg_color) {
		var canvas=document.createElement("canvas");
		img_canvas = canvas
		var ctx=canvas.getContext("2d");

		global_stage.width(force_width);
		global_stage.height(force_height);

		global_height = force_height
		global_width = force_width
		original_width = force_width
		original_height = force_height
		wpbeautify_update_canvas_size(global_height, global_width);
		canvas.width=force_width;
		canvas.height=force_height;

		rectangle = new Konva.Rect({
			x:0,
		  	y:0,
		  	width: force_width,
		  	height: force_height,
		  	fill: bg_color,
		  	draggable: false
		});
		img_layer.add(rectangle);
		img_layer.draw();
		if (callback)
			callback();
	}
}

function wpbeautify_update_canvas_size(height, width) {
	// set the size for all layers
	border_layer.width(width);
	border_layer.height(height);

	/*text_layer.width(width);
	text_layer.height(height);*/

	// rmi353, resize all text layers

	/*shapes_layer.width(width);
	shapes_layer.height(height);

	shapes_painting_rect.width(width);
	shapes_painting_rect.height(height);
	shapes_layer.draw();*/

	// rmi353, resize all shapes layers

	/*freedraw_layer.width(width);
	freedraw_layer.height(height);

	background_painting.width(width);
	background_painting.height(height);


	freedraw_layer.draw();*/

	// rmi353, resize all free draw

	/*shapes_layer.width(width);
	shapes_layer.height(height);*/

}


// DRAW SHAPES
var shapes_painting_rect;
var shapes_list = new Array();
var shape_type = '';

function wpbeautify_setup_shapes_layer() {
	shapes_layer = new Konva.Layer();
	shape_type = jQuery('#wpbeautify-shape-type').val();

	shapes_painting_rect = new Konva.Rect({
	    x:0,
	    y:0,
	    width:global_width,
	    height:global_height,
	    draggable : false
	})
	shapes_layer.add(shapes_painting_rect);
	global_stage.add(shapes_layer);
	var shape, down = false,oPoint, space=false;

	shapes_layer.on("mousedown", function(e) {
		// console.log(e)
		if (!painting_shapes) return;
	    document.body.style.cursor = 'crosshair';

	    down = true;
	    oPoint = {x:e.evt.layerX, y:e.evt.layerY};
	    var r = Math.round(Math.random()*255),
	        g = Math.round(Math.random()*255),
	        b = Math.round(Math.random()*255);

	    var line_color = jQuery('#shape-line-color').val();
	    // var fill_color = jQuery('#shape-fill-color').val();
	    var fill_color = jQuery('#shape-fill-color').minicolors('rgbObject');
	    // var opacity = jQuery('#shape-fill-color').attr('data-opacity')
	    var border_width = jQuery('#wpbeautify_shape_border_width').val();
	    var border_style = jQuery('#wpbeautify_shape_border_style').val();
	    var shape_type_txt = '';

	    // lineCap : wpbeautify_linejoin_to_num(dash_style),
	    // dash : wpbeautify_dash_to_num(dash_style, border_width)


		if (shape_type == 'rectangle' || shape_type == 'rectangle-round') {
		    shape = new Konva.Rect({
		        x: e.evt.layerX,
		        y: e.evt.layerY,
		        width: 11,
		        height: 1,
		        fill: 'rgba('+fill_color.r+','+fill_color.g+','+fill_color.b+','+fill_color.a+')',
		        stroke: line_color,
		        strokeWidth: border_width,
		        draggable: true,
		        lineCap : wpbeautify_linejoin_to_num(border_style),
		        dash : wpbeautify_dash_to_num(border_style, border_width)
		    });
		    if (shape_type == 'rectangle-round') {
		    	shape.cornerRadius(40);
		    	shape_type_txt = 'Rectangle (round)';
		    }
		    else
		    	shape_type_txt = 'Rectangle	';
		}

		else if (shape_type == 'circle') {
		    shape = new Konva.Circle({
		        x: e.evt.layerX,
		        y: e.evt.layerY,
		        width: 11,
		        height: 1,
		        fill: 'rgba('+fill_color.r+','+fill_color.g+','+fill_color.b+','+fill_color.a+')',
		        stroke: line_color,
		        strokeWidth: border_width,
		        draggable: true,
		        lineCap : wpbeautify_linejoin_to_num(border_style),
		        dash : wpbeautify_dash_to_num(border_style, border_width)
		    });
		    shape_type_txt = 'Circle';
		}

		else if (shape_type == 'ellipse') {
		    shape = new Konva.Ellipse({
		        x: e.evt.layerX,
		        y: e.evt.layerY,
		        width: 11,
		        height: 1,
		        fill: 'rgba('+fill_color.r+','+fill_color.g+','+fill_color.b+','+fill_color.a+')',
		        stroke: line_color,
		        strokeWidth: border_width,
		        draggable: true,
		        lineCap : wpbeautify_linejoin_to_num(border_style),
		        dash : wpbeautify_dash_to_num(border_style, border_width)
		    });
		    shape_type_txt = 'Ellipse';
		}

		else if (shape_type == 'star') {
		    shape = new Konva.Star({
		        x: e.evt.layerX,
		        y: e.evt.layerY,
		        width: 11,
		        height: 1,
		        fill: 'rgba('+fill_color.r+','+fill_color.g+','+fill_color.b+','+fill_color.a+')',
		        stroke: line_color,
		        strokeWidth: border_width,
		        draggable: true,
		        numPoints: 6,
		        lineCap : wpbeautify_linejoin_to_num(border_style),
		        dash : wpbeautify_dash_to_num(border_style, border_width)
		    });
		    shape_type_txt = 'Star';
		}

		else if (shape_type == 'line') {
		    shape = new Konva.Line({
		        /*x: e.layerX,
		        y: e.evt.layerY,
		        width: 11,
		        height: 1,*/
		        stroke: line_color,
		        strokeWidth: border_width,
		        lineCap : wpbeautify_linejoin_to_num(border_style),
		        dash : wpbeautify_dash_to_num(border_style, border_width)
		    });
		    shape_type_txt = 'Line';
		}

		else if (shape_type == 'wedge') {
		    shape = new Konva.Wedge({
		    	x: e.evt.layerX,
		    	y: e.evt.layerY,
		    	width: 11,
		    	height: 1,
		    	fill: 'rgba('+fill_color.r+','+fill_color.g+','+fill_color.b+','+fill_color.a+')',
		    	stroke: line_color,
		    	strokeWidth: border_width,
		    	draggable: true,
		    	lineCap : wpbeautify_linejoin_to_num(border_style),
		    	dash : wpbeautify_dash_to_num(border_style, border_width)	,
		    		        radius: 5,
		    		          angleDeg: 60,
		    		          rotationDeg: -120
		    });
		}

	    shape.on('mouseover', function () {
	                    document.body.style.cursor = 'move';
	                });
	    shape.on('mouseout', function () {
	                    document.body.style.cursor = 'default';
	                });


	    shapes_layer.add(shape);
		wpbtfy_add_layer( 'shape', shapes_layer, shape_type_txt/*, 0, shapes_layer*/ );

	    shapes_list.push(new Array(1, shape, shapes_layer));
	    // shapes_list.push(shape);
	});
	window.onkeyup = function(evt) {
		// console.log(evt)
	    if (evt.keyCode == 32) {
	      space = false;
	    }
	};
	window.onkeydown = function(evt) {
	    if (evt.keyCode == 32) {
	      space = true;
	    }
	};
	shapes_layer.on("mousemove", function(e) {
// console.log(e)
		if (!painting_shapes) return;

	    if (!down) return;

	    e.x = e.evt.layerX;
	    e.y = e.evt.layerY;

	    var p = shape.attrs,
	        w = e.x - p.x,
	        h = e.y - p.y;

	    if (space){
	        w = shape.attrs.width;
	        h = shape.attrs.height;
	        var dX = e.x - (p.x + w),
	            dY = e.y - (p.y + h);

	        oPoint.x += dX;
	        oPoint.y += dY;

	        shape.setX(p.x + dX);
	        shape.setY(p.y + dY);
	    }
	    else{
	        if (e.evt.shiftKey){
	            var d = Math.sqrt(Math.pow(e.x-p.x,2)+Math.pow(e.y-p.y,2));
	            w = h = d * Math.sin(Math.PI/4);
	        }
	        if(e.altKey){
	            shape.setX(oPoint.x - w/2);
	            shape.setY(oPoint.y - h/2);
	        }
	        else{
	    		if (shape_type == 'rectangle' || shape_type == 'rectangle-round') {
		            shape.x(oPoint.x);
		            shape.y(oPoint.y);
		        }
	            else if (shape_type == 'circle') {
	            	shape.x(oPoint.x+shape.radius()/2);
	            	shape.y(oPoint.y+shape.radius()/2);
	        	}
	    		else if (shape_type == 'ellipse') {
	    			// current_radius = shape.radius();
		            shape.x(oPoint.x);
		            shape.y(oPoint.y);
		        }
        		else if (shape_type == 'star') {
        			// current_radius = shape.radius();
    	            shape.x(oPoint.x);
    	            shape.y(oPoint.y);
    	        }

        		else if (shape_type == 'line') {
        			// current_radius = shape.radius();
    	            // shape.x(oPoint.x);
    	            // shape.y(oPoint.y);
    	            shape.points([e.x, e.y, oPoint.x, oPoint.y]);
    	        }

    	           		if (shape_type == 'wedge') {
    	           			 shape.x(oPoint.x+shape.width());
    	           			 shape.y(oPoint.y+shape.height());
    	       	        }
	        }
	    }

	    if (shape_type == 'rectangle' || shape_type == 'rectangle-round') {
	    	shape.width(w);
	    	shape.height(h);
		}
	    else if (shape_type == 'circle') {
		    shape.radius(w)
		}
	    else if (shape_type == 'ellipse') {
		    shape.radius({
			  x: w,
			  y: h
			});
		}
	    else if (shape_type == 'star') {
	    	shape.innerRadius(w);
	    	shape.outerRadius(w+w/2);
		}

	    if (shape_type == 'line') {
	    	shape.width(w);
	    	shape.height(h);
		}
		    if (shape_type == 'wedge') {
		    shape.radius(w)

			}
            wpbeautify_border_to_top()

	    shapes_layer.draw();
	});

	shapes_layer.on("mouseup", function(e) {
	    down = false;
	    painting_shapes = 0;
		wpbeautify_set_shapes_draggable(true);
	    document.body.style.cursor = 'default';
	    shapes_painting_rect.destroy();
		// console.log('finished')
	});

}

function wpbeautify_set_shapes_draggable(value) {
	for (i=0;i<shapes_list.length;i++)
		shapes_list[i][1].draggable(value);
}

/* Draw Shape */

function wpbeautify_start_drawing_shape() {
	painting_shapes = 1;
	wpbeautify_setup_shapes_layer()
	// shapes_layer.moveToTop();
	wpbeautify_set_shapes_draggable(false);
}

function wpbeautify_clear_shapes() {
	/*for (i=0;i<shapes_list.length;i++)
		shapes_list[i][2].destroy();*/
	painting_shapes = 0;
	wpbtfy_remove_layers_by_type( 'shape' );
}


// FREE DRAWING
var is_free_draw = 0;
var freedrawing_list = new Array();

// var background_painting;
function wpbeautify_setup_freedraw_layer() {

     // create a stage and a layer
/*        var stage = new Konva.Stage({
            container: 'container',
            width: 400,
            height: 400
        });
        var layer = new Konva.Layer();
        stage.add(layer);*/

		freedraw_layer = new Konva.Layer();
		global_stage.add(freedraw_layer);

        // an empty stage does not emit mouse-events
        // so fill the stage with a background rectangle
        // that can emit mouse-events
        background_painting = new Konva.Rect({
            x: 0,
            y: 0,
            width: global_width,
            height: global_height
        })
         freedraw_layer.add(background_painting);
        freedraw_layer.draw();


        // a flag we use to see if we're dragging the mouse
        var isMouseDown = false;
        // a reference to the line we are currently drawing
        var newline;
        // a reference to the array of points making newline
        var points = [];

        // on the background
        // listen for mousedown, mouseup and mousemove events
        background_painting.on('mousedown', function () {
        	if (!is_free_draw) return;
            onMousedown();
        });
        background_painting.on('mouseup', function () {
            onMouseup();
            background_painting.destroy();
        });


        background_painting.on('mousemove', function () {
            onMousemove();
        });

        background_painting.on('mouseover', function() {
            if(is_free_draw)
          document.body.style.cursor = 'url('+wpbeautify_vars.wpbeautify_plugin_url+'/img/cursors/lapicero.cur), crosshair';
          // document.body.style.cursor = 'crosshair';

              });

        background_painting.on('mouseout', function() {
          document.body.style.cursor = 'default';

              });

        // On mousedown
        // Set the isMouseDown flag to true
        // Create a new line,
        // Clear the points array for new points
        // set newline reference to the newly created line
        function onMousedown(event) {
            isMouseDown = true;
            points = [];
            // points.push(stage.getPointerPosition());
            // points = points().concat(stage.getPointerPosition()));

		    var line_color = jQuery('#wpbeautify_freedraw_line_color').val();
		    var line_width = jQuery('#wpbeautify_freedraw_line_width').val();



            newline = new Konva.Line({
                points: points,
                stroke: line_color,
                strokeWidth: line_width,
                draggable: true/*,
                lineCap: 'round',
                lineJoin: 'round'*/
            });

            newline.on('mouseup', function () {
                onMouseup();
            });

	    	freedrawing_list.push(new Array(1, newline, freedraw_layer));

            freedraw_layer.add(newline);
			wpbtfy_add_layer( 'line', freedraw_layer, 'Line' );

            // newline = line;
            // newline.setZIndex(100);
            wpbeautify_border_to_top()
            freedraw_layer.draw();

        }

        // on mouseup end the line by clearing the isMouseDown flag
        function onMouseup(event) {
            isMouseDown = false;
            is_free_draw = 0;
          	document.body.style.cursor = 'default';

            // console.log('fin')
        }

        // on mousemove
        // Add the current mouse position to the points[] array
        // Update newline to include all points in points[]
        // and redraw the layer
        function onMousemove(event) {
            if (!isMouseDown) {
                return;
            };
            // points.push(stage.getPointerPosition());
            // console.log(points);
  			var pos = global_stage.getPointerPosition();
            newline.points(newline.points().concat(pos.x, pos.y));

            /*newline.points(newline.points().concat(stage.getPointerPosition()));
console.log(newline.points())*/

    // current_points = newline.points();
  /*var pos = stage.getPointerPosition();
  points = current_points.push(pos.x, pos.y);
  newline.setPoints(points);*/

            // newline.points(points);
            newline.draw();
            freedraw_layer.draw();
        }

    }


function wpbeautify_start_drawing_freedraw() {
	wpbeautify_setup_freedraw_layer();
	is_free_draw = 1;
}

function wpbeautify_clear_freedraw() {
	// is_free_draw = 0;
	// freedraw_layer.removeChildren();
	/*shapes_painting_rect = new Konva.Rect({
	    x:0,
	    y:0,
	    width:global_width,
	    height: global_height
	})
	shapes_layer.add(shapes_painting_rect);	*/
    /*background_painting = new Konva.Rect({
        x: 0,
        y: 0,
        width: global_width,
        height: global_height
    })
    freedraw_layer.add(background_painting);
	wpbeautify_update_canvas_size(global_height, global_width);*/
	// freedraw_layer.draw();
	/*for (i=0;i<freedrawing_list.length;i++)
		freedrawing_list[i][2].destroy();*/
	is_free_draw = 0;
	wpbtfy_remove_layers_by_type( 'line' );
}


/* Text */

// Text
function wpbeautify_add_text() {
	text = '';

	var complexText = new Konva.Text({
		x: 10,
		y: 10,
		text: text,
		fontSize: 38,
		fontFamily: 'Calibri',
		fill: '#fff',
		width: global_width,
		padding: 20,
		align: 'center',
		draggable: true
	});

	complexText.on('mouseover', function () {
	                document.body.style.cursor = 'move';
	            });
	complexText.on('mouseout', function () {
	                document.body.style.cursor = 'default';
	            });
	var text_n = wpbeautify_texts.length;

	wpbeautify_add_text_box(text_n)

	var text_layer = new Konva.Layer();

	text_layer.add(complexText)
	global_stage.add(text_layer);

	wpbeautify_texts.push(new Array(text_n, complexText, text_layer));
	wpbeautify_update_text(text_n);
	wpbeautify_border_to_top()
	text_layer.draw()

	wpbtfy_add_layer( 'text', text_layer, 'Text', text_n );
}

/*
<button type="button"  class="btn btn-sm pull-right" data-toggle="collapse" data-target="#intro" >
  <span class="glyphicon glyphicon-chevron-down"></span>
</button>

<div id="intro" class="collapse in">
    Lorem IPsum content
</div>
*/
/*
'		<div class="row">'+
'<button type="button"  class="btn btn-sm pull-right" data-toggle="collapse" data-target="#intro" >'+
'  <span class="glyphicon glyphicon-chevron-down"></span> '+
'</button>'+
'</div>'+
*/
var wpbeautify_texts = Array();
function wpbeautify_add_text_box(text_n) {
	var google_fonts = wpbeautify_vars.google_fonts;

	var str_text = '<div class="wpbeautify_current_text form-horizontal" id="wpbeautify_text_'+text_n+'">'+
					'		<div class="well">'+
					'		  <div class="form-group">'+
					'		    <label class="col-sm-3 control-label" for="inputEmail3">Content</label>'+
					'		    <div class="col-sm-9">'+
					'		      <textarea class="form-control wpbeautify_text_setting wpbeautify_text_content" rows="4">Your text here...</textarea> '+
					'		    </div>'+
					'		  </div>'+
					'			<div class="form-group">'+
					'				<label class="col-sm-3 control-label" for="text-field">Family</label>'+
		            '				<div class="col-sm-9">'+
		            '					<select class=" form-control wpbeautify_text_setting wpbeautify_font_family" name=""><option value="Arial" style="font-family:Arial">Arial</option><option value="Comic Sans MS" style="font-family:Comic Sans MS">Comic Sans</option><option value="Georgia" style="font-family:Georgia">Georgia</option><option selected="selected" value="Impact" style="font-family:Impact">Impact</option><option value="Times New Roman" style="font-family:Times New Roman">Times New Roman</option><option value="Verdana" style="font-family:Verdana">Verdana</option>';
	var n_fonts = google_fonts.length;
	if (n_fonts) {
		for (i=0;i<n_fonts;i++) {
			str_text += '<option value="'+google_fonts[i]+'" style="font-family:'+google_fonts[i]+'">'+google_fonts[i]+'</option>';
		}
	}
	str_text +=		'					</select></div>'+
					'			</div>	'+
					'			<div class="form-group">'+
					'				<label class="col-sm-3 control-label" for="text-field">Color</label>'+
		            '				<div class="col-sm-4">'+
					'					<input type="text" class="form-control wpbtfy-colorpicker wpbeautify_text_setting wpbeautify_font_color" value="#ffffff">'+
					'				</div>'+
					'			</div>		'+
					'			<div class="form-group">'+
					'				<label class="col-sm-3 control-label" for="text-field">Border</label>'+
		            '				<div class="col-sm-4">'+
					'					<input type="text" class="form-control wpbtfy-colorpicker wpbeautify_text_setting wpbeautify_font_color_border" value="#000000">'+
					'				</div>'+
					'			</div>		'+
					'			<div class="form-group" >'+
					'				<label class="col-sm-3 control-label" for="text-field">Size</label>'+
		            '				<div class="col-sm-4">'+
					'			            <div class="input-group" style="width:75px">'+
					'			        <input type="text" value="45" class="form-control wpbtfy-spinner wpbeautify_text_setting wpbeautify_font_size">'+
					'			        </div>'+
					'				</div>'+
		            '				<div class="col-sm-5" style="padding-top:5px">'+
				    '			<div><button class="btn btn-xs pull-right wpbtfy-text-style font-style-italic"><span class="glyphicon glyphicon-italic"></span></button></div>'+
				    '			<div><button class="btn btn-xs pull-right wpbtfy-text-style font-style-bold" style="margin-right:5px" ><span class="glyphicon glyphicon-bold"></span></button></div>'+
					'				</div>'+
					'			</div>'+
					'			<div><button class="btn btn-sm pull-left wpbtfy-text-alignment" data-align="left"><span class="glyphicon glyphicon-align-left"></span></button></div>'+
					'			<div><button class="btn btn-sm btn-info pull-left wpbtfy-text-alignment" data-align="center"><span class="glyphicon glyphicon-align-center"></span></button></div>'+
					'			<div><button class="btn btn-sm pull-left wpbtfy-text-alignment" data-align="right"><span class="glyphicon glyphicon-align-right"></span></button></div>'+
					'			<button class="btn btn-danger btn-sm pull-right wpbeautify_delete_text" type="button"> <span class="glyphicon glyphicon-remove"></span> Delete</button>'+
					'			<div class="clear"></div>'+
					'		</div>'+
					'		<input type="hidden" class="wpbeautify_text_id" value="'+text_n+'">'+
					'	</div>';
	jQuery('#wpbeautify_current_texts').append(str_text);

	jQuery('#wpbeautify_text_'+text_n+' .wpbtfy-colorpicker').minicolors();
	jQuery('#wpbeautify_text_'+text_n+' .wpbtfy-spinner').spinedit();
}

function wpbeautify_update_text(text_id) {
	text_settings = jQuery('#wpbeautify_text_'+text_id);
	current_text = wpbeautify_get_text(text_id);

	text_layer = current_text[2]
	current_text = current_text[1]
	// console.log(text_id)
	// console.log(current_text)
	if (!current_text) return;
	current_text.fontFamily(text_settings.find('.wpbeautify_font_family').val())
	current_text.fontSize(text_settings.find('.wpbeautify_font_size').val())
	current_text.fill(text_settings.find('.wpbeautify_font_color').val())
	current_text.stroke(text_settings.find('.wpbeautify_font_color_border').val())
	current_text.text(text_settings.find('.wpbeautify_text_content').val())
	current_text.align(text_settings.find('.wpbtfy-text-alignment.btn-info').attr('data-align'));
	style = '';

	bold = text_settings.find('.wpbtfy-text-style.font-style-bold');
	if (bold.hasClass('btn-info'))
		style+= 'bold ';

	italic = text_settings.find('.wpbtfy-text-style.font-style-italic');
	if (italic.hasClass('btn-info'))
		style += 'italic';

	if (style == '')
		style = 'normal'
	current_text.fontStyle(style)
	// current_text.fontStyle('')
	text_layer.draw();

}

function wpbeautify_get_text(text_id) {
	for (i=0;i<wpbeautify_texts.length;i++) {
		if (wpbeautify_texts[i][0] == text_id)
			return wpbeautify_texts[i];
	}
	return 0;
}

function wpbeautify_delete_text(text_id) {
	current_text = wpbeautify_get_text(text_id);
	text_layer = current_text[2]

	text_layer.destroy();
	jQuery('#wpbeautify_text_'+text_id).remove();
}


/* Cropping */
var crop_layer;
var cropping_group;
var cropping_rect
var crop_area_rect;

function wpbeautify_start_crop() {
	jQuery('#wpbtfy-button-start-crop').hide();
	jQuery('#wpbtfy-button-do-crop').show();
	jQuery('#wpbtfy-button-cancel-crop').show();


        cropping_group = new Konva.Group({
          x: 0,
          y: 0,
          draggable: true,

          dragBoundFunc: function(pos) {
          	var maxY = global_height - cropping_rect.y() - cropping_rect.height();
          	var maxX = global_width - cropping_rect.x() - cropping_rect.width();
            var newY = pos.y < -cropping_rect.y() ? -cropping_rect.y() :  (pos.y > maxY ? maxY : pos.y);
            var newX = pos.x < -cropping_rect.x() ? -cropping_rect.x() :  (pos.x > maxX ? maxX : pos.x);
            return {
              x: newX,
              y: newY
            };
          }
        });

        crop_layer = new Konva.Layer();


        crop_layer.add(cropping_group);
        global_stage.add(crop_layer);

        cropping_rect = new Konva.Rect({
          x: 20,
          y: 20,
          width: global_width-40,
          height: global_height-40,
          name: 'image',
        fill: 'white',
        stroke: 'black',
        strokeWidth: 2,
        dash :[10, 5],
        opacity: 0.70
        });

	cropping_rect.on('mouseover', function () {
	                document.body.style.cursor = 'move';
	            });
	cropping_rect.on('mouseout', function () {
	                document.body.style.cursor = 'default';
	            });


        cropping_group.add(cropping_rect);
        addAnchor(cropping_group, 20, 20, 'topLeft');
        addAnchor(cropping_group, global_width-20, 20, 'topRight');
        addAnchor(cropping_group, global_width-20, global_height-20, 'bottomRight');
        addAnchor(cropping_group, 20, global_height-20, 'bottomLeft');

        cropping_group.on('dragstart', function() {
          this.moveToTop();
        });

        global_stage.draw();

          jQuery('#img-new-height-crop').val(wpbeautify_roundToTwo(global_height-40))
          jQuery('#img-new-width-crop').val(wpbeautify_roundToTwo(global_width-40))
}

function wpbeautify_cancel_crop() {
	jQuery('#wpbtfy-button-do-crop').hide();
	jQuery('#wpbtfy-button-start-crop').show();
	jQuery('#wpbtfy-button-cancel-crop').hide();
		crop_layer.destroy();
	// resize_image_size(cropping_rect.width(), cropping_rect.height(), 0, 0);
	global_stage.draw();
}

function wpbeautify_do_crop() {
	jQuery('#wpbtfy-button-do-crop').hide();
	jQuery('#wpbtfy-button-start-crop').show();
	jQuery('#wpbtfy-button-cancel-crop').hide();


 var topLeft = cropping_group.find('.topLeft')[0];

        group_left = cropping_group.x()
        group_top = cropping_group.y()
        group_width = cropping_group.width()
        group_height = cropping_group.height()



    img_left = cropping_rect.x()
    img_top = cropping_rect.y()
    img_width = cropping_rect.width()
    img_height = cropping_rect.height()

	var orig_w = global_width
	var orig_h = global_height
    global_width = cropping_rect.width()
    global_height = cropping_rect.height()


         // console.log('Group pos: '+group_left+', '+group_top+' - Size: '+group_width+' x '+group_height)
         current_crop = global_img_object.crop();

// 70, -11, 0, 59
// 124, -76, 0, 48
         // console.log('img_left = '+img_left)
         // console.log('group_left = '+group_left)
         // console.log('current_crop_x = '+current_crop.x)
         // console.log('x (suma) = '+(img_left+group_left+current_crop.x))

// 20, 0, 0, 20
		x_crop = img_left+group_left+current_crop.x
		y_crop = img_top+group_top+current_crop.y;

       if (img_layer.scaleX() == -1) {
       		current_x = img_layer.x();
       		// console.log('full canvas w = '+orig_w)
       		// console.log('cropping rect w = '+img_width)
       		// console.log('cropping rect x pos = '+img_left)
       		// console.log('current layer x = '+current_x)

       		 // img_layer.x(current_x - (orig_w-img_width-img_left))
       		 // img_layer.x(current_x - (img_left))

       		 // img_layer.x(current_x - (orig_w-img_width-current_x))
       		 // img_left =  img_left+(orig_w-(img_width+current_x))
       		 // img_left = orig_w - img_left;

	// img_left += (orig_w - (img_left+img_width))
	         // console.log('img_left2 = '+img_left)
	img_layer.x(img_width);
	// img_left += 140
	img_left = orig_w - (img_left+img_width)
	x_crop = img_left +current_crop.x
       }

       if (img_layer.scaleY() == -1) {
       		current_y = img_layer.y();
       		// img_layer.y(current_y - (orig_h-img_height))
       		img_layer.y(img_height)
			img_top = orig_h - (img_top+img_height)

       		y_crop = img_top +current_crop.y
       }

    var width_factor =  original_width /  orig_w;
    var height_factor =  original_height /  orig_h;

	// global_img_object.width(global_width*width_factor)
	// global_img_object.height(global_height*height_factor)

	global_img_object.width(global_width)
	global_img_object.height(global_height)

// console.log('img_object w = '+global_width)
// console.log('img_object h = '+global_height)

	global_img_object.crop({
	  x: x_crop,
	  y: y_crop,
	  width: cropping_rect.width(),
	  height: cropping_rect.height()
	})

// console.log('gli x: '+global_img_object.x())
// console.log('gls x: '+global_stage.x())


// rmi353, esto estaba activado


	// 	global_img_object.width(orig_w)
	// global_img_object.height(orig_h)

// orig_w
	/*global_stage.offsetX(img_left+group_left);
	global_stage.offsetY(img_top+group_top);*/

	// global_stage.offsetX(group_left);
	// global_stage.offsetY(group_top);



	global_stage.width(cropping_rect.width());
	global_stage.height(cropping_rect.height());


	original_width = global_width
	original_height = global_height

	wpbeautify_resize_border(global_width, global_height)

// img_layer.scaleX(1)

	crop_layer.destroy();
	// resize_image_size(cropping_rect.width(), cropping_rect.height(), 0, 0);
	global_stage.draw();
    // img_canvas.draw();
	return;

}

function wpbtfy_crop_image_predefined( size ) {
	// console.log(size)
	tamano = wpbtfy_get_size_from_label( size );
	crop_image_size(tamano[0], tamano[1]);
}

function crop_image_size( width, height ) {
	// console.log(width)
	// console.log(global_img_object.width())

	// console.log('aa0s w'+global_stage.width())
	// console.log('aa0s h'+global_stage.height())

	// console.log('aa0 w'+global_img_object.width())
	// console.log('aa0 h'+global_img_object.height())


		if (global_img_object.width() < width) {
			// console.log('entro1')
			global_stage.width(width);
			global_img_object.width(width);
		}
// console.log('0a')
// console.log(height)
// console.log(global_img_object.height())
		if (global_img_object.height() < height) {
			// console.log('entro2')
			global_stage.height(height);
			global_img_object.height(height);
		}

		// console.log('aa1s w'+global_stage.width())
		// console.log('aa1s h'+global_stage.height())

// console.log('aa1 w'+global_img_object.width())
// console.log('aa1 h'+global_img_object.height())
	// wpbeautify_update_canvas_size(height, width);
		
		global_img_object.crop({
		  x: 0,
		  y: 0,
		  width: width,
		  height: height
		})

/*console.log('b')

console.log('aa2s w'+global_stage.width())
console.log('aa2s h'+global_stage.height())

console.log('aa2 w'+global_img_object.width())
console.log('aa2 h'+global_img_object.height())*/

		global_width = width
		global_height = height
// console.log('b0 '+width)
try {
	// wpbeautify_update_canvas_size(height, width);
			global_img_object.height(height);
			global_img_object.width(width);

		global_stage.width(width);
// console.log('b1 '+width)

		global_stage.height(height);
// console.log('b2 '+height)

}
catch(err) {
    // document.getElementById("demo").innerHTML = err.message;
    console.log(err)
}
		original_width = global_width
		original_height = global_height


// console.log('c')

		wpbeautify_resize_border(global_width, global_height)

// console.log('d')

	// img_layer.scaleX(1)

		// crop_layer.destroy();
		// resize_image_size(cropping_rect.width(), cropping_rect.height(), 0, 0);
		global_stage.draw();

		jQuery('#img-new-height-crop').val(wpbeautify_roundToTwo(height))
		jQuery('#img-new-width-crop').val(wpbeautify_roundToTwo(width))

}
     function update(activeAnchor) {
        var group = activeAnchor.getParent();

        var topLeft = group.find('.topLeft')[0];
        var topRight = group.find('.topRight')[0];
        var bottomRight = group.find('.bottomRight')[0];
        var bottomLeft = group.find('.bottomLeft')[0];
        var image = group.find('.image')[0];

        var anchorX = activeAnchor.x();
        var anchorY = activeAnchor.y();

        // update anchor positions
        switch (activeAnchor.name()) {
          case 'topLeft':
            topRight.y(anchorY);
            bottomLeft.x(anchorX);
            break;
          case 'topRight':
            topLeft.y(anchorY);
            bottomRight.x(anchorX);
            break;
          case 'bottomRight':
            bottomLeft.y(anchorY);
            topRight.x(anchorX);
            break;
          case 'bottomLeft':
            bottomRight.y(anchorY);
            topLeft.x(anchorX);
            break;
        }

        image.setPosition(topLeft.getPosition());

        var width = topRight.x() - topLeft.x();
        var height = bottomLeft.y() - topLeft.y();
        if(width && height) {
        	// console.log('aaa')
          image.setSize({width:width, height: height});
          jQuery('#img-new-height-crop').val(wpbeautify_roundToTwo(height))
          jQuery('#img-new-width-crop').val(wpbeautify_roundToTwo(width))
	// console.log(image.x())
	// console.log(image.y())
        }
      }

      function addAnchor(group, x, y, name, start_hidden) {
      	if (!start_hidden)
      		start_hidden = false;

        var stage = group.getStage();
        var layer = group.getLayer();

        var anchor = new Konva.Circle({
          x: x,
          y: y,
          stroke: '#666',
          fill: '#ddd',
          strokeWidth: 2,
          radius: 8,
          name: name,
          draggable: true,
          dragOnTop: false
        });

        anchor.on('dragmove', function() {
          update(this);
          layer.draw();
        });
        anchor.on('mousedown touchstart', function() {
          group.setDraggable(false);
          this.moveToTop();
        });
        anchor.on('dragend', function() {
          group.setDraggable(true);
          layer.draw();
        });
        // add hover styling
        anchor.on('mouseover', function() {
          var layer = this.getLayer();
          document.body.style.cursor = 'crosshair';
          this.setStrokeWidth(4);
          layer.draw();
        });
        anchor.on('mouseout', function() {
          var layer = this.getLayer();
          document.body.style.cursor = 'default';
          this.strokeWidth(2);
          layer.draw();
        });

        if (start_hidden)
        	anchor.hide();
        group.add(anchor);
        // wpbtfy_anchors.push(anchor)
      }

function wpbeatify_show_loading_modal() {
	jQuery('#wpbeautify-loading-modal').themodal({
		fadeDuration: 250,
		fadeDelay: 0.80,
		escapeClose: false,
		  clickClose: false,
		  showClose: false
	});
}

function wpbeatify_hide_loading_modal() {
	jQuery.themodal.close();
}

/* Insert Image into Post */

/*
	Inserts image into WP
*/
function wpbeautify_insert_image(do_download, from_url_directly, callback) {
	wpbeatify_show_loading_modal();

	if (!from_url_directly)
		from_url_directly = 0;
	/*
		2 options:
			1) download image "as is"
			2) download the current stage
	*/

	if (!do_download) do_download = 0;
	file_extension = jQuery('#wpbeautify_file_extension').html();
	// console.log(file_extension)
	if (file_extension == '.png')
		mimetype = "image/png";
	else if (file_extension == '.gif')
		mimetype = "image/gif";
	else
		mimetype = "image/jpeg";

// console.log(global_width)
// console.log(global_height)
// console.log(global_stage.clip())

	var file_name = jQuery('#wpbeautify_file_name').val()
	if (!file_name || file_name == '') file_name = 'file';

	if (from_url_directly) {
     	var data = {
     		action: 'wpbeautify_save_image',
     		download : do_download,
     		image_title : jQuery('#wpbeautify_img_title').val(),
     		image_caption : jQuery('#wpbeautify_img_caption').val(),
     		image_alt : jQuery('#wpbeautify_img_alt').val(),
     		image_description : jQuery('#wpbeautify_img_description').val(),
     		image_size : jQuery("#wpbeautify_image_size").val(),
     		image_alignment : jQuery('#wpbeautify_img_alignment').val(),
     		link_to : jQuery('#wpbeautify_link_to').val(),
     		link_to_url : jQuery('#wpbeautify_link_to_url').val(),
     		watermark : jQuery('#wpbeautify_img_watermark').is(':checked'),
     		post_id : parent.jQuery('#post_ID').val(),
     		file_name : file_name+file_extension,
     		from_url : 1,
     		image_url : wpbeautify_img_just_selected
     	};

 		jQuery.post(ajaxurl, data, function(response) {
 			wpbeatify_hide_loading_modal();
 			if (response != '0') {
 				if (do_download == -1) {
 					wpbeautify_final_image_url = response;
 					if (callback)
 						callback();
 					return;
 				}
 				else if (do_download) {
 					wpbeautify_download_file(response, file_name+file_extension, 0);
 				}
 				else {
 						// tinyMCE.execCommand('mceInsertContent', false, response);
						parent.window.send_to_editor(response);
						jQuery('#wpbtfyModal').modal('hide')
					}
 			}
 			return;
 		});
		return;
	}

	global_stage.toDataURL({
        width: global_width,
        height: global_height,
        mimeType: mimetype,
        callback: function(dataUrl) {

        	var data = {
        		action: 'wpbeautify_save_image',
        		download : do_download,
        		image_title : jQuery('#wpbeautify_img_title').val(),
        		image_caption : jQuery('#wpbeautify_img_caption').val(),
        		image_alt : jQuery('#wpbeautify_img_alt').val(),
        		image_description : jQuery('#wpbeautify_img_description').val(),
        		image_size : jQuery("#wpbeautify_image_size").val(),
        		image_alignment : jQuery('#wpbeautify_img_alignment').val(),
        		link_to : jQuery('#wpbeautify_link_to').val(),
        		link_to_url : jQuery('#wpbeautify_link_to_url').val(),
        		watermark : jQuery('#wpbeautify_img_watermark').is(':checked'),
        		post_id : parent.jQuery('#post_ID').val(),
        		file_name : file_name+file_extension,
        		from_url : 0,
        		image_url : '',
        		data : dataUrl
        	};

    		jQuery.post(ajaxurl, data, function(response) {
 				wpbeatify_hide_loading_modal();

    			if (response != '0') {
    				if (do_download == -1) {
    					wpbeautify_final_image_url = response;
    					if (callback)
    						callback();
    					return;
    				}
    				else if (do_download) {
    					wpbeautify_download_file(response, file_name+file_extension, 0);
    				}
    				else {
    					// console.log(response)
   						/*if (parent.window.send_to_editor)
   							parent.window.send_to_editor(response);
   						else
   							window.send_to_editor(response);

   						var instance = window.opener.tinyMCE || window.parent.tinyMCE;
   						instance.execInstanceCommand('mceInsertContent', false, 'content', 'some text or html code');*/
   						// send_to_editor(response);
   						// tinyMCE.execCommand('mceInsertContent', false, response);
   						// wp.media.editor.insert(response);
   						// console.log(wpbtfy_orig_send_to_editor)
   						// wpbtfy_orig_send_to_editor(response);
   						// parent.tinyMCE.activeEditor.setContent(parent.tinyMCE.activeEditor.getContent() + response);
   						parent.window.send_to_editor(response);
   						jQuery('#wpbtfyModal').modal('hide')
   					}
    			}
    			return;
    		});

        }
	});
}

function wpbeautify_download_image() {

	if (1) { // rmi353, download from canvas
		image_url = last_preview_url.url;
		overlay_visible = 1
	}
	else {
		// download image as it is
		image_url = current_img.attr('data-url');
	}

	var data = {
		action: 'wpbeautify_download_image',
		image_url : image_url,
		image_size : jQuery('#wpbeautify_image_size').val(),
		watermark : jQuery('#wpbeautify_image_watermark').is(':checked'),
		file_name : jQuery('#wpbeautify_file_name').val()+jQuery('#wpbeautify_file_extension').html()
	};

	jQuery("#__attachments-view-wpbeautify-container").hide();
	jQuery('#wpbeautify_searching_span').html('Downloading Image...');
	jQuery('#wpbeautify_searching_div').show();

	jQuery.post(ajaxurl, data, function(response) {
		jQuery('#wpbeautify_searching_div').fadeOut('slow');

		fileurl = response
		filename = jQuery('#wpbeautify_file_name').val()+jQuery('#wpbeautify_file_extension').html()
		wpbeautify_download_file(fileurl, filename, 0);

		// If attribution required, download as well .txt file
		if (current_img.attr('data-attribution') == '1')
			wpbeautify_download_file(fileurl, jQuery('#wpbeautify_file_name').val()+'-attribution.txt', 1);

		if (!overlay_visible)
			jQuery("#__attachments-view-wpbeautify-container").fadeIn('slow');
		else {
			wpbeautify_show_overlay();
		}
	});
}

function wpbeautify_download_file (fileurl, filename, txtfile){
	var inputs = '';
	var iframeX;
	var downloadInterval;

		/*if (txtfile) {
			txt_append = 'T';
			if(jQuery("#iframeX"+txt_append)) jQuery("#iframeX"+txt_append).remove();
		}
		else {*/
			txt_append = '';
			if(jQuery("#iframeX")) jQuery("#iframeX").remove();
		/*}*/

		// creater new iframe
		iframeX= jQuery('<iframe src="[removed]false;" name="iframeX'+txt_append+'" id="iframeX'+txt_append+'"></iframe>').appendTo('body').hide();
		if(jQuery.browser.msie){
			downloadInterval = setInterval(function(){
				// if loading then readyState is "loading" else readyState is "interactive"
				if(iframeX&& iframeX[0].readyState !=="loading"){
					clearInterval(downloadInterval);
				}
			}, 23);
		}
		else {
				iframeX.load(function(){
			});
		}
/*
		if (txtfile ) {
			current_img = jQuery('#__attachments-view-wpbeautify .selected').find('img');
			source_service = current_img.attr('data-origin');
			original_url = current_img.attr('data-original-url');
			license = wpbeautify_licenses[current_img.attr('data-license')];
			license = license[0];
			author_url =  current_img.attr('data-author_url')
			author_name = current_img.attr('data-author_name')
			image_title = current_img.attr('title')

			attribution_txt = "Title: "+image_title+"\n";
			attribution_txt += "Source: "+source_service+"\n";
			attribution_txt += "URL: "+original_url+"\n";
			attribution_txt += "Author: "+author_name+"\n";
			attribution_txt += "Author URL: "+author_url+"\n";
			attribution_txt += "License: "+license;


			inputs+='<input type="hidden" name="wpbeautify_caption" value="'+ attribution_txt +'" />';
			inputs+='<input type="hidden" name="wpbeautify_file_name" value="'+ filename +'" />';
			jQuery('<form action="'+wpbeautifyjs_vars.admin_url+'?wpbeautify_file_export_attribution=1" method="post" target="iframeX'+txt_append+'">'+inputs+'</form>').appendTo('body').submit().remove();
		}
		else  {*/
			inputs+='<input type="hidden" name="wpbeautify_file_url" value="'+ fileurl +'" />';
			inputs+='<input type="hidden" name="wpbeautify_file_name" value="'+ filename +'" />';
			 jQuery('<form action="'+wpbeautify_vars.admin_url+'?wpbeautify_file_export=1" method="post" target="iframeX">'+inputs+'</form>').appendTo('body').submit().remove();
			// jQuery('<form action="'+wpbeautify_vars.admin_url+'?wpbeautify_file_export=1" method="post" target="iframeX">'+inputs+'</form>').appendTo('body').submit();
		// }
}

function dropbox_show_image_results() {
	jQuery('#wpbeautify_dropbox_results').show();
	wpbeautify_enable_actions(1);
}

function googledrive_show_image_results() {
	jQuery('#wpbeautify_googledrive_results').show();
	wpbeautify_enable_actions(1);
}

function wpbeautify_browse_flickr_albums() {
	jQuery('#wpbeautify_flickr_albumname').html('');

	var data = {
		action: 'wpbeautify_flickr_browse_albums'
	};
	jQuery('#wpbeautify_flickr_results').html(wpbtfy_loading_txt);

	jQuery.post(ajaxurl, data, function(response) {
		if (response != '0') {
			jQuery('#wpbeautify_flickr_results').html(response);
		}
		return;
	});
}

function wpbeautify_browse_flickr_album_pics(album_id, page, album_name) {
	var data = {
		action : 'wpbeautify_flickr_browse_album_pics',
		album_id : album_id,
		page : page
	};

	jQuery('#wpbeautify_flickr_results').html(wpbtfy_loading_txt);

	jQuery.post(ajaxurl, data, function(response) {
		if (response != '0') {
				// parent.window.send_to_editor(response);
				// jQuery('#wpbtfyModal').modal('hide')
			if (album_name)
				jQuery('#wpbeautify_flickr_albumname').html('Browsing album <b>'+album_name+'</b> (<a class="back_all_albums" data-site="flickr" href="#">Back to all albums</a>)');
			jQuery('#wpbeautify_flickr_results').html(response);
		}
		return;
	});
}


function wpbeautify_browse_googleplus_albums() {
	var data = {
		action: 'wpbeautify_googleplus_browse_albums'
	};
	jQuery('#wpbeautify_googleplus_albumname').html('');
	jQuery('#wpbeautify_googleplus_results').html(wpbtfy_loading_txt);

	jQuery.post(ajaxurl, data, function(response) {
		if (response != '0') {
			jQuery('#wpbeautify_googleplus_results').html(response);
		}
		return;
	});
}

function wpbeautify_browse_googleplus_album_pics(album_id, page, album_name) {
	var data = {
		action : 'wpbeautify_googleplus_browse_album_pics',
		album_id : album_id,
		page : page
	};
	jQuery('#wpbeautify_googleplus_results').html(wpbtfy_loading_txt);

	jQuery.post(ajaxurl, data, function(response) {
		if (response != '0') {
			if (album_name)
				jQuery('#wpbeautify_googleplus_albumname').html('Browsing album <b>'+album_name+'</b>  (<a class="back_all_albums" data-site="googleplus" href="#">Back to all albums</a>)');
			jQuery('#wpbeautify_googleplus_results').html(response);
		}
		return;
	});
}

function wpbeautify_browse_facebook_albums() {
	var data = {
		action: 'wpbeautify_facebook_browse_albums'
	};
	jQuery('#wpbeautify_facebook_albumname').html('');
	jQuery('#wpbeautify_facebook_results').html(wpbtfy_loading_txt);

	jQuery.post(ajaxurl, data, function(response) {
		if (response != '0') {
			jQuery('#wpbeautify_facebook_results').html(response);
		}
		return;
	});
}

function wpbeautify_browse_facebook_album_pics(album_id, page, album_name) {
	var data = {
		action : 'wpbeautify_facebook_browse_album_pics',
		album_id : album_id,
		page : page
	};
	jQuery('#wpbeautify_facebook_results').html(wpbtfy_loading_txt);

	jQuery.post(ajaxurl, data, function(response) {
		if (response != '0') {
			jQuery('#wpbeautify_facebook_results').html(response);
			if (album_name)
				jQuery('#wpbeautify_facebook_albumname').html('Browsing album <b>'+album_name+'</b>  (<a class="back_all_albums" data-site="facebook" href="#">Back to all albums</a>)');
		}
		return;
	});
}


function wpbeautify_browse_extras_albums() {
	var data = {
		action: 'wpbeautify_extras_browse_albums',
		page: wpbeautify_extras_album_page
	};
	jQuery('#wpbeautify_extras_albumname').html('');
	jQuery('#wpbeautify_extras_results').html(wpbtfy_loading_txt);

	jQuery.post(ajaxurl, data, function(response) {
		if (response != '0') {
			jQuery('#wpbeautify_extras_results').html(response);
		}
		return;
	});
}

function wpbeautify_browse_extras_album_pics(album_id, page, album_name) {
	var data = {
		action : 'wpbeautify_extras_browse_album_pics',
		album_id : album_id,
		page : page
	};
	jQuery('#wpbeautify_extras_results').html(wpbtfy_loading_txt);

	jQuery.post(ajaxurl, data, function(response) {
		if (response != '0') {
			jQuery('#wpbeautify_extras_results').html(response);
			if (album_name)
				jQuery('#wpbeautify_extras_albumname').html('Browsing album <b>'+album_name+'</b>  (<a class="back_all_albums" data-site="extras" href="#">Back to all albums</a>)');
		}
		return;
	});
}

function wpbeautify_browse_pinterest_albums() {
	var data = {
		action: 'wpbeautify_pinterest_browse_albums'
	};

	jQuery('#wpbeautify_pinterest_albumname').html('');

	jQuery('#wpbeautify_pinterest_results').html(wpbtfy_loading_txt);

	jQuery.post(ajaxurl, data, function(response) {
		if (response != '0') {
			jQuery('#wpbeautify_pinterest_results').html(response);
		}
		return;
	});
}

function wpbeautify_browse_pinterest_album_pics(album_id, page, album_name) {
	var data = {
		action : 'wpbeautify_pinterest_browse_album_pics',
		album_id : album_id,
		page : page
	};
	jQuery('#wpbeautify_pinterest_results').html(wpbtfy_loading_txt);

	jQuery.post(ajaxurl, data, function(response) {
		if (response != '0') {
			jQuery('#wpbeautify_pinterest_results').html(response);
			if (album_name)
				jQuery('#wpbeautify_pinterest_albumname').html('Browsing board <b>'+album_name+'</b>  (<a class="back_all_albums" data-site="pinterest" href="#">Back to all albums</a>)');
			else
				jQuery('#wpbeautify_pinterest_albumname').html('(<a class="back_all_albums" data-site="pinterest" href="#">Back to all albums</a>)');
		}
		return;
	});
}

function wpbeautify_browse_instagram_pics(page) {
	var data = {
		action : 'wpbeautify_instagram_browse_pics',
		page : page/*,
		album_id : album_id*/
	};
	jQuery('#wpbeautify_instagram_results').html(wpbtfy_loading_txt);
	jQuery.post(ajaxurl, data, function(response) {
		if (response != '0') {
			jQuery('#wpbeautify_instagram_results').html(response);
		}
		return;
	});
}

function wpbeautify_browse_extras( page ) {
	if (!page)
		page = 0;
	console.log('aq')
	var data = {
		action : 'wpbeautify_get_extras',
		page : page
	};
	jQuery('#wpbeautify_extra_results').html(wpbtfy_loading_txt);
	jQuery('#wpbeautify_extra_msg1').hide();
	jQuery.post(ajaxurl, data, function(response) {
		if (response != '0') {
			jQuery('#wpbeautify_extra_results').html(response);
			jQuery('#wpbeautify_extra_msg2').show();
		}
		return;
	});
}

function wpbeautify_browse_youzign(page) {
	var data = {
		action : 'wpbeautify_get_youzign',
		page : page
	};
	jQuery('#wpbeautify_youzign_results').html(wpbtfy_loading_txt);
	jQuery('#wpbeautify_youzign_msg1').hide();
	jQuery.post(ajaxurl, data, function(response) {
		if (response != '0') {
			jQuery('#wpbeautify_youzign_results').html(response);
			jQuery('#wpbeautify_youzign_msg2').show();
		}
		return;
	});
}

function wpbeautify_browse_memes() {
	var data = {
		action : 'wpbeautify_get_memes'
	};
	jQuery('#wpbeautify_meme_results').html(wpbtfy_loading_txt);
	jQuery('#wpbeautify_meme_msg1').hide();
	jQuery.post(ajaxurl, data, function(response) {
		if (response != '0') {
			jQuery('#wpbeautify_meme_results').html(response);
			jQuery('#wpbeautify_meme_msg2').show();
		}
		return;
	});
}

/*
	current album
	current page for albums
	current page for pics within album
*/
var wpbeautify_social_current_pages = {
    "facebook" : [0, 1, 1, ''],
    "instagram" : [0, 1, 1, ''],
    "pinterest" : [0, 1, 1, ''],
    "flickr" : [0, 1, 1, ''],
    "googleplus" : [0, 1, 1, ''],
    "extras" : [0, 1, 1, ''],
    "youzign" : [0, 1, 1, '']
};

function wpbeautify_social_pagination(img_type, page) {
	current_page = wpbeautify_social_current_pages[img_type][2];
	next_page = wpbeautify_social_pagination_update(current_page, page);
	wpbeautify_social_current_pages[img_type][2] = next_page;

	switch (img_type) {
		case 'facebook':
			wpbeautify_browse_facebook_album_pics(wpbeautify_social_current_pages[img_type][0], next_page);
			break;
		case 'instagram':
			wpbeautify_browse_instagram_pics(next_page);
			break;
		case 'pinterest':
			wpbeautify_browse_pinterest_album_pics(wpbeautify_social_current_pages[img_type][0], next_page);
			break;
		case 'flickr':
			wpbeautify_browse_flickr_album_pics(wpbeautify_social_current_pages[img_type][0], next_page);
			break;
		case 'googleplus':
			wpbeautify_browse_googleplus_album_pics(wpbeautify_social_current_pages[img_type][0], next_page);
			break;
		case 'youzign':
			wpbeautify_browse_youzign( next_page );
			break;
		case 'extras':
		// wpbeautify_social_current_pages['extras'][0] = current_album;
		// wpbeautify_social_current_pages['extras'][3] = current_album_name;
			wpbeautify_browse_extras_album_pics(wpbeautify_social_current_pages['extras'][0], next_page, wpbeautify_social_current_pages['extras'][3])
			// wpbeautify_browse_extras( next_page );
			break;
		default:
			break;
	}
}

function wpbeautify_social_pagination_update(current_page, next_page) {
	var return_page;
	if (next_page == 'next')
		return_page = current_page + 1;
	else if (next_page == 'prev') {
		if (current_page > 1)
			return_page = current_page  -1
		else
			return_page = next_page;
	}
	else
		return_page = next_page;
	return return_page;
}

// no derivative: 3, 6
var wpbeautify_licenses = new Array;
wpbeautify_licenses[0] = new Array('All Rights Reserved', '', '');
wpbeautify_licenses[1] = new Array('Attribution-NonCommercial-ShareAlike License', 'CC BY-NC-SA', 'http://creativecommons.org/licenses/by-nc-sa/2.0/');
wpbeautify_licenses[2] = new Array('Attribution-NonCommercial License', 'CC BY-NC', 'http://creativecommons.org/licenses/by-nc/2.0/');
wpbeautify_licenses[3] = new Array('Attribution-NonCommercial-NoDerivs License', 'CC BY-NC-ND', 'http://creativecommons.org/licenses/by-nc-nd/2.0/');
wpbeautify_licenses[4] = new Array('Attribution License', 'CC BY', 'http://creativecommons.org/licenses/by/2.0/');
wpbeautify_licenses[5] = new Array('Attribution-ShareAlike License', 'CC BY-SA', 'http://creativecommons.org/licenses/by-sa/2.0/');
wpbeautify_licenses[6] = new Array('Attribution-NoDerivs License', 'CC BY-ND', 'http://creativecommons.org/licenses/by-nd/2.0/');
wpbeautify_licenses[7] = new Array('No known copyright restrictions', '', 'http://www.23hq.com/commons/usage/');
wpbeautify_licenses[8] = new Array('United States Government Work', '', 'http://www.usa.gov/copyright.shtml');
wpbeautify_licenses[9] = new Array('Public Domain Dedication', 'CC0', 'http://creativecommons.org/publicdomain/zero/1.0/deed.en');


/* Share final image */

function wp_beautify_do_fb_share() {
	// console.log('aqui')
	var data = {
		action: 'wpbeautify_share_img_fb',
		type : jQuery('#wpbeautify-fb-share-type').val(),
		text : jQuery('#wpbeautify-fb-share-text').val(),
		link : jQuery('#wpbeautify-fb-share-link').val(),
		image_url : wpbeautify_final_image_url
	};

	jQuery.post(ajaxurl, data, function(response) {
		jQuery.themodal.close();
	});
}

function wp_beautify_do_twitter_share() {
	// console.log('aqui')
	var data = {
		action: 'wpbeautify_share_img_twitter',
		text : jQuery('#wpbeautify-twitter-share-text').val(),
		// link : jQuery('#wpbeautify-twitter-share-link').val(),
		image_url : wpbeautify_final_image_url
	};

	jQuery.post(ajaxurl, data, function(response) {
		jQuery.themodal.close();
	});
}

function wp_beautify_do_pinterest_share() {

	text = jQuery('#wpbeautify-pinterest-share-text').val(),
	link = jQuery('#wpbeautify-pinterest-share-link').val(),
	image_url = wpbeautify_final_image_url

	pin_it_url = "//www.pinterest.com/pin/create/button/?url="+encodeURIComponent(link)+"&media="+encodeURIComponent(image_url)+"&description="+encodeURIComponent(text);
	var win=window.open(pin_it_url, '_blank');
	  win.focus();
}


function wp_beautify_do_googleplus_share() {
	// console.log('aqui')

	var file_extension = jQuery('#wpbeautify_file_extension').html();
	var file_name = jQuery('#wpbeautify_file_name').val()
	if (!file_name || file_name == '') file_name = 'image';

	var data = {
		action: 'wpbeautify_share_img_googleplus',
		type : 1/*jQuery('#wpbeautify-fb-share-type').val()*/,
		text : jQuery('#wpbeautify-gplus-share-text').val(),
		// link : jQuery('#wpbeautify-gplus-share-link').val(),
		album : jQuery('#wpbeautify-gplus-albums').val(),
		image_url : wpbeautify_final_image_url,
		image_name : file_name+file_extension
	};

	jQuery.post(ajaxurl, data, function(response) {
		jQuery.themodal.close();
	});
}


function wp_beautify_do_dropbox_save() {
		image_url = wpbeautify_final_image_url;

// e.preventDefault();

	var options = {
	    /*files: [
	        // You can specify up to 100 files.
	        {'url': '...', 'filename': '...'},
	        {'url': '...', 'filename': '...'},
	        // ...
	    ],*/

	    // Success is called once all files have been successfully added to the user's
	    // Dropbox, although they may not have synced to the user's devices yet.
	    success: function () {
	        // Indicate to the user that the files have been saved.
	        alert("Success! Files saved to your Dropbox.");
	    },

	    // Progress is called periodically to update the application on the progress
	    // of the user's downloads. The value passed to this callback is a float
	    // between 0 and 1. The progress callback is guaranteed to be called at least
	    // once with the value 1.
	    progress: function (progress) {},

	    // Cancel is called if the user presses the Cancel button or closes the Saver.
	    cancel: function () {},

	    // Error is called in the event of an unexpected response from the server
	    // hosting the files, such as not being able to find a file. This callback is
	    // also called if there is an error on Dropbox or if the user is over quota.
	    error: function (errorMessage) {}
	};
	file_name = jQuery('#wpbeautify_file_name').val()+jQuery('#wpbeautify_file_extension').html()
	Dropbox.save(image_url, file_name, options);
}

function wp_beautify_do_gdrive_save() {
		image_url = wpbeautify_final_image_url;
	file_name = jQuery('#wpbeautify_file_name').val()+jQuery('#wpbeautify_file_extension').html()

		gapi.savetodrive.render('wpbtfy-savetodrive-div', {
		          src: image_url,
		          filename: file_name,
		          sitename: 'WP Beautify Pro'
		        });

		jQuery('#wpbeautify-gdrive-modal').themodal({
			fadeDuration: 250,
			fadeDelay: 0.80,
			escapeClose: true,
			  clickClose: false,
			  showClose: true
		});
}

function wpbeautify_enable_actions(action) {
	jQuery('button.wpbtfy-btn-action').prop('disabled', !action);

	if (!action) {
		jQuery('a.wpbtfy-btn-action').parent().addClass('disabled');
	}
	else {
		jQuery('a.wpbtfy-btn-action').parent().removeClass('disabled');
	}
}

function wpbeautify_load_gplus_albums() {
	// console.log('aqui')
	var data = {
		action: 'wpbeautify_googleplus_get_album_list'
	};

	jQuery.post(ajaxurl, data, function(response) {
		jQuery('#wpbeautify-gplus-albums').html(response);
		jQuery("#wpbeautify-gplus-albums option:selected").prop("selected", false);
		jQuery("#wpbeautify-gplus-albums option:first").prop("selected", "selected")
	});
}



function wpbeautify_dispatch_slide(event, this_el) {
	this_el.trigger({
	        'type': 'slide',
	        'value': event.value
	    })
	    .data('value', this_el.value)
	    .prop('value', this_el.value);
};



function wpbtfy_get_size_from_label( label )  {
	sizes = wpbeautify_vars.image_sizes;
	num_sizes = sizes.length;
	for (i=0;i<num_sizes;i++) {
		num_types = sizes[i].sizes.length;
		for (j=0;j<num_types;j++) {
			if (sizes[i].sizes[j][0] == label)
				return new Array(sizes[i].sizes[j][2], sizes[i].sizes[j][3]);
		}
	}
	return new Array(0,0);
}

/* Google DRive */

function wpbtfy_getDownloadUrl(fileId) {
            /*Before executing following client request you must include
                <script type="text/javascript" src="https://apis.google.com/js/client.js"></script>
            google client library*/

            var request =
                gapi.client.request({
                    'path': '/drive/v2/files/' + fileId,
                    'params': { 'maxResults': '1000' },
                    callback: function (responsejs, responsetxt) {
                            var fileDownloadUrl = responsejs.downloadUrl; //using this downloadUrl you will be able to download Drive File Successfully
                            wpbeautify_download_external_img(fileDownloadUrl, googledrive_show_image_results);

                    }
                });
        }


        function printFile(fileId) {
          var request = gapi.client.drive.files.get({
            'fileId': fileId
          });
          request.execute(function(resp) {
          	console.log(resp)
            console.log('Title: ' + resp.title);
            console.log('Description: ' + resp.description);
            console.log('MIME type: ' + resp.mimeType);
          });
        }

 function downloadFile(file, callback) {
   if (file.downloadUrl) {
     var accessToken = gapi.auth.getToken().access_token;
     var xhr = new XMLHttpRequest();
     xhr.open('GET', file.downloadUrl);
     xhr.setRequestHeader('Authorization', 'Bearer ' + accessToken);
     xhr.onload = function() {
     	console.log(xhr.responseText)
       // callback(xhr.responseText);
     };
     xhr.onerror = function() {
       callback(null);
     };
     xhr.send();
   } else {
     callback(null);
   }
 }

 function debug_item(item) {
 	console.log(item)
 }

function wpbtfy_set_sidebar_vals (filename, title, source, preview_img) {
	// console.log('fn'+filename)
 file_details = wpbeautify_get_file_name_from_url( filename );
 // console.log(file_details)
 jQuery('#wpbeautify_file_name').val(file_details[0]);
 jQuery('#wpbeautify_file_extension').html('.'+file_details[1]);
 jQuery('#wpbeautify_img_title').val(file_details[0]);
 jQuery('#wpbeautify_img_alt').val(file_details[0]);
 jQuery('#wpbeautify_img_name').html(file_details[0]);
 if (source) {
	 jQuery('#wpbeautify_img_source_link').html(source);
	 jQuery('#wpbeautify_img_source_link').attr('href', '#');
	}
/*	if (preview_img) {
		abc = 7;
	}*/
}


function wpbtfy_add_layer( type, layer, text, extra_id ) {
	if (!extra_id)
		extra_id = 0;
	var maxid = 0;
	jQuery( ".wpbtfy-layer" ).each(function( index ) {
		this_val = jQuery(this).attr('data-layer-id')
		if ( this_val > maxid )
			maxid = this_val;
	  // console.log( index + ": " + $( this ).text() );
	});
	maxid++;
	wpbtfy_layers.unshift(
		new Array( maxid, type, layer, text, extra_id )
	)
	wpbtfy_add_layer_html( maxid, type, text);
}

function wpbtfy_remove_layer( id ) {
	// console.log('remove '+id)
	for (i=0;i<wpbtfy_layers.length;i++) {
		if (wpbtfy_layers[i][0] == id) {
			type = wpbtfy_layers[i][1];
			layer = wpbtfy_layers[i][2];
			extra_id = wpbtfy_layers[i][4];
			wpbtfy_do_remove_layer( type, layer, extra_id );
			wpbtfy_layers.splice(i, 1);
			jQuery('.wpbtfy-layer[data-layer-id='+id+']').remove();
		}
	}
}

function wpbtfy_remove_layers_by_type( type ) {
	layers_delete = new Array();
	for (i=0;i<wpbtfy_layers.length;i++) {
		if (wpbtfy_layers[i][1] == type) {
			id = wpbtfy_layers[i][0];
			layers_delete.push( id );
			// wpbtfy_layers.splice(i, 1);
			// jQuery('.wpbtfy-layer[data-layer-id='+id+']').remove();
		}
	}
	layers_delete.reverse();
// console.log(layers_delete)
	for (j=0;j<layers_delete.length;j++) {
			id = layers_delete[j];
			// console.log('borro layer: '+id)
			wpbtfy_remove_layer( id );
			// wpbtfy_layers.splice(i, 1);
			// jQuery('.wpbtfy-layer[data-layer-id='+id+']').remove();
	}
}

function wpbtfy_do_remove_layer( type, layer, extra_id ) {
	if (type == 'text') {
		wpbeautify_delete_text( extra_id );
	}
	else if (type == 'shape' || type == 'line') {
		layer.destroy();
	}
}

function wpbeautify_remove_text_layer(text_id) {
	for (i=0;i<wpbtfy_layers.length;i++) {
		if (wpbtfy_layers[i][1] == 'text' && wpbtfy_layers[i][4] == text_id) {
			id = wpbtfy_layers[i][0];
			jQuery('.wpbtfy-layer[data-layer-id='+id+']').remove();
		}
	}
}

function wpbtfy_add_layer_html( id, type, text) {
	html_txt = '<div class="wpbtfy-layer" data-layer-id="'+id+'">'+
	  '<div class="layer-icon">'+
	  '  <i class="fa fa-'+wpbtfy_layer_type_icon(type)+'"></i>'+
	  '</div>'+
	  '<div class="layer-txt">'+
	  '  '+text+
	  '</div>'+
	  '<div class="layer-actions">'+
	  '  <i class="fa fa-arrow-down wpbtfy-layer-action wpbtfy-layer-down"></i>'+
	  '  <i class="fa fa-arrow-up wpbtfy-layer-action wpbtfy-layer-up"></i>'+
	  '  <i class="fa fa-remove wpbtfy-layer-action wpbtfy-layer-remove"></i>'+
	  '</div>'+
	  '<div class="clear"></div>'+
	  '</div>';

	jQuery('#wpbtfy-layers').prepend( html_txt );
}

function wpbtfy_layer_type_icon( type ) {
	if (type == 'text')
		return 'font'
	else if ( type == 'line')
		return 'minus'
	else if ( type == 'shape')
		return 'square-o'
	else
		return 'file-image-o';
}

function wpbtfy_get_layer_by_id( id ) {
	// console.log('remove '+id)
	for (i=0;i<wpbtfy_layers.length;i++) {
		if (wpbtfy_layers[i][0] == id) {
			return wpbtfy_layers[i];
		}
	}
	return 0;
}

function wpbtfy_layer_zindex( layer_id, direction ) {
	layer = wpbtfy_get_layer_by_id( layer_id );
	layer = layer[2];
	if (direction == 'up') {
		// zindex = layer.getZIndex();
		// layer.setZIndex(++zindex);
		layer.moveUp();
	}

	else if (direction == 'down') {
		// zindex = layer.getZIndex();
		// if (zindex > 0)
			// zindex--;
		// layer.setZIndex(zindex);
		layer.moveDown();
	}
	global_stage.draw();
/*
	for (i=0;i<wpbtfy_layers.length;i++) {
		if (wpbtfy_layers[i][0] == layer_id) {
			type = wpbtfy_layers[i][1];
			layer = wpbtfy_layers[i][2];
			extra_id = wpbtfy_layers[i][4];
			zindex = layer.getZIndex();
			console.log('zindex antes: '+zindex)
			if (zindex)
				zindex--;
			layer.setZIndex(zindex);
			zindex = layer.getZIndex();
			console.log('zindex despues: '+zindex)

		}
	}*/

}


/* Search Images to insert */


function wpbeautify_do_image_search_layers () {
	sites_selected = jQuery('#wpbeautify_freeimg_sources option:selected');
	sites_to_query = new Array('pixabay'/*, 'openclipart'*/);

	// console.log(sites_selected)

	/*jQuery.each(sites_selected, function(i, val) {
		this_el = jQuery(this);
		if (this_el.val() != 'all-sites')
			sites_to_query.push(this_el.val());
	});
	if (sites_to_query.length == 0) sites_to_query = 0;*/

	type_photo = 'true';
	type_clipart = 'true';

	/*img_type = jQuery('#wpbeautify_freeimg_type').val();
	if (img_type == 'photo')
		type_clipart = 0;
	if (img_type == 'clipart')
		type_photo = 0;*/

	yes_attribution = 'false';
	no_attribution = 'true';

	/*attr_type = jQuery('#wpbeautify_attribution_required').val();
	if (attr_type == 'attribution')
		no_attribution = 'false'
	else if (attr_type == 'noattribution')
		yes_attribution = 'false'*/

	jQuery("#wpbtfy_free_imgs_layer_div").html('<div id="wpbeautify_freeimg_loading" class="wpbeautify-loading" style="display:block"></div>')

	var data = {
		action: 'wpbeautify_search_free_image',
		keyword : jQuery('#wpbtfy-search-layer-imgs-keyword').val(),
		page : wpbeautify_layer_img_page,
		attribution : yes_attribution,
		noattribution : no_attribution,
		only_modifiables : true,
		photo : type_photo,
		clipart : type_clipart,
		sites : sites_to_query,
		is_small: true
	};

	jQuery.post(ajaxurl, data, function(response) {
		jQuery("#wpbtfy_free_imgs_layer_div").html(response);
		jQuery("#wpbtfy_free_imgs_layer_div").show();
	});
}

function wpbeautify_insert_image_layer( url ) {
	if (url) {
		wpbeatify_show_loading_modal();
		wpbeautify_download_layer_img(url, wpbeautify_layerimage_finished);
	}
	else if (wpbeautify_layer_img_just_selected) {
		wpbeatify_show_loading_modal();
		wpbeautify_download_layer_img(wpbeautify_layer_img_just_selected, wpbeautify_layerimage_finished);
	}
}

function wpbeautify_layerimage_finished() {
	wpbeatify_hide_loading_modal();


	var imageObj = new Image();
	imageObj.onload = function() {
		var img_layer_layer = new Konva.Layer();
		var img_width = this.width
		var img_height = this.height

		if (img_width > img_height) {
			// imagen horizontal
			inserted_img_width = global_width / 4;
			ratio = img_width / inserted_img_width;
			inserted_img_height = img_height / ratio;
		}
		else {
			inserted_img_height = global_height / 4;
			ratio = img_height / inserted_img_height;
			inserted_img_width = img_width / ratio;
		}
/*		console.log(this.width)
		console.log(this.height)
		var global_width = 0;
		var global_height = 0;*/

	  var image = new Konva.Image({
	    x: 0,
	    y: 0,
	    image: imageObj,
	    width: inserted_img_width,
	    height: inserted_img_height,
	    draggable: false,
	    name: 'image',
	    	    stroke: '#000',
	    	    strokeWidth: 1,
	            dash: [10, 5],
	            strokeEnabled : false
	  });

	  // add the shape to the layer

	  var imageGroup = new Konva.Group({
	    x: 90,
	    y: 90,
	    width: inserted_img_width,
	    height: inserted_img_height,
	    draggable: true,

	  });

	  img_layer_layer.add(imageGroup);

	  imageGroup.on('mouseover', function() {
          // console.log('over group')
	    	imageGroup.find('.image')[0].strokeEnabled(true);

	    	imageGroup.find('.topLeft')[0].show();
	    	imageGroup.find('.topRight')[0].show();
	    	imageGroup.find('.bottomRight')[0].show();
	    	imageGroup.find('.bottomLeft')[0].show();

	    	img_layer_layer.draw();

	  });

	  imageGroup.on('mouseout', function() {
	    	imageGroup.find('.image')[0].strokeEnabled(false);
	  		imageGroup.find('.topLeft')[0].hide();
	  		imageGroup.find('.topRight')[0].hide();
	  		imageGroup.find('.bottomRight')[0].hide();
	  		imageGroup.find('.bottomLeft')[0].hide();
	  		img_layer_layer.draw();
	  });

	  image.on('mouseout', function() {
            document.body.style.cursor = 'default';

	  });

	  image.on('mouseover', function() {
            document.body.style.cursor = 'move';
	  });

	  imageGroup.add(image);
	  addAnchorImg(imageGroup, 0, 0, 'topLeft', true);
	  addAnchorImg(imageGroup, inserted_img_width, 0, 'topRight', true);
	  addAnchorImg(imageGroup, inserted_img_width, inserted_img_height, 'bottomRight', true);
	  addAnchorImg(imageGroup, 0, inserted_img_height, 'bottomLeft', true);

	  global_stage.add(img_layer_layer);

	  // add the layer to the stage
	  wpbtfy_add_layer( 'image', /*layer*/img_layer_layer, 'Image'/*, 0, shapes_layer*/ );

	}
	imageObj.src = wpbeautify_layer_img_just_selected;
}

function wpbeautify_download_layer_img(imgurl, callback) {
	var data = {
		action: 'wpbeautify_external_upload',
		url : imgurl
	};


	jQuery.post(ajaxurl, data, function(response) {
			// wpbeautify_set_up_stage(response);
			wpbeautify_layer_img_just_selected = response
			// jQuery('#wpbeautify_preview_img').attr('src', response)
			// if (force_file_name)
			// 	file_name = force_file_name;
			// else
			// 	file_name = wpbeautify_get_file_name_from_url(imgurl);

			// wpbeautify_update_fileext(file_name[0], file_name[1]); // rmi353, acabo de cambiar
			// jQuery('#wpbeautify_img_title').val(file_name[0]);
			// jQuery('#wpbeautify_img_caption').val('');

			wpbeautify_hide_loading()
			// wpbeautify_enable_editor()
			if (callback)
				callback();
	});
}
/*
function wpbtfy_hide_anchors() {
    for (i=0;i<wpbtfy_anchors.length;i++)
    	wpbtfy_anchors[i].hide();
}

function wpbtfy_show_anchors() {
 for (i=0;i<wpbtfy_anchors.length;i++)
 	wpbtfy_anchors[i].show();
}*/

     function updateAnchor(activeAnchor) {
        var group = activeAnchor.getParent();

        var topLeft = group.find('.topLeft')[0];
        var topRight = group.find('.topRight')[0];
        var bottomRight = group.find('.bottomRight')[0];
        var bottomLeft = group.find('.bottomLeft')[0];
        var image = group.find('.image')[0];

        var anchorX = activeAnchor.x();
        var anchorY = activeAnchor.y();

        // update anchor positions
        switch (activeAnchor.name()) {
          case 'topLeft':
            topRight.y(anchorY);
            bottomLeft.x(anchorX);
            break;
          case 'topRight':
            topLeft.y(anchorY);
            bottomRight.x(anchorX);
            break;
          case 'bottomRight':
            bottomLeft.y(anchorY);
            topRight.x(anchorX);
            break;
          case 'bottomLeft':
            bottomRight.y(anchorY);
            topLeft.x(anchorX);
            break;
        }

        image.setPosition(topLeft.getPosition());

        var width = topRight.x() - topLeft.x();
        var height = bottomLeft.y() - topLeft.y();
        if(width && height) {
        	// console.log('aaa')
          image.setSize({width:width, height: height});
          // jQuery('#img-new-height-crop').val(wpbeautify_roundToTwo(height))
          // jQuery('#img-new-width-crop').val(wpbeautify_roundToTwo(width))
	// console.log(image.x())
	// console.log(image.y())
        }
      }

      function addAnchorImg(group, x, y, name, start_hidden) {
      	if (!start_hidden)
      		start_hidden = false;

        var stage = group.getStage();
        var layer = group.getLayer();

        var anchor = new Konva.Circle({
          x: x,
          y: y,
          stroke: '#000',
          // fill: '#ddd',
          strokeWidth: 2,
          radius: 6,
          name: name,
          draggable: true,
          dragOnTop: false
        });

        /*var anchor = new Konva.Rect({
          x: x,
          y: y,
          stroke: '#000',
          // fill: '#ddd',
          strokeWidth: 2,
          // radius: 8,
          width: 10,
          height: 10,
          name: name,
          draggable: true,
          dragOnTop: false
        });*/

        anchor.on('dragmove', function() {
          updateAnchor(this);
          layer.draw();
        });
        anchor.on('mousedown touchstart', function() {
          group.setDraggable(false);
          this.moveToTop();
        });
        anchor.on('dragend', function() {
          group.setDraggable(true);
          layer.draw();
        });
        // add hover styling
        anchor.on('mouseover', function() {
          var layer = this.getLayer();
// console.log(name)
          if (name == 'topLeft')
          	document.body.style.cursor = 'nw-resize';
          else if (name == 'bottomLeft')
          	document.body.style.cursor = 'sw-resize';
          else if (name == 'topRight')
          	document.body.style.cursor = 'ne-resize';
          else
          	document.body.style.cursor = 'se-resize';
          // console.log('over anchor')
          // this.setStrokeWidth(4);
          // this.show();
          layer.draw();
        });
        anchor.on('mouseout', function() {
          var layer = this.getLayer();
          document.body.style.cursor = 'default';
          this.strokeWidth(2);
          // this.hide();

          layer.draw();
        });

        if (start_hidden)
        	anchor.hide();
        group.add(anchor);
        // wpbtfy_anchors.push(anchor)
      }

/* Plan BG Color */

function wpbtfy_set_bg_color( color ) {
	size = jQuery('#wpbeautify_plainbg').val();
	if (!size || size == '0')
		tamano = new Array(800, 600);
	else
		tamano = wpbtfy_get_size_from_label( size );
	wpbeautify_is_edition = 1;
	wpbeautify_set_up_stage(false, wpbtfy_show_second_tab, color, tamano[0], tamano[1]);
}

function wpbtfy_show_second_tab() {
	// console.log('llamo')
	jQuery('#wpbeautify_file_name').val('Image');
	jQuery('#wpbeautify_file_extension').html('.png');
	jQuery('#wpbeautify_img_title').val('Image');

	jQuery('#wpbtfy-tabs a:last').tab('show');
	wpbeautify_enable_actions(1);
}