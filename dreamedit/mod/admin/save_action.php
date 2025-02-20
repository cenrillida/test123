<?
include_once dirname(__FILE__)."/../../_include.php";


$query = array();
foreach($mod_array["components"] as $k => $v)
{
	if(!isset($v["field"]) || $k == "id" || ($k == "pass" && trim($_REQUEST[$k]) == ""))
		continue;

	$data = $_REQUEST[$k];

	if(!isset($_REQUEST[$k]))
		$data = 0;

	if($k == "pass")
	{
		$data = md5(md5("пароль".$query[a_login]));
		$pass=$_REQUEST[$k];


    }
    if ($k=='hach')
        $data=hash_hmac('ripemd160',$query[a_login], $pass);
	$query[$v["field"]] =  $data;
}

if(!empty($_REQUEST["id"]))
{
	$DB->query("UPDATE  ?_admin SET ?a WHERE " . $mod_array["components"]["id"]["field"] . " = ?d", $query, $_REQUEST["id"]);
//	$DB->query("UPDATE ?_admin set a_hach=".hash_hmac('ripemd160', 'shef', 'master');
	$id = (int)$_REQUEST["id"];
}
else
{
	$id = $DB->query("INSERT INTO ?_admin SET ?a", $query);
}

Dreamedit::sendLocationHeader("https://" . $_CONFIG["global"]["paths"]["site"] . $_CONFIG["global"]["paths"]["admin_dir"] . "index.php?mod=" . $_REQUEST["mod"] . "&action=edit&id=" . $id);

?>