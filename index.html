<?php

//подключаем счетчи?для google - закомментрирован?до выяснен? ситуации
//include_once("analyticstracking.php");

// бере?конфиг систем?если конфиг не найден - выходи?
$_CONFIG["global"] = @parse_ini_file(dirname(__FILE__)."/dreamedit/_config.ini", true);
if(empty($_CONFIG["global"]))
	die("Config is not found!");
// создае?дополнительную переменную admin_path - полный путь до директории ?системой администрирования
$_CONFIG["global"]["paths"]["admin_path"] = $_SERVER["DOCUMENT_ROOT"]."/".$_CONFIG["global"]["paths"]["admin_dir"];
$_CONFIG["global"]["paths"]["template_path"] = $_SERVER["DOCUMENT_ROOT"]."/".$_CONFIG["global"]["paths"]["templates"];


// подключаем заголовк?страни?
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/headers.php";
// подключаем файл соединен? ?базо?
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/connect.php";
// подключаем файл соединен? ?базо?
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/site.fns.php";

 
// классы
// подключаем статичны?клас?для работы ядр?
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.Dreamedit.php";
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.Permissions.php";
// подключаем клас?- шаблонизатор
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.Templater.php";
// подключаем клас?для работы со страницами
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.Pages.php";
// подключаем клас?для работы ?инфолентам?
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.Ilines.php";
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.FirstNewsElement.php";
// подключаем клас?для работы ?изображениями
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.Directories.php";
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.Binding.php";
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.Imager.php";
// подключаем клас?для работы c?страницами эл-то?
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.Pagination.php";
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.Persons.php";
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.Publications.php";
// подключаем клас для работы ?календарем
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.Events.php";
// подключаем клас для получения списка публикаций ?журналах
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.Magazines.php";
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.Article.php";
//Для работы ?подразделениями (найт?цент? список подчиненны????)
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.Podr.php";
//Для работы со списками гранто?
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.Nirs.php";

include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.ModalWindow.php";

// подключаем клас?для работы ?заголовкам?главно?страницы
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.Headers.php";
// подключаем клас?для работы ?заголовкам?главно?страницы
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/bib.php";
// подключаем клас?для работы ?заголовкам?главно?страницы
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.Magazine.php";
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.MagazineNew.php";
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.DhtmlxBuilder.php";

include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.DocumentTemplater.php";
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.Statistic.php";
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.News.php";
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/Rest/class.Rest.php";
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.Videogallery.php";
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.CacheEngine.php";
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.CerSpecrub.php";
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.UriParser.php";
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.ArticleSendBuilder.php";
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.MailSend.php";
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.UUID.php";
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.FormBuilder.php";
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.DownloadService.php";
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.OnSiteAdmin.php";
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.MagazineRelocator.php";
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/TelegramBot/Autoloader.php";
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/NotificationService.php";
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/SwiperSliderBuilder.php";
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/AuthorBuilder.php";
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/AccordionBuilder.php";
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/TextProcessor.php";
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/CollapsedBuilder.php";
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/ComboboxBuilder.php";
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/PwJournalParser.php";

error_reporting(0);

// избавляем? от MagicQuotes
Dreamedit::removeMagicQuotes();

// обрабатываем настройк?домена
$domain = $DB->select("SELECT * FROM ?_domain");
$domainRow = array();
foreach($domain as $value)
{
	// находи?нужный доме?
	$dmn = explode("\n", $value["dmn_list"]);
	if(in_array($_SERVER["SERVER_NAME"], $dmn))
		$domainRow = $value;
}

// если доме?не определе? то выдаём 404
if(empty($domainRow))
{
	Dreamedit::sendHeaderByCode(404);
	exit;
}

