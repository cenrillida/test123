<?php
global $DB;
if($_SESSION[lang]!="/en")
    $result = $DB->select("SELECT id,name,picbig FROM publ WHERE out_from_print=1 AND status=1 AND picbig!=''");
else
    $result = $DB->select("SELECT id,name2 AS name,picbig FROM publ WHERE out_from_print=1 AND status=1 AND picbig!=''");
if(empty($result))
{
    if($_SESSION[lang]!="/en")
        echo '<p>Ќа данный момент список презентаций книг пуст</p>';
    else
        echo '<p>Not published</p>';
}
else
{
?>
<div class="connected-carousels">
<div class="stage" style="width: 590">
                    <div data-jcarousel="true" class="carousel carousel-stage-ph-outofprint-fp">
                        <ul style="left: 0px; top: 0px;">
                        	<?php
                        	foreach($result as $row) 
                            {
                                echo '<li><table width=590><tr><td align="left"><a target=_blank title="'.$row[name].'" href='.$_SESSION[lang].'/index.php?page_id=645&amp;id='.$row[id].'><img src="../dreamedit/pfoto/'.$row['picbig'].'" alt="" height="120" width="90"></a></td><td><b>'.$row[name].'<b></td></tr></table></li>';
                            }
							?>
                        </ul>
                    </div>
                    
                    <a data-jcarouselcontrol="true" href="#" class="prev prev-stage-ph-outofprint-fp inactive"><span>Л</span></a>
                    <a data-jcarouselcontrol="true" href="#" class="next next-stage-ph-outofprint-fp"><span>Ы</span></a>
 </div>
</div>
<?
}
?>