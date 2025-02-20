<?
	global $_CONFIG, $site_templater;
  //  include ('Mail.php');
//	include ($_SERVER['DOCUMENT_ROOT'] . 'mail_auth.ini');
	$result=0;
	$conn = mysql_connect("localhost",$_CONFIG["global"]["db_connect"]["login"] ,$_CONFIG["global"]["db_connect"]["password"] ) or die(mysql_error());
	mysql_select_db($_CONFIG["global"]["db_connect"]["db_name"], $conn) or die(mysql_error());
    $dig1=rand(1,10)*10;
    $dig2=rand(0,10);
	$sumdig=$dig1+$dig2;
	if(isset($_POST['Submit']) && !empty($_POST[fio]) && !empty($_POST[country]) && !empty($_POST[region]))
	{
		//include_once $_SERVER['DOCUMENT_ROOT'] . '/securimage/securimage.php';
		/*$securimage = new Securimage();
		if ($securimage->check($_POST['captcha_code']) == false) {
			if($_SESSION[lang]!="/en")
			{
				echo "Неверный код защиты от спама.<br /><br />";
				echo "Пожалуйста <a href='javascript:history.go(-1)'>вернитесь</a> и попробуйте снова.";
			}
			else
			{
				echo "The security code entered was incorrect.<br /><br />";
				echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
			}
			exit;
		}*/

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
            $to3='shefnew@gmail.com';
            $to4='delo@isras.ru';
            $to5='delo@isras.ru';

            $nn="\r\n";

            $data =  "Обратная связь:".$nn.
                "ФИО: ".$_POST["fio"].", ".$nn.
                "Страна: ".$_POST["country"].", ".$nn.
                "Регион: ".$_POST["region"].", ".$nn.
                "Вид деятельности: ".$_POST["vid"].", ".$nn.
                "Область научных интересов: ".$_POST["nauka"].", ".$nn.
                "Email: ".$_POST["email"].", ".$nn.
                "Телефон: ".$_POST["telephone"].", ".$nn.
                "Вопрос / предложение: ".$_POST["text"]
            ;
///////
            $subject = '=?koi8-r?B?'.base64_encode(convert_cyr_string("Обратная связь (ИМЭМО)", "w","k")).'?=';



// Записать в базу
            //mail("shefnew@gmail.com",$subject,$data);
            mail("alexqw1@yandex.ru", $subject, $data);
            mail("jungoo.work@gmail.com", $subject, $data);
            if (mysql_query("INSERT INTO feedback VALUES(" .
                "0," .
                "'" . $_POST['fio'] . "'," .
                "'" . $_POST['country'] . "'," .
                "'" . $_POST['region'] . "'," .
                "'" . $_POST['vid'] . "'," .
                "'" . $_POST['nauka'] . "'," .
                "'" . $_POST['email'] . "'," .
                "'" . $_POST['telephone'] . "'," .
                "'" . $_POST['text'] . "'," .
                "'" . date(Ymd) . "')")
            )
                $result = "true";
            else $result = "false";
        }
  }


	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
?>
<script language="JavaScript">
function check_email(email) {
  var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return filter.test(email);
}

