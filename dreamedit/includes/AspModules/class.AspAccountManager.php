<?php

class AspAccountManager {

    /** @var AspModule */
    private $aspModule;

    public function __construct($aspModule)
    {
        $this->aspModule = $aspModule;
    }

    public function setBuilderWithMode($mode) {
        if(empty($mode)) {
            $mode = "";
        }
        switch ($mode) {
            case "createXlsx":
                $this->aspModule->getAspPageBuilderManager()->setPageBuilder("createXlsx");
                break;
            case "educationUpload":
                $this->aspModule->getAspPageBuilderManager()->setPageBuilder("educationUpload");
                break;
            case "addEducation":
                $this->aspModule->getAspPageBuilderManager()->setPageBuilder("addEducation");
                break;
            case "editRegData":
                $this->aspModule->getAspPageBuilderManager()->setPageBuilder("editRegData");
                break;
            case "getUserData":
                $this->aspModule->getAspPageBuilderManager()->setPageBuilder("getUserData");
                break;
            case "changeUserStatus":
                $this->aspModule->getAspPageBuilderManager()->setPageBuilder("changeUserStatus");
                break;
            case "adminTableSource":
                $this->aspModule->getAspPageBuilderManager()->setPageBuilder("adminTableSource");
                break;
            case "adminTable":
                $this->aspModule->getAspPageBuilderManager()->setPageBuilder("adminTable");
                break;
            case "techSupportContact":
                $this->aspModule->getAspPageBuilderManager()->setPageBuilder("techSupportContact");
                break;
            case "getPdfFile":
                $this->aspModule->getAspPageBuilderManager()->setPageBuilder("getPdfFile");
                break;
            case "sendDocument":
                $this->aspModule->getAspPageBuilderManager()->setPageBuilder("sendDocument");
                break;
            case "uploadDocument":
                $this->aspModule->getAspPageBuilderManager()->setPageBuilder("uploadDocument");
                break;
            case "createDocument":
                $this->aspModule->getAspPageBuilderManager()->setPageBuilder("createDocument");
                break;
            case "getUserPhoto":
                $this->aspModule->getAspPageBuilderManager()->setPageBuilder("getUserPhoto");
                break;
            case "documentApplication":
                $this->aspModule->getAspPageBuilderManager()->setPageBuilder("documentApplication");
                break;
            case "addData":
                $this->aspModule->getAspPageBuilderManager()->setPageBuilder("addData");
                break;
            case "applyForEntry":
                $this->aspModule->getAspPageBuilderManager()->setPageBuilder("applyForEntry");
                break;
            case "applyForEntryUpload":
                $this->aspModule->getAspPageBuilderManager()->setPageBuilder("applyForEntryUpload");
                break;
            case "":
                $this->aspModule->getAspPageBuilderManager()->setPageBuilder("personal");
                break;
            default:
                echo "Ошибка доступа.";
        }
    }

}