<?php
define( 'WPBEAUTIFY_FONTS_PER_PAGE', 30 );
define( 'WPBEAUTIFY_GOOGLE_FONTS_URL', '//fonts.googleapis.com');

/* WP Option structure */

/********************
wp_beautify_font_options = array()

	current_fonts = array()
	elements_fonts = array()
		h1 = array('font', 'size', effect')
		h2 = array('font', 'size', 'effect')
		h3 = array('font', 'size', 'effect')
		h4 = array('font', 'size', 'effect')
		p = array('font', 'size', 'effect')
		li = array('font', 'size', 'effect')
		widget_title = array('font', 'size', 'effect')
		widget_content = array('font', 'size', 'effect')
		// futuro: clase x
	current_effects = array()
********************/
function wpbeautify_get_default_font_settings() {
	$options = array(
		'current_fonts' => array(),
		'current_fonts_exploded' => array(),
		'elements_fonts' => array(
			'h1' => array('enabled' => 0, 'font' => 0, 'size' => 0, 'effect' => 0),
			'h2' => array('enabled' => 0, 'font' => 0, 'size' => 0, 'effect' => 0),
			'h3' => array('enabled' => 0, 'font' => 0, 'size' => 0, 'effect' => 0),
			'h4' => array('enabled' => 0, 'font' => 0, 'size' => 0, 'effect' => 0),
			'p' => array('enabled' => 0, 'font' => 0, 'size' => 0, 'effect' => 0),
			'li' => array('enabled' => 0, 'font' => 0, 'size' => 0, 'effect' => 0),
			'widget_title' => array('enabled' => 0, 'font' => 0, 'size' => 0, 'effect' => 0),
			'widget_content' => array('enabled' => 0, 'font' => 0, 'size' => 0, 'effect' => 0)
			),
		'current_effects' => array()
		);
	return $options;
}

function wpbeautify_get_font_settings() {
	return get_site_option('wp_beautify_font_options', wpbeautify_get_default_font_settings());
}

function wpbeautify_set_font_settings($options) {
	return update_site_option('wp_beautify_font_options', $options, true);
}

function wpbeautify_get_current_fonts_array() {
	$font_settings = wpbeautify_get_font_settings();
	// var_dump ($font_settings['current_fonts']);
	return $font_settings['current_fonts'];
}

function wpbeautify_get_fonts_combinations() {
	$combinations = array(
		array('header' => array('Fjalla+One', 'Fjalla One'), 'body' => array('Average+Sans', 'Average Sans')),
		array('header' => array('Stint+Ultra+Expanded', 'Stint Ultra Expanded'), 'body' => array('Pontano+Sans', 'Pontano Sans')),
		array('header' => array('Clicker+Script', 'Clicker Script'), 'body' => array('EB+Garamond', 'EB Garamond')),
		array('header' => array('Oxygen', 'Oxygen'), 'body' => array('Source+Sans+Pro', 'Source Sans Pro')),
		array('header' => array('Dancing+Script', 'Dancing Script'), 'body' => array('Ledger', 'Ledger')),
		array('header' => array('Shadows+Into+Light+Two', 'Shadows Into Light Two'), 'body' => array('Roboto', 'Roboto')),
		array('header' => array('Bitter', 'Bitter'), 'body' => array('Raleway', 'Raleway')),
		array('header' => array('Lobster', 'Lobster'), 'body' => array('Cabin', 'Cabin')),
		array('header' => array('Allerta', 'Allerta'), 'body' => array('Crimson Text', 'Crimson Text')),
		array('header' => array('Dancing+Script', 'Dancing Script'), 'body' => array('Josefin+Sans', 'Josefin Sans')),
		array('header' => array('Allan', 'Allan'), 'body' => array('Cardo', 'Cardo')),
		array('header' => array('Ubuntu', 'Ubuntu'), 'body' => array('Vollkorn', 'Vollkorn')),
		array('header' => array('Libre+Baskerville', 'Libre Baskerville'), 'body' => array('Ubuntu', 'Ubuntu')),
		array('header' => array('Lato', 'Lato'), 'body' => array('Grand', 'Grand')),
		array('header' => array('Coustard:900', 'Coustard'), 'body' => array('Leckerli+One', 'Leckerli One')),
		array('header' => array('Raleway', 'Raleway'), 'body' => array('Merriweather', 'Merriweather')),
		array('header' => array('Amatic+SC', 'Amatic SC'), 'body' => array('Andika', 'Andika'))

	);

	return $combinations;
}

function wpbeautify_print_font_combinations() {
	?>
		<div class="row" >
	<?php
	$combinations = wpbeautify_get_fonts_combinations();
	foreach ($combinations as $combination) {
	?>
	<div class="col-6 col-sm-6 col-lg-4">
		<div class="well" data-header-font="<?php echo $combination['header'][1];?>" data-body-font="<?php echo $combination['body'][1];?>">
		<span><?php echo $combination['header'][1];?> + <?php echo $combination['body'][1];?></span>
			<h2 style="font-family:<?php echo $combination['header'][1];?>">Header title</h2>
			<p style="font-size:14px; font-family:<?php echo $combination['body'][1];?>;height:125px;oveflow:hidden">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut, nulla, ducimus, ipsum eum quaerat dignissimos molestias perspiciatis odio laboriosam repudiandae corrupti numquam dolore? Voluptate praesentium quae neque dolore impedit harum.</p>
			<div>
				<a target="_blank" href="<?php echo add_query_arg(array ('h1_p' => $combination['header'][0], 'h2_p' => $combination['header'][0], 'p_p' => $combination['body'][0]) ,site_url());?>" class="btn btn-sm btn-info"><i class="fa fa-eye"></i> Preview</a>
				<button class="btn btn-sm btn-info btn-enable-font-combination" ><i class="fa fa-check-square-o"></i> Enable</button>
				<button class="btn btn-sm btn-info btn-set-font-combination"><i class="fa fa-star"></i> Set as default</button>
			</div>
		</div>
	</div>

	<?php
	}
	?>
		</div>
	<?php
}

