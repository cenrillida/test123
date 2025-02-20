<?

function checkUserAgent()
{
	$bInfo = detect_browser();

	if($bInfo["name"] == "MSIE" || $bInfo["name"] == "Netscape")
		return true;

	return false;
}

function detect_browser()
{ 
	$bInfo = array();
	// Browser 
	if(eregi("(opera) ([0-9]{1,2}.[0-9]{1,3}){0,1}", $_SERVER["HTTP_USER_AGENT"], $match) || eregi("(opera/)([0-9]{1,2}.[0-9]{1,3}){0,1}", $_SERVER["HTTP_USER_AGENT"], $match)) 
	{ 
		$bInfo["name"]    = "Opera"; 
		$bInfo["version"] = $match[2]; 
	} 
	elseif(eregi("(konqueror)/([0-9]{1,2}.[0-9]{1,3})", $_SERVER["HTTP_USER_AGENT"], $match)) 
	{ 
		$bInfo["name"]    = "Konqueror"; 
		$bInfo["version"] = $match[2]; 
	} 
	elseif(eregi("(lynx)/([0-9]{1,2}.[0-9]{1,2}.[0-9]{1,2})", $_SERVER["HTTP_USER_AGENT"], $match)) 
	{ 
		$bInfo["name"]    = "Lynx "; 
		$bInfo["version"] = $match[2]; 
	} 
	elseif(eregi("(links) \(([0-9]{1,2}.[0-9]{1,3})", $_SERVER["HTTP_USER_AGENT"], $match)) 
	{ 
		$bInfo["name"]    = "Links "; 
		$bInfo["version"] = $match[2]; 
	} 
	elseif(eregi("(msie) ([0-9]{1,2}.[0-9]{1,3})", $_SERVER["HTTP_USER_AGENT"], $match)) 
	{ 
		$bInfo["name"]    = "MSIE"; 
		$bInfo["version"] = $match[2]; 
	} 
	elseif(eregi("(netscape6)/(6.[0-9]{1,3})", $_SERVER["HTTP_USER_AGENT"], $match)) 
	{ 
		$bInfo["name"]    = "Netscape"; 
		$bInfo["version"] = $match[2]; 
	} 
	elseif(eregi("mozilla/5",$_SERVER["HTTP_USER_AGENT"])) 
	{ 
		$bInfo["name"]    = "Netscape"; 
		$bInfo["version"] = "Unknown"; 
	} 
	elseif(eregi("(mozilla)/([0-9]{1,2}.[0-9]{1,3})", $_SERVER["HTTP_USER_AGENT"], $match)) 
	{ 
		$bInfo["name"]    = "Netscape"; 
		$bInfo["version"] = $match[2]; 
	} 
	elseif(eregi("w3m", $_SERVER["HTTP_USER_AGENT"])) 
	{ 
		$bInfo["name"]    = "w3m"; 
		$bInfo["version"] = "Unknown"; 
	} 
	else
	{
		$bInfo["name"]    = "Unknown"; 
		$bInfo["version"] = "Unknown";
	} 

	return $bInfo;
}
?>