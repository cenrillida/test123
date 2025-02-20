<?php
$rest = new Rest();

$result = $rest->execute($_GET['method'],$_GET);

header('Content-Type: application/json');
echo json_encode($result);