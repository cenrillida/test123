<?php
global $_CONFIG, $site_templater, $DB;
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
ini_set('memory_limit', '512M');
//$m = new MongoClient();
//
//$visitsDb = $m->imemon;
//$collection = $visitsDb->publ_stat;
//
//$sort_field = 'pdf_count_sum';
//if($_POST[sortBy]=='sees') {
//    $sort_field = 'publ_count_sum';
//}

////////////// Авторы
//////
$rowsa=$DB->select(
    "SELECT '0' AS id,avtor AS fio FROM publ GROUP BY avtor UNION SELECT '0' AS id,people AS fio FROM adm_article WHERE page_template='jarticle' GROUP BY people");

$persons = $DB->select("SELECT p.id AS ARRAY_KEYS, p.id, CONCAT(p.surname,' ',substring(p.name,1,1),'.',substring(p.fname,1,1),'.') AS fio FROM persons AS p");

foreach($rowsa as $row)
{

    $str0=explode("<br>",$row[fio]);
//  	 	echo "<hr />".$row[fio];

    foreach($str0 as $str)
    {
        $t=trim($str);

        if (!empty($t) && $t!='Коллектив авторов') {
            if (!is_numeric($t)) {
                if (substr($t, 0, 1) <= "Z")
                    $fio_en[$t][id] = 0;
                else
                    $fio[$t][id] = 0;
//  	 			  $fio[$t][fio]=$t;
            } else {
                if (substr($persons[$t][fio],0,1)<="Z")
                {
                    $fio_en[$persons[$t][fio]][id]=$persons[$t][id];
                }
                else
                {
                    $fio[$persons[$t][fio]][id]=$persons[$t][id];
                }
            }
        }
    }

}

ksort($fio);
ksort($fio_en);



$sort_field = 'pdf_count';
if($_POST[sortBy]=='sees') {
    $sort_field = 'publ_count';
}

$module = 'publ';

if($_POST[module]=='article') {
    $module = 'article';
}

//$cursor = $collection->aggregate(
//    array('$match' =>
//        array('module' =>
//            array('$in' =>
//                array($module, '')))),
//    array('$group' =>
//        array( '_id' => '$publ_id', 'pdf_count_sum' =>
//            array('$sum' => '$pdf_count'), 'publ_count_sum' =>
//            array('$sum' => '$publ_count'))),
//    array('$sort' =>
//        array($sort_field => -1)));

//$publStats = $DB->select("
//SELECT SUM(pdf_count) AS pdf_count_sum, SUM(publ_count) AS publ_count_sum,CONCAT(`year`,IF(LENGTH(`month`)=1,CONCAT('0',`month`),`month`)),publ_stat.*
//FROM `publ_stat`
//WHERE module=? OR module=''
//GROUP BY publ_id
//ORDER BY SUM(".$sort_field.") DESC",$module);

$limit = (int)$_POST[limit];
if(empty($limit)) {
    $limit = 100;
}
if($_POST[limit]=='all') {
    $limit = 999999;
}

$seeYearMonthFrom = '0';
$seeYearMonthTo = '999999';

if(!empty($_POST['seeMonthFrom']) && !empty($_POST['seeYearFrom']) && $_POST['seeAll']!='on') {
    if(strlen($_POST['seeMonthFrom'])==2 && strlen($_POST['seeYearFrom'])==4) {
        $seeYearMonthFrom = $_POST['seeYearFrom'].$_POST['seeMonthFrom'];
    }
}

if(!empty($_POST['seeMonthTo']) && !empty($_POST['seeYearTo']) && $_POST['seeAll']!='on') {
    if(strlen($_POST['seeMonthTo'])==2 && strlen($_POST['seeYearTo'])==4) {
        $seeYearMonthTo = $_POST['seeYearTo'].$_POST['seeMonthTo'];
    }
}

$publishedFrom = '1900-01-01';
$publishedTo = '9999-12-31';

if(!empty($_POST['publishedMonthFrom']) && !empty($_POST['publishedYearFrom']) && $_POST['publishedAll']!='on') {
    if(strlen($_POST['publishedMonthFrom'])==2 && strlen($_POST['publishedYearFrom'])==4) {
        $publishedFrom = $_POST['publishedYearFrom'].'-'.$_POST['publishedMonthFrom'].'-'.'01';
    }
}

