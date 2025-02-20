<?
	global $DB,$_CONFIG, $site_templater;


    	if(isset($_POST['Submit']))
	    {


// Загрузка
// Записать в базу

          $cont=$DB->select("SELECT id FROM comment_reg WHERE login='".$_POST[login]."'");
          if (count($cont)>0)
          {
          	 $result='login';
          }
          else
          {
	       if (!empty($_POST[surname]))


               echo $filename;
	           $a=$DB->query("INSERT INTO comment_reg (id, surname, name, fname, about,
	                          region, email2,
	                          login,psw,
	                          email, phone,
	                          work,interes,avatar,
	                          date
	                         ) VALUES
	                          (".
					            "0,".
					            "'".$_POST['surname']. "',".
					            "'".$_POST['name']. "',".
					            "'".$_POST['fname']. "',".
					            "'".$_POST['about']."',".
						        "'".$_POST['region']."',".
						        "'".$_POST['email2']."',".

						        "'".$_POST['login']."',".
						        "'".$_POST['password']."',".

						        "'".$_POST['email']."',".
				    		    "'".$_POST['phone']."',".

						        "'".$_POST['work']."',".
						        "'".$_POST['interes']."',".
						        "'".$filename."',".

						        "'".date(Ymd)."')"
			   );
		 $result="true";


		 }
      }






	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
?>

<script language="JavaScript">
function check_email(email) {
  var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return filter.test(email);
}


function MyFBCheckReg(dig1,dig2) {

    if (document.fbformreg.surname.value=="") {
	alert("Вы не ввели фамилию");
	return false;
  }
  if (document.fbformreg.name.value=="") {
	alert("Вы не ввели имя");
	return false;
  }

  if (document.fbformreg.work.value=="") {
	alert("Вы не указали место работы или учебы");
	return false;
  }
  if (document.fbformreg.interes.value=="") {
	alert("Вы не указали сферу научных интерtсов");
	return false;
  }

  if (document.fbformreg.region.value=="") {
	alert("Пожалуйста, укажите регион");
	return false;
  }
  if (document.fbformreg.email2.value!="")
  {
	  if (!check_email(document.fbform.email2.value)) {
		alert("Не правильный формат публичного e-mail");
		return false;
      }
  }
  if (document.fbformreg.login.value=="") {
	alert("Вы не ввели логин");
	return false;
  }
  if (document.fbformreg.password.value=="") {
	alert("Вы не ввели пароль");
	return false;
  }
  if (document.fbformreg.password.value.length<5)
  {
  	  alert("Слишком короткий пароль");
      return false;
  }
  if (document.fbformreg.password.value!==document.fbformreg.password2.value) {
	alert("Введенные пароли не совпадают");
	return false;
  }
  if (!check_email(document.fbformreg.email.value)) {
		alert("Не правильный формат e-mail");
		return false;
  }
   return(spamreg(dig1,dig2));

}
function spamreg(dig1,dig2)
{
	 var sum=document.fbform.dig.value;
	 if(dig1+dig2!=sum)
	 {

	 	alert("*Вы не прошли спам-контроль");
	 	return false
	 }
}

</script>

	<h1><?=@$_TPL_REPLACMENT["CONTENT_HEADER"]?></h1>
	<?

	if($result == false || $result== 'login')
	{
		echo $_TPL_REPLACMENT["CONTENT"];
	}

     if ($result=='login')
     {
        echo "<font color=red><strong>Логин ".$_POST[login]." уже занят. Введите другой</font></strong><br /><br />";
        $result=false;
      }
        $region0=$DB->select("SELECT *,INTERVAL(191,ASCII(region)) as lang FROM abstract_region ORDER BY lang,region");
