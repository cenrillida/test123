<?
global $DB,$_CONFIG, $site_templater;
	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
// ����������� ������
	?>
	<h1><?=@$_TPL_REPLACMENT["CONTENT_HEADER"]?></h1>
	<script language="JavaScript">
function MyFBCheck() {

    if (document.fbform.login.value=="" && document.fbform.email.value=="") {
	alert("���� ������� login ��� e-mail");
	return false;
  }
}
</script>
<?

$result=false;
if(isset($_POST['Submit']))
{
     if (!empty($_POST[login]))
		$psw0=$DB->select("SELECT psw,email,login FROM comment_reg WHERE login='".$_POST[login]."'");
	 else	
		$psw0=$DB->select("SELECT psw,email,login FROM comment_reg WHERE email='".$_POST[email]."'");

     if (count($psw0)>0)
     {

         $from = 'feedback@isras.ru';
	     $to = 'delo@isras.ru'; //$psw0[0][email];
	     $to4 = $psw0[0][email];
	     $to5 = $psw0[0][email];
	     $nn="\r\n";
	     $data =  "����������� ������:".$nn.
				 "��� login : ".$psw0[0]["login"].", ".$nn.
				 "��� ������: ".$psw0[0]["psw"].", ".$nn.
				 
   				 "������ ��������� ����� www.inion.ru"
                          ;
          send_mime_mail('INION RAN',
         'feedback@isras.ru',
               '���������� ������',
               $psw0[0][email],
               'CP1251',  // ���������, � ������� ��������� ������������ ������
               'KOI8-R', // ���������, � ������� ����� ���������� ������
               '����������� ������',$data
               );

                                $result="true";
//	                       else $result="false";

     }
    else
        $result="false2";
}
if($result == false)
{

?>
	<form name="fbform" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onSubmit="return MyFBCheck()">
<?

 	echo " <table width='100%' cellpadding='2' cellspacing='2' border='0'> ";
 	echo "<tr bgcolor=#efefef><td colspan='3'><b>����������, ������� ��� ����� ��� ����� ����������� �����:</b></td><tr>";
	echo  "   <tr ><td  width='35%' align='right'><span  value=".$_POST[login].">�����:</span></td><td width='2%'>&nbsp;</td><td width='71%' align='left'>
	         <input type='edit' name='login' maxlength='50' size='30' value='".$_POST[login]."'>&nbsp;<span class='red'></span></td></tr>";
	echo  "   <tr ><td  width='35%' align='right'><span  value=".$_POST[email].">E-mail:</span></td><td width='2%'>&nbsp;</td><td width='71%' align='left'>
	         <input type='edit' name='email' maxlength='50' size='30' value='".$_POST[email]."'>&nbsp;<span class='red'></span></td></tr>";

    echo "</table>";
    echo "<br/>";
	echo "<br />";
//	echo "<blockquote dir='ltr' style='margin-right: 0px'><blockquote dir='ltr' style='margin-right: 0px'><blockquote dir='ltr' style='margin-right: 0px'>";
    echo      	" <input type='submit' name='Submit' value='���������'>";
//    echo "</blockquote></blockquote></blockquote>";
    echo "</form>";

}
   else if ($result=="true")
    {
       echo "������ ������ �� ����������� �����, ��������� ��� �����������: ".$psw0[0][email];
    }
else if ($result=="false2")
{
	echo "����� �� ������";
}
function send_mime_mail($name_from, // ��� �����������
                        $email_from, // email �����������
                        $name_to, // ��� ����������
                        $email_to, // email ����������
                        $data_charset, // ��������� ���������� ������
                        $send_charset, // ��������� ������
                        $subject, // ���� ������
                        $body // ����� ������
                        ) {
  $to = mime_header_encode($name_to, $data_charset, $send_charset)
                 . ' <' . $email_to . '>';
  $subject = mime_header_encode($subject, $data_charset, $send_charset);
  $from =  mime_header_encode($name_from, $data_charset, $send_charset)
                     .' <' . $email_from . '>';
  if($data_charset != $send_charset) {
    $body = iconv($data_charset, $send_charset, $body);
  }
  $headers = "From: $from\r\n";
  $headers .= "Content-type: text/html; charset=$send_charset\r\n";
  $headers .= "Mime-Version: 1.0\r\n";

  return mail($to, $subject, $body, $headers);
}

function mime_header_encode($str, $data_charset, $send_charset) {
  if($data_charset != $send_charset) {
    $str = iconv($data_charset, $send_charset, $str);
  }
  return '=?' . $send_charset . '?B?' . base64_encode($str) . '?=';
}

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>

