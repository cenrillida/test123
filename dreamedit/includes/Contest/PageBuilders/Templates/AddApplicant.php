<?php

namespace Contest\PageBuilders\Templates;

use Contest\Contest;
use Contest\FormBuilders\Templates\AddApplicantFormBuilder;
use Contest\PageBuilders\PageBuilder;

class AddApplicant implements PageBuilder {

    /** @var Contest */
    private $contest;
    /** @var \Pages */
    private $pages;

    /**
     * AddApplicant constructor.
     * @param Contest $contest
     * @param \Pages $pages
     */
    public function __construct(Contest $contest, $pages)
    {
        $this->contest = $contest;
        $this->pages = $pages;
    }

    public function build($params = array())
    {
        global $DB,$_CONFIG,$site_templater;

        $currentUser = $this->contest->getAuthorizationService()->getCurrentUser();

        if($currentUser->getStatus()->isAdmin() && !empty($_GET['contest_id']) && is_numeric($_GET['contest_id'])) {
            $contestId = $this->contest->getContestService()->getContestById($_GET['contest_id']);
            if(!empty($contestId)) {

                $sendText = "Претендент успешно добавлен.";
                $buttonText = "Добавить";
                $lastName = "";
                $firstName = "";
                $thirdName = "";
                $lastNameR = "";
                $firstNameR = "";
                $thirdNameR = "";
                $changableDocuments = array();
                $documents = array();
                if(!empty($_GET['id'])) {
                    $applicant = $this->contest->getApplicantService()->getApplicantById($_GET['id']);
                    if(!empty($applicant)) {
                        $lastName = $applicant->getLastName();
                        $firstName = $applicant->getFirstName();
                        $thirdName = $applicant->getThirdName();
                        $lastNameR = $applicant->getLastNameR();
                        $firstNameR = $applicant->getFirstNameR();
                        $thirdNameR = $applicant->getThirdNameR();
                        $documents = $applicant->getDocuments();
                        $sendText = "Данные обновлены.";
                        $buttonText = "Изменить";

                        $counter = 1;
                        foreach ($applicant->getDocuments() as $k => $value) {
                            $changableDocuments[$k] = array();
                            if (!empty($value['document'])) {
                                $changableDocuments[$k]['document'] = "getDocuments&id=" . $counter . "&applicant_id=" . $_GET['id'];
                            } else {
                                $changableDocuments[$k]['document'] = "";
                            }
                            $counter++;
                        }
                    } else {
                        $this->contest->getPageBuilderManager()->setPageBuilder("error");
                        $this->contest->getPageBuilder()->build(array('error' => 'Претендент не найден'));
                        exit;
                    }
                }

                $formBuilder = new AddApplicantFormBuilder($sendText, "", "", $buttonText, false);

                $formBuilder->registerField(new \FormField("lastname", "text", true, "Фамилия", "Не введена фамилия","",false,"",$lastName));
                $formBuilder->registerField(new \FormField("firstname", "text", false, "Имя", "Не введено имя","",false,"",$firstName));
                $formBuilder->registerField(new \FormField("thirdname", "text", false, "Отчество", "Не введено отчество","",false,"",$thirdName));
                $formBuilder->registerField(new \FormField("lastname_r", "text", false, "Фамилия в род. падеже", "Не введена фамилия","",false,"",$lastNameR));
                $formBuilder->registerField(new \FormField("firstname_r", "text", false, "Имя в род. падеже", "Не введено имя","",false,"",$firstNameR));
                $formBuilder->registerField(new \FormField("thirdname_r", "text", false, "Отчество в род. падеже", "Не введено отчество","",false,"",$thirdNameR));
                $formBuilder->registerField(new \FormField("contest_id", "hidden", true, "", "","",false,"",$_GET['contest_id']));

                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                $formBuilder->registerField(new \FormField("", "header", false, "Документы"));

                $filePrefix = $_GET['contest_id'];

                $documentsComplexFields = array();
                $documentFile = new \FileField($documents,$this->contest->getDownloadService()->getDocumentsUploadPath(),array(".pdf"),10240 * 1024,$filePrefix,"pdf",$changableDocuments);
                $documentsComplexFields[] = new \FormField("document", "file", false, "Прикрепить документ (не более 10МБайт, формат: pdf)","","Выбрать файл", false,"","",array(),array(),"",array(),2,$documentFile);

                $formBuilder->registerField(new \FormField("documents", "complex-block", false, "Добавить документ","","", false,"",$documents,array(),array(),"", $documentsComplexFields));



                $posError = $formBuilder->processPostBuild();

                $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
                $this->contest->getPageBuilderManager()->setPageBuilder("top");
                $this->contest->getPageBuilder()->build(array("main_back" => true));

                ?>
                <div class="container-fluid">
                    <div class="row justify-content-start mb-3">
                        <div class="mr-3 mt-3">
                            <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=applicantsList&contest_id=<?=$_GET['contest_id']?>"
                               role="button">Вернуться к списку</a>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">

                        </div>
                    </div>
                </div>

                <?php

                if(!empty($posError)) {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        <?=$posError?>
                    </div>
                    <?php
                }

                $formBuilder->build();

                $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
            } else {
                $this->contest->getPageBuilderManager()->setPageBuilder("error");
                $this->contest->getPageBuilder()->build(array("error" => "Не найден конкурс"));
            }
        } else {
            $this->contest->getPageBuilderManager()->setPageBuilder("error");
            $this->contest->getPageBuilder()->build();
        }


    }

}