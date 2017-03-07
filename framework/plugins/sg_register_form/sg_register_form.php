<?php 




class SG_RegisterForm{

	/* add form element */
	function form() {
		$first_name = ( ! empty( $_POST['first_name'] ) ) ? trim( $_POST['first_name'] ) : '';

		?>
			<div class="row form-row form-row-wide">
				<div class="col-sm-6">
					<label for="first_name"><?php _e( 'First Name', 'mydomain' ) ?><br />
						<input type="text" name="first_name" id="first_name" class="input" value="<?php echo esc_attr( wp_unslash( $first_name ) ); ?>" />
					</label>
				</div>
				<!-- col -->
				<div class="col-sm-6">
					<label for="last_name"><?php _e( 'Last Name', 'mydomain' ) ?><br />
						<input type="text" name="last_name" id="last_name" class="input" value="<?php echo esc_attr( wp_unslash( $last_name ) ); ?>" />
					</label>
				</div>
				<!-- col -->
			</div>
		<?php
	}

	/* validate form submit */
	function validate( $errors, $sanitized_user_login, $user_email ) {
	
		if ( empty( $_POST['first_name'] ) || ! empty( $_POST['first_name'] ) && trim( $_POST['first_name'] ) == '' ) {
			$errors->add( 'first_name_error', __( '<strong>ERROR</strong>: You must include a first name.', 'mydomain' ) );
		}

		if ( empty( $_POST['last_name'] ) || ! empty( $_POST['last_name'] ) && trim( $_POST['last_name'] ) == '' ) {
			$errors->add( 'lastname_name_error', __( '<strong>ERROR</strong>: You must include a lastname name.', 'mydomain' ) );
		}

		return $errors;
	}

	/* save data */
	function save( $user_id ) {
		if ( ! empty( $_POST['first_name'] ) ) {
			update_user_meta( $user_id, 'first_name', trim( $_POST['first_name'] ) );
		}

		if ( ! empty( $_POST['last_name'] ) ) {
			update_user_meta( $user_id, 'last_name', trim( $_POST['last_name'] ) );
		}
	}

}



add_action('register_form', array('SG_RegisterForm', 'form'));
add_filter('registration_errors', array('SG_RegisterForm', 'validate'), 10, 3);
add_action('user_register', array('SG_RegisterForm', 'save'));
