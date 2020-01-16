<?php
/**
 * @package WPSG_Core
 * @version 2.0
 */
/*
Plugin Name: WPSG Core
Plugin URI: https://github.com/ilman/wpsg-core-plugin
Description: Enables most shortcodes, plugins and custom post types used in WPSG theme framework.
Author: Ilman Maulana
Version: 2.0
*/

function wpsg_core_plugin_path(){
	return plugin_dir_path(__FILE__);
}

/*
 * Allow shortcode template to be changed from plugin or template
 */
function wpsg_shortcode_template_paths($key, $template='default', $base_path=null){
	if(!$base_path){
		$base_path = __FILE__;
		$base_dir = $base_path;
	}
	else{
		$base_dir = dirname($base_path);
	}

	// set default template file
	$template_plugin_path = dirname($base_dir).'/templates/'.$key.'_'.$template.'.php';
	$template_theme_path = realpath(get_stylesheet_directory()).'/'.basename(dirname($base_dir)).'/'.$key.'_'.$template.'.php';

	// set template file to be either from theme or plugin
	if(file_exists($template_theme_path)){
		$template_path = $template_theme_path;
	}
	elseif(file_exists($template_plugin_path)){
		$template_path = $template_plugin_path;
	}
	else{
		$template_path = '';
	}

	return array(
		'template_plugin_path' => $template_plugin_path,
		'template_theme_path' => $template_theme_path,
		'template_path' => $template_path,
	);
}

if(!function_exists('wpsg_get_template_files')){
	function wpsg_get_template_files($key, $base_path=''){
		if(!$base_path){
			$base_path = __FILE__;
		}
		$base_dir = dirname($base_path);

		// set default template file
		$template_paths = wpsg_shortcode_template_paths('sg_multi_list');

		// set default template file
		$template_plugin_path = dirname($template_paths['template_plugin_path']);
		$template_theme_path = dirname($template_paths['template_theme_path']);

		$result = array();

		// template plugin files
		if(file_exists($template_plugin_path)){
			$files = scandir($template_plugin_path);

			foreach($files as $file){
				if(stripos($file, $key.'_') !== false){
					// $file = substr($file, stripos($file, $key));
					$file = str_replace([$key.'_', '.php'], '', $file);
					$result[] = $file;
				}
			}
		}

		// template theme files
		if(file_exists($template_theme_path)){
			$files = scandir($template_theme_path);
			foreach($files as $file){
				if(stripos($file, $key.'_') !== false){
					// $file = substr($file, stripos($file, $key));
					$file = str_replace([$key.'_', '.php'], '', $file);
					$result[] = $file;
				}
			}
		}

		return $result;
	}
}

if(!function_exists('wpsg_vc_template_field')){
	function wpsg_vc_template_field($key, $params=array()){
		$options = array();

		if(isset($params['excludes'])){
			if(is_string($params['excludes'])){
				$params['excludes'] = explode(',', $params['excludes']);
			}
		}

		foreach(wpsg_get_template_files($key) as $row){
			if(isset($params['excludes']) && $params['excludes']){
				$is_excluded = false;

				foreach($params['excludes'] as $exclude){
					$exclude = trim($exclude);

					if(stripos($row, $exclude) === 0){
						$is_excluded = true;
						break;
					}
				}

				if($is_excluded){
					continue;
				}
			}
			$options[$row] = ($row=='default') ? '' : $row;
		}

		sort($options);

		return array(
			'type' => 'dropdown',
			'heading' => 'Template',
			'param_name' => 'template',
			'admin_label' => true,
			'value' => $options,
		);
	}
}

require_once('includes/init.php');

require_once('framework/includes/SG_Util.php');
require_once('framework/includes/WPSG_Helpers_Lite.php');

require_once('framework/plugins/sg_popular_posts/sg_popular_posts.php');
require_once('framework/plugins/sg_related_posts/sg_related_posts.php');
require_once('framework/plugins/sg_user_avatar/sg_user_avatar.php');

require_once('shortcodes/sg_sc_framework.php');
require_once('shortcodes/sg_sc_framework_block.php');
require_once('shortcodes/sg_sc_framework_list.php');
require_once('shortcodes/sg_sc_post.php');
require_once('shortcodes/sg_sc_post_list.php');
require_once('shortcodes/sg_sc_wp.php');

require_once('framework/custom_post_types/sg_cpt_snippet.php');


require_once('visual_composer/vc.php');
$includes = array('vc_number_param','vc_heading','vc_btn','vc_icon_block','vc_image_block','vc_carousels','vc_carousel_item','vc_multi_list','vc_multi_list_item','vc_faqs','vc_faq_item','vc_shortcode');
foreach($includes as $file){
	$file = __DIR__.'/visual_composer/'.$file.'.php';
	if(!file_exists($file)){ continue; }
	require_once($file);
}
