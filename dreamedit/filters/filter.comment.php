
<script language="JavaScript">
function swCmnt(name)
{
    var a=document.getElementById(name).style;
    if (a.display=='none')
	    a.display='block';
	else
	    a.display='none';


}

function trim(string)
{
    return string.replace(/(^\s+)|(\s+$)/g, "");
}

function empty( mixed_var ) {    // Determine whether a variable is empty
    //
    // +   original by: Philippe Baumann

    return ( mixed_var === "" || mixed_var === 0   || mixed_var === "0" || mixed_var === null  || mixed_var === false  ) ;
}
function check_email(email) {
  var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return filter.test(email);
}


function MyFBCheckCmnt(dig1,dig2) {


  if (trim(document.fbformcmt.nic.value)=="") {
	alert("Вы не ввели имя");
	return false;
  }


  if (trim(document.fbformcmt.full_text.value)=="" ) {
	alert("Вы не ввели текст комментария");
	return false;
  }
  var str="*"+trim(document.fbformcmt.full_text.value);
  j=str.indexOf('<a');
  if (j>0)
  {
     alert("В тексте комментария нельзя использовать ссылки");
     return false;
  }

  // Защита от  спама

   return(spam(dig1,dig2));

}
function spam(dig1,dig2)
{
	 var sum=document.getElementById('dig').value;
	 if(dig1+dig2!=sum)
	 {

	 	alert("Вы не прошли спам-контроль");
	 	return false
	 }
}
</script>

<?
global $DB,$_CONFIG, $site_templater;
$_REQUEST[id]=(int)$DB->cleanuserinput($_REQUEST[id]);
$_REQUEST[page_id]=(int)$DB->cleanuserinput($_REQUEST[page_id]);


