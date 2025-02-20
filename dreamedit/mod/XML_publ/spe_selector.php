<style>
.abc a {color:white;}
.abc a:hover {color:red;}
</style>

<?
global $DB;
$avt = '';

 if ($_POST['matrix']) $temp = $_POST['matrix'];
//  else $temp = $bow[5];


$avt0=explode("<br>",trim($temp));

$i=0;
$avt="";
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
<script language="JavaScript">

//_______________
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
//_________________________
function sort(smbl)
{

   var fullfio= document.getElementsByName('full');
   var fio=document.getElementsByName('fio');


   var k=0;
 document.publ.users.options.length=0;

   for(i=0;i<fullfio.length;i++)
   {
   	   str=fullfio[i].value;

   	   if (str.substr(0,1) == smbl.charAt(0) || smbl.charAt(0)=='a')
   	   {
   	       document.publ.users.options[k] =  new Option(fullfio[i].value,fullfio[i].value);

   	       k++;
        }

    }

}
//_________________________

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
//______________________________
function delall()
{
document.publ.avtor.options.length = 0;
update();
}
//______________________________
function addotf()
{
 if (document.publ.addot.value != '')
{
  document.publ.avtor.options[document.publ.avtor.options.length] = new Option(document.publ.addot.value, document.publ.addot.value);

}
 else
  alert('введите ФИО');
 update();
}

//__________________________________
function update()
{
 document.publ.matrix.value='';
 for(i=0; i<document.publ.avtor.options.length; i++)
  document.publ.matrix.value += document.publ.avtor.options[i].value + '<br>';
}

//_________________________________
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

//__________________________________
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
   <tr>
      <td>
          <font color=white><b>Выбор авторов</b></font>
      </td>
   </tr>
   <tr>
      <td colspan=2>
<!--          <font color=white>-->
          <div class='abc'>
<?
             for ($i = ord("А"); $i <= ord("Я"); $i++)
                 if ((chr($i) != 'Ъ') && (chr($i) != 'Ь') && (chr($i) != 'Ы'))
                 echo "

                 <script language=javascript>
                     document.write('<a style=\"cursor:pointer;cursor:hand;\"  onclick=sort(".'"'.chr($i).'"'.") style=color:white><b>".chr($i)."</b></a>');
                 </script>
                 ";
?>

		     <script language=javascript>
                  document.write('<a href='+location+'# onclick=sort("all") style=color:white><b>&nbsp;&nbsp;BCE</b></a>');
             </script>
             </div>
        </td>
     </tr>
     <tr valign=top>
        <td>

            <input type=hidden name=matrix>
            <select name=users size=10 style="width: 355">

<?
                global $DB,$_CONFIG;

                 $row0 = $DB->select("SELECT concat(surname,' ',name,' ',fname) as fio FROM persons ORDER BY fio");
                 echo "<br>";

            echo "</select>";
            echo "<div style='display:none;'>";
                 echo "<select name='f' type='hidden'>";

                     foreach($row0 as $k=>$row)
                     {
                         $fio = $row[fio];
                         echo "<option type='hidden' id='full' name='full' value='".$fio."'></option>";
                     }
?>

                  </select>
             </div>
         </td>
         <td>
             <br><br><br>

             <input type="button" value=">" onclick="avtor_add()">
             <br>
             <input type="button" value="<" onclick="avtor_del()">
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
             <font color=white>Сторонний автор: рус|en</font>
             <br>

             <input name=addot type=text size=50px;>
             <br>

             <input type=button value='Добавить' onclick="addotf()">
         </td>
     </tr>
</table>

<script language="JavaScript">
   sort('А');
   restore();
   update();
</script>
