<?php

$url = 'http://rf.revolvermaps.com/w/2/a/a2.php?i=56ovy43nr90&m=8&s=142&c=54ff00&t=1';
$content = file_get_contents($url);
$content = str_replace("/w/s/a","//rf.revolvermaps.com/w/s/a",$content);
echo $content;