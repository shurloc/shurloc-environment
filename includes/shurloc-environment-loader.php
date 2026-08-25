<?php
/**
 * Loader for shurloc-environment must-use plugin.
 *
 * @package ShurlocEnvironment
 */

declare( strict_types=1 );

defined( 'ABSPATH' ) || exit;

$environment_file = WP_PLUGIN_DIR
	. '/shurloc-environment/includes/shurloc-environment-mu.php';

if ( file_exists( $environment_file ) ) {
	require_once $environment_file;

	if ( function_exists( 'shurloc_register_environment_hooks' ) ) {
		shurloc_register_environment_hooks();
	}
}
