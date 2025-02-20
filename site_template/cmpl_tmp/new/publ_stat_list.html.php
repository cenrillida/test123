<?
// Рейтинг публикаций
global $DB,$_CONFIG, $site_templater;


$pg = new Pages();

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.html");
?>


<div class='content'>
<div class="content sitepadding">


   <div class='contentpadding' >
  <!--   <?php //echo $_TPL_REPLACMENT["SUBMENU"];?>  -->
<!--////////////////////////////////-->


<h1><?=@$_TPL_REPLACMENT["CONTENT_HEADER"]?></h1>

<!--////////////////////////////////-->
<script>
var global_param;
var global_sort1;
var global_sort2;
var global_sort3;
var global_filter;


function doInitGrid(){

         if(document.getElementById('tblToGrid'))
         {

             var ss="";
             var arr;
             var value1 = document.cookie.match(/sort1=([^;]*)/i);
		     var value2 = document.cookie.match(/sort2=([^;]*)/i);
		     var value3= document.cookie.match(/sort3=([^;]*)/i);
		     var ffilter= document.cookie.match(/filter=([^;]*)/i);

			 if (ffilter)
			 {
			   ss=unescape(ffilter[1]);
			   arr=ss.split(",");
			 }
             else arr="";

			 if(value1) global_sort1=value1[1];
             if(value2) global_sort2=value2[1];
			 if(value3) global_sort3=value3[1];


	         grid = new dhtmlXGridFromTable('tblToGrid');

			 grid.attachHeader("#numeric_filter,#numeric_filter,#numeric_filter,#text_filter,#numeric_filter,#text_filter");
             grid.init;
<!--            grid.setColTypes("price,txt,txt,txt,txt");-->
             grid.setColSorting("int,int,int,str,int,str,str")



             grid.sortRows(global_sort1,global_sort2,global_sort3);

             grid.attachEvent("onFilterStart",doOnFilterStart);

        grid.attachEvent("onEditCell",onRowDblClicked);
             grid.attachEvent("onAfterSorting",doOnAfterSorting);

          var children = document.getElementById('mytbl').getElementsByTagName('input');
             for(i=0;i<arr.length;i++)
             {
			     if (!empty(arr[i]))
			     {
              	     grid.filterBy(i,arr[i],true);
              	     children[i].value=arr[i];
				 }
			 }


             grid.enableSmartRendering(true,50);
          <!--   grid.setSkin("light");-->


         }
}

function onRowDblClicked(param1,param2,param3)
{
	if (param1==0)
	{
	    var id = document.getElementById("id"+param2).value;
	    location.href='/index.php?page_id=1328&id='+id;
	}

}
function chfilter()
{
    setCookie("filter","");
    var a=document.getElementById("ftxt").style;
    a.display="none";
    var children = document.getElementById('mytbl').getElementsByTagName('input');
    for(var i=0;i<children.length;i++)
        children[i].value="";
    grid.filterBy(1,"");
}
// Cookies
function setCookie(name, value, expires, path, domain, secure) {
  var curCookie = name + "=" + escape(value) +
  ((expires) ? "; expires=" + expires.toGMTString() : "") +
  ((path) ? "; path=" + path : "") +
  ((domain) ? "; domain=" + domain : "") +
  ((secure) ? "; secure" : "");

  document.cookie = curCookie;
}

function doOnFilterStart(param1,param2){

   var a=document.getElementById("ftxt").style;
   a.display="block";
    setCookie("filter",param2);
    return true;
 }

 function doOnAfterSorting(rowId,cellInd,param){

	 var str=rowId+","+cellInd+","+param;

     setCookie("sort1",rowId);
     setCookie("sort2",cellInd);
     setCookie("sort3",param);
 }
