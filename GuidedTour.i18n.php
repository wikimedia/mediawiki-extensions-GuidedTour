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

	// Messages useful for more than one tour
	'guidedtour-end-tour' => 'End tour',
	'guidedtour-okay-button' => 'Okay',

	// Messages for specific tours.  These should be namespaced as
	// guidedtour-tour-specifictourname-message-name

	// test
	'guidedtour-tour-test-testing' => 'Testing',
	'guidedtour-tour-test-test-description' => 'This is a test of the description. Lorem ipsum dolor sit!',
	'guidedtour-tour-test-callouts' => 'Test callouts',
	'guidedtour-tour-test-portal-description' => 'This is the community portal page.',
	'guidedtour-tour-test-mediawiki-parse' => 'Test MediaWiki parse',
	'guidedtour-tour-test-wikitext-description' => 'A guider in your on-wiki tour can contain wikitext using onShow and parseDescription. Use it to create a wikilink to the [[{{MediaWiki:Guidedtour-help-url}}|Guided tours documentation]]. Or an external link [https://github.com/tychay/mwgadget.GuidedTour to GitHub], for instance.',
	'guidedtour-tour-test-description-page' => 'Test MediaWiki description pages',
	'guidedtour-tour-test-go-description-page' => 'Go to description page',
	'guidedtour-tour-test-launch-tour' => 'Test launch tour',
	'guidedtour-tour-test-launch-tour-description' => 'Guiders can launch other guided tours. Pretty cool, huh?',
	'guidedtour-tour-test-launch-using-tours' => 'Launch a tour on using tours',

	// gettingstarted
	'guidedtour-tour-gettingstarted-start-title' => 'Ready to help?',
	'guidedtour-tour-gettingstarted-start-description' => 'This page needs basic copyediting – improving the grammar, style, tone, or spelling – to make it clear and easy to read. This tour will show you the steps to take.',
	'guidedtour-tour-gettingstarted-click-edit-title' => 'Click \'{{int:vector-view-edit}}\'',
	'guidedtour-tour-gettingstarted-click-edit-description' => 'This will let you make changes to any part of the page, when you\'re ready.',
	'guidedtour-tour-gettingstarted-click-preview-title' => 'Preview (optional)',
	'guidedtour-tour-gettingstarted-click-preview-description' => 'Clicking \'{{int:showpreview}}\' allows you to check what the page will look like with your changes. Just don\'t forget to save.',
	'guidedtour-tour-gettingstarted-click-save-title' => 'You\'re almost finished!',
	'guidedtour-tour-gettingstarted-click-save-description' => 'Click \'{{int:savearticle}}\' and your changes will be visible.',
	'guidedtour-tour-gettingstarted-end-title' => 'Looking for more to do?',
	'guidedtour-tour-gettingstarted-end-description' => '[[Special:GettingStarted|Getting Started]] is updated every hour with new pages.',
);

/** Message documentation (Message documentation)
 * @author Mattflaschen
 * @author Shirayuki
 */
