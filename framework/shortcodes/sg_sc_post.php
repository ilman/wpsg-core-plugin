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


function _sg_validate_wp_query($attr){
	$query = array();
	$wp_key = array('author','author_name','author__in','author__not_in','cat','category_name','category__and','category__in','category__not_in','tag','tag_id','tag__and','tag__in','tag__not_in','tag_slug__and','tag_slug__in','tax_query','p','name','title','page_id','pagename','post_parent','post_parent__in','post_parent__not_in','post__in','post__not_in','post_name__in','has_password','post_password','post_type','post_status','comment_count','nopaging','posts_per_page','posts_per_archive_page','offset','paged','page','ignore_sticky_posts','order','orderby','year','monthnum','w','day','hour','minute','second','m','date_query','meta_key','meta_value','meta_value_num','meta_compare','meta_query');

	$custom_key = array('order_by','no_paging','post_id','post_name','post_slug','post_parent_id','category','cat_id','order_by_meta','post_include','post_exclude','post_slug_include','post_parent_include','post_parent_exclude','cat_include','cat_exclude','tag_include','tag_exclude','tag_slug_include','limit','skip');
	
	$array_key = array('p','name','page_id','author','author_name','cat','category_name','tag','tag_id','post_type','post_status','order','orderby','post_id','post_name','post_slug','category');

	// set default value
	if(!isset($attr['post_type'])){ $attr['post_type'] = 'post'; }
	if(!isset($attr['limit'])){ $attr['limit'] = get_option('posts_per_page', 10); }
	if(!isset($attr['order_by']) && !isset($attr['order_by_meta'])){ $attr['order_by'] = 'ID'; }
	if(!isset($attr['order'])){ $attr['order'] = 'ASC'; }
	if(!isset($attr['ignore_sticky_posts'])){ $attr['ignore_sticky_posts'] = true; }

	// map common key
	foreach($attr as $key=>$value){
		// if key is not in wp_key or not in our custom_key skip it
		if(!in_array($key, $wp_key) && !in_array($key, $custom_key)){
			continue;
		}

		// change value to array for supporting parameters
		if(in_array($key, $array_key)){
			if(!is_array($value) && $value){
				$value = trim(str_replace(' ','',$value));
			}
		}
		elseif(strpos($key, '__in')!==false || strpos($key, '__not_in')!==false || strpos($key, '_include')!==false || strpos($key, '_exclude')!==false || strpos($key, '__and')!==false){
			if(!is_array($value) && $value){
				$value = trim(str_replace(' ','',$value));
			}
		}

		// map our custom key to wp query parameters
		if($key=='post_name' || $key=='post_slug'){
			$query['post_name__in'] = explode(',', $value);
		}
		
		elseif($key=='post_id' || $key=='post_include'){
			$query['post__in'] = explode(',', $value);
		}
		elseif($key=='post_exclude'){
			$query['post__not_in'] = explode(',', $value);
		}
		
		elseif($key=='post_parent_id' || $key=='post_parent_include'){
			$query['post_parent__in'] = explode(',', $value);
		}
		elseif($key=='post_parent_exclude'){
			$query['post_parent__not_in'] = explode(',', $value);
		}

		elseif($key=='cat_id' || $key=='cat_include'){
			$query['category__in'] = explode(',', $value);
		}
		elseif($key=='cat_exclude'){
			$query['category__not_in'] = explode(',', $value);
		}

		elseif($key=='tag_id' || $key=='tag_include'){
			$query['tag__in'] = explode(',', $value);
		}
		elseif($key=='tag_exclude'){
			$query['tag__not_in'] = explode(',', $value);
		}

		elseif($key=='post_name_include' || $key=='post_slug_include'){
			$query['post_name__in'] = explode(',', $value);
		}

		elseif($key=='tag_slug_include'){
			$query['tag_slug__in'] = explode(',', $value);
		}

		elseif($key=='no_paging'){
			$query['nopaging'] = $value;
		}
		elseif($key=='limit'){
			$query['posts_per_page'] = $value;
		}
		elseif($key=='skip'){
			$query['offset'] = $value;
		}
		elseif($key=='order_by'){
			$query['orderby'] = $value;
		}
		elseif($key=='order_by_meta'){
			$query['orderby'] = 'meta_value_num';
			$query['meta_key'] = $value;
		}
		else{
			$query[$key] = $value;
		}

		unset($attr[$key]);
	}

	// map meta_query, example: [sg_post_list where_meta_$key=">= $value"]

	$meta_query = array();
	$array_compare = array('=', '!=', '>', '>=', '<', '<=', 'LIKE', 'NOT LIKE', 'IN', 'NOT IN', 'BETWEEN', 'NOT BETWEEN', 'EXISTS', 'NOT EXISTS');

	foreach($attr as $key=>$val){
		if(strpos($key, 'where_meta_')===0){

			$array_val = explode(' ', $val, 2);
			
			if(in_array($array_val[0], $array_compare)){
				$param_meta = array(
					'value' => $array_val[1],
					'compare' => $array_val[0],
				);
			}
			else{
				$param_meta = array(
					'value' => $array_val[0],
					'compare' => '=',
				);
			}

			$param_meta['key'] = trim(str_replace('where_meta_', '', $key));
			$meta_query[] = $param_meta;

			unset($attr[$key]);
		}
	}

	if(count($meta_query)){
		$query['meta_query'] = $meta_query;
	}

	// map tax_query, example: [sg_post_list where_taxonomy_month_destination="january"]

	$tax_query = array();

	foreach($attr as $key=>$val){
		if(strpos($key, 'where_taxonomy_')===0){

			$tax_query[] = array(
				'taxonomy' => trim(str_replace('where_taxonomy_', '', $key)),
				'field' => 'slug',
				'terms' => trim($val),
			);

			unset($attr[$key]);
		}
	}

	if(count($tax_query)){
		$query['tax_query'] = $tax_query;
	}

	return $query;
}


