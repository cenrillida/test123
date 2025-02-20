<?
include_once dirname(__FILE__)."/../../_include.php";

// подключаем файл соединения с базой
include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/site.fns.php";
$mz=new Magazine();
$xml=new xml_output();
$attr=$mz->getMagazineAttribute($_REQUEST[id]);
//print_r($attr);
$jnum=$mz->getMagazineNumber($_REQUEST[id]);
/////////  Посчитать node, статьи,  Pages
$node=10;
$pages=1;
$articles=0;
foreach($jnum as $jn)
{   if ($jn[page_template] =='jarticle')
   {   	  $articles++;
      if (!empty($jn[pages]))
      {
      		$pp=explode("-",$jn[pages]);
      		$pages=$pp[1];
      }
      $node+=7;  //segtitle,fpage,lpage,type,artitle,text
      if (!empty($jn[name_en])) $node+=1; //Название на английском
      if (!empty($jn[people])) // Есть авторы
      {//      	  $node+=2;
          $avt=explode("<br>",trim($jn[people]));
          if (!empty($avt[count($avt)][surname]))
	          $node+=count($avt)*4;
	      else
	          $node+=(count($avt)-1)*4;
      }
      if (!empty($jn[annots])) $node+=1; //Аннотация
      if (!empty($jn[annots_en])) $node+=1; //Аннотация на английском

      if (!empty($jn[keyword])) //ключевые слова
      {      	  $kw=explode(",",trim($jn[keyword]));
      	  if (!empty($rw[count($kw)]))
        	  $node+=count($kw);
          else
              $node+=count($kw)-1;
      }
      if (!empty($jn[keyword_en])) //ключевые слова
      {
      	  $kw=explode(",",trim($jn[keyword_en]));
      	  if (!empty($rw[count($kw)]))
        	  $node+=count($kw);
          else
              $node+=count($kw)-1;
      }
      if (!empty($jn[links])) //библиография
      {
      	  	$jn[links]=str_replace("<ol>","",str_replace("</ol>","",trim($jn[links])));
            $ll0=explode("<li>",$jn[links]);
      	  	if (!empty($ll0[count($ll0)]))
        	  	$node+=count($ll0);
        	else
        	     $node+=count($ll0)-1;
      }
      $node+=1; //pdf
   }
}

///////////////
//print_r($jnum);
$xml->startXML();
$xml->elementStart('journals');
   $xml->elementStart('opercard');
      $xml->element('operator',null,'"ИНИОН РАН|Кокарев Константин Павлович"');
      $xml->element('date',null,'"'.date('Y-m-d-G:i:s').'"');
      $xml->element('cntArticle',null,$articles);
  	  $xml->element('cntnode',null,$node);
  	  $xml->element('cs',null,"???");
   $xml->elementEnd('opercard');

  $xml->elementStart('journal');
      $xml->elementStart('journalInfo',array('lang' =>"RUS"));
	      $xml->element('jrntitle',null,'"'.utf8_encode($attr[0][page_name]).'"');
	      $xml->element('publ',null,'Институт научной информации по общественным наукам РАН');
	      $xml->element('placepubl',null,'Москва');
	      $xml->element('loc',null,'Адрес редакции: 117218, Москва, ул. Кржижановского, д. 24/35, корпус 5, оф. 301');
      $xml->elementEnd('journalInfo');
      $xml->elementStart('issue');
          $xml->element('issn',null,$attr[0][issn]);
          $xml->element('jrncode',null,$attr[0][eLibrary]);
          $xml->element('jnumUni',null,$attr[0][number]);
          $xml->element('jdateUni',null,$attr[0][date_public]);
          $xml->element('pages',null,'1-'.$pages);
