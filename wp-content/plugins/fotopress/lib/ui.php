<?php
function wpbeautify_adminmenu()
{
		if ( ckala_is_pro() )
			$page1 = add_menu_page('FotoPress Pro', 'FotoPress Pro', 'manage_options', 'fotopress', 'wpbeautify_panel', WPBEAUTIFY_URL . '/img/icons/logo.png');
		else
			$page1 = add_menu_page('FotoPress', 'FotoPress', 'manage_options', 'fotopress', 'wpbeautify_panel', WPBEAUTIFY_URL . '/img/icons/logo.png');

		$page3 = add_submenu_page('fotopress', 'Images', 'Images', 'manage_options', 'fotopress-images', 'wpbeautify_panel_images');

		if ( ckala_is_pro() ) {
			$page2 = add_submenu_page('fotopress', 'Fonts', 'Fonts', 'manage_options', 'fotopress-fonts', 'wpbeautify_panel_fonts');
			$page4 = add_submenu_page('fotopress', 'Videos', 'Videos', 'manage_options', 'fotopress-videos', 'wpbeautify_panel_video');
		}
		$page5 = add_submenu_page('fotopress', 'Help', 'Help', 'manage_options', 'fotopress-help', 'wpbeautify_panel_help');
		// $page5 = add_submenu_page('wp-beautify', 'Settings', 'Settings', 'manage_options', 'wpbeautify-settings', 'wpbeautify_panel_other_settings');
		// $page5 = add_submenu_page('wp-beautify', 'Support', 'Support', 'manage_options', 'wpbeautify-support', 'wpbeautify_panel');
		if (function_exists('remove_submenu_page'))
			remove_submenu_page('fotopress','fotopress');
		add_action( "admin_print_scripts-$page1", 'wpbeautify_admin_scripts' );
		add_action( "admin_print_styles-$page1", 'wpbeautify_admin_style' );
		add_action( "admin_print_scripts-$page3", 'wpbeautify_admin_scripts' );
		add_action( "admin_print_styles-$page3", 'wpbeautify_admin_style' );
		add_action( "admin_print_scripts-$page5", 'wpbeautify_admin_scripts' );
		add_action( "admin_print_styles-$page5", 'wpbeautify_admin_style' );

		if ( ckala_is_pro() ) {
			add_action( "admin_print_scripts-$page2", 'wpbeautify_admin_scripts' );
			add_action( "admin_print_styles-$page2", 'wpbeautify_admin_style' );
			add_action( "admin_print_scripts-$page4", 'wpbeautify_admin_scripts' );
			add_action( "admin_print_styles-$page4", 'wpbeautify_admin_style' );
			add_action( 'admin_footer-'. $page2, 'wpbeautify_admin_footer' );
		}
}

add_action('admin_menu', 'wpbeautify_adminmenu');

function wpbeautify_admin_scripts() {
	wp_register_script( 'wpbeautify_admin_js', WPBEAUTIFY_URL . '/js/wpbeautify-admin.js', array('jquery'), WPBEAUTIFY_VERSION);
	wp_enqueue_script( 'wpbeautify_admin_js');

	wp_register_script( 'wpbeautify_bootstrap_js', WPBEAUTIFY_URL . '/assets/ui/js/bootstrap.min.js', array('jquery'), WPBEAUTIFY_VERSION);
	wp_enqueue_script( 'wpbeautify_bootstrap_js');

	wp_register_script( 'wpbeautify_bootstrap_switch_js', WPBEAUTIFY_URL . '/assets/ui/js/bootstrap-switch.min.js', array('jquery'), WPBEAUTIFY_VERSION);
	wp_enqueue_script( 'wpbeautify_bootstrap_switch_js');

	wp_register_script( 'wpbeautify_bootstrap_minicolors_js', WPBEAUTIFY_URL . '/assets/ui/js/jquery.minicolors.min.js', array('jquery'), WPBEAUTIFY_VERSION);
	wp_enqueue_script( 'wpbeautify_bootstrap_minicolors_js');

	wp_register_script( 'wpbeautify_bootstrap_spinedit_js', WPBEAUTIFY_URL . '/assets/ui/js/bootstrap-spinedit.js', array('jquery'), WPBEAUTIFY_VERSION);
	wp_enqueue_script( 'wpbeautify_bootstrap_spinedit_js');

	wp_enqueue_script( 'jquery-ui-sortable' );

	wp_enqueue_media( );
}


function wpbeautify_admin_style() {
	wp_register_style('wpbeautify_admin_style', WPBEAUTIFY_URL . '/css/wpbeautify-admin.css', array(), WPBEAUTIFY_VERSION);
  	wp_enqueue_style('wpbeautify_admin_style');

	wp_register_style('wpbeautify_effects', WPBEAUTIFY_URL . '/css/effects.css', array(), WPBEAUTIFY_VERSION);
  	wp_enqueue_style('wpbeautify_effects');

	wp_register_style('wpbeautify_bootstrap_css', WPBEAUTIFY_URL . '/assets/ui/css/bootstrap-wpadmin.css', array(), WPBEAUTIFY_VERSION);
  	wp_enqueue_style('wpbeautify_bootstrap_css');

	wp_register_style('wpbeautify_bootstrap_switch_css', WPBEAUTIFY_URL . '/assets/ui/css/bootstrap-switch.min.css', array(), WPBEAUTIFY_VERSION);
  	wp_enqueue_style('wpbeautify_bootstrap_switch_css');

	// wp_register_style('wpbeautify_font_awesome_css', WPBEAUTIFY_URL . '/assets/ui/css/font-awesome.min.css', array(), WPBEAUTIFY_VERSION);
	wp_register_style('wpbeautify_font_awesome_css', '//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css', array(), WPBEAUTIFY_VERSION);
  	wp_enqueue_style('wpbeautify_font_awesome_css');
  	

	wp_register_style('wpbeautify_bootstrap_minicolors_css', WPBEAUTIFY_URL . '/assets/ui/css/jquery.minicolors.css', array(), WPBEAUTIFY_VERSION);
  	wp_enqueue_style('wpbeautify_bootstrap_minicolors_css');

	wp_register_style('wpbeautify_bootstrap_spinedit_css', WPBEAUTIFY_URL . '/assets/ui/css/bootstrap-spinedit.css', array(), WPBEAUTIFY_VERSION);
  	wp_enqueue_style('wpbeautify_bootstrap_spinedit_css');
}


function wpbeautify_admin_footer() {
?>
<!-- Modal -->
<div class="bootstrap-wpbtfy-wpadmin">
<div class="modal fade" id="wpbeautify_font_modal" tabindex="-1" role="dialog" aria-labelledby="wpbeautify_font_modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="wpbeautify_font_modalLabel">Font Preview</h4>
      </div>
      <div class="modal-body">
      <div class="pull-right">
      	<button type="button" class="btn btn-sm" id="wpbeautify_decrease_font_popup" >-</button>

      	<button type="button" class="btn btn-sm" id="wpbeautify_increase_font_popup" >+</button>
		</div>
        <div >
        	<p class="wpbeautify_font_preview_big">
				<?php
					wpbeautify_print_font_sample();
				?>
			</p>
        </div>

        <div>
        	<p class="wpbeautify_font_preview_small">
				<?php
					wpbeautify_print_font_sample();
				?>
			</p>
        </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
        <button id="popup_enable_font_btn" type="button" class="btn btn-success pull-left"  style="display:none">Enable Font</button>
        <button id="popup_disable_font_btn" type="button" class="btn btn-warning pull-left"  style="display:none">Disable Font</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div><!-- /.modal -->
<?php
}

function wpbeautify_panel() {
	echo 'Under construction';

}

function wpbeautify_font_select($el_name, $value='') {
	$fonts_settings = wpbeautify_get_font_settings();
	$current_fonts = $fonts_settings['current_fonts'];
	$str_ret = '<select name="'.$el_name.'" id="'.$el_name.'" class="wpbeautify_font_select form-control">';
	$str_ret .= '<option value="0">Select font...</option>';

	if ($current_fonts) {
		foreach ($current_fonts as $font) {
			$str_ret .= '<option style="font-family:'.$font.'" value="'.$font.'" '.selected($font, $value, false).'>'.$font.'</option>';
		}
	}
	$str_ret .= '</select>';
	return $str_ret;
}

function wpbeautify_font_size_input($el_name, $value='') {
	$str_ret = '<input type="text" style="width:50px" name="'.$el_name.'" id="'.$el_name.'" value="'.$value.'"> px';
	return $str_ret;
}

function wpbeautify_effect_select($el_name, $value='') {
	$fonts_settings = wpbeautify_get_font_settings();
	$current_effects = $fonts_settings['current_effects'];
	$str_ret = '<select name="'.$el_name.'" id="'.$el_name.'" class="wpbeautify_effect_select form-control">';
	$str_ret .= '<option value="0">- None -</option>';

	if ($current_effects) {
		foreach ($current_effects as $effect) {
			$str_ret .= '<option value="'.$effect.'" '.selected($effect, $value, false).'>'.wpbeautify_stringify_select($effect).'</option>';
		}
	}
	$str_ret .= '</select>';
	return $str_ret;
}

function wpbeautify_stringify_select($effect_code) {
	return ucwords(str_replace('-', ' ', $effect_code));
}