$messages['qqq'] = array(
	'guidedtour-desc' => '{{desc|name=GuidedTour|url=https://www.mediawiki.org/wiki/Extension:GuidedTour}}',
	'guidedtour-help-url' => 'Main page for GuidedTour documentation',
	'guidedtour-custom.css' => '{{Optional}}
Custom CSS for the GuidedTour extension.  Empty by default.',
	'guidedtour-end-tour' => 'Label text of checkbox for choosing whether to end tour',
	'guidedtour-okay-button' => 'Main action button text.  Will dismiss single tour step, go to next step, or end tour depending on context and {{msg-mw|guidedtour-end-tour}} checkbox.'
	'guidedtour-tour-test-testing' => 'Title of first step in test tour',
	'guidedtour-tour-test-test-description' => 'Sample description to show how it is used.
{{doc-important|Do not translate the Latin "Lorem ipsum dolor sit!".}}',
	'guidedtour-tour-test-callouts' => 'Title of second step in test tour, introducing callouts',
	'guidedtour-tour-test-portal-description' => 'Description of second step in test tour.  It will be pointing to the page link given at {{msg-mw|portal-url}}, in the toolbox',
	'guidedtour-tour-test-mediawiki-parse' => 'Description of third step in test tour',
	'guidedtour-tour-test-wikitext-description' => "Title of third step in test tour.  Do not translate onShow or parseDescription, because they are JavaScript method names.  Don't be concerned if [[{{MediaWiki:Guidedtour-help-url}}]] does not yet exist.",
	'guidedtour-tour-test-description-page' => 'Title of fourth step in test tour',
	'guidedtour-tour-test-go-description-page' => 'Text of the button pointing to [[{{MediaWiki:Guidedtour-help-url}}]]',
	'guidedtour-tour-test-launch-tour' => 'Title of fifth step in test tour',
	'guidedtour-tour-test-launch-tour-description' => 'Description of fifth step in test tour',
	'guidedtour-tour-test-launch-using-tours' => 'Button text for launching a tour on making tours',
	'guidedtour-tour-gettingstarted-start-title' => 'Title of first step of Getting Started tour.

See also:
* {{msg-mw|Notification-new-user}}',
	'guidedtour-tour-gettingstarted-start-description' => 'Description of first step of Getting Started tour',
	'guidedtour-tour-gettingstarted-click-edit-title' => 'Title of step showing user where to click {{msg-mw|vector-view-edit}}',
	'guidedtour-tour-gettingstarted-click-edit-description' => 'Description of step showing user where to click edit',
	'guidedtour-tour-gettingstarted-click-preview-title' => 'Title of step showing user where to click {{msg-mw|showpreview}}',
	'guidedtour-tour-gettingstarted-click-preview-description' => 'Click preview to preview your changes',
	'guidedtour-tour-gettingstarted-click-save-title' => 'Title of step showing user where to click {{msg-mw|savearticle}}',
	'guidedtour-tour-gettingstarted-click-save-description' => 'Click save to save your work',
	'guidedtour-tour-gettingstarted-end-title' => 'Title of last step of Getting Started tour!',
	'guidedtour-tour-gettingstarted-end-description' => 'You can find other interesting things to work on',
);

/** German (Deutsch)
 * @author Metalhead64
 */
$messages['de'] = array(
	'guidedtour-desc' => 'Stellt für Seiten eine popupgestützte Tour bereit, um neuen Benutzern zu helfen',
	'guidedtour-help-url' => 'Help:Geführte Touren',
	'guidedtour-end-tour' => 'Tour beenden',
	'guidedtour-okay-button' => 'Okay',
	'guidedtour-tour-test-testing' => 'Testen',
	'guidedtour-tour-test-test-description' => 'Dies ist ein Test der Beschreibung. Du kannst <b>HTML</b> wie Fettschrift verwenden. Lorem ipsum dolor sit!',
	'guidedtour-tour-test-callouts' => 'Legenden testen',
	'guidedtour-tour-test-portal-description' => 'Dies ist die Gemeinschaftsportalseite.',
	'guidedtour-tour-test-mediawiki-parse' => 'MediaWiki-Parser testen',
	'guidedtour-tour-test-wikitext-description' => 'Ein Leiter in deiner Wikitour kann Wikitext durch Verwendung von onShow und parseDescription beinhalten. Benutze es, um einen Wikilink zur [[{{MediaWiki:Guidedtour-help-url}}|Dokumentation]] oder einen externen Link [https://github.com/tychay/mwgadget.GuidedTour zu github] zu erstellen.',
	'guidedtour-tour-test-description-page' => 'MediaWiki-Beschreibungsseiten testen',
	'guidedtour-tour-test-go-description-page' => 'Gehe zur Beschreibungsseite',
	'guidedtour-tour-test-launch-tour' => 'Tourstart testen',
	'guidedtour-tour-test-launch-tour-description' => 'Leiter können andere geführte Touren starten. Ziemlich cool, nicht wahr?',
	'guidedtour-tour-test-launch-using-tours' => 'Eine Tour durch Verwendung von Touren starten',
);

/** French (français)
 * @author Gomoko
 * @author Seb35
 */
