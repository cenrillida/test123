<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();


$_CONFIG = array();

// берем конфиг системы если конфиг не найден - выходим
$_CONFIG["global"] = @parse_ini_file(dirname(__FILE__)."/_config.ini", true);
if(empty($_CONFIG["global"]))
    die("Файл конфигурации системы не найден");
// создаем дополнительную переменную admin_path - полный путь до директории с системой администрирования
$_CONFIG["global"]["paths"]["admin_path"] = $_SERVER["DOCUMENT_ROOT"]."/".$_CONFIG["global"]["paths"]["admin_dir"];
$_CONFIG["global"]["paths"]["template_path"] = $_SERVER["DOCUMENT_ROOT"]."/".$_CONFIG["global"]["paths"]["templates"];

// берем action'ы если конфиг не найден - выходим
$_CONFIG["action"] = @parse_ini_file(dirname(__FILE__)."/_action.ini", true);
if(empty($_CONFIG["global"]))
    die("Файл конфигурации панели действий не найден");


// подключаем заголовки страниц
include_once dirname(__FILE__)."/includes/headers.php";
// подключаем файл соединения с базой
include_once dirname(__FILE__)."/includes/connect.php";
// перекрываем неподдержваемые браузеры
include_once dirname(__FILE__)."/includes/browser_detect.php";
// подключаем переводчик
include_once dirname(__FILE__)."/includes/gettext.php";
// подключаем PHP-версию fckeditor'а и вастывляем BasePath;
//include_once dirname(__FILE__)."/includes/FCKEditor/fckeditor.php";
// подключаем функции для обработки xml;
include_once dirname(__FILE__)."/includes/dom.php";

// классы
// подключаем класс строительства форм
include_once dirname(__FILE__)."/includes/phorm/phorm.mod.class.php";
// подключаем статичный класс для работы ядра
include_once dirname(__FILE__)."/includes/class.Dreamedit.php";
// подключаем класс для работы с правами доступа
include_once dirname(__FILE__)."/includes/class.Permissions.php";
// подключаем класс - шаблонизатор
include_once dirname(__FILE__)."/includes/class.Templater.php";
// подключаем класс для проверки отображения action'ов
include_once dirname(__FILE__)."/includes/class.actionCheck.php";
// подключаем класс для работы со страницами
include_once dirname(__FILE__)."/includes/class.Pages.php";
// подключаем класс для работы с персонами
include_once dirname(__FILE__)."/includes/class.Persons.php";
// подключаем класс для работы с инфолентами
include_once dirname(__FILE__)."/includes/class.Ilines.php";
include_once dirname(__FILE__)."/includes/class.Directories.php";

include_once dirname(__FILE__)."/includes/class.Headers.php";
include_once dirname(__FILE__)."/includes/class.Polls.php";
include_once dirname(__FILE__)."/includes/class.Binding.php";
include_once dirname(__FILE__)."/includes/class.Blogs.php";
//Обработка событий календаря
include_once dirname(__FILE__)."/includes/class.Events.php";
// подключаем класс для работы с изображениями
include_once dirname(__FILE__)."/includes/class.Imager.php";
// подключаем класс для работы с js деревом
include_once dirname(__FILE__)."/includes/class.WriteTree.php";
// подключаем класс для работы cо страницами эл-тов
include_once dirname(__FILE__)."/includes/class.Pagination.php";
// подключаем класс для работы грантами
include_once dirname(__FILE__)."/includes/class.Nirs.php";
//Для работы с персонами
include_once dirname(__FILE__)."/includes/class.ROSPersons.php";
//Для работы с разделом помощт
include_once dirname(__FILE__)."/includes/class.Helper.php";
//Для голосования
include_once dirname(__FILE__)."/includes/class.Tenders.php";
//Для работы с публикациями
include_once dirname(__FILE__)."/includes/class.Publications.php";
//Для работы с ZOTERO
include_once dirname(__FILE__)."/includes/bib.php";
//Для работы с журналами
include_once dirname(__FILE__)."/includes/class.Magazine.php";
include_once dirname(__FILE__)."/includes/class.MagazineNew.php";
//Для работы со стьями в журналах
include_once dirname(__FILE__)."/includes/class.Article.php";
//Для формирования XML для elibrary
include_once dirname(__FILE__)."/includes/class.XMLWriter.php";

include_once dirname(__FILE__)."/includes/class.Statistic.php";

