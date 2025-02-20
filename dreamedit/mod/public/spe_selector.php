<style>
.abc a {color:white;}
.abc a:hover {color:red;}
</style>

<?
global $DB;
$avt = '';

 if ($_POST['matrix']) $temp = $_POST['matrix'];
  else $temp = $bow[avtor];

$people_affiliation_en = array();
$people_roles = array();

if(!empty($bow['people_affiliation_en'])) {
    $people_affiliation_en = unserialize($bow['people_affiliation_en']);
}



$publications = new Publications();

$contributorRolesList = $publications->getContributorRoles();

$avt0=explode("<br>",trim($temp));

$i=0;
$avt="";
$avtid="";
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

if(!empty($bow['people_role'])) {
    $people_roles = unserialize($bow['people_role']);
} else {
    foreach($avt0 as $k=>$avtor)
    {
        if (!empty($avtor))
        {
            $people_roles[] = 620;
        }
    }
}
$rolesStr = "";

foreach ($people_roles as $role) {
    $rolesStr .= $role."<br>";
}

//echo "@@@".$avt;

?>

<br>
<script language="JavaScript">

//_______________
function restore()
{

 var k = 0;
 var num = 0;
 var c = [];
 var cid=[];
 
 var b = '<? echo $avt; ?>';
 var bid = '<? echo $avtid; ?>';
    var brole = '<? echo $rolesStr; ?>';
 
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
 role=brole.split("<br>");

 for (i=0; i<c.length; i++)
 {
  if (c[i]=='') c[i]=cid[i];
  document.publ.avtor.options[i] =  new Option(c[i], cid[i]);
  if(role[i]!==undefined) {
      document.publ.avtor.options[i].dataset.role = role[i];
  } else {
      document.publ.avtor.options[i].dataset.role = '620';
  }

 }
 if(document.publ.avtor.options[0] !== undefined) {
     $('#people_roles')[0].value = document.publ.avtor.options[0].dataset.role;
 } else {
     $('#people_roles')[0].value = 620;
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

  var num = document.publ.users.value;

  for(i=0; i<document.publ.avtor.options.length; i++)
  {
  if(document.publ.avtor.options[i].value == document.publ.users.value)
     alike = true;

  }

   for(i=0;i<fullfio.length;i++)
     if(document.publ.users.value==fullfio[i].value)
         numfull=i;

  var nummer_array = document.publ.avtor.options.length;
  if(document.publ.avtor.options.length==1 && document.publ.avtor.options[0].value=="")
      nummer_array = 0;

     var inputEl = document.createElement("input");
     var inputElArr = $(inputEl);
     inputElArr.attr("type", "hidden");
     inputElArr.attr("id", "role_hidden"+(document.publ.avtor.options.length-1));
     inputElArr.attr("name", "role_hidden"+(document.publ.avtor.options.length-1));
     inputElArr.attr("value", "");
     $('#roles_hidden').append(inputElArr);

  if(alike) alert('Этот автор уже выбран!'); else {
      document.publ.avtor.options[nummer_array] = new Option(fullfio[numfull].text,document.publ.users.value);
      document.publ.avtor.options[nummer_array].dataset.role = 620;
  }

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
  if (document.publ.addot.text==undefined) document.publ.addot.text=document.getElementById('addot').value;
//  alert(document.getElementById('addot').value+"@");
 if (document.publ.addot.value != '')
{
    var nummer_array = document.publ.avtor.options.length;
    if(document.publ.avtor.options.length==1 && document.publ.avtor.options[0].value=="")
        nummer_array = 0;
  document.publ.avtor.options[nummer_array] = new Option(document.getElementById('addot').value, document.getElementById('addot').value);
    document.publ.avtor.options[nummer_array].dataset.role = 620;

}
 else
  alert('введите ФИО');
 update();
}

function addaf() {
    if (document.publ.addaff.value != '') {
        var el = new Option(document.publ.addaff.value, document.publ.addaff.value);
        el.dataset['pers_id'] = $('#addaf_button').data().current_id;
        document.publ.people_affiliation.options[document.publ.people_affiliation.options.length] = el;
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

function changePersId(el) {
    $('#addaf_button').data().current_id = el.selectedIndex;
    $('#addaf_button').attr("data-current_id", el.selectedIndex);
    $('#people_roles').data().current_id = el.selectedIndex;
    $('#people_roles').attr("data-current_id", el.selectedIndex);
    $('#people_affiliation').find('option').hide();
    $('option[data-pers_id='+el.selectedIndex+']').show();

    $('#people_roles')[0].value = document.publ.avtor.options[el.selectedIndex].dataset.role;
}

function changeRole(el) {
    if(document.publ.avtor.options[el.dataset.current_id]!==undefined) {
        document.publ.avtor.options[el.dataset.current_id].dataset.role = el.selectedOptions[0].value;
        update();
    }
}



//__________________________________
function update()
{
//alert('update');
 document.publ.matrix.value='';
 for(i=0; i<document.publ.avtor.options.length; i++)
 {
  document.publ.matrix.value += document.publ.avtor.options[i].value + '<br>';
//  document.publ.matrix.text += document.publ.avtor.options[i].text + '<br>';
 }

    $('#affiliations_hidden').html('');
    $('#roles_hidden').html('');
    for(i=0; i<document.publ.avtor.options.length; i++) {
        var inputEl = document.createElement("input");
        var inputElArr = $(inputEl);
        inputElArr.attr("type", "hidden");
        inputElArr.attr("id", "affiliation_hidden"+i);
        inputElArr.attr("name", "affiliation_hidden"+i);
        inputElArr.attr("value", "");
        $('#affiliations_hidden').append(inputElArr);

        var inputRoleEl = document.createElement("input");
        var inputRoleElArr = $(inputRoleEl);
        inputRoleElArr.attr("type", "hidden");
        inputRoleElArr.attr("id", "role_hidden"+i);
        inputRoleElArr.attr("name", "role_hidden"+i);
        inputRoleElArr.attr("value", document.publ.avtor.options[i].dataset.role);
        $('#roles_hidden').append(inputRoleElArr);
    }

    $('#affiliations_hidden').find('input').val('');

    $('#people_affiliation').find('option').each(function (elCount, el) {
        $('#affiliation_hidden'+el.dataset['pers_id']).val($('#affiliation_hidden'+el.dataset['pers_id']).val() + el.value + "{{{DELIMITER}}}");
    })
//  alert(document.publ.avtor.options[i].text);
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

     $('option[data-pers_id='+i+']').remove();
     $('#role_hidden'+i).remove();

  for(i; i<document.publ.avtor.options.length-1; i++) {
      if($('option[data-pers_id='+(i+1)+']').data() !== undefined) {
          $('option[data-pers_id='+(i+1)+']').data().pers_id = i;
          $('option[data-pers_id='+(i+1)+']').attr('data-pers_id', i);
      }
      document.publ.avtor.options[i] = new Option(document.publ.avtor.options[i + 1].text, document.publ.avtor.options[i + 1].value);
      document.publ.avtor.options[i].dataset.role = document.publ.avtor.options[i + 1].dataset.role;
  }
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
  var selectedtext = document.publ.avtor.text;


  var i = 0;
  for(i; i<document.publ.avtor.options.length; i++)
  {
   if(document.publ.avtor.options[i].value == document.publ.avtor.value)
   {
       strtext=document.publ.avtor.options[i].text
       break;
   }
  }

  var k = 0;
  if (action == 'up') k=i-1;
   else
  if (action == 'down') k=i+1;

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

     var roleTemp = document.publ.avtor.options[i].dataset.role;

  document.publ.avtor.options[i] = new Option(document.publ.avtor.options[k].text, document.publ.avtor.options[k].value);
     document.publ.avtor.options[i].dataset.role = document.publ.avtor.options[k].dataset.role;
  document.publ.avtor.options[k] = new Option(strtext, selected);
     document.publ.avtor.options[k].dataset.role = roleTemp;
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

                 $row0 = $DB->select("SELECT id,concat(surname,' ',name,' ',fname) as fio FROM persons ORDER BY fio");
                 echo "<br>";

            echo "</select>";
            echo "<div style='display:none;'>";
                 echo "<select name='f' type='hidden'>";

                     foreach($row0 as $k=>$row)
                     {
                         $fio = $row[fio];
                         echo "<option type='hidden' id='full' name='full' value='".$row[id]."'>".$fio."</option>";
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
             <select name=avtor size=10 style="width: 250" onchange="changePersId(this)"></select>
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

             <input name=addot id=addot type=text size=50px;>
             <br>

             <input type=button value='Добавить' onclick="addotf()">
         </td>
     </tr>
    <tr>
        <td>
            <p style="color: white;">Роль для выбранной персоны</p>
        </td>
    </tr>
    <tr>
        <td colspan="5">
            <select name="people_roles" id="people_roles" data-current_id="0" onchange="changeRole(this)">
                <?php
                foreach ($contributorRolesList as $contributorRole):?>
                        <option value="<?=$contributorRole['id']?>" <?php if($contributorRole['id']==620) echo 'selected';?>><?=htmlspecialchars($contributorRole['role_name'])?></option>
                    <?php
                endforeach;?>
            </select>
            <div id="roles_hidden">

            </div>
        </td>
    </tr>
    <tr>
        <td>
            <p style="color: white;">Аффилиация для выбранной персоны (En)</p>
        </td>
    </tr>
    <tr>
        <td colspan="5">
            <select style="width: 920px; overflow: scroll" name="people_affiliation" size="5" id="people_affiliation">
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
            <input style="width: 920px;" name="addaff" type=text>
            <br>
            <input type=button value='Добавить' id="addaf_button" data-current_id="0" onclick="addaf()">
            <input type=button value='Удалить' onclick="delaf()">
        </td>
    </tr>
</table>

<script language="JavaScript">
   sort('А');
   restore();
   update();
</script>
