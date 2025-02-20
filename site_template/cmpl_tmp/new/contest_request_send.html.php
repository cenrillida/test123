<?
// Отправить статью в журнал
	global $DB,$_CONFIG, $site_templater;  
  //  include ('Mail.php');
//	include ($_SERVER['DOCUMENT_ROOT'] . 'mail_auth.ini');
	$result=0;
	

//	$conn = mysql_connect("localhost",$_CONFIG["global"]["db_connect"]["login"] ,$_CONFIG["global"]["db_connect"]["password"] ) or die(mysql_error());
//	mysql_select_db($_CONFIG["global"]["db_connect"]["db_name"], $conn) or die(mysql_error());

	include ($_SERVER['DOCUMENT_ROOT']."/classes/upload/upload_class.php"); //classes is the map where the class file is stored (one above the root)
     $max_size = 5120*1024; // the max. size for uploading
	$my_upload = new file_upload;
	$pdf_upload = new file_upload;
	


    $my_upload->upload_dir = $_SERVER['DOCUMENT_ROOT']."/article_bank/"; // "files" is the folder for the uploaded files (you have to create this folder)
    $my_upload->extensions = array(".doc"); // specify the allowed extensions here
	$my_upload->language = "ru"; // use this to switch the messages into an other language (translate first!!!)
	$my_upload->max_length_filename = 50; // change this value to fit your field length in your database (standard 100)
	$my_upload->rename_file = true;

	$pdf_upload->upload_dir = $_SERVER['DOCUMENT_ROOT']."/article_bank/"; // "files" is the folder for the uploaded files (you have to create this folder)
    $pdf_upload->extensions = array(".pdf"); // specify the allowed extensions here
	$pdf_upload->language = "ru"; // use this to switch the messages into an other language (translate first!!!)
	$pdf_upload->max_length_filename = 50; // change this value to fit your field length in your database (standard 100)
	$pdf_upload->rename_file = true;
	$result=0;
	

	
	if(isset($_POST['Submit']) && !empty($_POST[fio]) && ($_POST[digj]==($_POST[dig1j]+$_POST[dig2j])) )
	{

				$from = 'feedback@isras.ru';
				$to = 'shef@isras.ru';
				$to3='shefnew@gmail.com';
				$to4='delo@isras.ru';
				$to5='delo@isras.ru';

				$nn_prev="<p>";
                $nn="</p>";

				$data =  $nn_prev."Обратная связь:".$nn.
                    $nn_prev."ФИО: ".$_POST["fio"].", ".$nn.
                    $nn_prev."Дата рождения: ".$_POST["telephone"].", ".$nn.
                    $nn_prev."Перечень полученных результатов: ".$_POST["doljn"].", ".$nn.
                    $nn_prev."Область науки и научное направление: ".$_POST["mobilephone"].", ".$nn.
                    $nn_prev."Высшее образование//квалификация//ученая степень//ученое звание: ".$_POST["fio_photo"].", ".$nn.
                    $nn_prev."Стаж и опыт работы: ".$_POST["devices"].$nn.
                    $nn_prev."Телефон: ".$_POST["fio_jour"].$nn.
                    $nn_prev."E-mail: ".$_POST["email2"].$nn
                          ;
///////
              $subject = '=?koi8-r?B?'.base64_encode(convert_cyr_string("Обратная связь (ИМЭМО)", "w","k")).'?=';
//////  Загрузка /////
     send_mime_mail("ИМЭМО РАН", "imemoran@imemo.ru", "Пресс-центр", "alexqw1@yandex.ru", "cp1251", "utf-8", "Анкета для конкурса", $data);
     $result=true;

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
		alert("Не введено ФИО");
	else alert("Your name is not entered");
	return false;
  }
      if (document.getElementById("telephone").value=="") {
    if (param!="en")
		alert("Не введена дата рождения");
	else alert("Your name is not entered");
	return false;
  }
     if (document.getElementById("doljn").value=="") {
    if (param!="en")
		alert("Не введен перечень полученных результатов");
	else alert("Your name is not entered");
	return false;
  }
        if (document.getElementById("mobilephone").value=="") {
    if (param!="en")
		alert("Не введены область науки и научное направление");
	else alert("Your name is not entered");
	return false;
  }
          if (document.getElementById("fio_photo").value=="") {
    if (param!="en")
		alert("Не введены: Высшее образование//квалификация//ученая степень//ученое звание");
	else alert("Your name is not entered");
	return false;
  }
            if (document.getElementById("devices").value=="") {
    if (param!="en")
		alert("Не введены стаж и опыт работы");
	else alert("Your name is not entered");
	return false;
  }
  /*if (document.getElementById("name_smi").value=="") {
	if (param!="en")	
		alert("Не введено название СМИ");
	else alert("Title of the article is not entered");	
	return false;
  }*/
  /*if (document.getElementById("email").value=="") {
	if (param!="en")	
		alert("Не указан e-mail");
	else alert("E-mail is not entered");	
	return false;
  }

  if (!check_email(document.getElementById("email").value)) {
	if (param!="en")
		alert("Неприемлимый формат email");
	else alert("E-mail is failed");	
	return false;
    }*/
   if (document.getElementById("email2").value=="") {
	if (param!="en")	
		alert("Не указан e-mail");
	else alert("E-mail is not entered");	
	return false;
  }

  if (!check_email(document.getElementById("email2").value)) {
	if (param!="en")
		alert("Неприемлимый формат email");
	else alert("E-mail is failed");	
	return false;
    }
