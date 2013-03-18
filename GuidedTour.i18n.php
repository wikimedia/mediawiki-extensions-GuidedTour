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
	'guidedtour-help-guider-url' => 'Help:Guided tours/guider',
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
	'guidedtour-tour-test-portal-description' => 'This is the {{int:portal}} page.',
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
	'guidedtour-help-guider-url' => 'Brief GuidedTour documentation page that a tour step can transclude.  Used in the test tour.',
	'guidedtour-custom.css' => '{{Optional}}
Custom CSS for the GuidedTour extension.  Empty by default.',
	'guidedtour-end-tour' => 'Label text of checkbox for choosing whether to end tour',
	'guidedtour-okay-button' => 'Main action button text.  Will dismiss single tour step, go to next step, or end tour depending on context and {{msg-mw|guidedtour-end-tour}} checkbox.
{{Identical|OK}}',
	'guidedtour-tour-test-testing' => 'Title of first step in test tour',
	'guidedtour-tour-test-test-description' => 'Sample description to show how it is used.
{{doc-important|Do not translate the Latin "Lorem ipsum dolor sit!".}}',
	'guidedtour-tour-test-callouts' => 'Title of second step in test tour, introducing callouts',
	'guidedtour-tour-test-portal-description' => 'Description of second step in test tour.  It will be pointing to the page link given at {{msg-mw|portal-url}}, in the toolbox',
	'guidedtour-tour-test-mediawiki-parse' => 'Description of third step in test tour',
	'guidedtour-tour-test-wikitext-description' => '{{doc-important|Do not translate "<code>onShow</code>" or "<code>parseDescription</code>", because they are JavaScript method names.}}
Title of third step in test tour.

Don\'t be concerned if [[{{MediaWiki:Guidedtour-help-url}}]] does not yet exist.',
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

/** Arabic (العربية)
 * @author Ciphers
 */
$messages['ar'] = array(
	'guidedtour-desc' => 'السماح للصفحات بعرض رسائل جولات تعريفية لمساعدة المستخدمين الجدد',
	'guidedtour-help-url' => 'مساعدة:جولات تعريفية', # Fuzzy
	'guidedtour-end-tour' => 'نهاية الجولة',
	'guidedtour-okay-button' => 'حسنا',
	'guidedtour-tour-test-testing' => 'تجربة',
	'guidedtour-tour-test-test-description' => 'هذه تجربة للوصف. أهلا بكم!',
	'guidedtour-tour-test-callouts' => 'شرح التجربة',
	'guidedtour-tour-test-portal-description' => 'هذه هي صفحة بوابة المجتمع.', # Fuzzy
	'guidedtour-tour-test-mediawiki-parse' => 'تحليل تجربة الميدياويكي',
	'guidedtour-tour-test-description-page' => 'صفحات شرح تجربة ميدياويكي',
	'guidedtour-tour-test-go-description-page' => 'اذهب إلى صفحة الشرح',
	'guidedtour-tour-test-launch-tour' => 'جولة تجربة الإطلاق',
	'guidedtour-tour-test-launch-tour-description' => 'من الممكن للأدلاء إطلاق المزيد من الجولات التعريفية. أليس ذلك رائعا؟',
	'guidedtour-tour-test-launch-using-tours' => 'إطلاق جولة حول استخدام الجولات',
	'guidedtour-tour-gettingstarted-start-title' => 'هل أنت مستعد للمساعدة؟',
	'guidedtour-tour-gettingstarted-start-description' => 'تحتاج هذه الصفحة للتنسيق البسيط - التدقيق اللغوي، والتنسيق، أو التدقيق الإملائي ولذلك لكي تصبح أبسط وأسهل للقراءة. ستساعدك هذه الجولة على معرفة كيفية القيام بذلك.',
	'guidedtour-tour-gettingstarted-click-edit-title' => "اضغط على '{{int:vector-view-edit}}'",
	'guidedtour-tour-gettingstarted-click-edit-description' => 'سيساعدك هذا على القيام بتغييرات على أي جزء من الصفحة عندما تكون جاهزا لذلك.',
	'guidedtour-tour-gettingstarted-click-preview-title' => 'عرض (اختياري)',
	'guidedtour-tour-gettingstarted-click-preview-description' => "إن الضغط على '{{int:showpreview}}' يساعدك على فحص ما ستظهر عليه الصفحة بعد قيامك بالتغييرات. لكن لا تنس حفظ تلك التغييرات.",
	'guidedtour-tour-gettingstarted-click-save-title' => 'لقد انتهيت تقريبا!',
	'guidedtour-tour-gettingstarted-click-save-description' => "اضغط على '{{int:savearticle}}' وسيتم حفظ تغييراتك.",
	'guidedtour-tour-gettingstarted-end-title' => 'هل تريد القيام بالمزيد من الأعمال؟',
	'guidedtour-tour-gettingstarted-end-description' => 'صفحة [[Special:GettingStarted|بداية التحرير]] يتم تحديثها كل ساعة بصفحات جديدة.',
);

/** Belarusian (беларуская)
 * @author Wizardist
 */