function wpbeautify_panel_fonts() {
	$page = isset($_GET['pagenum']) ? $_GET['pagenum'] : 0;
	$effects = isset($_GET['effects']) ? $_GET['effects'] : 0;
	$fonts_settings = wpbeautify_get_font_settings();
	$current_fonts = $fonts_settings['current_fonts'];
	$elements_fonts = $fonts_settings['elements_fonts'];
	$current_effects = $fonts_settings['current_effects'];

	if (isset($_POST['wpbeautify_update_fonts'])) {
		// update values
/*		if (isset($_POST['h1_font'])) {
			$elements_fonts['h1']['font'] = sanitize_text_field($_POST['h1_font']);
		}
		if (isset($_POST['h1_font_size'])) {
			$elements_fonts['h1']['size'] = intval($_POST['h1_font_size']);
		}
		if (isset($_POST['h1_effect'])) {
			$elements_fonts['h1']['effect'] = sanitize_text_field($_POST['h1_effect']);
		}
*/
		$html_elements = array('h1', 'h2', 'h3', 'h4', 'p', 'li', 'widget_title', 'widget_content');

		foreach ($html_elements as $element) {
			if (isset($_POST[$element.'_enabled']) && $_POST[$element.'_enabled'] == 1)
				$elements_fonts[$element]['enabled'] = 1;
			else
				$elements_fonts[$element]['enabled'] = 0;

			if (isset($_POST[$element.'_font']))
				$elements_fonts[$element]['font'] = sanitize_text_field($_POST[$element.'_font']);
/*			if (isset($_POST[$element.'_font_size']))
				$elements_fonts[$element]['size'] = intval($_POST[$element.'_font_size']);*/
			if (isset($_POST[$element.'_effect']))
				$elements_fonts[$element]['effect'] = sanitize_text_field($_POST[$element.'_effect']);
		}


/*		if (isset($_POST['h2_font'])) {
			$elements_fonts['h2']['font'] = sanitize_text_field($_POST['h2_font']);
		}
		if (isset($_POST['h2_font_size'])) {
			$elements_fonts['h2']['size'] = intval($_POST['h2_font_size']);
		}
		if (isset($_POST['h1_effect'])) {
			$elements_fonts['h1']['effect'] = sanitize_text_field($_POST['h1_effect']);
		}

		if (isset($_POST['h3_font'])) {
			$elements_fonts['h3']['font'] = sanitize_text_field($_POST['h3_font']);
		}

		if (isset($_POST['h3_font_size'])) {
			$elements_fonts['h3']['size'] = intval($_POST['h3_font_size']);
		}

		if (isset($_POST['h4_font'])) {
			$elements_fonts['h4']['font'] = sanitize_text_field($_POST['h4_font']);
		}

		if (isset($_POST['h4_font_size'])) {
			$elements_fonts['h4']['size'] = intval($_POST['h4_font_size']);
		}

		if (isset($_POST['p_font'])) {
			$elements_fonts['p']['font'] = sanitize_text_field($_POST['p_font']);
		}

		if (isset($_POST['p_font_size'])) {
			$elements_fonts['p']['size'] = intval($_POST['p_font_size']);
		}

		if (isset($_POST['li_font'])) {
			$elements_fonts['li']['font'] = sanitize_text_field($_POST['li_font']);
		}

		if (isset($_POST['li_font_size'])) {
			$elements_fonts['li']['size'] = intval($_POST['li_font_size']);
		}

		if (isset($_POST['widget_title_font'])) {
			$elements_fonts['widget_title']['font'] = sanitize_text_field($_POST['widget_title_font']);
		}

		if (isset($_POST['widget_title_font_size'])) {
			$elements_fonts['widget_title']['size'] = intval($_POST['widget_title_font_size']);
		}

		if (isset($_POST['widget_content_font'])) {
			$elements_fonts['widget_content']['font'] = sanitize_text_field($_POST['widget_content_font']);
		}

		if (isset($_POST['widget_content_font_size'])) {
			$elements_fonts['widget_content']['size'] = intval($_POST['widget_content_font_size']);
		}
*/
		$fonts_settings['elements_fonts'] = $elements_fonts;
		wpbeautify_set_font_settings($fonts_settings);
	}
	// var_dump($elements_fonts);
?>
	<div class="wrap">
		<img src="<?php echo WPBEAUTIFY_URL;?>/img/logo_medium.png" style="margin-left: 50px;margin-bottom:10px">
		<br/>

		<div class="bootstrap-wpbtfy-wpadmin">
			<div class="container">
				<div class="col-md-12">
					<div class="row">
						<div class="navbar">
							<div class="navbar-inner">
						        <ol class="breadcrumb">
								  <li><a href="#">FotoPress</a></li>
								  <li class="active">Fonts</li>
								</ol>
							</div>
						</div>
					</div>

					<div class="row">
					<div class="col-sm-9">

					<div class="active-fonts well">
						<form method="POST">
							<h4 style="padding-bottom:12px">Use Google Fonts for: </h4>
							<!-- <span class="wpbtfy-popover"><i class="fa fa-question-circle " data-container="body" data-toggle="popover" data-placement="left" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">a</i></span> <a href="#" id="examplep" class="btn large primary" data-toggle="popover" data-placement="right" data-title="titulo" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">click for popover</a> -->

							<p>Please activate at least one Font from the list below before they will appear in the dropdown lists (same with effects)</p>

							<table class="table table-condensed table_select_texts">
							<tr><th scope="col">Element</th><th scope="col">Font Family</th><!--<th scope="col">Font Size</th>--><th scope="col">Effect</th></tr>

							<tr><td><span class="checkbox">
							<?php if (($elements_fonts['h1']['enabled'])) $td_class = ''; else $td_class='empty'; ?>
							  <label>
							    <input class="font_el_enable" type="checkbox" value="1" name="h1_enabled" <?php checked($elements_fonts['h1']['enabled']);?>>
							    h1

							  </label></span> </td>
							  <td ><span class="<?php echo $td_class;?>"><?php echo wpbeautify_font_select('h1_font', $elements_fonts['h1']['font']);?> </span></td>
							  <!-- <td><?php echo wpbeautify_font_size_input('h1_font_size', $elements_fonts['h1']['size']);?></td> -->
							  <td><span class="<?php echo $td_class;?>"><?php echo wpbeautify_effect_select('h1_effect', $elements_fonts['h1']['effect']);?> </span></td>
							 </tr>

							<tr><td><div class="checkbox">
							<?php if (($elements_fonts['h2']['enabled'])) $td_class = ''; else $td_class='empty'; ?>

							  <label>
							    <input class="font_el_enable" type="checkbox" value="1" name="h2_enabled" <?php checked($elements_fonts['h2']['enabled']);?>>
							    h2
							  </label> </div>	</td>
							   <td><span class="<?php echo $td_class;?>"><?php echo wpbeautify_font_select('h2_font', $elements_fonts['h2']['font']);?> </span></td>
							   <!-- <td><span class="<?php echo $td_class;?>"><?php echo wpbeautify_font_size_input('h2_font_size', $elements_fonts['h2']['size']);?></td</span>> -->
							  <td><span class="<?php echo $td_class;?>"><?php echo wpbeautify_effect_select('h2_effect', $elements_fonts['h2']['effect']);?> </span></td>
							</tr>
							<tr><td><div class="checkbox">
							<?php if (($elements_fonts['h3']['enabled'])) $td_class = ''; else $td_class='empty'; ?>

							  <label>
							    <input class="font_el_enable" type="checkbox" value="1" name="h3_enabled" <?php checked($elements_fonts['h3']['enabled']);?>>
							    h3
							  </label> </div></td>
							   <td><span class="<?php echo $td_class;?>"><?php echo wpbeautify_font_select('h3_font', $elements_fonts['h3']['font']);?> </span></td>
							   <!-- <td><span class="<?php echo $td_class;?>"><?php echo wpbeautify_font_size_input('h3_font_size', $elements_fonts['h3']['size']);?></td</span>> -->
							  <td><span class="<?php echo $td_class;?>"><?php echo wpbeautify_effect_select('h3_effect', $elements_fonts['h3']['effect']);?> </span></td>
							</tr>
							<tr><td><div class="checkbox">
							<?php if (($elements_fonts['h4']['enabled'])) $td_class = ''; else $td_class='empty'; ?>

							  <label>
							    <input class="font_el_enable" type="checkbox" value="1" name="h4_enabled" <?php checked($elements_fonts['h4']['enabled']);?>>
							    h4
							  </label> </div>	</td>
							   <td><span class="<?php echo $td_class;?>"><?php echo wpbeautify_font_select('h4_font', $elements_fonts['h4']['font']);?> </span></td>
							   <!-- <td><span class="<?php echo $td_class;?>"><?php echo wpbeautify_font_size_input('h4_font_size', $elements_fonts['h4']['size']);?></td</span>> -->
							  <td><span class="<?php echo $td_class;?>"><?php echo wpbeautify_effect_select('h4_effect', $elements_fonts['h4']['effect']);?> </span></td>
												</tr>

							<tr><td><div class="checkbox">
							<?php if (($elements_fonts['p']['enabled'])) $td_class = ''; else $td_class='empty'; ?>

							  <label>
							    <input class="font_el_enable" type="checkbox" value="1" name="p_enabled" <?php checked($elements_fonts['p']['enabled']);?>>
							    Paragraph (&lt;p&gt;)
							  </label> </div>	</td>
							   <td><span class="<?php echo $td_class;?>"><?php echo wpbeautify_font_select('p_font', $elements_fonts['p']['font']);?> </span></td>
							   <!-- <td><span class="<?php echo $td_class;?>"><?php echo wpbeautify_font_size_input('p_font_size', $elements_fonts['p']['size']);?></td</span>> -->
							  <td><span class="<?php echo $td_class;?>"><?php echo wpbeautify_effect_select('p_effect', $elements_fonts['p']['effect']);?> </span></td>
							</tr>

							<tr><td><div class="checkbox">
							<?php if (($elements_fonts['li']['enabled'])) $td_class = ''; else $td_class='empty'; ?>

							  <label>
							    <input class="font_el_enable" type="checkbox" value="1" name="li_enabled" <?php checked($elements_fonts['li']['enabled']);?>>
							    List items (&lt;li&gt;)
							  </label> </div></td>
							   <td><span class="<?php echo $td_class;?>"><?php echo wpbeautify_font_select('li_font', $elements_fonts['li']['font']);?> </span></td>
							   <!-- <td><span class="<?php echo $td_class;?>"><?php echo wpbeautify_font_size_input('li_font_size', $elements_fonts['li']['size']);?></td</span>> -->
							  <td><span class="<?php echo $td_class;?>"><?php echo wpbeautify_effect_select('li_effect', $elements_fonts['li']['effect']);?> </span></td>
								</tr>

							<tr><td><div class="checkbox">
							<?php if (($elements_fonts['widget_title']['enabled'])) $td_class = ''; else $td_class='empty'; ?>

							  <label>
							    <input class="font_el_enable" type="checkbox" value="1" name="widget_title_enabled" <?php checked($elements_fonts['widget_title']['enabled']);?>>
							    Widget title
							  </label> </div></td>
							   <td><span class="<?php echo $td_class;?>"><?php echo wpbeautify_font_select('widget_title_font', $elements_fonts['widget_title']['font']);?> </span></td>
							   <!-- <td><span class="<?php echo $td_class;?>"><?php echo wpbeautify_font_size_input('widget_title_font_size', $elements_fonts['widget_title']['size']);?></td</span>> -->
							  <td><span class="<?php echo $td_class;?>"><?php echo wpbeautify_effect_select('widget_title_effect', $elements_fonts['widget_title']['effect']);?> </span></td>
								</tr>

							<tr><td><div class="checkbox">
							<?php if (($elements_fonts['widget_content']['enabled'])) $td_class = ''; else $td_class='empty'; ?>

							  <label>
							    <input class="font_el_enable" type="checkbox" value="1" name="widget_content_enabled" <?php checked($elements_fonts['widget_content']['enabled']);?>>
							    Widget content
							  </label> </div></td>
							   <td><span class="<?php echo $td_class;?>"><?php echo wpbeautify_font_select('widget_content_font', $elements_fonts['widget_content']['font']);?> </span></td>
							   <!-- <td><span class="<?php echo $td_class;?>"><?php echo wpbeautify_font_size_input('widget_content_font_size', $elements_fonts['widget_content']['size']);?></td</span>> -->
							  <td><span class="<?php echo $td_class;?>"><?php echo wpbeautify_effect_select('widget_content_effect', $elements_fonts['widget_content']['effect']);?> </span></td>
								</tr>
							</table>
							<input type="hidden" name="wpbeautify_update_fonts" value="1" />
							<button type="submit" class="btn btn-primary" name="submit-button-6" value="1">Save</button>
						</form>
					</div>
					</div>
					<div class="col-sm-3">
						<div class="row">
							<div class="progress">
							  <div id="active_fonts_progress" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="10" style="width: 0%">
							  </div>
							</div>
							<div class="alert alert-success" id="active_fonts_wrapper">
								<h2>Active fonts: <span style="font-weight:bold" id="wpbtfy_num_fonts">0</span></h2>
								<p id="font_explanation" style="display:none"> </p>
							</div>
							<br/>
							<br/>
						</div>

						<div class="row">
							<div class="progress">
							  <div id="active_effects_progress" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="10" style="width: 0%">
							  </div>
							</div>
							<div class="alert alert-success" id="active_effects_wrapper">
								<h2>Active effects: <span style="effect-weight:bold" id="wpbtfy_num_effects">0</span></h2>
								<p id="effect_explanation" style="display:none"> </p>
							</div>
						</div>
					</div>

				</div> <!-- row -->
				<div class="row">
<br/>

					<ul class="nav nav-tabs">
					  <li <?php if (!$effects) echo 'class="active"';?>><a href="<?php echo admin_url( 'admin.php?page=fotopress-fonts');?>"><i class="fa fa-font"></i> Fonts</a></li>
					  <li <?php if ($effects) echo 'class="active"';?>><a href="<?php echo admin_url( 'admin.php?page=fotopress-fonts&effects=1');?>"><i class="fa fa-bolt"></i> Effects</a></li>
					</ul>

					<br/>
					<?php
						if ($effects) {
							$effects = wpbeautify_get_all_font_effects();

							$str_ret = '';
							$exploded_effects = '';
							foreach ($effects['google'] as $effect) {
								$exploded_effects .= $effect['class'].'|';
							}
							$str_ret = '<link href="'.WPBEAUTIFY_GOOGLE_FONTS_URL.'/css?family=Alice:400,400italic,700&effect='.$exploded_effects.'" rel="stylesheet" type="text/css">';

							echo $str_ret;
					?>


						<table class="table canvakala-fonts-table">
							<tr><th></th><th>Sample</th><th>Active</th><th>&nbsp;</th><th>Browser Support</th></tr>
							<tr><th scope="row" colspan="5" ><h3>Google Effects:</h3></th></tr>
							<?php
								$str_ret = '';
								foreach ($effects['google'] as $effect) {
									$is_active_effect = in_array($effect['class'], $current_effects);
									if ($is_active_effect)
										$active_class= ' class="success"';
									else
										$active_class='';
									$str_ret .= '<tr'.$active_class.'><td></td>
										<td><span class="font-effect-'.$effect['class'].'" style="font-size:34px;font-family:Alice">'.$effect['name'].'</span></td>
										<td><div class="make-switch"><input type="checkbox" data-effect-name="'.$effect['class'].'" class="wpb_switch effect_list_switch" '.checked($is_active_effect, true, false).'/></div></td>
										<td><!--<button type="button" class="btn btn-info btn-sm wpbeautify-preview-effect" data-effect-name="'.$effect['class'].'"><span class="glyphicon glyphicon-zoom-in"></span> Preview</button>--></td>
										<td>'.wpbeautify_browser_support_icons($effect['support']).'</td></tr>';
								}
								$str_ret .= '<tr><th scope="row" colspan="5" ><br/><h3>Other Effects (ship with the plugin; already active):</h3></th></tr>';
								foreach ($effects['personal'] as $effect) {
									$is_active_effect = in_array($effect['class'], $current_effects);
									$str_ret .= '<tr><td></td>
										<td><span class="font-effect-'.$effect['class'].'" style="font-size:34px;font-family:Alice">'.$effect['name'].'</span></td>
										<td></td>
										<td><!--<button type="button" class="btn btn-info btn-sm wpbeautify-preview-effect" data-effect-name="'.$effect['class'].'"><span class="glyphicon glyphicon-zoom-in"></span> Preview</button>--></td>
										<td>'.wpbeautify_browser_support_icons($effect['support']).'</td></tr>';
								}


								echo $str_ret;
							?>
						</table>

						<?php
						} else {
							$searched_font = isset($_GET['searched_font']) ? $_GET['searched_font'] : 0;
							$font_filter = isset($_GET['font_filter']) ? $_GET['font_filter'] : 0;


							// which panel should be open?
						    if ($searched_font || $font_filter || $page) {
						    	// wizard closed, other-opened
						    	$wizard_icon = 'glyphicon-chevron-down';
						    	$wizard_status = '';
						    	$all_icon = 'glyphicon-chevron-up';
						    	$all_status = 'in';
						    }
						    else {
						    	// wizard open, other-closed
						    	$wizard_icon = 'glyphicon-chevron-up';
						    	$wizard_status = 'in';
						    	$all_icon = 'glyphicon-chevron-down';
						    	$all_status = '';
						    }

						    if ( $page ) $page--;
						    $offset = $page * WPBEAUTIFY_FONTS_PER_PAGE;
						    $str_ret = '';
							?>

							<div class="panel-group" id="accordion">
							  <div class="panel panel-default"> <!-- wizard panel -->
							    <div class="panel-heading">
							      <h4 class="panel-title">
							        <a data-toggle="collapse" data-parent="#accordion" href="#wizard_mode">
							          <i class="fa fa-magic"></i> Recommended Fonts
							        </a> <a data-toggle="collapse" data-parent="#accordion" href="#wizard_mode"><i class="indicator glyphicon <?php echo $wizard_icon; ?>  pull-right"></i></a>
							      </h4>
							    </div>
							    <div id="wizard_mode" class="panel-collapse collapse <?php echo $wizard_status; ?>">
							      <div class="panel-body">
							      	<?php wpbeautify_load_font_combinations_css();?>
							        <?php wpbeautify_print_font_combinations();?>
							      </div>
							    </div>
							  </div><!-- wizard fonts panel end -->
							  <div class="panel panel-default"> <!-- all fonts panel -->
							    <div class="panel-heading">
							      <h4 class="panel-title">
							        <a data-toggle="collapse" data-parent="#accordion" href="#advanced_mode">
							          <i class="fa fa-sort-alpha-asc"></i> All Fonts
							        </a> <a data-toggle="collapse" data-parent="#accordion" href="#advanced_mode"><i class="indicator glyphicon <?php echo $all_icon; ?>  pull-right"></i></a>
							      </h4>
							    </div>
							    <div id="advanced_mode" class="panel-collapse collapse <?php echo $all_status; ?>">
							      <div class="panel-body">

							<?php


							$fonts = wpbeautify_get_all_fonts($page, WPBEAUTIFY_FONTS_PER_PAGE, $searched_font, $font_filter);
							foreach ($fonts['fonts'] as $font) {
								$str_ret .= '<link href="'.WPBEAUTIFY_GOOGLE_FONTS_URL.'/css?family='.$font['family'].':400,400italic,700" rel="stylesheet" type="text/css">';
							}

						    $total_fonts = $fonts['total'];

						    if ( !$total_fonts || !$fonts) return '<br/>No data';


						    $page_links = paginate_links( array(
						            'base' =>  $searched_font ? admin_url( 'admin.php?page=fotopress-fonts&searched_font='.$searched_font.'&pagenum=%#%' ) : admin_url( 'admin.php?page=fotopress-fonts&pagenum=%#%' ),
						            'format' => '',
						            'end_size' => 2,
						            'mid_size' => 3,
						            'prev_text' => __( '&laquo;', 'aag' ),
						            'next_text' => __( '&raquo;', 'aag' ),
						            'total' => ceil( $total_fonts/WPBEAUTIFY_FONTS_PER_PAGE ),
						            'current' => $page+1,
						            'type' => 'array'
						        ) );

						    $str_ret .= '<div class="row" style="margin-bottom:10px">';
						    if ( $page_links ) {
						        $displaying = min($total_fonts, ( $offset+WPBEAUTIFY_FONTS_PER_PAGE ));
						        // $str_ret .= '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0"><span class="displaying-num" >Displaying '. ($offset+1) . '-'. $displaying . ' of '. $total_fonts . '</span>'. $page_links . '</div></div>';
						        $str_ret .= '<div class="col-md-2"><span class="displaying-num" >Displaying '. ($offset+1) . '-'. $displaying . ' of '. $total_fonts . '</span></div><div class="col-md-4">'. wpbeautify_listify_pagination($page_links) . '</div>';
						    }

							// $str_ret .= '';

							echo $str_ret;
						?>
						<div class="col-md-3">
							<form method="GET" class="form-inline" action="<?php echo admin_url('admin.php' );?>">
							   <div class="input-group">
							       <input type="hidden" name="page" value="canvakala-fonts" />
							       <input type="Search" placeholder="Search by name..." class="form-control" name="searched_font" value="<?php echo ($searched_font) ? $searched_font : '';?>"/>
							       <div class="input-group-btn">
							           <button class="btn btn-info">
							           <span class="glyphicon glyphicon-search"></span>
							           </button>
							       </div>
							   </div>
							</form>
							</div>
						   <div class="input-group col-md3-2">

								<select id="fonts_display_active" class="form-control">
									<option value="0">All</option>
									<option value="1" <?php selected($font_filter, 1);?>>Active</option>
									<option value="2" <?php selected($font_filter, 2);?>>Inactive</option>
								</select>
								<script>
								jQuery( document ).ready(function(  ) {
									jQuery('#fonts_display_active').on('change', function (e) {
										//alert(jQuery(this).val())
										document.location = "<?php echo admin_url( 'admin.php?page=fotopress-fonts&font_filter=');?>"+jQuery(this).val();
									});
								})
								</script>
							</div>
						</div>
						<table class="table canvakala-fonts-table" id="canvakala-fonts-table">
							<tr><th></th><th>Font Name</th><th>Active</th><th>&nbsp;</th><th>Sample</th></tr>
							<?php
								$str_ret = '';
								foreach ($fonts['fonts'] as $font) {
									$is_active_font = in_array($font['family'], $current_fonts);
									if ($is_active_font)
										$active_class= ' class="success"';
									else
										$active_class='';
									$str_ret .= '<tr data-font-name="'.$font['family'].'" '.$active_class.'><td></td>
										<td>'.$font['family'].'</td>
										<td><div class="make-switch"><input type="checkbox" data-font-name="'.$font['family'].'" class="wpb_switch font_list_switch" '.checked($is_active_font, true, false).'/></div></td>
										<td><button type="button" class="btn btn-primary btn-sm wpbeautify-preview-font" data-font-name="'.$font['family'].'"><span class="glyphicon glyphicon-zoom-in"></span> Preview</button></td>
										<td><span style="font-size:23px;font-family:'.$font['family'].'">Grumpy wizards make toxic brew for the evil Queen and Jack.</span></td></tr>';
								}
								echo $str_ret;
							?>
						</table>
						      </div>
						    </div>
						  </div> <!-- all fonts panel end -->
						</div> <!-- accordion end -->

						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
}

/*
		'image_sites' => array(
			'pixabay' => array('id' => 'pixabay', 'name' => 'Pixabay', 'used' => 0, 'order' => 0, 'details' => array('username' => '', 'api_key' => '', 'validapi' => '')),
			'flickr' => array('id' => 'flickr', 'name' => 'Flickr', 'used' => 0, 'order' => 1, 'details' => array('api_key' => '', 'validapi' => '')),
			'openclipart' => array('id' => 'openclipart', 'name' => 'Openclipart', 'used' => 0, 'order' => 2, 'details' => array()),
			'iamcc' => array('id' => 'iamcc', 'name' => 'Instagram', 'used' => 0, 'order' => 3, 'details' => array())
		),
		'social_sites' => array(
			'dropbox' => array('app_id' => ''),
			'facebook' => array('app_id' => '')
		),
		'watermark' => array()
		);*/

function wpbeautify_exchangeToken($single_use_token) {


        $ch = curl_init("https://www.google.com/accounts/AuthSubSessionToken");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: AuthSub token="' . $single_use_token . '"'
                ));

        $result = curl_exec($ch);  /* Execute the HTTP command. */

        # See if there has been a curl error
        if(curl_errno($ch)) {

                echo "<p><strong>Error: Could not generate session token! Exiting...</strong></p>";
                die ('Curl error: ' . curl_error($ch));

        }
        curl_close($ch);
        $splitStr = explode("=", $result);

        if (strlen($splitStr[1]) > 14) {
                return trim($splitStr[1]);
        } else {
                echo "<p><strong>Error: Could not generate session token! Exiting...</strong></p>";
                die('Unexpected value returned to exchangeToken(): ' . $splitStr[1]);
        }

}