function wpbeautify_load_font_combinations_css() {
	$combinations = wpbeautify_get_fonts_combinations();
	$fonts = array();
	foreach ($combinations as $combination) {
		if(!in_array($combination['header'][0], $fonts))
	        $fonts[] = $combination['header'][0];

    	if(!in_array($combination['body'][0], $fonts))
            $fonts[] = $combination['body'][0];
	}
 	$fonts_exploded = str_replace(' ', '+',implode($fonts, '|'));

 	echo "<link href='".WPBEAUTIFY_GOOGLE_FONTS_URL."/css?family=".$fonts_exploded."' rel='stylesheet' type='text/css'>";

}

function wpbeautify_get_all_fonts($page=0, $total_per_page=0, $searched_str=0, $font_filter=0) {
	$static_font_file = WPBEAUTIFY_DIR.'/assets/webfonts.php';
	include_once($static_font_file);
	global $wpbeautify_google_fonts;
	$data = json_decode($wpbeautify_google_fonts,true);
	$items = $data['items'];
	 // var_dump($items);
	 if ($searched_str)
	 	$items = wpbeautify_filter_fonts($items, $searched_str);

	 else if ($font_filter)
	 	$items = wpbeautify_filter_fonts_active($items, $font_filter);

	$pos = $page*$total_per_page;
	return array('total' => count($items), 'fonts' => array_slice($items, $pos, $total_per_page));


	$i = 0;
	foreach ($items as $item) {
	    $i++;
	    $str = 'Font '.$i.' '.$item['family'].' Subsets:';
	    foreach ($item['variants'] as $variant) {
	      $str .= ' '.$variant.' ';
	    }
	    $str.= ' Variants';
	    foreach ($item['subsets'] as $subset) {
	      $str .= ' '.$subset;
	    }
	    echo $str.'<br />';
	}
}

function wpbeautify_filter_fonts($items, $searched_str) {
	$new_items = array();
	foreach ($items as $item) {
		if (strpos(strtolower($item['family']),strtolower($searched_str)) !== false)
			$new_items[] = $item;
	}
	return $new_items;
}

function wpbeautify_filter_fonts_active($items, $font_filter) {
	$fonts_settings = wpbeautify_get_font_settings();
	$current_fonts = $fonts_settings['current_fonts'];

	$new_items = array();
	foreach ($items as $item) {
		if ($font_filter == 1) {
			if (in_array($item['family'],$current_fonts))
				$new_items[] = $item;
		}
		else if ($font_filter == 2) {
			if (!in_array($item['family'],$current_fonts))
				$new_items[] = $item;
		}
	}
	return $new_items;
}

function wpbeautify_print_font_sample() {
	$str_ret = '';
	$alphabet=range("A","Z");
	foreach($alphabet as $char)
		$str_ret .= $char;
	$str_ret .= '<br/>';
	$alphabet=range('a', 'z');
	foreach($alphabet as $char)
		$str_ret .= $char;
	$str_ret .= '<br/>';
	$alphabet=range('0', '9');
	foreach($alphabet as $char)
		$str_ret .= $char;
	$str_ret .= '<br/>';
	$str_ret .= 'The quick brown fox jumps over a lazy dog';
	$str_ret .= '<br/>';
	$str_ret .= 'This is <b>bold text</b> and this is <i>Italic</i>';

	echo $str_ret;
}

/* Effects */

