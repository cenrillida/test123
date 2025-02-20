<?php
global $DB,$_CONFIG, $site_templater;
if ($_SESSION["lang"]=="/en")
{
  $txt1="Director";
  $txt2="Scientific Secretary";
  $txt3="Chairman of the Academic Council";
  $txt4="Deputy Chairman of the Scientific Council";
}
else
{
  $txt1 = "Директор";
  $txt2="Ученый секретарь";
  $txt3="Председатель ученого совета";
  $txt4="Заместитель председателя Ученого совета";
}
$ps = new Persons();

	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
//print_r($_TPL_REPLACMENT);
 //   echo @$_TPL_REPLACMENT["TYPES"];
	if (!empty($_REQUEST["diss"])) $_TPL_REPLACMENT["TYPES"]=$_REQUEST["diss"];

	if (empty($_TPL_REPLACMENT['NUMBER']))$_TPL_REPLACMENT['NUMBER']=0;
	if ($_SESSION["lang"] !='/en')
		echo @$_TPL_REPLACMENT["CONTENT"];
	else	
		echo @$_TPL_REPLACMENT["CONTENT_EN"];
	
	if ($_TPL_REPLACMENT['TYPES']=='Администрация') $tbl='100'; 
	if ($_TPL_REPLACMENT['TYPES']=='Ученый совет') $tbl='200';
	
	if($_TPL_REPLACMENT['TYPES']==200)
	{
	if ($_SESSION["lang"]!='/en')
    $rows=$DB->select("SELECT DISTINCT a.*,s.icont_text,CONCAT(p.surname,' ',p.name,' ',p.fname) AS fio,pp.icont_text AS spec_ds, pp2.icont_text AS spec_ds2, pp3.icont_text AS spec_ds3, pp4.icont_text AS spec_ds4, p.grant_ac_council AS granted,
 	       CONCAT(IF (r.icont_text<>'не член',r.icont_text,''),IF(r.icont_text<>'',', ',''),IF(s.icont_text<>'',s.icont_text,''),IF(s.icont_text<>'' AND z.icont_text<>'',', ',''),IF(z.icont_text<>'',z.icont_text,'')) AS regalii, p.external_link AS external_link, 

                     d.icont_text AS dolj_text,p.picsmall,full,otdel,is_closed,p.dolj,
                     CONCAT('<a href=mailto:',mail1,'>',mail1,'</a>',IF (mail1<>'' AND tel1<>'',' | ',''),IF(tel1<>'' AND tel1<>'0',tel1,'')) AS contact
                     FROM Admin AS a
                     INNER join persons AS p ON p.id=a.persona
                     LEFT OUTER JOIN adm_directories_content AS s ON s.el_id=p.us  AND s.icont_var='value'
                     LEFT OUTER JOIN adm_directories_content AS z ON z.el_id=p.uz  AND z.icont_var='value'
                     LEFT OUTER JOIN adm_directories_content AS r ON r.el_id=p.ran  AND r.icont_var='value'
					 LEFT OUTER JOIN adm_directories_content AS pp ON pp.el_id=p.spec_ds  AND pp.icont_var='text'
					 LEFT OUTER JOIN adm_directories_content AS pp2 ON pp2.el_id=p.spec_ds2  AND pp2.icont_var='text'
					 LEFT OUTER JOIN adm_directories_content AS pp3 ON pp3.el_id=p.spec_ds3  AND pp3.icont_var='text'
					 LEFT OUTER JOIN adm_directories_content AS pp4 ON pp4.el_id=p.spec_ds4  AND pp4.icont_var='text'
                     LEFT OUTER JOIN adm_directories_content AS d ON d.el_id=p.dolj   AND d.icont_var='text'
                     WHERE type='".@$_TPL_REPLACMENT["TYPES"]."' AND p.grant_ac_council=0".
			        " ORDER BY a.sort");
	else
	$rows=$DB->select("SELECT DISTINCT a.*,s.icont_text,Autor_en AS fio,pp.icont_text AS spec_ds, pp2.icont_text AS spec_ds2, pp3.icont_text AS spec_ds3, pp4.icont_text AS spec_ds4, p.grant_ac_council AS granted,
 	       CONCAT(IF (r.icont_text<>'не член',r.icont_text,''),IF(r.icont_text<>'',', ',''),IF(s.icont_text<>'',s.icont_text,''),IF(s.icont_text<>'' AND z.icont_text<>'',', ',''),IF(z.icont_text<>'',z.icont_text,'')) AS regalii, p.external_link AS external_link, 

                     d.icont_text AS dolj_text,p.picsmall,full,otdel,is_closed,p.dolj,
                     CONCAT('<a href=mailto:',mail1,'>',mail1,'</a>',IF (mail1<>'' AND tel1<>'',' | ',''),IF(tel1<>'' AND tel1<>'0',tel1,'')) AS contact
                     FROM Admin AS a
                     INNER join persons AS p ON p.id=a.persona
                     LEFT OUTER JOIN adm_directories_content AS s ON s.el_id=p.us  AND s.icont_var='value_en'
                     LEFT OUTER JOIN adm_directories_content AS z ON z.el_id=p.uz  AND z.icont_var='value_en'
                     LEFT OUTER JOIN adm_directories_content AS r ON r.el_id=p.ran  AND r.icont_var='value_en'
					 LEFT OUTER JOIN adm_directories_content AS pp ON pp.el_id=p.spec_ds  AND pp.icont_var='text'
					 LEFT OUTER JOIN adm_directories_content AS pp2 ON pp2.el_id=p.spec_ds2  AND pp2.icont_var='text'
					 LEFT OUTER JOIN adm_directories_content AS pp3 ON pp3.el_id=p.spec_ds3  AND pp3.icont_var='text'
					 LEFT OUTER JOIN adm_directories_content AS pp4 ON pp4.el_id=p.spec_ds4  AND pp4.icont_var='text'
                     LEFT OUTER JOIN adm_directories_content AS d ON d.el_id=p.dolj   AND d.icont_var='text_en'
                     WHERE type='".@$_TPL_REPLACMENT["TYPES"]."' AND p.grant_ac_council=0".
			        " ORDER BY a.sort");
					
	if ($_SESSION["lang"]!='/en')
    $rows2=$DB->select("SELECT DISTINCT a.*,s.icont_text,CONCAT(p.surname,' ',p.name,' ',p.fname) AS fio,pp.icont_text AS spec_ds, pp2.icont_text AS spec_ds2, pp3.icont_text AS spec_ds3, pp4.icont_text AS spec_ds4, p.grant_ac_council AS granted,
 	       CONCAT(IF (r.icont_text<>'не член',r.icont_text,''),IF(r.icont_text<>'',', ',''),IF(s.icont_text<>'',s.icont_text,''),IF(s.icont_text<>'' AND z.icont_text<>'',', ',''),IF(z.icont_text<>'',z.icont_text,'')) AS regalii, p.external_link AS external_link, 

                     d.icont_text AS dolj_text,p.picsmall,full,otdel,is_closed,p.dolj,
                     CONCAT('<a href=mailto:',mail1,'>',mail1,'</a>',IF (mail1<>'' AND tel1<>'',' | ',''),IF(tel1<>'' AND tel1<>'0',tel1,'')) AS contact
                     FROM Admin AS a
                     INNER join persons AS p ON p.id=a.persona
                     LEFT OUTER JOIN adm_directories_content AS s ON s.el_id=p.us  AND s.icont_var='value'
                     LEFT OUTER JOIN adm_directories_content AS z ON z.el_id=p.uz  AND z.icont_var='value'
                     LEFT OUTER JOIN adm_directories_content AS r ON r.el_id=p.ran  AND r.icont_var='value'
					 LEFT OUTER JOIN adm_directories_content AS pp ON pp.el_id=p.spec_ds  AND pp.icont_var='text'
					 LEFT OUTER JOIN adm_directories_content AS pp2 ON pp2.el_id=p.spec_ds2  AND pp2.icont_var='text'
					 LEFT OUTER JOIN adm_directories_content AS pp3 ON pp3.el_id=p.spec_ds3  AND pp3.icont_var='text'
					 LEFT OUTER JOIN adm_directories_content AS pp4 ON pp4.el_id=p.spec_ds4  AND pp4.icont_var='text'
                     LEFT OUTER JOIN adm_directories_content AS d ON d.el_id=p.dolj   AND d.icont_var='text'
                     WHERE type='".@$_TPL_REPLACMENT["TYPES"]."' AND p.grant_ac_council=1".
			        " ORDER BY a.sort");
	else
	$rows2=$DB->select("SELECT DISTINCT a.*,s.icont_text,Autor_en AS fio,pp.icont_text AS spec_ds, pp2.icont_text AS spec_ds2, pp3.icont_text AS spec_ds3, pp4.icont_text AS spec_ds4, p.grant_ac_council AS granted,
 	       CONCAT(IF (r.icont_text<>'не член',r.icont_text,''),IF(r.icont_text<>'',', ',''),IF(s.icont_text<>'',s.icont_text,''),IF(s.icont_text<>'' AND z.icont_text<>'',', ',''),IF(z.icont_text<>'',z.icont_text,'')) AS regalii, p.external_link AS external_link, 

                     d.icont_text AS dolj_text,p.picsmall,full,otdel,is_closed,p.dolj,
                     CONCAT('<a href=mailto:',mail1,'>',mail1,'</a>',IF (mail1<>'' AND tel1<>'',' | ',''),IF(tel1<>'' AND tel1<>'0',tel1,'')) AS contact
                     FROM Admin AS a
                     INNER join persons AS p ON p.id=a.persona
                     LEFT OUTER JOIN adm_directories_content AS s ON s.el_id=p.us  AND s.icont_var='value_en'
                     LEFT OUTER JOIN adm_directories_content AS z ON z.el_id=p.uz  AND z.icont_var='value_en'
                     LEFT OUTER JOIN adm_directories_content AS r ON r.el_id=p.ran  AND r.icont_var='value_en'
					 LEFT OUTER JOIN adm_directories_content AS pp ON pp.el_id=p.spec_ds  AND pp.icont_var='text'
					 LEFT OUTER JOIN adm_directories_content AS pp2 ON pp2.el_id=p.spec_ds2  AND pp2.icont_var='text'
					 LEFT OUTER JOIN adm_directories_content AS pp3 ON pp3.el_id=p.spec_ds3  AND pp3.icont_var='text'
					 LEFT OUTER JOIN adm_directories_content AS pp4 ON pp4.el_id=p.spec_ds4  AND pp4.icont_var='text'
                     LEFT OUTER JOIN adm_directories_content AS d ON d.el_id=p.dolj   AND d.icont_var='text_en'
                     WHERE type='".@$_TPL_REPLACMENT["TYPES"]."' AND p.grant_ac_council=1".
			        " ORDER BY a.sort");
	}
	else
	{
			if ($_SESSION["lang"]!='/en')
    $rows=$DB->select("SELECT DISTINCT a.*,s.icont_text,CONCAT(p.surname,' ',p.name,' ',p.fname) AS fio,pp.icont_text AS spec_ds, pp2.icont_text AS spec_ds2, pp3.icont_text AS spec_ds3, pp4.icont_text AS spec_ds4, p.grant_ac_council AS granted,
 	       CONCAT(IF (r.icont_text<>'не член',r.icont_text,''),IF(r.icont_text<>'',', ',''),IF(s.icont_text<>'',s.icont_text,''),IF(s.icont_text<>'' AND z.icont_text<>'',', ',''),IF(z.icont_text<>'',z.icont_text,'')) AS regalii, p.external_link AS external_link, 

                     d.icont_text AS dolj_text,p.picsmall,full,otdel,is_closed,p.dolj,
                     CONCAT('<a href=mailto:',mail1,'>',mail1,'</a>',IF (mail1<>'' AND tel1<>'',' | ',''),IF(tel1<>'' AND tel1<>'0',tel1,'')) AS contact
                     FROM Admin AS a
                     INNER join persons AS p ON p.id=a.persona
                     LEFT OUTER JOIN adm_directories_content AS s ON s.el_id=p.us  AND s.icont_var='value'
                     LEFT OUTER JOIN adm_directories_content AS z ON z.el_id=p.uz  AND z.icont_var='value'
                     LEFT OUTER JOIN adm_directories_content AS r ON r.el_id=p.ran  AND r.icont_var='value'
					 LEFT OUTER JOIN adm_directories_content AS pp ON pp.el_id=p.spec_ds  AND pp.icont_var='text'
					 LEFT OUTER JOIN adm_directories_content AS pp2 ON pp2.el_id=p.spec_ds2  AND pp2.icont_var='text'
					 LEFT OUTER JOIN adm_directories_content AS pp3 ON pp3.el_id=p.spec_ds3  AND pp3.icont_var='text'
					 LEFT OUTER JOIN adm_directories_content AS pp4 ON pp4.el_id=p.spec_ds4  AND pp4.icont_var='text'
                     LEFT OUTER JOIN adm_directories_content AS d ON d.el_id=p.dolj   AND d.icont_var='text'
                     WHERE type='".@$_TPL_REPLACMENT["TYPES"]."'".
			        " ORDER BY a.sort");
	else
	$rows=$DB->select("SELECT DISTINCT a.*,s.icont_text,Autor_en AS fio,pp.icont_text AS spec_ds, pp2.icont_text AS spec_ds2, pp3.icont_text AS spec_ds3, pp4.icont_text AS spec_ds4, p.grant_ac_council AS granted,
 	       CONCAT(IF (r.icont_text<>'не член',r.icont_text,''),IF(r.icont_text<>'',', ',''),IF(s.icont_text<>'',s.icont_text,''),IF(s.icont_text<>'' AND z.icont_text<>'',', ',''),IF(z.icont_text<>'',z.icont_text,'')) AS regalii, p.external_link AS external_link, 

                     d.icont_text AS dolj_text,p.picsmall,full,otdel,is_closed,p.dolj,
                     CONCAT('<a href=mailto:',mail1,'>',mail1,'</a>',IF (mail1<>'' AND tel1<>'',' | ',''),IF(tel1<>'' AND tel1<>'0',tel1,'')) AS contact
                     FROM Admin AS a
                     INNER join persons AS p ON p.id=a.persona
                     LEFT OUTER JOIN adm_directories_content AS s ON s.el_id=p.us  AND s.icont_var='value_en'
                     LEFT OUTER JOIN adm_directories_content AS z ON z.el_id=p.uz  AND z.icont_var='value_en'
                     LEFT OUTER JOIN adm_directories_content AS r ON r.el_id=p.ran  AND r.icont_var='value_en'
					 LEFT OUTER JOIN adm_directories_content AS pp ON pp.el_id=p.spec_ds  AND pp.icont_var='text'
					 LEFT OUTER JOIN adm_directories_content AS pp2 ON pp2.el_id=p.spec_ds2  AND pp2.icont_var='text'
					 LEFT OUTER JOIN adm_directories_content AS pp3 ON pp3.el_id=p.spec_ds3  AND pp3.icont_var='text'
					 LEFT OUTER JOIN adm_directories_content AS pp4 ON pp4.el_id=p.spec_ds4  AND pp4.icont_var='text'
                     LEFT OUTER JOIN adm_directories_content AS d ON d.el_id=p.dolj   AND d.icont_var='text_en'
                     WHERE type='".@$_TPL_REPLACMENT["TYPES"]."'".
			        " ORDER BY a.sort");
	}
