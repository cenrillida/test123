<?
// ��������� ������
require_once dirname(__FILE__)."/DbSimple/config.php";
## ����������� � ��.
require_once dirname(__FILE__)."/DbSimple/Generic.php";

try {
    $DBH = new PDO("mysql:host={$_CONFIG["global"]["db_connect"]["host"]};dbname={$_CONFIG["global"]["db_connect"]["db_name"]}", $_CONFIG["global"]["db_connect"]["login"], $_CONFIG["global"]["db_connect"]["password"]);
    $DBH->exec("SET NAMES cp1251");
}
catch(PDOException $e) {
}

// ������������ � ��.
$DB = DbSimple_Generic::connect($_CONFIG["global"]["db_connect"]["db_type"] . "://" . $_CONFIG["global"]["db_connect"]["login"] . ":" . $_CONFIG["global"]["db_connect"]["password"] . "@" . $_CONFIG["global"]["db_connect"]["host"] . "/" . $_CONFIG["global"]["db_connect"]["db_name"]);

// ������������� ���������� ������.
$DB->setErrorHandler('databaseErrorHandler');
// ������������� ���������� �����.
$DB->setLogger('databaseQueryLogger');

// �������� ����� ����������.
$DB->transaction();
$DB->setIdentPrefix($_CONFIG["global"]["db_connect"]["tbl_prefix"]);

@$DB->query("SET NAMES cp1251");

// ��� ����������� ������ SQL.
function databaseErrorHandler($message, $info)
{
	global $_CONFIG;

	// �������� ���������� � ����
	$query_error_log_file = $_CONFIG["global"]["paths"]["admin_path"].$_CONFIG["global"]["paths"]["log_dir"]."queryError_".date("Y-m-d").".log";

	// ����� ���� ������
	error_log(date("r")."\n", 3, $query_error_log_file);

	// ����� ��������� �� ������
	error_log($message."\n", 3, $query_error_log_file);

	// ����� ��� ������ �� ������
	error_log("[code]: " . $info["code"] . "\n"      , 3, $query_error_log_file);
	error_log("[message]: " . $info["message"]  ."\n", 3, $query_error_log_file);
	error_log("[query]: "  .$info["query"] . "\n"    , 3, $query_error_log_file);
	error_log("[context]: " . $info["context"] . "\n", 3, $query_error_log_file);

	// ������� ����� ����� �������� ������ ����
	error_log("\n", 3, $query_error_log_file);

	// ���� �������������� @, ������ �� ������.
	if (!error_reporting()) return;
	// ������� ��������� ���������� �� ������.
	echo "SQL Error: $message<br><pre>"; 
	print_r($info);
	echo "</pre>";

	exit;
}


// ������� ����������� ��������
function databaseQueryLogger($obj, $query)
{
	global $_CONFIG;
	
	if(!$_CONFIG["global"]["general"]["log_query"])
		return;

	$query_log_file = $_SERVER["DOCUMENT_ROOT"] . "/" . $_CONFIG["global"]["paths"]["admin_dir"] . $_CONFIG["global"]["paths"]["log_dir"] . "query_" . date("Y-m-d") . ".log";

	// now date
	error_log(date("r")."\n", 3, $query_log_file);

	// ���������� ������������ � ����: phptype|dbsyntax|username|password|protocol|hostspec|port|socket|database|dsn
	// dbsyntax://hostspec:port/database
	error_log($obj->DbSimple_connectParams["dbsyntax"] . "://", 3, $query_log_file);
	error_log($obj->DbSimple_connectParams["hostspec"] . ":"  , 3, $query_log_file);
	error_log($obj->DbSimple_connectParams["port"] . "/"      , 3, $query_log_file);
	error_log($obj->DbSimple_connectParams["database"] . "\n" , 3, $query_log_file);

	// query
	error_log($query . "\n", 3, $query_log_file);

	// ������� ����� ����� �������� ������ ����
	error_log("\n", 3, $query_log_file);
}
?>