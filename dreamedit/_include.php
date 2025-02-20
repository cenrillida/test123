<?
/************************************************

���� �������
1. ���������� ��� ����������� ����������
2. ��������� ���������� ������� � ������� �������� $_CONFIG (���������� ��������� ������� + ��������� ��������� ������) � $_ACTIVE (������������ ���������: ������� ������, ����������������� ����, ����������� ��������)
3. ���������� �������� � �������. ������������� ���� ��������� ������������

************************************************/

session_start();


$_CONFIG = array();

// ����� ������ ������� ���� ������ �� ������ - �������
$_CONFIG["global"] = @parse_ini_file(dirname(__FILE__)."/_config.ini", true);
if(empty($_CONFIG["global"]))
	die("���� ������������ ������� �� ������");
// ������� �������������� ���������� admin_path - ������ ���� �� ���������� � �������� �����������������
$_CONFIG["global"]["paths"]["admin_path"] = $_SERVER["DOCUMENT_ROOT"]."/".$_CONFIG["global"]["paths"]["admin_dir"];
$_CONFIG["global"]["paths"]["template_path"] = $_SERVER["DOCUMENT_ROOT"]."/".$_CONFIG["global"]["paths"]["templates"];

// ����� action'� ���� ������ �� ������ - �������
$_CONFIG["action"] = @parse_ini_file(dirname(__FILE__)."/_action.ini", true);
if(empty($_CONFIG["global"]))
	die("���� ������������ ������ �������� �� ������");


// ���������� ��������� �������
include_once dirname(__FILE__)."/includes/headers.php";
// ���������� ���� ���������� � �����
include_once dirname(__FILE__)."/includes/connect.php";
// ����������� ��������������� ��������
include_once dirname(__FILE__)."/includes/browser_detect.php";
// ���������� ����������
include_once dirname(__FILE__)."/includes/gettext.php";
// ���������� PHP-������ fckeditor'� � ���������� BasePath;
//include_once dirname(__FILE__)."/includes/FCKEditor/fckeditor.php";
// ���������� ������� ��� ��������� xml;
include_once dirname(__FILE__)."/includes/dom.php";

// ������
// ���������� ����� ������������� ����
include_once dirname(__FILE__)."/includes/phorm/phorm.mod.class.php";
// ���������� ��������� ����� ��� ������ ����
include_once dirname(__FILE__)."/includes/class.Dreamedit.php";
// ���������� ����� ��� ������ � ������� �������
include_once dirname(__FILE__)."/includes/class.Permissions.php";
// ���������� ����� - ������������
include_once dirname(__FILE__)."/includes/class.Templater.php";
// ���������� ����� ��� �������� ����������� action'��
include_once dirname(__FILE__)."/includes/class.actionCheck.php";
// ���������� ����� ��� ������ �� ����������
include_once dirname(__FILE__)."/includes/class.Pages.php";
// ���������� ����� ��� ������ � ���������
include_once dirname(__FILE__)."/includes/class.Persons.php";
// ���������� ����� ��� ������ � �����������
include_once dirname(__FILE__)."/includes/class.Ilines.php";
include_once dirname(__FILE__)."/includes/class.Directories.php";

include_once dirname(__FILE__)."/includes/class.Headers.php";
include_once dirname(__FILE__)."/includes/class.Polls.php";
include_once dirname(__FILE__)."/includes/class.Binding.php";
include_once dirname(__FILE__)."/includes/class.Blogs.php";
//��������� ������� ���������
include_once dirname(__FILE__)."/includes/class.Events.php";
// ���������� ����� ��� ������ � �������������
include_once dirname(__FILE__)."/includes/class.Imager.php";
// ���������� ����� ��� ������ � js �������
include_once dirname(__FILE__)."/includes/class.WriteTree.php";
// ���������� ����� ��� ������ c� ���������� ��-���
include_once dirname(__FILE__)."/includes/class.Pagination.php";
// ���������� ����� ��� ������ ��������
include_once dirname(__FILE__)."/includes/class.Nirs.php";
//��� ������ � ���������
include_once dirname(__FILE__)."/includes/class.ROSPersons.php";
//��� ������ � �������� ������
include_once dirname(__FILE__)."/includes/class.Helper.php";
//��� �����������
include_once dirname(__FILE__)."/includes/class.Tenders.php";
//��� ������ � ������������
include_once dirname(__FILE__)."/includes/class.Publications.php";
//��� ������ � ZOTERO
include_once dirname(__FILE__)."/includes/bib.php";
//��� ������ � ���������
include_once dirname(__FILE__)."/includes/class.Magazine.php";
include_once dirname(__FILE__)."/includes/class.MagazineNew.php";
//��� ������ �� ������ � ��������
include_once dirname(__FILE__)."/includes/class.Article.php";
//��� ������������ XML ��� elibrary
include_once dirname(__FILE__)."/includes/class.XMLWriter.php";

