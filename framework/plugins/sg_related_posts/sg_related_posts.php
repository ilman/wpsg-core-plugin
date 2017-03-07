<?php 

/*
http://wp.tutsplus.com/tutorials/creative-coding/building-custom-wordpress-widgets/ 
http://www.wpbeginner.com/wp-themes/how-to-add-related-posts-with-a-thumbnail-without-using-plugins/
*/

class SG_RelatedPosts
{
	public static function get_posts($num_post=4, $template='', $args=false, $exclude='')
	{
		if(!isset($post)){ $post = null; }

		$args = array();
		$cat_ids = array();

		if(!isset($post->ID)){
			$categories = get_the_category();
		}
		else{
			$categories = get_the_category($post->ID);
		}
		
		
		if($exclude && is_array($categories)){
			foreach($categories as $cat){
				if($cat->slug != $exclude){
					$cat_ids[] = $cat->term_id;
				}
			}
		}

		if(!$template){
			$template = get_template_directory().'/sg_related_posts_template.php';
		}

		if(!file_exists($template)){
			$template = dirname(__FILE__).'/template.php';
		}
		
		$args = array(
			'category__in' => $cat_ids,
			'posts_per_page'=> $num_post,
			'ignore_sticky_posts' => 1,
			'post_type'=> 'post',
			'order' => 'DESC'
		);

		if(isset($post->ID)){
			$args['post__not_in'] = array($post->ID);
		}
		
		$temp_post = $post;
		$post = new WP_Query($args);
				
		include($template);
		
		$post = $temp_post;
		wp_reset_query();
	}
}



class SG_RelatedPostsWidget extends WP_Widget {
	
	public function __construct() {
		
		
		parent::__construct(
	 		'sg_related_post', // Base ID
			'SG Related Posts', // Name
			array( 'description' => __('Showing related posts in list style', 'wpsg_core') ) // Args
		);
	}
	
	/**
	 * Front-end display of widget.
	 */
	public function widget( $args, $instance ) {
		
		global $post;		
		
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		echo $before_widget;
		if ( ! empty( $title ) ){
			echo $before_title . $title . $after_title;
		}

		SG_RelatedPosts::get_posts($instance['num_post'], '', '', $instance['cat_slug']);
		
		echo $after_widget;	
	}
	
	/**
	 * Back-end widget form.
	 */
 	public function form( $instance ) {
		
		
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __('Related Posts', 'wpsg_core');
		}

		if ( isset( $instance[ 'cat_slug' ] ) ) {
			$cat_slug = $instance[ 'cat_slug' ];
		}
		
		$num_post = (isset($instance['num_post'])) ? $instance['num_post'] : 4;
		
		?>
		<p>
			<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e('Title:', 'wpsg_core'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_name( 'num_post' ); ?>"><?php _e('Number of Posts:', 'wpsg_core'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'num_post' ); ?>" name="<?php echo $this->get_field_name( 'num_post' ); ?>" type="text" value="<?php echo esc_attr( $num_post ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_name( 'cat_slug' ); ?>"><?php _e('Exclude Category Slug:', 'wpsg_core'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'cat_slug' ); ?>" name="<?php echo $this->get_field_name( 'cat_slug' ); ?>" type="text" value="<?php echo esc_attr( $cat_slug ); ?>" />
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['num_post'] = ( !empty( $new_instance['num_post'] ) ) ? strip_tags( $new_instance['num_post'] ) : '';
		$instance['cat_slug'] = ( !empty( $new_instance['cat_slug'] ) ) ? strip_tags( $new_instance['cat_slug'] ) : '';

		return $instance;
	}

	public static function register(){
		register_widget('SG_RelatedPostsWidget');
	}

}



add_action('widgets_init', array('SG_RelatedPostsWidget', 'register'));