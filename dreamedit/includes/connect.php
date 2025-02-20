<?
// подкючаем конфиг
require_once dirname(__FILE__)."/DbSimple/config.php";
## Подключение к БД.
require_once dirname(__FILE__)."/DbSimple/Generic.php";

try {
    $DBH = new PDO("mysql:host={$_CONFIG["global"]["db_connect"]["host"]};dbname={$_CONFIG["global"]["db_connect"]["db_name"]}", $_CONFIG["global"]["db_connect"]["login"], $_CONFIG["global"]["db_connect"]["password"]);
    $DBH->exec("SET NAMES cp1251");
}
catch(PDOException $e) {
}

// Подключаемся к БД.
$DB = DbSimple_Generic::connect($_CONFIG["global"]["db_connect"]["db_type"] . "://" . $_CONFIG["global"]["db_connect"]["login"] . ":" . $_CONFIG["global"]["db_connect"]["password"] . "@" . $_CONFIG["global"]["db_connect"]["host"] . "/" . $_CONFIG["global"]["db_connect"]["db_name"]);

// Устанавливаем обработчик ошибок.
$DB->setErrorHandler('databaseErrorHandler');
// Устанавливаем обработчик логов.
$DB->setLogger('databaseQueryLogger');

// Стартуем новую транзакцию.
$DB->transaction();
$DB->setIdentPrefix($_CONFIG["global"]["db_connect"]["tbl_prefix"]);

@$DB->query("SET NAMES cp1251");

// Код обработчика ошибок SQL.
function databaseErrorHandler($message, $info)
{
	global $_CONFIG;

	// логируем информацию в файл
	$query_error_log_file = $_CONFIG["global"]["paths"]["admin_path"].$_CONFIG["global"]["paths"]["log_dir"]."queryError_".date("Y-m-d").".log";

	// пишем дату ошибки
	error_log(date("r")."\n", 3, $query_error_log_file);

	// пишем сообщение об ошибке
	error_log($message."\n", 3, $query_error_log_file);

	// пишем все данные об ошибке
	error_log("[code]: " . $info["code"] . "\n"      , 3, $query_error_log_file);
	error_log("[message]: " . $info["message"]  ."\n", 3, $query_error_log_file);
	error_log("[query]: "  .$info["query"] . "\n"    , 3, $query_error_log_file);
	error_log("[context]: " . $info["context"] . "\n", 3, $query_error_log_file);

	// перенос строк между строками одного лога
	error_log("\n", 3, $query_error_log_file);

	// Если использовалась @, ничего не делать.
	if (!error_reporting()) return;
	// Выводим подробную информацию об ошибке.
	echo "SQL Error: $message<br><pre>"; 
	print_r($info);
	echo "</pre>";

	exit;
}


// Функция логирования запросов
function databaseQueryLogger($obj, $query)
{
	global $_CONFIG;
	
	if(!$_CONFIG["global"]["general"]["log_query"])
		return;

	$query_log_file = $_SERVER["DOCUMENT_ROOT"] . "/" . $_CONFIG["global"]["paths"]["admin_dir"] . $_CONFIG["global"]["paths"]["log_dir"] . "query_" . date("Y-m-d") . ".log";

	// now date
	error_log(date("r")."\n", 3, $query_log_file);

	// переменные подключкения к базе: phptype|dbsyntax|username|password|protocol|hostspec|port|socket|database|dsn
	// dbsyntax://hostspec:port/database
	error_log($obj->DbSimple_connectParams["dbsyntax"] . "://", 3, $query_log_file);
	error_log($obj->DbSimple_connectParams["hostspec"] . ":"  , 3, $query_log_file);
	error_log($obj->DbSimple_connectParams["port"] . "/"      , 3, $query_log_file);
	error_log($obj->DbSimple_connectParams["database"] . "\n" , 3, $query_log_file);

	// query
	error_log($query . "\n", 3, $query_log_file);

	// перенос строк между строками одного лога
	error_log("\n", 3, $query_log_file);
}
?>