<?php
global $_CONFIG,$DB,$page_content, $site_templater;

$pagem=$DB->select("SELECT pp.*,p.page_name AS jj,p.page_name_en AS jj_en FROM adm_pages_content AS pp
	INNER JOIN adm_pages AS p ON p.page_id=pp.page_id
	WHERE p.page_template='magazine' AND p.page_id IN
	(SELECT page_id FROM adm_pages_content WHERE cv_name='ITYPE_JOUR' AND cv_text='".$_SESSION[jour_id]."')");

foreach($pagem as $p)
{
    if ($p[cv_name]=='ARCHIVE_ID') $archiveid=$p[cv_text];
    if ($p[cv_name]=='RUBRICS_ID') $rubricid=$p[cv_text];
    if ($p[cv_name]=='AUTHORS_ID') $authorid=$p[cv_text];
    if ($p[cv_name]=='YEARS_ID')   $yearsid=$p[cv_text];
    if ($p[cv_name]=='AUTORS_YEARS_ID')  $ayearsid=$p[cv_text];

}

// 2. � �������
if ($_SESSION[jour_url] == 'meimo') {
    if (count($pagem) > 0) {
        $tpl = new Templater();
        $tpl->appendValues(array("CCLASS" => "������� 1"));
        $tpl->appendValues(array("CTYPE" => "�����"));
        if ($_SESSION[lang] != '/en')
            $tpl->appendValues(array("TITLE" => "� �������"));//$pagem[0][jj]));
        else
            $tpl->appendValues(array("TITLE_EN" => "In Journal"));
        $tpl->appendValues(array("SHOWTITLE" => "1"));
        if ($_SESSION[lang] != '/en')
            $tpl->appendValues(array("TEXT" => "<b><a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . ">" .
                mb_strtoupper($pagem[0][jj], 'cp1251') . "</a></b><br>" .
                "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $archiveid . ">�����</a><br />" .
                "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $rubricid . ">������ ������</a><br />" .
                "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $authorid . ">������ �������</a><br />" .
                "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $yearsid . ">������ �� ���</a><br />" .
                "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $ayearsid . ">������ �� ���</a><br />"
            ));

        else
            $tpl->appendValues(array("TEXT_EN" => "<b><a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . ">" .
                mb_strtoupper($pagem[0][jj_en], 'cp1251') . "</a></b><br>" .
                "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $archiveid . ">Full</a><br />" .
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
        $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"] . "tpl.headers_only_text.html");
        echo '</div>';
        //print_r($citas);
    }
}
if (count($pagem) > 0 && $_SESSION['jour_url'] != 'meimo') {
    $tpl = new Templater();
    $tpl->appendValues(array("CCLASS" => "������� 1"));
    $tpl->appendValues(array("CTYPE" => "�����"));
    if ($series[0]['series'] != "���������") {
        if ($_SESSION[lang] != '/en')
            $tpl->appendValues(array("TITLE" => "� �������"));//$pagem[0][jj]));
        else
            $tpl->appendValues(array("TITLE_EN" => "In Journal"));
    } else {
        if ($_SESSION[lang] != '/en')
            $tpl->appendValues(array("TITLE" => "� ����������"));//$pagem[0][jj]));
        else
            $tpl->appendValues(array("TITLE_EN" => "In Yearbook"));
    }
    $tpl->appendValues(array("SHOWTITLE" => "1"));
    if ($_SESSION[jour_url] != 'god_planety' && $_SESSION[jour_url] != 'WER') {
        if ($_SESSION[jour_url] != 'REBQUE') {
            if ($_SESSION[lang] != '/en') {
                $enArchive = "";
                if($_SESSION[jour_url]=="PMB") {
                    $enArchive = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $rubricid . ">������ �� ���������� �����</a><br />";
                }
                $tpl->appendValues(array("TEXT" => "<b><a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . ">" .
                    mb_strtoupper($pagem[0][jj], 'cp1251') . "</a></b><br>" .
                    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $archiveid . ">�����</a><br />" .$enArchive.
                    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $rubricid . ">������ ������</a><br />" .
                    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $authorid . ">������ �������</a><br />" .
                    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $yearsid . ">������ �� ���</a><br />" .
                    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $ayearsid . ">������ �� ���</a><br />"
                ));
            }
            else {
                $tpl->appendValues(array("TEXT_EN" => "<b><a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . ">" .
                    mb_strtoupper($pagem[0][jj_en], 'cp1251') . "</a></b><br>" .
                    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $archiveid . ">�����</a><br />" .
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
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $archiveid . ">�����</a><br />"
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
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $archiveid . ">�����</a><br />" .
                "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $rubricid . ">������ ������</a><br />" .
                "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $authorid . ">������ �������</a><br />" .
                "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $ayearsid . ">������ �� ���</a><br />"
            ));

        else
            $tpl->appendValues(array("TEXT_EN" => "<b><a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . ">" .
                mb_strtoupper($pagem[0][jj_en], 'cp1251') . "</a></b><br>" .
                "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $archiveid . ">Archive</a><br />" .
                "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $rubricid . ">Rubrisc</a><br />" .
                "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $authorid . ">Authors</a><br />" .
                "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href=" . $_SESSION[lang] . "/jour/" . $_SESSION[jour_url] . "/index.php?page_id=" . $ayearsid . ">Authors by year</a><br />"
            ));
    }

//	print_r($citas);echo $_SESSION[jour_id];
    echo '<div class="box">';
    $tpl->displayResultFromPath($_CONFIG["global"]["paths"]["templates"] . "tpl.headers_only_text.html");
    echo '</div>';
//print_r($citas);


}
///