<?php 

use WPSG_Core\SG_Util;

class SG_CptSnippet
{

	static function init() {
		register_post_type('sg_cpt_snippet',
			array(
				'labels' => array(
					'name' => __('Snippets', 'wpsg_core'),
					'singular_name' => __('Snippet', 'wpsg_core'),
					'add_new_item' => __('Add New Snippet', 'wpsg_core'),
					'edit_item' => __('Edit Snippet', 'wpsg_core'),
					'new_item' => __('New Snippet', 'wpsg_core'),
					'view_item' => __('View Snippet', 'wpsg_core'),
					'search_items' => __('Search Snippet', 'wpsg_core'),
					'not_found' => __('No snippet found', 'wpsg_core'),
				),
				'public' => true,
				'supports' => array('title', 'editor'),
				'exclude_from_search' => true,
				'menu_position' => 100,
				'publicly_queryable' => false,
				'query_var' => false

			)
		);
	}
	


	// Modify save datas

	static function save($post_id){
		if(isset($_POST['post_type']) && $_POST['post_type'] != 'sg_cpt_snippet'){
		  return;
		}

		$data = array(
			'ID' => $post_id
		);

		if(isset($_REQUEST['post_title'])){
			$data['post_title'] = SG_Util::slug($_REQUEST['post_title']);
		}

		// unhook this function so it doesn't loop infinitely
		remove_action('save_post', array('SG_CptSnippet', 'save'));
		// update the post, which calls save_post again
		wp_update_post($data);
		// re-hook this function
		add_action('save_post', array('SG_CptSnippet', 'save'));
	}



	// Change the columns for the edit CPT screen

	static function change_columns($cols) {

		$cols = array(
			'cb' => '<input type="checkbox" />',
			'sg_col_name' => __('Name', 'wpsg_core'),
			'sg_col_id' => __('ID', 'wpsg_core'),
			'sg_col_status' => __('Status', 'wpsg_core'),
			'sg_col_action' => __('Action', 'wpsg_core'),
		);
			
		return $cols;
	}
	

	static function custom_columns($column, $post_id){
		switch($column){
			case "sg_col_id":
				echo $post_id;
			break;
			case "sg_col_name":
				$name = get_the_title();
				echo '<a href="'.get_edit_post_link($post_id).'">'.$name.'</a>';
			break;
			case "sg_col_action":
				echo '<a href="'.get_edit_post_link($post_id).'"><span class="dashicons dashicons-edit"></span> Edit</a> ';
				echo '<a href="'.get_delete_post_link($post_id).'"><span class="dashicons dashicons-trash"></span> Delete</a> ';
			break;
			case "sg_col_status":
				echo get_post_status($post_id);
			break;
			
		}
	}


	// Remove default permalink from edit post

	static function permalinks($input){
		global $post;
		
		if(isset($post->post_type) && $post->post_type == 'sg_cpt_snippet'){
			return 'Snippet name should be lower case and doesnt contain spaces';
		}
		return $input;
	}
	

	// Remove default shortlink from edit post

	static function shortlinks($input){
		global $post;

		if(isset($post->post_type) && $post->post_type == 'sg_cpt_snippet'){
			return '';
		}
		return $input;
	}

	static function shortcode($attr){
		// extract the attributes into variables
		extract(shortcode_atts(array(
			'id' => '',
			'name' => ''
		), $attr));

		if(!$id && !$name){
			return '';
		}

		if($name){
			$query = "WHERE post_title = '%s'";
			$query_var = $name;
		}

		if($id){
			$query = "WHERE ID = %d";
			$query_var = $id;
		}

		global $wpdb;
		
		$row = $wpdb->get_row( 
			$wpdb->prepare("SELECT ID, post_content FROM $wpdb->posts ".$query, $query_var)
		);

		$id = SG_Util::val($row, 'ID');
		$content = SG_Util::val($row, 'post_content');

		$text = '<a class="snippet-{{ id }}" href="{{ link }}" target="_blank"><sup>Edit Snippet</sup></a>';

		return do_shortcode($content.sg_action_post_link($id, $text));
	}
}

add_action('init',  array('SG_CptSnippet', 'init'));
add_action('save_post', array('SG_CptSnippet', 'save'));
add_filter('manage_sg_cpt_snippet_posts_columns', array('SG_CptSnippet', 'change_columns'));
add_action('manage_sg_cpt_snippet_posts_custom_column', array('SG_CptSnippet', 'custom_columns'), 10, 2 );
add_filter('get_sample_permalink_html', array('SG_CptSnippet', 'permalinks'));
add_filter('pre_get_shortlink', array('SG_CptSnippet', 'shortlinks'));

add_shortcode('sg_snippet', array('SG_CptSnippet', 'shortcode'));