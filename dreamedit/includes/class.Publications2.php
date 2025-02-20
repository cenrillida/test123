<?
class Publications
{

    var $childNodesName;

	function __construct($childNodesName = "childNodes")
        {
	    $this->childNodesName = $childNodesName;
	}

        function Persons($childNodesName = "childNodes")
	{
            $this->__construct($childNodesName);
	}

	// ¬ыбрать все страницы (с использованием условий) + формирование списка детей в дополнительном ключе "childNodes"
	function getPublicationsByContextSearch($context_search)
	{
	    global $DB, $_CONFIG;
	    $rows =  $DB->select(
	    "SELECT id, name, name2, vid, tip FROM `publ` WHERE name like '%".$context_search."%' OR name2 like '%".$context_search."%'");


            return $rows;
     }

	function getPublicationVidArray()
	{
 		global $DB,$_CONFIG;

           $fd=$DB->select("SELECT text FROM vid ORDER BY id");
	   foreach($fd as $i=>$fd0)
	     $qq[$i]=$fd0[text];

        return $qq;
	 }

// ѕолучить название рубрики по Id
   function getRubricNameById($id)
   {        global $DB,$_CONFIG;
        $rows=$DB->select("SELECT name FROM publ_rubric WHERE id=".$id);
        return $rows[0];

   }

//ѕолучить список авторов
   function getAuthors($spisok)
   {     global $DB,$_CONFIG;

     $aa=explode("<br>",trim($spisok));
     $ret="";
     foreach($aa as $a)
     {     	if (!empty($a))