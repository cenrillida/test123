<?
global $_CONFIG, $DB_AFJOURNAL;
// ��������� ������
require_once dirname(__FILE__)."/DbSimple/config.php";
## ����������� � ��.
require_once dirname(__FILE__)."/DbSimple/Generic.php";

// ������������ � ��.
$DB_AFJOURNAL = DbSimple_Generic::connect($_CONFIG["global"]["db_connect_afjournal"]["db_type"] . "://" . $_CONFIG["global"]["db_connect_afjournal"]["login"] . ":" . $_CONFIG["global"]["db_connect_afjournal"]["password"] . "@" . $_CONFIG["global"]["db_connect_afjournal"]["host"] . "/" . $_CONFIG["global"]["db_connect_afjournal"]["db_name"]);

// ������������� ���������� ������.
$DB_AFJOURNAL->setErrorHandler('databaseErrorHandler');
// ������������� ���������� �����.
$DB_AFJOURNAL->setLogger('databaseQueryLogger');

// �������� ����� ����������.
$DB_AFJOURNAL->transaction();
$DB_AFJOURNAL->setIdentPrefix($_CONFIG["global"]["db_connect_afjournal"]["tbl_prefix"]);

@$DB_AFJOURNAL->query("SET NAMES cp1251");

?>