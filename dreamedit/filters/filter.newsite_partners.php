<?php
global $DB;
$partners = $DB->select("SELECT logo.icont_text AS logo, text.icont_text AS text, link.icont_text AS link FROM adm_directories_content AS ac INNER JOIN adm_directories_element AS ae ON ac.el_id=ae.el_id 
                          INNER JOIN adm_directories_content AS logo ON logo.el_id=ac.el_id AND logo.icont_var='logo' 
                          INNER JOIN adm_directories_content AS text ON text.el_id=ac.el_id AND text.icont_var='text' 
                          INNER JOIN adm_directories_content AS sort ON sort.el_id=ac.el_id AND sort.icont_var='sort' 
                          INNER JOIN adm_directories_content AS link ON link.el_id=ac.el_id AND link.icont_var='link' 
                          WHERE ae.itype_id=25 GROUP BY ac.el_id ORDER BY sort.icont_text");
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
<script>
    jQuery(document).ready(function(){
        jQuery('.customer-logos').slick({
            slidesToShow: 6,
            slidesToScroll: 3,
            autoplay: false,
            autoplaySpeed: 1500,
            arrows: true,
            dots: false,
            pauseOnHover: false,
            prevArrow: '<span class="slick-arrow-img-prev">‹</span>',
            nextArrow: '<span class="slick-arrow-img-next">›</span>',
            responsive: [{
                breakpoint: 768,
                settings: {
                    slidesToShow: 6
                }
            }, {
                breakpoint: 520,
                settings: {
                    slidesToShow: 6
                }
            }]
        });
    });
</script>
<div class="container-fluid">
    <hr>
</div>
<?php
echo '<section class="py-5 customer-logos slider">';
foreach ($partners AS $partner) {
    preg_match('~<img.*?src=["\']+(.*?)["\']+~', $partner['logo'], $result);
    echo '<div class="slide"><a href="'.$partner['link'].'"><img alt="'.$partner['text'].'" src="'.$result[1].'"></a></div>';
}
echo '</section>';
?>