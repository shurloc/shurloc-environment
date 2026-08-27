<?php
/**
 * Tests for WPForms staging safeguards.
 *
 * @package ShurlocEnvironment
 */

declare( strict_types=1 );

use PHPUnit\Framework\TestCase;

/**
 * Tests for WPForms staging safeguards.
 */
final class ShurlocEnvironmentWpformsTest extends TestCase {

	/**
	 * Reset the test environment before each test.
	 *
	 * @return void
	 */
	protected function setUp(): void {
		parent::setUp();

		$GLOBALS['shurloc_test_environment_type'] = 'production';
		$GLOBALS['shurloc_test_actions']          = array();
		$GLOBALS['shurloc_test_filters']          = array();
	}

	/**
	 * Test that the WPForms license notice is hidden on staging.
	 *
	 * @return void
	 */
	public function test_wpforms_license_notice_is_hidden_on_staging(): void {
		$GLOBALS['shurloc_test_environment_type'] = 'staging';

		ob_start();

		shurloc_hide_wpforms_license_notice_on_staging();

		$output = ob_get_clean();

		self::assertIsString( $output );
		self::assertStringContainsString(
			'#wpforms-notice-license-activation-reached',
			$output
		);
		self::assertStringContainsString(
			'display: none !important;',
			$output
		);
	}

	/**
	 * Test that no WPForms notice CSS is output on production.
	 *
	 * @return void
	 */
	public function test_wpforms_license_notice_is_not_hidden_on_production(): void {
		$GLOBALS['shurloc_test_environment_type'] = 'production';

		ob_start();

		shurloc_hide_wpforms_license_notice_on_staging();

		$output = ob_get_clean();

		self::assertSame( '', $output );
	}

	/**
	 * Test that the WPForms staging hook is registered.
	 *
	 * @return void
	 */
	public function test_wpforms_hooks_are_registered(): void {
		shurloc_register_wpforms_hooks();

		self::assertArrayHasKey(
			'admin_head',
			$GLOBALS['shurloc_test_actions']
		);

		self::assertArrayHasKey(
			10,
			$GLOBALS['shurloc_test_actions']['admin_head']
		);

		self::assertCount(
			1,
			$GLOBALS['shurloc_test_actions']['admin_head'][10]
		);

		self::assertSame(
			'shurloc_hide_wpforms_license_notice_on_staging',
			$GLOBALS['shurloc_test_actions']['admin_head'][10][0]['callback']
		);

		self::assertSame(
			1,
			$GLOBALS['shurloc_test_actions']['admin_head'][10][0]['accepted_args']
		);
	}

	/**
	 * Test that the main environment registration includes WPForms hooks.
	 *
	 * @return void
	 */
	public function test_environment_hooks_include_wpforms_hooks(): void {
		shurloc_register_environment_hooks();

		self::assertArrayHasKey(
			'admin_head',
			$GLOBALS['shurloc_test_actions']
		);

		self::assertSame(
			'shurloc_hide_wpforms_license_notice_on_staging',
			$GLOBALS['shurloc_test_actions']['admin_head'][10][0]['callback']
		);
	}
}