if(!empty($_POST['publishedMonthTo']) && !empty($_POST['publishedYearTo']) && $_POST['publishedAll']!='on') {
    if(strlen($_POST['publishedMonthTo'])==2 && strlen($_POST['publishedYearTo'])==4) {
        $publishedTo = $_POST['publishedYearTo'].'-'.$_POST['publishedMonthTo'].'-'.'31';
    }
}

$yearPublishedYearFrom = '1900';
$yearPublishedYearTo = '9999';

if(!empty($_POST['yearPublishedYearFrom']) && $_POST['yearPublishedAll']!='on') {
    if(strlen($_POST['yearPublishedYearFrom'])==4) {
        $yearPublishedYearFrom = $_POST['yearPublishedYearFrom'];
    }
}

if(!empty($_POST['yearPublishedYearTo']) && $_POST['yearPublishedAll']!='on') {
    if(strlen($_POST['yearPublishedYearTo'])==4) {
        $yearPublishedYearTo = $_POST['yearPublishedYearTo'];
    }
}

$idAuthor1 = '%';
$idAuthor2 = '%';
$idAuthor3 = '%';
$strAuthor = '%';

if (!empty($_POST[sfio]))
{
    $a=explode("#",$_POST[sfio]);
    if ($a[0]==0)
        $strAuthor='%'.$a[1].'%';
    else
    {
        $idAuthor1 = (int)$a[0].'<br>%';
        $idAuthor2 = '%<br>'.(int)$a[0].'<br>%';
        $idAuthor3 = '%<br>'.(int)$a[0];
    }

}

$rubric = '%';

if(!empty($_POST[rub])) {
    $rubric = (int)$_POST[rub];
}