$messages['fr'] = array(
	'guidedtour-desc' => 'Autoriser les pages à fournir une visite guidée surgissante pour aider les nouveaux utilisateurs',
	'guidedtour-help-url' => 'Help:Visites guidées',
	'guidedtour-end-tour' => 'Terminer la visite',
	'guidedtour-okay-button' => 'D’accord',
	'guidedtour-tour-test-testing' => 'Tester',
	'guidedtour-tour-test-test-description' => 'Ceci est un test de la description. Vous pouvez inclure du <b>HTML</b> comme le gras. Lorem ipsum dolor sit !',
	'guidedtour-tour-test-callouts' => 'Tester les liens de sortie',
	'guidedtour-tour-test-portal-description' => 'Ceci est la page de portail pour la communauté.',
	'guidedtour-tour-test-mediawiki-parse' => 'Tester le rendu mediawiki',
	'guidedtour-tour-test-wikitext-description' => 'Un guide dans votre visite du wiki peut contenir du wikitexte utilisant onShow et parseDescription. Utilisez-le pour créer un lien wiki vers la [[{{MediaWiki:Guidedtour-help-url}}|documentation des visites guidées]]. Ou un lien externe [https://github.com/tychay/mwgadget.GuidedTour vers github] par exemple.',
	'guidedtour-tour-test-description-page' => 'Tester les pages de description mediawiki',
	'guidedtour-tour-test-go-description-page' => 'Aller à la page de description',
	'guidedtour-tour-test-launch-tour' => 'Tester la visite de lancement',
	'guidedtour-tour-test-launch-tour-description' => 'Les guides peuvent lancer d’autres visites guidées. Plutôt cool, non ?',
	'guidedtour-tour-test-launch-using-tours' => 'Lancer une visite en utilisant des visites',
);

/** Galician (galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'guidedtour-desc' => 'Permite que as páxinas proporcionen unha visita guiada para axudar aos usuarios novos',
	'guidedtour-help-url' => 'Help:Visitas guiadas',
	'guidedtour-custom.css' => '/* CSS personalizado para a extensión de visitas guiadas. */',
	'guidedtour-start-tour' => 'Comezar a visita',
	'guidedtour-end-tour' => 'Finalizar a visita',
	'guidedtour-tour-test-testing' => 'Probas',
	'guidedtour-tour-test-test-description' => 'Esta é unha proba da descrición. Pode incluír <b>HTML</b> en negra. Lorem ipsum dolor sit!',
	'guidedtour-tour-test-callouts' => 'Probar as ligazóns de saída',
	'guidedtour-tour-test-portal-description' => 'Esta é a páxina do portal da comunidade.',
	'guidedtour-tour-test-mediawiki-parse' => 'Probar a análise do MediaWiki',
	'guidedtour-tour-test-wikitext-description' => 'Unha guía no seu wiki pode conter texto wiki usando onShow e parseDescription. Utilíceo para crear unha ligazón cara á [[{{MediaWiki:Guidedtour-help-url}}|documentación sobre as visitas guiadas]]. Ou unha ligazón externa [https://github.com/tychay/mwgadget.GuidedTour cara a github], por exemplo.',
	'guidedtour-tour-test-description-page' => 'Probar as páxinas de descrición de MediaWiki',
	'guidedtour-tour-test-go-description-page' => 'Ir á páxina de descrición',
	'guidedtour-tour-test-launch-tour' => 'Probar a visita de lanzamento',
	'guidedtour-tour-test-launch-tour-description' => 'As guías poden lanzar outras visitas guiadas. Caralludo, ou?',
	'guidedtour-tour-test-launch-using-tours' => 'Lanzar unha guía sobre como usar as visitas',
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
	'guidedtour-desc' => '新しい利用者を支援するポップアップのガイド付きツアーをページで提供できるようにする',
	'guidedtour-help-url' => 'Help:ガイド付きツアー',
	'guidedtour-custom.css' => '/* ガイドツアー拡張機能用のカスタムCSS */',
	'guidedtour-end-tour' => 'ツアーを終了',
	'guidedtour-okay-button' => 'OK',
	'guidedtour-tour-test-testing' => 'テスト',
	'guidedtour-tour-test-test-description' => 'これは説明のテストです。<b>太字</b>のような HTML を含めることができます。Lorem ipsum dolor sit!',
	'guidedtour-tour-test-callouts' => '呼び出しのテスト',
	'guidedtour-tour-test-portal-description' => 'これはコミュニティのポータルページです。',
	'guidedtour-tour-test-mediawiki-parse' => 'MediaWiki の構文解析のテスト',
	'guidedtour-tour-test-description-page' => 'MediaWiki 説明ページのテスト',
	'guidedtour-tour-test-go-description-page' => '説明ページに移動',
);