// если установлен редирект, то переходи?по нему
if(!empty($domainRow["dmn_redirect"]))
{
	// возвращаем хэде?301 (страница перемещена) ?пото?редирект
	Dreamedit::sendHeaderByCode(301);
	Dreamedit::sendLocationHeader(preg_match("/^https\:\/\//i", $domainRow["dmn_redirect"])? $domainRow["dmn_redirect"]: "https://".$domainRow["dmn_redirect"].$_SERVER["REQUEST_URI"]);
}
$lang_prefix = "";
if(strlen($_SERVER["REDIRECT_URL"])>3) {
	if (substr($_SERVER["REDIRECT_URL"], 0, 4) == "/en/" || $_SESSION["lang"] == "/en")
		$lang_prefix = "/en";
} else {
	if ($_SERVER["REDIRECT_URL"] == "/en" || $_SESSION["lang"] == "/en")
		$lang_prefix = "/en";
}



$_SESSION["lang"] = $lang_prefix;

$eng_stat = "";
if($_SESSION["lang"]=="/en")
    $eng_stat = "-en";

//Statistic::theCounter("all-web-site".$eng_stat);

$jour_prefix = "";
if(substr($_SERVER["REDIRECT_URL"],0,6) == '/jour/' || substr($_SERVER["REDIRECT_URL"],0,9) == '/en/jour/' || $_SESSION["jour"]=="/jour")
	$jour_prefix = "/jour";
$_SESSION["jour"] = $jour_prefix;
session_start();

$_SESSION["lang"] = $lang_prefix;
$_SESSION["jour"] = $jour_prefix;
$_SESSION["jour_id"] = "";
$_SESSION["jour_menuname"] = "";
$_SESSION["jour_issn"] = "";
$_SESSION["jour_url"] = "";
$_SESSION["menuname_en"] = "";
//if (!empty($_SESSION[jour]) && !empty($_REQUEST[jrid])) $_SESSION[jour_id]=$_REQUEST[jrid];
if ($_SESSION["jour"]=='/jour')
{

 
  global $DB;
  $_SERVER["REDIRECT_URL"]=$DB->cleanuserinput($_SERVER["REDIRECT_URL"]);
  $a1=explode("/jour",$_SERVER["REDIRECT_URL"]);
  $a2=explode("/",$a1[1]);
  $_SESSION["jour_url"]=$a2[1];
  $aa=$DB->select("SELECT m.page_id,p.page_id AS id,m.page_menuname AS menuname,m.page_menuname_en  AS menuname_en,m.issn, m.page_link 
				FROM  adm_magazine AS m ".
                 " INNER JOIN adm_pages_content AS p ON p.cv_name='itype_jour' AND p.cv_text= m.page_id ".
				 " INNER JOIN adm_pages AS pp ON pp.page_id=p.page_id AND pp.page_template='magazine' ".
				" WHERE m.page_journame=?", $a2[1]
  );

// print_r($aa); 
  $_SESSION["jour_id"]=$aa[0]["page_id"];
  if (empty($_REQUEST["page_id"])) $_REQUEST["page_id"]=$aa[0]["id"];
  $_SESSION["jour_menuname"]=$aa[0]["menuname"];
  $_SESSION["jour_issn"]=$aa[0]["issn"];
  if ($_SESSION["lang"]=='/en') $_SESSION["jour_menuname"]=$aa[0]["menuname_en"];
  //Statistic::theCounter($_SESSION[jour_url].$eng_stat);
}

$pg = new Pages();

