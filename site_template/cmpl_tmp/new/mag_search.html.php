<?php
global $_CONFIG, $site_templater;
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

if($_SESSION['lang']!="/en") {
    $searchText = "Поиск:";
    $notEnoughSymbols = "Для поиска введите больше символов";
    $articleNameSearch = "Поиск по названию статьи:";
    $articleKeywordSearch = "Поиск по ключевым словам:";
    $authorSearch = "Поиск по автору:";
    $nothingFound = "Ничего не найдено";
    $postFix = "";
} else {
    $searchText = "Search:";
    $notEnoughSymbols = "Please enter more characters to search";
    $articleNameSearch = "Search by article name:";
    $articleKeywordSearch = "Search by article keywords:";
    $authorSearch = "Search by author:";
    $nothingFound = "Nothing found";
    $postFix = "_en";
}

$search=iconv('cp1251','UTF-8',$_GET['search']);

$mz = new MagazineNew();
$persons = new Persons();

$searchArticles = array();

if(strlen($_GET['search'])>2) {
    $searchArticlesByName = $mz->searchArticleByName($_GET['search'],'name',$_TPL_REPLACMENT['MAIN_JOUR_ID'], $postFix);
    $searchArticlesByName = $mz->performStrongFoundText($searchArticlesByName, $postFix, $search, 'name');
    $searchArticlesByKeyword = $mz->searchArticleByKeyword($_GET['search'],'keyword',$_TPL_REPLACMENT['MAIN_JOUR_ID'], $postFix);
    $searchArticlesByKeyword = $mz->performStrongFoundText($searchArticlesByKeyword, $postFix, $search, 'keyword');
    $personsSearch = $persons->searchPerson($_GET['search']);

    foreach ($personsSearch as $key=>$person) {
        $authorArticles = $mz->getAuthorsArticleById($person['id'], $_TPL_REPLACMENT['MAIN_JOUR_ID']);

        if(empty($authorArticles)) {
            unset($personsSearch[$key]);
        }
    }
}

?>

<h3><?=$searchText?> <?=$_GET['search']?></h3>
<?php if(strlen($_GET['search'])>2):?>
    <hr>

    <h4><?=$articleNameSearch?></h4>

    <?php

    if(empty($searchArticlesByName)) {
        echo "<div>$nothingFound</div>";
    }

    foreach ($searchArticlesByName as $article) {
        ?>
        <div><a href="<?=$_SESSION['lang']?>/index.php?page_id=<?=$_TPL_REPLACMENT['ARCHIVE_ID']?>&article_id=<?=$article['page_id']?>"><?=$article['b_text']?></a></div>
        <?php
    }

    ?>
    <hr>

    <h4><?=$articleKeywordSearch?></h4>

    <?php

    if(empty($searchArticlesByKeyword)) {
        echo "<div>$nothingFound</div>";
    }

    foreach ($searchArticlesByKeyword as $article) {
        ?>
        <div><a href="<?=$_SESSION['lang']?>/index.php?page_id=<?=$_TPL_REPLACMENT['ARCHIVE_ID']?>&article_id=<?=$article['page_id']?>"><?=$article['name'.$postFix]?></a></div>
        <?php
    }

    ?>
    <hr>

    <h4><?=$authorSearch?></h4>

    <?php

    if(empty($personsSearch)) {
        echo "<div>$nothingFound</div>";
    }

    foreach ($personsSearch as $person) {
        if($_SESSION['lang']!="/en") {
            $personName = "{$person['surname']} {$person['name']} {$person['fname']}";
        } else {
            if(!empty($person['LastName_EN'])) {
                $personName = "{$person['Name_EN']} {$person['LastName_EN']}";
            } else {
                $personName = "{$person['Autor_en']}";
            }
        }
        ?>
        <div><a href="<?=$_SESSION['lang']?>/index.php?page_id=<?=$_TPL_REPLACMENT["AUTHOR_ID"]?>&id=<?=$person['id']?>"><?=$personName?></a></div>
        <?php
    }

    //$mz->echoFoundText($searchArticlesByKeyword, $postFix, $search, $_TPL_REPLACMENT['ARCHIVE_ID'], 'keyword');


else:?>
    <h4 class="text-danger"><?=$notEnoughSymbols?></h4>
<?php endif;?>


<?php

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
