<?php

class AspDocumentTemplaterManager {

    /** @var AspDocumentTemplater[] */
    private $pageList;
    /** @var AspModule */
    private $aspModule;

    public function __construct($aspModule)
    {
        $this->aspModule = $aspModule;
        $this->pageList = array(
            "application" => new AspApplicationDocumentTemplater(),
            "personalSheet" => new AspPersonalSheetTemplater(),
            "applyForEntry" => new AspApplyForEntryTemplater()
        );
    }

    public function setTemplater($name) {
        if(!empty($this->pageList[$name])) {
            $this->aspModule->setAspDocumentTemplater($this->pageList[$name]);
        }
    }

}