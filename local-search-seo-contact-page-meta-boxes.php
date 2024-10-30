<?php 
// Version: 4.0.1
	
if ( stristr( trim( $_SERVER["REQUEST_URI"] , '/' ), 'post-new.php' ) !== FALSE ) { $ebs_seo_cp_new_post = true; }
		
/**
 * Create meta boxes for custom post type edit page
 * 
 * Creates the JSON for the schema.org location data
 * 
 * @since 4.0.0
 * 
 * @global array $ebs_seo_cp_locations Array of CPT posts
 * 
 * @param WP_Post $post Post object for current editor 
 */
add_action( 'add_meta_boxes', 'ebs_seo_cp_add_location_edit_meta_boxes' );
function ebs_seo_cp_add_location_edit_meta_boxes() {
	global $ebs_seo_cp_locations;
	$list = array( 'slugdiv', 'revisionsdiv' );
	foreach ( $list as $id ) {
		remove_meta_box( $id, 'ebs_location', 'normal' );
	}

	if ( count( $ebs_seo_cp_locations ) >= 1 && $_GET['post'] != $ebs_seo_cp_locations[0]->ID && get_current_screen()->post_type == 'ebs_location' ) {	
		$check_allow_multiple = false;
		$check_allow_multiple = apply_filters( 'ebs_seo_cp_check_allow_multiple', $check_allow_multiple );
		if ( $check_allow_multiple !== true ) {
			echo 'Sorry, you are not allowed to access this page.';		
			wp_die();
		} 
	}
	add_meta_box(
		'ebs_seo_cp_meta_box_class_contact',
		__( 'Location Information', 'ebs_seo_cp' ), 
		'ebs_seo_cp_show_meta_box_contact', 
		'ebs_location', 
		'normal',
		'default' 
	);	
	add_meta_box(
		'ebs_seo_cp_meta_box_class_misc',
		__( 'Miscellaneous SEO Options', 'ebs_seo_cp' ),
		'ebs_seo_cp_show_meta_box_misc',
		'ebs_location',
		'normal',
		'default'
	);	
	add_meta_box(
		'ebs_seo_cp_meta_box_class_hours',
		__( 'Business Hours', 'ebs_seo_cp' ),
		'ebs_seo_cp_show_meta_box_hours',
		'ebs_location',
		'normal',
		'default'
	);
	add_meta_box(
		'ebs_seo_cp_meta_box_class_social',
		__( 'Social Media Links', 'ebs_seo_cp' ),
		'ebs_seo_cp_show_meta_box_social',
		'ebs_location',
		'normal',
		'default'
	);
	add_meta_box(
		'ebs_seo_cp_meta_box_class_help',
		__( 'Get More Help!', 'ebs_seo_cp' ),
		'ebs_seo_cp_show_meta_box_help',
		'ebs_location',
		'side',
		'high'
	);
	add_meta_box(
		'ebs_seo_cp_meta_box_class_upgrade',
		__( 'Get Premium Features!', 'ebs_seo_cp' ),
		'ebs_seo_cp_show_meta_box_upgrade',
		'ebs_location',
		'side',
		'low'
	);
	add_meta_box(
		'revisionsdiv', 
		__( 'Post Revisions', 'ebs_seo_cp' ), 
		'post_revisions_meta_box', 
		'ebs_location', 
		'advanced', 
		'low'
	);
}
	
/**
 * Create contact info meta box
 * 
 * Contains form for contact info
 * 
 * @since 4.0.0
 * 
 * @global bool $ebs_seo_cp_new_post Check for editing new post
 * 
 * @param WP_Post $post Post object for current editor 
 * 
 */
