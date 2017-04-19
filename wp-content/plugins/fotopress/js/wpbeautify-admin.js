var wpbeautify_current_font = '';
jQuery( document ).ready(function(  ) {
	jQuery('.wpbeautify-preview-font').click(function( ){
		font_name = jQuery(this).attr('data-font-name');
		wpbeautify_current_font = font_name;
		// console.log(font_name)
		jQuery('.wpbeautify_font_preview_big, .wpbeautify_font_preview_small').css('font-family', font_name);
		jQuery('#wpbeautify_font_modalLabel').html(font_name)

		if (wpbeautify_is_font_enabled(font_name)) {
			jQuery('#popup_disable_font_btn').show();
			jQuery('#popup_enable_font_btn').hide();
		}
		else {
			jQuery('#popup_disable_font_btn').hide();
			jQuery('#popup_enable_font_btn').show();

		}

		jQuery('#wpbeautify_font_modal').modal();
	});

	jQuery('#wpbeautify_font_modal').on('hidden.bs.modal', function () {
    	jQuery('.wpbeautify_font_preview_big').css('font-size', 24);
    	jQuery('.wpbeautify_font_preview_small').css('font-size', 12);
	})
	try {
		jQuery('.wpb_switch').bootstrapSwitch();
	}
	catch(err) {
	    // Block of code to handle errors
	}
/*	jQuery('.wpbtfy-popover').popover();

	jQuery('#examplep').popover();*/

	jQuery('.font_list_switch').on('switchChange.bootstrapSwitch', function (e, state) {
	    /*var $el = jQuery(data.el)
	      , value = data.value;

	      font = $el.attr('data-font-name')*/

	      font = jQuery(this).attr('data-font-name')
	      value = state ? 1 : 0;
   		wpbeautify_enable_font(font, value);
	});

	jQuery('.btn-enable-font-combination').click(function( ){
		this_el = jQuery(this);
		well = jQuery(this).closest('.well');
		header_font = well.attr('data-header-font');
		body_font = well.attr('data-body-font');
		wpbeautify_enable_font(header_font, 1);
		window.setTimeout(function() {
		    wpbeautify_enable_font(body_font, 1)
		}, 1500)
		// window.setTimeout(, 4000);
		this_el.removeClass('btn-info').addClass('btn-success').html('<i class="fa fa-check-square-o"></i>Enabled!');
	})

	jQuery('.btn-set-font-combination').click(function( ){
		this_el = jQuery(this);
		well = jQuery(this).closest('.well');
		header_font = well.attr('data-header-font');
		body_font = well.attr('data-body-font');
		wpbeautify_enable_font(header_font, 1, wpbeautify_set_header_font);
		window.setTimeout(function() {
			wpbeautify_enable_font(body_font, 1, wpbeautify_set_body_font);
		}, 1500)
		this_el.removeClass('btn-info').addClass('btn-success').html('<i class="fa fa-check-square-o"></i>Activated!');

	})

	jQuery('#popup_enable_font_btn').click(function( ){
		// console.log(wpbeautify_current_font)
		wpbeautify_enable_font(wpbeautify_current_font, 1);
		jQuery(this).hide();
		jQuery('#popup_disable_font_btn').show();
	});


	jQuery('#popup_disable_font_btn').click(function( ){
		// console.log(wpbeautify_current_font)

		wpbeautify_enable_font(wpbeautify_current_font, 0);
		jQuery(this).hide();
		jQuery('#popup_enable_font_btn').show();
	});

	// video
	jQuery ('input[name=logo_position]').click(function( ){
		wpbeautify_update_logo_preview();
	});

	jQuery ('#logo_transparency').change(function( ){
		wpbeautify_update_logo_preview();
	});


	jQuery('.effect_list_switch').on('switchChange.bootstrapSwitch', function (e, state) {


	    var $el = jQuery(this)

		var data = {
			action: 'wpbeautify_add_effect',
			activate: state ? 1 : 0,
			effect : $el.attr('data-effect-name')
		};

		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		jQuery.post(ajaxurl, data, function(response) {
			if (data.activate) {
				$el.closest('tr').addClass('success')
				jQuery(".wpbeautify_effect_select").append('<option style="effect-family:'+data.effect+'" value="'+data.effect+'">'+data.effect+'</option>');
			}
			else {
				$el.closest('tr').removeClass('success')
				jQuery(".wpbeautify_effect_select option[value='"+data.effect+"']").remove();
			}
			wpbeautify_update_effect_num();
		});
	});


	jQuery('.wpbeautify_advanced_options .handlediv').click(function() {
		jQuery(this).parent().find('.inside').toggle();
	});

    jQuery(".wpbeautify_sortable").sortable({
      update : function () {
		i = 0;
		jQuery('#wpbeautify_sites_list').find('li').each(function(){
			jQuery(this).find('.wpbeautify_order').val(i++);
		})
      }
    });

    jQuery("#wp_beautify_fb_auth").click(function( ){
    	jQuery('#wpbeautify_fb_authorize').val(1);
    	jQuery('#wpbeautify_images_form').submit();
	});

    jQuery("#wp_beautify_fb_deauth").click(function( ){
    	jQuery('#wpbeautify_fb_authorize').val(2);
    	jQuery('#wpbeautify_images_form').submit();
	});


    jQuery("#wp_beautify_instagram_auth").click(function( ){
    	jQuery('#wpbeautify_instagram_authorize').val(1);
    	jQuery('#wpbeautify_images_form').submit();
	});

    jQuery("#wp_beautify_gdrive_auth").click(function( e ){
    	e.preventDefault()
    	jQuery('#wpbeautify_gdrive_authorize').val(1);
    	jQuery('#wpbeautify_images_form').submit();
	});

    jQuery("#wp_beautify_flickr_auth").click(function( ){
    	jQuery('#wpbeautify_flickr_authorize').val(1);
    	jQuery('#wpbeautify_images_form').submit();
	});

    jQuery('#watermark_type_text').click(function(e) {
    	jQuery('#watermark_image_settings').hide();
    	jQuery('#watermark_text_settings').show();
    });

    jQuery('#watermark_type_image').click(function(e) {
    	jQuery('#watermark_text_settings').hide();
    	jQuery('#watermark_image_settings').show();
    });

    try {
    	jQuery('.wpbtfy-colorpicker').minicolors();
    	jQuery('.wpbtfy-spinner').spinedit();
    }
    catch(err) {
        // Block of code to handle errors
    }


	jQuery ('#wpbeautify_pixabay_ownkey').change(function( e ){
		$this = jQuery(this);
		if( $this.is(':checked') )
			jQuery('#pixabay-extra').show();
		else
			jQuery('#pixabay-extra').hide();
			
		// wpbeautify_update_logo_preview();
	});

	/* 1.2. WP Image Selector */
	var _custom_media = true,
	_orig_send_attachment = wp.media.editor.send.attachment;

	jQuery('#wpbeautify_watermark_uploadimg').click(function(e) {
		e.preventDefault();
		var send_attachment_bkp = wp.media.editor.send.attachment;
		var button = jQuery(this);
		_custom_media = true;

		wp.media.editor.send.attachment = function(props, attachment){
		 	if ( _custom_media ) {
				// console.log(attachment)
				jQuery('#upload_image_url').val(attachment.url)
				jQuery('#upload_image_url').trigger('change');
				jQuery('#img_watermark_preview').attr('src', attachment.url)
			} else {
				return _orig_send_attachment.apply( this, [props, attachment] );
			};
		}

		wp.media.editor.open(button);
		return false;
	});

	jQuery('.add_media').on('click', function(){
		_custom_media = false;
	});

	jQuery('.font_el_enable').on('change', function(){
		// _custom_media = false;
		// console.log('tttt')
		this_el = jQuery(this);
		if (this_el.is(':checked'))
			jQuery(this).closest('tr').find('span').removeClass('empty')
		else
			jQuery(this).closest('tr').find('span').addClass('empty')

	});

	function toggleChevron(e) {
	    jQuery(e.target)
	        .prev('.panel-heading')
	        .find("i.indicator")
	        .toggleClass('glyphicon-chevron-down glyphicon-chevron-up');
	}
	jQuery('#accordion').on('hidden.bs.collapse', toggleChevron);
	jQuery('#accordion').on('shown.bs.collapse', toggleChevron);

	wpbeautify_update_font_num();
	wpbeautify_update_effect_num();

	jQuery('#wpbeautify_increase_font_popup').click(function( ){
		current_big = parseInt(jQuery('.wpbeautify_font_preview_big').css('font-size')) + 2;
		jQuery('.wpbeautify_font_preview_big').css('font-size', current_big);

		current_small = parseInt(jQuery('.wpbeautify_font_preview_small').css('font-size')) + 2;
		jQuery('.wpbeautify_font_preview_small').css('font-size', current_small);

	});

	jQuery('#wpbeautify_decrease_font_popup').click(function( ){
		current_big = parseInt(jQuery('.wpbeautify_font_preview_big').css('font-size')) - 2;
		if (current_big > 12)
			jQuery('.wpbeautify_font_preview_big').css('font-size', current_big);

		current_small = parseInt(jQuery('.wpbeautify_font_preview_small').css('font-size')) - 2;
		if (current_small > 2)
			jQuery('.wpbeautify_font_preview_small').css('font-size', current_small);

	});

});


