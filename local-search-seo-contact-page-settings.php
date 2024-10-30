<?php
//ver 4.0.1

/**
 * Register plugin settings page
 * 
 * Registers menu page, submenu page, and removes default add/edit links
 * 
 * @since 4.0.0
 */
add_action( 'admin_menu' , 'ebs_seo_cp_register_plugin_settings', 10 );
function ebs_seo_cp_register_plugin_settings() {
    global $submenu, $ebs_seo_cp_locations;

    add_menu_page( 
        __( 'Locations', 'ebs_seo_cp' ),
        __( 'Local SEO', 'ebs_seo_cp' ),
        'manage_options',
        'location-menu',
        'ebs_seo_cp_render_admin_menu_cb',
        'dashicons-location',
        60
    );

    $check_allow_multiple = false;
    $check_allow_multiple = apply_filters( 'ebs_seo_cp_check_allow_multiple', $check_allow_multiple );
    if ( $check_allow_multiple !== true ) {
        remove_submenu_page( 'location-menu', 'edit.php?post_type=ebs_location' );
        if ( count( $ebs_seo_cp_locations ) > 0 ) {
            $submenu['location-menu'][] = array( __( 'Edit Location', 'ebs_seo_cp' ), 'manage_options', 'post.php?post=' . $ebs_seo_cp_locations[0]->ID . '&action=edit' );
        } else {
            $submenu['location-menu'][] = array( __( 'Edit Location', 'ebs_seo_cp' ), 'manage_options', 'post-new.php?post_type=ebs_location' );
        } 
    }

    add_submenu_page( 
        'location-menu',
        __( 'ExpertBusinessSearch.com Local Search SEO Contact Page Settings', 'ebs_seo_cp' ), 
        __( 'Settings', 'ebs_seo_cp' ), 
        'manage_options', 
        'local_search_seo_contact_page_settings', 
        'ebs_seo_cp_plugin_settings_page' 
    );
}

/**
 * Render plugin settings main menu page
 * 
 * Not used, left blank, possibly null the callback parameter?
 * 
 * @see ebs_seo_cp_register_plugin_settings
 * 
 * @since 4.0.0
 */
function ebs_seo_cp_render_admin_menu_cb( ) {
}

/**
 * Register plugin settings meta boxes
 * 
 * Sets up meta boxes for settings page
 * 
 * @since 4.0.0
 */
add_action( 'add_meta_boxes', 'ebs_seo_cp_add_settings_meta_boxes' );
function ebs_seo_cp_add_settings_meta_boxes() {
	add_meta_box(
		'ebs_seo_cp_meta_box_settings_upgrade',
		__( 'Get Premium Features!', 'ebs_seo_cp' ),
		'ebs_seo_cp_show_meta_box_upgrade',
		'local_search_seo_contact_page_settings',
		'normal',
		'default'
	);

    /** Set up Format Settings meta box */
	add_meta_box(
		'ebs_seo_cp_meta_box_settings_format',
		__( 'Output Formatting', 'ebs_seo_cp' ), 
		'ebs_seo_cp_show_meta_box_settings_format', 
		'local_search_seo_contact_page_settings', 
		'normal',
		'default' 
	);	
}

/**
 *  Format Settings meta box render
 * 
 * Creates the HTML for the Format Settings meta box
 * 
 * @since 4.0.0
 */