// находи?ID запрашиваемо?страницы
if(isset($_REQUEST["page_id"]))
{
	$page_res = $pg->getPageById($_REQUEST["page_id"]);

//echo "<br />___".$_SESSION;

	// если ID переда?проверяем на доступност?
	if(($_SESSION["lang"]!="/en" && isset($page_res["page_status"]) && $page_res["page_status"]) || ($_SESSION["lang"]=="/en" && isset($page_res["page_status_en"]) && $page_res["page_status_en"]))
	{
		// если ?страницы есть urlname то делаем редирект на него (включаем вс?переданные гето?переменные)
		if(!empty($page_res["page_urlname"]))
		{

			$qStr = str_replace('&amp;','&', $_SERVER["QUERY_STRING"]);
			// убирае?из строки QUERY_STRING упоминание ?page_id
			$qStr = preg_replace("/page_id=".(int)$_REQUEST["page_id"]."&?/", "", $qStr);
			Dreamedit::sendHeaderByCode(301);
			// нужн?подставлять протокол!!!

			if (($_SERVER['SERVER_NAME'] == 'pwjournal.ru' || $_SERVER['SERVER_NAME'] == 'www.pwjournal.ru')) {
				if(substr($page_res["page_urlname"],0,10)=='pwjournal/') {
					$page_res["page_urlname"] = substr($page_res["page_urlname"],10);
				} elseif(substr($page_res["page_urlname"],0,9)=='pwjournal') {
					$page_res["page_urlname"] = substr($page_res["page_urlname"],9);
				}
			}


if ($_SESSION["lang"]=="/en")
    Dreamedit::sendLocationHeader("https://".$_SERVER["SERVER_NAME"]."/en/".$page_res["page_urlname"].(!empty($qStr)? "?".$qStr: ""));
else			
			Dreamedit::sendLocationHeader("https://".$_SERVER["SERVER_NAME"]."/".$page_res["page_urlname"].(!empty($qStr)? "?".$qStr: ""));
//			Dreamedit::sendLocationHeader("http://".$_SERVER["SERVER_NAME"].$pg->getPageUrl($_REQUEST["page_id"], $_GET));


		}
		else
		{
			// инач?инициируем ID страницы
			$_REQUEST["page_id"] = (int)$_REQUEST["page_id"];
		}
	}
	else
	{
		// если страница недоступна ставим ее ?0
		$_REQUEST["page_id"] = 0;
	}
}
else
{

	$uriParser = new UriParser($pg);

	$pageId = $uriParser->parseUri();

	if($pageId!=-1) {
		$_REQUEST["page_id"] = $pageId;
	} else {
		$_REQUEST["page_id"] = $pg->getRootPageId(); // если urlname пуст - показываем главну?

		if(!empty($domainRow["dmn_index"]))
			$_REQUEST["page_id"] = $domainRow["dmn_index"];	// если указан?страница, то показываем её
	}
	
}

$pwJournalParser = new PwJournalParser($pg);
$pwJournalParser->tryLoadPwJournal();

// обрабатываем 404
if($_REQUEST["page_id"] == 0)
{



	// если не установлен?страница "не найден? то дальше ничего не делаем
	if(empty($domainRow["dmn_error"])) {
		Dreamedit::sendHeaderByCode(404);
		exit;
	} else {
		Dreamedit::sendHeaderByCode(301);
		if ($_SESSION["lang"] == "/en")
			Dreamedit::sendLocationHeader("https://" . $_SERVER["SERVER_NAME"] . "/en//index.php?page_id=".$domainRow["dmn_error"]);
		else
			Dreamedit::sendLocationHeader("https://" . $_SERVER["SERVER_NAME"] . "/index.php?page_id=".$domainRow["dmn_error"]);

	}
	$_REQUEST["page_id"] = (int)$domainRow["dmn_error"];
}

// получаем аттрибут?требуемо?страницы
$page_attr = $pg->getPageById($_REQUEST["page_id"]);

// если не зада?шаблон, то "страница не найден?
if(empty($page_attr["page_template"]) && empty($page_attr["page_link"]))
{
	if(empty($domainRow["dmn_error"])) {
		Dreamedit::sendHeaderByCode(404);
		exit;
	} else {
		Dreamedit::sendHeaderByCode(301);
		if ($_SESSION["lang"] == "/en")
			Dreamedit::sendLocationHeader("https://" . $_SERVER["SERVER_NAME"] . "/en/index.php?page_id=".$domainRow["dmn_error"]);
		else
			Dreamedit::sendLocationHeader("https://" . $_SERVER["SERVER_NAME"] . "/index.php?page_id=".$domainRow["dmn_error"]);

	}
	$_REQUEST["page_id"] = (int)$domainRow["dmn_error"];
}

if($_REQUEST["page_id"] == (int)$domainRow["dmn_error"]) {
	Dreamedit::sendHeaderByCode(404);
}

if($_SESSION["on_site_edit"]==1 && isset($_SESSION["admin"]) && !empty($_POST['htmlData']) && !empty($_POST['page_edit_id']) && !empty($_POST['mode'])) {
	$onSiteAdmin = new OnSiteAdmin();
	$onSiteAdmin->saveContent();
	exit;
}