function sc_sg_post_list($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'list' => 'default',
		'class' => '',
		'style' => '',
		'col_width' => 4,
	), $attr));
	
	global $post;
	$temp_post = $post;

	$args = _sg_validate_wp_query($attr);
	$sg_post = new WP_Query($args);

	if(file_exists(sg_view_path('framework/templates/list-'.$list.'.php'))){
		ob_start();
			include(sg_view_path('framework/templates/list-'.$list.'.php'));
		$output = ob_get_clean();
	}
	else{
		$output = sg_view_path('framework/templates/list-'.$list.'.php').' file not found';
	}

	$post = $temp_post;

	return $output;
}
add_shortcode('sg_post_list', 'sc_sg_post_list');


function sc_sg_post_single($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'slug' => '',
		'id' => '',
		'type' => 'post',
		'template' => '',
	), $attr));

	global $post;
	$temp_post = $post;

	$post_slug = $slug;
	$post_id = $id;

	$args = array();

	if($post_slug){
		$args = array('name'=>$post_slug);
	}

	if($post_id){
		$args = array('p'=>$post_id);
	}

	$args['post_type'] = $type;

	$sg_post = new WP_Query($args);

	if($template){
		$file_template = sg_view_path('framework/templates/'.$template.'.php');
		if(file_exists($file_template)){
			ob_start();
				include($file_template);
			$output = ob_get_clean();
		}
		else{
			$output = $file_template.' file not found';
		}
	}
	else{
		while ( $sg_post->have_posts() ){
			$sg_post->the_post();

			$output = do_shortcode(get_the_content().sg_action_post_link(get_the_ID()));
		}		
	}

	// visual composer
	if(class_exists('Vc_Base')){
		$vc_base = new Vc_Base;

		if(method_exists($vc_base, 'addFrontCss')){
			$vc_base->addFrontCss(get_the_ID());
		}
	}

	$post = $temp_post;

	return $output;
}
add_shortcode('sg_post_single', 'sc_sg_post_single');