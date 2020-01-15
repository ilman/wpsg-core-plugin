<?php 

$template_path = $template_paths['template_path'];
$template_theme_path = $template_paths['template_theme_path'];
$template_plugin_path = $template_paths['template_plugin_path'];

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

if($template_path){
	ob_start();
	include($template_path);
	$output = ob_get_clean();
}
else{
	$output = '<p>'.str_ireplace(realpath(WP_CONTENT_DIR), '', 'template '.$template_theme_path.' or '.$template_plugin_path.' not found').'</p>';
}

return $output;