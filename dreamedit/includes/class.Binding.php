<?

class Binding
{
	// конструктор дл€ PHP5+
	function __construct()
	{

	}

	// конструктор дл€ PHP4 <
	function Binding()
	{
		$this->__construct();
	}

	// получить cписок по type name
	function getTextsByTypeName($ilines_type_name,$value_name,$text_ru_name,$type_name,$use_id)
	{
		global $DB;
		if($use_id == 'yes')
		{
			return $DB->select(" SELECT 0 AS ARRAY_KEY, '' AS ".$text_ru_name." UNION SELECT dcr.el_id AS ARRAY_KEY, dcr.icont_text AS ".$text_ru_name." FROM ?_".$ilines_type_name."_content dcr INNER JOIN ?_".$ilines_type_name."_element de ON de.el_id = dcr.el_id AND dcr.icont_var = '".$text_ru_name."' INNER JOIN ?_".$ilines_type_name."_type dt ON de.itype_id = dt.itype_id WHERE dt.itype_name = ? ORDER BY ".$text_ru_name, $type_name);
		}
		return $DB->select(" SELECT '' AS ARRAY_KEY, '' AS ".$text_ru_name." UNION SELECT dck.icont_text AS ARRAY_KEY, dcr.icont_text AS ".$text_ru_name." FROM ?_".$ilines_type_name."_content dcr INNER JOIN ?_".$ilines_type_name."_element de ON de.el_id = dcr.el_id AND dcr.icont_var = '".$text_ru_name."' INNER JOIN ?_".$ilines_type_name."_content dck ON de.el_id = dck.el_id AND dck.icont_var = '".$value_name."' INNER JOIN ?_".$ilines_type_name."_type dt ON de.itype_id = dt.itype_id WHERE dt.itype_name = ? ORDER BY ".$text_ru_name, $type_name);
	}

	function getTextByValue($ilines_type_name,$value_name,$text_name,$type_name,$use_id,$value)
	{
		global $DB;
		if($use_id == 'yes')
		{
			return $DB->select("SELECT  dcr.icont_text AS ".$text_name." FROM ?_".$ilines_type_name."_content dcr INNER JOIN ?_".$ilines_type_name."_element de ON de.el_id = dcr.el_id AND dcr.icont_var = '".$text_name."' INNER JOIN ?_".$ilines_type_name."_type dt ON de.itype_id = dt.itype_id WHERE dt.itype_name = ? AND dck.icont_text = '".$value."'", $type_name);
		}
		return $DB->select("SELECT dcr.icont_text AS ".$text_name." FROM ?_".$ilines_type_name."_content dcr INNER JOIN ?_".$ilines_type_name."_element de ON de.el_id = dcr.el_id AND dcr.icont_var = '".$text_name."' INNER JOIN ?_".$ilines_type_name."_content dck ON de.el_id = dck.el_id AND dck.icont_var = '".$value_name."' INNER JOIN ?_".$ilines_type_name."_type dt ON de.itype_id = dt.itype_id WHERE dt.itype_name = ? AND  dck.icont_text = '".$value."'", $type_name);
	}
    function getTextByValue2($ilines_type_name,$value_name,$text_name,$type_name,$use_id,$value)
	{
		global $DB;
		
		return $DB->select("SELECT d.icont_text AS text FROM adm_directories_content AS d
							WHERE d.icont_var='text' AND d.el_id=".(int)$value
							);
	} 
}

?>