/* chrome, ff, opera, safari */
function wpbeautify_get_all_font_effects() {
	$font_effects_google = array(
		array('name' => 'Anaglyph', 'class' => 'anaglyph', 'support' => array(1, 1, 1, 1)),
		array('name' => 'Brick Sign', 'class' =>'brick-sign', 'support' => array(1, 0, 0, 1)),
		array('name' => 'Canvas Print', 'class' =>'canvas-print', 'support' => array(1, 0, 0, 1)),
		array('name' => 'Crackle', 'class' =>'crackle', 'support' => array(1, 0, 0, 1)),
		array('name' => 'Decaying', 'class' =>'decaying', 'support' => array(1, 0, 0, 1)),
		array('name' => 'Destruction', 'class' =>'destruction', 'support' => array(1, 0, 0, 1)),
		array('name' => 'Distressed', 'class' =>'distressed', 'support' => array(1, 0, 0, 1)),
		array('name' => 'Distressed Wood', 'class' =>'distressed-wood', 'support' => array(1, 0, 0, 1)),
		array('name' => 'Emboss', 'class' =>'emboss', 'support' => array(1, 1, 1, 1)),

		array('name' => 'Fire', 'class' =>'fire', 'support' => array(1, 1, 1, 1)),
		array('name' => 'Fire Animation', 'class' =>'fire-animation', 'support' => array(1, 1, 1, 1)),
		array('name' => 'Fragile', 'class' =>'fragile', 'support' => array(1, 0, 0, 1)),
		array('name' => 'Grass', 'class' =>'grass', 'support' => array(1, 0, 0, 1)),
		array('name' => 'Ice', 'class' =>'ice', 'support' => array(1, 0, 0, 1)),
		array('name' => 'Mitosis', 'class' =>'mitosis', 'support' => array(1, 0, 0, 1)),
		array('name' => 'Neon', 'class' =>'neon', 'support' => array(1, 1, 1, 1)),
		array('name' => 'Outline', 'class' =>'outline', 'support' => array(1, 1, 1, 1)),
		array('name' => 'Putting Green', 'class' =>'putting-green', 'support' => array(1, 0, 0, 1)),
		array('name' => 'Scuffed Steel', 'class' =>'scuffed-steel', 'support' => array(1, 0, 0, 1)),
		array('name' => 'Shadow Multiple', 'class' =>'shadow-multiple', 'support' => array(1, 1, 1, 1)),
		array('name' => 'Splintered', 'class' =>'splintered', 'support' => array(1, 0, 0, 1)),
		array('name' => 'Static', 'class' =>'static', 'support' => array(1, 0, 0, 1)),
		array('name' => 'Stonewash', 'class' =>'stonewash', 'support' => array(1, 0, 0, 1)),
		array('name' => 'Three Dimensional', 'class' =>'3d', 'support' => array(1, 1, 1, 1)),
		array('name' => 'Three Dimensional Float', 'class' =>'3d-float', 'support' => array(1, 1, 1, 1)),
		array('name' => 'Vintage', 'class' =>'vintage', 'support' => array(1, 0, 0, 1)),
		array('name' => 'Wallpaper', 'class' =>'wallpaper', 'support' => array(1, 0, 0, 1))

	);

	$font_effects_personal = array(
		array('name' => 'Inset', 'class' => 'inset', 'support' => array(1, 1, 1, 1)),
		array('name' => 'Neon Lights', 'class' => 'neon-lights', 'support' => array(1, 1, 1, 1)),
		array('name' => 'Letterpress', 'class' => 'letterpress', 'support' => array(1, 1, 1, 1)),
		array('name' => 'Shadow Hover', 'class' => 'shadow-hover', 'support' => array(1, 1, 1, 1)),
		array('name' => 'Scaling Hover', 'class' => 'scaling-hover', 'support' => array(1, 1, 1, 1)),
		array('name' => 'Single Stroke', 'class' => 'single-stroke', 'support' => array(1, 1, 1, 1)),
		array('name' => 'Cloudy', 'class' => 'cloudy', 'support' => array(1, 1, 1, 1)),
		array('name' => 'Vintage Retro', 'class' => 'vintage-retro', 'support' => array(1, 1, 1, 1)),

		array('name' => 'Stereoscopic 3D','class' => 'stereoscopic-3d', 'support' => array(1, 1, 1, 1)),
		array('name' => 'Text Highlighter Green','class' => 'text-highlighter-green', 'support' => array(1, 1, 1, 1)),
		array('name' => 'Text Highlighter Yellow','class' => 'text-highlighter-yellow', 'support' => array(1, 1, 1, 1)),
		array('name' => 'Text Highlighter Red','class' => 'text-highlighter-red', 'support' => array(1, 1, 1, 1)),
		array('name' => 'Strikethrough Text With Color','class' => 'strikethrough-text-color', 'support' => array(1, 1, 1, 1)),
/*		array('name' => 'Grow','class' => 'grow', 'support' => array(1, 1, 1, 1)),
		array('name' => 'Shrink','class' => 'shrink', 'support' => array(1, 1, 1, 1)),
		array('name' => 'Pop','class' => 'pop', 'support' => array(1, 1, 1, 1)),
		array('name' => 'Float','class' => 'float', 'support' => array(1, 1, 1, 1)),
		array('name' => 'Sink','class' => 'sink', 'support' => array(1, 1, 1, 1)),
		array('name' => 'Skew','class' => 'skew', 'support' => array(1, 1, 1, 1)),
		array('name' => 'Border Fade','class' => 'border-fade', 'support' => array(1, 1, 1, 1)),
		array('name' => 'Glow Hover','class' => 'glow-hover', 'support' => array(1, 1, 1, 1)),	*/

		array('name' => 'Text Outline' ,'class' =>  'text-outline' , 'support' => array(1, 1, 1, 1)),
		array('name' => '3D Text' ,'class' =>  '3d-text' , 'support' => array(1, 1, 1, 1)),
		array('name' => 'Text Shadow' ,'class' =>  'text-shadow' , 'support' => array(1, 1, 1, 1)),
		array('name' => 'Blurry Text' ,'class' =>  'blurry-text' , 'support' => array(1, 1, 1, 1)),
		array('name' => 'Milky Text' ,'class' =>  'milky-text' , 'support' => array(1, 1, 1, 1)),
		array('name' => 'Mystery Text' ,'class' =>  'mystery-text' , 'support' => array(1, 1, 1, 1)),
		array('name' => 'Engrave Text' ,'class' =>  'engrave-text' , 'support' => array(1, 1, 1, 1)),
		array('name' => 'Small Caps' ,'class' =>  'small-caps' , 'support' => array(1, 1, 1, 1)),
		array('name' => 'Text Glow' ,'class' =>  'text-glow' , 'support' => array(1, 1, 1, 1)),
		array('name' => 'Text Highlight with Border' ,'class' =>  'text-highlight-border' , 'support' => array(1, 1, 1, 1)),
		array('name' => 'Box Shadow' ,'class' =>  'box-shadow' , 'support' => array(1, 1, 1, 1)),
		array('name' => 'Hover Box' ,'class' =>  'hover-box' , 'support' => array(1, 1, 1, 1)),
		array('name' => '3D Buttons' ,'class' =>  '3d-buttons' , 'support' => array(1, 1, 1, 1)),
		array('name' => 'Callout Box' ,'class' =>  'callout-box' , 'support' => array(1, 1, 1, 1)),
		array('name' => 'Single Border' ,'class' =>  'single-border' , 'support' => array(1, 1, 1, 1)),
		array('name' => '75% Opacity' ,'class' =>  '75-opacity' , 'support' => array(1, 1, 1, 1)),
		array('name' => '50% Opacity' ,'class' =>  '50-opacity' , 'support' => array(1, 1, 1, 1)),
		array('name' => '25% Opacity' ,'class' =>  '25-opacity' , 'support' => array(1, 1, 1, 1)),


	);


	return array('google' => $font_effects_google, 'personal' => $font_effects_personal);
}

