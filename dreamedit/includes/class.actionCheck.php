<?

class СheckAction
{
	/* Расширение методов для конкретных модулей */

	// проверка доступности action'а Add в модуле Ilines
	function checkIlinesAdd()
	{
		if(!isset($_REQUEST["type"]))
			return true;

		return false;
	}

	// проверка доступности action'а Add в модуле Directory
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


	/* Стандартные методы */

	// проверка доступности action'а Save
	function checkSave()
	{
		if(isset($_REQUEST["id"]) && $_REQUEST['action'] !== 'open_rating_iline')
				return true;

		if(isset($_REQUEST["action"]) && $_REQUEST["action"] == "add")
				return true;

		return false;
	}

	// проверка доступности action'а AddEl (инфоленты)
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

	// проверка доступности action'а Copy
	function checkCopy()
	{
//		if(isset($_REQUEST["id"]))
			return true;

		return false;
	}

	// проверка доступности action'а Permissions
	function checkPermissions()
	{
		if(isset($_REQUEST["id"]) && isset($_REQUEST["action"]) && $_REQUEST["action"] == "edit")
			return true;

		return false;
	}

	// проверка доступности action'а Del
	function checkDel()
	{
		if(isset($_REQUEST["id"]) && isset($_REQUEST["action"]) && $_REQUEST["action"] == "edit")
			return true;

		return false;
	}

	// проверка доступности action'а Sort
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