$messages['be'] = array(
	'guidedtour-desc' => 'Дазваляе паказваць на старонках усплыўныя падказкі для дапамогі новым удзельнікам',
	'guidedtour-help-url' => 'Help:Экскурсіі па сайце',
	'guidedtour-help-guider-url' => 'Help:Экскурсіі па сайце/даведка',
	'guidedtour-end-tour' => 'Скончыць экскурсію',
	'guidedtour-okay-button' => 'Далей',
	'guidedtour-tour-test-testing' => 'Тэставанне',
	'guidedtour-tour-test-test-description' => 'Гэта тэст апісання. Lorem ipsum dolor sit!',
	'guidedtour-tour-test-callouts' => 'Тэст вынятак',
	'guidedtour-tour-test-portal-description' => 'Гэта старонка парталу супольнасці.', # Fuzzy
	'guidedtour-tour-test-mediawiki-parse' => 'Тэст сінтаксісу MediaWiki',
	'guidedtour-tour-test-wikitext-description' => 'Выняткі ў экскурсіях па сайце могуць змяшчаць вікітэкст, дзякуючы onShow і parseDescription. Іх можна выкарыстаць, каб стварыць спасылку на [[{{MediaWiki:Guidedtour-help-url}}|дакументацыю па экскурсіях]], або знешнюю спасылку на [https://github.com/tychay/mwgadget.GuidedTour GitHub].',
	'guidedtour-tour-test-description-page' => 'Тэст старонак апісання MediaWiki',
	'guidedtour-tour-test-go-description-page' => 'Перайсці на старонку апісання',
	'guidedtour-tour-test-launch-tour' => 'Тэставы запуск экскурсіі',
	'guidedtour-tour-test-launch-tour-description' => 'У часе адной экскурсіі можна пачаць і іншыя. Крута, га?',
	'guidedtour-tour-test-launch-using-tours' => 'Пачаць экскурсію пра выкарыстанне экскурсіяў',
	'guidedtour-tour-gettingstarted-start-title' => 'Гатовыя дапамагчы?',
	'guidedtour-tour-gettingstarted-start-description' => 'Гэтая старонка вымагае простай вычыткі: праверкі граматыкі, стылю, арфаграфіі — усяго, каб палегчыць успрыманне інфармацыі. Гэтая экскурсія пакажа вам, што трэба для гэтага зрабіць.',
	'guidedtour-tour-gettingstarted-click-edit-title' => 'Націсніце «{{int:vector-view-edit}}»',
	'guidedtour-tour-gettingstarted-click-edit-description' => 'Тут вы зможаце ўнесці змены ў любую частку старонкі, калі будзеце гатовыя.',
	'guidedtour-tour-gettingstarted-click-preview-title' => 'Папярэдні прагляд (па жаданні)',
	'guidedtour-tour-gettingstarted-click-preview-description' => 'Націсніце «{{int:showpreview}}», каб пабачыць, як будзе выглядаць старонка з унесенымі вамі зменамі. Па праглядзе не забудзьце захаваць!',
	'guidedtour-tour-gettingstarted-click-save-title' => 'Ужо амаль усё!',
	'guidedtour-tour-gettingstarted-click-save-description' => 'Націсніце «{{int:savearticle}}» і вашыя змены будуць бачныя ўсім.',
	'guidedtour-tour-gettingstarted-end-title' => 'Што б зрабіць?..',
	'guidedtour-tour-gettingstarted-end-description' => 'Старонка «[[Special:GettingStarted|З чаго пачаць]]» кожную гадзіну напаўняецца новымі старонкамі.',
);

/** Belarusian (Taraškievica orthography) (беларуская (тарашкевіца)‎)
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'guidedtour-desc' => 'Дазваляе паказваць на старонках усплыўныя падказкі для дапамогі новым удзельнікам',
	'guidedtour-help-url' => 'Help:Экскурсіі па сайце',
	'guidedtour-help-guider-url' => 'Help:Экскурсіі па сайце/даведка',
	'guidedtour-custom.css' => '/* Дадатковы CSS для пашырэньня GuidedTour. */',
	'guidedtour-end-tour' => 'Скончыць экскурсію',
	'guidedtour-okay-button' => 'Далей',
	'guidedtour-tour-test-testing' => 'Тэставаньне',
	'guidedtour-tour-test-test-description' => 'Гэта тэст апісаньня. Lorem ipsum dolor sit!',
	'guidedtour-tour-test-callouts' => 'Тэст вынятак',
	'guidedtour-tour-test-portal-description' => 'Гэта старонка парталу супольнасьці.', # Fuzzy
	'guidedtour-tour-test-mediawiki-parse' => 'Тэст сынтакса MediaWiki',
	'guidedtour-tour-test-wikitext-description' => 'Выняткі ў экскурсіях па сайце могуць зьмяшчаць вікітэкст, дзякуючы onShow і parseDescription. Іх можна выкарыстаць, каб стварыць спасылку на [[{{MediaWiki:Guidedtour-help-url}}|дакумэнтацыю па экскурсіях]], або вонкавую спасылку на [https://github.com/tychay/mwgadget.GuidedTour GitHub].',
	'guidedtour-tour-test-description-page' => 'Тэст старонак апісаньня MediaWiki',
	'guidedtour-tour-test-go-description-page' => 'Перайсьці на старонку апісаньня',
	'guidedtour-tour-test-launch-tour' => 'Тэставы запуск экскурсіі',
	'guidedtour-tour-test-launch-tour-description' => 'У часе адной экскурсіі можна пачаць і іншыя. Крута, га?',
	'guidedtour-tour-test-launch-using-tours' => 'Пачаць экскурсію пра выкарыстаньне экскурсіяў',
	'guidedtour-tour-gettingstarted-start-title' => 'Гатовыя дапамагчы?',
	'guidedtour-tour-gettingstarted-start-description' => 'Гэтая старонка вымагае простай вычыткі: праверкі граматыкі, стылю, артаграфіі — усяго, каб палегчыць успрыманьне інфармацыі. Гэтая экскурсія пакажа вам, што трэба для гэтага зрабіць.',
	'guidedtour-tour-gettingstarted-click-edit-title' => 'Націсьніце «{{int:vector-view-edit}}»',
	'guidedtour-tour-gettingstarted-click-edit-description' => 'Тут вы зможаце ўнесьці зьмены ў любую частку старонкі, калі будзеце гатовыя.',
	'guidedtour-tour-gettingstarted-click-preview-title' => 'Папярэдні прагляд (па жаданьні)',
	'guidedtour-tour-gettingstarted-click-preview-description' => 'Націсьніце «{{int:showpreview}}», каб пабачыць, як будзе выглядаць старонка з унесенымі вамі зьменамі. Па праглядзе не забудзьце захаваць!',
	'guidedtour-tour-gettingstarted-click-save-title' => 'Ужо амаль усё!',
	'guidedtour-tour-gettingstarted-click-save-description' => 'Націсьніце «{{int:savearticle}}» і вашыя зьмены будуць бачныя ўсім.',
	'guidedtour-tour-gettingstarted-end-title' => 'Што б зрабіць?..',
	'guidedtour-tour-gettingstarted-end-description' => 'Старонка «[[Special:GettingStarted|З чаго пачаць]]» кожную гадзіну напаўняецца новымі старонкамі.',
);

/** Breton (brezhoneg)
 * @author Fohanno
 * @author Y-M D
 */
$messages['br'] = array(
	'guidedtour-okay-button' => 'A-du',
	'guidedtour-tour-test-testing' => "Oc'h amprouiñ",
);

/** German (Deutsch)
 * @author Metalhead64
 */
