<?

include_once "_include.php";

if(isset($_SESSION[$_CONFIG["global"]["general"]["sess_name"]])) 
{ 
	unset($_SESSION[$_CONFIG["global"]["general"]["sess_name"]]["a_id"]);
	session_destroy(); 
}

Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."login.php");
exit;

?>