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
	'guidedtour-next-button' => 'Next',
	'guidedtour-okay-button' => 'Okay',

	// Messages for specific tours.  These should be namespaced as
	// guidedtour-tour-specifictourname-message-name

	// test
	'guidedtour-tour-test-testing' => 'Testing',
	'guidedtour-tour-test-test-description' => 'This is a test of the description. Lorem ipsum dolor sit!',
	'guidedtour-tour-test-callouts' => 'Test callouts',
	'guidedtour-tour-test-portal-description' => 'This is the {{int:portal}} page.',
	'guidedtour-tour-test-mediawiki-parse' => 'Test MediaWiki parse',
	// TODO: This is unused since it was removed from the main code for performance reasons.
	// It is being kept for now so it can be used if https://bugzilla.wikimedia.org/show_bug.cgi?id=25349 is fixed.
	'guidedtour-tour-test-wikitext-description' => 'A guider in your on-wiki tour can contain wikitext using onShow and parseDescription. Use it to create a wikilink to the [[{{MediaWiki:Guidedtour-help-url}}|Guided tours documentation]]. Or an external link [https://github.com/tychay/mwgadget.GuidedTour to GitHub], for instance.',
	'guidedtour-tour-test-description-page' => 'Test MediaWiki description pages',
	'guidedtour-tour-test-go-description-page' => 'Go to description page',
	'guidedtour-tour-test-launch-tour' => 'Test launch tour',
	'guidedtour-tour-test-launch-tour-description' => 'Guiders can launch other guided tours. Pretty cool, huh?',
	'guidedtour-tour-test-launch-using-tours' => 'Launch a tour on using tours',

	// gettingstarted
	'guidedtour-tour-gettingstarted-start-title' => 'Ready to help?',
	'guidedtour-tour-gettingstarted-start-description' => 'This page needs basic copyediting – improving the grammar, style, tone, or spelling – to make it clear and easy to read. This tour will show you the steps to take.',
	'guidedtour-tour-gettingstarted-click-edit-title' => 'Click "{{int:vector-view-edit}}"',
	'guidedtour-tour-gettingstarted-click-edit-description' => 'This will let you make changes to any part of the page, when you\'re ready.',
	'guidedtour-tour-gettingstarted-click-preview-title' => 'Preview (optional)',
	'guidedtour-tour-gettingstarted-click-preview-description' => 'Clicking "{{int:showpreview}}" allows you to check what the page will look like with your changes. Just don\'t forget to save.',
	'guidedtour-tour-gettingstarted-click-save-title' => 'You\'re almost finished!',
	'guidedtour-tour-gettingstarted-click-save-description' => 'Click "{{int:savearticle}}" and your changes will be visible.',
	'guidedtour-tour-gettingstarted-end-title' => 'Looking for more to do?',
	'guidedtour-tour-gettingstarted-end-description' => '[[Special:GettingStarted|Getting Started]] is updated every hour with new pages.',

	// firstedit (wiktext version)
	'guidedtour-tour-firstedit-edit-page-title' => 'Ready to edit?',

	// Both of these refer to the wikitext edit links.  However, if VisualEditor is
	// installed, we use a version that transcludes their tab/link text.
	// The same applies to the edit-section-description ones.
	'guidedtour-tour-firstedit-edit-page-description' => 'Click the "{{int:vector-view-edit}}" button to make your changes.',
	'guidedtour-tour-firstedit-edit-page-visualeditor-description' => 'Click the "{{int:visualeditor-ca-editsource}}" button to make your changes.',

	'guidedtour-tour-firstedit-edit-section-title' => 'Edit just a section',
	'guidedtour-tour-firstedit-edit-section-description' => 'There are "{{int:editsection}}" links for each major section in an article, so you can focus on just that part.',
	'guidedtour-tour-firstedit-edit-section-visualeditor-description' => 'There are "{{int:visualeditor-ca-editsource-section}}" links for each major section in an article, so you can focus on just that part.',
	'guidedtour-tour-firstedit-preview-title' => 'Preview your changes (optional)',
	'guidedtour-tour-firstedit-preview-description' => 'Clicking "{{int:showpreview}}" allows you to check what the page will look like with your changes. Just don\'t forget to save!',
	'guidedtour-tour-firstedit-save-title' => 'You\'re almost done!',
	'guidedtour-tour-firstedit-save-description' => 'When you\'re ready, clicking "{{int:savearticle}}" will make your changes visible for everyone.',

	'guidedtour-tour-firsteditve-edit-page-description' => 'Click the "{{int:vector-view-edit}} {{int:visualeditor-beta-appendix}}" button to make your changes.',
	'guidedtour-tour-firsteditve-edit-section-description' => 'There are "{{int:editsection}} {{int:visualeditor-beta-appendix}}" links for each major section in an article, so you can focus on just that part.',
	'guidedtour-tour-firsteditve-save-description' => 'When you\'re ready, clicking "{{int:visualeditor-toolbar-savedialog}}" will make your changes visible for everyone.',
);

/** Message documentation (Message documentation)
 * @author Mattflaschen
 * @author Shirayuki
 * @author Tgr
 */
$messages['qqq'] = array(
	'guidedtour-desc' => '{{desc|name=Guided Tour|url=http://www.mediawiki.org/wiki/Extension:GuidedTour}}',
	'guidedtour-help-url' => 'Main page for GuidedTour documentation',
	'guidedtour-help-guider-url' => 'Brief GuidedTour documentation page that a tour step can transclude.  Used in the test tour.',
	'guidedtour-custom.css' => '{{Optional}}
Custom CSS for the GuidedTour extension.  Empty by default.',
	'guidedtour-next-button' => 'Text for moving to next step of guided tour.
{{Identical|Next}}',
	'guidedtour-okay-button' => 'Main action button text.  Will dismiss single tour step (ending the tour if this is the last step) or do another tour-defined action.
{{Identical|OK}}',
	'guidedtour-tour-test-testing' => 'Title of first step in test tour',
	'guidedtour-tour-test-test-description' => 'Sample description to show how it is used.
{{doc-important|Do not translate the Latin "Lorem ipsum dolor sit!".}}',
	'guidedtour-tour-test-callouts' => 'Title of second step in test tour, introducing callouts',
	'guidedtour-tour-test-portal-description' => 'Description of second step in test tour.

It will be pointing to the page link given at {{msg-mw|Portal-url}}, in the toolbox.

Refers to {{msg-mw|Portal}}.',
	'guidedtour-tour-test-mediawiki-parse' => 'Description of third step in test tour',
	'guidedtour-tour-test-wikitext-description' => '{{doc-important|Do not translate "<code>onShow</code>" or "<code>parseDescription</code>", because they are JavaScript method names.}}
Title of third step in test tour.

Don\'t be concerned if [[{{MediaWiki:Guidedtour-help-url}}]] does not yet exist.

Refers to {{msg-mw|Guidedtour-help-url}}.',
	'guidedtour-tour-test-description-page' => 'Title of fourth step in test tour',
	'guidedtour-tour-test-go-description-page' => 'Text of the button pointing to [[{{MediaWiki:Guidedtour-help-url}}]]',
	'guidedtour-tour-test-launch-tour' => 'Title of fifth step in test tour',
	'guidedtour-tour-test-launch-tour-description' => 'Description of fifth step in test tour',
	'guidedtour-tour-test-launch-using-tours' => 'Button text for launching a tour on making tours',
	'guidedtour-tour-gettingstarted-start-title' => 'Title of intro step of Getting Started tour.

See also:
* {{msg-mw|Notification-new-user}}',
	'guidedtour-tour-gettingstarted-start-description' => 'Description of intro step of Getting Started tour',
	'guidedtour-tour-gettingstarted-click-edit-title' => 'Title of step showing user where to click {{msg-mw|vector-view-edit}}',
	'guidedtour-tour-gettingstarted-click-edit-description' => 'Description of step showing user where to click {{msg-mw|vector-view-edit}}',
	'guidedtour-tour-gettingstarted-click-preview-title' => 'Title of step showing user where to click {{msg-mw|showpreview}}',
	'guidedtour-tour-gettingstarted-click-preview-description' => 'Description of step showing user where to click {{msg-mw|showpreview}}',
	'guidedtour-tour-gettingstarted-click-save-title' => 'Title of step showing user where to click {{msg-mw|savearticle}}',
	'guidedtour-tour-gettingstarted-click-save-description' => 'Description of step showing user where to click {{msg-mw|savearticle}}',
	'guidedtour-tour-gettingstarted-end-title' => 'Title of final step of Getting Started tour',
	'guidedtour-tour-gettingstarted-end-description' => 'Description of final step of Getting Started tour',
	'guidedtour-tour-firstedit-edit-page-title' => 'Title of the step of the firstedit tour pointing to the main edit button',
	'guidedtour-tour-firstedit-edit-page-description' => 'Description of the step of the firstedit tour pointing to the main edit button, if VisualEditor is not installed.

See also:
* {{msg-mw|Guidedtour-tour-firstedit-edit-page-visualeditor-description}}
* {{msg-mw|Vector-view-edit}}',
	'guidedtour-tour-firstedit-edit-page-visualeditor-description' => 'Description of the step of the firstedit tour pointing to the main edit button, if VisualEditor is installed.

See also:
* {{msg-mw|Guidedtour-tour-firstedit-edit-page-description}}
* {{msg-mw|Visualeditor-ca-editsource}}',
	'guidedtour-tour-firstedit-edit-section-title' => 'Title of the step of the firstedit tour pointing to the section edit button',
	'guidedtour-tour-firstedit-edit-section-description' => 'Description of the step of the firstedit tour pointing to the section edit button, if VisualEditor is not installed

See also:
* {{msg-mw|editsection}}',
	'guidedtour-tour-firstedit-edit-section-visualeditor-description' => 'Description of the step of the firstedit tour pointing to the section edit button, if VisualEditor is installed

See also:
* {{msg-mw|visualeditor-ca-editsource-section}}',
	'guidedtour-tour-firstedit-preview-title' => 'Title of step explaining preview.

The body for this title is {{msg-mw|Guidedtour-tour-firstedit-preview-description}}.',
	'guidedtour-tour-firstedit-preview-description' => 'Description of step explaining preview

See also:
* {{msg-mw|showpreview}}',
	'guidedtour-tour-firstedit-save-title' => 'Title of step explaining saving an edit',
	'guidedtour-tour-firstedit-save-description' => 'Description of step explaining how to save

See also:
* {{msg-mw|savearticle}}',
	'guidedtour-tour-firsteditve-edit-page-description' => 'Description of the step of the firsteditve tour pointing to the VisualEditor edit button.

Refers to:
* {{msg-mw|Vector-view-edit}}
* {{msg-mw|Visualeditor-beta-appendix}}',
	'guidedtour-tour-firsteditve-edit-section-description' => 'Description of the step of the firsteditve tour pointing to the VE section edit button

Refers to:
* {{msg-mw|Editsection}}
* {{msg-mw|Visualeditor-beta-appendix}}',
	'guidedtour-tour-firsteditve-save-description' => 'Description of step of the firsteditve tour explaining how to save in VisualEditor.

Refers to {{msg-mw|Visualeditor-toolbar-savedialog}}.',
);

/** Arabic (العربية)
 * @author Ciphers
 */