function wpbeautify_panel_images() {
	$image_settings = wpbeautify_get_image_settings();

	if (isset($_GET['auth']) && $_GET['auth']) {
		if ($_GET['auth'] == 'gplus') {
			// store token
			$token = $_GET['token'];
			$newToken = wpbeautify_exchangeToken($token);
			// var_dump($newToken);
			// $image_settings = wpbeautify_get_image_settings();
			$image_settings['social_sites']['googleplus']['token'] = $newToken;
			wpbeautify_set_image_settings($image_settings);
			// update_option("wpbeautify_gdata_token",$newToken);
		}
		else if ($_GET['auth'] == 'instagram') {
			// store token

			$code = $_GET['code'];

			// check whether the user has granted access
			if (isset($code)) {
				$token = wpbeautify_instagram_store_token($code);

				$image_settings['social_sites']['instagram']['token'] = $token;
				wpbeautify_set_image_settings($image_settings);
			} else {

			  // check whether an error occurred
			  if (isset($_GET['error'])) {
			    echo 'An error occurred: ' . $_GET['error_description'];
			  }

			}

		}
		else if ($_GET['auth'] == 'facebook') {
			wpbeautify_facebook_do_auth();
		}
		else if ($_GET['auth'] == 'flickr') {
			wpbeautify_flickr_do_auth();
		}

		/*else if ($_GET['auth'] == 'pinterest') {
			wpbeautify_pinterest_do_auth();
		}*/

	}
	if ( isset( $_POST['wpbeautify_update_images'] ) && ( $_POST['wpbeautify_update_images'] == 1 ) ) {
		wpbeautify_process_settings_form();
		$wpbeautify_display_msg = 1;
	}

	$image_settings = wpbeautify_get_image_settings();

	$wpbeautify_sites = $image_settings['image_sites'];
	// var_dump($wpbeautify_sites);
	$watermark_settings = $image_settings['watermark'];

	usort( $wpbeautify_sites, 'wpbeautify_sort_by_order' );

	if ( ! isset( $image_settings['image_sites']['pixabay']['details']['ownkey'] ) )
		$image_settings['image_sites']['pixabay']['details']['ownkey'] = 0;
	$pix_own_key = $image_settings['image_sites']['pixabay']['details']['ownkey'];
	// var_dump($pix_own_key);
/*	if (isset($_POST[''])) {
		// it is an update

		$image_settings['image_sites']['pixabay']['username'] = $_POST['pixabay_username'];
		$image_settings['image_sites']['pixabay']['api_key'] = $_POST['pixabay_api_key'];
		$image_settings['image_sites']['flickr']['api_key'] = $_POST['flickr_api_key'];
		$image_settings['social_sites']['dropbox']['app_id'] = $_POST['dropbox_app_id'];
		$image_settings['social_sites']['facebook']['app_id'] = $_POST['facebook_app_id'];
		// wpbeautify_set_image_settings($image_settings);
	}*/
?>

	<div class="wrap">
		<img src="<?php echo WPBEAUTIFY_URL;?>/img/logo_medium.png" style="margin-left: 50px;margin-bottom:10px">
		<br/>

		<div class="bootstrap-wpbtfy-wpadmin">
			<div class="container">
						<div class="navbar">
							<div class="navbar-inner">
						        <ol class="breadcrumb">
								  <li><a href="#">FotoPress</a></li>
								  <li class="active">Images</li>
								</ol>
							</div>
						</div>


<h3>Image Sites</h3>
<br/>
				<form action="<?php echo admin_url('admin.php?page=fotopress-images');?>" method="post" accept-charset="UTF-8" id="wpbeautify_images_form">

<div class="form-horizontal" role="form" method="post">
<div class="well">

<h4 style="padding-left:40px"><i class="fa fa-picture-o"></i> Pixabay</h4>

	<div class="form-group">
	  <label for="wpbeautify_pixabay_ownkey" class="col-sm-2 control-label">&nbsp;</label>
	  <div class="col-sm-4">
	  <div class="checkbox">
	          <label for="wpbeautify_pixabay_ownkey">
	            <input type="checkbox" value="1" id="wpbeautify_pixabay_ownkey" name="wpbeautify_pixabay_ownkey" <?php checked( $image_settings['image_sites']['pixabay']['details']['ownkey'], '1' );?> />
	             Use your own Pixabay API Key
	          </label>
	        </div>
	  	<span class="help-block">Not needed, you can use the one Provided with FotoPress.</span>
	  </div>
	</div>
<div id="pixabay-extra" <?php if( !$pix_own_key ) echo ' style="display:none"';?>>
  <div class="form-group">
    <label for="wpbeautify_pixabay_username" class="col-sm-2 control-label">Pixabay Username</label>
    <div class="col-sm-4">
      <input type="form" class="form-control" name="wpbeautify_pixabay_username" placeholder="Your Pixabay Username" value="<?php echo esc_attr($image_settings['image_sites']['pixabay']['details']['username']);?>">
    </div>
  </div>
  <div class="form-group">
    <label for="wpbeautify_pixabay_apikey" class="col-sm-2 control-label">Pixabay Api Key</label>
    <div class="col-sm-4">
      <input type="form" class="form-control" name="wpbeautify_pixabay_apikey" placeholder="Your Pixabay API Key" value="<?php echo esc_attr($image_settings['image_sites']['pixabay']['details']['api_key']);?>">
    </div>
  </div>
  <div class="form-group">
    <label for="wpbeautify_pixabay_hires" class="col-sm-2 control-label">High Res Images</label>
    <div class="col-sm-4">
    <div class="checkbox">
            <label for="wpbeautify_pixabay_hires">
              <input type="checkbox" value="1" id="wpbeautify_pixabay_hires" name="wpbeautify_pixabay_hires" <?php checked( $image_settings['image_sites']['pixabay']['details']['hires'], '1' );?> />
               Use high resolution images when available
            </label>
          </div>
    	<span class="help-block">(requires approval from <a href="http://pixabay.com/en/service/contact/">Pixabay</a>). Make sure you got the approval first or the search will return no results if checked</span>
    </div>
  </div>


 <?php if ( /*0 &&*/$pix_own_key && !$image_settings['image_sites']['pixabay']['details']['validapi'] && ( !empty( $image_settings['image_sites']['pixabay']['details']['api_key'] ) || !empty( $image_settings['image_sites']['pixabay']['details']['username'] ) ) ) { ?>
  	<div class="form-group">
    	<div class="col-sm-2">
    	</div>
    	<div class="col-sm-4">
  			<div class="alert alert-danger"><b>ERROR:</b> Invalid API KEY</div>
  		</div>
  	</div>
<?php } ?>
</div>
</div> <!-- well -->

<div class="well">

	<h4 style="padding-left:40px"><i class="fa fa-flickr"></i> Flickr</h4>
  <div class="form-group">
    <label for="flickr_api_key" class="col-sm-2 control-label">Flickr API Key</label>
    <div class="col-sm-4">
      <input type="form" class="form-control" name="wpbeautify_flickr_apikey" placeholder="Your Flickr API Key" value="<?php echo esc_attr($image_settings['social_sites']['flickr']['api_key']);?>">
    	<span class="help-block">Get your Api Key <a target="blank" title="Opens in a New Window" href="http://www.flickr.com/services/apps/create/apply/">here</a></span>

    </div>
  </div>
<!--
  <div class="form-group">
    <label for="flickr_api_secret" class="col-sm-2 control-label">Flickr API Secret</label>
    <div class="col-sm-4">
      <input type="form" class="form-control" name="wpbeautify_flickr_apisecret" placeholder="Your Flickr API Secret" value="<?php /*echo esc_attr($image_settings['social_sites']['flickr']['api_secret']);*/?>">
    </div>
  </div>
-->
  <div class="form-group">
    <label for="flickr_api_key" class="col-sm-2 control-label">Flickr Username</label>
    <div class="col-sm-4">
      <input type="form" class="form-control" name="wpbeautify_flickr_username" placeholder="Your Flickr Username" value="<?php echo esc_attr($image_settings['social_sites']['flickr']['username']);?>">
    </div>
  </div>
<!--
  <div class="form-group">
   <label for="" class="col-sm-2 control-label">&nbsp;</label>
    <div class="col-sm-4">
	      <button class="btn btn-info" type="button" id="wp_beautify_flickr_auth"><i class="fa fa-arrow-right"></i> Authorize</button> &nbsp;&nbsp;&nbsp;
    	<span class="help-block">Enter your Api ID  & Api Secret and click here to authorize</span>
    </div>
  </div>
  <input type="hidden" name="wpbeautify_flickr_authorize"  id="wpbeautify_flickr_authorize" value="0" />
-->
   <?php if ( !$image_settings['image_sites']['flickr']['details']['validapi'] && ( !empty( $image_settings['image_sites']['flickr']['details']['api_key'] ) ) ) { ?>
    	<div class="form-group">
      	<div class="col-sm-2">
      	</div>
      	<div class="col-sm-4">

    			<div class="alert alert-danger"><b>ERROR:</b> Invalid API KEY</div>
    		</div>
    	</div>
  <?php } ?>
</div>


<div class="well">

	<h4 style="padding-left:40px;display: inline-block;"><a target="blank" title="Opens in a New Window" href="http://www.youzign.com"><img src="<?php echo WPBEAUTIFY_URL;?>/img/icons/youzign_logo.png" style="margin-right:12px" /></a></h4> <h5 style="display: inline-block;"> Use your <a target="_blank" href="http://www.wpbeautify.com/imnews/youzign1">youzign.com</a> designs inside FotoPress</h5>
  <div class="form-group">
    <label for="youzign_api_key" class="col-sm-2 control-label">Youzign Public Key</label>
    <div class="col-sm-4">
      <input type="form" class="form-control" name="wpbeautify_youzign_apikey" placeholder="Your Youzign Public Key" value="<?php echo esc_attr($image_settings['social_sites']['youzign']['api_key']);?>">
    	<span class="help-block">Get your Api Key <a target="blank" title="Opens in a New Window" href="https://youzign.com/profile/">here</a></span>

    </div>
  </div>

  <div class="form-group">
    <label for="youzign_api_key" class="col-sm-2 control-label">Youzign Token</label>
    <div class="col-sm-4">
      <input type="form" class="form-control" name="wpbeautify_youzign_token" placeholder="Your Youzign Token" value="<?php echo esc_attr($image_settings['social_sites']['youzign']['token']);?>">
    </div>
  </div>

   <?php if ( isset( $image_settings['image_sites']['youzign'] ) && !$image_settings['image_sites']['youzign']['details']['validapi'] && ( !empty( $image_settings['image_sites']['youzign']['details']['api_key'] ) ) ) { ?>
    	<div class="form-group">
      	<div class="col-sm-2">
      	</div>
      	<div class="col-sm-4">

    			<div class="alert alert-danger"><b>ERROR:</b> Invalid API KEY</div>
    		</div>
    	</div>
  <?php } ?>
</div> <!-- end youzign -->


<?php if ( !ckala_is_pro() ) echo '<div style="display:none">'; ?>

<div class="well">
	<h4 style="padding-left:40px"><i class="fa fa-dropbox"></i> Dropbox</h4>
  <div class="form-group">
    <label for="dropbox_app_id" class="col-sm-2 control-label">Dropbox App Key</label>
    <div class="col-sm-4">
      <input type="form" class="form-control" name="dropbox_app_id" placeholder="Your Dropbox App Key" value="<?php echo esc_attr($image_settings['social_sites']['dropbox']['app_id']);?>">
    	<span class="help-block">Get your App Key <a target="blank" title="Opens in a New Window" href="https://www.dropbox.com/developers/apps">here</a></span>

    </div>
  </div>
</div>

<div class="well">

	<h4 style="padding-left:40px"><i class="fa fa-facebook"></i> Facebook</h4>
  <div class="form-group">
    <label for="facebook_app_id" class="col-sm-2 control-label">Facebook App ID</label>
    <div class="col-sm-4">
      <input type="form" class="form-control" name="facebook_app_id" placeholder="Your Facebook App ID" value="<?php echo esc_attr($image_settings['social_sites']['facebook']['app_id']);?>">
    </div>
  </div>
  <div class="form-group">
    <label for="facebook_app_secret" class="col-sm-2 control-label">Facebook App Secret</label>
    <div class="col-sm-4">
      <input type="form" class="form-control" name="facebook_app_secret" placeholder="Your Facebook App Secret" value="<?php echo esc_attr($image_settings['social_sites']['facebook']['app_secret']);?>">
    	<span class="help-block">Get your App ID <a target="blank" title="Opens in a New Window" href="https://developers.facebook.com/">here</a></span>
    </div>
  </div>
    <div class="form-group">
     <label for="" class="col-sm-2 control-label">&nbsp;</label>
      <div class="col-sm-4">
	      <button class="btn btn-info" type="button" id="wp_beautify_fb_auth"><i class="fa fa-arrow-right"></i> Authorize</button> &nbsp;&nbsp;&nbsp;
    	  <button class="btn btn-danger" type="button" id="wp_beautify_fb_deauth"><i class="fa fa-arrow-right"></i> Deauthorize</button>
      	<span class="help-block">Enter your App ID  & App Secret and click here to authorize</span>
      </div>
    </div>
    <input type="hidden" name="wpbeautify_fb_authorize"  id="wpbeautify_fb_authorize" value="0" />
</div>


<div class="well">

	<h4 style="padding-left:40px"><i class="fa fa-google-plus"></i> Google Drive / Google+</h4>

	<div class="form-group">
	  <label for="facebook_app_id" class="col-sm-2 control-label">Google API Key</label>
	  <div class="col-sm-4">
	    <input type="form" class="form-control" name="googledrive_api_key" placeholder="Your Google API Key" value="<?php echo esc_attr($image_settings['social_sites']['googledrive']['api_key']);?>">
	  </div>
	</div>
	<div class="form-group">
	  <label for="facebook_app_secret" class="col-sm-2 control-label">Google Client ID</label>
	  <div class="col-sm-4">
	    <input type="form" class="form-control" name="googledrive_client_id" placeholder="Your Google Client ID" value="<?php echo esc_attr($image_settings['social_sites']['googledrive']['client_id']);?>">
	  	<span class="help-block">Get your API Key & App ID <a target="blank" title="Opens in a New Window" href="https://code.google.com/apis/console/">here</a></span>
	  </div>
	</div>

  <div class="form-group">
    <label for="instagram_api_secret" class="col-sm-2 control-label">Redirect URI</label>
    <div class="col-sm-4">
      <p class="form-control-static"><?php echo admin_url('/admin.php?page=fotopress-images&gdauthorize=1');?></p>
    <span class="help-block">Enter this URL in your Google Api Console Settings when creating your application</span>
    </div>
  </div>

  <div class="form-group">
    <label for="instagram_api_secret" class="col-sm-2 control-label">Javascript Origins</label>
    <div class="col-sm-4">
      <p class="form-control-static"><?php echo wpbeautify_site_url(); ?></p>
    <span class="help-block">Enter this URL in your Google Api Console Settings under Javascript origins when creating your application</span>
    </div>
    <input type="hidden" name="wpbeautify_gdrive_authorize"  id="wpbeautify_gdrive_authorize" value="0" />

  </div>

    <div class="form-group">
     <label for="" class="col-sm-2 control-label">&nbsp;</label>
      <div class="col-sm-4">
  		<a href="#" class="btn btn-info" type="button" id="wp_beautify_gdrive_auth"><i class="fa fa-arrow-right"></i> Save & Authorize</a>
      <span class="help-block">Click here to authorize your Google Account</span>
      </div>
    </div>

    <?php
    	if (isset($_POST['wpbeautify_gdrive_authorize']) && ($_POST['wpbeautify_gdrive_authorize'] == '1')) { ?>
    		<script src="https://www.google.com/jsapi?key=<?php echo esc_attr($image_settings['social_sites']['googledrive']['api_key']);?>"></script>
    		<script src="https://apis.google.com/js/client.js?onload=wpbtfy_init_auth"></script>
		<?php
    	}
    ?>
</div>

<div class="well">
	<h4 style="padding-left:40px"><i class="fa fa-pinterest"></i> Pinterest</h4>
  <div class="form-group">
    <label for="pinterest_username" class="col-sm-2 control-label">Pinterest username</label>
    <div class="col-sm-4">
      <input type="form" class="form-control" name="pinterest_username" placeholder="Your Pinterest username" value="<?php echo esc_attr($image_settings['social_sites']['pinterest']['username']);?>">
    </div>
  </div>
  <?php

  /*$al = wpbeautify_pinterest_get_photos_in_album( false );
  var_dump($al);*/
  ?>
</div>

<div class="well">

	<h4 style="padding-left:40px"><i class="fa fa-instagram"></i> Instagram</h4>
  <div class="form-group">
    <label for="instagram_api_key" class="col-sm-2 control-label">Client ID</label>
    <div class="col-sm-4">
      <input type="form" class="form-control" name="instagram_api_key" placeholder="Your Instagram Client ID" value="<?php echo esc_attr($image_settings['social_sites']['instagram']['api_key']);?>">
    	<span class="help-block">Get your Api Key <a target="blank" title="Opens in a New Window" href="http://instagram.com/developer/">here</a></span>
    </div>
  </div>
  <div class="form-group">
    <label for="instagram_api_secret" class="col-sm-2 control-label">Client Secret</label>
    <div class="col-sm-4">
      <input type="form" class="form-control" name="instagram_api_secret" placeholder="Your Instagram Client Secret" value="<?php echo esc_attr($image_settings['social_sites']['instagram']['api_secret']);?>">
    </div>
  </div>
  <div class="form-group">
    <label for="instagram_api_secret" class="col-sm-2 control-label">Redirect URL</label>
    <div class="col-sm-4">
      <p class="form-control-static"><?php echo admin_url('/admin.php?page=fotopress-images&iauthorize=1');?></p>
    <span class="help-block">Enter this URL in your Instagram Settings when creating your application</span>
    </div>
  </div>
  <div class="form-group">
   <label for="" class="col-sm-2 control-label">&nbsp;</label>
    <div class="col-sm-4">
  		<button class="btn btn-info" type="button" id="wp_beautify_instagram_auth"><i class="fa fa-arrow-right"></i> Authorize</button>
    <span class="help-block">Enter your Api Key & Api Secret and click here to authorize</span>
    </div>
  </div>
    <input type="hidden" name="wpbeautify_instagram_authorize"  id="wpbeautify_instagram_authorize" value="0" />

    <?php /*$ret = wpbeautify_instagram_get_images();
    var_dump($ret); */?>
</div>


<div class="well">

	<h4 style="padding-left:40px"><i class="fa fa-twitter"></i> Twitter</h4>
  <div class="form-group">
    <label for="twitter_api_key" class="col-sm-2 control-label">Twitter Api Key</label>
    <div class="col-sm-4">
      <input type="form" class="form-control" name="twitter_api_key" placeholder="Your Twitter Api Key" value="<?php echo esc_attr($image_settings['social_sites']['twitter']['api_key']);?>">
    </div>
  </div>
  <div class="form-group">
    <label for="twitter_api_secret" class="col-sm-2 control-label">Twitter Api Secret</label>
    <div class="col-sm-4">
      <input type="form" class="form-control" name="twitter_api_secret" placeholder="Your Twitter Api Secret" value="<?php echo esc_attr($image_settings['social_sites']['twitter']['api_secret']);?>">
    </div>
  </div>

  <div class="form-group">
    <label for="twitter_token" class="col-sm-2 control-label">Access Token</label>
    <div class="col-sm-4">
      <input type="form" class="form-control" name="twitter_token" placeholder="Your Twitter Access Token" value="<?php echo esc_attr($image_settings['social_sites']['twitter']['token']);?>">
    </div>
  </div>

  <div class="form-group">
    <label for="twitter_token_secret" class="col-sm-2 control-label">Access Token Secret</label>
    <div class="col-sm-4">
      <input type="form" class="form-control" name="twitter_token_secret" placeholder="Your Twitter Access Token Secret" value="<?php echo esc_attr($image_settings['social_sites']['twitter']['token_secret']);?>">
    	<span class="help-block">Get your Api details <a target="blank" title="Opens in a New Window" href="https://apps.twitter.com/">here</a></span>
    </div>
  </div>
</div>

<?php if ( !ckala_is_pro() ) echo '</div>'; ?>

<br/>
<div class="form-group">
  <div class="col-sm-offset-2 col-sm-10">
    <button type="submit" class="btn btn-primary" name="submit-button-1" value="1"><span class="glyphicon glyphicon-ok"></span> Save all Changes</button>
  </div>
</div>
<br/>

<h3>Free Image Sources</h3>
<div class="well">


				<div class="form-group">
				  <div  class="col-sm-2 control-label"></div>
				  <div class="col-sm-4">
		<p> Drag and drop the items to reorder priority when searching. Check them to activate/deactivate when searching for free images</p>

				<?php echo wpbeautify_image_sites_settings( $wpbeautify_sites ); ?>

      			<button type="submit" class="btn btn-primary" name="submit-button-2" value="1"><span class="glyphicon glyphicon-ok"></span> Save All Changes</button>

				</div>
				<input type="hidden" name="wpbeautify_submitted" value="1" />
				<!-- <input type="submit" value="Save Settings" class="button-primary" id="wpbeautify_submit"> -->

</div>
</div>
<br/>
<?php
	if ( ckala_is_pro() )
		echo '<p>More Help on getting your API keys <a target="_blank" href="http://www.wpbeautify.com/imnews/fotopress-pro-apikeys">here</a></p>';
	else
		echo '<p>More Help on getting your API keys <a target="_blank" href="http://www.wpbeautify.com/imnews/fotopress-apikeys">here</a></p>';

?>

				<?php if( !ckala_is_pro() ) fotopress_upgrade_pro(); ?>


<?php if ( !ckala_is_pro() ) echo '<div style="display:none">'; ?>

<br/>
		<h3>Watermarking Settings </h3>
<div class="well">

	<div class="form-horizontal" role="form" method="post">

	  <div class="form-group">
	    <label for="dropbox_app_id" class="col-sm-2 control-label">Watermark Type</label>
	    <div class="col-sm-4">
		    <label class="radio-inline">
		      <input type="radio" name="watermark_type" id="watermark_type_text" value="text" <?php checked($watermark_settings['watermark_type'] == 'text');?>> Text
		    </label>
		    <label class="radio-inline">
		      <input type="radio"  name="watermark_type" id="watermark_type_image" value="image" <?php checked($watermark_settings['watermark_type'] == 'image');?>> Image
		    </label>
	    </div>
	  </div>

	 <!-- text settings -->
	<div id="watermark_text_settings" style="<?php if ($watermark_settings['watermark_type'] == 'image') echo 'display:none';?>">
	  <div class="form-group">
	    <label for="pinterest_username" class="col-sm-2 control-label">Watermark Text</label>
	    <div class="col-sm-4">
	      <input type="form" class="form-control" name="watermark_text" placeholder="Enter Watermarking Text" value="<?php echo $watermark_settings['watermark_text'];?>">
	    </div>
	  </div>

	  <div class="form-group">
	    <label for="watermark_font" class="col-sm-2 control-label">Font</label>
	    <div class="col-sm-4">
	    <select name="watermark_font" class="form-control">
	    	<!--<option selected="selected" style="font-family: 'Arial';" value="Arial.ttf" <?php selected($watermark_settings['watermark_font'], 'Arial.ttf');?>>
	    		Arial									</option>-->
	    	<option selected="selected" style="font-family: 'Arial Black';" value="Arial_Black.ttf" <?php selected($watermark_settings['watermark_font'], 'Arial_Black.ttf');?>>
	    		Arial Black									</option>
	    	<option style="font-family: 'Comic Sans MS';" value="Comic_Sans_MS.ttf" <?php selected($watermark_settings['watermark_font'], 'Comic_Sans_MS.ttf');?>>
	    		Comic Sans MS									</option>
	    	<option style="font-family: 'Georgia';" value="Georgia.ttf" <?php selected($watermark_settings['watermark_font'], 'Georgia.ttf');?>>
	    		Georgia									</option>
	    	<option style="font-family: 'Impact';" value="Impact.ttf" <?php selected($watermark_settings['watermark_font'], 'Impact.ttf');?>>
	    		Impact									</option>
	    	<option style="font-family: 'Verdana';" value="Verdana.ttf" <?php selected($watermark_settings['watermark_font'], 'Verdana.ttf');?>>
	    		Verdana									</option>
	    									</select>
	    </div>
	  </div>

	  <div class="form-group">
	    <label for="pinterest_username" class="col-sm-2 control-label">Text Size</label>
	    <div class="col-sm-2">
	    	<div class="input-group">
	      		<input type="text" style="" size="3" value="<?php echo $watermark_settings['watermark_text_size'];?>" name="watermark_text_size" class="form-control wpbtfy-spinner">
	      	<span class="input-group-addon">px</span>
	      </div>
	    </div>
	  </div>

	  <div class="form-group">
	    <label for="pinterest_username" class="col-sm-2 control-label">Text Color</label>
	    <!-- <div class="col-sm-4"> -->
	      <input class="form-control wpbtfy-colorpicker" type="text" data-position="bottom left" value="<?php echo $watermark_settings['watermark_text_color'];?>"  name="watermark_text_color"> <!-- size="6" maxlength="6"-->
	    <!-- </div> -->
	  </div>
	</div> <!-- end of text settings -->

		 <!-- image settings -->
		<div class="form-table" id="watermark_image_settings" style="<?php if ($watermark_settings['watermark_type'] == 'text') echo 'display:none';?>">

		<div class="form-group">
		  <label for="pinterest_username" class="col-sm-2 control-label">Select Image</label>
		  <div class="col-sm-4">

		  <div class="input-group">
		        <input class="form-control" id="upload_image_url" type="text" size="36" name="watermark_image_url" value="<?php echo $watermark_settings['watermark_image_url'];?>" />
		        <span class="input-group-btn">
		          <button id="wpbeautify_watermark_uploadimg" class="btn btn-default" type="button"><span class="glyphicon glyphicon-upload"></span> Select Image</button>
		        </span>

		      </div><!-- /input-group -->
	    		<span class="help-block">Enter the image URL or select an image from the WordPress Gallery</span>

	 			<br/>
			  <img id="img_watermark_preview" src="<?php echo $watermark_settings['watermark_image_url'];?>" style="max-width:300px;max-height:300px">
		  </div>
		</div>
		</div> <!-- end of image settings -->

	  <div class="form-group">
	    <label for="" class="col-sm-2 control-label">Position</label>
	    <div class="col-sm-4">
	      <table  id="wpbeautify_watermark_position" class="table table-bordered">
	      	<tbody><tr>
	      			<td title="Top left">
	      				<input type="radio" value="top_left" name="watermark_position" <?php checked($watermark_settings['watermark_position'], 'top_left');?>>
	      			</td>

	      			<td title="Top center">
	      				<input type="radio" value="top_center" name="watermark_position" <?php checked($watermark_settings['watermark_position'], 'top_center');?>>
	      			</td>

	      			<td title="Top right">
	      				<input type="radio" value="top_right" name="watermark_position" <?php checked($watermark_settings['watermark_position'], 'top_right');?>>
	      			</td>
	      											</tr>
	      										<tr>

	      			<td title="Middle left">
	      				<input type="radio" value="middle_left" name="watermark_position" <?php checked($watermark_settings['watermark_position'], 'middle_left');?>>
	      			</td>

	      			<td title="Middle center">
	      				<input type="radio" value="middle_center" name="watermark_position" <?php checked($watermark_settings['watermark_position'], 'middle_center');?>>
	      			</td>

	      			<td title="Middle right">
	      				<input type="radio"  value="middle_right" name="watermark_position" <?php checked($watermark_settings['watermark_position'], 'middle_right');?>>
	      			</td>
	      											</tr>
	      										<tr>

	      			<td title="Bottom left">
	      				<input type="radio" value="bottom_left" name="watermark_position" <?php checked($watermark_settings['watermark_position'], 'bottom_left');?>>
	      			</td>

	      			<td title="Bottom center">
	      				<input type="radio" value="bottom_center" name="watermark_position" <?php checked($watermark_settings['watermark_position'], 'bottom_center');?>>
	      			</td>

	      			<td title="Bottom right">
	      				<input type="radio" value="bottom_right" name="watermark_position" <?php checked($watermark_settings['watermark_position'], 'bottom_right');?>>
	      			</td>
	      		</tr>
	      	</tbody></table>
	    </div>
	  </div>

	  <div class="form-group">
	    <label for="pinterest_username" class="col-sm-2 control-label">Offset</label>
	    <div class="col-sm-3">
	    <label for="pinterest_username" class="col-sm-5 control-label">Horizontal</label>

	    	<div class="input-group">
	      		<input type="text" style="" size="3" value="<?php echo $watermark_settings['watermark_offset_x'];?>" name="watermark_offset_x" class="form-control wpbtfy-spinner">
	      	<span class="input-group-addon">px</span>
	      </div>
	      <br/>
	    <label for="pinterest_username" class="col-sm-5 control-label">Vertical</label>

	      	<div class="input-group">
	        		<input type="text" style="" size="3" value="<?php echo $watermark_settings['watermark_offset_y'];?>" name="watermark_offset_y" class="form-control wpbtfy-spinner">
	        	<span class="input-group-addon">px</span>

	        </div>

	    </div>
	  </div>

	  </div>





			<input type="hidden" name="wpbeautify_update_images" value="1" />

		  <div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" class="btn btn-primary" name="submit-button-3" value="1"><span class="glyphicon glyphicon-ok"></span> Save all Changes</button>
		    </div>
		  </div>
	  </div>
</div>
		  <?php if ( !ckala_is_pro() ) echo '</div>'; ?>
		  <input type="hidden" name="ie11sux" id="ie11sux" value="<?php echo md5(microtime()."ie11sux"); ?>"/>
		</form>
			</div>
		</div>
	</div>
<?php
}


