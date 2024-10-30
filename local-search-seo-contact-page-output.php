<?php /*
Plugin Name: Local Search SEO Contact Page
Plugin URI: http://www.expertbusinesssearch.com/store/local-search-seo-contact-page/
Description: Easy to use plugin that provides Schema.org markup for your website, as well as shortcodes for a contact page.
Author: Expert Business Search, LLC
Version: 4.0.1
Author URI: http://www.expertbusinesssearch.com/
*/
require_once( 'local-search-seo-contact-page-functions.php' );
require_once( 'local-search-seo-contact-page-settings.php' );
require_once( 'local-search-seo-contact-page-meta-boxes.php' );
require_once( 'local-search-seo-contact-page-contextual-help.php' ); 

//Shortcodes for all or specific parts
add_shortcode( 'ebs_seo_cp_full', 'ebs_seo_cp_full' );
add_shortcode( 'ebs_seo_cp_contact_only', 'ebs_seo_cp_contact_only' );
add_shortcode( 'ebs_seo_cp_location_img_only', 'ebs_seo_cp_location_img_only' );
add_shortcode( 'ebs_seo_cp_logo_img_only', 'ebs_seo_cp_logo_img_only' );
add_shortcode( 'ebs_seo_cp_map_only', 'ebs_seo_cp_map_only' );
add_shortcode( 'ebs_seo_cp_hours_only', 'ebs_seo_cp_hours_only' );
add_shortcode( 'ebs_seo_cp_social_media_only', 'ebs_seo_cp_social_media_only' );


add_shortcode( 'local_seo_info_full', 'ebs_seo_cp_full' );
add_shortcode( 'local_seo_info_contact_only', 'ebs_seo_cp_contact_only' );
add_shortcode( 'local_seo_info_image_only', 'ebs_seo_cp_location_img_only' );
add_shortcode( 'local_seo_info_logo_only', 'ebs_seo_cp_logo_img_only' );
add_shortcode( 'local_seo_info_map_only', 'ebs_seo_cp_map_only' );
add_shortcode( 'local_seo_info_hours_only', 'ebs_seo_cp_hours_only' );
add_shortcode( 'local_seo_info_social_media_only', 'ebs_seo_cp_social_media_only' );

add_shortcode( 'seo_contact_page_info_full', 'ebs_seo_cp_full' );
add_shortcode( 'seo_contact_page_info_contact_only', 'ebs_seo_cp_contact_only' );
add_shortcode( 'seo_contact_page_info_image_only', 'ebs_seo_cp_location_img_only' );
add_shortcode( 'seo_contact_page_info_logo_only', 'ebs_seo_cp_logo_img_only' );
add_shortcode( 'seo_contact_page_info_map_only', 'ebs_seo_cp_map_only' );
add_shortcode( 'seo_contact_page_info_hours_only', 'ebs_seo_cp_hours_only' );
add_shortcode( 'seo_contact_page_info_social_media_only', 'ebs_seo_cp_social_media_only' );

$ebs_seo_cp_location_query_args = array( 
	'orderby' => 'ID',
	'order' => 'ASC',
	'post_type' => 'ebs_location',
	'posts_per_page' => -1,
);
$ebs_seo_cp_locations = get_posts( $ebs_seo_cp_location_query_args ); 

/**
 * Plugin link manipulator
 * 
 * Add an upgrade CTA to plugin object on plugins page
 * 
 * @since 4.0.0
 * 
 */
add_filter( 'plugin_action_links', 'ebs_seo_cp_action_links', 10, 2 );
function ebs_seo_cp_action_links( $links, $file ) {
    static $this_plugin;
    if ( !$this_plugin) {
 
        $this_plugin = plugin_basename( __FILE__ );
    }
    if ( $file == $this_plugin ) {
 
        $link = '<a href="' . get_bloginfo( 'wpurl' ) . '/wp-admin/admin.php?page=local_search_seo_contact_page_settings#upgrade">Upgrade to premium</a>';
 		array_unshift( $links, $link );
    }
 
    return $links;
}

/**
 * Render the json for location data in header
 * 
 * Creates the JSON for the schema.org location data
 * 
 * @since 4.0.0
 * 
 * @global array $ebs_seo_cp_locations Array of CPT posts
 * 
 */
