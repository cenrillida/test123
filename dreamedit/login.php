<?
include_once "_include.php";
if(!empty($_POST["admin"]["login"]) && !empty($_POST["admin"]["pass"]))
{
	$login_res = $DB->selectCell("SELECT a_id FROM ?_admin WHERE a_login = ? AND a_pass = ? AND a_status = 1", $_POST["admin"]["login"], md5($_POST["admin"]["pass"]));
	$login_res = $DB->selectCell("SELECT a_id FROM ?_admin WHERE a_login = ? AND a_hach = ? AND a_status = 1", $_POST["admin"]["login"], hash_hmac('ripemd160',$_POST["admin"]["login"], $_POST["admin"]["pass"]));

	if(!empty($login_res))
	{
//       print_r($_SESSION);
		Dreamedit::updateSession($login_res);
//	echo "<br />https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php";
//	print_r($_SESSION);
		Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php");

	}
	else
	{
		$error = Dreamedit::translate("�������� ����� ��� ������! ������ ��������");
	}

}

if(!empty($_POST["admin"]["send"]) && (empty($_POST["admin"]["login"]) || empty($_POST["admin"]["pass"])))
	$error = Dreamedit::translate("�� ��������� ���� ����� ��� ������! ������ ��������");

?>


<html>
<head>
<title></title>
<link rel="stylesheet" type="text/css" href="<?=$_CONFIG["global"]["paths"]["skin_dir"].$_CONFIG["global"]["general"]["default_skin"]?>/de_style.css">
</head>

<body>

<table class="login" width="100%" height="100%">
<tbody>
	<tr>
		<td>
			<center>
				<?
				// �������� ���������������� �������� ������������
				if(checkUserAgent())
				{
					echo isset($error)? "<font color='red'>".$error."</font><br />": "<br />";
					echo Dreamedit::translate("��� ������� � ������� ���������� ������ ������<br />���� ����� � ������")
				?>
					<br /><br />
					<form action="" method="POST">
						<input type="text" name="admin[login]"><br />
						<input type="password" name="admin[pass]"><br />
						<input type="submit" class="form_button" name="admin[send]" value="<?=Dreamedit::translate("�����")?>">
					</form>
				<?
				}
				else
				{
					$bInfo = detect_browser();

					echo Dreamedit::translate("�������: ").$bInfo["name"]."<br />";
					echo Dreamedit::translate("������: ").$bInfo["version"]."<br />";
					echo Dreamedit::translate("������ ������� �� ��������������!<br />������ � ������� ���������� ������ ������������!")."<br />";
				}
				?>
				<br /><?=Dreamedit::translate("&copy; DreamEdit ��� ����� ��������")?>
			</center>
		</td>
	</tr>
</table>

</body>
</html>
