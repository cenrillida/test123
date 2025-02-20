<?php
// ����� �� ������

global $link;

$query = "SELECT id FROM `persons` AS pers WHERE pers.otdel='424' OR pers.otdel2='424' OR pers.otdel3='424'" or die("Error in the consult.." . mysqli_error($link));
$result = $link->query($query);

$autors="";

$first=true;

while($row = mysqli_fetch_array($result))
{
    if($first) {
        $autors .= " WHERE (avtor LIKE '" . $row[id] . "<br>%' OR avtor LIKE '%<br>" . $row[id] . "<br>%'";
        $first=false;
    }
    else
        $autors.=" OR avtor LIKE '".$row[id]."<br>%' OR avtor LIKE '%<br>".$row[id]."<br>%'";
}

$query = "SELECT `year` FROM publ".$autors.") GROUP BY `year` ORDER BY `year` DESC" or die("Error in the consult.." . mysqli_error($link));

$result = $link->query($query);
if(!empty($_GET[year]))
    echo '<a href="/energyeconomics/index.php?page_id='.$p_id.'">Все</a> | ';
else
    echo '<b>Все</b> | ';
while($row = mysqli_fetch_array($result)) {
    if($_GET[year]!=$row[year])
    echo '<a href="/energyeconomics/index.php?page_id='.$p_id.'&year='.$row['year'].'">'.$row['year'].'</a> | ';
    else
        echo '<b>'.$row[year].'</b> | ';
}
echo "<br><br>";

$yearRequest="";

if(!empty($_GET[year])) {
    $yearRequest="&year=".(int)$_GET[year];
    if ($first) {
        $autors .= " WHERE year=".(int)$_GET[year];
    } else {
        $autors .= ") AND year=".(int)$_GET[year];
    }
}
else
    $autors.=')';

$query = "SELECT id,name,picsmall,avtor,link,hide_autor FROM publ".$autors or die("Error in the consult.." . mysqli_error($link));
$result = $link->query($query);

$pages_count = ceil($result->num_rows/10);

if(empty($_GET[publ_page_id]))
    $cur_page=0;
else
    $cur_page=(int)$_GET[publ_page_id]-1;



$limit=10*$cur_page;

//$query = "SELECT id,name,picsmall,avtor,link,hide_autor FROM publ".$autors." ORDER BY STR_TO_DATE(date, '%d.%m.%Y') DESC LIMIT ".$limit.",10" or die("Error in the consult.." . mysqli_error($link));
$query = "SELECT id,name,picsmall,avtor,link,hide_autor FROM publ".$autors." ORDER BY year DESC,id DESC LIMIT ".$limit.",10" or die("Error in the consult.." . mysqli_error($link));

$result = $link->query($query);

while($row = mysqli_fetch_array($result))
{
    $avtors = explode("<br>",$row[avtor]);
    $avtor_str="";
    $first_avtor=true;
    foreach($avtors as $key => $value) {
        if(empty($value))
            continue;
        if($first_avtor){
            $first_avtor=false;
        }
        else
            $avtor_str.=", ";
        if(is_numeric($value)) {
                $results = $link->query("SELECT id,CONCAT(surname,' ', if(name is null or name = '', '', CONCAT(SUBSTRING(name,1,1), '. ')), if(fname is null or fname = '', '', CONCAT(SUBSTRING(fname,1,1), '. '))) AS full_name FROM persons WHERE id=".$value);
                while($row_avtor = mysqli_fetch_array($results)) {
                    $avtor_str.="<a href=\"/index.php?page_id=555&amp;id=".$row_avtor[id].$yearRequest."\" title=\"Об авторе подробнее\"><em>".$row_avtor[full_name]."</em></a>";
                }
            }
        else
            $avtor_str.="<em>".$value."</em>";
    }
    ?>

    <table border="0" style="width:90%;">
        <tbody>
        <tr>
            <td style="vertical-align:top;">
                <img alt="/dreamedit/pfoto/<? if(!empty($row[picsmall])) echo $row[picsmall]; else echo "e_logo.jpg";?>" title="" src="/dreamedit/pfoto/<? if(!empty($row[picsmall])) echo $row[picsmall]; else echo "e_logo.jpg";?>" border="3" style="border-color:#cecce8;" hspace="20" vspace="2"><br>
            </td>
            <td width="100%" style="vertical-align:top;">
                <? if($row[hide_autor]!="on") echo $avtor_str."<br>";?><a href="/index.php?page_id=645&amp;id=<?=$row[id]?>" title="more..."><?=$row[name]?></a><?=$row[link]?>
            </td></tr>
        </tbody>
    </table>
<?
}
?>
    <br clear="all">
    <b>страницы:</b>&nbsp;&nbsp;
<? if($cur_page!=0):?>
    <a href="/energyeconomics/index.php?page_id=<?=$p_id?>&amp;publ_page_id=<?=$cur_page.$yearRequest?>"><b>предыдущая&nbsp;&nbsp;←</b>&nbsp;&nbsp;</a>&nbsp;&nbsp;
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
        <a href="/energyeconomics/index.php?page_id=<?=$p_id?>&amp;publ_page_id=<?=$i.$yearRequest?>"><?=$i?></a>&nbsp;&nbsp;
    <? endif;?>
<? }
?>
<? if($cur_page+1<$pages_count):?>
    <a href="/energyeconomics/index.php?page_id=<?=$p_id?>&amp;publ_page_id=<?=$cur_page+2?><?=$yearRequest?>">&nbsp;&nbsp;<b>→&nbsp;следующая</b>&nbsp;&nbsp;</a>&nbsp;&nbsp;
<? endif;?>