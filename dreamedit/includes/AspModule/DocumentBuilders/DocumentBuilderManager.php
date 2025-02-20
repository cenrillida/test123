<?php

namespace AspModule\DocumentBuilders;

use AspModule\AspModule;
use AspModule\DocumentBuilders\Templates\ApplicationDissertationDocumentBuilder;
use AspModule\DocumentBuilders\Templates\ApplicationDocumentBuilder;
use AspModule\DocumentBuilders\Templates\ApplyForEntryBuilder;
use AspModule\DocumentBuilders\Templates\ConsentDataProcessingDocumentBuilder;
use AspModule\DocumentBuilders\Templates\PersonalSheetBuilder;
use AspModule\DocumentBuilders\Templates\ScienceWorkBuilder;

class DocumentBuilderManager {

    /** @var DocumentBuilder[] */
    private $pageList;
    /** @var AspModule */
    private $aspModule;

    public function __construct($aspModule)
    {
        $this->aspModule = $aspModule;
        $this->pageList = array(
            "application" => new ApplicationDocumentBuilder(),
            "applicationDissertation" => new ApplicationDissertationDocumentBuilder(),
            "personalSheet" => new PersonalSheetBuilder(),
            "applyForEntry" => new ApplyForEntryBuilder(),
            "scienceWork" => new ScienceWorkBuilder($aspModule),
            "consentDataProcessing" => new ConsentDataProcessingDocumentBuilder()
        );
    }

    public function setBuilder($name) {
        if(!empty($this->pageList[$name])) {
            $this->aspModule->setDocumentBuilder($this->pageList[$name]);
        }
    }

}