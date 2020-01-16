<?php 

$output = '<a class="'.$class.'" '.$url.'>'.do_shortcode($content).'</a>';

if($container_class){
	$output = '<div class="'.$container_class.'">'.$output.'</div>';
}

echo $output;
