<?php

function wpsg_enqueue_scripts(){
	$file_path = 'assets/style.css';
	$theme_file_url = plugin_dir_url(__DIR__).$file_path;
	$theme_file_path = wpsg_core_plugin_path().$file_path;
	$theme_mod_time = (file_exists($theme_file_path)) ? filemtime($theme_file_path) : 0;
	$theme_mod_time = date("Y-m-d-H:i:s", $theme_mod_time);
		

	wp_enqueue_style('wpsg-style', $theme_file_url, array(), $theme_mod_time, 'all' );
}

add_action('wp_enqueue_scripts', 'wpsg_enqueue_scripts');