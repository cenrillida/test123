<?php
global $DB;

$photogalaryid=10;

$video_count = 6;

if($_SESSION[lang]!="/en") {
    $videos = $DB->select("SELECT ac.el_id AS id, t.icont_text AS title, u.icont_text AS url, y.icont_text AS youtube_url, ps.icont_text AS photo_stop, ti.icont_text AS time_seconds FROM adm_ilines_element AS ae 
    INNER JOIN adm_ilines_content AS ac ON ac.el_id=ae.el_id 
    INNER JOIN adm_ilines_content AS st ON st.icont_var='status' AND st.el_id=ae.el_id
    INNER JOIN adm_ilines_content AS dt ON dt.icont_var='date' AND dt.el_id=ae.el_id
    INNER JOIN adm_ilines_content AS t ON t.icont_var='title' AND t.el_id=ae.el_id
    INNER JOIN adm_ilines_content AS u ON u.icont_var='url' AND u.el_id=ae.el_id
    LEFT JOIN adm_ilines_content AS ti ON ti.icont_var='time_seconds' AND ti.el_id=ae.el_id
    INNER JOIN adm_ilines_content AS y ON y.icont_var='youtube_url' AND y.el_id=ae.el_id
    INNER JOIN adm_ilines_content AS ps ON ps.icont_var='photo_stop' AND ps.el_id=ae.el_id
    WHERE ae.itype_id=" . $photogalaryid . " AND st.icont_text=1 GROUP BY ae.el_id ORDER BY dt.icont_text DESC LIMIT ".$video_count);
}
else {
    $videos = $DB->select("SELECT ac.el_id AS id, t.icont_text AS title, u.icont_text AS url, y.icont_text AS youtube_url, ps.icont_text AS photo_stop, ti.icont_text AS time_seconds FROM adm_ilines_element AS ae 
    INNER JOIN adm_ilines_content AS ac ON ac.el_id=ae.el_id 
    INNER JOIN adm_ilines_content AS st ON st.icont_var='status' AND st.el_id=ae.el_id
    INNER JOIN adm_ilines_content AS dt ON dt.icont_var='date' AND dt.el_id=ae.el_id
    INNER JOIN adm_ilines_content AS t ON t.icont_var='title_en' AND t.el_id=ae.el_id
    INNER JOIN adm_ilines_content AS u ON u.icont_var='url_en' AND u.el_id=ae.el_id
    LEFT JOIN adm_ilines_content AS ti ON ti.icont_var='time_seconds' AND ti.el_id=ae.el_id
    INNER JOIN adm_ilines_content AS y ON y.icont_var='youtube_url' AND y.el_id=ae.el_id
    INNER JOIN adm_ilines_content AS ps ON ps.icont_var='photo_stop' AND ps.el_id=ae.el_id
    WHERE ae.itype_id=" . $photogalaryid . " AND st.icont_text=1 GROUP BY ae.el_id ORDER BY dt.icont_text DESC LIMIT ".$video_count);
}
if(!empty($videos))
    echo '<div class="container-fluid"><div class="row">';

$counter = 0;

foreach ($videos as $video): $counter++;?>

    <div class="col-lg-4 col-md-6 col-xs-12 pb-3<?php if($counter>2) echo ' d-none d-lg-block';?>">
        <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" data-src="//<?=$video['youtube_url']?>?autoplay=true&height=100%25&width=100%25<?php if(!empty($video['time_seconds'])) echo '&start='.$video['time_seconds'].'&t='.$video['time_seconds'];?>" allow="autoplay" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
            <img class="video-iframe-image" src="<?=$video['photo_stop']?>" alt="">
            <div class="video-iframe-button-div">
                <button class="btn btn-secondary video-iframe-button" type="button"><i class="fas fa-video"></i> <?php if($_SESSION[lang]!='/en') echo 'Смотреть'; else echo 'Watch';?></button>
            </div>
        </div>
        <div class="video-text mt-3">
            <?php if(!empty($video['url'])):?>
            <a href="<?=$_CONFIG['new_prefix'].$video['url']?>"><h5><?=$video['title']?></h5></a>
            <?php else:?>
            <h5><?=$video['title']?></h5>
            <?php endif;?>
        </div>
    </div>

<?php endforeach;

if(!empty($videos))
    echo '</div></div>';

?>