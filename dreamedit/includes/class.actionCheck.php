<?

class �heckAction
{
	/* ���������� ������� ��� ���������� ������� */

	// �������� ����������� action'� Add � ������ Ilines
	function checkIlinesAdd()
	{
		if(!isset($_REQUEST["type"]))
			return true;

		return false;
	}

	// �������� ����������� action'� Add � ������ Directory
	function checkDirectoriesAdd()
	{
		if(!isset($_REQUEST["type"]))
			return true;

		return false;
	}
	function checkNirsAdd()
	{
		if(!isset($_REQUEST["type"]))
			return true;

		return false;
	}
	function checkHeadersAdd()
	{
		if(!isset($_REQUEST["type"]))
			return true;

		return false;
	}
	function checkPollsAdd()
	{
		if(!isset($_REQUEST["type"]))
			return true;

		return false;
	}


	/* ����������� ������ */

	// �������� ����������� action'� Save
	function checkSave()
	{
		if(isset($_REQUEST["id"]) && $_REQUEST['action'] !== 'open_rating_iline')
				return true;

		if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "add")
				return true;

		return false;
	}

	// �������� ����������� action'� AddEl (���������)
	function checkAddEl()
	{
		if(isset($_REQUEST["id"]))
		{
			if(isset($_REQUEST["action"]) && ($_REQUEST["action"] == "edit"))
			{
				if(!isset($_REQUEST["type"]))
					return true;
			}
		}

		return false;
	}

	// �������� ����������� action'� Copy
	function checkCopy()
	{
//		if(isset($_REQUEST["id"]))
			return true;

		return false;
	}

	// �������� ����������� action'� Permissions
	function checkPermissions()
	{
		if(isset($_REQUEST["id"]) && isset($_REQUEST["action"]) && $_REQUEST["action"] == "edit")
			return true;

		return false;
	}

	// �������� ����������� action'� Del
	function checkDel()
	{
		if(isset($_REQUEST["id"]) && isset($_REQUEST["action"]) && $_REQUEST["action"] == "edit")
			return true;

		return false;
	}

	// �������� ����������� action'� Sort
	function checkSort()
	{
		if(isset($_REQUEST["id"]) && isset($_REQUEST["action"]) && $_REQUEST["action"] == "edit")
			return true;

		return false;
	}
	function checkCom()
	{
		if(isset($_REQUEST["id"]) && isset($_REQUEST["action"]) && $_REQUEST["action"] == "edit")
			return true;

		return false;
	}

	function checkIlinesType() {
        if(isset($_REQUEST["id"]) && isset($_REQUEST["action"]) && $_REQUEST["action"] == "edit" && $_REQUEST["type"]=="l")
            return true;

        return false;
    }
}
?>