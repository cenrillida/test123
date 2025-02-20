<?
  
  if ($_REQUEST[t]!=100 && $_REQUEST[t]!=200  && $_REQUEST[t]!=300)
  {
     $dissovet=$DB->select("SELECT icont_text AS name FROM adm_directories_content WHERE el_id=".$_REQUEST[t]);
  }
  switch($_REQUEST[t])
  {
    case 100:
       echo "<b>Состав Администрации</b>";
       break;
	 case 200:
       echo "<b>Состав Учёного совета</b>";
       break;  
	 case 300:
       echo "<b>Состав Экспертов</b>";
       break;   
	 default:
       echo "<b>Диссовет: ".$dissovet[0][name];	 
  }

 if(isset($_POST['Submit']))
	{
        $cacheEngine = new CacheEngine();
        $cacheEngine->reset();
		
//		if ($_REQUEST[oper]=='sovet') $tbl='Sovet';
//		if ($_REQUEST[oper]=='adm') $tbl='Admin';
 //       $DB->query("TRUNCATE TABLE ".$tbl);

 if (!empty($_POST[type_sp]))
		{
        $DB->query("DELETE FROM Admin WHERE type='".$_POST[type_sp]."'");
		$i=1;
        $matrix=explode("<br>",trim($_POST[matrix]));

       foreach($matrix AS $f)
        {
			if (!empty($f))
			{
  	 		$DB->query("INSERT INTO Admin (id,sort,persona,type)
        	VALUES (0,".$i.",".$f.",'".$_POST[type_sp]."')");
//            echo "<br />".$i." ".$f;
            $i++;
            }
        }
        echo "Данные записаны";
		}
	}
	else
	{
	global $DB;
	$diss=$DB->select("SELECT c.el_id AS id,c.icont_text AS text FROM adm_directories_content AS c
		                    INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND e.itype_id=16");
 //   print_r($diss);							

?>
	 <form name='publ'  enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" >
<?
		echo "<div style='display:none;'><input id='type_sp' name='type_sp' value='".$_REQUEST[t]."'></input></div>";
		 include 'spe_selector.php';
		 echo "<input type=submit  name='Submit' value='Записать'><br />";
		 echo "</form>";

    }
?>

