<style>
.abc a {color:white;}
.abc a:hover {color:red;}
</style>

<?
global $DB;
$avt = '';

 if ($_POST['matrix2']) $temp = $_POST['matrix2'];
  else $temp = $bow[people_linked];


$avt0=explode("<br>",trim($temp));

$i=0;
$avt="";
$avtid="";
$avtors = array();
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
		
		$avtid.=$avtor."<br>";
        $i++;
     }
}
//echo "@@@".$avt;

?>

<br>
<script language="JavaScript">

//_______________
function restore2()
{

 var k = 0;
 var num = 0;
 var c = [];
 var cid=[];
 
 var b = '<? echo $avt; ?>';
 var bid = '<? echo $avtid; ?>';
 
/*
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
*/ 
 c=b.split("<br>");
 cid=bid.split("<br>");

 for (i=0; i<c.length; i++)
 {
  if (c[i]=='') c[i]=cid[i];
  document.publ.avtor2.options[i] =  new Option(c[i], cid[i]);
  }
}

var a = [];
//_________________________
function sort2(smbl)
{


   var fullfio= document.getElementsByName('full2');
   var fio=document.getElementsByName('fio2');


   var k=0;

 document.publ.users2.options.length=0;

   for(i=0;i<fullfio.length;i++)
   {
   	   str=fullfio[i].value;
       strtext=fullfio[i].text;

   	   if (strtext.substr(0,1) == smbl.charAt(0) || smbl.charAt(0)=='a')
   	   {
   	       document.publ.users2.options[k] =  new Option(fullfio[i].text,fullfio[i].value);
//           document.publ.users.text[k]=strtext;
   	       k++;
        }

    }

}
//_________________________

function avtor_add2()
{

 if (document.publ.users2.value)
 {
  var alike=false;
  var fullfio= document.getElementsByName('full2');
  var txt= document.getElementsByName('users2');

  var num = document.publ.users2.value;

  for(i=0; i<document.publ.avtor2.options.length; i++)
  {
  if(document.publ.avtor2.options[i].value == document.publ.users2.value)
     alike = true;

  }

   for(i=0;i<fullfio.length;i++)
     if(document.publ.users2.value==fullfio[i].value)
         numfull=i;

  var nummer_array = document.publ.avtor2.options.length;
  if(document.publ.avtor2.options.length==1 && document.publ.avtor2.options[0].value=="")
      nummer_array = 0;

  if(alike) alert('Этот автор уже выбран!'); else
   document.publ.avtor2.options[nummer_array] = new Option(fullfio[numfull].text,document.publ.users2.value);
 }
update2();
}
//______________________________
function delall2()
{
document.publ.avtor2.options.length = 0;
update2();
}
//______________________________
function addotf2()
{
  if (document.publ.addot2.text==undefined) document.publ.addot2.text=document.getElementById('addot2').value;
//  alert(document.getElementById('addot').value+"@");
 if (document.publ.addot2.value != '')
{
    var nummer_array = document.publ.avtor2.options.length;
    if(document.publ.avtor2.options.length==1 && document.publ.avtor2.options[0].value=="")
        nummer_array = 0;
  document.publ.avtor2.options[nummer_array] = new Option(document.getElementById('addot2').value, document.getElementById('addot2').value);

}
 else
  alert('введите ФИО');
 update2();
}

//__________________________________
function update2()
{
//alert('update');
 document.publ.matrix2.value='';
 for(i=0; i<document.publ.avtor2.options.length; i++)
 {
  document.publ.matrix2.value += document.publ.avtor2.options[i].value + '<br>';
//  document.publ.matrix.text += document.publ.avtor.options[i].text + '<br>';
 }
//  alert(document.publ.avtor.options[i].text);
}

//_________________________________
function avtor_del2()
{
 if(document.publ.avtor2.value)
 {
  var selected = document.publ.avtor2.value;
  var i = 0;
  for(i; i<document.publ.avtor2.options.length; i++)
   if(document.publ.avtor2.options[i].value == document.publ.avtor2.value) break;
  for(i; i<document.publ.avtor2.options.length-1; i++)
  document.publ.avtor2.options[i] = new Option(document.publ.avtor2.options[i+1].text, document.publ.avtor2.options[i+1].value);
  document.publ.avtor2.options.length = document.publ.avtor2.options.length-1;
 }
 else
  alert('Выбирите кого удалять!!');
 update2();
}

//__________________________________
function avtor_move2(action)
{
if(document.publ.avtor2.value)
 {
  var selected = document.publ.avtor2.value;
  var selectedtext = document.publ.avtor2.text;

  var i = 0;
  for(i; i<document.publ.avtor2.options.length; i++)
  {
   if(document.publ.avtor2.options[i].value == document.publ.avtor2.value)
   {
       strtext=document.publ.avtor2.options[i].text;
       break;
   }
  }

  var k = 0;
  if (action == 'up') k=i-1;
   else
  if (action == 'down') k=i+1;
  document.publ.avtor2.options[i] = new Option(document.publ.avtor2.options[k].text, document.publ.avtor2.options[k].value);
  document.publ.avtor2.options[k] = new Option(strtext, selected);
 }
 else
  alert('Выбирите кого перемещать!');
update2();

}

</script>

<table border=0 bgcolor=gray>
   <tr>
      <td>
          <font color=white><b>Выбор связанных персон</b></font>
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
                     document.write('<a style=\"cursor:pointer;cursor:hand;\"  onclick=sort2(".'"'.chr($i).'"'.") style=color:white><b>".chr($i)."</b></a>');
                 </script>
                 ";
?>

		     <script language=javascript>
                  document.write('<a href='+location+'# onclick=sort2("all") style=color:white><b>&nbsp;&nbsp;BCE</b></a>');
             </script>
             </div>
        </td>
     </tr>
     <tr valign=top>
        <td>

            <input type=hidden name=matrix2>
            <select name=users2 size=10 style="width: 355">

<?
                global $DB,$_CONFIG;

                 $row0 = $DB->select("SELECT id,concat(surname,' ',name,' ',fname) as fio FROM persons ORDER BY fio");
                 echo "<br>";

            echo "</select>";
            echo "<div style='display:none;'>";
                 echo "<select name='f2' type='hidden'>";

                     foreach($row0 as $k=>$row)
                     {
                         $fio = $row[fio];
                         echo "<option type='hidden' id='full2' name='full2' value='".$row[id]."'>".$fio."</option>";
                     }
?>

                  </select>
             </div>
         </td>
         <td>
             <br><br><br>

             <input type="button" value=">" onclick="avtor_add2()">
             <br>
             <input type="button" value="<" onclick="avtor_del2()">
         </td>
         <td>
             <select name=avtor2 size=10 style="width: 250"></select>
             <br><br>
         </td>
         <td>
             <input type="button" value="/\" onclick="avtor_move2('up')">
             <br>
             <input type="button" value="\/" onclick="avtor_move2('down')">
         </td>
         <td>
             <font color=white>Сторонний автор: рус|en</font>
             <br>

             <input name=addot2 id=addot2 type=text size=50px;>
             <br>

             <input type=button value='Добавить' onclick="addotf2()">
         </td>
     </tr>
</table>

<script language="JavaScript">
   sort2('А');
   restore2();
   update2();
</script>
