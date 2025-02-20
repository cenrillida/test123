<?

class Dreamedit
{

	function __construct()
	{

	}

	function Dreamedit()
	{
		$this->__construct();
	}


	// функция обновления модулей и action'ов
	function updateRegistredObjects()
	{
		global $_CONFIG, $DB;

		// создаем массив имеющихся модулей
		$mod_array = array();
		$mod_array = $DB->select("SELECT ?_modules.mod_name as ARRAY_KEY, ?_modules.* FROM ?_modules");

		// создаем массив имеющихся action'ов
		$act_array = array();
		$act_array = $DB->select("SELECT ?_actions.act_name AS ARRAY_KEY, ?_actions.* FROM ?_actions");

		// пробегаем по конфигам всех модулей
		foreach(glob($_CONFIG["global"]["paths"]["mod_dir"]."*/mod.ini") as $config_filename)
		{
			$conf = parse_ini_file($config_filename, true);

			// если модуля в базе еще нет - записываем
			if(!isset($mod_array[$conf["general"]["name"]]))
			{
				$DB->query("INSERT INTO ?_modules (mod_name, mod_update) VALUES (?, UNIX_TIMESTAMP())", $conf["general"]["name"]);
	//			$mod_array[$conf["general"]["name"]]["mod_update"] = filemtime($config_filename);
			}
			// отмечаем существование модуля
			$mod_array[$conf["general"]["name"]]["exists"] = 1;

			// пробегаем по всем action'ам модуля
			if(!isset($conf["actions"]))
				continue;

			foreach($conf["actions"] as $k => $v)
			{
				if(isset($_CONFIG["action"][$k]["special"]))
					continue;

				// если action'а в базе нету, то записываем
				if(!isset($act_array[$k]))
					$DB->query("INSERT INTO ?_actions (act_name) VALUES (?)", $k);

				// отмечаем существование action'а
				$act_array[$k]["exists"] = 1;
			}
		}

		// удаляем все записи связанные с несуществующиими модулями
		$mod_delete = array();
		foreach($mod_array as $k => $v)
		{
			if(!isset($v["exists"]))
				$mod_delete[] = $v["mod_id"];
		}
		if(count($mod_delete))
		{
			$DB->query("DELETE FROM ?_modules WHERE mod_id IN (?a)", $mod_delete);
	// сделать запрос с регуляркой для удаления прав на модули
	//		$DB->query("DELETE FROM ?_admin_modules_actions WHERE mod_id IN (?a)", $mod_delete);
		}

		// удаляем все записи связанные с несуществующиими action'ами (хотя они не будут мешать)
		$act_delete = array();
		foreach($act_array as $k => $v)
		{
			if(!isset($v["exists"]))
				$act_delete[] = $v["act_id"];
		}
		if(count($act_delete))
		{
			$DB->query("DELETE FROM ?_actions WHERE act_id IN (?a)", $act_delete);
	// сделать запрос с регуляркой для удаления прав на несуществующие действия (хотя они не будут мешать)
	//		$DB->query("DELETE FROM ?_admin_modules_actions WHERE action_id IN (?a)", $act_delete);
		}

		// теперь проверяем наличие всех модулей
		$mod_array = $DB->select('SELECT mod_name AS ARRAY_KEY, ?_modules.* FROM ?_modules');
		if(empty($mod_array))
			die(Dreamedit::translate("Нет установленых модулей"));
	}

	// функция удаления устаревших логов
	function cleanLogs()
	{
		global $_CONFIG;

		foreach(glob($_CONFIG["global"]["paths"]["admin_path"].$_CONFIG["global"]["paths"]["log_dir"]."*.log") as $v)
		{
			// если лог хранится дольше чем указанно в конфиге - удалям
			if(date("d", time() - filemtime($v)) > $_CONFIG["global"]["general"]["log_archiv"])
				unlink($v);
		}
	}

	// расширенная функция для парсинга ini файлов
	function parseConfigIni($file, $separator)
	{
		$data = parse_ini_file($file, true);
		foreach($data as $key => $settings)
		{
			$a = &$config;
			foreach(explode($separator, $key) as $part)
				$a = &$a[$part];

			$a = $settings;
		}

		return $config;
	}

	// перевод
	function translate($txt)
	{
	//	return _($txt);
		return $txt;
	}

	// избавляемся от MagicQuotes
	function removeMagicQuotes()
	{
		// избавляемся от паразитического magic quots GET POST COOKIE
		if(get_magic_quotes_gpc())
		{
			Dreamedit::stripSlashesRecursive($_GET);
			Dreamedit::stripSlashesRecursive($_POST);
			Dreamedit::stripSlashesRecursive($_COOKIE);
			Dreamedit::stripSlashesRecursive($_REQUEST);
			Dreamedit::stripSlashesRecursive($_SERVER); // пока глюков не обнаружено!!!
		}
		// избавляемся от паразитического magic quots RUNTIME
		if(get_magic_quotes_runtime())
			set_magic_quotes_runtime(0);
	}

	// убираем лишние слеши
	function stripSlashesRecursive(&$el)
	{
		if(is_array($el))
		{
			foreach($el as $k=>$v)
				Dreamedit::stripSlashesRecursive($el[$k]);
		}
		else
		{
			$el = stripslashes($el);
		}
	}

	// обновление сессии, надо пересмотреть
	function updateSession($a_id)
	{
		global $_CONFIG, $DB;

		// уничтожаем старую сессию
		if(isset($_SESSION[$_CONFIG["global"]["general"]["sess_name"]]))
			unset($_SESSION[$_CONFIG["global"]["general"]["sess_name"]]);


		// вытаскиваем обновленные данные
		$sess_res = $DB->selectRow("SELECT * FROM ?_admin WHERE a_id = ?d AND a_status = 1", $a_id);

        // если пользователь удален или отключен не регестрируем новую сессию
		if(empty($sess_res))
			return;

		// регистрируем новую сессию
		$_SESSION[$_CONFIG["global"]["general"]["sess_name"]] = $sess_res;
		$_SESSION[$_CONFIG["global"]["general"]["sess_name"]]["access"] = Permissions::setPermissions($a_id);
	}