add_action( 'wp_head', 'ebs_seo_cp_output_jsonld');
function ebs_seo_cp_output_jsonld( ) {
	global $ebs_seo_cp_locations;

	$location = $ebs_seo_cp_locations[0]->ID;
	$location = apply_filters( 'ebs_seo_cp_set_location', $location, 'json' );

	
	$options = ebs_seo_cp_get_options( $location );

	if ( ! empty( $options['ebs_seo_cp_uri'] ) ) { $ebs_seo_cp_LocalBusiness['@id'] = $options['ebs_seo_cp_uri']; }
	if ( ! empty( $options['ebs_seo_cp_name'] ) ) { 
		$ebs_seo_cp_LocalBusiness['@type'] = 'LocalBusiness';
		$ebs_seo_cp_LocalBusiness['name'] = $options['ebs_seo_cp_name'];
	}

	if ( ! empty( $options['ebs_seo_cp_street'] ) ) { 
		$ebs_seo_cp_PostalAddress['@type'] = 'PostalAddress'; 
		$ebs_seo_cp_PostalAddress['streetAddress'] = $options['ebs_seo_cp_street']; 
	}
	if ( ! empty( $options['ebs_seo_cp_unit'] ) ) { $ebs_seo_cp_PostalAddress['streetAddress'] .= ' ' . $options['ebs_seo_cp_unit']; }
	if ( ! empty( $options['ebs_seo_cp_city'] ) ) { $ebs_seo_cp_PostalAddress['addressLocality'] = $options['ebs_seo_cp_city']; }
	if ( ! empty( $options['ebs_seo_cp_state'] ) ) { $ebs_seo_cp_PostalAddress['addressRegion'] = $options['ebs_seo_cp_state']; }
	if ( ! empty( $options['ebs_seo_cp_zip'] ) ) { $ebs_seo_cp_PostalAddress['postalCode'] = $options['ebs_seo_cp_zip']; }
	if ( ! empty( $options['ebs_seo_cp_country'] ) ) { $ebs_seo_cp_PostalAddress['addressCountry'] = $options['ebs_seo_cp_country']; }
	if ( ! empty( $ebs_seo_cp_PostalAddress ) ) { $ebs_seo_cp_LocalBusiness['address'] = $ebs_seo_cp_PostalAddress; }

	if ( ( ! empty( $options['ebs_seo_cp_latitude'] ) ) && ( ! empty( $options['ebs_seo_cp_longitude'] ) ) ) {
		$ebs_seo_cp_GeoCoordinates = array(
			'@type'             => 'GeoCoordinates',
			'latitude'          => $options['ebs_seo_cp_latitude'],
			'longitude'         => $options['ebs_seo_cp_longitude']
		);
		$ebs_seo_cp_LocalBusiness['geo'] = $ebs_seo_cp_GeoCoordinates;
	}

	$ebs_seo_cp_hours = array(
		'Sunday' => array(
					'open_check' => $options['ebs_seo_cp_hours_sunday_check_open'],
					'shortname' => 'Su',
					'open' =>  $options['ebs_seo_cp_hours_sunday_open'],
					'close' => $options['ebs_seo_cp_hours_sunday_close'],
					),
		'Monday' => array( 
					'open_check' => $options['ebs_seo_cp_hours_monday_check_open'],
					'shortname' => 'Mo',
					'open' =>  $options['ebs_seo_cp_hours_monday_open'],
					'close' => $options['ebs_seo_cp_hours_monday_close'],
					),
		'Tuesday' => array( 
					'open_check' => $options['ebs_seo_cp_hours_tuesday_check_open'],
					'shortname' => 'Tu',
					'open' =>  $options['ebs_seo_cp_hours_tuesday_open'],
					'close' => $options['ebs_seo_cp_hours_tuesday_close'],
					),
		'Wednesday' => array( 
					'open_check' => $options['ebs_seo_cp_hours_wednesday_check_open'],
					'shortname' => 'We',
					'open' =>  $options['ebs_seo_cp_hours_wednesday_open'],
					'close' => $options['ebs_seo_cp_hours_wednesday_close'],
					),
		'Thursday' => array( 
					'open_check' => $options['ebs_seo_cp_hours_thursday_check_open'],
					'shortname' => 'Th',
					'open' =>  $options['ebs_seo_cp_hours_thursday_open'],
					'close' => $options['ebs_seo_cp_hours_thursday_close'],
					),
		'Friday' => array( 
					'open_check' => $options['ebs_seo_cp_hours_friday_check_open'],
					'shortname' => 'Fr',
					'open' =>  $options['ebs_seo_cp_hours_friday_open'],
					'close' => $options['ebs_seo_cp_hours_friday_close'],
					),
		'Saturday' => array(
					'open_check' => $options['ebs_seo_cp_hours_saturday_check_open'],
					'shortname' => 'Sa',
					'open' =>  $options['ebs_seo_cp_hours_saturday_open'],
					'close' => $options['ebs_seo_cp_hours_saturday_close'],
					),
	);
	foreach ( $ebs_seo_cp_hours as $day ) {
		if ( $day['open_check'] == 'on' ) { $ebs_seo_cp_openingHours .= $day['shortname'] . " " . date( 'H:i', strtotime( $day['open'] ) ) . "-" .  date( 'H:i', strtotime( $day['close'] ) ) . ","; }
	}
	if ( !empty( $ebs_seo_cp_openingHours ) ) { $ebs_seo_cp_LocalBusiness['openingHours'] = $ebs_seo_cp_openingHours; }
	
	if ( ! empty( $options['ebs_seo_cp_url'] ) ) { $ebs_seo_cp_LocalBusiness['url'] = $options['ebs_seo_cp_url']; }
	if ( ! empty( $options['ebs_seo_cp_email'] ) ) { $ebs_seo_cp_LocalBusiness['email'] = $options['ebs_seo_cp_email']; }
	if ( ! empty( $options['ebs_seo_cp_phone_1'] ) ) { $ebs_seo_cp_LocalBusiness['telephone'][] = $options['ebs_seo_cp_phone_1']; }
	if ( ! empty( $options['ebs_seo_cp_phone_2'] ) ) { $ebs_seo_cp_LocalBusiness['telephone'][] = $options['ebs_seo_cp_phone_2']; }
	if ( ! empty( $options['ebs_seo_cp_phone_3'] ) ) { $ebs_seo_cp_LocalBusiness['faxNumber'] = $options['ebs_seo_cp_phone_3']; }
	if ( ! empty( $options['ebs_seo_cp_description'] ) ) { $ebs_seo_cp_LocalBusiness['description']  = $options['ebs_seo_cp_description']; }
	if ( ! empty( $options['ebs_seo_cp_price_range'] ) ) { $ebs_seo_cp_LocalBusiness['priceRange']  = $options['ebs_seo_cp_price_range']; }
	if ( ! empty( $options['ebs_seo_cp_payments_accepted'] ) ) { $ebs_seo_cp_LocalBusiness['paymentAccepted']  = $options['ebs_seo_cp_payments_accepted']; }
	if ( ! empty( $options['ebs_seo_cp_currencies_accepted'] ) ) { $ebs_seo_cp_LocalBusiness['currenciesAccepted']  = $options['ebs_seo_cp_currencies_accepted']; }
	if ( ! empty( $options['ebs_seo_cp_location_img'] ) ) { $ebs_seo_cp_LocalBusiness["image"] = $options['ebs_seo_cp_location_img']; }
	if ( ! empty( $options['ebs_seo_cp_logo_img'] ) ) { $ebs_seo_cp_LocalBusiness['logo'] = $options['ebs_seo_cp_logo_img']; }
	if ( ! empty( $options['ebs_seo_cp_google_map_override'] ) ) { $ebs_seo_cp_LocalBusiness['hasMap'] = $options['ebs_seo_cp_google_map_override']; }
	
	$ebs_seo_cp_sameAs = array ();
		$social_list = array( 'ebs_seo_cp_facebook', 'ebs_seo_cp_twitter', 'ebs_seo_cp_youtube', 'ebs_seo_cp_linkdin', 'ebs_seo_cp_google_my_business', 'ebs_seo_cp_google_plus', 'ebs_seo_cp_yelp', 'ebs_seo_cp_pinterest', 'ebs_seo_cp_hotfrog', 'ebs_seo_cp_foursquare', 'ebs_seo_cp_flickr', 'ebs_seo_cp_digg', 'ebs_seo_cp_reddit', 'ebs_seo_cp_tumblr', 'ebs_seo_cp_stumbleupon', 'ebs_seo_cp_delicius', 'ebs_seo_cp_merchant_circle');
		foreach ( $social_list as $social ) {
			if ( !empty( $options[$social]  ) ) { $ebs_seo_cp_sameAs[] = $options[$social]; }
		}			
	if ( count( $ebs_seo_cp_sameAs ) > 0 ) { $ebs_seo_cp_LocalBusiness['sameAs'] = $ebs_seo_cp_sameAs; }
	

	if ( count( $ebs_seo_cp_LocalBusiness ) > 0 ) {	
		//LocalBusiness schema has data. Set the schema context and send to json output	
		$ebs_seo_cp_output_jsonld = array( '@context' => 'http://schema.org' ) + $ebs_seo_cp_LocalBusiness;
	} 

	$ebs_seo_cp_output_jsonld_out = apply_filters( 'ebs_seo_cp_filter_json_array', $ebs_seo_cp_output_jsonld );

	//echo json data if present
	if ( count( $ebs_seo_cp_output_jsonld_out ) > 0 ) {
		echo "\n" . '<script type="application/ld+json">';
		echo "\n" . json_encode( $ebs_seo_cp_output_jsonld_out, JSON_PRETTY_PRINT );
		echo "\n" . '</script>';
	}
}

