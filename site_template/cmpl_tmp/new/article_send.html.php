<?
// ��������� ������ � ������
	global $DB,$_CONFIG, $site_templater;
  //  include ('Mail.php');
//	include ($_SERVER['DOCUMENT_ROOT'] . 'mail_auth.ini');
	$result=0;
//	$conn = mysql_connect("localhost",$_CONFIG["global"]["db_connect"]["login"] ,$_CONFIG["global"]["db_connect"]["password"] ) or die(mysql_error());
//	mysql_select_db($_CONFIG["global"]["db_connect"]["db_name"], $conn) or die(mysql_error());

	include ($_SERVER['DOCUMENT_ROOT']."/classes/upload/upload_class.php"); //classes is the map where the class file is stored (one above the root)
        $max_size = 5120*1024; // the max. size for uploading

	$my_upload = new file_upload;

    $my_upload->upload_dir = $_SERVER['DOCUMENT_ROOT']."/abstract_".$_TPL_REPLACMENT["PATH"]."_bank/"; // "files" is the folder for the uploaded files (you have to create this folder)
    $my_upload->extensions = array(".doc", ".docx",".pdf"); // specify the allowed extensions here
	$my_upload->language = "ru"; // use this to switch the messages into an other language (translate first!!!)
	$my_upload->max_length_filename = 50; // change this value to fit your field length in your database (standard 100)
	$my_upload->rename_file = true;

	$result=0;
	if(isset($_POST['Submit']) && !empty($_POST[fio]) && !empty($_POST[country]) && !empty($_POST[region]))
	{

				$from = 'feedback@isras.ru';
				$to = 'shef@isras.ru';
				$to3='shefnew@gmail.com';
				$to4='delo@isras.ru';
				$to5='delo@isras.ru';

                                $nn="\r\n";

				$data =  "�������� �����:".$nn.
				"���: ".$_POST["fio"].", ".$nn.
				"������: ".$_POST["country"].", ".$nn.
				"������: ".$_POST["region"].", ".$nn.
				"��� ������������: ".$_POST["vid"].", ".$nn.
				"������� ������� ���������: ".$_POST["nauka"].", ".$nn.
				"Email: ".$_POST["email"].", ".$nn.
				"�������: ".$_POST["telephone"].", ".$nn.
				"������ / �����������: ".$_POST["text"]
                          ;
///////
              $subject = '=?koi8-r?B?'.base64_encode(convert_cyr_string("�������� ����� (�����)", "w","k")).'?=';
//////  �������� /////
        
    
//	$conn = mysql_connect("localhost",$_CONFIG["global"]["db_connect"]["login"] ,$_CONFIG["global"]["db_connect"]["password"] ) or die(mysql_error());

	if(isset($_POST['Submit']))
	{


// ��������
        $my_upload->the_temp_file = $_FILES['upload']['tmp_name'];
        $my_upload->the_file = $_FILES['upload']['name'];
		$my_upload->http_error = $_FILES['upload']['error'];
		$my_upload->replace = "y";
		$my_upload->do_filename_check = "n"; // use this boolean to check for a valid filename
		$temp="�������� ";
		if ($my_upload->upload())

			$fname=$my_upload->file_copy;
		
			// file to upload:
			 $local_file = $_SERVER['DOCUMENT_ROOT']."/article_bank/".$fname;


// �������� � ����
//  mail("shefnew@gmail.com",$subject,$data);
//  mail("jungoo.work@gmail.com",$subject,$data);
               $file=$my_upload->file_copy;
               if (mysql_query("INSERT INTO article_send VALUES(".
	            "0,".
				"'".$_SESSION[jour_id]."',".
	            "'".$_POST['fio']. "',".
				"'".$_POST['fio_en']. "',".
				"'".$_POST['name']. "',".
				"'".$_POST['name_en']. "',".
	            "'".$_POST['rebric']."',".
                "'".$file. "',".      
		    "'".$_POST['email']."',".
		    "'".$_POST['telephone']."',".
		    "'".$_POST['text']."',".
	            "'".date(Ymd)."')")
		 )
		 $result="true";
		 else $result="false";
  }

}
	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
?>
<script language="JavaScript">
function check_email(email) {
  var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return filter.test(email);
}

