<?php

session_start();

if(!$_SESSION[authorize]) {
    header('Location: https://imemo.ru/energyeconomics/admin/index.php');
    exit;
}

function download($file) {
	if (file_exists($file)) {
	    header('Content-Description: File Transfer');
	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename='.basename($file));
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($file));
	    readfile($file);
	    exit;
	}
}

if($_GET[file]=="oil") { 
	download("/home/imemon/html/energyeconomics/tables/oil_request.csv");
}
elseif ($_GET[file]=="ctl") {
	download("/home/imemon/html/energyeconomics/tables/ctl_request.csv");
}
elseif ($_GET[file]=="bio") {
	download("/home/imemon/html/energyeconomics/tables/bio_oil.csv");
}
elseif ($_GET[file]=="china_data") {
	download("/home/imemon/html/energyeconomics/tables/china_data.csv");
}
elseif ($_GET[file]=="saudi_data") {
	download("/home/imemon/html/energyeconomics/tables/saudi_data.csv");
}
else
echo "404 Not found";

?>