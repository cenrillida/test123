<?php
include_once dirname(__FILE__)."/_include.php";
global $DB;
$data = $DB->select('SELECT * FROM newsite_testing WHERE address=?', $_SERVER["REMOTE_ADDR"]);
if(isset($_GET['participate'])) {
    if ((int)$_GET['participate'] == 0) {
        if (empty($data))
            $DB->query('INSERT INTO newsite_testing (address) VALUES (?)', $_SERVER["REMOTE_ADDR"]);
    }
    if ((int)$_GET['participate'] == 1) {
        if (!empty($data))
            $DB->query('DELETE FROM newsite_testing WHERE address=?', $_SERVER["REMOTE_ADDR"]);
    }
}
$data = $DB->select('SELECT * FROM newsite_testing WHERE address=?', $_SERVER["REMOTE_ADDR"]);
?>
<!doctype html>

<html lang="ru">
<head>
    <meta charset="windows-1251">
    <title>Тестирование нового сайта</title>
</head>

<body>
    <div>
        <p><b>Ваш IP <?php if(empty($data)) echo 'не участвует'; else echo 'участвует';?> в тестировании нового сайта</b></p>
        <form method="get" >
            <input name="participate" type="hidden" value="<?php if(empty($data)) echo '0'; else echo '1';?>">
            <input type="submit" value="<?php if(empty($data)) echo 'Участвовать'; else echo 'Отказаться от участия';?>">
        </form>
    </div>
</body>
</html>