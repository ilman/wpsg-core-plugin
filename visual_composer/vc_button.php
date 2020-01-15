<?php 

/*
	More info: http://kb.wpbakery.com/index.php?title=Vc_map
*/

if(!class_exists('VCTUIButtonAddons')){
	class VCTUIButtonAddons {
		function __construct()
		{
			// We safely integrate with VC with this hook
			add_action('init', array($this, 'integrateWithVC'));

			add_shortcode('tui_btn', array($this, 'shortcode'));
			add_shortcode('tui_btn', array($this, 'shortcode'));
		}

		public function integrateWithVC() 
		{
			// Check if Visual Composer is installed
			if(!defined('WPB_VC_VERSION')) {
				return;
			}
			
			vc_map(array(
				'name' => 'TUI Button',
				'base' => 'tui_btn',
				'category' => 'TUI',
				'icon' => plugins_url('../assets/favicon.png', __FILE__),
				'params' => array(
					
					array(
						'type' => 'textfield',
						'heading' => 'Text',
						'param_name' => 'content',
						'holder' => 'div',
					),

					array(
						'type' => 'textfield',
						'heading' => 'URL',
						'param_name' => 'url',
						'admin_label' => true
					),

					array(
						'type' => 'textfield',
						'heading' => 'Extra Class Name',
						'param_name' => 'class',
						'description' => 'Style particular content element differently - add a class name and refer to it in custom CSS.',
					),

					array(
						'type' => 'textfield',
						'heading' => 'Container Class Name',
						'param_name' => 'container_class',
					),

					// backward compatibility. since 4.6
					array(
						'type' => 'hidden',
						'param_name' => 'img_link_large',
					),

				),
			));
		}

		public function shortcode($attr=array(), $content=null)
		{
			// extract the attributes into variables
			extract(shortcode_atts(array(
				'container_class' => '',
				'class' => 'btn-primary',
				'url' => '',
			), $attr));

			if(strpos($url, '//') === false){
				if(strpos($url,'/') === 0){
					$url = site_url().$url;
				}
			}

			if($url){
				$url = 'href="'.$url.'"';
			}

			$class = trim('btn tui-btn '.$class);

			$output = '<a class="'.$class.'" '.$url.'>'.do_shortcode($content).'</a>';

			if($container_class){
				$output = '<div class="'.$container_class.'">'.$output.'</div>';
			}

			return $output;
		}
	}
}


// Finally initialize code
new VCTUIButtonAddons();