function ebs_seo_cp_show_meta_box_contact( $post ) {
	global $ebs_seo_cp_new_post;
		
	echo '<table class="widefat"><tbody>';
	wp_nonce_field( 'ebs_seo_cp_noncename_contact', 'ebs_seo_cp_noncename_contact' );	
	$meta_keys = array(
		array(	
		    'id' => 'ebs_seo_cp_name',
		    'type' => 'text',
		    'label' => __( 'Company Name: ', 'ebs_seo_cp' ),
		    'desc' => __( 'ex: Expert Business Search, LLC', 'ebs_seo_cp' ),
		    'default' => '',
		    'required' => true, 
		    'recommended' => false,
		    'callback' => '',
	    ),
	    array(	
		    'id' => 'ebs_seo_cp_street',
		    'type' => 'text',
		    'label' => __( 'Street Address: ', 'ebs_seo_cp' ),
		    'desc' => __( 'ex: 7867 24 Mile Road', 'ebs_seo_cp' ),
		    'default' => '',
		    'required' => true, 
		    'recommended' => false,
		    'callback' => '',
	    ),
		array(	
			'id' => 'ebs_seo_cp_unit',
			'type' => 'text',
			'label' => __( 'Unit: ', 'ebs_seo_cp' ),
			'desc' => __( 'ex: Suite 9', 'ebs_seo_cp' ),
			'default' => '',
			'required' => false, 
			'recommended' => false,
			'callback' => '',
		),
		array(	
			'id' => 'ebs_seo_cp_city',
			'type' => 'text',
			'label' => __( 'City: ', 'ebs_seo_cp' ),
			'desc' => __( 'ex: Shelby Twp.', 'ebs_seo_cp' ),
			'default' => '',
			'required' => true, 
			'recommended' => false,
			'callback' => '',
		),
		array(	
			'id' => 'ebs_seo_cp_state',
			'type' => 'text',
			'label' => __( 'State: ', 'ebs_seo_cp' ),
			'desc' => __( 'ex: MI', 'ebs_seo_cp' ),
			'default' => '',
			'required' => true, 
			'recommended' => false,
			'callback' => '',
		),
		array(	
			'id' => 'ebs_seo_cp_zip',
			'type' => 'text',
			'label' => __( 'Zip Code: ', 'ebs_seo_cp' ),
			'desc' => __( 'ex: 48316', 'ebs_seo_cp' ),
			'default' => '',
			'required' => true, 
			'recommended' => false,
			'callback' => '',
		),
		array(	
			'id' => 'ebs_seo_cp_country',
			'type' => 'text',
			'label' => __( 'Country: ', 'ebs_seo_cp' ),
			'desc' => __( 'ex: United States', 'ebs_seo_cp' ),
			'default' => '',
			'required' => true, 
			'recommended' => false,
			'callback' => '',
		),
		array(	
			'id' => 'ebs_seo_cp_email',
			'type' => 'text',
			'label' => __( 'E-mail address: ', 'ebs_seo_cp' ),
			'desc' => __( 'ex: Support@ExpertBusinessSearch.com', 'ebs_seo_cp' ),
			'default' => '',
			'required' => true, 
			'recommended' => false,
			'callback' => '',
		),
		array(	
			'id' => 'ebs_seo_cp_phone_1',
			'type' => 'text',
			'label' => __( 'Phone #1: ', 'ebs_seo_cp' ),
			'desc' => __( 'ex: 1 (586) 232-4268', 'ebs_seo_cp' ),
			'default' => '',
			'required' => true, 
			'recommended' => false,
			'callback' => '',
		),
		array(	
			'id' => 'ebs_seo_cp_phone_2',
			'type' => 'text',
			'label' => __( 'Phone #2: ', 'ebs_seo_cp' ),
			'desc' => __( '', 'ebs_seo_cp' ),
			'default' => '',
			'required' => false, 
			'recommended' => false,
			'callback' => '',
		),
		array(	
			'id' => 'ebs_seo_cp_phone_3',
			'type' => 'text',
			'label' => __( 'Fax #: ', 'ebs_seo_cp' ),
			'desc' => __( '', 'ebs_seo_cp' ),
			'default' => '',
			'required' => false, 
			'recommended' => false,
			'callback' => '',
		)
	);

		
	/**
	 * Filter options meta key fields
	 * 
	 * Allows to add additional fields to the contact info options meta box
	 * 
	 * @since 4.0.0
	 * 
	 * @param array $meta_keys {
	 * 		An array of fields to render
	 * 		@type string $id The ID/name of the form field and meta key id
	 * 		@type string $type The type of field to render
	 * 		@type string $desc the description of the field
	 * 		@type string $label the label of the field
	 * 		@type string $default the default value of this field
	 * 		@type bool $required is the field required?
	 * 		@type bool $recommended is the field recommended?
	 * 		@type string $callback callback function to call if $type is 'custom'. is given meta key array as argument.
	 * 
	 */
	$meta_keys = apply_filters( 'ebs_seo_cp_location_contact_options_meta_keys', $meta_keys );
	foreach ( $meta_keys as $meta_key ) {

		$meta_key['data'] = get_post_meta( $post->ID, $meta_key['id'], true );
		if ( $ebs_seo_cp_new_post == true ) { $meta_key['data'] = $meta_key['default']; }
		
		echo ebs_seo_cp_render_field( $meta_key );	
	}
    echo '<tr><td colspan="2">';
    submit_button( __( 'Save', 'ebs_seo_cp' ) );
    echo '</td></tr>';
	echo '</tbody></table>';
}
	
