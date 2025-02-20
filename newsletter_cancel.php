<?php
// ����?������ ������?���� ������ �� ������ - ������?
$_CONFIG["global"] = @parse_ini_file(dirname(__FILE__)."/dreamedit/_config.ini", true);
if(empty($_CONFIG["global"]))
    die("Config is not found!");
// ������?�������������� ���������� admin_path - ������ ���� �� ���������� ?�������� �����������������
$_CONFIG["global"]["paths"]["admin_path"] = $_SERVER["DOCUMENT_ROOT"]."/".$_CONFIG["global"]["paths"]["admin_dir"];
$_CONFIG["global"]["paths"]["template_path"] = $_SERVER["DOCUMENT_ROOT"]."/".$_CONFIG["global"]["paths"]["templates"];


// ���������� ��������?������?
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/headers.php";
// ���������� ���� ��������? ?����?
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/connect.php";
// ���������� ���� ��������? ?����?
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/site.fns.php";
global $DB;

if(!empty($_GET['code'])) {
    $cancel_code = $DB->cleanuserinput(mb_strtolower($_GET['code']));

    $user = $DB->select("SELECT * FROM newsletter_users WHERE cancel_code = ?", $cancel_code);
    if(!empty($user)) {
        $DB->query('DELETE FROM newsletter_users WHERE cancel_code = ?', $cancel_code);
        echo "�� ������� ���������� �� �������� ����� ���";
    } else {
        echo "������������ �� ������";
    }
} else {
    echo "404";
}