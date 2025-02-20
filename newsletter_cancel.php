<?php
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
global $DB;

if(!empty($_GET['code'])) {
    $cancel_code = $DB->cleanuserinput(mb_strtolower($_GET['code']));

    $user = $DB->select("SELECT * FROM newsletter_users WHERE cancel_code = ?", $cancel_code);
    if(!empty($user)) {
        $DB->query('DELETE FROM newsletter_users WHERE cancel_code = ?', $cancel_code);
        echo "Вы успешно отписались от рассылки ИМЭМО РАН";
    } else {
        echo "Пользователь не найден";
    }
} else {
    echo "404";
}