/**
 * Create hours info meta box
 * 
 * Contains form for hours info
 * 
 * @since 4.0.0
 * 
 * @global bool $ebs_seo_cp_new_post Check for editing new post
 * 
 * @param WP_Post $post Post object for current editor 
 * 
 */
function ebs_seo_cp_show_meta_box_hours( $post ) {
	global $ebs_seo_cp_new_post;

	echo '<table class="widefat"><thead><tr>
		<th class="row-title" style="width:175px;">' . __( 'Day ', 'ebs_seo_cp' ) . '</th>
		<th style="text-align:center;">' . __( 'Open?', 'ebs_seo_cp' ) . '</th>
		<th style="text-align:center;">' . __( 'Opens at', 'ebs_seo_cp' ) . '</th>
		<th style="text-align:center;">' . __( 'Closes at', 'ebs_seo_cp' ) . '</th>
		</tr></thead><tbody>';

	$days = array( 
		'sunday' => __( 'Sunday', 'ebs_seo_cp' ),
		'monday' => __( 'Monday', 'ebs_seo_cp' ),
		'tuesday' => __( 'Tuesday', 'ebs_seo_cp' ),
		'wednesday' => __( 'Wednesday', 'ebs_seo_cp' ),
		'thursday' => __( 'Thursday', 'ebs_seo_cp' ),
		'friday' => __( 'Friday', 'ebs_seo_cp' ),
		'saturday' => __( 'Saturday', 'ebs_seo_cp' ),	
	);

	$ebs_seo_cp_hours_startday = strtolower( get_post_meta( $post->ID, 'ebs_seo_cp_hours_startday', true ) );

	foreach ( $days as $day_id => $day_string) {
		unset( $check, $open, $close );
		if ( get_post_meta( $post->ID, "ebs_seo_cp_hours_{$day_id}_check_open", true ) == 'on' ) { 
			$check = 'checked="checked"'; 
		}
		$open = get_post_meta( $post->ID, "ebs_seo_cp_hours_{$day_id}_open", true );
		$close = get_post_meta( $post->ID, "ebs_seo_cp_hours_{$day_id}_close", true );
		echo "<tr class='alt'>
			<td><label class='row-title' for='ebs_seo_cp_hours_{$day_id}_check_open'>{$day_string}</label></td>
			<td align='center'><input type='checkbox' id='ebs_seo_cp_hours_{$day_id}_check_open' name='ebs_seo_cp_hours_{$day_id}_check_open'{$check}></td>			
			<td align='center'><input type='text' class='ebs-time' name='ebs_seo_cp_hours_{$day_id}_open' style='width:5em;' value='{$open}' size='20'></td>
			<td align='center'><input type='text' class='ebs-time' name='ebs_seo_cp_hours_{$day_id}_close' style='width:5em;' value='{$close}' size='20'></td>
		</tr>";
	}

	echo '<tr class="alt ebs-seo-cp-advanced">
			<td class="row-title" style="width:175px;">
				<label for="ebs_seo_cp_hours_startday">' . __( 'First day of week', 'ebs_seo_cp' ) . ': </label>
			</td>
			<td colspan="4">';				
	echo '<select name="ebs_seo_cp_hours_startday" id="ebs_seo_cp_hours_startday">'; 
	
	foreach ( $days as $day_id => $day_string) {
		echo "<option value='{$day_id}'"; 
		if( $ebs_seo_cp_hours_startday == $day_id ) {
			echo ' selected'; 
		}
		echo ">{$day_string}</option>"; 
	} 
	echo '</select><br /><span class="description">' . __( 'If you would like to change the day your week starts with (usually Sunday or Monday), set that here.', 'ebs_seo_cp' ) . '</span></td></tr>';
    echo '<tr><td colspan="4">';
    submit_button( __( 'Save', 'ebs_seo_cp' ) );
    echo '</td></tr>';
	echo '</tbody></table>';
}
	