$messages['de'] = array(
	'guidedtour-desc' => 'Stellt für Seiten eine popupgestützte Tour bereit, um neuen Benutzern zu helfen',
	'guidedtour-help-url' => 'Help:Geführte Touren',
	'guidedtour-help-guider-url' => 'Help:Geführte Touren/Leiter',
	'guidedtour-end-tour' => 'Tour beenden',
	'guidedtour-okay-button' => 'Okay',
	'guidedtour-tour-test-testing' => 'Testen',
	'guidedtour-tour-test-test-description' => 'Dies ist ein Test der Beschreibung. Lorem ipsum dolor sit!',
	'guidedtour-tour-test-callouts' => 'Legenden testen',
	'guidedtour-tour-test-portal-description' => 'Dies ist die Seite „{{int:portal}}“.',
	'guidedtour-tour-test-mediawiki-parse' => 'MediaWiki-Parser testen',
	'guidedtour-tour-test-wikitext-description' => 'Ein Leiter in deiner Wikitour kann Wikitext durch Verwendung von onShow und parseDescription beinhalten. Benutze es, um einen Wikilink zur [[{{MediaWiki:Guidedtour-help-url}}|Dokumentation]] oder einen externen Link [https://github.com/tychay/mwgadget.GuidedTour zu github] zu erstellen.',
	'guidedtour-tour-test-description-page' => 'MediaWiki-Beschreibungsseiten testen',
	'guidedtour-tour-test-go-description-page' => 'Gehe zur Beschreibungsseite',
	'guidedtour-tour-test-launch-tour' => 'Tourstart testen',
	'guidedtour-tour-test-launch-tour-description' => 'Leiter können andere geführte Touren starten. Ziemlich cool, nicht wahr?',
	'guidedtour-tour-test-launch-using-tours' => 'Eine Tour durch Verwendung von Touren starten',
	'guidedtour-tour-gettingstarted-start-title' => 'Bereit zum Helfen?',
	'guidedtour-tour-gettingstarted-start-description' => 'Diese Seite muss grundredigiert werden. Verbessere die Grammatik, Rechtschreibung, den Stil und Ton, um sie klar und leicht lesbar zu machen. Diese Tour zeigt dir die nötigen Schritte.',
	'guidedtour-tour-gettingstarted-click-edit-title' => 'Klicke auf „{{int:vector-view-edit}}“',
	'guidedtour-tour-gettingstarted-click-edit-description' => 'Dies ermöglicht dir Änderungen an beliebigen Teilen der Seite, falls du bereit bist.',
	'guidedtour-tour-gettingstarted-click-preview-title' => 'Vorschau (optional)',
	'guidedtour-tour-gettingstarted-click-preview-description' => 'Klicke auf „{{int:showpreview}}“, um zu sehen, wie die Seite mit deinen Änderungen aussieht. Vergiss nicht zu speichern.',
	'guidedtour-tour-gettingstarted-click-save-title' => 'Du bist fast fertig!',
	'guidedtour-tour-gettingstarted-click-save-description' => 'Klicke auf „{{int:savearticle}}“ und deine Änderungen werden sichtbar.',
	'guidedtour-tour-gettingstarted-end-title' => 'Willst du mehr?',
	'guidedtour-tour-gettingstarted-end-description' => 'Die Spezialseite „[[Special:GettingStarted|Anfangen]]“ wird stündlich mit neuen Seiten aktualisiert.',
);

/** Spanish (español)
 * @author Fitoschido
 */
$messages['es'] = array(
	'guidedtour-okay-button' => 'Aceptar',
	'guidedtour-tour-test-description-page' => 'Probar las páginas de descripción de MediaWiki',
	'guidedtour-tour-test-go-description-page' => 'Ir a la página de descripción',
	'guidedtour-tour-gettingstarted-click-edit-title' => 'Pulsa «{{int:vector-view-edit}}»',
	'guidedtour-tour-gettingstarted-click-preview-title' => 'Previsualización (opcional)',
	'guidedtour-tour-gettingstarted-click-save-title' => '¡Ya casi has terminado!',
	'guidedtour-tour-gettingstarted-end-title' => '¿Buscas más que hacer?',
);

/** Estonian (eesti)
 * @author Pikne
 * @author RM87
 */
$messages['et'] = array(
	'guidedtour-tour-gettingstarted-click-edit-title' => "Klõpsa '{{int:vector-view-edit}}'",
	'guidedtour-tour-gettingstarted-click-preview-title' => 'Eelvaade (valikuline)',
	'guidedtour-tour-gettingstarted-click-save-title' => 'Sa oled peaaegu lõpetanud!',
	'guidedtour-tour-gettingstarted-click-save-description' => "Vajuta '{{int:savearticle}}' ja sinu muudatused on nähtavad.",
);

/** Basque (euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'guidedtour-okay-button' => 'Ados',
);

/** French (français)
 * @author Gomoko
 * @author Ltrlg
 * @author Seb35
 * @author Trizek
 */
$messages['fr'] = array(
	'guidedtour-desc' => 'Autoriser les pages à afficher une visite guidée par pop-up pour aider les nouveaux utilisateurs',
	'guidedtour-help-url' => 'Help:Visites guidées',
	'guidedtour-help-guider-url' => 'Help:Visites guidées/guide',
	'guidedtour-end-tour' => 'Terminer la visite',
	'guidedtour-okay-button' => 'D’accord',
	'guidedtour-tour-test-testing' => 'Tester',
	'guidedtour-tour-test-test-description' => 'Ceci est un test de la description. Lorem ipsum dolor sit !',
	'guidedtour-tour-test-callouts' => 'Tester les liens de sortie',
	'guidedtour-tour-test-portal-description' => 'Ceci est la page {{int:portal}}.',
	'guidedtour-tour-test-mediawiki-parse' => 'Tester le rendu MediaWiki',
	'guidedtour-tour-test-wikitext-description' => 'Un élément du guide de visite peut contenir du wikitexte utilisant onShow et parseDescription. Utilisez-le pour créer un lien wiki vers la [[{{MediaWiki:Guidedtour-help-url}}|documentation des visites guidées]]. Ou un lien externe [https://github.com/tychay/mwgadget.GuidedTour vers GitHub] par exemple.',
	'guidedtour-tour-test-description-page' => 'Tester les pages de description MediaWiki',
	'guidedtour-tour-test-go-description-page' => 'Aller à la page de description',
	'guidedtour-tour-test-launch-tour' => 'Tester la visite de lancement',
	'guidedtour-tour-test-launch-tour-description' => 'Les guides peuvent créer d’autres visites guidées. Plutôt cool, non ?',
	'guidedtour-tour-test-launch-using-tours' => "Lancer une visite sur l'utilisation des visites",
	'guidedtour-tour-gettingstarted-start-title' => 'Prêt à aider?',
	'guidedtour-tour-gettingstarted-start-description' => "Cette page a besoin d’une modification sur la forme — améliorer la grammaire, le style, le ton ou l'orthographe — pour la rendre claire et facile à lire. Cette visite guidée vous montrera les étapes à entreprendre.",
	'guidedtour-tour-gettingstarted-click-edit-title' => 'Cliquez sur « {{int:vector-view-edit}} »',
	'guidedtour-tour-gettingstarted-click-edit-description' => 'Cela vous permettra de faire des modifications à n’importe quelle partie de la page, quand vous serez prêt.',
	'guidedtour-tour-gettingstarted-click-preview-title' => 'Aperçu (facultatif)',
	'guidedtour-tour-gettingstarted-click-preview-description' => "Cliquer sur « {{int:showpreview}} » vous permet de vérifier à quoi ressemblera la page avec vos modifications. Ensuite, n'oubliez pas de publier pour enregistrer.",
	'guidedtour-tour-gettingstarted-click-save-title' => 'Vous avez presque fini !',
	'guidedtour-tour-gettingstarted-click-save-description' => 'Cliquez sur «”{{int:savearticle}} » et vos modifications seront visibles.',
	'guidedtour-tour-gettingstarted-end-title' => 'Vous cherchez autre chose à faire ?',
	'guidedtour-tour-gettingstarted-end-description' => '[[Special:GettingStarted|Pour démarrer]] est mis à jour chaque heure avec de nouvelles pages.',
);

