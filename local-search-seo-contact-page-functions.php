<?php 
// Version: 4.0.1

/**
 * Admin Notices Output function
 * 
 * Generates the HTML for viewing the upgrade notice on the dashboard
 * 
 * @since 4.0.0
 */
add_action( 'admin_notices', 'ebs_seo_cp_admin_notices' );
function ebs_seo_cp_admin_notices() {
	$premium_upgrade_notice = get_option( 'ebs_seo_cp_upgrade_premium_dismiss' );
	if ( ! empty( $premium_upgrade_notice ) ) {
		$dismiss = add_query_arg( array( 'ebs_seo_cp_upgrade_premium_dismiss' => 'true' ), admin_url() );
		echo "<div class='ebs-notice notice notice-info is-dismissible' data-dismiss-url='{$dismiss}'><p>" . __( 'Thank you for using the ExpertBusinessSearch.com Local SEO Contact Page plugin! Please take a moment to consider upgrading to', 'ebs_seo_cp' ) . " <a href='https://www.expertbusinesssearch.com/local-search-plugin'>" . __('Premium', 'ebs_seo_cp') . "</a> " . __( 'for additional features such as multiple location support and much more!', 'ebs_seo_cp' ) . "</p></div>";
	}	
    if ( $_GET['page'] == 'local_search_seo_contact_page_settings' && !empty( $_POST['ebs_seo_cp_nonce'] ) ) {
        echo "<div class='ebs-notice notice notice-success is-dismissible' data-dismiss-url='{$dismiss}'><p>" . __( 'Settings saved.', 'ebs_seo_cp') . "</p></div>";
    }
}

/**
 * Admin notices dismissal function
 * 
 * Listens for a specific `$_GET` variable and if present and set correctly, removes option and dies. 
 * Called via AJAX 
 * 
 * @since 4.0.0
 */
add_action( 'admin_init', 'ebs_seo_cp_admin_notices_init' );
function ebs_seo_cp_admin_notices_init() {
	global $typenow;
	$dismiss = filter_input( INPUT_GET, 'ebs_seo_cp_upgrade_premium_dismiss', FILTER_SANITIZE_STRING );
    if ( $dismiss == 'true' ) {
		delete_option( 'ebs_seo_cp_upgrade_premium_dismiss' );
        wp_die();
    }
}

add_action( 'current_screen', 'ebs_seo_cp_current_screen' );
function ebs_seo_cp_current_screen() {
	$screen = get_current_screen();
	if ( $screen->base == 'edit' && $screen->id == 'edit-ebs_location' ) {		
		$check_allow_multiple = false;
		$check_allow_multiple = apply_filters( 'ebs_seo_cp_check_allow_multiple', $check_allow_multiple );
		if ( $check_allow_multiple !== true ) {
			echo 'Sorry, you are not allowed to access this page.';
			wp_die();
		}

	}
}

/**
 * Admin javascript output function
 * 
 * Queues and outputs javascript files and libraries for use on dashboard
 * 
 * @since 4.0.0
 */
add_action( 'admin_print_scripts', 'ebs_seo_cp_init_admin_scripts' );
function ebs_seo_cp_init_admin_scripts() {
	global $typenow;
	if ( $_GET['post_type'] == 'ebs_location' || $_GET['page'] == 'local_search_seo_contact_page_settings' || $typenow == 'ebs_location' ) { 
		
		wp_register_script( 'local-search-seo-contact-page-admin-script', plugins_url( 'inc/js/local-search-seo-contact-page-admin-script.js', __FILE__) );	
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'local-search-seo-contact-page-admin-script' );
		wp_enqueue_script( 'thickbox' );
		wp_enqueue_script( 'common' );
		wp_enqueue_script( 'wp-lists' );
		wp_enqueue_script( 'postbox' );
		wp_enqueue_media();
	}
	wp_register_script( 'local-search-seo-contact-page-admin-dismiss-script', plugins_url( 'inc/js/local-search-seo-contact-page-admin-dismiss-script.js', __FILE__) );	
	wp_enqueue_script( 'local-search-seo-contact-page-admin-dismiss-script' );
}


/**
 * Admin CSS
 * 
 * Queues and outputs CSS files and libraries for use on dashboard
 * 
 * @since 4.0.0
 */
