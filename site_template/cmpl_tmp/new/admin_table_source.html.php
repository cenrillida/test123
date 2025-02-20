<?php

global $_CONFIG;
 
$path = str_replace('/dreamedit/','',$_CONFIG['global']['paths']['admin_path']);

require($path."/js/dhtmlx/dhtmlxConnector/codebase/config.php");


require_once($path."/js/dhtmlx/dhtmlxConnector/codebase/grid_connector.php");



$res=mysql_connect($mysql_server,$mysql_user,$mysql_pass);
mysql_select_db($mysql_db); 
if (empty($_REQUEST[ex])) 
  $where=1;
else
  $where=" journal=". $_REQUEST[ex];
 
 	$grid = new GridConnector($res);

 	$grid->enable_live_update('actions_table');
	

	$grid->enable_log("put_sql.log",true);

	//$grid->sql->attach("update","UPDATE vuz_total SET finished='1'");
	
	$grid->dynamic_loading(100);
	
	
	$grid->set_encoding("windows-1251");
	//$grid->render_table("vuz_total","id","new_name,date_beg,date_end");window.location = \"start.html?v=',vuz_id,'\"; 
	$grid->render_sql("SELECT id AS gr_id,CONCAT('<span style=\'font-size:14px;color:red\'>X</span>','^javascript:deleteLogin(',id,',\"','удалить','\")','^_self') AS ex,id,
	CONCAT(name,'<br />',name_en) AS name,
	CONCAT(fio,'<br />',fio_en) AS fio,CONCAT(affiliation,'<br />',affiliation_en) AS affiliation,rubric,CONCAT('<a href=mailto:',email,'>',email,'</a>') AS email,
	IF (file<>'',	CONCAT('<a href=\"email.php?file=/article_bank/',file,'&email=',email,'&name=',REPLACE(name,'\"',''),'&fio=',REPLACE(fio,'\"',''),'\">Открыть текст</a>'),' ') AS file,date,".
	"  date_rez,rez_type,primech_rez,date_publ,publ_type,primech  ".
	                              // '^javascript:deleteLogin(',V.id,',\"',L.pswd,'\")'
	" FROM article_send WHERE del='' 
	AND ".$where.
	 " ORDER BY name ASC"    
	,"gr_id","ex,name,fio,affiliation,email,rubric,file,date,date_rez,rez_type,primech_rez,date_publ,publ_type,primech");
	//$grid->render_sql("SELECT CONCAT(new_name,'^javascript:(function(){document.cookie=\"csi=',vuz_id-1,'; path=/\"; ;window.location =\"http://csi.socioprognoz.ru/start.html?v=',vuz_id,'\", \"\", \"\";})();') AS new_name,date_beg,date_end, inter_day+inter_zaoch as inter_count FROM vuz_total","id","new_name,date_beg,date_end, inter_count"); 
?>


