<?php

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


global $DB;
//$DB->query("SET NAMES utf8");

$xmlStr = file_get_contents("https://doi.crossref.org/servlet/submissionDownload?usr=primakov&pwd=14_prim&file_name=1605275928-62dcdd8fc334eba3c077a090000a79a1.xml&type=result");
$xml = new SimpleXMLElement($xmlStr);
$jsonXml = json_encode($xml);
$arrayXml = json_decode($jsonXml,TRUE);


if(!empty($arrayXml['record_diagnostic'])) {
    var_dump($arrayXml['submission_id']);
}