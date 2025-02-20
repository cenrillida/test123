<?
include_once dirname(__FILE__)."/../../_include.php";


if($type == "l")
{
	$lid = isset($_REQUEST["lid"])? (int)$_REQUEST["lid"]: $DB->query("INSERT INTO ?_ilines_element SET itype_id = ?d, el_date = UNIX_TIMESTAMP()", $_REQUEST["id"]);

	$DB->query("DELETE FROM ?_ilines_content WHERE el_id = ?d", $lid);

	$urlKey = -1;
    foreach($phorm->data() as $k => $v) {
        if(!isset($v["field"]))
            continue;

        if($v["field"]=="iline_url") {
            $urlKey = $k;
        }
        if($v["field"]=="title") {
            $titleKey = $k;
        }
        if($v["field"]=="title_en") {
            $titleKeyEn = $k;
        }
    }

    if($urlKey!=-1) {
        if (empty($_REQUEST[$urlKey])) {
            if (!empty($_REQUEST[$titleKeyEn])) {
                $latName = Dreamedit::cyrToLat($_REQUEST[$titleKeyEn]);
            } else {
                $latName = Dreamedit::cyrToLat($_REQUEST[$titleKey]);
            }
            $latName = str_replace("(", "-", $latName);
            $latName = str_replace(")", "-", $latName);
            $latName = preg_replace("/[^a-zA-Z-\d ]/", "", $latName);
            $latName = preg_replace("/ +/", " ", $latName);

            $latName = ltrim(rtrim($latName));
            $latName = str_replace(" ", "-", $latName);
            $latName = preg_replace("/-+/", "-", $latName);
            $latName = ltrim(rtrim($latName,"-"),"-");
            $latName = mb_strtolower($latName);

            $latName = Dreamedit::cyrToLatExcl($latName);



        } else {
            $latName = $_REQUEST[$urlKey];
        }

        while (true) {
            $used = $DB->select("SELECT * FROM adm_ilines_content WHERE icont_var='iline_url' AND icont_text=?",$latName);

            if (!empty($used)) {
                $latName .= "-" . $lid;
            } else {
                break;
            }
        }

        $_REQUEST[$urlKey] = $latName;

    }

	foreach($phorm->data() as $k => $v)
	{
		if(!isset($v["field"]))
			continue;

		$DB->query("INSERT INTO ?_ilines_content SET el_id = ?d, icont_var = ?, icont_text = ?", $lid, $v["field"], $_REQUEST[$k]);
		if($v["field"]=="date2")
			$DB->query("INSERT INTO ?_ilines_content SET el_id = ?d, icont_var = ?, icont_text = ?", $lid, "date_s", $_REQUEST[$k]);
	}

    $cacheEngine = new CacheEngine();
    $cacheEngine->reset();
	Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"]."&action=edit&type=l&id=".$lid);
}
else
{
	$query = array();
	foreach($phorm->data() as $k => $v)
	{
		if(!isset($v["field"]) || $k == "id")
			continue;

		$data = $_REQUEST[$k];
		if(!isset($_REQUEST[$k]))
			$data = 0;

		$query[$v["field"]] = $data;
	}

	if(!empty($id))
	{
		$DB->query("UPDATE ?_ilines_type SET ?a WHERE ".$mod_array["components"]["id"]["field"]." = ?d", $query, $id);
	}
	else
	{
		$id = $DB->query("INSERT INTO ?_ilines_type SET ?a", $query);
	}

    $cacheEngine = new CacheEngine();
    $cacheEngine->reset();
	Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"]."&action=edit&id=".$id);
}

?>