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
$arr_video= array();

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
	//$status = mysqli_fetch_array($result_content);
	
	while($row = mysqli_fetch_array($result_content)) 
	{
		$arr_video[$count_vg][$row['icont_var']]=$row['icont_text'];
	}	 
	$count_vg++;
}


if($sort_t['itype_el_sort_type']=="DESC")
usort($arr_video, "compare_desc"); 
if($sort_t['itype_el_sort_type']=="ASC")
usort($arr_video, "compare"); 

//echo '<div><img alt="" src="/files/Image/DCC-20_05.jpg" height="264" width="396">
//&nbsp;&nbsp;<img alt="" src="/files/Image/DCC-20_10.jpg" height="264" width="176"></div>';

//SELECT * FROM adm_ilines_element AS ae INNER JOIN adm_ilines_content AS ac ON ac.el_id=ae.el_id WHERE ae.itype_id=9 

if($count_vg>0)
{
?>
<div class="connected-carousels">
<div class="stage">
                    <div data-jcarouselautoscroll="true" data-jcarousel="true" class="carousel carousel-stage2">
                        <ul style="left: 0px; top: 0px;">
                        	<?php
                        	for ($i=0; $i < $count_vg; $i++) { 
                        		$sum=265+592*$i;
                                $params="?rel=0&autoplay=1";
                                $par="1";
                                if($arr_video[$i]['params'])
                                {
                                    $params="";
                                    $par="0";
                                }
                        		echo "
                        	<li>
                        		<style>
                        		#play-button-piar-".$i." {
                        		background-image:url('css/play_button_piar.png');
                                background-size: 100%; 
    							width: 75px; 
    							height: 75px; 
    							position: absolute; 
    							top: 255px; 
    							left: ".$sum."px;
								}
								#play-button-piar-".$i.":hover {
    							background-image:url('css/play_button_piar_s.png'); 
    							width: 75px; 
    							height: 75px; 
    							position: absolute; 
    							top: 255px; 
    							left: ".$sum."px;
								}
                        		</style>";
								echo "<a href=\"javascript:doPopup('//".$arr_video[$i]['youtube_url'].$params."', ".$par.")\"><div id=play-button-piar-".$i.">
								</div></a>";
								echo '<img src="..'.$arr_video[$i]['photo_stop'].'" alt="" height="333" width="592">
							</li>';
							}
							?>                       
							</ul>
                    </div>
                    <table><tr><td width="100"><div class="title red"><a href="index.php?page_id=1010"><h2>Видеогалерея</h2></a></div></td>
                    	<td width="470">
                    <div data-jcarousel="true" class="carousel carousel-stage21">
                        <ul style="left: 0px; top: 0px;">
                            <?php
                            for ($i=0; $i < $count_vg; $i++) { 
                                $iDate=explode('.',substr($arr_video[$i]['date'],0,10));
                            echo '<li><table><tr><td width="470"><div class="column_td">'.date('d.m.y', mktime(0,0,0,$iDate[1],$iDate[2],$iDate[0])).' - ';
                            if(!empty($arr_video[$i]['url']))
                            echo '<a target="_blank" href='.$arr_video[$i]['url'].'>'.$arr_video[$i]['title'].'</a>';
                            else
                            echo $arr_video[$i]['title'];
                            echo '</div></td><tr></table></li>';
                            }
                            ?>
                        </ul>
                    </div></td></tr></table>
                    <a data-jcarouselcontrol="true" href="#" class="prev prev-stage2 inactive"><span>‹</span></a>
                    <a data-jcarouselcontrol="true" href="#" class="next next-stage2"><span>›</span></a>


 </div>
</div>
<?php
}?>
