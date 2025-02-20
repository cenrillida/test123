<br>
<script language="JavaScript">


var def = [];
function sort2()
{
 if(!def[0])
 {
  var k = 0;
  for(i=0; i<document.publ.list.options.length; i++) {
   def[k] = document.publ.list.options[k].value;
   k++;
  }
 }
for(i=0; i<def.length; i++) document.publ.list.options[i] =  new Option(def[i], def[i]);
 if (document.publ.sel.value == 'all') spe=1;
 else
{
 //alert(document.publ.list.options[2].value);
 for(i=0; i<document.publ.list.options.length; i++)
 {
  if( (document.publ.list.options[i].value.charAt(0) != document.publ.sel.value.charAt(0)) && (document.publ.list.options[i].value.charAt(0) != document.publ.sel.value.charAt(0)) )   {    document.publ.list.remove(i); 
   i=i-1;
  }
 }
 //alert(document.publ.sel.value);
}
}

function restore2()
{
 var k = 0;
 var num = 0;
 var c = [];
 var b = '<? echo $_POST['returns']; ?>';
 if (b.length == 0) b = '<? echo $bow[6]; ?>';

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
  document.publ.rubrica.options[i] =  new Option(c[i], c[i]);
}


function update2()
{

 document.publ.returns.value='';
 for(i=0; i<document.publ.rubrica.options.length; i++)
  document.publ.returns.value += document.publ.rubrica.options[i].value + '<br>';

}

function delall2()
{
 document.publ.rubrica.options.length = 0;
 update2();
}

function rubrica_add()
{
 if (document.publ.list.value)
 {
  var alike=false;
  for(i=0; i<document.publ.rubrica.options.length; i++)
  if(document.publ.rubrica.options[i].value == document.publ.list.value)
   alike = true;
  if(alike) alert('Эта рубрика уже выбрана!'); else  
   document.publ.rubrica.options[document.publ.rubrica.options.length] = new Option(document.publ.list.value, document.publ.list.value);
 }
update2();
}

function rubrica_del()
{
 if(document.publ.rubrica.value)
 {
  var selected = document.publ.rubrica.value;
  var i = 0;
  for(i; i<document.publ.rubrica.options.length; i++)
   if(document.publ.rubrica.options[i].value == document.publ.rubrica.value) break;
  for(i; i<document.publ.rubrica.options.length-1; i++)
  document.publ.rubrica.options[i] = new Option(document.publ.rubrica.options[i+1].value, document.publ.rubrica.options[i+1].value);
  document.publ.rubrica.options.length = document.publ.rubrica.options.length-1;
 }
 else
  alert('Выбирите что удалять!!');
update2();
}

function rubrica_move(action)
{
 if(document.publ.rubrica.value)
 {
  var selected = document.publ.rubrica.value;
  var i = 0;
  for(i; i<document.publ.rubrica.options.length; i++)
   if(document.publ.rubrica.options[i].value == document.publ.rubrica.value) break;
  var k = 0;
  if (action == 'up') k=i-1;
   else
  if (action == 'down') k=i+1;
  document.publ.rubrica.options[i] = new Option(document.publ.rubrica.options[k].value, document.publ.rubrica.options[k].value);
  document.publ.rubrica.options[k] = new Option(selected, selected);
 }
 else
  alert('Выбирите что перемещать!');
update2();
}

</script>

<input type=hidden name=returns value=''>

<table border=0 bgcolor=gray>
 <tr>
  <td>
   <font color=white><b>Выбор рубрик</b></font>
  </td>
 </tr>
 <tr>
  <td>
<select name=sel onclick=sort2();>
<option value=all>Все</option>
   <?
//<select name=sel onclick=sort2();>
  // <option value=all>Все</option>

   $pg = new Pages();
   $podr = $pg->getPages();
   $spe = $podr[280][childNodes];
   $menu1 = ''; $old = '';
   //print_r($podr);
   for($i=0; $i<count($spe); $i++)
   {
   $podpunct1 = $podr[$spe[$i]][childNodes];
    $menu1[$i] .= ("<OPTION value='".($i+1)." ".$podr[$spe[$i]][page_name]."'>".($i+1).". ".$podr[$spe[$i]][page_name]."</OPTION>");
   if(count($podpunct1)>0)
    {
     for ($j=0; $j<count($podpunct1); $j++)
      {
       $podpunct2 = $podr[$podr[$spe[$i]][childNodes][$j]][childNodes];
        $old[$i][$j] .= ("<option value='".($i+1).".".($j+1)." ".$podr[$podr[$spe[$i]][childNodes][$j]][page_name]."' >&nbsp;&nbsp;&nbsp;".
          ($i+1).".".($j+1).". ".$podr[$podr[$spe[$i]][childNodes][$j]][page_name]."</option>");
      }
    }
   }

   for ($i=0; $i<count($spe); $i++)
    echo $menu1[$i];
  ?>   
   </select> 

  </td>
  <td colspan=2 align=right>
   <input type=button value=X onclick='delall2();'>&nbsp;
  </td>
 </tr>
 <tr valign=top>
  <td>

   <select name=list size=10 style="width: 355">
   <?
   if ($_POST['otdel']) echo "<select name=otdel><option value='".$_POST['otdel']."'>".$_POST['otdel']."</option><option value=''>&nbsp;</option>"; 
   else
   for ($i=0; $i<count($spe); $i++)
    {
     echo $menu1[$i];
     for ($j=0; $j<count($podr[$spe[$i]][childNodes]); $j++)
      {
       echo $old[$i][$j];
      }
    }
   ?>

   </select>
  </td>
  <td>
   <br><br><br>
   <input type="button" value=">" onclick="rubrica_add()">
   <br><br>
   <input type="button" value="<" onclick="rubrica_del()">
  </td>
  <td>
   <select name=rubrica size=10 style="width: 384"></select>
   <br><br>
  </td>
  <td>
   <input type="button" value="/\" onclick="rubrica_move('up')">
   <br>
   <input type="button" value="\/" onclick="rubrica_move('down')">
  </td>
 </tr>
</table>

<script language="JavaScript">
 sort2();
 restore2();
 update2();
</script>
