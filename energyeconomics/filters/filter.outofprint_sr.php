<?php
global $link;

$query = "SELECT id,name,picbig FROM publ WHERE out_from_print=1 AND picbig!=''" or die("Error in the consult.." . mysqli_error($link)); 
$result = $link->query($query); 
if($result->num_rows==0)
    echo '<p>На данный момент список презентаций книг пуст</p>';
else
{
?>
<div class="connected-carousels">
<div class="stage" style="width: 300">
                    <div data-jcarousel="true" class="carousel carousel-stage-ph-outofprint">
                        <ul style="left: 0px; top: 0px;">
                        	<?php
                        	while($row = mysqli_fetch_array($result)) 
                            {
                                echo '<li><table width=300><tr><td align="center"><a target=_blank title="'.$row[name].'" href=../index.php?page_id=645&amp;id='.$row[id].'><img src="../dreamedit/pfoto/'.$row['picbig'].'" alt="" height="240" width="180"></a></td></tr></table></li>';
                            }
							?>
                        </ul>
                    </div>
                    
                    <a data-jcarouselcontrol="true" href="#" class="prev prev-stage-ph-outofprint inactive"><span>‹</span></a>
                    <a data-jcarouselcontrol="true" href="#" class="next next-stage-ph-outofprint"><span>›</span></a>
 </div>
</div>
<?
}
?>