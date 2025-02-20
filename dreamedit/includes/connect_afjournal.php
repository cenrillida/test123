<?
global $_CONFIG, $DB_AFJOURNAL;
// подкючаем конфиг
require_once dirname(__FILE__)."/DbSimple/config.php";
## Подключение к БД.
require_once dirname(__FILE__)."/DbSimple/Generic.php";

// Подключаемся к БД.
$DB_AFJOURNAL = DbSimple_Generic::connect($_CONFIG["global"]["db_connect_afjournal"]["db_type"] . "://" . $_CONFIG["global"]["db_connect_afjournal"]["login"] . ":" . $_CONFIG["global"]["db_connect_afjournal"]["password"] . "@" . $_CONFIG["global"]["db_connect_afjournal"]["host"] . "/" . $_CONFIG["global"]["db_connect_afjournal"]["db_name"]);

// Устанавливаем обработчик ошибок.
$DB_AFJOURNAL->setErrorHandler('databaseErrorHandler');
// Устанавливаем обработчик логов.
$DB_AFJOURNAL->setLogger('databaseQueryLogger');

// Стартуем новую транзакцию.
$DB_AFJOURNAL->transaction();
$DB_AFJOURNAL->setIdentPrefix($_CONFIG["global"]["db_connect_afjournal"]["tbl_prefix"]);

@$DB_AFJOURNAL->query("SET NAMES cp1251");

?>