/*
	alert(document.getElementById("file"));
  if (document.getElementById("file").value=="") { 
	if (param!="en")	
		alert("Не приложен текст статьи");
	else alert("Not is File");	
	return false;
  }

*/ 
 
   return(spamsend(dig1j,dig2j));
 }
 function chrub()
 {
 
   var a=document.getElementById('rub');
   document.getElementById('rubric').value=a.value;
 
 }
 function spamsend(dig1j,dig2j)
{
    
	var d1=document.getElementById('dig1j').value;
	var d2=document.getElementById('dig2j').value;
	
	var sum=document.getElementById('digj').value;
	 if(Number(d1)+Number(d2)!=Number(sum))
	 {

	 	alert("Вы не прошли спам-контроль");
	 	return false
	 }
	 else return true;
}
</script>


<?



	if($result == false)
	{
		if ($_SESSION[lang]!='/en')
			echo $_TPL_REPLACMENT["CONTENT"];
		else echo $_TPL_REPLACMENT["CONTENT_EN"];	
	}
	else
	{
		if($_SESSION[lang]!='/en')
			echo '<div class="sent-block"><img width=170px src="/img/e_mail_b.jpg" /><p>Ваша анкета отправлена.</p></div>';
		else
			echo '<div class="sent-block"><img width=170px src="/img/e_mail_b.jpg" /><p>Your article have been sent.</p></div>';
	}
	
  if ($_SESSION[lang]=="/en") $param='en'; else $param="";

  
  $dig1j=rand(1,10)*10;
  $dig2j=rand(0,10);
  
//  print_r($rows);

//print_r($rows);
   
  ?>

	<form name="feedform" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onSubmit="return FeedCheck('<?=@$param?>')">
