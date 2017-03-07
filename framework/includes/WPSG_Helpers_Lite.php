<?php 

if(!function_exists('sg_action_post_link')){
	function sg_action_post_link($id = null, $text = ''){
		$output = $text;
		$link = get_edit_post_link($id);

		if($text){
			$output = str_replace('{{ id }}', $id, $output);
			$output = str_replace('{{ link }}', $link, $output);
		}
		else{
			$output .= '<div class="float-actions">';
			$output .= '<a class="btn btn-warning btn-sm id-'.$id.'" href="'.get_edit_post_link($id).'"><i class="fa fa-pencil"></i> Edit Post</a>';
			$output .= '</div>';
		}

		if(current_user_can('edit_posts')){
			return $output;
		}		
	}
}