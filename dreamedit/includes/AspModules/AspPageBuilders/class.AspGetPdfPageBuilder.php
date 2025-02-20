<?php

class AspGetPdfPageBuilder implements AspPageBuilder {
    /** @var AspModule */
    private $aspModule;
    /** @var Pages */
    private $pages;

    public function __construct($aspModule,$pages)
    {
        $this->aspModule = $aspModule;
        $this->pages = $pages;
    }

    public function build()
    {
        if(empty($_GET['user_id'])) {

            switch ($_GET['file']) {
                case "getApplyForEntry":
                    $this->aspModule->getAspDocumentService()->getDocument("getApplyForEntry");
                    break;
                case "getApplication":
                    $this->aspModule->getAspDocumentService()->getDocument("getApplication");
                    break;
                case "getPersonalDocument":
                    $this->aspModule->getAspDocumentService()->getDocument("getPersonalDocument");
                    break;
                case "getEducation":
                    $this->aspModule->getAspDocumentService()->getDocument("getEducation");
                    break;
                case "getAutobiography":
                    $this->aspModule->getAspDocumentService()->getDocument("getAutobiography");
                    break;
                case "getPersonalSheet":
                    $this->aspModule->getAspDocumentService()->getDocument("getPersonalSheet");
                    break;
                case "getIndividualAchievements":
                    $this->aspModule->getAspDocumentService()->getDocument("getIndividualAchievements",$_GET['id']);
                    break;
                case "getDisabledInfo":
                    $this->aspModule->getAspDocumentService()->getDocument("getDisabledInfo");
                    break;
                default:
                    echo "Ошибка доступа.";
            }

        } else {
            if($this->aspModule->getAspStatusManager()->getStatusBy($this->aspModule->getCurrentUser()->getStatus())->isAdminAllow()) {
                $user = $this->aspModule->getAspModuleUserManager()->getUserById($_GET['user_id']);
                switch ($_GET['file']) {
                    case "getApplyForEntry":
                        $this->aspModule->getAspDocumentService()->getDocument("getApplyForEntry","",$user);
                        break;
                    case "getApplication":
                        $this->aspModule->getAspDocumentService()->getDocument("getApplication","",$user);
                        break;
                    case "getPersonalDocument":
                        $this->aspModule->getAspDocumentService()->getDocument("getPersonalDocument","",$user);
                        break;
                    case "getEducation":
                        $this->aspModule->getAspDocumentService()->getDocument("getEducation","",$user);
                        break;
                    case "getAutobiography":
                        $this->aspModule->getAspDocumentService()->getDocument("getAutobiography","",$user);
                        break;
                    case "getPersonalSheet":
                        $this->aspModule->getAspDocumentService()->getDocument("getPersonalSheet","",$user);
                        break;
                    case "getIndividualAchievements":
                        $this->aspModule->getAspDocumentService()->getDocument("getIndividualAchievements",$_GET['id'],$user);
                        break;
                    case "getDisabledInfo":
                        $this->aspModule->getAspDocumentService()->getDocument("getDisabledInfo","",$user);
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