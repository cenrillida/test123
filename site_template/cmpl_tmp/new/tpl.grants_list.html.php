<?php
echo "<h4>{$_TPL_REPLACMENT["GRANT_HEADER"]}:</h4>";
echo "<ul class='speclist'>";
var_dump($_TPL_REPLACMENT);
foreach($_TPL_REPLACMENT["GRANT_LIST"] as $row)
{
    if ($row["year_beg"]!=$row["year_end"]) $years=$row["year_beg"]."-".$row["year_end"]." ��."; else $years=$row["year_end"]." �.";
    echo "<li style='list-style-type: square'>".$row["title"]."<br />".
        "����� ����������: ".$years."<br />".
        "������������: ".$row["regalii"]." ".$row["fio"]."</li>";
}
echo "</ul>";