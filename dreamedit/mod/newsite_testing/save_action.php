<?
include_once dirname(__FILE__)."/../../_include.php";

if($_COOKIE[oldsite]==1) {
    setcookie("oldsite", "0", 0, "/");
    echo "Вы успешно выключили старый сайт";
}
else {
    setcookie("oldsite", "1", 0, "/");
    echo "Вы успешно включили старый сайт";
}

?>