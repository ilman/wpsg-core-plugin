<?php 

// don't load directly
if (!defined('ABSPATH')) die('-1');

class VCWPSGCarouselsAddons
{
	public $shortcode_slug = 'wpsg_carousels';

	function __construct()
	{
		// We safely integrate with VC with this hook
		add_action('init', array($this, 'integrateWithVC'));
		add_shortcode($this->shortcode_slug, array($this, 'shortcode'));
	}

	public function integrateWithVC() 
	{
		// Check if Visual Composer is installed
		if(!defined('WPB_VC_VERSION')){ return; }

		// if(class_exists('WPBakeryShortCode')){
		// 	include(__DIR__.'/vc_carousels_class.php');
		// }
		
		vc_map(array(
			'name' => 'WPSG Carousels',
			'base' => $this->shortcode_slug,
			'category' => 'WPSG',
			'icon' => plugins_url('assets/favicon.png', __DIR__),
			'weight' => 9,

			'as_parent' 	=> array('only' => 'wpsg_carousel_item'),
			'content_element' => true,
			'is_container' => true,
			'show_settings_on_create' => false,
			// 'js_view' => 'VcWPSGCarouselsView',
			'js_view' => 'VcColumnView',
			'class' => 'vc_wpsg_container',

			'default_content' => '[wpsg_carousel_item][/wpsg_carousel_item]',

			'params' => array(

				array(
					'type' 			=> 	'vc_number',
					'heading' 		=> 	'Columns On Desktop',
					'edit_field_class' => 'vc_col-sm-4 vc_padding-top',
					'param_name' 	=> 	'cols',
					'value'			=>	'4',
					'admin_label' => true,
				),
				array(
					'type' 			=> 	'vc_number',
					'heading' 		=> 	'Columns On Tablet',
					'edit_field_class' => 'vc_col-sm-4 vc_padding-top',
					'param_name' 	=> 	'cols_sm',
					'value'			=>	'4',
					'admin_label' => true,
				),
				array(
					'type' 			=> 	'vc_number',
					'heading' 		=> 	'Columns On Mobile',
					'edit_field_class' => 'vc_col-sm-4 vc_padding-top',
					'param_name' 	=> 	'cols_xs',
					'value'			=>	'1',
					'admin_label' => true,
				),

				array(
					'type' => 'textfield',
					'heading' => 'Class',
					'param_name' => 'class',
					'admin_label' => true,
					'group' => 'Attributes',
				),

				array(
					'type' => 'textfield',
					'heading' => 'ID',
					'param_name' => 'id',
					'admin_label' => true,
					'group' => 'Attributes',
				),

				array(
					'type' => 'css_editor',
					'heading' => esc_html__( 'CSS Box', 'js_composer' ),
					'param_name' => 'css',
					'group' => esc_html__( 'Design Options', 'js_composer' ),
				),

			),
		));
	}

	public function shortcode($attr=array(), $content=null)
	{
		// extract the attributes into variables
		extract(shortcode_atts(array(
			'cols' => 4,
			'cols_sm' => 3,
			'cols_xs' => 1,
			'class' => '',
			'id' => '',
			'style' => '',
			'template' => 'default',
		), $attr));

		$template = ($template) ? $template : 'default';

		$class = trim('wpsg-carousels '.$class);
		// $class = ($content) ? trim($class.' with-content') : trim($class.' no-content');
		$class = trim($class.' '.$template);

		// set default template file
		$template_paths = wpsg_shortcode_template_paths($this->shortcode_slug, $template, __FILE__);
		
		$output = include(wpsg_core_plugin_path().'/output.php');

		return $output;
	}

}
// Finally initialize code
new VCWPSGCarouselsAddons();