function ebs_seo_cp_show_meta_box_settings_format() {
	$fields = array(         
		array(	
            'id' => 'ebs_seo_cp_address_format_instructions',
            'type' => 'instructions',
            'label' => __( '', 'ebs_seo_cp' ),
            'desc' => __( 'Use this tool to change how your address will be displayed publicly. Useful if your locale uses an alternate address format from the USA, or if you would like to add additional text to your address.', 'ebs_seo_cp' ),
            'default' => '',
            'required' => false,
            'recommended' => false,
            'callback' => '',
         ),
         array(	
            'id' => 'ebs_seo_cp_address_format',
            'type' => 'textarea',
            'label' => __( 'Address Output Format: ', 'ebs_seo_cp' ),
            'desc' => __( '<p>You can use the following fields:  {street-address}, {city}, {state}, {postal-code}, {country}</p>Example: <br/>', 'ebs_seo_cp' ) . "<pre>{street-address} &lt;br /&gt;\r\n{city}, {state} {postal-code} &lt;br /&gt; \r\n{country}</pre>",
            'default' => '',
            'required' => false,
            'recommended' => false,
            'callback' => '',
         ),
         array(	
            'id' => 'ebs_seo_cp_full_shortcode_format',
            'type' => 'textarea',
            'label' => __( 'Full Shortcode Output Format: ', 'ebs_seo_cp' ),
            'desc' => __( '<p>You can use the following fields:  {contact-info}, {hours}, {logo}, {image}, {social-media}, {map}</p><p>Example: <br/>', 'ebs_seo_cp' ) . "<pre>&lt;div style='display: table; width: 100%;'&gt;\r\n\t&lt;div style='display: table-row-group;'&gt;\r\n\t\t&lt;div style='display: table-row;'&gt;\r\n\t\t\t&lt;div style='display: table-cell;'&gt;{logo}&lt;/div&gt;\r\n\t\t\t&lt;div style='display: table-cell;'&gt;{image}&lt;/div&gt;\r\n\t\t&lt;/div&gt;\r\n\t\t&lt;div style='display: table-row;'&gt;\r\n\t\t\t&lt;div style='display: table-cell;'&gt;{contact-info}&lt;/div&gt;\r\n\t\t\t&lt;div style='display: table-cell;'&gt;{hours}&lt;/div&gt;\r\n\t\t&lt;/div&gt;\r\n\t&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;div style='width: 100%;'&gt;\r\n\t{social-media}\r\n&lt;/div&gt;\r\n&lt;div style='width: 100%;'&gt;\r\n\t{map}\r\n&lt;/div&gt;</pre>",
            'default' => '',
            'required' => false,
            'recommended' => false,
            'callback' => '',
         ),
    );

	echo '<table class="widefat"><tbody>';
    wp_nonce_field( 'ebs_seo_cp_format_settings_nonce', 'ebs_seo_cp_format_settings_nonce' );	
    
	foreach ( $fields as $field ) {

		$field['data'] = get_option( $field['id'] );
        if ( $field['required'] === true  && empty( $field['data'] ) )  { $field['data'] = $field['default']; }
        
		if ( isset( $_POST[$field['id']] ) ) {
            $field['data'] = $_POST[$field['id']];
        }
        update_option( $field['id'], $field['data'] );
        $field['data'] = stripslashes($field['data'] );
        echo ebs_seo_cp_render_field( $field );
    }
    echo '<tr><td colspan="2">';
    submit_button();
    echo '</td></tr>';
	echo '</tbody></table>';


}

/**
 * Render the settings submenu page
 * 
 * Creates the HTML for the submenu page, and runs meta boxes
 * 
 * @since 4.0.0
 */
function ebs_seo_cp_plugin_settings_page() {

    /**
     * Set up `local_search_seo_contact_page_settings` meta boxes
     * 
     * 
     * 
     * @since 4.0.0
     */
    do_action( 'add_meta_boxes', 'local_search_seo_contact_page_settings' );

    ?>
 
    <div class="wrap"> 
        <h2><?php _e( 'ExpertBusinessSearch.com Local Search SEO Contact Page Settings', 'ebs_seo_cp' ); ?></h2> 
        <form id="ebs_seo_cp_settings_form" method="post" action="admin.php?page=local_search_seo_contact_page_settings"> 
            <?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
            <?php wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false ); ?> 
            <?php wp_nonce_field( 'ebs_seo_cp_nonce', 'ebs_seo_cp_nonce', false ); ?> 
            <div id="poststuff"> 
                <div id="post-body" class="metabox-holder columns-1"> 
                    <div id="postbox-container-1" class="postbox-container">

                        <?php $result = do_meta_boxes( 'local_search_seo_contact_page_settings', 'normal', null ); ?>
                        
                    </div>

                </div>
            </div>
        </form>
    </div>
    <?php   
	
} //end ebs_seo_cp_plugin_settings_page()

/**
 * Footer javascript for settings page
 * 
 * Sends javascript for metabox open/close/reorder control
 * 
 * @since 4.0.0
 */
add_action( 'admin_footer', 'ebs_seo_cp_plugin_settings_page_footer' );
function ebs_seo_cp_plugin_settings_page_footer(){
    if ( $_GET['page'] == 'local_search_seo_contact_page_settings' ) {
?>
<script type="text/javascript">
    //<![CDATA[
    jQuery(document).ready( function($) {
        // toggle
        $('.if-js-closed').removeClass('if-js-closed').addClass('closed');
        postboxes.add_postbox_toggles( '<?php echo 'local_search_seo_contact_page_settings'; ?>' );
    });
    //]]>
</script>
<?php
    }
}
?>