<?

  global $DB,$_CONFIG;
  mysql_connect($_CONFIG['global']['db_connect']['host'], $_CONFIG['global']['db_connect']['login'], $_CONFIG['global']['db_connect']['password']);
  mysql_select_db($_CONFIG['global']['db_connect']['db_name']);

  $pic0=$DB->select("SELECT picsmall,picbig FROM publ WHERE id=".$_GET[id]);
  if (!empty($pic0[0][picsmall])) unlink($_CONFIG['global'][paths][admin_path]."pfoto/".$pic0[0][picsmall]);
  if (!empty($pic0[0][picbig])) unlink($_CONFIG['global'][paths][admin_path]."pfoto/".$pic0[0][picbig]);

  $result =  mysql_query('delete from publ where id='.$_GET['id']);

  mysql_close();

?>

ѕубликаци€ удалена.
<br>
¬ы будете перенаправлены на главную страницу через 3 секунды

<meta http-equiv=refresh content="3; url=index.php?mod=public">
