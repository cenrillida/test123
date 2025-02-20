<?php
global $DB,$_CONFIG;

$query = "SELECT ac.el_id FROM adm_ilines_element AS ae INNER JOIN adm_ilines_content AS ac ON ac.el_id=ae.el_id WHERE ae.itype_id=4 GROUP BY el_id ORDER BY el_date DESC LIMIT 50";
$result = $DB->select($query);

$pg = new Pages();

$count_nap=0;

//$arr;
$arr_nap=array();


foreach($result as $row)
{
    $arr_nap[$count_nap]['el_id']=$row['el_id'];
    $query = "SELECT * FROM adm_ilines_content WHERE el_id=".$row['el_id'];
    $result_content = $DB->select($query);
    foreach($result_content as $row)
    {
        $arr_nap[$count_nap][$row['icont_var']]=$row['icont_text'];
    }
    $count_nap++;
}

foreach($arr_nap as $k => $v)
{
    //echo "<a hidden=true src=test>".$ilines->getNewsOutOfMain($v[el_id])."</a>";
    if($v['sem']==408 || $v['rubric']==492 || date("Y.m.d")<$v['date2'])
    {
        unset($arr_nap[$k]);
        $count_nap--;
    }

}

$arr_nap=array_values($arr_nap);

function sorta_ap_left($a, $b) {
    if ($a['date2'] < $b['date2'])
        return 1;
}
function sortb_ap_left($a, $b) {
    if ($a['date2'] > $b['date2'])
        return 1;
}

//print_r($arr_nm);

//if ($sort_t['itype_el_sort_field']=="date") {
//	usort($arr_nap, 'sorta_ap_left');
//}
//if ($sort_t['itype_el_sort_field']=="date2") {
usort($arr_nap, 'sorta_ap_left');
//}

//print_r($arr_nm);


//echo '<div><img alt="" src="/files/Image/DCC-20_05.jpg" height="264" width="396">
//&nbsp;&nbsp;<img alt="" src="/files/Image/DCC-20_10.jpg" height="264" width="176"></div>';

//SELECT * FROM adm_ilines_element AS ae INNER JOIN adm_ilines_content AS ac ON ac.el_id=ae.el_id WHERE ae.itype_id=9

if($count_nap>1)
{
        if($count_nap>4)
            $count_nap=8;

        for ($i=0; $i < $count_nap; $i++) {
             ?>


            <div class="col-12 col-md-6 col-xl-6 pb-3">
                <div class="shadow border bg-white p-3 h-100 position-relative">
                    <div class="row">
                        <div class="col-12 text-right">
                            <div style="color: darkgrey;"><?=substr($arr_nap[$i]['date2'],8,2).'.'.substr($arr_nap[$i]['date2'],5,2).'.'.substr($arr_nap[$i]['date2'],0,4).' г.'?></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="news-element">
                                <?=$arr_nap[$i]['last_text']?>
                                <?php if(!empty($arr_nap[$i][full_text]) && $arr_nap[$i][full_text]!='<p>&nbsp;</p>'):?>
                                    <p><a target="_blank" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?><?=$pg->getPageUrl(502, array("id" => $arr_nap[$i]['el_id']))?>"><?php if ($_SESSION[lang]!="/en") echo 'подробнее...'; else echo "more...";?></a></p>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                    <?php if(!empty($arr_nap[$i][full_text]) && $arr_nap[$i][full_text]!='<p>&nbsp;</p>'):?>
                        <a target="_blank" href="<?=$_CONFIG['new_prefix'].$_SESSION['lang']?><?=$pg->getPageUrl(502, array("id" => $arr_nap[$i]['el_id']))?>" class="h-100 w-100 position-absolute overlay-top-left-null hover-highlight" draggable="true"></a>
                    <?php endif;?>
                </div>
            </div>


            <?php

        }
}
else
    echo '<table><tbody><tr><td>Объявления о мероприятиях: <p>Ближайших мероприятий нет</p></td></tr></tbody></table>';
?>
