<?php 

// don't load directly
if (!defined('ABSPATH')) die('-1');

function wpsg_vc_admin_script(){
	wp_register_style( 'wpsg-admin-vc', plugins_url( 'assets/vc_admin.css', __DIR__ ) );
	wp_enqueue_style( 'wpsg-admin-vc' );

	// wp_register_script( 'wpsg-admin-vc', plugins_url( 'assets/vc_admin.js', __DIR__ ), array('jquery','vc_editors-templates-preview-js'), '1.9.0', true);
	// wp_enqueue_script( 'wpsg-admin-vc' );
}

add_action( 'admin_enqueue_scripts', 'wpsg_vc_admin_script' );

function wpsg_vc_init(){
	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_sg_faqs extends WPBakeryShortCodesContainer { }
		class WPBakeryShortCode_sg_faq_item extends WPBakeryShortCode { }

		class WPBakeryShortCode_sg_carousels extends WPBakeryShortCodesContainer { }
		class WPBakeryShortCode_sg_carousel_item extends WPBakeryShortCodesContainer { }

		class WPBakeryShortCode_sg_link_list extends WPBakeryShortCodesContainer { }
		class WPBakeryShortCode_sg_link_list_item extends WPBakeryShortCode { }

		class WPBakeryShortCode_sg_car_brand_list extends WPBakeryShortCodesContainer { }
		class WPBakeryShortCode_sg_car_brand_list_item extends WPBakeryShortCode { }


		class WPBakeryShortCode_sg_multi_list extends WPBakeryShortCodesContainer { }
		class WPBakeryShortCode_sg_multi_list_item extends WPBakeryShortCodesContainer { }
	}
}

add_action( 'init', 'wpsg_vc_init' );