function wpbeautify_sort_by_order( $a, $b ) {
	return $a['order'] - $b['order'];
}

function wpbeautify_image_sites_settings( $wpbeautify_sites ) {
	$str_ret = '<ul style="" class="wpbeautify_sortable" id="wpbeautify_sites_list"> '; //id="searchstrings-list" class="menu ui-sortable">
	foreach ( $wpbeautify_sites as $key => $site ) {
		$str_ret .= '<li class=""><div class="wpbeautify_moreoptions metabox-holder">
			<div  class="meta-box-sortables">
			<div  class="wpbeautify_advanced_options postbox';
		if ( !isset( $site['details']['validapi'] ) || ( !isset( $site['details']['api_key'] ) ) || empty( $site['details']['api_key'] ) )
			$str_ret .= ' closed';
		else if ( 0 == $site['details']['validapi'] )
				$str_ret .= ' open';
			else
				$str_ret .= ' closed';

			$str_ret .= ' ">
			<h4 class="hndle" style="padding-left:15px">
			<span>'.'<input type="checkbox" id="wpbeautify_checked_'.$site['id'].'" name="wpbeautify_checked_'.$site['id'].'" '.checked( $site['used'], true, 0 ).' value="1"/> <label style="vertical-align:top;" for="wpbeautify_checked_'.$site['id'].'">'.$site['name'].'</label>'.'</span>
			</h4>
			<input class="wpbeautify_order" type="hidden" name="wpbeautify_pos_'.$site['id'].'" value="'.$key.'" />

			';
		$str_ret .= '</div></div></div></li>';

	}

	$str_ret .= '</ul>';
	return $str_ret;
}