	// Сформировать массив (дочерних) страниц для построения дерева
	function createTreeArrayFromPages($rows, $url)
	{
		// mytree.add(id, pid, name, url, title, target, icon, iconOpen, open);
		$treeArr = array();
		foreach($rows as $k => $v)
		{
			$img = !empty($v["page_link"])? "link": "page";
			if(empty($v["page_status"]))
				$img .= "Gray";

			$treeArr[$k]			 = array();
			$treeArr[$k]["pid"]		 = @$v["page_parent"];
			$treeArr[$k]["name"]	 = @$v["page_name"];
			$treeArr[$k]["url"]		 = str_replace(array("{ID}", "{URL}", "{PAGE_NAME}"), array($k, Pages::getPageUrl($k, array(), $rows), @$v["page_name"]), $url);
			$treeArr[$k]["title"]    = @$v["page_name"]." (ID: ".$k.")";
			$treeArr[$k]["target"]	 = null;
			$treeArr[$k]["icon"]	 = $img.".gif";
			$treeArr[$k]["iconOpen"] = $img.".gif";
			$treeArr[$k]["open"]     = false;
		}

		return $treeArr;
	}
	// Сформировать массив (дочерних) страниц для построения дерева помощи
	function createTreeArrayFromHelpers($rows, $url)
	{
		// mytree.add(id, pid, name, url, title, target, icon, iconOpen, open);
		$treeArr = array();
		foreach($rows as $k => $v)
		{
			$img = !empty($v["page_link"])? "link": "page";
			if(empty($v["page_status"]))
				$img .= "Gray";

			$treeArr[$k]			 = array();
			$treeArr[$k]["pid"]		 = @$v["page_parent"];
			$treeArr[$k]["name"]	 = @$v["page_name"];
			$treeArr[$k]["url"]		 = str_replace(array("{ID}", "{URL}", "{PAGE_NAME}"), array($k, Pages::getPageUrl($k, array(), $rows), @$v["page_name"]), $url);
			$treeArr[$k]["title"]    = @$v["page_name"]." (ID: ".$k.")";
			$treeArr[$k]["target"]	 = null;
			$treeArr[$k]["icon"]	 = $img.".gif";
			$treeArr[$k]["iconOpen"] = $img.".gif";
			$treeArr[$k]["open"]     = false;
		}

		return $treeArr;
	}
		// Сформировать массив (дочерних) страниц для построения дерева журналов
	function createTreeArrayFromMagazine($rows, $url)
	{
		// mytree.add(id, pid, name, url, title, target, icon, iconOpen, open);
		$treeArr = array();
		foreach($rows as $k => $v)
		{
			$img = !empty($v["page_link"])? "link": "page";
			if(empty($v["page_status"]))
				$img .= "Gray";

			$treeArr[$k]			 = array();
			$treeArr[$k]["pid"]		 = @$v["page_parent"];
			$treeArr[$k]["name"]	 = @$v["page_name"];
			$treeArr[$k]["url"]		 = str_replace(array("{ID}", "{URL}", "{PAGE_NAME}"), array($k, Magazine::getPageUrl($k, array(), $rows), @$v["page_name"]), $url);
			$treeArr[$k]["title"]    = @$v["page_name"]." (ID: ".$k.")";
			$treeArr[$k]["target"]	 = null;
			$treeArr[$k]["icon"]	 = $img.".gif";
			$treeArr[$k]["iconOpen"] = $img.".gif";
			$treeArr[$k]["open"]     = false;
		}

		return $treeArr;
	}
    // Сформировать массив (дочерних) страниц для построения дерева статей
	function createTreeArrayFromArticle($rows, $url)
	{
		// mytree.add(id, pid, name, url, title, target, icon, iconOpen, open);
		$treeArr = array();
//		print_r($rows);
		foreach($rows as $k => $v)
		{
			$img = !empty($v["page_link"])? "link": "page";
			if(empty($v["page_status"]))
				$img .= "Gray";

			$treeArr[$k]			 = array();
			$treeArr[$k]["pid"]		 = @$v["page_parent"];
			if ($v[page_template]=='jnumber')
				$treeArr[$k]["name"]	 = @$v["j_name"]."-".$v["year"]."-".$v["page_name"];
			else
				$treeArr[$k]["name"]	 = @$v["page_name"];

			$treeArr[$k]["url"]		 = str_replace(array("{ID}", "{URL}", "{PAGE_NAME}"), array($k, Article::getPageUrl($k, array(), $rows), @$v["page_name"]), $url);
			$treeArr[$k]["title"]    = @$v["page_name"]." (ID: ".$k.")";
			$treeArr[$k]["target"]	 = null;
			$treeArr[$k]["icon"]	 = $img.".gif";
			$treeArr[$k]["iconOpen"] = $img.".gif";
			$treeArr[$k]["open"]     = false;
		}

		return $treeArr;
	}
	// Сформировать массив Персон
	function createTreeArrayFromPersons($rows, $url)
	{
		// mytree.add(id, pid, name, url, title, target, icon, iconOpen, open);
		$treeArr = array();
		foreach($rows as $k => $v)
		{
//			$img = !empty($v["page_link"])? "link": "page";

			$treeArr[$k]			 = array();
			$treeArr[$k]["pid"]		 = @$v["id"];
			$treeArr[$k]["name"]	 = @$v["surname"];
//			$treeArr[$k]["url"]		 = str_replace(array("{ID}", "{URL}", "{PAGE_NAME}"), array($k, Pages::getPageUrl($k, array(), $rows), @$v["page_name"]), $url);
			$treeArr[$k]["title"]    = @$v["surname"]." (ID: ".$k.")";
			$treeArr[$k]["target"]	 = null;
			$treeArr[$k]["icon"]	 = $img.".gif";
			$treeArr[$k]["iconOpen"] = $img.".gif";
			$treeArr[$k]["open"]     = false;
		}

		return $treeArr;
	}


