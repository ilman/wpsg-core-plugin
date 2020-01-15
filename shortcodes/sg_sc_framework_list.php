<?php 

use WPSG_Core\SG_Util;

function sc_sg_list($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'layout' => '',
		'class' => ''
	), $attr));
	
	$param_class = trim("$layout $class");
	if($param_class){
		$param_class = ' class="'.$param_class.'"';
	}

	$output = '<ul'.$param_class.'>'.do_shortcode($content).'</ul>';

	return $output;
}
add_shortcode('sg_list', 'sc_sg_list');



function sc_sg_li($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'class' => ''
	), $attr));

	$param_class = trim("$class");
	if($param_class){
		$param_class = ' class="'.$param_class.'"';
	}

	$output = '<li'.$param_class.'>'.do_shortcode($content).'</li>';

	return $output;
}
add_shortcode('sg_li', 'sc_sg_li');




function sc_sg_list_fa($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'layout' => '',
		'class' => ''
	), $attr));
	
	$param_class = trim("fa-ul $layout $class");
	if($param_class){
		$param_class = ' class="'.$param_class.'"';
	}

	$output = '<ul'.$param_class.'>'.do_shortcode($content).'</ul>';

	return $output;
}
add_shortcode('sg_list_fa', 'sc_sg_list_fa');



function sc_sg_li_fa($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'icon' => '',
		'icon_class' => '',
		'class' => ''
	), $attr));

	$param_icon = '';
	if($icon){
		$icon = 'fa-'.$icon;
		$param_icon = ' <i class="'.trim("fa fa-li $icon $icon_class").'"></i>';
	}

	$param_class = trim("$class");
	if($param_class){
		$param_class = ' class="'.$param_class.'"';
	}
	
	$output = '<li'.$param_class.'>'.$param_icon.do_shortcode($content).'</li>';

	return $output;
}
add_shortcode('sg_li_fa', 'sc_sg_li_fa');




function sc_sg_list_badge($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'layout' => '',
		'class' => ''
	), $attr));
	
	$param_class = trim("list-blank $layout $class");
	if($param_class){
		$param_class = ' class="'.$param_class.'"';
	}

	$output = '<ul'.$param_class.'>'.do_shortcode($content).'</ul>';

	return $output;
}
add_shortcode('sg_list_badge', 'sc_sg_list_badge');



function sc_sg_li_badge($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'icon' => '',
		'text' => '',
		'badge_class' => '',
		'badge_size' => 'md',
		'badge_shape' => 'circle',
		'block_align' => 'left',
		'class' => ''
	), $attr));


	if($icon){
		$icon = 'fa-'.$icon;
		$param_text = '<i class="'.trim("fa $icon").'"></i>';
	}

	if($text){
		$param_text = '<i class="fa">'.$text.'</i>';
	}

	$param_class = trim("$class");
	if($param_class){
		$param_class = ' class="'.$param_class.'"';
	}

	$block_align = ($block_align) ? 'align-'.$block_align : '';
	$badge_shape = ($badge_shape) ? 'badge-'.$badge_shape : '';
	$badge_size  = ($badge_size) ? 'badge-'.$badge_size : '';

	$param_badge_class = trim("badge badge-icon $badge_shape $badge_size $badge_class");

	$output = '<li'.$param_class.'>
	<div class="block">
		<div class="'.trim("block-thumb $block_align").'">
			<span class="'.$param_badge_class.'">'.$param_text.'</span>
		</div>
		<!-- block-thumb -->
		<div class="block-body">'.do_shortcode($content).'</div>
		<!-- block-body -->
	</div>
	</li>';
	
	$output = '<li'.$param_class.'>'.$output.'</li>';

	return $output;
}
add_shortcode('sg_li_badge', 'sc_sg_li_badge');




function sc_sg_list_group($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'type' => '',
		'class' => ''
	), $attr));
	
	$param_class = trim("list-group $class");
	if($param_class){
		$param_class = ' class="'.$param_class.'"';
	}

	$tag = ($type=='link' ) ? 'div' : 'ul';

	$output = '<'.$tag.$param_class.'>'.do_shortcode($content).'</'.$tag.'>';

	return $output;
}
add_shortcode('sg_list_group', 'sc_sg_list_group');



function sc_sg_li_group($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'type' => '',
		'url' => '',
		'class' => ''
	), $attr));

	$param_class = trim("list-group-item $class");
	if($param_class){
		$param_class = ' class="'.$param_class.'"';
	}

	$tag = ($type=='link' ) ? 'a' : 'li';

	$param_href = trim("$url");
	if($param_href){
		$param_href = ' href="'.$param_href.'"';
	}
	
	$output = '<'.$tag.$param_class.$param_href.'>'.do_shortcode($content).'</'.$tag.'>';

	return $output;
}
add_shortcode('sg_li_group', 'sc_sg_li_group');




function sc_sg_list_dl($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'layout' => '',
		'class' => ''
	), $attr));

	if($layout){
		$layout = 'dl-'.$layout;
	}
	
	$param_class = trim("$layout $class");
	if($param_class){
		$param_class = ' class="'.$param_class.'"';
	}

	$output = '<dl'.$param_class.'>'.do_shortcode($content).'</dl>';

	return $output;
}
add_shortcode('sg_list_dl', 'sc_sg_list_dl');


function sc_sg_dt($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'class' => ''
	), $attr));
	
	$param_class = trim("$class");
	if($param_class){
		$param_class = ' class="'.$param_class.'"';
	}

	$output = '<dt'.$param_class.'>'.do_shortcode($content).'</dt>';

	return $output;
}
add_shortcode('sg_dt', 'sc_sg_dt');

function sc_sg_dd($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'class' => ''
	), $attr));
	
	$param_class = trim("$class");
	if($param_class){
		$param_class = ' class="'.$param_class.'"';
	}

	$output = '<dd'.$param_class.'>'.do_shortcode($content).'</dd>';

	return $output;
}
add_shortcode('sg_dd', 'sc_sg_dd');