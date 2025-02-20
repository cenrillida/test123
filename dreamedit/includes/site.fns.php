<?

// вытаскиаем ID всех родительских страниц начиная с самой верхней и заканчивая текущей
function getParents($id)
{
	$arr = array();
	getParentsCallBack($arr, $id);
	return $arr;
}

// рекурсивная функция для вытаскивания нужного родителя
function getParentsCallBack(&$parentsArr, $id)
{
	global $DB;

	array_unshift($parentsArr, (int)$id);

	$parent_id = $DB->selectCell("SELECT page_parent FROM ?_pages WHERE page_id = ?d", $id);
	if($parent_id != 0)
	{
		getParentsCallBack($parentsArr, $parent_id);
	}
	return;
}

// вытаскиаем ID родителя требуемого уровня
function getParentInLevel($id, $lvl)
{
	global $DB;

	$arr = getParents($id);
	return $arr[$lvl];
}
?>