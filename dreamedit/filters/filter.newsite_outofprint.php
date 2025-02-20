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
    $publications = new Publications();
 echo '<div class="row justify-content-center">';
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
     <div class="col-4 col-md-2 col-lg-1d5 mb-3 my-md-auto">
         <div class="align-bottom text-center position-relative shelf-book hover-highlight hover-highlight-center-dark">
             <div class="book shadow mx-auto" data-toggle="tooltip" data-placement="top" data-html="true" title="<?=$name?>"><a href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?><?=$row['link']?>"><img src="<?=$image_url?>" alt=""></a></div>
         </div>
     </div>
 <?php endforeach;
 echo '</div>';
}