function wpbeautify_process_settings_form() {
	$image_settings = wpbeautify_get_image_settings();
// var_dump($_POST['wpbeautify_pixabay_hires']);
// wp_die();
	$old_sites_info = $image_settings['image_sites'];//get_option( 'wpbeautify_image_sites', 0 );

	$site1 =  array(
		'id' => 'pixabay',
		'name' => 'Pixabay',
		'used' => isset( $_POST['wpbeautify_checked_pixabay'] ),
		'order' => isset( $_POST['wpbeautify_pos_pixabay'] ) ? $_POST['wpbeautify_pos_pixabay'] : 1,
		'details' => array (
			'username' => isset( $_POST['wpbeautify_pixabay_username'] ) ? esc_attr( $_POST['wpbeautify_pixabay_username'] ) : '',
			'api_key' =>  isset( $_POST['wpbeautify_pixabay_apikey'] ) ? esc_attr( $_POST['wpbeautify_pixabay_apikey'] ) : '',
			'validapi' => 1/*( $old_sites_info ? $old_sites_info['pixabay']['details']['validapi'] : 0 )*/,
			'ownkey'  => isset( $_POST['wpbeautify_pixabay_ownkey'] ) ? esc_attr( $_POST['wpbeautify_pixabay_ownkey'] ) : 0,
			'hires' => isset( $_POST['wpbeautify_pixabay_hires'] ) ? esc_attr( $_POST['wpbeautify_pixabay_hires'] ) : '',
		)
	);

	/*if ( isset( $_POST['wpbeautify_pixabay_username'] ) && ( isset( $_POST['wpbeautify_pixabay_apikey'] ) ) ) {
		// Pixabay details provided
		if ( ( $old_sites_info['pixabay']['details']['username'] != $_POST['wpbeautify_pixabay_username'] ) || ( $old_sites_info['pixabay']['details']['api_key'] != $_POST['wpbeautify_pixabay_apikey'] ) ) {
			// there is a change, need to re-check
			include_once WPBEAUTIFY_DIR.'/lib/imageapis/pixabay_api.php';
			if ( tsfpix_pixabay_testapikey( $_POST['wpbeautify_pixabay_username'], $_POST['wpbeautify_pixabay_apikey'] ) )
				$site1['details']['validapi'] = 1;
			else
				$site1['details']['validapi'] = 0;
		}
	}*/


	$site2 =  array(
		'id' => 'flickr',
		'name' => 'Flickr',
		'used' => isset( $_POST['wpbeautify_checked_flickr'] ),
		'order' => isset( $_POST['wpbeautify_pos_flickr'] ) ? $_POST['wpbeautify_pos_flickr'] : 2,
		'details' => array (
			'api_key' =>  isset( $_POST['wpbeautify_flickr_apikey'] ) ? esc_attr( $_POST['wpbeautify_flickr_apikey'] ) : '',
			'username' =>  isset( $_POST['wpbeautify_flickr_username'] ) ? esc_attr( $_POST['wpbeautify_flickr_username'] ) : '',
			// 'onlynoattribution' =>  ( isset( $_POST['wpbeautify_flickr_onlynoattribution'] ) ? 1 : 0 ),
			'validapi' => ( $old_sites_info ? $old_sites_info['flickr']['details']['validapi'] : 0 )

		)
	);

	if ( isset( $_POST['wpbeautify_flickr_apikey'] ) ) {
		// flickr details provided
		if ( $old_sites_info['flickr']['details']['api_key'] != $_POST['wpbeautify_flickr_apikey'] ) {
			// there is a change, need to re-check
			include_once WPBEAUTIFY_DIR.'/lib/imageapis/flickr_api.php';
			if ( tsfpix_flickr_testapikey( $_POST['wpbeautify_flickr_apikey'] ) )
				$site2['details']['validapi'] = 1;
			else
				$site2['details']['validapi'] = 0;
		}
	}

	$site3 =  array(
		'id' => 'openclipart',
		'name' => 'Open Clip Art',
		'used' => isset( $_POST['wpbeautify_checked_openclipart'] ),
		'order' => isset( $_POST['wpbeautify_pos_openclipart'] ) ? $_POST['wpbeautify_pos_openclipart'] : 3,
		'details' => array (

		)
	);

	$site4 =  array(
		'id' => 'iamcc',
		'name' => 'Instagram',
		'used' => isset( $_POST['wpbeautify_checked_iamcc'] ),
		'order' => isset( $_POST['wpbeautify_pos_iamcc'] ) ? $_POST['wpbeautify_pos_iamcc'] : 4,
		'details' => array (
		)
	);


	$site5 =  array(
		'id' => 'europeana',
		'name' => 'Europeana',
		'used' => isset( $_POST['wpbeautify_checked_europeana'] ),
		'order' => isset( $_POST['wpbeautify_pos_europeana'] ) ? $_POST['wpbeautify_pos_europeana'] : 5,
		'details' => array (
		)
	);

	
	$site6 =  array(
		'id' => 'ookaboo',
		'name' => 'Ookaboo',
		'used' => isset( $_POST['wpbeautify_checked_ookaboo'] ),
		'order' => isset( $_POST['wpbeautify_pos_ookaboo'] ) ? $_POST['wpbeautify_pos_ookaboo'] : 6,
		'details' => array (
			'apikey' =>  isset( $_POST['wpbeautify_ookaboo_apikey'] ) ? esc_attr( $_POST['wpbeautify_ookaboo_apikey'] ) : '',
			'onlynoattribution' =>  ( isset( $_POST['wpbeautify_ookaboo_onlynoattribution'] ) ? 1 : 0 ),
			'validapi' => 0
		)
	);

	$site7 =  array(
		'id' => 'iconfinder',
		'name' => 'Iconfinder',
		'used' => isset( $_POST['wpbeautify_checked_iconfinder'] ),
		'order' => isset( $_POST['wpbeautify_pos_europeana'] ) ? $_POST['wpbeautify_pos_europeana'] : 7,
		'details' => array (
		)
	);

	$site8 =  array(
		'id' => '500px',
		'name' => '500px',
		'used' => isset( $_POST['wpbeautify_checked_500px'] ),
		'order' => isset( $_POST['wpbeautify_pos_europeana'] ) ? $_POST['wpbeautify_pos_europeana'] : 8,
		'details' => array (
		)
	);

	$site9 =  array(
		'id' => 'wikimedia',
		'name' => 'Wikimedia',
		'used' => isset( $_POST['wpbeautify_checked_wikimedia'] ),
		'order' => isset( $_POST['wpbeautify_pos_europeana'] ) ? $_POST['wpbeautify_pos_europeana'] : 9,
		'details' => array (
		)
	);

	$site10 =  array(
		'id' => 'nasa',
		'name' => 'Nasa',
		'used' => isset( $_POST['wpbeautify_checked_nasa'] ),
		'order' => isset( $_POST['wpbeautify_pos_europeana'] ) ? $_POST['wpbeautify_pos_europeana'] : 10,
		'details' => array (
		)
	);

	$sites_array = array( 'pixabay' => $site1, 
			'flickr' => $site2,
			'openclipart' => $site3,
			'iamcc' => $site4 );

	$pro_sites = array( 'europeana' => $site5,
		'ookaboo' => $site6,
		'iconfinder' => $site7,
		'500px' => $site8,
		'wikimedia' => $site9,
		'nasa' => $site10
		 );

	if ( ckala_is_pro() )
		$sites_array = array_merge( $sites_array, $pro_sites );
// var_dump($sites_array);

	$image_settings['social_sites']['youzign']['api_key'] = $_POST['wpbeautify_youzign_apikey'];
	$image_settings['social_sites']['youzign']['token'] = $_POST['wpbeautify_youzign_token'];

	$image_settings['social_sites']['dropbox']['app_id'] = $_POST['dropbox_app_id'];
	$image_settings['social_sites']['facebook']['app_id'] = $_POST['facebook_app_id'];
	$image_settings['social_sites']['facebook']['app_secret'] = $_POST['facebook_app_secret'];

	$image_settings['social_sites']['googledrive']['api_key'] = $_POST['googledrive_api_key'];
	$image_settings['social_sites']['googledrive']['client_id'] = $_POST['googledrive_client_id'];

	$image_settings['social_sites']['flickr']['api_key'] = $_POST['wpbeautify_flickr_apikey'];
	// $image_settings['social_sites']['flickr']['api_secret'] = $_POST['wpbeautify_flickr_apisecret'];

	$image_settings['social_sites']['flickr']['username'] = $_POST['wpbeautify_flickr_username'];
	// $image_settings['social_sites']['googleplus']['username'] = $_POST['googleplus_username'];
	$image_settings['social_sites']['pinterest']['username'] = $_POST['pinterest_username'];
	$image_settings['social_sites']['instagram']['api_key'] = $_POST['instagram_api_key'];
	$image_settings['social_sites']['instagram']['api_secret'] = $_POST['instagram_api_secret'];

	$image_settings['social_sites']['twitter']['api_key'] = $_POST['twitter_api_key'];
	$image_settings['social_sites']['twitter']['api_secret'] = $_POST['twitter_api_secret'];
	$image_settings['social_sites']['twitter']['token'] = $_POST['twitter_token'];
	$image_settings['social_sites']['twitter']['token_secret'] = $_POST['twitter_token_secret'];


	// update_option( 'wpbeautify_image_sites', $sites_array );
	// $options['']
	$image_settings['image_sites'] = $sites_array;
	// var_dump($image_settings);
	wpbeautify_set_image_settings($image_settings);

	usort( $sites_array, 'wpbeautify_sort_by_order' );
	$array_in_order = array();
	foreach ( $sites_array as $site ) {
		if ( $site['used'] )
			$array_in_order[] = $site['id'];
	}
	update_site_option( 'wpbeautify_sites_in_order', $array_in_order );

	wpbeautify_update_watermark_settings();
}

