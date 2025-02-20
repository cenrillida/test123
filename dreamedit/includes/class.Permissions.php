<?

class Permissions
{
/*
	function __construct()
	{
	
	}

	function Permissions()
	{
		$this->__construct();
	}
*/

	// ��������� ���� �������
	function setPermissions($id)
	{
		global $DB;

		$retVal = array();
		foreach($DB->select("SELECT * FROM ?_permissions WHERE a_id = ?d ", $id) as $v)
			$retVal[$v["permit_obj"]] = 1;

		return $retVal;
	}

	// �������� ���� ������� �� ������
	function checkModPermit($pData, $modName)
	{
		return (isset($pData["all"]) || isset($pData["modules|".$modName]));
	}

	// �������� ���� ������� �� �������� � ������
	function checkActionPermit($pData, $modName, $actName)
	{
		global $DB;

		$registredActions = $DB->select("SELECT ?_actions.act_name AS ARRAY_KEY, ?_actions.* FROM ?_actions");
		return (!isset($registredActions[$actName]) || isset($pData["all"]) || isset($pData["actions|".$modName."|".$actName]));
	}

}

?>