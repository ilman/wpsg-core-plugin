<?php 

// don't load directly
if (!defined('ABSPATH')) die('-1');

class VCWPSGMultiListAddons
{
	public $shortcode_slug = 'sg_multi_list';

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
			'name' => 'WPSG Multi List',
			'base' => $this->shortcode_slug,
			'category' => 'WPSG',
			'icon' => plugins_url('assets/favicon.png', __DIR__),
			'weight' => 9,

			'as_parent' 	=> array('only' => 'sg_multi_list_item'),
			'content_element' => true,
			'is_container' => true,
			'show_settings_on_create' => false,
			'js_view' => 'VcColumnView',
			'class' => 'vc_wpsg_container',

			'params' => array(

				wpsg_vc_template_field($this->shortcode_slug, ['excludes'=>'item']),

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
			'class' => '',
			'id' => '',
			'template' => '',
		), $attr));

		$template = ($template) ? $template : 'default';

		$class = trim('sg-multi-list '.$class);
		// $class = ($content) ? trim($class.' with-content') : trim($class.' no-content');
		$class = trim($class.' '.$template);

		// set default template file
		$template_paths = wpsg_shortcode_template_paths($this->shortcode_slug, $template, __FILE__);

		// setup
		global $multi_list_id;
		global $multi_list_item_id;
		if(!isset($multi_list_id) || !$multi_list_id){
			$multi_list_id = 0;
		}
		$multi_list_id++;
		$multi_list_item_id = 0;

		preg_match_all('/\[sg_multi_list_item [^\]]*?title="([^\"]+?)"\]/', $content, $matches);

		$titles = array();
		if(isset($matches[1]) && $matches[1]){
			$titles[] = $matches[1];
		}

		preg_match_all('/\[sg_multi_list_item [^\]]*?template="([^\"]+?)"\]/', $content, $matches);

		if(isset($matches[1]) && $matches[1]){
			$content = preg_replace('/template="[^\"]+"/', 'template="'.$template.'"', $content);
		}
		else{
			$content = str_replace('[sg_multi_list_item', '[sg_multi_list_item template="'.$template.'"', $content);
		}
		// end setup
		
		$output = include(wpsg_core_plugin_path().'/output.php');

		return $output;
	}

}
// Finally initialize code
new VCWPSGMultiListAddons();