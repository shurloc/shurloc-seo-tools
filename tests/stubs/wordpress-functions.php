<?php
/**
 * WordPress function test doubles.
 *
 * @package ShurlocSEOTools
 */

declare( strict_types=1 );


/**
 * Registered test actions.
 */
$GLOBALS['shurloc_test_actions'] = array();

/**
 * Registered test action metadata.
 */
$GLOBALS['shurloc_test_action_metadata'] = array();

/**
 * Current test page ID.
 */
$GLOBALS['shurloc_test_page_id'] = 0;

/**
 * Current test post.
 */
$GLOBALS['shurloc_test_post'] = null;

/**
 * Filtered test post content.
 */
$GLOBALS['shurloc_test_filtered_content'] = null;


if ( ! function_exists( 'wp_strip_all_tags' ) ) {

	/**
	 * Strip HTML and PHP tags from a string.
	 *
	 * @param string $text          Text to strip.
	 * @param bool   $remove_breaks Whether to remove line breaks and whitespace.
	 * @return string
	 */
	function wp_strip_all_tags(
		string $text,
		bool $remove_breaks = false
	): string {

		$text = preg_replace(
			'@<(script|style)[^>]*?>.*?</\1>@si',
			'',
			$text
		) ?? '';

        // phpcs:ignore WordPress.WP.AlternativeFunctions.strip_tags_strip_tags -- Test double for wp_strip_all_tags().
		$text = strip_tags( $text );

		if ( $remove_breaks ) {
			$text = preg_replace(
				'/[\r\n\t ]+/',
				' ',
				$text
			) ?? '';
		}

		return trim( $text );
	}
}

if ( ! function_exists( 'add_action' ) ) {

	/**
	 * Register a test action.
	 *
	 * @param string   $hook          Hook name.
	 * @param callable $callback      Callback.
	 * @param int      $priority      Priority.
	 * @param int      $accepted_args Accepted arguments.
	 * @return true
	 */
	function add_action(
		string $hook,
		$callback,
		int $priority = 10,
		int $accepted_args = 1
	): bool {

		$GLOBALS['shurloc_test_actions'][ $hook ][] =
			$callback;

		$GLOBALS['shurloc_test_action_metadata'][ $hook ][] =
			array(
				'priority'      => $priority,
				'accepted_args' => $accepted_args,
			);

		return true;
	}
}

if ( ! function_exists( 'is_page' ) ) {

	/**
	 * Determine whether the current request matches a page.
	 *
	 * @param int|string|array<int|string> $page Page identifier.
	 * @return bool
	 */
	function is_page(
		$page = ''
	): bool {

		$current_page_id =
			$GLOBALS['shurloc_test_page_id'];

		if ( 0 >= $current_page_id ) {
			return false;
		}

		if ( '' === $page ) {
			return true;
		}

		if ( is_array( $page ) ) {

			foreach ( $page as $page_value ) {

				if (
					(string) $current_page_id ===
					(string) $page_value
				) {
					return true;
				}
			}

			return false;
		}

		return (string) $current_page_id ===
			(string) $page;
	}
}

if ( ! function_exists( 'get_post' ) ) {

	/**
	 * Get the current test post.
	 *
	 * @param int|WP_Post|null $post Post ID or post object.
	 * @return WP_Post|null
	 */
	function get_post(
		$post = null
	): ?WP_Post {

		if ( $post instanceof WP_Post ) {
			return $post;
		}

		$current_post =
			$GLOBALS['shurloc_test_post'];

		return $current_post instanceof WP_Post
			? $current_post
			: null;
	}
}

if ( ! function_exists( 'apply_filters' ) ) {

	/**
	 * Apply a test filter.
	 *
	 * @param string $hook  Hook name.
	 * @param mixed  $value Value.
	 * @param mixed  ...$args Additional arguments.
	 * @return mixed
	 */
	function apply_filters(
		string $hook,
		$value,
		...$args
	) {

		unset( $args );

		if (
			'the_content' === $hook &&
			null !== $GLOBALS['shurloc_test_filtered_content']
		) {
			return $GLOBALS['shurloc_test_filtered_content'];
		}

		return $value;
	}
}

if ( ! function_exists( 'wp_json_encode' ) ) {

	/**
	 * Encode test data as JSON.
	 *
	 * @param mixed $value Value to encode.
	 * @param int   $flags JSON encoding flags.
	 * @param int   $depth Maximum depth.
	 * @return string|false
	 */
	function wp_json_encode(
		$value,
		int $flags = 0,
		int $depth = 512
	): string|false {

		if ( $depth < 1 ) {
			return false;
		}

		// phpcs:ignore WordPress.WP.AlternativeFunctions.json_encode_json_encode -- Test double for wp_json_encode().
		return json_encode(
			$value,
			$flags,
			$depth
		);
	}
}

if ( ! function_exists( 'wp_kses' ) ) {

	/**
	 * Filter test HTML.
	 *
	 * @param string                     $content         Content.
	 * @param array<string,mixed>|string $allowed_html Allowed HTML.
	 * @param array<string,mixed>        $allowed_protocols Allowed protocols.
	 * @return string
	 */
	function wp_kses(
		string $content,
		$allowed_html,
		array $allowed_protocols = array()
	): string {

		unset(
			$allowed_html,
			$allowed_protocols
		);

		return $content;
	}
}