//print_r($rows);
    $i=0;
	if ($_TPL_REPLACMENT['TYPES']>300)
	   echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ".
	   "<div class='text-right text-uppercase'><a href=/index.php?page_id=504&diss=".$_TPL_REPLACMENT['TYPES']."><b>Список защит</b></a></div>";
	echo "<table>";
	
	
	if ($_TPL_REPLACMENT['TYPES']==200)
	{
	foreach($rows as $row)
	{
        echo "<tr>";
        echo "<td valign='top'>";
        if (!empty($row["picsmall"]) && ($_TPL_REPLACMENT['TYPES']=='100' || $_TPL_REPLACMENT['TYPES']=='300'))
            echo "<img src=/dreamedit/foto/".$row["picsmall"]." />";
        echo "</td>";
        echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
        echo "<td valign='top'>";
        if ($_TPL_REPLACMENT['TYPES']=='100')
	        echo "<b>".$row["dolj_text"]."</b><br />";
        if ($_TPL_REPLACMENT['TYPES']=='200')
        {
           if ($i==0) echo "<b>".$txt3."</b>";
           if ($i==1 && $_TPL_REPLACMENT['NO_SECRETARY']!=1) echo "<b>".$txt2."</b>";
		//   if ($i==2) echo "<b>"."Эксперты"."</b>";
           if ($i>0 && $i<=$_TPL_REPLACMENT['NUMBER'] && $_TPL_REPLACMENT['NUMBER']!='0') "<b>".$txt4."</b>";
        }
		$num='yes';
  if (($_TPL_REPLACMENT['TYPES']!='100') && ($_TPL_REPLACMENT['TYPES']!='200') && ($_TPL_REPLACMENT['TYPES']!='300'))
		{
		   
		   if ($i==0) {
				echo "<b>".($i+1).". Председатель Диссертационного совета</b>";
				$num='none';
			} 
           if ($i==($_TPL_REPLACMENT['NUMBER']+1)) 
		   {
				echo "<b>".($i+1).". Учёный секретарь</b>";
				$num='none';
			}
           if ($i>0 && $i<=$_TPL_REPLACMENT['NUMBER']) 
		   {
						echo "<b>".($i+1).". Заместитель председателя Диссертационного совета</b>";
						$num='none';
			}
		}
		if ($row["otdel"]=='1239')
		{

		  $span="<span style='border: solid 1px gray;padding:1px 1px 1px 2px;'>";
		  $span2="</span>";
		}
		else
		{
		   $span="";$span2="";
		}
		echo "<h4>";
		if (($_TPL_REPLACMENT['TYPES']!='100') && ($_TPL_REPLACMENT['TYPES']!='200') && ($_TPL_REPLACMENT['TYPES']!='300') && $num=='yes')
		   echo ($i+1).". ";
		echo "<b>".$row["sort"].". </b>";

		if(!empty($row['external_link'])) {
			echo "<a target='_blank' href=".$row['external_link'].">&nbsp;".$span.$row["fio"].$span2."</a>";
		} else {
			if($ps->isClosed($row)) {
				echo "&nbsp;".$span.$row["fio"].$span2;
			} else {
				echo "<a href=".$_SESSION["lang"]."/index.php?page_id=".$_TPL_REPLACMENT["PERSONA_PAGE"]."&id=".$row["persona"].">&nbsp;".$span.$row["fio"].$span2."</a>";
			}
		}

		echo "</h4>";
        if (!empty($row["regalii"]))
	        echo $row["regalii"]."<br />";
		if (($_TPL_REPLACMENT['TYPES']!='100') && ($_TPL_REPLACMENT['TYPES']!='200') && ($_TPL_REPLACMENT['TYPES']!='300') )
		{
			$spec = substr($row["spec_ds"],0,8);
			preg_match("@^\s?(\d+.\d+.\d+\.?)@",$row["spec_ds"],$specMatched);
			if(isset($specMatched[0])) {
				$spec = $specMatched[0];
			}
			$spec2 = substr($row["spec_ds2"],0,8);
			preg_match("@^\s?(\d+.\d+.\d+\.?)@",$row["spec_ds2"],$specMatched2);
			if(isset($specMatched2[0])) {
				$spec2 = $specMatched2[0];
			}
			$spec3 = substr($row["spec_ds3"],0,8);
			preg_match("@^\s?(\d+.\d+.\d+\.?)@",$row["spec_ds3"],$specMatched3);
			if(isset($specMatched3[0])) {
				$spec3 = $specMatched3[0];
			}

            if($_TPL_REPLACMENT['TYPES']=="411")
				echo 'Специальность: '.$spec."<br />";
			if($_TPL_REPLACMENT['TYPES']=="412")
				echo 'Специальность: '.$spec2."<br />";
			if($_TPL_REPLACMENT['TYPES']=="413")
				echo 'Специальность: '.$spec3."<br />";
        }
		if($row['is_closed'] != 1) {
			echo $row["contact"];
		}
        echo "<tr>";
        echo "<tr><td colspan=3>&nbsp;</td></tr>";
        $i++;
	}
	if(!empty($rows2))
	{
	if ($_SESSION["lang"] !='/en')
		echo "</table><div class='sep'> </div><b>Почетные члены Ученого Совета</b><p></p>";
	else
	    echo "</table><div class='sep'> </div><b>Honored members of Academic Council</b><p></p>";
	}
	echo "<table>";
	foreach($rows2 as $row)
	{
        echo "<tr>";
        echo "<td valign='top'>";
        if (!empty($row["picsmall"]) && ($_TPL_REPLACMENT['TYPES']=='100' || $_TPL_REPLACMENT['TYPES']=='300'))
            echo "<img src=/dreamedit/foto/".$row["picsmall"]." />";
        echo "</td>";
        echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
        echo "<td valign='top'>";
        if ($_TPL_REPLACMENT['TYPES']=='100')
	        echo "<b>".$row["dolj_text"]."</b><br />";
        if ($_TPL_REPLACMENT['TYPES']=='200')
        {
           if ($i==0) echo "<b>".$txt3."</b>";
           if ($i==1 && $_TPL_REPLACMENT['NO_SECRETARY']!=1) echo "<b>".$txt2."</b>";
		//   if ($i==2) echo "<b>"."Эксперты"."</b>";
           if ($i>0 && $i<=$_TPL_REPLACMENT['NUMBER'] && $_TPL_REPLACMENT['NUMBER']!='0') "<b>".$txt4."</b>";
        }
		$num='yes';
  if (($_TPL_REPLACMENT['TYPES']!='100') && ($_TPL_REPLACMENT['TYPES']!='200') && ($_TPL_REPLACMENT['TYPES']!='300'))
		{
		   
		   if ($i==0) {
				echo "<b>".($i+1).". Председатель Диссертационного совета</b>";
				$num='none';
			} 
           if ($i==($_TPL_REPLACMENT['NUMBER']+1)) 
		   {
				echo "<b>".($i+1).". Учёный секретарь</b>";
				$num='none';
			}
           if ($i>0 && $i<=$_TPL_REPLACMENT['NUMBER']) 
		   {
						echo "<b>".($i+1).". Заместитель председателя Диссертационного совета</b>";
						$num='none';
			}
		}
		if ($row["otdel"]=='1239')
		{

		  $span="<span style='border: solid 1px gray;padding:1px 1px 1px 2px;'>";
		  $span2="</span>";
		}
		else
		{
		   $span="";$span2="";
		}
		echo "<h4>";
		if (($_TPL_REPLACMENT['TYPES']!='100') && ($_TPL_REPLACMENT['TYPES']!='200') && ($_TPL_REPLACMENT['TYPES']!='300') && $num=='yes')
		   echo ($i+1).". ";
		if(!empty($row['external_link'])) {
			echo "<a target='_blank' href=".$row['external_link'].">".$span.$row["fio"].$span2."</a>";
		} else {
			if ($ps->isClosed($row)) {
				echo $span . $row["fio"] . $span2;
			} else {
				echo "<a href=" . $_SESSION["lang"] . "/index.php?page_id=" . $_TPL_REPLACMENT["PERSONA_PAGE"] . "&id=" . $row["persona"] . ">" . $span . $row["fio"] . $span2 . "</a>";
			}
		}
		echo "</h4>";
        if (!empty($row["regalii"]))
	        echo $row["regalii"]."<br />";
		if (($_TPL_REPLACMENT['TYPES']!='100') && ($_TPL_REPLACMENT['TYPES']!='200') && ($_TPL_REPLACMENT['TYPES']!='300') )
		{
			$spec = substr($row["spec_ds"],0,8);
			preg_match("@^\s?(\d+.\d+.\d+\.?)@",$row["spec_ds"],$specMatched);
			if(isset($specMatched[0])) {
				$spec = $specMatched[0];
			}
			$spec2 = substr($row["spec_ds2"],0,8);
			preg_match("@^\s?(\d+.\d+.\d+\.?)@",$row["spec_ds2"],$specMatched2);
			if(isset($specMatched2[0])) {
				$spec2 = $specMatched2[0];
			}
			$spec3 = substr($row["spec_ds3"],0,8);
			preg_match("@^\s?(\d+.\d+.\d+\.?)@",$row["spec_ds3"],$specMatched3);
			if(isset($specMatched3[0])) {
				$spec3 = $specMatched3[0];
			}
            
			if($_TPL_REPLACMENT['TYPES']=="411")
				echo 'Специальность: '.$spec."<br />";
			if($_TPL_REPLACMENT['TYPES']=="412")
				echo 'Специальность: '.$spec2."<br />";
			if($_TPL_REPLACMENT['TYPES']=="413")
				echo 'Специальность: '.$spec3."<br />";
        }
		if($row['is_closed'] != 1) {
			echo $row["contact"];
		}
        echo "<tr>";
        echo "<tr><td colspan=3>&nbsp;</td></tr>";
        $i++;
	}
    echo "</table>";
	}
	else
	{
	foreach($rows as $row)
	{
        echo "<tr>";
        echo "<td valign='top'>";
        if (!empty($row["picsmall"]) && ($_TPL_REPLACMENT['TYPES']=='100' || $_TPL_REPLACMENT['TYPES']=='300'))
            echo "<img src=/dreamedit/foto/".$row["picsmall"]." />";
        echo "</td>";
        echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
        echo "<td valign='top'>";
        if ($_TPL_REPLACMENT['TYPES']=='100')
	        echo "<b>".$row["dolj_text"]."</b><br />";
        if ($_TPL_REPLACMENT['TYPES']=='200')
        {
           if ($i==0) echo "<b>".$txt3."</b>";
           if ($i==1 && $_TPL_REPLACMENT['NO_SECRETARY']!=1) echo "<b>".$txt2."</b>";
		//   if ($i==2) echo "<b>"."Эксперты"."</b>";
           if ($i>0 && $i<=$_TPL_REPLACMENT['NUMBER'] && $_TPL_REPLACMENT['NUMBER']!='0') "<b>".$txt4."</b>";
        }
		$num='yes';
  if (($_TPL_REPLACMENT['TYPES']!='100') && ($_TPL_REPLACMENT['TYPES']!='200') && ($_TPL_REPLACMENT['TYPES']!='300'))
		{
		   
		   if ($i==0) {
				echo "<b>".($i+1).". Председатель Диссертационного совета</b>";
				$num='none';
			} 
           if ($i==($_TPL_REPLACMENT['NUMBER']+1)) 
		   {
				echo "<b>".($i+1).". Учёный секретарь</b>";
				$num='none';
			}
           if ($i>0 && $i<=$_TPL_REPLACMENT['NUMBER']) 
		   {
						echo "<b>".($i+1).". Заместитель председателя Диссертационного совета</b>";
						$num='none';
			}
		}
		if ($row["otdel"]=='1239')
		{

		  $span="<span style='border: solid 1px gray;padding:1px 1px 1px 2px;'>";
		  $span2="</span>";
		}
		else
		{
		   $span="";$span2="";
		}
		echo "<h4>";
		if (($_TPL_REPLACMENT['TYPES']!='100') && ($_TPL_REPLACMENT['TYPES']!='200') && ($_TPL_REPLACMENT['TYPES']!='300') && $num=='yes')
		   echo ($i+1).". ";
		if(!empty($row['external_link'])) {
			echo "<a target='_blank' href=".$row['external_link'].">".$span.$row["fio"].$span2."</a>";
		} else {
			if ($ps->isClosed($row)) {
				echo $span . $row["fio"] . $span2;
			} else {
				echo "<a href=" . $_SESSION["lang"] . "/index.php?page_id=" . $_TPL_REPLACMENT["PERSONA_PAGE"] . "&id=" . $row["persona"] . ">" . $span . $row["fio"] . $span2 . "</a>";
			}
		}
		echo "</h4>";
        if (!empty($row["regalii"]))
	        echo $row["regalii"]."<br />";
		if (($_TPL_REPLACMENT['TYPES']!='100') && ($_TPL_REPLACMENT['TYPES']!='200') && ($_TPL_REPLACMENT['TYPES']!='300') )
		{
			$spec = substr($row["spec_ds"],0,8);
			preg_match("@^\s?(\d+.\d+.\d+\.?)@",$row["spec_ds"],$specMatched);
			if(isset($specMatched[0])) {
				$spec = $specMatched[0];
			}
			$spec2 = substr($row["spec_ds2"],0,8);
			preg_match("@^\s?(\d+.\d+.\d+\.?)@",$row["spec_ds2"],$specMatched2);
			if(isset($specMatched2[0])) {
				$spec2 = $specMatched2[0];
			}
			$spec3 = substr($row["spec_ds3"],0,8);
			preg_match("@^\s?(\d+.\d+.\d+\.?)@",$row["spec_ds3"],$specMatched3);
			if(isset($specMatched3[0])) {
				$spec3 = $specMatched3[0];
			}

          
			           if($_TPL_REPLACMENT['TYPES']=="411")
				echo 'Специальность: '.$spec."<br />";
			if($_TPL_REPLACMENT['TYPES']=="412")
				echo 'Специальность: '.$spec2."<br />";
			if($_TPL_REPLACMENT['TYPES']=="413")
				echo 'Специальность: '.$spec3."<br />";
        }
		if($row['is_closed'] != 1) {
			echo $row["contact"];
		}
        echo "<tr>";
        echo "<tr><td colspan=3>&nbsp;</td></tr>";
        $i++;
	}
    echo "</table>";
	}
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>

