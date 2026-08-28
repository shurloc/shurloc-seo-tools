<?php
/**
 * Plugin bootstrap.
 *
 * @package ShurlocSEOTools
 */

declare( strict_types=1 );

namespace Shurloc\SEOTools;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Bootstrap the plugin.
 */
function shurloc_seo_tools_bootstrap(): void {
	/**
	 * Autoloader.
	 */

	require_once SHURLOC_SEO_TOOLS_PATH . 'includes/class-shurloc-autoloader.php';

	$autoloader = new Shurloc_Autoloader(
		base_directory: __DIR__,
	);

	$autoloader->register();

	/**
	 * FAQ schema.
	 */

	$faq_schema_parser = new Shurloc_FAQ_Schema_Parser();

	$faq_schema_generator = new Shurloc_FAQ_Schema_Generator();

	$faq_schema_integration = new Shurloc_FAQ_Schema_Integration(
		parser: $faq_schema_parser,
		generator: $faq_schema_generator,
	);

	$faq_schema_integration->register();
}

add_action(
	'plugins_loaded',
	__NAMESPACE__ . '\\shurloc_seo_tools_bootstrap',
	20
);
