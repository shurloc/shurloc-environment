<?php
/**
 * PHPUnit bootstrap.
 *
 * @package ShurlocEnvironment
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || define( 'ABSPATH', dirname( __DIR__ ) . '/' );

/**
 * Current WordPress environment type used by tests.
 */
$GLOBALS['shurloc_test_environment_type'] = 'production';

/**
 * Registered test actions.
 */
$GLOBALS['shurloc_test_actions'] = array();

/**
 * Registered test filters.
 */
$GLOBALS['shurloc_test_filters'] = array();

if ( ! function_exists( 'wp_get_environment_type' ) ) {
	/**
	 * Test replacement for wp_get_environment_type().
	 *
	 * @return string
	 */
	function wp_get_environment_type(): string {
		return $GLOBALS['shurloc_test_environment_type'];
	}
}

if ( ! function_exists( 'esc_html' ) ) {
	/**
	 * Test replacement for esc_html().
	 *
	 * @param string $text Text to escape.
	 * @return string
	 */
	function esc_html( string $text ): string {
		return $text;
	}
}

if ( ! function_exists( 'add_action' ) ) {
	/**
	 * Test replacement for add_action().
	 *
	 * @param string   $hook_name     Action hook name.
	 * @param callable $callback      Callback.
	 * @param int      $priority      Hook priority.
	 * @param int      $accepted_args Number of accepted arguments.
	 * @return true
	 */
	function add_action(
		string $hook_name,
		callable $callback,
		int $priority = 10,
		int $accepted_args = 1
	): true {
		$GLOBALS['shurloc_test_actions'][ $hook_name ][ $priority ][] = array(
			'callback'      => $callback,
			'accepted_args' => $accepted_args,
		);

		return true;
	}
}

if ( ! function_exists( 'add_filter' ) ) {
	/**
	 * Test replacement for add_filter().
	 *
	 * @param string   $hook_name     Filter hook name.
	 * @param callable $callback      Callback.
	 * @param int      $priority      Hook priority.
	 * @param int      $accepted_args Number of accepted arguments.
	 * @return true
	 */
	function add_filter(
		string $hook_name,
		callable $callback,
		int $priority = 10,
		int $accepted_args = 1
	): true {
		$GLOBALS['shurloc_test_filters'][ $hook_name ][ $priority ][] = array(
			'callback'      => $callback,
			'accepted_args' => $accepted_args,
		);

		return true;
	}
}

require_once dirname( __DIR__ ) . '/includes/shurloc-environment-mu.php';
