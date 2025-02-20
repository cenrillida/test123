
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
global $DB;

$photogalaryid=10;
//delete($arr_video_sidebar_dynkin);
$arr_video_sidebar_dynkin=array();

$result = $DB->select("SELECT itype_el_sort_type FROM adm_ilines_type WHERE itype_id=".$photogalaryid." LIMIT 1"); 

$sort_t = $result[0];

$result = $DB->select("SELECT ac.el_id FROM adm_ilines_element AS ae 
    INNER JOIN adm_ilines_content AS ac ON ac.el_id=ae.el_id 
    INNER JOIN adm_ilines_content AS st ON st.icont_var='status' AND st.el_id=ae.el_id
    INNER JOIN adm_ilines_content AS dt ON dt.icont_var='date' AND dt.el_id=ae.el_id
    WHERE ae.itype_id=".$photogalaryid." AND st.icont_text=1 GROUP BY el_id ORDER BY dt.icont_text ".$sort_t['itype_el_sort_type']." LIMIT 1"); 

$count_vg=0;

//$arr;

$row=$result[0];

$result_content = $DB->select("SELECT * FROM adm_ilines_content WHERE el_id=".$row['el_id']);
foreach ($result_content as $row) {
    $arr_video_sidebar_dynkin[$count_vg][$row['icont_var']]=$row['icont_text'];
} 
$count_vg++;

if($sort_t['itype_el_sort_type']=="DESC")
usort($arr_video_sidebar_dynkin, "compare_desc"); 
if($sort_t['itype_el_sort_type']=="ASC")
usort($arr_video_sidebar_dynkin, "compare"); 

if($count_vg>0)
{
?>
                        	<?php
                        	for ($i=0; $i < $count_vg; $i++) { 
                                $params="?rel=0&autoplay=1";
                                $par="1";
                                if($arr_video_sidebar_dynkin[$i]['params'])
                                {
                                    $params="";
                                    $par="0";
                                }
                                if(substr($arr_video_sidebar_dynkin[$i]['youtube_url'],0,5)=="http:") {$delimiter = "http://"; $arr_video_sidebar_dynkin[$i]['youtube_url']=str_replace("http://","",$arr_video_sidebar_dynkin[$i]['youtube_url']);} else $delimiter = "//";
                        		echo "<a class=\"play-button-a\" href=\"javascript:doPopup('".$delimiter.$arr_video_sidebar_dynkin[$i]['youtube_url'].$params."', ".$par.")\"><div id=play-button-piar-video-sidebar-".$i.">
                                </div></a>";
                                echo '<img src="..'.$arr_video_sidebar_dynkin[$i]['photo_stop'].'" alt="" height="187" width="332">
                           ';
                        	}
							?>
                	<?php
                    if($_SESSION[lang]=="/en")
                        $head_name = "Videogallery";
                    else
                        $head_name = "Видеогалерея";
                    //echo "<table><tr><td width=\"100\"><div class=\"title red\"><h2>".$head_name."</h2></div></td>";

                    //echo '<td width="232">';
                    echo '<div class="video-text">';
                	for ($i=0; $i < $count_vg; $i++) { 
                        if($_SESSION[lang]!="/en")
                            $ph_h_text=$arr_video_sidebar_dynkin[$i]['title'];
                        elseif(!empty($arr_video_sidebar_dynkin[$i]['title_en']))
                            $ph_h_text=$arr_video_sidebar_dynkin[$i]['title_en'];
                        else
                            $ph_h_text="Sorry. Only in Russian.";

                        $iDate=explode('.',substr($arr_video_sidebar_dynkin[$i]['date'],0,10));
                    echo date('d.m.y', mktime(0,0,0,$iDate[1],$iDate[2],$iDate[0])).' - ';
                    if($_SESSION[lang]!="/en")
                    {
                        if(!empty($arr_video_sidebar_dynkin[$i]['url']))
                        echo '<a target="_blank" href='.$arr_video_sidebar_dynkin[$i]['url'].'>'.$ph_h_text.'</a>';
                        else
                        echo $ph_h_text;
                    }
                    elseif(!empty($arr_video_sidebar_dynkin[$i]['title_en']))
                    {
                        if(!empty($arr_video_sidebar_dynkin[$i]['url_en']))
                        echo '<a target="_blank" href='.$arr_video_sidebar_dynkin[$i]['url_en'].'>'.$ph_h_text.'</a>';
                        else
                        echo $ph_h_text;
                    }
                    else
                    {
                        if(!empty($arr_video_sidebar_dynkin[$i]['url']))
                        echo '<a target="_blank" href='.$arr_video_sidebar_dynkin[$i]['url'].'>'.$ph_h_text.'</a>';
                        else
                        echo $ph_h_text;
                    }

                	}
                    if($_SESSION[lang]!="/en")
                        echo '<br><br><a href="/index.php?page_id=1102">Перейти в видеогалерею</a></div>';
                    else
                        echo '<br><br><a href="/en/index.php?page_id=1102">To videogallery</a></div>';
                    //echo '</td></tr></table>';
                	?>
<?php
}?>