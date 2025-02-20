<?

class Magazines
{
	// конструктор для PHP5+
	function __construct()
	{

	}

	// конструктор для PHP4 <
	function Magazines()
	{
		$this->__construct();
	}

//диапазон годов выпуска журнала
    function getMagazinesYears($id0)
    {
// id0 - старшая страница с номерами журналов
         global $DB,$_config;
		$pg = new Pages();

    	$num00=explode(",",$id0);
        $nn="(";
		foreach($num00 as $num0)
		{

			$numbers=$pg->getChilds($num0,true);


			foreach($numbers as $num)
			{
			    $nn.=" c.page_id=".$num[page_id]." OR ";
			}
		}	//По всем id

		if (strlen($nn)>1)
		{
		   $nn=substr($nn,0,-4).")";
		}
		else $nn=1;

        $years0=$DB->select("SELECT DISTINCT cv_text AS year FROM adm_pages_content AS c WHERE cv_name='year' AND cv_text <> '' AND ".$nn. " ORDER BY cv_text DESC");


        return $years0;

    }
// Для поиска в журналах
function getMagazinesSearch($fio_surname,$fio_name,$fio_fname,$id0,$year,$name)
	{
//  id0 - старшая страница с номерами журналов (список)
// fio_surname="*", если поиск по ФИО не нужен



		global $DB,$_config;
		$pg = new Pages();

		$iret=0;
// Задана фамилия
       if ($fio_surname!="*" && !empty($fio_surname))
       {
         if(!empty($fio_name[0])) $fname=$fio_name[0].".";
         if(!empty($fio_fname[0])) $ffname=$fio_fname[0].".";
         $fio_search="(c.cv_text like '%".$fio_surname." ".$fname.$ffname."%' ".
                 " or c.cv_text like '%".$f.$ffname.$fio_surname."%' ".
                 " or c.cv_text like '%".$fname.$fio_surname."%' )";
         $fio1=$fio_surname." ".$fname.$ffname;
         $fio2=$fname.$ffname.$fio_surname;
         $fio3=$fname.$fio_surname;

        }


        if (!empty($fio_search)) $fio_search=" AND ".$fio_search;
        $match="";
        $and="";
    if (!empty($name))
    {
       $match="MATCH(c.cv_name,c.cv_text) AGAINST ('".$name."')";
       $and=" AND ";
    }
        $num00=explode(",",$id0);
        $nn="(";
		foreach($num00 as $num0)
		{

			$numbers=$pg->getChilds($num0,true);


			foreach($numbers as $num)
			{
			    $nn.=" c.page_id=".$num[page_id]." OR ";

			}
		}	//По всем id

			if (strlen($nn)>1)
			{
		    	$nn=substr($nn,0,-4).")";
		    	$nn2="";
		    }
		    else
		    $nn=1;

		    if ($year!="*")
		        $nn2= " AND y.cv_text =".$year;

		   	else $nn2="";
  //////////////////////

// Собрать ФИО
 //           echo $nn2." ".$nn1;
            if ($nn !=1)
            {

		    	$sp0=$DB->select("SELECT DISTINCT c.page_id,t.cv_text AS page_title, y.cv_text AS year,c.cv_text AS name,
		    	                 m.cv_text as name2
		    	                 FROM adm_pages_content AS c ".
			    				 " INNER JOIN adm_pages_content AS t ON t.page_id=c.page_id AND t.cv_name='title' ".
			    				 " INNER JOIN adm_pages_content AS y ON y.page_id=c.page_id AND y.cv_name='year' ".$nn2.
			    				 " INNER JOIN adm_pages_content AS m ON m.page_id=c.page_id AND m.cv_name='month' ".
			    				 " INNER JOIN adm_pages AS pp ON pp.page_id=c.page_id AND pp.page_status=1 ".
				    			 " WHERE c.cv_name='content' AND ".$nn.
					    		 $fio_search.$and.$match.
					    		 " ORDER BY y.cv_text DESC,t.cv_text,c.cv_text "
                       		    ) ;


    			foreach($sp0 as $sp)
        		{

        		// Прогнать по все найденным словам
        $iiii=0;
        $ibeg=0;
        while(1==1)
        {

                   $iiii++;
                if ($iiii>5) break;
// Найти название
		    		$ii=strpos(strtolower($sp[name]),strtolower($fio1),$ibeg);
		    		if (empty($ii))
		    		    $ii=strpos(strtolower($sp[name]),strtolower($fio2),$ibeg);
		    		    $ii01=strpos(strtolower($sp[name]),strtolower($fio2),$ibeg);
		    		if (empty($ii))
		    		    $ii=strpos(strtolower($sp[name]),strtolower($fio3),$ibeg);
		    		    $ii02=strpos(strtolower($sp[name]),strtolower($fio3),$ibeg);

                 if (empty($ii))  // Нет автора, только контекст
                   {

                    $ii=strpos(strtolower($sp[name]),strtolower($name),$ibeg);
 //                   echo "<br />".$sp[page_title]."______________***   *".$ii."*".$iiii;
                    if (empty($ii))
                    {
//                        echo "!!!!!!!!!!!!!!!!!!!!";
                        break;
                    }
                    $ibeg=$ii+1;
                    for($i=$ii+1;$i>0;$i=$i-1)
                       if ($sp[name][$i]==">" ||
                           $sp[name][$i]==">") break;

 //                    echo "<br />____".$ii." ".$i;
                   }
		    		else
			    	for($i=$ii;$i>0;$i=$i-1)
				    {
					   if ($sp[name][$i]==">") break;
					   $ibeg=$ii+1;
                    }

                    $ii0=$ii;

// Название заканчивается br Или р
	    		    $ii2=strpos($sp[name],"<br />",$ii);
    	    		$ii3=strpos($sp[name],"</p>",$ii);
	    	    	if (empty($ii2)) $ii2=$ii3;
	    	    	if ($ii3<$ii2) $ii2=$ii3;
// Найти ссылку на pdf

                    $ilink=strpos($sp[name],"href",$ii);
                    $slink2=strpos($sp[name],"<br",$ii);
                    $slink3=strpos($sp[name],"</p>",$ii);
                    if ($slink2<$ilink || $slink3<$ilink) $ilink=0;
                    if($slink2<$slink3) $send=$slink2;
                    else $send=$slink3;
                    $nam=substr($sp[name],$ii,$send);
                    $ilink=strpos(substr($sp[name],$ii,$send),"href");

                    if ($ilink > 0 )
                    {
                    	$ilink2=strpos($nam,">",$ilink);
                    	$link=substr($snam,$ilink+5+$ii,$ilink2-$ilink-5+$ii);
         //           echo "****** ii=".$ii."$ ilink=".$ilink." ilink2=".$ilink2." txt=".substr($sp[cv_text],$ilink+5,$ilink2-$ilink-5);
                    }
                    else
                        $link="";

             	    $ret[$iret]=array("id" => $sp[page_id],
              	                      "title" =>$sp[page_title],
              	                      "name"=> strip_tags (substr($sp[name],$i+1,$ii2-$i+1)),
              	                      "name2"=>$sp[name2],
              	                      "year"=>$sp[year],
                                      "link"=>$link

              	                      );
			        $iret++;

                }
        //    }

           }
	    }

	     return $ret;
    }



