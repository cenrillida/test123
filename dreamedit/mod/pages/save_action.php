<?
include_once dirname(__FILE__)."/../../_include.php";

function updateChildPageUrl($page_id) {
    global $DB;
    $pg = new Pages();
    $childs = $pg->getChilds($page_id);
    foreach ($childs as $child) {
        if(!empty($child['page_urlname'])) {
            $parent_pages = $pg->getParents($child['page_parent']);
            $url = createUrl($child['page_urlname'], $parent_pages);
            $DB->query("UPDATE adm_pages SET page_urlname='".$url."' WHERE page_id=".$child['page_id']);
        }
        updateChildPageUrl($child['page_id']);
    }
}

function createUrl($data, $pages) {
    $page_url_name = "";
    if(!empty($pages)) {
        $pages_urls = explode("/", $data);
        $pages_urls = array_reverse($pages_urls);
        foreach ($pages as $page_k => $page) {
            $parent_pages_urls = explode("/", $page['page_urlname']);
            $parent_pages_urls = array_reverse($parent_pages_urls);
            if (!empty($page['page_urlname'])) {
                $page_url_name .= $parent_pages_urls[0]."/";
            }
        }
        $url = $page_url_name.$pages_urls[0];
        return $url;
    }
    return $data;
}

//        error_reporting(E_ALL);
//        ini_set('display_errors', 1);

ini_set('max_execution_time', 300);
ini_set('memory_limit', '512M');

// создаем массив постояннных значений
$query = array();

$pg = new Pages();
$pages = $pg->getParents($_REQUEST['parent']);

foreach($mod_array["components"] as $k => $v)
{
	if(!isset($v["field"]) || $k == "id")
		continue;

	$data = @$_REQUEST[$k];
	if($k == "status" || $k == "status_en" || $k == "dell" || $k == "noright" || $k == "notop" || $k == "noprint" || $k == "blank" || $k == "addmenu" || $k == "addmenuleft" || $k == "notshowmenu" || $k == "submenu_page_capitalize" || $k == "notshowchilds" || $k == "nobreadcrumbs" || $k == "nocomment" || $k == "activatestat" || $k == "mobile_right_totop" || $k == "submenu_bold" || $k == "menu_bold" || $k == "noactivemenulink" || $k == "title_uppercase" || $k == "archive_material" || $k == "to_pwjournal")
		$data = (int)@$_REQUEST[$k];

	if($k == "addmenusize") {
	    if(!empty($_REQUEST[$k])) {
	        $data = (int)@$_REQUEST[$k];
        } else {
	        $data = 0;
        }
    }


	if($k == "urlname")
	{
		$urlnameVars = Templater::getVarsFromStr($data);
		$urlData = "";
		if(!empty($urlnameVars))
		{
			$urlData = str_replace(array(".", "/"), array("\.", "\/"), $data);
			$urlData  = "^".preg_replace("/{[A-Z]+[A-Z_]*}/", "([a-zA-Z0-9_]+)", $urlData)."$";
		}
		$query[$v["field"]."_regexp"] = $urlData;

        if(!empty($data)) {
            $data = createUrl($data, $pages);
        }
//        if($_REQUEST["id"]==900) {
//            var_dump($_REQUEST["name"]);
//
//            if(!empty($_REQUEST["name_en"])) {
//                $latName = $_REQUEST["name_en"];
//            } else {
//                $latName = Dreamedit::cyrToLat($_REQUEST["name"]);
//            }
//
//            $latName = ltrim($latName);
//            $latName = str_replace(" ","-",$latName);
//            $latName = mb_strtolower($latName);
//            var_dump($latName);
//            exit;
//        }
 	}

	$query[$v["field"]] = $data;
}

// создаем массив значений контента
$content_query = array();
if(isset($tpl_vars))
{
	foreach($tpl_vars as $k => $v)
	{
		if(!isset($v["field"]))
			continue;

		$data = "";
		if(isset($_REQUEST[$k]))
			$data = $_REQUEST[$k];

		$content_query[strtoupper($v["field"])] = $data;
	}
}

if(!empty($_REQUEST["id"]))
{


	$DB->query("UPDATE ?_pages SET ?a WHERE ".$mod_array["components"]["id"]["field"] . " = ?d", $query, $_REQUEST["id"]);

	$DB->query("DELETE FROM ?_pages_content WHERE ".$mod_array["components"]["id"]["field"] . " = ?d", $_REQUEST["id"]);
	foreach($content_query as $k => $v)
	{
		$DB->query("INSERT INTO ?_pages_content SET ".$mod_array["components"]["id"]["field"] . " = ?d, cv_name = ?, cv_text = ?", $_REQUEST["id"], $k, $v);
	}
    updateChildPageUrl($_REQUEST["id"]);

    $cacheEngine = new CacheEngine();
    $cacheEngine->reset();

	Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"]."&action=edit&id=".$_REQUEST["id"]);
}
else
{
	$id = $DB->query("INSERT INTO ?_pages SET ?a", $query);

    $cacheEngine = new CacheEngine();
    $cacheEngine->reset();

	Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"]."&action=edit&id=".$id);
}

?>