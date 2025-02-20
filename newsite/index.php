<?php

//подключаем счетчи?для google - закомментрирован?до выяснен? ситуации
//include_once("analyticstracking.php");

// бере?конфиг систем?если конфиг не найден - выходи?
$_CONFIG["global"] = @parse_ini_file(dirname(__FILE__)."/../dreamedit/_config.ini", true);
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
// подключаем клас?- шаблонизатор
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.Templater.php";
// подключаем клас?для работы со страницами
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.Pages.php";
// подключаем клас?для работы ?инфолентам?
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.Ilines.php";
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
//Для работы ?подразделениями (найт?цент? список подчиненны????)
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.Podr.php";
//Для работы со списками гранто?
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.Nirs.php";

// подключаем клас?для работы ?заголовкам?главно?страницы
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.Headers.php";
// подключаем клас?для работы ?заголовкам?главно?страницы
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/bib.php";
// подключаем клас?для работы ?заголовкам?главно?страницы
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.Magazine.php";

include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.Statistic.php";

$_CONFIG["new_prefix"] = "/newsite";



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

$domainRow['dmn_name'] = "www.imemo.ru/newsite";
$domainRow['dmn_list'] = "www.imemo.ru/newsite";

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
if(strpos($_SERVER["REDIRECT_URL"],"/en") !== false || $_SESSION[lang]=="/en")
	$lang_prefix = "/en";

$_SESSION[lang] = $lang_prefix;

$eng_stat = "";
if($_SESSION[lang]=="/en")
    $eng_stat = "-en";

Statistic::theCounter("all-web-site".$eng_stat);

$jour_prefix = "";
if(strpos($_SERVER["REDIRECT_URL"],"/jour") !== false || $_SESSION[jour]=="/jour")
	$jour_prefix = "/jour";
if(strpos($_SERVER["REDIRECT_URL"],"/jour_cut") !== false || $_SESSION[jour]=="/jour_cut")
	$jour_prefix = "/jour_cut";
$_SESSION[jour] = $jour_prefix;
//if (!empty($_SESSION[jour]) && !empty($_REQUEST[jrid])) $_SESSION[jour_id]=$_REQUEST[jrid];
if ($_SESSION[jour]=='/jour')
{
 
  global $DB;
  $_SERVER["REDIRECT_URL"]=$DB->cleanuserinput($_SERVER["REDIRECT_URL"]);
  $a1=explode("/jour",$_SERVER["REDIRECT_URL"]);
  $a2=explode("/",$a1[1]);
  $_SESSION[jour_url]=$a2[1];
  $aa=$DB->select("SELECT m.page_id,p.page_id AS id,m.page_menuname AS menuname,m.page_menuname_en  AS menuname_en,m.issn  
				FROM  adm_magazine AS m ".
                 " INNER JOIN adm_pages_content AS p ON p.cv_name='itype_jour' AND p.cv_text= m.page_id ".
				 " INNER JOIN adm_pages AS pp ON pp.page_id=p.page_id AND pp.page_template='magazine' ".
				" WHERE m.page_journame='".$a2[1]."'"
  );
// print_r($aa); 
  $_SESSION[jour_id]=$aa[0][page_id];
  if (empty($_REQUEST[page_id])) $_REQUEST[page_id]=$aa[0][id];
  $_SESSION[jour_menuname]=$aa[0][menuname];
  $_SESSION[jour_issn]=$aa[0][issn];
  if ($_SESSION[lang]=='/en') $_SESSION[jour_menuname]=$aa[0][menuname_en];
  Statistic::theCounter($_SESSION[jour_url].$eng_stat);
}
if ($_SESSION[jour]=='/jour_cut')
{
 
  global $DB;
  $_SERVER["REDIRECT_URL"]=$DB->cleanuserinput($_SERVER["REDIRECT_URL"]);
  $a1=explode("/jour_cut",$_SERVER["REDIRECT_URL"]);
  $a2=explode("/",$a1[1]);
  $_SESSION[jour_url]=$a2[1];
  $aa=$DB->select("SELECT m.page_id,p.page_id AS id,m.page_menuname AS menuname,m.page_menuname_en  AS menuname_en,m.issn  
				FROM  adm_magazine AS m ".
                 " INNER JOIN adm_pages_content AS p ON p.cv_name='itype_jour' AND p.cv_text= m.page_id ".
				 " INNER JOIN adm_pages AS pp ON pp.page_id=p.page_id AND pp.page_template='magazine' ".
				" WHERE m.page_journame='".$a2[1]."'"
  );
// print_r($aa); 
  $_SESSION[jour_id]=$aa[0][page_id];
  if (empty($_REQUEST[page_id])) $_REQUEST[page_id]=$aa[0][id];
  $_SESSION[jour_menuname]=$aa[0][menuname];
  $_SESSION[jour_issn]=$aa[0][issn];
  if ($_SESSION[lang]=='/en') $_SESSION[jour_menuname]=$aa[0][menuname_en];
    Statistic::theCounter($_SESSION[jour_url].$eng_stat);
}
//echo '<a href="aaa" style="display: none;">'.$_REQUEST["page_id"].'</a>';


