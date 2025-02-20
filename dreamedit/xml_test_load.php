<?php

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
//$DB->query("SET NAMES utf8");

$xmlStr = file_get_contents("https://doi.crossref.org/servlet/submissionDownload?usr=primakov&pwd=14_prim&file_name=1605275928-62dcdd8fc334eba3c077a090000a79a1.xml&type=result");
$xml = new SimpleXMLElement($xmlStr);
$jsonXml = json_encode($xml);
$arrayXml = json_decode($jsonXml,TRUE);


if(!empty($arrayXml['record_diagnostic'])) {
    var_dump($arrayXml['submission_id']);
}