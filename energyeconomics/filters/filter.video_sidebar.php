
<script language="javascript">  
function doPopup(popupPath, par) { 
var percent = encodeURIComponent('%');
if(par)
    popupPath += '&height=100' + percent + '&width=100' + percent; 
pWnd=window.open(popupPath,'name',  
'width=560,height=315,scrollbars=NO,left=350,top=100');
}
</script> 
<?php
global $link;

$photogalaryid=10;
//delete($arr_video_sidebar_dynkin);
$arr_video_sidebar_dynkin=array();

$query = "SELECT itype_el_sort_type FROM adm_ilines_type WHERE itype_id=".$photogalaryid or die("Error in the consult.." . mysqli_error($link)); 
$result = $link->query($query); 

$sort_t = mysqli_fetch_array($result);

$query = "SELECT ac.el_id FROM adm_ilines_element AS ae INNER JOIN adm_ilines_content AS ac ON ac.el_id=ae.el_id WHERE ae.itype_id=".$photogalaryid." GROUP BY el_id ORDER BY el_date ".$sort_t['itype_el_sort_type'] or die("Error in the consult.." . mysqli_error($link)); 
$result = $link->query($query); 

$count_vg=0;

//$arr;

while($row = mysqli_fetch_array($result)) 
{ 
	$query = "SELECT * FROM adm_ilines_content WHERE el_id=".$row['el_id']." AND icont_var='status'" or die("Error in the consult.." . mysqli_error($link)); 
	$result_content = $link->query($query); 
	$status = mysqli_fetch_array($result_content);
	if($status[2]==0)
		continue;
    $query = "SELECT * FROM adm_ilines_content WHERE el_id=".$row['el_id'] or die("Error in the consult.." . mysqli_error($link)); 
    $result_content = $link->query($query); 
    while($row = mysqli_fetch_array($result_content)) 
    {
        $arr_video_sidebar_dynkin[$count_vg][$row['icont_var']]=$row['icont_text'];
    }    
    $count_vg++;
}

if($sort_t['itype_el_sort_type']=="DESC")
usort($arr_video_sidebar_dynkin, "compare_desc"); 
if($sort_t['itype_el_sort_type']=="ASC")
usort($arr_video_sidebar_dynkin, "compare"); 


//echo '<div><img alt="" src="/files/Image/DCC-20_05.jpg" height="264" width="396">
//&nbsp;&nbsp;<img alt="" src="/files/Image/DCC-20_10.jpg" height="264" width="176"></div>';

//SELECT * FROM adm_ilines_element AS ae INNER JOIN adm_ilines_content AS ac ON ac.el_id=ae.el_id WHERE ae.itype_id=9 

if($count_vg>0)
{
?>

<div class="connected-carousels">
<div class="stage" style="width: 300">
                    <div data-jcarousel="true" class="carousel carousel-stage-ph-video-sidebar">
                        <ul style="left: 0px; top: 0px;">
                        	<?php
                        	for ($i=0; $i < $count_vg; $i++) { 
                                $sum=130+300*$i;
                                $params="?rel=0&autoplay=1";
                                $par="1";
                                if($arr_video_sidebar_dynkin[$i]['params'])
                                {
                                    $params="";
                                    $par="0";
                                }
                                echo "
                            <li>
                                <style>
                                #play-button-piar-video-sidebar-".$i." {
                                background-image:url('css/play_button_piar.png');
                                background-size: 100%; 
                                width: 50px; 
                                height: 50px; 
                                position: absolute; 
                                top: 110px; 
                                left: ".$sum."px;
                                }
                                #play-button-piar-video-sidebar-".$i.":hover {
                                background-image:url('css/play_button_piar_s.png'); 
                                width: 50px; 
                                height: 50px; 
                                position: absolute; 
                                top: 110px; 
                                left: ".$sum."px;
                                }
                                </style>";
                        		echo "<a href=\"javascript:doPopup('//".$arr_video_sidebar_dynkin[$i]['youtube_url'].$params."', ".$par.")\"><div id=play-button-piar-video-sidebar-".$i.">
                                </div></a>";
                                echo '<img src="..'.$arr_video_sidebar_dynkin[$i]['photo_stop'].'" alt="" height="169" width="300">
                            </li>';
                        	}
							?>
                        </ul>
                    </div>
                    
                    <div data-jcarousel="true" class="carousel carousel-stage-ph-video-sidebar1">
                        <ul style="left: 0px; top: 0px;">
                        	<?php
                        	for ($i=0; $i < $count_vg; $i++) { 
                                if(mb_strlen($arr_video_sidebar_dynkin[$i]['title'], "utf-8")>90)
                                    $ph_h_text=mb_substr($arr_video_sidebar_dynkin[$i]['title'], 0,90, "utf-8")."...";
                                else
                                    $ph_h_text=$arr_video_sidebar_dynkin[$i]['title'];

                                $iDate=explode('.',substr($arr_video_sidebar_dynkin[$i]['date'],0,10));
                            echo '<li><table><tr><td width="470"><div class="column_td1">'.date('d.m.y', mktime(0,0,0,$iDate[1],$iDate[2],$iDate[0])).' - ';
                            if(!empty($arr_video_sidebar_dynkin[$i]['url']))
                            echo '<a target="_blank" href='.$arr_video_sidebar_dynkin[$i]['url'].'>'.$ph_h_text.'</a>';
                            else
                            echo $ph_h_text;
                            echo '</div></td><tr></table></li>';
                        	}
                        	?>
                        </ul>
                    </div>
                    <a data-jcarouselcontrol="true" href="#" class="prev prev-stage-ph-video-sidebar inactive"><span>‹</span></a>
                    <a data-jcarouselcontrol="true" href="#" class="next next-stage-ph-video-sidebar"><span>›</span></a>
 </div>
</div>
<?php
}?>