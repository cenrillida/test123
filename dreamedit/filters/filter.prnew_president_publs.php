<?php
global $DB;

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

if($_SESSION[lang]!="/en") {
    $rows = $DB->select("SELECT id,name COLLATE cp1251_general_ci AS name,STR_TO_DATE(date, '%d.%m.%y') AS date, picbig COLLATE cp1251_general_ci AS logo, picmain COLLATE cp1251_general_ci AS logo_slider, CONCAT('/index.php?page_id=645&id=',id) AS link
 FROM publ WHERE 1=1".$personSql." ORDER BY year DESC LIMIT 6");
}

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



<div class="d-flex justify-content-center president-publs-loader-main">
    <div class="spinner-border president-publs-loader mt-5" role="status" style="display: none">
        <span class="sr-only">Loading...</span>
    </div>
</div>


<div class="col-12 py-3 more-button-president-publs text-center">
    <div class="pr-red-title-a-main"><button class="pr-red-title-a pl-2 pr-2" target="_blank"><i class="fas fa-chevron-down"></i></button> <button class="pr-red-title-a-back president-publs-ajax" target="_blank"><i class="fas fa-chevron-down"></i></button></div>
</div>

<script>
    president_publs_count = 6;
    $( ".president-publs-ajax" ).on( "click", function(event) {
        event.preventDefault();
        jQuery.ajax({
            type: 'GET',
            url: '/index.php?page_id=<?=$_REQUEST[page_id]?>&ajax_mode=1&ajax_president_publs='+president_publs_count,
            success: function (data) {
                president_publs_count += 12;
                $('.president-publs-loader-main').before(data);
                collumns_scroll();
                $('[data-toggle="tooltip"]').tooltip();
            },
            complete: function (data) {
                $('.president-publs-loader').hide();
                $('.more-button-president-publs').show();
            },
            beforeSend: function () {
                $('.president-publs-loader').show();
                $('.more-button-president-publs').hide();
            }
        })
    });
</script>
