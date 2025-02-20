<?php
global $link,$p_id;

$inside_section=$link->query("SELECT * FROM adm_pages WHERE page_parent=".$p_id." ORDER BY page_position");

echo "<div class='font-big'><b>В этом разделе:</b>";
echo '<ul class="speclist">';
while($row2 = mysqli_fetch_array($inside_section)) {
    echo "<li><a href='/energyeconomics/index.php?page_id=$row2[page_id]'>$row2[page_name]</a></li>";
}
echo '</ul></div>';
?>