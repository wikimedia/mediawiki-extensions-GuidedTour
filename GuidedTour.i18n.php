<?php
/**
 * Internationalisation file for Guided Tour extension.
 *
 * @file
 * @author Terry Chay tchay@wikimedia.org
 * @author Matthew Flaschen mflaschen@wikimedia.org
 * @author Luke Welling lwelling@wikimedia.org
 * @ingroup Extensions
 */
$messages = array();

$messages['en'] = array(
	'guidedtour-desc' => 'Allows pages to provide a popup guided tour to assist new users',
	'guidedtour-help-url' => 'Help:Guided tours',
	'guidedtour-custom.css' => '/* Custom CSS for the GuidedTour extension. */',

	'guidedtour-start-tour' => 'Start tour',
	'guidedtour-end-tour' => 'End tour',
	'guidedtour-next' => '→',

	// test
	'guidedtour-tour-test-testing' => 'Testing',
	'guidedtour-tour-test-test-description' => 'This is a test of the description. You can include <b>HTML</b> like bold. Lorem ipsum dolor sit!',
	'guidedtour-tour-test-callouts' => 'Test callouts',
	'guidedtour-tour-test-portal-description' => 'This is the community portal page.',
	'guidedtour-tour-test-mediawiki-parse' => 'Test mediawiki parse',
	'guidedtour-tour-test-wikitext-description' => 'A guider in your on-wiki tour can contain wikitext using onShow and parseDescription. Use it to create a wikilink to the [[{{MediaWiki:Guidedtour-help-url}}|Guided tours documentation]]. Or an external link [https://github.com/tychay/mwgadget.GuidedTour to github], for instance.',
	'guidedtour-tour-test-description-page' => 'Test mediawiki description pages',
	'guidedtour-tour-test-go-description-page' => 'Go to description page',
	'guidedtour-tour-test-launch-tour' => 'Test launch tour',
	'guidedtour-tour-test-launch-tour-description' => 'Guiders can launch other guided tours. Pretty cool, huh?',
	'guidedtour-tour-test-launch-using-tours' => 'Launch a tour on using tours',
);

/** Message documentation (Message documentation)
 */
$messages['qqq'] = array(
	'guidedtour-desc' => '{{desc|name=GuidedTour|url=https://www.mediawiki.org/wiki/Extension:GuidedTour}}',
	'guidedtour-help-url' => 'Main page for GuidedTour documentation',
	'guidedtour-custom.css' => 'Custom CSS for the GuidedTour extension.  Empty by default.',
	'guidedtour-start-tour' => 'Text for button that starts tour',
	'guidedtour-end-tour' => 'Text for button that ends tour',
	'guidedtour-next' => 'Text for moving to next step of guided tour',
	'guidedtour-tour-test-testing' => 'Title of first step in test tour',
	'guidedtour-tour-test-test-description' => 'Description of the first step of test tour, in HTML.  Be sure to bold some text (it does not have to be the same word).  Do not translate the Latin.',
	'guidedtour-tour-test-callouts' => 'Title of second step in test tour, introducing callouts',
	'guidedtour-tour-test-portal-description' => 'Description of second step in test tour.  It will be pointing to the page link given at {{msg-mw|portal-url}}, in the toolbox',
	'guidedtour-tour-test-mediawiki-parse' => 'Description of third step in test tour',
	'guidedtour-tour-test-wikitext-description' => "Title of third step in test tour.  Do not translate onShow or parseDescription, because they are JavaScript method names.  Don't be concerned if [[{{MediaWiki:Guidedtour-help-url}}]] does not yet exist.",
	'guidedtour-tour-test-description-page' => 'Title of fourth step in test tour',
	'guidedtour-tour-test-go-description-page' => 'Text of the button pointing to [[{{MediaWiki:Guidedtour-help-url}}]]',
	'guidedtour-tour-test-launch-tour' => 'Title of fifth step in test tour',
	'guidedtour-tour-test-launch-tour-description' => 'Description of fifth step in test tour',
	'guidedtour-tour-test-launch-using-tours' => 'Button text for launching a tour on making tours',
);

/** German (Deutsch)
 * @author Metalhead64
 */
$messages['de'] = array(
	'guidedtour-desc' => 'Stellt für Seiten eine popupgestützte Tour bereit, um neuen Benutzern zu helfen',
	'guidedtour-help-url' => 'Help:Geführte Touren',
	'guidedtour-start-tour' => 'Tour starten',
	'guidedtour-end-tour' => 'Tour beenden',
	'guidedtour-next' => '→',
	'guidedtour-tour-test-testing' => 'Testen',
	'guidedtour-tour-test-portal-description' => 'Dies ist die Gemeinschaftsportalseite.',
	'guidedtour-tour-test-description-page' => 'MediaWiki-Beschreibungsseiten testen',
	'guidedtour-tour-test-go-description-page' => 'Gehe zur Beschreibungsseite',
	'guidedtour-tour-test-launch-tour-description' => 'Leiter können andere geführte Touren starten. Ziemlich cool, nicht wahr?',
);

/** French (français)
 * @author Gomoko
 */
$messages['fr'] = array(
	'guidedtour-desc' => 'Autoriser les pages à fournir une visite guidée surgissante pour aider les nouveaux utilisateurs',
);

/** Galician (galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'guidedtour-desc' => 'Permite que as páxinas proporcionen unha visita guiada para axudar aos usuarios novos',
);

/** Italian (italiano)
 * @author Beta16
 */
$messages['it'] = array(
	'guidedtour-desc' => 'Consente di gestire pagine per fornire un tour guidato tramite popup per assistere i nuovi utenti',
);

/** Japanese (日本語)
 * @author Shirayuki
 */
$messages['ja'] = array(
	'guidedtour-desc' => '新しい利用者を支援するポップアップのガイドツアーをページで提供できるようにする',
	'guidedtour-custom.css' => '/* ガイドツアー拡張機能用のカスタムCSS */',
);

/** Korean (한국어)
 * @author 아라
 */
$messages['ko'] = array(
	'guidedtour-desc' => '새 사용자를 돕기 위해 팝업 가이드 투어를 제공하는 문서 허용',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'guidedtour-desc' => 'Овозможува страниците да даваат отскочни прозорци со водени надгледни упатства за новите корисници',
	'guidedtour-custom.css' => '/* Прилагоден CSS за додатокот GuidedTour. */',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'guidedtour-desc' => 'Maakt het mogelijk om een rondleiding weer te geven voor nieuwe gebruikers',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'guidedtour-desc' => "A përmët le pàgine për fornì na vìsita guidà da fnestre an riliev për giuté j'utent neuv",
);

/** Ukrainian (українська)
 * @author Base
 */
$messages['uk'] = array(
	'guidedtour-desc' => 'Дозволяє сторінкам виводити вспливаюче навчання для допомоги новачкам',
);
