<?

// Работа с корзинкой

global $DB, $_CONFIG, $site_templater;

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
?>
<script type='text/javascript'>
var icoll=1;
function MyCheck()
{
	var len=document.userpubl.elements['ch[]'].length;
//	alert(document.userpubl.elements['ch[]']);
//	if (document.userpubl.elements['ch[]'].length==undefined)
//	{
//	 alert("*");
//	}
	var s=0;
	for(var i=1;i<len;i=i+1)
	{
	   if (document.userpubl.elements['ch[]'][i].checked)
	   {
	   	   s=1;
	   	   break;
	   }
	}
//    if (s==0 && document.userpubl.elements['ch[]'].length==undefined)
//    {
//      alert("!!!");
//      document.userpubl.elements['ch[]'][0].checked=true;
//      alert(document.userpubl.elements['ch[]'][0].checked);
//    }
    if (s==0)
    {
       alert("Надо отметить публикации, которые Вы хотите сохранить");
       return false;
    }
    return true;
}
function newcollection(param)
{
//   alert(document.getElementById('newselect').value);
//   alert(document.getElementById('list').innerHTML);
   document.getElementById('list').innerHTML=document.getElementById('list').innerHTML +
         "<br /><label><input  name='chp[]' type='checkbox' value='-" + icoll + "'>" +
         document.getElementById('newselect').value + "</input></label>";


   document.getElementById('newlist').innerHTML=document.getElementById('newlist').innerHTML +
   "<input type='checkbox' name='chn[]' checked value='"+icoll+"#"+document.getElementById('newselect').value+"'>"
   +icoll+"#"+document.getElementById('newselect').value+
   "</input>";
 //  alert(document.getElementById('newlist').innerHTML);
   icoll=icoll+1;
   document.getElementById('newselect').value="";

}

function publ_del(id,sp)
{

   var l=explode("|",sp);

   var str="";
   var len=l.length;
   for(var ii=0;ii=ii+1;ii<=(len-1))
   {
   	  if (l[ii] != id) str=str + l[ii] + "|";
  	  if ((ii+1)>l.length) break;
//  	  if (ii>8) break;
   }

   if (str!="") str=str.substr(0,(str.length-1));
//   alert("final="+str);
   document.getElementById("name"+id).style.display="none";
   document.getElementById("del"+id).style.display="none";
   var largeExpDate = new Date ();
   largeExpDate.setTime(largeExpDate.getTime() + (365 * 24 * 3600 * 1000));
   setCookie('publ',str,largeExpDate);
   setCookie('date_ins',date,largeExpDate);
}
function clear_publ(page)
{

    var largeExpDate = new Date ();
      largeExpDate.setTime(largeExpDate.getTime() + (365 * 24 * 3600 * 1000));

      setCookie('publ',"",largeExpDate);
      setCookie('date_ins',"",largeExpDate);
      location.href="/index.php?page_id="+page;


}
</script>
<?


//print_r($_COOKIE); echo "<br /><br />";
//print_r($_REQUEST);
//print_r($_POST);
//echo "<br />";
//print_r($_REQUEST);

