// logo
(function($){
  MediaElementPlayer.prototype.buildlogo = function(player, controls, layers, media){
    var loop = $('<div class="mejs-button mejs-logo-button">' +
      '<img class="wpbeautify-video-logo" src="' + player.options.logo.image + '" />' +
      '</div>')
      // append it to the toolbar
      .appendTo(layers)
      // add a click toggle event
/*      .click(function(){
        window.open(player.options.logo.link, '_blank');
      });*/
  };
})(jQuery);

/* global mejs, _wpmejsSettings */
(function ($) {
	// add mime-type aliases to MediaElement plugin support
	mejs.plugins.silverlight[0].types.push('video/x-ms-wmv');
	mejs.plugins.silverlight[0].types.push('audio/x-ms-wma');
  
// mejs.plugins = mejs.plugins.slice(1);
	$(function () {
    if ((wpbeautify_video.logo_url != null) && (wpbeautify_video.logo_url != '')) {
      // console.log(wpbeautify_video.logo_url)
  		var settings = {
      		features: ['logo','playpause', 'progress', 'duration', 'volume', 'fullscreen'],
      		logo: { image: wpbeautify_video.logo_url, link: '' }
  		};
    }
    else {
      var settings = {}
    }
      // var settings = {}
    
		if ( typeof _wpmejsSettings !== 'undefined' )
			settings.pluginPath = _wpmejsSettings.pluginPath;

    var settings_horizontal = jQuery.extend(true, {}, settings);
    settings_horizontal.videoVolume = 'horizontal';
    
    $('.wp-audio-shortcode:not(".wpbtfy-volume-horizontal"), .wp-video-shortcode:not(".wpbtfy-volume-horizontal")').mediaelementplayer( settings );
		$('.wp-audio-shortcode.wpbtfy-volume-horizontal, .wp-video-shortcode.wpbtfy-volume-horizontal').mediaelementplayer( settings_horizontal );
	});

}(jQuery));