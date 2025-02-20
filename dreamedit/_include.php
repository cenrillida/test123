<?
/************************************************

ядро системы
1. подключаем все необходимые библиотеки
2. формируем глобальные массивы с данными настроек $_CONFIG (глобальные настройки системы + настройки активного модуля) и $_ACTIVE (динамические настройки: текущий модуль, прользовательский скин, выполняемое действие)
3. управление доступом к системе. распределение прав активного пользователя

************************************************/

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
include_once dirname(__FILE__)."/includes/Rest/class.Rest.php";
include_once dirname(__FILE__)."/includes/class.News.php";
include_once dirname(__FILE__)."/includes/class.FirstNewsElement.php";

// избавляемся от MagicQuotes
Dreamedit::removeMagicQuotes();

// если входим или выходим, то шаблоны не нужны
if(basename($_SERVER["PHP_SELF"]) == "login.php" || basename($_SERVER["PHP_SELF"]) == "logout.php")
	return;

// обновляем данные в сессии если она уже есть
if(isset($_SESSION[$_CONFIG["global"]["general"]["sess_name"]]))
	Dreamedit::updateSession($_SESSION[$_CONFIG["global"]["general"]["sess_name"]]["a_id"]);

// если пользователь не авторизован (или при обновлении сессии оказался удаленным/отключенным), перенаправляем на авторизацию
// или если браузер не поддерживается
if(!isset($_SESSION[$_CONFIG["global"]["general"]["sess_name"]]) || !checkUserAgent())
{
	// возможно не стоит привязываться к домену на котором стит админка!
	// тогда переходим на "/".$_CONFIG["global"]["paths"]["admin_dir"]."login.php"
	Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."login.php");
}


$_ACTIVE = array();

// устанавливем модуль по-умолчанию
$_ACTIVE["mod"] = $_CONFIG["global"]["general"]["default_mod"];

// если выбран модуль и доступ у пользователя есть, то переустанавливаем активный модуль
if(isset($_REQUEST["mod"]) && Permissions::checkModPermit($_SESSION[$_CONFIG["global"]["general"]["sess_name"]]["access"], $_REQUEST["mod"]))
	$_ACTIVE["mod"] = $_REQUEST["mod"];

// создаем дополнительную переменную mod_path - путь до модуля относительно DOCUMENT_ROOT
$_CONFIG["global"]["paths"]["mod_path"] = $_CONFIG["global"]["paths"]["mod_dir"].$_ACTIVE["mod"]."/";

// дополняем/изменяем action'ы в завистимости от настроек action'ов модуля (если он есть)
if(file_exists($_CONFIG["global"]["paths"]["admin_path"].$_CONFIG["global"]["paths"]["mod_path"]."_action.ini"))
{
	$modAction = Dreamedit::parseConfigIni($_CONFIG["global"]["paths"]["admin_path"].$_CONFIG["global"]["paths"]["mod_path"]."/_action.ini", ":");
	foreach($modAction as $act => $attr)
	{
		foreach($attr as $k => $v)
			$_CONFIG["action"][$act][$k] = $v;
	}
}

// устанавливаем действие по-умолчанию
$_ACTIVE["action"] = $_CONFIG["global"]["general"]["default_act"];

// если происходит action и доступ у пользователя есть, то переустанавливаем текущий action
if(isset($_REQUEST["action"]))
{
	// если нажата "специальная" кнопка - переводим на страницу имя_action'a.php
	if(isset($_CONFIG["action"][$_REQUEST["action"]]["special"]))
		Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"].$_REQUEST["action"].".php");

	// если есть действие и доступ к модулю разрешен и действие внутри модуля разрешено, то ставим действие активным
	if(isset($_REQUEST["action"]) && Permissions::checkModPermit($_SESSION[$_CONFIG["global"]["general"]["sess_name"]]["access"], $_REQUEST["mod"]) && Permissions::checkActionPermit($_SESSION[$_CONFIG["global"]["general"]["sess_name"]]["access"], $_REQUEST["mod"], $_REQUEST["action"]))
		$_ACTIVE["action"] = $_REQUEST["action"];
}


// берем конфиг активного модуля
$_CONFIG["module"] = Dreamedit::parseConfigIni($_CONFIG["global"]["paths"]["admin_path"].$_CONFIG["global"]["paths"]["mod_path"]."mod.ini", ":");

// устанавливаем внешний вид
$_ACTIVE["skin"] = $_CONFIG["global"]["general"]["default_skin"];
if(!empty($_SESSION[$_CONFIG["global"]["general"]["sess_name"]]["a_skin"]))
	$_ACTIVE["skin"] = $_SESSION[$_CONFIG["global"]["general"]["sess_name"]]["a_skin"];

// создаем дополнительную переменную skin_path - путь до skina'а относительно DOCUMENT_ROOT
$_CONFIG["global"]["paths"]["skin_path"] = $_CONFIG["global"]["paths"]["skin_dir"].$_ACTIVE["skin"]."/";

?>