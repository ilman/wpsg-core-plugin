<?php 

use Scienceguard\SG_FormBs;


function sg_user_avatar( $user )
{
	$attr = array('class'=>'sgtb-form-control regular-text');
    ?>
    	<hr />

        <h3>User Avatar</h3>

        <table class="form-table">
            <tr>
                <th><label>Custom Avatar</label></th>
                <td>
                    <style>
                        .custom-avatar .media-upload-preview img{ max-width:150px; }
                    </style>
                    <div class="sgtb custom-avatar" style="max-width:500px;">
                    	<?php 
                    		echo SG_FormBs::field('upload', 'user_avatar', esc_attr(get_the_author_meta('user_avatar', $user->ID)), $attr, null);
                    	?>
                    </div>
                </td>
            </tr>
        </table>
    <?php
}


add_action( 'show_user_profile', 'sg_user_avatar' );
add_action( 'edit_user_profile', 'sg_user_avatar' );


function sg_save_user_avatar( $user_id )
{
    update_user_meta( $user_id,'user_avatar', sanitize_text_field( $_POST['user_avatar'] ) );
}

add_action( 'personal_options_update', 'sg_save_user_avatar' );
add_action( 'edit_user_profile_update', 'sg_save_user_avatar' );


function sg_user_avatar_admin_enqueue_scripts() {
	global $hook_suffix;
	global $pagenow;
	global $wp_scripts;

	if($pagenow == 'profile.php' || $pagenow == 'user-edit.php'){
		wp_enqueue_media();
		// wp_enqueue_script('sg-font-google');
		// wp_enqueue_script('sg-form-upload');
		// wp_enqueue_style('sg-framework');
        SG_Builder::form_init();
	}
}

add_action( 'admin_init', 'sg_user_avatar_admin_enqueue_scripts' );


function sg_user_social_links( $user )
{
    ?>
        <hr />
        
        <h3>User Social Links</h3>

        <table class="form-table">
            <tr>
                <th><label for="facebook_profile">Facebook Profile</label></th>
                <td><input type="text" name="facebook_profile" value="<?php echo esc_attr(get_the_author_meta( 'facebook_profile', $user->ID )); ?>" class="regular-text" /></td>
            </tr>

            <tr>
                <th><label for="twitter_profile">Twitter Profile</label></th>
                <td><input type="text" name="twitter_profile" value="<?php echo esc_attr(get_the_author_meta( 'twitter_profile', $user->ID )); ?>" class="regular-text" /></td>
            </tr>

            <tr>
                <th><label for="google_profile">Google+ Profile</label></th>
                <td><input type="text" name="google_profile" value="<?php echo esc_attr(get_the_author_meta( 'google_profile', $user->ID )); ?>" class="regular-text" /></td>
            </tr>
        </table>

        <hr />
    <?php
}

add_action( 'show_user_profile', 'sg_user_social_links' );
add_action( 'edit_user_profile', 'sg_user_social_links' );


function sg_save_user_social_links( $user_id )
{
    update_user_meta( $user_id,'facebook_profile', sanitize_text_field( $_POST['facebook_profile'] ) );
    update_user_meta( $user_id,'twitter_profile', sanitize_text_field( $_POST['twitter_profile'] ) );
    update_user_meta( $user_id,'google_profile', sanitize_text_field( $_POST['google_profile'] ) );
}

add_action( 'personal_options_update', 'sg_save_user_social_links' );
add_action( 'edit_user_profile_update', 'sg_save_user_social_links' );