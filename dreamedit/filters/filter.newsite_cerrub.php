<?

global $DB,$_CONFIG;

if($_GET['cer_test']==1) {
    $manager = new CerSpecrubManager();

    if ($_SESSION[lang] != "/en") {
        $elements = $manager->getAllElements(1, 3);
    } else {
        $elements = $manager->getAllElements(1, 3, "en");
    }

    if (!empty($elements)) {
        echo '<div class="row position-relative overflow-hidden m-md-3 text-center justify-content-center">';
    }
    foreach ($elements as $element) {

        if ($_SESSION[lang] != "/en") {
            $img = $element->getImg();
            $title = $element->getTitle();
            $fulltext = $element->getFulltext();
        } else {
            $img = $element->getImgEn();
            $title = $element->getTitleEn();
            $fulltext = $element->getFulltextEn();
        }

        ?>
        <div class="col-lg-4 my-3<?php if (empty($img)) echo " my-auto"; ?>">
            <?php if (!empty($img)): ?>
                <div class="position-relative first-news-card">
                    <img class="card-img" src="/files/Image/cerspecrub/<?= $img ?>" alt="<?= htmlspecialchars($title) ?>">
                    <div class="position-absolute img-ton">
                        <div class="card-body text-white absolute-bottom w-100">
                            <a class="text-white"
                               href="<?= $_SESSION['lang'] ?>/index.php?page_id=1557&id=<?= $element->getId() ?>"><h5
                                        class="card-title card-comments-title"><?= $fulltext ?></h5></a>
                        </div>
                    </div>
                    <a href="<?= $_SESSION['lang'] ?>/index.php?page_id=1557&id=<?= $element->getId() ?>"
                       class="h-100 w-100 position-absolute overlay-top-left-null hover-highlight hover-highlight-center-dark"
                       draggable="true"></a>
                </div>
            <?php else: ?>
                <div class="w-100 first-news-card">
                    <a href="<?= $_SESSION['lang'] ?>/index.php?page_id=1557&id=<?= $element->getId() ?>"><h5
                                class="card-title card-comments-title"><?= $fulltext ?></h5></a>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
    if (!empty($elements)) {
        echo '</div>';
        ?>
        <div class="row">
            <div class="col-12 text-center">
                <div class="video-text mt-5 mb-3">
                    <a class="btn btn-lg imemo-button text-uppercase" href="<?=$_SESSION['lang']?>/index.php?page_id=1558" role="button"><?php if ($_SESSION[lang]!="/en") echo 'Все'; else echo "All";?></a>
                </div>
            </div>
        </div>
        <?php
    }
}
?>