/**
 * Render the full shortcode, calls all subsequent shortcodes 
 * 
 * Creates the HTML for the full output shortcode
 * 
 * @since 4.0.0
 * 
 * @global array $ebs_seo_cp_locations Array of CPT posts
 * 
 * @param array $atts {
 * 	    Short code paramater attributes (from editor)
 * 
 * 		@type string $location ID of location post type to display
 * 		@type string $link_in_new_window Open links in a new window, on/off (checkbox value)
 * 		@type string $width Embedded map width
 * 		@type string $height Embedded map height
 * }
 * @param string $content unused
 * @param string $tag unused
 */
function ebs_seo_cp_full( $atts, $content = null, $tag ) {
	global $ebs_seo_cp_locations;
	$ebs_seo_cp_full_shortcode_format = stripslashes( get_option( 'ebs_seo_cp_full_shortcode_format' ) );
	$atts = shortcode_atts( array(
		  'location' => $ebs_seo_cp_locations[0]->ID,
		  'link_in_new_window' => 'on',
		  'height' => '',
		  'width' => '',
		  ), $atts );

	$atts['location'] = apply_filters( 'ebs_seo_cp_set_location', $atts['location'], 'shortcode' );

	$options = ebs_seo_cp_get_options( $atts['location'] );
		
	//Piece together full page from individual shortcodes. Try and keep whitespace under control (missing elements not leaving behind placeholder whitespace)
	$ebs_seo_cp_content = ebs_seo_cp_header();
	
	if ( empty( $ebs_seo_cp_full_shortcode_format ) ) {
		$ebs_seo_cp_full_shortcode_format = '
	<div style="display: table; width: 100%;">
		<div style="display: table-row-group;">
			<div style="display: table-row;">
				<div style="display: table-cell;">{logo}</div>
				<div style="display: table-cell;">{image}</div>
			</div>
			<div style="display: table-row;">
				<div style="display: table-cell;">{contact-info}</div>
				<div style="display: table-cell;">{hours}</div>
			</div>
		</div>
	</div>
	<div style="width: 100%;">
		{social-media}
	</div>
	<div style="width: 100%;">
		{map}
	</div>';
	}
	$patterns = array(
		0 => '/{contact-info}/', 
		1 => '/{hours}/',
		2 => '/{logo}/',
		3 => '/{image}/',
		4 => '/{social-media}/',
		5 => '/{map}/'
	);
	$replacements = array(
		0 => ebs_seo_cp_contact_only( $atts, $content, $tag, false ),
		1 => ebs_seo_cp_hours_only( $atts, $content, $tag, false ),
		2 => ebs_seo_cp_logo_img_only( $atts, $content, $tag, false ),
		3 => ebs_seo_cp_location_img_only( $atts, $content, $tag, false ),
		4 => ebs_seo_cp_social_media_only( $atts, $content, $tag, false ),
		5 => ebs_seo_cp_map_only( $atts, $content, $tag, false )
	);
	$ebs_seo_cp_content .= preg_replace( $patterns, $replacements, $ebs_seo_cp_full_shortcode_format );
	
	$ebs_seo_cp_content .= ebs_seo_cp_footer();
	return $ebs_seo_cp_content;
}

/**
 * Render the head of  shortcode output
 * 
 * Creates the HTML for the head used in all shortcode output as wrapper
 * 
 * @since 4.0.0
 * 
 */
function ebs_seo_cp_header() {
	$header_blob = '<!-- Begin ExpertBusinessSearch.com Local Search SEO Contact Page output --> <div class="ebs-seo-cp-container ebs-seo-cp">';
	return $header_blob;
}

/**
 * Render the footer of  shortcode output
 * 
 * Creates the HTML for the foot used in all shortcode output as wrapper
 * 
 * @since 4.0.0
 * 
 */
function ebs_seo_cp_footer() {
	return '</div><!-- End Local Search SEO Contact Page output -->';
}

