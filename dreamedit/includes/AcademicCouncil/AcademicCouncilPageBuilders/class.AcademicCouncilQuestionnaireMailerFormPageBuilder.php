<?php

class AcademicCouncilQuestionnaireMailerFormPageBuilder implements AcademicCouncilPageBuilder {
    /** @var AcademicCouncilModule */
    private $academicCouncilModule;
    /** @var Pages */
    private $pages;

    public function __construct($academicCouncilModule,$pages)
    {
        $this->academicCouncilModule = $academicCouncilModule;
        $this->pages = $pages;
    }

    public function build()
    {
        global $DB,$_CONFIG,$site_templater;

        if($this->academicCouncilModule->getAcademicCouncilAuthorizationService()->isAuthorized()) {

            $questionnaire = $this->academicCouncilModule->getAcademicCouncilQuestionnaireService()->getQuestionnaireById($_GET['id']);
            if(!empty($questionnaire)) {
                if ($_SESSION[lang] != "/en") {
                    $formBuilder = new AcademicCouncilQuestionnaireMailerFormBuilder("������ ����������.", "", "", "���������");
                    $questionnairePageId = $this->pages->getFirstPageIdByTemplate("ac_questionnaire");
                    foreach ($questionnaire->getMembers() as $member) {
                        $formBuilder->registerField(new FormField("", "header", false, $member->getLastName()." ".$member->getFirstName()." ".$member->getThirdName()));
                        $formBuilder->registerField(new FormField("", "header-text", false, "<a target=\"_blank\" href=\"https://www.imemo.ru/index.php?page_id=".$questionnairePageId."&code=".$member->getCode()."&questionnaire_id=".$questionnaire->getId()."\">������ ������</a>"));
                        $formBuilder->registerField(new FormField("", "form-row", false, ""));
                        $fioField = new FormField("fio-".$member->getUserId(), "text", true, "���", "�� ������� ���", "", false, "", $member->getLastName()." ".$member->getFirstName()." ".$member->getThirdName(),array(),array(),"col-lg-6");
                        $fioField->setReadOnly(true);
                        $formBuilder->registerField($fioField);
                        $formBuilder->registerField(new FormField("mail-".$member->getUserId(), "text", true, "E-mail", "�� ������� �����", "", false, "�������� �����", $member->getEmail(),array(),array(),"col-lg-6"));
                        $formBuilder->registerField(new FormField("", "form-row-end", false, ""));
                    }

                    $formBuilder->registerField(new FormField("", "hr", false, ""));
                    $formBuilder->registerField(new FormField("mail_subject", "text", true, "���� ���������", "�� ������� ���� ���������",""));
                    $formBuilder->registerField(new FormField("", "header-text", false, "{FIO} � {LINK} - ��� ������������. �� �� ������ ������������� ���������� ������ ��� � ������."));
                    $formBuilder->registerField(new FormField("mail_text", "textarea", true, "����� ���������", "","", false, "","������������, {FIO}!\n\n������ ��� ����������� ������: {LINK}\n\n� ���������,\n����� ���.",array(),array(),"",array(),10));
                    $formBuilder->registerField(new FormField("", "hr", false, ""));
                    $formBuilder->registerField(new FormField("", "header-text", false, "���������� �����"));

                    $attachmentsComplexFields = array();
                    $attachmentsFile = new FileField(array(),__DIR__."/../Documents/Uploads/",array(),10240 * 1024,"","");
                    $attachmentsComplexFields[] = new FormField("attachment", "file", false, "���������� ���� (�� ����� 10�����)","","������� ����", false,"","",array(),array(),"",array(),2,$attachmentsFile);

                    $formBuilder->registerField(new FormField("attachments", "complex-block", false, "�������� ����","","", false,"","",array(),array(),"", $attachmentsComplexFields));



                    $posError = $formBuilder->processPostBuild();

                }
            }

            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "top.text.html");

            $exitPageId = $this->pages->getFirstPageIdByTemplate("ac_lk_login");
            ?>
            <div class="container-fluid">
                <div class="row justify-content-between mb-3">
                    <div>
                        <?php if(!empty($_GET['mode'])):?>
                            <div class="mr-3 mt-3">
                                <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>"
                                   role="button">��������� � ������ �������</a>
                            </div>
                        <?php endif;?>
                    </div>
                    <div class="row justify-content-end">
                        <div class="mt-3 pl-2 pr-2">
                            <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$exitPageId?>&logout=1"
                               role="button">�����</a>
                        </div>
                    </div>
                </div>
            </div>

            <?php

            if (!empty($posError)) {
                ?>
                <div class="alert alert-danger" role="alert">
                    <?= $posError ?>
                </div>
                <?php
            }
            if(!empty($questionnaire)) {
                $formBuilder->build();
            } else {
                echo "������ �������";
            }

            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "bottom.text.html");
        } else {
            echo "������ �������";
        }
    }

}