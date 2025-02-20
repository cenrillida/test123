<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<?
  include_once substr($_CONFIG["global"]["paths"]['admin_path'],0,-10)."classes/guid/guid.php";
  global $DB,$_CONFIG;
echo "preview";

    $alike=false;

  if (!empty($_POST[oi])) {
  $rr=$DB->select("SELECT id FROM persons
                   WHERE surname='".$_POST[surname]."' AND ".
                   "name='".$_POST[name]."' AND fname='".$_POST[fname]."' AND ".
                   " id <> ".$_POST[oi]);
  if (!empty($rr))
  {
     echo "<br><font color=red><b>* Информация об этом человеке уже введена.</b></font><br><br>";
     $alike=true;
 }
}
if (!$alike) echo "<br><font color=red><b>!!!!!!!!!!Проверьте правильность ввода и нажмите на кнопку 'Сохранить в БД'</b></font><br><br>";

?>



Вы ввели следующие данные:
<br><br>

<?php
//print_r($_POST);
if (empty($_POST['reid'])) $_POST['reid']=$_POST['oi'];
if($_POST['reid']) $id = $_POST['reid'];


// Фотографии
if (!empty($_POST[reid]))
{
   $pic00=$DB->select("SELECT picsmall,picbig FROM persons WHERE id =".$_POST[reid]);
   $filenames=$pic00[0][picsmall];
   $filenameb=$pic00[0][picbig];

}
else
{
   $filenames="";
   $filenameb="";
}
if ($_FILES[pic1][tmp_name]<> "")
{

  $guid=new guid();
  if (empty($filenames)) $filenames=str_replace("-","_",$guid->tostring())."_s.jpg";
  $uploaddir = $_CONFIG['global']['paths'][admin_path]."foto/";

  move_uploaded_file($_FILES['pic1']['tmp_name'], $uploaddir.$filenames) ;


}


if ($_FILES[pic2][tmp_name]<>"")
{
  $guid=new guid();
  if (empty($filenameb)) $filenameb=str_replace("-","_",$guid->tostring())."_b.jpg";

  $uploaddir = $_CONFIG['global']['paths'][admin_path]."foto/";

  move_uploaded_file($_FILES['pic2']['tmp_name'], $uploaddir.$filenameb) ;
}



echo "<table  width=100%><tr><td rowspan=2  width=240 valign=top>";
        echo "<img src=/dreamedit/foto/".$filenameb." height=240 width=180></td><td width=63 valign='top' >";
        echo "<img src=/dreamedit/foto/".$filenames." height=84 width=63></td>";
        echo "<td valign=top><table width='100%'><tr><td><b>ФИО</b></td>";
        echo "<td colspan=3>".$_POST['surname']."&nbsp".$_POST['name']."&nbsp".$_POST['fname']."&nbsp"."</td></tr><tr><td><b>Отдел</b></td>";
       
/*$rows=$DB->select("SELECT page_name AS name FROM adm_pages WHERE page_id=".$_POST['otdel']);
	   echo "<td colspan=3>".$rows[0][name]."</td></tr><tr><td><b>Ученая степень</b></td>";*/


// ученая степень

