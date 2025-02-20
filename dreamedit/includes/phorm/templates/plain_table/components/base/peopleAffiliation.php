<tr valign="top"><td nowrap>
<?php
	$prompt .= ":";
	$prompt = count($validate_errors) ? "<span class=\"error\">".$prompt."</span>" : $prompt;
	echo $prompt."\n";
	echo (isset($required) && $required)? "&nbsp;<span class=\"required\">*</span>": "";
?>
</td><td width="100%">
<?php
//var_dump($people_affiliation_en);
//_________________________
?>
<style>
.abc a {color:white;}
.abc a:hover {color:red;}
</style>

<?
global $DB;
$avt = '';

  $temp = $value;


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
function is_Numeric(x) {
// I use this function like this: if (isNumeric(myVar)) { }
// regular expression that validates a value is numeric
var RegExp = /^(-)?(\d*)(\.?)(\d*)$/; // Note: this WILL allow a number that ends in a decimal: -452.
// compare the argument to the RegEx
// the 'match' function returns 0 if the value didn't match
var result = x.match(RegExp);
return result;
}
//_______________
function restore()
{

 var k = 0;
 var num = 0;
 var c = [];
 var b = '<? echo $avt; ?>';
 var b='<?= $value ?>';
//alert(b);
 avt=explode("<br>",b);
 for(i=0;i<avt.length;i++)
 {
    var fullfio= document.getElementsByName('full');
    if (is_Numeric(avt[i]))
    {
        for(j=0;j<fullfio.length;j++)
           if (fullfio[j].value==avt[i]) break;

        if (fullfio[j]!=null)
			document.data_form.avtor.options[i] =  new Option( fullfio[j].text,avt[i]);
    }
    else document.data_form.avtor.options[i] =  new Option(avt[i], avt[i]);
  }

}


var a = [];
//_________________________
function sortfio(smbl)
{

   var fullfio= document.getElementsByName('full');
   var fio=document.getElementsByName('fio');


   var k=0;

 document.data_form.users.options.length=0;

   for(i=0;i<fullfio.length;i++)
   {
   	   str=fullfio[i].value;
       strtext=fullfio[i].text;

   	   if (strtext.substr(0,1) == smbl.charAt(0) || smbl.charAt(0)=='a')
   	   {
   	       document.data_form.users.options[k] =  new Option(fullfio[i].text,fullfio[i].value);
//           document.data_form.users.text[k]=strtext;
   	       k++;
        }

    }

}
//_________________________

function avtor_add()
{

 if (document.data_form.users.value)
 {
  var alike=false;
  var fullfio= document.getElementsByName('full');
  var txt= document.getElementsByName('users');

  var num = document.data_form.users.value;

  for(i=0; i<document.data_form.avtor.options.length; i++)
  {
  if(document.data_form.avtor.options[i].value == document.data_form.users.value)
     alike = true;

  }

   for(i=0;i<fullfio.length;i++)
     if(document.data_form.users.value==fullfio[i].value)
         numfull=i;
  if(alike) alert('Этот автор уже выбран!'); else
   document.data_form.avtor.options[document.data_form.avtor.options.length] = new Option(fullfio[numfull].text,document.data_form.users.value);
 }
update();
}
//______________________________
function delall()
{

document.data_form.avtor.options.length = 0;
update();
}
//______________________________
function addotf()
{

 if (document.data_form.addot.value != '')
  document.data_form.avtor.options[document.data_form.avtor.options.length] = new Option(document.data_form.addot.value, document.data_form.addot.value);
 else
  alert('введите ФИО');
 update();
}

function addaf() {
    if (document.data_form.addaff.value != '') {
        var el = new Option(document.data_form.addaff.value, document.data_form.addaff.value);
        el.dataset['pers_id'] = $('#addaf_button').data().current_id;
        document.data_form.people_affiliation.options[document.data_form.people_affiliation.options.length] = el;
    }
    update();
}

function delaf()
{
    var selected = $('#people_affiliation option:selected');

    if(selected.length>0)
    {
        selected.remove();
    }
    else
        alert('Выберите что удалять');
    update();
}

function addon() {
    if (document.data_form.addonf.value != '') {
        var el = new Option(document.data_form.addonf.value, document.data_form.addonf.value);
        el.dataset['pers_id'] = $('#addon_button').data().current_id;
        document.data_form.select_organization_name.options[document.data_form.select_organization_name.options.length] = el;
    }
    update();
}

