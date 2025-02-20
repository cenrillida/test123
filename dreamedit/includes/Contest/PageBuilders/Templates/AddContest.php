<?php

namespace Contest\PageBuilders\Templates;

use Contest\Contest;
use Contest\FormBuilders\Templates\AddContestFormBuilder;
use Contest\FormBuilders\Templates\AddUserFormBuilder;
use Contest\PageBuilders\PageBuilder;

class AddContest implements PageBuilder {

    /** @var Contest */
    private $contest;
    /** @var \Pages */
    private $pages;

    /**
     * AddContest constructor.
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





        if($currentUser->getStatus()->isAdmin()) {

            $userSelectArr = array();
            $userSelectArr[] = new \OptionField("", "");

            $contractTermSelectArr = array();
            $contractTermSelectArr[] = new \OptionField("", "");
            $contractTermSelectArr[] = new \OptionField("срочный трудовой договор до 1 года", "Срочный трудовой договор до 1 года");
            $contractTermSelectArr[] = new \OptionField("срочный трудовой договор до 3 лет", "Срочный трудовой договор до 3 лет");
            $contractTermSelectArr[] = new \OptionField("срочный трудовой договор до 5 лет", "Срочный трудовой договор до 5 лет");
            $contractTermSelectArr[] = new \OptionField("трудовой договор на неопределенный срок", "Трудовой договор на неопределенный срок");
            $contractTermSelectArr[] = new \OptionField("срочный трудовой договор до истечения срока полномочий директора", "Срочный трудовой договор до истечения срока полномочий директора");


            $sendText = "Конкурс успешно добавлен.";
            $buttonText = "Добавить";
            $date = "";
            $position = "";
            $positionR = "";
            $protocol = "";
            $contestGroupId = $_GET['contest_group_id'];
            $isOnlineVote = true;
            $chairman = "";
            $viceChairman = "";
            $secretary = "";
            $contractTerm = "";
            if(!empty($_GET['id'])) {
                $contest = $this->contest->getContestService()->getContestById($_GET['id']);
                if(!empty($contest)) {
                    $date = $contest->getDate();
                    $position = $contest->getPosition();
                    $positionR = $contest->getPositionR();
                    $protocol = $contest->getProtocol();
                    $sendText = "Данные обновлены.";
                    $buttonText = "Изменить";
                    $contestGroupId = $contest->getContestGroupId();
                    $isOnlineVote = $contest->isOnlineVote();
                    $contractTerm = $contest->getContractTerm();
                    if($contest->getChairman() !== null) {
                        $chairman = $contest->getChairman()->getId();
                    }
                    if($contest->getViceChairman() !== null) {
                        $viceChairman = $contest->getViceChairman()->getId();
                    }
                    if($contest->getSecretary() !== null) {
                        $secretary = $contest->getSecretary()->getId();
                    }
                } else {
                    $this->contest->getPageBuilderManager()->setPageBuilder("error");
                    $this->contest->getPageBuilder()->build(array('error' => 'Конкурс не найден'));
                    exit;
                }
            }

            if(!empty($contestGroupId) && is_numeric($contestGroupId)) {
                $contestGroup = $this->contest->getContestGroupService()->getContestGroupById($contestGroupId);
            }

            if(!empty($contestGroup)) {

                foreach ($contestGroup->getParticipants() as $user) {
                    $userSelectArr[] = new \OptionField($user->getId(), $user->getLastName()." ".$user->getFirstName()." ".$user->getThirdName());
                }

                $formBuilder = new AddContestFormBuilder($sendText, "", "", $buttonText, false);

                if(!empty($_GET['id'])) {
                    $formBuilder->registerField(new \FormField("position", "text", true, "Вакантная должность", "Не введена должность", "", false, "", $position));
                    $formBuilder->registerField(new \FormField("position_r", "text", true, "Вакантная должность (в род. падеже)", "Не введена должность в род. падеже", "", false, "", $positionR));
                } else {
                    $positionSelectArr = array();
                    $positionSelectArr[] = new \OptionField("", "");
                    foreach ($this->contest->getPositionService()->getAllPositions() as $positionEl) {
                        $positionSelectArr[] = new \OptionField($positionEl->getId(), $positionEl->getTitle());
                    }
                    $departmentSelectArr = array();
                    $departmentSelectArr[] = new \OptionField("", "");
                    foreach ($this->contest->getDepartmentService()->getAllDepartments() as $departmentEl) {
                        $departmentSelectArr[] = new \OptionField($departmentEl->getId(), $departmentEl->getTitle());
                    }
                    $formBuilder->registerField(new \FormField("position", "hidden", false, "", "", "", false, "", $position));
                    $formBuilder->registerField(new \FormField("position_r", "hidden", false, "", "", "", false, "", $positionR));
                    $formBuilder->registerField(new \FormField("position_select", "select", false, "Вакантная должность", "", "", false, "", "",$positionSelectArr));
                    $formBuilder->registerField(new \FormField("department_select", "select", false, "Подразделение", "", "", false, "", "",$departmentSelectArr));
                }
                $formBuilder->registerField(new \FormField("protocol", "text", false, "Протокол", "","",false,"",$protocol));
                $formBuilder->registerField(new \FormField("contract_term", "select", false, "Срок трудового договора", "", "", false, "", $contractTerm,$contractTermSelectArr));
                $formBuilder->registerField(new \FormField("", "form-row", false, ""));
                $formBuilder->registerField(new \FormField("chairman_id", "select", false, "Председатель", "", "0", false, "", $chairman, $userSelectArr, array(), "col-lg-4"));
                $formBuilder->registerField(new \FormField("vice_chairman_id", "select", false, "Заместитель председателя", "", "0", false, "", $viceChairman, $userSelectArr, array(), "col-lg-4"));
                $formBuilder->registerField(new \FormField("secretary_id", "select", false, "Секретарь", "", "0", false, "", $secretary, $userSelectArr, array(), "col-lg-4"));
                $formBuilder->registerField(new \FormField("", "form-row-end", false, ""));
                $formBuilder->registerField(new \FormField("date", "date", true, "Дата", "Не введена дата","",false,"",$date));
                $formBuilder->registerField(new \FormField("contest_group_id", "hidden", true, "", "","",false,"",$contestGroupId));
                $formBuilder->registerField(new \FormField("online_vote", "checkbox", false, "Онлайн голосование", "","",false,"",$isOnlineVote,array(),array()));
                $posError = $formBuilder->processPostBuild();

                $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
                $this->contest->getPageBuilderManager()->setPageBuilder("top");
                $this->contest->getPageBuilder()->build(array("main_back" => true));

                ?>
                <div class="container-fluid">
                    <div class="row justify-content-start mb-3">
                        <div class="mr-3 mt-3">
                            <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=contestsList&contest_group_id=<?= $contestGroupId ?>"
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
                $this->contest->getPageBuilder()->build(array("error" => "Не найдена группа конкурсов"));
            }
        } else {
            $this->contest->getPageBuilderManager()->setPageBuilder("error");
            $this->contest->getPageBuilder()->build();
        }


    }

}