	// Сформировать массив (дочерних) страниц для построения дерева
	function createTreeArrayFromIlines($types, $elements)
	{
		global $_CONFIG, $_ACTIVE;
		// mytree.add(id, pid, name, url, title, target, icon, iconOpen, open);

		$treeArr = array();
		foreach($types as $k => $v)
		{
			$treeArr["t".$k]			 = array();
			$treeArr["t".$k]["pid"]		 = "t0";
			$treeArr["t".$k]["name"]	 = $v["itype_name"];
			$treeArr["t".$k]["url"]		 = "https://" . $_CONFIG["global"]["paths"]["site"] . $_CONFIG["global"]["paths"]["admin_dir"] . "index.php?mod=" . $_ACTIVE["mod"] . "&action=edit&id=" . $v["itype_id"];
			$treeArr["t".$k]["title"]    = $v["itype_name"] . " (ID: ".$v["itype_id"].")";
			$treeArr["t".$k]["target"]	 = null;
			$treeArr["t".$k]["icon"]	 = "folder.gif";
			$treeArr["t".$k]["iconOpen"] = "folderopen.gif";
			$treeArr["t".$k]["open"]     = false;
            $treeArr["t".$k]["cleanId"]     = $k;
		}

		foreach($elements as $elID => $el)
		{
			// выбираем нужную картинку
			$img = "page";
			if(!empty($types[$el["itype_id"]]["itype_el_status"]))
			{
				$state = explode(",", $types[$el["itype_id"]]["itype_el_status"]);
				$status = 0;
				foreach($state as $v)
				{
					if(empty($el["content"][strtoupper(trim($v))]))
						$status++;
				}

				if(count($state) > 0 && $status == count($state))
					$img .= "Gray";
			}

			// в зависимости от заданной структуры отображаем элементы
			$iline_tpl = new Templater();
			$iline_tpl->setValues($el["content"]);
			$el_name = $iline_tpl->getResultFromString($types[$el["itype_id"]]["itype_el_structure"]);

			$treeArr["l".$elID]				= array();
			$treeArr["l".$elID]["pid"]		= "t".$el["itype_id"];
			$treeArr["l".$elID]["name"]		= $el_name;
			$treeArr["l".$elID]["url"]		= "https://" . $_CONFIG["global"]["paths"]["site"] . $_CONFIG["global"]["paths"]["admin_dir"] . "index.php?mod=" . $_ACTIVE["mod"] . "&action=edit&type=l&id=" . $elID;
			$treeArr["l".$elID]["title"]    = $el_name." (ID: ".$elID.")";
			$treeArr["l".$elID]["target"]	= null;
			$treeArr["l".$elID]["icon"]		= $img.".gif";
			$treeArr["l".$elID]["iconOpen"] = $img.".gif";
			$treeArr["l".$elID]["open"]     = false;
            $treeArr["l".$elID]["cleanId"]     = $elID;
		}

		return $treeArr;
	}

    // Сформировать массив (дочерних) страниц для построения дерева
    function createTreeArrayFromIlinesForAuto($types)
    {
        global $_CONFIG, $_ACTIVE;
        // mytree.add(id, pid, name, url, title, target, icon, iconOpen, open);

        $treeArr = array();
        foreach($types as $k => $v)
        {
            if(empty($v['itype_auto_structure']))
                continue;
            $treeArr["t".$k]			 = array();
            $treeArr["t".$k]["pid"]		 = "t0";
            $treeArr["t".$k]["name"]	 = $v["itype_name"];
            $treeArr["t".$k]["url"]		 = "https://" . $_CONFIG["global"]["paths"]["site"] . $_CONFIG["global"]["paths"]["admin_dir"] . "index.php?mod=" . $_ACTIVE["mod"] . "&action=edit&id=" . $v["itype_id"];
            $treeArr["t".$k]["title"]    = $v["itype_name"] . " (ID: ".$v["itype_id"].")";
            $treeArr["t".$k]["target"]	 = null;
            $treeArr["t".$k]["icon"]	 = "cd.gif";
            $treeArr["t".$k]["iconOpen"] = "cd.gif";
            $treeArr["t".$k]["open"]     = false;
            $treeArr["t".$k]["cleanId"]     = $k;
        }

        return $treeArr;
    }

	function createTreeArrayFromIBlogs($types, $elements)
	{
		global $_CONFIG, $_ACTIVE;
		// mytree.add(id, pid, name, url, title, target, icon, iconOpen, open);

		$treeArr = array();
		foreach($types as $k => $v)
		{
			$treeArr["t".$k]			 = array();
			$treeArr["t".$k]["pid"]		 = "t0";
			$treeArr["t".$k]["name"]	 = $v["itype_name"];
			$treeArr["t".$k]["url"]		 = "https://" . $_CONFIG["global"]["paths"]["site"] . $_CONFIG["global"]["paths"]["admin_dir"] . "index.php?mod=" . $_ACTIVE["mod"] . "&action=edit&id=" . $v["itype_id"];
			$treeArr["t".$k]["title"]    = $v["itype_name"] . " (ID: ".$v["itype_id"].")";
			$treeArr["t".$k]["target"]	 = null;
			$treeArr["t".$k]["icon"]	 = "folder.gif";
			$treeArr["t".$k]["iconOpen"] = "folderopen.gif";
			$treeArr["t".$k]["open"]     = false;
		}

		foreach($elements as $elID => $el)
		{
			// выбираем нужную картинку
			$img = "page";
			if(!empty($types[$el["itype_id"]]["itype_el_status"]))
			{
				$state = explode(",", $types[$el["itype_id"]]["itype_el_status"]);
				$status = 0;
				foreach($state as $v)
				{
					if(empty($el["content"][strtoupper(trim($v))]))
						$status++;
				}

				if(count($state) > 0 && $status == count($state))
					$img .= "Gray";
			}

			// в зависимости от заданной структуры отображаем элементы
			$iline_tpl = new Templater();
			$iline_tpl->setValues($el["content"]);
			$el_name = $iline_tpl->getResultFromString($types[$el["itype_id"]]["itype_el_structure"]);

			$treeArr["l".$elID]				= array();
			$treeArr["l".$elID]["pid"]		= "t".$el["itype_id"];
			$treeArr["l".$elID]["name"]		= $el_name;
			$treeArr["l".$elID]["url"]		= "https://" . $_CONFIG["global"]["paths"]["site"] . $_CONFIG["global"]["paths"]["admin_dir"] . "index.php?mod=" . $_ACTIVE["mod"] . "&action=edit&type=l&id=" . $elID;
			$treeArr["l".$elID]["title"]    = $el_name." (ID: ".$elID.")";
			$treeArr["l".$elID]["target"]	= null;
			$treeArr["l".$elID]["icon"]		= $img.".gif";
			$treeArr["l".$elID]["iconOpen"] = $img.".gif";
			$treeArr["l".$elID]["open"]     = false;
		}

		return $treeArr;
	}