function wpbeautify_browser_support_icons($browsers) {
	$str_ret = '';
	if ($browsers[0])
		$str_ret .= '<img title="Google Chrome" alt="Google Chrome" src="'.WPBEAUTIFY_URL.'/img/browsers/chrome.png" /> ';

	if ($browsers[1])
		$str_ret .= '<img title="Mozilla Firefox" alt="Mozilla Firefox" src="'.WPBEAUTIFY_URL.'/img/browsers/firefox.png" /> ';

	if ($browsers[2])
		$str_ret .= '<img title="Opera" alt="Opera" src="'.WPBEAUTIFY_URL.'/img/browsers/opera.png" /> ';

	if ($browsers[3])
		$str_ret .= '<img style="width:34px" title="Safari" alt="Safari" src="'.WPBEAUTIFY_URL.'/img/browsers/safari.png" /> ';

	return $str_ret;
}

function wpbeautify_editor_fontsize_filter( $options ) {
	// var_dump($options);
	// if (WPBEAUTIFY_WPVERSION < 3.9) {
		// array_shift( $options );
		if (!in_array('formatselect', $options))
			array_unshift( $options, 'formatselect');

		// var_dump($options);
		if (!in_array('fontsizeselect', $options))
			array_unshift( $options, 'fontsizeselect');

		// if (!in_array('fontselect', $options))
		if (!in_array('fontselect', $options))
			array_unshift( $options, 'fontselect');

	// }

	return $options;
}
add_filter('mce_buttons_2', 'wpbeautify_editor_fontsize_filter', 20);

add_filter('tiny_mce_before_init', 'wpbeautify_editor_font_choices' );

function wpbeautify_editor_font_choices( $init ) {
	$fonts_settings = wpbeautify_get_font_settings();
	$current_fonts = $fonts_settings['current_fonts'];

	if (WPBEAUTIFY_WPVERSION < 3.9)
		$findex = 'theme_advanced_fonts';
	else
		$findex = 'font_formats';
// var_dump($init);
    $init[$findex] =
                'Andale Mono=andale mono,times;'.
                'Arial=arial,helvetica,sans-serif;'.
                'Arial Black=arial black,avant garde;'.
                'Book Antiqua=book antiqua,palatino;'.
                'Comic Sans MS=comic sans ms,sans-serif;'.
                'Courier New=courier new,courier;'.
                'Georgia=georgia,palatino;'.
                'Helvetica=helvetica;'.
                'Impact=impact,chicago;'.
                'Tahoma=tahoma,arial,helvetica,sans-serif;'.
                'Terminal=terminal,monaco;'.
                'Times New Roman=times new roman,times;'.
                'Trebuchet MS=trebuchet ms,geneva;'.
                'Verdana=verdana,geneva'.
                '';

    if ($current_fonts) {
	    $i=0;$len = count($current_fonts);
	    foreach ($current_fonts as $extra_font) {
	    	if ($i++ < ($len))
				$init[$findex] .= ';';

	    	$init[$findex] .= $extra_font.'='.$extra_font;
	    }
	}

	if (WPBEAUTIFY_WPVERSION < 3.9)
		$init['theme_advanced_font_sizes'] = "10px,11px,12px,13px,14px,15px,16px,17px,18px,19px,20px,21px,22px,23px,24px,25px,26px,27px,28px,29px,30px,32px,48px,54px,60px,72px";
	else
		$init['fontsize_formats'] = "10px 11px 12px 13px 14px 15px 16px 17px 18px 19px 20px 21px 22px 23px 24px 25px 26px 27px 28px 29px 30px 32px 48px 54px 60px 72px";

    return $init;
}