function FeedCheck(param) {
  
  if (document.getElementById("fio").value=="") {
    if (param!="en")
		alert("�� ������� ���");
	else alert("Your name is not entered");
	return false;
  }
  if (document.getElementById("fio_en").value=="") {
	if (param!="en")
		alert("�� ������� ��� �� ����������");
	else alert("Your name in English is not entered");
	return false;
  }
  if (document.getElementById("name").value=="") {
	if (param!="en")	
		alert("�� ������� �������� ������");
	else alert("Title of the article is not entered");	
	return false;
  }
if (document.getElementById("name_en").value=="") {
	if (param!="en")	
		alert("�� ������ �������� ������ �� ����������");
	else alert("Title of the article In English is not entered");	
	return false;
  }
  if (document.getElementById("rubric").value=="") { 
	if (param!="en")	
		alert("�� ������� �������");
	else alert("Rubric is not entered");	
	return false;
  }
  if (document.getElementById("email").value=="") { 
	if (param!="en")	
		alert("�� ������ e-mail");
	else alert("E-mail is not entered");	
	return false;
  }

  if (!check_email(document.getElementById("email").value)) {
	if (param!="en")
		alert("������������ ������ email");
	else alert("E-mail is failed");	
	return false;
    }
  if (document.getElementById("file").value=="") { 
	if (param!="en")	
		alert("�� �������� ����� ������");
	else alert("Not is File");	
	return false;
  }
  
  return false;
 }
 function chrub()
 {
 
   var a=document.getElementById('rub');
   document.getElementById('rubric').value=a.value;
 
 }
</script>


<?

	if($result == false)
	{
		if ($_SESSION[lang]!='/en')
			echo $_TPL_REPLACMENT["CONTENT"];
		else echo $_TPL_REPLACMENT["CONTENT_EN"];	
	}
  if ($_SESSION[lang]=="/en") $param='en'; else $param="";

  $mz=new Magazine();
  if ($_SESSION["lang"]!='/en')
  {
	$rows=$mz->getRubricAll(49,1,' ',' ' ,"*");
	
  }
  else	
  {
	
	$rows=$mz->getRubricAllEn(49,1,' ',' ' ,"*");
  }	
