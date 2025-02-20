<?
// ��������� ������ � ������
global $DB,$_CONFIG, $site_templater;

$articleSendBuilder = new ArticleSendBuilder($_TPL_REPLACMENT["OLD_MAGAZINE_ID"],true,$_TPL_REPLACMENT["MAIN_JOUR_ID"]);

if($_TPL_REPLACMENT["MAIN_JOUR_ID"]==1614) {

    if ($_SESSION[lang] != "/en") {
        $articleSendBuilder->registerField(new ArticleSendFormField("fio", "text", true, "���", "�� ������� ���"));
        $articleSendBuilder->registerField(new ArticleSendFormField("fio_en", "text", true, "��� (English)", "�� ������� ��� �� ����������"));
        $articleSendBuilder->registerField(new ArticleSendFormField("affiliation", "textarea", true, "����������", "�� ������� ����������"));
        $articleSendBuilder->registerField(new ArticleSendFormField("affiliation_en", "textarea", true, "���������� (English)", "�� ������� ���������� �� ����������"));
        $articleSendBuilder->registerField(new ArticleSendFormField("name", "textarea", true, "�������� ������", "�� ������� �������� ������"));
        $articleSendBuilder->registerField(new ArticleSendFormField("name_en", "textarea", true, "�������� ������ (English)", "�� ������� �������� ������ �� ����������"));
        $articleSendBuilder->registerField(new ArticleSendFormField("rubric", "rubric", true, "�������������� �������", "�� ������� �������", "����� �������"));
        $articleSendBuilder->registerField(new ArticleSendFormField("upload2", "file", false, "���������� ������ (�� ����� 5�����, ������: doc, docx)", "", "������� ����"));
        $articleSendBuilder->registerField(new ArticleSendFormField("email", "email", true, "<b>��� ����� � ���������</b><br>����� e-mail", "�� ������ e-mail", "name@example.com", true, "������������ ������ email"));
        $articleSendBuilder->registerField(new ArticleSendFormField("telephone", "text", false, "����� ��������", ""));
        $articleSendBuilder->registerField(new ArticleSendFormField("text", "textarea", false, "�����������", ""));
    } else {
        $articleSendBuilder->registerField(new ArticleSendFormField("fio", "text", true, "Author� name (Russian)", "Your name is not entered"));
        $articleSendBuilder->registerField(new ArticleSendFormField("fio_en", "text", true, "Author� name (English)", "Your name In English is not entered"));
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
        $articleSendBuilder->registerField(new ArticleSendFormField("fio", "text", true, "���", "�� ������� ���"));
        $articleSendBuilder->registerField(new ArticleSendFormField("fio_en", "text", true, "��� (english)", "�� ������� ��� �� ����������"));
        $articleSendBuilder->registerField(new ArticleSendFormField("affiliation", "textarea", true, "����������", "�� ������� ����������"));
        $articleSendBuilder->registerField(new ArticleSendFormField("affiliation_en", "textarea", true, "���������� (English)", "�� ������� ���������� �� ����������"));
        $articleSendBuilder->registerField(new ArticleSendFormField("name", "textarea", true, "�������� ������", "�� ������� �������� ������"));
        $articleSendBuilder->registerField(new ArticleSendFormField("name_en", "textarea", true, "�������� ������ (English)", "�� ������� �������� ������ �� ����������"));
        $articleSendBuilder->registerField(new ArticleSendFormField("type", "select", true, "��� ������", "�� ������ ��� ������", "������� ������|��������"));
        $articleSendBuilder->registerField(new ArticleSendFormField("upload2", "file", false, "���������� ������ (�� ����� 5�����, ������: doc, docx)", "", "������� ����"));
        $articleSendBuilder->registerField(new ArticleSendFormField("email", "email", true, "<b>��� ����� � ���������</b><br>����� e-mail", "�� ������ e-mail", "name@example.com", true, "������������ ������ email"));
        $articleSendBuilder->registerField(new ArticleSendFormField("telephone", "text", false, "����� ��������", ""));
        $articleSendBuilder->registerField(new ArticleSendFormField("text", "textarea", false, "�����������", ""));
    } else {
        $articleSendBuilder->registerField(new ArticleSendFormField("fio_en", "text", true, "Author� name (English)", "Your name In English is not entered"));
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