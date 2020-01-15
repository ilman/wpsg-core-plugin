<?php 

use WPSG_Core\SG_Util;

function sc_sg_post_title($attr=array()){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'tag' => '',
		'link' => '',
		'class' => '',
		'style' => '',
	), $attr));
	
	$param_class = 'class="'.$class.'"';
	$param_style = 'style="'.$style.'"';
	$param_link = ' href="'.get_the_permalink().'"';

	$output = get_the_title();

	if($link){
		$output = '<a'.$param_link.'>'.$output.'</a>';
	}

	if($tag){
		$output = "<".trim("$tag $param_class $param_style").">".$output."</$tag>";
	}

	return $output;
}
add_shortcode('sg_post_title', 'sc_sg_post_title');




function sc_sg_post_permalink(){
	return get_the_permalink();
}
add_shortcode('sg_post_permalink', 'sc_sg_post_permalink');



function sc_sg_post_content(){

	ob_start();
	the_content();
	$output = ob_get_clean();
	
	return $output;
}
add_shortcode('sg_post_content', 'sc_sg_post_content');



function sc_sg_post_excerpt(){
	return get_the_excerpt();
}
add_shortcode('sg_post_excerpt', 'sc_sg_post_excerpt');




function sc_sg_post_image($attr=array()){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'size' => ''
	), $attr));

	return sg_get_post_thumbnail($size); 
}
add_shortcode('sg_post_image', 'sc_sg_post_image');




function sc_sg_post_meta($attr=array()){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'key' => '',
		'default' => ''
	), $attr));

	$output = get_post_meta(get_the_ID(), $key, true);

	if(!$output){
		$output = $default;
	}

	return do_shortcode($output);
}
add_shortcode('sg_post_meta', 'sc_sg_post_meta');