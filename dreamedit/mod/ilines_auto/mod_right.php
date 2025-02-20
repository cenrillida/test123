<?
//
//        error_reporting(E_ALL);
//        ini_set('display_errors', 1);
//
//ini_set('memory_limit', '512M');

ini_set('post_max_size','200M');
ini_set('upload_max_filesize','200M');

include_once dirname(__FILE__)."/../../_include.php";


include_once "form.php";
include_once "mod_fns.php";

$phorm = new mod_phorm($mod_array);
$ilines = new Ilines();

$id = (int)@$_REQUEST["id"];
$type = isset($_REQUEST["type"])? "l": "";

if($_ACTIVE["action"] == "edit")
{
	// должен прийти t_id
	getStructure($id);
    $phorm->add_comp("xml_file", array("class" => "base::file", "prompt" => "XLSX файл"));
    $phorm->add_comp("xml_first_line", array("class" => "base::textbox", "prompt" => "С какой строки начинать", "size" => 5, "value" => ""));
    $phorm->add_comp("xlsx_encoding", array("class" => "base::selectbox", "prompt" => "Кодировка", "options" => array("UTF-8" => "UTF-8", "windows-1251" => "Windows-1251")));
    $phorm->add_comp("zip_file", array("class" => "base::file", "prompt" => "ZIP файл"));
    //$phorm->add_comp("files_path", array("class" => "base::textbox", "prompt" => "Или адрес до папки с файлами", "size" => 151, "value" => "/files/"));
	$phorm->display();
	//var_dump($phorm->phorm['components']);
}

if($_ACTIVE["action"] == "save")
{
    getStructure($id);
    $phorm->add_comp("xml_file", array("class" => "base::file", "prompt" => "XLSX файл"));
    $phorm->add_comp("xml_first_line", array("class" => "base::textbox", "prompt" => "С какой строки начинать", "size" => 5, "value" => ""));
    $phorm->add_comp("xlsx_encoding", array("class" => "base::selectbox", "prompt" => "Кодировка", "options" => array("UTF-8" => "UTF-8", "windows-1251" => "Windows-1251")));
    $phorm->add_comp("zip_file", array("class" => "base::file", "prompt" => "ZIP файл"));
    //$phorm->add_comp("files_path", array("class" => "base::textbox", "prompt" => "Или адрес до папки с файлами", "size" => 151, "value" => "/files/"));
	$phorm->mod_phorm_values($_REQUEST);

	if(!$phorm->validate() || empty($_FILES['xml_file']['tmp_name'][0]))
	{
		$phorm->display();
		return;
	}

    include_once "save_action.php";
//
//	var_dump($_FILES);
//	echo "<hr>";
//	var_dump($_REQUEST);

}

?>