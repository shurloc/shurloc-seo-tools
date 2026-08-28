<?php
/**
 * WordPress function test doubles.
 *
 * @package ShurlocSEOTools
 */

declare( strict_types=1 );

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
