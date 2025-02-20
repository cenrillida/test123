<?

  global $DB,$_CONFIG;
//mysql_connect($_CONFIG['global']['db_connect']['host'], $_CONFIG['global']['db_connect']['login'], $_CONFIG['global']['db_connect']['password']);
//mysql_select_db($_CONFIG['global']['db_connect']['db_name']);

 $pic0=$DB->select("SELECT picsmall,picbig FROM persons WHERE id=".$_REQUEST[id]);
  if (!empty($pic0[0][picsmall])) unlink($_CONFIG['global'][paths][admin_path]."pfoto/".$pic0[0][picsmall]);
  if (!empty($pic0[0][picbig])) unlink($_CONFIG['global'][paths][admin_path]."pfoto/".$pic0[0][picbig]);


 $result =  $DB->query('delete from persons where id='.$_REQUEST['id']);


?>

Удалено