	// Сформировать массив (дочерних) страниц для построения дерева
	function createTreeArrayFromDirectories($types, $elements)
	{
		global $_CONFIG, $_ACTIVE;
		// mytree.add(id, pid, name, url, title, target, icon, iconOpen, open);

		$treeArr = array();
		foreach($types as $k => $v)
		{
			$treeArr["t".$k]			 = array();
			$treeArr["t".$k]["pid"]		 = "t0";
			$treeArr["t".$k]["name"]	 = $v["itype_name"];
			$treeArr["t".$k]["url"]		 = "https://" . $_CONFIG["global"]["paths"]["site"] . $_CONFIG["global"]["paths"]["admin_dir"] . "index.php?mod=" . $_ACTIVE["mod"] . "&action=edit&id=" . $v["itype_id"];
			$treeArr["t".$k]["title"]    = $v["itype_name"] . " (ID: ".$v["itype_id"].")";
			$treeArr["t".$k]["target"]	 = null;
			$treeArr["t".$k]["icon"]	 = "folder.gif";
			$treeArr["t".$k]["iconOpen"] = "folderopen.gif";
			$treeArr["t".$k]["open"]     = false;
		}

		foreach($elements as $elID => $el)
		{
			// выбираем нужную картинку
			$img = "page";
			if(!empty($types[$el["itype_id"]]["itype_el_status"]))
			{
				$state = explode(",", $types[$el["itype_id"]]["itype_el_status"]);
				$status = 0;
				foreach($state as $v)
				{
					if(empty($el["content"][strtoupper(trim($v))]))
						$status++;
				}

				if(count($state) > 0 && $status == count($state))
					$img .= "Gray";
			}

			// в зависимости от заданной структуры отображаем элементы
			$iline_tpl = new Templater();
			$iline_tpl->setValues($el["content"]);
			$el_name = $iline_tpl->getResultFromString($types[$el["itype_id"]]["itype_el_structure"]);

			$treeArr["l".$elID]				= array();
			$treeArr["l".$elID]["pid"]		= "t".$el["itype_id"];
			$treeArr["l".$elID]["name"]		= $el_name;
			$treeArr["l".$elID]["url"]		= "https://" . $_CONFIG["global"]["paths"]["site"] . $_CONFIG["global"]["paths"]["admin_dir"] . "index.php?mod=" . $_ACTIVE["mod"] . "&action=edit&type=l&id=" . $elID;
			$treeArr["l".$elID]["title"]    = $el_name." (ID: ".$elID.")";
			$treeArr["l".$elID]["target"]	= null;
			$treeArr["l".$elID]["icon"]		= $img.".gif";
			$treeArr["l".$elID]["iconOpen"] = $img.".gif";
			$treeArr["l".$elID]["open"]     = false;
		}

		return $treeArr;
	}
	function createTreeArrayFromHeaders($types, $elements)
	{
		global $_CONFIG, $_ACTIVE;
		// mytree.add(id, pid, name, url, title, target, icon, iconOpen, open);

		$treeArr = array();
		foreach($types as $k => $v)
		{
			$treeArr["t".$k]			 = array();
			$treeArr["t".$k]["pid"]		 = "t0";
			$treeArr["t".$k]["name"]	 = $v["itype_name"];
			$treeArr["t".$k]["url"]		 = "https://" . $_CONFIG["global"]["paths"]["site"] . $_CONFIG["global"]["paths"]["admin_dir"] . "index.php?mod=" . $_ACTIVE["mod"] . "&action=edit&id=" . $v["itype_id"];
			$treeArr["t".$k]["title"]    = $v["itype_name"] . " (ID: ".$v["itype_id"].")";
			$treeArr["t".$k]["target"]	 = null;
			$treeArr["t".$k]["icon"]	 = "folder.gif";
			$treeArr["t".$k]["iconOpen"] = "folderopen.gif";
			$treeArr["t".$k]["open"]     = false;
		}

		foreach($elements as $elID => $el)
		{
			// выбираем нужную картинку
			$img = "page";
			if(!empty($types[$el["itype_id"]]["itype_el_status"]))
			{
				$state = explode(",", $types[$el["itype_id"]]["itype_el_status"]);
				$status = 0;
				foreach($state as $v)
				{
					if(empty($el["content"][strtoupper(trim($v))]))
						$status++;
				}

				if(count($state) > 0 && $status == count($state))
					$img .= "Gray";
			}

			// в зависимости от заданной структуры отображаем элементы
			$iline_tpl = new Templater();
			$iline_tpl->setValues($el["content"]);
			$el_name = $iline_tpl->getResultFromString($types[$el["itype_id"]]["itype_el_structure"]);

			$treeArr["l".$elID]				= array();
			$treeArr["l".$elID]["pid"]		= "t".$el["itype_id"];
			$treeArr["l".$elID]["name"]		= $el_name;
			$treeArr["l".$elID]["url"]		= "https://" . $_CONFIG["global"]["paths"]["site"] . $_CONFIG["global"]["paths"]["admin_dir"] . "index.php?mod=" . $_ACTIVE["mod"] . "&action=edit&type=l&id=" . $elID;
			$treeArr["l".$elID]["title"]    = $el_name." (ID: ".$elID.")";
			$treeArr["l".$elID]["target"]	= null;
			$treeArr["l".$elID]["icon"]		= $img.".gif";
			$treeArr["l".$elID]["iconOpen"] = $img.".gif";
			$treeArr["l".$elID]["open"]     = false;
		}

		return $treeArr;
	}
	// Сформировать массив (дочерних) страниц для построения дерева NIR
	function createTreeArrayFromNirs($types, $elements)
	{
		global $_CONFIG, $_ACTIVE;
		// mytree.add(id, pid, name, url, title, target, icon, iconOpen, open);

		$treeArr = array();
		foreach($types as $k => $v)
		{
			$treeArr["t".$k]			 = array();
			$treeArr["t".$k]["pid"]		 = "t0";
			$treeArr["t".$k]["name"]	 = $v["itype_name"];
			$treeArr["t".$k]["url"]		 = "https://" . $_CONFIG["global"]["paths"]["site"] . $_CONFIG["global"]["paths"]["admin_dir"] . "index.php?mod=" . $_ACTIVE["mod"] . "&action=edit&id=" . $v["itype_id"];
			$treeArr["t".$k]["title"]    = $v["itype_name"] . " (ID: ".$v["itype_id"].")";
			$treeArr["t".$k]["target"]	 = null;
			$treeArr["t".$k]["icon"]	 = "folder.gif";
			$treeArr["t".$k]["iconOpen"] = "folderopen.gif";
			$treeArr["t".$k]["open"]     = false;
		}

		foreach($elements as $elID => $el)
		{
			// выбираем нужную картинку
			$img = "page";
			if(!empty($types[$el["itype_id"]]["itype_el_status"]))
			{
				$state = explode(",", $types[$el["itype_id"]]["itype_el_status"]);
				$status = 0;
				foreach($state as $v)
				{
					if(empty($el["content"][strtoupper(trim($v))]))
						$status++;
				}

				if(count($state) > 0 && $status == count($state))
					$img .= "Gray";
			}

			// в зависимости от заданной структуры отображаем элементы
			$iline_tpl = new Templater();
			$iline_tpl->setValues($el["content"]);
			$el_name = $iline_tpl->getResultFromString($types[$el["itype_id"]]["itype_el_structure"]);

			$treeArr["l".$elID]				= array();
			$treeArr["l".$elID]["pid"]		= "t".$el["itype_id"];
			$treeArr["l".$elID]["name"]		= $el_name;
			$treeArr["l".$elID]["url"]		= "https://" . $_CONFIG["global"]["paths"]["site"] . $_CONFIG["global"]["paths"]["admin_dir"] . "index.php?mod=" . $_ACTIVE["mod"] . "&action=edit&type=l&id=" . $elID;
			$treeArr["l".$elID]["title"]    = $el_name." (ID: ".$elID.")";
			$treeArr["l".$elID]["target"]	= null;
			$treeArr["l".$elID]["icon"]		= $img.".gif";
			$treeArr["l".$elID]["iconOpen"] = $img.".gif";
			$treeArr["l".$elID]["open"]     = false;
		}

		return $treeArr;
	}
	function createTreeArrayFromPolls($types, $elements)
	{
		global $_CONFIG, $_ACTIVE;
		// mytree.add(id, pid, name, url, title, target, icon, iconOpen, open);

		$treeArr = array();
		foreach($types as $k => $v)
		{
			$treeArr["t".$k]			 = array();
			$treeArr["t".$k]["pid"]		 = "t0";
			$treeArr["t".$k]["name"]	 = $v["itype_name"];
			$treeArr["t".$k]["url"]		 = "https://" . $_CONFIG["global"]["paths"]["site"] . $_CONFIG["global"]["paths"]["admin_dir"] . "index.php?mod=" . $_ACTIVE["mod"] . "&action=edit&id=" . $v["itype_id"];
			$treeArr["t".$k]["title"]    = $v["itype_name"] . " (ID: ".$v["itype_id"].")";
			$treeArr["t".$k]["target"]	 = null;
			$treeArr["t".$k]["icon"]	 = "folder.gif";
			$treeArr["t".$k]["iconOpen"] = "folderopen.gif";
			$treeArr["t".$k]["open"]     = false;
		}

		foreach($elements as $elID => $el)
		{
			// выбираем нужную картинку
			$img = "page";
			if(!empty($types[$el["itype_id"]]["itype_el_status"]))
			{
				$state = explode(",", $types[$el["itype_id"]]["itype_el_status"]);
				$status = 0;
				foreach($state as $v)
				{
					if(empty($el["content"][strtoupper(trim($v))]))
						$status++;
				}

				if(count($state) > 0 && $status == count($state))
					$img .= "Gray";
			}

			// в зависимости от заданной структуры отображаем элементы
			$iline_tpl = new Templater();
			$iline_tpl->setValues($el["content"]);
			$el_name = $iline_tpl->getResultFromString($types[$el["itype_id"]]["itype_el_structure"]);

			$treeArr["l".$elID]				= array();
			$treeArr["l".$elID]["pid"]		= "t".$el["itype_id"];
			$treeArr["l".$elID]["name"]		= $el_name;
			$treeArr["l".$elID]["url"]		= "https://" . $_CONFIG["global"]["paths"]["site"] . $_CONFIG["global"]["paths"]["admin_dir"] . "index.php?mod=" . $_ACTIVE["mod"] . "&action=edit&type=l&id=" . $elID;
			$treeArr["l".$elID]["title"]    = $el_name." (ID: ".$elID.")";
			$treeArr["l".$elID]["target"]	= null;
			$treeArr["l".$elID]["icon"]		= $img.".gif";
			$treeArr["l".$elID]["iconOpen"] = $img.".gif";
			$treeArr["l".$elID]["open"]     = false;
		}

		return $treeArr;
	}

