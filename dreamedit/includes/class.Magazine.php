<?


class Magazine
{
	var $childNodesName;

	function __construct($childNodesName = "childNodes")
	{
		ini_set('memory_limit', '256M');
		$this->childNodesName = $childNodesName;
	}

	function Pages($childNodesName = "childNodes")
	{
		$this->__construct($childNodesName);
	}

	// �������� ���� �������� �������� (�� ��������� - page_id)
	function getRootPageId($field = "page_id")
	{
		global $DB;
		return $DB->selectCell("SELECT ?# FROM ?_magazine WHERE page_parent = 0", $field);
	}

	// ������� ��� �������� (� �������������� �������) + ������������ ������ ����� � �������������� ����� "childNodes"
	function getPages($page_status = null, $page_link = null, $page_type = null)
	{
		global $DB;

		$rows =  $DB->select(
			"SELECT ".
				"?_magazine.page_id AS ARRAY_KEY, ".
				"?_magazine.* ".
			"FROM ?_magazine ".
			"WHERE ".
				"1 = 1 ".
				"{AND page_status  = ?d} ".
				"{AND page_link    = ?d} ".
				"{AND page_type    = ?d} ".
			"ORDER BY ".
				"page_position ASC, ".
				"page_name ASC",

			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status),
			(is_null($page_link)   ? DBSIMPLE_SKIP: $page_link),
			(is_null($page_type)   ? DBSIMPLE_SKIP: $page_type)
		);

		$rows[0] = array();
		$rows[0][$this->childNodesName] = array();
		foreach($rows as $k => $v)
			$rows[(int)@$v["page_parent"]][$this->childNodesName][] = $k;

		return $rows;
	}
	// English ������� ��� �������� (� �������������� �������) + ������������ ������ ����� � �������������� ����� "childNodes"
	function getPagesEn($page_status = null, $page_link = null, $page_type = null)
	{
		global $DB;

		$rows =  $DB->select(
			"SELECT ".
				"?_magazine.page_id AS ARRAY_KEY, ".
				"?_magazine.* ".
			"FROM ?_magazine ".
			"WHERE ".
				" page_name_en <> '' AND ".
				"{AND page_status  = ?d} ".
				"{AND page_link    = ?d} ".
				"{AND page_type    = ?d} ".
			"ORDER BY ".
				"page_position ASC, ".
				"page_name ASC",

			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status),
			(is_null($page_link)   ? DBSIMPLE_SKIP: $page_link),
			(is_null($page_type)   ? DBSIMPLE_SKIP: $page_type)
		);

		$rows[0] = array();
		$rows[0][$this->childNodesName] = array();
		foreach($rows as $k => $v)
			$rows[(int)@$v["page_parent"]][$this->childNodesName][] = $k;

		return $rows;
	}
	// ��� �������������� � ���������������� ������
	function getNumbersAll($date_public = null, $page_link = null, $page_type = null)
	{

		global $DB;
		global $DB;
		if (!empty($_REQUEST[page_id]))
		{

		If (empty($jid))
		{
				$jid0=$this->getMagazineJId($_REQUEST[page_id]);
				$jid=$jid0[0][journal];
		}
	//	echo "<br />".$jid."@@@@".$_SESSION[jour_id];
		$rows=$DB->select ("SELECT a.page_id AS pid,a.*,c.cv_text AS date_public FROM `adm_article` AS a
		 LEFT OUTER JOIN adm_article_content AS c ON c.page_id=a.page_id AND cv_name='date_public' ".
		" WHERE page_template='jnumber' AND a.page_status=1 AND a.journal=".$_SESSION[jour_id]."  AND c.cv_text<>''");

        return $rows;
        }
    }
    // ��� �������������� � ���������������� ������ �� ���� ��������
	function getNumbersAllMagazine($jid,$date_public = null, $page_link = null, $page_type = null)
	{

		global $DB;


		$rows=$DB->select ("SELECT a.*,mm.page_name AS jname,c.cv_text AS date_public,a.journal FROM `adm_article` AS a
		 LEFT OUTER JOIN adm_article_content AS c ON c.page_id=a.page_id AND cv_name='date_public' ".
		 " INNER JOIN adm_magazine AS mm ON mm.page_id=a.journal ".
		" WHERE a.page_template='jnumber' AND a.page_status=1 ORDER BY a.journal,c.cv_text");

        return $rows;
    }
	
	
	// ������� ��� ������ � �������
	function getPagesArticle($page_status = null, $page_link = null, $page_type = null,$jid=null)
	{
		global $DB;
/*		if (1==1) //if (!empty($jid) && $jid>1000)
		{	
        $rr=$DB->select("SELECT page_name AS number, year 
		                 FROM adm_article WHERE page_id=".$jid);
		//				 print_r($rr);
						 
		$where="adm_article.year=".$rr[0][year]." AND adm_article.number='".$rr[0][number]."'";
		}
		else
*/		$where=1;
		$rows =  $DB->select(
			"SELECT DISTINCT 	".
				"?_article.page_id AS ARRAY_KEY, ".
				"?_article.* ".
			"FROM ?_article ".
			"WHERE  ".
				"1 = 1 AND ".$where.
				"{AND page_status  = ?d} ".

			"ORDER BY  ".
				"page_parent ASC, ".
				" page_position,".
				"page_name ASC",

			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status)
		);

		$rows[0] = array();
		$rows[0][$this->childNodesName] = array();
		foreach($rows as $k => $v)
			$rows[(int)@$v["page_parent"]][$this->childNodesName][] = $k;
/*
		foreach($rows as $r)
{
   echo "<br />".$r[page_parent]." ".$r[page_id]. " ".$r[page_name]." ".$r[page_position];//print_r($r);
}
*/
		return $rows;
	}
	// English ������� ��� ������ � �������
	function getPagesArticleEn($page_status = null, $page_link = null, $page_type = null)
	{
		global $DB;

		$rows =  $DB->select(
			"SELECT ".
				"?_article.page_id AS ARRAY_KEY, ".
				"?_article.* ".
			"FROM ?_article ".
			" INNER JOIN adm_article_content AS o ON o.page_id=adm_article.page_id AND cv_name='order' ". 
			"WHERE ".
				" (IFNULL(o.cv_text,'')<>'') ".
				"{AND page_status  = ?d} ".

			"ORDER BY  ".
				"page_position ASC, ".
				"name_en ASC",

			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status)
		);

		$rows[0] = array();
		$rows[0][$this->childNodesName] = array();
		foreach($rows as $k => $v)
			$rows[(int)@$v["page_parent"]][$this->childNodesName][] = $k;

		return $rows;
	}
    // ������� ��� ������ � ������� ��� ���������
	function getPagesArticleNone($page_status = null, $page_link = null, $page_type = null)
	{
		global $DB;

		$rows =  $DB->select(
			"SELECT ".
				"?_article.page_id AS ARRAY_KEY, ".
				"?_article.page_id,?_article.page_name,?_article.name,?_article.jid,?_article.number,?_article.year,?_article.date_public,?_article.people, ".
				"m.page_name AS journal_name ".
			"FROM ?_article ".
			" INNER JOIN ?_magazine AS m ON m.page_id=?_article.journal ".
			"WHERE ".
				"1 = 1 ".
				" AND page_template='jarticle' ".
				"{AND page_status  = ?d} ".


			"ORDER BY  ".
			"name ASC",

			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status)
		);

		$rows[0] = array();
		$rows[0][$this->childNodesName] = array();
		foreach($rows as $k => $v)
			$rows[(int)@$v["page_parent"]][$this->childNodesName][] = $k;

		return $rows;
	}
	// English ������� ��� ������ � ������� ��� ���������
	function getPagesArticleNoneEn($page_status = null, $page_link = null, $page_type = null)
	{
		global $DB;

		$rows =  $DB->select(
			"SELECT ".
				"?_article.page_id AS ARRAY_KEY, ".
				"?_article.page_id,?_article.page_name,?_article.name,?_article.jid,?_article.number,?_article.year,?_article.date_public,?_article.people, ".
				"m.page_name AS journal_name ".
			"FROM ?_article ".
			" INNER JOIN ?_magazine AS m ON m.page_id=?_article.journal ".
			"WHERE ".
				" page_name_en<>'' AND ".
				" AND page_template='jarticle' ".
				"{AND page_status  = ?d} ".


			"ORDER BY  ".
			"name ASC",

			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status)
		);

		$rows[0] = array();
		$rows[0][$this->childNodesName] = array();
		foreach($rows as $k => $v)
			$rows[(int)@$v["page_parent"]][$this->childNodesName][] = $k;

		return $rows;
	}
      // ������� ��� �������� ������� � �������� (� �������������� �������) + ������������ ������ ����� � �������������� ����� "childNodes"
	function getPagesRoot($page_status = null, $page_link = null, $page_type = null, $page_parent = null)
	{
		global $DB;

        if (empty($page_parent)) $page_parent=1;

		$rows =  $DB->select(
			"SELECT ".
				"?_magazine.page_id AS ARRAY_KEY, ".
				"?_magazine.* ".
			"FROM ?_magazine ".
			"WHERE ".
				"1 = 1 ".
				"{AND page_status  = ?d} ".
				"{AND page_link    = ?d} ".
				"{AND page_type    = ?d} ".
				" AND page_parent =".$page_parent." OR page_id= ".$page_parent.
			" ORDER BY  ".
				"page_position ASC, ".
				"page_name ASC",

			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status),
			(is_null($page_link)   ? DBSIMPLE_SKIP: $page_link),
			(is_null($page_type)   ? DBSIMPLE_SKIP: $page_type)
		);


		$rows[0] = array();
		$rows[0][$this->childNodesName] = array();

		foreach($rows as $k => $v)
		{
    			$rows[(int)@$v["page_parent"]][$this->childNodesName][] = $k;
        }
		return $rows;
	}
	 // English ������� ��� �������� ������� � �������� (� �������������� �������) + ������������ ������ ����� � �������������� ����� "childNodes"
	function getPagesRootEn($page_status = null, $page_link = null, $page_type = null, $page_parent = null)
	{
		global $DB;

        if (empty($page_parent)) $page_parent=1;

		$rows =  $DB->select(
			"SELECT ".
				"?_magazine.page_id AS ARRAY_KEY, ".
				"?_magazine.* ".
			"FROM ?_magazine ".
			"WHERE ".
				" page_name_en<>'' AND ".
				"{AND page_status  = ?d} ".
				"{AND page_link    = ?d} ".
				"{AND page_type    = ?d} ".
				" AND page_parent =".$page_parent." OR page_id= ".$page_parent.
			" ORDER BY  ".
				"page_position ASC, ".
				"page_name ASC",

			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status),
			(is_null($page_link)   ? DBSIMPLE_SKIP: $page_link),
			(is_null($page_type)   ? DBSIMPLE_SKIP: $page_type)
		);


		$rows[0] = array();
		$rows[0][$this->childNodesName] = array();

		foreach($rows as $k => $v)
		{
    			$rows[(int)@$v["page_parent"]][$this->childNodesName][] = $k;
        }
		return $rows;
	}
