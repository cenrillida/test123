<?php
global $_CONFIG,$DB,$page_content, $site_templater;

$mz=new Magazine();


$template=$DB->select("SELECT page_template FROM adm_pages WHERE page_id=".(int)$_REQUEST[page_id]);
$rowsm=$mz->getMagazineAllYear($_SESSION[jour_id]);

$pagem=$DB->select("SELECT pp.*,p.page_name AS jj,p.page_name_en AS jj_en FROM adm_pages_content AS pp
	INNER JOIN adm_pages AS p ON p.page_id=pp.page_id
	WHERE p.page_template='magazine' AND p.page_id IN
	(SELECT page_id FROM adm_pages_content WHERE cv_name='ITYPE_JOUR' AND cv_text='".$_SESSION[jour_id]."')");
$citas=$DB->select("SELECT cv_text AS citas FROM adm_magazine_content AS c
	               INNER JOIN adm_magazine AS m ON m.page_id=c.page_id AND 
                   m.page_parent=".$_SESSION[jour_id].
    " WHERE cv_name='citas'");
$block=$DB->select("SELECT c.cv_text AS block, c2.cv_text AS blocktxt,cen.cv_text AS blocken, c2en.cv_text AS blocktxt_en 
					FROM adm_magazine_content AS c
	               INNER JOIN adm_magazine AS m ON m.page_id=c.page_id AND 
                   m.page_parent=".$_SESSION[jour_id].
    " INNER JOIN adm_magazine_content AS c2 ON c2.page_id=c.page_id AND c2.cv_name='blocktxt' ".
    " LEFT OUTER JOIN adm_magazine_content AS cen ON cen.page_id=c.page_id AND cen.cv_name='block_en' ".
    " LEFT OUTER JOIN adm_magazine_content AS c2en ON c2en.page_id=c.page_id AND c2en.cv_name='blocktxt_en' ".
    " WHERE c.cv_name='block'");
$subscr=$DB->select("SELECT c.cv_text AS subscr, c2.cv_text AS subscr_en
					FROM adm_magazine_content AS c
	               INNER JOIN adm_magazine AS m ON m.page_id=c.page_id AND 
                   m.page_parent=".$_SESSION[jour_id].
    " INNER JOIN adm_magazine_content AS c2 ON c2.page_id=c.page_id AND c2.cv_name='subscr_en' ".
    " WHERE c.cv_name='subscr'");

$series = $DB->select("SELECT series FROM adm_magazine WHERE page_id=".$_SESSION[jour_id]);


foreach($pagem as $p)
{
    if ($p[cv_name]=='ARCHIVE_ID') $archiveid=$p[cv_text];
    if ($p[cv_name]=='RUBRICS_ID') $rubricid=$p[cv_text];
    if ($p[cv_name]=='AUTHORS_ID') $authorid=$p[cv_text];
    if ($p[cv_name]=='YEARS_ID')   $yearsid=$p[cv_text];
    if ($p[cv_name]=='AUTORS_YEARS_ID')  $ayearsid=$p[cv_text];

}
//print_r($pagem);


$years="";
//if($_SESSION[jour_url]=="REBQUE")
//{
//    $rows_rebque=$mz->getMagazineAllPublic();
//    foreach($rows_rebque as $row)
//    {
//        $years.=" <a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=1025&jid=".$row[jid].
//            ">".$row[year]."</a> |";
//    }
//}
//else
//{
    foreach($rowsm as $row)
    {
        $years.=" <a href=".$_SESSION[lang]."/jour/".$_SESSION[jour_url]."/index.php?page_id=".$yearsid.
            "&year=".$row[year].
            ">".$row[year]."</a> |";

    }
//}


// вывод правого блока на главной

// 5a. Заголовки блоков страниц модуль
if(!empty($block[0][block])) {
    $headers = new Headers();

    $elements = $headers->getHeaderElements($block[0][block]);

    if (!empty($elements)) {
        foreach ($elements as $k => $v) {
            $tpl = new Templater();
            $tpl->setValues($v);
            if ($v["ctype"] == "Фильтр") {
                $tpl->appendValues(array("FILTERCONTENT" => $page_content[$v["fname"]]));
                $tpl->appendValues(array("YEARS_ID" => $yearsid));
            }
            $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"] . "tpl.headers_right_jour.html");
        }
    }
} else {

// 1. Индексируется
    if (count($citas) > 0) {

        $tpl = new Templater();
        $tpl->appendValues(array("CCLASS" => "Красный"));
        $tpl->appendValues(array("CTYPE" => "Текст"));
        if ($_SESSION[lang] != '/en')
            $tpl->appendValues(array("TITLE" => "Индексируется"));//$pagem[0][jj]));
        else
            $tpl->appendValues(array("TITLE_EN" => "Indexed"));
        $tpl->appendValues(array("SHOWTITLE" => "1"));
        $tpl->appendValues(array("TEXT" => $citas[0][citas]));
        $tpl->appendValues(array("TEXT_EN" => $citas[0][citas]));
        //	 $tpl->appendValues(array("TEXT_EN" => $years));
        echo '<div class="box">';
        $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"] . "tpl.headers_right.html");
        echo '</div>';
    }
///

// 1a. Текущий номер

    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "last_number");

///

// 3. Отправить статью

    if($_SESSION[jour_url] == 'PMB') {
        $tpl = new Templater();
        $tpl->appendValues(array("CCLASS" => "Зеленый"));
        $tpl->appendValues(array("CTYPE" => "Текст"));

        if ($_SESSION[lang] != '/en')
            $tpl->appendValues(array("TITLE" => "Отправить статью"));//$pagem[0][jj]));
        else
            $tpl->appendValues(array("TITLE_EN" => "Submit an Article"));

        $tpl->appendValues(array("SHOWTITLE" => "1"));
        $tpl->appendValues(array("TEXT" => "<img hspace=6 src=/files/Image/send_art.jpg /><a href=/jour/" . $_SESSION[jour_url] . "/index.php?page_id=1632>Форма для отправки статьи</a>"));
        $tpl->appendValues(array("TEXT_EN" => "<img hspace=6 src=/files/Image/send_art.jpg /><a href=/en/jour/" . $_SESSION[jour_url] . "/index.php?page_id=1632>Submit an Article</a>"));

        echo '<div class="box">';
        $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"] . "tpl.headers_right.html");
        echo '</div>';
    }
///


// 2. В журнале
    if ($_SESSION[jour_url] == 'meimo') {
        if (count($pagem) > 0) {
            $tpl = new Templater();
            $tpl->appendValues(array("CCLASS" => "Голубой 1"));
            $tpl->appendValues(array("CTYPE" => "Текст"));
            if ($_SESSION[lang] != '/en')
                $tpl->appendValues(array("TITLE" => "В журнале"));//$pagem[0][jj]));
            else
                $tpl->appendValues(array("TITLE_EN" => "In Journal"));
            $tpl->appendValues(array("SHOWTITLE" => "1"));
            if ($_SESSION[lang] != '/en')
                $tpl->appendValues(array("TEXT" => "<b><a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . ">" .
                    mb_strtoupper($pagem[0][jj], 'cp1251') . "</a></b><br>" .
                    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $archiveid . ">Архив</a><br />" .
                    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $rubricid . ">Индекс рубрик</a><br />" .
                    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $authorid . ">Индекс авторов</a><br />" .
                    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $yearsid . ">Статьи за год</a><br />" .
                    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $ayearsid . ">Авторы за год</a><br />"
                ));

            else
                $tpl->appendValues(array("TEXT_EN" => "<b><a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . ">" .
                    mb_strtoupper($pagem[0][jj_en], 'cp1251') . "</a></b><br>" .
                    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $archiveid . ">Archive</a><br />" .
                    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $rubricid . ">Subjects</a><br />" .
                    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $authorid . ">Authors</a><br />" .
                    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $yearsid . ">Articles by year</a><br />" .
                    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $ayearsid . ">Authors by year</a><br />"
                ));

            //	print_r($citas);echo $_SESSION[jour_id];
            echo '<div class="box">';
            $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"] . "tpl.headers_right.html");
            echo '</div>';
            //print_r($citas);
        }
    }
    if (count($pagem) > 0 && $_SESSION['jour_url'] != 'meimo') {
        $tpl = new Templater();
        $tpl->appendValues(array("CCLASS" => "Голубой 1"));
        $tpl->appendValues(array("CTYPE" => "Текст"));
        if ($series[0]['series'] != "Ежегодник") {
            if ($_SESSION[lang] != '/en')
                $tpl->appendValues(array("TITLE" => "В журнале"));//$pagem[0][jj]));
            else
                $tpl->appendValues(array("TITLE_EN" => "In Journal"));
        } else {
            if ($_SESSION[lang] != '/en')
                $tpl->appendValues(array("TITLE" => "В ежегоднике"));//$pagem[0][jj]));
            else
                $tpl->appendValues(array("TITLE_EN" => "In Yearbook"));
        }
        $tpl->appendValues(array("SHOWTITLE" => "1"));
        if ($_SESSION[jour_url] != 'god_planety' && $_SESSION[jour_url] != 'WER') {
            if ($_SESSION[jour_url] != 'REBQUE' && $_SESSION[jour_url] != 'oprme' && $_SESSION[jour_url] != 'SIPRI' && $_SESSION[jour_url] != 'REB-2' && $_SESSION[jour_url] != 'Russia-n-World') {



                    if ($_SESSION[lang] != '/en') {
                        $enArchive = "";
                        if($_SESSION[jour_url]=="PMB") {
                            $enArchive = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=1648>Все статьи</a><br />";
                            $enArchive .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=1548>Статьи на английском языке</a><br />";
                        }
                        $tpl->appendValues(array("TEXT" => "<b><a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . ">" .
                            mb_strtoupper($pagem[0][jj], 'cp1251') . "</a></b><br>" .
                            "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $archiveid . ">Архив</a><br />" .$enArchive.
                            "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $rubricid . ">Индекс рубрик</a><br />" .
                            "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $authorid . ">Индекс авторов</a><br />" .
                            "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $yearsid . ">Статьи за год</a><br />" .
                            "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $ayearsid . ">Авторы за год</a><br />"
                        ));
                    }

                    else {
                        $enArchive = "";
                        if($_SESSION[jour_url]=="PMB") {
                            $enArchive = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=1648>Full Archive</a><br />";
                            $enArchive .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=1548>Articles in English</a><br />";
                        }
                        $tpl->appendValues(array("TEXT_EN" => "<b><a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . ">" .
                            mb_strtoupper($pagem[0][jj_en], 'cp1251') . "</a></b><br>" .
                            "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $archiveid . ">Archive</a><br />" .$enArchive.
                            "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $rubricid . ">Subjects</a><br />" .
                            "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $authorid . ">Authors</a><br />" .
                            "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $yearsid . ">Articles by year</a><br />" .
                            "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $ayearsid . ">Authors by year</a><br />"
                        ));
                    }

            } else {
                if ($_SESSION[lang] != '/en')
                    $tpl->appendValues(array("TEXT" => "<b><a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . ">" .
                        mb_strtoupper($pagem[0][jj], 'cp1251') . "</a></b><br>" .
                        "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $archiveid . ">Архив</a><br />"
                    ));

                else
                    $tpl->appendValues(array("TEXT_EN" => "<b><a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . ">" .
                        mb_strtoupper($pagem[0][jj_en], 'cp1251') . "</a></b><br>" .
                        "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $archiveid . ">Archive</a><br />"
                    ));
            }
        } else {
            if ($_SESSION[lang] != '/en')
                $tpl->appendValues(array("TEXT" => "<b><a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . ">" .
                    mb_strtoupper($pagem[0][jj], 'cp1251') . "</a></b><br>" .
                    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $archiveid . ">Архив</a><br />" .
                    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $rubricid . ">Индекс рубрик</a><br />" .
                    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $authorid . ">Индекс авторов</a><br />" .
                    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $ayearsid . ">Авторы за год</a><br />"
                ));

            else
                $tpl->appendValues(array("TEXT_EN" => "<b><a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . ">" .
                    mb_strtoupper($pagem[0][jj_en], 'cp1251') . "</a></b><br>" .
                    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $archiveid . ">Archive</a><br />" .
                    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $rubricid . ">Rubrics</a><br />" .
                    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $authorid . ">Authors</a><br />" .
                    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $ayearsid . ">Authors by year</a><br />"
                ));
        }

//	print_r($citas);echo $_SESSION[jour_id];
        echo '<div class="box">';
        $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"] . "tpl.headers_right.html");
        echo '</div>';
//print_r($citas);


    }
///

// x. по годам
    if ($_SESSION[jour_url] != 'god_planety' && $_SESSION[jour_url] != 'WER' && $_SESSION[jour_url] != 'oprme' && $_SESSION[jour_url] != 'REB-2' && $_SESSION[jour_url] != 'Russia-n-World' && $_SESSION['jour_url']!='REBQUE') {
        $tpl = new Templater();
        $tpl->appendValues(array("CCLASS" => "Красный"));
        $tpl->appendValues(array("CTYPE" => "Текст"));
        if ($_SESSION[lang] != '/en')
            $tpl->appendValues(array("TITLE" => "По годам"));//$pagem[0][jj]));
        else
            $tpl->appendValues(array("TITLE_EN" => "Years"));
        $tpl->appendValues(array("SHOWTITLE" => "1"));
        $tpl->appendValues(array("TEXT" => $years));
        $tpl->appendValues(array("TEXT_EN" => $years));
        echo '<div class="box">';
        $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"] . "tpl.headers_right.html");
        echo '</div>';
    }
///

}