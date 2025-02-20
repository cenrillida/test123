<?
// Для работы с подразделениями (получить список подчиненных подразделений, найти центр и т.п.
class Podr
{
	// конструктор для PHP5+
	function __construct()
	{

	}

	// конструктор для PHP4 <
	function Podr()
	{
		$this->__construct();
	}

// Узнать ID центра и отдела по ID персоны
	function getCenterOtdelByFioId($fio_id)
	{
//
		$pg=new Pages();
		global $DB,$_config;


		$otd=$DB->select("SELECT otdel,podr.id_txt AS otdel_id,a.page_parent AS center_id,b.page_name AS center_name,
		                   CONCAT(persona.surname,' ',persona.name,' ',persona.fname) AS fio
		                  FROM persona ".
		                 " INNER JOIN podr ON podr.name=persona.otdel".
		                 " INNER JOIN adm_pages AS a ON a.page_id=podr.id_txt".
		                 " INNER JOIN adm_pages AS b ON b.page_id=a.page_parent".
		                 " WHERE id=".(int)$fio_id
		                 );
		$podr_id=$otd[0][otdel_id];
		$podr_name=$otd[0][otdel];
		$fio=$otd[0][fio];
		$center_id=0;
		$center_name="";
		if (substr($otd[0][otdel],0,5) == 'Центр')
		{
		   $center_id=$otd[0][otdel_id];
		   $center_name=$otd[0][otdel];
		}
		elseif (substr($otd[0][center_name],0,5) == 'Центр')
		{
           $center_id=$otd[0][center_id];
		   $center_name=$otd[0][center_name];
        }
        if (substr($podr_name,0,6)=='Группа')    // Прочитать на уровень выше
        {
            $otd=$DB->select("SELECT b.page_id AS podr_id,b.page_name AS podr_name,
                              d.page_id AS center_id,d.page_name AS center_name
                              FROM adm_pages AS b
                              INNER JOIN adm_pages AS d ON d.page_id=b.page_parent
                              WHERE b.page_id=".$otd[0][center_id]
                             );
            if (substr($otd[0][center_name],0,5)=='Центр')
            {
               $center_id=$otd[0][center_id];
               $center_name=$otd[0][center_name];
            }
            $podr_id=$otd[0][podr_id];
            $podr_name=$otd[0][podr_name];
        }
        $center_chif=0;
        $podr_chif=0;
//        if ($podr_id == $center_id)
//        {
           $otd=$DB->select("SELECT name,id_txt,p.page_name FROM podr ".
                            " INNER JOIN adm_pages AS p ON p.page_id=id_txt" .
                            " WHERE dol1='".$fio."'");
           foreach($otd as $ot)
           {
                if (substr($ot[page_name],0,5)=='Центр')
                {
                	$center_id=$ot[id_txt];
                	$center_name=$ot[page_name];
                	$center_chif=1;
                }
                else
                {
                	$podr_id=$ot[id_txt];
                	$podr_name=$ot[page_name];
                	$podr_chif=1;
                }
           }
//        }
        $ret=array($fio_id=>array(
                                  "podr_id"=>$podr_id,
                                  "podr_name"=>$podr_name,
                                  "center_id"=>$center_id,
                                  "center_name"=>$center_name,
                                  "center_chif"=>$center_chif,
                                  "podr_chif"=>$podr_chif,
                                  ));
	     return $ret;
    }
// Получить строку WHERE для подчиненных подразделений. $where_name - имя поля в базе
    function CenterCildsWhereString($center_id,$where_name)
	{
         $pg=new Pages();
		 global $DB,$_config;
		 $ret="(".$where_name." = ".(int)$center_id." OR ";
		 $otd0=$pg->getChilds($center_id);

		 foreach($otd0 as $k=>$otd)
		 {
		 	$ret.=$where_name." = ".$k." OR ";
		 	$otd20=$pg->getChilds($k);
		 	foreach($otd20 as $k2=>$otd2)
		 	{
		 	    $ret.=$where_name." = ".$k2." OR ";
		 	}
		 }
		 $ret=substr($ret,0,-4).")";
		 return $ret;
	}
// Названия всех подчиненных подрахзделений
	 function CenterCildsName($center_id)
	{
         $pg=new Pages();
		 global $DB,$_config;
         $ii=0;
		 $otd0=$pg->getChilds($center_id);
		 foreach($otd0 as $k=>$otd)
		 {
		 	$ret[$ii]=array("page_id"=>$otd[page_id],
		 	               "page_name"=>$otd[page_name],
		 	               "level"=>1);
		 	$ii++;
		 	$otd20=$pg->getChilds($k);
		 	foreach($otd20 as $k2=>$otd2)
		 	{
		 	    $ret[$ii]=array("page_id"=>$otd2[page_id],
		 	               "page_name"=>$otd2[page_name],
		 	               "level"=>2);
		 	    $ii++;
		 	}
		 }

		 return $ret;
	}
// Список всех центров. Параметр - id страшней страницы подразделений
	function CentersList($podr_id,$invise)
	{
         $pg=new Pages();
		 global $DB,$_config;
         $ii=0;
		 $otd0=$pg->getChilds($podr_id);

		 foreach($otd0 as $k=>$otd)
		 {
		 	$inv=1;


//		 	if ($invise==1)

     		 	$inv0=$DB->select("SELECT invis FROM podr WHERE id_txt=".$otd[page_id]);
     		if ($inv0[0][invis]=='on') 	$inv=0;
     		if ($inv!=0)
     		{
		 	    $ret[$ii]=array("page_id"=>$otd[page_id],
		 	               "page_name"=>$otd[page_name]);
		 	    $ii++;
		 	}
         }

		 return $ret;
	}
		// Получить список ID персон для подразделения
    function CenterPersonsWhereString($center_id,$where_name = "podr.page_id")
	{
         $pg=new Pages();
		 global $DB,$_config;
		 $center_id=$DB->cleanuserinput((int)$center_id);
		 if (empty($where_name)) $where_name="podr.page_id";
		 $ret="(".$where_name." = ".$center_id." OR ";
		 $otd0=$pg->getChilds($center_id);

		 foreach($otd0 as $k=>$otd)
		 {
		 	$ret.=$where_name." = ".$k." OR ";
		 	$otd20=$pg->getChilds($k);
		 	foreach($otd20 as $k2=>$otd2)
		 	{
		 	    $ret.=$where_name." = ".$k2." OR ";
		 	}
		 }
		
		 $ret=substr($ret,0,-4).")";
		 $fio0=$DB->select("SELECT persons.id FROM persons
		                    INNER JOIN adm_pages AS podr ON podr.page_id=persons.otdel OR podr.page_id=persons.otdel2 OR podr.page_id=persons.otdel3
		                    WHERE ".$ret);

		 return $fio0;
	}
}

?>