/**
 * Create misc seo info meta box
 * 
 * Contains form for misc seo info
 * 
 * @since 4.0.0
 * 
 * @global bool $ebs_seo_cp_new_post Check for editing new post
 * 
 * @param WP_Post $post Post object for current editor 
 * 
 */
function ebs_seo_cp_show_meta_box_misc( $post ) {
	global $ebs_seo_cp_new_post;
	$meta_keys = array(	
		array(	
			'id' => 'ebs_seo_cp_url',
			'type' => 'text',
			'label' => __( 'Location URL: ', 'ebs_seo_cp' ),
			'desc' => __( 'URL to the home page for this location.', 'ebs_seo_cp' ),
			'default' => '',
			'required' => false, 
			'recommended' => true,
			'callback' => '',
		),
		array(	
			'id' => 'ebs_seo_cp_uri',
			'type' => 'text',
			'label' => __( '@id URI: ', 'ebs_seo_cp' ),
			'desc' => __( 'This will be automatically generated for you if left blank, or you can enter your own. A <span style="font-weight:bold">unique</span> URI to identify this location. Does not have to be a valid web address.', 'ebs_seo_cp' ),
			'default' => '',
			'required' => false, 
			'recommended' => false,
			'callback' => '',
		),
		array(	
			'id' => 'ebs_seo_cp_google_map_override',
			'type' => 'text',
			'desc' =>  __( 'This will be automatically generated for you, if it is incorrect you may insert the correct URL to your location on Google Maps here.', 'ebs_seo_cp' ) . '<br><span style="font-weight: bold;">' . __( "For best results, it is highly recommended that you have Google My Business account set up for this location's address.", 'ebs_seo_cp' ) . "</span>",
			'label' => __( 'Google Maps URL: ', 'ebs_seo_cp' ),
			'default' => '',
			'required' => false,
			'recommended' => true,
			'callback' => '',
		),	
		array(	
			'id' => 'ebs_seo_cp_location_img',
			'type' => 'img',
			'desc' =>  __( 'Choose a picture that represents your company. A picture of your building, a road sign, or a group photo of your employees works here.', 'ebs_seo_cp' ),
			'label' => __( 'Location image: ', 'ebs_seo_cp' ),
			'default' => '',
			'required' => true, 
			'recommended' => false,
			'callback' => '',
		),
		array(	
			'id' => 'ebs_seo_cp_logo_img',
			'type' => 'img',
			'desc' =>  __( 'Use your logo here.', 'ebs_seo_cp' ),
			'label' => __( 'Logo image: ', 'ebs_seo_cp' ),
			'default' => '',
			'required' => false, 
			'recommended' => true,
			'callback' => '',
		),
		array(	
			'id' => 'ebs_seo_cp_price_range',
			'type' => 'text',
			'desc' =>  __( ' Enter a range of one to five dollar signs ( $ - $$$$$ )', 'ebs_seo_cp' ),
			'label' => __( 'Price range: ', 'ebs_seo_cp' ),
			'default' => '',
			'required' => false, 
			'recommended' => true,
			'callback' => '',
		),
		array(	
			'id' => 'ebs_seo_cp_payments_accepted',
			'type' => 'text',
			'desc' =>  __( ' ex: Cash, Check, Visa, Mastercard, Paypal, etc.', 'ebs_seo_cp' ),
			'label' => __( 'Payments accepted:', 'ebs_seo_cp' ),
			'default' => '',
			'required' => false, 
			'recommended' => false,
			'callback' => '',
		),
		array(	
			'id' => 'ebs_seo_cp_currencies_accepted',
			'type' => 'text',
			'desc' =>  __( ' ex: USD, CAD, GBP. See <a href="http://en.wikipedia.org/wiki/ISO_4217" target="_blank">WikiPedia</a> for more info.', 'ebs_seo_cp' ),
			'label' => __( 'Currencies accepted: ', 'ebs_seo_cp' ),
			'default' => '',
			'required' => false, 
			'recommended' => false,
			'callback' => '',
		),
	);
	$upload_link = get_upload_iframe_src( 'image' );

	/**
	 * Filter options meta key fields
	 * 
	 * Allows to add additional fields to the misc seo options meta box
     * 
     * @since 4.0.0
	 * 
	 * @param array $meta_keys {
	 * 		An array of fields to render
	 * 		@type string $id The ID/name of the form field and meta key id
	 * 		@type string $type The type of field to render (img, type, and custom)
	 * 		@type string $desc the description of the field
	 * 		@type string $label the label of the field
	 * 		@type string $default the default value of this field
	 * 		@type bool $required is the field required?
	 * 		@type bool $recommended is the field recommended?
	 * 		@type string $callback callback function to call if $type is 'custom'. is given meta key array as argument.	 * 
	 */
	$meta_keys = apply_filters( 'ebs_seo_cp_location_misc_options_meta_keys', $meta_keys );

	echo '<table class="widefat"><tbody>';
	foreach ( $meta_keys as $meta_key ) {
		$meta_key['data'] = get_post_meta( $post->ID, $meta_key['id'], true );
		if ( $ebs_seo_cp_new_post == true ) { $meta_key['data'] = $meta_key['default']; }

		echo ebs_seo_cp_render_field( $meta_key );
	}
    echo '<tr><td colspan="2">';
    submit_button( __( 'Save', 'ebs_seo_cp' ) );
    echo '</td></tr>';
	echo '</tbody></table>';
}
	
