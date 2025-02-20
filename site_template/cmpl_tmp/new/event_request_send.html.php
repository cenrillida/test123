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
	

	
	if(isset($_POST['Submit']))
	{
        $response = $_POST["g-recaptcha-response"];
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data_captcha['secret'] = '6LecaG8UAAAAAHtU8Ee0sF7_oxV61LBV8U1zHCun';
        $data_captcha['response'] = $_POST["g-recaptcha-response"];
        $options['http']['method'] = "POST";
        $options['http']['content'] = http_build_query($data_captcha);

        $context  = stream_context_create($options);
        $verify = file_get_contents($url, false, $context);
        $captcha_success=json_decode($verify);
        if ($captcha_success->success==false) {
            if($_SESSION[lang]!="/en")
            {
                echo "Не пройдена проверка от спама.<br /><br />";
                echo "Пожалуйста <a href='javascript:history.go(-1)'>вернитесь</a> и попробуйте снова.";
            }
            else
            {
                echo "Spam protection failed.<br /><br />";
                echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
            }
            exit;
        } else if ($captcha_success->success==true) {
            $from = 'feedback@isras.ru';
            $to = 'shef@isras.ru';
            $to3 = 'shefnew@gmail.com';
            $to4 = 'delo@isras.ru';
            $to5 = 'delo@isras.ru';

            $nn = "<br>";

            $data = "Обратная связь:" . $nn .
                "Мероприятие: " . $_POST["name_event"] . ", " . $nn .
                "Дата: " . $_POST["date"] . ", " . $nn .
                "Время: " . $_POST["time"] . ", " . $nn .
                "Название СМИ: " . $_POST["name_smi"] . ", " . $nn .
                "Адрес редакции: " . $_POST["adress"] . ", " . $nn .
                "ФИО главного редактора: " . $_POST["fio"] . ", " . $nn .
                "Контактный телефон редакции: " . $_POST["telephone"] . ", " . $nn .
                "E-mail редакции: " . $_POST["email"] . ", " . $nn .
                "ФИО аккредитованного журналиста: " . $_POST["fio_jour"] . ", " . $nn .
                "Должность: " . $_POST["doljn"] . ", " . $nn .
                "Мобильный телефон: " . $_POST["mobilephone"] . ", " . $nn .
                "E-mail: " . $_POST["email2"] . ", " . $nn .
                "ФИО оператора/фотографа: " . $_POST["fio_photo"] . ", " . $nn .
                "Вносимое фото/телеоборудование: " . $_POST["devices"];
///////
            $subject = '=?koi8-r?B?' . base64_encode(convert_cyr_string("Обратная связь (ИМЭМО)", "w", "k")) . '?=';
//////  Загрузка /////
            send_mime_mail("ИМЭМО РАН", "presscenter@imemo.ru", "Пресс-центр", "presscenter@imemo.ru", "cp1251", "utf-8", "Анкета для аккредитации СМИ", $data);
            $result = true;
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

    $('.invalid-feedback').remove();
    $('.is-valid').removeClass('is-valid');
    $('.is-invalid').removeClass('is-invalid');

    var success = true;

    if (param!="en") {
        if(!checkParam("name_event", "Не введено мероприятие")) {
            success = false;
        }
        if(!checkParam("date", "Не введена дата")) {
            success = false;
        }
        if(!checkParam("time", "Не введено время")) {
            success = false;
        }
        if(!checkParam("fio", "Не введено ФИО главного редактора")) {
            success = false;
        }
        if(!checkParam("adress", "Не введен адрес редакции")) {
            success = false;
        }
        if(!checkParam("telephone", "Не введен контактный телефон редакции")) {
            success = false;
        }
        if(!checkParam("fio_jour", "Не введено ФИО аккредитованного журналиста")) {
            success = false;
        }
        if(!checkParam("doljn", "Не введена должность")) {
            success = false;
        }
        if(!checkParam("mobilephone", "Не введен мобильный телефонь")) {
            success = false;
        }
        if(!checkParam("fio_photo", "Не введено ФИО фотографа или оператора")) {
            success = false;
        }
        if(!checkParam("devices", "Не введено вносимое оборудование")) {
            success = false;
        }
        if(!checkParam("name_smi", "Не введено название СМИ")) {
            success = false;
        }
        if(!checkParam("email", "Не указан e-mail")) {
            success = false;
        } else {
            if (!check_email(document.getElementById("email").value)) {
                $("#email").parent().append("<div class=\"invalid-feedback\">Неприемлимый формат email</div>");
                $("#email").removeClass('is-valid');
                $("#email").addClass('is-invalid');
                success = false;
            }
        }
        if(!checkParam("email2", "Не указан e-mail")) {
            success = false;
        } else {
            if (!check_email(document.getElementById("email2").value)) {
                $("#email2").parent().append("<div class=\"invalid-feedback\">Неприемлимый формат email</div>");
                $("#email2").removeClass('is-valid');
                $("#email2").addClass('is-invalid');
                success = false;
            }
        }
    } else {
        if(!checkParam("name_event", "Event is not entered")) {
            success = false;
        }
        if(!checkParam("date", "Date is not entered")) {
            success = false;
        }
    }
    if(!success) {
        return false;
    }

    if (!grecaptcha.getResponse()) {
        if (param!="en")
            alert("Пройдите спам проверку");
        else alert("Spam protection failed");
        return false;
    }
 
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
	 // if(Number(d1)+Number(d2)!=Number(sum))
	 // {
     //     $("#digj").parent().append("<div class=\"invalid-feedback\">Вы не прошли спам-контроль</div>");
     //     $("#digj").addClass('is-invalid');
	 // 	return false
	 // }
	 return true;
}
function checkParam(attr,text) {
    if (document.getElementById(attr).value=="") {
        $("#"+attr).parent().append("<div class=\"invalid-feedback\">"+text+"</div>");
        $("#"+attr).addClass('is-invalid');
        return false;
    } else {
        $("#"+attr).addClass('is-valid');
    }
    return true;
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
       if($_GET[debug]!=10) {
           ?>
           <div class="form-group">
               <label for="name_event">Мероприятие (*)</label>
               <input type='text' name='name_event' id='name_event' class="form-control" placeholder="">
           </div>
           <div class="form-group">
               <label for="date">Дата (*)</label>
               <input type='date' name='date' id='date' class="form-control date-form-width" placeholder="">
           </div>
           <div class="form-group">
               <label for="time">Время (*)</label>
               <input type='text' name='time' id='time' class="form-control" placeholder="">
           </div>
           <div class="form-group">
               <label for="name_smi">Название СМИ (*)</label>
               <input type='text' name='name_smi' id='name_smi' class="form-control" placeholder="">
           </div>
           <div class="form-group">
               <label for="adress">Адрес редакции (*)</label>
               <textarea class="form-control" name='adress' id='adress' rows="2"></textarea>
           </div>
           <div class="form-group">
               <label for="fio">ФИО главного редактора (*)</label>
               <input type='text' name='fio' id='fio' class="form-control" placeholder="">
           </div>
           <div class="form-group">
               <label for="telephone">Контактный телефон редакции (*)</label>
               <input type='text' name='telephone' id='telephone' class="form-control" placeholder="">
           </div>
           <div class="form-group">
               <label for="email">E-mail редакции (*)</label>
               <input type="email" class="form-control" name='email' id='email' placeholder="name@example.com">
           </div>
           <div class="form-group">
               <label for="fio_jour">ФИО аккредитованного журналиста (*)</label>
               <input type='text' name='fio_jour' id='fio_jour' class="form-control" placeholder="">
           </div>
           <div class="form-group">
               <label for="doljn">Должность (*)</label>
               <input type='text' name='doljn' id='doljn' class="form-control" placeholder="">
           </div>
           <div class="form-group">
               <label for="mobilephone">Мобильный телефон (*)</label>
               <input type='text' name='mobilephone' id='mobilephone' class="form-control" placeholder="">
           </div>
           <div class="form-group">
               <label for="email2">E-mail (*)</label>
               <input type="email" class="form-control" name='email2' id='email2' placeholder="name@example.com">
           </div>
           <div class="form-group">
               <label for="fio_photo">ФИО оператора//фотографа (*)</label>
               <textarea class="form-control" name='fio_photo' id='fio_photo' rows="2"></textarea>
           </div>
           <div class="form-group">
               <label for="devices">Вносимое фото//телеоборудование (*)</label>
               <textarea class="form-control" name='devices' id='devices' rows="2"></textarea>
           </div>
           <div class="form-group">
               <label for="spamp"><b>Защита от спама (*)</b></label>
               <div class="g-recaptcha" data-sitekey="6LecaG8UAAAAADsh6X_qAAM9NVd26fZggzJwh-HJ" name="spamp" id="spamp"></div>
           </div>
           <?php
       } else {


           echo " <table width='90%' cellpadding='0' cellspacing='0' border='0'> ";
           echo "   <tr><td width='37%' align='right'>Мероприятие:</td><td width='2%'>&nbsp;</td><td width='61%' align='left'><input type='text' name='name_event' id='name_event' maxlength='150' size='30'>&nbsp;<span class='red'>*</span></td></tr>";
           echo "   <tr><td width='37%' align='right'>Дата:</td><td width='2%'>&nbsp;</td><td width='61%' align='left'><input type='date' name='date' id='date' maxlength='150' size='30'>&nbsp;<span class='red'>*</span></td></tr>";
           echo "   <tr><td width='37%' align='right'>Время:</td><td width='2%'>&nbsp;</td><td width='61%' align='left'><input type='edit' name='time' id='time' maxlength='150' size='30'>&nbsp;<span class='red'>*</span></td></tr>";
           echo "   <tr><td width='37%' align='right'>Название СМИ:</td><td width='2%'>&nbsp;</td><td width='61%' align='left'><input type='edit' name='name_smi' id='name_smi' maxlength='150' size='30'>&nbsp;<span class='red'>*</span></td></tr>";
           echo "	    <tr><td width='37%' align='right' valign=top>Адрес редакции:</td><td width='2%' valign=top>&nbsp;</td><td width='61%' align='left'>
	<textarea name='adress' id='adress' rows='2' cols='54'></textarea>&nbsp;*</td></tr>";
           echo "   <tr><td width='37%' align='right'>ФИО главного редактора:</td><td width='2%'>&nbsp;</td><td width='61%' align='left'><input type='edit' name='fio' id='fio' maxlength='150' size='30'>&nbsp;<span class='red'>*</span></td></tr>";
           echo "	    <tr><td width='37%' align='right'>Контактный телефон редакции:</td><td width='2%'>&nbsp;</td><td width='61%' align='left'><input type='edit' name='telephone' id='telephone' maxlength='50' size='30'>&nbsp;<span class='red'>*</span></td></tr>";
           echo "	    <tr><td width='37%' align='right'>E-mail редакции:</td><td width='2%'>&nbsp;</td><td width='61%' align='left'><input type='edit' name='email' id='email' maxlength='50' size='30'>&nbsp;<span class='red'>*</span></td></tr>";
           echo "   <tr><td width='37%' align='right'>ФИО аккредитованного журналиста:</td><td width='2%'>&nbsp;</td><td width='61%' align='left'><input type='edit' name='fio_jour' id='fio_jour' maxlength='150' size='30'>&nbsp;<span class='red'>*</span></td></tr>";
           echo "   <tr><td width='37%' align='right'>Должность:</td><td width='2%'>&nbsp;</td><td width='61%' align='left'><input type='edit' name='doljn' id='doljn' maxlength='150' size='30'>&nbsp;<span class='red'>*</span></td></tr>";
           echo "   <tr><td width='37%' align='right'>Мобильный телефон:</td><td width='2%'>&nbsp;</td><td width='61%' align='left'><input type='edit' name='mobilephone' id='mobilephone' maxlength='150' size='30'>&nbsp;<span class='red'>*</span></td></tr>";
           echo "	    <tr><td width='37%' align='right'>E-mail:</td><td width='2%'>&nbsp;</td><td width='61%' align='left'><input type='edit' name='email2' id='email2' maxlength='50' size='30'>&nbsp;<span class='red'>*</span></td></tr>";
           echo "	    <tr><td width='37%' align='right' valign=top>ФИО оператора//фотографа:</td><td width='2%' valign=top>&nbsp;</td><td width='61%' align='left'>
	<textarea name='fio_photo' id='fio_photo' rows='2' cols='54'></textarea>&nbsp;*</td></tr>";
           echo "	    <tr><td width='37%' align='right' valign=top>Вносимое фото//телеоборудование:</td><td width='2%' valign=top>&nbsp;</td><td width='61%' align='left'>
	<textarea name='devices' id='devices' rows='2' cols='54'></textarea>&nbsp;*</td></tr>";

           echo "   <tr ><td valign='top' colspan='3'><br /><b>Защита от спама.</b> <br />Пожалуйста, введите сумму двух чисел: <strong>" . $dig1j . "+" . $dig2j . "=</strong>" . "
	         <input type='edit' name='digj' ID='digj' maxlength='50' size='5' >" .
               "<span class='red'>*</span></td></tr>";
           echo "<input type='hidden' value='" . $dig1j . "' name='dig1j' id='dig1j'>" .
               "<input type='hidden' value='" . $dig2j . "' name='dig2j' id='dig2j'>";
           echo "	  </table>";
       }
    }
	else
	{

	}
	if ($_SESSION[lang] !='/en')
		echo "	  <input type='submit' name='Submit' value='Отправить' class='btn btn-lg btn-primary imemo-button text-uppercase'>";
	else	
   		echo "	  <input type='submit' name='Submit' value='Send' class='btn btn-lg btn-primary imemo-button text-uppercase'>";

	}
?>
	</form>
	<br clear="all">
	<p>
<?

	if (!empty($_POST)) {
		if($result==false)
		{
		    var_dump($_POST);
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