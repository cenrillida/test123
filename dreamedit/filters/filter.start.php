
<script language="JavaScript">
function stpage()
{
   var stp=document.getElementById("start_page").style;
   if (stp.display=='none')
      stp.display='block';
   else
      stp.display='none';
}
</script>
<?


// ������� ���������
global $DB,$_CONFIG;

$HTTP_USER_AGENT=$_SERVER['HTTP_USER_AGENT'];
if(eregi("opera",$HTTP_USER_AGENT))// ���� � ���� �����, �� ���������� $browse = OP
$browser = "OP";

else if(eregi("msie",$HTTP_USER_AGENT))// ���� � ���� MSIE, �� ���������� $browse = IE
$browser = "IE";

else if(eregi("Mozilla.[4.]",$HTTP_USER_AGENT))
$browser = "NS";

else if(eregi("Mozilla.[5|6]",$HTTP_USER_AGENT))
$browser = "MO";
else // ���� ���-�� ������ , �� OT
$browser = "OT";


if ($browser=="IE")
{
if (!isset($_REQUEST[en]))
	echo "<a href='#' onclick=\"this.style.behavior= 'url(#default#homepage)'; this.setHomePage('http://www.polisportal.ru');\"> ������� �������� ���������</a>";
else
	echo "<a href='#' onclick=\"this.style.behavior= 'url(#default#homepage)'; this.setHomePage('http://www.polisportal.ru');\"> ".strtoupper("make this your home page")."</a>";

}
else
{

if (!isset($_REQUEST[en]))
	echo "<a onClick=stpage() href=# title='������� �������� ���������'>������� �������� ���������</a>";
else
	echo "<a onClick=stpage() href=# title='Make this your home page'>".strtoupper("make this your home page")."</a>";

?>
<div id="start_page" style="display: none; background-color:white;">
<table style='width:100%;height:80px;background-color:white;'>
<tr><td valign='top'>
<div class="content">
<a id="start-page-href" class="icon" href="">
<img border='0' hspace='10' align='left' alt="socioprognoz" src="/files/Image/logo_site.jpg" title='���������� ������� �� ������ "���" � ������ ������������� ��������'"/>
</a>
<a onClick="stpage();" href="#">
<img align='right' alt="X " border='0' src="/image/close2.png"/>
</a> <br />
<?
if (!isset($_REQUEST[en]))
{
?>
<p>
����������  �������� <br />�� ������ ���� � ���������.<br />(������ ���� ����������� � ������ ������������ ��������).<br /> ����� ������� ��� �� ����������� ����.
</p>
<?
} else {
?>
<p>
Drag the "logo"<br />
on the icon of "Home" and release.<br />
(Icon "House " is located in the browser toolbar).<br />
Then click "Yes " from the popup window.
</p>
<?
}
?>
</div>

</td></tr></table>
</div>
<?
}
?>



