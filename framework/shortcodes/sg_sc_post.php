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



function sc_sg_post_list($attr=array(), $content=null){
	global $post;

	$temp_post = $post;

	// extract the attributes into variables
	extract(shortcode_atts(array(
		'post_type' => 'post',
		'limit'	=> get_option('posts_per_page', 10),
		'offset' => 0,
		'order_by' => 'ID',
		'order' => 'asc',
		'list' => 'default',
		'class' => '',
		'item_rel' => '',
		'style' => '',
		'col_width' => 4,
		'is_single' => false
	), $attr));

	unset($attr['post_type']);
	unset($attr['limit']);
	unset($attr['offset']);
	unset($attr['order']);
	unset($attr['order_by']);
	unset($attr['list']);
	unset($attr['class']);
	unset($attr['item_rel']);
	unset($attr['style']);
	unset($attr['col_width']);

	// map attr
	$param_args = array();
	$param_meta = array();
	$arr_compare = array('=', '!=', '>', '>=', '<', '<=', 'LIKE', 'NOT LIKE', 'IN', 'NOT IN', 'BETWEEN', 'NOT BETWEEN', 'EXISTS', 'NOT EXISTS');
	foreach($attr as $key=>$val){
		if(strpos($key, 'where_meta_')===0){

			$arr_val = explode(' ', $val, 3);
			$arr_val_0 = strtoupper(trim(SG_Util::val($arr_val, 0)));
			$arr_val_1 = strtoupper(trim(SG_Util::val($arr_val, 1)));
			if(in_array($arr_val_0, $arr_compare)){
				$val = SG_Util::val($arr_val, 1).' '.SG_Util::val($arr_val, 2);
				$compare = $arr_val_0;
			}
			elseif($arr_val_0 == 'NOT' && in_array($arr_val_1, $arr_compare)){
				$val = SG_Util::val($arr_val, 2);
				$compare = $arr_val_0.' '.$arr_val_1;
			}
			else{
				$compare = '=';
			}

			$param_meta[] = array(
				'key' => str_replace('where_meta_', '', $key),
				'value' => $val,
				'compare' => $compare
			);
		}
		else{
			$decode_val = json_decode($val, true);
			$param_args[$key] = ($decode_val) ? $decode_val : $val;
		}
	}

	$args = array(
		'post_type' => $post_type, 
		'posts_per_page' => $limit,
		'orderby' => $order_by,
		'order' => $order,
	);

	if($param_meta){
		$args['meta_query'] = $param_meta;
	}

	$args = array_merge($args, $param_args);

	

	$sg_post = new WP_Query($args);

	if($is_single){
		if($content){
			do_shortcode($content);
		}
		else{
			$output = '<h2>'.$sg_post->get_the_title().'</h2>';
			$output .= $sg_post->get_the_content();
		}
	}
	else{
		ob_start();
			include(sg_view_path('templates/list-'.$list.'.php'));
		$output = ob_get_clean();
	}

	$post = $temp_post;

	return $output;
}
add_shortcode('sg_post_list', 'sc_sg_post_list');


function sc_sg_post_single($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'post_slug' => '',
		'post_id' => '',
	), $attr));

	unset($attr['post_slug']);
	unset($attr['post_id']);

	$attr['is_single'] = true;

	return sc_sg_post_single($attr, $content);
}
add_shortcode('sg_post_single', 'sc_sg_post_single');