/**
 * Create social media info meta box
 * 
 * Contains form for social media info
 * 
 * @since 4.0.0
 *  
 * @param WP_Post $post Post object for current editor 
 * 
 */
function ebs_seo_cp_show_meta_box_social( $post ) {
	$meta_keys = array(	
		array(	
			'id' => 'ebs_seo_cp_facebook',
			'type' => 'text',
			'desc' =>  __( ' Enter Facebook URL.', 'ebs_seo_cp' ),
			'label' => __( 'Facebook: ', 'ebs_seo_cp' ),
			'default' => '',
			'required' => false, 
			'recommended' => true,
			'callback' => '',
		),
		array(	
			'id' => 'ebs_seo_cp_twitter',
			'type' => 'text',
			'desc' =>  __( ' Enter Twitter URL.', 'ebs_seo_cp' ),
			'label' => __( 'Twitter: ', 'ebs_seo_cp' ),
			'default' => '',
			'required' => false, 
			'recommended' => true,
			'callback' => '',
		),
		array(	
			'id' => 'ebs_seo_cp_linkedin',
			'type' => 'text',
			'desc' =>  __( ' Enter LinkedIn URL.', 'ebs_seo_cp' ),
			'label' => __( 'LinkedIn: ', 'ebs_seo_cp' ),
			'default' => '',
			'required' => false, 
			'recommended' => true,
			'callback' => '',
		),
		array(	
			'id' => 'ebs_seo_cp_google_my_business',
			'type' => 'text',
			'desc' =>  __( ' Enter Google My business URL.', 'ebs_seo_cp' ),
			'label' => __( 'Google My Business: ', 'ebs_seo_cp' ),
			'default' => '',
			'required' => false, 
			'recommended' => true,
			'callback' => '',
		),
		array(	
			'id' => 'ebs_seo_cp_google_plus',
			'type' => 'text',
			'desc' =>  __( ' Enter Google Plus URL.', 'ebs_seo_cp' ),
			'label' => __( 'Google Plus: ', 'ebs_seo_cp' ),
			'default' => '',
			'required' => false, 
			'recommended' => true,
			'callback' => '',
		),
		array(	
			'id' => 'ebs_seo_cp_yelp',
			'type' => 'text',
			'desc' =>  __( ' Enter Yelp URL.', 'ebs_seo_cp' ),
			'label' => __( 'Yelp: ', 'ebs_seo_cp' ),
			'default' => '',
			'required' => false, 
			'recommended' => true,
			'callback' => '',
		),
		array(	
			'id' => 'ebs_seo_cp_pinterest',
			'type' => 'text',
			'desc' =>  __( ' Enter Pinterest URL.', 'ebs_seo_cp' ),
			'label' => __( 'Pinterest: ', 'ebs_seo_cp' ),
			'default' => '',
			'required' => false, 
			'recommended' => true,
			'callback' => '',
		),
		array(	
			'id' => 'ebs_seo_cp_youtube',
			'type' => 'text',
			'desc' =>  __( ' Enter YouTube URL.', 'ebs_seo_cp' ),
			'label' => __( 'YouTube: ', 'ebs_seo_cp' ),
			'default' => '',
			'required' => false, 
			'recommended' => true,
			'callback' => '',
		),
		array(	
			'id' => 'ebs_seo_cp_flickr',
			'type' => 'text',
			'desc' =>  __( ' Enter flickr URL.', 'ebs_seo_cp' ),
			'label' => __( 'flickr: ', 'ebs_seo_cp' ),
			'default' => '',
			'required' => false, 
			'recommended' => false,
			'callback' => '',
		),
		array(	
			'id' => 'ebs_seo_cp_tumblr',
			'type' => 'text',
			'desc' =>  __( ' Enter tumblr URL.', 'ebs_seo_cp' ),
			'label' => __( 'tumblr: ', 'ebs_seo_cp' ),
			'default' => '',
			'required' => false, 
			'recommended' => false,
			'callback' => '',
		),
		array(	
			'id' => 'ebs_seo_cp_foursquare',
			'type' => 'text',
			'desc' =>  __( ' Enter FourSquare URL.', 'ebs_seo_cp' ),
			'label' => __( 'FourSquare: ', 'ebs_seo_cp' ),
			'default' => '',
			'required' => false, 
			'recommended' => false,
			'callback' => '',
		),
		array(	
			'id' => 'ebs_seo_cp_hotfrog',
			'type' => 'text',
			'desc' =>  __( ' Enter HotFrog URL.', 'ebs_seo_cp' ),
			'label' => __( 'HotFrog: ', 'ebs_seo_cp' ),
			'default' => '',
			'required' => false, 
			'recommended' => false,
			'callback' => '',
		),
		array(	
			'id' => 'ebs_seo_cp_reddit',
			'type' => 'text',
			'desc' =>  __( ' Enter Reddit URL.', 'ebs_seo_cp' ),
			'label' => __( 'Reddit: ', 'ebs_seo_cp' ),
			'default' => '',
			'required' => false, 
			'recommended' => false,
			'callback' => '',
		),
		array(	
			'id' => 'ebs_seo_cp_digg',
			'type' => 'text',
			'desc' =>  __( ' Enter Digg URL.', 'ebs_seo_cp' ),
			'label' => __( 'Digg: ', 'ebs_seo_cp' ),
			'default' => '',
			'required' => false, 
			'recommended' => false,
			'callback' => '',
		),
		array(	
			'id' => 'ebs_seo_cp_stumbleupon',
			'type' => 'text',
			'desc' =>  __( ' Enter StumbleUpon URL.', 'ebs_seo_cp' ),
			'label' => __( 'StumbleUpon: ', 'ebs_seo_cp' ),
			'default' => '',
			'required' => false, 
			'recommended' => false,
			'callback' => '',
		),
		array(	
			'id' => 'ebs_seo_cp_delicious',
			'type' => 'text',
			'desc' =>  __( ' Enter Del.ico.us URL.', 'ebs_seo_cp' ),
			'label' => __( 'Del.ico.us: ', 'ebs_seo_cp' ),
			'default' => '',
			'required' => false, 
			'recommended' => false,
			'callback' => '',
		),
		array(	
			'id' => 'ebs_seo_cp_merchant_circle',
			'type' => 'text',
			'desc' =>  __( ' Enter Merchant Circle URL.', 'ebs_seo_cp' ),
			'label' => __( 'Merchant Circle: ', 'ebs_seo_cp' ),
			'default' => '',
			'required' => false, 
			'recommended' => false,
			'callback' => '',
		),
	);

	/**
	 * Filter social media meta key fields
	 * 
	 * Allows to add additional fields to the social media options meta box
     * 
     * @since 4.0.0
	 * 
	 * @param array $meta_keys {
	 * 		An array of fields to render
	 * 		@type string $id The ID/name of the form field and meta key id
	 * 		@type string $desc the description of the field
	 * 		@type string $label the label of the field
	 * 
	 */
	$meta_keys = apply_filters( 'ebs_seo_cp_location_social_media_options_meta_keys', $meta_keys );

	echo '<table class="widefat"><tbody>';	
	foreach ( $meta_keys as $meta_key ) {
		$meta_key['data'] = get_post_meta( $post->ID, $meta_key['id'], true );

		echo ebs_seo_cp_render_field( $meta_key );
	}
    echo '<tr><td colspan="2">';
    submit_button( __( 'Save', 'ebs_seo_cp' ) );
    echo '</td></tr>';
	echo '</tbody></table>';
}

