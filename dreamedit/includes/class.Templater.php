<?
/********************************
Templater
var	$compileDir - дирекория в которую сохраняются откомпилированные шаблоны
var	$data		- хранит данные для замены (array(tmpVar -> value))

clear()							- очищает значения аттрибутов
getVarsFromStr($str)			- возвращает переменные из шаблона (принимает контент шаблона)
getVarsFromPath($path)			- возвращает переменные из шаблона (принимает путь к шаблону)
setValues($data)				- сохраняет данные для замены в объект
appendValues($data)				- добавляет данные для замены в объект
getResultFromString($str)		- возвращает контент шаблона из строки
getResultFromPath($path)		- возвращает контент шаблона из пути к шаблону
displayResultFromString($str)	- отображает контент шаблона из строки
displayResultFromPath($path)	- отображает контент шаблона из пути к шаблону
********************************/



class Templater
{
	var	$compileDir;
	var	$data;

	// конструктор для PHP5+
	function __construct()
	{
		$this->clear();
		return true;
	}

	// конструктор для PHP4 <
	function Templater()
	{
		return $this->__construct();
	}

	// очищаем аттрибуты объекта
	function clear()
	{
	    global $DB;
		// ставим значения "по-умочанию"
		$this->compileDir = "cmpl_tmp/new";
        $ip_testing_newsite = $DB->select('SELECT * FROM newsite_testing WHERE address=?', $_SERVER["REMOTE_ADDR"]);
//        if(!empty($ip_testing_newsite))
//            $this->compileDir = "cmpl_tmp/new";
        if($_COOKIE["oldsite"]==1)
            $this->compileDir = "cmpl_tmp";


//		if($_SERVER["SCRIPT_FILENAME"]=="/home/imemon/html/newsite/index.php")
//            $this->compileDir = "cmpl_tmp/new";

		$this->data = array();
	}

	// получаем шаблонные переменные из полученной строки
	function getVarsFromStr($str)
	{
		preg_match_all("/{([A-Z]+[A-Z_]*)}/", $str, $matches);
		return array_unique($matches[1]);
	}

	// получаем шаблонные переменные из переданного пути
	function getVarsFromPath($path)
	{
		$matches = $this->getVarsFromStr(@file_get_contents($path));
		return $matches;
	}

	// устанавливаем переменные для замены
	function setValues($data)
	{
		$this->data = $data; 
	}

	// добавляем переменные для замены
	function appendValues($data)
	{
		$this->data = array_merge($this->data, $data);
	}

	// вернуть сформированный результат шаблона из строки
	function getResultFromString($str)
	{
		ob_start();
		$this->displayResultFromString($str);
		$tpl_content = ob_get_contents();
		ob_end_clean();

		return $tpl_content;
	}

	// вернуть сформированный результат шаблона по пути
	function getResultFromPath($path)
	{
		ob_start();
		$this->displayResultFromPath($path);
		$tpl_content = ob_get_contents();
		ob_end_clean();
		return $tpl_content;
	}

	// отобразить результат скомпилированного шаблона по пути
	function displayResultFromString($str)
	{ 
		$this->evalTemplate($this->compileTemplate($str));
	}

	// отобразить результат скомпилированного шаблона по пути
	function displayResultFromPath($path)
	{
		$this->evalTemplate($this->compileTemplate(@file_get_contents($path), $path));
	}

	// выполняем скомпилированный шаблон
	function evalTemplate($path)
	{
		$_TPL_REPLACMENT = array();
		foreach($this->data as $k => $v)
			$_TPL_REPLACMENT[strtoupper($k)] = is_array($v)? implode("", $v): $v;



		include $path;
	}


	// компилируем шаблон
	function compileTemplate($str, $path = "")
	{
		// определяем расположение скомпилированного шаблона


		if(empty($path))
		{
			$cmplTpl = dirname(__FILE__)."/".$this->compileDir."/".crc32($str).".php";
			$noFiletime = true;
		}
		else
		{
			$cmplTpl = dirname($path)."/".$this->compileDir."/".basename($path).".php";
			$noFiletime = false;
		}
        if (substr($cmplTpl,0,4)=="site")
        {
           $cmplTpl = dirname(__FILE__)."/../../".dirname($path)."/".$this->compileDir."/".basename($path).".php";
           $path=dirname(__FILE__)."/../../".$path;
        }

		// проверяем есть ли нужные закэшированные шаблоны
		if(file_exists($cmplTpl) && ($noFiletime || filemtime($path) < filemtime($cmplTpl)) )
			return $cmplTpl;

		if(!is_dir(dirname($cmplTpl)))
			mkdir(dirname($cmplTpl));

		$vars = $this->getVarsFromStr($str);

		$cmpVars = array();
		foreach($vars as $v)
			$cmpVars["/{".$v."}/"]  = '<?=@$_TPL_REPLACMENT["'.$v.'"]?>';

		$tplContent = preg_replace(array_keys($cmpVars), $cmpVars, $str);

		$this->writeTemplate($cmplTpl, $tplContent);

		return $cmplTpl;
	}

	// запись шаблона в файл
	function writeTemplate($cmplTpl, $tplContent)
	{
		if(!function_exists("file_put_contents"))
		{
			$h = fopen($cmplTpl, "w");
			fwrite($h, $tplContent);
			fclose($h);
		}
		else
			file_put_contents($cmplTpl, $tplContent);
	}
}

?>