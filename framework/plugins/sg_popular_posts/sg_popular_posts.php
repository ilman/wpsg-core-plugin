<?php 
/*
http://wp.tutsplus.com/tutorials/creative-coding/building-custom-wordpress-widgets/ 
*/

class SG_PopularPosts{

	static $meta_key = 'views';

	public static function set_post_views($post_id)
	{
	    $count_key = self::$meta_key;
	    $count = get_post_meta($post_id, $count_key, true);
	    if($count==''){
	        $count = 0;
	        delete_post_meta($post_id, $count_key);
	        add_post_meta($post_id, $count_key, '0');
	    }else{
	        $count++;
	        update_post_meta($post_id, $count_key, $count);
	    }
	}

	public static function get_posts($num_posts=4, $template='', $args=false)
	{
		if(!isset($post)){ $post = null; }

		if(!$args){
			$args = array( 
				'posts_per_page' => $num_posts,
				'meta_key' => self::$meta_key,
				'ignore_sticky_posts' => 1,
				'post_type'=> 'post',
				'orderby' => 'meta_value_num',
				'order' => 'DESC'
			);
		}

		if(!$template){
			$template = dirname(__FILE__).'/template.php';
		}

		$temp_post = $post;
		$post = new WP_Query($args);

		include($template);

		$post = $temp_post;
		wp_reset_query();
	}
}

class SG_PopularPostsWidget extends WP_Widget {
	
	public function __construct() {
		parent::__construct(
	 		'sg_popular_posts', // Base ID
			'SG Popular Posts', // Name
			array( 'description' => __( 'Showing popular post as list', 'wpsg_core' ) ) // Args
		);
	}
	
	/**
	 * Front-end display of widget.
	 */
	public function widget( $args, $instance ) {
		global $post;		
		$orig_post = $post;
		
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		echo $before_widget;
		if ( ! empty( $title ) ){
			echo $before_title . $title . $after_title;
		}

		SG_PopularPosts::get_posts($instance['num_post']);
		
		echo $after_widget;
	}
	
	/**
	 * Back-end widget form.
	 */
 	public function form($instance)
 	{	
		if(isset($instance['title'])){
			$title = $instance['title'];
		}
		else {
			$title = __( 'Popular Posts', 'wpsg_core' );
		}
		
		$num_post = (isset($instance['num_post'])) ? $instance['num_post'] : 3;
		
		?>
			<p>
				<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_name( 'num_post' ); ?>"><?php _e( 'Number of Posts:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'num_post' ); ?>" name="<?php echo $this->get_field_name( 'num_post' ); ?>" type="text" value="<?php echo esc_attr( $num_post ); ?>" />
			</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 */
	public function update( $new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['num_post'] = ( !empty( $new_instance['num_post'] ) ) ? strip_tags( $new_instance['num_post'] ) : '';

		return $instance;
	}

	public static function register(){
		register_widget('SG_PopularPostsWidget');
	}

}


add_action('widgets_init', array('SG_PopularPostsWidget', 'register'));