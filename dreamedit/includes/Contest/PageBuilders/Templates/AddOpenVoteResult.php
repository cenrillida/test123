<?php

namespace Contest\PageBuilders\Templates;

use Contest\Contest;
use Contest\FormBuilders\Templates\AddContestFormBuilder;
use Contest\FormBuilders\Templates\AddOpenVoteResultFormBuilder;
use Contest\FormBuilders\Templates\AddUserFormBuilder;
use Contest\Models\Applicant;
use Contest\Models\OpenVoteResult;
use Contest\PageBuilders\PageBuilder;

class AddOpenVoteResult implements PageBuilder {

    /** @var Contest */
    private $contest;
    /** @var \Pages */
    private $pages;

    /**
     * AddOpenVoteResult constructor.
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
            $contest = $this->contest->getContestService()->getContestById($_GET['contest_id']);
            if(!empty($contest)) {
                if(!$contest->isOnlineVote()) {

                    $applicantSelectArr = array();
                    $applicantSelectArr[] = new \OptionField("", "");
                    foreach ($contest->getApplicants() as $applicant) {
                        $applicantSelectArr[] = new \OptionField($applicant->getId(), $applicant->getLastName() . " " . $applicant->getFirstName() . " " . $applicant->getThirdName());
                    }


                    $sendText = "Результат успешно установлен.";
                    $buttonText = "Установить результат";
                    $openVoteResult = $this->contest->getOpenVoteService()->getAllOpenVoteResultsByContestId($contest->getId());
                    $numberOfPeoplePresented = $contest->getNumberOfPeoplePresented();
                    $firstPlace = "";
                    $secondPlace = "";
                    if ($contest->getFirstPlace() != null) {
                        $firstPlace = $contest->getFirstPlace()->getId();
                    }
                    if ($contest->getSecondPlace() != null) {
                        $secondPlace = $contest->getSecondPlace()->getId();
                    }

                    $formBuilder = new AddOpenVoteResultFormBuilder($sendText, "", "", $buttonText, false);

                    $formBuilder->registerField(new \FormField("number_of_people_presented", "text", false, "Количество присутствующих", "", "", false, "", $numberOfPeoplePresented));
                    $formBuilder->registerField(new \FormField("first_place", "select", false, "Выбор 1-ого места", "", "", false, "", $firstPlace, $applicantSelectArr));

                    $formBuilder->registerField(new \FormField("", "header", false, "Голосование:"));
                    $counter = 1;
                    foreach ($contest->getApplicants() as $applicant) {

                        $for = "0";
                        $against = "0";
                        $abstained = "0";

                        if (!empty($openVoteResult)) {
                            $resultByUserArray = array_filter(
                                $openVoteResult,
                                function (OpenVoteResult $e) use (&$applicant) {
                                    return $e->getApplicant()->getId() == $applicant->getId();
                                }
                            );
                            $result = array_shift($resultByUserArray);

                            if (!empty($result)) {
                                $for = $result->getFor();
                                $against = $result->getAgainst();
                                $abstained = $result->getAbstained();
                            }
                        }


                        $formBuilder->registerField(new \FormField("", "hr", false, ""));
                        $formBuilder->registerField(new \FormField("", "header", false, "Претендент №" . $counter));
                        $formBuilder->registerField(new \FormField("", "header-text", false, "Ф.И.О.: " . $applicant->getLastName() . " " . $applicant->getFirstName() . " " . $applicant->getThirdName()));
                        $formBuilder->registerField(new \FormField("", "form-row", false, ""));
                        $formBuilder->registerField(new \FormField($applicant->getId() . "__for", "text", false, "За", "", "0", false, "", $for, array(), array(), "col-lg-4"));
                        $formBuilder->registerField(new \FormField($applicant->getId() . "__against", "text", false, "Против", "", "0", false, "", $against, array(), array(), "col-lg-4"));
                        $formBuilder->registerField(new \FormField($applicant->getId() . "__abstained", "text", false, "Воздержались", "", "", false, "", $abstained, array(), array(), "col-lg-4"));
                        $formBuilder->registerField(new \FormField("", "form-row-end", false, ""));

                        $counter++;
                    }

                    $posError = $formBuilder->processPostBuild();

                    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "top.text.html");
                    $this->contest->getPageBuilderManager()->setPageBuilder("top");
                    $this->contest->getPageBuilder()->build(array("main_back" => true));

                    ?>
                    <div class="container-fluid">
                        <div class="row justify-content-start mb-3">
                            <div class="mr-3 mt-3">
                                <a class="btn btn-lg imemo-button text-uppercase"
                                   href="/index.php?page_id=<?= $_REQUEST['page_id'] ?>&mode=contestsList&contest_group_id=<?= $contest->getContestGroupId() ?>"
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

                    if (!empty($posError)) {
                        ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $posError ?>
                        </div>
                        <?php
                    }

                    $formBuilder->build();

                    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "bottom.text.html");
                } else {
                    $this->contest->getPageBuilderManager()->setPageBuilder("error");
                    $this->contest->getPageBuilder()->build(array("error" => "Данный конкурс с онлайн голосованием"));
                }
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