/**
 * Render the location image shortcode for output
 * 
 * Creates the HTML for the location image shortcode
 * 
 * @since 4.0.0
 * 
 * @global array $ebs_seo_cp_locations Array of CPT posts
 * 
 * @param array $atts {
 * 	    Short code paramater attributes (from editor)
 * 
 * 		@type string $location ID of location post type to display
 * 		@type string $link_in_new_window Open links in a new window, on/off (checkbox value)
 * }
 * @param string $content unused
 * @param string $tag unused
 * @param bool $wrap If calling this function as a single output, wrap it in a div using 
 * 					 ebs_seo_cp_header and ebs_seo_cp_footer
 */
function ebs_seo_cp_location_img_only( $atts, $content = null, $tag, $wrap = true) {
	global $ebs_seo_cp_locations;
	$atts = shortcode_atts( array(
		  'location' => $ebs_seo_cp_locations[0]->ID,
		  'link_in_new_window' => 'on',
		  ), $atts );

	$atts['location'] = apply_filters( 'ebs_seo_cp_set_location', $atts['location'], 'shortcode' );

	$options = ebs_seo_cp_get_options( $atts['location'] );
	if ( $options['ebs_seo_cp_location_img'] ) { 
		$location_blob = '';		
		//If we are viewing individual shortcode, lets wrap it in div tags
		if ( $wrap == true ) {
			$location_blob .= ebs_seo_cp_header();
		} 
		$location_blob .= '<div class="ebs-seo-cp-image-container"><img class="ebs-seo-cp-image" width="150" src="' . $options['ebs_seo_cp_location_img'] . '" title="' . $options['ebs_seo_cp_name'] . '"/></div>';
		//If we are viewing the individual shortcode, lets wrap it in div tags
		if ( $wrap == true ) {
			$location_blob .= ebs_seo_cp_footer();
		}		
		//Return our code blob
		return $location_blob; 
	}
}

/**
 * Render the logo image shortcode for output
 * 
 * Creates the HTML for the logo image shortcode
 * 
 * @since 4.0.0
 * 
 * @global array $ebs_seo_cp_locations Array of CPT posts
 * 
 * @param array $atts {
 * 	    Short code paramater attributes (from editor)
 * 
 * 		@type string $location ID of location post type to display
 * 		@type string $link_in_new_window Open links in a new window, on/off (checkbox value)
 * }
 * @param string $content unused
 * @param string $tag unused
 * @param bool $wrap If calling this function as a single output, wrap it in a div using 
 * 					 ebs_seo_cp_header and ebs_seo_cp_footer
 */
function ebs_seo_cp_logo_img_only( $atts, $content = null, $tag, $wrap = true ) {
	global $ebs_seo_cp_locations;
	$atts = shortcode_atts( array(
		  'location' => $ebs_seo_cp_locations[0]->ID,
		  'link_in_new_window' => 'on',
		  ), $atts );

	$atts['location'] = apply_filters( 'ebs_seo_cp_set_location', $atts['location'], 'shortcode' );

	$options = ebs_seo_cp_get_options( $atts['location'] );
	if ( $options['ebs_seo_cp_logo_img'] ) { 
		$logo_blob = '';
		
		//If we are viewing individual shortcode, lets wrap it in div tags
		if ( $wrap == true ) {
			$logo_blob .= ebs_seo_cp_header();
		} 
		$logo_blob .= '<div class="ebs-seo-cp-logo-container"><img class="ebs-seo-cp-logo" width="150" src="' . $options['ebs_seo_cp_logo_img'] . '" title="' . $options['ebs_seo_cp_name'] . '"/></div>';
		//If we are viewing individual shortcode, lets wrap it in div tags
		if ( $wrap == true ) {
			$logo_blob .= ebs_seo_cp_footer();
		} 
		return $logo_blob; 
	}
}

/**
 * Render the Contact info shortcode for output
 * 
 * Creates the HTML for the contact info shortcode
 * 
 * @since 4.0.0
 * 
 * @global array $ebs_seo_cp_locations Array of CPT posts
 * 
 * @param array $atts {
 * 	    Short code paramater attributes (from editor)
 * 
 * 		@type string $location ID of location post type to display
 * 		@type string $link_in_new_window Open links in a new window, on/off (checkbox value)
 * }
 * @param string $content unused
 * @param string $tag unused
 * @param bool $wrap If calling this function as a single output, wrap it in a div using 
 * 					 ebs_seo_cp_header and ebs_seo_cp_footer
 */