/** Korean (한국어)
 * @author 아라
 */
$messages['ko'] = array(
	'guidedtour-desc' => '새 사용자를 돕기 위해 팝업 가이드 투어를 제공하는 문서 허용',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'guidedtour-help-url' => 'Help:Guidéiert Touren',
	'guidedtour-start-tour' => 'Tour ufänken',
	'guidedtour-end-tour' => 'Mam Tour ophalen',
	'guidedtour-tour-test-testing' => 'Testen',
	'guidedtour-tour-test-portal-description' => "Dëst ass d'Portalsäit vun der Community",
	'guidedtour-tour-test-mediawiki-parse' => 'MediaWiki-Parser testen',
	'guidedtour-tour-test-go-description-page' => "Op d'Beschreiwungssäit goen",
	'guidedtour-tour-test-launch-tour' => 'Ufank vum Tour testen',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'guidedtour-desc' => 'Овозможува страниците да даваат отскочни прозорци со водени надгледни упатства за новите корисници',
	'guidedtour-help-url' => 'Help:Водени тури',
	'guidedtour-custom.css' => '/* Прилагоден CSS за додатокот GuidedTour. */',
	'guidedtour-end-tour' => 'Заврши ја турата',
	'guidedtour-okay-button' => 'Во ред',
	'guidedtour-tour-test-testing' => 'Испробување',
	'guidedtour-tour-test-test-description' => 'Ова е проба за описот. Можете да ставите <b>HTML</b> како засебелени букви. Lorem ipsum dolor sit!',
	'guidedtour-tour-test-callouts' => 'Испробување на повици',
	'guidedtour-tour-test-portal-description' => 'Ова е страница на порталот на заедницата.',
	'guidedtour-tour-test-mediawiki-parse' => 'Испробување на парсирањето на МедијаВики',
	'guidedtour-tour-test-wikitext-description' => 'Водичот во вашата викутира може да содржи викитекст што користи onShow и parseDescription. Користете го за да направите викиврска до [[{{MediaWiki:Guidedtour-help-url}}|Документацијата за Водени тури]]. Или пак надворешна врска, на пример [https://github.com/tychay/mwgadget.GuidedTour до github].',
	'guidedtour-tour-test-description-page' => 'Испробување на описните страници на МедијаВики',
	'guidedtour-tour-test-go-description-page' => 'Појди на описна страница',
	'guidedtour-tour-test-launch-tour' => 'Испробување на пуштањето на турата',
	'guidedtour-tour-test-launch-tour-description' => 'Водичите можат да пуштаат други водени тури. Баш добро, нели?',
	'guidedtour-tour-test-launch-using-tours' => 'Пушти тура за користење на тури',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'guidedtour-desc' => 'Maakt het mogelijk om een rondleiding weer te geven voor nieuwe gebruikers',
	'guidedtour-help-url' => 'Help:Rondleidingen',
	'guidedtour-end-tour' => 'Rondleiding beëindigen',
	'guidedtour-okay-button' => 'Oké',
	'guidedtour-tour-test-testing' => 'Testen',
	'guidedtour-tour-test-test-description' => 'Dit is een test van de beschrijving. U kunt <b>HTML</b> gebruiken.',
	'guidedtour-tour-test-callouts' => 'Test toelichtingen',
	'guidedtour-tour-test-portal-description' => 'Dit is het gemeenschapsportaal.',
	'guidedtour-tour-test-mediawiki-parse' => 'Test mediawiki parse',
	'guidedtour-tour-test-wikitext-description' => 'Een raadgever in uw wikirondleiding die wikitekst kan bevatten met gebruik van onShow en parseDescription. Gebruik het om een wikikoppeling te maken naar de [[{{MediaWiki:Guidedtour-help-url}}|documentatie voor rondleidingen]]. U kunt er ook een externe koppeling mee maken, zoals bijvoorbeeld [https://github.com/tychay/mwgadget.GuidedTour naar GitHub].',
	'guidedtour-tour-test-description-page' => "Test MediaWiki beschrijvingspagina's",
	'guidedtour-tour-test-go-description-page' => 'Ga naar beschrijvingspagina',
	'guidedtour-tour-test-launch-tour' => 'Test start rondleiding',
	'guidedtour-tour-test-launch-tour-description' => 'Via raadgevers kunnen andere rondleidingen gestart worden. Leuk, toch?',
	'guidedtour-tour-test-launch-using-tours' => 'Start een rondleiding bij het gebruik van rondleidingen',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'guidedtour-desc' => "A përmët le pàgine për fornì na vìsita guidà da fnestre an riliev për giuté j'utent neuv",
	'guidedtour-help-url' => 'Help:Vir guidà',
	'guidedtour-start-tour' => 'Ancamin-a vir',
	'guidedtour-end-tour' => 'Finiss vir',
	'guidedtour-tour-test-testing' => 'Prové',
	'guidedtour-tour-test-test-description' => "Cost a l'é na preuva dla descrission. It peule anclude <b>HTML</b> an grassèt. Lorem ipsum dolor sit!",
	'guidedtour-tour-test-callouts' => 'Fumèt ëd test',
	'guidedtour-tour-test-portal-description' => "Costa a l'é la pagina dël portal dla comunità.",
	'guidedtour-tour-test-mediawiki-parse' => 'Preuva parsificassion dël test',
	'guidedtour-tour-test-wikitext-description' => 'Un guidator an tò vir dla wiki a peul conten-e wikitest dovrand onShow e parse Description. Dòvrlo për creé un wikilink a la [[{{MediaWiki:Guidedtour-help-url}}|Documentassion dij vir guidà]]. O un colegament estern [https://github.com/tychay/mwgadget.GuidedTour a github], për esempi.',
	'guidedtour-tour-test-description-page' => 'Preuva pagine ëd descrission ëd mediawiki',
	'guidedtour-tour-test-go-description-page' => 'Và a la pagina ëd descrission',
	'guidedtour-tour-test-launch-tour' => 'Preuva ël vir inissial',
	'guidedtour-tour-test-launch-tour-description' => 'Ij guidator a peulo ancaminé àutr vir guidà. Bastansa bel, nò?',
	'guidedtour-tour-test-launch-using-tours' => 'Ancamin-a un vir dzor dovré ij vir',
);

