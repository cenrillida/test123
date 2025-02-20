<?php
global $_CONFIG, $site_templater;

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

$ilines = new Ilines();
$dict = new Directories();
if ($_SESSION['lang']!='/en')
{
	$sem_txt=$dict->getSemById($_TPL_REPLACMENT['SEM']);
	$archiveSemTxt = $dict->getSemById($_TPL_REPLACMENT['ARCHIVE_SEM']);
    $suff="";
	$suffCap="";
	}
else
{
	$sem_txt=$dict->getSemByIdEn($_TPL_REPLACMENT['SEM']);
	$archiveSemTxt = $dict->getSemByIdEn($_TPL_REPLACMENT['ARCHIVE_SEM']);
	$suff='_en';
	$suffCap='_EN';
}

	//print_r($sem_txt);

// Если есть привяка к новостной ленте
//echo "<b>".$sem_txt[TEXT]."</b>";

if(!empty($_TPL_REPLACMENT['ARCHIVE_SEM'])) {
	echo $archiveSemTxt["BEFORE_TEXT$suffCap"];
	$archiveSemYears=$ilines->getSemYears($_TPL_REPLACMENT['ARCHIVE_SEM']);
	if (!empty($archiveSemYears))
	{
		if ($_SESSION['lang']!='/en')
			echo "<br /><b>Архив заседаний: </b>";
		else echo "<br />Archive: </b>";
		echo "<p>";
		$i=0;
		foreach($archiveSemYears as $y)
		{
			if ($i>7)
			{
				//echo "<br />";
				$i=0;
			}
			echo " &nbsp;"."<a href=".$_SESSION['lang']."/index.php?page_id=".$_TPL_REPLACMENT['SPISOK_PAGE']."&sem=".$_TPL_REPLACMENT['ARCHIVE_SEM']."&pg=".$_REQUEST['page_id']."&year=".$y['year'].">".
				$y['year']."</a> &nbsp;|";
			$i++;
		}
		echo "</p>";
	}
	echo $archiveSemTxt["FULL_TEXT$suffCap"];
}



IF(!empty($_TPL_REPLACMENT['SEM']))
{
	echo $sem_txt["BEFORE_TEXT$suffCap"];

   $years=$ilines->getSemYears($_TPL_REPLACMENT['SEM']);
   $newsem=$ilines->getNewSem($_TPL_REPLACMENT['SEM']);

   if (!empty($newsem))
{

//echo "<div class='sep'> </div>";
if ($_SESSION['lang']!='/en') echo "<b>Ближайшее заседание: </b>";
else echo "<b>Next meeting: </b>";
foreach($newsem as $ns)
{
	if(isset($ns["content"]["DATE2"]))
		{
			preg_match("/([0-9]{4})\.([0-9]{2})\.([0-9]{2}) ([0-9]{2})\:([0-9]{2})/i", $ns["content"]["DATE2"], $matches);
			$ns["content"]["DATE2"] = mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
			$ns["content"]["DATE2"] = date("d.m.Y г.", $ns["content"]["DATE2"]);
		}
	
	echo "<b>".$ns['content']['DATE2']."</b>";
	echo $ns['content']['PREV_TEXT'.strtoupper($suff)];
	
}
echo "<div class='sep'> </div>";
}
   
 //echo "<br />___". $_TPL_REPLACMENT[SEM]; 

   if (!empty($years))
   {
   	  if ($_SESSION['lang']!='/en')
		echo "<br /><b>Архив заседаний: </b>";
	  else echo "<br />Archive: </b>";	
	  echo "<p>";
	  $i=0;
   	  foreach($years as $y)
   	  {
   	     if ($i>7)
		 {
		   //echo "<br />";
		   $i=0;
		 }
		 echo " &nbsp;"."<a href=".$_SESSION['lang']."/index.php?page_id=".$_TPL_REPLACMENT['SPISOK_PAGE']."&sem=".$_TPL_REPLACMENT['SEM']."&pg=".$_REQUEST['page_id']."&year=".$y['year'].">".
   	     $y['year']."</a> &nbsp;|";
		 $i++;
   	  }
       echo "</p>";
   }
}
if (!empty($sem_txt['CHIF']))
{
if ($_REQUEST['page_id']!=512 )
{
	if($sem_txt['CHAIRMAN']==1) {
		$chiefText = "Председатель";
	} else {
		$chiefText = "Руководитель";
	}
   if ($_SESSION['lang']!='/en')
	echo "<p><b>{$chiefText}:</b> <a href=/index.php?page_id=".$_TPL_REPLACMENT['FULL_ID_P']."&id=".$sem_txt['CHIF'].">".
      $sem_txt['FIO']."</a></p>";
  else	  
	echo "<p><b>Chief</b> <a href=/en/index.php?page_id=".$_TPL_REPLACMENT['FULL_ID_P']."&id=".$sem_txt['CHIF'].">".
      $sem_txt['FIO']."</a></p>";

  }
 else
 {
   
   if ($_SESSION['lang']!='/en')
	echo "<p><b>Председатель Ученого совета</b> <a href=/index.php?page_id=".$_TPL_REPLACMENT['FULL_ID_P']."&id=".$sem_txt['CHIF'].">".
      $sem_txt['FIO']."</a></p>";
  else	  
	echo "<p><b>Chief</b> <a href=/en/index.php?page_id=".$_TPL_REPLACMENT['FULL_ID_P']."&id=".$sem_txt['CHIF'].">".
      $sem_txt['FIO']."</a></p>";

  }
 } 
 
if ($_SESSION['lang']!='/en')   echo $sem_txt['FULL_TEXT'];
else echo $sem_txt['FULL_TEXT_EN'];
//print_r($sem_txt);
//echo $_TPL_REPLACMENT["CONTENT"]."<br /><br />";




$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");