function ebs_seo_cp_contact_only( $atts, $content = null, $tag, $wrap = true ) {
	global $ebs_seo_cp_locations;
	$ebs_seo_cp_address_format = stripslashes( get_option( 'ebs_seo_cp_address_format' ) );
	$atts = shortcode_atts( array(
		  'location' => $ebs_seo_cp_locations[0]->ID,
		  'link_in_new_window' => 'on',
		  ), $atts );

	$atts['location'] = apply_filters( 'ebs_seo_cp_set_location', $atts['location'], 'shortcode' );
	
	$options = ebs_seo_cp_get_options( $atts['location'] );

		
	//If we are viewing individual shortcode, lets wrap it in  div tags
	if ( $wrap == true ) {
		$contact_blob .= ebs_seo_cp_header();
	}
	$contact_blob .= '<span class="ebs-seo-cp-name">' . $options['ebs_seo_cp_name'] . '</span>';
	
	if ( $options['ebs_seo_cp_street'] ) {
		$contact_blob .= '<div class="ebs-seo-cp-address">';
		if ( empty( $ebs_seo_cp_address_format ) ) {
			$ebs_seo_cp_address_format = '
			{street-address}<br />
			{city}, {state} {postal-code}<br />
			{country}';
		}
		$patterns = array(
			0 => '/{street-address}/', 
			1 => '/{city}/',
			2 => '/{state}/',
			3 => '/{postal-code}/',
			4 => '/{country}/'
		);
		$replacements = array(
			0 => '<span class="ebs-seo-cp-street-address">' . $options['ebs_seo_cp_street'] . ' ' . $options['ebs_seo_cp_unit'] . '</span>',
			1 => '<span class="ebs-seo-cp-locality">' . $options['ebs_seo_cp_city'] . '</span>',
			2 => '<span class="ebs-seo-cp-region">' . $options['ebs_seo_cp_state'] . '</span>',
			3 => '<span class="ebs-seo-cp-postal-code">' . $options['ebs_seo_cp_zip'] . '</span>',
			4 => '<span class="ebs-seo-cp-country">' . $options['ebs_seo_cp_country'] . '</span>'
		);
		$contact_blob .= preg_replace( $patterns, $replacements, $ebs_seo_cp_address_format );
		$contact_blob .= '</div>';
	}
	if ( $options['ebs_seo_cp_phone_1'] ) { 
		$phone_1_stripped = preg_replace( '[\D]', '', $options['ebs_seo_cp_phone_1'] );
		$contact_blob .= '<div class=""><span class="ebs-seo-cp-telephone">' . __('Telephone: ', 'ebs_seo_cp' ) . '</span> <abbr class="" title="+' . $phone_1_stripped . '">' . $options['ebs_seo_cp_phone_1'] . '</abbr></div>'; 
		
	}
	if ( $options['ebs_seo_cp_phone_2'] ) { 		
		$phone_2_stripped = preg_replace( '[\D]', '', $options['ebs_seo_cp_phone_2'] );
		$contact_blob .= '<div class=""><span class="ebs-seo-cp-telephone">' . __('Telephone: ', 'ebs_seo_cp' ) . '</span> <abbr class="" title="+' . $phone_2_stripped . '">' . $options['ebs_seo_cp_phone_2'] . '</abbr></div>'; 
	}
	if ( $options['ebs_seo_cp_phone_3'] ) { 		
		$phone_3_stripped = preg_replace( '[\D]', '', $options['ebs_seo_cp_phone_3'] );
		$contact_blob .= '<div class=""><span class="ebs-seo-cp-telephone">' . __('Fax: ', 'ebs_seo_cp' ) . '</span> <abbr class="" title="+' . $phone_3_stripped . '">' . $options['ebs_seo_cp_phone_3'] . '</abbr></div>'; 
		
	}
	if ( $options['ebs_seo_cp_email'] ) { $contact_blob .= '<span class="ebs-seo-cp-email">' . __('E-Mail: ', 'ebs_seo_cp' ) . '</span> <a class="" href="mailto:' . $options['ebs_seo_cp_email'] . '">' . $options['ebs_seo_cp_email'] . '</a><br />';}
	
	//If we are viewing individual shortcode, lets wrap it in div tags
	if ( $wrap == true ) {
		$contact_blob .= ebs_seo_cp_footer();
	} 
	return $contact_blob;
}

/**
 * Render the map shortcode for output
 * 
 * Creates the HTML for the map shortcode
 * 
 * @since 4.0.0
 * 
 * @global array $ebs_seo_cp_locations Array of CPT posts
 * 
 * @param array $atts {
 * 	    Short code paramater attributes (from editor)
 * 
 * 		@type string $location ID of location post type to display
 * 		@type string $link_in_new_window Open links in a new window, on/off (checkbox value)
 * 		@type string $width Embedded map width
 * 		@type string $height Embedded map height
 * }
 * @param string $content unused
 * @param string $tag unused
 * @param bool $wrap If calling this function as a single output, wrap it in a div using 
 * 					 ebs_seo_cp_header and ebs_seo_cp_footer
 */
function ebs_seo_cp_map_only( $atts, $content = null, $tag, $wrap = true ) {
	global $ebs_seo_cp_locations;
	$atts = shortcode_atts( array(
		  'location' => $ebs_seo_cp_locations[0]->ID,
		  'link_in_new_window' => 'on',
		  'width' => '',
		  'height' => '',
		  ), $atts );

	$atts['location'] = apply_filters( 'ebs_seo_cp_set_location', $atts['location'], 'shortcode' );
		  
	$options = ebs_seo_cp_get_options( $atts['location'] );	
	
	$map_blob = '<div class="ebs-seo-cp-map-container">';
	if ( isset( $atts['height'] ) && $atts['height'] != '' ) {
		$h = $atts['height'];
	} 
    //else if ( isset( $options['ebs_seo_cp_google_map_height'] ) ) {
	//	$h =  get_post_meta( $location, 'ebs_seo_cp_google_map_height', true );
	//} else {
	//	$h = '350';
	//}
	if ( isset( $atts['width'] ) && $atts['width'] != '' ) {
		$w = $atts['width'];
	} 
    //else if ( isset( $options['ebs_seo_cp_google_map_width'] ) ) {
	//	$w = get_post_meta( $location, 'ebs_seo_cp_google_map_width', true );
	//} else {
	//	$w = '100%';
	//}
    $size = '';
    if ( isset( $h ) && isset( $w ) ) {
        $size = " width='{$w}' height='{$h}'";
    }
	$map_blob .= '<iframe width="' . $w . '" height="' . $h . '" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="' . $options['ebs_seo_cp_google_map_override'] . '&output=embed"></iframe>';
	$map_blob .= '</div>';
	return $map_blob;
}

/**
 * Render the hours shortcode for output
 * 
 * Creates the HTML for the hours shortcode
 * 
 * @since 4.0.0
 * 
 * @global array $ebs_seo_cp_locations Array of CPT posts
 * 
 * @param array $atts {
 * 	    Short code paramater attributes (from editor)
 * 
 * 		@type string $location ID of location post type to display
 * 		@type string $link_in_new_window Open links in a new window, on/off (checkbox value)
 * }
 * @param string $content unused
 * @param string $tag unused
 * @param bool $wrap If calling this function as a single output, wrap it in a div using 
 * 					 ebs_seo_cp_header and ebs_seo_cp_footer
 */