if(!is_numeric($_REQUEST[useridext])) echo 'нужна регистрация';
else {
   $user0=$DB->select("SELECT surname,name,fname FROM comment_reg WHERE id=".$_REQUEST[useridext]);
   $user=$user0[0];

}
// Добавить новую подборку (надо переписать)
if (is_numeric($_REQUEST[useridext]))
{

	 //  Удаление
    if (count($_POST[chd])>0 && isset($_REQUEST[save]))
    {
    	foreach($_POST[chd] as $chd)
    	{
//    	   echo "<br />___".$chd;
    	   $DB->query("DELETE FROM user_publ WHERE user_id=".$_REQUEST[useridext]." AND counter=".$chd);
           $nn=$DB->select("SELECT name FROM user_collection WHERE id=".$chd);
           if ($nn!='Моя коллекция')
	    	   $DB->query("DELETE FROM user_collection WHERE user_id=".$_REQUEST[useridext]." AND id=".$chd);

    	}


    }
	 if (!empty($_POST[chn]) && isset($_REQUEST[save]))
    {
        foreach($_POST[chn] as $k=>$ns0)
        {
        $ns=explode("#",$ns0);
        $rs=$DB->select("SELECT id FROM user_collection WHERE name='".$ns[1]."'");
        if (count($rs)==0)
        {
            $DB->query("INSERT INTO user_collection (id,user_id,name) values(0,".$_REQUEST[useridext].",'".$ns[1]."') ");
            $lastids = $DB->select("SELECT LAST_INSERT_ID() FROM user_collection");
//            $len=count($_POST[sel]);
            $ind=array_search("-".$ns[0],$_POST[chp]);
            $_POST['chp'][$ind]=$lastids[0]['LAST_INSERT_ID()'];
        }
        }

    }
	$rowsr=$DB->select("SELECT w.id,sum(w.count) AS count,c.name FROM (
			SELECT id,0 AS count FROM user_collection WHERE user_id=".$_REQUEST[useridext].
		   " UNION
			SELECT counter AS id,count(id) AS count FROM
				                   user_publ WHERE user_id=".$_REQUEST[useridext]." GROUP BY counter) AS w
			INNER JOIN user_collection AS c ON c.id=w.id
			GROUP by w.id ORDER BY c.name"
	                    );

	if (count($rowsr)==0)
	{
	   $DB->query("INSERT INTO user_collection (id,user_id,name) values(0,".$_REQUEST[useridext].",'Моя коллекция') ");
            $lastids = $DB->select("SELECT LAST_INSERT_ID() FROM user_collection");
            $POST[chp][$lastids[0]['LAST_INSERT_ID()']]='on';
       $rowsr[0][id]=$lastids[0]['LAST_INSERT_ID()'][0];
       $rowsr[0][name]="Моя коллекция";
       $rowsr[0]['count']=0;
    }


}

