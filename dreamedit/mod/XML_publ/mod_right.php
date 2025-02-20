<?

if($_GET['action'] == 'add') include 'action.php';
 else
if($_GET['action'] == 'save') include 'save.php';
 else
if($_GET['show'] == 'ok') include 'show.php';
 else
if($_GET['act'] == 'search') include 'search.php';
 else
if($_GET['act'] == 'del') include 'delete.php';
 else
if($_GET['act'] == 'edit') {include 'edit.php';}
 else
if($_GET['act'] == 'set') include 'set.php';
 else
if($_GET['act'] == 'delask') include 'delask.php';
 //else
//if($_GET['shw']) include 'delask.php';
//echo "<br />______________GET_________";print_r($_GET);
//$_POST[fname]='bib3.bib';print_r($_POST);
if($_GET['act'] == 'load') echo "Загрузка";

echo "<br />";

//$zt=new Dispatcher();

  include_once substr($_CONFIG["global"]["paths"]['admin_path'],0,-10)."classes/guid/guid.php";
 $uploaddir = $_CONFIG['global']['paths'][admin_path]."XMLPubl/";
if ($_FILES[fname][tmp_name]<> "" && $_REQUEST[mode]<>'journal')
{

  $guid=new guid();
  if (empty($filenames)) $filenames=str_replace("-","_",$guid->tostring()).".xml";



  move_uploaded_file($_FILES['fname']['tmp_name'], $uploaddir.$filenames) ;
//  echo "uo";

}

if (empty($filenames)) $filenames=$_REQUEST["file"];
//$a=setDB($filenames);
;
$doc = new DomDocument;
$doc->validateOnParse = true;
//echo $uploaddir.$filenames."____";
$doc->load($uploaddir.$filenames);
$title=$doc->getElementsByTagName("title");
$jjour0=$doc->getElementsByTagName("issn");
$jjour=$jjour0->item(0)->nodeValue;
$title_name=convutf8($title->item(0)->nodeValue);
$jtitle=$doc->getElementsByTagName("jrntitle");
$jtitle_name=convutf8($jtitle->item(0)->nodeValue);
$jnum=$doc->getElementsByTagName("number");
  $jnum_name=convutf8($jnum->item(0)->nodeValue);
  $jyear=$doc->getElementsByTagName("dateUni");
  $jyear_name=convutf8($jyear->item(0)->nodeValue);


echo "<br />>>>".$title_name." ".$jnum_name." ".$jyear_name;
if ($_REQUEST[mode]<>'journal' && !empty($jjour))
	echo "<a href=/dreamedit/index.php?mod=XML_publ&action=edit&mode=journal&file=".$filenames."> Сохранить как номер журнала</a>";

//if (!empty($title_name))
//{
//	echo "<br />Номер журнала: ".$title_name;
//	$_REQUEST[mode]='journal';
//}

$i=0;

if ($_REQUEST[mode]<>'journal')
{

  echo  "<a href=/dreamedit/index.php?mod=XML_publ&act=edit&id=".$k."&file=".$filenames.">"." Редактировать</a>";

}