	function getMagazinesByFio($fio_surname,$fio_name,$fio_fname,$id0,$year)
	{
//
		global $DB,$_config;
		$pg = new Pages();

		$iret=0;


		$num00=explode(",",$id0);


         $fio_search="(c.cv_text like '%".$fio_surname." ".$fio_name[0].".".$fio_fname[0].".%' ".
                 " or c.cv_text like '%".$fio_name[0].".".$fio_fname[0].". ".$fio_surname."%' ".
                 " or c.cv_text like '%".$fio_name[0].". ".$fio_surname."%' )";
         $fio1=$fio_surname." ".$fio_name[0].".".$fio_fname[0].".";
         $fio2=$fio_name[0].".".$fio_fname[0].". ".$fio_surname;
         $fio3=$fio_name[0].". ".$fio_surname;

        $nn="(";
		foreach($num00 as $num0)
		{

			$numbers=$pg->getChilds($num0,true);


			foreach($numbers as $num)
			{
			    $nn.=" c.page_id=".$num[page_id]." OR ";
//echo "<br /><br />".$num0." ".$num[page_id];
			}
		}	//По всем id

			if (strlen($nn)>1)
			{
		    	$nn=substr($nn,0,-4).")";
		    	$nn2="";
		    	if ($year=="prnd")
		    	{
		    	if (date('m')<4) $kk=1;
		    	else $kk=0;
		    	    $nn2= "AND (y.cv_text like '%".(date('Y')-$kk)."%' OR y.cv_text like '%".(date('Y')-1-$kk)."%')";
		    	}
		    	else
		    	if ($year!="*")
		    	    $nn2= " AND y.cv_text =".$year;
   		   	}
		   	else $nn=1;
  //////////////////////

// Собрать ФИО
 //           echo $nn2." ".$nn1;
            if ($nn !=1)
            {

		    	$sp0=$DB->select("SELECT c.page_id,t.cv_text AS page_title, y.cv_text AS year,c.cv_text AS name,
		    	                 m.cv_text as name2
		    	                 FROM adm_pages_content AS c ".
			    				 " INNER JOIN adm_pages_content AS t ON t.page_id=c.page_id AND t.cv_name='title' ".
			    				 " INNER JOIN adm_pages_content AS y ON y.page_id=c.page_id AND y.cv_name='year' ".$nn2.
			    				 " INNER JOIN adm_pages_content AS m ON m.page_id=c.page_id AND m.cv_name='month' ".
			    				 " INNER JOIN adm_pages AS pp ON pp.page_id=c.page_id AND pp.page_status=1 ".
				    			 " WHERE c.cv_name='content' AND ".$nn. "  AND ".
					    		 $fio_search.
					    		 " ORDER BY y.cv_text DESC,c.cv_text "
                       		    ) ;


    			foreach($sp0 as $sp)
        		{
// Найти название
		    		$ii=strpos(strtolower($sp[cv_text]),strtolower($fio1));
		    		if (empty($ii))
		    		    $ii=strpos(strtolower($sp[cv_text]),strtolower($fio2));
		    		    $ii01=strpos(strtolower($sp[cv_text]),strtolower($fio2));
		    		if (empty($ii))
		    		    $ii=strpos(strtolower($sp[cv_text]),strtolower($fio3));
		    		    $ii02=strpos(strtolower($sp[cv_text]),strtolower($fio3));
                    if (empty($ii))  // Нет автора, только контекст
                   {

                    $ii=strpos(strtolower($sp[name]),strtolower($name));
 //                   echo "<br />".$sp[page_title]."______________***   *".$ii."*".$iiii;
                    if (empty($ii))
                    {
//                        echo "!!!!!!!!!!!!!!!!!!!!";
                        break;
                    }
                    $ibeg=$ii+1;
                    for($i=$ii+1;$i>0;$i=$i-1)
                       if ($sp[name][$i]==">" ||
                           $sp[name][$i]==">") break;

 //                    echo "<br />____".$ii." ".$i;
                   }
		    		else

			    	for($i=$ii;$i>0;$i=$i-1)
				    {
					   if ($sp[cv_text][$i]==">") break;
                    }
                    $ii0=$ii;
// Название заканчивается br Или р
	    		    $ii2=strpos($sp[cv_text],"<br />",$ii);
    	    		$ii3=strpos($sp[cv_text],"</p>",$ii);
	    	    	if (empty($ii2)) $ii2=$ii3;
	    	    	if ($ii3<$ii2) $ii2=$ii3;
// Найти ссылку на pdf

                    $ilink=strpos($sp[name],"href",$ii);
                    $slink2=strpos($sp[name],"<br",$ii);
                    $slink3=strpos($sp[name],"</p>",$ii);
                    if ($slink2<$ilink || $slink2<$ilink) $ilink=0;
                    $ilink=strpos($sp[cv_text],"href",$ii);
                    if ($ilink > 0 )
                    {
                    	$ilink2=strpos($sp[cv_text],">",$ilink);
                    	$link=substr($sp[cv_text],$ilink+5,$ilink2-$ilink-5);
         //           echo "****** ii=".$ii."$ ilink=".$ilink." ilink2=".$ilink2." txt=".substr($sp[cv_text],$ilink+5,$ilink2-$ilink-5);
                    }
                    else
                        $link="";

             	    $ret[$iret]=array("id" => $sp[page_id],
              	                      "title" =>$sp[page_title],
              	                      "name"=> strip_tags (substr($sp[cv_text],$i+1,$ii2-$i+1)),
              	                      "name2"=>$sp[name2],
              	                      "year"=>$sp[year],
                                      "link"=>$link

              	                      );
			        $iret++;

                }
        //    }

	    }

	     return $ret;
    }
    function getPublicationsByFioId($fioid,$id0,$year,$idp,$ida)
	{
// id0 - список ID страниц с журналами
// idp - сведения о публикации
// ida - сведения об авторе
		global $DB,$_config;
		$pg = new Pages();

		$iret=0;
		if (!empty($fioid))
		{
            $fio0=$DB->select("SELECT surname,name,fname FROM persons WHERE id=".(int)$fioid);
            $fio_surname=$fio0[0][surname];
            $fio_name=$fio0[0][name];
            $fio_fname=$fio0[0][fname];
        }


         $fio_search="(c.cv_text like '%".$fio_surname." ".$fio_name[0].".".$fio_fname[0].".%' ".
                 " or c.cv_text like '%".$fio_name[0].".".$fio_fname[0].". ".$fio_surname."%' ".
                 " or c.cv_text like '%".$fio_name[0].". ".$fio_surname."%' )";
         $fio1=$fio_surname." ".$fio_name[0].".".$fio_fname[0].".";
         $fio2=$fio_name[0].".".$fio_fname[0].". ".$fio_surname;
         $fio3=$fio_name[0].". ".$fio_surname;

        $num00=explode(",",$id0);
        $nn="(";
		foreach($num00 as $num0)
		{

			$numbers=$pg->getChilds($num0,true);


			foreach($numbers as $num)
			{
			    $nn.=" c.page_id=".$num[page_id]." OR ";
//echo "<br /><br />".$num0." ".$num[page_id];
			}
		}	//По всем id

			if (strlen($nn)>1)
			{
			$nn=substr($nn,0,-4).")";
		    }
		   	else $nn=1;
		    $nn2="";
		    if ($year=="prnd")
		        $nn2= "AND (y.cv_text like '%".date('Y')."%' OR y.cv_text like '%".(date('Y')-1)."%')";
		    else
		    if ($year!="*")
		        $nn2= " AND y.cv_text =".(int)$year;

  //////////////////////

// Собрать ФИО

            if ($nn !=1)
            {

		    	$sp0=$DB->select("(SELECT 'mag' as 'type',c.page_id,c.cv_text AS name,m.cv_text as name2,
		    	               t.cv_text AS avtor, y.cv_text AS year, '*' as visible,' ' AS full
                                 FROM adm_pages_content AS c ".
			    				 " INNER JOIN adm_pages_content AS t ON t.page_id=c.page_id AND t.cv_name='title' ".
			    				 " INNER JOIN adm_pages_content AS y ON y.page_id=c.page_id AND y.cv_name='year' ".$nn2.
			    				 " INNER JOIN adm_pages_content AS m ON m.page_id=c.page_id AND m.cv_name='month' ".
			    				 " INNER JOIN adm_pages AS pp ON pp.page_id=c.page_id AND pp.page_status=1 ".
				    			 " WHERE c.cv_name='content' AND ".$nn. "  AND ".
					    		 $fio_search.
					    		 ") UNION (".
					    		 "SELECT 'publ' AS 'type', id AS page_id,name,name2,avtor,year,`hide_autor` AS visible,link AS full FROM `publ` WHERE avtor like '".
					    		 $fioid."<br>%' OR avtor like'%<br>".$fioid."<br>%') ORDER BY YEAR desc, type desc,name asc"
                       		    ) ;

    			foreach($sp0 as $sp)
        		{
// Найти название для журналов
                  if ($sp[type]=="mag")
                  {
// проверить все форматы ФИО
                    $ii00=0;$ii01=0;$ii02=0;
		    		$ii=strpos(strtolower($sp[name]),strtolower($fio1));
		    		if (empty($ii))
		    		    $ii=strpos(strtolower($sp[name]),strtolower($fio2));
		    		else
		    		{

		    		    $ii00=$ii;
		    		}
		    		$ii01=strpos(strtolower($sp[name]),strtolower($fio2));
		    		if (empty($ii))
		    		    $ii=strpos(strtolower($sp[name]),strtolower($fio3));

		    		$ii02=strpos(strtolower($sp[name]),strtolower($fio3));
/////
               if (empty($ii))  // Нет автора, только контекст
                   {

                    $ii=strpos(strtolower($sp[name]),strtolower($name));
 //                   echo "<br />".$sp[page_title]."______________***   *".$ii."*".$iiii;
                    if (empty($ii))
                    {
//                        echo "!!!!!!!!!!!!!!!!!!!!";
                        break;
                    }
                    $ibeg=$ii+1;
                    for($i=$ii+1;$i>0;$i=$i-1)
                       if ($sp[name][$i]==">" ||
                           $sp[name][$i]==">") break;

 //                    echo "<br />____".$ii." ".$i;
                   }
		    		else

			    	for($i=$ii;$i>0;$i=$i-1)
				    {
					   if ($sp[name][$i]==">") break;
                    }
// Название заканчивается br Или р
	    		    $ii2=strpos($sp[name],"<br />",$ii);
    	    		$ii3=strpos($sp[name],"</p>",$ii);
	    	    	if (empty($ii2)) $ii2=$ii3;
	    	    	if ($ii3<$ii2) $ii2=$ii3;
	    	    	$ii0=$ii;
// Найти ссылку на pdf

                    $ilink=strpos($sp[name],"href",$ii);
                    $slink2=strpos($sp[name],"<br",$ii);
                    $slink3=strpos($sp[name],"</p>",$ii);
                    if ($slink2<$ilink || $slink2<$ilink) $ilink=0;
                    if ($ilink > 0 )
                    {
                    	$ilink2=strpos($sp[name],">",$ilink);
                    	$link="href=".substr($sp[name],$ilink+5,$ilink2-$ilink-5);
//                   echo "****** ii=".$ii."$ ilink=".$ilink." ilink2=".$ilink2." txt=".substr($sp[cv_text],$ilink+5,$ilink2-$ilink-5);
                    }
                    else
                        $link="href=/index.php?page_id=".$sp[page_id];
// Подставить ссылку на ФИО



             	    $ret[$iret]=array("id" => $sp[page_id],
             	                      "type"=>$sp['type'],
              	                      "avtor" =>$sp[avtor],
              	                      "name"=> strip_tags (substr($sp[name],$i+1,$ii2-$i+1)),
              	                      "name2"=>$sp[name2],
              	                      "year"=>$sp[year],
                                      "link"=>$link,
                                      "full"=>$sp[full],
                                      "visible"=>$sp[visible]
              	                      );
			        }
                  else  // Публикации
                  {
// Найти авторов
                  if ($sp[visible]!='on')
                  {
                      $avt_spisok="";
                      $avt0=explode("<br>",trim($sp[avtor]));
                      foreach($avt0 as $avt)
                      {
                      	if (!empty($avt))
                      	{
                         if (is_numeric($avt))
                      	 {
                      	  $fiot=$DB->select("SELECT CONCAT('<a title=\'Сведения о персоне\' href=/index.php?page_id=".
                      	            $ida."&id=',id,'>',surname,' ',substring(name,1,1),' ',substring(fname,1,1),
                      	            '</a>') AS fioname FROM persona WHERE id=".$avt);
                          $fion=$fiot[0][fioname];
                         }
                         else

                      	   $fion=$avt;

                      	 if (strpos($fion,"Коллектив авторов")===false)

                        	 $avt_spisok.=$fion.", ";
                      }
                      }
                      if (!empty($avt_spisok))
                          $avt_spisok=substr($avt_spisok,0,-2);
                                                            }
                  $ret[$iret]=array("id" => $sp[page_id],
                                      "type"=>$sp['type'],
              	                      "avtor" =>$avt_spisok,
              	                      "name"=> $sp[name],
              	                      "name2"=>$sp[name2],
              	                      "year"=>$sp[year],
                                      "link"=>'href=/index.php?page_id='.$idp.'&id='.$sp[page_id],
                                      "full"=>$sp[full],
                                      "visible"=>$sp[visible]

                                    );
                  }

                  $iret++;

                }
        //    }

	    }

	     return $ret;
    }
    	function getSocisByFio($fio,$id0,$year)
	{
		global $DB,$_config;
		$pg = new Pages();

		$iret=0;


		$num00=explode(",",$id0);

//        print_r($num00);

		foreach($num00 as $num0)
		{

			$numbers=$pg->getChilds($num0,true);

	        $nn="(";
			foreach($numbers as $num)
			{
			    $nn.=" c.page_id=".$num[page_id]." OR ";
			}
			if (strlen($nn)>1)
			{
		    	$nn=substr($nn,0,-4).")";
		    	$nn2="";
		    	if ($year=="prnd")
		    	    $nn2= "AND (y.cv_text like '%".date('Y')."%' OR y.cv_text like '%".(date('Y')-1)."%')";
   		   	}
		   	else $nn=1;
  //////////////////////
            if ($nn !=1)
            {

		    	$sp0=$DB->select("SELECT c.page_id,c.page_id,t.cv_text AS page_title, y.cv_text AS year,c.cv_text FROM adm_pages_content AS c ".
			    				 " INNER JOIN adm_pages_content AS t ON t.page_id=c.page_id AND t.cv_name='title' ".
			    				 " INNER JOIN adm_pages_content AS y ON y.page_id=c.page_id AND y.cv_name='year' ".$nn2.
				    			 " WHERE c.cv_name='content' AND ".$nn. " AND
					    		  c.cv_text like '%".$fio."%' "
                       		    ) ;

    			foreach($sp0 as $sp)
        		{
// Найти название

		    		$ii=strpos(strtolower($sp[cv_text]),strtolower($fio));


		    		$ii0=$ii;
			    	for($i=$ii;$i>0;$i=$i-1)
				    {
					   if ($sp[cv_text][$i]==">") break;
                    }
// Название заканчивается br Или р
	    		    $ii2=strpos($sp[cv_text],"<br />",$ii);
    	    		$ii3=strpos($sp[cv_text],"</p>",$ii);
	    	    	if (empty($ii2)) $ii2=$ii3;
	    	    	if ($ii3<$ii2) $ii2=$ii3;
// Найти ссылку на pdf

                    $ilink=strpos($sp[cv_text],"href",$ii);
                    if ($ilink > 0 )
                    {
                    	$ilink2=strpos($sp[cv_text],">",$ilink);
                    	$link=substr($sp[cv_text],$ilink+5,$ilink2-$ilink-5);
         //           echo "****** ii=".$ii."$ ilink=".$ilink." ilink2=".$ilink2." txt=".substr($sp[cv_text],$ilink+5,$ilink2-$ilink-5);
                    }
                    else
                        $link="";

             	    $ret[$iret]=array("id" => $sp[page_id],
              	                      "title" =>$sp[page_title],
              	                      "name"=> strip_tags (substr($sp[cv_text],$i+1,$ii2-$i+1)),
              	                      "year"=>$sp[year],
                                      "link"=>$link

              	                      );
			        $iret++;

                }
            }

	    }

	     return $ret;
    }

}

?>