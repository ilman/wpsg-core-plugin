<?php 

// don't load directly
if (!defined('ABSPATH')) die('-1');

class VCWPSGImageLinkBlockAddons
{
	public $shortcode_slug = 'sg_image_link_block';

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
			'name' => 'WPSG Image Link Block',
			'base' => $this->shortcode_slug,
			'category' => 'WPSG',
			'icon' => plugins_url('assets/favicon.png', __DIR__),
			'weight' => 9,
			
			'params' => array(

				array(
					'type' => 'textfield',
					'heading' => 'Title',
					'param_name' => 'title',
					'admin_label' => true,
				),

				// array(
				// 	'type' => 'textfield',
				// 	'heading' => 'Title Tag',
				// 	'param_name' => 'title_tag',
				// 	'admin_label' => true,
				// ),

				array(
					'type' => 'attach_image',
					'heading' => 'Image',
					'param_name' => 'image',
					'value' => '',
					'description' => 'Select image from media library.',
					'admin_label' => true
				),

				array(
					'type' => 'textfield',
					'heading' => 'Link URL',
					'param_name' => 'url',
					'admin_label' => true,
				),

				array(
					'type' => 'textarea_html',
					'heading' => 'Content',
					'param_name' => 'content',
					'value' => '',
					'description' => 'Enter your content.',
					'holder' => 'div',
					'class' => '',
				),

				wpsg_vc_template_field($this->shortcode_slug),

				// backward compatibility. since 4.6
				array(
					'type' => 'hidden',
					'param_name' => 'img_link_large',
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
			'title_tag' => 'h4',
			'image' => '',
			'image_size' => '',
			'subtitle' => '',
			'url' => '',
			'class' => '',
			'id' => '',
			'style' => '',
			'template' => 'default',
		), $attr));

		$template = ($template) ? $template : 'default';

		$class = trim('sg-image-link-block '.$class);
		// $class = ($content) ? trim($class.' with-content') : trim($class.' no-content');
		$class = trim($class.' '.$template);

		// set default template file
		$template_paths = wpsg_shortcode_template_paths($this->shortcode_slug, $template, __FILE__);
		
		$output = include(wpsg_core_plugin_path().'/output.php');

		return $output;
	}

}
// Finally initialize code
new VCWPSGImageLinkBlockAddons();