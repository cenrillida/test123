<?
include_once dirname(__FILE__)."/../../_include.php";

$cacheEngine = new CacheEngine();
$cacheEngine->reset();

Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"]."&reset=1");

?>