<? if($result == false)
{
   if ($_SESSION[lang] !='/en')
   {
	echo " <table width='90%' cellpadding='0' cellspacing='0' border='0'> ";
	/*echo  "   <tr><td width='37%' align='right'>Название СМИ:</td><td width='2%'>&nbsp;</td><td width='61%' align='left'><input type='edit' name='name_smi' id='name_smi' maxlength='150' size='30'>&nbsp;<span class='red'>*</span></td></tr>";
	echo "	    <tr><td width='37%' align='right' valign=top>Адрес редакции:</td><td width='2%' valign=top>&nbsp;</td><td width='61%' align='left'>
	<textarea name='adress' id='adress' rows='2' cols='54'></textarea>&nbsp;*</td></tr>";*/
	echo  "   <tr><td width='37%' align='right'>ФИО:</td><td width='2%'>&nbsp;</td><td width='61%' align='left'><input type='edit' name='fio' id='fio' maxlength='150' size='30'>&nbsp;<span class='red'>*</span></td></tr>";
	echo "	    <tr><td width='37%' align='right'>Дата рождения:</td><td width='2%'>&nbsp;</td><td width='61%' align='left'><input type='date' name='telephone' id='telephone' maxlength='50' size='30'>&nbsp;<span class='red'>*</span></td></tr>";
       /*echo "	    <tr><td width='37%' align='right'>E-mail редакции:</td><td width='2%'>&nbsp;</td><td width='61%' align='left'><input type='edit' name='email' id='email' maxlength='50' size='30'>&nbsp;<span class='red'>*</span></td></tr>";*/
       echo  "   <tr><td width='37%' align='right'>Телефон:</td><td width='2%'>&nbsp;</td><td width='61%' align='left'><input type='edit' name='fio_jour' id='fio_jour' maxlength='150' size='30'></td></tr>";
       echo "	    <tr><td width='37%' align='right'>E-mail:</td><td width='2%'>&nbsp;</td><td width='61%' align='left'><input type='edit' name='email2' id='email2' maxlength='50' size='30'>&nbsp;<span class='red'>*</span></td></tr>";
	echo "	    <tr><td width='37%' align='right' valign=top>Высшее образование//квалификация//ученая степень//ученое звание:</td><td width='2%' valign=top>&nbsp;</td><td width='61%' align='left'>
	<textarea name='fio_photo' id='fio_photo' rows='4' cols='54'></textarea>&nbsp;*</td></tr>";
	echo "	    <tr><td width='37%' align='right' valign=top>Стаж и опыт работы:</td><td width='2%' valign=top>&nbsp;</td><td width='61%' align='left'>
	<textarea name='devices' id='devices' rows='4' cols='54'></textarea>&nbsp;*</td></tr>";
	echo "	    <tr><td width='37%' align='right' valign=top>Область науки и научное направление:</td><td width='2%' valign=top>&nbsp;</td><td width='61%' align='left'>
	<textarea name='mobilephone' id='mobilephone' rows='4' cols='54'></textarea>&nbsp;*</td></tr>";
	echo "	    <tr><td width='37%' align='right' valign=top>Перечень ранее полученных результатов(*):</td><td width='2%' valign=top>&nbsp;</td><td width='61%' align='left'>
	<textarea name='doljn' id='doljn' rows='4' cols='54'></textarea>&nbsp;*</td></tr>";

	echo  "   <tr ><td valign='top' colspan='3'><br /><b>Защита от спама.</b> <br />Пожалуйста, введите сумму двух чисел: <strong>".$dig1j."+".$dig2j."=</strong>"."
	         <input type='edit' name='digj' ID='digj' maxlength='50' size='5' >".
	         "<span class='red'>*</span></td></tr>";
      echo "<input type='hidden' value='".$dig1j."' name='dig1j' id='dig1j'>".
           "<input type='hidden' value='".$dig2j."' name='dig2j' id='dig2j'>";
	echo "	  </table>";
    }
	else
	{

	}
	echo "	  <br/>";
	echo "		<br />";
	echo "		<br />";
	echo "		<br />";
	if ($_SESSION[lang] !='/en')
		echo "	  <input type='submit' name='Submit' value='Отправить'>";
	//else
   		//echo "	  <input type='submit' name='Submit' value='Send'>";

	}
?>
	</form>
<?
    if($result == false) {
        if ($_SESSION[lang] != '/en') {
            echo "<p style='color: grey'>(*) - перечни ранее полученных результатов за период не менее пяти лет до даты проведения Конкурса с указанием электронных ссылок на выполненные работы и (или) полученные результаты: список научных трудов; список грантов и договоров на выполнение научно-исследовательских работ, включая  международные проекты, в  выполнении которых участвовал претендент; список экспертно-аналитических материалов, подготовленных претендентом; список докладов на научных конференциях, в том числе международных; программы подготовки научно-педагогических кадров в аспирантуре с указанием числа лиц, освоивших эти программы; число аспирантов, успешно защитивших научно-квалификационную работу (диссертацию), руководство которыми осуществлял претендент, и так далее.</p>";
        }
    }
?>
	<br clear="all">
	<p>
<?

	if (!empty($_POST)) {
		if($result==false)
		{
    	      if ($_SESSION[lang]!='/en')
				echo "Ошибка отправки. Повторите еще раз";
			  else
                echo "Error sending. Say it again";			  
         }
		 if ($_SESSION[lang]!='/en')
			echo "<b>".$_TPL_REPLACMENT["RESULT"]."</b>";
		 else	
		    echo "<b>".$_TPL_REPLACMENT["RESULT_EN"]."</b>";
    }

?>
</p>

<?
function send_mime_mail($name_from, // имя отправителя
                        $email_from, // email отправителя
                        $name_to, // имя получателя
                        $email_to, // email получателя
                        $data_charset, // кодировка переданных данных
                        $send_charset, // кодировка письма
                        $subject, // тема письма
                        $body // текст письма
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