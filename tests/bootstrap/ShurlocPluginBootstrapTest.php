<?php
/**
 * Tests for plugin bootstrap.
 *
 * @package ShurlocSEOTools
 */

declare( strict_types=1 );

namespace Shurloc\SEOTools;

use PHPUnit\Framework\TestCase;

/**
 * Tests plugin initialization.
 *
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
final class ShurlocPluginBootstrapTest extends TestCase {

	/**
	 * Prepare each test.
	 *
	 * @return void
	 */
	protected function setUp(): void {

		parent::setUp();

		$GLOBALS['shurloc_test_actions']         = array();
		$GLOBALS['shurloc_test_action_metadata'] = array();
	}

	/**
	 * Bootstrap function should exist.
	 *
	 * @return void
	 */
	public function test_bootstrap_function_exists(): void {

		$this->load_plugin();

		self::assertTrue(
			function_exists(
				__NAMESPACE__ .
					'\\shurloc_seo_tools_bootstrap'
			)
		);
	}

	/**
	 * Bootstrap should initialize the autoloader.
	 *
	 * @return void
	 */
	public function test_bootstrap_registers_autoloader(): void {

		$this->load_plugin();

		shurloc_seo_tools_bootstrap();

		self::assertTrue(
			class_exists(
				Shurloc_Autoloader::class
			)
		);
	}

	/**
	 * Bootstrap should load the FAQ schema parser.
	 *
	 * @return void
	 */
	public function test_bootstrap_loads_faq_schema_parser(): void {

		$this->load_plugin();

		shurloc_seo_tools_bootstrap();

		self::assertTrue(
			class_exists(
				Shurloc_FAQ_Schema_Parser::class
			)
		);
	}

	/**
	 * Bootstrap should load the FAQ schema generator.
	 *
	 * @return void
	 */
	public function test_bootstrap_loads_faq_schema_generator(): void {

		$this->load_plugin();

		shurloc_seo_tools_bootstrap();

		self::assertTrue(
			class_exists(
				Shurloc_FAQ_Schema_Generator::class
			)
		);
	}

	/**
	 * Bootstrap should load the FAQ schema integration.
	 *
	 * @return void
	 */
	public function test_bootstrap_loads_faq_schema_integration(): void {

		$this->load_plugin();

		shurloc_seo_tools_bootstrap();

		self::assertTrue(
			class_exists(
				Shurloc_FAQ_Schema_Integration::class
			)
		);
	}

	/**
	 * Bootstrap should register FAQ schema output.
	 *
	 * @return void
	 */
	public function test_bootstrap_registers_faq_schema_hook(): void {

		$this->load_plugin();

		shurloc_seo_tools_bootstrap();

		self::assertArrayHasKey(
			'wp_head',
			$GLOBALS['shurloc_test_actions']
		);

		self::assertSame(
			99,
			$GLOBALS['shurloc_test_action_metadata']
				['wp_head'][0]['priority']
		);

		self::assertSame(
			1,
			$GLOBALS['shurloc_test_action_metadata']
				['wp_head'][0]['accepted_args']
		);
	}

	/**
	 * Load the plugin file.
	 *
	 * @return void
	 */
	private function load_plugin(): void {

		require_once dirname( __DIR__, 2 ) .
			'/shurloc-seo-tools.php';
	}
}