	function arrayIntersectKey()
	{
		$argc = func_num_args();

		for($i = 1; !empty($isec) && $i < $argc; $i++)
		{
			$arr = func_get_arg($i);

			foreach($isec as $k => $v)
			{
				if (!isset($arr[$k]))
					unset($isec[$k]);
			}
		}

		return $isec;
	}

	// отправляем хедер по его коду
	function sendHeaderByCode($code)
	{
		$headersByCode = array(
			100 => "HTTP/1.1 100 Continue",
			101 => "HTTP/1.1 101 Switching Protocols",
			200 => "HTTP/1.1 200 OK",
			201 => "HTTP/1.1 201 Created",
			202 => "HTTP/1.1 202 Accepted",
			203 => "HTTP/1.1 203 Non-Authoritative Information",
			204 => "HTTP/1.1 204 No Content",
			205 => "HTTP/1.1 205 Reset Content",
			206 => "HTTP/1.1 206 Partial Content",
			300 => "HTTP/1.1 300 Multiple Choices",
			301 => "HTTP/1.1 301 Moved Permanently",
			302 => "HTTP/1.1 302 Found",
			303 => "HTTP/1.1 303 See Other",
			304 => "HTTP/1.1 304 Not Modified",
			305 => "HTTP/1.1 305 Use Proxy",
			307 => "HTTP/1.1 307 Temporary Redirect",
			400 => "HTTP/1.1 400 Bad Request",
			401 => "HTTP/1.1 401 Unauthorized",
			402 => "HTTP/1.1 402 Payment Required",
			403 => "HTTP/1.1 403 Forbidden",
			404 => "HTTP/1.1 404 Not Found",
			405 => "HTTP/1.1 405 Method Not Allowed",
			406 => "HTTP/1.1 406 Not Acceptable",
			407 => "HTTP/1.1 407 Proxy Authentication Required",
			408 => "HTTP/1.1 408 Request Time-out",
			409 => "HTTP/1.1 409 Conflict",
			410 => "HTTP/1.1 410 Gone",
			411 => "HTTP/1.1 411 Length Required",
			412 => "HTTP/1.1 412 Precondition Failed",
			413 => "HTTP/1.1 413 Request Entity Too Large",
			414 => "HTTP/1.1 414 Request-URI Too Large",
			415 => "HTTP/1.1 415 Unsupported Media Type",
			416 => "HTTP/1.1 416 Requested range not satisfiable",
			417 => "HTTP/1.1 417 Expectation Failed",
			500 => "HTTP/1.1 500 Internal Server Error",
			501 => "HTTP/1.1 501 Not Implemented",
			502 => "HTTP/1.1 502 Bad Gateway",
			503 => "HTTP/1.1 503 Service Unavailable",
			504 => "HTTP/1.1 504 Gateway Time-out",
		);

		if(isset($headersByCode[$code]))
			header($headersByCode[$code]);
	}

