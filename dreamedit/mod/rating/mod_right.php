<?
include_once dirname(__FILE__)."/../../_include.php";
include_once "mod_fns.php";
global $DB;

function echoTable($news, $lang="") {
    ?>
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Название</th>
            <th scope="col">Количество</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($news as $news_element):
            $news_more_page = 502;
            if($news_element['type_id']==5)
                $news_more_page = 503;
            if(empty($news_element['title'])) {
                $news_element['title'] = "Нет названия";
            }
            ?>
            <tr>
                <th scope="row"><a target="_blank" href="<?=$lang?>/index.php?page_id=<?=$news_more_page?>&id=<?=(int)$news_element['news_id']?>"><?=$news_element['title']?></a></th>
                <td class="align-middle"><?=$news_element[sumviews]?></td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
<?php
}
?>
<link href="/newsite/css/bootstrap.min.css?v=2" rel="stylesheet">
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

        <?php if(empty($_GET['type'])):?>
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="/dreamedit/index.php?mod=rating&type=1" type="button" class="btn btn-secondary" style="height: auto">За все время</a>
                <a href="/dreamedit/index.php?mod=rating&type=2" type="button" class="btn btn-secondary" style="height: auto">Английская версия за интервал</a>
            </div>
        <?php elseif($_GET['type']==1):?>
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="/dreamedit/index.php?mod=rating" type="button" class="btn btn-secondary" style="height: auto">За интервал</a>
                <a href="/dreamedit/index.php?mod=rating&type=2" type="button" class="btn btn-secondary" style="height: auto">Английская версия за интервал</a>
            </div>
        <?php elseif($_GET['type']==2):?>
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="/dreamedit/index.php?mod=rating&type=1" type="button" class="btn btn-secondary" style="height: auto">За все время</a>
                <a href="/dreamedit/index.php?mod=rating" type="button" class="btn btn-secondary" style="height: auto">Русская версия за интервал</a>
            </div>
        <?php endif;?>
            <hr>
        </div>
    </div>
    <div class="row">
        <?php if(empty($_GET['type'])):?>
        <div class="col-4">
            <h3>Топ 50 новостей за день</h3>
            <?php echoTable(Statistic::getTopNews("0","",50,true));?>
        </div>
        <div class="col-4">
            <h3>Топ 50 новостей за неделю</h3>
            <?php echoTable(Statistic::getTopNews("7","",50,true));?>
        </div>
        <div class="col-4">
            <h3>Топ 50 новостей за месяц</h3>
            <?php echoTable(Statistic::getTopNews("30","",50,true));?>
        </div>
        <?php elseif($_GET['type']==1):?>
        <div class="col-6">
            <h3>Топ 50 новостей за все время</h3>
            <?php echoTable(Statistic::getTopNews("","",50,true));?>
        </div>
            <div class="col-6">
                <h3>Топ 50 новостей за все время(англ)</h3>
                <?php echoTable(Statistic::getTopNews("","-en",50,true), "/en");?>
            </div>
        <?php elseif($_GET['type']==2):?>
            <div class="col-4">
                <h3>Топ 50 новостей за день</h3>
                <?php echoTable(Statistic::getTopNews("0","-en",50,true), "/en");?>
            </div>
            <div class="col-4">
                <h3>Топ 50 новостей за неделю</h3>
                <?php echoTable(Statistic::getTopNews("7","-en",50,true), "/en");?>
            </div>
            <div class="col-4">
                <h3>Топ 50 новостей за месяц</h3>
                <?php echoTable(Statistic::getTopNews("30","-en",50,true), "/en");?>
            </div>
        <?php endif;?>
    </div>
</div>
