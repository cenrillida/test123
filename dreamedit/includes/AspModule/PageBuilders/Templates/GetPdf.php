<?php

namespace AspModule\PageBuilders\Templates;

use AspModule\AspModule;
use AspModule\PageBuilders\PageBuilder;

class GetPdf implements PageBuilder {
    /** @var AspModule */
    private $aspModule;
    /** @var \Pages */
    private $pages;

    public function __construct($aspModule,$pages)
    {
        $this->aspModule = $aspModule;
        $this->pages = $pages;
    }

    public function build($params = array())
    {
        if(empty($_GET['user_id'])) {

            switch ($_GET['file']) {
                case "getApplyForEntry":
                    $this->aspModule->getDocumentService()->getDocument("getApplyForEntry");
                    break;
                case "getConsentDataProcessing":
                    $this->aspModule->getDocumentService()->getDocument("getConsentDataProcessing");
                    break;
                case "getApplication":
                    $this->aspModule->getDocumentService()->getDocument("getApplication");
                    break;
                case "getPersonalDocument":
                    $this->aspModule->getDocumentService()->getDocument("getPersonalDocument");
                    break;
                case "getPensionCertificate":
                    $this->aspModule->getDocumentService()->getDocument("getPensionCertificate");
                    break;
                case "getEssay":
                    $this->aspModule->getDocumentService()->getDocument("getEssay");
                    break;
                case "getScienceWorkList":
                    $this->aspModule->getDocumentService()->getDocument("getScienceWorkList");
                    break;
                case "getEducation":
                    $this->aspModule->getDocumentService()->getDocument("getEducation");
                    break;
                case "getAutobiography":
                    $this->aspModule->getDocumentService()->getDocument("getAutobiography");
                    break;
                case "getPersonalSheet":
                    $this->aspModule->getDocumentService()->getDocument("getPersonalSheet");
                    break;
                case "getIndividualAchievements":
                    $this->aspModule->getDocumentService()->getDocument("getIndividualAchievements",$_GET['id']);
                    break;
                case "getDisabledInfo":
                    $this->aspModule->getDocumentService()->getDocument("getDisabledInfo");
                    break;
                case "getEducationPeriodReference":
                    $this->aspModule->getDocumentService()->getDocument("getEducationPeriodReference");
                    break;
                default:
                    echo "Ошибка доступа.";
            }

        } else {
            if($this->aspModule->getStatusService()->getStatusBy($this->aspModule->getCurrentUser()->getStatus())->isAdminAllow()) {
                $user = $this->aspModule->getUserService()->getUserById($_GET['user_id']);
                switch ($_GET['file']) {
                    case "getApplyForEntry":
                        $this->aspModule->getDocumentService()->getDocument("getApplyForEntry","",$user);
                        break;
                    case "getConsentDataProcessing":
                        $this->aspModule->getDocumentService()->getDocument("getConsentDataProcessing","",$user);
                        break;
                    case "getApplication":
                        $this->aspModule->getDocumentService()->getDocument("getApplication","",$user);
                        break;
                    case "getPersonalDocument":
                        $this->aspModule->getDocumentService()->getDocument("getPersonalDocument","",$user);
                        break;
                    case "getPensionCertificate":
                        $this->aspModule->getDocumentService()->getDocument("getPensionCertificate","",$user);
                        break;
                    case "getEssay":
                        $this->aspModule->getDocumentService()->getDocument("getEssay","",$user);
                        break;
                    case "getScienceWorkList":
                        $this->aspModule->getDocumentService()->getDocument("getScienceWorkList","",$user);
                        break;
                    case "getEducation":
                        $this->aspModule->getDocumentService()->getDocument("getEducation","",$user);
                        break;
                    case "getAutobiography":
                        $this->aspModule->getDocumentService()->getDocument("getAutobiography","",$user);
                        break;
                    case "getPersonalSheet":
                        $this->aspModule->getDocumentService()->getDocument("getPersonalSheet","",$user);
                        break;
                    case "getIndividualAchievements":
                        $this->aspModule->getDocumentService()->getDocument("getIndividualAchievements",$_GET['id'],$user);
                        break;
                    case "getDisabledInfo":
                        $this->aspModule->getDocumentService()->getDocument("getDisabledInfo","",$user);
                        break;
                    case "getEducationPeriodReference":
                        $this->aspModule->getDocumentService()->getDocument("getEducationPeriodReference","",$user);
                        break;
                    default:
                        echo "Ошибка доступа.";
                }
            } else {
                echo "Ошибка доступа.";
            }
        }
    }
}