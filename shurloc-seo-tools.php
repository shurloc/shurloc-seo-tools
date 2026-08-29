<?php
/**
 * Plugin Name:       Shur-loc SEO Tools
 * Plugin URI:        https://github.com/shurloc/shurloc-seo-tools
 * Description:       SEO tools for the Shur-loc website.
 * Version:           0.1.1
 * Requires at least: 7.0
 * Requires PHP:      8.4
 * Requires Plugins:  shurloc-tools
 * Author:            Shur-loc
 * Author URI:        https://shurloc.com/
 * Text Domain:       shurloc-seo-tools
 *
 * @package ShurlocSEOTools
 */

namespace Shurloc\SEOTools;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/includes/constants.php';
require_once __DIR__ . '/includes/bootstrap.php';
