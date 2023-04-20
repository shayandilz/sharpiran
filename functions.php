<?php
/**
 * Enqueue scripts and styles.
 */
function amaco_scripts() {

	//    <!-- Icons -->
	wp_enqueue_style( 'bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css', array());
	wp_enqueue_style( 'main-font-face', get_stylesheet_directory_uri() . '/public/fonts/Iransans/fontface.css', array());
	wp_enqueue_style( 'style', get_stylesheet_directory_uri() . '/public/css/style.css', array());
//    wp_style_add_data('style', 'rtl', 'replace');


	wp_enqueue_script( 'main-js', get_template_directory_uri() . '/public/js/app.js', array(), true );

    wp_localize_script('main-js', 'jsData', array(
        'root_url' => get_site_url(),
        'nonce' => wp_create_nonce('my-nonce'),
        'api_root' => admin_url('admin-ajax.php'),
        'user_id' => get_current_user_id(),
        'apiUser' => 'ck_1cd80595e1d0e1d7859ddfd0fe0e7d6d5479ebfb',
        'apiKey' => 'cs_a8cc4d5f113d7b6cd74265c3d75106519a530341'
    ));

}

add_action( 'wp_enqueue_scripts', 'amaco_scripts' );
add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );

add_filter( 'https_ssl_verify', '__return_false' );
add_filter( 'https_local_ssl_verify', '__return_false' );
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function baloochy_setup() {

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
	register_nav_menu( 'headerMenuLocation', 'منوی اصلی' );
	register_nav_menu( 'footerLocationOne', 'منوی اول فوتر' );
	register_nav_menu( 'footerLocationTwo', 'منوی دوم فوتر' );
}

add_action( 'after_setup_theme', 'baloochy_setup' );

/**
 * Custom template tags for this theme.
 */
//require get_template_directory() . '/inc/template-tags.php';


if ( function_exists( 'acf_add_options_page' ) ) {

	acf_add_options_page( array(
		'page_title' => 'تنظیمات پوسته',
		'menu_title' => 'تنظیمات پوسته',
		'menu_slug'  => 'theme-general-settings',
		'capability' => 'edit_posts',
		'redirect'   => false
	) );
}


function add_menu_link_class( $classes, $item, $args ) {
	if ( isset( $args->link_class ) ) {
		$classes['class'] = $args->link_class;
	}

	return $classes;


}

add_filter( 'nav_menu_link_attributes', 'add_menu_link_class', 1, 3 );

//add_filter( 'walker_nav_menu_start_el', 'parent_menu_dropdown', 10, 4 );
//function parent_menu_dropdown( $item_output, $item, $depth, $args ) {
//
//	$icon = get_field( 'menu_icon', $item );
//	if ( ! empty( $item->classes ) && in_array( 'menu-item-object-custom', $item->classes ) ) {
//		return $item_output . ' <div class="position-relative"> ' . $icon . '</div>';
//	}
//
//	return $item_output;
//}

//populate gravity form
/**
 * Populate ACF select field options with Gravity Forms forms
 */
//function acf_populate_gf_forms_ids( $field ) {
//	if ( class_exists( 'GFFormsModel' ) ) {
//		$choices = [];
//
//		foreach ( \GFFormsModel::get_forms() as $form ) {
//			$choices[ $form->id ] = $form->title;
//		}
//
//		$field['choices'] = $choices;
//	}
//
//	return $field;
//}
//
//add_filter( 'acf/load_field/name=gravity_choices', 'acf_populate_gf_forms_ids' );



// helper function to find a menu item in an array of items
function wpd_get_menu_item( $field, $object_id, $items ) {
	foreach ( $items as $item ) {
		if ( $item->$field == $object_id ) {
			return $item;
		}
	}

	return false;
}