function ebs_seo_cp_hours_only( $atts, $content = null, $tag, $wrap = true ) {
	global $ebs_seo_cp_locations;
	$atts = shortcode_atts( array(
		  'location' => $ebs_seo_cp_locations[0]->ID,
		  'link_in_new_window' => 'on',
		  ), $atts );

	$atts['location'] = apply_filters( 'ebs_seo_cp_set_location', $atts['location'], 'shortcode' );
		  
	$options = ebs_seo_cp_get_options( $atts['location'] );
	$ebs_seo_cp_hours = array(
						'sunday' => array(
									'closed' => $options['ebs_seo_cp_hours_sunday_check_open'],
									'open' =>  $options['ebs_seo_cp_hours_sunday_open'],
									'close' => $options['ebs_seo_cp_hours_sunday_close'],
									'label' => __( 'Sunday', 'ebs_seo_cp' )
									),
						'monday' => array( 
									'closed' => $options['ebs_seo_cp_hours_monday_check_open'],
									'open' =>  $options['ebs_seo_cp_hours_monday_open'],
									'close' => $options['ebs_seo_cp_hours_monday_close'],
									'label' => __( 'Monday', 'ebs_seo_cp' )
									),
						'tuesday' => array( 
									'closed' => $options['ebs_seo_cp_hours_tuesday_check_open'],
									'open' =>  $options['ebs_seo_cp_hours_tuesday_open'],
									'close' => $options['ebs_seo_cp_hours_tuesday_close'],
									'label' => __( 'Tuesday', 'ebs_seo_cp' )
									),
						'wednesday' => array( 
									'closed' => $options['ebs_seo_cp_hours_wednesday_check_open'],
									'open' =>  $options['ebs_seo_cp_hours_wednesday_open'],
									'close' => $options['ebs_seo_cp_hours_wednesday_close'],
									'label' => __( 'Wednesday', 'ebs_seo_cp' )
									),
						'thursday' => array( 
									'closed' => $options['ebs_seo_cp_hours_thursday_check_open'],
									'open' =>  $options['ebs_seo_cp_hours_thursday_open'],
									'close' => $options['ebs_seo_cp_hours_thursday_close'],
									'label' => __( 'Thursday', 'ebs_seo_cp' )
									),
						'friday' => array( 
									'closed' => $options['ebs_seo_cp_hours_friday_check_open'],
									'open' =>  $options['ebs_seo_cp_hours_friday_open'],
									'close' => $options['ebs_seo_cp_hours_friday_close'],
									'label' => __( 'Friday', 'ebs_seo_cp' )
									),
						'saturday' => array(
									'closed' => $options['ebs_seo_cp_hours_saturday_check_open'],
									'open' =>  $options['ebs_seo_cp_hours_saturday_open'],
									'close' => $options['ebs_seo_cp_hours_saturday_close'],
									'label' => __( 'Saturday', 'ebs_seo_cp' )
									),
						);
	$hours_blob = '';					
	if ( $wrap == true ) { $hours_blob .= ebs_seo_cp_header(); } 

	$hours_blob .= '<span class="ebs-seo-cp-hours">' . __( 'Hours', 'ebs_seo_cp' ) . '</span>' . '';
	$hours_blob .= '<div style="display: table; width: 100%;"><div style="display: table-row-group;">';
	
	//TODO: Fix start day?
	foreach ( $ebs_seo_cp_hours as $key => $day ) {
		if ( $key != strtolower( $options['ebs_seo_cp_hours_startday'] ) ) {
			$orphan_day = array_shift( $ebs_seo_cp_hours );
			array_push( $ebs_seo_cp_hours, $orphan_day );
		} else { 
			break;
		}
	}

	foreach ( $ebs_seo_cp_hours as $key => $day ) {
		if  ( $day['closed'] != 'on' ) {
			$longhours = __( 'Closed', 'ebs_seo_cp' );	
		} else {
			if ( $atts['ebs_seo_cp_hours_24h'] == 'on' ) {
				$longhours = date( 'G:i', strtotime( $day['open'] ) ) . ' - ' . date( 'G:i', strtotime( $day['close'] ) );
			} else {
				$longhours = date( 'g:i a', strtotime( $day['open'] ) ) . ' - ' . date( 'g:i a', strtotime( $day['close'] ) );
			}
		}
		$hours_blob .= "<div style='display: table-row;'><div style='display: table-cell;'><span class='ebs-seo-cp-dayname'>{$day['label']}:</span></div><div style='display: table-cell;'><span class='ebs-seo-cp-hoursout'>{$longhours}</span></div></div>";
	}

	$hours_blob .= '</div></div>';
	if ( $wrap == true ) { $hours_blob .= ebs_seo_cp_footer(); } 

	return $hours_blob;
}

/**
 * Render the social media links shortcode for output
 * 
 * Creates the HTML for the Social media shortcode
 * 
 * @since 4.0.0
 * 
 * @global array $ebs_seo_cp_locations Array of CPT posts
 * 
 * @param array $atts {
 * 	    Short code paramater attributes (from editor)
 * 
 * 		@type string $location ID of location post type to display
 * 		@type string $link_in_new_window Open links in a new window, on/off (checkbox value)
 * }
 * @param string $content unused
 * @param string $tag unused
 * @param bool $wrap If calling this function as a single output, wrap it in a div using 
 * 					 ebs_seo_cp_header and ebs_seo_cp_footer
 */
