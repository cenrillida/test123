<?php
global $link;

$photogalaryid=9;

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
<div class="stage" style="width: 300">
                    <div data-jcarousel="true" class="carousel carousel-stage-ph-h">
                        <ul style="left: 0px; top: 0px;">
                        	<?php
                        	for ($i=0; $i < $count_pg; $i++) { 
                        		echo '<li><img src="..'.$arr[$i]['photo_h'].'" alt="" height="200" width="300"></li>';
                        	}
							?>
                        </ul>
                    </div>
                    
                    <div data-jcarousel="true" class="carousel carousel-stage-ph-h1">
                        <ul style="left: 0px; top: 0px;">
                        	<?php
                        	for ($i=0; $i < $count_pg; $i++) { 
                                if(mb_strlen($arr[$i]['title'], "utf-8")>90)
                                    $ph_h_text=mb_substr($arr[$i]['title'], 0,90, "utf-8")."...";
                                else
                                    $ph_h_text=$arr[$i]['title'];

                                $iDate=explode('.',substr($arr[$i]['date'],0,10));
                        	echo '<li><table width="290"><tr><td><div class="column_td1">'.date('d.m.y', mktime(0,0,0,$iDate[1],$iDate[2],$iDate[0])).' - ';
                            if(!empty($arr[$i]['url']))
                            echo '<a target="_blank" href='.$arr[$i]['url'].'>'.$ph_h_text.'</a>';
                            else
                            echo $ph_h_text;
                            echo '</div></td><tr></table></li>';}
                        	?>
                        </ul>
                    </div>
                    <a data-jcarouselcontrol="true" href="#" class="prev prev-stage-ph-h inactive"><span>‹</span></a>
                    <a data-jcarouselcontrol="true" href="#" class="next next-stage-ph-h"><span>›</span></a>
 </div>
</div>
<?php
}?>