function wpbeautify_enable_font(font, status, callback) {
	var data = {
		action: 'wpbeautify_add_font',
		activate: status ? 1 : 0,
		font : font
	};

	jQuery.post(ajaxurl, data, function(response) {
		tr_font = jQuery('#canvakala-fonts-table').find("tr[data-font-name='" + data.font + "']");
		// console.log(data.activate)
		if (data.activate) {
			tr_font.addClass('success')
			jQuery(".wpbeautify_font_select option[value='"+data.font+"']").remove();
			jQuery(".wpbeautify_font_select").append('<option style="font-family:'+data.font+'" value="'+data.font+'">'+data.font+'</option>');
			if (callback)
				callback(font);
			wpbeautify_update_font_num()
		}
		else {
			tr_font.removeClass('success')
			jQuery(".wpbeautify_font_select option[value='"+data.font+"']").remove();
			wpbeautify_update_font_num()
		}
	});
}

function wpbeautify_set_header_font(font) {
	for (i=1;i<5;i++) {
		jQuery('#h'+i+'_font').val(font);
		jQuery('.table_select_texts input[name="h'+i+'_enabled"]').attr('checked', true);
		jQuery('.table_select_texts input[name="h'+i+'_enabled"]').trigger('change');
	}

}

function wpbeautify_set_body_font(font) {
	jQuery('#p_font').val(font);
	jQuery('#li_font').val(font);
	jQuery('.table_select_texts input[name="p_enabled"]').attr('checked', true);
	jQuery('.table_select_texts input[name="li_enabled"]').attr('checked', true);
	jQuery('.table_select_texts input[name="li_enabled"]').trigger('change');
	jQuery('.table_select_texts input[name="p_enabled"]').trigger('change');
}