// Список публикаций из Cookie, если надо, сохраняем
if (!empty($_REQUEST[publ]))
{
echo "<br /><br /><b>".substr($_REQUEST[date_ins],6,2).".".substr($_REQUEST[date_ins],4,2).".".substr($_REQUEST[date_ins],0,4). " Вы отложили публикации:</b>";
echo "<br /><br />";
$sp0=explode("|",$_REQUEST[publ]);
$where="";
$ids=Array();
$i=0;
foreach($sp0 as $sp)
{
   if (is_numeric($sp))
   {
	   $where.=" id=".$sp." OR ";

	   if (isset($_REQUEST[save]) &&  is_numeric($_REQUEST[useridext]) && in_array($sp,$_POST[ch]))
	   {
	   	  foreach($_POST[chp] as $sel)
	   	  {
	   	  $id0=$DB->select("SELECT id FROM user_publ WHERE publ_id=".$sp." AND  counter=".$sel);
	   	  if (empty($id0))
	   	  {
		   	  $DB->query("INSERT INTO user_publ (user_id,publ_id,date_insert,counter)
		   	  values(".
		   	  $_REQUEST[useridext].",".
		   	  $sp.",".
		   	  $_REQUEST[date_ins].",".
		   	  $sel.
		   	  ")");
	   	  }
	   	  else
	   	  {
	   	  	 $ids[$i]=$sp;
	   	  	 $i++;

	   	  }
          }
	   }
   }
}
if (strlen($where)>4) $where=substr($where,0,-4);
if (empty($where)) $where =1;
if (!empty($_REQUEST[publ]))
	$rows=$DB->select("SELECT DISTINCT id,name FROM publ WHERE ".$where." ORDER BY name ");
}

//Список отложенных публикаций (форма)
echo "<form name=userpubl method=post  action=/my_publ.html?save onSubmit='return MyCheck()'>";
echo "<input id=ch[] style='display:none;' type=checkbox name='ch[]' value='".$row[id]."' ".$check." ></input>";
echo "<table>";
foreach ($rows as $row)
{
   echo "<tr>";
   if ($_POST[ch][$row[id]]=='on' || count($rows)==1) $check='checked'; else $check='';
   echo "<td style='vertical-align:top;'><label><input id=ch[] type=checkbox name='ch[]' value='".$row[id]."' ".$check." ></input></label></td>";
   echo "<td>";
   echo "<div  id='name".$row[id]."' ><a href=/index.php?page_id=".$_TPL_REPLACMENT[PUBL_PAGE]."&id=".$row[id].">".$row[name]."</a></div></td>";
   echo "</tr>";
   echo "<td><td colspace='2'>&nbsp;</td></tr>";
}

echo "</table>";

/////
// Список подборок
echo "<br />";

if(is_numeric($_REQUEST[useridext]) && !empty($_REQUEST[publ]))
{
	echo "<div id='listsel' style='padding-left:5px;display:block;background-color:white;'> ";
//    echo "<b>Выберте, в каких подборках сохранить публикации:</b><br />";
    echo "<div id='list' style='display:none;'>";

    foreach($rowsr as $row)
    {

    	if ($row[name]=="Моя коллекция") $check='checked'; else $check='';
    	echo "<br /><label><input type='checkbox' name='chp[]' value='".$row[id]."' ".$check.">";
//        echo $row[name]."</input></label>";
//    	echo "<input type='checkbox' name='chd[]' value='".$row[id]."' >".$row[name]."</input>";
        echo $row[name];
    }
    echo "</div>";
//    echo "<input name='newselect' id='newselect' ></input>";
//    echo "<a onclick=newcollection() style='cursor:hand;cursor:pointer;'>Добавить новую подборку</a><br /><br />";

    echo "</div>";

	echo "<div id='newlist' style='display:none;'>";

	echo "</div>";

	echo "<br /><input type=submit value='сохранить' id='s1' style='display:block;' ></input>";

}

echo "</form>";
// Если нет логина

if(!is_numeric($_REQUEST[useridext]))
{
   echo "<div class='box5' id='login_in' style='padding-left:20px;background-color:white;'>Вы можете сохранить список в своем личном кабинете. Для этого необходимо ввести логин и пароль";

    if($_GET[debug]==2) {
        echo $_TPL_REPLACMENT["LOGIN"];
    } else {
        include($_TPL_REPLACMENT["LOGIN"]);
    }
   echo "</div>";
}
else {
    if ($_GET[debug] == 2) {
        echo $_TPL_REPLACMENT["LOGIN"];
    } else {
        include($_TPL_REPLACMENT["LOGIN"]);
    }
}
if (!empty($_REQUEST[publ]))
	echo "<br /><a href=# onclick=clear_publ(".$_REQUEST[page_id].") >Очистить список публикаций, отложенных сегодня</a>";
else
    echo "Откройте список публикации и отложите те из них, которые Вам интересны";

//////////// Список сохраненных публикаций
if (is_numeric($_REQUEST[useridext]))
{
	echo "<hr /><b>Работы в Вашей коллекции:</b>";
	if (empty($_TPL_REPLACMENT[count_publ]))$_TPL_REPLACMENT[count_publ]=20;
    $rowsall=$DB->select("SELECT p.id,p.name,p.avtor,p.hide_autor,c.name AS collection,u.date_insert,u.count_click,u.date_of,c.id AS cid
    					FROM publ AS p
                        INNER JOIN user_publ AS u ON u.publ_id=p.id AND user_id=".$_REQUEST[useridext].
                       " INNER JOIN user_collection AS c ON c.id=u.counter ".
                       " ORDER BY c.name,u.count_click DESC,p.name"
	                    );

$cname='';
echo "<form name=userpubl2 method=post  action=/my_publ.html?save >";

foreach($rowsall as $row)
{
/*
   if ($cname!=$row[collection])
   {
   	   if (!empty($cname)) echo "</div>";
   	   echo "<br /><br /><label><input type='checkbox' name='chd[]' value='".$row[cid]."' >
   	   <a name='".$row[cid]."'></a><b>Подборка: ".$row[collection]."</input></label></b>";
   	   $cname=$row[collection];
   	   echo "<div style='padding-left:30px;'>";
   }
*/
   echo "<br /><br /><a href=/index.php?page_id=".$_TPL_REPLACMENT[PUBL_PAGE]."&id=".$row[id].">".$row[name]."</a><br />";
   echo "Размещено: ".substr($row[date_insert],8,2).".".substr($row[date_insert],5,2).".".substr($row[date_insert],0,4).
   ", открыто: ".$row[count_click].", последний раз ".
   substr($row[date_of],8,2).".".substr($row[date_of],5,2).".".substr($row[date_of],0,4);

}

if (!empty($cname)) echo "</div>";
	echo "<br /><input type=submit value='сохранить' id='s1' style='display:block;' ></input>";

echo "</form>";
}
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>