function delon()
{
    var selected = $('#select_organization_name option:selected');

    if(selected.length>0)
    {
        selected.remove();
    }
    else
        alert('Выберите что удалять');
    update();
}

function addone() {
    if (document.data_form.addonef.value != '') {
        var el = new Option(document.data_form.addonef.value, document.data_form.addonef.value);
        el.dataset['pers_id'] = $('#addone_button').data().current_id;
        document.data_form.select_organization_name_en.options[document.data_form.select_organization_name_en.options.length] = el;
    }
    update();
}

function delone()
{
    var selected = $('#select_organization_name_en option:selected');

    if(selected.length>0)
    {
        selected.remove();
    }
    else
        alert('Выберите что удалять');
    update();
}


function changePersId(el) {
    $('#addaf_button').data().current_id = el.selectedIndex;
    $('#addaf_button').attr("data-current_id", el.selectedIndex);
    $('#people_affiliation').find('option').hide();
    $('#addon_button').data().current_id = el.selectedIndex;
    $('#addon_button').attr("data-current_id", el.selectedIndex);
    $('#select_organization_name').find('option').hide();
    $('#addone_button').data().current_id = el.selectedIndex;
    $('#addone_button').attr("data-current_id", el.selectedIndex);
    $('#select_organization_name_en').find('option').hide();
    $('option[data-pers_id='+el.selectedIndex+']').show();
}

//__________________________________
function update()
{

 document.data_form.people.value='';
// alert(document.data_form.avtor.options[1].value+" " +document.data_form.avtor.options[1].text)
 for(i=0; i<document.data_form.avtor.options.length; i++)
  document.data_form.people.value += document.data_form.avtor.options[i].value + '<br>';

    $('#affiliations_hidden').html('');
    for(i=0; i<document.data_form.avtor.options.length; i++) {
        var inputEl = document.createElement("input");
        var inputElArr = $(inputEl);
        inputElArr.attr("type", "hidden");
        inputElArr.attr("id", "affiliation_hidden"+i);
        inputElArr.attr("name", "affiliation_hidden"+i);
        inputElArr.attr("value", "");
        $('#affiliations_hidden').append(inputElArr);
    }

    $('#affiliations_hidden').find('input').val('');

    $('#people_affiliation').find('option').each(function (elCount, el) {
        $('#affiliation_hidden'+el.dataset['pers_id']).val($('#affiliation_hidden'+el.dataset['pers_id']).val() + el.value + "{{{DELIMITER}}}");
    })

    $('#organizations_name_hidden').html('');
    for(i=0; i<document.data_form.avtor.options.length; i++) {
        var inputEl = document.createElement("input");
        var inputElArr = $(inputEl);
        inputElArr.attr("type", "hidden");
        inputElArr.attr("id", "organization_name_hidden"+i);
        inputElArr.attr("name", "organization_name_hidden"+i);
        inputElArr.attr("value", "");
        $('#organizations_name_hidden').append(inputElArr);
    }

    $('#organizations_name_hidden').find('input').val('');

    $('#select_organization_name').find('option').each(function (elCount, el) {
        $('#organization_name_hidden'+el.dataset['pers_id']).val($('#organization_name_hidden'+el.dataset['pers_id']).val() + el.value + "{{{DELIMITER}}}");
    })

    $('#organizations_name_en_hidden').html('');
    for(i=0; i<document.data_form.avtor.options.length; i++) {
        var inputEl = document.createElement("input");
        var inputElArr = $(inputEl);
        inputElArr.attr("type", "hidden");
        inputElArr.attr("id", "organization_name_en_hidden"+i);
        inputElArr.attr("name", "organization_name_en_hidden"+i);
        inputElArr.attr("value", "");
        $('#organizations_name_en_hidden').append(inputElArr);
    }

    $('#organizations_name_en_hidden').find('input').val('');

    $('#select_organization_name_en').find('option').each(function (elCount, el) {
        $('#organization_name_en_hidden'+el.dataset['pers_id']).val($('#organization_name_en_hidden'+el.dataset['pers_id']).val() + el.value + "{{{DELIMITER}}}");
    })
}

