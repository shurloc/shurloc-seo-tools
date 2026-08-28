<?php
/**
 * Tests for the FAQ schema generator.
 *
 * @package ShurlocSEOTools
 */

declare( strict_types=1 );

namespace Shurloc\SEOTools;

use PHPUnit\Framework\TestCase;

/**
 * Tests the FAQ schema generator.
 */
final class ShurlocFAQSchemaGeneratorTest extends TestCase {

	/**
	 * Generator under test.
	 *
	 * @var Shurloc_FAQ_Schema_Generator
	 */
	private Shurloc_FAQ_Schema_Generator $generator;

	/**
	 * Prepare each test.
	 *
	 * @return void
	 */
	protected function setUp(): void {

		parent::setUp();

		$this->generator =
			new Shurloc_FAQ_Schema_Generator();
	}

	/**
	 * Verify empty FAQ data produces no schema.
	 *
	 * @return void
	 */
	public function test_generate_returns_empty_array_for_empty_items(): void {

		self::assertSame(
			array(),
			$this->generator->generate(
				faq_items: array(),
			)
		);
	}

	/**
	 * Verify a valid FAQ item is converted to FAQPage schema.
	 *
	 * @return void
	 */
	public function test_generate_builds_faq_page_schema(): void {

		$result = $this->generator->generate(
			faq_items: array(
				array(
					'question' => 'What is Shur-loc mesh?',
					'answer'   =>
						'Shur-loc mesh is used for screening and filtration applications.',
				),
			),
		);

		self::assertSame(
			array(
				'@context'   => 'https://schema.org',
				'@type'      => 'FAQPage',
				'mainEntity' => array(
					array(
						'@type'          => 'Question',
						'name'           => 'What is Shur-loc mesh?',
						'acceptedAnswer' => array(
							'@type' => 'Answer',
							'text'  =>
								'Shur-loc mesh is used for screening and filtration applications.',
						),
					),
				),
			),
			$result
		);
	}

	/**
	 * Verify multiple FAQ items are preserved in order.
	 *
	 * @return void
	 */
	public function test_generate_builds_multiple_questions(): void {

		$result = $this->generator->generate(
			faq_items: array(
				array(
					'question' => 'What sizes are available?',
					'answer'   => 'Many mesh sizes are available.',
				),
				array(
					'question' => 'What materials are available?',
					'answer'   => 'Several materials are available.',
				),
			),
		);

		self::assertArrayHasKey(
			'mainEntity',
			$result
		);

		self::assertCount(
			2,
			$result['mainEntity']
		);

		self::assertSame(
			'What sizes are available?',
			$result['mainEntity'][0]['name']
		);

		self::assertSame(
			'What materials are available?',
			$result['mainEntity'][1]['name']
		);
	}

	/**
	 * Verify surrounding whitespace is removed.
	 *
	 * @return void
	 */
	public function test_generate_trims_question_and_answer(): void {

		$result = $this->generator->generate(
			faq_items: array(
				array(
					'question' => '  What size should I use?  ',
					'answer'   => '  Choose the size appropriate for the application.  ',
				),
			),
		);

		self::assertArrayHasKey(
			'mainEntity',
			$result
		);

		self::assertSame(
			'What size should I use?',
			$result['mainEntity'][0]['name']
		);

		self::assertSame(
			'Choose the size appropriate for the application.',
			$result['mainEntity'][0]['acceptedAnswer']['text']
		);
	}

	/**
	 * Verify an empty question is ignored.
	 *
	 * @return void
	 */
	public function test_generate_skips_item_with_empty_question(): void {

		$result = $this->generator->generate(
			faq_items: array(
				array(
					'question' => '',
					'answer'   => 'This answer should not be included.',
				),
			),
		);

		self::assertSame(
			array(),
			$result
		);
	}

	/**
	 * Verify a whitespace-only question is ignored.
	 *
	 * @return void
	 */
	public function test_generate_skips_item_with_whitespace_only_question(): void {

		$result = $this->generator->generate(
			faq_items: array(
				array(
					'question' => '   ',
					'answer'   => 'This answer should not be included.',
				),
			),
		);

		self::assertSame(
			array(),
			$result
		);
	}

	/**
	 * Verify an empty answer is ignored.
	 *
	 * @return void
	 */
	public function test_generate_skips_item_with_empty_answer(): void {

		$result = $this->generator->generate(
			faq_items: array(
				array(
					'question' => 'What is this?',
					'answer'   => '',
				),
			),
		);

		self::assertSame(
			array(),
			$result
		);
	}

	/**
	 * Verify a whitespace-only answer is ignored.
	 *
	 * @return void
	 */
	public function test_generate_skips_item_with_whitespace_only_answer(): void {

		$result = $this->generator->generate(
			faq_items: array(
				array(
					'question' => 'What is this?',
					'answer'   => '   ',
				),
			),
		);

		self::assertSame(
			array(),
			$result
		);
	}

	/**
	 * Verify invalid items do not remove valid items.
	 *
	 * @return void
	 */
	public function test_generate_preserves_valid_items_when_others_are_invalid(): void {

		$result = $this->generator->generate(
			faq_items: array(
				array(
					'question' => '',
					'answer'   => 'Invalid answer.',
				),
				array(
					'question' => 'What is valid?',
					'answer'   => 'This is a valid FAQ answer.',
				),
				array(
					'question' => 'What is missing?',
					'answer'   => '',
				),
			),
		);

		self::assertArrayHasKey(
			'mainEntity',
			$result
		);

		self::assertCount(
			1,
			$result['mainEntity']
		);

		self::assertSame(
			'What is valid?',
			$result['mainEntity'][0]['name']
		);

		self::assertSame(
			'This is a valid FAQ answer.',
			$result['mainEntity'][0]['acceptedAnswer']['text']
		);
	}
}