function wpbeautify_update_watermark_settings() {
	$image_settings = wpbeautify_get_image_settings();

	$array_settings = array();
	$watermark_type = isset( $_POST['watermark_type'] ) ? $_POST['watermark_type'] : 'text';
	$array_settings['watermark_type'] = $watermark_type;

	$watermark_text = isset( $_POST['watermark_text'] ) ? $_POST['watermark_text'] : '';
	$array_settings['watermark_text'] = $watermark_text;

	$watermark_font = isset( $_POST['watermark_font'] ) ? $_POST['watermark_font'] : 'Arial_Black.ttf';
	$array_settings['watermark_font'] = $watermark_font;

	$watermark_text_size = isset( $_POST['watermark_text_size'] ) ? $_POST['watermark_text_size'] : '30';
	$array_settings['watermark_text_size'] = $watermark_text_size;

	$watermark_text_color = isset( $_POST['watermark_text_color'] ) ? $_POST['watermark_text_color'] : '000000';
	$array_settings['watermark_text_color'] = $watermark_text_color;

	$watermark_image_url = isset( $_POST['watermark_image_url'] ) ? $_POST['watermark_image_url'] : 'http://';
	$array_settings['watermark_image_url'] = $watermark_image_url;

/*	$watermark_image_max_w = isset( $_POST['watermark_image_max_w'] ) ? $_POST['watermark_image_max_w'] : '0';
	$array_settings['watermark_image_max_w'] = $watermark_image_max_w;

	$watermark_image_max_h = isset( $_POST['watermark_image_max_h'] ) ? $_POST['watermark_image_max_h'] : '0';
	$array_settings['watermark_image_max_h'] = $watermark_image_max_h;*/

	$watermark_position = isset( $_POST['watermark_position'] ) ? $_POST['watermark_position'] : 'right_bottom';
	$array_settings['watermark_position'] = $watermark_position;

	$watermark_offset_x = isset( $_POST['watermark_offset_x'] ) ? $_POST['watermark_offset_x'] : '0';
	$array_settings['watermark_offset_x'] = $watermark_offset_x;

	$watermark_offset_y = isset( $_POST['watermark_offset_y'] ) ? $_POST['watermark_offset_y'] : '0';
	$array_settings['watermark_offset_y'] = $watermark_offset_y;

	$image_settings['watermark'] = $array_settings;
	wpbeautify_set_image_settings($image_settings);
}


