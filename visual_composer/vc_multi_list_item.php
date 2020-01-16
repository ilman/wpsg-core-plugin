<?php 

// don't load directly
if (!defined('ABSPATH')) die('-1');

class VCWPSGMultiListItemAddons
{
	public $shortcode_slug = 'sg_multi_list_item';

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
		
		vc_map(array(
			'name' => 'WPSG Multi List Item',
			'base' => $this->shortcode_slug,
			'category' => 'WPSG',
			'icon' => plugins_url('assets/favicon.png', __DIR__),

			'as_child' 		=> array('only' => 'sg_multi_list'),
			'content_element' => true,
			'is_container' => true,
			'show_settings_on_create' => false,
			'js_view' => 'VcColumnView',
			'class' => 'vc_wpsg_container',

			'params' => array(

				array(
					'type' => 'textfield',
					'heading' => 'Title',
					'param_name' => 'title',
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
			'title' => '',
			'class' => '',
			'template' => '',
		), $attr));

		$template = ($template) ? $template : 'default';

		$class = trim('sg-multi-list-item '.$class);
		// $class = ($content) ? trim($class.' with-content') : trim($class.' no-content');
		$class = trim($class.' '.$template);

		// set default template file
		$template_paths = wpsg_shortcode_template_paths($this->shortcode_slug, $template, __FILE__);
		
		$output = include(wpsg_core_plugin_path().'/output.php');

		return $output;
	}

}
// Finally initialize code
new VCWPSGMultiListItemAddons();