function FeedCheck(param,dig1,dig2) {

    $('.invalid-feedback').remove();
    $('.is-valid').removeClass('is-valid');
    $('.is-invalid').removeClass('is-invalid');

    var success = true;

    if (param!="en") {
        if(!checkParam("fio", "Не введено ФИО")) {
            success = false;
        }
        if(!checkParam("country", "Не введена страна")) {
            success = false;
        }
        if(!checkParam("region", "Не введен регион")) {
            success = false;
        }
        if(!checkParam("vid", "Не введен вид деятельности")) {
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
    } else {
        if(!checkParam("fio", "Your name is not entered")) {
            success = false;
        }
        if(!checkParam("country", "Country is not entered")) {
            success = false;
        }
        if(!checkParam("region", "City is not entered")) {
            success = false;
        }
        if(!checkParam("vid", "Type of activity is not entered")) {
            success = false;
        }
        if(!checkParam("email", "E-mail is not entered")) {
            success = false;
        } else {
            if (!check_email(document.getElementById("email").value)) {
                $("#email").parent().append("<div class=\"invalid-feedback\">E-mail is failed</div>");
                $("#email").removeClass('is-valid');
                $("#email").addClass('is-invalid');
                success = false;
            }
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
 return(spamfb(param)); 
}
function spamfb(param)
{
	
	
	var sum=document.getElementById('dig0').value;
//	alert("!"+sum);
	var dig1=document.getElementById('dig01').value;
	var dig2=document.getElementById('dig02').value;
//	alert("@@"+dig1+" "+dig2+" " +sum+" "+(Number(dig1)+Number(dig2)));
 	/*if((Number(dig1)+Number(dig2))!=sum)
	 {
	 	if (param!="en")	
			alert("Вы не прошли спам-контроль");
		else alert("You did not complete spam control");
	 	return false
	 }*/
	 //else
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
  if ($_SESSION[lang]=="/en") $param='en'; else $param="";
  $dig1=rand(1,10)*10;
    $dig2=rand(0,10);
	$sumdig=$dig1+$dig2;
?>

	<form name="feedform" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onSubmit="return FeedCheck('<?=@$param?>',<?=$dig1?>,<?=$dig2?>)">
<? if($result == false)
{
  
   if ($_SESSION[lang] !='/en')
   {
       ?>
       <div class="form-group">
           <label for="fio">ФИО (*)</label>
           <input type='text' name='fio' id='fio' class="form-control" placeholder="">
       </div>
       <div class="form-group">
           <label for="country">Страна (*)</label>
           <input type='text' name='country' id='country' class="form-control" placeholder="">
       </div>
       <div class="form-group">
           <label for="region">Регион, город, село и т.д. (*)</label>
           <input type='text' name='region' id='region' class="form-control" placeholder="">
       </div>
       <div class="form-group">
           <label for="vid">Вид деятельности (*)</label>
           <input type='text' name='vid' id='vid' class="form-control" placeholder="">
       </div>
       <div class="form-group">
           <label for="nauka">Область научных интересов</label>
           <input type='text' name='nauka' id='nauka' class="form-control" placeholder="">
       </div>
       <div class="form-group">
           <label for="email">Контактный e-mail (*)</label>
           <input type="email" class="form-control" name='email' id='email' placeholder="name@example.com">
       </div>
       <div class="form-group">
           <label for="telephone">Контактный телефон</label>
           <input type='text' name='telephone' id='telephone' class="form-control" placeholder="">
       </div>
       <div class="form-group">
           <label for="text">Ваш вопрос или предложение</label>
           <textarea class="form-control" name='text' id='text' rows="10"></textarea>
       </div>
       <div class="form-group">
           <label for="spamp">Защита от спама (*)</label>
           <div class="g-recaptcha" data-sitekey="6LecaG8UAAAAADsh6X_qAAM9NVd26fZggzJwh-HJ" name="spamp" id="spamp"></div>
       </div>

        <?php

    }
	else
	{
	    ?>

        <div class="form-group">
            <label for="fio">Your name (*)</label>
            <input type='text' name='fio' id='fio' class="form-control" placeholder="">
        </div>
        <div class="form-group">
            <label for="country">Country (*)</label>
            <input type='text' name='country' id='country' class="form-control" placeholder="">
        </div>
        <div class="form-group">
            <label for="region">City (*)</label>
            <input type='text' name='region' id='region' class="form-control" placeholder="">
        </div>
        <div class="form-group">
            <label for="vid">Type of activity (*)</label>
            <input type='text' name='vid' id='vid' class="form-control" placeholder="">
        </div>
        <div class="form-group">
            <label for="nauka">Research interests</label>
            <input type='text' name='nauka' id='nauka' class="form-control" placeholder="">
        </div>
        <div class="form-group">
            <label for="email">E-mail (*)</label>
            <input type="email" class="form-control" name='email' id='email' placeholder="name@example.com">
        </div>
        <div class="form-group">
            <label for="telephone">Phone</label>
            <input type='text' name='telephone' id='telephone' class="form-control" placeholder="">
        </div>
        <div class="form-group">
            <label for="text">Your question or suggestion</label>
            <textarea class="form-control" name='text' id='text' rows="10"></textarea>
        </div>
        <div class="form-group">
            <label for="spamp">Spam protection (*)</label>
            <div class="g-recaptcha" data-sitekey="6LecaG8UAAAAADsh6X_qAAM9NVd26fZggzJwh-HJ" name="spamp" id="spamp"></div>
        </div>

        <?php

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
    	      if ($_SESSION[lang]!='/en')
				echo "Ошибка отправки. Повторите еще раз";
			  else
                echo "Error sending. Say it again";			  
         } else {
            if ($_SESSION[lang]!='/en')
                echo "Письмо отправлено.";
            else
                echo "Mail was sent.";
        }
		 echo "<b>".$_TPL_REPLACMENT["RESULT"]."</b>";
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