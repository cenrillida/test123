<?php
global $DB;

$photogalaryid=9;

$arr=array();

$sort_t = $DB->select("SELECT itype_el_sort_type FROM adm_ilines_type WHERE itype_id=".$photogalaryid);
$sort_t=$sort_t[0];

$result = $DB->select("SELECT ac.el_id FROM adm_ilines_element AS ae INNER JOIN adm_ilines_content AS ac ON ac.el_id=ae.el_id AND ac.icont_var='date' WHERE ae.itype_id=".$photogalaryid." GROUP BY el_id ORDER BY ac.icont_text ".$sort_t['itype_el_sort_type']." LIMIT 7");

$count_pg=0;

//$arr;

foreach($result as $row) 
{ 
	$result_content = $DB->select("SELECT * FROM adm_ilines_content WHERE el_id=".$row['el_id']." AND icont_var='status'" );
	$status = $result_content[0];
    //var_dump($status);
	if($status['icont_text']==0)
		continue;
	$result_content = $DB->select("SELECT * FROM adm_ilines_content WHERE el_id=".$row['el_id']);
	foreach($result_content as $row) 
	{
		$arr[$count_pg][$row['icont_var']]=$row['icont_text'];
	}	 
	$count_pg++;
}

if($sort_t['itype_el_sort_type']=="DESC")
usort($arr, "compare_desc"); 
if($sort_t['itype_el_sort_type']=="ASC")
usort($arr, "compare"); 

//echo '<div><img alt="" src="/files/Image/DCC-20_05.jpg" height="264" width="396">
//&nbsp;&nbsp;<img alt="" src="/files/Image/DCC-20_10.jpg" height="264" width="176"></div>';

//SELECT * FROM adm_ilines_element AS ae INNER JOIN adm_ilines_content AS ac ON ac.el_id=ae.el_id WHERE ae.itype_id=9 

if($count_pg>0)
{
?>
    <div class="col-12">
        <div class="shadow border bg-white p-3 h-100">
            <div class="row">
                <div class="col-12">

                    <div class="connected-carousels">
                    <div class="stage">
                                        <div data-jcarousel="true" class="carousel carousel-stage">
                                            <ul style="left: 0px; top: 0px;">
                                                <?php
                                                for ($i=0; $i < $count_pg; $i++) {
                                                    echo '<li><img src="..'.$arr[$i]['photo_h'].'" alt="" height="264" width="396">
                                                &nbsp;&nbsp;
                                                <img src="..'.$arr[$i]['photo_v'].'" alt="" height="264" width="176">&nbsp;&nbsp;</li>';
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                        <table><tr>
                                            <td width="570">
                                        <div data-jcarousel="true" class="carousel carousel-stage1">
                                            <ul style="left: 0px; top: 0px;">
                                                <?php
                                                for ($i=0; $i < $count_pg; $i++) {

                                                    $iDate=explode('.',substr($arr[$i]['date'],0,10));
                                                echo '<li><table><tr><td width="570"><div class="column_td">'.date('d.m.y', mktime(0,0,0,$iDate[1],$iDate[2],$iDate[0])).' - ';
                                                if(!empty($arr[$i]['url'])){
                                                    if($_SESSION[lang]!="/en")
                                                        echo '<a target="_blank" href='.$arr[$i]['url'].'>'.$arr[$i]['title'].'</a>';
                                                    elseif($arr[$i]['title_en']!="")
                                                        echo '<a target="_blank" href='.$arr[$i]['url_en'].'>'.$arr[$i]['title_en'].'</a>';
                                                    else
                                                        echo '<a target="_blank" href='.$arr[$i]['url'].'>Sorry. Only in Russian.</a>';

                                                }
                                                else {
                                                    if($_SESSION[lang]!="/en")
                                                        echo $arr[$i]['title'];
                                                    elseif($arr[$i]['title_en']!="")
                                                        echo $arr[$i]['title_en'];
                                                    else
                                                        echo 'Sorry. Only in Russian.';

                                                }
                                                echo '</div></td><tr></table></li>';
                                                }
                                                ?>
                                            </ul>
                                        </div></td></tr></table>
                                        <a data-jcarouselcontrol="true" href="#" class="prev prev-stage inactive"><span>‹</span></a>
                                        <a data-jcarouselcontrol="true" href="#" class="next next-stage"><span>›</span></a>
                     </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
<?php
}?>