$messages['ar'] = array(
	'guidedtour-desc' => 'السماح للصفحات بعرض رسائل جولات تعريفية لمساعدة المستخدمين الجدد',
	'guidedtour-help-url' => 'مساعدة:جولات تعريفية', # Fuzzy
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

/** Asturian (asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'guidedtour-desc' => "Permite que les páxines ufran una visita guiada p'ayudar a los usuarios nuevos",
	'guidedtour-help-url' => 'Help:Visites guiaes',
	'guidedtour-help-guider-url' => 'Help:Visites guiaes/guía',
	'guidedtour-next-button' => 'Siguiente',
	'guidedtour-okay-button' => 'Aceutar',
	'guidedtour-tour-test-testing' => 'Probar',
	'guidedtour-tour-test-test-description' => 'Esto ye una prueba de la descripción. ¡Lorem ipsum dolor sit!',
	'guidedtour-tour-test-callouts' => 'Probar les llamaes de salida',
	'guidedtour-tour-test-portal-description' => 'Esta ye la páxina del {{int:portal}}.',
	'guidedtour-tour-test-mediawiki-parse' => "Probar l'analís de MediaWiki",
	'guidedtour-tour-test-wikitext-description' => 'Un guía de la visita de la wiki pue contener testu wiki usando onShow y parseDescription. Uselo pa crear un enllaz a la [[{{MediaWiki:Guidedtour-help-url}}|documentación de les visites guiaes]]. O un enllaz esternu [https://github.com/tychay/mwgadget.GuidedTour a GitHub], por exemplu.',
	'guidedtour-tour-test-description-page' => 'Probar les páxines de descripción de MediaWiki',
	'guidedtour-tour-test-go-description-page' => 'Dir a la páxina de descripción',
	'guidedtour-tour-test-launch-tour' => 'Probar el llanzamientu de visites',
	'guidedtour-tour-test-launch-tour-description' => 'Los guíes puen llanzar otres visites guiaes. Prestoso, ¿acuéi?',
	'guidedtour-tour-test-launch-using-tours' => "Llanzar una visita sobro l'usu de les visites",
	'guidedtour-tour-gettingstarted-start-title' => "¿Preparáu p'ayudar?",
	'guidedtour-tour-gettingstarted-start-description' => "Esta páxina necesita ediciones básiques (ameyorar la gramática, l'estilu, el tonu, o la ortografía) para facela más clara y fácil de lleer. Esta guía amosará-y los pasos a siguir.",
	'guidedtour-tour-gettingstarted-click-edit-title' => "Calque '{{int:vector-view-edit}}'",
	'guidedtour-tour-gettingstarted-click-edit-description' => 'Esto permitirá-y facer cambios en cualquier parte de la páxina, cuando tea preparáu.',
	'guidedtour-tour-gettingstarted-click-preview-title' => 'Vista previa (opcional)',
	'guidedtour-tour-gettingstarted-click-preview-description' => 'Si calca "{{int:showpreview}}" podrá comprobar como se verá la páxina colos cambios. Pero nun escaeza guardala.',
	'guidedtour-tour-gettingstarted-click-save-title' => '¡Yá casi acabó!',
	'guidedtour-tour-gettingstarted-click-save-description' => 'Calque "{{int:savearticle}}" y los cambios sedrán visibles.',
	'guidedtour-tour-gettingstarted-end-title' => '¿Busca más que facer?',
	'guidedtour-tour-gettingstarted-end-description' => 'La páxina de [[Special:GettingStarted|primeros pasos]] anuevase cada hora con páxines nueves.',
	'guidedtour-tour-firstedit-edit-page-title' => '¿Preparáu pa editar?',
	'guidedtour-tour-firstedit-edit-page-description' => "Calque nel botón '{{int:vector-view-edit}}' pa facer los cambios.",
	'guidedtour-tour-firstedit-edit-page-visualeditor-description' => "Calque nel botón '{{int:visualeditor-ca-editsource}}' pa facer los cambios.",
	'guidedtour-tour-firstedit-edit-section-title' => 'Editar sólo una seición',
	'guidedtour-tour-firstedit-edit-section-description' => "Hai enllaces '{{int:editsection}}' pa cada seición principal d'un artículu, de mou que pue centrase sólo nesa parte.",
	'guidedtour-tour-firstedit-edit-section-visualeditor-description' => "Hai enllaces '{{int:visualeditor-ca-editsource-section}}' pa cada seición principal d'un artículu, de mou que pue centrase sólo nesa parte.",
	'guidedtour-tour-firstedit-preview-title' => 'Vista previa de los cambios (opcional)',
	'guidedtour-tour-firstedit-preview-description' => "Si calca '{{int:showpreview}}' podrá comprobar como se verá la páxina colos cambios. ¡Pero nun escaeza guardala!",
	'guidedtour-tour-firstedit-save-title' => '¡Yá casi ta fecho!',
	'guidedtour-tour-firstedit-save-description' => "Cuando tea preparáu, en calcando '{{int:savearticle}}', los cambios sedrán visibles pa toos.",
	'guidedtour-tour-firsteditve-edit-page-description' => 'Calque nel botón "{{int:vector-view-edit}} {{int:visualeditor-beta-appendix}}" pa facer los sos cambios.',
	'guidedtour-tour-firsteditve-edit-section-description' => 'Hai enllaces "{{int:editsection}} {{int:visualeditor-beta-appendix}}" pa cada seición principal d\'un artículu, de mou que pue centrase sólo nesa parte.',
	'guidedtour-tour-firsteditve-save-description' => 'Cuando tea preparáu, en calcando "{{int:visualeditor-toolbar-savedialog}}" los cambios tarán visibles pa toos.',
);

/** Belarusian (беларуская)
 * @author Wizardist
 */
$messages['be'] = array(
	'guidedtour-desc' => 'Дазваляе паказваць на старонках усплыўныя падказкі для дапамогі новым удзельнікам',
	'guidedtour-help-url' => 'Help:Экскурсіі па сайце',
	'guidedtour-help-guider-url' => 'Help:Экскурсіі па сайце/даведка',
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
	'guidedtour-next-button' => 'Далей',
	'guidedtour-okay-button' => 'Далей',
	'guidedtour-tour-test-testing' => 'Тэставаньне',
	'guidedtour-tour-test-test-description' => 'Гэта тэст апісаньня. Lorem ipsum dolor sit!',
	'guidedtour-tour-test-callouts' => 'Тэст вынятак',
	'guidedtour-tour-test-portal-description' => 'Гэта старонка {{int:portal}}.',
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

/** Bengali (বাংলা)
 * @author Aftab1995
 * @author Bellayet
 */
$messages['bn'] = array(
	'guidedtour-desc' => 'নতুন ব্যবহারকারীদের সহযোগিতার জন্য পাতায় একটি ভাসমান নির্দেশনামূলক ভ্রমণের সুযোগ করে দেয়।',
	'guidedtour-help-url' => 'Help:নির্দেশনামূলক ভ্রমণ',
	'guidedtour-help-guider-url' => 'Help:নির্দেশনামূলক ভ্রমণ/নির্দেশক',
	'guidedtour-next-button' => 'পরবর্তী',
	'guidedtour-okay-button' => 'ঠিক আছে',
	'guidedtour-tour-test-testing' => 'পরীক্ষণ',
	'guidedtour-tour-test-description-page' => 'পরীক্ষামূলক মিডিয়াউইকি বিবরণ পাতা',
	'guidedtour-tour-test-go-description-page' => 'বিবরণ পাতায় যাও',
	'guidedtour-tour-test-launch-tour' => 'পরীক্ষামূলক ভ্রমণ আরম্ভ করুন',
	'guidedtour-tour-gettingstarted-start-title' => 'সহায়িকার জন্য প্রস্তুত?',
	'guidedtour-tour-gettingstarted-click-edit-title' => "'{{int:vector-view-edit}}' ক্লিক করুন",
	'guidedtour-tour-gettingstarted-click-preview-title' => 'প্রাকদর্শন (ঐচ্ছিক)',
	'guidedtour-tour-gettingstarted-click-save-title' => 'আপনি প্রায় সম্পন্ন করেছেন!',
	'guidedtour-tour-gettingstarted-click-save-description' => "'{{int:savearticle}}' ক্লিক করুন এবং আপনার পরিবর্তনগুলো দৃশ্যমান হবে।",
	'guidedtour-tour-gettingstarted-end-title' => 'আরও কি করা যায় তা ভাবছেন?',
);

/** Breton (brezhoneg)
 * @author Fohanno
 * @author Y-M D
 */
$messages['br'] = array(
	'guidedtour-okay-button' => 'A-du',
	'guidedtour-tour-test-testing' => "Oc'h amprouiñ",
);

/** Catalan (català)
 * @author QuimGil
 * @author Vriullop
 */
$messages['ca'] = array(
	'guidedtour-desc' => 'Permet incorporar una visita guiada a les pàgines per a ajudar nous usuaris.',
	'guidedtour-help-url' => 'Help:Visites guiades',
	'guidedtour-help-guider-url' => 'Help:Visites guiades/guia',
	'guidedtour-next-button' => 'Següent',
	'guidedtour-okay-button' => "D'acord",
	'guidedtour-tour-test-testing' => 'Proves',
	'guidedtour-tour-test-test-description' => 'Això és una prova de la descripció. Lorem ipsum dolor sit!',
	'guidedtour-tour-test-callouts' => 'Prova les crides',
	'guidedtour-tour-test-portal-description' => 'Aquesta és la pàgina {{int:portal}}.',
	'guidedtour-tour-test-mediawiki-parse' => 'Prova el processament de MediaWiki',
	'guidedtour-tour-test-description-page' => 'Prova les pàgines de descripció de MediaWiki',
	'guidedtour-tour-test-go-description-page' => 'Vés a la pàgina de descripció',
	'guidedtour-tour-test-launch-tour' => "Prova l'inici de la visita",
	'guidedtour-tour-test-launch-tour-description' => 'Les guies poden iniciar altres visites guiades. Molt bo, eh?',
	'guidedtour-tour-test-launch-using-tours' => 'Inicia una visita guiada sobre visites guiades',
	'guidedtour-tour-gettingstarted-start-title' => 'Esteu disposats a ajudar?',
	'guidedtour-tour-gettingstarted-start-description' => "Aquesta pàgina necessita correccions bàsiques (millorant la gramàtica, l'estil, el to o l'ortografia) per a fer-la clara i fàcil de llegir. Aquesta visita guiada li mostrarà els passos a seguir.",
	'guidedtour-tour-gettingstarted-click-edit-title' => "Feu clic a '{{int:vector-view-edit}}'",
	'guidedtour-tour-gettingstarted-click-edit-description' => 'Això li permetrà fer canvis en qualsevol part de la pàgina, quan estigui a punt.',
	'guidedtour-tour-gettingstarted-click-preview-title' => 'Mostra previsualització (opcional)',
	'guidedtour-tour-gettingstarted-click-preview-description' => "Si feu clic a '{{int:showpreview}}' podreu comprovar com es es veurà la pàgina amb els seus canvis. No us oblideu de desar.",
	'guidedtour-tour-gettingstarted-click-save-title' => 'Gairebé heu acabat!',
	'guidedtour-tour-gettingstarted-click-save-description' => "Feu clic a '{{int:savearticle}}' i els seus canvis seran visibles.",
	'guidedtour-tour-gettingstarted-end-title' => 'Busqueu més tasques a fer?',
	'guidedtour-tour-gettingstarted-end-description' => "[[Special:GettingStarted|Introducció]] s'actualitza cada hora amb noves pàgines.",
	'guidedtour-tour-firstedit-edit-page-title' => 'Disposat a editar?',
	'guidedtour-tour-firstedit-edit-page-description' => "Cliqueu la pestanya '{{int:vector-view-edit}}' per fer els vostres canvis.",
	'guidedtour-tour-firstedit-edit-page-visualeditor-description' => "Cliqueu la pestanya '{{int:visualeditor-ca-editsource}}' per fer els vostres canvis.",
	'guidedtour-tour-firstedit-edit-section-title' => "Modificació d'una secció",
	'guidedtour-tour-firstedit-edit-section-description' => "Hi ha enllaços '{{int:editsection}}' per a cada secció en un article que permet centrar-se només en una part.",
	'guidedtour-tour-firstedit-edit-section-visualeditor-description' => "Hi ha enllaços '{{int:visualeditor-ca-editsource-section}}' per a cada secció en un article que permet centrar-se només en una part.",
	'guidedtour-tour-firstedit-preview-title' => 'Previsualització opcional dels canvis',
	'guidedtour-tour-firstedit-preview-description' => "Si cliqueu a '{{int:showpreview}}' podreu comprovar com quedarà la pàgina amb els vostres canvis. En acabat, no us oblideu de desar!",
	'guidedtour-tour-firstedit-save-title' => 'Gairebé ja està!',
	'guidedtour-tour-firstedit-save-description' => "Quan ho tingueu a punt, cliqueu a '{{int:savearticle}}' i els vostres canvis ja seran visibles per a tothom.",
	'guidedtour-tour-firsteditve-edit-page-description' => 'Feu clic a "{{int:vector-view-edit}} {{int:visualeditor-beta-appendix}}" per a fer els vostres canvis.',
	'guidedtour-tour-firsteditve-edit-section-description' => 'Disposeu d\'enllaços "{{int:editsection}} {{int:visualeditor-beta-appendix}}" a cada secció principal, per a concentrar-vos només en la part que vulgueu modificar.',
	'guidedtour-tour-firsteditve-save-description' => 'Quan estigueu a punt, fent clic a "{{int:visualeditor-toolbar-savedialog}}" fareu els vostres canvis visibles per a tothom.',
);

/** Czech (česky)
 * @author Mormegil
 */
$messages['cs'] = array(
	'guidedtour-desc' => 'Umožňuje stránkám poskytovat vyskakovacího průvodce pro pomoc novým uživatelům',
	'guidedtour-tour-gettingstarted-end-description' => 'Na [[Special:GettingStarted|Jak začít]] se každou hodinu objevují nové stránky.',
);

/** German (Deutsch)
 * @author Kghbln
 * @author Metalhead64
 */
$messages['de'] = array(
	'guidedtour-desc' => 'Ermöglicht Pop-up-gestützte Rundgänge zur Unterstützung neuer Benutzer',
	'guidedtour-help-url' => 'Help:Geführte Touren',
	'guidedtour-help-guider-url' => 'Help:Geführte Touren/Guider',
	'guidedtour-next-button' => 'Nächster',
	'guidedtour-okay-button' => 'Okay',
	'guidedtour-tour-test-testing' => 'Testen',
	'guidedtour-tour-test-test-description' => 'Dies ist ein Test der Beschreibung. Lorem ipsum dolor sit!',
	'guidedtour-tour-test-callouts' => 'Legenden testen',
	'guidedtour-tour-test-portal-description' => 'Dies ist die Seite „{{int:portal}}“.',
	'guidedtour-tour-test-mediawiki-parse' => 'MediaWiki-Parser testen',
	'guidedtour-tour-test-wikitext-description' => 'Ein Guider in deiner Wikitour kann Wikitext durch Verwendung von onShow und parseDescription beinhalten. Benutze es, um beispielsweise einen Wikilink zur [[{{MediaWiki:Guidedtour-help-url}}|Dokumentation]] oder einen externen Link [https://github.com/tychay/mwgadget.GuidedTour zu GitHub] zu erstellen.',
	'guidedtour-tour-test-description-page' => 'MediaWiki-Beschreibungsseiten testen',
	'guidedtour-tour-test-go-description-page' => 'Gehe zur Beschreibungsseite',
	'guidedtour-tour-test-launch-tour' => 'Tourstart testen',
	'guidedtour-tour-test-launch-tour-description' => 'Guider können andere geführte Touren starten. Ziemlich cool, nicht wahr?',
	'guidedtour-tour-test-launch-using-tours' => 'Eine Tour durch Verwendung von Touren starten',
	'guidedtour-tour-gettingstarted-start-title' => 'Bereit zum Helfen?',
	'guidedtour-tour-gettingstarted-start-description' => 'Diese Seite muss grundredigiert werden. Verbessere die Grammatik, Gestaltung, Rechtschreibung und den Ton, um sie klar und leicht lesbar zu machen. Diese Tour zeigt dir die nötigen Schritte.',
	'guidedtour-tour-gettingstarted-click-edit-title' => 'Klicke auf „{{int:vector-view-edit}}“',
	'guidedtour-tour-gettingstarted-click-edit-description' => 'Dies ermöglicht dir Änderungen an beliebigen Teilen der Seite, falls du bereit bist.',
	'guidedtour-tour-gettingstarted-click-preview-title' => 'Vorschau (optional)',
	'guidedtour-tour-gettingstarted-click-preview-description' => 'Klicke auf „{{int:showpreview}}“, um zu sehen, wie die Seite mit deinen Änderungen aussieht. Vergiss nicht zu speichern.',
	'guidedtour-tour-gettingstarted-click-save-title' => 'Du bist fast fertig!',
	'guidedtour-tour-gettingstarted-click-save-description' => 'Klicke auf „{{int:savearticle}}“ und deine Änderungen werden sichtbar.',
	'guidedtour-tour-gettingstarted-end-title' => 'Willst du mehr?',
	'guidedtour-tour-gettingstarted-end-description' => 'Die Spezialseite „[[Special:GettingStarted|Anfangen]]“ wird stündlich mit neuen Seiten aktualisiert.',
	'guidedtour-tour-firstedit-edit-page-title' => 'Bereit zum Bearbeiten?',
	'guidedtour-tour-firstedit-edit-page-description' => 'Klicke auf „{{int:vector-view-edit}}“, um deine Änderungen durchzuführen.',
	'guidedtour-tour-firstedit-edit-page-visualeditor-description' => 'Klicke auf „{{int:visualeditor-ca-editsource}}“, um deine Änderungen durchzuführen.',
	'guidedtour-tour-firstedit-edit-section-title' => 'Nur einen Abschnitt bearbeiten',
	'guidedtour-tour-firstedit-edit-section-description' => 'Es gibt „{{int:editsection}}“-Links für jeden Artikelabschnitt, so dass du dich nur auf diesen Teil fokussieren kannst.',
	'guidedtour-tour-firstedit-edit-section-visualeditor-description' => 'Es gibt „{{int:visualeditor-ca-editsource-section}}“-Links für jeden Artikelabschnitt, so dass du dich nur auf diesen Teil fokussieren kannst.',
	'guidedtour-tour-firstedit-preview-title' => 'Vorschau deiner Änderungen (optional)',
	'guidedtour-tour-firstedit-preview-description' => 'Mit Klick auf „{{int:showpreview}}“ kannst du überprüfen, wie die Seite mit deinen Änderungen aussehen wird. Vergiss nicht zu speichern!',
	'guidedtour-tour-firstedit-save-title' => 'Du bist fast fertig!',
	'guidedtour-tour-firstedit-save-description' => 'Wenn du fertig bist, macht das Klicken auf „{{int:savearticle}}“ deine Änderungen für jeden sichtbar.',
	'guidedtour-tour-firsteditve-edit-page-description' => 'Klicke auf „{{int:vector-view-edit}} {{int:visualeditor-beta-appendix}}“, um deine Änderungen durchzuführen.',
	'guidedtour-tour-firsteditve-edit-section-description' => 'Für jeden Artikelabschnitt gibt es die Links „{{int:editsection}} {{int:visualeditor-beta-appendix}}“, so dass du dich nur auf diesen Teil konzentrieren kannst.',
	'guidedtour-tour-firsteditve-save-description' => 'Wenn du fertig bist, klicke auf „{{int:visualeditor-toolbar-savedialog}}“, um deine Änderungen für jeden sichtbar zu machen.',
);

/** Spanish (español)
 * @author Fitoschido
 * @author QuimGil
 */
$messages['es'] = array(
	'guidedtour-desc' => 'Permite a las páginas ofrecer una visita guiada para ayudar a nuevos usuarios',
	'guidedtour-help-url' => 'Help:Visitas guiadas',
	'guidedtour-help-guider-url' => 'Help:Visitas guiadas/guía',
	'guidedtour-next-button' => 'Siguiente',
	'guidedtour-okay-button' => 'Aceptar',
	'guidedtour-tour-test-testing' => 'Pruebas',
	'guidedtour-tour-test-test-description' => 'Esta es una prueba de la descripción. Lorem ipsum dolor sit!',
	'guidedtour-tour-test-callouts' => 'Prueba de llamadas',
	'guidedtour-tour-test-portal-description' => 'Esta es la página de {{int:portal}}.',
	'guidedtour-tour-test-mediawiki-parse' => 'Prueba del procesamiento de MediaWiki',
	'guidedtour-tour-test-description-page' => 'Probar las páginas de descripción de MediaWiki',
	'guidedtour-tour-test-go-description-page' => 'Ir a la página de descripción',
	'guidedtour-tour-test-launch-tour' => 'Prueba de inicio de la visita guiada',
	'guidedtour-tour-test-launch-tour-description' => 'Las guías pueden iniciar otras visitas guiada. Muy bueno, ¿eh?',
	'guidedtour-tour-test-launch-using-tours' => 'Iniciar una visita guiada sobre visitas guiadas',
	'guidedtour-tour-gettingstarted-start-title' => '¿Listo para ayudar?',
	'guidedtour-tour-gettingstarted-start-description' => 'Esta página necesita correcciones básicas (mejorar la gramática, el estilo, el tono o la ortografía) para que sea clara y fácil de leer. Esta visita guiada le mostrará los pasos a seguir.',
	'guidedtour-tour-gettingstarted-click-edit-title' => 'Pulsa «{{int:vector-view-edit}}»',
	'guidedtour-tour-gettingstarted-click-edit-description' => 'Esto le permitirá realizar cambios en cualquier parte de la página, cuando esté listo.',
	'guidedtour-tour-gettingstarted-click-preview-title' => 'Previsualización (opcional)',
	'guidedtour-tour-gettingstarted-click-preview-description' => "Clicando en '{{int:showpreview}}' puede comprobar cómo se verá la página con sus cambios. No se olvide de guardar.",
	'guidedtour-tour-gettingstarted-click-save-title' => '¡Ya casi ha terminado!',
	'guidedtour-tour-gettingstarted-click-save-description' => "Haga clic en '{{int:savearticle}}' y sus cambios serán visibles.",
	'guidedtour-tour-gettingstarted-end-title' => '¿Busca más tareas que hacer?',
	'guidedtour-tour-gettingstarted-end-description' => '[[Special:GettingStarted|Introducción]] se actualiza cada hora con nuevas páginas.',
	'guidedtour-tour-firstedit-edit-page-title' => '¿Te animas a editar?',
	'guidedtour-tour-firstedit-edit-section-title' => 'Editar solo una sección',
	'guidedtour-tour-firstedit-preview-title' => 'Previsualiza tus cambios (opcional)',
	'guidedtour-tour-firstedit-save-title' => '¡Ya casi has terminado!',
	'guidedtour-tour-firstedit-save-description' => 'Cuando termines, pulsa en «{{int:savearticle}}» para que todos puedan ver tus cambios.',
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

/** Finnish (suomi)
 * @author Nike
 * @author Samoasambia
 * @author Silvonen
 */
$messages['fi'] = array(
	'guidedtour-tour-test-go-description-page' => 'Siirry kuvaussivulle',
	'guidedtour-tour-gettingstarted-click-save-description' => 'Napsauta »{{int:savearticle}}» ja muutoksesi tulevat näkyviin.',
	'guidedtour-tour-firstedit-edit-page-title' => 'Valmis muokkaamaan?',
	'guidedtour-tour-firstedit-preview-title' => 'Esikatsella muutoksiasi (valinnainen)',
	'guidedtour-tour-firstedit-save-title' => 'Olet melkein valmis!',
);

/** French (français)
 * @author Gomoko
 * @author Jean-Frédéric
 * @author Ltrlg
 * @author Seb35
 * @author Trizek
 * @author Urhixidur
 */
$messages['fr'] = array(
	'guidedtour-desc' => 'Autoriser les pages à afficher une visite guidée par pop-up pour aider les nouveaux utilisateurs',
	'guidedtour-help-url' => 'Help:Visites guidées',
	'guidedtour-help-guider-url' => 'Help:Visites guidées/guide',
	'guidedtour-next-button' => 'Suivant',
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
	'guidedtour-tour-gettingstarted-start-title' => 'Prêt à aider ?',
	'guidedtour-tour-gettingstarted-start-description' => "Cette page a besoin d’une modification sur la forme — améliorer la grammaire, le style, le ton ou l'orthographe — pour la rendre claire et facile à lire. Cette visite guidée vous montrera les étapes à entreprendre.",
	'guidedtour-tour-gettingstarted-click-edit-title' => 'Cliquez sur « {{int:vector-view-edit}} »',
	'guidedtour-tour-gettingstarted-click-edit-description' => 'Cela vous permettra de faire des modifications à n’importe quelle partie de la page, quand vous serez prêt.',
	'guidedtour-tour-gettingstarted-click-preview-title' => 'Aperçu (facultatif)',
	'guidedtour-tour-gettingstarted-click-preview-description' => "Cliquer sur « {{int:showpreview}} » vous permet de vérifier à quoi ressemblera la page avec vos modifications. Ensuite, n'oubliez pas de publier pour enregistrer.",
	'guidedtour-tour-gettingstarted-click-save-title' => 'Vous avez presque fini !',
	'guidedtour-tour-gettingstarted-click-save-description' => 'Cliquez sur «”{{int:savearticle}} » et vos modifications seront visibles.',
	'guidedtour-tour-gettingstarted-end-title' => 'Vous cherchez autre chose à faire ?',
	'guidedtour-tour-gettingstarted-end-description' => '[[Special:GettingStarted|Pour démarrer]] est mis à jour chaque heure avec de nouvelles pages.',
	'guidedtour-tour-firstedit-edit-page-title' => 'Prêt à modifier ?',
	'guidedtour-tour-firstedit-edit-page-description' => 'Cliquez sur le bouton « {{int:vector-view-edit}} » pour faire vos modifications.',
	'guidedtour-tour-firstedit-edit-page-visualeditor-description' => 'Cliquez sur le bouton « {{int:visualeditor-ca-editsource}} » pour faire vos modifications.',
	'guidedtour-tour-firstedit-edit-section-title' => 'Modifier seulement une section',
	'guidedtour-tour-firstedit-edit-section-description' => 'Il y a des liens « {{int:editsection}} » pour chaque section majeure d’un article, afin que vous puissiez vous concentrer sur cette partie.',
	'guidedtour-tour-firstedit-edit-section-visualeditor-description' => 'Il y a des liens « {{int:visualeditor-ca-editsource-section}} » pour chaque section majeure d’un article, afin que vous puissiez vous concentrer sur cette partie.',
	'guidedtour-tour-firstedit-preview-title' => 'Prévisualisez vos modifications (facultatif)',
	'guidedtour-tour-firstedit-preview-description' => 'Cliquer sur « {{int:showpreview}} » vous permet de vérifier à quoi ressemblera la page avec vos modifications. Ensuite, n’oubliez pas de publier pour enregistrer.',
	'guidedtour-tour-firstedit-save-title' => 'Vous avez presque terminé !',
	'guidedtour-tour-firstedit-save-description' => 'Lorsque vous êtes prêt, cliquez sur « {{int:savearticle}} » pour rendre vos modifications visibles à tous.',
	'guidedtour-tour-firsteditve-edit-page-description' => 'Cliquez sur le bouton « {{int:vector-view-edit}} {{int:visualeditor-beta-appendix}} » pour effectuer vos modifications.',
	'guidedtour-tour-firsteditve-edit-section-description' => 'Il y a des liens « {{int:editsection}} {{int:visualeditor-beta-appendix}} » pour chaque section principale dans un article, de sorte que vous puissiez vous focaliser uniquement sur cette partie.',
	'guidedtour-tour-firsteditve-save-description' => 'Quand vous serez prêt, cliquer sur « {{int:visualeditor-toolbar-savedialog}} » rendra vos modifications visibles pour tout le monde.',
);

/** Galician (galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'guidedtour-desc' => 'Permite que as páxinas proporcionen unha visita guiada para axudar aos usuarios novos',
	'guidedtour-help-url' => 'Help:Visitas guiadas',
	'guidedtour-help-guider-url' => 'Help:Visitas guiadas/guía',
	'guidedtour-custom.css' => '/* CSS personalizado para a extensión de visitas guiadas. */',
	'guidedtour-next-button' => 'Seguinte',
	'guidedtour-okay-button' => 'Aceptar',
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
	'guidedtour-tour-firstedit-edit-page-title' => 'Está listo para editar?',
	'guidedtour-tour-firstedit-edit-page-description' => 'Prema no botón "{{int:vector-view-edit}}" para facer as súas modificacións.',
	'guidedtour-tour-firstedit-edit-page-visualeditor-description' => 'Prema no botón "{{int:visualeditor-ca-editsource}}" para facer as súas modificacións.',
	'guidedtour-tour-firstedit-edit-section-title' => 'Editar só unha sección',
	'guidedtour-tour-firstedit-edit-section-description' => 'Hai unha ligazón "{{int:editsection}}" en cada sección, para que poida centrarse só nesa parte do artigo.',
	'guidedtour-tour-firstedit-edit-section-visualeditor-description' => 'Hai unha ligazón "{{int:visualeditor-ca-editsource-section}}" en cada sección, para que poida centrarse só nesa parte do artigo.',
	'guidedtour-tour-firstedit-preview-title' => 'Vista previa dos cambios (opcional)',
	'guidedtour-tour-firstedit-preview-description' => 'Premer en "{{int:showpreview}}" serve para comprobar como se verá a páxina coas modificacións. Non esqueza gardar despois!',
	'guidedtour-tour-firstedit-save-title' => 'Xa case rematou!',
	'guidedtour-tour-firstedit-save-description' => 'Cando remate, prema en "{{int:savearticle}}" para que os cambios sexan visibles para todos.',
	'guidedtour-tour-firsteditve-edit-page-description' => 'Prema no botón "{{int:vector-view-edit}} {{int:visualeditor-beta-appendix}}" para realizar as súas modificacións.',
	'guidedtour-tour-firsteditve-edit-section-description' => 'Hai unha ligazón "{{int:editsection}} {{int:visualeditor-beta-appendix}}" en cada sección, para que poida centrarse só nesa parte do artigo.',
	'guidedtour-tour-firsteditve-save-description' => 'Cando remate, prema en "{{int:visualeditor-toolbar-savedialog}}" para que os cambios sexan visibles para todos.',
);

/** Gujarati (ગુજરાતી)
 * @author Ashok modhvadia
 */
$messages['gu'] = array(
	'guidedtour-next-button' => 'આગળ',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author ExampleTomer
 * @author NLIGuy
 * @author דוד
 */
$messages['he'] = array(
	'guidedtour-desc' => 'מאפשר לספק בדפים חלונות קופצים שעוזרים למשתמשים חדשים',
	'guidedtour-help-url' => 'Help:סיורים מודרכים',
	'guidedtour-help-guider-url' => 'עזרה: סיורים מודרכים/צעדים בסיור',
	'guidedtour-next-button' => 'הבא',
	'guidedtour-okay-button' => 'סבבה',
	'guidedtour-tour-test-testing' => 'בדיקות',
	'guidedtour-tour-test-test-description' => 'זוהי בדיקה של תיאור. צנח לו זלזל!',
	'guidedtour-tour-test-callouts' => 'בדיקת חלונות הסבר',
	'guidedtour-tour-test-portal-description' => 'זהו דף ה{{int:portal}}.',
	'guidedtour-tour-test-mediawiki-parse' => 'בדיקות פענוח מדיה-ויקי',
	'guidedtour-tour-test-description-page' => 'בדקו את דפי התיאור של מדיה-ויקי',
	'guidedtour-tour-test-go-description-page' => 'עברו לדף התיאור',
	'guidedtour-tour-test-launch-tour' => 'בדקו את סיור הניסיון',
	'guidedtour-tour-test-launch-tour-description' => 'שלבים בסיור יכולים להפעיל סיורים מודרכים אחרים. די מגניב, הא?',
	'guidedtour-tour-test-launch-using-tours' => 'התחילו סיור היכרות על אודות השימוש בסיורים',
	'guidedtour-tour-gettingstarted-start-title' => 'מוכנים לעזור?',
	'guidedtour-tour-gettingstarted-start-description' => 'דף זה דורש עריכת טקסט וליטוש - שיפור התחביר, הסגנון, הטון או האיות - על מנת להפכו לברור וקל לקריאה. סיור זה יראה לכם את הצעדים הנדרשים לכך.',
	'guidedtour-tour-gettingstarted-click-edit-title' => 'לחצו על {{int:vector-view-edit}}',
	'guidedtour-tour-gettingstarted-click-edit-description' => 'דבר זה יאפשר לכם לערוך שינויים לכל חלק של הדף, כאשר אתם מוכנים לכך.',
	'guidedtour-tour-gettingstarted-click-preview-title' => 'תצוגה מקדימה (אופציונלי)',
	'guidedtour-tour-gettingstarted-click-preview-description' => 'לחיצה על {{int:showpreview}} מאפשרת לך לבדוק כיצד ייראה העמוד עם השינויים שלך. רק לא לשכוח לשמור!',
	'guidedtour-tour-gettingstarted-click-save-title' => 'כמעט סיימתם!',
	'guidedtour-tour-gettingstarted-click-save-description' => 'לחצו על {{int:savearticle}} והשינוי שלכם יהיה גלוי.',
	'guidedtour-tour-gettingstarted-end-title' => 'מחפשים דברים נוספים לעשות?',
	'guidedtour-tour-gettingstarted-end-description' => '[[Special:GettingStarted|Getting Started]] מתעדכן מדי שעה עם דפים חדשים.',
);

/** Upper Sorbian (hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'guidedtour-help-url' => 'Help:Wjedźene tury',
	'guidedtour-help-guider-url' => 'Help:Wjedźene tury/wjednik',
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

/** Hungarian (magyar)
 * @author Tgr
 */
$messages['hu'] = array(
	'guidedtour-desc' => 'Lehetővé teszi szövegbuborékokból álló bemutatók megjelenítését az új felhasználóknak.',
	'guidedtour-help-url' => 'Help:Útikalauz',
	'guidedtour-help-guider-url' => 'Segítség:Útikalauz/kalauz',
	'guidedtour-next-button' => 'Tovább',
	'guidedtour-okay-button' => 'Rendben',
	'guidedtour-tour-test-testing' => 'Teszt',
	'guidedtour-tour-test-test-description' => 'Ez egy teszt leírás. Lorem ipsum dolor sit!',
	'guidedtour-tour-test-callouts' => 'Szövegbuborék teszt',
	'guidedtour-tour-test-portal-description' => 'Ez a {{int:portal}}.',
	'guidedtour-tour-test-mediawiki-parse' => 'MediaWiki parser teszt',
	'guidedtour-tour-test-description-page' => 'MediaWiki leírás teszt',
	'guidedtour-tour-test-go-description-page' => 'Ugrás a leírásra',
	'guidedtour-tour-test-launch-tour' => 'Útikalauz-indítás teszt',
	'guidedtour-tour-test-launch-tour-description' => 'Az útikalauzok újabb útikalauzokat indíthatnak. Jó, mi?',
	'guidedtour-tour-test-launch-using-tours' => 'Útikalauz-kalauz indítása',
	'guidedtour-tour-gettingstarted-start-title' => 'Segítenél?',
	'guidedtour-tour-gettingstarted-start-description' => 'Ennek az oldalnak javítani kell a  helyesírásán vagy a megfogalmazásán, hogy könnyen olvasható legyen. Végigvezetünk a szükséges lépéseken.',
	'guidedtour-tour-gettingstarted-click-edit-title' => 'Kattints a „{{int:vector-view-edit}}” feliratra',
	'guidedtour-tour-gettingstarted-click-edit-description' => 'Ez lehetővé teszi a szócikk bármely részének megváltoztatását, ha készen állsz.',
	'guidedtour-tour-gettingstarted-click-preview-title' => 'Előnézet (opcionális)',
	'guidedtour-tour-gettingstarted-click-preview-description' => 'Az „{{int:showpreview}}” gombra kattintva megnézheted, hogyan néz majd ki az oldal a módosításaid után. Csak ne felejtsd el elmenteni a végén.',
	'guidedtour-tour-gettingstarted-click-save-title' => 'Mindjárt végzünk!',
	'guidedtour-tour-gettingstarted-click-save-description' => 'Kattints a „{{int:savearticle}}” gombra, és a változtatásaid megjelennek.',
	'guidedtour-tour-gettingstarted-end-title' => 'Szeretnéd folytatni?',
	'guidedtour-tour-gettingstarted-end-description' => 'Az [[Special:GettingStarted|Első lépések]] óránként új oldalakkal frissül.',
	'guidedtour-tour-firstedit-edit-page-title' => 'Készen állsz szerkeszteni?',
	'guidedtour-tour-firstedit-edit-page-description' => 'Kattints a „{{int:vector-view-edit}}” gombra a szöveg módosításához.',
	'guidedtour-tour-firstedit-edit-page-visualeditor-description' => 'Kattints a „{{int:visualeditor-ca-editsource}}” gombra a szöveg módosításához.',
	'guidedtour-tour-firstedit-edit-section-title' => 'Egyetlen szakasz szerkesztése',
	'guidedtour-tour-firstedit-edit-section-description' => 'A cikk minden nagyobb szakaszához tartozik egy „{{int:editsection}}” link, ha csak azzal a résszel akarsz foglalkozni.',
	'guidedtour-tour-firstedit-edit-section-visualeditor-description' => 'A cikk minden nagyobb szakaszához tartozik egy „{{int:visualeditor-ca-editsource-section}}” link, ha csak azzal a résszel akarsz foglalkozni.',
	'guidedtour-tour-firstedit-preview-title' => 'Nézd meg az eredményt (opcionális)',
	'guidedtour-tour-firstedit-preview-description' => 'Az „{{int:showpreview}}” gombra kattintva ellenőrizheted, hogyan fog kinézni az oldal a módosításaiddal együtt. Ne felejtsd el a végén elmenteni!',
	'guidedtour-tour-firstedit-save-title' => 'Majdnem kész vagy!',
	'guidedtour-tour-firstedit-save-description' => 'Ha végeztél, a „{{int:savearticle}}” gombra kattintva a változtatásaid bekerülnek a cikkbe.',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'guidedtour-desc' => 'Permitte que un guida appare in paginas pro assister nove usatores',
	'guidedtour-help-url' => 'Help:Visitas guidate',
	'guidedtour-help-guider-url' => 'Help:Visitas guidate/guida',
	'guidedtour-next-button' => 'Sequente',
	'guidedtour-okay-button' => 'OK',
	'guidedtour-tour-test-testing' => 'Test',
	'guidedtour-tour-test-test-description' => 'Isto es un test del description. Lorem ipsum dolor sit!',
	'guidedtour-tour-test-portal-description' => 'Iste es le pagina del {{int:portal}}.',
	'guidedtour-tour-test-mediawiki-parse' => 'Test del analysator syntactic de MediaWiki',
	'guidedtour-tour-test-description-page' => 'Test del paginas de description de MediaWiki',
	'guidedtour-tour-test-go-description-page' => 'Vader al pagina de description',
	'guidedtour-tour-test-launch-tour' => 'Test del lanceamento del visita guidate',
	'guidedtour-tour-test-launch-tour-description' => 'Le guidas pote lancear altere visitas guidate. Multo bon, nonne?',
	'guidedtour-tour-test-launch-using-tours' => 'Lancear un visita guidate sur le uso de visitas guidate',
	'guidedtour-tour-gettingstarted-start-title' => 'Preste a adjutar?',
	'guidedtour-tour-gettingstarted-start-description' => 'Iste pagina ha besonio de redaction basic (meliorar le grammatica, stilo, tono o orthographia) pro render lo clar e facile a leger. Iste visita guidate demonstra le passos a prender.',
	'guidedtour-tour-gettingstarted-click-edit-title' => 'Clicca sur "{{int:vector-view-edit}}"',
	'guidedtour-tour-gettingstarted-click-edit-description' => 'Isto te permitte modificar omne parte del pagina, quando tu es preste.',
	'guidedtour-tour-gettingstarted-click-preview-title' => 'Previsualisation (optional)',
	'guidedtour-tour-gettingstarted-click-preview-description' => 'Cliccar sur "{{int:showpreview}}" permitte verificar le aspecto del pagina con tu modificationes. Solmente non oblida de salveguardar lo.',
	'guidedtour-tour-gettingstarted-click-save-title' => 'Tu ha quasi finite!',
	'guidedtour-tour-gettingstarted-click-save-description' => 'Clicca sur "{{int:savearticle}}" e tu modificationes essera visibile.',
	'guidedtour-tour-gettingstarted-end-title' => 'Cerca altere cosas a facer?',
	'guidedtour-tour-gettingstarted-end-description' => '[[Special:GettingStarted|Prime passos]] es actualisate cata hora con nove paginas.',
	'guidedtour-tour-firstedit-edit-page-title' => 'Preste a modificar?',
	'guidedtour-tour-firstedit-edit-page-description' => 'Clicca sur le button "{{int:vector-view-edit}}" pro facer tu cambiamentos.',
	'guidedtour-tour-firstedit-edit-page-visualeditor-description' => 'Clicca sur le button "{{int:visualeditor-ca-editsource}}" pro facer tu cambiamentos.',
	'guidedtour-tour-firstedit-edit-section-title' => 'Modificar solmente un section',
	'guidedtour-tour-firstedit-edit-section-description' => 'Il ha ligamines "{{int:editsection}}" pro cata major section in un articulo, de sorta que tu pote concentrar te a iste parte.',
	'guidedtour-tour-firstedit-edit-section-visualeditor-description' => 'Il ha ligamines "{{int:visualeditor-ca-editsource-section}}" pro cata major section in un articulo, de sorta que tu pote concentrar te a iste parte.',
	'guidedtour-tour-firstedit-preview-title' => 'Previsualisar tu modificationes (optional)',
	'guidedtour-tour-firstedit-preview-description' => 'Cliccar sur "{{int:showpreview}}" permitte verificar le aspecto del pagina con tu modificationes. Solmente non oblida de salveguardar lo!',
	'guidedtour-tour-firstedit-save-title' => 'Tu ha quasi finite!',
	'guidedtour-tour-firstedit-save-description' => 'Quando tu es preste, un clic sur "{{int:savearticle}}" rendera tu cambiamentos visibile a tote le mundo.',
);

/** Italian (italiano)
 * @author Beta16
 * @author Gianfranco
 */
$messages['it'] = array(
	'guidedtour-desc' => 'Consente di gestire pagine per fornire un tour guidato tramite popup per assistere i nuovi utenti',
	'guidedtour-help-url' => 'Help:Visite guidate',
	'guidedtour-help-guider-url' => 'Aiuto:Visite guidate/guida',
	'guidedtour-next-button' => 'Successivo',
	'guidedtour-okay-button' => 'Ok',
	'guidedtour-tour-test-testing' => 'Prova',
	'guidedtour-tour-test-test-description' => 'Questa è una prova della descrizione. Lorem ipsum dolor sit!',
	'guidedtour-tour-test-callouts' => 'Prova didascalie',
	'guidedtour-tour-test-portal-description' => 'Questa è la pagina {{int:portal}}.',
	'guidedtour-tour-test-mediawiki-parse' => 'Prova MediaWiki parse',
	'guidedtour-tour-test-description-page' => 'Prova le pagine di descrizione di MediaWiki',
	'guidedtour-tour-test-go-description-page' => 'Vai alla pagina di descrizione',
	'guidedtour-tour-test-launch-tour' => 'Prova la visita di partenza',
	'guidedtour-tour-test-launch-tour-description' => 'Le guide possono lanciare altre visite guidate. Non male, eh?',
	'guidedtour-tour-test-launch-using-tours' => "Lancia un tour sull'utilizzo delle visite",
	'guidedtour-tour-gettingstarted-start-title' => 'Pronti ad aiutare?',
	'guidedtour-tour-gettingstarted-start-description' => "Questa pagina ha bisogno di un editing di base – migliorare la grammatica, lo stile, il tono o l'ortografia – per renderla chiara e di facile lettura. Questo tour vi mostrerà le azioni da compiere.",
	'guidedtour-tour-gettingstarted-click-edit-title' => "Fai clic su '{{int:vector-view-edit}}'",
	'guidedtour-tour-gettingstarted-click-edit-description' => 'Questo ti consente di apportare modifiche in qualsiasi parte della pagina, quando sei pronto.',
	'guidedtour-tour-gettingstarted-click-preview-title' => 'Anteprima (opzionale)',
	'guidedtour-tour-gettingstarted-click-preview-description' => "Facendo clic su '{{int:showpreview}}' ti permette di verificare quello che sarà l'aspetto della pagina con le tue modifiche. Basta non dimenticare di salvare.",
	'guidedtour-tour-gettingstarted-click-save-title' => 'Hai quasi finito!',
	'guidedtour-tour-gettingstarted-click-save-description' => "Fai click su '{{int:savearticle}}' e le modifiche saranno visibili.",
	'guidedtour-tour-gettingstarted-end-title' => 'Cerchi altro da fare?',
	'guidedtour-tour-gettingstarted-end-description' => 'La [[Special:GettingStarted|guida introduttiva]] è aggiornata ogni ora con nuove pagine.',
	'guidedtour-tour-firstedit-edit-page-title' => 'Pronto a modificare?',
	'guidedtour-tour-firstedit-edit-page-description' => 'Clicca "{{int:vector-view-edit}}" per fare le tue modifiche.',
	'guidedtour-tour-firstedit-edit-page-visualeditor-description' => 'Clicca "{{int:visualeditor-ca-editsource}}" per fare le tue modifiche.',
	'guidedtour-tour-firstedit-edit-section-title' => 'Modifica solo una sezione',
	'guidedtour-tour-firstedit-edit-section-description' => 'Esistono collegamenti "{{int:editsection}}" per ogni sezione principale di un articolo, così puoi concentrarti solo quella parte.',
	'guidedtour-tour-firstedit-edit-section-visualeditor-description' => 'Esistono collegamenti "{{int:visualeditor-ca-editsource-section}}" per ogni sezione principale di un articolo, così puoi concentrarti solo quella parte.',
	'guidedtour-tour-firstedit-preview-title' => "Vedi un'anteprima delle tue modifiche (facoltativo)",
	'guidedtour-tour-firstedit-preview-description' => 'Cliccando su "{{int:showpreview}}" ti permette di verificare come sarà l\'aspetto della pagina con le modifiche apportate. Non ti dimenticare di salvare!',
	'guidedtour-tour-firstedit-save-title' => 'Hai quasi finito!',
	'guidedtour-tour-firstedit-save-description' => 'Quando sei pronto, clicca su "{{int:savearticle}}" e renderai le tue modifiche visibili a tutti.',
	'guidedtour-tour-firsteditve-edit-page-description' => 'Clicca "{{int:vector-view-edit}} {{int:visualeditor-beta-appendix}}" per fare le tue modifiche.',
	'guidedtour-tour-firsteditve-edit-section-description' => 'Esistono collegamenti "{{int:editsection}} {{int:visualeditor-beta-appendix}}" per ogni sezione principale di un articolo, così puoi concentrarti solo quella parte.',
	'guidedtour-tour-firsteditve-save-description' => 'Quando sei pronto, clicca su "{{int:visualeditor-toolbar-savedialog}}" e renderai le tue modifiche visibili a tutti.',
);

/** Japanese (日本語)
 * @author Shirayuki
 */
$messages['ja'] = array(
	'guidedtour-desc' => '新しい利用者を支援するポップアップのガイド付きツアーをページで提供できるようにする',
	'guidedtour-help-url' => 'Help:ガイド付きツアー',
	'guidedtour-help-guider-url' => 'Help:ガイド付きツアー/guider',
	'guidedtour-custom.css' => '/* ガイドツアー拡張機能用のカスタムCSS */',
	'guidedtour-next-button' => '次へ',
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
	'guidedtour-tour-gettingstarted-click-preview-description' => '「{{int:showpreview}}」をクリックすると、編集結果の見た目を確認できます。保存するのを忘れないようにしてください。',
	'guidedtour-tour-gettingstarted-click-save-title' => 'もう少しで終わります!',
	'guidedtour-tour-gettingstarted-click-save-description' => '「{{int:savearticle}}」をクリックすると、変更内容が最新版として保存されます。',
	'guidedtour-tour-gettingstarted-end-title' => '他にできることをお探しですか?',
	'guidedtour-tour-firstedit-edit-page-description' => '「{{int:vector-view-edit}}」ボタンをクリックして編集します。',
	'guidedtour-tour-firstedit-edit-page-visualeditor-description' => '「{{int:visualeditor-ca-editsource}}」ボタンをクリックして編集します。',
	'guidedtour-tour-firstedit-preview-title' => '変更内容のプレビュー (省略可能)',
	'guidedtour-tour-firstedit-save-title' => 'もう少しで完了します!',
	'guidedtour-tour-firsteditve-edit-page-description' => '変更するには、「{{int:vector-view-edit}} {{int:visualeditor-beta-appendix}}」をクリックしてください。',
	'guidedtour-tour-firsteditve-edit-section-description' => '主要な節それぞれに「{{int:editsection}} {{int:visualeditor-beta-appendix}}」リンクがあるため、その節のみに着目できます。',
);

/** Georgian (ქართული)
 * @author David1010
 */
$messages['ka'] = array(
	'guidedtour-tour-test-testing' => 'ტესტირება',
);

/** Korean (한국어)
 * @author 아라
 */
$messages['ko'] = array(
	'guidedtour-desc' => '새 사용자를 돕기 위해 팝업 가이드 투어를 문서에 제공할 수 있습니다',
	'guidedtour-help-url' => 'Help:가이드 투어',
	'guidedtour-help-guider-url' => 'Help:가이드 투어/안내자',
	'guidedtour-custom.css' => '/* 이 CSS 설정은 가이드 투어 확장 기능에 적용됩니다. */',
	'guidedtour-next-button' => '다음',
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
	'guidedtour-tour-gettingstarted-click-preview-description' => '"{{int:showpreview}}"를 클릭하면 문서가 어떻게 바뀌었는지 확인할 수 있습니다. 저장하는 것을 잊지 마세요.',
	'guidedtour-tour-gettingstarted-click-save-title' => '거의 끝났습니다!',
	'guidedtour-tour-gettingstarted-click-save-description' => "'{{int:savearticle}}'을 클릭하여 바뀜을 볼 수 있습니다.",
	'guidedtour-tour-gettingstarted-end-title' => '다른 할 것을 찾고 있습니까?',
	'guidedtour-tour-gettingstarted-end-description' => '[[Special:GettingStarted|시작하기]]는 새 문서로 매 시간마다 업데이트합니다.',
	'guidedtour-tour-firstedit-edit-page-title' => '편집할 준비가 되었습니까?',
	'guidedtour-tour-firstedit-edit-page-description' => '내용을 바꾸려면 "{{int:vector-view-edit}}" 버튼을 클릭하세요.',
	'guidedtour-tour-firstedit-edit-page-visualeditor-description' => '내용을 바꾸려면 "{{int:visualeditor-ca-editsource}}" 버튼을 클릭하세요.',
	'guidedtour-tour-firstedit-edit-section-title' => '문단 편집',
	'guidedtour-tour-firstedit-edit-section-description' => '각 주요 문단 부분에 집중할 수 있도록, 문서에 각 주요 문단에 대한 "{{int:editsection}}" 링크가 있습니다.',
	'guidedtour-tour-firstedit-edit-section-visualeditor-description' => '각 주요 문단 부분에 집중할 수 있도록, 문서에 각 주요 문단에 대한 "{{int:visualeditor-ca-editsource-section}}" 링크가 있습니다.',
	'guidedtour-tour-firstedit-preview-title' => '바뀐 내용 미리 보기 (선택 사항)',
	'guidedtour-tour-firstedit-preview-description' => '"{{int:showpreview}}"를 클릭하면 문서가 어떻게 바뀌었는지 확인할 수 있습니다. 저장하는 것을 잊지 마세요!',
	'guidedtour-tour-firstedit-save-title' => '거의 끝나갑니다!',
	'guidedtour-tour-firstedit-save-description' => '준비가 되면, "{{int:savearticle}}"을 클릭하면 바꾼 내용을 모두에게 보여줍니다.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'guidedtour-desc' => "Erméiglecht Pop-up-ënnerstëtzt Toure fir nei Benotzer z'assistéieren",
	'guidedtour-help-url' => 'Help:Guidéiert Touren',
	'guidedtour-help-guider-url' => 'Help:Guided tours/Guide',
	'guidedtour-next-button' => 'Nächst',
	'guidedtour-okay-button' => 'OK',
	'guidedtour-tour-test-testing' => 'Testen',
	'guidedtour-tour-test-test-description' => 'Dëst ass en Test vun der Beschreiwung. Lorem ipsum dolor sit!',
	'guidedtour-tour-test-portal-description' => "Dëst ass d'{{int:portal}}-Säit",
	'guidedtour-tour-test-mediawiki-parse' => 'MediaWiki-Parser testen',
	'guidedtour-tour-test-description-page' => 'MediaWiki-Beschreiwungssäiten testen',
	'guidedtour-tour-test-go-description-page' => "Op d'Beschreiwungssäit goen",
	'guidedtour-tour-test-launch-tour' => 'Ufank vum Tour testen',
	'guidedtour-tour-test-launch-using-tours' => "En Tour ufänken duerch d'Benotze vun Touren",
	'guidedtour-tour-gettingstarted-start-title' => 'Wëllt Dir eng Hand upaken?',
	'guidedtour-tour-gettingstarted-click-edit-title' => "Klickt op '{{int:vector-view-edit}}'",
	'guidedtour-tour-gettingstarted-click-edit-description' => 'Dëst léist Iech Ännerungen op all Deel vun der Säit maachen esoubal wéi Dir prett sidd.',
	'guidedtour-tour-gettingstarted-click-preview-title' => 'Weisen ouni ze späicheren (fakuktativ)',
	'guidedtour-tour-gettingstarted-click-preview-description' => 'Klickt op "{{int:showpreview}}", fir ze gesinn, wéi d\'Säit mat dengen Ännerungen ausgesäit. Vergiesst net ze späicheren.',
	'guidedtour-tour-gettingstarted-click-save-title' => 'Dir sidd bal fäerdeg!',
	'guidedtour-tour-gettingstarted-click-save-description' => "Klickt op '{{int:savearticle}}' an Är Ännerunge sinn ze gesinn.",
	'guidedtour-tour-gettingstarted-end-title' => 'Wëllt Dir méi maachen?',
	'guidedtour-tour-gettingstarted-end-description' => '[[Special:GettingStarted|Fir unzefänke]] gëtt all Stonn mat neie Säiten aktualiséiert.',
	'guidedtour-tour-firstedit-edit-page-title' => 'Sidd Dir prëtt fir ze änneren?',
	'guidedtour-tour-firstedit-edit-page-description' => "Klickt op de Knäppchen '{{int:vector-view-edit}}' fir Är Ännerungen ze maachen.",
	'guidedtour-tour-firstedit-edit-page-visualeditor-description' => "Klickt op de Knäppchen '{{int:visualeditor-ca-editsource}}' fir Är Ännerungen ze maachen.",
	'guidedtour-tour-firstedit-edit-section-title' => 'Ännert just een Abschnitt',
	'guidedtour-tour-firstedit-edit-section-description' => 'Et gëtt "{{int:editsection}}"-Linke fir all gréisseren Abschnitt an engem Artikel, sou kënnt Dir Iech just op een Deel konzentréieren.',
	'guidedtour-tour-firstedit-edit-section-visualeditor-description' => 'Et gëtt "{{int:visualeditor-ca-editsource-section}}"-Linke fir all gréisseren Abschnitt an engem Artikel, sou kënnt Dir Iech just op een Deel konzentréieren.',
	'guidedtour-tour-firstedit-preview-title' => 'Kuckt Är Ännerungen ouni ze späicheren (fakultativ)',
	'guidedtour-tour-firstedit-preview-description' => 'Klicken op "{{int:showpreview}}", erlaabt Iech ze gesinn, wéi d\'Säit mat Ären Ännerungen ausgesäit. Vergiesst net ze späicheren.',
	'guidedtour-tour-firstedit-save-title' => 'Dir sidd bal fäerdeg!',
	'guidedtour-tour-firstedit-save-description' => "Wann Dir fäerdeg sidd, klickt op {{int:savearticle}}' fir Är Ännerunge jidderengem ze weisen.",
	'guidedtour-tour-firsteditve-edit-page-description' => 'Klickt op de "{{int:vector-view-edit}} {{int:visualeditor-beta-appendix}}" Knäppche fir e maachen.',
	'guidedtour-tour-firsteditve-edit-section-description' => 'Et gëtt "{{int:editsection}} {{int:visualeditor-beta-appendix}}"-Linke fir all gréisseren Abschnitt an engem Artikel, sou kënnt Dir Iech just op een Deel konzentréieren.',
	'guidedtour-tour-firsteditve-save-description' => 'Wann Dir fäerdeg sidd, klickt op "{{int:visualeditor-toolbar-savedialog}}" fir Är Ännerunge fir jidderee visibel ze maachen.',
);

/** Lithuanian (lietuvių)
 * @author Mantak111
 */
$messages['lt'] = array(
	'guidedtour-next-button' => 'Kitas',
	'guidedtour-okay-button' => 'Gerai',
);

/** Latvian (latviešu)
 * @author Papuass
 */
$messages['lv'] = array(
	'guidedtour-next-button' => 'Tālāk',
	'guidedtour-okay-button' => 'Labi',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'guidedtour-desc' => 'Овозможува страниците да даваат отскочни прозорци со водени надгледни упатства за новите корисници',
	'guidedtour-help-url' => 'Help:Водени тури',
	'guidedtour-help-guider-url' => 'Help:Водени тури/водич',
	'guidedtour-custom.css' => '/* Прилагоден CSS за додатокот GuidedTour. */',
	'guidedtour-next-button' => 'Следно',
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
	'guidedtour-tour-firstedit-edit-page-title' => 'Спремни сте да уредувате?',
	'guidedtour-tour-firstedit-edit-page-description' => 'Стиснете на копчето „{{int:vector-view-edit}}“ за да ги направите саканите измени.',
	'guidedtour-tour-firstedit-edit-page-visualeditor-description' => 'Стиснете на копчето „{{int:visualeditor-ca-editsource}}“ за да ги направите саканите измени.',
	'guidedtour-tour-firstedit-edit-section-title' => 'Уредете го само овој дел',
	'guidedtour-tour-firstedit-edit-section-description' => 'Постојат врски „{{int:editsection}}“ во секој дел (поднаслов) од статијата, за да можете да го уредите само него.',
	'guidedtour-tour-firstedit-edit-section-visualeditor-description' => 'Постојат врски „{{int:visualeditor-ca-editsource-section}}“ во секој дел (поднаслов) од статијата, за да можете да го уредите само него.',
	'guidedtour-tour-firstedit-preview-title' => 'Прегледајте ги измените (по желба)',
	'guidedtour-tour-firstedit-preview-description' => 'Стискајќи на „{{int:showpreview}}“ можете да видите како ќе изгледа изменетата страница. Само не заборавајте да ја зачувате!',
	'guidedtour-tour-firstedit-save-title' => 'Речиси сте готови!',
	'guidedtour-tour-firstedit-save-description' => 'Кога сте готови, стиснете на „{{int:savearticle}}“ и измените ќе бидат видливи за секого.',
	'guidedtour-tour-firsteditve-edit-page-description' => 'Стиснете на копчето „{{int:vector-view-edit}} {{int:visualeditor-beta-appendix}}“ за да ги направите промените.',
	'guidedtour-tour-firsteditve-edit-section-description' => 'Секој поважен дел (поднаслов) од статијата има врски „{{int:editsection}} {{int:visualeditor-beta-appendix}}“ за да можете да му се посветите само на тој дел.',
	'guidedtour-tour-firsteditve-save-description' => 'Кога ќе сте готови, стиснете на „{{int:visualeditor-toolbar-savedialog}}“ и така промените ќе станат видливи за секого.',
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
	'guidedtour-next-button' => 'Berikutnya',
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
	'guidedtour-tour-firstedit-edit-page-title' => 'Sedia untuk menyunting?',
	'guidedtour-tour-firstedit-edit-page-description' => 'Klik butang "{{int:vector-view-edit}}" untuk menyiarkan suntingan anda.',
	'guidedtour-tour-firstedit-edit-page-visualeditor-description' => 'Klik butang "{{int:visualeditor-ca-editsource}}" untuk menyiarkan suntingan anda.',
	'guidedtour-tour-firstedit-edit-section-title' => 'Sunting satu bahagian sahaja',
	'guidedtour-tour-firstedit-edit-section-description' => 'Terdapat pautan "{{int:editsection}}" untuk setiap bahagian utama pada sesebuah rencana supaya anda boleh hanya bertumpu pada bahagian berkenaan.',
	'guidedtour-tour-firstedit-edit-section-visualeditor-description' => 'Terdapat pautan "{{int:visualeditor-ca-editsource-section}}" untuk setiap bahagian utama pada sesebuah rencana supaya anda boleh hanya bertumpu pada bahagian berkenaan.',
	'guidedtour-tour-firstedit-preview-title' => 'Pratayangkan suntingan anda (tidak wajib)',
	'guidedtour-tour-firstedit-preview-description' => 'Anda boleh menyemak rupa halaman selepas suntingan dengan mengklik "{{int:showpreview}}". Tapi jangan lupa untuk menyimpan!',
	'guidedtour-tour-firstedit-save-title' => 'Hampir siap!',
	'guidedtour-tour-firstedit-save-description' => 'Apabila anda sedia, klik "{{int:savearticle}}" dan perlihatkan suntingan anda kepada semua pembaca.',
	'guidedtour-tour-firsteditve-edit-page-description' => 'Klik butang "{{int:vector-view-edit}} {{int:visualeditor-beta-appendix}}" untuk menyiarkan suntingan.',
	'guidedtour-tour-firsteditve-edit-section-description' => 'Terdapat pautan "{{int:editsection}}{{int:visualeditor-beta-appendix}}" untuk setiap bahagian utama pada sesebuah rencana supaya anda boleh hanya bertumpu pada bahagian berkenaan.',
	'guidedtour-tour-firsteditve-save-description' => 'Apabila anda sedia, klik "{{int:visualeditor-toolbar-savedialog}}" dan perlihatkan suntingan anda kepada semua pembaca.',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'guidedtour-desc' => 'Maakt het mogelijk om een rondleiding weer te geven voor nieuwe gebruikers',
	'guidedtour-help-url' => 'Help:Rondleidingen',
	'guidedtour-help-guider-url' => 'Help:Rondleidingen/gids',
	'guidedtour-next-button' => 'Volgende',
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
	'guidedtour-help-url' => 'Help:Vìsite guidà',
	'guidedtour-tour-test-testing' => 'Prové',
	'guidedtour-tour-test-test-description' => "Costa a l'é na preuva dla descrission. Lorem ipsum dolor sit!",
	'guidedtour-tour-test-callouts' => 'Fumèt ëd test',
	'guidedtour-tour-test-portal-description' => "Costa a l'é la pàgina {{int:portal}}.",
	'guidedtour-tour-test-mediawiki-parse' => "Prové l'arzultà MediaWiki",
	'guidedtour-tour-test-wikitext-description' => "N'element ëd la guida dla vìsita a peul conten-e dël wikitest ch'a deuvra onShow e parseDescription. Ch'a lo deuvra për creé na liura wiki a la [[{{MediaWiki:Guidedtour-help-url}}|Documentassion dle vìsite guidà]]. O na liura esterna [https://github.com/tychay/mwgadget.GuidedTour a Github], për esempi.",
	'guidedtour-tour-test-description-page' => 'Prové le pàgine ëd descrission ëd mediawiki',
	'guidedtour-tour-test-go-description-page' => 'Andé a la pàgina ëd descrission',
	'guidedtour-tour-test-launch-tour' => 'Prové la vìsita inissial',
	'guidedtour-tour-test-launch-tour-description' => "Le guide a peulo creé d'àutre vìsite guidà. Ròba da pocio, neh?",
	'guidedtour-tour-test-launch-using-tours' => 'Ancaminé na vìsita su coma dovré le vìsite',
);

/** Portuguese (português)
 * @author Alchimista
 * @author Raylton P. Sousa
 */
$messages['pt'] = array(
	'guidedtour-desc' => 'Permite que páginas proporcionem uma visita guiada por pop-ups, para ajudar os novos utilizadores.',
	'guidedtour-help-url' => 'Help:Visitas guiadas',
	'guidedtour-help-guider-url' => 'Help:Visitas guiadas/guia',
	'guidedtour-next-button' => 'Próximo',
	'guidedtour-okay-button' => 'OK',
	'guidedtour-tour-test-testing' => 'Testando',
	'guidedtour-tour-test-test-description' => 'Este é um teste da descrição. Lorem ipsum sit de dolor!',
	'guidedtour-tour-test-callouts' => 'Testes ao balão do guia',
	'guidedtour-tour-test-portal-description' => 'Esta é a página de {{int:portal}}.',
	'guidedtour-tour-test-mediawiki-parse' => 'Testar a análise sintáctica do Mediawiki',
	'guidedtour-tour-test-wikitext-description' => 'Um guia na sua visita guiada pela wiki pode conter wikitexto usando onShow e parseDescription. Use-os para criar um wikilink para o [[{{MediaWiki:Guidedtour-help-url}}|Documentação das visitas guiadas]]. Ou um link externo [https://github.com/tychay/mwgadget.GuidedTour para o GitHub], por exemplo.',
	'guidedtour-tour-test-description-page' => 'Testar páginas de descrição do MediaWiki',
	'guidedtour-tour-test-go-description-page' => 'Ir para a página de descrição',
	'guidedtour-tour-test-launch-tour' => 'Teste do lançamento do guia',
	'guidedtour-tour-test-launch-tour-description' => 'Os guias podem lançar outras visitas guiadas, muito interessante, não?',
	'guidedtour-tour-test-launch-using-tours' => 'Lançar um guia sobre como usar visitas guiadas',
	'guidedtour-tour-gettingstarted-start-title' => 'Pronto para ajudar?',
	'guidedtour-tour-gettingstarted-start-description' => 'Esta página precisa de edição básica – melhorar a gramática, estilo, tom ou ortografia – para tornar o texto claro e fácil de ler. Esta guia irá mostrar-lhe os passos a tomar.',
	'guidedtour-tour-gettingstarted-click-edit-title' => "Clique '{{int:vector-view-edit}}'",
	'guidedtour-tour-gettingstarted-click-edit-description' => 'Isso permitirá que possa fazer alterações em qualquer parte da página, quando estiver pronto.',
	'guidedtour-tour-gettingstarted-click-preview-title' => 'Pré-visualizar (opcional)',
	'guidedtour-tour-gettingstarted-click-preview-description' => "Clicando em '{{int:showpreview}}' permite pré-visualizar  a página com as suas alterações. Só não se esqueça de salvar.",
	'guidedtour-tour-gettingstarted-click-save-title' => 'Está quase a terminar!',
	'guidedtour-tour-gettingstarted-click-save-description' => "Clique em '{{int:savearticle}}' e as suas alterações serão visíveis.",
	'guidedtour-tour-gettingstarted-end-title' => 'Procura algo mais para fazer?',
	'guidedtour-tour-gettingstarted-end-description' => 'A página [[Special:GettingStarted|Getting Started]] é atualizado a cada hora com novas páginas.',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Raylton P. Sousa
 */
$messages['pt-br'] = array(
	'guidedtour-desc' => 'Permite que páginas proporcionem uma visita guiada por pop-ups, para ajudar os novos utilizadores.',
	'guidedtour-help-url' => 'Help:Visitas guiadas',
	'guidedtour-help-guider-url' => 'Help:Visitas guiadas/tutorial',
	'guidedtour-next-button' => 'Próximo',
	'guidedtour-okay-button' => 'Entendido',
	'guidedtour-tour-test-testing' => 'Teste',
	'guidedtour-tour-test-test-description' => 'Está é uma descrição teste. Lorem ipsum dolor sit!',
	'guidedtour-tour-test-callouts' => 'Teste ao balão do guia',
	'guidedtour-tour-test-portal-description' => 'Esta é a página do {{int:portal}}.',
	'guidedtour-tour-test-mediawiki-parse' => 'Teste a análise sintáctica do Mediawiki',
	'guidedtour-tour-test-wikitext-description' => 'Um guia na sua visita guiada pela wiki pode conter wikitexto usando onShow e parseDescription. Use-os para criar um wikilink para o [[{{MediaWiki:Guidedtour-help-url}}|Documentação das visitas guiadas]]. Ou um link externo [https://github.com/tychay/mwgadget.GuidedTour para o GitHub], por exemplo.',
	'guidedtour-tour-test-description-page' => 'Teste de páginas de descrição do MediaWiki',
	'guidedtour-tour-test-go-description-page' => 'Ir para página de descrição',
	'guidedtour-tour-test-launch-tour' => 'Teste do lançamento do guia',
	'guidedtour-tour-test-launch-tour-description' => 'Os guias podem lançar outras visitas guiadas, muito legal, não?',
	'guidedtour-tour-test-launch-using-tours' => 'Lançar um guia sobre como usar visitas guiadas',
	'guidedtour-tour-gettingstarted-start-title' => 'Pronto para ajudar?',
	'guidedtour-tour-gettingstarted-start-description' => 'Esta página precisa de edição básica – melhorar a gramática, estilo, tom ou ortografia – para tornar o texto claro e fácil de ler. Esta guia irá mostrar-lhe as etapas que deve seguir.',
	'guidedtour-tour-gettingstarted-click-edit-title' => "Clique em '{{int:vector-view-edit}}'",
	'guidedtour-tour-gettingstarted-click-edit-description' => 'Isto irá permitir que faça alterações em qualquer parte da página, quando você estiver pronto.',
	'guidedtour-tour-gettingstarted-click-preview-title' => 'Previsualização(opcional)',
	'guidedtour-tour-gettingstarted-click-preview-description' => "Clicar em '{{int:showpreview}}' permite que você verifique como a página vai ficar depois das suas alterações. Só não esqueça de salvar.",
	'guidedtour-tour-gettingstarted-click-save-title' => 'Você está quase terminando!',
	'guidedtour-tour-gettingstarted-click-save-description' => "Clique em '{{int:savearticle}}' e suas alterações serão visíveis.",
	'guidedtour-tour-gettingstarted-end-title' => 'Procurando mais o que fazer?',
	'guidedtour-tour-gettingstarted-end-description' => 'A página [[Special:GettingStarted|Primeiros passos]] é atualizada a cada hora, com novas páginas.',
);

/** tarandíne (tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'guidedtour-desc' => "Permette a le pàggene de avè 'nu popup cu gire guidate pe aijutà le utinde nuève",
	'guidedtour-help-url' => 'Help:Gire guidate',
	'guidedtour-help-guider-url' => 'Help:Gire guidate/guidature',
	'guidedtour-next-button' => 'Prossime',
	'guidedtour-okay-button' => 'Apposte',
	'guidedtour-tour-test-testing' => 'Stoche a teste',
	'guidedtour-tour-test-test-description' => "Quiste jè 'nu teste d'a descrizione. Lorem ipsum dolor sit!",
	'guidedtour-tour-test-callouts' => 'Teste de le didascalie',
	'guidedtour-tour-test-portal-description' => "Queste jè 'a pàgene {{int:portal}}.",
	'guidedtour-tour-test-mediawiki-parse' => "Analizzatore d'u teste de MediaUicchi",
	'guidedtour-tour-test-description-page' => 'Test pàggene de descrizione de MediaUicchi',
	'guidedtour-tour-test-go-description-page' => "Vèje sus 'a pàgene de descrizione",
	'guidedtour-tour-test-launch-tour' => "Test de lange d'u gire",
	'guidedtour-tour-test-launch-tour-description' => 'Le guidature ponne langià otre gire guidate. A uerre, no!?',
	'guidedtour-tour-test-launch-using-tours' => "Lange 'nu gire pe ausè le gire",
	'guidedtour-tour-gettingstarted-start-title' => "Pronde pe dà 'na màne?",
	'guidedtour-tour-gettingstarted-start-description' => "Sta pàgene ave abbesògne de cangiamende d'a copie 'nderra-'nderre - pe migliorà 'a grammateche, 'u stile, 'u tone o 'a pronunge - pe farle pulite e facile da leggere. Stu gire face vedè le passe ca a fà.",
	'guidedtour-tour-gettingstarted-click-edit-title' => "Cazze '{{int:vector-view-edit}}'",
	'guidedtour-tour-gettingstarted-click-edit-description' => "Quiste te lasse ca tu face le cangiaminde jndr'à ogne vanne d'a pàgene, quanne tu si pronde.",
	'guidedtour-tour-gettingstarted-click-preview-title' => 'Andeprime (opzionale)',
	'guidedtour-tour-gettingstarted-click-preview-description' => "Cazzanne '{{int:showpreview}}' te permette de verificà ca 'a pàgene iesse cu le cangiaminde tune. No te demendicà de reggistrà.",
	'guidedtour-tour-gettingstarted-click-save-title' => "E' quase spicciate!",
	'guidedtour-tour-gettingstarted-click-save-description' => "Cazze '{{int:savearticle}}' e le cangiaminde tune devendane visibbile.",
	'guidedtour-tour-gettingstarted-end-title' => 'Ste cirche otre da fà?',
	'guidedtour-tour-gettingstarted-end-description' => '[[Special:GettingStarted|Pe accumenzà]] avène aggiornate ogne ore cu pàggene nove.',
	'guidedtour-tour-firstedit-edit-page-title' => 'Pronde a cangià?',
	'guidedtour-tour-firstedit-edit-page-description' => 'Cazze \'u buttone "{{int:vector-view-edit}}" pe fà le cangiaminde.',
	'guidedtour-tour-firstedit-edit-page-visualeditor-description' => 'Cazze \'u buttone "{{int:visualeditor-ca-editsource}}" pe fà le cangiaminde.',
	'guidedtour-tour-firstedit-edit-section-title' => "Cange giuste 'na sezione",
	'guidedtour-tour-firstedit-edit-section-description' => 'Stonne collegaminde "{{int:editsection}}" pe ogne sezione prengepàle jndr\'à vôsce, accussì tu puè congendrarte sus a quedda parte.',
	'guidedtour-tour-firstedit-edit-section-visualeditor-description' => 'Stonne collegaminde "{{int:visualeditor-ca-editsource-section}}" pe ogne sezione prengepàle jndr\'à vôsce, accussì tu puè congendrarte sus a quedda parte.',
	'guidedtour-tour-firstedit-preview-title' => "Fà vedè l'andeprime de le cangiaminde tune (facoltative)",
	'guidedtour-tour-firstedit-preview-description' => "Cazzanne '{{int:showpreview}}' te permette de verificà ca 'a pàgene iesse cu le cangiaminde tune. No te demendicà de reggistrà.",
	'guidedtour-tour-firstedit-save-title' => "Tu l'è ggià fatte!",
	'guidedtour-tour-firstedit-save-description' => 'Quanne si pronde, cazzanne "{{int:savearticle}}" face devendà le cangiaminde tune visibbile a tutte.',
	'guidedtour-tour-firsteditve-edit-page-description' => 'Cazze \'u buttone "{{int:vector-view-edit}} {{int:visualeditor-beta-appendix}}" pe fà le cangiaminde tune.',
	'guidedtour-tour-firsteditve-edit-section-description' => 'Stonne collegaminde "{{int:editsection}} {{int:visualeditor-beta-appendix}}" pe ogne sezione prengepàle jndr\'à vôsce, accussì tu puè congendrarte sus a quedda parte.',
	'guidedtour-tour-firsteditve-save-description' => 'Quanne sì pronde, cazzanne "{{int:visualeditor-toolbar-savedialog}}" le cangiaminde tune addevendane visibbile a tutte.',
);

/** Russian (русский)
 * @author DCamer
 * @author KPu3uC B Poccuu
 */
$messages['ru'] = array(
	'guidedtour-tour-test-testing' => 'Тестирование',
	'guidedtour-tour-test-test-description' => 'Это проверка описания. Lorem ipsum dolor sit!',
	'guidedtour-tour-test-callouts' => 'Тест выноски',
	'guidedtour-tour-test-mediawiki-parse' => 'Тест mediawiki parse',
	'guidedtour-tour-test-go-description-page' => 'Перейти на страницу описания',
	'guidedtour-tour-test-launch-tour' => 'Тестовый запуск тура',
);

/** Slovenian (slovenščina)
 * @author Eleassar
 */
$messages['sl'] = array(
	'guidedtour-tour-firsteditve-edit-page-description' => 'Za prikaz sprememb, ki ste jih vnesli, kliknite gumb  »{{int:vector-view-edit}} {{int:visualeditor-beta-appendix}}«.',
	'guidedtour-tour-firsteditve-edit-section-description' => 'V vsakem večjem razdelku člankov so na razpolago povezave »{{int:editsection}} {{int:visualeditor-beta-appendix}}«, s katerimi se lahko osredotočite samo na ta del.',
	'guidedtour-tour-firsteditve-save-description' => 'Ko boste pripravljeni, lahko s klikom gumba »{{int:visualeditor-toolbar-savedialog}}« svoje spremembe napravite vidne vsakomur.',
);

/** Serbian (Cyrillic script) (српски (ћирилица)‎)
 * @author Milicevic01
 */
$messages['sr-ec'] = array(
	'guidedtour-next-button' => 'Следеће',
);

/** Swedish (svenska)
 * @author Ainali
 * @author Jopparn
 */
$messages['sv'] = array(
	'guidedtour-desc' => 'Tillåter sidor att ge en popup-guidad tur för att hjälpa nya användare',
	'guidedtour-help-url' => 'Help:Guidade turer',
	'guidedtour-help-guider-url' => 'Help:Guidade turer/guider',
	'guidedtour-next-button' => 'Nästa',
	'guidedtour-okay-button' => 'Okej',
	'guidedtour-tour-test-testing' => 'Testar',
	'guidedtour-tour-test-test-description' => 'Detta är ett test av beskrivningen. Lorem ipsum dolor sit!',
	'guidedtour-tour-test-callouts' => 'Testa utpekning',
	'guidedtour-tour-test-portal-description' => 'Detta är sidan {{int:portal}}.',
	'guidedtour-tour-test-mediawiki-parse' => 'Testa MediaWikitolkning',
	'guidedtour-tour-test-description-page' => 'Testa sidbeskrivning för MediaWiki',
	'guidedtour-tour-test-go-description-page' => 'Gå till beskrivningssida',
	'guidedtour-tour-test-launch-tour' => 'Testa starta tur',
	'guidedtour-tour-test-launch-tour-description' => 'Turer kan starta andra guidade turer. Ganska coolt, va?',
	'guidedtour-tour-test-launch-using-tours' => 'Starta en tur om att använda turer',
	'guidedtour-tour-gettingstarted-start-title' => 'Redo att hjälpa?',
	'guidedtour-tour-gettingstarted-start-description' => 'Denna sida behöver grundläggande textförbättring – förbättra grammatik, stil, ton eller stavning – för att göra det tydligt och lätt att läsa. Denna tur visar dig stegen att ta.',
	'guidedtour-tour-gettingstarted-click-edit-title' => 'Klicka på {{int:vector-view-edit}}',
	'guidedtour-tour-gettingstarted-click-edit-description' => 'Detta låter dig göra ändringar i vilken del av sidan som helst när du är redo.',
	'guidedtour-tour-gettingstarted-click-preview-title' => 'Förhandsgranska (valfritt)',
	'guidedtour-tour-gettingstarted-click-preview-description' => "Genom att klicka på '{{int:showpreview}}' kan du kontrollera hur sidan ser ut med dina ändringar. Glöm bara inte att spara.",
	'guidedtour-tour-gettingstarted-click-save-title' => 'Du är nästan klar!',
	'guidedtour-tour-gettingstarted-click-save-description' => "Klicka på '{{int:savearticle}}' och dina ändringar kommer att vara synliga.",
	'guidedtour-tour-gettingstarted-end-title' => 'Letar du efter mer att göra?',
	'guidedtour-tour-gettingstarted-end-description' => '[[Special:GettingStarted|Komma igång]] uppdateras varje timme med nya sidor.',
	'guidedtour-tour-firstedit-edit-page-title' => 'Redo att redigera?',
	'guidedtour-tour-firstedit-edit-page-description' => "Klicka på '{{int:vector-view-edit}}'-knappen för att göra dina ändringar.",
	'guidedtour-tour-firstedit-edit-page-visualeditor-description' => "Klicka på '{{int:visualeditor-ca-editsource}}'-knappen för att göra dina ändringar.",
	'guidedtour-tour-firstedit-edit-section-title' => 'Redigera bara ett avsnitt',
	'guidedtour-tour-firstedit-edit-section-description' => 'Det finns "{{int:editsection}}"-länkar för varje större avsnitt i en artikel, så att du kan fokusera på endast den delen.',
	'guidedtour-tour-firstedit-edit-section-visualeditor-description' => 'Det finns "{{int:visualeditor-ca-editsource-avsnitt}}"-länkar för varje större avsnitt i en artikel, så att du kan fokusera på endast den delen.',
	'guidedtour-tour-firstedit-preview-title' => 'Förhandsgranska dina ändringar (valfritt)',
	'guidedtour-tour-firstedit-preview-description' => 'Genom att klicka på "{{int:showpreview}}" kan du kontrollera hur sidan ser ut med dina ändringar. Glöm bara inte att spara!',
	'guidedtour-tour-firstedit-save-title' => 'Du är nästan klar!',
	'guidedtour-tour-firstedit-save-description' => 'När du är redo, kommer ett klick på "{{int:savearticle}}" att synliggöra dina ändringar för alla.',
	'guidedtour-tour-firsteditve-edit-page-description' => 'Klicka på knappen "{{int:vector-view-edit}} {{int:visualeditor-beta-appendix}}" för att göra dina ändringar.',
	'guidedtour-tour-firsteditve-edit-section-description' => 'Det finns "{{int:editsection}} {{int:visualeditor-beta-appendix}}"-länkar för varje större avsnitt i en artikel, så att du kan fokusera på endast den delen.',
	'guidedtour-tour-firsteditve-save-description' => 'När du är redo, kommer ett klick på "{{int:visualeditor-toolbar-savedialog}}" att synliggöra dina ändringar för alla.',
);

/** Ukrainian (українська)
 * @author Andriykopanytsia
 * @author Base
 */
$messages['uk'] = array(
	'guidedtour-desc' => 'Дозволяє сторінкам виводити вспливаюче навчання для допомоги новачкам',
	'guidedtour-help-url' => 'Help:Інтерактивні тури',
	'guidedtour-help-guider-url' => 'Довідка: інтерактивні тури/гід',
	'guidedtour-next-button' => 'Далі',
	'guidedtour-okay-button' => 'Гаразд',
	'guidedtour-tour-test-testing' => 'Тестування',
	'guidedtour-tour-test-test-description' => 'Це випробування опису. Lorem ipsum dolor sit!',
	'guidedtour-tour-test-callouts' => 'Тест виноски',
	'guidedtour-tour-test-portal-description' => 'Це сторінка {{int:portal}}.',
	'guidedtour-tour-test-mediawiki-parse' => 'Тест аналізу Медіавікі',
	'guidedtour-tour-test-description-page' => 'Тест опису сторінок Медіавікі',
	'guidedtour-tour-test-go-description-page' => 'Перейти на сторінку опису',
	'guidedtour-tour-test-launch-tour' => 'Тестовий запуск туру',
	'guidedtour-tour-test-launch-tour-description' => 'Гід може запускати інші інтерактивні тури. Досить непогано, так?',
	'guidedtour-tour-test-launch-using-tours' => 'Запуск тур по використанню турів',
	'guidedtour-tour-gettingstarted-start-title' => 'Готові до допомоги?',
	'guidedtour-tour-gettingstarted-start-description' => 'Ця сторінка потребує основного технічного редагування – поліпшення граматики, стилю, тону або орфографії - аби зробити її легшою до читання та сприйняття. Цей тур покаже вам кроки, які потрібно зробити.',
	'guidedtour-tour-gettingstarted-click-edit-title' => "Натисніть '{{int:vector-view-edit}}'",
	'guidedtour-tour-gettingstarted-click-edit-description' => 'Це дозволить вам змінювати будь-яку частину сторінки, коли ви будете готові.',
	'guidedtour-tour-gettingstarted-click-preview-title' => "Попередній перегляд (необов'язково)",
	'guidedtour-tour-gettingstarted-click-preview-description' => 'Клацання "{{int:showpreview}}" дає змогу перевіряти вигляд сторінки із внесеними змінами. Тільки не забудьте зберегти.',
	'guidedtour-tour-gettingstarted-click-save-title' => 'Ви майже закінчили!',
	'guidedtour-tour-gettingstarted-click-save-description' => "Натисніть '{{int:savearticle}}' і зміни буде видно.",
	'guidedtour-tour-gettingstarted-end-title' => 'Шукаєте ще роботи?',
	'guidedtour-tour-gettingstarted-end-description' => '[[Special:GettingStarted|Перші кроки]] оновлюється щогодини з новими сторінками.',
	'guidedtour-tour-firstedit-edit-page-title' => 'Готові редагувати?',
	'guidedtour-tour-firstedit-edit-page-description' => "Натисніть кнопку  '{{int:vector-view-edit}}', щоб внести зміни.",
	'guidedtour-tour-firstedit-edit-page-visualeditor-description' => "Натисніть кнопку '{{int:visualeditor-ca-editsource}}', аби внести зміни.",
	'guidedtour-tour-firstedit-edit-section-title' => 'Редагувати тільки в розділі',
	'guidedtour-tour-firstedit-edit-section-description' => "Існують посилання '{{int:editsection}}' для кожного головного розділу в статті, тому ви можете зосередитися тільки на цій частині.",
	'guidedtour-tour-firstedit-edit-section-visualeditor-description' => "Існують посилання '{{int:visualeditor-ca-editsource-section}}' для кожного головного розділу в статті, тому ви можете зосередитися тільки на цій частині.",
	'guidedtour-tour-firstedit-preview-title' => 'Переглянути ваші зміни (за бажанням)',
	'guidedtour-tour-firstedit-preview-description' => 'Клацання "{{int:showpreview}}" дає змогу перевіряти вигляд сторінки із внесеними змінами. Тільки не забудьте зберегти!',
	'guidedtour-tour-firstedit-save-title' => 'Майже все готове!',
	'guidedtour-tour-firstedit-save-description' => "Коли ви будете готові, натискання '{{int:savearticle}}' зробить ваші зміни видимими для всіх.",
	'guidedtour-tour-firsteditve-edit-page-description' => 'Натисніть на кнопку "{{int:vector-view-edit}} {{int:visualeditor-beta-appendix}}", аби внести свої зміни.',
	'guidedtour-tour-firsteditve-edit-section-description' => 'Існують посилання "{{int:editsection}} {{int:visualeditor-beta-appendix}}" для кожного головного розділу в статті, тому ви можете зосередитися тільки на цій частині.',
	'guidedtour-tour-firsteditve-save-description' => 'Коли ви будете готові, натискання "{{int:visualeditor-toolbar-savedialog}}" зробить ваші зміни видимими для всіх.',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'guidedtour-desc' => 'Hiển thị chương trình hướng dẫn sử dụng cho những người dùng mới',
	'guidedtour-help-url' => 'Help:Chương trình hướng dẫn sử dụng',
	'guidedtour-help-guider-url' => 'Help:Chương trình hướng dẫn sử dụng/giới thiệu',
	'guidedtour-custom.css' => '/* Mã CSS tùy biến dành cho phần mở rộng GuidedTour. */',
	'guidedtour-next-button' => 'Tiếp',
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
	'guidedtour-tour-gettingstarted-click-preview-title' => 'Xem trước (tùy chọn)',
	'guidedtour-tour-gettingstarted-click-preview-description' => 'Bấm “{{int:showpreview}}” để kiểm tra các thay đổi của bạn có phải hiển thị đúng hay không. Hãy nhớ lưu trang.',
	'guidedtour-tour-gettingstarted-click-save-title' => 'Gần xong!',
	'guidedtour-tour-gettingstarted-click-save-description' => 'Bấm “{{int:savearticle}}” là các thay đổi của bạn sẽ được áp dụng vào trang.',
	'guidedtour-tour-gettingstarted-end-title' => 'Muốn biết cái gì cần làm?',
	'guidedtour-tour-gettingstarted-end-description' => 'Trang [[Special:GettingStarted|Bắt đầu]] được cập nhật từng giờ với trang mới.',
	'guidedtour-tour-firstedit-edit-page-title' => 'Có sẵn sàng để sửa đổi?',
	'guidedtour-tour-firstedit-edit-page-description' => 'Bấm nút “{{int:vector-view-edit}}” để sửa đổi trang.',
	'guidedtour-tour-firstedit-edit-page-visualeditor-description' => 'Bấm nút “{{int:visualeditor-ca-editsource}}” để sửa đổi trang.',
	'guidedtour-tour-firstedit-edit-section-title' => 'Chỉ việc sửa đôi một phần trang',
	'guidedtour-tour-firstedit-edit-section-description' => 'Mỗi tiêu đề lớn trong bài có liên kết “{{int:editsection}}” để chỉ sửa đổi phần trang đó.',
	'guidedtour-tour-firstedit-edit-section-visualeditor-description' => 'Mỗi tiêu đề lớn trong bài có liên kết “{{int:visualeditor-ca-editsource-section}}” để nhảy tới tiêu đề khi bắt đầu sửa đổi.',
	'guidedtour-tour-firstedit-preview-title' => 'Xem trước các thay đổi của bạn (tùy chọn)',
	'guidedtour-tour-firstedit-preview-description' => 'Bấm “{{int:showpreview}}” để kiểm tra các thay đổi của bạn có hiển thị như bạn muốn. Đừng quên lưu trang!',
	'guidedtour-tour-firstedit-save-title' => 'Gần xong rồi!',
	'guidedtour-tour-firstedit-save-description' => 'Sau khi sửa đổi xong, bấm “{{int:savearticle}}” để xuất bản các thay đổi của bạn để cho mọi người xem.',
	'guidedtour-tour-firsteditve-edit-page-description' => 'Bấm nút “{{int:vector-view-edit}} {{int:visualeditor-beta-appendix}}” để thực hiện các thay đổi.',
	'guidedtour-tour-firsteditve-edit-section-description' => 'Mỗi tiêu đề lớn trong bài có liên kết “{{int:editsection}} {{int:visualeditor-beta-appendix}}” để nhảy tới tiêu đề khi bắt đầu sửa đổi.',
	'guidedtour-tour-firsteditve-save-description' => 'Sau khi sửa đổi xong, bấm “{{int:visualeditor-toolbar-savedialog}}” để xuất bản các thay đổi của bạn để cho mọi người xem.',
);

/** Wu (吴语)
 * @author 十弌
 */
$messages['wuu'] = array(
	'guidedtour-tour-gettingstarted-click-edit-title' => '點 "{{int:vector-view-edit}}"',
	'guidedtour-tour-gettingstarted-click-preview-description' => '點 "{{int:showpreview}}" 讓爾望得著改爻之後頁面個變化，休要忘記爻保存起。',
	'guidedtour-tour-gettingstarted-click-save-description' => '點 "{{int:savearticle}}" 爾個改動便保存爻。',
	'guidedtour-tour-firstedit-edit-page-title' => '準備開改來爻朆？',
	'guidedtour-tour-firstedit-edit-page-visualeditor-description' => '點 "{{int:visualeditor-ca-editsource}}" 捺鈕準定改動。',
	'guidedtour-tour-firstedit-edit-section-title' => '便改一個章節',
	'guidedtour-tour-firstedit-edit-section-visualeditor-description' => '文章各個主要章節都有 "{{int:visualeditor-ca-editsource-section}}" 鏈接, 爾好專門入心一箇部份。',
	'guidedtour-tour-firstedit-preview-title' => '改動望望相起',
	'guidedtour-tour-firstedit-save-title' => '爾便要妝了滯爻！',
	'guidedtour-tour-firstedit-save-description' => '準備起爻，點"{{int:savearticle}}"大家人便都望得著爾個改動爻。',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Hydra
 * @author Li3939108
 * @author Shizhao
 * @author Yfdyh000
 * @author 乌拉跨氪
 */
$messages['zh-hans'] = array(
	'guidedtour-desc' => '允许页面提供一个弹出式导览来引导新用户',
	'guidedtour-help-url' => 'Help:导览',
	'guidedtour-help-guider-url' => 'Help:导览/向导',
	'guidedtour-next-button' => '下一步',
	'guidedtour-okay-button' => '好的',
	'guidedtour-tour-test-testing' => '测试',
	'guidedtour-tour-test-test-description' => '这是一个描述的测试。Lorem ipsum dolor sit!',
	'guidedtour-tour-test-callouts' => '测试标注',
	'guidedtour-tour-test-portal-description' => '这是{{int:portal}}页。',
	'guidedtour-tour-test-mediawiki-parse' => '测试MediaWiki解析器',
	'guidedtour-tour-test-description-page' => '测试MediaWiki描述页',
	'guidedtour-tour-test-go-description-page' => '转到描述页面',
	'guidedtour-tour-test-launch-tour' => '测试启动导览',
	'guidedtour-tour-test-launch-tour-description' => '向导可以启动其他导览。很酷，对吧？',
	'guidedtour-tour-test-launch-using-tours' => '在使用的导览上启动一个导览',
	'guidedtour-tour-gettingstarted-start-title' => '准备好帮助了吗？',
	'guidedtour-tour-gettingstarted-start-description' => '此页需要基本的校对（改善其语法、文风、用词或错别字）使其更易于阅读。本导览将告诉您该如何做。',
	'guidedtour-tour-gettingstarted-click-edit-title' => '点击“{{int:vector-view-edit}}”',
	'guidedtour-tour-gettingstarted-click-edit-description' => '当您准备好后，点击此处便可对该页的每一部分作出更改。',
	'guidedtour-tour-gettingstarted-click-preview-title' => '预览（可选）',
	'guidedtour-tour-gettingstarted-click-preview-description' => '点击“{{int:showpreview}}”，您将看到您在该页面作出了哪些更改。请不要忘记保存。',
	'guidedtour-tour-gettingstarted-click-save-title' => '您马上就完成了！',
	'guidedtour-tour-gettingstarted-click-save-description' => '点击“{{int:savearticle}}”，您将保存您所作出的更改。',
	'guidedtour-tour-gettingstarted-end-title' => '想要寻找更多的事情做？',
	'guidedtour-tour-gettingstarted-end-description' => '[[Special:GettingStarted|入门指南]]每小时会更新页面。',
	'guidedtour-tour-firstedit-edit-page-title' => '准备好编辑了吗？',
	'guidedtour-tour-firstedit-edit-page-description' => '点击“{{int:vector-view-edit}}”按钮，确认你的修改。',
	'guidedtour-tour-firstedit-edit-page-visualeditor-description' => '点击“{{int:visualeditor-ca-editsource}}”按钮，确认您的修改。',
	'guidedtour-tour-firstedit-edit-section-title' => '只编辑一个章节',
	'guidedtour-tour-firstedit-edit-section-description' => '条目中每个主要章节都有“{{int:editsection}}”链接，这可以让你只在这部分集中精神。',
	'guidedtour-tour-firstedit-edit-section-visualeditor-description' => '条目中每个主要章节都有“{{int:visualeditor-ca-editsource-section}}”链接，这可以让你集中精神于该部分。',
	'guidedtour-tour-firstedit-preview-title' => '预览您的更改（可选）',
	'guidedtour-tour-firstedit-preview-description' => '点击“{{int:showpreview}}”，您将看到您在该页面作出了哪些更改。请不要忘记保存！',
	'guidedtour-tour-firstedit-save-title' => '你马上就要完成了！',
	'guidedtour-tour-firstedit-save-description' => '当你准备好时，点击“{{int:savearticle}}”，您所做的修改会让所有人都看到。',
);

/** Traditional Chinese (中文（繁體）‎)
 * @author Simon Shek
 */
$messages['zh-hant'] = array(
	'guidedtour-next-button' => '下一步',
);
