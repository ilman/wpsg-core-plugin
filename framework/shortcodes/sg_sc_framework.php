<?php

use WPSG_Core\SG_Util;

$sg_collapse_count = 0;
$sg_collapse_content_count = 0;
$sg_gmap_count = 0;

function sc_sg_section($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'color_set' => '',
		'separator' => '',
		'wrapper' => '',
		'class' => ''
	), $attr));
	
	$param = trim("page-section $color_set $separator $class");
	$output = '<div class="'.$param.'">'.do_shortcode($content).'</div>';

	return $output;
}
add_shortcode('sg_section', 'sc_sg_section');



function sc_sg_row($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'class' => ''
	), $attr));
	
	$param = trim("row $class");
	$output = '<div class="'.$param.'">'.do_shortcode($content).'</div>';

	return $output;
}
add_shortcode('sg_row', 'sc_sg_row');



function sc_sg_col($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'width' => '12',
		'view' => 'sm',
		'offset' => '',
		'class' => ''
	), $attr));
	
	//verify width value
	if($width>=1 && $width<=12){
		$width = 'col-'.$view.'-'.$width;
	}
	else{
		$width = 'col-'.$view.'-12';
	}

	//verify offset value
	if($offset>=1 && $offset<=12){
		$offset = 'col-'.$view.'-offset-'.$offset;
	}
	else{
		$offset = '';
	}

	$param = trim("$width $offset $class");
	$output = '<div class="'.$param.'">'.do_shortcode($content).'</div>';

	return $output;
}
add_shortcode('sg_col', 'sc_sg_col');



function sc_sg_spacer($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'height' => 0,
		'style' => '',
		'class' => ''
	), $attr));
	
	$param_class = trim("vspace $class");
	$param_style = trim("$style");

	
	//verify height
	if($height){
		$param_style .= ' height:'.$height;
	}

	//finalize param_style
	$param_style = ' style="'.$param_style.'"';

	$output = '<div class="'.$param_class.'"'.$param_style.'></div>';

	return $output;
}
add_shortcode('sg_spacer', 'sc_sg_spacer');



function sc_sg_divider($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'style' => '',
		'class' => ''
	), $attr));
	
	//verify style
	if($style){
		$style = 'divider-'.$style;
	}
	
	$param_class = trim("divider divider-solid-line $style $class");
	$output = '<div class="'.$param_class.'"></div>';

	return $output;
}
add_shortcode('sg_divider', 'sc_sg_divider');



function sc_sg_divider_icon($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'style' => '',
		'icon' => '',
		'icon_class' => '',
		'class' => ''
	), $attr));

	//verify style
	if($style){
		$style = 'divider-'.$style;
	}

	$param_class = trim("sg-title title-divider $style $class");
	$param_icon = trim("fa fa-$icon $icon_class");

	$output = '<div class="'.$param_class.'">
	<span class="before"></span>
	<span class="inner"><i class="'.$param_icon.'"></i></span>
	<span class="after"></span>
	</div>';

	return $output;
}
add_shortcode('sg_divider_icon', 'sc_sg_divider_icon');



function sc_sg_divider_text($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'style' => '',
		'class' => ''
	), $attr));

	//verify style
	if($style){
		$style = 'divider-'.$style;
	}

	$param_class = trim("sg-title title-divider $style $class");

	$output = '<div class="'.$param_class.'">
	<span class="before"></span>
	<span class="inner">'.do_shortcode($content).'</span>
	<span class="after"></span>
	</div>';

	return $output;
}
add_shortcode('sg_divider_text', 'sc_sg_divider_text');







function sc_sg_collapse($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'id' => 0,
		'style' => '',
		'class' => ''
	), $attr));

	global $sg_collapse_count;

	$sg_collapse_count++;

	$param_class = trim("panel-group panel-accordion $class");
	$param_id = ($id) ? $id : 'collapse-'.$sg_collapse_count;

	$output = '<div class="'.$param_class.'" id="'.$param_id.'">'.do_shortcode($content).'</div>';

	return $output;
}
add_shortcode('sg_collapse', 'sc_sg_collapse');



function sc_sg_collapse_content($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'parent_id' => 0,
		'panel_id' => 0,
		'panel_style' => '',
		'title' => 'Title',
		'class' => ''
	), $attr));

	global $sg_collapse_count;
	global $sg_collapse_content_count;

	$sg_collapse_count++;
	$sg_collapse_content_count++;

	$param_parent_id = ($parent_id) ? $parent_id : 'collapse-'.$sg_collapse_count;
	$param_panel_id = ($parent_id) ? $parent_id : 'panel-'.$sg_collapse_count;
	
	$param_class = trim("panel panel-border $class");

	$panel_heading = '<div class="panel-heading">
        <h4 class="panel-title">
            <a href="#'.$param_parent_id.'-'.$param_panel_id.'" data-parent="#'.$param_parent_id.'" data-toggle="collapse" class="collapsed">
                <i class="fa panel-toggle fa-plus"></i>'.$title.'</a>
        </h4>
    </div>';

    $panel_body = '<div class="panel-collapse collapse" id="'.$param_parent_id.'-'.$param_panel_id.'">
        <div class="panel-body">
            <i class="fa panel-toggle fa-minus"></i>'.do_shortcode($content).'
        </div>
    </div>';


	$output = '<div class="'.$param_class.'">'.$panel_heading.$panel_body.'</div>';

	return $output;
}
add_shortcode('sg_collapse_content', 'sc_sg_collapse_content');