function wpbeautify_site_html( $site ) {
	//var_dump($site);
	$str_ret = '';
	switch ( $site['id'] ) {
	case 'pixabay':
		$str_ret .= wpbeautify_pixabay_settings( $site );
		break;
	case 'flickr':
		$str_ret .= wpbeautify_flickr_settings( $site );
		break;
	case 'iamcc':
	case 'openclipart':
	case 'europeana':
		$str_ret .= 'No settings';
		break;
	case 'ookaboo':
		$str_ret .= wpbeautify_ookaboo_settings( $site );
		break;
	}
	return $str_ret;

}

function wpbeautify_pixabay_settings( $site ) {

	$str_ret = '<table class="wpbeautify_settings_table">
					<tr>
						<th scope="row">Username</th>
						<td><input type="text" class="wpbeautify_settings" name="wpbeautify_pixabay_username" value="'.$site['details']['username'].'" /> </td><td><a target="_blank" href="http://pixabay.com/accounts/register/">Get your API Key here</a></td>
					</tr>
					<tr>
						<th scope="row">API Key</th>
						<td><input type="text" class="wpbeautify_settings" name="wpbeautify_pixabay_apikey" value="'.$site['details']['api_key'].'" /> </td><td></td>
					</tr>';

	if ( !$site['details']['validapi'] && ( !empty( $site['details']['api_key'] ) || !empty( $site['details']['username'] ) ) )
		$str_ret .= '<tr><td class="form-invalid" colspan="3"><b>ERROR:</b> Invalid API KEY</td></tr>';

	$str_ret .= '</table>';

	$str_ret .= '<p><input type="checkbox" value="1" id="wpbeautify_pixabay_hires" name="wpbeautify_pixabay_hires" '.checked( $site['details']['hires'], true, 0 ).'" /> </td>
						<label for="wpbeautify_pixabay_hires">Use High Resolution Images (requires approval from Pixabay)</label></p>';
	return $str_ret;
}

function wpbeautify_flickr_settings( $site ) {
	$str_ret = '<table class="wpbeautify_settings_table">
					<tr>
						<th scope="row">API Key</th>
						<td><input type="text" class="wpbeautify_settings" name="wpbeautify_flickr_apikey" value="'.$site['details']['api_key'].'" /> </td><td><a target="_blank" href="http://www.flickr.com/services/apps/create/apply/">Get your API Key here</a></td>
					</tr>';
	if ( !$site['details']['validapi'] && ( !empty( $site['details']['api_key'] ) ) )
		$str_ret .= '<tr><td class="form-invalid" colspan="3"><b>ERROR:</b> Invalid API KEY</td></tr>';

	$str_ret .= '</table>';

	/*$str_ret .= '<p><input type="checkbox" value="1" id="wpbeautify_flickr_onlynoattribution" name="wpbeautify_flickr_onlynoattribution" '.checked( $site['details']['onlynoattribution'], true, 0 ).'" /> </td>
						<label for="wpbeautify_flickr_onlynoattribution">Only Images with No Attribution Required</label></p>';*/
	return $str_ret;
}

function wpbeautify_ookaboo_settings( $site ) {
	$str_ret = '<table class="wpbeautify_settings_table">
					<tr>
						<th scope="row">API Key</th>
						<td><input class="wpbeautify_settings" type="text" name="wpbeautify_ookaboo_apikey" value="'.$site['details']['api_key'].'" /> </td><td><a target="_blank" href="http://api.ookaboo.com/api1/register_for_api">Get your API Key here</a></td>
					</tr>
	</table>
						<p><input type="checkbox" value="1" id="wpbeautify_ookaboo_onlynoattribution" name="wpbeautify_ookaboo_onlynoattribution" '.checked( $site['details']['onlynoattribution'], true, 0 ).'" /> </td>
						<label for="wpbeautify_ookaboo_onlynoattribution">Only Images with No Attribution Required</label></p>
	';
	return $str_ret;
}

