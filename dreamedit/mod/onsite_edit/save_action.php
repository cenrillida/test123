<?
include_once dirname(__FILE__)."/../../_include.php";

if($_SESSION["on_site_edit"]==1) {
    $_SESSION["on_site_edit"]=0;
    echo "Вы успешно выключили редактирование данных с лица сайта";
}
else {
    $_SESSION["on_site_edit"]=1;
    echo "Вы успешно включили редактирование данных с лица сайта";
}

?>