//_________________________________
function avtor_del()
{

 if(document.data_form.avtor.value)
 {
  var selected = document.data_form.avtor.value;

  var i = 0;
  for(i; i<document.data_form.avtor.options.length; i++)
   if(document.data_form.avtor.options[i].value == document.data_form.avtor.value) break;

     $('option[data-pers_id='+i+']').remove();

  for(i; i<document.data_form.avtor.options.length-1; i++) {
      if($('option[data-pers_id='+(i+1)+']').data() !== undefined) {
          $('option[data-pers_id='+(i+1)+']').data().pers_id = i;
          $('option[data-pers_id='+(i+1)+']').attr('data-pers_id', i);
      }
      document.data_form.avtor.options[i] = new Option(document.data_form.avtor.options[i + 1].text, document.data_form.avtor.options[i + 1].value);
  }
  document.data_form.avtor.options.length = document.data_form.avtor.options.length-1;
 }
 else
  alert('Выберите кого удалять!!');
 update();
}

//__________________________________
function avtor_move(action)
{

 if(document.data_form.avtor.value)
 {
  var selected = document.data_form.avtor.value;
  var selectedtext = document.data_form.avtor.text;
  var avtorCount = document.data_form.avtor.length;


  var i = 0;
  for(i; i<document.data_form.avtor.options.length; i++)
  {
   if(document.data_form.avtor.options[i].value == document.data_form.avtor.value)
   {
       strtext=document.data_form.avtor.options[i].text
       break;
   }
  }

  var k = 0;
  if (action == 'up') k=i-1;
   else
  if (action == 'down') k=i+1;

  if(k>=0 && k<avtorCount) {
      if($('option[data-pers_id='+i+']').data() !== undefined) {
          $('option[data-pers_id='+i+']').data().pers_id = 'r';
          $('option[data-pers_id='+i+']').attr('data-pers_id', 'r');
      }
      if($('option[data-pers_id='+k+']').data() !== undefined) {
          $('option[data-pers_id='+k+']').data().pers_id = i;
          $('option[data-pers_id='+k+']').attr('data-pers_id', i);
      }
      if($('option[data-pers_id=r]').data() !== undefined) {
          $('option[data-pers_id=r]').data().pers_id = k;
          $('option[data-pers_id=r]').attr('data-pers_id', k);
      }
      $('#addaf_button').data().current_id = k;
      $('#addaf_button').attr("data-current_id", k);

      document.data_form.avtor.options[i] = new Option(document.data_form.avtor.options[k].text, document.data_form.avtor.options[k].value);
      document.data_form.avtor.options[k] = new Option(strtext, selected);
  }
 }
 else
  alert('Выберите кого перемещать!');
update();

}

</script>

<table border=0 bgcolor=gray>
   <tr>
      <td>
          <font color=white><b>Выбор присутствующих</b></font>
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
                     document.write('<a style=\"cursor:pointer;cursor:hand;\"  onclick=sortfio(".'"'.chr($i).'"'.") style=color:white><b>".chr($i)."</b></a>');
                 </script>

                 ";

?>

		     <script language=javascript>
                  document.write('<a href='+location+'# onclick=sortfio("all") style=color:white><b>&nbsp;&nbsp;BCE</b></a>');
             </script>
             </div>
        </td>
     </tr>
     <tr valign=top>
        <td>
<?

            global $DB,$_CONFIG;
			$ps=new Persons();
//			$row0=$ps->getFioAll('*');


?>
            <input type=hidden id="people_hidden" name=people value='<? echo $value ?>' >
            <select name=users size=10 style="width: 355">


<?
                 $row0 = $DB->select("SELECT id, CONCAT(surname,' ',name,' ',fname) as fio FROM persons ORDER BY fio");
            echo "<br>";



            echo "</select>";

            echo "<div style='display:none;'>";
                 echo "<select name='f' >";

                     foreach($row0 as $k=>$row)
                     {
                         $fio = $row[fio];
                         echo "<option type='hidden' id='full' name='full' value='".$row[id]."'>".$row[fio]."</option>";
                     }
?>

                  </select>
<?


