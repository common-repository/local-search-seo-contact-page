<?php 
// Version: 4.0.0

add_filter( 'contextual_help', 'ebs_seo_cp_contextual_help', 10, 3 );
function ebs_seo_cp_contextual_help( $contextual_help, $screen_id, $screen ) {
    if ( $screen_id != 'ebs_location' || ! method_exists( $screen, 'add_help_tab' ) )
		return $contextual_help;
		
	$screen->add_help_tab( array(
		'id'      => 'ebs_seo_cp_help_tab_overview',
		'title'   => __( 'Overview', 'ebs_seo_cp' ),
		'content' => '&nbsp;' . __( '
		<p>First of all, thank you for supporting our plugin! We are dedicated to making your experience with our software as easy as can be. You can view support options in the "Get Help!" metabox below the "Publish" metabox.
		<p>The main objective of the ExpertBusinessSearch.com Local SEO Contact Page is to provide SEO details for local-centric searches. The main tool behind this feature is what is called Schema.org markup, or basically a framework for detailing certain pieces of information for indexing by search engines including Google, Bing, Ask.com, and many many more.
		<p>The detailed information ranges from official contact details all the way to what types of payments and currencies your business accepts.
		<p>Local SEO Contact Page accomplishes this by taking the information you supply and injecting that information into pre-defined code snippets that are formatted for acceptance by all major search engines.
		', 'ebs_seo_cp' ) . '',
	));
    $screen->add_help_tab( array(
        'id'      => 'ebs_seo_cp_help_tab_shortcodes',
        'title'   => __( 'Shortcode usage', 'ebs_seo_cp' ),
        'content' => '&nbsp;' . __( ' 
		<table class="widefat">
		<thead>
			<tr>
				<th class="row-title">Shortcode</th>
				<th class="row-title">Description</th>
			</tr>
		</thead><tbody>		
		<tr>
			<td class="row-title"><label for="tablecell">[ebs_seo_cp_full location={id} width={width} height={height}]</label></td>
			<td>This shortcode will output all data available, and includes parameters for location ID, and Google Map embedded width and height. Any field left blank will be ignored at output.</td>
		</tr>
		<tr class="alt">
			<td class="row-title"><label for="tablecell">[ebs_seo_cp_contact_only location={id}]</label></td>
			<td>This shortcode will output all data related to the Contact Information group of fields. Any field left blank will be ignored at output.</td>
		</tr>	
		<tr>
			<td class="row-title"><label for="tablecell">[ebs_seo_cp_location_img_only location={id}]</label></td>
			<td>This shortcode will output the image that you input for "Location image", which is typically a picture of your building or employees, or something that can identify your business but is NOT your logo.</td>
		</tr>
		<tr class="alt">
			<td class="row-title"><label for="tablecell">[ebs_seo_cp_logo_img_only location={id}]</label></td>
			<td>This shortcode will output the image that you input for "Logo image", which is your Business logo and is indexed by search engines as such.</td>
		</tr>
		<tr>
			<td class="row-title"><label for="tablecell">[ebs_seo_cp_map_only location={id} width={width} height={height}]</label></td>
			<td>This shortcode will output an embedded Google Maps iFrame and includes parameters for location ID, and Google Map embedded width and height.</td>
		</tr>
		<tr class="alt">
			<td class="row-title"><label for="tablecell">[ebs_seo_cp_hours_only location={id}]</label></td>
			<td>This shortcode will output a formatted table with your Business hours.</td>
		</tr>
		<tr>
			<td class="row-title"><label for="tablecell">[ebs_seo_cp_social_media_only location={id}]</label></td>
			<td>This shortcode will output your Social Media links, as outlined in the Social Media Links group of fields. Any field left blank will be ignored at output.</td>
		</tr>

	</tbody>
	<tfoot>
			<tr>
				<th class="row-title">Shortcode</th>
				<th class="row-title">Description</th>
			</tr>
	</tfoot>
</table>
		', 'ebs_seo_cp' ) . '',
    ));
    return $contextual_help;
}
?>