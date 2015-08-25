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
		$simpleExpectedCookieString = FormatJson::encode( array(
			'version' => 1,
			'tours' => array(
				'example' => array(
					'step' => 'bar',
				),
			),
		) );

		return array(
			array(
				FormatJson::encode( array(
					'version' => 1,
					'tours' => array(
						'example' => array(
							'step' => 'foo',
							'firstArticleId' => 123,
						),
					),
				) ),
				'example',
				'bar',
				FormatJson::encode( array(
					'version' => 1,
					'tours' => array(
						'example' => array(
							'step' => 'bar',
							'firstArticleId' => 123,
						),
					)
				) )
			),

			array(
				null,
				'example',
				'bar',
				$simpleExpectedCookieString,
			),

			array(
				'',
				'example',
				'bar',
				$simpleExpectedCookieString
			),

			array(
				'{}',
				'example',
				'bar',
				$simpleExpectedCookieString
			),

			array(
				FormatJson::encode( array(
					'version' => 1,
					'tours' => array(
						'someOtherTour' => array(
							'step' => 'baz',
							'firstSpecialPageName' => 'Special:Watchlist',
						),
					)
				) ),
				'example',
				'bar',
				FormatJson::encode( array(
					'version' => 1,
					'tours' => array(
						'someOtherTour' => array(
							'step' => 'baz',
							'firstSpecialPageName' => 'Special:Watchlist',
						),
						'example' => array(
							'step' => 'bar',
						),
					)
				) ),
			),
		);
	}
}
