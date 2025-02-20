<?php
global $link, $p_id;


$query = "SELECT ac.el_id, d.icont_text AS date2, CASE WHEN DATEDIFF( d.icont_text, CURDATE( ) )>0 THEN pt.icont_text WHEN DATEDIFF( d.icont_text, CURDATE( ) )<0 THEN lt.icont_text WHEN DATEDIFF( d.icont_text, CURDATE( ) )=0 THEN tt.icont_text END AS last_text FROM adm_ilines_element AS ae
			INNER JOIN adm_ilines_content AS ac ON ac.el_id=ae.el_id
			INNER JOIN adm_ilines_content AS otd ON otd.el_id=ae.el_id AND otd.icont_var='otdel'
			INNER JOIN adm_ilines_content AS d ON d.el_id=ae.el_id AND d.icont_var='date2'
			INNER JOIN adm_ilines_content AS lt ON lt.el_id=ae.el_id AND lt.icont_var='last_text'
			INNER JOIN adm_ilines_content AS tt ON tt.el_id=ae.el_id AND tt.icont_var='today_text'
			INNER JOIN adm_ilines_content AS pt ON pt.el_id=ae.el_id AND pt.icont_var='prev_text'
 			WHERE (ae.itype_id=4 OR ae.itype_id=18) AND otd.icont_text='424'
 			GROUP BY el_id
 			ORDER BY d.icont_text DESC LIMIT 3" or die("Error in the consult.." . mysqli_error($link));
$result = $link->query($query);

$first_f=true;
while($row = mysqli_fetch_array($result))
{
	?>

	<div>

		<?php
		if($first_f)
			$first_f=false;
		else
			echo '<div class="news-razd"></div>';
		echo '<table><tbody><tr><td>'.substr($row['date2'],8,2).'.'.substr($row['date2'],5,2).'.'.substr($row['date2'],0,4).' г.'.$row['last_text'].'<a style="text-decoration:none" href="/index.php?page_id=502&amp;id='.$row['el_id'].'" target="_blank">подробнее &gt;&gt;</a></td></tr></tbody></table>';

		?>
	</div>
	<?php
}
?>