/** Galician (galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'guidedtour-desc' => 'Permite que as páxinas proporcionen unha visita guiada para axudar aos usuarios novos',
	'guidedtour-help-url' => 'Help:Visitas guiadas',
	'guidedtour-help-guider-url' => 'Help:Visitas guiadas/guía',
	'guidedtour-custom.css' => '/* CSS personalizado para a extensión de visitas guiadas. */',
	'guidedtour-end-tour' => 'Finalizar a visita',
	'guidedtour-okay-button' => 'De acordo',
	'guidedtour-tour-test-testing' => 'Probas',
	'guidedtour-tour-test-test-description' => 'Esta é unha proba da descrición. Lorem ipsum dolor sit!',
	'guidedtour-tour-test-callouts' => 'Probe as ligazóns de saída',
	'guidedtour-tour-test-portal-description' => 'Esta é a páxina do {{int:portal}}.',
	'guidedtour-tour-test-mediawiki-parse' => 'Probe o rendemento do MediaWiki',
	'guidedtour-tour-test-wikitext-description' => 'Os elemento da guía poden conter texto wiki usando onShow e parseDescription. Utilíceo para crear unha ligazón cara á [[{{MediaWiki:Guidedtour-help-url}}|documentación sobre as visitas guiadas]]. Ou unha ligazón externa [https://github.com/tychay/mwgadget.GuidedTour cara a GitHub], por exemplo.',
	'guidedtour-tour-test-description-page' => 'Probe as páxinas de descrición de MediaWiki',
	'guidedtour-tour-test-go-description-page' => 'Ir á páxina de descrición',
	'guidedtour-tour-test-launch-tour' => 'Probe a visita de iniciación',
	'guidedtour-tour-test-launch-tour-description' => 'As guías poden lanzar outras visitas guiadas. Caralludo, ou?',
	'guidedtour-tour-test-launch-using-tours' => 'Iniciar a guía sobre como usar as visitas',
	'guidedtour-tour-gettingstarted-start-title' => 'Listo para axudar?',
	'guidedtour-tour-gettingstarted-start-description' => 'Esta páxina necesita correccións básicas (mellorar a gramática, o estilo, o ton, a lingua) para facela máis clara e fácil de ler. Esta guía halle mostrar os pasos a seguir.',
	'guidedtour-tour-gettingstarted-click-edit-title' => 'Prema en "{{int:vector-view-edit}}"',
	'guidedtour-tour-gettingstarted-click-edit-description' => 'Isto permite facer modificacións en calquera parte da páxina, cando estea preparado.',
	'guidedtour-tour-gettingstarted-click-preview-title' => 'Vista previa (opcional)',
	'guidedtour-tour-gettingstarted-click-preview-description' => 'Premer en "{{int:showpreview}}" serve para comprobar como se verá a páxina coas modificacións. Non esqueza gardar despois.',
	'guidedtour-tour-gettingstarted-click-save-title' => 'Case rematou!',
	'guidedtour-tour-gettingstarted-click-save-description' => 'Prema en "{{int:savearticle}}" para facer visibles as súas modificacións.',
	'guidedtour-tour-gettingstarted-end-title' => 'Busca outra cousa que facer?',
	'guidedtour-tour-gettingstarted-end-description' => 'A páxina dos [[Special:GettingStarted|primeiros pasos]] actualízase cada hora con novas páxinas.',
);

/** Hebrew (עברית)
 * @author Amire80
 */
$messages['he'] = array(
	'guidedtour-desc' => 'אפשרות לספק בדפים חלונות קופצים שעוזרים למשתמשים חדשים',
	'guidedtour-end-tour' => 'לסיים את הסיור',
	'guidedtour-okay-button' => 'סבבה',
	'guidedtour-tour-test-testing' => 'בדיקות',
	'guidedtour-tour-test-test-description' => 'זוהי בדיקה של תיאור. צנח לו זלזל!',
	'guidedtour-tour-test-callouts' => 'בדיקת חלונות יוצאים',
	'guidedtour-tour-test-portal-description' => 'זהו דף שער הקהילה.', # Fuzzy
	'guidedtour-tour-test-mediawiki-parse' => 'בדיקת פענוח מדיה ויקי',
);

