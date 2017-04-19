(function() {
	tinymce.create('tinymce.plugins.wpbeautifyvideo', {
		init: function(ed, url) {
			// console.log(url)
			ed.addButton('wpbeautifyvideo', {
				title: 'FotoPress Video',
				image: url+'/../img/icons/film_add.png',
				onclick: function() {
					var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
					W = W - 80;
					H = H - 124;
					tb_show('FotoPress Video', '#TB_inline?inlineId=wpbeautifyJSpopup&width=' + W + '&height=' + H);
					jQuery("#TB_window").animate({
						height: H + 40 + 'px'
					});
					return false;
				}
			});
		},
		createControl: function(n, cm) {
			return null;
		},
		getInfo: function() {
			return {
				longname: 'FotoPress Video',
				author: 'Raul Mellado',
				authorurl: 'http://www.raulmellado.com/',
				infourl: 'http://www.fotopress.com/',
				version: '1.0'
			};
		}
	});
	tinymce.PluginManager.add('wpbeautifyvideo', tinymce.plugins.wpbeautifyvideo);
	
	jQuery(function() {
		//get the checkbox defaults
		var autoplay_default = jQuery('#wpbeautifyvideo-autoplay-default').val();
		if ( autoplay_default == 'on' )
			autoplay_checked = ' checked';
		else
			autoplay_checked = '';
		
		var preload_default = jQuery('#wpbeautifyvideo-preload-default').val();
		if ( preload_default == 'on' )
			preload_checked = ' checked';
		else
			preload_checked = '';

		var logo_default = jQuery('#wpbeautifyvideo-logo-default').val();
		if ( logo_default == 'on' )
			logo_checked = ' checked';
		else
			logo_checked = '';

		
		var form = jQuery('<div id="wpbeautifyJSpopup">\
		<table id="wpbeautifyvideotable" class="form-table">\
			<tr>\
				<th><label for="wpbeautifyvideo-src">Source</label></th>\
				<td><input type="text" name="wpbeautifyvideo-src" id="wpbeautifyvideo-src" class="wpbeautify-input-field"><br>\
				<small>The location of the  source for the video. Can also be a Youtube url like: <em>https://www.youtube.com/watch?v=ouQbb9MbOx0</em></small></td>\
			</tr>\
			<tr>\
				<th><label for="wpbeautifyvideo-skin">Skin</label></th>\
				<td><select name="wpbeautifyvideo-skin" id="wpbeautifyvideo-skin" style="width:200px">\
				<option value="">Default</option>\
				<option value="skin1">Minimalist 1</option>\
				<option value="skin2">Minimalist 2</option>\
				<option value="skin3">Full Skin 1</option>\
				<option value="skin4">Full Skin 2</option>\
				<option value="skin5">Full Skin 3</option>\
				<option value="skin6">Full Skin 4</option>\
				<option value="skin7">Full Skin 5</option>\
				<option value="skin8">Full Skin 6</option>\
				<option value="skin9">Full Skin 7</option>\
				<option value="skin9">Full Skin 8</option>\
				</select>\
				<br>\
				<small>The skin for the Video Player.</small></td>\
			</tr>\
			<tr>\
				<th><label for="wpbeautifyvideo-hidelogo">Hide logo</label></th>\
				<td><input id="wpbeautifyvideo-hidelogo" name="wpbeautifyvideo-hidelogo" type="checkbox"'+logo_checked+' /><br/>\
				<small>You need to configure logo image first</small></td>\
				</td>\
			</tr>\
			<tr>\
				<th><label for="wpbeautifyvideo-poster">Poster Image</label></th>\
				<td><input type="text" name="wpbeautifyvideo-poster" id="wpbeautifyvideo-poster" class="wpbeautify-input-field"><br>\
				<small>The location of the poster frame for the video.</small></td>\
			</tr>\
			<tr>\
				<th><label for="wpbeautifyvideo-width">Width</label></th>\
				<td><input type="text" name="wpbeautifyvideo-width" id="wpbeautifyvideo-width" ><br>\
				<small>The width of the video (in px)</small></td>\
			</tr>\
			<tr>\
				<th><label for="wpbeautifyvideo-height">Height</label></th>\
				<td><input type="text" name="wpbeautifyvideo-height" id="wpbeautifyvideo-height"><br>\
				<small>The height of the video (in px)</small></td>\
			</tr>\
			<tr>\
				<th><label for="wpbeautifyvideo-autoplay">Autoplay</label></th>\
				<td><input id="wpbeautifyvideo-autoplay" name="wpbeautifyvideo-autoplay" type="checkbox"'+autoplay_checked+' /></td>\
			</tr>\
		</table>\
		<p class="submit">\
				<input type="button" id="wpbeautifyvideo-submit" class="button-primary" value="Insert Video" name="submit" />\
		</p>\
		</div>');
		var table = form.find('table');
		form.appendTo('body').hide();

		
		form.find('#wpbeautifyvideo-submit').click(function(){
			
			var shortcode = '[fotopress-video';
			
			//text options
			var options = { 
				'src'      : '',
				'skin'      : '',
				'poster'   : '',
				'width'    : '',
				'height'   : ''
			};
			
			for(var index in options) {
				var value = table.find('#wpbeautifyvideo-' + index).val();
				
				// attaches the attribute to the shortcode only if it's different from the default value
				if ( value !== options[index] )
					shortcode += ' ' + index + '="' + value + '"';
			}
			
			//checkbox options
			options = { 
				'autoplay' : autoplay_default,
				'preload'  : preload_default,
				'hidelogo'     : ''
			};
			
			for(var index in options) {
				var value = table.find('#wpbeautifyvideo-' + index).is(':checked');
				
				if ( value == true )
					checked = 'on';
				else
					checked = '';
				
				// attaches the attribute to the shortcode only if it's different from the default value
				if ( checked !== options[index] )
					shortcode += ' ' + index + '="' + value + '"';
			}
			
			//close the shortcode
			shortcode += ']';
			
// 			shortcode = '<fotopress-video width="640" height="360" id="player1" preload="none">\
//     <source type="video/youtube" src="http://www.youtube.com/watch?v=nOEw9iiopwI" />\
// </video>';
			// inserts the shortcode into the active editor
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
			// closes Thickbox
			tb_remove();
		});
	});
})();
