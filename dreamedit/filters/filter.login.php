<script language="JavaScript">
function exit (page,name, value, expires, path, domain, secure) {
  var curCookie = name + "=" + "undefined" +
  ((expires) ? "; expires=" + "Thu, 01-Jan-70 00:00:01 GMT" : "") +
  ((path) ? "; path=" + path : "") +
  ((domain) ? "; domain=" + domain : "") +
  ((secure) ? "; secure" : "");

  document.cookie = curCookie;
  ///deleteCookie('useridext');
  location.replace("https://www.imemo.ru/index.php?page_id="+page);
//  location.href='http://polis.isras.ru/index.php?page_id='+page;
  return false;

}
</script>
<?
global $DB,$_CONFIG, $site_templater;

if(strpos($_SERVER[REQUEST_URI],"&en") !== false || strpos($_SERVER[REQUEST_URI],"?en") !== false)
$suff="_EN";
else $suff="";


echo "<a name='login'></a>";
//print_r($_POST);
if(isset($_POST[Submit]) || (!empty($_POST[username]) && !empty($_POST[passwd])) )
{

	$log=$DB->select("SELECT id,CONCAT(name,' ',fname) AS name FROM comment_reg WHERE login=? AND psw=?",$_POST[username],$_POST[passwd]);
	if (count($log)==0)
	   echo "<p align='center'><strong>��� ����� �������. ��������� ��� ���</strong></p>";
	else
	{
	   setcookie("useridext",$log[0][id]);
	   $_COOKIE[useridext]=$log[0][id];
	   $_REQUEST[useridext]=$log[0][id];
	}
}

if (!(empty($_COOKIE) || $_COOKIE[useridext]=='undefined' || empty($_COOKIE[useridext])))
{

	  $log=$DB->select("SELECT id,CONCAT(name,' ',fname) AS name,avatar FROM comment_reg WHERE id=".$_COOKIE[useridext]);
	   setcookie(user,$log[0][id]);
	   echo "<br /><table><tr><td><!--<img src=".$log[0][avatar]." align='left' />--></td><td valign='middle' align='center'>"."<br /><strong>������������,<br />".$log[0][name]."!</strong></td></tr></table>";
	   echo "<b style='color:#303030'>�������� ��������:</b><br /><a href=/index.php?page_id=".$page_content[BOOK_PAGE].">- ������� � ������� �����</a>";
	   echo "<br /><a href=/index.php?page_id=".$page_content[AUTHOR__PAGE].">- ������� � ���������� ��������</a>";

	   echo "<br /><br /><a style='cursor:hand;cursor:pointer;' onClick=exit(".$_REQUEST[page_id].",'useridext')>�����</a><br />";
}

else

{
?>
<form id="form-login" name="login" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<div class="clear">
	<input id="mod_login_username" class="inputbox" type="text" alt="�����" name="username"/>
	<label for="mod_login_username"> 		<?	echo $suff=="_EN" ? "Login"  : "�����"	; ?> </label>
</div>
<div class="clear">
	<input id="mod_login_password" class="inputbox" type="password" alt="������" name="passwd"/>
	<label for="mod_login_password"> 		<?	echo $suff=="_EN" ? "Password"  : "������"	; ?> </label>
</div>
<div class="clear">
	<div class="extra-indent-top1">
	</div>
</div>

<div class="clear extra-indent-link">
	<div >
<!--	<span><input class="button_form" type="submit" value="������" name="Submit"/></span>/-->
		<a class='button_form' name='submit' onclick="document.getElementById('form-login').submit()" href="#">
		<span>
			<span>		<?	echo $suff=="_EN" ? "Enter"  : "�����"	; ?></span>
		</span>

		</a>

	<!--	<input class="button indent-button" type="submit" value="������" name="Submit"/>/-->
	</div>
	<div class="fleft">
		<p>
			<a href="/index.php?page_id=650"> <? echo $suff=="_EN" ? "Forgot your password?"  : "������ ������?"; ?> </a>
		</p>
		<p class="indent1">
		<?	echo $suff=="_EN" ? "Want to register?"  : "�� �� ���������������� �� ����� �����?"	; ?>
			<span>
				<a href="/index.php?page_id=649">		<?	echo $suff=="_EN" ? "Registration"  : "�����������"	; ?></a>
			</span>
		</p>
	</div>
</div>
</form>
<?
}
?>


