<?php

class AuthorBuilder
{
    private $people;
    private $authorPageId;
    private $lang;
    private $avtList = '';
    private $avtListShort = '';
    private $avtListShortSide = '';
    private $fiosFull;

    public function __construct($people, $authorPageId, $lang = '', $fiosFull = true)
    {
        $this->people = $people;
        $this->authorPageId = $authorPageId;
        $this->lang = $lang;
        $this->fiosFull = $fiosFull;
    }

    private function getFiosFromPeople($people) {
        $fios=$people["fio"];
        if($_REQUEST["jj"]!=1665)
        {
            if($this->fiosFull) {
                $fios = $people["name_surname"];

                if(ltrim($fios) == "") {
                    if ($this->lang != '/en') {
                        $fios = $people["fioshort"];
                    } else {
                        $fios = mb_stristr($people["fioshort"], " ") . " " . mb_stristr($people["fioshort"], " ", true);

                    }
                }
            } else {
                if($people["full_name_echo"]==1) {
                    $fios = $people["name_surname"];
                } else {
                    if ($this->lang != '/en') {
                        $fios = $people["fioshort"];
                    } else {
                        $fios = substr(mb_stristr($people["fioshort"], " "), 1, 1) . ". " . mb_stristr($people["fioshort"], " ", true);
                    }
                }
            }
        }
        return $fios;
    }

    public function processAuthors() {
        $this->avtList="";
        $this->avtListShort="";
        $this->avtListShortSide="";
        foreach($this->people as $people)
        {
            if (!empty($people["id"]) && $people["id"] != '488' && $people["id"]!='270')
            {
                $this->avtList.=$this->getFiosFromPeople($people).", ";
                if($people["full_name_echo"]==1) {
                    $this->avtListShort.=$people["name_surname"].", ";
                    $this->avtListShortSide.=$people["name_surname"].", ";
                } else {
                    if($this->lang=="/en") {
                        $people["fioshort_side"] = mb_stristr($people["fioshort"], " ", true) . " " . substr(mb_stristr($people["fioshort"], " "), 1, 1) . ".";
                    }
                    $this->avtListShort.=$people["fioshort_side"].", ";
                    $this->avtListShortSide.=$people["fioshort"].", ";
                }
            }
        }
        if (!empty($this->avtList)) $this->avtList=substr($this->avtList,0,-2);
        if (!empty($this->avtListShort)) $this->avtListShort=substr($this->avtListShort,0,-2);
        if (!empty($this->avtListShortSide)) $this->avtListShortSide=substr($this->avtListShortSide,0,-2);
    }

    public function echoAuthors($articleRow) {
        $peopleCounter = 1;
        foreach($this->people as $people)
        {
            $fios = $this->getFiosFromPeople($people);
            if (!empty($people["id"]) && $people["id"] != '488' && $people["id"]!='270')
            {
                if ($people["otdel"]!='Умершие сотрудники')
                {
                    echo "<div>".
                        "<a href=".$this->lang."/index.php?page_id=".$this->authorPageId."&id=".$people["id"]."&jid=".$_REQUEST["jid"]."&jj=".$_REQUEST["jj"].">".
                        $fios."</a>";

                    if (!empty($people["work"])) echo ",<br />".$people["work"];
                    if (!empty($people["mail1"]) && $people["mail1"]!='no' && $_REQUEST["jj"]!=1614) echo ", <a href=mailto:".$people["mail1"].">".$people["mail1"]."</a>";
                }
                else
                    echo "<div><span style='border:1px solid gray;'>".
                        "<a href=".$this->lang."/index.php?page_id=".$this->authorPageId."&id=".$people["id"]."&jid=".$_REQUEST["jid"]."&jj=".$_REQUEST["jj"].">".
                        $fios."</a></span>";

                if(!empty($people['orcid'])) {
                    echo " <a target='_blank' href=\"https://orcid.org/{$people['orcid']}\"><i class=\"fab fa-orcid\" style=\"color: #a5cd39\"></i></a>";
                }
                echo "</div>";


                $organizationNameArray = array();
                if($this->lang!="/en") {
                    if(!empty($articleRow['organization_name'])) {
                        $organizationNameArray = unserialize($articleRow['organization_name']);
                    }
                } else {
                    if(!empty($articleRow['organization_name_en'])) {
                        $organizationNameArray = unserialize($articleRow['organization_name_en']);
                    }
                }

                foreach ($organizationNameArray[$peopleCounter-1] as $value) {
                    echo "<p>$value</p>";
                }



            }
            $peopleCounter++;
        }
    }

    public function getAuthorRowWithLinks() {
        $avtList = '';
        foreach($this->people as $people)
        {
            if (!empty($people['id']))
            {

                $fios=$people['fio'];
                if($_REQUEST['jj']==1614 || $_REQUEST['jj']==1672)
                {
                    if($people['full_name_echo']==1) {
                        $fios = $people['name_surname'];
                    } else {
                        if ($_SESSION['lang'] != '/en') {
                            $fios = $people['fioshort'];
                        } else {
                            $fios = substr(mb_stristr($people['fioshort'], " "), 1, 1) . ". " . mb_stristr($people['fioshort'], " ", true);
                        }
                    }

                }
                if($_REQUEST['jj']==1665) {
                    $fios = $people['name_surname'];
                }
                if($_SESSION['lang']=='/en' && $_REQUEST['jj']==1669) {
                    if(strpos($people['enlastname'],' ') !== false) {
                        $fios = $people['enlastname'].', '.$people['enfirstname'];
                    } else {
                        $fios = preg_replace("/[ ]/", ", ", $fios, 1);
                    }
                }
//      	      	echo "<br />";print_R($people);
                if(substr($people['fio'],0,8)!='Редакция' && substr($people['fio'],0,8)!=false)
                {
                    if ($people['otdel']!='Умершие сотрудники')
                        $avtList.="<a href=".$_SESSION['lang']."/index.php?page_id=".$this->authorPageId."&id=".$people['id'].
                            ">".$fios."</a>, ";
                    else

                        $avtList.="<a style='border:1px solid gray;' href=".$_SESSION['lang']."/index.php?page_id=".$this->authorPageId."&id=".$people['id'].
                            ">".$fios."</a>, "; //.$people[work].",".$people[mail1]."";
                }
            }
        }
        $avtList = substr($avtList, 0,-2);
        return $avtList;
    }

    /**
     * @return mixed
     */
    public function getAvtList()
    {
        return $this->avtList;
    }

    /**
     * @return mixed
     */
    public function getAvtListShort()
    {
        return $this->avtListShort;
    }

    /**
     * @return mixed
     */
    public function getAvtListShortSide()
    {
        return $this->avtListShortSide;
    }


}