<?php 

// don't load directly
if (!defined('ABSPATH')) die('-1');

class VCWPSGShortcodeAddons
{
	public $shortcode_slug = 'wpsg_shortcode';

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
			'name' => 'WPSG Shortcode',
			'base' => $this->shortcode_slug,
			'category' => 'WPSG',
			'icon' => plugins_url('../assets/favicon.png', __FILE__),
			'params' => array(
				

				array(
					'type' => 'textarea',
					'heading' => 'Content',
					'param_name' => 'content',
					'value' => '[shortcode]',
					'description' => 'Enter your content.',
					'holder' => 'div',
					'class' => '',
				),

				array(
					'type' => 'textfield',
					'heading' => 'Class',
					'param_name' => 'class',
					'description' => 'Style particular content element differently - add a class name and refer to it in custom CSS.',
				),

			),
		));
	}

	public function shortcode($attr=array(), $content=null)
	{
		// extract the attributes into variables
		extract(shortcode_atts(array(
			'class' => '',
		), $attr));

		$class = trim('wpsg-shortcode '.$class);

		$output = '<div class="'.$class.'">
			'.do_shortcode($content).'
		</div>';

		return $output;
	}

}
// Finally initialize code
new VCWPSGShortcodeAddons();