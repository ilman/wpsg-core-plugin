<?php

function wpsg_enqueue_scripts(){
	$file_path = 'assets/style.css';
	$theme_file_url = plugin_dir_url(__DIR__).$file_path;
	$theme_file_path = wpsg_core_plugin_path().$file_path;
	$theme_mod_time = (file_exists($theme_file_path)) ? filemtime($theme_file_path) : 0;
	$theme_mod_time = date("Y-m-d-H:i:s", $theme_mod_time);
		

	wp_enqueue_style('wpsg-style', $theme_file_url, array(), $theme_mod_time, 'all' );
}

function wpsg_enqueue_admin_scripts(){
	wp_register_style('wpsg-admin-style', plugins_url( 'assets/admin.css', __DIR__ ) );
	wp_enqueue_style('wpsg-admin-style');

	// wp_register_script( 'wpsg-admin-vc', plugins_url( 'assets/vc_admin.js', __DIR__ ), array('jquery','vc_editors-templates-preview-js'), '1.9.0', true);
	// wp_enqueue_script( 'wpsg-admin-vc' );
}


add_action('wp_enqueue_scripts', 'wpsg_enqueue_scripts');
add_action('admin_enqueue_scripts', 'wpsg_enqueue_admin_scripts');