add_action( 'admin_print_styles', 'ebs_seo_cp_init_admin_styles' );
function ebs_seo_cp_init_admin_styles() {
	global $typenow;
	if ( $_GET['post_type'] == 'ebs_location' || $_GET['page'] == 'local_search_seo_contact_page_settings' || $typenow == 'ebs_location'  ) { 
		
		wp_register_style( 'local-search-seo-contact-page-admin-stylesheet', plugins_url( 'inc/css/local-search-seo-contact-page-admin-stylesheet.css', __FILE__) );
		wp_register_style( 'fontawesome', 'https://use.fontawesome.com/releases/v5.0.13/css/all.css');

		wp_enqueue_style( 'local-search-seo-contact-page-admin-stylesheet' );
		wp_enqueue_style( 'thickbox' );
		wp_enqueue_style( 'fontawesome' );
	}
}
add_action( 'admin_head', 'ebs_sep_cp_admin_head_css' );
function ebs_sep_cp_admin_head_css() {
	global $typenow;
	if ( $_GET['post_type'] == 'ebs_location' || $typenow == 'ebs_location'  ){
		$check_allow_multiple = false;
		$check_allow_multiple = apply_filters( 'ebs_seo_cp_check_allow_multiple', $check_allow_multiple );
		
		if ( $check_allow_multiple !== true ) {
			echo '<style type="text/css">.page-title-action{display:none;}</style>';
		}
	}
}

/**
 * Admin javascript output function
 * 
 * Queues and outputs javascript files and libraries for use on frontend
 * 
 * @since 4.0.0
 */
add_action( 'wp_enqueue_scripts', 'ebs_seo_cp_init_scripts' );
function ebs_seo_cp_init_scripts() {
    wp_register_style( 'local-search-seo-contact-page-stylesheet', plugins_url( 'inc/css/local-search-seo-contact-page-stylesheet.css', __FILE__) );
    wp_enqueue_style( 'local-search-seo-contact-page-stylesheet' );
}


/**
 * Custom post type registration function
 * 
 * Registers the 'ebs_location' custom post type
 * 
 * @since 4.0.0 
 */
add_action( 'init', 'ebs_seo_cp_register_post_type_location', 0 );
function ebs_seo_cp_register_post_type_location() {
	$labels = array(
		'name'                => _x( 'Locations', 'Post Type General Name', 'ebs_seo_cp' ),
		'singular_name'       => _x( 'Location', 'Post Type Singular Name', 'ebs_seo_cp' ),
		'menu_name'           => __( 'Locations', 'ebs_seo_cp' ),
		'parent_item_colon'   => __( 'Parent Location:', 'ebs_seo_cp' ),
		'all_items'           => __( 'Edit Locations', 'ebs_seo_cp' ),
		'view_item'           => __( 'View Location', 'ebs_seo_cp' ),
		'add_new_item'        => __( 'Add New Location', 'ebs_seo_cp' ),
		'add_new'             => __( 'New Location', 'ebs_seo_cp' ),
		'edit_item'           => __( 'Edit Location', 'ebs_seo_cp' ),
		'update_item'         => __( 'Update Location', 'ebs_seo_cp' ),
		'search_items'        => __( 'Search locations', 'ebs_seo_cp' ),
		'not_found'           => __( 'No locations found', 'ebs_seo_cp' ),
		'not_found_in_trash'  => __( 'No locations found in Trash', 'ebs_seo_cp' ),
	);
	$args = array(
		'label'               => __( 'location', 'ebs_seo_cp' ),
		'description'         => __( 'Location details', 'ebs_seo_cp' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'revisions' ),
		'taxonomies'          => array(  ),
		'hierarchical'        => false,
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => 'location-menu',
		'show_in_nav_menus'   => false,
		'show_in_admin_bar'   => false,
		'menu_position'       => 60,
		'menu_icon'           => 'dashicons-location',
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'query_var'           => 'ebs_seo_cp_location',
		'rewrite'             => false,
		'capability_type'     => 'post',
	);
	register_post_type( 'ebs_location', $args );
}

/**
 * Custom Post Type save_post hook
 * 
 * Saves meta keys submitted on edit post type screen
 * 
 * @since 4.0.0
 */
