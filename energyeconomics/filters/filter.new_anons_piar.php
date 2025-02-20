<?php
global $link;

$query = "SELECT ac.el_id FROM adm_ilines_element AS ae INNER JOIN adm_ilines_content AS ac ON ac.el_id=ae.el_id WHERE ae.itype_id=4 GROUP BY el_id ORDER BY el_date DESC LIMIT 50" or die("Error in the consult.." . mysqli_error($link)); 
$result = $link->query($query); 

$count_nap=0;

//$arr;


while($row = mysqli_fetch_array($result)) 
{ 
	$arr_nap[$count_nap]['el_id']=$row['el_id'];
	$query = "SELECT * FROM adm_ilines_content WHERE el_id=".$row['el_id'] or die("Error in the consult.." . mysqli_error($link)); 
	$result_content = $link->query($query); 
	while($row = mysqli_fetch_array($result_content)) 
	{
		$arr_nap[$count_nap][$row['icont_var']]=$row['icont_text'];
	}	 
	$count_nap++;
}

foreach($arr_nap as $k => $v)
	{
		//echo "<a hidden=true src=test>".$ilines->getNewsOutOfMain($v[el_id])."</a>";
		if($v['rubric']==492 || date("Y.m.d")>=$v['date2'])
		{
			unset($arr_nap[$k]);
			$count_nap--;
		}
						
	}

	$arr_nap=array_values($arr_nap);

function sorta_ap($a, $b) {
            if ($a['date2'] > $b['date2'])
                return 1;
        }
function sortb_ap($a, $b) {
            if ($a['date2'] > $b['date2'])
                return 1;
}

//print_r($arr_nap);

//if ($sort_t['itype_el_sort_field']=="date") {
//	usort($arr_nap, 'sorta_ap');
//}
//if ($sort_t['itype_el_sort_field']=="date2") {
	usort($arr_nap, 'sortb_ap');
//}

//print_r($arr_nap);
        

//echo '<div><img alt="" src="/files/Image/DCC-20_05.jpg" height="264" width="396">
//&nbsp;&nbsp;<img alt="" src="/files/Image/DCC-20_10.jpg" height="264" width="176"></div>';

//SELECT * FROM adm_ilines_element AS ae INNER JOIN adm_ilines_content AS ac ON ac.el_id=ae.el_id WHERE ae.itype_id=9 

if($count_nap>0)
{
?>

<div>

<?php 
$first_nm=true;
if($count_nap>1)
	$count_nap=1;

for ($i=0; $i < $count_nap; $i++) { 
	if($first_nm)
		$first_nm=false;
	else
		echo '<div class="news-razd"></div>';
     echo '<table><tbody><tr><td>Объявления о мероприятиях: '.substr($arr_nap[$i]['date2'],8,2).'.'.substr($arr_nap[$i]['date2'],5,2).'.'.substr($arr_nap[$i]['date2'],0,4).' г.'.$arr_nap[$i]['prev_text'].'<a style="text-decoration:none" href="/index.php?page_id=502&amp;id='.$arr_nap[$i]['el_id'].'" target="_blank">подробнее &gt;&gt;</a></td></tr></tbody></table>';
    }
    
?>
</div>
<?php
}
else
	echo '<table><tbody><tr><td>Объявления о мероприятиях: <p>Ближайших мероприятий нет</p></td></tr></tbody></table>';
?>