/** Russian (русский)
 * @author DCamer
 */
$messages['ru'] = array(
	'guidedtour-end-tour' => 'Закончить тур',
	'guidedtour-tour-test-testing' => 'Тестирование',
	'guidedtour-tour-test-test-description' => 'Это тест описание. Вы можете видеть что <b>HTML</b> полужирный. Lorem ipsum dolor sit!',
	'guidedtour-tour-test-callouts' => 'Тест выноски',
	'guidedtour-tour-test-mediawiki-parse' => 'Тест mediawiki parse',
	'guidedtour-tour-test-go-description-page' => 'Перейти на страницу описания',
	'guidedtour-tour-test-launch-tour' => 'Тестовый запуск тура',
);

/** Ukrainian (українська)
 * @author Base
 */
$messages['uk'] = array(
	'guidedtour-desc' => 'Дозволяє сторінкам виводити вспливаюче навчання для допомоги новачкам',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Yfdyh000
 */
$messages['zh-hans'] = array(
	'guidedtour-desc' => '允许页面提供一个弹出式菜单来帮助新用户',
	'guidedtour-help-url' => '帮助:导游', # Fuzzy
	'guidedtour-end-tour' => '结束教程',
	'guidedtour-tour-test-testing' => '测验',
	'guidedtour-tour-test-portal-description' => '这是社区门户页面。',
	'guidedtour-tour-test-mediawiki-parse' => '测试 MediaWiki 解析器',
	'guidedtour-tour-test-description-page' => '测试 MediaWiki 描述页面',
	'guidedtour-tour-test-go-description-page' => '转到描述页面',
);
