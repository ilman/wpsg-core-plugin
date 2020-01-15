<?php 

/*--- add metabox ---*/

class WPSGVCMetabox extends WPSGMetabox
{

	function html()
	{
		global $post;
		wp_nonce_field(basename(__FILE__), $this->id.'_nonce');
		$metas = get_post_meta($post->ID);
		$values = array();

		foreach($metas as $key=>$value){
			if(stripos($key, $this->prefix) === false){ continue; }

			$values[$key] = @$value[0];
		}		

		$fields = array(
			array('title'=>'WP Head', 'name'=>'head', 'type'=>'textarea', 'attrs'=>['rows'=>4], 'desc'=>'Code to be placed in wp_head'),
			array('title'=>'WP Foot', 'name'=>'foot', 'type'=>'textarea', 'attrs'=>['rows'=>4], 'desc'=>'Code to be placed in wp_foot'),
			
		);

		echo '<div class="tui-metabox">';
		echo '<dl class="form-table">';
		foreach($fields as $idx=>$field){

			$field_type = (isset($field['type'])) ? $field['type'] : null;
			$field_name = (isset($field['name'])) ? $field['name'] : null;
			$field_title = (isset($field['title'])) ? $field['title'] : null;
			$field_attrs = (isset($field['attrs'])) ? $field['attrs'] : null;
			$field_default = (isset($field['default'])) ? $field['default'] : null;
			$field_options = (isset($field['options'])) ? $field['options'] : null;
			$field_desc = (isset($field['desc'])) ? $field['desc'] : null;

			echo '<dt><label for="'.$this->prefix.'_'.$field_name.'">'.$field_title.'</label></dt>';
			echo '<dd>'.$this->_input($field_type, $field_name, $values, $field_attrs, $field_default, $field_options).'<div class="field-desc">'.$field_desc.'</div></dd>';
		}
		echo '</dl>';
		echo '</div>';

		echo "<style>
			.tui-metabox dl dt{ font-weight:bold; margin-bottom:5px; }
			.tui-metabox dl dd{ margin-left:0; }
			.tui-metabox .field-desc{ margin-top:5px; color:#999; font-size:0.9em; line-height:1.4em; font-style:italic; }
			.tui-metabox .alert-info{ color:#0c5460; background-color:#d1ecf1; border:#bee5eb solid 1px; padding:10px; }
			.tui-metabox .form-table .alert-info{ margin-left:-10px; margin-right:-10px; }
		</style>";
	}

	function wp_head()
	{
		$wp_head = get_post_meta(get_the_ID(), '_wpsg_wp_meta_head', true);

		echo do_shortcode($wp_head);
	}

	function wp_foot()
	{
		$wp_foot = get_post_meta(get_the_ID(), '_wpsg_wp_meta_foot', true);

		echo do_shortcode($wp_foot);
	}
}

$wpsg_mb = new WPSGVCMetabox(array(
	'id' => 'wpsg_wp_meta',
	'title' => 'WPSG Head/Foot Code',
	'post_types' => array('page')
));

add_action('wp_head', [$wpsg_mb, 'wp_head'], 10);
add_action('wp_footer', [$wpsg_mb, 'wp_foot'], 10);