function wpbeautify_update_font_num() {
	// num_fonts = 3;
	num_fonts = jQuery('#h1_font option').length -1;
	if (num_fonts < 4) {
		// ok
		cssclass = 'success';
		jQuery('#font_explanation').hide()
	}
	else if (num_fonts < 7) {
		// warning
		cssclass = 'warning';
		jQuery('#font_explanation').show().html('Adding more fonts might slow down your site');
	}
	else {
		// error
		cssclass = 'danger';
		jQuery('#font_explanation').show().html('Adding more fonts might slow down your site');
	}

	jQuery('#wpbtfy_num_fonts').html(num_fonts);

	if (num_fonts > 10) num_fonts = 10;

	progress_el = jQuery('#active_fonts_progress');
	progress_el.width((num_fonts*10)+ "%");
	progress_el.removeClass();
	progress_el.addClass('progress-bar progress-bar-'+cssclass );

	alert_el = jQuery('#active_fonts_wrapper');
	alert_el.removeClass();
	alert_el.addClass('alert alert-'+cssclass );
}


function wpbeautify_update_effect_num() {
	// num_effects = 3;
	num_effects = jQuery('#h1_effect option').length -1;
	if (num_effects < 4) {
		// ok
		cssclass = 'success';
		jQuery('#effect_explanation').hide()
	}
	else if (num_effects < 7) {
		// warning
		cssclass = 'warning';
		jQuery('#effect_explanation').show().html('Adding more effects might slow down your site');
	}
	else {
		// error
		cssclass = 'danger';
		jQuery('#effect_explanation').show().html('Adding more effects might slow down your site');
	}

	jQuery('#wpbtfy_num_effects').html(num_effects);

	if (num_effects > 10) num_effects = 10;

	progress_el = jQuery('#active_effects_progress');
	progress_el.width((num_effects*10)+ "%");
	progress_el.removeClass();
	progress_el.addClass('progress-bar progress-bar-'+cssclass );

	alert_el = jQuery('#active_effects_wrapper');
	alert_el.removeClass();
	alert_el.addClass('alert alert-'+cssclass );
}


