<?php

class GuidedTourLauncherTest extends MediaWikiTestCase {
	/**
	 * @dataProvider getNewCookieProvider
	 */
	public function testGetNewCookie( $oldCookieValue, $tourName, $step, $expectedNewCookieValue ) {
		$newCookieValue = GuidedTourLauncher::getNewCookie( $oldCookieValue, $tourName, $step );
		$this->assertSame(
			$expectedNewCookieValue,
			$newCookieValue
		);
	}

	public function getNewCookieProvider() {
		$simpleExpectedCookieString = FormatJson::encode( [
			'version' => 1,
			'tours' => [
				'example' => [
					'step' => 'bar',
				],
			],
		] );

		return [
			[
				FormatJson::encode( [
					'version' => 1,
					'tours' => [
						'example' => [
							'step' => 'foo',
							'firstArticleId' => 123,
						],
					],
				] ),
				'example',
				'bar',
				FormatJson::encode( [
					'version' => 1,
					'tours' => [
						'example' => [
							'step' => 'bar',
							'firstArticleId' => 123,
						],
					]
				] )
			],

			[
				null,
				'example',
				'bar',
				$simpleExpectedCookieString,
			],

			[
				'',
				'example',
				'bar',
				$simpleExpectedCookieString
			],

			[
				'{}',
				'example',
				'bar',
				$simpleExpectedCookieString
			],

			[
				FormatJson::encode( [
					'version' => 1,
					'tours' => [
						'someOtherTour' => [
							'step' => 'baz',
							'firstSpecialPageName' => 'Special:Watchlist',
						],
					]
				] ),
				'example',
				'bar',
				FormatJson::encode( [
					'version' => 1,
					'tours' => [
						'someOtherTour' => [
							'step' => 'baz',
							'firstSpecialPageName' => 'Special:Watchlist',
						],
						'example' => [
							'step' => 'bar',
						],
					]
				] ),
			],
		];
	}
}