function ebs_seo_cp_social_media_only( $atts, $content = null, $tag, $wrap = true ) {
	global $ebs_seo_cp_locations;
	$atts = shortcode_atts( array(
		  'location' => $ebs_seo_cp_locations[0]->ID,
		  'link_in_new_window' => 'on',
		  ), $atts );

	$atts['location'] = apply_filters( 'ebs_seo_cp_set_location', $atts['location'], 'shortcode' );
		  
	$options = ebs_seo_cp_get_options( $atts['location'] );
	$social_media_blob = '';
	if ( $wrap == true ) {
		$social_media_blob .= ebs_seo_cp_header();
	} 
	$contact_link_target = ( $atts['link_in_new_window'] == 'on' ? '_blank' : '_top' );
	$social_media_list = array(
		'ebs_seo_cp_facebook' => 'Facebook',
		'ebs_seo_cp_twitter' => 'Twitter',
		'ebs_seo_cp_linkedin' => 'LinkedIn',
		'ebs_seo_cp_yelp' => 'Yelp',
		'ebs_seo_cp_youtube' => 'YouTube',
		'ebs_seo_cp_pinterest' => 'Pinterest',
		'ebs_seo_cp_google_my_business' => 'Google-My-Business',
		'ebs_seo_cp_google_plus' => 'Google-Plus',
		'ebs_seo_cp_flickr' => 'Flickr',
		'ebs_seo_cp_tumblr' => 'Tumblr',
		'ebs_seo_cp_reddit' => 'Reddit',
		'ebs_seo_cp_stumbleupon' => 'StumbleUpon',
		'ebs_seo_cp_foursquare' => 'FourSquare',
		'ebs_seo_cp_digg' => 'Digg',
		'ebs_seo_cp_delicious' => 'Del.icio.us',
		'ebs_seo_cp_merchant_circle' => 'Merchant-Circle',
		'ebs_seo_cp_hotfrog' => 'HotFrog',
	);

	$social_media_blob .= '<div class="ebs-seo-cp-social-media-container" style="width:100%;">';
	foreach ( $social_media_list as $k => $v ) {
		if ( ! empty( $options[$k] ) ) { 
			$social_media_blob .= "<a class='ebs-seo-cp-social-media-link' target='{$contact_link_target}' href='{$options[$k]}'>";
			$social_media_blob .= "<img  class='ebs-seo-cp-social-media-link-image' src='" . plugins_url( "images/Expert-Business-Search-Com-Local-SEO-Plugin-{$v}-Logo.png", __FILE__) . "'></a>";	
		}
	}
	$social_media_blob .= "</div>";
	if ( $wrap == true ) {
		$social_media_blob .= ebs_seo_cp_footer();
	} 
	return $social_media_blob;
}

/**
 * Activation hook function
 * 
 * Migrates data from old options page in 2.0 to post type then deletes it, also initializes upgrade notice 
 * 
 * @since 4.0.0
 */
