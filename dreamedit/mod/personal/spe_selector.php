<style>
.abc a {color:white;}
.abc a:hover {color:red;}
</style>

<?
global $DB;
$avt = '';


if (!empty($_REQUEST[t]))
{
$avtors=$DB->select("SELECT p.id,CONCAT(surname,' ',name,' ',fname) AS fio
                   FROM Admin AS s
                   INNER JOIN persons AS p ON p.id=s.persona
				   WHERE s.type=".$_REQUEST[t]." 
                   ORDER BY s.sort");

// print_r($avtors);
}
 $i=0;
/*
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
*/
$avt='';
$avtid='';
foreach($avtors as $a)
{
	$avt.=$a[fio]."<br>";
	$avtid.=$a[id]."<br>";
}
?>

<br>
<script language="JavaScript">
function is_Numeric(x) {
// I use this function like this: if (isNumeric(myVar)) { }
// regular expression that validates a value is numeric
var RegExp = /^(-)?(\d*)(\.?)(\d*)$/; // Note: this WILL allow a number that ends in a decimal: -452.
// compare the argument to the RegEx
// the 'match' function returns 0 if the value didn't match
var result = x.match(RegExp);
return result;
}
function explode( delimiter, string ) {    // Split a string by string
    //
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: kenneth
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)

    var emptyArray = { 0: '' };

    if ( arguments.length != 2
        || typeof arguments[0] == 'undefined'
        || typeof arguments[1] == 'undefined' )
    {
        return null;
    }

    if ( delimiter === ''
        || delimiter === false
        || delimiter === null )
    {
        return false;
    }

    if ( typeof delimiter == 'function'
        || typeof delimiter == 'object'
        || typeof string == 'function'
        || typeof string == 'object' )
    {
        return emptyArray;
    }

    if ( delimiter === true ) {
        delimiter = '1';
    }

    return string.toString().split ( delimiter.toString() );
}
//_______________
function restore()
{

 var k = 0;
 var num = 0;
 var c = [];
 var b = '<? echo $avtid; ?>';
 document.getElementById('matrix').value=b;
// alert(document.getElementById('matrix').value);
// var b='<?= $value ?>';
//alert(b);
 avt=explode("<br>",b);
 for(i=0;i<avt.length;i++)
 {
     if( avt[i] !== '') {
         var fullfio = document.getElementsByName('full');
         if (is_Numeric(avt[i])) {
             for (j = 0; j < fullfio.length; j++)
                 if (fullfio[j].value == avt[i]) break;

             document.publ.avtor.options[i] = new Option(fullfio[j].text, avt[i]);
         } else {
             document.publ.avtor.options[i] = new Option(avt[i], avt[i]);
         }
     }
  }

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
       strtext=fullfio[i].text;
   	   if (strtext.substr(0,1) == smbl.charAt(0) || smbl.charAt(0)=='a')
   	   {
   	       document.publ.users.options[k] =  new Option(fullfio[i].text,fullfio[i].value);
//           document.publ.users.text[k]=strtext;
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
  var fullfio= document.getElementsByName('full');
  var txt= document.getElementsByName('users');
  for(i=0; i<document.publ.avtor.options.length; i++)
  {
  	if(document.publ.avtor.options[i].value == document.publ.users.value)
   	alike = true;
  }

   for(i=0;i<fullfio.length;i++)
     if(document.publ.users.value==fullfio[i].value)
         numfull=i;
  if(alike) alert('Эта персона уже выбрана!'); else
   document.publ.avtor.options[document.publ.avtor.options.length] = new Option(fullfio[numfull].text,document.publ.users.value);
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
 {

  document.publ.matrix.value += document.publ.avtor.options[i].value + '<br>';
  }
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
  document.publ.avtor.options[i] = new Option(document.publ.avtor.options[i+1].text, document.publ.avtor.options[i+1].value);
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
  {
   if(document.publ.avtor.options[i].value == document.publ.avtor.value)
   {
       strtext=document.publ.avtor.options[i].text
       break;
   }
  }

//   var i = 0;
//   for(i; i<document.publ.avtor.options.length; i++)
//   if(document.publ.avtor.options[i].value == document.publ.avtor.value) break;
  var k = 0;
  if (action == 'up') k=i-1;
   else
  if (action == 'down') k=i+1;
  document.publ.avtor.options[i] = new Option(document.publ.avtor.options[k].text, document.publ.avtor.options[k].value);
  document.publ.avtor.options[k] = new Option(strtext, selected);
//    document.data_form.avtor.options[i] = new Option(document.data_form.avtor.options[k].text, document.data_form.avtor.options[k].value);
//  document.data_form.avtor.options[k] = new Option(strtext, selected);

 }
 else
  alert('Выбирите кого перемещать!');
update();

}

</script>

<table border=0 bgcolor=gray>
   <tr>
      <td>
          <font color=white><b>Выбор персон</b></font>
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

            <input type=hidden name=matrix id='matrix'>
            <select name=users size=30 style="width: 355">

<?
                global $DB,$_CONFIG;

                 $row0 = $DB->select("SELECT id,CONCAT(surname,' ',name,' ',fname) AS fio FROM persons ORDER BY fio");
                 echo "<br>";

            echo "</select>";
            echo "<div style='display:none;'>";
                 echo "<select name='f' type='hidden'>";

                     foreach($row0 as $k=>$row)
                     {
                         $fio = $row[fio];
                      echo "<option type='hidden' id='full' name='full' value='".$row[id]."'>".$row[fio]."</option>";
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
             <select name=avtor size=30 style="width: 250"></select>
             <br><br>
         </td>
         <td>
             <input type="button" value="/\" onclick="avtor_move('up')">
             <br>
             <input type="button" value="\/" onclick="avtor_move('down')">
         </td>
<!--
        <td>
             <font color=white>Сторонний автор: рус|en</font>
             <br>

             <input name=addot type=text size=50px;>
             <br>

             <input type=button value='Добавить' onclick="addotf()">
         </td>
/-->
     </tr>
</table>

<script language="JavaScript">
   sort('А');
   restore();
   update();
</script>