function wpbeautify_panel_video() {
	$image_settings = wpbeautify_get_image_settings();
	$video_settings = $image_settings['video'];

	if (isset($_POST['wpbtfy_update_video_settings'])) {
		$image_settings['video']['logo_img_url'] = $_POST['logo_image_url'];
		$image_settings['video']['logo_position'] = $_POST['logo_position'];
		$image_settings['video']['transparency'] = $_POST['logo_transparency'];

		wpbeautify_set_image_settings($image_settings);
		$video_settings = $image_settings['video'];
	}

	$position = $video_settings['logo_position'];
	if (!$position) $position = 'top_right';
?>
<script>
jQuery( document ).ready(function(  ) {
	wpbeautify_update_logo_preview();

	jQuery('#upload_image_url').change(function( ){
		wpbeautify_update_logo_preview();
	});
});
</script>

	<div class="wrap">
		<img src="<?php echo WPBEAUTIFY_URL;?>/img/logo_medium.png" style="margin-left: 50px;margin-bottom:10px">
		<br/>

		<div class="bootstrap-wpbtfy-wpadmin">
			<div class="container">
				<div class="navbar">
					<div class="navbar-inner">
				        <ol class="breadcrumb">
						  <li><a href="#">FotoPress</a></li>
						  <li class="active">Videos</li>
						</ol>
					</div>
				</div>
				<form method="POST">
					<h3> Logo </h3>

					<div class="well">
						<div class="form-horizontal">
							<div class="form-group">
							  <label for="pinterest_username" class="col-sm-2 control-label">Select Image</label>
							  <div class="col-sm-9">

							  <div class="input-group">
							        <input class="form-control" id="upload_image_url" type="text" size="36" name="logo_image_url" value="<?php echo $video_settings['logo_img_url'];?>" />
							        <span class="input-group-btn">
							          <button id="wpbeautify_watermark_uploadimg" class="btn btn-default" type="button"><span class="glyphicon glyphicon-upload"></span> Select Image</button>
							        </span>

							      </div><!-- /input-group -->
						    		<span class="help-block">Enter the image URL or select an image from the WordPress Gallery</span>

						 			<br/>
								  <!-- <img id="img_watermark_preview" src="<?php echo $video_settings['logo_img_url'];?>" style="max-width:300px;max-height:300px"> -->
							  </div>
							</div>

						  <div class="form-group">
						    <label for="" class="col-sm-2 control-label">Position</label>
						    <div class="col-sm-4">
						      <table  id="wpbeautify_watermark_position" class="table table-bordered">
						      	<tbody><tr>
						      			<td title="Top left">
						      				<input type="radio" value="top_left" name="logo_position" <?php checked($position, 'top_left');?>>
						      			</td>


						      			<td title="Top right">
						      				<input type="radio" value="top_right" name="logo_position" <?php checked($position, 'top_right');?>>
						      			</td>
						      											</tr>

						      										<tr>

						      			<td title="Bottom left">
						      				<input type="radio" value="bottom_left" name="logo_position" <?php checked($position, 'bottom_left');?>>
						      			</td>


						      			<td title="Bottom right">
						      				<input type="radio" value="bottom_right" name="logo_position" <?php checked($position, 'bottom_right');?>>
						      			</td>
						      		</tr>
						      	</tbody></table>
						    </div>
						    <div class="col-sm-5">
						    	<div class="wpbtfy_video_preview">
						    		<img id="video-preview-logo" src="<?php echo $video_settings['logo_img_url'];?>" />
						    	</div>
						    </div>
						  </div>

						  <div class="form-group">
						    <label for="" class="col-sm-2 control-label">Transparency</label>
						    <div class="col-sm-4">
							    <div class="input-group" style="width:100px">
							      <input type="text" class="form-control" id="logo_transparency" name="logo_transparency" value="<?php echo $video_settings['transparency'];?>">
							      <span class="input-group-addon">%</span>
							    </div>

						    </div>

						  </div>

						  <br/>
						  <div class="form-group">
						    <div class="col-sm-offset-2 col-sm-10">
						      <button type="submit" class="btn btn-primary" name="submit-button-4" value="1"><span class="glyphicon glyphicon-ok"></span> Save all Changes</button>
						    </div>
						  </div>

						  </div>

					</div> <!-- well -->

					<!--<div class="well">
						<h4> Video Skins </h4>

					</div> -->
					<input type="hidden" name="wpbtfy_update_video_settings" value="1" />
				</form>
			</div>
		</div>
	</div>
<?php
}

function wpbeautify_panel_help() {
?>
	<div class="wrap">
		<img src="<?php echo WPBEAUTIFY_URL;?>/img/logo_medium.png" style="margin-left: 50px;margin-bottom:10px">
		<br/>

		<div class="bootstrap-wpbtfy-wpadmin">
			<div class="container">
				<div class="navbar">
					<div class="navbar-inner">
				        <ol class="breadcrumb">
						  <li><a href="#">FotoPress</a></li>
						  <li class="active">Help</li>
						</ol>
					</div>
				</div>
				<?php if( !ckala_is_pro() ) fotopress_upgrade_pro(); ?>
				<div class="well" style="font-size:1.3em">
					<p><strong>Video : First Steps to getting lots of images in your search</strong></p>
					<iframe width="640" height="360" src="https://www.youtube.com/embed/tVcFt6cNHt8?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe><br/><br/>

					<?php if (ckala_is_pro()) { ?>
					<p><strong>Video : How to use the FotoPress Pro Image Editor</strong></p>
					<iframe width="640" height="360" src="https://www.youtube.com/embed/j0fauOX2yrc?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe><br/><br/>

					<p><strong>Video : How to use the FotoPress Pro Font Options</strong></p>
					<iframe width="640" height="360" src="https://www.youtube.com/embed/Us5fG2FIeJE?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe><br/><br/>

					<p><strong>Video : How to use the FotoPress Pro Video Options</strong></p>
					<iframe width="640" height="360" src="https://www.youtube.com/embed/XqvI6IlFnDQ?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe><br/><br/>

					You can download your user manual <a href="http://www.wpbeautify.com/imnews/fotopress-pro-manual" target="_blank">here</a>
					<br/><br/>
					More help getting your API keys <a href="http://www.wpbeautify.com/imnews/fotopress-pro-apikeys" target="_blank">here</a>
					<?php } else { ?>

					<p><strong>Video : How to use the FotoPress Image Editor</strong></p>
					<iframe width="640" height="360" src="https://www.youtube.com/embed/EvOKjKegRg8?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe><br/><br/>

					You can download your user manual <a href="http://www.wpbeautify.com/imnews/fotopress-manual" target="_blank">here</a>
					<br/><br/>
					More help getting your API keys <a href="http://www.wpbeautify.com/imnews/fotopress-apikeys" target="_blank">here</a>
					<?php } ?>

					<br/><br/>
					If you have any questions, please open a ticket in our <a href="http://support.kudosinteractive.com" target="_blank">support desk</a>
				</div>
				
			</div>
		</div>
	</div>
<?php


}

function wpbeautify_panel_other_settings() {
?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"></div><h2>Settings</h2>

		<div class="bootstrap-wpbtfy-wpadmin">
			<div class="container">
						<div class="navbar">
							<div class="navbar-inner">
						        <ol class="breadcrumb">
								  <li><a href="#">FotoPress</a></li>
								  <li class="active">Settings</li>
								</ol>
							</div>
						</div>





<h3 id="forms" class="page-header">Social Media Share Icons</h3>

<form class="form-horizontal" role="form" method="post">


  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Choose a Set</label>
    <div class="col-sm-4">
            <select class="form-control">
  <option>Set 1</option>
  <option>Set 2</option>
  <option>Set 3</option>
  <option>Set 4</option>
  <option>Set 5</option>
</select>
    </div>
  </div>
  <div class="form-group">

    <label class="col-sm-2 control-label"></label>
    <div class="col-sm-4">

	<img src="<?php echo WPBEAUTIFY_URL;?>/assets/social-media/2/facebook.png"  style="width:32px" />
	<img src="<?php echo WPBEAUTIFY_URL;?>/assets/social-media/2/twitter.png"  style="width:32px" />
	<img src="<?php echo WPBEAUTIFY_URL;?>/assets/social-media/2/googleplus.png"  style="width:32px" />
	<img src="<?php echo WPBEAUTIFY_URL;?>/assets/social-media/2/pinterest.png"  style="width:32px" />
	<img src="<?php echo WPBEAUTIFY_URL;?>/assets/social-media/2/linkedin.png"  style="width:32px" />
	<br/><br/>

	<img src="<?php echo WPBEAUTIFY_URL;?>/assets/social-media/1/facebook.png"  style="width:32px" />
	<img src="<?php echo WPBEAUTIFY_URL;?>/assets/social-media/1/twitter.png"  style="width:32px" />
	<img src="<?php echo WPBEAUTIFY_URL;?>/assets/social-media/1/googleplus.png"  style="width:32px" />
	<img src="<?php echo WPBEAUTIFY_URL;?>/assets/social-media/1/pinterest.png"  style="width:32px" />
	<img src="<?php echo WPBEAUTIFY_URL;?>/assets/social-media/1/linkedin.png"  style="width:32px" />
</div>
</div>

  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Show on</label>
    <div class="col-sm-4">
<div class="checkbox">
  <label>
    <input type="checkbox" value="">
    Posts
  </label>
</div>

<div class="checkbox">
  <label>
    <input type="checkbox" value="">
    Pages
  </label>
</div>

<div class="checkbox">
  <label>
    <input type="checkbox" value="">
    Archives
  </label>
</div>

<div class="checkbox">
  <label>
    <input type="checkbox" value="">
    Category
  </label>
</div>

  </div>
    </div>

  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Display</label>
    <div class="col-sm-4">
<div class="checkbox">
  <label>
    <input type="checkbox" value="">
    Before the content
  </label>
</div>

<div class="checkbox">
  <label>
    <input type="checkbox" value="">
    After the content
  </label>
</div>
</div>
</div>

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-primary" name="submit-button-5" value="1"><span class="glyphicon glyphicon-ok"></span> Save Changes</button>
    </div>
  </div>


</form>

			</div>
		</div>
	</div>
<?php
}


/* WP Admin Dashboard */

function canvakala_update_feed_quickly( $seconds ) {
  return 2;
}

function canvakala_dashboard_widget_function() {
	// add_filter( 'wp_feed_cache_transient_lifetime' , 'canvakala_update_feed_quickly' );
	$rss = fetch_feed( "http://www.wpbeautify.com/imnews/custom-feed/" );
	// remove_filter( 'wp_feed_cache_transient_lifetime' , 'canvakala_update_feed_quickly' );

    if ( is_wp_error($rss) ) {
          if ( is_admin() || current_user_can('manage_options') ) {
               echo '<p>';
               printf(__('<strong>RSS Error</strong>: %s'), $rss->get_error_message());
               echo '</p>';
          }
     return;
	}

	if ( !$rss->get_item_quantity() ) {
	     echo '<p>Apparently, there are no updates to show!</p>';
	     $rss->__destruct();
	     unset($rss);
	     return;
	}

	echo "<ul>\n";

	if ( !isset($items) )
	     $items = 3;

	     foreach ( $rss->get_items(0, $items) as $item ) {
	          $publisher = '';
	          $site_link = '';
	          $link = '';
	          $content = '';
	          $date = '';
	          $link = esc_url( strip_tags( $item->get_link() ) );
	          $title = esc_html( $item->get_title() );
	           $cat = $item->get_item_tags('', 'thumbnail');
	     	// echo '<pre>';
	     	// print_r($item);
	     	// print_r($item);
	     	// print_r($cat);
	     	// $enclosure = $item->get_enclosure();
	     	// var_dump($enclosure);
	     	// print_r($enclosure->get_thumbnail());
	     	// echo '</pre>';

	           $thumbnail_img = $cat[0]['data'];
	          $content = $item->get_content();
	          $content = wp_html_excerpt($content, 300, '[...]');
	          $content .= "<p style='text-align:right'><a href='$link'  target='_blank'>Learn More</a></p>";

	         echo "<li>
	         	<div style='float:left;width:18%;margin-right:4%;display:block;padding-top:4px'><a href='$link' target='_blank'><img src='".$thumbnail_img."' style='width:100%;height:auto' /></a></div>
	         	<div style='float:left;width:78%'><a class='rsswidget' href='$link' target='_blank'>$title</a>\n<div class='rssSummary'>$content</div></div>
	         	<div class='clear'></div>
	         	</li>\n<li><hr/></li>";
	}

	echo "</ul><div style='clear:both'></div>\n";
	$rss->__destruct();
	unset($rss);
}

function canvakala_add_dashboard_widget() {
     // wp_add_dashboard_widget('rmi353-dashboard-widget', 'Recommended Internet Marketing Tools', 'canvakala_dashboard_widget_function');
     add_meta_box('rmi353-dashboard-widget', 'Recommended Internet Marketing Tools', 'canvakala_dashboard_widget_function', 'dashboard', 'side', 'high');
}

// add_action('wp_dashboard_setup', 'canvakala_add_dashboard_widget');
// add_action('wp_user_dashboard_setup', 'canvakala_add_dashboard_widget');
// add_action('wp_newtwork_dashboard_setup', 'canvakala_add_dashboard_widget');

?>