function filterBy(){

			var tVal = document.getElementById("title_flt").childNodes[0].value.toLowerCase();
			var aVal = document.getElementById("title_mb").childNodes[0].value.toLowerCase();

			for(var i=0; i< grid.getRowsNum();i++){

				var tStr = grid.cells2(i,1).getValue().toString().toLowerCase();
				var aStr = grid.cells2(i,3).getValue().toString().toLowerCase();

				if((tVal=="" || tStr.indexOf(tVal)==0) && (aVal=="" || aStr.indexOf(aVal)==0))
					grid.setRowHidden(grid.getRowId(i),false)
				else
					grid.setRowHidden(grid.getRowId(i),true)
			}

		}
function populateSelectWithAuthors(selObj){
			selObj.options.add(new Option("All",""))
			var usedAuthAr = new dhtmlxArray();
			for(var i=0;i<grid.getRowsNum();i++){
				var authNm = grid.cells2(i,3).getValue();
				if(usedAuthAr._dhx_find(authNm)==-1){
					selObj.options.add(new Option(authNm,authNm))
					usedAuthAr[usedAuthAr.length] = authNm;
				}
			}
		}
function filter_def(page_id)
{
	var a=document.getElementById('limit[]');
	a.checked=true;
	var a=document.getElementById('view[]');
	a.checked=true;
    var a=document.getElementById('ctl[]');
	a.checked=true;
    var a=document.getElementById('sfio');
     a.value='';

    var a=document.getElementById('rub');
     a.value='';
//     chfilter();
//	a.checked=true;
    location.href='/index.php?page_id='+page_id;
}

</script>



<?

////////////////////
$count0=$DB->select("SELECT count(id) AS count FROM publ WHERE name <> '' AND status=1");
$nn_page=$_TPL_REPLACMENT['COUNT'];
if (empty($nn_page)) $nn_page=40;
$numpages=ceil($count0[0]['count']/$_TPL_REPLACMENT['COUNT']);
  if(!$_REQUEST['page']) $page = 1;
      else $page = $_REQUEST['page'];
//    $count = 0;

//print_r($_POST);
if(!empty($_GET[rub]) && empty($_POST[rub])) $_POST[rub]=$_GET[rub];
if(!empty($_GET[view]) && empty($_POST[view])) $_POST[view]=$_GET[view];
if(!empty($_GET[ctl]) && empty($_POST[ctl])) $_POST[ctl]=$_GET[ctl];


if (($_REQUEST['page']) && ($_REQUEST['page']>1))
   $request_string=str_replace(" ","_",$request_string);
   $previos = "<a href=index.php?page_id=" .
   $_REQUEST[page_id]."&page=".($_REQUEST['page']-1).str_replace(" ","_",$request_string).$rubreq."><b>предыдущая&nbsp&nbsp&larr;</b></a>&nbsp&nbsp; ";

//Сформировать список с номерами страниц

	if ($_REQUEST['page']<=$numpages)

	if ($_REQUEST[page]=="") $tpage=1;
	else $tpage = $_REQUEST[page];
	$next = "<a href=index.php?page_id=".$_REQUEST[page_id]."&page=".($tpage+1).str_replace(" ","_",$request_string).$rubreq."><b>&nbsp&rarr;&nbsp&nbsp   cледующая</b></a>";
    $porog=15; //$numpages*0.3; //Показывать треть от номеров страниц
	if($_REQUEST[page] > 1) $spe .= $previos;
	if ($page>ceil($porog/2)+1)
	{

	    $spe .= '<a href=index.php?page_id='.$_REQUEST[page_id].str_replace(" ","_",$request_string).$rubreq."&page=1>1</a>&nbsp;&nbsp ";
	}
	if ($page>ceil($porog/2)+2)
	{
	   $spe .= '... ';
	}

	if ($page<=ceil($porog/2)) $page_start=1;
	else
	    if ($page>($numpages-$porog)) $page_start=$numpages-$porog;
	    else
	       $page_start=$page-ceil($porog/2);
	if ($page_start<1) $page_start=1;
	$page_end=$numpages;
	if($numpages>$porog+$page_start-1) $page_end=$porog+$page_start-1;
	for($i=$page_start;$i<$page_end;$i++)
	{
		if($page==$i)
		{
		   $ii="<strong>".$i."</strong>";
		   $spe .= $ii."&nbsp;&nbsp ";
        }
		else
		{
		   $ii=$i;
    		$spe .= "<a style='text-decoration:underline;' href=index.php?page_id=".$_REQUEST[page_id].str_replace(" ","_",$request_string).$rubreq."&page=".$i.">".$ii."</a>&nbsp;&nbsp ";
	    }
	 }

	if($page<$numpages && $page_end<$numpages) $spe .= '... ';
	if ($page!=$numpages)
    	$spe .= '<a href=index.php?page_id='.$_REQUEST[page_id].str_replace(" ","_",$request_string).$rubreq."&page=".$numpages.">".$numpages."</a>&nbsp;&nbsp ";
    else
       	$spe .= '<a href=index.php?page_id='.$_REQUEST[page_id].str_replace(" ","_",$request_string).$rubreq."&page=".$numpages."><b>".$numpages."</b></a>&nbsp;&nbsp ";

	if ($_REQUEST[page]< $numpages && $numpages > 1) $spe .= "&nbsp;&nbsp;".$next;