	// отсылаем header("Location: ") и убиваем скрипт
	function sendLocationHeader($location)
	{
		header("Location: ".$location);
		exit;
	}

	// формирование даты текстом (type == 1: в им падеже, type == 1: в род падеже, )
    public static function rus_get_month_name($mon, $type = 1)
	{
		if($type == 1)
		{
			$months[1]  = "Январь";
			$months[2]  = "Февраль";
			$months[3]  = "Март";
			$months[4]  = "Апрель";
			$months[5]  = "Май";
			$months[6]  = "Июнь";
			$months[7]  = "Июль";
			$months[8]  = "Август";
			$months[9]  = "Сентябрь";
			$months[10] = "Октябрь";
			$months[11] = "Ноябрь";
			$months[12] = "Декабрь";
		}

		if($type == 2)
		{
			$months[1]  = "Января";
			$months[2]  = "Февраля";
			$months[3]  = "Марта";
			$months[4]  = "Апреля";
			$months[5]  = "Мая";
			$months[6]  = "Июня";
			$months[7]  = "Июля";
			$months[8]  = "Августа";
			$months[9]  = "Сентября";
			$months[10] = "Октября";
			$months[11] = "Ноября";
			$months[12] = "Декабря";
		}

		return @$months[(int)$mon];
	}

    public static function cyrToLat($text) {
	    $cyr = array('а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п',
            'р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я',
            'А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П',
            'Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я');
        $lat = array(
            'a','b','v','g','d','e','io','zh','z','i','y','k','l','m','n','o','p',
            'r','s','t','u','f','h','ts','ch','sh','sht','a','i','y','e','yu','ya',
            'A','B','V','G','D','E','Io','Zh','Z','I','Y','K','L','M','N','O','P',
            'R','S','T','U','F','H','Ts','Ch','Sh','Sht','A','I','Y','e','Yu','Ya'
        );
        $latText = str_replace($cyr, $lat, $text);
        return $latText;
    }

    public static function cyrToLatExcl($text) {
        $exclArr = array(
            'dinkin' => 'dynkin',
            'voytolovsk' => 'voitolovsk',
            'voitolovskiy' => 'voitolovsky',
            'fedor' => 'feodor',
            'fiodor' => 'feodor'
        );

        foreach ($exclArr as $excl => $replace) {
            $text = str_replace($excl, $replace,$text);
        }

        return $text;
    }

    public static function RusEnding($n, $n1, $n2, $n5) {
        if($n >= 11 and $n <= 19) return $n5;
        $n = $n % 10;
        if($n == 1) return $n1;
        if($n >= 2 and $n <= 4) return $n2;
        return $n5;
    }

    public static function LineBreakToComma($txt) {
        $txt = preg_replace("/[,.]* *[\r\n]+/",", ",$txt);
        return $txt;
    }

    public static function LineBreakToSpace($txt) {
        $txt = preg_replace("/[\r\n]+/"," ",$txt);
        return $txt;
    }

    public static function LineBreakToBr($txt) {
        $txt = preg_replace("/[\r\n]+/","<br>",$txt);
        return $txt;
    }
    public static function LineBreakToBrAll($txt) {
        $txt = str_replace("\r\n","<br>",$txt);
        $txt = str_replace("\n","<br>",$txt);
        return $txt;
    }
    public static function LineBreakPlusBrAll($txt) {
        $txt = str_replace("\n","\n<br>",$txt);
        return $txt;
    }

    public static function normJsonStr($str){
        $str = preg_replace_callback('/\\\u([a-f0-9]{4})/i', create_function('$m', 'return chr(hexdec($m[1])-1072+224);'), $str);
        return iconv('cp1251', 'utf-8', $str);
    }