//$_REQUEST[mode]='journal';
//Сохранить номер журнала
if ($_REQUEST[mode]=='journal')
{
$i=0;


  $jid0=$DB->select("SELECT page_id,journal FROM adm_article WHERE j_name LIKE '%".$title_name."%' AND page_template='0'");
  $jid=$jid0[0][page_id];
 echo "<br />________________".$jid; echo "SELECT page_id,journal FROM adm_article WHERE j_name LIKE '%".$title_name."%' AND page_template='0'";
	//////////////////////////////
	$depth = 0; $ixml=0;
	//$xmldata=new Array;
	$uploaddir = $_CONFIG['global']['paths'][admin_path]."XMLPubl/";
	$file = $uploaddir.$filenames;
	//echo $file;
	$xml_parser = xml_parser_create();

	xml_set_element_handler($xml_parser, "startElement", "endElement");
	xml_set_character_data_handler($xml_parser, "stringElement");

	if (!($fp = fopen($file, "r"))) {
	 die("could not open XML input");
	}

	while ($data = fgets($fp)) {
	 if (!xml_parse($xml_parser, $data, feof($fp))) {
		 echo "<br>XML Error: ";
		 echo xml_error_string(xml_get_error_code($xml_parser));
		 echo " at line ".xml_get_current_line_number($xml_parser);

		 break;
 	 }
    }

	xml_parser_free($xml_parser);


//print_r($xmldata);

//foreach($xmldata as $k=>$x)
//{
//  echo "<br />".$k; print_r($x);
//}
////////////////////////////
//print_r($jid0);

echo "SELECT page_id,journal FROM adm_article
    WHERE page_parent=".$jid.
          " AND page_template='jnumber' ".
          " AND page_name = '".$jnum_name."' ".
          " AND year=".substr($jyear_name,0,4);
if (!empty($jnum_name))
  $number=$DB->select("SELECT page_id,journal FROM adm_article
    WHERE page_parent=".$jid.
          " AND page_template='jnumber' ".
          " AND page_name = '".$jnum_name."' ".
          " AND year=".substr($jyear_name,0,4));
  $jname=$jtitle_name;

//break;
//}
// echo "<br />_________".$jtitle_name." ".$jyear_name." ".$j_num_name;
  if (count($number)>0) echo "Номер журнала уже введен. Воспользуйтесь режимом коррекции";
  else
  {
  $rubric='';$author=''; $reference='';
  //Информация о номере
  $DB->query("INSERT INTO adm_article (page_id,page_template,page_name,journal,year,j_name,date,page_status,page_parent)
           VALUES(0,'jnumber','".$jnum_name."',".
           "'".$jid0[0][journal]."',".
           "'".$jyear_name."', ".
           "'".$jname."',".
           "'".date('Ymd')."',".
           "'1',".
           $jid.")");
      $result = $DB->select("SELECT LAST_INSERT_ID() AS tid FROM adm_article LIMIT 1");

      $tid=$result[0][tid];
      $rubid=0;
      $iarticle=false;
  foreach($xmldata as $x)
  {

     switch ($x[name])
     {
        case 'SECTITLE':

        if ($x[LANG]=='RUS')
        {
	        $DB->query("INSERT INTO adm_article (page_id,page_template,page_name,journal,year,j_name,date,page_status,name,page_parent)
	           VALUES(0,'jrubric','".$x[data]."',".
	           "'".$jid0[0][journal]."',".
	           "'".$jyear_name."', ".
	           "'".$jname."',".
	           "'".date('Ymd')."',".
	           "'1',".
	           "'".$x[data]."',".
	           $tid.")");
	           $rubid0 = $DB->select("SELECT LAST_INSERT_ID() AS tid FROM adm_article LIMIT 1");
	           $rid=$rubid0[0][tid];
	           $rubid=$rid;
	    }
	    else
	       $DB->query("UPDATE adm_article SET name_en='".$x[data]."' WHERE page_id=".$rubid);

         break;
         case 'ARTTITLE':
            $atitle[$x[LANG]]=$x[data];

         break;
 //        case 'CORRESPONDENT':
 //        case 'ARTTITLE':
         case 'endAUTHOR':
         echo "fio=".$fio."#";
         if (!empty($fio))
           {
           	  $pers=$DB->select("SELECT id FROM persons WHERE
				                      surname='".trim($fio)."' ".
				                     " AND name ='".trim($fname)."' ".
				                     " AND fname ='".trim($ffname)."' ");
			  if (empty($pers))
			  {
			    	   $otd=$DB->select("SELECT page_id FROM adm_pages WHERE page_name='".$jname."' ".
				                      " AND page_template='podr'"
				             );
				       if (count($otd)==0) $otdel=228; else $otdel=$otd[0][page_id];
				       $DB->query("INSERT INTO persons
				                  (id,surname,name,fname,Autor_en,ForSite,ForSite_en,mail1,otdel,jnumber)
				                  VALUES(
				                  0,".
				                  "'".$fio."',"."'".$fname."',"."'".$ffname."',".
				                  "'".$fio_en.", ".$fname_en.".".$ffname_en."',".
				                  "'".$work."',".
				                  "'".$work_en."',".
				                  "'".$email."',".
				                  $otdel.
				                  ",'".$jname."|".$jnum_name."|".$jyear_name."'".
				                  ")");
				       $pid = $DB->select("SELECT LAST_INSERT_ID() AS pid FROM persons LIMIT 1");
            	 $authors.=$pid[0][pid]."<br>";
              }

              else
                 $authors.=$pers[0][id]."<br>";

		 $fio='';$fname='';$ffanme='';$fio_en='';$work='';$email='';

           }
        break;
        case 'endARTICLE':


           if(!empty($reference)) $reference="<p><ol>".$reference."</ol></p>";
           	$DB->query("INSERT INTO adm_article
                      (page_id,page_parent,page_name,name,name_en,people,page_template,journal,j_name,year,number,
                       annots,annots_en,date,keyword,keyword_en,page_status,
                       pages,jid,`links`,atype)
                       VALUES (
                       0,".
                       "'".$rid."',".
                       "'".$atitle[RUS]."',".
                       "'".$atitle[RUS]."',".
                       "'".$atitle[ENG]."',".
                       "'".$authors."',".
                       "'jarticle',".
                       "'".$jid0[0][journal]."',".
                       "'".$jname."',".
                       "'".$year_name."',".
                       "'".$num_name."',".
                       "'".$abstr[RUS]."',".
                       "'".$abstr[ENG]."',".
                       "'".date('Ymd')."',".
                       "'".$kw[RUS]."',".
                       "'".$kw[ENG]."',".
                       "'1',".
                       "'".$pages."',".

                       "'".$jid."',".
                       "'".$reference."',".
                       "'b".$type."')");
            $reference='';
            $authors='';




         //     $iarticle=true;
         //     $atitle[$x[LANG]]=$x[data];

         break;
         case 'INDIVIDINFO':
            $langfio=$x[LANG];

         break;
         case 'SURNAME':
               if ($langfio=='RUS')
               {
               		$fio=$x[data];
               		$lang='ru';
               }
               if ($langfio=='ENG')
               {
               		$fio_en=$x[data];
               		$lang='en';
               }
         break;
         case 'INITIALS':
               $ff=$x[data];
               $ff0=explode(".",$ff);
               if (count($ff0)<2) $ff0=explode(" ",$ff);
               if ($lang=='ru')
               {
               	   $fname=$ff0[0];
	               $ffname=$ff0[1];
               }
               else
               {
               	   $fname_en=$ff0[0];
	               $ffname_en=$ff0[1];
               }
//               echo $fio.$fname;print_r($ff0);
         break;
         case 'ORGNAME':
               if ($lang=="ru")
	               $work=$x[data];
	           else
	               $work_en=$x[data];

         break;
         case 'EMAIL':
               $email=$x[data];
         break;
         case 'ABSTRACT':
            $abstr[$x[LANG]]=$x[data];
         break;
         case 'KEYWORD':
            if (!empty($x[LANG]))
            {
            	$lang=$x[LANG];
            	$kw[$lang]='';
            }
            $kw[$lang].=$x[data]."<br>";
         break;
         case 'REFERENCE':
            $reference.="<li>".$x[data]."</li>";
         break;
         case 'PAGES':
            $pages=$x[data];
         break;
          case 'ARTTYPE':
            $type=$x[data];
         break;
		//////////////// Разобраться с авторами
          /*
				    if (count($pers)==0)
				    {
				       $otd=$DB->select("SELECT page_id FROM adm_pages WHERE page_name='".$jname."' ".
				                      " AND page_template='podr'"
				             );
				       if (count($otd)==0) $otdel=236; else $otdel=$otd[0][page_id];
				       $DB->query("INSERT INTO persons
				                  (id,surname,name,fname,otdel,jnumber)
				                  VALUES(
				                  0,".
				                  "'".$aa[0]."',"."'".$aa[1]."',"."'".$aa[2]."',".
				                  $otdel.
				                  ",'".$jname."|".$bib->fields[number]."|".$bib->fields[year]."'".
				                  ")");
				       $pid = $DB->select("SELECT LAST_INSERT_ID() AS pid FROM persons LIMIT 1");
				       $sauthors.=$pid[0][pid]."<br>";
				    }
				    else
				       $sauthors.=$pers[0][id]."<br>";
				}
               }
  			*/


	}//switch
   }//Цикла по xml

  }
  echo "<br /> Номер журнала ".$jname." ".$bib->fields[number]." ".$bib->fields[year]." успешно добавлен" ;
  echo "<br />Необходимо перейти в модуль работы со статьям и проверить порядок статей, добавить рубрики";
}
//////
if ((!$_GET['action'])&&(!$_GET['show'])&&(!$_GET['act'])) {
echo "<br />Имеются следующие записи :<br><br>";
$wow = array ();
global $DB,$_CONFIG;


//for($i=0; $i<count($wow); $i++)
 //for ($k=0; $k<strlen($wow[$i][10]); $k++)
  //echo 1;

}
function convutf8($text)
{
$text = str_replace(chr(208).chr(160),chr(208),$text); # Р
$text = str_replace(chr(208).chr(144),chr(192),$text); # А
$text = str_replace(chr(208).chr(145),chr(193),$text); # Б
$text = str_replace(chr(208).chr(146),chr(194),$text); # В
$text = str_replace(chr(208).chr(147),chr(195),$text); # Г
$text = str_replace(chr(208).chr(148),chr(196),$text); # Д
$text = str_replace(chr(208).chr(149),chr(197),$text); # Е
$text = str_replace(chr(208).chr(129),chr(168),$text); # Ё
$text = str_replace(chr(208).chr(150),chr(198),$text); # Ж
$text = str_replace(chr(208).chr(151),chr(199),$text); # З
$text = str_replace(chr(208).chr(152),chr(200),$text); # И
$text = str_replace(chr(208).chr(153),chr(201),$text); # Й
$text = str_replace(chr(208).chr(154),chr(202),$text); # К
$text = str_replace(chr(208).chr(155),chr(203),$text); # Л
$text = str_replace(chr(208).chr(156),chr(204),$text); # М
$text = str_replace(chr(208).chr(157),chr(205),$text); # Н
$text = str_replace(chr(208).chr(158),chr(206),$text); # О
$text = str_replace(chr(208).chr(159),chr(207),$text); # П
$text = str_replace(chr(208).chr(161),chr(209),$text); # С
$text = str_replace(chr(208).chr(162),chr(210),$text); # Т
$text = str_replace(chr(208).chr(163),chr(211),$text); # У
$text = str_replace(chr(208).chr(164),chr(212),$text); # Ф
$text = str_replace(chr(208).chr(165),chr(213),$text); # Х
$text = str_replace(chr(208).chr(166),chr(214),$text); # Ц
$text = str_replace(chr(208).chr(167),chr(215),$text); # Ч
$text = str_replace(chr(208).chr(168),chr(216),$text); # Ш
$text = str_replace(chr(208).chr(169),chr(217),$text); # Щ
$text = str_replace(chr(208).chr(170),chr(218),$text); # Ъ
$text = str_replace(chr(208).chr(171),chr(219),$text); # Ы
$text = str_replace(chr(208).chr(172),chr(220),$text); # Ь
$text = str_replace(chr(208).chr(173),chr(221),$text); # Э
$text = str_replace(chr(208).chr(174),chr(222),$text); # Ю
$text = str_replace(chr(208).chr(175),chr(223),$text); # Я
$text = str_replace(chr(208).chr(176),chr(224),$text); # а
$text = str_replace(chr(208).chr(177),chr(225),$text); # б
$text = str_replace(chr(208).chr(178),chr(226),$text); # в
$text = str_replace(chr(208).chr(179),chr(227),$text); # г
$text = str_replace(chr(208).chr(180),chr(228),$text); # д
$text = str_replace(chr(208).chr(181),chr(229),$text); # е
$text = str_replace(chr(209).chr(145),chr(184),$text); # ё
$text = str_replace(chr(208).chr(182),chr(230),$text); # ж
$text = str_replace(chr(208).chr(183),chr(231),$text); # з
$text = str_replace(chr(208).chr(184),chr(232),$text); # и
$text = str_replace(chr(208).chr(185),chr(233),$text); # й
$text = str_replace(chr(208).chr(186),chr(234),$text); # к
$text = str_replace(chr(208).chr(187),chr(235),$text); # л
$text = str_replace(chr(208).chr(188),chr(236),$text); # м
$text = str_replace(chr(208).chr(189),chr(237),$text); # н
$text = str_replace(chr(208).chr(190),chr(238),$text); # о
$text = str_replace(chr(208).chr(191),chr(239),$text); # п
$text = str_replace(chr(209).chr(128),chr(240),$text); # р
$text = str_replace(chr(209).chr(129),chr(241),$text); # с
$text = str_replace(chr(209).chr(130),chr(242),$text); # т
$text = str_replace(chr(209).chr(131),chr(243),$text); # у
$text = str_replace(chr(209).chr(132),chr(244),$text); # ф
$text = str_replace(chr(209).chr(133),chr(245),$text); # х
$text = str_replace(chr(209).chr(134),chr(246),$text); # ц
$text = str_replace(chr(209).chr(135),chr(247),$text); # ч
$text = str_replace(chr(209).chr(136),chr(248),$text); # ш
$text = str_replace(chr(209).chr(137),chr(249),$text); # щ
$text = str_replace(chr(209).chr(138),chr(250),$text); # ъ
$text = str_replace(chr(209).chr(139),chr(251),$text); # ы
$text = str_replace(chr(209).chr(140),chr(252),$text); # ь
$text = str_replace(chr(209).chr(141),chr(253),$text); # э
$text = str_replace(chr(209).chr(142),chr(254),$text); # ю
$text = str_replace(chr(209).chr(143),chr(255),$text); # я
$text = str_replace(chr(194).chr(171),chr(171),$text); # «
$text = str_replace(chr(194).chr(187),chr(187),$text); # »
$text = str_replace(chr(226).chr(128).chr(148),chr(151),$text); # —
return $text;
}
function startElement($parser, $name, $attrs) {
 global $depth,$xmldata,$ixml;

// echo str_repeat("&nbsp;", $depth * 3); // отступы
// echo "<b>Element: $name</b><br>"; // имя элемента
 $ixml++;
 $xmldata[$ixml][name]=$name;
 $depth++; // увеличиваем глубину, чтобы браузер показал отступы

 foreach ($attrs as $attr => $value) {
// echo str_repeat("&nbsp;", $depth * 3); // отступы
 // выводим имя атрибута и его значение
// echo 'Attribute: '.$attr.' = '.$value.'<br>';
 $xmldata[$ixml][$attr]=$value;
 }
 //echo "<br />______________________".$name;
}
function stringElement($parser, $str) {

 if (strlen(trim($str)) > 0) {
 global $depth,$xmldata,$ixml;

// echo str_repeat("&nbsp;", $depth * 3); // отступ
// echo 'String: '.convutf8($str).'<br>'; // выводим строку
 $xmldata[$ixml]["data"]=convutf8($str);
 $ixml++;
 }
}
function endElement($parser, $name) {
 global $depth,$xmldata,$ixml;

 $depth--; // уменьшаем глубину
 $ixml++;
 $xmldata[$ixml][name]="end".$name;
// echo "<br />".$ixml." +++++++++++++++++++++++end".$name;
}

?>