include_once dirname(__FILE__)."/includes/class.CacheEngine.php";


global $DB;
$DB->query("SET NAMES utf8");
//
//include_once dirname(__FILE__)."/_include.php";

$mz = new MagazineNew();
$pg = new Pages();
$xml = new xml_output();

$rows=$mz->getMagazineNumberEn(10054);
$rows=$mz->appendContentArticle($rows);

$numberContent = $mz->getArticleById(10054);
$numberContent[0]['content'] = $mz->getArticleContentByPageId(10054);
$journalInfo = $pg->getContentByPageId($numberContent[0]['journal_new']);

$vol_pos = strripos($numberContent[0]['page_name'], "т.");
$comma = strripos($numberContent[0]['page_name'], ",");

if ($comma !== false) {
    $issue = substr($numberContent[0]['page_name'], 0, $comma);
} else {
    $issue = $numberContent[0]['page_name'];
}

$doiBatchId = time()."-".md5($journalInfo['CROSSREF_ABBREV']."-".time()."-"."10054");

//var_dump($journalInfo);
//exit;

header("Content-Type: text/html; charset=utf8");

ob_start();

$xml->startXML();
$xml->elementStart('doi_batch',array(
    "xmlns" => "http://www.crossref.org/schema/4.4.2",
    "xmlns:xsi" => "http://www.w3.org/2001/XMLSchema-instance",
    "version" => "4.4.2",
    "xsi:schemaLocation" =>
        "http://www.crossref.org/schema/4.4.2 http://www.crossref.org/schema/deposit/crossref4.4.2.xsd"
));
    $xml->elementStart('head');
        $xml->element(
            'doi_batch_id',
            null,
            $doiBatchId
        );
        $xml->element('timestamp',null,date("YmdHi"));
        $xml->elementStart('depositor');
            $xml->element('depositor_name',null,"primakov");
            $xml->element('email_address',null,"mirina@imemo.ru");
        $xml->elementEnd('depositor');
        $xml->element('registrant',null,"WEB-FORM");
    $xml->elementEnd('head');
    $xml->elementStart('body');
        $xml->elementStart('journal');
            $xml->elementStart('journal_metadata');
                $xml->element('full_title',null,$journalInfo['PAGE_MENUNAME_EN']);
                $xml->element('abbrev_title',null,$journalInfo['CROSSREF_ABBREV']);
                if(!empty($journalInfo['CROSSREF_ISSN'])) {
                    $xml->element('issn',array("media_type" => "print"),$journalInfo['CROSSREF_ISSN']);
                }
                if(!empty($journalInfo['CROSSREF_ISSN_ELECTRONIC'])) {
                    $xml->element(
                        'issn',
                        array("media_type" => "electronic"),
                        $journalInfo['CROSSREF_ISSN_ELECTRONIC']
                    );
                }
            $xml->elementEnd('journal_metadata');
            $xml->elementStart('journal_issue');
                if(!empty($journalInfo['CROSSREF_ISSN'])) {
                    $xml->elementStart('publication_date', array("media_type" => "print"));
                        $xml->element('year', null, $numberContent[0]['year']);
                    $xml->elementEnd('publication_date');
                }
                if(!empty($journalInfo['CROSSREF_ISSN_ELECTRONIC'])) {
                    $xml->elementStart('publication_date', array("media_type" => "online"));
                        $xml->element('year', null, $numberContent[0]['year']);
                    $xml->elementEnd('publication_date');
                }
                $volString = "";
                if ($vol_pos !== false) {
                    $volString = "-".substr($numberContent[0]['page_name'], $vol_pos+4);
                    $xml->elementStart('journal_volume');
                        $xml->element(
                            'volume',
                            null,
                            substr($numberContent[0]['page_name'], $vol_pos+4)
                        );
                    $xml->elementEnd('journal_volume');
                }
                $xml->element('issue',null,$issue);
            $xml->elementEnd('journal_issue');
            foreach($rows as $k=>$row)
            {
                switch($row['page_template'])
                {
                    case 'jarticle':

                        $xml->elementStart('journal_article', array("publication_type" => "full_text"));
                            $xml->elementStart('titles');
                                $xml->element('title',null,$row['name_en']);
                                $xml->element('original_language_title',null,$row['name']);
                            $xml->elementEnd('titles');
                            $xml->elementStart('contributors');
                                $people0=$mz->getAutorsEn($row['people']);
                                $peopleCounter = 1;
                                foreach($people0 as $people)
                                {
                                    if (!empty($people['id']))
                                    {
                                        if(substr($people['fio'],0,8)!='Редакция' &&
                                            substr($people['fio'],0,8)!=false)
                                        {
                                            $sequence = "additional";
                                            if($peopleCounter == 1) {
                                                $sequence = "first";
                                            }
                                            $xml->elementStart(
                                                'person_name',
                                                array('contributor_role' => 'author', 'sequence' => $sequence)
                                            );
                                                $xml->element(
                                                    'given_name',
                                                    null,
                                                    substr(
                                                        mb_stristr($people['fioshort'], " "),
                                                        1,
                                                        1
                                                    ) . "."
                                                );
                                                $xml->element(
                                                    'surname',
                                                    null,
                                                    mb_stristr($people['fioshort'], " ", true)
                                                );
                                            $xml->elementEnd('person_name');
                                        }
                                    }
                                    $peopleCounter++;
                                }
                            $xml->elementEnd('contributors');
                            if(!empty($journalInfo['CROSSREF_ISSN'])) {
                                $xml->elementStart('publication_date', array("media_type" => "print"));
                                $xml->element('year', null, $numberContent[0]['year']);
                                $xml->elementEnd('publication_date');
                            }
                            if(!empty($journalInfo['CROSSREF_ISSN_ELECTRONIC'])) {
                                $xml->elementStart('publication_date', array("media_type" => "online"));
                                $xml->element('year', null, $numberContent[0]['year']);
                                $xml->elementEnd('publication_date');
                            }
                            $articlePagesArray = explode("-",$row['pages']);
                            if(!empty($articlePagesArray[0]) && !empty($articlePagesArray[1])) {
                                $xml->elementStart('pages');
                                    $xml->element('first_page', null, $articlePagesArray[0]);
                                    $xml->element('last_page', null, $articlePagesArray[1]);
                                $xml->elementEnd('pages');
                            }
                            $xml->elementStart('doi_data');
                                $xml->element(
                                    'doi',
                                    null,
                                    "10.20542/".
                                    substr($journalInfo['CROSSREF_ISSN'],0,4).
                                    "-".
                                    substr($journalInfo['CROSSREF_ISSN'],5,4).
                                    "-".
                                    $numberContent[0]['year'].
                                    $volString.
                                    "-".
                                    $issue.
                                    "-".
                                    $row['pages']
                                );
                                $xml->element('resource', null, "https://www.imemo.ru/index.php?page_id=".$journalInfo["ARCHIVE_ID"]."&article_id=".$row['page_id']);
                            $xml->elementEnd('doi_data');
                        $xml->elementEnd('journal_article');
                        break;
                }
            }
        $xml->elementEnd('journal');
    $xml->elementEnd('body');
