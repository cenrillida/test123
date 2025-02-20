<?php
	// бере?конфиг систем?если конфиг не найден - выходи?
	$_CONFIG["global"] = @parse_ini_file(dirname(__FILE__)."/dreamedit/_config.ini", true);
	if(empty($_CONFIG["global"]))
		die("Config is not found!");
	// создае?дополнительную переменную admin_path - полный путь до директории ?системой администрирования
	$_CONFIG["global"]["paths"]["admin_path"] = $_SERVER["DOCUMENT_ROOT"]."/".$_CONFIG["global"]["paths"]["admin_dir"];
	$_CONFIG["global"]["paths"]["template_path"] = $_SERVER["DOCUMENT_ROOT"]."/".$_CONFIG["global"]["paths"]["templates"];


	// подключаем заголовк?страни?
	include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/headers.php";
	// подключаем файл соединен? ?базо?
	include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/connect.php";
	// подключаем файл соединен? ?базо?
	include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/site.fns.php";

	header("Content-type: application/json");

	function addAnswer($info, $lang)
	{
		$temp = explode("_",$info);
		$answer_id=$temp[1];
		$survey_id=$temp[2];
		global $DB;
		if($lang!="_en")
			$arr["info"] = "100";
		else
			$arr["info"] = "Thank you! Your vote has been counted.";
		$rows = $DB->select("SELECT * FROM adm_ilines_content WHERE el_id=? AND icont_var=?", $survey_id, "answer".$answer_id.$lang);
		if(empty($rows[0][icont_text]) || $rows[0][icont_text]=="<p>&nbsp;</p>" || $rows[0][icont_text]=="<p></p>") {
				if($lang!="_en")
					$arr["info"] = "300";
				else
					$arr["info"] = "Incorrect answer";
			}
		else
		{
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			    $ip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
			    $ip = $_SERVER['REMOTE_ADDR'];
			}
			$DB->query("INSERT INTO survey SET ip = ?, answer_id = ?, survey_id = ?",$ip,$answer_id,$survey_id);
		}
		$arr["id"]=$survey_id;
		return $arr;
	}

	function showResults($info)
	{
		$survey_id=$info;
		global $DB;
		$arr[1] = $DB->select("SELECT COUNT(*) AS cnt
							FROM survey 
							WHERE answer_id=1 AND survey_id=?",$survey_id);
		$arr[2] = $DB->select("SELECT COUNT(*) AS cnt 
							FROM survey 
							WHERE answer_id=2 AND survey_id=?",$survey_id);
		$arr[3] = $DB->select("SELECT COUNT(*) AS cnt 
							FROM survey 
							WHERE answer_id=3 AND survey_id=?",$survey_id);
		$arr[4] = $DB->select("SELECT COUNT(*) AS cnt 
							FROM survey 
							WHERE answer_id=4 AND survey_id=?",$survey_id);
		$arr[5] = $DB->select("SELECT COUNT(*) AS cnt 
							FROM survey 
							WHERE answer_id=5 AND survey_id=?",$survey_id);
		return $arr;
	}

	if ($_POST['action'] == 'add_answer') {
		echo json_encode(addAnswer($_POST['info'], $_POST['lang']));
	}
	if ($_POST['action'] == 'show_results') {
		echo json_encode(showResults($_POST['info']));
	}
?>