    public static function encodeText($text) {
        return iconv("windows-1251","utf-8", $text);
    }

    /**
     * Creates a random unique temporary directory, with specified parameters,
     * that does not already exist (like tempnam(), but for dirs).
     *
     * Created dir will begin with the specified prefix, followed by random
     * numbers.
     *
     * @link https://php.net/manual/en/function.tempnam.php
     *
     * @param string|null $dir Base directory under which to create temp dir.
     *     If null, the default system temp dir (sys_get_temp_dir()) will be
     *     used.
     * @param string $prefix String with which to prefix created dirs.
     * @param int $mode Octal file permission mask for the newly-created dir.
     *     Should begin with a 0.
     * @param int $maxAttempts Maximum attempts before giving up (to prevent
     *     endless loops).
     * @return string|bool Full path to newly-created dir, or false on failure.
     */
    public static function tempdir($dir = null, $prefix = 'tmp_', $mode = 0700, $maxAttempts = 1000)
    {
        /* Use the system temp dir by default. */
        if (is_null($dir))
        {
            $dir = sys_get_temp_dir();
        }

        /* Trim trailing slashes from $dir. */
        $dir = rtrim($dir, DIRECTORY_SEPARATOR);

        /* If we don't have permission to create a directory, fail, otherwise we will
         * be stuck in an endless loop.
         */
        if (!is_dir($dir) || !is_writable($dir))
        {
            return false;
        }

        /* Make sure characters in prefix are safe. */
        if (strpbrk($prefix, '\\/:*?"<>|') !== false)
        {
            return false;
        }

        /* Attempt to create a random directory until it works. Abort if we reach
         * $maxAttempts. Something screwy could be happening with the filesystem
         * and our loop could otherwise become endless.
         */
        $attempts = 0;
        do
        {
            $path = sprintf('%s%s%s%s', $dir, DIRECTORY_SEPARATOR, $prefix, mt_rand(100000, mt_getrandmax()));
        } while (
            !mkdir($path, $mode) &&
            $attempts++ < $maxAttempts
        );

        return $path;
    }

    public static function compressImage($source, $destination, $quality) {

        $info = getimagesize($source);

        if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($source);

        elseif ($info['mime'] == 'image/gif')
            $image = imagecreatefromgif($source);

        elseif ($info['mime'] == 'image/png')
            $image = imagecreatefrompng($source);

        imagejpeg($image, $destination, $quality);

    }

    public static function scaleImage($source, $destinations)
    {
            $im = new imagick($source);

            $width = $im->getImageWidth();
            $height = $im->getImageHeight();

            foreach ($destinations as $destination) {
                if(!file_exists($destination['destination'])) {
                    if($width > $height) {
                        if($destination['size']<$width) {
                            $im->resizeImage($destination['size'], 0, imagick::FILTER_LANCZOS, 1);
                        }
                    }
                    else {
                        if($destination['size']<$height) {
                            $im->resizeImage(0 , $destination['size'], imagick::FILTER_LANCZOS, 1);
                        }
                    }

                    $im->setImageCompression(true);
                    $im->setCompression(Imagick::COMPRESSION_JPEG);
                    $im->setCompressionQuality(20);

                    $im->writeImage($destination['destination']);
                }
            }

            $im->clear();
            $im->destroy();
    }