include_once dirname(__FILE__)."/includes/class.Statistic.php";

include_once dirname(__FILE__)."/includes/class.CacheEngine.php";
include_once dirname(__FILE__)."/includes/Rest/class.Rest.php";
include_once dirname(__FILE__)."/includes/class.News.php";
include_once dirname(__FILE__)."/includes/class.FirstNewsElement.php";

// ����������� �� MagicQuotes
Dreamedit::removeMagicQuotes();

// ���� ������ ��� �������, �� ������� �� �����
if(basename($_SERVER["PHP_SELF"]) == "login.php" || basename($_SERVER["PHP_SELF"]) == "logout.php")
	return;

// ��������� ������ � ������ ���� ��� ��� ����
if(isset($_SESSION[$_CONFIG["global"]["general"]["sess_name"]]))
	Dreamedit::updateSession($_SESSION[$_CONFIG["global"]["general"]["sess_name"]]["a_id"]);

// ���� ������������ �� ����������� (��� ��� ���������� ������ �������� ���������/�����������), �������������� �� �����������
// ��� ���� ������� �� ��������������
if(!isset($_SESSION[$_CONFIG["global"]["general"]["sess_name"]]) || !checkUserAgent())
{
	// �������� �� ����� ������������� � ������ �� ������� ���� �������!
	// ����� ��������� �� "/".$_CONFIG["global"]["paths"]["admin_dir"]."login.php"
	Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."login.php");
}


$_ACTIVE = array();

// ������������ ������ ��-���������
$_ACTIVE["mod"] = $_CONFIG["global"]["general"]["default_mod"];

// ���� ������ ������ � ������ � ������������ ����, �� ����������������� �������� ������
if(isset($_REQUEST["mod"]) && Permissions::checkModPermit($_SESSION[$_CONFIG["global"]["general"]["sess_name"]]["access"], $_REQUEST["mod"]))
	$_ACTIVE["mod"] = $_REQUEST["mod"];

// ������� �������������� ���������� mod_path - ���� �� ������ ������������ DOCUMENT_ROOT
$_CONFIG["global"]["paths"]["mod_path"] = $_CONFIG["global"]["paths"]["mod_dir"].$_ACTIVE["mod"]."/";

// ���������/�������� action'� � ������������ �� �������� action'�� ������ (���� �� ����)
if(file_exists($_CONFIG["global"]["paths"]["admin_path"].$_CONFIG["global"]["paths"]["mod_path"]."_action.ini"))
{
	$modAction = Dreamedit::parseConfigIni($_CONFIG["global"]["paths"]["admin_path"].$_CONFIG["global"]["paths"]["mod_path"]."/_action.ini", ":");
	foreach($modAction as $act => $attr)
	{
		foreach($attr as $k => $v)
			$_CONFIG["action"][$act][$k] = $v;
	}
}

// ������������� �������� ��-���������
$_ACTIVE["action"] = $_CONFIG["global"]["general"]["default_act"];

// ���� ���������� action � ������ � ������������ ����, �� ����������������� ������� action
if(isset($_REQUEST["action"]))
{
	// ���� ������ "�����������" ������ - ��������� �� �������� ���_action'a.php
	if(isset($_CONFIG["action"][$_REQUEST["action"]]["special"]))
		Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"].$_REQUEST["action"].".php");

	// ���� ���� �������� � ������ � ������ �������� � �������� ������ ������ ���������, �� ������ �������� ��������
	if(isset($_REQUEST["action"]) && Permissions::checkModPermit($_SESSION[$_CONFIG["global"]["general"]["sess_name"]]["access"], $_REQUEST["mod"]) && Permissions::checkActionPermit($_SESSION[$_CONFIG["global"]["general"]["sess_name"]]["access"], $_REQUEST["mod"], $_REQUEST["action"]))
		$_ACTIVE["action"] = $_REQUEST["action"];
}


// ����� ������ ��������� ������
$_CONFIG["module"] = Dreamedit::parseConfigIni($_CONFIG["global"]["paths"]["admin_path"].$_CONFIG["global"]["paths"]["mod_path"]."mod.ini", ":");

// ������������� ������� ���
$_ACTIVE["skin"] = $_CONFIG["global"]["general"]["default_skin"];
if(!empty($_SESSION[$_CONFIG["global"]["general"]["sess_name"]]["a_skin"]))
	$_ACTIVE["skin"] = $_SESSION[$_CONFIG["global"]["general"]["sess_name"]]["a_skin"];

// ������� �������������� ���������� skin_path - ���� �� skina'� ������������ DOCUMENT_ROOT
$_CONFIG["global"]["paths"]["skin_path"] = $_CONFIG["global"]["paths"]["skin_dir"].$_ACTIVE["skin"]."/";

?>