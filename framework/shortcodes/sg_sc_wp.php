<?php 

function sc_sg_template_url(){
	return get_template_directory_uri();
}
add_shortcode('sg_template_url', 'sc_sg_template_url');


function sc_email( $atts , $content = null ) {
	
	$content = do_shortcode($content);
	if(!is_email($content)){ return $content; }

	return '<a href="mailto:'.antispambot($content).'">'.antispambot($content).'</a>';
}
add_shortcode('email', 'sc_email');
add_shortcode('sg_email', 'sc_email');