    /**
     * @param $user_agent null
     * @return string
     */
    public static function getOS($user_agent = null)
    {
        if(!isset($user_agent) && isset($_SERVER['HTTP_USER_AGENT'])) {
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
        }

        // https://stackoverflow.com/questions/18070154/get-operating-system-info-with-php
        $os_array = array(
            'windows nt 10'                              =>  'Windows 10',
            'windows nt 6.3'                             =>  'Windows 8.1',
            'windows nt 6.2'                             =>  'Windows 8',
            'windows nt 6.1|windows nt 7.0'              =>  'Windows 7',
            'windows nt 6.0'                             =>  'Windows Vista',
            'windows nt 5.2'                             =>  'Windows Server 2003/XP x64',
            'windows nt 5.1'                             =>  'Windows XP',
            'windows xp'                                 =>  'Windows XP',
            'windows nt 5.0|windows nt5.1|windows 2000'  =>  'Windows 2000',
            'windows me'                                 =>  'Windows ME',
            'windows nt 4.0|winnt4.0'                    =>  'Windows NT',
            'windows ce'                                 =>  'Windows CE',
            'windows 98|win98'                           =>  'Windows 98',
            'windows 95|win95'                           =>  'Windows 95',
            'win16'                                      =>  'Windows 3.11',
            'iphone'                                     =>  'iPhone',
            'ipod'                                       =>  'iPod',
            'ipad'                                       =>  'iPad',
            'android'                                    =>  'Android',
            'blackberry'                                 =>  'BlackBerry',
            'webos'                                      =>  'Mobile',
            'mac os x 10.1[^0-9]'                        =>  'Mac OS X Puma',
            'macintosh|mac os x'                         =>  'Mac OS X',
            'mac_powerpc'                                =>  'Mac OS 9',
            'linux'                                      =>  'Linux',
            'ubuntu'                                     =>  'Linux - Ubuntu',

            '(media center pc).([0-9]{1,2}\.[0-9]{1,2})'=>'Windows Media Center',
            '(win)([0-9]{1,2}\.[0-9x]{1,2})'=>'Windows',
            '(win)([0-9]{2})'=>'Windows',
            '(windows)([0-9x]{2})'=>'Windows',

            // Doesn't seem like these are necessary...not totally sure though..
            //'(winnt)([0-9]{1,2}\.[0-9]{1,2}){0,1}'=>'Windows NT',
            //'(windows nt)(([0-9]{1,2}\.[0-9]{1,2}){0,1})'=>'Windows NT', // fix by bg

            'Win 9x 4.90'=>'Windows ME',
            '(windows)([0-9]{1,2}\.[0-9]{1,2})'=>'Windows',
            'win32'=>'Windows',
            '(java)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,2})'=>'Java',
            '(Solaris)([0-9]{1,2}\.[0-9x]{1,2}){0,1}'=>'Solaris',
            'dos x86'=>'DOS',
            'Mac OS X'=>'Mac OS X',
            'Mac_PowerPC'=>'Macintosh PowerPC',
            '(mac|Macintosh)'=>'Mac OS',
            '(sunos)([0-9]{1,2}\.[0-9]{1,2}){0,1}'=>'SunOS',
            '(beos)([0-9]{1,2}\.[0-9]{1,2}){0,1}'=>'BeOS',
            '(risc os)([0-9]{1,2}\.[0-9]{1,2})'=>'RISC OS',
            'unix'=>'Unix',
            'os/2'=>'OS/2',
            'freebsd'=>'FreeBSD',
            'openbsd'=>'OpenBSD',
            'netbsd'=>'NetBSD',
            'irix'=>'IRIX',
            'plan9'=>'Plan9',
            'osf'=>'OSF',
            'aix'=>'AIX',
            'GNU Hurd'=>'GNU Hurd',
            '(fedora)'=>'Linux - Fedora',
            '(kubuntu)'=>'Linux - Kubuntu',
            '(ubuntu)'=>'Linux - Ubuntu',
            '(debian)'=>'Linux - Debian',
            '(CentOS)'=>'Linux - CentOS',
            '(Mandriva).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)'=>'Linux - Mandriva',
            '(SUSE).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)'=>'Linux - SUSE',
            '(Dropline)'=>'Linux - Slackware (Dropline GNOME)',
            '(ASPLinux)'=>'Linux - ASPLinux',
            '(Red Hat)'=>'Linux - Red Hat',
            // Loads of Linux machines will be detected as unix.
            // Actually, all of the linux machines I've checked have the 'X11' in the User Agent.
            //'X11'=>'Unix',
            '(linux)'=>'Linux',
            '(amigaos)([0-9]{1,2}\.[0-9]{1,2})'=>'AmigaOS',
            'amiga-aweb'=>'AmigaOS',
            'amiga'=>'Amiga',
            'AvantGo'=>'PalmOS',
            //'(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1}-([0-9]{1,2}) i([0-9]{1})86){1}'=>'Linux',
            //'(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1} i([0-9]{1}86)){1}'=>'Linux',
            //'(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1})'=>'Linux',
            '[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}'=>'Linux',
            '(webtv)/([0-9]{1,2}\.[0-9]{1,2})'=>'WebTV',
            'Dreamcast'=>'Dreamcast OS',
            'GetRight'=>'Windows',
            'go!zilla'=>'Windows',
            'gozilla'=>'Windows',
            'gulliver'=>'Windows',
            'ia archiver'=>'Windows',
            'NetPositive'=>'Windows',
            'mass downloader'=>'Windows',
            'microsoft'=>'Windows',
            'offline explorer'=>'Windows',
            'teleport'=>'Windows',
            'web downloader'=>'Windows',
            'webcapture'=>'Windows',
            'webcollage'=>'Windows',
            'webcopier'=>'Windows',
            'webstripper'=>'Windows',
            'webzip'=>'Windows',
            'wget'=>'Windows',
            'Java'=>'Unknown',
            'flashget'=>'Windows',

            // delete next line if the script show not the right OS
            //'(PHP)/([0-9]{1,2}.[0-9]{1,2})'=>'PHP',
            'MS FrontPage'=>'Windows',
            '(msproxy)/([0-9]{1,2}.[0-9]{1,2})'=>'Windows',
            '(msie)([0-9]{1,2}.[0-9]{1,2})'=>'Windows',
            'libwww-perl'=>'Unix',
            'UP.Browser'=>'Windows CE',
            'NetAnts'=>'Windows',
        );

        // https://github.com/ahmad-sa3d/php-useragent/blob/master/core/user_agent.php
        $arch_regex = '/\b(x86_64|x86-64|Win64|WOW64|x64|ia64|amd64|ppc64|sparc64|IRIX64)\b/ix';
        $arch = preg_match($arch_regex, $user_agent) ? '64' : '32';

        foreach ($os_array as $regex => $value) {
            if (preg_match('{\b('.$regex.')\b}i', $user_agent)) {
                //return $value.' x'.$arch;
                return $value;
            }
        }

        return 'Unknown';
    }

    public static function getBrowser() {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version= "";

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        }elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        }elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the useragent yes seperately and for good reason
        if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)){
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        }elseif(preg_match('/Firefox/i',$u_agent)){
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        }elseif(preg_match('/OPR/i',$u_agent)){
            $bname = 'Opera';
            $ub = "Opera";
        }elseif(preg_match('/Chrome/i',$u_agent) && !preg_match('/Edge/i',$u_agent)){
            $bname = 'Google Chrome';
            $ub = "Chrome";
        }elseif(preg_match('/Safari/i',$u_agent) && !preg_match('/Edge/i',$u_agent)){
            $bname = 'Apple Safari';
            $ub = "Safari";
        }elseif(preg_match('/Netscape/i',$u_agent)){
            $bname = 'Netscape';
            $ub = "Netscape";
        }elseif(preg_match('/Edge/i',$u_agent)){
            $bname = 'Edge';
            $ub = "Edge";
        }elseif(preg_match('/Trident/i',$u_agent)){
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        }

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
            ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }
        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
                $version= $matches['version'][0];
            }else {
                $version= $matches['version'][1];
            }
        }else {
            $version= $matches['version'][0];
        }

        // check if we have a number
        if ($version==null || $version=="") {$version="?";}

        return array(
            'userAgent' => $u_agent,
            'name'      => $bname,
            'version'   => $version,
            'platform'  => $platform,
            'pattern'    => $pattern
        );
    }

    public static function generatePassword($length = 8) {
        $letters = "qwertyuiopasdfghjklzxcvbnm1234567890"; // символы для генерации пароля

        $retPass = "";
        for($i = 0; $i < $length; $i++)
            $retPass .= $letters[rand(0,strlen($letters)-1)];

        return $retPass;
    }

    public static function validateDate($date, $format = 'Y.m.d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

}

?>