add_action( 'save_post', 'ebs_seo_cp_save_postdata' );
function ebs_seo_cp_save_postdata( $post_id ) { 
	global $ebs_seo_cp_locations;

	if ( $_POST['post_type'] != 'ebs_location' ) { return; }		
	if ( ! current_user_can( 'edit_page', $post_id ) ) { return; }
	
	if ( ! isset( $_POST['ebs_seo_cp_noncename_contact'] ) || ! wp_verify_nonce( $_POST['ebs_seo_cp_noncename_contact'], 'ebs_seo_cp_noncename_contact' ) ) { return; }

	$meta_keys = array( 
		'ebs_seo_cp_name',
		'ebs_seo_cp_street',
		'ebs_seo_cp_unit',
		'ebs_seo_cp_city',
		'ebs_seo_cp_state',
		'ebs_seo_cp_zip',
		'ebs_seo_cp_country',
		'ebs_seo_cp_email',
		'ebs_seo_cp_url',
		'ebs_seo_cp_uri', 
		'ebs_seo_cp_phone_1',
		'ebs_seo_cp_phone_2',
		'ebs_seo_cp_phone_3',
		'ebs_seo_cp_hours_sunday_check_open',
		'ebs_seo_cp_hours_sunday_open',
		'ebs_seo_cp_hours_sunday_close',
		'ebs_seo_cp_hours_monday_check_open',
		'ebs_seo_cp_hours_monday_open',
		'ebs_seo_cp_hours_monday_close',
		'ebs_seo_cp_hours_tuesday_check_open',
		'ebs_seo_cp_hours_tuesday_open',
		'ebs_seo_cp_hours_tuesday_close',
		'ebs_seo_cp_hours_wednesday_check_open',
		'ebs_seo_cp_hours_wednesday_open',
		'ebs_seo_cp_hours_wednesday_close',
		'ebs_seo_cp_hours_thursday_check_open',
		'ebs_seo_cp_hours_thursday_open',
		'ebs_seo_cp_hours_thursday_close',
		'ebs_seo_cp_hours_friday_check_open',
		'ebs_seo_cp_hours_friday_open',
		'ebs_seo_cp_hours_friday_close',
		'ebs_seo_cp_hours_saturday_check_open',
		'ebs_seo_cp_hours_saturday_open',
		'ebs_seo_cp_hours_saturday_close',	
		'ebs_seo_cp_hours_startday',
		'ebs_seo_cp_location_img',
		'ebs_seo_cp_logo_img',
		'ebs_seo_cp_payments_accepted',
		'ebs_seo_cp_currencies_accepted',
		'ebs_seo_cp_price_range',
		'ebs_seo_cp_google_map_override',
		'ebs_seo_cp_facebook',
		'ebs_seo_cp_twitter',
		'ebs_seo_cp_youtube',
		'ebs_seo_cp_linkedin',
		'ebs_seo_cp_google_my_business',
		'ebs_seo_cp_google_plus',
		'ebs_seo_cp_yelp',
		'ebs_seo_cp_pinterest',
		'ebs_seo_cp_hotfrog',
		'ebs_seo_cp_foursquare',
		'ebs_seo_cp_flickr',
		'ebs_seo_cp_digg',
		'ebs_seo_cp_reddit',
		'ebs_seo_cp_tumblr',
		'ebs_seo_cp_stumbleupon',
		'ebs_seo_cp_delicious',
		'ebs_seo_cp_merchant_circle',
	);
		
	//sanitize checkbox fields
	$checkbox_array = array(
		'ebs_seo_cp_kml_include',
		'ebs_seo_cp_hours_sunday_check_open',
		'ebs_seo_cp_hours_monday_check_open',
		'ebs_seo_cp_hours_tuesday_check_open',
		'ebs_seo_cp_hours_wednesday_check_open',
		'ebs_seo_cp_hours_thursday_check_open',
		'ebs_seo_cp_hours_friday_check_open',
		'ebs_seo_cp_hours_saturday_check_open',
	);
	
	foreach ( $checkbox_array as $checkbox ) {
		if ( empty( $_POST[$checkbox] ) ) { $_POST[$checkbox] = 'off'; }
	}

	if ( empty( $_POST['ebs_seo_cp_google_map_override'] ) ) {
		$search_url = urlencode( $_POST['ebs_seo_cp_name'] ) . ',+';
		$search_url .= urlencode( $_POST['ebs_seo_cp_street'] ) . ',+';
		if ( ! empty($_POST['ebs_seo_cp_unit'] ) ) { $search_url .= urlencode( $_POST['ebs_seo_cp_unit'] ) . ',+'; }
		$search_url .= urlencode( $_POST['ebs_seo_cp_city'] ) . ',+';
		$search_url .= urlencode( $_POST['ebs_seo_cp_state'] ) . ',+';
		$search_url .= urlencode( $_POST['ebs_seo_cp_zip'] ) . ',+';
		$search_url .= urlencode( $_POST['ebs_seo_cp_country'] );
		$_POST['ebs_seo_cp_google_map_override'] = 'https://www.google.com/maps?q=' . $search_url;
	}

	if ( empty( $_POST['ebs_seo_cp_uri'] ) ) {
		$schema_uri = $_POST['ebs_seo_cp_name'] . ' ' . $_POST['ebs_seo_cp_street'];
		$_POST['ebs_seo_cp_uri'] = get_site_url( null, '', 'http' ) .'/#' .  urlencode( $schema_uri );
	}

	foreach ( $meta_keys as $meta_key ) {
		$old_meta_data = get_post_meta( $post_id, $meta_key, true );
		$new_meta_data = sanitize_text_field( $_POST[$meta_key] );

		if ( $new_meta_data && $new_meta_data != $old_meta_data ) {
			update_post_meta( $post_id, $meta_key, $new_meta_data );
		} elseif ( $new_meta_data == '' && $old_meta_data) {
			delete_post_meta( $post_id, $meta_key, $old_meta_data );
		}
	}	
}