/** Upper Sorbian (hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'guidedtour-help-url' => 'Help:Wjedźene tury',
	'guidedtour-help-guider-url' => 'Help:Wjedźene tury/wjednik',
	'guidedtour-end-tour' => 'Turu skónčić',
	'guidedtour-okay-button' => 'W porjadku',
	'guidedtour-tour-test-testing' => 'Testowanje',
	'guidedtour-tour-test-test-description' => 'To je test wopisanja. Lorem ipsum dolor sit!',
	'guidedtour-tour-test-callouts' => 'Wujasnjenja testować',
	'guidedtour-tour-test-portal-description' => 'To je strona {{int:portal}}.',
	'guidedtour-tour-test-mediawiki-parse' => 'Parsowanje MediaWiki testować',
	'guidedtour-tour-test-description-page' => 'Wopisanske strony mdiaWiki testować',
	'guidedtour-tour-test-go-description-page' => 'Dźi k wopisanskej stronje',
	'guidedtour-tour-test-launch-tour' => 'Turowy start testować',
	'guidedtour-tour-test-launch-tour-description' => 'Wjednicy móža druhe wjedźene tury startować. Dosć cool, něwěrno?',
	'guidedtour-tour-gettingstarted-start-title' => 'Sy hotowy, zo by pomhał?',
	'guidedtour-tour-gettingstarted-click-edit-title' => "Klikń na '{{int:vector-view-edit}}'",
	'guidedtour-tour-gettingstarted-click-preview-title' => 'Přehlad (opcionalny)',
	'guidedtour-tour-gettingstarted-click-preview-description' => "Kliknjenje an '{{int:showpreview}}' ći zmóžnja kontrolować, kak strona z twojimi změnami wupada. Njezabudź na składowanje.",
	'guidedtour-tour-gettingstarted-click-save-title' => 'Sy nimale hotowy!',
	'guidedtour-tour-gettingstarted-click-save-description' => "Klikń na '{{int:savearticle}}' a twoje změny budu widźomne.",
	'guidedtour-tour-gettingstarted-end-title' => 'Chceš wjace činić?',
	'guidedtour-tour-gettingstarted-end-description' => '[[Special:GettingStarted|Prěnje kroki]] so kóždu hodźinu z nowymi stronami aktualizuje.',
);

/** Italian (italiano)
 * @author Beta16
 */
$messages['it'] = array(
	'guidedtour-desc' => 'Consente di gestire pagine per fornire un tour guidato tramite popup per assistere i nuovi utenti',
	'guidedtour-tour-test-go-description-page' => 'Vai alla pagina di descrizione',
	'guidedtour-tour-gettingstarted-click-preview-title' => 'Anteprima (opzionale)',
);

/** Japanese (日本語)
 * @author Shirayuki
 */
$messages['ja'] = array(
	'guidedtour-desc' => '新しい利用者を支援するポップアップのガイド付きツアーをページで提供できるようにする',
	'guidedtour-help-url' => 'Help:ガイド付きツアー',
	'guidedtour-help-guider-url' => 'Help:ガイド付きツアー/guider',
	'guidedtour-custom.css' => '/* ガイドツアー拡張機能用のカスタムCSS */',
	'guidedtour-end-tour' => 'ツアーを終了',
	'guidedtour-okay-button' => 'OK',
	'guidedtour-tour-test-testing' => 'テスト',
	'guidedtour-tour-test-test-description' => 'これは説明のテストです。Lorem ipsum dolor sit!',
	'guidedtour-tour-test-callouts' => '呼び出しのテスト',
	'guidedtour-tour-test-portal-description' => 'これは{{int:portal}}のページです。',
	'guidedtour-tour-test-mediawiki-parse' => 'MediaWiki の構文解析のテスト',
	'guidedtour-tour-test-description-page' => 'MediaWiki 説明ページのテスト',
	'guidedtour-tour-test-go-description-page' => '説明ページに移動',
	'guidedtour-tour-gettingstarted-start-title' => '準備はできていますか?',
	'guidedtour-tour-gettingstarted-click-edit-title' => '「{{int:vector-view-edit}}」をクリック',
	'guidedtour-tour-gettingstarted-click-edit-description' => '記事の編集を開始するには「{{int:vector-view-edit}}」をクリックしてください', # Fuzzy
	'guidedtour-tour-gettingstarted-click-preview-title' => 'プレビュー (省略可能)',
	'guidedtour-tour-gettingstarted-click-preview-description' => '変更内容のプレビューを表示するには「{{int:showpreview}}」をクリックしてください', # Fuzzy
	'guidedtour-tour-gettingstarted-click-save-title' => 'もう少しで終わります!',
	'guidedtour-tour-gettingstarted-click-save-description' => '変更内容を保存するには「{{int:savearticle}}」をクリックしてください', # Fuzzy
	'guidedtour-tour-gettingstarted-end-title' => '他にできることをお探しですか?',
);

/** Georgian (ქართული)
 * @author David1010
 */
$messages['ka'] = array(
	'guidedtour-end-tour' => 'ტურის დასრულება',
	'guidedtour-tour-test-testing' => 'ტესტირება',
);

/** Korean (한국어)
 * @author 아라
 */