function wpbeautify_is_font_enabled(font) {
	// var current_fonts = jQuery('#h1_font option').map(function() { return jQuery(this).val(); });
	var current_fonts = jQuery.map(jQuery('#h1_font option'), function(e) { return e.value; });
	for (i=0;i<current_fonts.length;i++) {
		if (current_fonts[i] == font)
			return 1;
	}
	return 0;
}

/* Video */

function wpbeautify_update_logo_preview() {
	logo_img = jQuery('#video-preview-logo');
	logo_img.attr('src', jQuery('#upload_image_url').val());
	pos = jQuery ('input[name=logo_position]:checked').val();
	transparency = jQuery('#logo_transparency').val();
	var default_offset = 15;
	var top = 0;
	var bottom = 0;
	var left = 0;
	var right = 0;

	switch (pos) {
		case 'top_left':
			top = default_offset;
			left = default_offset;
			break;
		case 'top_right':
			top = default_offset;
			right = default_offset;
			break;
		case 'bottom_left':
			bottom = default_offset;
			left = default_offset;
			break;
		case 'bottom_right':
			bottom = default_offset;
			right = default_offset;
			break;
	}

	logo_img.attr( "style", "" );
	if (top) {
		logo_img.css({
			'top' : top+'px'
		});
	}

	if (right) {
		logo_img.css({
			'right' : right+'px'
		});
	}

	if (left) {
		logo_img.css({
			'left' : left+'px'
		});
	}

	if (bottom) {
		logo_img.css({
			'bottom' : bottom+'px'
		});
	}

	if (transparency && transparency != '0') {
		trans = (100 - transparency)/100;
		logo_img.css({
			'opacity' : trans
		});
	}
	// switch ()
}



/**!
 * Google Drive File Picker Example
 * By Daniel Lo Nigro (http://dan.cx/)
 */
