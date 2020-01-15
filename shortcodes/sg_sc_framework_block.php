<?php 

use WPSG_Core\SG_Util;

function sc_sg_block($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'layout' => '',
		'align' => '',
		'style' => '',
		'class' => '',
		'rel' => '',
	), $attr));

	$param_class = trim("block $layout $align $style $class");
	$param_rel = trim($rel);
	$param_rel = ($param_rel) ? ' rel="'.$param_rel.'"' : '';

	$content = preg_replace('/^\<br \/\>|\<br \/\>$/', '', $content);
	$content = preg_replace('/\[\/sg_block_thumb\]\<br \/\>/', '[/sg_block_thumb]', $content);


	$output = '<div class="'.$param_class.'"'.$param_rel.'>'.do_shortcode($content).'</div>';

	return $output;
}
add_shortcode('sg_block', 'sc_sg_block');



function sc_sg_block_thumb($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'class' => ''
	), $attr));

	$param_class = trim("block-thumb $class");

	$content = preg_replace('/^\<br \/\>|\<br \/\>$/', '', $content);

	$output = '<div class="'.$param_class.'">'.do_shortcode($content).'</div>';

	return $output;
}
add_shortcode('sg_block_thumb', 'sc_sg_block_thumb');




function sc_sg_block_body($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'class' => ''
	), $attr));

	$param_class = trim("block-body $class");

	$content = preg_replace('/^\<br \/\>|\<br \/\>$/', '', $content);

	$output = '<div class="'.$param_class.'">'.do_shortcode($content).'</div>';

	return $output;
}
add_shortcode('sg_block_body', 'sc_sg_block_body');
add_shortcode('sg_block_content', 'sc_sg_block_body');




function sc_sg_block_icon($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'layout' => '',
		'align' => '',
		'icon' => '',
		'badge_shape' => 'badge-circle',
		'badge_bg' => 'bg-primary',
		'badge_color' => '',
		'badge_border' => 'border-primary',
		'badge_size' => 'badge-lg',
		'badge_class' => '',
		'class' => ''
	), $attr));

	$param_class = trim("block $class");
	$param_icon = trim("fa fa-$icon");
	$param_badge = trim("badge badge-icon $badge_shape $badge_bg $badge_color $badge_border $badge_size $badge_class");

	$content = preg_replace('/^\<br \/\>|\<br \/\>$/', '', $content);

	$output = '<div class="'.$param_class.'">
			<div class="block-thumb">
				<span class="'.$param_badge.'">
					<i class="'.$param_icon.'"></i>
				</span>
			</div>
			<div class="block-body">'.do_shortcode($content).'</div>
		</div>';

	return $output;
}
add_shortcode('sg_block_icon', 'sc_sg_block_icon');


function sc_sg_block_image($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'layout' => '',
		'align' => '',
		'image' => '',
		'class' => ''
	), $attr));

	if($align){
		$align = 'text-'.$align;
	}

	$param_class = trim("block $class $align");

	$content = preg_replace('/^\<br \/\>|\<br \/\>$/', '', $content);

	$output = '<div class="'.$param_class.'">
			<div class="block-thumb">
				<img src="'.trim($image).'" />
			</div>
			<div class="block-body">'.do_shortcode($content).'</div>
		</div>';

	return $output;
}
add_shortcode('sg_block_image', 'sc_sg_block_image');