$pg = new Pages();

// находи?ID запрашиваемо?страницы
if(isset($_REQUEST["page_id"]))
{
	$page_res = $pg->getPageById($_REQUEST["page_id"]);
//echo "<br />___".$_SESSION;
	// если ID переда?проверяем на доступност?
	if(isset($page_res["page_status"]) && $page_res["page_status"])
	{
		// если ?страницы есть urlname то делаем редирект на него (включаем вс?переданные гето?переменные)
		if(!empty($page_res["page_urlname"]))
		{
			// убирае?из строки QUERY_STRING упоминание ?page_id
			$qStr = preg_replace("/page_id=".(int)$_REQUEST["page_id"]."&?/", "", $_SERVER["QUERY_STRING"]);
			Dreamedit::sendHeaderByCode(301);
			// нужн?подставлять протокол!!!
if ($_SESSION[lang]=="/en")
    Dreamedit::sendLocationHeader("https://".$_SERVER["SERVER_NAME"].$_CONFIG['new_prefix']."/en/".$page_res["page_urlname"].(!empty($qStr)? "?".$qStr: ""));
else			
			Dreamedit::sendLocationHeader("https://".$_SERVER["SERVER_NAME"].$_CONFIG['new_prefix']."/".$page_res["page_urlname"].(!empty($qStr)? "?".$qStr: ""));
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
	// парсим uri
	$uri = explode("?", $_SERVER["REQUEST_URI"]);
	$page_urlname = substr($uri[0], 1, strlen($uri[0]));

	// пробуе?найт?по urlname'?
	if(!empty($page_urlname))
	{
        if($_CONFIG["new_prefix"] == "/newsite")
            $page_urlname = str_replace("newsite/","",$page_urlname);

		if(!empty($lang_prefix))
		$page_urlname = str_replace("en/","",$page_urlname);
		if(!empty($jour_prefix))
		{
			if($jour_prefix=="/jour")
				$page_urlname = str_replace("jour/","",$page_urlname);
			if($jour_prefix=="/jour_cut")
				$page_urlname = str_replace("jour_cut/","",$page_urlname);
		}

		$page_res = $pg->getPageByUrl($page_urlname, 1);
		$_REQUEST["page_id"] = (int)@$page_res["page_id"];
		$pg->registHiddenVariables($_REQUEST["page_id"], $page_urlname);
		
	
	}
	else
	{
		$_REQUEST["page_id"] = $pg->getRootPageId(); // если urlname пуст - показываем главну?
		if(!empty($domainRow["dmn_index"]))
			$_REQUEST["page_id"] = $domainRow["dmn_index"];	// если указан?страница, то показываем её
	}
	
	
}

// обрабатываем 404
if($_REQUEST["page_id"] == 0)
{
	Dreamedit::sendHeaderByCode(404);
	// если не установлен?страница "не найден? то дальше ничего не делаем
	if(empty($domainRow["dmn_error"]))
		exit;

	$_REQUEST["page_id"] = (int)$domainRow["dmn_error"];
}

// получаем аттрибут?требуемо?страницы
$page_attr = $pg->getPageById($_REQUEST["page_id"]);

// если не зада?шаблон, то "страница не найден?
if(empty($page_attr["page_template"]) && empty($page_attr["page_link"]))
{
	Dreamedit::sendHeaderByCode(404);
	exit;
}

// получаем ID контента страницы (?случае ссылки)
$pageContentId = $_REQUEST["page_id"];
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
		Dreamedit::sendLocationHeader($page_attr["page_link"]); // инач?просто редирект на указанну?ссылку
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

foreach($postFilters as $postFilterData)
{
	
	if(file_exists($_CONFIG["global"]["paths"]["admin_path"].$_CONFIG["global"]["paths"]["filters"].$postFilterData["filter_filename"]))
	{
		if($jour_prefix=="/jour_cut")
		{
			if(file_exists($_CONFIG["global"]["paths"]["admin_path"].$_CONFIG["global"]["paths"]["filters"]."mag_cut_".$postFilterData["filter_filename"]))
			{
				ob_start();
				include $_CONFIG["global"]["paths"]["admin_path"].$_CONFIG["global"]["paths"]["filters"]."mag_cut_".$postFilterData["filter_filename"];
				$page_content[strtoupper($postFilterData["filter_placeholder"])] = ob_get_contents();
				ob_end_clean();
				continue;
			}
		}
			ob_start();
			include $_CONFIG["global"]["paths"]["admin_path"].$_CONFIG["global"]["paths"]["filters"].$postFilterData["filter_filename"];
			$page_content[strtoupper($postFilterData["filter_placeholder"])] = ob_get_contents();

			ob_end_clean();
	}
}

// заполняем шаблон контенто?
$site_templater->setValues($page_content);

//if($jour_prefix=="/jour_cut")
//	print_r($page_content);

//Другие данные в фильтрах

//выводи?страницу
if($jour_prefix=="/jour_cut")
	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."mag_cut_".$page_attr["page_template"].".html");
else
	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"].$page_attr["page_template"].".html");
?>