// ���� �� ���� �������������� ������ ������� � ���� ������
	function getMagazineAllYear($jid)
	{

	    $cleanId = (int)$jid;

		if (!empty($_REQUEST[page_id])|| !empty($_REQUEST[id]))
		{
		if (empty($_REQUEST[page_id])) $_REQUEST[page_id]=$_REQUEST[id];
		global $DB;

		If (empty($cleanId))
		{
				$jid0=$this->getMagazineJId($_REQUEST[page_id]);
            $cleanId=(int)$jid0[0][journal];
		}
		if (!empty($cleanId))
		return $DB->select(
			"SELECT * FROM
					(SELECT DISTINCT a.year
					      FROM adm_article AS a
					      INNER JOIN adm_article_content AS c ON c.page_id=a.page_id AND c.cv_name='date_public'
					      INNER JOIN adm_magazine AS mz ON mz.page_id = a.journal
					      WHERE   a.journal=".$cleanId." AND c.cv_text<>''
					      AND a.page_template='jnumber'
					      ) AS t
			 ORDER BY  year DESC "

		);

		}
	}	
	// English ��� �������������� ������ ������� � ���� ������ 
 // ������� ��� �������� (� �������������� �������) + ������������ ������ ����� � �������������� ����� "childNodes" ��� Dreamedit
	function getPagesAll($page_status = null, $page_link = null, $page_type = null)
	{
		global $DB;

		$rows =  $DB->select(
			"SELECT ".
				"?_magazine.page_id AS ARRAY_KEY, ".
				"?_magazine.* ".
			"FROM ?_magazine ".
			"WHERE ".
				"1 = 1 ".
				"{AND page_status  = ?d} ".
				"{AND page_link    = ?d} ".
				"{AND page_type    = ?d} ".
                "AND page_old=1  ".
			"ORDER BY ".
			   	"page_position ASC, ".
				"page_name ASC ",

			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status),
			(is_null($page_link)   ? DBSIMPLE_SKIP: $page_link),
			(is_null($page_type)   ? DBSIMPLE_SKIP: $page_type)
		);

		$rows[0] = array();
		$rows[0][$this->childNodesName] = array();
		foreach($rows as $k => $v)
			$rows[(int)@$v["page_parent"]][$this->childNodesName][] = $k;

		return $rows;
	}
	 // English ������� ��� �������� (� �������������� �������) + ������������ ������ ����� � �������������� ����� "childNodes" ��� Dreamedit
	function getPagesAllEn($page_status = null, $page_link = null, $page_type = null)
	{
		global $DB;

		$rows =  $DB->select(
			"SELECT ".
				"?_magazine.page_id AS ARRAY_KEY, ".
				"?_magazine.* ".
			"FROM ?_magazine ".
			"WHERE ".
				" page_name_en<>'' AND ".
				"{AND page_status  = ?d} ".
				"{AND page_link    = ?d} ".
				"{AND page_type    = ?d} ".
                "AND page_old=1  ".
			"ORDER BY ".
			   	"page_position ASC, ".
				"page_name ASC ",

			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status),
			(is_null($page_link)   ? DBSIMPLE_SKIP: $page_link),
			(is_null($page_type)   ? DBSIMPLE_SKIP: $page_type)
		);

		$rows[0] = array();
		$rows[0][$this->childNodesName] = array();
		foreach($rows as $k => $v)
			$rows[(int)@$v["page_parent"]][$this->childNodesName][] = $k;

		return $rows;
	}
	//�������� ���� �������� ��� dreamedit
	function getMagazineNameAllD()
	{
	   global $DB;
	   return $DB->select("SELECT a.page_id,m.page_name
	          FROM adm_magazine AS m ".
			" INNER JOIN adm_article AS a ON a.journal=m.page_id AND a.page_parent=0 ".
	   	//	  INNER JOIN adm_pages_content AS pc ON pc.cv_text=m.page_id AND pc.cv_name='itype_jour'
	   	//	  INNER JOIN adm_pages AS p ON p.page_id=pc.page_id AND p.page_template='magazine_article'
	   		 " WHERE m.page_status=1 AND m.page_template='0'
	          ORDER BY m.page_name");
	}
	//�������� ���� ��������
	function getMagazineNameAll()
	{
	   global $DB;
	   return $DB->select("SELECT m.page_id,m.page_name,pc.page_id AS link_id,m.series,m.logo,m.info,m.issn,m.info
	          FROM adm_magazine AS m
	   		  INNER JOIN adm_pages_content AS pc ON pc.cv_text=m.page_id AND pc.cv_name='itype_jour'
	   		  INNER JOIN adm_pages AS p ON p.page_id=pc.page_id AND p.page_template='magazine_article'
	   		  WHERE m.page_status=1 AND m.page_template='0'
	          ORDER BY m.page_name");
	}
	//�������� ���� �������� ��� ������� ��������
	function getMagazineNameAllMain($online_resource = 0)
	{
	   global $DB;
	   return $DB->select("SELECT DISTINCT m.page_id,m.page_name,m.page_name_en,m.series,m.series_en,m.logo,m.info,m.info_en,
	          m.issn,pp.page_id AS journal_page,page_journame, m.page_link 
	          FROM adm_magazine AS m
			  
			  LEFT OUTER JOIN adm_pages AS pp ON  pp.page_template='magazine' AND 
			  pp.page_id IN (SELECT page_id FROM adm_pages_content AS ppc WHERE  ppc.cv_name='itype_jour' 
				   AND ppc.cv_text=m.page_id)
	   		  WHERE m.page_status=1 AND m.page_template='0' AND m.online_resource=?
				
	          ORDER BY m.priority,m.page_name", $online_resource);
	}

	function getMagazinesUrls() {
	    global $DB;
	    return $DB->select("SELECT page_id,page_journame FROM adm_magazine WHERE page_journame<>'' AND page_parent=0");
    }
	
	
	// ������� �������� �� ID
	function getPageById($id, $page_status = null, $page_type = null)
	{
		global $DB;
		return $DB->selectRow(
			"SELECT * ".
			"FROM ?_magazine ".
			"WHERE ".
				"page_id = ?d ".
				"{AND page_status  = ?d} ".
				"{AND page_type    = ?d} ",

			$id,
			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status),
			(is_null($page_type)   ? DBSIMPLE_SKIP: $page_type)
		);
	}
	
	// ������ ��������� ����� ������� �� id �������� ����������

	function getMagazineJId($id)
	{

	    $cleanId = (int)$id;

	if (!empty($cleanId))
		{
		global $DB;
		for ($i=0;$i<5;$i++)
		{
			$rows= $DB->select(
				"SELECT a.*,c.cv_text AS journal FROM
			  	 adm_pages AS a ".
			  	" INNER JOIN adm_pages AS n ON n.page_id=a.page_parent ".
			 	 " INNER JOIN adm_pages_content AS c ON c.page_id=n.page_id AND cv_name='ITYPE_JOUR' ".
			   	" WHERE a.page_id=".$cleanId);
			if (empty($rows))
			{
				$id0=$DB->select("SELECT page_parent FROM adm_pages WHERE page_id=".$cleanId);
                $cleanId=(int)$id0[0][page_parent];

			}
			if (empty($cleanId)) break;
			else break;
        }
        }

		return $rows;
	}

	// ������ ��������� ����� �������
	function getLastMagazineNumber($jid)
	{
		global $DB;

		$cleanId = (int)$jid;

		if (!empty($cleanId))
		{
		 $rows=$DB->select(
			"SELECT * FROM
					(SELECT a.page_id,a.page_name,a.page_name_en,a.year,c.cv_text,a.journal,pc.cv_text AS page_summary,
					p.page_id AS pid,substring(a.j_name,9,(length(j_name)-9)),m.logo,pcy.page_id AS years_id 
					      FROM adm_article AS a
					      INNER JOIN adm_article_content AS c ON c.page_id=a.page_id

					      LEFT OUTER JOIN adm_pages AS p ON p.page_template='magazine' 
						  AND p.page_name=IF(substring(j_name,1,7)='������ ',substring(a.j_name,9,(length(j_name)-9)),
						  a.j_name)
					      LEFT OUTER JOIN adm_pages_content AS pc ON pc.page_id=p.page_id AND pc.cv_name='SUMMARY_ID'
						  LEFT OUTER JOIN adm_pages_content AS pcy ON pcy.page_id=p.page_id AND pcy.cv_name='YEARS_ID'
						  INNER JOIN adm_magazine AS m ON m.page_id=".$cleanId.
					     " WHERE a.journal=".$cleanId." AND  a.page_status=1 AND c.cv_name='date_public') AS tt
			 ORDER BY cv_text DESC LIMIT 1"

		);

		return $rows;
		}
	}
	// ��� ������� ������
	function getLastMagazineNumberRub($jid,$number,$year)
	{
		global $DB;

        $cleanId = (int)$jid;

		if (!empty($cleanId))
		{
		 if (empty($year)) $year=date("Y");
		 if (empty($number)) $number=1;
		 if ($cleanId!='137') $numwhere=" AND  number='".$number."'"; else $numwhere="";
		 $rows=$DB->select(
			"SELECT page_id,name,page_name,name_en  FROM adm_article WHERE journal=".$cleanId." AND year=".$year.
			$numwhere.
	//	"	AND  number='".$number."'".
			" AND page_template='jrubric' AND page_status=1 ORDER BY page_id");
		}
	
		
		return $rows;
		
	}
	// ��� ������ �������
	function getMagazineAll($jid)
	{
		global $DB;

        $cleanId = (int)$jid;

		if (!empty($_REQUEST[page_id]))
		{

		If (empty($cleanId))
		{
				$jid0=$this->getMagazineJId($_REQUEST[page_id]);
            $cleanId=(int)$jid0[0][journal];
		}
//		If (empty($jid)) $jid0=this->getMagazineJId($_REQUEST[page_id]);

		return $DB->select(
			"SELECT * FROM
					(SELECT a.page_id,a.page_name,a.year,c.cv_text,a.journal,a.page_status
					      FROM adm_article AS a, adm_article_content AS c
					      WHERE  a.journal=".$cleanId." AND a.page_id=c.page_id AND c.cv_name='date_public'
					      AND a.page_template='jnumber'
					      ) AS t
			 ORDER BY cv_text DESC "

		);
		}
		
		 else
        {
//		  return $a[0][page_name]='text';
		  return $DB->select(
			"SELECT * FROM
					(SELECT a.page_id,a.page_name,a.year,c.cv_text,a.journal,a.page_status
					      FROM adm_article AS a, adm_article_content AS c
					      WHERE   a.page_id=c.page_id AND c.cv_name='date_public'
					      AND a.page_template='jnumber'
					      ) AS t
			 ORDER BY journal,cv_text DESC ");
		  
		}  
	}

	// ��� �������������� ������ ������� � ���� ������
	function getMagazineAllPublic($jid)
	{

        $cleanId = (int)$jid;

		if (!empty($_REQUEST[page_id])|| !empty($_REQUEST[id]))
		{
		if (empty($_REQUEST[page_id])) $_REQUEST[page_id]=$_REQUEST[id];
		global $DB;
        if (!empty($_SESSION[jour_id])) $cleanId=$_SESSION[jour_id];
		If (empty($cleanId))
		{
				$jid0=$this->getMagazineJId($_REQUEST[page_id]);
            $cleanId=(int)$jid0[0][journal];
		}
	    	
		return $DB->select(
			"SELECT * FROM
					(SELECT a.page_id,a.page_name,a.page_name_en,a.year,a.page_id AS jid,c.cv_text AS date_public,c2.cv_text AS subject,a.journal,
					a.page_status,mz.page_name AS jour_name,mz.numbers
					      FROM adm_article AS a
					      INNER JOIN adm_article_content AS c ON c.page_id=a.page_id AND c.cv_name='date_public'
					      INNER JOIN adm_article_content AS c2 ON c2.page_id=a.page_id AND c2.cv_name='subject'
					      INNER JOIN adm_magazine AS mz ON mz.page_id = a.journal
					      WHERE   a.journal=".$cleanId." AND c.cv_text<>''
					      AND a.page_template='jnumber'
					      ) AS t
			 ORDER BY  date_public DESC "

		);

		}
	}
	// English ��� �������������� ������ ������� � ���� ������
	function getMagazineAllPublicEn($jid)
	{

        $cleanId = (int)$jid;

		if (!empty($_REQUEST[page_id])|| !empty($_REQUEST[id]))
		{
		if (empty($_REQUEST[page_id])) $_REQUEST[page_id]=$_REQUEST[id];
		global $DB;

		If (empty($cleanId))
		{
				$jid0=$this->getMagazineJId($_REQUEST[page_id]);
            $cleanId=(int)$jid0[0][journal];
		}

		return $DB->select(
			"SELECT * FROM
					(SELECT a.page_id,a.page_name,a.page_name_en,a.year,a.page_id AS jid,c.cv_text AS date_public,
					c2.cv_text AS subject,c3.cv_text AS subject_en,a.journal,
					a.page_status,mz.page_name AS jour_name,mz.numbers
					      FROM adm_article AS a
					      INNER JOIN adm_article_content AS c ON c.page_id=a.page_id AND c.cv_name='date_public'
					      INNER JOIN adm_article_content AS c2 ON c2.page_id=a.page_id AND c2.cv_name='subject'
						  LEFT OUTER JOIN adm_article_content AS c3 ON c3.page_id=a.page_id AND c3.cv_name='subject_en'
					      INNER JOIN adm_magazine AS mz ON mz.page_id = a.journal
					      WHERE   a.journal=".$cleanId." AND c.cv_text<>''
					      AND a.page_template='jnumber'
					      ) AS t
			 ORDER BY date_public DESC "

		);

		}
	}
 // ��������� ������ �� ������
	function getArticleByRandom($pid,$page_status = 1, $page_link = null, $page_type = null)
	{
		global $DB;
		$rows= $DB->select(
			"SELECT ".
				"?_article.page_id AS ARRAY_KEY, ".
				"?_article.name,?_article.people ".
			"FROM ?_article ".
			"WHERE   ".
				"page_parent = ?d ".
				"{AND page_status  = ?d} ".

			"ORDER BY  ".
				"page_position ASC, ".
				"page_name ASC",

			$pid,
			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status)

		);

//		print_r($rows);
        return $rows;
	}
    // ������� �������� �� ID
	function getPageByIdOfficial($id, $page_status = null, $page_type = null)
	{
		global $DB;
		return $DB->selectRow(
			"SELECT * ".
			"FROM ?_magazine ".
			"WHERE ".
				"page_id = ?d ".
				"{AND page_status  = ?d} ".
				"{AND page_type    = ?d} ",

			$id,
			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status),
			(is_null($page_type)   ? DBSIMPLE_SKIP: $page_type)
		);
	}
	// ������� ID ���� �������� ��-��� ������� �� ������������� ID (� ��� ���������)
	function getChilds($pid, $page_status = null, $page_link = null, $page_dell = null, $page_type = null)
	{
		global $DB;
		return $DB->select(
			"SELECT ".
				"?_magazine.page_id AS ARRAY_KEY, ".
				"?_magazine.* ".
			"FROM ?_magazine ".
			"WHERE ".
				"page_parent = ?d ".
				"{AND page_status  = ?d} ".
				"{AND page_link    = ?d} ".
				"{AND page_dell    = ?d} ".
				"{AND page_type    = ?d} ".
			"ORDER BY ".
				"page_position ASC, ".
				"page_name ASC",

			$pid,
			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status),
			(is_null($page_link)   ? DBSIMPLE_SKIP: $page_link),
			(is_null($page_dell)   ? DBSIMPLE_SKIP: $page_dell),
			(is_null($page_type)   ? DBSIMPLE_SKIP: $page_type)
		);
	}
	// English ������� ID ���� �������� ��-��� ������� �� ������������� ID (� ��� ���������)
	function getChildsEn($pid, $page_status = null, $page_link = null, $page_dell = null, $page_type = null)
	{
		global $DB;
		return $DB->select(
			"SELECT ".
				"?_magazine.page_id AS ARRAY_KEY, ".
				"?_magazine.* ".
			"FROM ?_magazine ".
			"WHERE ".
				" page_name_en <> '' AND page_parent = ?d ".
				"{AND page_status  = ?d} ".
				"{AND page_link    = ?d} ".
				"{AND page_dell    = ?d} ".
				"{AND page_type    = ?d} ".
			"ORDER BY ".
				"page_position ASC, ".
				"page_name_en ASC",

			$pid,
			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status),
			(is_null($page_link)   ? DBSIMPLE_SKIP: $page_link),
			(is_null($page_dell)   ? DBSIMPLE_SKIP: $page_dell),
			(is_null($page_type)   ? DBSIMPLE_SKIP: $page_type)
		);
	}
	// ������� ID ���� �������� ��-��� ������� �� ������������� ID (� ��� ���������)
	function getChildsArticle($pid, $page_status = null, $page_link = null, $page_dell = null, $page_type = null)
	{

		global $DB;
		$rows= $DB->select(
			"SELECT ".
				"?_article.page_id AS ARRAY_KEY, ".
				"?_article.* ".
			"FROM ?_article ".
			"WHERE   ".
				"page_parent = ?d ".
				"{AND page_status  = ?d} ".

			"ORDER BY ".
				"page_position ASC, ".
				"page_name ASC",

			$pid,
			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status)

		);
        return $rows;
	}
	// English ������� ID ���� �������� ��-��� ������� �� ������������� ID (� ��� ���������)
	function getChildsArticleEn($pid, $page_status = null, $page_link = null, $page_dell = null, $page_type = null)
	{

		global $DB;
		$rows= $DB->select(
			"SELECT ".
				"?_article.page_id AS ARRAY_KEY, ".
				"?_article.* ".
			"FROM ?_article ".
			"WHERE   ".
				" page_name_en <> '' AND page_parent = ?d ".
				"{AND page_status  = ?d} ".

			"ORDER BY ".
				"page_position ASC, ".
				"page_name_en ASC",

			$pid,
			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status)

		);
        return $rows;
	}
	// ������� ID ���� �������� ��-��� ������� �� ������������� ID � ������ ����������� ������
	function getChildsArticleAll($pid, $page_status = null, $page_link = null, $page_dell = null, $page_type = null)
	{

		global $DB;
		$rows= $DB->select(
			"SELECT ".
				"?_article.page_id AS ARRAY_KEY, ".
				"?_article.* ".
			"FROM ?_article ".
			"WHERE   ".
				"page_parent = ?d ".
				"{AND page_status  = ?d} ".

			"ORDER BY ".
				"page_position ASC, ".
				"page_name ASC",

			$pid,
			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status)

		);
        return $rows;
	}
	// English ������� ID ���� �������� ��-��� ������� �� ������������� ID � ������ ����������� ������
	function getChildsArticleAllEn($pid, $page_status = null, $page_link = null, $page_dell = null, $page_type = null)
	{

		global $DB;
		$rows= $DB->select(
			"SELECT ".
				"?_article.page_id AS ARRAY_KEY, ".
				"?_article.* ".
			"FROM ?_article ".
			"WHERE   ".
				" page_name_en <> '' AND page_parent = ?d ".
				"{AND page_status  = ?d} ".

			"ORDER BY ".
				"page_position ASC, ".
				"page_name_en ASC",

			$pid,
			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status)

		);
        return $rows;
	}
	
	// ������� ID ���� �������� ��-��� ������� �� ������������� ID � ������ ����������� ������ ���������� �� ��������
	function getChildsArticleAllAlf($pid, $page_status = null, $page_link = null, $page_dell = null, $page_type = null)
	{

		global $DB;
		$rows= $DB->select(
			"SELECT ".
				"?_article.page_id AS ARRAY_KEY, ".
				"?_article.* ".
			"FROM ?_article ".
			"WHERE   ".
				"page_parent = ?d ".
				"{AND page_status  = ?d} ".

			"ORDER BY  ".
//				"page_position ASC, ".
				"name ASC",
			$pid,
			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status)

		);

        return $rows;
	}
	// English ������� ID ���� �������� ��-��� ������� �� ������������� ID � ������ ����������� ������ ���������� �� ��������
	function getChildsArticleAllAlfEn($pid, $page_status = null, $page_link = null, $page_dell = null, $page_type = null)
	{

		global $DB;
		$rows= $DB->select(
			"SELECT ".
				"?_article.page_id AS ARRAY_KEY, ".
				"?_article.* ".
			"FROM ?_article ".
			"WHERE   ".
				"page_name_en<>'' AND page_parent = ?d ".
				"{AND page_status  = ?d} ".

			"ORDER BY  ".
//				"page_position ASC, ".
				"name_en ASC",
			$pid,
			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status)

		);

        return $rows;
	}
		// ������� ID ���� �������� ��-��� ������� �� ������������� ID (� ��� ���������) c ������������ �����
	function getChildsOfficial($pid, $page_status = null, $page_link = null, $page_dell = null, $page_type = null)
	{
		global $DB;
		return $DB->select(
			"SELECT ".
				"?_magazine.page_id AS ARRAY_KEY, ".
				"?_magazine.* ".
			"FROM ?_magazine ".
			"WHERE ".
				"page_parent = ?d ".
				"{AND page_status  = ?d} ".
				"{AND page_link    = ?d} ".
				"{AND page_dell    = ?d} ".
				"{AND page_type    = ?d} ".
			"ORDER BY ".
				"page_position ASC, ".
				"page_name ASC",

			$pid,
			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status),
			(is_null($page_link)   ? DBSIMPLE_SKIP: $page_link),
			(is_null($page_dell)   ? DBSIMPLE_SKIP: $page_dell),
			(is_null($page_type)   ? DBSIMPLE_SKIP: $page_type)
		);
	}
    // ������� ID ���� �������� ��-��� ������� �� ������������� ID (� ��� ���������) �� ������ ���������
	function getChildsCMS($pid, $page_status = null, $page_link = null, $page_dell = null, $page_type = null)
	{
		global $DB;
		return $DB->select(
			"SELECT ".
				"?_magazine.page_id AS ARRAY_KEY, ".
				"?_magazine.* ".
			"FROM ?_magazine ".
			"WHERE ".
				"page_parent = ?d ".
				"{AND page_status  = ?d} ".
				"{AND page_link    = ?d} ".
				"{AND page_dell    = ?d} ".
				"{AND page_type    = ?d} ".
				" AND page_old=1 ".
			"ORDER BY ".
				"page_position ASC, ".
				"page_name ASC",

			$pid,
			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status),
			(is_null($page_link)   ? DBSIMPLE_SKIP: $page_link),
			(is_null($page_dell)   ? DBSIMPLE_SKIP: $page_dell),
			(is_null($page_type)   ? DBSIMPLE_SKIP: $page_type)
		);
	}
	// ������� ����� ��-���
	function getBranch($id, $page_status = null, $page_link = null, $page_type = null)
	{
		global $DB;
		$rows = $this->getPages($page_status, $page_link, $page_type);

		$retVal = array();
		$this->unpackChildsRecursive($rows, $retVal, $id);

		return $retVal;
	}
	// �������� �������
    function getAutors($spisok)
    {
        global $DB;
        $str0=explode('<br>',trim($spisok));
        //       print_r($str0);
        $where='';
//		$fiosp=new Array();
        $i=0;
        foreach($str0 as $str)
        {
//			echo "<br />*".$str."*";
            if (!empty($str) && is_numeric($str))
                $where.="id=".$str." OR ";
            $fiosp[$str]['sort']=$i;
            $i++;

        }

        $where=substr($where,0,-4);

        if (!empty($where))
            $ff= $DB->select("SELECT p.id,CONCAT(p.surname,' ',substring(p.name,1,1),'. ',IF(p.fname<>'',CONCAT(substring(p.fname,1,1),'.'),'')) AS fio, CONCAT(p.surname,' ',substring(p.name,1,1),'.') AS fioshort_side,CONCAT(substring(p.name,1,1),'. ',p.surname) AS fioshort,CONCAT(p.name,' ',p.surname) AS name_surname,d.icont_text AS grade,chl.icont_text AS ran,p.picsmall AS picsmall,ForSite AS work,mail1,
      				if(o.page_status=1,o.page_name,'')  AS otdel, p.full_name_echo, CONCAT(p.surname,' ',p.name,IF(p.fname<>'',CONCAT(' ',p.fname),'')) AS fio_full_meta
			        FROM persons AS p
			        LEFT JOIN adm_pages AS o ON o.page_id = p.otdel
			        LEFT JOIN adm_directories_content AS d ON d.el_id = p.us AND d.icont_var='text'
			        LEFT JOIN adm_directories_content AS chl ON chl.el_id = p.ran AND chl.icont_var='text'
			        WHERE ".$where);

        foreach($ff as $f)
        {
            $fiosp[$f[id]][id]=$f[id];
            $fiosp[$f[id]][fio]=$f[fio];
            $fiosp[$f[id]][fioshort_side]=$f[fioshort_side];
            $fiosp[$f[id]][fioshort]=$f[fioshort];
            $fiosp[$f[id]][work]=$f[work];
            $fiosp[$f[id]][mail1]=$f[mail1];
            $fiosp[$f[id]][otdel]=$f[otdel];
            $fiosp[$f[id]][grade]=$f[grade];
            $fiosp[$f[id]][ran]=$f[ran];
            $fiosp[$f[id]][name_surname]=$f[name_surname];
            $fiosp[$f[id]][picsmall]=$f[picsmall];
            $fiosp[$f[id]][full_name_echo]=$f[full_name_echo];
            $fiosp[$f[id]][fio_full_meta]=$f[fio_full_meta];

        }

//       print_r($fiosp);
        return $fiosp;
    }
		// English �������� �������
	function getAutorsEn($spisok)
	{
		global $DB;
		$str0=explode('<br>',trim($spisok));
 //       print_r($str0);
		$where='';
//		$fiosp=new Array();
		$i=0;
		foreach($str0 as $str)
		{
//			echo "<br />*".$str."*";
			if (!empty($str) && is_numeric($str))
			   $where.="id=".$str." OR ";
			$fiosp[$str]['sort']=$i;
			$i++;

		}

		$where=substr($where,0,-4);

    if (!empty($where))
      		$ff= $DB->select("SELECT p.id,Autor_en AS fio,Autor_en AS fioshort,ForSite_en AS work,mail1,
      				if(o.page_status=1,o.page_name,'')  AS otdel, p.name AS rusname, p.LastName_EN AS enlastname, p.Name_EN AS enfirstname, CONCAT(p.Name_EN,' ',p.LastName_EN) AS name_surname,d.icont_text AS grade,chl.icont_text AS ran,p.picsmall AS picsmall, p.full_name_echo
			        FROM persons AS p
			        LEFT JOIN adm_pages AS o ON o.page_id = p.otdel
			        LEFT JOIN adm_directories_content AS d ON d.el_id = p.us AND d.icont_var='text_en'
			        LEFT JOIN adm_directories_content AS chl ON chl.el_id = p.ran AND chl.icont_var='text_en'
			        WHERE ".$where);

       foreach($ff as $f)
        {
            $fiosp[$f[id]][id]=$f[id];
            $fiosp[$f[id]][fio]=$f[fio];
			$fiosp[$f[id]][rusname]=$f[rusname];
			$fiosp[$f[id]][enlastname]=$f[enlastname];
            $fiosp[$f[id]][enfirstname]=$f[enfirstname];
			$fiosp[$f[id]][fioshort]=$f[fioshort];
            $fiosp[$f[id]][work]=$f[work];
            $fiosp[$f[id]][mail1]=$f[mail1];
			$fiosp[$f[id]][otdel]=$f[otdel];
            $fiosp[$f[id]][grade]=$f[grade];
            $fiosp[$f[id]][ran]=$f[ran];
            $fiosp[$f[id]][name_surname]=$f[name_surname];
            $fiosp[$f[id]][picsmall]=$f[picsmall];
            $fiosp[$f[id]][full_name_echo]=$f[full_name_echo];
        }

//       print_r($fiosp);
       return $fiosp;
	}
	// �������� ���� ������� ������� 2
    function getAuthorsAll2($jid,$alf='�')
	{
		global $DB;

        $cleanId = (int)$jid;

		if(strlen($alf)>2) {
		    $alf = substr($alf,0,2);
        }
		
	   if ($alf<>'z') $where = "SUBSTRING(surname,1,1)='".$alf."'";
		else $where ="(SUBSTRING(surname,1,1)>='�' AND SUBSTRING(surname,1,1)<='�')";
		
		$rows=$DB->select("SELECT a.* FROM adm_article AS a ".
//		                   INNER JOIN adm_article_content AS c ON c.page_id=a.page_id AND cv_name='date_public' AND cv_text<>''
//						   WHERE page_template='jarticle' AND journal=".$jid." ");
                          " WHERE page_template='jarticle' AND date_public<>'' AND journal=".$cleanId." ORDER BY date_public DESC");

						  $avtor=Array();
	    $rowsa=$DB->select("SELECT id,CONCAT(surname,' ',SUBSTRING(name,1,1),'. ',SUBSTRING(fname,1,1),'.') AS fio,Autor_en FROM persons 
		WHERE ".$where.
		" ORDER BY surname,name,fname");
		
	foreach($rowsa as $ra)
	{
	   $avtname[$ra[id]]=$ra[fio];
	   
	}
	foreach($rows as $row)
		{
        	
	
					$aa=explode("<br>",trim($row[people]));
				     foreach($aa as $avt)
				     {
				        if (!empty($avt) && !empty($avtname[$avt]))
				        {
                            $fio=$avtname[$avt];
						                            	
							$avtor[$fio][j].=$row[number]."-".$row[year]." | ";	
                            $avtor[$fio][id].=$row[page_id]." | ";	
							$avtor[$fio][avtor_id]=$avt;
							
				         }
				     }
	  	}

ksort($avtor);

        return $avtor;

	}	
// �������� ���� ������� n ������� 2
    function getAuthorsAll2En($jid,$alf='A')
	{
		global $DB;

        $cleanId = (int)$jid;

        if(strlen($alf)>2) {
            $alf = substr($alf,0,2);
        }
		
	    if ($alf<>'z') $where = "SUBSTRING(Autor_en,1,1)='".$alf."'";
		else $where ="(SUBSTRING(Autor_en,1,1)>='A' AND SUBSTRING(surname,1,1)<='Z')";
		
		$rows=$DB->select("SELECT a.* FROM adm_article AS a ".
//		                   INNER JOIN adm_article_content AS c ON c.page_id=a.page_id AND cv_name='date_public' AND cv_text<>''
//                           WHERE page_template='jarticle' AND journal=".$jid." ");
						    " WHERE page_template='jarticle' AND date_public<>'' AND journal=".$cleanId." ORDER BY date_public DESC");
		$avtor=Array();
	    $rowsa=$DB->select("SELECT id,Autor_en AS fio,Autor_en FROM persons WHERE ".$where.
		" ORDER BY Autor_en");
	
	foreach($rowsa as $ra)
	{
	   $avtname[$ra[id]]=$ra[fio];
	   
	}
	
	foreach($rows as $row)
		{
        	
	
					$aa=explode("<br>",trim($row[people]));
				    
				     foreach($aa as $avt)
				     {
				        if (!empty($avt) && !empty($avtname[$avt]))
				        {
                            $fio=$avtname[$avt];
						    if($_SESSION[lang]=='/en' && !empty($row[number_en]))
						    	$row[number]=$row[number_en];
							$avtor[$fio][j].=$row[number]."-".$row[year]." | ";	
                            $avtor[$fio][id].=$row[page_id]." | ";	
							$avtor[$fio][avtor_id]=$avt;
							
				         }
				     }
	  	}

ksort($avtor);

        return $avtor;

	}	
		// �������� ������� Zotero
	function getAutorsBib($spisok)
	{
		global $DB;
		$str0=explode('<br>',trim($spisok));
 //       print_r($str0);
		$where='';
//		$fiosp=new Array();
		$i=0;
		foreach($str0 as $str)
		{
//			echo "<br />*".$str."*";
			if (!empty($str) && is_numeric($str))
			   $where.="id=".$str." OR ";
			$fiosp[$str]['sort']=$i;
			$i++;

		}

		$where=substr($where,0,-4);
    if (!empty($where))
      		$ff= $DB->select("SELECT p.id,CONCAT(p.surname,', ',p.name,' ',p.fname) AS fio,ForSite AS work,mail1,
      				if(o.page_status=1,o.page_name,'')  AS otdel
			        FROM persons AS p
			        LEFT JOIN adm_pages AS o ON o.page_id = p.otdel
			        WHERE ".$where);
       $retbib="";
       foreach($ff as $f)
        {

			$retbib.=$f[fio]." and ";
        }
       $retbib=substr($retbib,0,-4);

       return $retbib;
	}
	// English �������� ������� Zotero
	function getAutorsBibEn($spisok)
	{
		global $DB;
		$str0=explode('<br>',trim($spisok));
 //       print_r($str0);
		$where='';
//		$fiosp=new Array();
		$i=0;
		foreach($str0 as $str)
		{
//			echo "<br />*".$str."*";
			if (!empty($str) && is_numeric($str))
			   $where.="id=".$str." OR ";
			$fiosp[$str]['sort']=$i;
			$i++;

		}

		$where=substr($where,0,-4);
    if (!empty($where))
      		$ff= $DB->select("SELECT p.id,Autor_en AS fio,ForSite_en AS work,mail1,
      				if(o.page_status=1,o.page_name,'')  AS otdel
			        FROM persons AS p
			        LEFT JOIN adm_pages AS o ON o.page_id = p.otdel
			        WHERE ".$where);
       $retbib="";
       foreach($ff as $f)
        {

			$retbib.=$f[fio]." and ";
        }
       $retbib=substr($retbib,0,-4);

       return $retbib;
	}
// �������� ���� �������
    function getAuthorsAll($jid)
	{
		global $DB;

        $cleanId = (int)$jid;

		$rows=$DB->select("SELECT a.page_id FROM adm_article AS a
		                   INNER JOIN adm_article_content AS c ON c.page_id=a.page_id AND cv_name='date_public' AND cv_text<>''
                           WHERE page_template='jnumber' AND journal=".$cleanId." ORDER BY cv_text DESC");
		$avtor=Array();
	
	foreach($rows as $row0)
		{
        	$rowas=$this->getMagazineNumber($row0[page_id]);
        	$jn=$row0[page_id];

        	if (!empty($rowas))
			{
			  	$rows=$this->appendContentArticle($rowas);
				//������� �������

				  foreach($rowas as $k=>$row)
				  {
				
				  if ($row[page_template]=='jarticle')
				  {
				  	 $aa=explode("<br>",trim($row[people]));
				     foreach($aa as $avt)
				     {
				        if (!empty($avt))
				        {
				           $avtor[$avt][$jn].="*".$row[page_id];
				         }
				     }
				  }
                  }

  		    }
  		}


        return $avtor;

	}
	
// ������� ����� �������
	function getMagazineNumber($jid, $page_status = null, $page_link = null, $page_type = null)
	{
		global $DB;
//		$id0=$DB->select("SELECT cv_text AS page_id FROM ?_pages_content WHERE cv_name='number' AND page_id=".$jid);
//echo "<br />___".$jid;
		$id=(int)$jid; //$id0[0][page_id];
//		$rows = $this->getPagesArticle($page_status, $page_link, $page_type);
        $rows = $this->getPagesArticle("1", $page_link, $page_type,$id);
		
	
		$retVal = array();


		$this->unpackChildsRecursive($rows, $retVal, $id);

        return $retVal;

	}
	// Englisb ������� ����� �������
	function getMagazineNumberEn($jid, $page_status = null, $page_link = null, $page_type = null)
	{
		global $DB;
//		$id0=$DB->select("SELECT cv_text AS page_id FROM ?_pages_content WHERE cv_name='number' AND page_id=".$jid);

		$id=(int)$jid; //$id0[0][page_id];
//		$rows = $this->getPagesArticle($page_status, $page_link, $page_type);
        $rows = $this->getPagesArticle("1", $page_link, $page_type);

		$retVal = array();
		$this->unpackChildsRecursive($rows, $retVal, $id);

	   return $retVal;

	}

	// ������� ������� �������
	function getMagazineRubric($jid, $page_status = null, $page_link = null, $page_type = null)
	{
		global $DB;
        $cleanId = (int)$jid;
		if (!empty($cleanId))
		{
		$id0=$DB->select("SELECT page_parent,page_template FROM ?_article WHERE  page_id=".$cleanId. " AND page_status=1");
		if (!empty($id0[0][page_parent]))
		{
		while($id0[0][page_template]!='jnumber' && !empty($id0[0][page_template]))
		{

		    $id0=$DB->select("SELECT page_id,page_parent,page_template FROM ?_article WHERE  page_id=".$id0[0][page_parent]." AND page_status=1");
         }

		$id=$id0[0][page_id];

        $page_status=1;
		$rows = $this->getPagesRubric($page_status, $page_link, $page_type);

		$retVal = array();
		$this->unpackChildsRecursive($rows, $retVal, $id);
        return $retVal;
        } }
	}
	// English ������� ������� �������
	function getMagazineRubricEn($jid, $page_status = null, $page_link = null, $page_type = null)
	{
		global $DB;
        $cleanId = (int)$jid;
		if (!empty($cleanId))
		{
		$id0=$DB->select("SELECT page_parent,page_template FROM ?_article WHERE  page_id=".$cleanId. " AND page_status=1");
		if (!empty($id0[0][page_parent]))
		{
		while($id0[0][page_template]!='jnumber' && !empty($id0[0][page_template]))
		{

		    $id0=$DB->select("SELECT page_id,page_parent,page_template FROM ?_article WHERE  page_id=".$id0[0][page_parent]." AND page_status=1");
         }

		$id=$id0[0][page_id];

        $page_status=1;
		$rows = $this->getPagesRubricEn($page_status, $page_link, $page_type);

		$retVal = array();
		$this->unpackChildsRecursive($rows, $retVal, $id);
        return $retVal;
        } }
	}
	// �������� ������ �� id �������
	function getArticlePageId($jid)
	{
	   global $DB;
        $cleanId = (int)$jid;
	   $rows=$DB->select("SELECT p.page_id FROM adm_pages AS p
	                      INNER JOIN adm_pages_content AS pc ON pc.page_id=p.page_id AND cv_name='itype_jour' AND cv_text=".$cleanId.
						" WHERE p.page_template='magazine_article'"
						  );
	   return $rows;					  
	}
	// ����� (id) �������� �� id ������
	function getMagazineByArticleId($jid, $page_status = null, $page_link = null, $page_type = null)
	{

		global $DB;
		$cleanId = (int)$jid;
		if (!empty($cleanId))
		{
		    $lang_post_fix = "";
		    if($_SESSION[lang]=="/en") {
		        $lang_post_fix = "_en";
            }
		$id0=$DB->select("SELECT page_parent,page_template FROM ?_article WHERE  page_id=".$cleanId." AND page_status".$lang_post_fix."=1");


		if (!empty($id0[0][page_parent]))
		{
		while($id0[0][page_template]!='jnumber' && !empty($id0[0][page_parent]))
		{
           if (!empty($_SESSION[jour_id]))
		    $id0=$DB->select("SELECT page_id,page_name,page_parent,name_en,page_template FROM ?_article WHERE  page_id=".$id0[0][page_parent]." AND journal=".$_SESSION[jour_id]);
		   else
		    $id0=$DB->select("SELECT page_id,page_name,page_parent,name_en,page_template FROM ?_article WHERE  page_id=".$id0[0][page_parent]);
		   
         }
//print_r($id0);
		$id=$id0[0][page_id];
        }
        else
        $id=$cleanId;
	  }

	 if (!empty($id))
	 {
       if ($_SESSION[lang]!='/en')	   
	   $retVal=$DB->select("SELECT a.*,a.page_name AS number,a.year AS yyear,d.page_name AS jname,d.issn,d.publisher_en AS publisher,d.page_urlname AS page_journame,d.*,'".$id0[0][page_name]."' AS number_art ".
	       " FROM ?_article AS a
	        INNER JOIN ?_magazine AS d ON d.page_id=a.journal
	        WHERE  a.page_id=".$id);
			
		else	
		$retVal=$DB->select("SELECT a.*,a.page_name AS number,a.page_name_en AS number_en,a.year AS yyear,d.page_name_en AS jname,d.issn,d.publisher,d.page_urlname AS page_journame,d.*,'".$id0[0][page_name]."' AS number_art ".
	       " FROM ?_article AS a
	        INNER JOIN ?_magazine AS d ON d.page_id=a.journal
	        WHERE  a.page_id=".$id);
      }
//	 echo "@@@";print_r($retVal);
	 return $retVal;
	}
	// �������� ��� ����� ������ ��� �������
    function getAuthorsArticleById($author_id,$jid)
	{
		global $DB;

		$cleanId = (int)$jid;
		
		if (!empty($cleanId))
		$rows=$DB->select("SELECT DISTINCT a.page_id FROM adm_article AS a

                           WHERE  page_template='jarticle' AND date_public<>''
                           AND
                           a.journal=".$cleanId.
                           " AND
                           (people LIKE '".$author_id."<br>%' OR
                           people LIKE '%<br>".$author_id."<br>%' OR
                           people LIKE '%<br>".$author_id."')
                           ORDER BY date_public DESC");


        return $rows;

	}
	// �������� ��� ����� ������ ��� ���� ��������
    function getAuthorsArticleByIdAll($author_id)
	{
		global $DB;
		
	//	if (!empty($jid))
		$rows=$DB->select("SELECT DISTINCT a.page_id FROM adm_article AS a

                           WHERE  page_template='jarticle' AND date_public<>'' ".
                                                      " AND
                           (people LIKE '".$author_id."<br>%' OR
                           people LIKE '%<br>".$author_id."<br>%' OR
                           people LIKE '%<br>".$author_id."')
                           ORDER BY date_public DESC");


        return $rows;

	}
	// �������� ������� �� id ������
	function getRubricByArticleId($jid, $page_status = null, $page_link = null, $page_type = null)
	{
		global $DB;

		$cleanId = (int)$jid;

		if (!empty($cleanId))
		{
		$id0=$DB->select("SELECT page_parent,page_template FROM ?_article WHERE  page_id=".$cleanId);
		if (!empty($id0[0][page_parent]))
		{
		while($id0[0][page_template]!='jrubric' && !empty($id0[0][page_parent]))
		{

		    $id0=$DB->select("SELECT page_id,page_parent,page_template FROM ?_article WHERE  page_id=".$id0[0][page_parent]);
         }

		$id=$id0[0][page_id];

	 } }
	 if (!empty($id))
	    $retVal=$DB->select("SELECT a.*,c.cv_text AS rubric FROM ?_article AS a,?_article_content AS c
	    WHERE a.page_id=".$id." AND a.page_id=c.page_id AND c.cv_name='rubric'"
	    );

	 return $retVal;
	}
   // ������� ��� ������� � �������
	function getRubricAll($jid,$page_status = null, $page_link = null, $page_type = null,$year=null)
	{
		global $DB;

        $cleanId = (int)$jid;

		if (empty($year)) $whereyear=""; else $whereyear=" AND year='".(int)$year."'";
		if ($year=="*") $whereyear=" AND year>".(date("Y")-11);
  if (!empty($cleanId))
  {
		$rows =  $DB->select(
			"SELECT ".
				"?_article.page_id AS ARRAY_KEY, ".
//				" IF (?_article.page_parent=jid,0,page_parent) AS rtype,".
				"?_article.* ".
			"FROM ?_article ".

//			" INNER JOIN ?_article_content AS c ON c.page_id=?_article.page_id AND cv_name='date_public'".
			"WHERE  ".
				"page_template = 'jrubric' ".
				" AND page_parent=jid ".$whereyear.
				" AND journal =".$cleanId.
				" {AND page_status  = ?d} ".


			"ORDER BY  ".
			     "IF (substring(page_name,1,11)='���� ������',
				 CONCAT('9',date_public),0) DESC,".
//                "rtype,page_parent,".
				"page_name ASC, date_public DESC ",
//				"c.icont_text DESC",

			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status)
		);

//		$rows[0] = array();
//		$rows[0][$this->childNodesName] = array();
//		foreach($rows as $k => $v)
//			$rows[(int)@$v["page_parent"]][$this->childNodesName][] = $k;
		return $rows;
		}
	}
	
	// ������� ��� ������� � ������� (EN)
	function getRubricAllEn($jid,$page_status = null, $page_link = null, $page_type = null,$year=null)
	{
		global $DB;

        $cleanId = (int)$jid;

		if (empty($year)) $whereyear=""; else $whereyear=" AND year='".(int)$year."'";
		if ($year=="*") $whereyear=" AND year>".(date("Y")-11);
  if (!empty($cleanId))
  {
		$rows =  $DB->select(
			"SELECT ".
				"?_article.page_id AS ARRAY_KEY, ".
				"?_article.* ".
			"FROM ?_article ".
			"WHERE  ".
				"page_template = 'jrubric' ".
				" AND page_parent=jid ".$whereyear.
				" AND journal =".$cleanId.
				" {AND page_status  = ?d} ".


			"ORDER BY  ".
			     "IF (substring(page_name,1,11)='���� ������',
				 CONCAT('9',date_public),0) DESC,".
				"name_en ASC, date_public DESC ",

			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status)
		);

//		$rows[0] = array();
//		$rows[0][$this->childNodesName] = array();
//		foreach($rows as $k => $v)
//			$rows[(int)@$v["page_parent"]][$this->childNodesName][] = $k;

		return $rows;
		}
	}
	
	// ������� ��� ������� � �������  (�� ��������)
	function getPagesRubric($page_status = null, $page_link = null, $page_type = null)
	{
		global $DB;

		$rows =  $DB->select(
			"SELECT ".
				"?_article.page_id AS ARRAY_KEY, ".
				"?_article.* ".
			"FROM ?_article ".
			"WHERE ".
				"page_template = 'jrubric' ".
				"{AND page_status  = ?d} ".

			"ORDER BY  ".
				"page_position ASC, ".
				"page_name ASC",

			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status)
		);

		$rows[0] = array();
		$rows[0][$this->childNodesName] = array();
		foreach($rows as $k => $v)
			$rows[(int)@$v["page_parent"]][$this->childNodesName][] = $k;

		return $rows;
	}
	// ����������� �-���. ��������� ������ ��������� �����
	function unpackChildsRecursive(&$data, &$retVal, $start = 0)
	{
		if(!empty($start))
			$retVal[$start] = $data[$start];

		if(!isset($data[$start][$this->childNodesName]))
			return;

		foreach($data[$start][$this->childNodesName] as $v)
			$this->unpackChildsRecursive($data, $retVal, $v);
	}


	// ������������ � ������� ������� �������
	function appendContent($pages)
	{
		global $DB;
		$rows = $DB->select("SELECT * FROM ?_magazine_content WHERE  page_id IN (?a)", array_keys($pages));

		foreach($pages as $v)
			$pages[$v["page_id"]]["content"] = array();

		foreach($rows as $v)
			$pages[$v["page_id"]]["content"][$v["cv_name"]] = $v["cv_text"];

		return $pages;

	}
    // ������������ � ������� ������� �������
	function appendContentArticle($pages)
	{
		global $DB;
		if (!empty($pages))
		{
		$rows = $DB->select("SELECT * FROM ?_article_content WHERE  page_id IN (?a)", array_keys($pages));

		foreach($pages as $v)
			$pages[$v["page_id"]]["content"] = array();

		foreach($rows as $v)
			$pages[$v["page_id"]]["content"][$v["cv_name"]] = $v["cv_text"];

		}
		return $pages;

	}
	 // �������� �����
	function getArticleById($id)
	{
		global $DB;

		$cleanId = (int)$id;

		$rows = $DB->select("SELECT a.*,m.page_name_en AS j_name_en FROM ?_article AS a
		                     LEFT OUTER JOIN ?_magazine AS m ON m.page_id=a.journal 
		        WHERE   a.page_id=".$cleanId);


		return $rows;

	}
	// �������� ������� �������� �� � ID
	function getContentByPageId($pageId)
	{
		$rows = $this->appendContent(array($pageId => array()));
		return $rows[$pageId]["content"];
	}

	// �������� ID ������������� ��-��
	function getParentId($id)
	{
		$pid = $this->getPageById($id);
		return $pid["page_parent"];
	}

	// �������� URL � ��������� ��������
	// ������������ ���� ����� ��� ���!
	function getPageUrl($id, $vars = array(), $pages = array())
	{
		global $DB;

		if(empty($pages) || !isset($pages[$id]))
			$pages = $this->getPages();

		if(!isset($pages[$id]) || empty($pages[$id]["page_status"]))
			return;

		$qStr = array();
		if(!empty($vars))
		{
			foreach($vars as $vName => $vValue)
			{

				if(!empty($vValue))
					$qStr[$vName] = $vName."=".$vValue;
			}
		}


		if(!empty($pages[$id]["page_urlname"]))
		{
			if(!empty($pages[$id]["page_urlname_regexp"]))
			{

				$urlVars = Templater::getVarsFromStr($pages[$id]["page_urlname"]);
				foreach($urlVars as $vName)
				{
					$vValue = "";
					if(isset($vars[strtolower($vName)]))
					{
						$vValue = $vars[strtolower($vName)];
						unset($qStr[strtolower($vName)]);
					}
					$pages[$id]["page_urlname"] = str_replace('{'.$vName.'}', $vValue, $pages[$id]["page_urlname"]);
				}
			}
			return "/".$pages[$id]["page_urlname"].(!empty($qStr)? "?".implode("&", $qStr): "");
		}

		if(!empty($pages[$id]["page_link"]))
		{
			if(intval($pages[$id]["page_link"]) > 0)
			{

				$retVal = "/index.php?page_id=".$pages[$id]["page_link"].(!empty($qStr)? "&".implode("&", $qStr): "");
				$link_urlname = isset($pages[$pages[$id]["page_link"]])? $pages[$pages[$id]["page_link"]]["page_urlname"]: "";

				if(!empty($link_urlname))
					$retVal = "/".$link_urlname.(!empty($qStr)? "?".implode("&", $qStr): "");
			}
			else
				$retVal = $pages[$id]["page_link"];

			return $retVal;
		}

		return "/index.php?page_id=".$id.(!empty($qStr)? "&".implode("&", $qStr): "");
	}
    // �������� �������� ������ ��� XML
	function getMagazineAttribute($id)
	{
		global $DB;
		$rows=$DB->select("SELECT j.page_id,j.page_name,j.issn,j.eLibrary,a.date_public
		                  FROM adm_magazine AS j
		                  INNER JOIN adm_article AS a ON a.journal=j.page_id");
		return $rows;
	}
	// ������� ������� ��-�� �� ID �������� (���� �������� - ������, �� ����� ��������� ��-��)
	function getLinkedPages($id)
	{
		global $DB;

		$self = $this->getPageById($id);
		// �������� ID ������-��������
		$masterID = ((int)$self["page_link"] > 0)? $self["page_link"]: $id;

		$retVal = array();

		$pages = $this->getPages();
		// ��������� �� ���� ���������
		foreach($pages as $k => $v)
		{
			// ���� ID �������� ��� �� ������ ����� �� ����������� ���� ���������
			if(($k == $masterID || @$v["page_link"] == $masterID))
			{
				// ���� �� ��������� ����� ������ - ��������� ������������ ����� � ����� ������
				$parent = $k;
				while($parent != 0)
				{
					$retVal[$parent] = $pages[$parent];
					$parent = $pages[$parent]["page_parent"];
				}
			}
		}

		return $retVal;

	}

	// ������� ��� ������������ ��-�� (� ��� ��������)
	function getParents($id, $page_status = null, $page_link = null, $page_type = null)
	{
		$rows = $this->getPages($page_status, $page_link, $page_type);

		$retVal = array();

		// ���� �� ��������� ����� ������ - ��������� ������������ ����� � ����� ������
		$parent = $id;
		while($parent != 0)
		{
			$retVal[$parent] = $rows[$parent];
			$parent = $rows[$parent]["page_parent"];
		}

		return array_reverse($retVal, true);
	}

	function getPageByUrl($url, $page_status = null, $page_type = null)
	{
		global $DB;

		// ��������� ������ ���������� � �����
		$row = $DB->selectRow(
			"SELECT * ".
			"FROM ?_magazine ".
			"WHERE ".
				"page_urlname = ? ".
				"{AND page_status  = ?d} ".
				"{AND page_type    = ?d} ",

			rawurldecode($url),
			(is_null($page_status) ? DBSIMPLE_SKIP: $page_status),
			(is_null($page_type)   ? DBSIMPLE_SKIP: $page_type)
		);

		// ��������� ���������� �� ���������
		if(empty($row))
			$row = $DB->selectRow(
				"SELECT * ".
				"FROM ?_magazine ".
				"WHERE ".
					"page_urlname_regexp != '' ".
					"AND ? REGEXP BINARY page_urlname_regexp ".
					"{AND page_status  = ?d} ".
					"{AND page_type    = ?d} ",

				rawurldecode($url),
				(is_null($page_status) ? DBSIMPLE_SKIP: $page_status),
				(is_null($page_type)   ? DBSIMPLE_SKIP: $page_type)
			);

		// �������� ����� �������� ����� ���� � ������� ������� � ������������ "index.html" (������ �������� �������� �������)
		return $row;
	}


	function registHiddenVariables($pageID, $url)
	{
		$row = $this->getPageById($pageID);
		if(!empty($row["page_urlname_regexp"]))
		{
			$vars = Templater::getVarsFromStr($row["page_urlname"]);
			preg_match("/".$row["page_urlname_regexp"]."/", $url, $matches);
			foreach($vars as $matchKey => $varName)
				$_REQUEST[strtolower($varName)] = $matches[$matchKey + 1];
		}
	}

// ������ ���� ������� ������� �� if �������� ��������
   function magazine_pages($id="")
   {
     global $DB;

     $cleanId = (int)$id;

	 if (!empty($id))
	 {
	    $rows=$DB->select("SELECT * FROM ?_pages_content WHERE page_id=".$cleanId);
		foreach($rows as $row)
		{
	        $pages[$row[cv_name]]=$row[cv_text];	
		}
	  }
      return $pages;
   }

   function getAllArticlesByNumber($jid) {
	    global $DB;

       $articlesFirstRub = $DB->select("
	    SELECT aa.page_id,aa.name, aa.name_en FROM adm_article AS aj
	    INNER JOIN adm_article AS ar ON ar.page_parent=aj.page_id
	    INNER JOIN adm_article AS aa ON aa.page_parent=ar.page_id
	    WHERE aj.page_id = ?d AND aa.page_status=1
	    
	    ", $jid);

       $articlesSecondRub = $DB->select("
	    SELECT aa.page_id,aa.name, aa.name_en FROM adm_article AS aj
	    INNER JOIN adm_article AS ar ON ar.page_parent=aj.page_id
	    INNER JOIN adm_article AS ar2 ON ar2.page_parent=ar.page_id
	    INNER JOIN adm_article AS aa ON aa.page_parent=ar2.page_id
	    WHERE aj.page_id = ?d AND aa.page_status=1
	    
	    ", $jid);

       $articles = array_merge($articlesFirstRub,$articlesSecondRub);

       return $articles;
   }

   function getEnArticlesByNumber($jid) {
	    global $DB;

       $articlesFirstRub = $DB->select("
	    SELECT aa.page_id,aa.name_en FROM adm_article AS aj
	    INNER JOIN adm_article AS ar ON ar.page_parent=aj.page_id
	    INNER JOIN adm_article AS aa ON aa.page_parent=ar.page_id
	    WHERE aj.page_id = ?d AND aa.name=aa.name_en AND aa.page_status=1
	    
	    ", $jid);

	    $articlesSecondRub = $DB->select("
	    SELECT aa.page_id,aa.name_en FROM adm_article AS aj
	    INNER JOIN adm_article AS ar ON ar.page_parent=aj.page_id
	    INNER JOIN adm_article AS ar2 ON ar2.page_parent=ar.page_id
	    INNER JOIN adm_article AS aa ON aa.page_parent=ar2.page_id
	    WHERE aj.page_id = ?d AND aa.name=aa.name_en AND aa.page_status=1
	    
	    ", $jid);

	    $articles = array_merge($articlesFirstRub,$articlesSecondRub);

	    return $articles;
   }


//	function get

}




?>