/*
function mytheme_tinymce_settings($settings)
{
    //First  we define the styles we want to add in format 'Style Name' => 'css classes'
    $classes = array(
        __('Test style 1','mytheme')     => 'teststyle',
        __('Test style 2','mytheme')     => 'teststyle',
        __('Test style 3','mytheme')     => 'teststyle',
    );

    //Delimit styles by semicolon in format 'Title=classes;' so TinyMCE can use it
    if ( ! empty($settings['theme_advanced_styles']) )
    {
        $settings['theme_advanced_styles'] .= ';';
    }
    else
    {
        //If there's nothing defined yet, define it
        $settings['theme_advanced_styles'] = '';
    }

    //Loop through our newly defined classes and add them to TinyMCE
    $class_settings = '';
    foreach ( $classes as $name => $value )
    {
        $class_settings .= "{$name}={$value};";
    }

    //Add our new class settings to the TinyMCE $settings array
    $settings['theme_advanced_styles'] .= trim($class_settings, '; ');

    return $settings;
}
add_filter('tiny_mce_before_init','mytheme_tinymce_settings');
*/

function wpbeautify_effectdropdown_colors() {
   echo '<style type="text/css">
           #menu_content_content_styleselect_menu_tbl tr td a span.mceText {color: #000000!important;}
           #menu_content_content_fontsizeselect_menu_tbl tr td a span.mceText {line-height:normal/*font-size: 12px!important;*/}
         </style>';
}

add_action('admin_head', 'wpbeautify_effectdropdown_colors');


// Ajax functions

add_action( 'wp_ajax_wpbeautify_add_font', 'wpbeautify_add_available_font' );
add_action( 'wp_ajax_wpbeautify_add_effect', 'wpbeautify_add_available_effect' );

function wpbeautify_add_available_font() {
	$action = intval( $_POST['activate'] );
	$font =  $_POST['font'] ;

	$fonts_settings = wpbeautify_get_font_settings();
	$current_fonts = $fonts_settings['current_fonts'];

	if ($action) {
		//add font
		if (!in_array($font, $current_fonts))
			$current_fonts[] = $font;
	}
	else {
		$current_fonts = wpbeautify_array_removal($font, $current_fonts);
	}
 	$fonts_settings['current_fonts'] = $current_fonts;
 	$fonts_settings['current_fonts_exploded'] = str_replace(' ', '+',implode($current_fonts, '|'));
 	wpbeautify_set_font_settings($fonts_settings);
	die(); // this is required to return a proper result
}


function wpbeautify_add_available_effect() {
	$action = intval( $_POST['activate'] );
	$effect =  $_POST['effect'] ;

	$fonts_settings = wpbeautify_get_font_settings();
	$current_effects = $fonts_settings['current_effects'];

	if ($action) {
		//add effect
		if (!in_array($effect, $current_effects))
			$current_effects[] = $effect;
	}
	else {
		$current_effects = wpbeautify_array_removal($effect, $current_effects);
	}
 	$fonts_settings['current_effects'] = $current_effects;
 	$fonts_settings['current_effects_exploded'] = str_replace(' ', '+',implode($current_effects, '|'));
 	wpbeautify_set_font_settings($fonts_settings);
	die(); // this is required to return a proper result
}


if (!is_admin()) {
	// frontend
    add_action('wp_print_styles', 'wpbeautify_load_fonts');
    add_action('wp_footer', 'wpbeautify_load_fonts_frontend');
}
else
    add_action('admin_print_styles', 'wpbeautify_load_fonts');


function wpbeautify_load_fonts() {
	if( ckala_is_pro() ) {
		$fonts_settings = wpbeautify_get_font_settings();
		$current_fonts_exploded = isset($fonts_settings['current_fonts_exploded']) ? $fonts_settings['current_fonts_exploded'] : '';
		if (!empty($current_fonts_exploded)) {
			$current_effects_exploded = isset($fonts_settings['current_effects_exploded']) ? $fonts_settings['current_effects_exploded'] : '';
			if (!empty($current_effects_exploded))
		    	wp_register_style('wpbeautify_google_fonts', WPBEAUTIFY_GOOGLE_FONTS_URL.'/css?family='.$current_fonts_exploded.'&effect='.$current_effects_exploded);
		    else
		    	wp_register_style('wpbeautify_google_fonts', WPBEAUTIFY_GOOGLE_FONTS_URL.'/css?family='.$current_fonts_exploded);
		    wp_enqueue_style( 'wpbeautify_google_fonts');
		}
	} else {

		$google_enabled_fonts = array(
		  'Alex+Brush',
		  'Abril+Fatface',
		  'Amaranth',
		  'Bevan',
		  'Covered+By+Your+Grace',
		  'Fjord',
		  'Gravitas+One',
		  'Indie+Flower',
		  'Josefin+Sans',
		  'Jura',
		  'League+Gothic',
		  'Lobster',
		  'Merriweather',
		  'Montserrat',
		  'Playfair+Display',
		  'Signika',
		  'Shadows+Into+Light',
		  'Pacifico'
		  );
		$current_fonts_exploded = implode( '|', $google_enabled_fonts );
		wp_register_style('wpbeautify_google_fonts', WPBEAUTIFY_GOOGLE_FONTS_URL.'/css?family='.$current_fonts_exploded);
		wp_enqueue_style( 'wpbeautify_google_fonts');
	}
?>
	<style type="text/css">
<?php
		wpbeautify_custom_text_effects_css();
?>
	</style>
<?php
}

