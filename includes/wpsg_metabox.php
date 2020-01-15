<?php 

class WPSGMetabox
{
	var $id,
	$prefix,
	$title,
	$fields,
	$post_types = array('post', 'page'),
	$context = 'normal', //normal, advanced, side
	$priority = 'default'; //high, core, default, low

	function __construct($args)
	{
		if(is_array($args)){
			foreach($args as $key=>$val){
				$this->$key = $val;	
			}
		}

		if(!isset($this->prefix)){ $this->prefix = '_'.$this->id; }

		add_action('add_meta_boxes', array($this, 'init'));
		add_action('save_post',  array($this, 'save'));

		if($GLOBALS['pagenow']=='post.php'){
			add_action('admin_enqueue_scripts', array($this, 'admin_script'));
		}
	}

	function init()
	{
		add_meta_box(
			$this->id,
			$this->title,
			array($this, 'html'),
			$this->post_types,
			$this->context,
			$this->priority
		);
	}

	protected function _slugify($str, $sep='_')
	{
		$str = strtolower($str);
		$str = preg_replace('/[^a-z0-9'.$sep.']/', $sep, $str);
		$str = preg_replace('/'.$sep.'+/', $sep, $str);
		
		return trim($str, $sep);
	}

	protected function _validateOptions($options)
	{
		if(!isset($options[0])){ return array(); }

		$result = array();
		if(!is_array($options[0])){
			foreach($options as $opt){
				$opt_value = $this->_slugify($opt);
				$result[] = array('label'=>$opt, 'value'=>$opt_value);
			}
		}
		else{
			$result = $options;
		}

		return $options;
	}

	protected function _input($type, $name, $values=null, $attr='', $default='', $options='')
	{
		$options = ($options) ? $options : array();
		$options = $this->_validateOptions($options);
		$attr = ($attr) ? $attr : array();

		$output = '';
		$output_attr = '';

		foreach($attr as $key=>$val){
			$output_attr .= $key.'="'.$val.'"';
		}

		$attr_class = (isset($attr['class'])) ? $attr['class'] : null;

		$input_name = ($this->prefix) ? $this->prefix.'_'.$name : $name;
		$input_id = $this->_slugify($input_name);
		$input_value = (isset($values[$input_name])) ? $values[$input_name] : $default;

		if($type == 'checkbox'){
			$input_class = trim('form-checkbox '.$attr_class);
			$input_value = @unserialize($input_value);
			if(!is_array($input_value)){ $input_value = array(); }

			$output .= '<div class="'.$input_class.'" id="'.$input_id.'" '.$output_attr.'>';
			foreach($options as $opt){
				$is_checked = (in_array($opt['value'], $input_value)) ? ' checked="true"' : '';
				$output .= '<label><input type="checkbox" name="'.$input_name.'[]" value="'.htmlspecialchars($opt['value']).'" '.$is_checked.' /> '.$opt['label'].'</label>';
			}
			$output .= '</div>';
		}
		elseif($type == 'radio'){
			$input_class = trim('form-radio '.$attr_class);

			$output .= '<div class="'.$input_class.'" id="'.$input_id.'" '.$output_attr.'>';
			foreach($options as $opt){
				$is_checked = ($opt['value'] == $input_value) ? ' checked="true"' : '';
				$output .= '<label><input type="radio" name="'.$input_name.'" value="'.htmlspecialchars($opt['value']).'" '.$is_checked.' /> '.$opt['label'].'</label>';
			}
			$output .= '</div>';
		}
		elseif($type == 'select'){
			$input_class = trim('form-control '.$attr_class);
			$output .= '<select class="'.$input_class.'" id="'.$input_id.'" name="'.$input_name.'" '.$output_attr.'>';
			foreach($options as $opt){
				$is_selected = ($opt['value'] === $input_value) ? ' selected="true"' : '';
				$output .= '<option value="'.htmlspecialchars($opt['value']).'" '.$is_selected.'>'.$opt['label'].'</label>';
			}
			$output .= '</select>';
		}
		elseif($type == 'textarea'){
			$input_class = trim('form-control widefat '.$attr_class);
			$output .= '<textarea class="'.$input_class.'" id="'.$input_id.'" name="'.$input_name.'" '.$output_attr.'>'.htmlspecialchars($input_value).'</textarea>';
		}
		elseif($type == 'editor'){
			$input_class = trim('form-control widefat '.$attr_class);

			ob_start();
			wp_editor( 
				$input_value, 
				$input_name, 
				['media_buttons' => true, 'textarea_rows' => 5] 
			);
			$output .= ob_get_clean();
		}
		elseif($type == 'upload'){
			$input_class = trim('form-control '.$attr_class);
			$output .= '<div class="sgmb-upload"><input type="text" class="sgmb-upload-field '.$input_class.'" id="'.$input_id.'" name="'.$input_name.'" value="'.htmlspecialchars($input_value).'" /><input id="'.$input_id.'-button" class="button sgmb-upload-btn" data-name="'.$input_name.'" type="button" value="Upload Image" /></div>';
			if($input_value){
				if(is_numeric($input_value)){
					$image = wp_get_attachment_image_src($input_value, '400x400');
					if(is_array($image)){
						$image = $image[0];
					}
				}
				else{
					$image = $input_value;
				}
				
				$output .= '<div class="sgmb-upload-preview"><div><img src="'.$image.'" /></div></div>';
			}
			else{
				$output .= '<div class="sgmb-upload-preview"></div>';
			}
		}
		elseif($type == 'multi-upload'){
			$input_class = trim('form-control '.$attr_class);
			$output .= '<div class="sgmb-upload"><input id="'.$input_id.'-button" class="button sgmb-upload-btn" data-upload-multiple="true" data-name="'.$input_name.'" type="button" value="Upload Image" /></div>';
			if($input_value){				
				$output .= '<div class="sgmb-upload-preview multiple">';

				$input_value = (array) @unserialize($input_value);
				foreach($input_value as $input_val){
					$image = wp_get_attachment_image_src($input_val, 'thumbnail');
					if(is_array($image)){
						$image = $image[0];
					}

					$output .= '<div><img src="'.$image.'" /><input type="hidden" name="'.$input_name.'[]" value="'.htmlspecialchars($input_val).'" /><i class="remove">x</i></div>';
				}

				$output .= '</div>';
			}
			else{
				$output .= '<div class="sgmb-upload-preview"></div>';
			}
		}
		elseif($type == 'separator'){
			$input_class = trim('form-control widefat '.$attr_class);
			$output .= '<hr />';
		}
		else{
			$input_class = trim('form-control widefat '.$attr_class);
			$output .= '<input type="text" class="'.$input_class.'" id="'.$input_id.'" name="'.$input_name.'" value="'.htmlspecialchars($input_value).'" '.$output_attr.'/>';
		}

		return $output;
	}

