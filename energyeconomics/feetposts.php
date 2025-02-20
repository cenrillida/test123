
<?php



global $link;
global $p_id;

$current_page = $p_id;
if($p_id!=1107) {
	$path = "<a href=\"/energyeconomics/\">Главная</a>";
	while (true) {
		$query = "SELECT page_id,page_parent,page_name FROM adm_pages WHERE page_id=" . $current_page or die("Error in the consult.." . mysqli_error($link));
		$result = $link->query($query);

		while ($row = mysqli_fetch_array($result)) {
			if($p_id==$row[page_id])
				$path_array[] = "&nbsp;&gt;&nbsp;".$row[page_name];
			else
				$path_array[] = "&nbsp;&gt;&nbsp;<a href=\"/energyeconomics/?page_id=".$row[page_id]."\">".$row[page_name]."</a>";
			$current_page = $row[page_parent];
		}
		if ($current_page == 0 || $current_page == 1107 || $current_page == 1108)
			break;
	}
	if(!empty($path_array))
	{
		$path_array = array_reverse($path_array);
		foreach($path_array as $k => $v) {
			$path.=$v;
		}
	}
}
else
	$path="Главная";

$query = "SELECT ac.el_id,ac.icont_text FROM adm_headers_element AS ae INNER JOIN adm_headers_content AS ac ON ac.el_id=ae.el_id WHERE ae.itype_id=".$feetposts_id." AND ac.icont_var='sort' GROUP BY el_id ORDER BY ac.icont_text" or die("Error in the consult.." . mysqli_error($link)); 
$result = $link->query($query); 


$count=0;

while($row = mysqli_fetch_array($result)) 
{ 
	$query = "SELECT * FROM adm_headers_content WHERE el_id=".$row['el_id'] or die("Error in the consult.." . mysqli_error($link)); 
	$result_content = $link->query($query); 
	while($row = mysqli_fetch_array($result_content)) 
	{
		$arr_fp[$row['icont_var']][$count]=$row['icont_text'];
	}
	if($arr_fp['ctype'][$count]=='Фильтр')
	{
		$query = "SELECT filter_filename FROM adm_filters WHERE filter_placeholder='".$arr_fp['fname'][$count]."'" or die("Error in the consult.." . mysqli_error($link)); 
		$result_content = $link->query($query); 
		while($row = mysqli_fetch_array($result_content)) 
		{
			$arr_fp['filter_filename'][$count]=$row['filter_filename'];
		}
	}	 
	$count++;
}