function wpbeautify_load_fonts_frontend() {
	?>
		<?php wpbeautify_print_styles_css();?>
	<script type='text/javascript'>
	jQuery(document).ready(function($) {
	<?php
		$str_ret = '';
		$fonts_settings = wpbeautify_get_font_settings();
		$elements_fonts = $fonts_settings['elements_fonts'];
// var_dump($elements_fonts);
		$html_elements = array('h1', 'h2', 'h3', 'h4', 'p', 'li', 'widget_title', 'widget_content');

		foreach ($html_elements as $element) {
// var_dump($element);
			if ($elements_fonts[$element]['enabled'] && isset($elements_fonts[$element]['effect']) && $elements_fonts[$element]['effect'] && wpbeautify_is_loaded_effect($elements_fonts[$element]['effect']))
				$str_ret .= 'jQuery("'.$element.'").addClass("font-effect-'.$elements_fonts[$element]['effect'].'")';
		}
/*
		if (isset($elements_fonts['h2']['font']) && $elements_fonts['h2']['font'])
			$str_ret .= 'h2 { font-family:'.$elements_fonts['h2']['font'].' !important;}';

		if (isset($elements_fonts['h3']['font']) && $elements_fonts['h3']['font'])
			$str_ret .= 'h3 { font-family:'.$elements_fonts['h3']['font'].' !important;}';

		if (isset($elements_fonts['h4']['font']) && $elements_fonts['h4']['font'])
			$str_ret .= 'h4 { font-family:'.$elements_fonts['h4']['font'].' !important;}';

		if (isset($elements_fonts['p']['font']) && $elements_fonts['p']['font'])
			$str_ret .= 'p { font-family:'.$elements_fonts['p']['font'].' !important;}';

		if (isset($elements_fonts['li']['font']) && $elements_fonts['li']['font'])
			$str_ret .= 'li { font-family:'.$elements_fonts['li']['font'].' !important;}';

		if (isset($elements_fonts['widget_content']['font']) && $elements_fonts['widget_content']['font'])
			$str_ret .= '.widget { font-family:'.$elements_fonts['widget_content']['font'].' !important;}';

		if (isset($elements_fonts['widget_title']['font']) && $elements_fonts['widget_title']['font'])
			$str_ret .= '.widget-title { font-family:'.$elements_fonts['widget_title']['font'].' !important;}';*/

		echo $str_ret;
	?>
	});
	</script>
	<?php
}

function wpbeautify_custom_text_effects_css() {
?>

<?php
}

