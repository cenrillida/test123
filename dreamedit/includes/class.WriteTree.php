<?

/********************************************************
treeElements =
Array(
	nodeID => Array(
		["pid"]		 = parent_id,
		["name"]	 = nodeName,
		["url"]		 = onNodeClickUrl,
		["title"]    = nodeTitle,
		["target"]	 = target (null),
		["icon"]	 = nodeImg,
		["iconOpen"] = openNodeImg,
		["open"]     = isOpen (bool),
	)
)
********************************************************/
class WriteTree
{
	var $treeElements; // эл-ты дерева
	var $treeName; // имя дерева в js

	var $createdTrees = array(); // имя дерева в js


	function __construct($name = "", $data = array())
	{
		$this->clear();

		if(!empty($data))
			$this->setElements($data);

		if(!empty($name))
			$this->setTreeName($name);
	}

	function WriteTree($name = "", $data = array())
	{
		$this->__construct($name, $data);
	}

	function clear()
	{
		$this->configData = array();
		$this->setElements(array());
		$this->setTreeName("dTree");
	}



	function setTreeName($name)
	{
		$this->treeName = $name;
	}

	function setElements($data)
	{
		$this->treeElements = $data;
	}

	function appendElements($data)
	{
		$this->treeElements = array_merge($this->treeElements, $data);
	}

	function appendElement($id, $elementData)
	{
		$this->treeElements[$id] = $elementData;
	}

	function deleteElement($id)
	{
		unset($this->treeElements[$id]);
	}

	function setTreeConfig($attribute, $data)
	{
		$this->configData[$attribute] = $data;
	}

	function displayConfig()
	{
		if(!isset($this->createdTrees[$this->treeName]))
			return trigger_error($this->treeName." treeObject doesn't exists!", E_USER_WARNING);

		foreach($this->configData as $attribute => $data)
			echo $this->treeName.".config.".$attribute." = '".$data."';\n";
	}

	function displayTree($treeTitle, $start = 0)
	{
		// mytree.add(id, pid, name, url, title, target, icon, iconOpen, open);

		echo "<script type=\"text/javascript\">\n";

		echo "var ".$this->treeName." = new dTree('".$this->treeName."');\n";
		$this->createdTrees[$this->treeName] = true;

		$this->displayConfig();

		// рисуем корень дерева
		echo $this->treeName.".add('".$start."', -1, '".$treeTitle."');\n";

		foreach($this->treeElements as $id => $el)
		{

			echo $this->treeName.".add('".$id."', '".$el["pid"]."', ".'"'.str_replace('"','',$el["name"]).'"'.", '".$el["url"]."',".' "'.str_replace('"','',str_replace("'","*",$el["title"])).'", '.(is_null($el["target"])? "null": "'".$el["target"]."'").", '".$el["icon"]."', '".$el["iconOpen"]."'".($el["open"]? ", true": "").");\n";
	//	echo $this->treeName.".add('".$id."', '".$el["pid"]."', '".str_replace('"','',$el["name"])."', '".$el["url"]."',".' "'.str_replace('"','',str_replace("'","*","qqqqqq")).'", '.(is_null($el["target"])? "null": "'".$el["target"]."'").", '".$el["icon"]."', '".$el["iconOpen"]."'".($el["open"]? ", true": "").");\n";
		
	}

		echo "document.write(".$this->treeName.");\n";

		echo "</script>";
	}
// Для услуг
function displayServiceTree($treeTitle, $start = 0,$rows)
	{
//	print_r($rows);
echo "<script type=\"text/javascript\">\n";
        $imgpath="inion.isras.ru/dreamedit/skin/classic/images/dTree/";
		echo "var ".$this->treeName." = new dTree('".$this->treeName."');\n";
		echo $this->treeName.".config.imgPath = 'https://".$imgpath."';\n";
		//echo $this->treeName.".config.imgPath = 'https://audio.isras.ru/dreamedit/skin/classic//images/dTree/';\n";
     //   $treeTitle='Ученые степени';
        echo $this->treeName.".add('0','-1','".$treeTitle."');\n";
        $i=0; $j=0;
        foreach ($rows as $p)
        {

           if ($p[el_id]==$p[gid])
           {
		        $j++;
//		        echo $this->treeName.".add('".((-1000)*$j)."','0','".$p[usluga]."');\n";
		        echo $this->treeName.".add('".((-1000)*$j)."','0', '".$p["usluga"]."', ".
				"'javascript:treeSelect(\'g\',\'".$p["gid"]."\',\'".$p["usluga"]."\',\'".$p["gruppa"]."\',\'".$p[usluga]."\');', '".$p["usluga"]."',
              null, 'page.gif', 'page.gif');\n";
		   }
           else
           {
  //      $url="index.php?mod=directory2&action=edit&type=stepen&id=";
 //       foreach($rows as $p)
//		{

			echo $this->treeName.".add('".($i+100000)."','".((-1000)*$j)."', '".$p["usluga"]."', ".
			"'javascript:treeSelect(\'u\',\'".$p["el_id"]."\',\'".$p["usluga"]."\',\'".$p["gruppa"]."\',\'".$p[usluga]."\');', '".$p["usluga"]."',
              null, 'page.gif', 'page.gif');\n";
           }
           $i++;
			}

		echo $this->treeName.".openAll();\n;";
		echo "document.write(".$this->treeName.");\n";
		echo "</script>";
	}
