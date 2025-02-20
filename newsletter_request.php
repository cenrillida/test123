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
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.UUID.php";
global $DB;

if(!empty($_GET['email'])) {
    if(filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
        $exist = $DB->select('SELECT id FROM newsletter_users WHERE email = ?', $_GET['email']);
        if(empty($exist)) {
            $request_exist = $DB->select('SELECT IF((NOW() - INTERVAL 5 MINUTE)>time, 1, 0) AS time_protect,code FROM newsletter_requests WHERE email = ?', $_GET['email']);
            $email = $_GET['email'];
            $code = '';
            $time_protect=1;
            if(empty($request_exist)) {
                $code = str_replace("@", "",str_replace(".","",$email))."_".UUID::v4();
                $code = $DB->cleanuserinput(mb_strtolower($code));
                $DB->query('INSERT INTO newsletter_requests(email,code) VALUES(?,?)',$email,$code);
            } else {
                $code = $request_exist[0]['code'];
                $time_protect = $request_exist[0]['time_protect'];
                if($time_protect)
                    $DB->query('UPDATE newsletter_requests SET time=NOW() WHERE email = ?', $email);
            }
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=windows-1251' . "\r\n";
            $headers .= 'From: '.'=?WINDOWS-1251?B?'.base64_encode('����� ���').'?='.' <newsletter@imemo.ru>' . "\r\n";
            $mail_text = "������������!<br><br>�� �������� ������ �� �������� �� ����� ����� ���.<br>����� ����������� ���� ��������, ��������� �� ������:<br><br><a href=\"https://imemo.ru/newsletter_request.php?code=".$code."\">�����������</a><br><br>���� �� �� ���������� ������, �������������� ��� ���������.<br><br>� ���������,<br>����� ���.";
            if($time_protect) {
                mail($email, '=?WINDOWS-1251?B?' . base64_encode('����������� �� ��������') . '?=', $mail_text, $headers);
                echo "��� ���� ���������� ������ ��� ������������� �������� �� ��������.";
            } else {
                echo "��������� ������ ����� ��������� ����� 5 �����";
            }
        } else {
         echo '�� ��� ���������';
        }
    } else {
        echo '�������� email �����';
    }
    //$cancel_code = $DB->cleanuserinput(mb_strtolower($_GET['cancel_code']));
    //var_dump($cancel_code);
} elseif(!empty($_GET['code'])) {
    $code = $DB->cleanuserinput(mb_strtolower($_GET['code']));
    $exist = $DB->select('SELECT * FROM newsletter_requests WHERE code = ?', $code);
    if(!empty($exist)) {
        $exist_user = $DB->select('SELECT * FROM newsletter_users WHERE email = ?', $exist[0]['email']);
        if(!empty($exist_user)) {
            echo "�� ��� ���������";
        } else {
            $DB->query('INSERT INTO newsletter_users(email,cancel_code) VALUES(?,?)',$exist[0]['email'],$code);
            echo "�� ������� ��������� �� ��������.";
        }
        $DB->query('DELETE FROM newsletter_requests WHERE code = ?', $code);
    } else {
        echo '������ �� ������';
    }
} else {
    echo '�������� email �����';
}