function wpbeautify_print_styles_css() {
	$fonts_settings = wpbeautify_get_font_settings();
	$elements_fonts = $fonts_settings['elements_fonts'];

?>
	<style type="text/css">

	<?php
	$str_ret = '';
	if ($elements_fonts['h1']['enabled'] && isset($elements_fonts['h1']['font']) && $elements_fonts['h1']['font'] && wpbeautify_is_loaded_font($elements_fonts['h1']['font'])) {
		$str_ret .= 'h1 { font-family:'.$elements_fonts['h1']['font'].' !important;}';
		if (isset($elements_fonts['h1']['size']) && $elements_fonts['h1']['size'] )
			$str_ret .= 'h1 { font-size:'.$elements_fonts['h1']['size'].'px !important;}';
	}

	if ($elements_fonts['h2']['enabled'] && isset($elements_fonts['h2']['font']) && $elements_fonts['h2']['font'] && wpbeautify_is_loaded_font($elements_fonts['h2']['font'])) {
		$str_ret .= 'h2 { font-family:'.$elements_fonts['h2']['font'].' !important;}';
		if (isset($elements_fonts['h2']['size']) && $elements_fonts['h2']['size'] )
			$str_ret .= 'h2 { font-size:'.$elements_fonts['h2']['size'].'px !important;}';
	}

	if ($elements_fonts['h3']['enabled'] && isset($elements_fonts['h3']['font']) && $elements_fonts['h3']['font'] && wpbeautify_is_loaded_font($elements_fonts['h3']['font'])) {
		$str_ret .= 'h3 { font-family:'.$elements_fonts['h3']['font'].' !important;}';
		if (isset($elements_fonts['h3']['size']) && $elements_fonts['h3']['size'] )
			$str_ret .= 'h3 { font-size:'.$elements_fonts['h3']['size'].'px !important;}';
	}

	if ($elements_fonts['h4']['enabled'] && isset($elements_fonts['h4']['font']) && $elements_fonts['h4']['font'] && wpbeautify_is_loaded_font($elements_fonts['h4']['font'])) {
		$str_ret .= 'h4 { font-family:'.$elements_fonts['h4']['font'].' !important;}';
		if (isset($elements_fonts['h4']['size']) && $elements_fonts['h4']['size'] )
			$str_ret .= 'h4 { font-size:'.$elements_fonts['h4']['size'].'px !important;}';
	}

	if ($elements_fonts['p']['enabled'] && isset($elements_fonts['p']['font']) && $elements_fonts['p']['font'] && wpbeautify_is_loaded_font($elements_fonts['p']['font'])) {
		$str_ret .= 'p { font-family:'.$elements_fonts['p']['font'].' !important;}';
		if (isset($elements_fonts['p']['size']) && $elements_fonts['p']['size'] )
			$str_ret .= 'p { font-size:'.$elements_fonts['p']['size'].'px !important;}';
	}

	if ($elements_fonts['li']['enabled'] && isset($elements_fonts['li']['font']) && $elements_fonts['li']['font'] && wpbeautify_is_loaded_font($elements_fonts['li']['font'])) {
		$str_ret .= 'li { font-family:'.$elements_fonts['li']['font'].' !important;}';
		if (isset($elements_fonts['li']['size']) && $elements_fonts['li']['size'] )
			$str_ret .= 'li { font-size:'.$elements_fonts['li']['size'].'px !important;}';
	}

	if ($elements_fonts['widget_content']['enabled'] && isset($elements_fonts['widget_content']['font']) && $elements_fonts['widget_content']['font'] && wpbeautify_is_loaded_font($elements_fonts['widget_content']['font'])) {
		$str_ret .= '.widget { font-family:'.$elements_fonts['widget_content']['font'].' !important;}';
		if (isset($elements_fonts['widget_content']['size']) && $elements_fonts['widget_content']['size'] )
			$str_ret .= '.widget { font-size:'.$elements_fonts['widget_content']['size'].'px !important;}';
	}

	if ($elements_fonts['widget_title']['enabled'] && isset($elements_fonts['widget_title']['font']) && $elements_fonts['widget_title']['font'] && wpbeautify_is_loaded_font($elements_fonts['widget_title']['font'])) {
		$str_ret .= '.widget-title { font-family:'.$elements_fonts['widget_title']['font'].' !important;}';
		if (isset($elements_fonts['widget_title']['size']) && $elements_fonts['widget_title']['size'] )
			$str_ret .= '.widget-title { font-size:'.$elements_fonts['widget_title']['size'].'px !important;}';

	}
		echo ($str_ret);
	?>

	</style>
	<?php
	// Font Previews
	$str_ret = '';
	if (isset($_GET['h1_p'])) {
		// enqueue_font
		$str_ret .= "<link href='".WPBEAUTIFY_GOOGLE_FONTS_URL."/css?family=".$_GET['h1_p']."' rel='stylesheet' type='text/css'>";
		$str_ret .= '<style type="text/css">h1 { font-family:'.str_replace('+', ' ', $_GET['h1_p']).' !important;}</style>';
	}

	if (isset($_GET['h2_p'])) {
		// enqueue_font
		$str_ret .= "<link href='".WPBEAUTIFY_GOOGLE_FONTS_URL."/css?family=".$_GET['h2_p']."' rel='stylesheet' type='text/css'>";
		$str_ret .= '<style type="text/css">h2 { font-family:'.str_replace('+', ' ', $_GET['h2_p']).' !important;}</style>';
	}

	if (isset($_GET['h3_p'])) {
		// enqueue_font
		$str_ret .= "<link href='".WPBEAUTIFY_GOOGLE_FONTS_URL."/css?family=".$_GET['h3_p']."' rel='stylesheet' type='text/css'>";
		$str_ret .= '<style type="text/css">h3 { font-family:'.str_replace('+', ' ', $_GET['h3_p']).' !important;}</style>';
	}

	if (isset($_GET['h4_p'])) {
		// enqueue_font
		$str_ret .= "<link href='".WPBEAUTIFY_GOOGLE_FONTS_URL."/css?family=".$_GET['h4_p']."' rel='stylesheet' type='text/css'>";
		$str_ret .= '<style type="text/css">h4 { font-family:'.str_replace('+', ' ', $_GET['h4_p']).' !important;}</style>';
	}

	if (isset($_GET['p_p'])) {
		// enqueue_font
		$str_ret .= "<link href='".WPBEAUTIFY_GOOGLE_FONTS_URL."/css?family=".$_GET['p_p']."' rel='stylesheet' type='text/css'>";
		$str_ret .= '<style type="text/css">p { font-family:'.str_replace('+', ' ', $_GET['p_p']).' !important;}</style>';
	}

	if (isset($_GET['li_p'])) {
		// enqueue_font
		$str_ret .= "<link href='".WPBEAUTIFY_GOOGLE_FONTS_URL."/css?family=".$_GET['li_p']."' rel='stylesheet' type='text/css'>";
		$str_ret .= '<style type="text/css">li { font-family:'.str_replace('+', ' ', $_GET['li_p']).' !important;}</style>';
	}
		echo ($str_ret);


}

function wpbeautify_is_loaded_font($font) {
	$fonts_settings = wpbeautify_get_font_settings();
	$current_fonts = $fonts_settings['current_fonts'];
	return in_array($font, $current_fonts);
}

function wpbeautify_is_loaded_effect($effect) {
	$fonts_settings = wpbeautify_get_font_settings();
	$current_effects = $fonts_settings['current_effects'];
	return in_array($effect, $current_effects);
}

function wpbeautify_add_editor_styles() {
/*    $font_url = WPBEAUTIFY_GOOGLE_FONTS_URL.'/css?family=Lato:300,400,700';*/

	$fonts_settings = wpbeautify_get_font_settings();
	$current_fonts_exploded = isset($fonts_settings['current_fonts_exploded']) ? $fonts_settings['current_fonts_exploded'] : '';
	if (!empty($current_fonts_exploded)) {
		$current_effects_exploded = isset($fonts_settings['current_effects_exploded']) ? $fonts_settings['current_effects_exploded'] : '';
		if (!empty($current_effects_exploded))
	    	$font_url = WPBEAUTIFY_GOOGLE_FONTS_URL.'/css?family='.$current_fonts_exploded.'&effect='.$current_effects_exploded;
	    else
	    	$font_url = WPBEAUTIFY_GOOGLE_FONTS_URL.'/css?family='.$current_fonts_exploded;
	}


	if (!empty($font_url))
    	add_editor_style( str_replace( ',', '%2C', $font_url ) );
}
add_action( 'init', 'wpbeautify_add_editor_styles' );