// Add custom field to My Account page
add_action( 'woocommerce_edit_account_form', 'add_custom_field_to_my_account' );
function add_custom_field_to_my_account() {
    woocommerce_form_field(
        'user_identity', // Field ID
        array(
            'type'        => 'text',
            'label'       => __( ' شماره شناسنامه', 'woocommerce' ),
            'placeholder' => __( 'شماره شناسنامه خود را وارد کنید', 'woocommerce' ),
            'required'    => false,
            'class'       => array( 'form-row-wide' ),
            'clear'       => true,
        ),
        get_user_meta( get_current_user_id(), 'user_identity', true ) // Default value
    );
    woocommerce_form_field(
        'user_code', // Field ID
        array(
            'type'        => 'text',
            'label'       => __( 'کد ملی', 'woocommerce' ),
            'placeholder' => __( 'کد ملی خود را وارد کنید', 'woocommerce' ),
            'required'    => false,
            'class'       => array( 'form-row-wide' ),
            'clear'       => true,
        ),
        get_user_meta( get_current_user_id(), 'user_code', true ) // Default value
    );
}

// Save custom field value
add_action( 'woocommerce_save_account_details', 'save_custom_field_from_my_account', 10, 1 );
function save_custom_field_from_my_account( $user_id ) {
    if ( isset( $_POST['user_identity'] ) ) {
        update_user_meta( $user_id, 'user_identity', sanitize_text_field( $_POST['user_identity'] ) );
    }if ( isset( $_POST['user_code'] ) ) {
        update_user_meta( $user_id, 'user_code', sanitize_text_field( $_POST['user_code'] ) );
    }
}
// Add custom field data to order meta data
add_filter( 'woocommerce_rest_insert_shop_order_object', 'add_custom_field_to_order_meta_data', 10, 3 );
function add_custom_field_to_order_meta_data( $order, $request, $creating ) {
    $user_id = $order->get_customer_id();
    if ( $user_id ) {
        $custom_field_identity = get_user_meta( $user_id, 'user_identity', true );
        if ( $custom_field_identity ) {
            $order->add_meta_data( 'user_identity', $custom_field_identity, true );
        }

        $custom_field_code = get_user_meta( $user_id, 'user_code', true );
        if ( $custom_field_code ) {
            $order->add_meta_data( 'user_code', $custom_field_code, true );
        }
    }
    return $order;
}
// Add custom field to order details in WooCommerce admin dashboard
add_action( 'woocommerce_admin_order_data_after_billing_address', 'add_custom_field_to_order_details', 10, 1 );
add_action( 'woocommerce_admin_order_data_after_shipping_address', 'add_custom_field_to_order_details', 10, 1 );
function add_custom_field_to_order_details( $order ) {
    $user_id = $order->get_customer_id();
    if ( $user_id ) {
        $custom_field_identity = get_user_meta( $user_id, 'user_identity', true );
        if ( $custom_field_identity ) {
            echo '<p><strong>'.__( ' شماره شناسنامه', 'woocommerce' ).':</strong> '.$custom_field_identity.'</p>';
        }

        $custom_field_code = get_user_meta( $user_id, 'user_code', true );
        if ( $custom_field_code ) {
            echo '<p><strong>'.__( 'کد ملی', 'woocommerce' ).':</strong> '.$custom_field_code.'</p>';
        }
    }
}
// Add first name, last name, and mobile number fields to WooCommerce register form
add_action( 'woocommerce_register_form', 'add_custom_fields_to_registration_form' );
function add_custom_fields_to_registration_form() {
    ?>
    <p class="form-row form-row-first">
        <label for="first_name"><?php _e( 'First name', 'woocommerce' ); ?><span class="required">*</span></label>
        <input type="text" class="input-text" name="first_name" id="first_name" value="<?php if ( ! empty( $_POST['first_name'] ) ) echo esc_attr( $_POST['first_name'] ); ?>" required />
    </p>
    <p class="form-row form-row-last">
        <label for="last_name"><?php _e( 'Last name', 'woocommerce' ); ?><span class="required">*</span></label>
        <input type="text" class="input-text" name="last_name" id="last_name" value="<?php if ( ! empty( $_POST['last_name'] ) ) echo esc_attr( $_POST['last_name'] ); ?>" required />
    </p>
    <div class="clear"></div>
    <p class="form-row form-row-wide">
        <label for="mobile_number"><?php _e( 'Mobile number', 'woocommerce' ); ?><span class="required">*</span></label>
        <input type="tel" class="input-text" name="mobile_number" id="mobile_number" value="<?php if ( ! empty( $_POST['mobile_number'] ) ) echo esc_attr( $_POST['mobile_number'] ); ?>" required />
    </p>
    <?php
}

