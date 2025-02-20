<?php

namespace Crossref\PageBuilders;

use Crossref\Crossref;
use Crossref\PageBuilders\Templates\Admin;
use Crossref\PageBuilders\Templates\Error;
use Crossref\PageBuilders\Templates\JournalsList;
use Crossref\PageBuilders\Templates\LoginForm;
use Crossref\PageBuilders\Templates\NumberCheck;
use Crossref\PageBuilders\Templates\NumberCheckUpload;
use Crossref\PageBuilders\Templates\PublCheck;
use Crossref\PageBuilders\Templates\PublCheckUpload;
use Crossref\PageBuilders\Templates\PublsList;
use Crossref\PageBuilders\Templates\Top;
use Crossref\PageBuilders\Templates\Xml;
use Crossref\PageBuilders\Templates\XmlPubl;

class PageBuilderManager {

    /** @var PageBuilder[] */
    private $pageList;
    /** @var Crossref */
    private $crossref;
    /** @var \Pages */
    private $pages;

    public function __construct($crossref, $pages)
    {
        $this->crossref = $crossref;
        $this->pages = $pages;
        $this->pageList = array(
            "login" => new LoginForm($this->crossref,$this->pages),
            "admin" => new Admin($this->crossref,$this->pages),
            "error" => new Error($this->crossref,$this->pages),
            "top" => new Top($this->crossref,$this->pages),
            "journalsList" => new JournalsList($this->crossref,$this->pages),
            "numberCheck" => new NumberCheck($this->crossref,$this->pages),
            "xml" => new Xml($this->crossref,$this->pages),
            "numberCheckUpload" => new NumberCheckUpload($this->crossref,$this->pages),
            "publCheck" => new PublCheck($this->crossref,$this->pages),
            "publCheckUpload" => new PublCheckUpload($this->crossref,$this->pages),
            "publsList" => new PublsList($this->crossref,$this->pages),
            "xmlPubl" => new XmlPubl($this->crossref,$this->pages)
        );
    }

    public function setPageBuilder($name) {
        if(!empty($this->pageList[$name])) {
            $this->crossref->setPageBuilder($this->pageList[$name]);
        } else {
            $this->crossref->setPageBuilder($this->pageList['error']);
        }
    }

}