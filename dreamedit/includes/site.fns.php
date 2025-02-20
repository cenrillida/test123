<?

// ���������� ID ���� ������������ ������� ������� � ����� ������� � ���������� �������
function getParents($id)
{
	$arr = array();
	getParentsCallBack($arr, $id);
	return $arr;
}

// ����������� ������� ��� ������������ ������� ��������
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

// ���������� ID �������� ���������� ������
function getParentInLevel($id, $lvl)
{
	global $DB;

	$arr = getParents($id);
	return $arr[$lvl];
}
?>