//  print_r($rows);
$_REQUEST[jj]=49;
if ($_SESSION[lang]!='/en')
	 $rows=$DB->select("SELECT SUBSTRING_INDEX(IFNULL(r.name,r.page_name),':',1) AS name,
	 IFNULL(r.name_en,r.page_name) AS name_en,sum(z.count) AS sum 
	 FROM 
	 (SELECT page_parent,count(page_id)AS count 
		FROM `adm_article` WHERE date_public<>'' AND page_template='jarticle' 
		AND IFNULL(name,page_name) <> '������ ����� ������'
		GROUP BY page_parent) AS z 
		INNER JOIN adm_article AS r ON r.page_id=z.page_parent AND r.page_template='jrubric' 
		    AND r.journal='".$_REQUEST[jj]."' 
		GROUP BY SUBSTRING_INDEX(IFNULL(name,page_name),':',1)
		ORDER BY IFNULL(name,page_name)");
    else
	$rows=$DB->select("SELECT SUBSTRING_INDEX(IFNULL(r.name,r.page_name),':',1) AS name,
	 IFNULL(r.name_en,r.page_name) AS name_en,sum(z.count) AS sum, name_en AS en 
	 FROM 
	 (SELECT page_parent,count(page_id)AS count 
		FROM `adm_article` WHERE date_public<>'' AND page_template='jarticle' 
		GROUP BY page_parent) AS z 
		INNER JOIN adm_article AS r ON r.page_id=z.page_parent AND r.page_template='jrubric' 
		AND r.journal='".$_REQUEST[jj]."'
		GROUP BY SUBSTRING_INDEX(page_name,':',1)
		ORDER BY IF(IFNULL(r.name_en,' ')=' ',0,1) DESC, r.name_en");
//print_r($rows);
   
  ?>

	<form name="feedform" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onSubmit="return FeedCheck('<?=@$param?>')">
<? if($result == false)
{
   if ($_SESSION[lang] !='/en')
   {
	echo " <table width='90%' cellpadding='0' cellspacing='0' border='0'> ";
	echo  "   <tr><td width='37%' align='right'>���:</td><td width='2%'>&nbsp;</td><td width='61%' align='left'><input type='edit' name='fio' id='fio' maxlength='150' size='30'>&nbsp;<span class='red'>*</span></td></tr>";
	echo  "   <tr><td width='37%' align='right'>��� (english):</td><td width='2%'>&nbsp;</td><td width='61%' align='left'><input type='edit' name='fio_en' id='fio_en' maxlength='150' size='30'>&nbsp;<span class='red'>*</span></td></tr>";

	echo "	    <tr><td width='37%' align='right' valign=top>�������� ������:</td><td width='2%' valign=top>&nbsp;</td><td width='61%' align='left'>
	<textarea name='name' id='name' rows='2' cols='54'></textarea>&nbsp;*</td></tr>";
	echo "	    <tr><td width='37%' align='right' valign=top>�������� ������ (English):</td><td width='2%' valign=top>&nbsp;</td><td width='61%' align='left'>
	<textarea name='name_en' id='name_en' rows='2' cols='54'></textarea>&nbsp;*</td></tr>";
	echo  "   <tr><td width='37%' align='right'>�������������� �������:</td><td width='2%'>&nbsp;</td>
	<td width='61%' align='left'><input type='edit' name='rubric' id='rubric' maxlength='350' size='32'>&nbsp;*";
	echo "<select onchange=chrub() id=rub><option value=''></option>";
	foreach($rows as $row)
	{
	  echo "<option value='".$row[name]."' title='".$row[name]."'>".substr($row[name],0,25)."</option>";
	}
	echo "</select>";
	echo "</td></tr>";

	 echo "<tr><td colspan=3><br /><b>���������� ������ (�� ����� 5�����, ������: doc, docx)</b></td></tr>";
	 echo "      <tr><td  align='right'>
	������� ����</td><td >&nbsp;</td><td align='left'>".
	$my_upload->create_file_field('upload', '', 50, false)."</td></tr>";
	echo "<tr><td colspan=3><br /><b>��� ����� � ���������</b></td></tr>";
	echo "	    <tr><td width='37%' align='right'>����� e-mail:</td><td width='2%'>&nbsp;</td><td width='61%' align='left'><input type='edit' name='email' id='email' maxlength='50' size='30'>&nbsp;<span class='red'>*</span></td></tr>";
	echo "	    <tr><td width='37%' align='right'>����� ��������:</td><td width='2%'>&nbsp;</td><td width='61%' align='left'><input type='edit' name='telephone' id='telephone' maxlength='50' size='30'></td></tr>";
	echo "	    <tr><td width='37%' align='right'>�����������:</td><td width='2%'>&nbsp;</td><td width='61%' align='left'><textarea  maxlength-'1000' name='text' id='text'  cols='45'  rows='2'></textarea></td></tr>";
	echo "	  </table>";
    }
	else
	{
		echo " <table width='90%' cellpadding='0' cellspacing='0' border='0'> ";
	echo  "   <tr><td width='37%' align='right'>Your name:</td><td width='2%'>&nbsp;</td><td width='61%' align='left'><input type='edit' name='fio' id='fio' maxlength='50' size='30'>&nbsp;<span class='red'>*</span></td></tr>";
	echo "	    <tr><td width='37%' align='right'>Country:</td><td width='2%'>&nbsp;</td><td width='61%' align='left'><input type='edit' name='country' id='country' maxlength='50' size='30'>&nbsp;<span class='red'>*</span></td></tr>";
	echo "	    <tr><td width='37%' align='right'>City:</td><td width='2%'>&nbsp;</td><td width='61%' align='left'><input type='edit'  name='region' id='region' maxlength='50' size='30'>&nbsp;<span class='red'>*</span></td></tr>";
	echo "	    <tr><td width='37%' align='right'>Type of activity:</td><td width='2%'>&nbsp;</td><td width='61%' align='left'><input type='edit' name='vid' id='vid' maxlength='50' size='30'>&nbsp;<span class='red'>*</span></td></tr>";
	echo "	    <tr><td width='37%' align='right'>Research interests:</td><td width='2%'>&nbsp;</td><td width='61%' align='left'><input type='edit' name='nauka'  id='nauka' maxlength='50' size='30'>&nbsp;</td></tr>";
	echo "	    <tr><td width='37%' align='right'>E-mail:</td><td width='2%'>&nbsp;</td><td width='61%' align='left'><input type='edit' name='email' id='email' maxlength='50' size='30'>&nbsp;<span class='red'>*</span></td></tr>";
	echo "	    <tr><td width='37%' align='right'>Phone:</td><td width='2%'>&nbsp;</td><td width='61%' align='left'><input type='edit' name='telephone' id='telephone' maxlength='50' size='30'></td></tr>";
	echo "	    <tr><td width='37%' align='right'>Your question or suggestion:</td><td width='2%'>&nbsp;</td><td width='61%' align='left'><textarea  maxlength-'1000' name='text' id='text'  cols='45'  rows='10'></textarea></td></tr>";
	echo "	  </table>";   
	}
	echo "	  <br/>";
	echo "		<br />";
	echo "		<br />";
	echo "		<br />";
	if ($_SESSION[lang] !='/en')
		echo "	  <input type='submit' name='Submit' value='���������'>";
	else	
   		echo "	  <input type='submit' name='Submit' value='Send'>";

	}
?>
	</form>
	<br clear="all">
	<p>
<?

	if (!empty($_POST)) {
		if($result==false)
		{
    	      if ($_SESSION[lang]!='/en')
				echo "������ ��������. ��������� ��� ���";
			  else
                echo "Error sending. Say it again";			  
         }
		 echo "<b>".$_TPL_REPLACMENT["RESULT"]."</b>";
    }

?>
</p>

<?
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