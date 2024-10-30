=== Local Search SEO Contact Page ===
Contributors: ExpertBusinessSearch
Author URI: https://www.expertbusinesssearch.com/
Plugin URI: http://www.expertbusinesssearch.com/
Tags: local, seo, contact, schema, structured data
Version: 4.0.1
Requires at least: 4.6.0
Tested up to: 4.9.8
Stable tag: 4.0.2

Markup your website with Schema.org Structured SEO Data and display your contact details. Index your business with Google and get rich results in SERPs.

==== Description ====

The Local Search SEO Contact Page plugin for WordPress prints standardized Schema.org LocalBusiness structured data in JSON-LD format in your site's header on all pages. You can also use shortcodes to print your business's contact information on the front end of your site.

To use this plugin, go to the Local SEO -> Edit Location page and input as few or as many options as you like. Any options left blank will either be left off the plugin output, or in some cases a forced default will be applied.

= Features =

* Easy to use location information entry page
* Many shortcode options to choose from for displaying your contact data
* Google recommended JSON-LD structured data output format
* Schema.org formatted LocalBusiness for structured data
* Display address, phone numbers, fax, and email for contacting your business
* Display your hours of operation 
* Social media images and links for Facebook, Twitter, YouTube, LinkedIn, and many, many more
* Embedded Google Map on your contact page
* Index all of your data with Google for enhanced rich search results on Google and other search engines

= Features available as a Premium extension =

* Support for multiple Locations
* Assign a default location for your entire site
* Organization Schema alongside your LocalBusiness Schema
* Choose your specific LocalBusiness Schema type
* Assign Local SEO data to specific pieces of content
* Disable Local SEO data for specific pieces of content
* Widgets featuring your location's information - prints site default, page default, or a specific location
* KML and GeoSitemap generation
* [Check out the premium extension today!](http://www.expertbusinesssearch.com/local-search-plugin/)

= Other Info =

If you have any suggestions or feature requests, feel free to contact us on [our website](http://www.expertbusinesssearch.com/contact-us/)


= Related Links =

* [Full Documentation](http://www.expertbusinesssearch.com/documentation/local-search-seo-contact-page-plugin/)
* [Premium Extension](http://www.expertbusinesssearch.com/local-search-plugin/)
* [Our Homepage](http://www.expertbusinesssearch.com)


==== Installation ====

1. Upload the full directory into your wp-content/plugins directory
2. Log into WordPress and go to Plugins.
3. Activate the plugin at the plugin administration page
6. Enter your location data under Local SEO -> Edit Location
8. Insert a shortcode into any post or page. Example: [local_seo_info_full]


==== Frequently Asked Questions ==== 

= How do I output my contact information on my contact page?

  Use the [local_seo_info_full] shortcode to print all information. There are also shortcodes that output individual blocks of information: [local_seo_info_contact_only], [local_seo_info_image_only], [local_seo_info_logo_only], [local_seo_info_map_only], [local_seo_info_hours_only], and [local_seo_info_social_media_only].

= How can I find out if my SEO data is correct? =

  Google has a [Structured Data Testing Tool](https://search.google.com/structured-data/testing-tool) that will quickly tell you what data it sees about your business, and report any problems.

= Why is my structured data validation test is failing? =

  Please make sure that all "required" fields are filled out for your location. Google recently made the Schema.org "image" field a required field, and this is usually what is missing.

= Why isn't my embedded Google map not working? =

  It is recommended to have a Google Places account set up for your location. If you still have trouble, you may generate your own embedded maps URL and save it to your location.



== Upgrade Notice ==

* This version will perform a migration when first activated, moving any location data from Version 2 of this plugin to the newly implemented Location screen. If you have Version 2 installed, your data will be migrated to this plugin and the old data will be deleted.
* This version contains a major feature change: Google now recommends Schema.org to be presented as JSON-LD data, which is now the only supported structured data output of this plugin. Contact Info shortcodes now display your contact information with no microdata fields attached to the visible HTML elements

== Screenshots ==

1. Location info input page
2. Formatting options page
3. Shortcode output example (full shortcode)

== Other Notes ==

If you are interested in localizing this plugin, please contact us at wpsupport@expertbusinesssearch.com

==== Changelog ====
= 4.0.2 =
* Fixes for extension integration
* Changed Google Places to Google My Business
* Removed browser validation check on required fields to allow saving of incomplete location information
* Other minor fixes and improvements

= 4.0.1 =
* Fixed bug with contact-only output
* Fixed broken links

= 4.0.0 =
* Google recommended JSON-LD data output
* Simplified Location data entry form
* Simplified settings page with front-end output format/layout options
* Audited and optimized codebase for faster pageloads