/**
 * Create help info meta box
 * 
 * Contains help information in sidebar
 * 
 * @since 4.0.0
 * 
 * @param WP_Post $post Post object for current editor 
 * 
 */
function ebs_seo_cp_show_meta_box_help( $post ) {
	//TODO: redo

	echo  __( 'For questions and feature requests: ', 'ebs_seo_cp' ) . '<br /><a href="mailto:wpsupport@expertbusinesssearch.com" target="_blank">' . __( 'E-Mail Support', 'ebs_seo_cp' ) . '</a><br /><br />';
	echo '<a href="http://www.expertbusinesssearch.com/store/premium-local-search-seo-contact-page/frequently-asked-questions/" target="_blank">' . __( 'FAQ', 'ebs_seo_cp' ) . '</a><br />';
	echo '<a href="http://www.expertbusinesssearch.com/store/premium-local-search-seo-contact-page/usage-instructions/" target="_blank">' . __( 'Usage Instructions', 'ebs_seo_cp' ) . '</a><br />';
}

/**
 * Create upgrade info meta box
 * 
 * Contains upgrade information in sidebar
 * 
 * @since 4.0.0
 * 
 * @param WP_Post $post Post object for current editor 
 * 
 */
function ebs_seo_cp_show_meta_box_upgrade( $post ) {
	//TODO: redo

	echo '<a name="upgrade"></a><h3>' . __( 'Purchase our premium add-on today and supercharge your Local SEO!', 'ebs_seo_cp' ) . '</h3>';
	echo '<p>' . __( 'We took our plugin back to the drawing board and implemented heaps of powerful new features to get the most out of your Local Search Engine Optimization strategy. Here is a brief overview of what we have to offer:', 'ebs_seo_cp' ) . '</p>';
	$features = array(
		__('Support for multiple locations', 'ebs_seo_cp' ),
		__('Support for organization schema', 'ebs_seo_cp' ),
		__('Choose your LocalBusiness type', 'ebs_seo_cp' ),
		__('Use widgets in addition to shortcodes to output your contact information', 'ebs_seo_cp' ),
		__('Set a default location for your entire site', 'ebs_seo_cp' ),
		__('Override the default location for specific pages', 'ebs_seo_cp' ),
		__('Disable Schema.org SEO data for specific pages', 'ebs_seo_cp' ),
	);
	echo "<ul>";
	foreach ( $features as $feature ) {
		echo "<li style='list-style:disc;margin-left:2em;'>{$feature}</li>";
	}
	echo "</ul>";

	echo '<a href="https://www.expertbusinesssearch.com/local-search-plugin/" target="_blank" class="button button-primary button-large">' . __( 'Buy now!', 'ebs_seo_cp' ) . '</a>';
}
?>