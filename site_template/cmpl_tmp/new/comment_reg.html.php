<?
	global $DB,$_CONFIG, $site_templater;


    	if(isset($_POST['Submit']))
	    {


// ��������
// �������� � ����

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
	alert("�� �� ����� �������");
	return false;
  }
  if (document.fbformreg.name.value=="") {
	alert("�� �� ����� ���");
	return false;
  }

  if (document.fbformreg.work.value=="") {
	alert("�� �� ������� ����� ������ ��� �����");
	return false;
  }
  if (document.fbformreg.interes.value=="") {
	alert("�� �� ������� ����� ������� �����t���");
	return false;
  }

  if (document.fbformreg.region.value=="") {
	alert("����������, ������� ������");
	return false;
  }
  if (document.fbformreg.email2.value!="")
  {
	  if (!check_email(document.fbform.email2.value)) {
		alert("�� ���������� ������ ���������� e-mail");
		return false;
      }
  }
  if (document.fbformreg.login.value=="") {
	alert("�� �� ����� �����");
	return false;
  }
  if (document.fbformreg.password.value=="") {
	alert("�� �� ����� ������");
	return false;
  }
  if (document.fbformreg.password.value.length<5)
  {
  	  alert("������� �������� ������");
      return false;
  }
  if (document.fbformreg.password.value!==document.fbformreg.password2.value) {
	alert("��������� ������ �� ���������");
	return false;
  }
  if (!check_email(document.fbformreg.email.value)) {
		alert("�� ���������� ������ e-mail");
		return false;
  }
   return(spamreg(dig1,dig2));

}
function spamreg(dig1,dig2)
{
	 var sum=document.fbform.dig.value;
	 if(dig1+dig2!=sum)
	 {

	 	alert("*�� �� ������ ����-��������");
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
        echo "<font color=red><strong>����� ".$_POST[login]." ��� �����. ������� ������</font></strong><br /><br />";
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
 	echo "<tr bgcolor=#efefef><td colspan='3'><b>����������, �������������:</b></td><tr>";
	echo  "   <tr ><td  width='35%' align='right'><span  value=".$_POST[surname].">�������:</span></td><td width='2%'>&nbsp;</td><td width='71%' align='left'>
	         <input type='edit' name='surname' maxlength='50' size='30' value='".$_POST[surname]."'>&nbsp;<span class='red'>*</span></td></tr>";

	echo  "   <tr ><td width='35%' align='right'><span >���:</span></td><td width='2%'>&nbsp;</td><td width='71%' align='left'>
	          <input type='edit' name='name' maxlength='50' size='20' value='".$_POST[name]."'>&nbsp;<span class='red'>*</span></td></tr>";
	echo  "   <tr  ><td width='35%'   align='right' ><span >��������:</span></td><td width='2%'>&nbsp;</td><td width='71%' align='left'>
	          <input type='edit' name='fname' maxlength='50' size='30' value='".$_POST[fname]."'>&nbsp;<span class='red'></span></td></tr>";

	echo  "   <tr ><td width='35%' align='right' value='".$_POST[abouut]."'><span >������� �������� � ����:</span></td><td width='2%'>&nbsp;</td><td width='71%' align='left'>
                  <input type='edit' name='about' maxlength='250' size='50'>&nbsp;<span class='red'></span><br />";
	echo "  <font size='1'>(�������, ����� �������, ����������� ��� �������� ������)</font></td></tr>";
    echo  "   <tr ><td width='35%' align='right' valign='top' value='".$_POST[work]."'><span >����� ������ (�����):</span></td><td width='2%'>&nbsp;</td><td width='71%' align='left'>
                  <input type='edit' name='work' maxlength='250' size='50'>&nbsp;<span class='red'>*</span><br />";
    echo " <font size='1'>(������� �������� �������� ��� ���)</font></td></tr>";
    echo  "   <tr ><td width='35%' align='right' value='".$_POST[interes]."'><span >����� ������� ���������:</span></td><td width='2%'>&nbsp;</td><td width='71%' align='left'>
                  <input type='edit' name='interes' maxlength='250' size='50'>&nbsp;<span class='red'>*</span></td></tr>";
    echo "	    <tr  ><td width='35%' align='right' valign='middle'><span >������:</span></td>
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
       echo "<tr  ><td width='35%' align='right'><span >��������� e-mail:</span></td><td width='2%'>&nbsp;</td><td width='71%' align='left'>
	         <input type='edit' name='email2' maxlength='50' size='50' value='".$_POST[email2]."'>&nbsp;<span class='red'></span></td></tr>";

       echo "<tr><td colspan='3'>&nbsp;</td></tr>";
       echo "<tr bgcolor=#efefef><td colspan='3'><strong>�������:</strong></td></tr>";
  	   echo "<tr ><td width='35%' align='right'><span >�����:</span></td><td width='2%'>&nbsp;</td><td width='71%' align='left'>
             <input type='edit' name='login' maxlength='250' size='50' value='".$_POST[login]."'>&nbsp;<span class='red'>*</span></td></tr>";
  	   echo "<tr ><td width='35%' align='right'><span >������:</span></td><td width='2%'>&nbsp;</td><td width='71%' align='left'>
             <input type='password' name='password' maxlength='250' size='50'>&nbsp;<span class='red'>*</span></td></tr>";
       echo "<tr ><td width='35%' align='right'><span >������������� ������:</span></td><td width='2%'>&nbsp;</td><td width='71%' align='left'>
             <input type='password' name='password2' maxlength='250' size='50'>&nbsp;<span class='red'>*</span></td></tr>";


       echo "<tr><td colspan='3'>&nbsp;</td></tr>";
       echo "<tr bgcolor=#efefef><td colspan='3'><strong>���������� ��� ������������� �������</strong></td></tr>";
       echo "<tr ><td width='35%' align='right'><span >���������� e-mail:</span></td><td width='2%'>&nbsp;</td><td width='71%' align='left'>
	          <input type='edit' name='email' maxlength='50' size='50' value='".$_POST[email]."'>&nbsp;<span class='red'>*</span></td></tr>";
       echo "<tr ><td>&nbsp;</td><td width='2%'>&nbsp;</td>
             <td><font size='1'>(e-mail �� �����������, �� ����� �������������� �������������� ����� ��� ��������� ����������)</font></td></tr>";


 	   echo "<tr ><td width='35%' align='right'><span >���������� �������:</span></td><td width='2%'>&nbsp;</td><td width='71%' align='left'>
	           <input type='edit' name='phone' maxlength='50' size='50' value='".$_POST[phone]."'>&nbsp;<span class='red'></span></td></tr>";

       echo "<tr ><td>&nbsp;</td><td width='2%'>&nbsp;</td>
              <td><font size='1'>(������� �� �����������, �� ����� �������������� �������������� ����� ��� ��������� ����������)</font></td></tr>";
       echo "<tr><td colspan='3'>&nbsp;</td></tr>";

      echo "<tr bgcolor=#efefef><td colspan='3'><strong>������ �� �����</strong></td></tr>";
       echo  "   <tr ><td valign='top' >����������, ������� ����� ���� �����: <strong>".$dig1."+".$dig2."=</strong></td><td></td><td width='71%' align='left'>".
	        " <br /><input type='edit' id='dig' name='dig' maxlength='50' size='5' onChange=spamreg(".$dig1.",".$dig2.")>".
	         "<span class='red'>*</span></td></tr>";
      echo "<input type='hidden' value='".$dig1."' name='dig1'>".
           "<input type='hidden' value='".$dig2."' name='dig2'>";
	   echo "</table>";
	   echo "<br/>";

	  echo "<br />";
	  echo "<blockquote dir='ltr' style='margin-right: 0px'><blockquote dir='ltr' style='margin-right: 0px'><blockquote dir='ltr' style='margin-right: 0px'>
          	 <input type='submit' name='Submit' value='���������'>";
      echo "</form>";

}

?>

	<br clear="all">
	<p>
<?
/*
   if((substr($my_upload->show_error_string(),0,3) == "���") &&($result=="true"))
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
        echo "�����������! �� ������� ������  �����������!<br />";

	    echo "<b>".$_TPL_REPLACMENT["RESULT"]."</b>";
//	    if (empty($_FILES['upload1']['tmp_name']))


}
else
 {
        
		if (!empty($_REQUEST[submit]))
		 echo "��������! ��� ����������� �������� ������";
 }
   if (!empty($_REQUEST[ret])) $ret="/index.php?page_id=".$_REQUEST[ret];else $ret="/";

   echo "<br /><br /><a href=".$ret.">��������� �� ��������</a>";

?>
</p>


<?

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>