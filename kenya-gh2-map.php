<?php
/**
 * Plugin Name: Kenya Green Hydrogen Map
 * Plugin URI:  https://example.com/kenya-gh2-map
 * Description: Interactive SVG map of Kenya showing Green Hydrogen and Derivatives project pipeline. Use shortcode [kenya_gh2_map] to embed.
 * Version:     1.0.0
 * Author:      GH2 Projects
 * License:     GPL-2.0+
 * Text Domain: kenya-gh2-map
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'KGH2_PLUGIN_DIR' ) ) {
	define( 'KGH2_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'KGH2_PLUGIN_URL' ) ) {
	define( 'KGH2_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}
if ( ! defined( 'KGH2_VERSION' ) ) {
	define( 'KGH2_VERSION', '1.0.0' );
}

/**
 * Check whether the shortcode appears on the current post/page.
 */
function kgh2_has_shortcode() {
	global $post;
	return is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'kenya_gh2_map' );
}

/**
 * Enqueue front-end assets only when the shortcode is present on the page.
 */
function kgh2_enqueue_assets() {
	if ( ! kgh2_has_shortcode() ) {
		return;
	}

	wp_enqueue_style(
		'kgh2-montserrat',
		'https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'kgh2-style',
		KGH2_PLUGIN_URL . 'assets/css/kenya-gh2-map.css',
		array( 'kgh2-montserrat' ),
		KGH2_VERSION
	);

	wp_enqueue_script(
		'kgh2-script',
		KGH2_PLUGIN_URL . 'assets/js/kenya-gh2-map.js',
		array(),
		KGH2_VERSION,
		true // load in footer
	);
}
add_action( 'wp_enqueue_scripts', 'kgh2_enqueue_assets' );

/**
 * Shortcode handler: [kenya_gh2_map]
 *
 * Attribute:
 * - panel="on|off|1|0|true|false" (default: "on")
 * - register="on|off|1|0|true|false" (default: "on") Project Register panel below map
 */
function kgh2_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'panel'    => 'on',
			'register' => 'on',
		),
		$atts,
		'kenya_gh2_map'
	);

	// Normalize panel visibility to boolean.
	$panel_value        = strtolower( trim( (string) $atts['panel'] ) );
	$kgh2_show_panel    = ! in_array( $panel_value, array( '0', 'off', 'no', 'false' ), true );

	$register_value      = strtolower( trim( (string) $atts['register'] ) );
	$kgh2_show_register  = ! in_array( $register_value, array( '0', 'off', 'no', 'false' ), true );

	ob_start();
	$template_path = KGH2_PLUGIN_DIR . 'templates/map-template.php';
	if ( file_exists( $template_path ) ) {
		// Makes $kgh2_show_panel and $kgh2_show_register available inside the template.
		include $template_path;
	} else {
		echo '<!-- KGH2 Error: Map template not found. -->';
	}
	return ob_get_clean();
}
add_shortcode( 'kenya_gh2_map', 'kgh2_shortcode' );
