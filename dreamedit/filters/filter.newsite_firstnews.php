<?

global $DB,$_CONFIG;

$news = new News();
$firstNews = $news->getFirstNews();

if(!empty($firstNews)) {
    echo '<div class="row position-relative overflow-hidden m-md-3 text-center justify-content-center">';
}
foreach ($firstNews as $key => $element) {
    $image = $element->getImageUrl();
    ?>
    <div class="col-lg-4 my-3<?php if(empty($image)) echo " my-auto";?>">
            <?php if(!empty($image)):?>
            <div class="position-relative first-news-card">
                <img class="card-img" src="<?=$image?>" alt="<?=$element->getImageAlt()?>">
                <div class="position-absolute img-ton">
                    <div class="card-body text-white absolute-bottom w-100">
                        <a class="text-white" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?>/index.php?page_id=1594&id=<?=$element->getId()?>"><h5 class="card-title card-comments-title"><?=$element->getTitle()?></h5></a>
                        <div class="mb-3 d-none d-xl-block">
                            <div class="text-center">
                                <?=$element->getAuthorsImagesStr()?>
                            </div>
                            <b class="font-italic"><?=$element->getAuthorsStr()?></b>
                        </div>
                    </div>
                </div>
                <a href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?>/index.php?page_id=1594&id=<?=$element->getId()?>" class="h-100 w-100 position-absolute overlay-top-left-null hover-highlight hover-highlight-center-dark" draggable="true"></a>
            </div>
            <?php else:?>
            <div class="w-100 first-news-card">
                <a href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?>/index.php?page_id=1594&id=<?=$element->getId()?>"><h5 class="card-title card-comments-title"><?=$element->getTitle()?></h5></a>
                <div class="mb-3 d-none d-xl-block">
                    <div class="text-center">
                        <?=$element->getAuthorsImagesStr()?>
                    </div>
                    <b class="font-italic"><?=$element->getAuthorsStr()?></b>
                </div>
            </div>
            <?php endif;?>
    </div>
    <?php
}
if(!empty($firstNews)) {
    echo '</div>';
    ?>
    <div class="row">
        <div class="col-12 text-center">
            <div class="video-text mt-3 mb-3">
                <a class="btn btn-lg imemo-button text-uppercase"
                   href="<?= $_CONFIG['new_prefix'] . $_SESSION['lang'] ?>/index.php?page_id=527"
                   role="button"><?php if ($_SESSION[lang] != "/en") echo 'Все комментарии'; else echo "All comments"; ?></a>
            </div>
        </div>
    </div>
    <?php
}
?>