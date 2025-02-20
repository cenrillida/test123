<?
// Отправить статью в журнал
global $DB,$_CONFIG, $site_templater;

$articleSendBuilder = new ArticleSendBuilder($_TPL_REPLACMENT["OLD_MAGAZINE_ID"],true,$_TPL_REPLACMENT["MAIN_JOUR_ID"]);

if($_TPL_REPLACMENT["MAIN_JOUR_ID"]==1614) {

    if ($_SESSION[lang] != "/en") {
        $articleSendBuilder->registerField(new ArticleSendFormField("fio", "text", true, "ФИО", "Не введено ФИО"));
        $articleSendBuilder->registerField(new ArticleSendFormField("fio_en", "text", true, "ФИО (English)", "Не введено ФИО на английском"));
        $articleSendBuilder->registerField(new ArticleSendFormField("affiliation", "textarea", true, "Аффилиация", "Не введена аффилиация"));
        $articleSendBuilder->registerField(new ArticleSendFormField("affiliation_en", "textarea", true, "Аффилиация (English)", "Не введена аффилиация на английском"));
        $articleSendBuilder->registerField(new ArticleSendFormField("name", "textarea", true, "Название статьи", "Не введено название статьи"));
        $articleSendBuilder->registerField(new ArticleSendFormField("name_en", "textarea", true, "Название статьи (English)", "Не введено название статьи на английском"));
        $articleSendBuilder->registerField(new ArticleSendFormField("rubric", "rubric", true, "Предполагаемая рубрика", "Не введена рубрика", "Выбор рубрики"));
        $articleSendBuilder->registerField(new ArticleSendFormField("upload2", "file", false, "Прикрепить статью (не более 5МБайт, формат: doc, docx)", "", "Выбрать файл"));
        $articleSendBuilder->registerField(new ArticleSendFormField("email", "email", true, "<b>Для связи с редакцией</b><br>Адрес e-mail", "Не указан e-mail", "name@example.com", true, "Неприемлимый формат email"));
        $articleSendBuilder->registerField(new ArticleSendFormField("telephone", "text", false, "Номер телефона", ""));
        $articleSendBuilder->registerField(new ArticleSendFormField("text", "textarea", false, "Комментарий", ""));
    } else {
        $articleSendBuilder->registerField(new ArticleSendFormField("fio", "text", true, "Author’ name (Russian)", "Your name is not entered"));
        $articleSendBuilder->registerField(new ArticleSendFormField("fio_en", "text", true, "Author’ name (English)", "Your name In English is not entered"));
        $articleSendBuilder->registerField(new ArticleSendFormField("affiliation", "textarea", true, "Affiliation (Russian)", "Affiliation is not entered"));
        $articleSendBuilder->registerField(new ArticleSendFormField("affiliation_en", "textarea", true, "Affiliation (English)", "Affiliation In English is not entered"));
        $articleSendBuilder->registerField(new ArticleSendFormField("name", "textarea", true, "Title of paper (Russian)", "Title of the article is not entered"));
        $articleSendBuilder->registerField(new ArticleSendFormField("name_en", "textarea", true, "Title of paper (English)", "Title of the article In English is not entered"));
        $articleSendBuilder->registerField(new ArticleSendFormField("rubric", "rubric", true, "Intended Rubric", "Rubric is not entered", "Choose rubric"));
        $articleSendBuilder->registerField(new ArticleSendFormField("upload2", "file", false, "Attach paper (no more than 5MB, format: doc, docx)", "", "Choose file"));
        $articleSendBuilder->registerField(new ArticleSendFormField("email", "email", true, "<b>Contacts with editorial board</b><br>E-mail", "E-mail is not entered", "name@example.com", true, "Wrong email format"));
        $articleSendBuilder->registerField(new ArticleSendFormField("telephone", "text", false, "Phone", ""));
        $articleSendBuilder->registerField(new ArticleSendFormField("text", "textarea", false, "Comments", ""));
    }
    $articleSendBuilder->processPostBuild("",true);
}

if($_TPL_REPLACMENT["MAIN_JOUR_ID"]==1669) {

    if ($_SESSION[lang] != "/en") {
        $articleSendBuilder->registerField(new ArticleSendFormField("fio", "text", true, "ФИО", "Не введено ФИО"));
        $articleSendBuilder->registerField(new ArticleSendFormField("fio_en", "text", true, "ФИО (english)", "Не введено ФИО на английском"));
        $articleSendBuilder->registerField(new ArticleSendFormField("affiliation", "textarea", true, "Аффилиация", "Не введена аффилиация"));
        $articleSendBuilder->registerField(new ArticleSendFormField("affiliation_en", "textarea", true, "Аффилиация (English)", "Не введена аффилиация на английском"));
        $articleSendBuilder->registerField(new ArticleSendFormField("name", "textarea", true, "Название статьи", "Не введено название статьи"));
        $articleSendBuilder->registerField(new ArticleSendFormField("name_en", "textarea", true, "Название статьи (English)", "Не введено название статьи на английском"));
        $articleSendBuilder->registerField(new ArticleSendFormField("type", "select", true, "Тип статьи", "Не выбран тип статьи", "Научная статья|Рецензия"));
        $articleSendBuilder->registerField(new ArticleSendFormField("upload2", "file", false, "Прикрепить статью (не более 5МБайт, формат: doc, docx)", "", "Выбрать файл"));
        $articleSendBuilder->registerField(new ArticleSendFormField("email", "email", true, "<b>Для Связи с редакцией</b><br>Адрес e-mail", "Не указан e-mail", "name@example.com", true, "Неприемлимый формат email"));
        $articleSendBuilder->registerField(new ArticleSendFormField("telephone", "text", false, "Номер телефона", ""));
        $articleSendBuilder->registerField(new ArticleSendFormField("text", "textarea", false, "Комментарий", ""));
    } else {
        $articleSendBuilder->registerField(new ArticleSendFormField("fio_en", "text", true, "Author’ name (English)", "Your name In English is not entered"));
        $articleSendBuilder->registerField(new ArticleSendFormField("affiliation_en", "textarea", true, "Affiliation (English)", "Affiliation In English is not entered"));
        $articleSendBuilder->registerField(new ArticleSendFormField("name_en", "textarea", true, "Title of paper (English)", "Title of the article In English is not entered"));
        $articleSendBuilder->registerField(new ArticleSendFormField("type", "select", true, "Type of submission", "Type of submission is not selected", "Research article|Book review"));
        $articleSendBuilder->registerField(new ArticleSendFormField("upload2", "file", false, "Attach paper (no more than 5MB, format: doc, docx)", "", "Choose file"));
        $articleSendBuilder->registerField(new ArticleSendFormField("email", "email", true, "<b>Contacts for communication with editorial board</b><br>E-mail", "E-mail is not entered", "name@example.com", true, "Wrong email format"));
        $articleSendBuilder->registerField(new ArticleSendFormField("telephone", "text", false, "Phone", ""));
        $articleSendBuilder->registerField(new ArticleSendFormField("text", "textarea", false, "Comments", ""));
    }
    $articleSendBuilder->processPostBuild("putikmiru@imemo.ru",true);
}



$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

$jour=$DB->select("SELECT page_name,page_name_en FROM adm_pages WHERE page_id=".$_TPL_REPLACMENT["MAIN_JOUR_ID"]);
if ($_SESSION[lang]!='/en')
  echo "<h2>".$jour[0][page_name]."</h2><br />";
else
  echo "<h2>".$jour[0][page_name_en]."</h2><br />";

$articleSendBuilder->build();

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>