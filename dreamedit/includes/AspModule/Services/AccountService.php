<?php

namespace AspModule\Services;

use AspModule\AspModule;

class AccountService {

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
        if($this->aspModule->getAuthorizationService()->checkLogin()) {
            switch ($mode) {
                case "createUser":
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("createUser");
                    break;
                case "documentApplicationControl":
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("documentApplicationControl");
                    break;
                case "createXlsx":
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("createXlsx");
                    break;
                case "educationUpload":
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("educationUpload");
                    break;
                case "addEducation":
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("addEducation");
                    break;
                case "editRegData":
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("editRegData");
                    break;
                case "getUserData":
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("getUserData");
                    break;
                case "changeUserStatus":
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("changeUserStatus");
                    break;
                case "adminTableSource":
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("adminTableSource");
                    break;
                case "adminTableUpdate":
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("adminTableUpdate");
                    break;
                case "adminTable":
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("adminTable");
                    break;
                case "techSupportContact":
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("techSupportContact");
                    break;
                case "faq":
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("faq");
                    break;
                case "getPdfFile":
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("getPdfFile");
                    break;
                case "sendDocument":
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("sendDocument");
                    break;
                case "uploadDocument":
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("uploadDocument");
                    break;
                case "createDocument":
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("createDocument");
                    break;
                case "getUserPhoto":
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("getUserPhoto");
                    break;
                case "documentApplication":
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("documentApplication");
                    break;
                case "addData":
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("addData");
                    break;
                case "applyForEntry":
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("applyForEntry");
                    break;
                case "applyForEntryUpload":
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("applyForEntryUpload");
                    break;
                case "applicationsYears":
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("applicationsYears");
                    break;
                case "addApplicationsYear";
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("addApplicationsYear");
                    break;
                case "":
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("personal");
                    break;
                case "login":
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("login");
                    break;
                default:
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("error");
            }
            $currentUser = $this->aspModule->getCurrentUser();
            $status = $this->aspModule->getStatusService()->getStatusBy($currentUser->getStatus());
            if(
                !$status->isAdminAllow() &&
                (!$this->aspModule->getDocumentApplicationStatusService()->isOpenedStudy() || $currentUser->isForDissertationAttachment()) &&
                (!$this->aspModule->getDocumentApplicationStatusService()->isOpenedDissertation() || !$currentUser->isForDissertationAttachment())
            ) {
                switch ($mode) {
                    case "techSupportContact":
                        $this->aspModule->getPageBuilderManager()->setPageBuilder("techSupportContact");
                        break;
                    case "faq":
                        $this->aspModule->getPageBuilderManager()->setPageBuilder("faq");
                        break;
                    case "login":
                        $this->aspModule->getPageBuilderManager()->setPageBuilder("login");
                        break;
                    default:
                        $this->aspModule->getPageBuilderManager()->setPageBuilder("documentApplicationClosed");
                }
            }
        } else {
            switch ($mode) {
                case "passwordUpdate":
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("passwordUpdate");
                    break;
                case "passwordReset":
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("passwordReset");
                    break;
                case "registerConfirm":
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("registerConfirm");
                    break;
                case "register":
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("register");
                    break;
                case "login":
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("login");
                    break;
                case "":
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("login");
                    break;
                default:
                    $this->aspModule->getPageBuilderManager()->setPageBuilder("error");
            }
        }
    }

}