	public function save($post_id)
	{
		if(!current_user_can('edit_post', $post_id)){
			return $post_id;
		}
		
		// if(!isset($_POST[$this->id.'_nonce']) || !wp_verify_nonce($_POST[$this->id.'_nonce'], basename(__FILE__))){
		// 	return $post_id;
		// }

		//Check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}

		//Don't update on Quick Edit
		if (defined('DOING_AJAX') ) {
			return $post_id;
		}

		$active_keys = array();

		foreach($_POST as $key=>$value){
			if(stripos($key, $this->prefix) === false){ continue; }
			elseif($key == $this->prefix.'_nonce'){ continue; }

			if($value){
				update_post_meta($post_id, $key, $value);
			}
			else{
				delete_post_meta($post_id, $key);
			}

			$active_keys[] = $key;
		}

		// delete unused keys
		// $metas = get_post_meta($post_id);
		// foreach($metas as $key=>$value){
		// 	if(stripos($key, $this->prefix) !== false){
		// 		if(!in_array($key, $active_keys)){
		// 			delete_post_meta($post_id, $key);
		// 		}
		// 	}
		// }

	}

	public function input($type, $name, $values=null, $attr='', $default='', $options='')
	{
		return $this->_input($type, $name, $values, $attr, $default, $options);
	}

	public function html()
	{
		
	}

	public function admin_script()
	{
		// style
		wp_enqueue_style('thickbox');
		wp_enqueue_style('sg-metabox-style', plugins_url('assets/sg_metabox_plugin.css',  dirname(__FILE__)));

		// script
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_register_script('sg-metabox-script', plugins_url('assets/sg_metabox_plugin.js',  dirname(__FILE__)), array('jquery','media-upload','thickbox','jquery-ui-sortable'));
		wp_enqueue_script('sg-metabox-script');
	}
}

class WPSGBaseMetabox extends WPSGMetabox
{

	function html()
	{
		global $post;
		wp_nonce_field(basename(__FILE__), $this->id.'_nonce');
		$metas = get_post_meta($post->ID);
		$values = array();

		foreach($metas as $key=>$value){
			if($this->prefix && stripos($key, $this->prefix) === false){ continue; }

			$values[$key] = @$value[0];
		}		

		$fields = $this->fields;

		echo '<div class="wpsg-metabox">';
		echo '<div class="form-table">';
		foreach($fields as $idx=>$field){

			$field_type = (isset($field['type'])) ? $field['type'] : null;
			$field_name = (isset($field['name'])) ? $field['name'] : null;
			$field_title = (isset($field['title'])) ? $field['title'] : null;
			$field_attrs = (isset($field['attrs'])) ? $field['attrs'] : null;
			$field_default = (isset($field['default'])) ? $field['default'] : null;
			$field_options = (isset($field['options'])) ? $field['options'] : null;
			$field_desc = (isset($field['desc'])) ? $field['desc'] : null;

			echo '<div class="form-group">';
			echo '<label for="'.$this->prefix.'_'.$field_name.'">'.$field_title.'</label>';
			echo $this->_input($field_type, $field_name, $values, $field_attrs, $field_default, $field_options).'<div class="field-desc">'.$field_desc.'</div>';
			echo '</div>';
		}
		echo '</div>';
		echo '</div>';

		wp_enqueue_style('wpsg-admin-metabox', plugins_url('assets/admin-metabox.css', __DIR__));
	}
}