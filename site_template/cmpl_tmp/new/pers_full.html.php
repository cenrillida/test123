<?
global $DB,$_CONFIG, $site_templater;
//print_r($_SESSION[lang]);
if($_SESSION["lang"] == "")
{
	$lang_suf = "_RU"; 
	$orcidText = "Профиль автора в ORCID";
}
else
{
	$lang_suf = "_EN";
	$_REQUEST["en"]=true;
    $orcidText = "Author's profile in ORCID";
}
//print_r($_SESSION[lang]);echo "<br />_________________<br />";print_r($_REQUEST);
//echo "@@@";
$ps = new Persons();
$isClosed = false;
if(!empty($_REQUEST["id"])) {
    $rows=$ps->getPersonsById($_REQUEST["id"]);

    if(!empty($rows)) {
        $isClosed = $ps->isClosed($rows[0]);
    }
}

if(empty($rows) || $isClosed) {
    Dreamedit::sendHeaderByCode(301);
    Dreamedit::sendLocationHeader("https://".$_SERVER["SERVER_NAME"]."/404");
    exit;
}

if(!empty($rows)) {

//print_r($rows);
    $site_templater->appendValues(array("DESCRIPTION" => "Сотрудник ИМЭМО РАН " . strip_tags($rows[0]["fio"])));
    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "top.text.html");

    $pg = new Pages();

    $id = addslashes((int)$_REQUEST['id']);
    global $_CONFIG;
    $ps = new Persons();
    $second_profile = $DB->select("SELECT id FROM persons WHERE second_profile=" . $id);
    if (!empty($second_profile)) {
        $id = $second_profile[0]["id"];
    }

    $second_profile = $DB->select("SELECT CONCAT(surname,' ',name,' ',fname) AS fio,LastName_EN AS f_lastname_en, second_profile FROM persons WHERE id=" . $id);
    if ($second_profile[0]['second_profile'] != -1) {
        $id = $second_profile[0]['second_profile'];
        $_REQUEST["id"] = $id;
        $new_fio = $second_profile[0]['fio'];
        $new_lastname_en = $second_profile[0]['f_lastname_en'];
    }
