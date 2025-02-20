<?
// Вышли из печати

global $DB,$_CONFIG;
if ($_SESSION[lang]!='/en')
{
$rows=$DB->select("SELECT id,name
	FROM publ
	WHERE out_from_print=1 AND status=1
                ");
}
else
{
$rows=$DB->select("SELECT id,name2
	FROM publ
	WHERE out_from_print=1 AND status=1
                ");
}

if(count($rows>0))
{
	foreach($rows as $row)
	{
		if ($_SESSION[lang]!='/en')
		{
			echo "<p align=justify><strong><a target=_blank href=https://imemo.ru/index.php?page_id=645&amp;id=".$row[id]."><img alt= width=16 height=16 hspace=3 src=https://imemo.ru/files/Image/button.png /></a></strong><strong><a target=_blank href=https://imemo.ru/index.php?page_id=645&amp;id=".$row[id].">".$row['name']."</a></strong><strong> </strong></p>";
		}
		else
		{
					echo "<p align=justify><strong><a target=_blank href=https://imemo.ru/en/index.php?page_id=645&amp;id=".$row[id]."><img alt= width=16 height=16 hspace=3 src=https://imemo.ru/files/Image/button.png /></a></strong><strong><a target=_blank href=https://imemo.ru/en/index.php?page_id=645&amp;id=".$row[id].">".$row['name2']."</a></strong><strong> </strong></p>";
		}
	}
}

?>