$xml->elementEnd('doi_batch');
$xml->endXML();

$xmlData = ob_get_clean();

//var_dump("тест");
var_dump($xmlData);

$url = "https://test.crossref.org/servlet/deposit";

$params = array(
    'login_id' => 'primakov',
    'login_passwd' => '14_prim',
    'fname' => $xmlData
);
$eol = "\r\n";
$data = '';

$mime_boundary=md5(time());

$data .= '--' . $mime_boundary . $eol;
$data .= 'Content-Disposition: form-data; name="login_id"' . $eol . $eol;
$data .= "primakov" . $eol;
$data .= '--' . $mime_boundary . $eol;
$data .= 'Content-Disposition: form-data; name="login_passwd"' . $eol . $eol;
$data .= "14_prim" . $eol;
$data .= '--' . $mime_boundary . $eol;
$data .= 'Content-Disposition: form-data; name="fname"; filename='.$doiBatchId.'.xml' . $eol;
$data .= 'Content-Type: text/xml' . $eol.$eol;
$data .= $xmlData . $eol;
$data .= "--" . $mime_boundary . "--" . $eol . $eol;

$para = array('http' => array(
    'method' => 'POST',
    'header' => 'Content-Type: multipart/form-data; boundary=' . $mime_boundary . $eol,
    'content' => $data
));
$context  = stream_context_create($para);
$result = file_get_contents($url, false, $context);
if ($result === FALSE) {
    echo "POST ERROR";
}

//$result = file_get_contents($url);

var_dump($result);