// Вывести заголосок с количеством публикаций
 //      echo "<b>".$vsego."</b><br />";
 //    if ($numpages > 1)
 //       echo "<center>".$spe."</center>";
// Посчитать начальную и конечную публикацию в списке
       $i0=($page-1)*$nn_page;
       $in=$page*$nn_page;
//////////////
// Сформировать строку поиска

$search_string_s="1";
$search_string_p="1";

     switch($_POST[limit])
     {
     	case 0:
     	   $lim="LIMIT 100";
     	   break;
     	case 1:
     	   $lim="LIMIT 500";
     	   break;
     	case 2:
     	   $lim="";
     	   break;
     }

      switch($_POST[view])
     {
     	case 0:
     	   break;
     	case 1:
     	   $search_string_s=" s.month=".date("m")." AND s.year=".date("Y");
     	   break;
     	case 2:
     	   $m2=date('m');$y2=date('Y');
     	   if ($m2>3)
     	   {
     	   	   $m1=(date('m')-2);
     	   	   $y1=date('Y');
     	   }
     	   else
     	   {
     	   	   $m1=((date('m')-2)+12);
     	   	   $y1=(date('Y')-1);
     	   }
     	   $search_string_s=" ((s.month>=".$m1." AND s.year=".$y1.") OR (s.year=".$y2." AND s.month<=".$m2."))";
     	   break;
     	 case 3:
     	   $m2=date('m');$y2=date('Y');
     	   if ($m2>3)
     	   {
     	   	   $m1=(date('m')-5);
     	   	   $y1=date('Y');
     	   }
     	   else
     	   {
     	   	   $m1=((date('m')-5)+12);
     	   	   $y1=(date('Y')-1);
     	   }
     	   $search_string_s=" ((s.month>=".$m1." AND s.year=".$y1.") OR (s.year=".$y2." AND s.month<=".$m2."))";
     	   break;
         case 4:
     	   $search_string_s=" s.year=".date("Y");
     	   break;
     	 }
      switch($_POST[ctl])
     {
     	case 0:
     	   break;
     	case 1:
     	   $search_string_p=" substring(p.date, 4,2)=".date("m")." AND substring(p.date,7,2)=".substr(date("Y"),2,2);
     	   break;
     	case 2:
     	   $m2=date('m');$y2=substr(date('Y'),2,2);
     	   if ($m2>3)
     	   {
     	   	   $m1=(date('m')-2);
     	   	   $y1=substr(date('Y'),2,2);
     	   }
     	   else
     	   {
     	   	   $m1=((date('m')-2)+12);
     	   	   $y1=substr((date('Y')-1),2,2);
     	   }

     	   $search_string_p=" ((substring(p.date, 4,2)>=".$m1." AND substring(p.date,7,2)=".$y1.") OR (substring(p.date,7,2)=".$y2." AND substring(p.date, 4,2)<=".$m2."))";
     	   break;
     	case 3:
     	   $m2=date('m');$y2=substr(date('Y'),2,2);
     	   if ($m2>3)
     	   {
     	   	   $m1=(date('m')-5);
     	   	   $y1=substr(date('Y'),2,2);
     	   }
     	   else
     	   {
     	   	   $m1=((date('m')-5)+12);
     	   	   $y1=substr((date('Y')-1),2,2);
     	   }

     	   $search_string_p=" ((substring(p.date, 4,2)>=".$m1." AND substring(p.date,7,2)=".$y1.") OR (substring(p.date,7,2)=".$y2." AND substring(p.date, 4,2)<=".$m2."))";
     	   break;
     	 case 4:
     	   $search_string_p=" substring(p.date,7,2)=".substr(date("Y"),2,2);
      }