$messages['ko'] = array(
	'guidedtour-desc' => '새 사용자를 돕기 위해 팝업 가이드 투어를 문서에 제공할 수 있습니다',
	'guidedtour-help-url' => 'Help:가이드 투어',
	'guidedtour-help-guider-url' => 'Help:가이드 투어/안내자',
	'guidedtour-end-tour' => '투어 끝내기',
	'guidedtour-okay-button' => '확인',
	'guidedtour-tour-test-testing' => '테스트',
	'guidedtour-tour-test-test-description' => '설명의 테스트입니다. Lorem ipsum dolor sit!',
	'guidedtour-tour-test-callouts' => '호출 텍스트',
	'guidedtour-tour-test-portal-description' => '{{int:portal}} 문서입니다.',
	'guidedtour-tour-test-mediawiki-parse' => '미디어위키 구문 분석 테스트',
	'guidedtour-tour-test-wikitext-description' => '위키 투어의 안내자는 onShow와 parseDescription을 사용하여 포함할 수 있습니다. [[{{MediaWiki:Guidedtour-help-url}}|가이드 투어 설명서]]에 위키링크를 만드는 데 사용하세요. 또는 예를 들어 [https://github.com/tychay/mwgadget.GuidedTour GitHub로] 바깥 링크를 만드는 데 사용하세요.',
	'guidedtour-tour-test-description-page' => '미디어위키 설명 문서 테스트',
	'guidedtour-tour-test-go-description-page' => '설명 문서로 가기',
	'guidedtour-tour-test-launch-tour' => '시작 투어 테스트',
	'guidedtour-tour-test-launch-tour-description' => '안내자는 다른 가이드 투어를 시작할 수 있습니다. 멋지죠?',
	'guidedtour-tour-test-launch-using-tours' => '투어를 사용하여 투어 시작',
	'guidedtour-tour-gettingstarted-start-title' => '도움을 받을 준비가 되었습니까?',
	'guidedtour-tour-gettingstarted-start-description' => '이 문서는 명확하고 쉽게 읽을 수 있도록 기본적인 교정 - 문법, 스타일, 어조나 맞춤법 - 이 필요합니다. 이 투어는 수행할 단계를 보여줍니다.',
	'guidedtour-tour-gettingstarted-click-edit-title' => "'{{int:vector-view-edit}}' 클릭",
	'guidedtour-tour-gettingstarted-click-edit-description' => '준비가 되면 문서의 어떠한 부분을 바꿀 것입니다.',
	'guidedtour-tour-gettingstarted-click-preview-title' => '미리 보기 (선택 사항)',
	'guidedtour-tour-gettingstarted-click-preview-description' => "'{{int:showpreview}}'를 클릭하면 문서가 어떻게 바뀌었는지 확인할 수 있습니다. 저장하는 것을 잊지 마세요.",
	'guidedtour-tour-gettingstarted-click-save-title' => '거의 끝났습니다!',
	'guidedtour-tour-gettingstarted-click-save-description' => "'{{int:savearticle}}'을 클릭하여 바뀜을 볼 수 있습니다.",
	'guidedtour-tour-gettingstarted-end-title' => '다른 할 것을 찾고 있습니까?',
	'guidedtour-tour-gettingstarted-end-description' => '[[Special:GettingStarted|시작하기]]는 새 문서로 매 시간마다 업데이트합니다.',
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
	'guidedtour-help-guider-url' => 'Help:Водени тури/водич',
	'guidedtour-custom.css' => '/* Прилагоден CSS за додатокот GuidedTour. */',
	'guidedtour-end-tour' => 'Заврши ја турата',
	'guidedtour-okay-button' => 'Во ред',
	'guidedtour-tour-test-testing' => 'Испробување',
	'guidedtour-tour-test-test-description' => 'Ова е проба за описот. Lorem ipsum dolor sit!',
	'guidedtour-tour-test-callouts' => 'Испробување на повици',
	'guidedtour-tour-test-portal-description' => 'Ова е страница на порталот {{int:portal}}.',
	'guidedtour-tour-test-mediawiki-parse' => 'Испробување на парсирањето на МедијаВики',
	'guidedtour-tour-test-wikitext-description' => 'Водичот во вашата викутира може да содржи викитекст што користи onShow и parseDescription. Користете го за да направите викиврска до [[{{MediaWiki:Guidedtour-help-url}}|Документацијата за Водени тури]]. Или пак надворешна врска, на пример [https://github.com/tychay/mwgadget.GuidedTour до github].',
	'guidedtour-tour-test-description-page' => 'Испробување на описните страници на МедијаВики',
	'guidedtour-tour-test-go-description-page' => 'Појди на описна страница',
	'guidedtour-tour-test-launch-tour' => 'Испробување на пуштањето на турата',
	'guidedtour-tour-test-launch-tour-description' => 'Водичите можат да пуштаат други водени тури. Баш добро, нели?',
	'guidedtour-tour-test-launch-using-tours' => 'Пушти тура за користење на тури',
	'guidedtour-tour-gettingstarted-start-title' => 'Спремни сте да помогнете?',
	'guidedtour-tour-gettingstarted-start-description' => 'На страницава ѝ треба лектура – да се подобри граматиката, стилот, тонот и правописот – за да биде јасна и лесна за читање. Овие надгледни напатствија ќе ви покажат кои чекори треба да ги преземете.',
	'guidedtour-tour-gettingstarted-click-edit-title' => 'Стиснете на „{{int:vector-view-edit}}“',
	'guidedtour-tour-gettingstarted-click-edit-description' => 'Со ова ќе можете да вршите измени на било кој дел од страницата, кога сте подготвени.',
	'guidedtour-tour-gettingstarted-click-preview-title' => 'Преглед (незадолжително)',
	'guidedtour-tour-gettingstarted-click-preview-description' => 'Ако стиснете на „{{int:showpreview}}“ ќе видите како ќе изгледа страницата со вашите измени. Само не заборавајте да ги зачувате.',
	'guidedtour-tour-gettingstarted-click-save-title' => 'Речиси сте готови!',
	'guidedtour-tour-gettingstarted-click-save-description' => 'Стиснете на „{{int:savearticle}}“ и измените ќе бидат видливи.',
	'guidedtour-tour-gettingstarted-end-title' => 'Сакате повеќе да направите?',
	'guidedtour-tour-gettingstarted-end-description' => '[[Special:GettingStarted|Први чекори]] се подновува со нови страници на секој час.',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Santhosh.thottingal
 */
$messages['ml'] = array(
	'guidedtour-okay-button' => 'ശരി',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'guidedtour-desc' => 'Membolehkan halaman untuk menyediakan lawatan berpandu popup untuk membantu pengguna baru',
	'guidedtour-help-url' => 'Help:Lawatan berpandu',
	'guidedtour-help-guider-url' => 'Help:Lawatan berpandu/pemandu',
	'guidedtour-end-tour' => 'Tamatkan lawatan',
	'guidedtour-okay-button' => 'Baik',
	'guidedtour-tour-test-testing' => 'Menguji',
	'guidedtour-tour-test-test-description' => 'Ini ialah ujian untuk keterangan. Lorem ipsum dolor sit!',
	'guidedtour-tour-test-callouts' => 'Uji petak bual',
	'guidedtour-tour-test-portal-description' => 'Ini ialah halaman {{int:portal}}.',
	'guidedtour-tour-test-mediawiki-parse' => 'Uji huraian MediaWiki',
	'guidedtour-tour-test-wikitext-description' => 'Pemandu dalam jelajah dalam wiki anda boleh mengandungi teks wiki dengan menggunakan onShow dan parseDescription. Gunakannya untuk membuat pautan wiki ke [[{{MediaWiki:Guidedtour-help-url}}|dokumentasi Jelajah berpandu]]. Atau pautan luar [https://github.com/tychay/mwgadget.GuidedTour ke GitHub], contohnya.',
	'guidedtour-tour-test-description-page' => 'Uji halaman keterangan MediaWiki',
	'guidedtour-tour-test-go-description-page' => 'Pergi ke halaman keterangan',
	'guidedtour-tour-test-launch-tour' => 'Uji lancar jelajah',
	'guidedtour-tour-test-launch-tour-description' => 'Pemandu boleh melancarkan jelajah berpandu yang lain. Hebat, kan?',
	'guidedtour-tour-test-launch-using-tours' => 'Lancarkan jelajah menggunakan jelajah',
	'guidedtour-tour-gettingstarted-start-title' => 'Sedia untuk menolong?',
	'guidedtour-tour-gettingstarted-start-description' => 'Halaman ini memerlukan suntingan asas - membetulkan tatabahasa, gaya, lenggok atau ejaan - supaya jelas dan mudah dibaca. Jelajah ini akan menunjukkan anda langkah-langkah yang harus diambil.',
	'guidedtour-tour-gettingstarted-click-edit-title' => "Klik '{{int:vector-view-edit}}'",
	'guidedtour-tour-gettingstarted-click-edit-description' => 'Ini akan membolehkan anda untuk menyunting mana-mana bahagian halaman apabila anda bersedia.',
	'guidedtour-tour-gettingstarted-click-preview-title' => 'Pralihat (tidak wajib)',
	'guidedtour-tour-gettingstarted-click-preview-description' => "Mengklik '{{int:showpreview}}' membolehkan anda untuk menyemak rupa halaman dengan suntingan anda. Jangan lupa untuk simpan.",
	'guidedtour-tour-gettingstarted-click-save-title' => 'Anda hampir siap!',
	'guidedtour-tour-gettingstarted-click-save-description' => "Klik '{{int:savearticle}}' untuk memperlihatkan suntingan anda.",
	'guidedtour-tour-gettingstarted-end-title' => 'Nak cari kerja lagi?',
	'guidedtour-tour-gettingstarted-end-description' => '[[Special:GettingStarted|Permulaan]] dikemaskinikan setiap jam dengan halaman baru.',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'guidedtour-desc' => 'Maakt het mogelijk om een rondleiding weer te geven voor nieuwe gebruikers',
	'guidedtour-help-url' => 'Help:Rondleidingen',
	'guidedtour-help-guider-url' => 'Help:Rondleidingen/gids',
	'guidedtour-end-tour' => 'Rondleiding beëindigen',
	'guidedtour-okay-button' => 'Oké',
	'guidedtour-tour-test-testing' => 'Testen',
	'guidedtour-tour-test-test-description' => 'Dit is een test van de beschrijving. Lorem ipsum dolor sit!',
	'guidedtour-tour-test-callouts' => 'Test toelichtingen',
	'guidedtour-tour-test-portal-description' => 'Dit is de pagina {{int:portal}}.',
	'guidedtour-tour-test-mediawiki-parse' => 'Test mediawiki parse',
	'guidedtour-tour-test-wikitext-description' => 'Een raadgever in uw wikirondleiding die wikitekst kan bevatten met gebruik van onShow en parseDescription. Gebruik het om een wikikoppeling te maken naar de [[{{MediaWiki:Guidedtour-help-url}}|documentatie voor rondleidingen]]. U kunt er ook een externe koppeling mee maken, zoals bijvoorbeeld [https://github.com/tychay/mwgadget.GuidedTour naar GitHub].',
	'guidedtour-tour-test-description-page' => "Test MediaWiki beschrijvingspagina's",
	'guidedtour-tour-test-go-description-page' => 'Ga naar beschrijvingspagina',
	'guidedtour-tour-test-launch-tour' => 'Test start rondleiding',
	'guidedtour-tour-test-launch-tour-description' => 'Via raadgevers kunnen andere rondleidingen gestart worden. Leuk, toch?',
	'guidedtour-tour-test-launch-using-tours' => 'Start een rondleiding bij het gebruik van rondleidingen',
	'guidedtour-tour-gettingstarted-start-title' => 'Klaar om te helpen?',
	'guidedtour-tour-gettingstarted-start-description' => 'Deze pagina heeft eindredactie nodig: de grammatica, stijl, toon en/of spelling moeten verbeterd worden om de pagina duidelijker en makkelijker te lezen te maken. Deze rondleiding laat u zien welke stappen u kunt maken.',
	'guidedtour-tour-gettingstarted-click-edit-title' => 'Klik "{{int:vector-view-edit}}"',
	'guidedtour-tour-gettingstarted-click-edit-description' => 'Door hier te klikken kunt u als u dat wilt wijzigingen maken aan de hele pagina.',
	'guidedtour-tour-gettingstarted-click-preview-title' => 'Voorvertoning (optioneel)������',
	'guidedtour-tour-gettingstarted-click-preview-description' => 'Door te klikken op "{{int:showpreview}}" kunt u controleren hoe de pagina wordt weergegeven met uw wijzigingen. Vergeet uw wijzigingen niet op te slaan.',
	'guidedtour-tour-gettingstarted-click-save-title' => 'U bent bijna klaar!',
	'guidedtour-tour-gettingstarted-click-save-description' => 'Klik "{{int:savearticle}}" zodat uw wijzigingen zichtbaar worden.',
	'guidedtour-tour-gettingstarted-end-title' => 'Op zoek naar meer om te doen?',
	'guidedtour-tour-gettingstarted-end-description' => "[[Special:GettingStarted|Aan de slag]] wordt ieder uur bijgewerkt met nieuwe pagina's.",
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

/** tarandíne (tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'guidedtour-okay-button' => 'Apposte',
);

/** Russian (русский)
 * @author DCamer
 */
$messages['ru'] = array(
	'guidedtour-end-tour' => 'Закончить тур',
	'guidedtour-tour-test-testing' => 'Тестирование',
	'guidedtour-tour-test-test-description' => 'Это тест описание. Вы можете видеть что <b>HTML</b> полужирный. Lorem ipsum dolor sit!', # Fuzzy
	'guidedtour-tour-test-callouts' => 'Тест выноски',
	'guidedtour-tour-test-mediawiki-parse' => 'Тест mediawiki parse',
	'guidedtour-tour-test-go-description-page' => 'Перейти на страницу описания',
	'guidedtour-tour-test-launch-tour' => 'Тестовый запуск тура',
);

/** Swedish (svenska)
 * @author Ainali
 */
$messages['sv'] = array(
	'guidedtour-okay-button' => 'Okej',
	'guidedtour-tour-test-testing' => 'Testar',
	'guidedtour-tour-test-test-description' => 'Detta är ett test av beskrivningen. Lorem ipsum dolor sit!',
	'guidedtour-tour-test-go-description-page' => 'Gå till beskrivningssida',
	'guidedtour-tour-gettingstarted-start-title' => 'Redo att hjälpa?',
	'guidedtour-tour-gettingstarted-click-edit-description' => 'Detta låter dig göra ändringar i vilken del av sidan som helst när du är redo.',
	'guidedtour-tour-gettingstarted-click-preview-title' => 'Förhandsgranska (valfritt)',
	'guidedtour-tour-gettingstarted-click-save-title' => 'Du är nästan klar!',
);

/** Ukrainian (українська)
 * @author Base
 */
$messages['uk'] = array(
	'guidedtour-desc' => 'Дозволяє сторінкам виводити вспливаюче навчання для допомоги новачкам',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'guidedtour-desc' => 'Hiển thị chương trình hướng dẫn sử dụng cho những người dùng mới',
	'guidedtour-help-url' => 'Help:Chương trình hướng dẫn sử dụng',
	'guidedtour-help-guider-url' => 'Help:Chương trình hướng dẫn sử dụng/giới thiệu',
	'guidedtour-custom.css' => '/* Mã CSS tùy biến dành cho phần mở rộng GuidedTour. */',
	'guidedtour-end-tour' => 'Kết thúc trình hướng dẫn',
	'guidedtour-okay-button' => 'OK',
	'guidedtour-tour-test-testing' => 'Đo thử',
	'guidedtour-tour-test-test-description' => 'Thử lời miêu tả đây. Lorem ipsum dolor sit!',
	'guidedtour-tour-test-callouts' => 'Thử ô gọi',
	'guidedtour-tour-test-portal-description' => 'Đây là trang {{int:portal}}.',
	'guidedtour-tour-test-mediawiki-parse' => 'Kiểm tra bộ phân tích MediaWiki',
	'guidedtour-tour-test-wikitext-description' => 'Một hộp trong chương trình hướng dẫn wiki có thể sử dụng onShow và parseDescription trong văn bản wiki. Bạn có thể chẳng hạn đặt một liên kết đến [[{{MediaWiki:Guidedtour-help-url}}|tài liệu chương trình hướng dẫn]] hoặc đến [https://github.com/tychay/mwgadget.GuidedTour tài liệu tại GitHub] trong hộp hướng dẫn.',
	'guidedtour-tour-test-description-page' => 'Kiểm tra trang miêu tả MediaWiki',
	'guidedtour-tour-test-go-description-page' => 'Mở trang miêu tả.',
	'guidedtour-tour-test-launch-tour' => 'Thử mở hướng dẫn',
	'guidedtour-tour-test-launch-tour-description' => 'Các hộp hướng dẫn có thể mở hướng dẫn khác. Hay nhỉ?',
	'guidedtour-tour-test-launch-using-tours' => 'Mở hướng dẫn chỉ cách sử dụng hướng dẫn',
	'guidedtour-tour-gettingstarted-start-title' => 'Có sẵn sàng giúp đỡ?',
	'guidedtour-tour-gettingstarted-start-description' => 'Trang này cần được cải tiến về văn phong, ngữ pháp, và chính tả để cho dễ đọc hiểu hơn. Chương trình này sẽ chỉ cho bạn cách sửa đổi trang.',
	'guidedtour-tour-gettingstarted-click-edit-title' => 'Nhấn chuột vào “{{int:vector-view-edit}}”',
	'guidedtour-tour-gettingstarted-click-edit-description' => 'Nút này cho phép bạn thay đổi bất kỳ phần nào của trang này.',
	'guidedtour-tour-gettingstarted-click-preview-title' => 'Xem thử (tùy chọn)',
	'guidedtour-tour-gettingstarted-click-preview-description' => 'Bấm “{{int:showpreview}}” để kiểm tra các thay đổi của bạn có phải hiển thị đúng hay không. Hãy nhớ lưu trang.',
	'guidedtour-tour-gettingstarted-click-save-title' => 'Gần xong!',
	'guidedtour-tour-gettingstarted-click-save-description' => 'Bấm “{{int:savearticle}}” là các thay đổi của bạn sẽ được áp dụng vào trang.',
	'guidedtour-tour-gettingstarted-end-title' => 'Muốn biết cái gì cần làm?',
	'guidedtour-tour-gettingstarted-end-description' => 'Trang [[Special:GettingStarted|Bắt đầu]] được cập nhật từng giờ với trang mới.',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Hydra
 * @author Yfdyh000
 * @author 乌拉跨氪
 */
$messages['zh-hans'] = array(
	'guidedtour-desc' => '允许页面提供一个弹出式菜单来帮助新用户',
	'guidedtour-help-url' => 'Help:有引导游览',
	'guidedtour-help-guider-url' => '帮助:有引导游览/导游',
	'guidedtour-end-tour' => '结束教程',
	'guidedtour-okay-button' => '好的',
	'guidedtour-tour-test-testing' => '测验',
	'guidedtour-tour-test-test-description' => '这是一条描述演示。Lorem ipsum dolor sit!',
	'guidedtour-tour-test-callouts' => '测试标注',
	'guidedtour-tour-test-portal-description' => '这是{{int:portal}}页面。',
	'guidedtour-tour-test-mediawiki-parse' => '测试 MediaWiki 解析器',
	'guidedtour-tour-test-description-page' => '测试 MediaWiki 描述页面',
	'guidedtour-tour-test-go-description-page' => '转到描述页面',
	'guidedtour-tour-test-launch-tour' => '测试开始游览',
	'guidedtour-tour-test-launch-tour-description' => '导向器可以启动其他导游。很酷对吧？',
	'guidedtour-tour-gettingstarted-start-title' => '准备好开始了吗？',
	'guidedtour-tour-gettingstarted-start-description' => '该页面需要基本的修编——修改其语法结构、语言风格、语言基调或错字——使其更易于阅读。本教程将告诉您该如何做。',
	'guidedtour-tour-gettingstarted-click-edit-title' => '点击“{{int:vector-view-edit}}”',
	'guidedtour-tour-gettingstarted-click-edit-description' => '当您准备好后，点击此处便可对该页的每一部分作出更改。',
	'guidedtour-tour-gettingstarted-click-preview-title' => '预览（可选）',
	'guidedtour-tour-gettingstarted-click-preview-description' => '点击“{{int:showpreview}}”，您将看到您在该页面作出哪些更改。请不要忘记保存。',
	'guidedtour-tour-gettingstarted-click-save-title' => '您马上就要完成了！',
	'guidedtour-tour-gettingstarted-click-save-description' => '点击“{{int:savearticle}}”，您将保存您所作出的更改。',
	'guidedtour-tour-gettingstarted-end-title' => '想要寻找更多的事情做？',
	'guidedtour-tour-gettingstarted-end-description' => '[[Special:GettingStarted|入门指南]]每小时会有新页面。',
);
