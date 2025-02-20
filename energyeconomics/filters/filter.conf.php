<?php
global $link, $p_id;

$query = "SELECT ae.el_id FROM adm_ilines_element AS ae
			INNER JOIN adm_ilines_content AS ac ON ac.el_id=ae.el_id
			INNER JOIN adm_ilines_content AS otd ON otd.el_id=ae.el_id AND otd.icont_var='otdel'
 			WHERE (ae.itype_id=4 OR ae.itype_id=18) AND otd.icont_text='424'
 			GROUP BY el_id" or die("Error in the consult.." . mysqli_error($link));
$result = $link->query($query);

$pages_count = ceil($result->num_rows/10);

if(empty($_GET[news_page_id]))
	$cur_page=0;
else
	$cur_page=(int)$_GET[news_page_id]-1;



$limit=10*$cur_page;

$query = "SELECT ac.el_id, d.icont_text AS date2, CASE WHEN DATEDIFF( d.icont_text, CURDATE( ) )>0 THEN pt.icont_text WHEN DATEDIFF( d.icont_text, CURDATE( ) )<0 THEN lt.icont_text WHEN DATEDIFF( d.icont_text, CURDATE( ) )=0 THEN tt.icont_text END AS last_text FROM adm_ilines_element AS ae
			INNER JOIN adm_ilines_content AS ac ON ac.el_id=ae.el_id
			INNER JOIN adm_ilines_content AS otd ON otd.el_id=ae.el_id AND otd.icont_var='otdel'
			INNER JOIN adm_ilines_content AS d ON d.el_id=ae.el_id AND d.icont_var='date2'
			INNER JOIN adm_ilines_content AS lt ON lt.el_id=ae.el_id AND lt.icont_var='last_text'
			INNER JOIN adm_ilines_content AS tt ON tt.el_id=ae.el_id AND tt.icont_var='today_text'
			INNER JOIN adm_ilines_content AS pt ON pt.el_id=ae.el_id AND pt.icont_var='prev_text'
 			WHERE (ae.itype_id=4 OR ae.itype_id=18) AND otd.icont_text='424'
 			GROUP BY el_id
 			ORDER BY d.icont_text DESC LIMIT ".$limit.",10" or die("Error in the consult.." . mysqli_error($link));
$result = $link->query($query);


while($row = mysqli_fetch_array($result)) 
{
	?>

	<div>

		<?php

		echo '<div class="news-razd"></div>';
		echo '<table><tbody><tr><td>'.substr($row['date2'],8,2).'.'.substr($row['date2'],5,2).'.'.substr($row['date2'],0,4).' г.'.$row['last_text'].'<a style="text-decoration:none" href="/index.php?page_id=502&amp;id='.$row['el_id'].'" target="_blank">подробнее &gt;&gt;</a></td></tr></tbody></table>';

		?>
	</div>
	<?php
}
?>
<div class="sep"> </div>
<br clear="all">
<b>страницы:</b>&nbsp;&nbsp;
<? if($cur_page!=0):?>
	<a href="/energyeconomics/index.php?page_id=<?=$p_id?>&amp;news_page_id=<?=$cur_page?>"><b>предыдущая&nbsp;&nbsp;←</b>&nbsp;&nbsp;</a>&nbsp;&nbsp;
<? endif;?>
<?
$right=$cur_page+1+5;
$left=$cur_page+1-5;
if($left<=0) {
	$right = $right-$left;
	$left = 1;
}
for($i=$left;$i<=$right;$i++) {?>
		<? if($cur_page+1==$i && $i<=$pages_count): ?>
			<b><?=$i?></b>&nbsp;&nbsp;
		<? endif;?>
		<? if($cur_page+1!=$i && $i<=$pages_count): ?>
			<a href="/energyeconomics/index.php?page_id=<?=$p_id?>&amp;news_page_id=<?=$i?>"><?=$i?></a>&nbsp;&nbsp;
		<? endif;?>
<? }
?>
<? if($cur_page+1<$pages_count):?>
	<a href="/energyeconomics/index.php?page_id=<?=$p_id?>&amp;news_page_id=<?=$cur_page+2?>">&nbsp;&nbsp;<b>→&nbsp;следующая</b>&nbsp;&nbsp;</a>&nbsp;&nbsp;
<? endif;?>