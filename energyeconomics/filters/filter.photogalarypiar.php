<?php
global $link;

$photogalaryid=19;

$query = "SELECT itype_el_sort_type FROM adm_ilines_type WHERE itype_id=".$photogalaryid or die("Error in the consult.." . mysqli_error($link)); 
$result = $link->query($query); 
$arr=array();

$sort_t = mysqli_fetch_array($result);

$query = "SELECT ac.el_id FROM adm_ilines_element AS ae INNER JOIN adm_ilines_content AS ac ON ac.el_id=ae.el_id WHERE ae.itype_id=".$photogalaryid." GROUP BY el_id ORDER BY el_date ".$sort_t['itype_el_sort_type'] or die("Error in the consult.." . mysqli_error($link)); 
$result = $link->query($query); 

$count_pg=0;

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

<div class="connected-carousels">
<div class="stage">
                    <div data-jcarousel="true" class="carousel carousel-stage">
                        <ul style="left: 0px; top: 0px;">
                        	<?php
                        	for ($i=0; $i < $count_pg; $i++) { 
                        		echo '<li><a target="_blank" href='.$arr[$i]['url'].'><img src="..'.$arr[$i]['photo_h'].'" alt="" height="333" width="592"></a></li>';
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
                            if(!empty($arr[$i]['url']))
                            echo '<a target="_blank" href='.$arr[$i]['url'].'>'.$arr[$i]['title'].'</a>';
                            else
                            echo $arr[$i]['title'];
                            echo '</div></td><tr></table></li>';
                            }
                            ?>
                        </ul>
                    </div></td></tr></table>
                    <a data-jcarouselcontrol="true" href="#" class="prev prev-stage inactive"><span>‹</span></a>
                    <a data-jcarouselcontrol="true" href="#" class="next next-stage"><span>›</span></a>
 </div>
</div>
<?php
}?>