function sc_sg_gmap($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'id' => 0,
		'class' => '',
		'style' => '',
		'url' => '',
	), $attr));

	global $sg_gmap_count;

	$sg_gmap_count++;

	$param_class = trim("gmap $class");
	$param_id = ($id) ? $id : 'gmap-'.$sg_gmap_count;

	//get param_data
	$attr_data = array();
	foreach($attr as $key=>$val){
		if(strpos($key, 'data_')===0){
			$attr_data[SG_Util::slug($key)] = $val;
		}
	}

	$param_data = ' '.SG_Util::inline_attr($attr_data);

	$output = '<div class="'.$param_class.'" id="'.$param_id.'"'.$param_data.'></div>';

	return $output;
}
add_shortcode('sg_gmap', 'sc_sg_gmap');




function sc_sg_btn($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'color' => 'default',
		'class' => '',
		'style' => '',
		'url' => '',
	), $attr));

	$color = 'btn-'.$color;

	$param_class = trim("btn $color $class");
	$param_href = trim(' href="'.$url.'"');

	$output = '<a class="'.$param_class.'"'.$param_href.'>'.do_shortcode($content).'</a>';

	return $output;
}
add_shortcode('sg_btn', 'sc_sg_btn');



function sc_sg_div($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'class' => '',
		'style' => '',
		'rel' => '',
	), $attr));

	$param_class = trim("$class");
	if($param_class){
		$param_class = ' class="'.$param_class.'"';
	}

	$param_rel = trim($rel);
	$param_rel = ($param_rel) ? ' rel="'.$param_rel.'"' : '';

	$param_style = trim("$style");
	if($param_style){
		$param_style = ' style="'.$param_style.'"';
	}

	$output = '<div'.$param_class.$param_style.$param_rel.'>'.do_shortcode($content).'</div>';

	return $output;
}
add_shortcode('sg_div', 'sc_sg_div');
add_shortcode('sg_div_1', 'sc_sg_div');
add_shortcode('sg_div_2', 'sc_sg_div');
add_shortcode('sg_div_3', 'sc_sg_div');
add_shortcode('sg_div_4', 'sc_sg_div');


function sc_sg_p($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'class' => '',
		'style' => '',
		'rel' => '',
	), $attr));

	$param_class = trim("$class");
	if($param_class){
		$param_class = ' class="'.$param_class.'"';
	}

	$param_rel = trim($rel);
	$param_rel = ($param_rel) ? ' rel="'.$param_rel.'"' : '';

	$param_style = trim("$style");
	if($param_style){
		$param_style = ' style="'.$param_style.'"';
	}

	$output = '<p'.$param_class.$param_style.$param_rel.'>'.do_shortcode($content).'</p>';

	return $output;
}
add_shortcode('sg_p', 'sc_sg_p');



function sc_sg_span($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'class' => '',
		'style' => '',
	), $attr));

	$param_class = trim("$class");
	if($param_class){
		$param_class = ' class="'.$param_class.'"';
	}

	$param_style = trim("$style");
	if($param_style){
		$param_style = ' style="'.$param_style.'"';
	}

	$output = '<span'.$param_class.$param_style.'>'.do_shortcode($content).'</span>';

	return $output;
}
add_shortcode('sg_span', 'sc_sg_span');



function sc_sg_badge($attr=array(), $content=null){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'class' => '',
		'style' => '',
	), $attr));

	$param_class = trim("badge $class");
	if($param_class){
		$param_class = ' class="'.$param_class.'"';
	}

	$param_style = trim("$style");
	if($param_style){
		$param_style = ' style="'.$param_style.'"';
	}

	$output = '<span'.$param_class.$param_style.'>'.do_shortcode($content).'</span>';

	return $output;
}
add_shortcode('sg_badge', 'sc_sg_badge');


function sc_sg_fa($attr=array()){
	// extract the attributes into variables
	extract(shortcode_atts(array(
		'icon' => '',
		'fixed_width' => 'false',
		'class' => '',
		'style' => '',
	), $attr));

	if($icon){
		$icon = 'fa-'.$icon;
	}

	if($fixed_width=='true'){
		$class = 'fa-fw '.$class;
	}

	$param_class = trim("fa $icon $class");

	$param_style = trim(' style="'.$style.'"');

	$output = '<i class="'.$param_class.'"'.$param_style.'></i>';

	return $output;
}
add_shortcode('sg_fa', 'sc_sg_fa');




function sc_sg_iframe($attr=array()){
	$param_attr = '';
	foreach($attr as $key=>$val) {
		$param_attr .= ' '.$key.'="'.$val.'"';
	}

	$output = '<iframe'.$param_attr.'></iframe>';

	return $output;
}
add_shortcode('sg_iframe', 'sc_sg_iframe');