$buffer=$DB->select("SELECT c.icont_text AS short,c2.icont_text AS 'full' 
					FROM adm_directories_content AS c 
					INNER JOIN adm_directories_content AS c2 ON c2.el_id=c.el_id AND c2.icont_var='value' 
					WHERE c.el_id=".$_POST[us]." AND c.icont_var='text'
					");
$qq=$buffer[0][short]." | ".$buffer[0][full];

        echo "<td>".$qq."</td>".
	     "<td><b>Ученое звание</b></td>";
// ученая степень

$buffer=$DB->select("SELECT c.icont_text AS short,c2.icont_text AS 'full' 
					FROM adm_directories_content AS c 
					INNER JOIN adm_directories_content AS c2 ON c2.el_id=c.el_id AND c2.icont_var='value' 
					WHERE c.el_id=".$_POST[uz]." AND c.icont_var='text'");
$qq=$buffer[0][short]." | ".$buffer[0][full];


        echo "<td>".$qq."</td></tr><tr><td><b>Должность</b></td>";


// Доложность


$buffer=$DB->select("SELECT c.icont_text AS 'text' 
					FROM adm_directories_content AS c 
					WHERE c.el_id=".$_POST[dolj]." AND c.icont_var='text'");
$qq=$buffer[0][text];
if (!empty($_POST['4len']))
    $buffer=$DB->select("SELECT c.icont_text AS 'text' 
					FROM adm_directories_content AS c 
					WHERE c.el_id=".$_POST['4len']." AND c.icont_var='text'");

echo "<td>".$qq."</td><td><b>Членство в РАН</b></td><td>";
echo $buffer[0][text];
echo "</td></tr><tr>";
        echo "<td><b>Тел 1</b></td><td>".$_POST['tel1']."</td><td><b>Тел 2</b></td><td>".$_POST['tel2']."</td></tr><tr><td>";
        echo "<b>E-mail 1</b></td><td>".$_POST['mail1']."</td><td><b>E-mail 2</b></td><td>".$_POST['mail2']."</td></tr><tr>";


echo "<td><b>Руководитель</b></td><td>";
if (!$_POST['ruk']) echo "Нет"; else echo "Да";
echo "</td><td><b>Ученый секретарь подразделения</b></td>";
echo "<td>";
if (!$_POST['usp']) echo "Нет"; else echo "Да";
echo "</td></tr><tr>";


echo "<td><b>Доп. регалии</b></td><td colspan=3>".$_POST['rewards']."</td></tr>";
echo "<td><b>Строка для сайта</b></td><td colspan=3>".$_POST['ForSite']."</td></tr>";
echo "</table></td></tr>";



 echo "<td colspan='2'><b>О себе:</b><br><br>".$_POST['about']."";
  echo "<br><br><b>О себе Английский:</b><br><br>".$_POST['about_en']."</td></tr>";

        echo "</table>";


?>

<form action=index.php?mod=personal&oper=add method=post>
<input type=hidden name=name value="<? echo $_POST['name'];?>" >
<input type=hidden name=surname value="<? echo $_POST['surname'];?>" >
<input type=hidden name=fname value="<? echo $_POST['fname'];?>" >
<input type=hidden name=Autor_en value="<? echo $_POST['Autor_en'];?>" >
<input type=hidden name=Name_EN value="<? echo $_POST['Name_EN'];?>" >
<input type=hidden name=LastName_EN value="<? echo $_POST['LastName_EN'];?>" >
<input type=hidden name=second_profile value="<? echo $_POST['second_profile'];?>" >
<input type=hidden name=us value="<? echo $_POST['us'];?>" >
<input type=hidden name=uz value="<? echo $_POST['uz'];?>" >
<input type=hidden name=4len value="<? echo $_POST['4len'];?>" >
<input type=hidden name=rewards value="<? echo $_POST['rewards'];?>" >
<input type=hidden name=rewards_en value="<? echo $_POST['rewards_en'];?>" >
<input type=hidden name=ForSite value="<? echo $_POST['ForSite'];?>" >
<input type=hidden name=ForSite_en value="<? echo $_POST['ForSite_en'];?>" >
<input type=hidden name=dolj value="<? echo $_POST['dolj'];?>" >
<input type=hidden name=dolj2 value="<? echo $_POST['dolj2'];?>" >
<input type=hidden name=dolj3 value="<? echo $_POST['dolj3'];?>" >
<input type=hidden name=otdel value="<? echo $_POST['otdel'];?>" >
<input type=hidden name=otdel2 value="<? echo $_POST['otdel2'];?>" >
<input type=hidden name=otdel3 value="<? echo $_POST['otdel3'];?>" >
<input type=hidden name=otdel_old value="<? echo $_POST['otdel_old'];?>" >
<input type=hidden name=about value='<? echo htmlentities($_POST['about'], ENT_COMPAT, 'windows-1251');?>' >
<input type=hidden name=about_en value='<? echo htmlentities($_POST['about_en'], ENT_COMPAT, 'windows-1251');?>' >
<input type=hidden name=ruk value="<? echo $_POST['ruk']; ?>" >
<input type=hidden name=usp value="<? echo $_POST['usp']; ?>" >
<input type=hidden name=tel1 value="<? echo $_POST['tel1'];?>" >
<input type=hidden name=tel2 value="<? echo $_POST['tel2'];?>" >
<input type=hidden name=mail1 value="<? echo $_POST['mail1'];?>" >
<input type=hidden name=mail2 value="<? echo $_POST['mail2'];?>" >
    <input type=hidden name=emails_for_mailing value="<? echo $_POST['emails_for_mailing'];?>" >
    <input type=hidden name=orcid value="<? echo $_POST['orcid'];?>" >
    <input type=hidden name=external_link value="<? echo $_POST['external_link'];?>" >

<input type=hidden name=save value=y>
<input type=hidden value=do name=test>
<input type=hidden name=oi value=<? echo $_POST['oi']; ?> >
<input type=hidden name=pic1 value="<? echo $filenames; ?>">
<input type=hidden name=pic2 value="<? echo $filenameb; ?>">
<input type=hidden name=spec_ds value="<? echo $_POST['spec_ds'];?>" >
<input type=hidden name=spec_ds2 value="<? echo $_POST['spec_ds2'];?>" >
<input type=hidden name=spec_ds3 value="<? echo $_POST['spec_ds3'];?>" >
<input type=hidden name=spec_ds4 value="<? echo $_POST['spec_ds4'];?>" >
<input type=hidden name='full' value="<? echo $_POST['full']; ?>">
    <input type=hidden name='is_closed' value="<? echo $_POST['is_closed']; ?>">
<input type=hidden name='grant_ac_council' value="<? echo $_POST['grant_ac_council']; ?>">
<input type=hidden name='full_name_echo' value="<? echo $_POST['full_name_echo']; ?>">
<input type=hidden name=work value="<? echo $_POST['work'];?>" >
<!--<input type=checkbox name='deluser' >&nbsp;Удалить ввод пользователя<br />/-->
<? if(!$alike) echo "<input type=submit value='Сохранить в БД'>"; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<A HREF="javascript:history.back()" onMouseOver="window.status='Назад';return true">НАЗАД</A>
</form>

<?



 if($_POST['save'] == 'y')
 {
;
  if ($_POST['ruk']=='on') $flag1 = 1; else $flag1 = 0;
  if ($_POST['usp']=='on') $flag2 = 1; else $flag2 = 0;
  if ($_POST['full']=='on') $flag3 = 1; else $flag3 = 0;
  if ($_POST['grant_ac_council']=='on') $flag4 = 1; else $flag4 = 0;
     if ($_POST['full_name_echo']=='on') $flag5 = 1; else $flag5 = 0;
     if ($_POST['is_closed']=='on') $flag6 = 1; else $flag6 = 0;

     $cacheEngine = new CacheEngine();
     $cacheEngine->reset();


  if (empty($_POST[work])) $_POST[work]='ИНИОН';
//  print_r($_POST);
   if (empty($_POST[oi]))
   {




       $DB->query("INSERT INTO persons
              (id,surname,name,fname,Autor_en,Name_EN,LastName_EN,us,uz,ran,rewards,rewards_en,ForSite,ForSite_en,
              	dolj,dolj2,dolj3,
				otdel,otdel2,otdel3,
				about,about_en,ruk,sekr,
               tel1,tel2,mail1,mail2,emails_for_mailing,orcid,external_link,picsmall,picbig,spec_ds,spec_ds2,spec_ds3,spec_ds4,second_profile,`full`,full_name_echo,is_closed)
       			VALUES (0, '".
					$_POST['surname']."', '".
					$_POST['name']."', '".
					$_POST['fname']."', '".
					$_POST['Autor_en']."', '".
					$_POST['Name_EN']."', '".
					$_POST['LastName_EN']."', '".
					$_POST['us']."', '".
					$_POST['uz']."', '".
					$_POST['4len']."', '".
					$_POST['rewards']."', '".
					$_POST['rewards_en']."', '".
					$_POST['ForSite']."', '".
					$_POST['ForSite_en']."', '".
					$_POST['dolj']."', '".
					$_POST['dolj2']."', '".
					$_POST['dolj3']."', '".
					$_POST['otdel']."', '".
					$_POST['otdel2']."', '".
					$_POST['otdel3']."', '".
					$_POST['about']."', '".
					$_POST['about_en']."',".
					$flag1.", ".
					$flag2. ", '".
					$_POST['tel1']."', 	'".
					$_POST['tel2']."', '".
					$_POST['mail1']."', '".
					$_POST['mail2']."', '".
                    $_POST['emails_for_mailing']."', '".
                    $_POST['orcid']."', '".
                    $_POST['external_link']."', '".
					$_POST['pic1']."', '".
					$_POST['pic2']."', '".
					$_POST['spec_ds']."', '".
					$_POST['spec_ds2']."', '".
					$_POST['spec_ds3']."', '".
					$_POST['spec_ds4']."', '".
                    $_POST['second_profile']."', ".
					
                    $flag3.", ".$flag5.", ".$flag6.
					") ");

  }
   else
   {

       $DB->query("UPDATE persons SET ".
					"surname='".$_POST['surname']."', ".
					"name='".$_POST['name']."', ".
					"fname='".$_POST['fname']."', ".
					'Autor_en="'.$_POST['Autor_en'].'"'.", ".
					'Name_EN="'.$_POST['Name_EN'].'"'.", ".
					'LastName_EN="'.$_POST['LastName_EN'].'"'.", ".
					"us='".$_POST['us']."', ".
					"uz='".$_POST['uz']."', ".
					"ran='".$_POST['4len']."', ".
					"ForSite='".$_POST['ForSite']."', ".
					'ForSite_en="'.$_POST['ForSite_en'].'"'.", ".
					"rewards='".$_POST['rewards']."', ".
					"rewards_en='".$_POST['rewards_en']."', ".
					"dolj='".$_POST['dolj']."', ".
					"dolj2='".$_POST['dolj2']."', ".
					"dolj3='".$_POST['dolj3']."', ".
					"otdel='".$_POST['otdel']."', ".
					"otdel2='".$_POST['otdel2']."', ".
					"otdel3='".$_POST['otdel3']."', ".
					"about='".$_POST[about]."', ".
					'about_en="'.str_replace('"','\"',$_POST[about_en]).'"'.", ".
					"ruk=".$flag1.", ".
					"sekr=".$flag2.", ".
					"grant_ac_council=".$flag4.", ".
                    "full_name_echo=".$flag5.", ".
                    "is_closed=".$flag6.", ".
					"tel1='".$_POST['tel1']."', ".
					"tel2='".$_POST['tel2']."', ".
					"mail1='".$_POST['mail1']."', ".
					"mail2='".$_POST['mail2']."', ".
                    "emails_for_mailing='".$_POST['emails_for_mailing']."', ".
                    "orcid='".$_POST['orcid']."', ".
                    "external_link='".$_POST['external_link']."', ".
					"picsmall='".$_POST[pic1]."' ,".
					"picbig='".$_POST[pic2]."', ".
					"spec_ds='".$_POST[spec_ds]."', ".
					"spec_ds2='".$_POST[spec_ds2]."', ".
					"spec_ds3='".$_POST[spec_ds3]."', ".
					"spec_ds4='".$_POST[spec_ds4]."', ".
                    "second_profile='".$_POST[second_profile]."', ".
                    "full=".$flag3.
					"  WHERE id=".$_POST[oi]);
   }


   if($_POST[deluser]=="on")
      $DB->query("DELETE FROM inter2009.prnd_persona WHERE id_persona=".$_POST[oi]);

     $cacheEngine = new CacheEngine();
     $cacheEngine->reset();

  mysql_close();
  echo "<br /><br /><font color='red' size-'3'><b>Данные записаны!</b></font><br /> Через 3 секунды Вы будете перенаправлены на главную страницу";
  echo "<META HTTP-EQUIV=REFRESH CONTENT='30;/dreamedit/index.php?mod=personal' />";
 }
?>