(function() {
  /**
   * Initialise a Google Driver file picker
   */
  var FilePicker = window.FilePicker = function(options) {
    // Config
    this.apiKey = options.apiKey;
    this.clientId = options.clientId;

    // Elements
    this.buttonEl = options.buttonEl;

    // Events
    this.onSelect = options.onSelect;
    this.buttonEl.addEventListener('click', this.open.bind(this));

    // Disable the button until the API loads, as it won't work properly until then.
    this.buttonEl.disabled = true;



    // Load the drive API
    gapi.client.setApiKey(this.apiKey);
    gapi.client.load('drive', 'v2', this._driveApiLoaded.bind(this));
    google.load('picker', '1', { callback: this._pickerApiLoaded.bind(this) });


  }

  FilePicker.prototype = {
    /**
     * Open the file picker.
     */
    open: function() {
      // Check if the user has already authenticated
      var token = gapi.auth.getToken();
      if (token) {
        this._showPicker();
      } else {
        // The user has not yet authenticated with Google
        // We need to do the authentication before displaying the Drive picker.
        this._doAuth(false, function() { this._showPicker(); }.bind(this));
      }
    },

    /**
     * Show the file picker once authentication has been done.
     * @private
     */
    _showPicker: function() {
    	// gapi.auth.setToken(null)
      var accessToken = gapi.auth.getToken().access_token;
      // var view = new google.picker.PhotosView().setType(google.picker.PhotosView.Type.UPLOADED);
      var webcamview = new google.picker.WebCamView(google.picker.WebCamViewType.STANDARD);

      this.picker = new google.picker.PickerBuilder().
        // addView(google.picker.ViewId.PHOTOS).
        addView(google.picker.ViewId.DOCS_IMAGES).
        // addView(google.picker.ViewId.IMAGE_SEARCH).
        // addView(webcamview).
        setAppId(this.clientId).
        setOAuthToken(accessToken).
        setCallback(this._pickerCallback.bind(this)).
        build().
        setVisible(true);

        // this.picker.addView(google.picker.ViewId.DOCS_IMAGES);

    },

    /**
     * Called when a file has been selected in the Google Drive file picker.
     * @private
     */
    _pickerCallback: function(data) {
      /*if (data[google.picker.Response.ACTION] == google.picker.Action.PICKED) {
        var file = data[google.picker.Response.DOCUMENTS][0],
          id = file[google.picker.Document.ID],
          request = gapi.client.drive.files.get({
            fileId: id
          });

        request.execute(this._fileGetCallback.bind(this));
      }*/
      var url = 'nothing';
              if (data[google.picker.Response.ACTION] == google.picker.Action.PICKED) {
                var file = data[google.picker.Response.DOCUMENTS][0];
                var id = file[google.picker.Document.ID];

                /*
					picasa
					docs

                */
                if (file.serviceId == 'picasa') {
                	return;
                	url = file[google.picker.Document.URL];
                	console.log(url)
                	    var request = gapi.client.drive.files.get({
                	      fileId: id
                	    });
// console.log('file1 = ')
// console.log(file)
                	  request.execute(this._fileGetCallbackPicasa.bind(this));

                }
                else {
                	jQuery('#wpbeautify_googledrive_loading').show();
// console.log(file)
                	var imgurl = 'https://www.googleapis.com/drive/v2/files/'+id+'?alt=media';
                	var accessToken = gapi.auth.getToken().access_token;
                	    var xhr = new XMLHttpRequest();
                	    xhr.open('GET', imgurl);
                	    xhr.overrideMimeType('text/plain; charset=x-user-defined');
                	    xhr.setRequestHeader('Authorization', 'Bearer ' + accessToken);
                	    xhr.onload = function() {
                	      jQuery( "#wpbtfy-drive-test" ).load(function( e ) {
                	      	// console.log('eventoooo')
                	        txt = jQuery("#wpbtfy-drive-test").attr('src');
                	        wpbeautify_download_external_img('nothing', googledrive_show_image_results, file.name, true,  txt);
                	        wpbtfy_set_sidebar_vals(file.name, file.name);
                	        jQuery('#wpbeautify_googledrive_results').html('<div style="text-align:center"><img style="width:110px" src="'+/*file.thumbnailLink*/''+'" /><br/><span>'+file.name+'</span><br/>'+wpbtfy_edit_img_txt+'</div>');
                	        jQuery( "#wpbtfy-drive-test" ).unbind();
                	      });

                	      jQuery("#wpbtfy-drive-test").attr('src', 'data:image/png;base64,' + base64Encode(xhr.responseText));
                	    };
                	    xhr.onerror = function() {
                	    	console.log('aquino')

                	      // callback(null);
                	    };
                	    xhr.send();
                }
              }
    },
    /**
     * Called when file details have been retrieved from Google Drive.
     * @private
     */
    _fileGetCallback: function(file) {
      /*if (this.onSelect) {
        this.onSelect(file);
      }*/
// console.log('file_content')
// console.log(file)
	  url = file.webContentLink;
	  url = url.replace("export=download", "export=view")
	  url = file.downloadURL;

  	// console.log('no drive')


      jQuery('#wpbeautify_googledrive_loading').show();
      wpbeautify_download_external_img(url, googledrive_show_image_results, file.originalFilename, true);
      jQuery('#wpbeautify_googledrive_results').html('<div style="text-align:center"><img style="width:110px" src="'+file.thumbnailLink+'" /><br/><span>'+file.originalFilename+'</span><br/>'+wpbtfy_edit_img_txt+'</div>');
    },

        _fileGetCallbackPicasa: function(file, type) {
// console.log('file2 = ')
// console.log(file)

          jQuery('#wpbeautify_googledrive_loading').show();
          wpbeautify_download_external_img(url, googledrive_show_image_results, file.originalFilename);
          jQuery('#wpbeautify_googledrive_results').html('<div style="text-align:center"><img style="width:110px" src="'+file.thumbnailLink+'" /><br/><span>'+file.originalFilename+'</span><br/>'+wpbtfy_edit_img_txt+'</div>');
        },
    /**
     * Called when the Google Drive file picker API has finished loading.
     * @private
     */
    _pickerApiLoaded: function() {
      this.buttonEl.disabled = false;
    },

    /**
     * Called when the Google Drive API has finished loading.
     * @private
     */
    _driveApiLoaded: function() {
      this._doAuth(true);
    },

    /**
     * Authenticate with Google Drive via the Google JavaScript API.
     * @private
     */
    _doAuth: function(immediate, callback) {
    	client_id = this.clientId;
    	if( client_id.indexOf('.apps.googleusercontent.com') !== -1 )
    		client_id = clientId + '.apps.googleusercontent.com';
      gapi.auth.authorize({
        client_id: client_id/*this.clientId + '.apps.googleusercontent.com'*/,
        // scope: 'https://www.googleapis.com/auth/drive.readonly',
        // scope: 'https://www.googleapis.com/auth/photos',
        scope: 'https://www.googleapis.com/auth/drive.readonly'/*['https://www.googleapis.com/auth/photos', 'https://www.googleapis.com/auth/drive.readonly', 'https://www.googleapis.com/auth/drive.readonly.metadata', 'https://www.googleapis.com/auth/photos.upload']*/,
        //scope: ['https://www.googleapis.com/auth/photos', 'https://www.googleapis.com/auth/drive.readonly'],
        immediate: immediate
      }, callback);
    }
  };
}());


