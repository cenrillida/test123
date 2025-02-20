<?php
if($_COOKIE[userid_meimo_edit_secure]=='f2fsd!@sfsF3wd' && $_COOKIE[userid_meimo_edit]==1) {
	global $DB;

	if (!empty($_POST['delete'])) {
		$delete_id = (int)$_POST['delete'];
		$DB->query("UPDATE article_send SET del='" . date('Ymd') . "' WHERE id = ?", $delete_id);
	} else {
		$value = mb_convert_encoding($_POST['value'], "cp1251", "UTF-8");
		if ($value == 'true' && ($_POST['column'] == "check1" || $_POST['column'] == "check2")) {
			$value = 1;
		}
		if ($value == 'false' && ($_POST['column'] == "check1" || $_POST['column'] == "check2")) {
			$value = 0;
		}
		$id = (int)$_POST['id'];
		$column_id = $_POST['column'];

		switch ($column_id) {
			case 'check1':
				$column_id = 'rez_type';
				break;
			case 'check2':
				$column_id = 'publ_type';
				break;
			case 'notes1':
				$column_id = 'primech_rez';
				break;
			case 'notes2':
				$column_id = 'primech';
				break;
			case 'publdate':
				$column_id = 'date_publ';
				break;
			case 'review':
				$column_id = 'date_rez';
				break;
			default:
				$column_id = '';
				break;
		}

		if (!empty($column_id) && !empty($id)) {
			$DB->query("UPDATE article_send SET " . $column_id . " = ? WHERE id = ?", $value, $id);
		}
	}
}