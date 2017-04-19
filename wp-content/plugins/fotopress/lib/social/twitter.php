<?php

function wpbeautify_share_img_twitter($text, /*$link,*/ $image_url) {
	require_once WPBEAUTIFY_DIR.'/lib/social/twitter_api/TwitterAPIExchange.php';
	$image_settings = wpbeautify_get_image_settings();
	
	$settings = array(
	    'consumer_key' => $image_settings['social_sites']['twitter']['api_key'],
	    'consumer_secret' => $image_settings['social_sites']['twitter']['api_secret'],
	    'oauth_access_token' => $image_settings['social_sites']['twitter']['token'],
	    'oauth_access_token_secret' => $image_settings['social_sites']['twitter']['token_secret']
	);

	$postfields = array(
	    'media[]' => file_get_contents($image_url)/*"@{$image_url}"*/, 
	    'status' => $text
	);
	$url = 'https://api.twitter.com/1.1/statuses/update_with_media.json';
	// $url = 'https://api.twitter.com/1.1/statuses/update.json';
	$requestMethod = 'POST';

	$twitter = new TwitterAPIExchange($settings);
	$code = $twitter->buildOauth($url, $requestMethod)
	             ->setPostfields($postfields)
	             ->performRequest();

	return;
}
?>