$current_rubric="";
foreach($jnum as $jn)
{
          if ($jn[page_template]=='jrubric')
          {          	  $current_rubric=$jn[name];
          }
          if (!empty($jn[people]))
          {          	$avt=$mz->getAutors($jn[people]);
 //           echo "<br />___";
 //           print_r($avt);

          }

          if (!empty($current_rubric))
          {
             $xml->elementStart('jseparate');
              	  $xml->element('segtitle',array('lang' =>"RUS"),$jn[name]);
             $xml->elementEnd('jseparate');
          }
          if ($jn[page_template]=='jarticle')
          {
             $xml->elementStart('article');
             	if (!empty($jn[pages])) $str=explode("-",$jn[pages]);
                $xml->element('fpageart',null,$str[0]);
                $xml->element('lpageart',null,$str[1]);
                if (!empty($jn[people]))
                {
	                $xml->elementStart('authors');
	                $iavt=1;
	                foreach($avt as $a)
	                {	                 	if (!empty($a[surname]))
	                 	{
	                 	$xml->elementStart('author',array('num'=>$iavt));
		                 	$iavt++;
//		                 	$xml->element('correspondent',null,'0');
		                 	$xml->elementStart('individInfo',array('lang' =>"RUS"));
			                 	$xml->element('surname',null,$a[surname]);
			                 	$xml->element('name',null,$a[name].' '.$a[fname]);
			                 	$xml->element('auwork',null,$a[work]);
		 //                     $xml->element('auinf',null,$a[work]);
		                        $xml->element('auemail',null,$a[mail1]);
		                    $xml->elementEnd('individInfo');
	                    $xml->elementEnd('author');
	                    }
	                }
	                $xml->elementEnd('authors');
                }
                else
                $xml->element('noauthors');
                $xml->elementStart('arttitles');
	                 $xml->element('arttitle',array('lang' =>"RUS"),$jn[name]);
	                 if (!empty($jn[name_en]))
			                 $xml->element('arttitle',array('lang' =>"ENG"),$jn[name_en]);

                $xml->elementEnd('arttitles');
                if (!empty($jn[annots]))
                {
                   	$xml->elementStart('abstracts');
                       $xml->element('abstract',array('lang' =>"RUS"),utf8_encode(strip_tags($jn[annots])));
                       $xml->element('abstract',array('lang' =>"ENG"),utf8_encode(strip_tags($jn[annots_en])));

                   	$xml->elementEnd('abstracts');
                }
                else
                	$xml->element('noabstracts');
                if (empty($jn[atype]))	$jn[atype]='RAR';
                $xml->element('arttype',null,$jn[atype]);

// Текст статьи
//                if (empty($jn[contents])) $jn[contents]=$jn[name]." ".strip_tags($jn[annots]);
                $jn[contents]=utf8_encode($jn[name]." ".strip_tags($jn[annots]));
                $xml->element('text',null,strip_tags($jn[contents]));
               if (!empty($jn[keyword]) ||!empty($jn[keyword_en]))
               {
               $xml->elementStart('keywords');

               if (!empty($jn[keyword]))
               {
                    $xml->elementStart('kwdGroup',array('lang' =>"RUS"));
                    $kw0=explode(",",strip_tags($jn[keyword]));
                    foreach($kw0 as $kw)
                    {
                        if (!empty($kw))
	                        $xml->element('keyword',null,$kw);
                    }
                    $xml->elementEnd('kwdGroup');
                }
                 if (!empty($jn[keyword_en]))
               {
                    $xml->elementStart('kwdGroup',array('lang' =>"ENG"));
                    $kw0=explode(",",strip_tags($jn[keyword_en]));
                    foreach($kw0 as $kw)
                    {
                        if (!empty($kw))
		                    $xml->element('keyword',null,$kw);
                    }
                    $xml->elementEnd('kwdGroup');
                }
               $xml->elementEnd('keywords');
               }
               else
                    $xml->element('nokeywords');
               if (!empty($jn[links]))
               {               	  $xml->elementStart('biblist');
                   	$jn[links]=str_replace("<ol>","",str_replace("</ol>","",trim($jn[links])));
                    $ll0=explode("<li>",$jn[links]);

                    foreach($ll0 as $ll)
                    {                    	$ll=trim(strip_tags($ll));
                    	if (!empty($ll))
       		             	$xml->element('blistpar',null,$ll);

                    }
                  $xml->elementEnd('biblist');
               }
               else
                   $xml->element('nobiblist');
               if (strpos($jn['link'],'href=',0) >0)
				{

//				   $filter="/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?= ()~_|!:,.;]*[A-Z0-9+&@#\/%=~_|]\.pdf/i";

//				   preg_match_all($filter,$jn['link'],$res);

//				   for($i=0;$i<=count($res);$i++)
//				   {
//				      $jn['link']=str_replace($res[0][$i],str_replace(' ','^',$res[0][$i]),$jn['link']);
//				   }
                   $ref=strpos($jn['link'],'href=');
                   $ref2=strpos($jn['link'],'.pdf',$ref);
                   for($i=$ref2;$i>1;$i=$i-1)
                   {                   	  if (substr($jn['link'],$i,1)=='/') break;
                   }
                   $jn['link']=substr($jn['link'],($i+1),($ref2-$i+3));
				}
               $xml->element('fpdf',null,$jn['link']);
             $xml->elementEnd('article');
           }
}
      $xml->elementEnd('issue');
   $xml->elementEnd('journal');
$xml->elementEnd('journals');
$xml->endXML();
?>