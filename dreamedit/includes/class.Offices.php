<?

class Offices
{
	// конструктор для PHP5+
	function __construct()
	{

	}

	// конструктор для PHP4 <
	function Offices()
	{
		$this->__construct();
	}


	// получить всех сотрудников по алфавиту
	function getPersonalByAlphabet()
	{
		global $DB;
        $row0=$DB->select("SELECT id,CONCAT(surname,' ',name,' ',fname) AS fio,otdel,
              SUBSTRING(surname,1,1)  AS litera
              FROM persona
              WHERE otdel <> 'Партнеры' AND otdel <> 'Умершие сотрудники'
              GROUP BY  SUBSTRING(surname,1,1) ORDER BY surname,name,fname");

        $bukva="";
        foreach($row0 as $row)
        {
            $fioret=array(
                          "litera"=>$row[litera],
                          "id"=>$row[id],
                          "fio"=>$row[fio],
                          "otdel"=>$row[otdel]
                          );

        }

        return $fioret;
	}

	//Печатать div в виде дерева со списком сотрубников
    function printPersonalByAlphabet($type,$tt,$divname)
	{
		global $DB;
        $row0=$DB->select("SELECT id,CONCAT(surname,' ',name,' ',fname) AS fio,otdel,
              SUBSTRING(surname,1,1)  AS litera
              FROM persona
              WHERE otdel <> 'Партнеры' AND otdel <> 'Умершие сотрудники'
               ORDER BY SUBSTRING(surname,1,1),surname,name,fname");

        $bukva="";
        foreach($row0 as $row)
        {


            if ($row[litera]!=$bukva)
            {
            	if ($bukva != "")
            	{
            	   echo "</div>";
            	}
            	   echo "<div id=".$type."lit".ord($row[litera])."plus style='display:block'>";
            	   echo "&nbsp;&nbsp;&nbsp<a href=javascript:chdiv(".ord($row[litera]).",'plus','".$type."')> <strong>
            	   <img border='0' src=/img/plus.gif />&nbsp;&nbsp;".
            	   $row[litera]."</strong></a>";
            	   echo "</div>";

            	echo "<div id=".$type."lit".ord($row[litera])."minus style='display:none'>";
            	echo "&nbsp;&nbsp;&nbsp<a href=javascript:chdiv(".ord($row[litera]).",'minus','".$type."')><strong>
            	<img border='0' src=/img/minus.gif />&nbsp;&nbsp;".
               	$row[litera]."</strong></a>";
            	$bukva=$row[litera];
            }

            echo "<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp<input type='checkbox' id='".$tt.$row[id]."' name='ex[".$row[id]."]' value ='".$row[id]."#".$row[fio]."' ".$sel.
            " onChange=search_fio(".$row[id].",'".$type."','".$tt."')". " ".
            ">".$row[fio]."</input>";
        }
 	    echo "</div>";



        return $fioret;
	}
    function cln($btnName,$name){


   echo "<img src=\""."/files/Image/".$btnName.".jpg\" id=\"button_".$btnName."_".$name."\"
        style=\"CURSOR: hand; CURSOR: pointer;\" align=\"absmiddle\" width=\"17\" height=\"17\" alt=\"".
        Dreamedit::translate("Выбрать дату")."\" title=\"".Dreamedit::translate("Выбрать дату")."\" />";
?>
     <script>
    Calendar.setup({
        inputField     :    "<?=$name?>",
        ifFormat       :    "%Y.%m.%d ",
        button         :    "button_<?=$btnName?>_<?=$name?>",
        showsTime      :    true,
        align          :    "br"
    });
</script>
<?
}

  function spisok($pole)
  {
     global $DB,$config;
     $row0=$DB->select("SELECT ".$pole." FROM Office_incoming");
//     $list=new array();
     $sp="(";
     foreach($row0 as $row)
     {
     	$aa=explode("|",$row[$pole]);
     	     foreach($aa as $id)
     	     {
     	     	if (!empty($id))
     	            $a[$id]=1;

     	      }
      }
      foreach($a as $id=>$b)
      {
              $sp.=" id=".$id." OR ";
      }
      $sp=substr($sp,0,-4).")";




      return($sp);
   }
   // Собрать переписку
    function getChilds($id,&$retvar)
   {
      global $DB;
      $id_childs=$DB->select("SELECT number_refer FROM Office_incoming WHERE id=".$id);
      if (empty($id_childs[0][number_refer]))
      {

//         return($id);
           $ret="";
           $aa=$this->getParents("number_refer='".$id."'",$ret);

           $retvar=$ret.",".$id;
           return ;

      }
      else
      {

          $this->getChilds($id_childs[0][number_refer],&$retvar);
      }
   }
   function getParents($id_where,&$idspisok)
   {
   	   global $DB;

   	   $ids0=$DB->select("SELECT id FROM Office_incoming WHERE ".$id_where);

   	   if (count($ids0)==0)
   	   {
          if (!empty($idspisok)) $idspisok=substr($idspisok,0,-1);
          $bb=array("a"=>$idspisok);

   	      return ($bb);
   	   }
   	   $id_where="(";
   	   foreach($ids0 as $ids)
   	   {
   	   	   $idspisok.=$ids[id].",";
   	   	   $id_where.="number_refer = '".$ids[id] ."' OR ";

   	   }
   	   $id_where=substr($id_where,0,-4).")";
   	   $this->getParents($id_where,&$idspisok);

   }
}

?>