$dig1=rand(1,10)*10;
$dig2=rand(0,10);
if($result == false)
{

?>
	<form name="fbformreg" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onSubmit="return MyFBCheckReg(<?=@$dig1?>,<?=@$dig2?>)">
<?

 	echo " <table width='100%' cellpadding='2' cellspacing='2' border='0'> ";
 	echo "<tr bgcolor=#efefef><td colspan='3'><b>Пожалуйста, представьтесь:</b></td><tr>";
	echo  "   <tr ><td  width='35%' align='right'><span  value=".$_POST[surname].">Фамилия:</span></td><td width='2%'>&nbsp;</td><td width='71%' align='left'>
	         <input type='edit' name='surname' maxlength='50' size='30' value='".$_POST[surname]."'>&nbsp;<span class='red'>*</span></td></tr>";

	echo  "   <tr ><td width='35%' align='right'><span >Имя:</span></td><td width='2%'>&nbsp;</td><td width='71%' align='left'>
	          <input type='edit' name='name' maxlength='50' size='20' value='".$_POST[name]."'>&nbsp;<span class='red'>*</span></td></tr>";
	echo  "   <tr  ><td width='35%'   align='right' ><span >Отчество:</span></td><td width='2%'>&nbsp;</td><td width='71%' align='left'>
	          <input type='edit' name='fname' maxlength='50' size='30' value='".$_POST[fname]."'>&nbsp;<span class='red'></span></td></tr>";

	echo  "   <tr ><td width='35%' align='right' value='".$_POST[abouut]."'><span >Краткие сведения о себе:</span></td><td width='2%'>&nbsp;</td><td width='71%' align='left'>
                  <input type='edit' name='about' maxlength='250' size='50'>&nbsp;<span class='red'></span><br />";
	echo "  <font size='1'>(коротко, одной строкой, публикуется под фамилией автора)</font></td></tr>";
    echo  "   <tr ><td width='35%' align='right' valign='top' value='".$_POST[work]."'><span >Место работы (учебы):</span></td><td width='2%'>&nbsp;</td><td width='71%' align='left'>
                  <input type='edit' name='work' maxlength='250' size='50'>&nbsp;<span class='red'>*</span><br />";
    echo " <font size='1'>(укажите наиболее значимое для Вас)</font></td></tr>";
    echo  "   <tr ><td width='35%' align='right' value='".$_POST[interes]."'><span >Сфера научных интересов:</span></td><td width='2%'>&nbsp;</td><td width='71%' align='left'>
                  <input type='edit' name='interes' maxlength='250' size='50'>&nbsp;<span class='red'>*</span></td></tr>";
    echo "	    <tr  ><td width='35%' align='right' valign='middle'><span >Регион:</span></td>
                <td width='2%'>&nbsp;</td>
                <td width='71%' align='left' valign='top'><select name='region' >";
    echo "<option value=''></option>";

        foreach($region0 as $region)
        {
         	if ($_POST[region]==$region[id]) $sel='selected'; else $sel="";
         	echo "<option value='".$region[id]."' ".$sel. ">".$region[region]."</option>\n";
	    }
       echo "</select>*";
       echo "</td></tr>";
       echo "<tr  ><td width='35%' align='right'><span >Публичный e-mail:</span></td><td width='2%'>&nbsp;</td><td width='71%' align='left'>
	         <input type='edit' name='email2' maxlength='50' size='50' value='".$_POST[email2]."'>&nbsp;<span class='red'></span></td></tr>";

       echo "<tr><td colspan='3'>&nbsp;</td></tr>";
       echo "<tr bgcolor=#efefef><td colspan='3'><strong>Укажите:</strong></td></tr>";
  	   echo "<tr ><td width='35%' align='right'><span >Логин:</span></td><td width='2%'>&nbsp;</td><td width='71%' align='left'>
             <input type='edit' name='login' maxlength='250' size='50' value='".$_POST[login]."'>&nbsp;<span class='red'>*</span></td></tr>";
  	   echo "<tr ><td width='35%' align='right'><span >Пароль:</span></td><td width='2%'>&nbsp;</td><td width='71%' align='left'>
             <input type='password' name='password' maxlength='250' size='50'>&nbsp;<span class='red'>*</span></td></tr>";
       echo "<tr ><td width='35%' align='right'><span >Подтверждение пароля:</span></td><td width='2%'>&nbsp;</td><td width='71%' align='left'>
             <input type='password' name='password2' maxlength='250' size='50'>&nbsp;<span class='red'>*</span></td></tr>";


       echo "<tr><td colspan='3'>&nbsp;</td></tr>";
       echo "<tr bgcolor=#efefef><td colspan='3'><strong>Информация для администрации проекта</strong></td></tr>";
       echo "<tr ><td width='35%' align='right'><span >Контактный e-mail:</span></td><td width='2%'>&nbsp;</td><td width='71%' align='left'>
	          <input type='edit' name='email' maxlength='50' size='50' value='".$_POST[email]."'>&nbsp;<span class='red'>*</span></td></tr>";
       echo "<tr ><td>&nbsp;</td><td width='2%'>&nbsp;</td>
             <td><font size='1'>(e-mail не публикуется, но может использоваться администрацией сайта для уточнения информации)</font></td></tr>";


 	   echo "<tr ><td width='35%' align='right'><span >Контактный телефон:</span></td><td width='2%'>&nbsp;</td><td width='71%' align='left'>
	           <input type='edit' name='phone' maxlength='50' size='50' value='".$_POST[phone]."'>&nbsp;<span class='red'></span></td></tr>";

       echo "<tr ><td>&nbsp;</td><td width='2%'>&nbsp;</td>
              <td><font size='1'>(телефон не публикуется, но может использоваться администрацией сайта для уточнения информации)</font></td></tr>";
       echo "<tr><td colspan='3'>&nbsp;</td></tr>";

      echo "<tr bgcolor=#efefef><td colspan='3'><strong>Защита от спама</strong></td></tr>";
       echo  "   <tr ><td valign='top' >Пожалуйста, введите сумму двух чисел: <strong>".$dig1."+".$dig2."=</strong></td><td></td><td width='71%' align='left'>".
	        " <br /><input type='edit' id='dig' name='dig' maxlength='50' size='5' onChange=spamreg(".$dig1.",".$dig2.")>".
	         "<span class='red'>*</span></td></tr>";
      echo "<input type='hidden' value='".$dig1."' name='dig1'>".
           "<input type='hidden' value='".$dig2."' name='dig2'>";
	   echo "</table>";
	   echo "<br/>";

	  echo "<br />";
	  echo "<blockquote dir='ltr' style='margin-right: 0px'><blockquote dir='ltr' style='margin-right: 0px'><blockquote dir='ltr' style='margin-right: 0px'>
          	 <input type='submit' name='Submit' value='Отправить'>";
      echo "</form>";

}

?>

	<br clear="all">
	<p>
<?
/*
   if((substr($my_upload->show_error_string(),0,3) == "Фай") &&($result=="true"))
    {


	    echo $my_upload->show_error_string();
	    echo "<b>".$_TPL_REPLACMENT["RESULT"]."</b>";
    }
            else
    {




echo "<br />".$temp;

           echo $my_upload->show_error_string();



    }


*/
if ($result=="true")
{
        echo "Поздравляем! Вы успешно прошли  регистрацию!<br />";

	    echo "<b>".$_TPL_REPLACMENT["RESULT"]."</b>";
//	    if (empty($_FILES['upload1']['tmp_name']))


}
else
 {
        
		if (!empty($_REQUEST[submit]))
		 echo "Извините! При регистрации возникли ошибки";
 }
   if (!empty($_REQUEST[ret])) $ret="/index.php?page_id=".$_REQUEST[ret];else $ret="/";

   echo "<br /><br /><a href=".$ret.">вернуться на страницу</a>";

?>
</p>


<?

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>