<?
global $DB;
$avt = '';

 if ($_POST['matrix']) $temp = $_POST['matrix'];
  else $temp = $bow[avtor];


$avt0=explode("<br>",trim($temp));

$i=0;
$avt="";
if (empty($_GET[alf])) $bukva="А";
else $bukva=$_GET[alf];
foreach($avt0 as $k=>$avtor)
{

    if (!empty($avtor))
    {
       if (is_numeric($avtor))
        {
    	   $ff=$DB->select("SELECT concat(surname,' ',name,' ',fname) as fio FROM persons WHERE id=".$avtor);
           $avtors[$i]=$ff[0][fio];
        }
        else
        {
            $avtors[$i]=$avtor;
        }
        $avt.=$avtors[$i]."<br>";
        $i++;
     }
}


?>

<br>
<script language="javascript">

function goto (alf,page) {

var hr=location.href;

setCookie("bukva",alf);
location.href=hr;

 alert(alf);
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
</script>
<script language="JavaScript">




function restore()
{
 var k = 0;
 var num = 0;
 var c = [];
 var b = '<? echo $avt; ?>';
 for (i=0; i<b.length; i++)
  if (b.charAt(i) == '<')
  {
   //alert(b);
   for (k; k<i; k++)
   {
    if (!c[num]) c[num]='';
    c[num] += b.charAt(k);
   }
   i=i+4;
   k=i;
   num=num+1;
  }
 for (i=0; i<c.length; i++)
  document.publ.avtor.options[i] =  new Option(c[i], c[i]);
}

var a = [];
function sort(smbl)
{
for(i=0; i<a.length; i++)
 document.publ.users.options[i] =  new Option(a[i], a[i]);
if (smbl != 'all') {
var k = 0;
 for(i=0; i<document.publ.users.options.length; i++) {
  a[k] = document.publ.users.options[k].value;
  k++;
 }
 for(i=0; i<document.publ.users.options.length; i++) {
  if(document.publ.users.options[i].value.charAt(0) != smbl.charAt(0))
  {
   document.publ.users.remove(i);
   i=i-1;
  }
 }
}
}


function avtor_add()
{
 if (document.publ.users.value)
 {
  var alike=false;
  for(i=0; i<document.publ.avtor.options.length; i++)
  if(document.publ.avtor.options[i].value == document.publ.users.value)
   alike = true;
  if(alike) alert('Этот автор уже выбран!'); else
   document.publ.avtor.options[document.publ.avtor.options.length] = new Option(document.publ.users.value, document.publ.users.value);
 }
update();
}

function delall()
{
document.publ.avtor.options.length = 0;
update();
}

function addotf()
{
 if (document.publ.addot.value != '')
  document.publ.avtor.options[document.publ.avtor.options.length] = new Option(document.publ.addot.value, document.publ.addot.value);
 else
  alert('введите ФИО');
 update();
}

function update()
{
 document.publ.matrix.value='';
 for(i=0; i<document.publ.avtor.options.length; i++)
  document.publ.matrix.value += document.publ.avtor.options[i].value + '<br>';
}


function avtor_del()
{
 if(document.publ.avtor.value)
 {
  var selected = document.publ.avtor.value;
  var i = 0;
  for(i; i<document.publ.avtor.options.length; i++)
   if(document.publ.avtor.options[i].value == document.publ.avtor.value) break;
  for(i; i<document.publ.avtor.options.length-1; i++)
  document.publ.avtor.options[i] = new Option(document.publ.avtor.options[i+1].value, document.publ.avtor.options[i+1].value);
  document.publ.avtor.options.length = document.publ.avtor.options.length-1;
 }
 else
  alert('Выбирите кого удалять!!');
 update();
}

function avtor_move(action)
{
 if(document.publ.avtor.value)
 {
  var selected = document.publ.avtor.value;
  var i = 0;
  for(i; i<document.publ.avtor.options.length; i++)
   if(document.publ.avtor.options[i].value == document.publ.avtor.value) break;
  var k = 0;
  if (action == 'up') k=i-1;
   else
  if (action == 'down') k=i+1;
  document.publ.avtor.options[i] = new Option(document.publ.avtor.options[k].value, document.publ.avtor.options[k].value);
  document.publ.avtor.options[k] = new Option(selected, selected);
 }
 else
  alert('Выбирите кого перемещать!');
update();

}

</script>

<table border=0 bgcolor=gray>
<tr><td>
<font color=white><b>Выбор авторов</b></font>
</td></tr>
<tr>
<td colspan=2>
<font color=white>
<?
// document.write('<a href='+location+'# onclick=sort(".'"'.chr($i).'"'.") style=color:white><b>".chr($i)."</b></a>');

 for ($i = ord("А"); $i <= ord("Я"); $i++)
 {
  if ((chr($i) != 'Ъ') && (chr($i) != 'Ь') && (chr($i) != 'Ы'))


?>
<!--     <a href=/dreamedit/index.php?mod=public&act=<?=$_REQUEST[act]?>&id=<?=$_REQUEST[id]?>&alf=<?=chr($i)?> style="color:white;" ><b><?=chr($i)?></b></a>-->
<?
  }
//<a href='+location+'# onclick=sort('.chr($i).'); style='color: white'><b>'.chr($i).'</b>&nbsp;</a>
?>

<script language=javascript>
document.write('<a href='+location+'# onclick=sort() style=color:white><b>&nbsp;&nbsp;BCE</b></a>');
</script>

</tr>
<tr valign=top>
<td>

<input type=hidden name=matrix>

<select name=users size=10 style="width: 355">

<?
 global $DB,$_CONFIG;

   $row0 = $DB->select("SELECT concat(surname,' ',name,' ',fname) as fio FROM persons ORDER BY fio");
   echo "<br>";
   foreach($row0 as $k=>$row)
   {
      $fio = $row[fio];
      echo "<option value='".$fio."'>".$fio."</option>";
   }
//mysql_close();
?>

</select>
</td>
<td>
<br><br><br>

<input type="button" value=">" onclick="avtor_add()" style="cursor:pointer;cursor:hand;">
<br>
<input type="button" value="<" onclick="avtor_del()" style="cursor:pointer;cursor:hand;">
</td>
<td>
<select name=avtor size=10 style="width: 250"></select>
<br><br>
</td>
<td>
<input type="button" value="/\" onclick="avtor_move('up')">
<br>
<input type="button" value="\/" onclick="avtor_move('down')">
</td>
<td>
<font color=white>Сторонний автор</font>
<br>
<input name=addot type=text>
<br>
<input type=button value='Добавить' onclick="addotf()">
</td></tr></table>

<script language="JavaScript">
 sort('all');
 restore();
 update();
</script>
