<?php
include_once dirname(__FILE__)."/../../_include.php";

global $DB;
$m = new MongoClient();
$visitsDb = $m->imemon;
$visitsDailyCollection = $visitsDb->visits_daily;

$id = (int)$_GET['id'];

$filterRu = array(
    'magazine' => "newsfull-$id"
);
$filterEn = array(
    'magazine' => "newsfull-$id-en"
);

$searchByDate = "";
if(isset($_GET['search_by_date'])) {
    $searchByDate = " AND `date` = '{$_GET['search_by_date']}'";
    $filterRu['date'] = $_GET['search_by_date'];
    $filterEn['date'] = $_GET['search_by_date'];
}

if(isset($_POST['views'])) {
    $visitsDailyCollection->update($filterRu, array('$set' => array('views' => (int)$_POST['views'])));
    echo '<p>Сохранено</p>';
}

if(isset($_POST['views_en'])) {
    $visitsDailyCollection->update($filterEn, array('$set' => array('views' => (int)$_POST['views_en'])));
    echo '<p>Сохранено</p>';
}

$newsElement = $DB->select("SELECT *
FROM `adm_ilines_content`
WHERE `el_id` = ?d AND `icont_var` = 'title'", $id);

$newsRatingElement = $visitsDailyCollection->findOne($filterRu);
$newsRatingElementEn = $visitsDailyCollection->findOne($filterEn);

?>
    <p><b><?=$newsElement[0]['icont_text']?></b></p>
<?php
if(!empty($newsRatingElement)):
?>
<p>Редактирование рейтинга для русской версии сайта за <?=$newsRatingElement['date']?>:</p>
<form method="post">
    <input id="id" name="id" value="<?=$id?>" type="hidden" />
    <input id="date" name="date" value="<?=$newsRatingElement['date']?>" type="hidden" />
    <input id="views" name="views" type="text" value="<?=$newsRatingElement['views']?>" />
    <button type="submit" style="width: 100px">Сохранить</button>
</form>
<?php else: ?>
<p>Нет данных за эту дату для рейтинга на русской версии сайта</p>
<?php endif;

?>
<?php
if(!empty($newsRatingElementEn)):
    ?>
    <p>Редактирование рейтинга для английской версии сайта за <?=$newsRatingElementEn['date']?>:</p>
    <form method="post">
        <input id="id" name="id" value="<?=$id?>" type="hidden" />
        <input id="date" name="date" value="<?=$newsRatingElementEn['date']?>" type="hidden" />
        <input id="views_en" name="views_en" type="text" value="<?=$newsRatingElementEn['views']?>" />
        <button type="submit" style="width: 100px">Сохранить</button>
    </form>
<?php else: ?>
    <p>Нет данных за эту дату для рейтинга на английской версии сайта</p>
<?php endif;

?>

<p>Поиск по дате:</p>

<form method="get">
    <input id="mod" name="mod" value="<?=$_GET['mod']?>" type="hidden" />
    <input id="type" name="type" value="<?=$_GET['type']?>" type="hidden" />
    <input id="id" name="id" value="<?=$id?>" type="hidden" />
    <input id="action" name="action" value="<?=$_GET['action']?>" type="hidden" />
    <input id="search_by_date" name="search_by_date" type="date" />
    <button type="submit" style="width: 100px">Искать</button>
</form>
