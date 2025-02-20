<?

  global $DB,$_CONFIG;
mysql_connect($_CONFIG['global']['db_connect']['host'], $_CONFIG['global']['db_connect']['login'], $_CONFIG['global']['db_connect']['password']);
mysql_select_db($_CONFIG['global']['db_connect']['db_name']);

 $pic0=$DB->select("SELECT picsmall,picbig FROM publ WHERE id=".$_GET[id]);
  if (!empty($pic0[0][picsmall])) unlink($_CONFIG['global'][paths][admin_path]."pfoto/".$pic0[0][picsmall]);
  if (!empty($pic0[0][picbig])) unlink($_CONFIG['global'][paths][admin_path]."pfoto/".$pic0[0][picbig]);


 $result =  mysql_query('delete from persona where id='.$_GET['oi']);

  mysql_close();

?>

Удалено