register_activation_hook( __FILE__, 'ebs_seo_cp_activate' );
function ebs_seo_cp_activate() {

	update_option( 'ebs_seo_cp_upgrade_premium_dismiss', 'upgrade' );

    $check_free = get_option('ebs_seo_cp_name');
    if ( ! empty( $check_free ) ) {
        $check_free = true;
    } else {
        $check_free = false;
    }

    if ( $check_free ) {
        //free data present
        $_POST['ebs_seo_cp_url'] = get_option('ebs_seo_cp_url');
        $_POST['ebs_seo_cp_name'] = get_option('ebs_seo_cp_name');
        $_POST['ebs_seo_cp_street'] = get_option('ebs_seo_cp_address');
        $_POST['ebs_seo_cp_unit'] = get_option('ebs_seo_cp_apt');
        $_POST['ebs_seo_cp_city'] = get_option('ebs_seo_cp_city');
        $_POST['ebs_seo_cp_state'] = get_option('ebs_seo_cp_state');
        $_POST['ebs_seo_cp_zip'] = get_option('ebs_seo_cp_zip');
        $_POST['ebs_seo_cp_country'] = get_option('ebs_seo_cp_country');
        $_POST['ebs_seo_cp_phone_1'] = get_option('ebs_seo_cp_full_phone_1');
        $_POST['ebs_seo_cp_phone_2'] = get_option('ebs_seo_cp_full_phone_2');
        $_POST['ebs_seo_cp_phone_3'] = get_option('ebs_seo_cp_full_phone_3');
        $_POST['ebs_seo_cp_email'] = get_option('ebs_seo_cp_email');

        $_POST['ebs_seo_cp_hours_monday_check_open'] = get_option('ebs_seo_cp_monday');
        $_POST['ebs_seo_cp_hours_tuesday_check_open'] = get_option('ebs_seo_cp_tuesday');
        $_POST['ebs_seo_cp_hours_wednesday_check_open'] = get_option('ebs_seo_cp_wednesday');
        $_POST['ebs_seo_cp_hours_thursday_check_open'] = get_option('ebs_seo_cp_thursday');
        $_POST['ebs_seo_cp_hours_friday_check_open'] = get_option('ebs_seo_cp_friday');
        $_POST['ebs_seo_cp_hours_saturday_check_open'] = get_option('ebs_seo_cp_saturday');
        $_POST['ebs_seo_cp_hours_sunday_check_open'] = get_option('ebs_seo_cp_sunday');

        $_POST['ebs_seo_cp_hours_monday_open_open'] = get_option('ebs_seo_cp_open_monday');
        $_POST['ebs_seo_cp_hours_tuesday_open'] = get_option('ebs_seo_cp_open_tuesday');
        $_POST['ebs_seo_cp_hours_wednesday_open'] = get_option('ebs_seo_cp_open_wednesday');
        $_POST['ebs_seo_cp_hours_thursday_open'] = get_option('ebs_seo_cp_open_thursday');
        $_POST['ebs_seo_cp_hours_friday_open'] = get_option('ebs_seo_cp_open_friday');
        $_POST['ebs_seo_cp_hours_saturday_open'] = get_option('ebs_seo_cp_open_saturday');
        $_POST['ebs_seo_cp_hours_sunday_open'] = get_option('ebs_seo_cp_open_sunday');

        $_POST['ebs_seo_cp_hours_monday_close'] = get_option('ebs_seo_cp_close_monday');
        $_POST['ebs_seo_cp_hours_tuesday_close'] = get_option('ebs_seo_cp_close_tuesday');
        $_POST['ebs_seo_cp_hours_wednesday_close'] = get_option('ebs_seo_cp_close_wednesday');
        $_POST['ebs_seo_cp_hours_thursday_close'] = get_option('ebs_seo_cp_close_thursday');
        $_POST['ebs_seo_cp_hours_friday_close'] = get_option('ebs_seo_cp_close_friday');
        $_POST['ebs_seo_cp_hours_saturday_close'] = get_option('ebs_seo_cp_close_saturday');
        $_POST['ebs_seo_cp_hours_sunday_close'] = get_option('ebs_seo_cp_close_sunday');

        $_POST['ebs_seo_cp_location_img'] = get_option('ebs_seo_cp_location_img');
        $_POST['ebs_seo_cp_logo_img'] = get_option('ebs_seo_cp_logo_img');
        $_POST['ebs_seo_cp_payments_accepted'] = get_option('ebs_seo_cp_payment');
        $_POST['ebs_seo_cp_currencies_accepted'] = get_option('ebs_seo_cp_currencies');
        $_POST['ebs_seo_cp_price_range'] = get_option('ebs_seo_cp_pricerange');
        $_POST['ebs_seo_cp_facebook'] = get_option('ebs_seo_cp_facebook');
        $_POST['ebs_seo_cp_twitter'] = get_option('ebs_seo_cp_twitter');
        $_POST['ebs_seo_cp_youtube'] = get_option('ebs_seo_cp_youtube');
        $_POST['ebs_seo_cp_linkedin'] = get_option('ebs_seo_cp_linkedin');
        $_POST['ebs_seo_cp_pinterest'] = get_option('ebs_seo_cp_pinterest');
        $_POST['ebs_seo_cp_google_my_business'] = get_option('ebs_seo_cp_googleplaces');
        $_POST['ebs_seo_cp_google_plus'] = get_option('ebs_seo_cp_googleplus');
        $_POST['ebs_seo_cp_yelp'] = get_option('ebs_seo_cp_yelp');
        $_POST['ebs_seo_cp_merchant_circle'] = get_option('ebs_seo_cp_merchantcircle');
        $_POST['ebs_seo_cp_hotfrog'] = get_option('ebs_seo_cp_hotfrog');
        $_POST['ebs_seo_cp_flickr'] = get_option('ebs_seo_cp_flickr');
        $_POST['ebs_seo_cp_digg'] = get_option('ebs_seo_cp_digg');
        $_POST['ebs_seo_cp_foursquare'] = get_option('ebs_seo_cp_foursquare');
        $_POST['ebs_seo_cp_tumblr'] = get_option('ebs_seo_cp_tumblr');
        $_POST['ebs_seo_cp_stumbleupon'] = get_option('ebs_seo_cp_stumbleupon');
        $_POST['ebs_seo_cp_delicious'] = get_option('ebs_seo_cp_delicious');
		$_POST['post_type'] = 'ebs_location';
		$_POST['ebs_seo_cp_noncename_contact'] =  wp_create_nonce( 'ebs_seo_cp_noncename_contact' );
		$_POST['ebs_seo_cp_schema_type'] = 'LocalBusiness';
        
        $postarr = array(
            'post_type' => 'ebs_location',
            'post_title' => $_POST['ebs_seo_cp_name'],
            'post_status' => 'publish'

        );
        $new_post_id = wp_insert_post($postarr);
        if ( is_numeric( $new_post_id ) && $new_post_id > 0 && ( ! is_wp_error( $new_post_id ) ) ) {
			$success_free = $new_post_id;
            //post successful, delete old data.
			delete_option('ebs_seo_cp_url');
            delete_option('ebs_seo_cp_name');
            delete_option('ebs_seo_cp_address');
            delete_option('ebs_seo_cp_apt');
            delete_option('ebs_seo_cp_city');
            delete_option('ebs_seo_cp_state');
            delete_option('ebs_seo_cp_zip');
            delete_option('ebs_seo_cp_country');
            delete_option('ebs_seo_cp_full_phone_1');
            delete_option('ebs_seo_cp_full_phone_2');
            delete_option('ebs_seo_cp_full_phone_3');
            delete_option('ebs_seo_cp_email');

            delete_option('ebs_seo_cp_monday');
            delete_option('ebs_seo_cp_tuesday');
            delete_option('ebs_seo_cp_wednesday');
            delete_option('ebs_seo_cp_thursday');
            delete_option('ebs_seo_cp_friday');
            delete_option('ebs_seo_cp_saturday');
            delete_option('ebs_seo_cp_sunday');

            delete_option('ebs_seo_cp_open_monday');
            delete_option('ebs_seo_cp_open_tuesday');
            delete_option('ebs_seo_cp_open_wednesday');
            delete_option('ebs_seo_cp_open_thursday');
            delete_option('ebs_seo_cp_open_friday');
            delete_option('ebs_seo_cp_open_saturday');
            delete_option('ebs_seo_cp_open_sunday');

            delete_option('ebs_seo_cp_close_monday');
            delete_option('ebs_seo_cp_close_tuesday');
            delete_option('ebs_seo_cp_close_wednesday');
            delete_option('ebs_seo_cp_close_thursday');
            delete_option('ebs_seo_cp_close_friday');
            delete_option('ebs_seo_cp_close_saturday');
            delete_option('ebs_seo_cp_close_sunday');

            delete_option('ebs_seo_cp_location_img');
            delete_option('ebs_seo_cp_logo_img');
            delete_option('ebs_seo_cp_payment');
            delete_option('ebs_seo_cp_currencies');
            delete_option('ebs_seo_cp_pricerange');
            delete_option('ebs_seo_cp_facebook');
            delete_option('ebs_seo_cp_twitter');
            delete_option('ebs_seo_cp_youtube');
            delete_option('ebs_seo_cp_linkedin');
            delete_option('ebs_seo_cp_pinterest');
            delete_option('ebs_seo_cp_googleplaces');
            delete_option('ebs_seo_cp_googleplus');
            delete_option('ebs_seo_cp_yelp');
            delete_option('ebs_seo_cp_merchantcircle');
            delete_option('ebs_seo_cp_hotfrog');
            delete_option('ebs_seo_cp_flickr');
            delete_option('ebs_seo_cp_digg');
            delete_option('ebs_seo_cp_foursquare');
            delete_option('ebs_seo_cp_tumblr');
            delete_option('ebs_seo_cp_stumbleupon');
			delete_option('ebs_seo_cp_delicious');
        }
    }
    
}
?>