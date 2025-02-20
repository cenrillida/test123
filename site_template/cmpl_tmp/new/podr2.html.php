<?
// Страница со списком подразделений
global $DB, $_CONFIG, $site_templater;

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

//include_once $_CONFIG["global"]["paths"]["admin_path"] ."/includes/class.Persons.php";

$pg = new Pages();
$persons = new Persons();

// Получить дочерние страницы подразделений
if ($_SESSION[lang]!='/en')
{
	$centers= $pg->getChilds($_TPL_REPLACMENT["FULL_ID"]);
	echo $_TPL_REPLACMENT["CONTENT"];
	$suff="";
	$txtruk='Руководитель';
	$txtsekr="Ученый секретарь";
}	
else
{
	$centers= $pg->getChildsEn($_TPL_REPLACMENT["FULL_ID"]);
	echo $_TPL_REPLACMENT["CONTENT_EN"];
	$suff="_en";
	$txtruk='Head';
	$txtsekr="Scientific Secretary";
}

	//echo "<br /><br />";
$centers=$pg->appendContent($centers);

// Цикл по центрам

foreach($centers as  $center) {
//echo "<br />";print_r($center);
//   $center=$pg->getPageById($center[page_id]);
    if ($center[page_status] != 0) {
    	if($center[page_id]==424)
    		echo "<br />"."<a name='dep".$center[page_id]."'>".
          "<h3><a class=podr href='/energyeconomics/'>".
          $center["page_name".$suff]."</a></h3><br />";
        elseif($center['content']['LIST_LINK_OFF']==1)
			echo "<br />"."<a name='dep".$center[page_id]."'>".
                "<h3>".$center["page_name".$suff]."</h3><br />";
		else
      echo "<br />"."<a name='dep".$center[page_id]."'>".
          "<h3><a class=podr href='".$_SESSION[lang]."/index.php?page_id=".$center[page_id]."'>".
          $center["page_name".$suff]."</a></h3><br />";


// Отделы и сектора
      if ($_SESSION[lang]!="/en")
		$sectors= $pg->getChilds($center[page_id]);
	  else	
		$sectors= $pg->getChildsEn($center[page_id]);

	  $sectors = $pg->appendContent($sectors);

      echo "<ul class='speclist'>";
      foreach($sectors as $pp1) {
              
			 if ($pp1[page_status] != 0) {

	            echo "<li>";
				if($pp1['content']['LIST_LINK_OFF'] ==1 ) {
					echo $pp1["page_name" . $suff];
				}
				else {
					echo "<a href='" . $_SESSION[lang] . "/index.php?page_id=" . $pp1[page_id] . "'>" .
						$pp1["page_name" . $suff];
					echo "</a>";
				}
	// Группы
	            if ($_SESSION[lang]!="/en")
					$gruppa=$pg->getChilds($pp1[page_id]);
				else
				  $gruppa=$pg->getChildsEn($pp1[page_id]);

				$gruppa = $pg->appendContent($gruppa);
	            if (!empty($gruppa))
	            {
		  	    echo "<ul class='speclist'>";
		            foreach($gruppa as $pp2) {

			       if ($pp2[page_status] != 0) {
      		                  echo "<li>";

							   if($pp2['content']['LIST_LINK_OFF'] ==1 ) {
								   echo $pp2["page_name" . $suff];
							   }
							   else {
								   echo "<a href=".$_SESSION[lang]."/index.php?page_id=".$pp2[page_id].">".$pp2["page_name".$suff]."</a>";
							   }
							 echo "</li>";
						}
			     }

			    echo "</ul></li>"; // по группам
			
			    }
		 } // видимость отдела
      }
      echo "</ul>"; // по отделам

   } //invis центра
}

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
