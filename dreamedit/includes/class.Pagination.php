<?

class Pagination 
{
	// конструктор для PHP5+
	function __construct()
	{

	}

	// конструктор для PHP4 <
	function Pagination()
	{
		return $this->__construct();
	}


	function createPages($elCnt, $elOnPage, $selected = 1, $pgCnt = "all", $chevrons = false)
	{
		$pgNum = @(int)ceil($elCnt / $elOnPage);

		if($pgNum <= 1) 
			return array(1); 

		if($selected < 1)
			$selected = 1;
		if($selected > $pgNum)
			$selected = $pgNum;

		$retVal = array();
		if (isset($_REQUEST[en])) 
		{
		   $txt1='prev';$txt2='next';
		}
		else
		{
		  $txt1='предыдущая';$txt2='следующая';
		}
		if($chevrons) {
		    $txt1 = "<i class=\"fas fa-chevron-left\"></i>";
		    $txt2 = "<i class=\"fas fa-chevron-right\"></i>";
        }
		if(intval($pgCnt) > 0)
		{
			$strt = ($selected - $pgCnt > 0)     ? $selected - $pgCnt: 1; 
			$end  = ($selected + $pgCnt < $pgNum)? $selected + $pgCnt: $pgNum; 

			if($selected > 1) 
			{ 
	//			$retVal[] = array(1, "««");
                if($chevrons) {
                    $retVal[] = array($selected - 1, $txt1 );
                } else {
                    $retVal[] = array($selected - 1, "<b>" . $txt1 . "&nbsp;&nbsp;&larr;</b>&nbsp;&nbsp;");
                }
			} 

			for($i = $strt; $i <= $end; $i++) 
				$retVal[] = array($i, $i);

			if($selected < $pgNum) 
			{
                if($chevrons) {
                    $retVal[] = array($selected + 1, $txt2);
                } else {
                    $retVal[] = array($selected + 1, "&nbsp;&nbsp<b>&rarr;&nbsp;" . $txt2 . "</b>&nbsp;&nbsp;");
                }
	//			$retVal[] = array($pgNum, "»»");
			} 
		
		}
		else
		{
			for($i = 1; $i <= $pgNum; $i++) 
				$retVal[] = $i;		
		}

		return $retVal;
	}

	static function createPagination($elCount,$elOnPage,$addParams = array(), $pageParam = "p", $pageButtonsCount = 15) {
        $porog=$pageButtonsCount; //$numpages*0.3; //Показывать треть от номеров страниц
        $spe2 = "";

        if(!$_REQUEST[$pageParam]) $page = 1;
        else $page = $_REQUEST[$pageParam];
        $numpages = ceil($elCount/$elOnPage);

        $pg = new Pages();

        unset($addParams[$pageParam]);

        if($page > 1) {
            $spe2 .= "<li class=\"page-item pr-2 pt-2\"><a class=\"page-link\" href=\"".$_SESSION[lang] . $pg->getPageUrl($_REQUEST["page_id"], array_merge(array($pageParam => $page-1),$addParams))."\"><i class=\"fas fa-chevron-left\"></i></a></li>";
        }
        if ($page>ceil($porog/2))
        {
            $spe2 .= '<li class="page-item pr-2 pt-2"><a class="page-link" href="'.$_SESSION[lang] . $pg->getPageUrl($_REQUEST["page_id"], array_merge(array($pageParam => 1),$addParams)).'">1</a></li>';
        }
        if ($page>ceil($porog/2))
        {
            $spe2 .= '<li class="page-item pr-2 pt-2"><a class="page-link" href="#">...</a></li>';
        }

        if ($page<=ceil($porog/2)) $page_start=1;
        else
            if ($page>($numpages-$porog)) $page_start=$numpages-$porog;
            else
                $page_start=$page-ceil($porog/2);

        if($page>ceil($porog/2) && $page<=ceil($porog/2)+3) {
            $page_start = 3;
        }
        if($page>ceil($porog/2) && $page<=$porog+2 && ($page_start<1 || $numpages-$porog==1 || $numpages-$porog==2)) {
            $page_start = 3;
        }

        if ($page_start<1) $page_start=1;
        $page_end=$numpages;
        if($numpages>$porog+$page_start-1) $page_end=$porog+$page_start;

        for($i=$page_start;$i<$page_end;$i++)
        {
            if($page==$i)
            {
                $ii="<strong>".$i."</strong>";
                $spe2 .= '<li class="page-item active pr-2 pt-2"><a class="page-link" href="#">'.$ii.'</a></li>';
            }
            else
            {
                $ii=$i;
                $spe2 .= '<li class="page-item pr-2 pt-2"><a class="page-link" href="'.$_SESSION[lang] . $pg->getPageUrl($_REQUEST["page_id"], array_merge(array($pageParam => $i),$addParams)).'">'.$ii.'</a></li>';
            }
        }

        if($page<$numpages && $page_end<$numpages) {
            $spe2 .= '<li class="page-item pr-2 pt-2"><a class="page-link" href="#">...</a></li>';
        }
        if ($page!=$numpages) {
            $spe2 .= '<li class="page-item pr-2 pt-2"><a class="page-link" href="'. $_SESSION[lang] . $pg->getPageUrl($_REQUEST["page_id"], array_merge(array($pageParam=> $numpages),$addParams)) .'">'.$numpages.'</a></li>';
        }
        else {
            $spe2 .= '<li class="page-item active pr-2 pt-2"><a class="page-link" href="#">'.$numpages.'</a></li>';
        }

        if ($page< $numpages && $numpages > 1) {
            $spe2 .= '<li class="page-item pr-2 pt-2"><a class="page-link" href="'.$_SESSION[lang] . $pg->getPageUrl($_REQUEST["page_id"], array_merge(array($pageParam => $page+1),$addParams)).'"><i class="fas fa-chevron-right"></i></a></li>';
        }
        return $spe2;
    }

    /**
     * @param $elCount
     * @param $elOnPage
     * @param string $pageParam
     * @return bool
     */
    static function isLastPage($elCount, $elOnPage, $pageParam = "p") {
        if(!$_REQUEST[$pageParam]) $page = 1;
        else $page = $_REQUEST[$pageParam];
        $numpages = ceil($elCount/$elOnPage);
        if($page==$numpages) {
            return true;
        } else {
            return false;
        }
    }
}



?>