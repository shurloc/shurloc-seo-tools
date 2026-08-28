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
}

add_action(
	'plugins_loaded',
	__NAMESPACE__ . '\\shurloc_seo_tools_bootstrap',
	20
);