/*
	$fonts_settings = wpbeautify_get_font_settings();
	$current_fonts_exploded = isset($fonts_settings['current_fonts_exploded']) ? $fonts_settings['current_fonts_exploded'] : '';
	if (!empty($current_fonts_exploded)) {
		$current_effects_exploded = isset($fonts_settings['current_effects_exploded']) ? $fonts_settings['current_effects_exploded'] : '';
		if (!empty($current_effects_exploded))
	    	wp_register_style('wpbeautify_google_fonts', WPBEAUTIFY_GOOGLE_FONTS_URL.'/css?family='.$current_fonts_exploded.'&effect='.$current_effects_exploded);
	    else
	    	wp_register_style('wpbeautify_google_fonts', WPBEAUTIFY_GOOGLE_FONTS_URL.'/css?family='.$current_fonts_exploded);
	    wp_enqueue_style( 'wpbeautify_google_fonts');


*/


	    /* Editor effects */

	    /**
 * Apply styles to the visual editor
 */
add_filter('mce_css', 'wpbeautify_mcekit_editor_style');
function wpbeautify_mcekit_editor_style($url) {

    if ( !empty($url) )
        $url .= ',';

    // Retrieves the plugin directory URL
    // Change the path here if using different directories
    $url .= WPBEAUTIFY_URL . '/css/effects.css';

    return $url;
}

/**
 * Add "Styles" drop-down
 */
add_filter( 'mce_buttons_2', 'wpbeautify_mce_editor_buttons', 20 );

function wpbeautify_mce_editor_buttons( $buttons ) {
    // array_unshift( $buttons, 'styleselect' );
    // var_dump($buttons);
    if (!in_array('styleselect', $buttons))
    	array_splice( $buttons, 2, 0, 'styleselect' );

    if (WPBEAUTIFY_WPVERSION < 3.9)
    	if (!in_array('forecolor', $buttons))
	    	array_splice( $buttons, 4, 0, 'forecolor' );

	if (!in_array('backcolor', $buttons))
    	array_splice( $buttons, 4, 0, 'backcolor' );
    return $buttons;
}

/**
 * Add styles/classes to the "Styles" drop-down
 */
add_filter( 'tiny_mce_before_init', 'wpbeautify_mce_before_init', 20 );

function wpbeautify_mce_before_init( $settings ) {
 	$effects = wpbeautify_get_all_font_effects();
 	$google_array = array();
 	$personal_array = array();

	$fonts_settings = wpbeautify_get_font_settings();
	$current_effects = $fonts_settings['current_effects'];
// var_dump($current_effects);
/*	if ($action) {
		//add effect
		if (!in_array($effect, $current_effects))
			$current_effects[] = $effect;
	}*/

	if ($effects['google']) {
  		foreach ($effects['google'] as $effect) {
			if (in_array($effect['class'], $current_effects)) {

			$google_array[] =         array(
            'title' => $effect['name'],
             'inline' => 'span',
            // 'wrapper' => true ,

            'classes' => 'font-effect-'.$effect['class']
            );
			}
  		}
	}

	if ($effects['personal']) {
  		foreach ($effects['personal'] as $effect) {
			$personal_array[] =  array(
            'title' => $effect['name'],
             'inline' => 'span',
            // 'selector' => 'a',
            'classes' => 'font-effect-'.$effect['class']
            );
  		}
	}

// wp_die('abcdef');
  	 // var_dump($style_formats);
  // var_dump($settings['style_formats']);
  // var_dump(json_encode($settings['style_formats']));


	if ( isset( $settings['style_formats'] ) && ( !empty( $settings['style_formats'] ) /*&& is_array(  $settings['style_formats'] )*/ ) ) {
		if ( !isset($settings['style_formats']) || !$settings['style_formats'] )
			$settings['style_formats'] = '';
		// $settings_formats = $settings['style_formats'];
			$style_formats = array_merge (
				array(array( 'title' => 'Google Effects' )),
		  		$google_array,
		  		array(array( 'title' => 'Other Effects' )),
		  		$personal_array,
		  		(array) json_decode( $settings['style_formats'])
		  	);
	}
	else {
		// $settings_formats = '';
			$style_formats = array_merge (
				array(array( 'title' => 'Google Effects' )),
		  	$google_array,
		  	array(array( 'title' => 'Other Effects' )),
		  	$personal_array
		  	);
	}

	// var_dump($settings_formats);
	// var_dump(json_encode($settings_formats));



  	 // var_dump($style_formats);
    $settings['style_formats'] = json_encode( $style_formats );

    return $settings;

}

/* Learn TinyMCE style format options at http://www.tinymce.com/wiki.php/Configuration:formats */

/*
 * Add custom stylesheet to the website front-end with hook 'wp_enqueue_scripts'
 */
// add_action('wp_enqueue_scripts', 'wpbeautify_mcekit_editor_enqueue');

/*
 * Enqueue stylesheet, if it exists.
 */
/*function wpbeautify_mcekit_editor_enqueue() {
  $StyleUrl = plugin_dir_url(__FILE__).'editor-styles.css'; // Customstyle.css is relative to the current file
  wp_enqueue_style( 'myCustomStyles', $StyleUrl );
}
*/



?>