// Дерево публикаций из базы
   function displayTreeBases($treeTitle,$imgpath,$publications)
	{
		  global $DB;
		  $rubric=$DB->select("SELECT r.id AS rid,r.name AS rubric
                     FROM base_rubric AS r

	                 ORDER BY r.sort,r.name ");
//  print_r($publications);echo "!!!!";


  echo "<script type=\"text/javascript\">\n";

		echo "var ".$this->treeName." = new dTree('".$this->treeName."');\n";
		//$this->displayConfig();
		echo $this->treeName.".config.imgPath = 'https://".$imgpath."';\n";

		echo $this->treeName.".add('0','-1','".$treeTitle."');\n";



   foreach($rubric as $i=>$vid)
		{
			echo $this->treeName.".add('".($vid[rid]*100+100000)."','0','".ltrim($vid[rubric])."','',null, 'page.gif', 'page.gif');\n";

		$srubric=$DB->select("SELECT id,name  FROM base_subrubric WHERE rubric=".$vid[rid]." ORDER BY sort,name");
		foreach($srubric as $sid=>$v)
		{
			echo $this->treeName.".add('".((-100)*$v[id])."', '".($vid[rid]*100+100000)."', '".$v["name"], "', '', null, 'page.gif', 'page.gif');\n";

		}


	}

	foreach($publications as $p)
		{

//				echo $this->treeName.".add('".$p[id]."', '".'-100'."', '".str_replace('"',' ',addcslashes(trim($p["name"]), "\n\r\""))."', 'javascript:treeSelect(\'".$p["id"]."\',\'".str_replace('"',' ',addcslashes(trim($p["name"]), "\n\r\""))."\',\'".str_replace('"',' ',addcslashes(trim($p["name"]),"\n\r\"."))."\');', null, 'page.gif', 'page.gif');\n";
 				echo $this->treeName.".add('".$p[id]."', '".(-100)*$p[subrubric]."', '".str_replace('"',' ',addcslashes(trim($p["name"]), "\n\r\"")).
 				"','index.php?mod=base&action=edit&id=".$p[id]."', null, 'page.gif', 'page.gif');\n";

		}


		echo $this->treeName.".openAll();\n;";
		echo "document.write(".$this->treeName.");\n";

		echo "</script>";

	}
	function displayFlatTree($treeTitle,$imgpath,$persons,$b)
	{

//        if ($b=="AZ") $b="";
		echo "<script type=\"text/javascript\">\n";
		echo "var ".$this->treeName." = new dTree('".$this->treeName."');\n";
		echo $this->treeName.".config.imgPath = 'https://".$imgpath."';\n";
		echo $this->treeName.".add('0','-1','".$treeTitle."');\n";
if ($b!="AZ") {
        echo $this->treeName.".add('-2','0','".$b."а ... ".$b."ж','',null, 'page.gif', 'page.gif');\n";
      echo $this->treeName.".add('-10','0','".$b."з ...".$b." м','',null, 'page.gif', 'page.gif');\n";
        echo $this->treeName.".add('-11','0','".$b."н ...".$b." ф','',null, 'page.gif', 'page.gif');\n";
        echo $this->treeName.".add('-12','0','".$b."х ...".$b." я','',null, 'page.gif', 'page.gif');\n";
        echo $this->treeName.".add('-13','0','".$b."a ...".$b." z','',null, 'page.gif', 'page.gif');\n;";
}
else
        echo $this->treeName.".add('-13','0','A ... Z','',null, 'page.gif', 'page.gif');\n;";
		foreach($persons as $p)
		{

   			if(ord(strtoupper(substr($p["fullname"],1))) <= ord('Z'))
		 	echo $this->treeName.".add('".$p[id]."', '-13', '".$p["fullname"]."', 'javascript:treeSelect(\'".$p["id"]."\',\'".$p["shortname"]."\',\'".$p["Autor_en"]."\',\'".$p["contact"]."\',\'".$p["ForSite"]."\',\'".$p["fullname"]."\',\'"." "."\',\'"." "."\',\'".$p["rank"]."\',\'".$p["academ"]."\');', '".$p["fullname"]."', null, 'page.gif', 'page.gif');\n";
           else if(ord(strtoupper(substr($p["fullname"],1))) <= ord('Ж') )
				echo $this->treeName.".add('".$p[id]."', '-2', '".$p["fullname"]."', 'javascript:treeSelect(\'".$p["id"]."\',\'".$p["shortname"]."\',\'".$p["Autor_en"]."\',\'".$p["contact"]."\',\'".$p["ForSite"]."\',\'".$p["fullname"]."\',\'".$p["picbig"]."\',\'".$p["picsmall"]."\',\'".$p["rank"]."\',\'".$p["academ"]."\');', '".$p["fullname"]."', null, 'page.gif', 'page.gif');\n";

			else if(ord(strtoupper(substr($p["fullname"],1))) <= ord('М') )
				echo $this->treeName.".add('".$p[id]."', '-10', '".$p["fullname"]."', 'javascript:treeSelect(\'".$p["id"]."\',\'".$p["shortname"]."\',\'".$p["Autor_en"]."\',\'".$p["contact"]."\',\'".$p["ForSite"]."\',\'".$p["fullname"]."\',\'".$p["picbig"]."\',\'".$p["picsmall"]."\',\'".$p["id"]."\',\'".$p["id"]."\');', '".$p["fullname"]."', null, 'page.gif', 'page.gif');\n";
			else if(ord(strtoupper(substr($p["fullname"],1))) <= ord('Ф') )
				echo $this->treeName.".add('".$p[id]."', '-11', '".$p["fullname"]."', 'javascript:treeSelect(\'".$p["id"]."\',\'".$p["shortname"]."\',\'".$p["Autor_en"]."\',\'".$p["contact"]."\',\'".$p["ForSite"]."\',\'".$p["fullname"]."\',\'"." "."\',\'"." "."\',\'".$p["id"]."\',\'".$p["id"]."\');', '".$p["fullname"]."', null, 'page.gif', 'page.gif');\n";
			else if(ord(strtoupper(substr($p["fullname"],1))) <= ord('Я') )
				echo $this->treeName.".add('".$p[id]."', '-12', '".$p["fullname"]."', 'javascript:treeSelect(\'".$p["id"]."\',\'".$p["shortname"]."\',\'".$p["Autor_en"]."\',\'".$p["contact"]."\',\'".$p["ForSite"]."\',\'".$p["fullname"]."\',\'"." "."\',\'"." "."\',\'".$p["id"]."\',\'".$p["id"]."\');', '".$p["fullname"]."', null, 'page.gif', 'page.gif');\n";
			else
				echo $this->treeName.".add('".$p[id]."', '-0', '".$p["fullname"]."', 'javascript:treeSelect(\'".$p["id"]."\',\'".$p["shortname"]."\',\'".$p["Autor_en"]."\',\'".$p["contact"]."\',\'".$p["ForSite"]."\',\'".$p["fullname"]."\',\'"." "."\',\'"." "."\',\'".$p["id"]."\',\'".$p["id"]."\');', '".$p["fullname"]."', null, 'page.gif', 'page.gif');\n";

		}

		//javascript:treeSelect(\'/?page_id=538&id=".$p["id"]."\', '".$p["fullname"]."');
		echo $this->treeName.".openAll();\n;";

		echo "document.write(".$this->treeName.");\n";

		echo "</script>";

	}
       // Дерево персоналий по алфавиту
	function displayFlatTreeAlf($treeTitle,$imgpath,$persons)
	{

//echo "123";
		$alf=Array("а","б","в","г","д","е","ё","ж","з","и","й","к","л","м","н","о","п","р","с","т","у","ф","х","ц","ч","ш","щ","ь","ы","ъ","э","ю","я");
        $i=0;
        foreach($persons as $p)
        {
        	$alf0[substr($p[fullname],1,1)]="*";

        }

		echo "<script type=\"text/javascript\">\n";

		echo "var ".$this->treeName." = new dTree('".$this->treeName."');\n";
		echo $this->treeName.".config.imgPath = 'https://".$imgpath."';\n";
		//echo $this->treeName.".config.imgPath = 'https://audio.isras.ru/dreamedit/skin/classic//images/dTree/';\n";
        echo $this->treeName.".add('0','-1','".$treeTitle."');\n";

        $i=0;
        foreach($persons as $p)
		{

			echo $this->treeName.".add('".($i+100000)."','0', '".$p["fullname"]."', 'javascript:treeSelect(\'".$p["id"]."\',\'".$p["fullname"]."\',\'".$p["otdel"]."\',\'".$p["contact"]."\',\'".$p["dolj"]."\',\'".$p["us"]."\',\'".$p["picbig"]."\',\'".$p["picsmall"]."\',\'".$p["uz"]."\',\'".$p["chlen"]."\');', '".$p["fullname"]."', null, 'page.gif', 'page.gif');\n";
            $i++;
					}

		echo $this->treeName.".openAll();\n;";
		echo "document.write(".$this->treeName.");\n";
		echo "</script>";

	}
	 //Дерево для статей
    function displayArticlesTree($treeTitle,$imgpath,$publications)
	{
		echo "<script type=\"text/javascript\">\n";
		echo "var ".$this->treeName." = new dTree('".$this->treeName."');\n";
		//$this->displayConfig();
		echo $this->treeName.".config.imgPath = 'https://".$imgpath."';\n";

		echo $this->treeName.".add('0','-1','".$treeTitle."');\n";
		$alf=Array("А","Б","В","Г","Д","Е","Ё","Ж","З","И","К","Л","М","Н","О","П","Р","С","Т","У","Ф","Х","Ц","Ч","Ш","Щ","Э","Ю","Я");
        $i=0;
        foreach($publications as $p)
        {
          if (!empty($p[name]))
         {
        	if (empty($alf0[substr($p[name],0,1)]))
        	{
	        	$alf0[substr(trim($p[name]),0,1)]=$i;
	        	$i++;
            }
         }
        }

		foreach($alf0 as $alf=>$i)
		{
			echo $this->treeName.".add('".($i+100000)."','0','".mb_strtoupper($alf)."','',null, 'page.gif', 'page.gif');\n";
		}


		foreach($publications as $p)
		{
//			$i=array_search(substr($p[name],0,1),$alf);
//echo "<br />______";print_r($p);
         if (!empty($p[name]))
         {
			$i=$alf0[substr($p[name],0,1)];
			if ($p[date_public]=='') $sym="-";else $sym=" ";
			echo $this->treeName.".add('".$p[page_id]."', '".($i+100000)."', '".$sym.str_replace('"',' ',addcslashes(trim($p["name"]).
			" (№ ".$p[number].", ".$p[year].")", "\n\r\"")).
			"', 'javascript:treeSelect(\'".$p["page_id"]."&jid=".$p[jid]."\',\'".str_replace('"',' ',addcslashes(trim($p["name"]), "\n\r\""))."\',\'".
			str_replace('"',' ',addcslashes("// Вестник Института социологии, № ".trim($p["number"]).", ".trim($p["year"]), "\n\r\""))."\');', '".str_replace('"',' ',addcslashes(trim($p["name"])." (№ ".$p[number].", ".$p[year].")","\n\r\""))."', null, 'page.gif', 'page.gif');\n";
		  }
		}

		//javascript:treeSelect(\'/?page_id=538&id=".$p["id"]."\', '".$p["fullname"]."');
		echo $this->treeName.".openAll();\n;";
		echo "document.write(".$this->treeName.");\n";

		echo "</script>";

	}
	  //Дерево для статей одного номера
    function displayArticlesTree2($treeTitle,$imgpath,$publications)
	{
//print_r($_REQUEST);

		echo "<script type=\"text/javascript\">\n";
		echo "var ".$this->treeName." = new dTree('".$this->treeName."');\n";
		//$this->displayConfig();
		echo $this->treeName.".config.imgPath = 'https://".$imgpath."';\n";

		echo $this->treeName.".add('0','-1','".$treeTitle."');\n";
//		$alf=Array("А","Б","В","Г","Д","Е","Ё","Ж","З","И","К","Л","М","Н","О","П","Р","С","Т","У","Ф","Х","Ц","Ч","Ш","Щ","Э","Ю","Я");
//		for($i=0; $i < count($alf); $i++)
//		{
//			echo $this->treeName.".add('".($i+100000)."','0','".$alf[$i]."','',null, 'page.gif', 'page.gif');\n";
//		}
//        for ($i=0;$i<count($publications);$i++)
//        {
//	        echo $this->treeName.".add('".($i+100000)."','0','*','',null, 'page.gif', 'page.gif');\n";
//	    }

		$i=0;
		foreach($publications as $p)
		{
//echo "<br />______";print_r($p);
			 //array_search(substr($p[name],0,1),$alf);
			if ($p[date_public]=='') $sym="-";else $sym=" ";
			if ($p[page_template]=='jarticle')
			{
//			echo $this->treeName.".add('".$p[page_id]."', '".($i+100000)."', '".$sym.str_replace('"',' ',addcslashes(trim($p["name"]).
//			" (№ ".$p[number].", ".$p[year].")", "\n\r\"")).
//			"', 'javascript:treeSelect(\'".$p["page_id"]."&jid=".$p[jid]."\',\'".str_replace('"',' ',addcslashes(trim($p["name"]), "\n\r\""))."\',\'".
//			str_replace('"',' ',addcslashes("// Вестник Института социологии, № ".trim($p["number"]).", ".trim($p["year"]), "\n\r\""))."\');', '".str_replace('"',' ',addcslashes(trim($p["name"])." (№ ".$p[number].", ".$p[year].")","\n\r\""))."', null, 'page.gif', 'page.gif');\n";

			echo $this->treeName.".add('".($i+100000)."', 0,'".$sym.str_replace('"',' ',addcslashes(trim($p["name"]).
			" (№ ".$p[number].", ".$p[year].")", "\n\r\"")).
			"', 'javascript:treeSelect(\'".$p["page_id"]."&jid=".$p[jid]."\',\'".str_replace('"',' ',addcslashes(trim($p["name"]), "\n\r\""))."\',\'".
			str_replace('"',' ',addcslashes($treeTitle, "\n\r\""))."\');', '".str_replace('"',' ',addcslashes(trim($p["name"])." (№ ".$p[number].", ".$p[year].")","\n\r\""))."', null, 'page.gif', 'page.gif');\n";


		    $i++;
		    }
		}

		//javascript:treeSelect(\'/?page_id=538&id=".$p["id"]."\', '".$p["fullname"]."');
		echo $this->treeName.".openAll();\n;";
		echo "document.write(".$this->treeName.");\n";

		echo "</script>";

	}
// Для публикаций
	function displayPublicationTree($treeTitle,$imgpath,$publications,$vids)
	{
		echo "<script type=\"text/javascript\">\n";
		echo "var ".$this->treeName." = new dTree('".$this->treeName."');\n";
		//$this->displayConfig();
		echo $this->treeName.".config.imgPath = 'https://".$imgpath."';\n";

		echo $this->treeName.".add('0','-1','".$treeTitle."');\n";

//		for($i=0; $i < count($vids); $i++)

        foreach($vids as $i=>$vid)
		{
//			echo $this->treeName.".add('".($i+10001)."','0','".ltrim($vids[$i])."','',null, 'page.gif', 'page.gif');\n";
			echo $this->treeName.".add('".($i+10000)."','0','".ltrim($vid)."','',null, 'page.gif', 'page.gif');\n";
		}

		//for($i=0; $i< 112; $i++)
		//{
		//		echo $this->treeName.".add('".$publications[$i][id]."', '".($publications[$i][vid]+10000)."', '".addcslashes(trim($publications[$i]["name"]), "\n\r")."', 'javascript:treeSelect(\'".$publications[$i]["id"]."\',\'".addcslashes(trim($publications[$i]["name"]), "\n\r")."\',\'"." "/*addcslashes(trim($p["name2"]), "\n\r")*/."\');', '".addcslashes(trim($publications[$i]["name"]),"\n\r")."', null, 'page.gif', 'page.gif');\n";
		//}
		foreach($publications as $p)
		{
				echo $this->treeName.".add('".$p[id]."', '".($p[vid]+10000)."', '".str_replace('"',' ',addcslashes(trim($p["name"]), "\n\r\""))."', 'javascript:treeSelect(\'".$p["id"]."\',\'".str_replace('"',' ',addcslashes(trim($p["name"]), "\n\r\""))."\',\'".str_replace('"',' ',addcslashes(trim($p["name2"]), "\n\r\""))."\');', '".str_replace('"',' ',addcslashes(trim($p["name"]),"\n\r\""))."', null, 'page.gif', 'page.gif');\n";
		}

		//javascript:treeSelect(\'/?page_id=538&id=".$p["id"]."\', '".$p["fullname"]."');
		echo $this->treeName.".openAll();\n;";
		echo "document.write(".$this->treeName.");\n";

		echo "</script>";

	}
// Для новостей
function displayNewsTree($treeTitle,$imgpath,$publications,$vids)
	{
//echo "@@@";print_r($publications);
	echo "<script type=\"text/javascript\">\n";
		echo "var ".$this->treeName." = new dTree('".$this->treeName."');\n";
		//$this->displayConfig();
		echo $this->treeName.".config.imgPath = 'https://".$imgpath."';\n";

		echo $this->treeName.".add('0','-1','".$treeTitle."');\n";

//		for($i=0; $i < count($vids); $i++)

        foreach($vids as $i=>$vid)
		{
//			echo $this->treeName.".add('".($i+10001)."','0','".ltrim($vids[$i])."','',null, 'page.gif', 'page.gif');\n";
			echo $this->treeName.".add('".($vid+10000)."','0','".ltrim($vid)."','',null, 'page.gif', 'page.gif');\n";
		}

		//for($i=0; $i< 112; $i++)
		//{
		//		echo $this->treeName.".add('".$publications[$i][id]."', '".($publications[$i][vid]+10000)."', '".addcslashes(trim($publications[$i]["name"]), "\n\r")."', 'javascript:treeSelect(\'".$publications[$i]["id"]."\',\'".addcslashes(trim($publications[$i]["name"]), "\n\r")."\',\'"." "/*addcslashes(trim($p["name2"]), "\n\r")*/."\');', '".addcslashes(trim($publications[$i]["name"]),"\n\r")."', null, 'page.gif', 'page.gif');\n";
		//}
		foreach($publications as $p)
		{
//				echo $this->treeName.".add('".$p[id]."', '".($p[vid]+10000)."', '".str_replace('"',' ',addcslashes(trim($p["name"]), "\n\r\""))."', 'javascript:treeSelect(\'".$p["id"]."\',\'".str_replace('"',' ',addcslashes(trim($p["name"]), "\n\r\""))."\',\'".str_replace('"',' ',addcslashes(trim(strip_tags($p["name2"])), "\n\r\""))."\');', '".str_replace('"',' ',addcslashes(trim($p["name"]),"\n\r\""))."', null, 'page.gif', 'page.gif');\n";

echo $this->treeName.".add('".$p[id]."', '".($p[vid]+10000)."', '".str_replace('"',' ',addcslashes(trim(str_replace("'","*",$p["name"])), "\n\r\""))."', 'javascript:treeSelect(	\'".$p["id"]."\',\'".str_replace('"',' ',addcslashes(trim($p["name"]), "\n\r\""))."\',\'".str_replace('"',' ',addcslashes(trim(strip_tags(str_replace("'","*",$p["name2"]))), "\n\r\""))."\',\'".str_replace('"',' ',addcslashes(trim(strip_tags($p["tip"])), "\n\r\""))."\');', '".str_replace('"',' ',addcslashes(trim(str_replace("'","*",$p["name"])),"\n\r\""))."', null, 'page.gif', 'page.gif');\n";
	

		}

		//javascript:treeSelect(\'/?page_id=538&id=".$p["id"]."\', '".$p["fullname"]."');
		echo $this->treeName.".openAll();\n;";
		echo "document.write(".$this->treeName.");\n";

		echo "</script>";

	}

	function openTreeTo($id, $selected = true)
	{
		if(!isset($this->createdTrees[$this->treeName]))
			return trigger_error($this->treeName." treeObject doesn't exists!", E_USER_WARNING);

		echo "<script>";
		echo $this->treeName.".openTo('".$id."', ".($selected? "true": "false").");";
		echo "</script>";
	}


}

?>