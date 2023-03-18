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

/*--Offset Pre_Get_Posts pagination fix--*/
//add_action('pre_get_posts', 'myprefix_query_offset', 1 );
//function myprefix_query_offset(&$query) {
//
//	if ( $query->is_home() && ! $query->is_main_query() ) {
//		return;
//	}
//
//	$offset = 3;
//
//	$ppp = get_option('posts_per_page');
//
//	if ( $query->is_paged ) {
//
//		$page_offset = $offset + ( ($query->query_vars['paged']-1) * $ppp );
//
//		$query->set('offset', $page_offset );
//
//	}
//	else {
//
//		if ( $query->is_home() && $query->is_main_query() ) {
//			$query->set('offset',$offset);
//		}
//
//	}
//}

//add_filter('found_posts', 'myprefix_adjust_offset_pagination', 1, 2 );
//function myprefix_adjust_offset_pagination($found_posts, $query) {
//
//	$offset = 3;
//
//	if ( $query->is_home()  ) {
//		return $found_posts - $offset;
//	}
//	return $found_posts;
//}


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