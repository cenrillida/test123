<?php
	$enctype = isset($enctype) ? " enctype=\"$enctype\"" : "";
	print "<form name=\"$name\" id=\"$name\" method=\"POST\" action=\"$action\"$enctype>\n";
?>
<table border="0" cellpadding="5" cellspacing="0" width="100%">