function ebs_seo_cp_render_field( $field ) {
	
	$required = '';
	$additional_label = '';
	if ( $field['required'] === true ) { 
		//$required = " required"; 
		$additional_label = "<br /><span style='color:red;font-style:italic;font-size:smaller'>Required</span>";
	} 
	if ( $field['recommended'] === true ) { 
		$additional_label = "<br /><span style='font-style:italic;font-size:smaller'>Recommended</span>";
	} 

	echo "<tr><td class='row-title' style='width:175px;'><label for='{$field['id']}'>{$field['label']}{$additional_label}</label></td><td>";
	
	switch ( $field['type'] ) {
		case 'instructions': 
			break;
		
		case "checkbox":	
			echo "<input type='checkbox' id='{$field['id']}' name='{$field['id']}'"; 
			if ( $field['data'] == "on" ) { echo " checked='checked'"; } 
			echo ">"; 
			break;

		case 'img':
			$img_check = false;
			if ( ! empty( $field['data'] ) ) {
				$img_check = true;
			}
			echo "<div id='upload_{$field['id']}'><div class='ebs-seo-cp-img-container'>";
			if ( $img_check ) {
				echo "<img src='{$field['data']}' alt='' style='max-width:200px;' />";
			}
			echo '</div>';
			echo '<div style="width:100%;display:table;">';
			echo '<span style="width:1px;display:table-cell;margin-top:-5px;">';
			echo "<input type='button' class='button ebs-seo-cp-img-upload";
			if ( $img_check == true ) { 
				echo ' hidden';
			}
			echo "' value='" .  __( 'Upload or select an image', 'ebs_seo_cp' ) . "' />";
			echo "<input type='button'  class='button ebs-seo-cp-img-delete";
			if ( $img_check == false ) { 
				echo ' hidden';
			}
			echo "' value='" .  __( 'Remove image', 'ebs_seo_cp' ) . "' />";
			echo '</span>';
			echo "<input style='display:table-cell; width:100%'  class='ebs-seo-cp-img-id' name='{$field['id']}' id='{$field['id']}' type='text' value='{$field['data']}' {$required} />";
			echo "</div></div>";
			break;

		case 'custom':
			echo call_user_func( $field['callback'], $field );
			break;

		case 'textarea':
			echo '<textarea style="width:100%;" id="' . $field['id'] . '" name="' . $field['id'] . '" rows="10">' . $field['data'] . '</textarea><br />';
			break;
		default:
			echo "<input type='text' id='{$field['id']}' name='{$field['id']}' value='" . esc_attr( $field['data'] ) . "' style='width:100%;'{$required} /><br />";
			break;
	}
	
	echo "<span class='description'>{$field['desc']}</span></td></tr>";	
}

/**
 * Custom Post Type meta key retrieval function
 * 
 * Gets all meta keys for a given post ID
 * 
 * @since 4.0.0
 */
function ebs_seo_cp_get_options( $location ) {
	if ( get_post_type( $location )  == 'ebs_location' ) {
		$data = get_post_custom( $location );
		foreach ( $data as $k => $v ) {
			$return[$k] = $v[0];
		}
		$return['ebs_seo_cp_title'] = get_the_title( $location );
		return $return;
	}
}
?>