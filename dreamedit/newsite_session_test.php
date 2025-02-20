<?php

if(isset($_GET['participate'])) {
    if ((int)$_GET['participate'] == 0) {
        if (empty($_COOKIE[newsite]) || $_COOKIE[newsite]==0)
            setcookie("newsite", "1", 0, "/");
    }
    if ((int)$_GET['participate'] == 1) {
        if ($_COOKIE[newsite]==1)
            setcookie("newsite", "0", 0, "/");
    }
}
?>

<!doctype html>

<html lang="ru">
<head>
    <meta charset="windows-1251">
    <title>Тестирование нового сайта</title>
</head>

<body>
    <div>
        <p><b>Вы <?php if(empty($_COOKIE[newsite]) || $_COOKIE[newsite]==0) echo 'не участвуете'; else echo 'участвуете';?> в тестировании нового сайта</b></p>
        <form method="get" >
            <input name="participate" type="hidden" value="<?php if(empty($_COOKIE[newsite]) || $_COOKIE[newsite]==0) echo '0'; else echo '1';?>">
            <input type="submit" value="<?php if(empty($_COOKIE[newsite]) || $_COOKIE[newsite]==0) echo 'Участвовать'; else echo 'Отказаться от участия';?>">
        </form>
    </div>
</body>
</html>