// Save first name, last name, and mobile number fields to user meta data
add_action( 'woocommerce_created_customer', 'save_custom_fields_to_user_meta_data' );
function save_custom_fields_to_user_meta_data( $customer_id ) {
    if ( isset( $_POST['first_name'] ) ) {
        update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['first_name'] ) );
        wc_add_notice( __( 'First name added.', 'woocommerce' ), 'success' );
    }
    if ( isset( $_POST['last_name'] ) ) {
        update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['last_name'] ) );
        wc_add_notice( __( 'Last name added.', 'woocommerce' ), 'success' );
    }
    if ( isset( $_POST['mobile_number'] ) ) {
        update_user_meta( $customer_id, 'mobile_number', sanitize_text_field( $_POST['mobile_number'] ) );
        wc_add_notice( __( 'Mobile number added.', 'woocommerce' ), 'success' );
    }
}

function the_breadcrumb() {
	global $post;
	echo '<ul class="breadcrumb my-0 py-4">';
	if (!is_home()) {
		echo '<li class="breadcrumb-item"><a class="text-decoration-none text-semi-light" href="';
		echo get_option('home');
		echo '">';
		echo 'صفحه اصلی';
		echo '</a></li>';
        $terms = get_the_terms( $post->ID, 'product_categories' );
        $termName = $terms[0]->name;
		if (is_category() || is_single() || $termName) {
			echo '<li class="breadcrumb-item"><a class="breadcrumb-item text-white text-decoration-none" href="' . $termName->slug . '">';
            echo $termName;
			if (is_single()) {
				echo '</a></li><li class="breadcrumb-item">';
				the_title();
				echo '</li>';
			}
		} elseif (is_page()) {
			if($post->post_parent){
				$anc = get_post_ancestors( $post->ID );
				$title = get_the_title();
				foreach ( $anc as $ancestor ) {
					$output = '<li><a class="breadcrumb-item" href="'.get_permalink($ancestor).'" title="'.get_the_title($ancestor).'">'.get_the_title($ancestor).'</a></li> <li class="separator">/</li>';
				}
				echo $output;
				echo '<strong title="'.$title.'"> '.$title.'</strong>';
			} else {
				echo '<li class="breadcrumb-item"><strong> '.get_the_title().'</strong></li>';
			}
		}
	}
	echo '</ul>';
}
/**
 * Disable the emoji's
 */
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}

add_action( 'init', 'disable_emojis' );

/**
 * Filter function used to remove the tinymce emoji plugin.
 *
 * @param array $plugins
 *
 * @return array Difference betwen the two arrays
 */
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @param array $urls URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 *
 * @return array Difference betwen the two arrays.
 */
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' == $relation_type ) {
		/** This filter is documented in wp-includes/formatting.php */
		$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );

		$urls = array_diff( $urls, array( $emoji_svg_url ) );
	}

	return $urls;
}


add_filter( 'is_xml_preprocess_enabled', 'wpai_is_xml_preprocess_enabled', 10, 1 );
function wpai_is_xml_preprocess_enabled( $is_enabled ) {
	return false;
}
//function removeWooCommerceDownloadSection($items) {
//    unset( $items['downloads'] );
//    return $items;
//}
//add_filter('woocommerce_account_menu_items', 'removeWooCommerceDownloadSection', 10, 1);


// create hook for file uploading
add_action('wp_ajax_nopriv_upload_file', 'upload_file_callback');
add_action('wp_ajax_upload_file', 'upload_file_callback');

function upload_file_callback()
{
    // check security nonce which one we created in html form and sending with data.
    check_ajax_referer('uploadingFile', 'security');

    // removing white space
    $fileName = preg_replace('/\s+/', '-', $_FILES["file"]["name"]);

    // removing special character but keep . character because . seprate to extantion of file
    $fileName = preg_replace('/[^A-Za-z0-9.\-]/', '', $fileName);

    // rename file using time
    $fileName = time() . '-' . $fileName;

    // upload file
    if (wp_upload_bits($fileName, null, file_get_contents($_FILES["file"]["tmp_name"]))) {
        var_dump(wp_upload_bits($fileName, null, file_get_contents($_FILES["file"]["tmp_name"]))['url']);
    } else {
        echo json_encode(['code' => 404, 'msg' => 'Some thing is wrong! Try again.']);
    }
}