function wpbtfy_getURL(url, accessToken){
    return jQuery.ajax({
        type: "GET",
        url: url,
        cache: false,
        async: false,
        beforeSend: function (request)
        {
            request.setRequestHeader("Authorization", 'Bearer ' + accessToken);
        }
    }).responseText;
}

function getBase64FromImageUrl(URL) {
    var img = new Image();
    img.src = URL;
    img.onload = function () {


    var canvas = document.createElement("canvas");
    canvas.width =this.width;
    canvas.height =this.height;

    var ctx = canvas.getContext("2d");
    ctx.drawImage(this, 0, 0);


    var dataURL = canvas.toDataURL("image/png");

    alert(  dataURL.replace(/^data:image\/(png|jpg);base64,/, ""));

    }
}

    function getBase64Image(img) {
        // Create an empty canvas element
        var canvas = document.createElement("canvas");
        canvas.width = img.width;
        canvas.height = img.height;

        // Copy the image contents to the canvas
        var ctx = canvas.getContext("2d");
        ctx.drawImage(img, 0, 0);

        // Get the data-URL formatted image
        // Firefox supports PNG and JPEG. You could check img.src to
        // guess the original format, but be aware the using "image/jpg"
        // will re-encode the image.
        var dataURL = canvas.toDataURL("image/png");

        return dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
    }



    function base64Encode(str) {
            var CHARS = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
            var out = "", i = 0, len = str.length, c1, c2, c3;
            while (i < len) {
                c1 = str.charCodeAt(i++) & 0xff;
                if (i == len) {
                    out += CHARS.charAt(c1 >> 2);
                    out += CHARS.charAt((c1 & 0x3) << 4);
                    out += "==";
                    break;
                }
                c2 = str.charCodeAt(i++);
                if (i == len) {
                    out += CHARS.charAt(c1 >> 2);
                    out += CHARS.charAt(((c1 & 0x3)<< 4) | ((c2 & 0xF0) >> 4));
                    out += CHARS.charAt((c2 & 0xF) << 2);
                    out += "=";
                    break;
                }
                c3 = str.charCodeAt(i++);
                out += CHARS.charAt(c1 >> 2);
                out += CHARS.charAt(((c1 & 0x3) << 4) | ((c2 & 0xF0) >> 4));
                out += CHARS.charAt(((c2 & 0xF) << 2) | ((c3 & 0xC0) >> 6));
                out += CHARS.charAt(c3 & 0x3F);
            }
            return out;
        }