//echo '<div class="box" id="featPosts"><div><p><a target="_self" href="/index.php?page_id=509"><img alt="Официальный сайт ИМЭМО РАН" src="/files/Image/BIG_BANNER_LQ5.jpg" height="236" width="590"></a></p></div><div class="cleaner">&nbsp;</div>
//</div>';
if($count>0)
{
echo '<div id="main">';
for ($j_f=0; $j_f < $count; $j_f++) { 
	if($arr_fp['status'][$j_f])
	{
echo	'<div class="box" >';

if($arr_fp['showtitle'][$j_f]==1)
{
	$color_fp_title="red";
	$img_url_p1="background-image: url('/images/back_title_";
	$img_url_p2=".png');";
	if($arr_fp['cclass'][$j_f]=="Голубой 1") $color_fp_title="blue";
	if($arr_fp['cclass'][$j_f]=="Голубой 2") $color_fp_title="blue2";
	if($arr_fp['cclass'][$j_f]=="Голубой 3") $color_fp_title="blue3";
	if($arr_fp['cclass'][$j_f]=="Темный") $color_fp_title="dark";
	if($arr_fp['cclass'][$j_f]=="Зеленый") $color_fp_title="green";
	if($arr_fp['cclass'][$j_f]=="Серый") $color_fp_title="grey";
	if($arr_fp['cclass'][$j_f]=="Серый 2") $color_fp_title="grey2";
	if($arr_fp['cclass'][$j_f]=="Розовый") $color_fp_title="pink";
	if($arr_fp['cclass'][$j_f]=="Красный") $color_fp_title="red";
	if($arr_fp['cclass'][$j_f]=="Фиолетовый") $color_fp_title="purple";
	if($arr_fp['cclass'][$j_f]=="Белый") $color_fp_title="white";

	if($arr_fp['showpath'][$j_f]!=1) {
		if ($color_fp_title == "white")
			echo '<div class="title ' . $color_fp_title . '">';
		else
			echo '<div class="title" style="text-align: right;">';
		$header_text_color = "";
		if ($color_fp_title != "white")
			$header_text_color = ' style="color: white; display: inline-block; padding-left: 10px; padding-right: 10px; ' . $img_url_p1 . $color_fp_title . $img_url_p2 . '"';
		if (!empty($arr_fp['link_id'][$j_f])) {
			if ($arr_fp['link_id'][$j_f] == 1006 || $arr_fp['link_id'][$j_f] == 1008 || $arr_fp['link_id'][$j_f] == 1010 || $arr_fp['link_id'][$j_f] == 1011 || $arr_fp['link_id'][$j_f] == 1012 || $arr_fp['link_id'][$j_f] == 1013)
				echo '<a href=index.php?page_id=' . $arr_fp['link_id'][$j_f] . '><h6' . $header_text_color . '>' . $arr_fp['title'][$j_f] . '</h6></a>';
			else
				echo '<a target="_blank" href=../index.php?page_id=' . $arr_fp['link_id'][$j_f] . '><h6' . $header_text_color . '>' . $arr_fp['title'][$j_f] . '</h6></a>';
		} else
			echo '<h6' . $header_text_color . '>' . $arr_fp['title'][$j_f] . '</h6>';
		echo '</div>';
	}
	else {
		if ($color_fp_title == "white")
			echo '<div class="title ' . $color_fp_title . '">';
		else
			echo '<div class="title" style="text-align: left;">';
		$header_text_color = " style=\"text-transform: none; ";
		if ($color_fp_title != "white")
			$header_text_color = ' style="color: white; display: inline-block; padding-left: 10px; padding-right: 10px; text-transform: none; ' . $img_url_p1 . $color_fp_title . $img_url_p2 . '"';
		if (!empty($arr_fp['link_id'][$j_f])) {
			if ($arr_fp['link_id'][$j_f] == 1006 || $arr_fp['link_id'][$j_f] == 1008 || $arr_fp['link_id'][$j_f] == 1010 || $arr_fp['link_id'][$j_f] == 1011 || $arr_fp['link_id'][$j_f] == 1012 || $arr_fp['link_id'][$j_f] == 1013)
				echo '<a href=index.php?page_id=' . $arr_fp['link_id'][$j_f] . '><h6' . $header_text_color . '>' . $path . '</h6></a>';
			else
				echo '<a target="_blank" href=../index.php?page_id=' . $arr_fp['link_id'][$j_f] . '><h6' . $header_text_color . '>' . $path . '</h6></a>';
		} else
			echo '<h6' . $header_text_color . '>' . $path . '</h6>';
		echo '</div>';
	}
}

if($arr_fp['ctype'][$j_f]=='Фильтр') {
	if(!$arr_fp['filter_text'][$j_f]) {
		if ($arr_fp['text'][$j_f] != '<p>&nbsp;</p>' && $arr_fp['text'][$j_f] != '' && $arr_fp['text'][$j_f] != '<p></p>')
			echo $arr_fp['text'][$j_f];
		include_once("filters/" . $arr_fp['filter_filename'][$j_f]);
	}
	else
	{
		include_once("filters/" . $arr_fp['filter_filename'][$j_f]);
		if ($arr_fp['text'][$j_f] != '<p>&nbsp;</p>' && $arr_fp['text'][$j_f] != '' && $arr_fp['text'][$j_f] != '<p></p>')
			echo $arr_fp['text'][$j_f];
	}
}
else
echo $arr_fp['text'][$j_f];
echo '</div>';
}
}
?>

<?php

echo '</div>';
}?>