//Проверить наличие фотографии
    $row = $ps->getPersonsByIdFull($id);
    if ($second_profile[0]['second_profile'] != -1) {
        $old_fio = " (" . $row[0]["surname"] . ")";
        $row[0]["fio"] = $new_fio;
        $row[0]["f_lastname_en"] = $new_lastname_en;
    }
    if ($_SESSION["lang"] != '/en')
        $rowss = $DB->select("SELECT Admin.*,IF(type=100,'Дирекции',IF(type=200,'Ученого совета',IF(d.icont_text<>'',CONCAT('Диссертационного совета ',d.icont_text),''))) AS spisok,
                    pc.page_id
					FROM Admin 
                    LEFT OUTER JOIN adm_directories_content AS d ON d.el_id=Admin.type AND d.icont_var='text' 
					LEFT OUTER JOIN adm_pages_content AS pc ON pc.cv_name='sovet' AND pc.cv_text=d.el_id 
		WHERE persona=" . $id . " ORDER BY type");
    else
        $rowss = $DB->select("SELECT Admin.*,IF(type=100,'Directorate',IF(type=200,'Academic Council',IF(d.icont_text<>'',CONCAT('Dissertation Council ',d.icont_text),''))) AS spisok,
                    pc.page_id
					FROM Admin 
                    LEFT OUTER JOIN adm_directories_content AS d ON d.el_id=Admin.type AND d.icont_var='text' 
					LEFT OUTER JOIN adm_pages_content AS pc ON pc.cv_name='sovet' AND pc.cv_text=d.el_id 
		WHERE persona=" . $id . " ORDER BY type");
    $rowssem = $DB->select("SELECT c.icont_text AS sem, pc.page_id , t.icont_text AS title,ten.icont_text AS title_en
                      FROM adm_directories_content AS c
					  INNER JOIN adm_directories_content AS t ON t.el_id=c.el_id AND t.icont_var='text'
					  LEFT OUTER JOIN adm_directories_content AS ten ON ten.el_id=c.el_id AND ten.icont_var='text_en'
					  INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND e.itype_id=15
					  INNER JOIN adm_pages_content AS pc ON pc.cv_name='sem' AND pc.cv_text=c.el_id
					  INNER JOIN adm_pages AS ppc ON ppc.page_id=pc.page_id AND ppc.page_status=1 
					  WHERE c.icont_var='chif' AND c.icont_text=" . (int)$_REQUEST["id"]);
// print_r($rowssem);
    echo "<div class='publ'>";
    if (!empty($row[0]["picbig"])) {
        $photo = '<a href=#><img alt="" src="/dreamedit/foto/' . $row[0]["picbig"] . '?ver=' . filemtime('dreamedit/foto/' . $row[0]["picbig"]) . '" /></a>';
    } else
        $photo = "";

    if(isset($_TPL_REPLACMENT["PERS_PAGE"])) {
        if ($_SESSION["lang"] != '/en')
            echo "<a href=/indeх.php?page_id=" . $_TPL_REPLACMENT["PERS_PAGE"] . ">К списку персон</a>";
        else
            echo "<a href=/en/indeх.php?page_id=" . $_TPL_REPLACMENT["PERS_PAGE"] . ">To the list of persons</a>";
    }

    echo "<br /><br />";
    $year_life = "";
    if ($row[0]["otdel_id"] == 1239)
        $year_life = " <b style='color: grey'>(" . $row[0]["rewards"] . ")</b>";
    if ($row[0]["full"] == 1) {
        if ($_SESSION["lang"] != '/en')
            echo "<h2>" . $row[0]["fio"] . $old_fio . $year_life . "<br /></h2>";
        else
            echo "<h2>" . $row[0]["f_name_en"] . " " . $row[0]["f_lastname_en"] . $year_life . "<br /></h2>";
//	if (!empty($row[0][fio_en]) && $_SESSION[lang] !='/en')
//	 echo "<br /><h2><span style='border: solid 1px gray;'>&nbsp; ".$row[0][fio_en]."&nbsp;</span></h2>";
    } else {
        if ($_SESSION["lang"] != '/en')
            echo "<h2>" . $row[0]["fio"] . $old_fio . $year_life . "</h2>";
        else
            echo "<h2>" . $row[0]["f_name_en"] . " " . $row[0]["f_lastname_en"] . $year_life . "</h2>";
//	if (!empty($row[0][fio_en]) && $_SESSION[lang]!='/en') echo "<h2> ".$row[0][fio_en]."</h2><br />";

        echo "<br />";
    }
    echo "<div class=''>";
    echo "<div class='row'>";
    echo "<div class='text-center col-12 col-md-2 order-last'>";

    if (!empty($photo))
        echo $photo;

    echo "</div><div class='col'>";
    if (!empty($row[0]["regalii0"]) || !empty($row[0]["regalii0"]))
        echo $row[0]["regalii0"] . "<br />" . $row[0]["regalii"];

    if ($row[0]["otdel"] != 'Партнеры' && $row[0]["otdel_id"] != 1239 && $row[0]["otdel_id"] != 1240) {
        if ($row[0]["otdel"] != 'Партнеры' && $row[0]["dolj"] <> 'сотрудник другой организации')
            echo $row[0]["dolj"] . "<br />";
        echo $row[0]["otdel"];
    }
    if ($row[0]["otdel_id"] != 1239 && $row[0]["otdel_id"] != 1240) {
        if ($row[0]["dolj2"] <> '') echo "<br />" . $row[0]["dolj2"] . "<br />" . $row[0]["otdel2"];
        if ($row[0]["dolj3"] <> '') echo "<br />" . $row[0]["dolj3"] . "<br />" . $row[0]["otdel3"];
    }
    echo "<br />";

    if (!empty($row[0]["contact"]) && $row[0]["contact"] != '<a href="mailto:"></a>' && $row[0]["contact"] != '<a href=mailto:></a>') {
        if ($_SESSION["lang"] != '/en')
            echo "<div class='mt-3'><b>Контактная информация</b></div>";
        else
            echo "<div class='mt-3'><b>Сontact Information</b></div>";
        echo "<div>" . $row[0]["contact"] . "</div>";
    }
    if ($_SESSION["lang"] != '/en') {
        echo "<div class='mt-3'><a href=/index.php?page_id=" . $_TPL_REPLACMENT["PERSS_PAGE"] . "&pid=" . $_REQUEST["id"] . ">О персоне подробнее</a></div>";
        echo "<div class='mt-3'><a href=/index.php?page_id=1500&fio=" . $_REQUEST["id"] . ">Публикации автора</a></div>";
    } else {
        echo "<div class='mt-3'><a href=/en/index.php?page_id=" . $_TPL_REPLACMENT["PERSS_PAGE"] . "&pid=" . $_REQUEST["id"] . ">About the person detailed</a></div>";
        echo "<div class='mt-3'><a href=/en/index.php?page_id=1500&fio=" . $_REQUEST["id"] . ">Author's publications</a></div>";

    }

    if(!empty($row[0]["orcid"])) {
        echo "<div class='mt-3'><a target='_blank' href=\"https://orcid.org/{$row[0]['orcid']}\">$orcidText <i class=\"fab fa-orcid\" style=\"color: #a5cd39\"></i></a></div>";
    }
    echo "</div>";
    echo "</div>";
    echo "</div><br />";

    if (count($rowss) > 0) {

        $includedInText = "";
        foreach ($rowss as $rs) {
            if ($rs["type"] == 100) $page_id = 510;
            if ($rs["type"] == 200) $page_id = 511;
            if ($rs["type"] != 100 && $rs["type"] != 200 && $rs["type"] != 300) $page_id = $rs["page_id"];

            $pg = new Pages();

            $page = $pg->getPageById($page_id);

            if (!empty($rs["spisok"]) && $page["page_status"])
                $includedInText .= "<li><a href=" . $_SESSION["lang"] . "/index.php?page_id=" . $page_id . ">" . $rs["spisok"] . "</a></li>";
        }
        if (!empty($includedInText)) {
            if ($_SESSION["lang"] != '/en') echo "<b>Входит в состав:</b><ul>";
            else echo "<b>Member of:</b><ul>";
            echo $includedInText;
            echo "</ul>";
        }
    }
    if (count($rowssem) > 0) {
        if ($_SESSION["lang"] != '/en') echo "<b>Руководит семинарами: </b><ul>";
        else echo "<b>Lead the workshops: </b><ul>";
        foreach ($rowssem as $rs) {

            if ($_SESSION["lang"] != '/en')
                echo "<li><a href=/index.php?page_id=" . $rs["page_id"] . ">" . $rs["title"] . "</a></li>";
            else if (!empty($rs["title_en"]))
                echo "<li><a href=/en/index.php?page_id=" . $rs["page_id"] . ">" . $rs["title_en"] . "</a></li>";

        }
        echo "</ul>";
    }

    $nirs = new Nirs();
    $rowsn = $nirs->getGrantByPersId(date("Y"), "", $_REQUEST["id"]);
    if (count($rowsn) > 0 && $_SESSION["lang"] != '/en') {

        echo "<b>Руководит проектами: </b><ul>";
        foreach ($rowsn as $r) {
            $grant = $r["grant_type"];
            if ($grant == 'РФФИ')
                $grant = '<a href="/index.php?page_id=1003">РФФИ</a>';
            if ($grant == 'РНФ')
                $grant = '<a href="/index.php?page_id=967">РНФ</a>';
            if ($grant == 'Грант Президента Российской Федерации')
                $grant = '<a href="/RF_President_Grant">Грант Президента Российской Федерации</a>';
            echo "<li>" . $grant . " " . $r["number"] . "<br />";
            echo "<b>" . $r["title"] . "</b><br />";
            echo "Срок проведения: " . $r["year_beg"] . " - " . $r["year_end"];
            echo "</li>";
        }
        echo "</ul>";
    }

    echo $row[0]["about"];




    echo "<br />";
    echo "</div>";
}
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>



