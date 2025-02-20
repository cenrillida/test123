<?
/********************************
Templater
var	$compileDir - ��������� � ������� ����������� ����������������� �������
var	$data		- ������ ������ ��� ������ (array(tmpVar -> value))

clear()							- ������� �������� ����������
getVarsFromStr($str)			- ���������� ���������� �� ������� (��������� ������� �������)
getVarsFromPath($path)			- ���������� ���������� �� ������� (��������� ���� � �������)
setValues($data)				- ��������� ������ ��� ������ � ������
appendValues($data)				- ��������� ������ ��� ������ � ������
getResultFromString($str)		- ���������� ������� ������� �� ������
getResultFromPath($path)		- ���������� ������� ������� �� ���� � �������
displayResultFromString($str)	- ���������� ������� ������� �� ������
displayResultFromPath($path)	- ���������� ������� ������� �� ���� � �������
********************************/



class Templater
{
	var	$compileDir;
	var	$data;

	// ����������� ��� PHP5+
	function __construct()
	{
		$this->clear();
		return true;
	}

	// ����������� ��� PHP4 <
	function Templater()
	{
		return $this->__construct();
	}

	// ������� ��������� �������
	function clear()
	{
	    global $DB;
		// ������ �������� "��-��������"
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

	// �������� ��������� ���������� �� ���������� ������
	function getVarsFromStr($str)
	{
		preg_match_all("/{([A-Z]+[A-Z_]*)}/", $str, $matches);
		return array_unique($matches[1]);
	}

	// �������� ��������� ���������� �� ����������� ����
	function getVarsFromPath($path)
	{
		$matches = $this->getVarsFromStr(@file_get_contents($path));
		return $matches;
	}

	// ������������� ���������� ��� ������
	function setValues($data)
	{
		$this->data = $data; 
	}

	// ��������� ���������� ��� ������
	function appendValues($data)
	{
		$this->data = array_merge($this->data, $data);
	}

	// ������� �������������� ��������� ������� �� ������
	function getResultFromString($str)
	{
		ob_start();
		$this->displayResultFromString($str);
		$tpl_content = ob_get_contents();
		ob_end_clean();

		return $tpl_content;
	}

	// ������� �������������� ��������� ������� �� ����
	function getResultFromPath($path)
	{
		ob_start();
		$this->displayResultFromPath($path);
		$tpl_content = ob_get_contents();
		ob_end_clean();
		return $tpl_content;
	}

	// ���������� ��������� ����������������� ������� �� ����
	function displayResultFromString($str)
	{ 
		$this->evalTemplate($this->compileTemplate($str));
	}

	// ���������� ��������� ����������������� ������� �� ����
	function displayResultFromPath($path)
	{
		$this->evalTemplate($this->compileTemplate(@file_get_contents($path), $path));
	}

	// ��������� ���������������� ������
	function evalTemplate($path)
	{
		$_TPL_REPLACMENT = array();
		foreach($this->data as $k => $v)
			$_TPL_REPLACMENT[strtoupper($k)] = is_array($v)? implode("", $v): $v;



		include $path;
	}


	// ����������� ������
	function compileTemplate($str, $path = "")
	{
		// ���������� ������������ ����������������� �������


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

		// ��������� ���� �� ������ �������������� �������
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

	// ������ ������� � ����
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