<?php
global $DB,$_CONFIG,$page_content;
// Главная новость

$current_number = (int)$_GET['ajax_president_publs'];

if(!empty($_TPL_REPLACMENT["PERSON"])) {
    $person = (int)$_TPL_REPLACMENT["PERSON"];
    $personSql = " AND (avtor LIKE '".$person."<br>%' OR
                           avtor LIKE '%<br>".$person."<br>%' OR
                           avtor LIKE '%<br>".$person."' OR people_linked LIKE '".$person."<br>%' OR
                           people_linked LIKE '%<br>".$person."<br>%' OR
                           people_linked LIKE '%<br>".$person."')";
} else {
    $personSql = "";
}

$query = "SELECT id,name COLLATE cp1251_general_ci AS name,STR_TO_DATE(date, '%d.%m.%y') AS date, picbig COLLATE cp1251_general_ci AS logo, picmain COLLATE cp1251_general_ci AS logo_slider, CONCAT('/index.php?page_id=645&id=',id) AS link
 FROM publ WHERE 1=1".$personSql." ORDER BY year DESC LIMIT ?d, 12";
$rows = $DB->select($query,$current_number);

if(!empty($rows)) {
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

        ?>
        <div class="col-6 col-md-4 col-lg-4 mb-3 my-md-auto py-3 right-changable-4-2">
            <div class="align-bottom text-center position-relative shelf-book hover-highlight hover-highlight-center-dark">
                <div class="book shadow mx-auto" data-toggle="tooltip" data-placement="top" data-html="true" title="<?=$row['name']?>"><a target="_blank" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?><?=$row['link']?>"><img src="<?=$image_url?>" alt=""></a></div>
            </div>
        </div>
    <?php endforeach;
}

?>