?>
             </div>
         </td>
         <td>
             <br><br><br>

             <input type="button" value=">" onclick="avtor_add()">
             <br>
             <input type="button" value="<" onclick="avtor_del()">
         </td>
         <td>
             <select id="avtor_select" name=avtor size=10 style="width: 250" onchange="changePersId(this)"></select>
             <br><br>
         </td>
         <td>
             <input type="button" value="/\" onclick="avtor_move('up')">
             <br>
             <input type="button" value="\/" onclick="avtor_move('down')">
         </td>
         <td>
             <font color=white>Сторонний человек</font>
             <br>
             <input name=addot type=text>
             <br>
             <input type=button value='Добавить' onclick="addotf()">
         </td>
     </tr>
    <tr>
        <td>
            <p style="color: white;">Название организации для выбранной персоны</p>
        </td>
    </tr>
    <tr>
        <td colspan="5">
            <select style="width: 750px; overflow: scroll" name="select_organization_name" size="5" id="select_organization_name">
                <?php
                foreach ($organization_name as $key=>$organizationNameItem):
                    foreach ($organizationNameItem as $organizationItem):?>
                        <option value="<?=htmlspecialchars($organizationItem)?>" data-pers_id="<?=$key?>" <?php if($key>0) echo 'style="display: none;"';?>><?=htmlspecialchars($organizationItem)?></option>
                    <?php endforeach;
                endforeach;?>
            </select>
        </td>
    </tr>
    <tr>
        <td colspan="5">
            <div id="organizations_name_hidden">
                <input type=hidden id="organization_name_hidden0" name="organization_name_hidden0" value='' >
            </div>
            <input style="width: 750px;" name="addonf" type=text>
            <br>
            <input type=button value='Добавить' id="addon_button" data-current_id="0" onclick="addon()">
            <input type=button value='Удалить' onclick="delon()">
        </td>
    </tr>
    <tr>
        <td>
            <p style="color: white;">Название организации для выбранной персоны (En)</p>
        </td>
    </tr>
    <tr>
        <td colspan="5">
            <select style="width: 750px; overflow: scroll" name="select_organization_name_en" size="5" id="select_organization_name_en">
                <?php
                foreach ($organization_name_en as $key=>$organizationNameItem):
                    foreach ($organizationNameItem as $organizationItem):?>
                        <option value="<?=htmlspecialchars($organizationItem)?>" data-pers_id="<?=$key?>" <?php if($key>0) echo 'style="display: none;"';?>><?=htmlspecialchars($organizationItem)?></option>
                    <?php endforeach;
                endforeach;?>
            </select>
        </td>
    </tr>
    <tr>
        <td colspan="5">
            <div id="organizations_name_en_hidden">
                <input type=hidden id="organization_name_en_hidden0" name="organization_name_en_hidden0" value='' >
            </div>
            <input style="width: 750px;" name="addonef" type=text>
            <br>
            <input type=button value='Добавить' id="addone_button" data-current_id="0" onclick="addone()">
            <input type=button value='Удалить' onclick="delone()">
        </td>
    </tr>
    <tr>
        <td>
            <p style="color: white;">Аффилиация для выбранной персоны (En)</p>
        </td>
    </tr>
    <tr>
        <td colspan="5">
            <select style="width: 750px; overflow: scroll" name="people_affiliation" size="5" id="people_affiliation">
                <?php
                foreach ($people_affiliation_en as $key=>$peopleAffiliationItem):
                    foreach ($peopleAffiliationItem as $affiliationItem):?>
                    <option value="<?=htmlspecialchars($affiliationItem)?>" data-pers_id="<?=$key?>" <?php if($key>0) echo 'style="display: none;"';?>><?=htmlspecialchars($affiliationItem)?></option>
                <?php endforeach;
                endforeach;?>
            </select>
        </td>
    </tr>
    <tr>
        <td colspan="5">
            <div id="affiliations_hidden">
                <input type=hidden id="affiliation_hidden0" name="affiliation_hidden0" value='' >
            </div>
            <input style="width: 750px;" name="addaff" type=text>
            <br>
            <input type=button value='Добавить' id="addaf_button" data-current_id="0" onclick="addaf()">
            <input type=button value='Удалить' onclick="delaf()">
        </td>
    </tr>
</table>

<script language="JavaScript">
   sortfio('А');
   restore();
   update();
</script>



<?

//_________________________

	if(!empty($help))
		echo "<p class=\"form_help\">".$help."</p>";
?>
</td></tr>