$magazineRelocator = new MagazineRelocator();

$magazineRelocator->checkAndRelocateWithPageAttr($_REQUEST['page_id'], $page_attr);

$cacheEngine = CacheEngine::getInstance();
$cacheNotExclude = $cacheEngine->checkExclude();

if($_SERVER['SERVER_NAME'] == 'pwjournal.ru' || $_SERVER['SERVER_NAME'] == 'www.pwjournal.ru') {
	if($_REQUEST['page_id'] == $domainRow["dmn_index"]) {
		$cacheNotExclude = false;
	}
}

if($cacheNotExclude) {
	$cacheEngine->tryLoadPage();
}

// получаем ID контента страницы (?случае ссылки)
$pageContentId = $_REQUEST["page_id"];

if($_SESSION["jour"]=="/jour" && empty($aa)) {
	$aa = $DB->select("SELECT m.page_link, m.page_link_en  
				FROM  adm_magazine AS m ".
		" WHERE m.page_journame='".$a2[1]."'");
	if(!empty($aa[0]["page_link"])) {
		$page_attr["page_link"] = $aa[0]["page_link"];
	}
	if(!empty($aa[0]["page_link_en"])) {
		$page_attr["page_link_en"] = $aa[0]["page_link_en"];
	}

}

if(!empty($page_attr["page_link"]))
{
	if(is_numeric($page_attr["page_link"]))
	{
		$pageContentId = (int)$page_attr["page_link"];	// если выбранная страница - ссылка, то проверяем на чт??производим нужное действие

		// если не зада?шаблон ?ссылки, то бере?шаблон мастер-страницы
		if(empty($page_attr["page_template"]))
		{
			$linked_attr = $pg->getPageById($pageContentId);
			$page_attr["page_template"] = $linked_attr["page_template"];
		}
	}
	else
	{
		if($_SESSION["lang"]=="/en" && !empty($page_attr["page_link_en"])) {
			Dreamedit::sendLocationHeader($page_attr["page_link_en"]);
		} else {
			Dreamedit::sendLocationHeader($page_attr["page_link"]); // инач?просто редирект на указанну?ссылку
		}
	}
}

$site_templater = new Templater();

// вытаскивае?всех родителе?вместе ?контенто?
$content = $pg->appendContent($pg->getParents($pageContentId));

// заполняем шаблон текуще?страницы начиная от самого верхнего родите? ?перезаписыванием переоб?вленны?переменных
$page_content = array();
foreach($content as $pid => $v)
{
	// если ?родите? не?контента (не выбран шаблон) то пропускаем
	if(empty($v["content"]) || empty($v["page_template"]))
		continue;
////////////////
	// готови?массив замены переменных
	foreach($v["content"] as $cvName => $cvText)
		$page_content[$cvName] = $cvText;
}

// активируем вс?постфильтр?
$postFilters = $DB->select("SELECT * FROM ?_filters WHERE piar_filter=0 ORDER BY filter_sort ASC");

//print_r($postFilters);

foreach ($postFilters as $postFilterData) {

	if (file_exists($_CONFIG["global"]["paths"]["admin_path"] . $_CONFIG["global"]["paths"]["filters"] . $postFilterData["filter_filename"])) {
		//var_dump( $_CONFIG["global"]["paths"]["filters"] . $postFilterData["filter_filename"]);
		$page_content[strtoupper($postFilterData["filter_placeholder"])] = $_CONFIG["global"]["paths"]["admin_path"] . $_CONFIG["global"]["paths"]["filters"] . $postFilterData["filter_filename"];
	}
}

if ($_SESSION["lang"]=='/en')
{
	$_REQUEST["en"]=true;
}

$site_templater->setValues($page_content);

$_REQUEST['lang'] = $_SESSION['lang'];

if($cacheNotExclude) {
	$cacheEngine->saveAndLoadPage();
} else {
//выводим страницу
	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . $page_attr["page_template"] . ".html");
}
?>