if (!empty($_REQUEST[page_id]))
{
$dig1=rand(1,10)*10;
$dig2=rand(0,10);

if (!empty($_REQUEST[id]))
   $str=' AND page_id2='.$_REQUEST[id];
else
   $str="";
$cmnt0=$DB->select("SELECT t.*,g.avatar,CONCAT(g.surname,' ',g.name,' ',g.fname) AS FIO FROM comment_txt AS t
                    LEFT OUTER JOIN comment_reg AS g ON g.id=t.user_id
                    WHERE t.page_id=".(int)$_REQUEST[page_id]." AND t.verdict=1 ".$str. " ORDER BY t.date DESC ");
// Запись

if(isset($_POST[Submit_cmt]))
{


	if (empty($_POST[nic]) || empty($_POST[full_text]) || ($_POST[dig]!=($_POST[dig1]+$_POST[dig2])))
	{
	   echo "<br />Данные не корректны</br />";

	}
	else
	{
	$d=$DB->select("SELECT id FROM comment_txt
	                 WHERE page_id=".(int)$_REQUEST[page_id]. " AND ".
	                 "user_name='".$_POST[nic]."' AND ".
	                 "text='".$_POST[full_text]."'"
	                );
//echo strlen($_POST[fio])."@@@".$_POST[email];
    if (count($d)==0 && strlen($_POST[nic])>3 && $_POST[email]!='sample@email.tst')
    {
//echo "@@";  
  $a=$DB->query("INSERT INTO comment_txt (id,page_id,user_name,text,date,page_id2,verdict,email)
	        VALUES(
	        0,".
      (int)$_REQUEST[page_id].",".
	        "'".$_POST[nic]."',".
	        "'".$_POST[full_text]."',".
	        "'".date('Y').'.'.date('m').".".date('d')."',".
	        "'".(int)$_GET[id]."',".
	        "0,".
	        "'".$_POST[email]."'".
	        " )"
	        );
    echo "<br />Спасибо. Ваш комментарий принят<br />";
    }
    }
}


?>
<br />
<div id="commentspost">
<?	
	if (count($cmnt0)==0)
	{
	   echo "<h2 class='title'>Нет комментариев</h2>";
       echo "<p><a style='cursor:pointer;cursor:hand;' onClick=swCmnt('comment_write')>Вы можете быть первым, кто оставит комментарий</a></p>";
    }
else
{
	echo "<h2 class='title'>Комментарии к этой странице</h2>";
	
	echo "<p><a style='cursor:pointer;cursor:hand;' onClick=swCmnt('comment_write')>Оставить комментарий</a></p>";
}
	echo "</div>";
?>
<div id=comment_write style='display:none; background=#efefef;' >

	<form name="fbformcmt"
	enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"
	onSubmit="return MyFBCheckCmnt(<?=$dig1?>,<?=$dig2?>)">
    <table >
<?
  $nic="";



  if (!empty($_COOKIE[useridext]) && $_COOKIE[useridext]!='undefined')
  {
     $usercmt=$DB->select("SELECT id,login,CONCAT(surname,' ',name,' ',fname) AS fio,avatar FROM comment_reg WHERE id=".$_COOKIE[useridext]);
     echo "<input type='hidden' name='user_id' value=".$usercmt[0][id].">";
     echo "<input type='hidden' name='nic' value=".$usercmt[0][login].">";
     $nic=$usercmt[0][fio];

  }

  if (empty($nic))
  {
     echo  "   <tr ><td><span  value=".$_POST[nic].">Ваше имя, псевдоним: * </span></td><td  align='left'>
	         <input type='edit' name='nic' maxlength='50' size='66' value='".$_POST[nic]."'></td></tr>";
  }
  else
     echo  "   <tr ><td><strong>".$nic."<strong></td><td width='71%' align='left'>
	         </td></tr>";
      echo  "   <tr ><td><span  value=".$_POST[email].">E-mail<br />(не публикуется):</span></td><td width='71%' align='left'>
	         <input type='edit' name='email' maxlength='50' size='50' value='".$_POST[email]."'>&nbsp;<span class='red'></span></td></tr>";



     echo "<tr><td colspan='2'>Введите текст комментария (комментарий будет опубликован после одобрения модератором)*:</td><tr>";
     echo "<tr><td colspan='2'>
             <textarea  maxlength='3500' name='full_text'  cols='68'  rows='15'>".$_POST[text_full]."</textarea><span class='red'>*</span></td></tr>";


      echo  "   <tr ><td valign='top' colspan='2'>Защита от спама. <br />Пожалуйста, введите сумму двух чисел: <strong>".$dig1."+".$dig2."=</strong>"."
	         <input type='edit' name='dig' id='dig' maxlength='50' size='5' onChange=spam(".$dig1.",".$dig2.")>".
	         "<span class='red'>*</span></td></tr>";
      echo "<input type='hidden' value='".$dig1."' name='dig1' id='dig1'>".
           "<input type='hidden' value='".$dig2."' name='dig2' id='dig2'>";



    echo "</table>";
     echo    "	<input type='submit' name='Submit_cmt' value='Отправить'>";
     echo "</form>";

?>
</div>


<?
//echo "<br /><a style='cursor:pointer;cursor:hand;' onClick=swCmnt('comment_read')>Читать комментарии [".count($cmnt0)."]:</a><br />";
//if (count($cmnt0)==0) $block='none';
//else $block='block';

?>
<div id=comment_read >
<?
//print_r($cmnt0);
echo "<br /><strong>Комментарии к этой странице:</strong><br /><br />";
//print_r($cmnt0);
foreach($cmnt0 as $cmnt)
{

        $tpl = new Templater();


        $tpl->setValues($cmnt);
		$tpl->appendValues(array("date" => substr($cmnt["date"],8,2).".".substr($cmnt["date"],5,2).".".substr($cmnt["date"],0,4)));

		if (!empty($cmnt["FIO"]))
		{

		   $tpl->appendValues(array("USER" => $cmnt["FIO"]));
		}
		else
		{

		   $tpl->appendValues(array("USER" => $cmnt["user_name"]));
		}
		$tpl->appendValues(array("TEXT" => $cmnt["text"]));
		$tpl->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."tpl.cmnt.html");


}
}
?>
</div>