<?php
global $DB;

if($_SESSION[lang]!="/en") {
    $rows = $DB->select("SELECT id,name COLLATE cp1251_general_ci AS name,STR_TO_DATE(date, '%d.%m.%y') AS date, picbig COLLATE cp1251_general_ci AS logo, picmain COLLATE cp1251_general_ci AS logo_slider, CONCAT('/index.php?page_id=645&id=',id) AS link, 'publ' AS type
FROM `publ`
WHERE status=1 AND no_publ_ofp=0 AND picbig<>''
UNION
SELECT aa.page_id AS id, CONCAT(am.page_name, '. Номер: ', aa.page_name, '. Год: ', aa.year) COLLATE cp1251_general_ci AS name, STR_TO_DATE(ac.cv_text, '%Y.%m.%d') AS date, logo.cv_text COLLATE cp1251_general_ci AS logo, logo_slider.cv_text COLLATE cp1251_general_ci AS logo_slider, CONCAT('/index.php?page_id=',IF(sl.cv_text<>'' AND sl.cv_text IS NOT NULL,CONCAT(sl.cv_text,'&article_id=',aa.page_id),am.page_id)) AS link, 'mag' AS type
FROM `adm_article` AS aa
INNER JOIN adm_article_content AS ac ON aa.page_id=ac.page_id AND ac.cv_name='DATE_PUBLIC'
LEFT JOIN adm_article_content AS so ON aa.page_id=so.page_id AND so.cv_name='SLIDER_OFF'
INNER JOIN adm_pages AS am ON aa.journal_new=am.page_id
INNER JOIN adm_pages_content AS logo ON am.page_id=logo.page_id AND logo.cv_name='LOGO'
INNER JOIN adm_pages_content AS logo_slider ON am.page_id=logo_slider.page_id AND logo_slider.cv_name='LOGO_SLIDER'
INNER JOIN adm_pages_content AS sl ON sl.page_id=am.page_id AND sl.cv_name='ARCHIVE_ID'
WHERE aa.page_template='jnumber' AND aa.page_status=1 AND (so.cv_text IS NULL OR so.cv_text = 0)
ORDER BY date DESC
LIMIT 6");
}
else {
    $rows = $DB->select("SELECT id,name2 COLLATE cp1251_general_ci AS name,STR_TO_DATE(date, '%d.%m.%y') AS date, picbig COLLATE cp1251_general_ci AS logo, picmain COLLATE cp1251_general_ci AS logo_slider, CONCAT('/index.php?page_id=645&id=',id) AS link, 'publ' AS type
FROM `publ`
WHERE status=1 AND no_publ_ofp=0 AND picbig<>''
UNION
SELECT aa.page_id AS id, CONCAT(am.page_name_en, '. Number: ', aa.page_name, '. Year: ', aa.year) COLLATE cp1251_general_ci AS name, STR_TO_DATE(ac.cv_text, '%Y.%m.%d') AS date, logo.cv_text COLLATE cp1251_general_ci AS logo, logo_slider.cv_text COLLATE cp1251_general_ci AS logo_slider, CONCAT('/index.php?page_id=',IF(sl.cv_text<>'' AND sl.cv_text IS NOT NULL,CONCAT(sl.cv_text,'&article_id=',aa.page_id),am.page_id)) AS link, 'mag' AS type
FROM `adm_article` AS aa
INNER JOIN adm_article_content AS ac ON aa.page_id=ac.page_id AND ac.cv_name='DATE_PUBLIC'
LEFT JOIN adm_article_content AS so ON aa.page_id=so.page_id AND so.cv_name='SLIDER_OFF'
INNER JOIN adm_pages AS am ON aa.journal_new=am.page_id
INNER JOIN adm_pages_content AS logo ON am.page_id=logo.page_id AND logo.cv_name='LOGO'
INNER JOIN adm_pages_content AS logo_slider ON am.page_id=logo_slider.page_id AND logo_slider.cv_name='LOGO_SLIDER'
INNER JOIN adm_pages_content AS sl ON sl.page_id=am.page_id AND sl.cv_name='ARCHIVE_ID'
WHERE aa.page_template='jnumber' AND aa.page_status=1 AND (so.cv_text IS NULL OR so.cv_text = 0)
ORDER BY date DESC
LIMIT 6");
}

if(!empty($rows)) {
    ?>
    <div class="col-12 col-sm-6 col-xl-12 pb-3">
        <div class="row position-relative">
            <div class="bookshelfimg w-100 mb-5 mb-xl-3">
                <img class="w-100 position-absolute shelf-element-text" src="/newsite/img/bookshelv.png" alt="">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">

    <?php
    $first_oup = true;
    $publications = new Publications();
    foreach ($rows as $row):
        preg_match_all( '@src="([^"]+)"@' , $row['logo_slider'], $imgSrc );
        $imgSrc = array_pop($imgSrc);
        if(empty($imgSrc)) {
            preg_match_all( '@src="([^"]+)"@' , $row['logo'], $imgSrc );
            $imgSrc = array_pop($imgSrc);
            if(empty($imgSrc)) {
                if (empty($row['logo'])) {
                    $image_url = '/dreamedit/pfoto/e_logo_slider.jpg';
                } else
                    $image_url = '/dreamedit/pfoto/'.$row['logo'];
            } else
                $image_url = $imgSrc[0];
        } else
            $image_url = $imgSrc[0];

        if($row['link']=="/jour/afjournal") {
            $row['link'] = '/index.php?page_id=1514';
        }

        $name = $row['name'];
        if($row['type']=='publ') {
            if ($_SESSION[lang] != '/en') {
                $name = $publications->getCitationLinkById($row['id']);
            }
        }

        ?>
        <div class="carousel-item<?php if($first_oup) { echo ' active'; $first_oup = false; }?>">
            <div class="row ml-2 mr-2 justify-content-center">
                <div class="col">
                    <div class="align-bottom text-center position-relative shelf-book">
                        <div class="book-text mx-auto" data-toggle="tooltip" data-placement="top" data-html="true" title="<?=$name?>"><a href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?><?=$row['link']?>"><img class="shadow" src="<?=$image_url?>" alt=""></a></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach;
}?>
                    </div>
                    <a class="carousel-control-prev imemo-color-control" href="#carouselExampleControls" role="button" data-slide="prev">
                        <i class="fas fa-3x fa-caret-left"></i>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next imemo-color-control" href="#carouselExampleControls" role="button" data-slide="next">
                        <i class="fas fa-3x fa-caret-right"></i>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
