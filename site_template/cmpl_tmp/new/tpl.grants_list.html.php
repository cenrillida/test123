<?php
echo "<h4>{$_TPL_REPLACMENT["GRANT_HEADER"]}:</h4>";
echo "<ul class='speclist'>";
var_dump($_TPL_REPLACMENT);
foreach($_TPL_REPLACMENT["GRANT_LIST"] as $row)
{
    if ($row["year_beg"]!=$row["year_end"]) $years=$row["year_beg"]."-".$row["year_end"]." гг."; else $years=$row["year_end"]." г.";
    echo "<li style='list-style-type: square'>".$row["title"]."<br />".
        "Сроки выполнения: ".$years."<br />".
        "Руководитель: ".$row["regalii"]." ".$row["fio"]."</li>";
}
echo "</ul>";