if($_POST['noSees']=='on') {
    if($_POST[module]=='publ' || empty($_POST[module])) {
        $publs = $DB->select("
SELECT publ_id 
FROM publ_stat AS ps 
WHERE (`module`='' OR `module`='publ') 
AND ps.publ_id>0 
AND CONCAT(ps.`year`,IF(LENGTH(ps.`month`)=1,CONCAT('0',ps.`month`),ps.`month`))>=? 
AND CONCAT(ps.`year`,IF(LENGTH(ps.`month`)=1,CONCAT('0',ps.`month`),ps.`month`))<=? 
GROUP BY publ_id", $seeYearMonthFrom, $seeYearMonthTo);
        $publIds = array('0');
        foreach ($publs as $publ) {
            $publIds[] = $publ['publ_id'];
        }
        //var_dump($publs);
        $publStats = $DB->select("
SELECT 0 AS pdf_count_sum, 0 AS publ_count_sum, p.name, p.link, p.date AS date_p, p.year AS year_p, p.id AS publ_id, 'publ' AS module_s
FROM publ AS p 
WHERE p.id NOT IN (?a) 
AND p.status=1 
AND STR_TO_DATE(p.`date`,'%d.%m.%y')>=? 
AND STR_TO_DATE(p.`date`,'%d.%m.%y')<=? 
AND p.`year`>=? 
AND p.`year`<=? 
AND p.avtor LIKE ? 
AND ( p.avtor LIKE ? OR p.avtor LIKE ? OR p.avtor LIKE ?) 
    AND (p.rubric LIKE ? OR p.rubric2 LIKE ? OR p.rubric2d LIKE ? OR p.rubric2_3 LIKE ? OR p.rubric2_4 LIKE ? OR p.rubric2_5 LIKE ? ) 
ORDER BY p.name ASC LIMIT ?d
", $publIds, $publishedFrom, $publishedTo, $yearPublishedYearFrom, $yearPublishedYearTo, $strAuthor, $idAuthor1, $idAuthor2, $idAuthor3, $rubric, $rubric, $rubric, $rubric, $rubric, $rubric, $limit );
    }
    if($_POST[module]=='article') {
        $publs = $DB->select("
SELECT publ_id 
FROM publ_stat AS ps 
WHERE (`module`='' OR `module`='article') 
AND ps.publ_id>0 
AND CONCAT(ps.`year`,IF(LENGTH(ps.`month`)=1,CONCAT('0',ps.`month`),ps.`month`))>=? 
AND CONCAT(ps.`year`,IF(LENGTH(ps.`month`)=1,CONCAT('0',ps.`month`),ps.`month`))<=? 
GROUP BY publ_id", $seeYearMonthFrom, $seeYearMonthTo);
        $publIds = array('0');
        foreach ($publs as $publ) {
            $publIds[] = $publ['publ_id'];
        }

        $publsAfjournal = $DB->select("
SELECT publ_id 
FROM publ_stat AS ps 
WHERE (`module`='afjourn') 
AND ps.publ_id>0 
AND CONCAT(ps.`year`,IF(LENGTH(ps.`month`)=1,CONCAT('0',ps.`month`),ps.`month`))>=? 
AND CONCAT(ps.`year`,IF(LENGTH(ps.`month`)=1,CONCAT('0',ps.`month`),ps.`month`))<=? 
GROUP BY publ_id", $seeYearMonthFrom, $seeYearMonthTo);
        $publIdsAfjournal = array('0');
        foreach ($publsAfjournal as $publ) {
            $publIdsAfjournal[] = $publ['publ_id'];
        }

        $publStats = $DB->select("
SELECT * FROM (
SELECT 0 AS pdf_count_sum, 0 AS publ_count_sum, p.name, p.link, p.date AS date_p, p.year AS year_p, p.page_id AS publ_id, 'article' AS module_s
FROM adm_article AS p 
WHERE p.page_id NOT IN (?a) 
AND p.page_template = 'jarticle' 
AND (p.date_public<>'' 
AND p.page_status=1) 
AND STR_TO_DATE(p.`date_public`,'%Y.%m.%d')>=? 
AND STR_TO_DATE(p.`date_public`,'%Y.%m.%d')<=? 
AND p.`year`>=? 
AND p.`year`<=? 
AND p.people LIKE ? 
AND ( p.people LIKE ? OR p.people LIKE ? OR p.people LIKE ?) 
UNION 
SELECT 0 AS pdf_count_sum, 0 AS publ_count_sum, t.cv_text AS name, pdf.cv_text AS link, n.date_created AS date_p, y.page_name AS year_p, p.page_id AS publ_id, 'afjourn' AS module_s
FROM afjourn.`adm_pages` AS p
INNER JOIN afjourn.adm_pages_content AS t ON t.page_id=p.page_id AND t.cv_name='TITLE'
INNER JOIN afjourn.adm_pages_content AS peop ON peop.page_id=p.page_id AND peop.cv_name='PEOPLE'
INNER JOIN afjourn.adm_pages_content AS pdf ON pdf.page_id=p.page_id AND pdf.cv_name='LINK_PDF'
INNER JOIN afjourn.adm_pages AS r ON p.page_parent=r.page_id
INNER JOIN afjourn.adm_pages AS n ON r.page_parent=n.page_id
INNER JOIN afjourn.adm_pages AS y ON n.page_parent=y.page_id
WHERE p.page_id NOT IN (?a)
AND (n.date_created<>'' 
AND p.page_status=1) 
AND STR_TO_DATE(p.`date_created`,'%Y.%m.%d')>=? 
AND STR_TO_DATE(p.`date_created`,'%Y.%m.%d')<=? 
AND y.page_name>=? 
AND y.page_name<=? 
AND peop.cv_text LIKE ? 
AND ( peop.cv_text LIKE ? OR peop.cv_text LIKE ? OR peop.cv_text LIKE ?) ) as pptpprny
ORDER BY name ASC LIMIT ?d
", $publIds, $publishedFrom, $publishedTo, $yearPublishedYearFrom, $yearPublishedYearTo, $strAuthor, $idAuthor1, $idAuthor2, $idAuthor3, $publIdsAfjournal, $publishedFrom, $publishedTo, $yearPublishedYearFrom, $yearPublishedYearTo, $strAuthor, $idAuthor1, $idAuthor2, $idAuthor3, $limit );
    }
} else {
    if($_POST[module]=='publ' || empty($_POST[module])) {
        $publStats = $DB->select("
    SELECT SUM(ps.pdf_count) AS pdf_count_sum, SUM(ps.publ_count) AS publ_count_sum,p.name,p.link,p.date AS date_p,p.year AS year_p,'publ' AS module_s,ps.* 
    FROM `publ_stat` AS ps 
    INNER JOIN `publ` AS p ON p.id=ps.publ_id
    WHERE (ps.module=? OR ps.module='') 
    AND p.status=1 AND ps.publ_id>0 
    AND CONCAT(ps.`year`,IF(LENGTH(ps.`month`)=1,CONCAT('0',ps.`month`),ps.`month`))>=? 
    AND CONCAT(ps.`year`,IF(LENGTH(ps.`month`)=1,CONCAT('0',ps.`month`),ps.`month`))<=? 
    AND STR_TO_DATE(p.`date`,'%d.%m.%y')>=? 
    AND STR_TO_DATE(p.`date`,'%d.%m.%y')<=? 
    AND p.`year`>=? 
    AND p.`year`<=? 
    AND p.avtor LIKE ? 
    AND ( p.avtor LIKE ? OR p.avtor LIKE ? OR p.avtor LIKE ?) 
    AND (p.rubric LIKE ? OR p.rubric2 LIKE ? OR p.rubric2d LIKE ? OR p.rubric2_3 LIKE ? OR p.rubric2_4 LIKE ? OR p.rubric2_5 LIKE ? ) 
    GROUP BY ps.publ_id 
    ORDER BY SUM(" . $sort_field . ") DESC LIMIT ?d", $module, $seeYearMonthFrom, $seeYearMonthTo, $publishedFrom, $publishedTo, $yearPublishedYearFrom, $yearPublishedYearTo, $strAuthor, $idAuthor1, $idAuthor2, $idAuthor3, $rubric, $rubric, $rubric, $rubric, $rubric, $rubric, $limit);
    }
    if($_POST[module]=='article') {

        $publStats = $DB->select("
    SELECT * FROM (SELECT SUM(ps.pdf_count) AS pdf_count_sum, SUM(ps.publ_count) AS publ_count_sum,p.name,p.date AS date_p,p.year AS year_p,p.link,'article' AS module_s, p.page_id AS publ_id, ps.pdf_count, ps.publ_count
    FROM `publ_stat` AS ps 
    INNER JOIN `adm_article` AS p ON p.page_id=ps.publ_id AND p.page_template='jarticle'
    WHERE (ps.module=? OR ps.module='') 
    AND (p.date_public<>'' 
    AND p.page_status=1) 
    AND ps.publ_id>0 
    AND CONCAT(ps.`year`,IF(LENGTH(ps.`month`)=1,CONCAT('0',ps.`month`),ps.`month`))>=? 
    AND CONCAT(ps.`year`,IF(LENGTH(ps.`month`)=1,CONCAT('0',ps.`month`),ps.`month`))<=? 
    AND STR_TO_DATE(p.`date_public`,'%Y.%m.%d')>=? 
    AND STR_TO_DATE(p.`date_public`,'%Y.%m.%d')<=? 
    AND p.`year`>=? 
    AND p.`year`<=? 
    AND p.people LIKE ? 
    AND ( p.people LIKE ? OR p.people LIKE ? OR p.people LIKE ?) 
    GROUP BY ps.publ_id 
    UNION 
    SELECT SUM(ps.pdf_count) AS pdf_count_sum, SUM(ps.publ_count) AS publ_count_sum,t.cv_text AS name,n.date_created AS date_p,y.page_name AS year_p,pdf.cv_text AS link,'afjourn' AS module_s, p.page_id AS publ_id, ps.pdf_count, ps.publ_count
    FROM `publ_stat` AS ps 
    INNER JOIN afjourn.`adm_pages` AS p ON p.page_id=ps.publ_id
    INNER JOIN afjourn.adm_pages_content AS t ON t.page_id=p.page_id AND t.cv_name='TITLE'
    INNER JOIN afjourn.adm_pages_content AS peop ON peop.page_id=p.page_id AND peop.cv_name='PEOPLE'
    INNER JOIN afjourn.adm_pages_content AS pdf ON pdf.page_id=p.page_id AND pdf.cv_name='LINK_PDF'
    INNER JOIN afjourn.adm_pages AS r ON p.page_parent=r.page_id
    INNER JOIN afjourn.adm_pages AS n ON r.page_parent=n.page_id
    INNER JOIN afjourn.adm_pages AS y ON n.page_parent=y.page_id
    WHERE (ps.module='afjourn') 
    AND (n.date_created<>'' 
    AND p.page_status=1) 
    AND ps.publ_id>0 
    AND CONCAT(ps.`year`,IF(LENGTH(ps.`month`)=1,CONCAT('0',ps.`month`),ps.`month`))>=? 
    AND CONCAT(ps.`year`,IF(LENGTH(ps.`month`)=1,CONCAT('0',ps.`month`),ps.`month`))<=? 
    AND STR_TO_DATE(p.`date_created`,'%Y.%m.%d')>=? 
    AND STR_TO_DATE(p.`date_created`,'%Y.%m.%d')<=? 
    AND y.page_name>=? 
    AND y.page_name<=? 
    AND peop.cv_text LIKE ? 
    AND ( peop.cv_text LIKE ? OR peop.cv_text LIKE ? OR peop.cv_text LIKE ?) 
    GROUP BY ps.publ_id) as pppptpprny 
    ORDER BY ".$sort_field."_sum DESC LIMIT ?d", $module, $seeYearMonthFrom, $seeYearMonthTo, $publishedFrom, $publishedTo, $yearPublishedYearFrom, $yearPublishedYearTo, $strAuthor, $idAuthor1, $idAuthor2, $idAuthor3, $seeYearMonthFrom, $seeYearMonthTo, $publishedFrom, $publishedTo, $yearPublishedYearFrom, $yearPublishedYearTo, $strAuthor, $idAuthor1, $idAuthor2, $idAuthor3, $limit);
    }
}

$seeAll = 0;
$downlAll = 0;

$pg=new Directories();

$rub0=$pg->getDirectoryRubrics("Рубрики в публикациях");


?>

<div class="mb-3">
    <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
            <div class="row">
                <div class="col-6 col-md-2">
                    <h5>Выводить:</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="limit" id="gridRadios1" value="100"<?php if($_POST[limit]==100 || empty($_POST[limit])) echo ' checked'; ?>>
                        <label class="form-check-label" for="gridRadios1">
                            Top 100
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="limit" id="gridRadios2" value="500"<?php if($_POST[limit]==500) echo ' checked'; ?>>
                        <label class="form-check-label" for="gridRadios2">
                            Top 500
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="limit" id="gridRadios3" value="all"<?php if($_POST[limit]=='all') echo ' checked'; ?>>
                        <label class="form-check-label" for="gridRadios3">
                            Все
                        </label>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="form-group">
                        <label for="sortBy">Сортировка по</label>
                        <select id="sortBy" class="form-control" name="sortBy">
                            <option value="downl"<?php if($_POST[sortBy]=='downl' || empty($_POST[sortBy])) echo ' selected'; ?>>Количеству скачиваний</option>
                            <option value="sees"<?php if($_POST[sortBy]=='sees') echo ' selected'; ?> >Просмотрам</option>
                        </select>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="form-group">
                        <label for="module">Модуль</label>
                        <select id="module" class="form-control" name="module">
                            <option value="publ"<?php if($_POST[module]=='publ' || empty($_POST[module])) echo ' selected'; ?>>Публикации</option>
                            <option value="article"<?php if($_POST[module]=='article') echo ' selected'; ?> >Статьи в журнале</option>
                        </select>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="form-group">
                        <label for="sfio">Автор</label>
                        <select id="sfio" class="form-control" name="sfio">
                            <?php
                            echo "<option value=''></option>";
                            foreach($fio as $k=>$f)
                            {
                                if ($_POST[sfio]==$f[id]."#".$k) $sel=" selected "	; else $sel="";
                                echo "<option value='".$f[id]."#".$k."' ".$sel.">".$k."</option>";
                            }
                            foreach($fio_en as $k=>$f)
                            {
                                if ($_POST[sfio]==$f[id]."#".$k) $sel=" selected "	; else $sel="";
                                echo "<option value='".$f[id]."#".$k."'".$sel.">".$k."</option>";
                            }?>
                        </select>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="form-group">
                        <label for="rub">Рубрика (публикации)</label>
                        <select id="rub" class="form-control" name="rub">
                            <?php
                            echo "<option value=''></option>";
                            foreach($rub0 as $rub)
                            {
                                if($rub[id]==$_POST[rub]) $sel=" selected "; else $sel="";
                                if (strlen($rub[name]) >30) $sym="...";else $sym="";
                                echo "<option title='".$rub[text]."' value=".$rub[id].$sel.">".substr($rub[text],0,30).$sym."</option>";
                            }?>
                        </select>
                    </div>
                </div>
            </div>
        <hr>
        <div class="row">
            <div class="col-12 col-md-6">
                <h5>Просмотрены за</h5>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="seeAll" name="seeAll" <?php if($_POST['seeAll']=='on' || (empty($_POST['seeAll']) && empty($_POST['seeMonthFrom']))) echo 'checked';?>>
                        <label class="form-check-label" for="seeAll">
                            Все время
                        </label>
                    </div>
                </div>
                <div class="form-row seeRow">
                    <div class="form-group col-md">
                        <label for="seeMonthFrom">Месяц от</label>
                        <select id="seeMonthFrom" class="form-control" name="seeMonthFrom" <?php if($_POST['seeAll']=='on' || (empty($_POST['seeAll']) && empty($_POST['seeMonthFrom']))) echo 'disabled';?>>
                            <?php for ($i=1;$i<=12;$i++):?>
                                <option value="<?php if(strlen($i)==1) echo '0'.$i; else echo $i;?>" <?php if((int)$_POST['seeMonthFrom']==$i) echo 'selected';?>><?=Dreamedit::rus_get_month_name($i)?></option>
                            <?php endfor;?>
                        </select>
                    </div>
                    <div class="form-group col-md">
                        <label for="seeYearFrom">Год от</label>
                        <select id="seeYearFrom" class="form-control" name="seeYearFrom" <?php if($_POST['seeAll']=='on' || (empty($_POST['seeAll']) && empty($_POST['seeMonthFrom']))) echo 'disabled';?>>
                            <?php
                            for($i=(int)date('Y');$i>=1900;$i--):?>
                                <option <?php if($_POST['seeYearFrom']==$i) echo 'selected'?>><?=$i?></option>
                            <?php
                            endfor;
                            ?>
                        </select>
                    </div>

                    <div class="form-group col-md">
                        <label for="seeMonthTo">Месяц до</label>
                        <select id="seeMonthTo" class="form-control" name="seeMonthTo" <?php if($_POST['seeAll']=='on' || (empty($_POST['seeAll']) && empty($_POST['seeMonthFrom']))) echo 'disabled';?>>
                            <?php for ($i=1;$i<=12;$i++):?>
                                <option value="<?php if(strlen($i)==1) echo '0'.$i; else echo $i;?>" <?php if((int)$_POST['seeMonthTo']==$i) echo 'selected';?>><?=Dreamedit::rus_get_month_name($i)?></option>
                            <?php endfor;?>
                        </select>
                    </div>
                    <div class="form-group col-md">
                        <label for="seeYearTo">Год до</label>
                        <select id="seeYearTo" class="form-control" name="seeYearTo" <?php if($_POST['seeAll']=='on' || (empty($_POST['seeAll']) && empty($_POST['seeMonthFrom']))) echo 'disabled';?>>
                            <?php
                            for($i=(int)date('Y');$i>=1900;$i--):?>
                                <option <?php if($_POST['seeYearTo']==$i) echo 'selected'?>><?=$i?></option>
                            <?php
                            endfor;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="noSees" name="noSees" <?php if($_POST['noSees']=='on') echo 'checked';?>>
                        <label class="form-check-label" for="noSees">
                            Ни разу не просмотрены
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <h5>Поступили в каталог</h5>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="publishedAll" name="publishedAll" <?php if($_POST['publishedAll']=='on' || (empty($_POST['publishedAll']) && empty($_POST['publishedMonthFrom']))) echo 'checked';?>>
                        <label class="form-check-label" for="publishedAll">
                            За все время
                        </label>
                    </div>
                </div>
                <div class="form-row publishedRow">
                    <div class="form-group col-md">
                        <label for="publishedMonthFrom">Месяц от</label>
                        <select id="publishedMonthFrom" class="form-control" name="publishedMonthFrom" <?php if($_POST['publishedAll']=='on' || (empty($_POST['publishedAll']) && empty($_POST['publishedMonthFrom']))) echo 'disabled';?>>
                            <?php for ($i=1;$i<=12;$i++):?>
                                <option value="<?php if(strlen($i)==1) echo '0'.$i; else echo $i;?>" <?php if((int)$_POST['publishedMonthFrom']==$i) echo 'selected';?>><?=Dreamedit::rus_get_month_name($i)?></option>
                            <?php endfor;?>
                        </select>
                    </div>
                    <div class="form-group col-md">
                        <label for="publishedYearFrom">Год от</label>
                        <select id="publishedYearFrom" class="form-control" name="publishedYearFrom" <?php if($_POST['publishedAll']=='on' || (empty($_POST['publishedAll']) && empty($_POST['publishedMonthFrom']))) echo 'disabled';?>>
                            <?php
                            for($i=(int)date('Y');$i>=1900;$i--):?>
                                <option <?php if($_POST['publishedYearFrom']==$i) echo 'selected'?>><?=$i?></option>
                            <?php
                            endfor;
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md">
                        <label for="publishedMonthTo">Месяц до</label>
                        <select id="publishedMonthTo" class="form-control" name="publishedMonthTo" <?php if($_POST['publishedAll']=='on' || (empty($_POST['publishedAll']) && empty($_POST['publishedMonthFrom']))) echo 'disabled';?>>
                            <?php for ($i=1;$i<=12;$i++):?>
                                <option value="<?php if(strlen($i)==1) echo '0'.$i; else echo $i;?>" <?php if((int)$_POST['publishedMonthTo']==$i) echo 'selected';?>><?=Dreamedit::rus_get_month_name($i)?></option>
                            <?php endfor;?>
                        </select>
                    </div>
                    <div class="form-group col-md">
                        <label for="publishedYearTo">Год до</label>
                        <select id="publishedYearTo" class="form-control" name="publishedYearTo" <?php if($_POST['publishedAll']=='on' || (empty($_POST['publishedAll']) && empty($_POST['publishedMonthFrom']))) echo 'disabled';?>>
                            <?php
                            for($i=(int)date('Y');$i>=1900;$i--):?>
                                <option <?php if($_POST['publishedYearTo']==$i) echo 'selected'?>><?=$i?></option>
                            <?php
                            endfor;
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <h5>Год выпуска</h5>
        <div class="form-group">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="yearPublishedAll" name="yearPublishedAll" <?php if($_POST['yearPublishedAll']=='on' || (empty($_POST['yearPublishedAll']) && empty($_POST['yearPublishedYearFrom']))) echo 'checked';?>>
                <label class="form-check-label" for="yearPublishedAll">
                    За все время
                </label>
            </div>
        </div>
        <div class="form-row yearPublishedRow">
            <div class="form-group col-md">
                <label for="yearPublishedYearFrom">Год от</label>
                <select id="yearPublishedYearFrom" class="form-control" name="yearPublishedYearFrom" <?php if($_POST['yearPublishedAll']=='on' || (empty($_POST['yearPublishedAll']) && empty($_POST['yearPublishedYearFrom']))) echo 'disabled';?>>
                    <?php
                    for($i=(int)date('Y');$i>=1900;$i--):?>
                        <option <?php if($_POST['yearPublishedYearFrom']==$i) echo 'selected'?>><?=$i?></option>
                    <?php
                    endfor;
                    ?>
                </select>
            </div>
            <div class="form-group col-md">
                <label for="yearPublishedYearTo">Год до</label>
                <select id="yearPublishedYearTo" class="form-control" name="yearPublishedYearTo" <?php if($_POST['yearPublishedAll']=='on' || (empty($_POST['yearPublishedAll']) && empty($_POST['yearPublishedYearFrom']))) echo 'disabled';?>>
                    <?php
                    for($i=(int)date('Y');$i>=1900;$i--):?>
                        <option <?php if($_POST['yearPublishedYearTo']==$i) echo 'selected'?>><?=$i?></option>
                    <?php
                    endfor;
                    ?>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary imemo-button text-uppercase">Показать</button>
    </form>
</div>

<div class="table-responsive">
    <table class="table" id="publ_stat_table">
        <thead class="thead-dark">
        <tr>
            <th scope="col" class="bg-color-imemo">Просм.</th>
            <th scope="col" class="bg-color-imemo">Скачано</th>
            <th scope="col" class="bg-color-imemo">Библиографичеcкая ссылка</th>
            <th scope="col" class="bg-color-imemo">Год</th>
            <th scope="col" class="bg-color-imemo">Дата</th>
            <th scope="col" class="bg-color-imemo">pdf</th>
            <th scope="col" class="bg-color-imemo">Подробнее</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($publStats as $el):
            $dateP = $el['date_p'];
            if($el['module_s']=='afjourn') {
                try {
                    $dt = date_create_from_format("Y.m.d H:i", $el['date_p']);
                    $dateP = $dt->format('Ymd');
                } catch (Exception $e) {
                }
            }
            $seeAll+=$el['publ_count_sum'];
            $downlAll+=$el['pdf_count_sum'];
            ?>
        <tr>
            <td><?=$el['publ_count_sum']?></td>
            <td><?=$el['pdf_count_sum']?></td>
            <td><?=$el['name']?></td>
            <td><?=$el['year_p']?></td>
            <td><?=$dateP?></td>
            <td class="text-center"><?php if (strpos($el['link'],".pdf")>0) echo '<i class="fas fa-check text-success"></i>';?></td>
            <td class="text-center"><a target="_blank" href="/index.php?page_id=<?php if($el['module_s']=='publ') echo '838'; if($el['module_s']=='article' || $el['module_s']=='afjourn') echo '1882';?>&id=<?=$el['publ_id']?><?php if($el['module_s']=='afjourn') echo '&ap=1';?>"><i class="fas fa-link text-info"></i></a></td>
        </tr>
        <?php
        endforeach;?>
        </tbody>
    </table>
</div>
    <hr>
<div>
    <h5>Просмотров в сумме: <b><?=$seeAll?></b></h5>
</div>
<div>
    <h5>Скачиваний в сумме: <b><?=$downlAll?></b></h5>
</div>

    <script>
        $("#seeAll").change(function() {
            if(this.checked) {
                $('.seeRow').find('select').attr('disabled', true);
            } else {
                $('.seeRow').find('select').attr('disabled', false);
            }
        });
        $("#publishedAll").change(function() {
            if(this.checked) {
                $('.publishedRow').find('select').attr('disabled', true);
            } else {
                $('.publishedRow').find('select').attr('disabled', false);
            }
        });
        $("#yearPublishedAll").change(function() {
            if(this.checked) {
                $('.yearPublishedRow').find('select').attr('disabled', true);
            } else {
                $('.yearPublishedRow').find('select').attr('disabled', false);
            }
        });
    </script>

    <script>
        function sortTableStat(n, numeric=false) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("publ_stat_table");
            switching = true;
            // Set the sorting direction to ascending:
            dir = "asc";
            /* Make a loop that will continue until
            no switching has been done: */
            while (switching) {
                // Start by saying: no switching is done:
                switching = false;
                rows = table.rows;
                /* Loop through all table rows (except the
                first, which contains table headers): */
                for (i = 1; i < (rows.length - 1); i++) {
                    // Start by saying there should be no switching:
                    shouldSwitch = false;
                    /* Get the two elements you want to compare,
                    one from current row and one from the next: */
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];
                    /* Check if the two rows should switch place,
                    based on the direction, asc or desc: */
                    if (dir == "asc") {
                        if(numeric) {
                            if (Number(x.innerHTML) > Number(y.innerHTML)) {
                                //if so, mark as a switch and break the loop:
                                shouldSwitch = true;
                                break;
                            }
                        } else {
                            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                                // If so, mark as a switch and break the loop:
                                shouldSwitch = true;
                                break;
                            }
                        }


                    } else if (dir == "desc") {
                        if(numeric) {
                            if (Number(x.innerHTML) < Number(y.innerHTML)) {
                                //if so, mark as a switch and break the loop:
                                shouldSwitch = true;
                                break;
                            }
                        } else {
                            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                                // If so, mark as a switch and break the loop:
                                shouldSwitch = true;
                                break;
                            }
                        }
                    }

                }
                if (shouldSwitch) {
                    /* If a switch has been marked, make the switch
                    and mark that a switch has been done: */
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    // Each time a switch is done, increase this count by 1:
                    switchcount ++;
                } else {
                    /* If no switching has been done AND the direction is "asc",
                    set the direction to "desc" and run the while loop again. */
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }
    </script>

<?php

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");