//////////

     $search_r=1;
     if (!empty($_POST[rub]))
     {

     	   $search_r=" (p.rubric2 =".$_POST[rub]." OR p.rubric2d =".$_POST[rub].")";

     }
//////////

     $search_a=1;
//     print_r($_POST);
     if (!empty($_POST[sfio]))
     {
     	$a=explode("#",$_POST[sfio]);
//     	echo "<br />_____";
//     	print_r($a);
     	if ($a[0]==0)
     	   $search_a=" p.avtor LIKE '%".$a[1]."%'";
     	else
     	{
//     	   echo "<br />*"."p.avtor LIKE '".$a[0]."<br%'";
     	   $search_a="( p.avtor LIKE '".$a[0]."<br>%' OR p.avtor LIKE '%<br>".$a[0]."<br>%' OR p.avtor LIKE '%<br>".$a[0]."')";
         }

     }
//if (!empty($search_string_s)) $search_string_s=substr($search_string,0,-4); else $search_string=1;
//echo "<br />_________".$search_a; print_r($a);

if($_GET[debug]==55) {
    var_dump(" SELECT * FROM
					(SELECT p.id,p.avtor,p.name,p.name2,p.year,p.date,
				   `link`,
				   SUM(IFNULL(s.publ_count,0)) AS publ_count,SUM(IFNULL(s.pdf_count,0)) AS pdf_count,IFNULL(s.date,0) AS publ_date
				   FROM publ AS p
                   INNER JOIN publ_stat AS s ON s.publ_id=p.id
                   WHERE p.name <> ''  AND p.status=1 AND ".$search_string_s. " AND ".$search_string_p." AND ".$search_a." AND ".$search_r.
        "  GROUP BY publ_id ) AS t
                  ORDER BY pdf_count*pdf_count  DESC  ".$lim

    );
    //exit;
}

if ($_POST[view]!=5)
$rows=$DB->select(" SELECT * FROM
					(SELECT p.id,p.avtor,p.name,p.name2,p.year,p.date,
				   `link`,
				   SUM(IFNULL(s.publ_count,0)) AS publ_count,SUM(IFNULL(s.pdf_count,0)) AS pdf_count,IFNULL(s.date,0) AS publ_date
				   FROM publ AS p
                   INNER JOIN publ_stat AS s ON s.publ_id=p.id
                   WHERE p.name <> ''  AND p.status=1 AND ".$search_string_s. " AND ".$search_string_p." AND ".$search_a." AND ".$search_r.
                  "  GROUP BY publ_id ) AS t
                  ORDER BY pdf_count*pdf_count  DESC  ".$lim

                   );
//                ORDER BY sqrt(publ_count*publ_count+pdf_count*pdf_count)  DESC  ".$lim

else
$rows=$DB->select("SELECT p.id,p.avtor,p.name, p.name2,p.year,p.date, `hide_autor` AS avt,`link` FROM publ AS p
      WHERE ".$search_string_p." AND ".$search_a." AND ".$search_r." AND (p.name<>'' AND p.status=1 AND p.id NOT IN(
                    SELECT publ_id FROM publ_stat AS s WHERE  ".$search_string_s.")) ".$lim);

/*if($_GET[debug]==1) {
  $rowsnull = $DB->selectCol("SELECT publ_id FROM publ_stat WHERE ".$search_string_s." GROUP BY publ_id");
  $rowsnull_find=$DB->selectCol("SELECT p.id AS count FROM publ AS p WHERE ".$search_string_p." AND ".$search_a." AND ".$search_r." AND (p.name<>'' AND p.status=1)");
  $rowsnull_count = 0;
  foreach ($rowsnull_find as $key => $value) {
    if(!in_array($value, $rowsnull))
      $rowsnull_count++;
  }
  exit;
}*/

$rowsnull=$DB->select("SELECT count(p.id) AS count FROM publ AS p LEFT JOIN (SELECT publ_id FROM publ_stat AS s WHERE ".$search_string_s.") AS ps ON p.id=ps.publ_id WHERE ".$search_string_p." AND ".$search_a." AND ".$search_r." AND (p.name<>'' AND p.status=1 AND ps.publ_id IS NULL)  ");




////////////// Авторы
//////
  $rowsa=$DB->select(
         "SELECT  id,fio FROM
			(
			SELECT '0' AS id,avtor AS fio FROM publ
			UNION
			 SELECT p.id,
			 CONCAT(p.surname,' ',substring(p.name,1,1),'.',substring(p.fname,1,1),'.') AS fio
			 FROM persons AS p
			INNER JOIN publ ON avtor LIKE CONCAT(p.id,'<br%') OR avtor LIKE CONCAT('%br>',p.id,'<br%') OR avtor LIKE CONCAT('%br>',p.id)
			) AS t
			");

  foreach($rowsa as $row)
  {
  	 if ($row[id]!=0)
  	 {
  	     if (substr($row[fio][fio],0,1)<="Z")
  	     {
  	        $fio_en[$row[fio]][id]=$row[id];
  	     	$fio_en[$row[fio]][fio]=$row[fioshort];
  	     }
  	     else
  	     {
  	     	$fio[$row[fio]][id]=$row[id];
  	     	$fio[$row[fio]][fio]=$row[fioshort];
  	     }
  	 }
  	 else
  	 {
  	 	$str0=explode("<br>",$row[fio]);
//  	 	echo "<hr />".$row[fio];

  	 	foreach($str0 as $str)
  	 	{
  	 		$t=trim($str);

  	 		if (!empty($t) && $t!='Коллектив авторов')
  	 		   if (!is_numeric($t))
  	 		   {
                  if (substr($t,0,1)<="Z")
                     $fio_en[$t][id]=0;
                  else
  	 			     $fio[$t][id]=0;
//  	 			  $fio[$t][fio]=$t;
               }
  	 	}
  	 }
  }



  ksort($fio);
  ksort($fio_en);


////////////


  $ii=0;
 foreach($rows as $row)
 {
    $ii++;
    echo "<input type='hidden' id='id".$ii."' value=".$row[id]."></input>";
 }



//Фильтр
echo "<table>";
echo "<tr>";
echo "<td valign='top'><br /><br /><b>Фильтр к списку публикаций</b><br /><br />";

?>
	<form name="fpsearch" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" >
<?

echo "<table width='100%'>";
echo "<tr>";
echo "<a style='cursor:pointer;cursor:hand;' onClick=filter_def(".$_REQUEST[page_id].") title='Установить по умолчанию'>Установить по умолчанию</a>";
echo "<td><hr /><b>Выводить:</b><br /><br />";
if ($_POST[limit]==0) $check=" checked ";else $check="";
echo " <input type='radio' id='limit[]' name='limit' value='0'". $check."> Top 100</input><br />";
if ($_POST[limit]==1) $check=" checked ";else $check="";
echo " <input type='radio'  id='limit[]' name='limit' value='1'". $check."> Top 500</input><br />";
if ($_POST[limit]==2) $check=" checked ";else $check="";
echo " <input type='radio'  id='limit[]' name='limit' value='2'". $check."> Все</input><br />";
echo "</td></tr>";

echo "<tr>";
echo "<td><hr /><b>Просмотрены:</b><br /><br />";
if ($_POST[view]==0) $check=" checked ";else $check="";
echo " <input type='radio'  id='view[]' name='view' value='0'". $check."> Не важно</input><br />";
if ($_POST[view]==1) $check=" checked ";else $check="";
echo " <input type='radio'   id='view[]' name='view' value='1'". $check."> За последний месяц</input><br />";
if ($_POST[view]==2) $check=" checked ";else $check="";
echo " <input type='radio'   id='view[]' name='view' value='2'". $check."> За последние 3 месяцa</input><br />";
if ($_POST[view]==3) $check=" checked ";else $check="";
echo " <input type='radio'   id='view[]' name='view' value='3'". $check."> За последние полгода</input><br />";
if ($_POST[view]==4) $check=" checked ";else $check="";
echo " <input type='radio'   id='view[]' name='view' value='4'". $check."> За последний год</input><br />";
if ($_POST[view]==5) $check=" checked ";else $check="";
echo " <input type='radio'   id='view[]' name='view' value='5'". $check."> Ни разу</input><br />";
echo "</td></tr>";

echo "<tr>";
echo "<td><hr /><br /><b>Поступили в каталог:</b><br />";
if ($_POST[ctl]==0) $check=" checked ";else $check="";
echo " <input type='radio' id='ctl[]' name='ctl' value='0'". $check."> Не важно</input><br />";
if ($_POST[ctl]==1) $check=" checked ";else $check="";
echo " <input type='radio'  id='ctl[]' name='ctl' value='1'". $check."> В текущем месяце</input><br />";
if ($_POST[ctl]==2) $check=" checked ";else $check="";
echo " <input type='radio'  id='ctl[]' name='ctl' value='2'". $check."> За последние 3 месяцa</input><br />";
if ($_POST[ctl]==3) $check=" checked ";else $check="";
echo " <input type='radio'  id='ctl[]' name='ctl' value='3'". $check."> За последние полгода</input><br />";
if ($_POST[ctl]==4) $check=" checked ";else $check="";
echo " <input type='radio'  id='ctl[]' name='ctl' value='4'". $check."> В текущем году</input><br />";
echo "</td></tr>";

echo "<tr>";
echo "<td>";
echo "<br /><hr /><b>Авторы:</b><br />";

echo "<select name='sfio' id='sfio' style='color:#333333;'>";
echo "<option value=''></option>";

foreach($fio as $k=>$f)
{
    if ($_POST[sfio]==$f[id]."#".$k) $sel=" selected "	; else $sel="";
    echo "<option value='".$f[id]."#".$k."' ".$sel.">".$k."</option>";
}
foreach($fio_en as $k=>$f)
{
    if ($_POST[sfio]==$f[id]."#".$k) $sel=" selected "	; else $sel="";
    echo "<option value='".$f[id]."#".$k."'".$sel.">".$k."</option>";
}
echo "</select>";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo "<br /><hr /><b>Рубрики</b><br />";

$pg=new Directories();

$rub0=$pg->getDirectoryRubrics("Рубрики в публикациях");
//print_r($rub0);
echo "<select name='rub' id='rub'  style='color:#333333;'>";
echo "<option value=''></option>";
foreach($rub0 as $rub)
{
	if($rub[id]==$_POST[rub]) $sel=" selected "; else $sel="";
	if (strlen($rub[name]) >30) $sym="...";else $sym="";
	echo "<option title='".$rub[text]."' value=".$rub[id].$sel.">".substr($rub[text],0,30).$sym."</option>";
}
echo "</select>";



echo "<tr><td><br />";
echo "<input type='submit' name='Submit' value='Показать'>";
echo "</td></tr>";
echo "</table>";
echo "</form>";
echo "</td>";
echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";

echo "<td valign='top' width='100%'>";
echo "<b>Всего публикаций: </b>".$count0[0]['count']."<br />";
echo "<br /><b>Выводится публикаций (с учетом Вашего запроса):</b> ".count($rows);
echo "<br /><b>Из них ни разу не просмотрено публикаций: </b>".$rowsnull[0]['count']."<br /><br />";

$a=trim($_COOKIE[filter],",");
     if (!empty($a)  ) $block='block'; else $block='none';
        echo "<br /><div id='ftxt' style='display:".$block.";'><br /><strong>Фильтр включен</strong>".
         "&nbsp;&nbsp;&nbsp;<a style='cursor:pointer;cursor:hand' href=javascript:chfilter()>сбросить</a>
         </div>";


?>
<div id='mytbl'>

<!--<table class='dhtmlXGrid' style='font-family:Tahoma;font-size:11px;' gridHeight='800px'  id="tblToGrid" border="1" lightnavigation="true" imgpath="http://it.isras.ru/grid/dhtmlxGrid/codebase/imgs/"  >
-->
<table width='100%' border='1'>
<tr>
<!--<td align='center'>&nbsp;Рейтинг&nbsp;</td>-->
<td align='center'>&nbsp;Аннот.&nbsp;</td><td align='center'>&nbsp;Скачано&nbsp;</td><td>Библиографичеcкая ссылка</td><td>Год<td>Дата<br />в каталоге</td>
<td>&nbsp;pdf&nbsp;</td><td>подробнее</td></tr>

<?
$nn="\r\n";
foreach($rows as $row)
{
	echo "<tr>";

//	echo "<td align='right' valign='top'>".round(sqrt($row[publ_count]*$row[publ_count]+$row[pdf_count]*$row[pdf_count]),2)."</td>";
	echo "<td align='right' valign='top'>".$row[publ_count]."&nbsp;&nbsp;&nbsp;</td>";
	echo "<td align='right' valign='top'>".$row[pdf_count]."&nbsp;&nbsp;&nbsp;</td>";
// Разобрать авторов
    $avt0=explode("<br>",trim($row[avtor]));
    $avt_list="";
    foreach($avt0 as $avt)
    {
    	if (is_numeric($avt))
    	{
    		$aa=$DB->select("SELECT CONCAT(surname,' ',substring(name,1,1),'. ',substring(fname,1,1),'.') AS fio
    						 FROM persons WHERE id=".$avt);
    		$avt_list.=$aa[0][fio].",";
    	}
    	else
    	    $avt_list.=$avt.",";
    	}
    	$avt_list=substr($avt_list,0,-1);
//
	if ($row[avt]!='on' && false)  // отключен вывод авторов
    	echo "<td width='100%' title='".$avt_list.$nn.$row[name].$row[name2]." '>".$avt_list.$row[name]."".$row[name2]."</td>";
	else
 		echo "<td  width='100%' title='".$nn.$row[name].$row[name2]." '>"."".$row[name]."".$row[name2]."</td>";
	echo "<td class='px-2'>".$row[year]."</td>";
	echo "<td class='px-2'>".str_replace(".","/",$row['date'])."</td>";
	if (strpos($row['link'],".pdf")>0)
	{
		$ch="checked='checked'";
		$txtpdf="Есть текст в pdf";
	}
	else
	{
		$ch="";
		$txtpdf="Только аннотация";
	}

	echo "<td align='center' title='".$txtpdf."'><input type=checkbox ".$ch."></input></td>";
	echo "<td>"."<a href=/index.php?page_id=".$_TPL_REPLACMENT[FULL_ID_P]."&id=".$row[id]." title='сведения о публикации'>подробнее</a>"."</td>";
    echo "</tr>";

}
echo "</table></div>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "</div>";

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.html");
?>
