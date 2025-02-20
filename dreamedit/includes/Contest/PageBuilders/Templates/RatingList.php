<?php

namespace Contest\PageBuilders\Templates;

use Contest\Contest;
use Contest\FormBuilders\Templates\AddOnlineVoteFormBuilder;
use Contest\FormBuilders\Templates\AddUserFormBuilder;
use Contest\Models\OnlineVoteResult;
use Contest\PageBuilders\PageBuilder;

class RatingList implements PageBuilder {

    /** @var Contest */
    private $contest;
    /** @var \Pages */
    private $pages;

    /**
     * RatingList constructor.
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

        if($currentUser->getStatus()->isCanVote() && !empty($_GET['contest_id'])) {
            $contest = $this->contest->getContestService()->getContestById($_GET['contest_id']);
            if(!empty($contest)) {
                $contestGroup = $this->contest->getContestGroupService()->getContestGroupById($contest->getContestGroupId());
                if(!empty($contestGroup)) {
                    if($contestGroup->isActive()) {
                        if (in_array($currentUser, $contestGroup->getParticipants())) {
                            $sendText = "Рейтинговый лист успешно заполнен.";
                            $buttonText = "Подтвердить";
                            $onlineVoteResult = $this->contest->getOnlineVoteService()->getAllOnlineVoteResultsByContestIdAndUserId($_GET['contest_id'], $currentUser->getId());


                            if (!$contest->isOnlineVote()) {
                                $this->contest->getPageBuilderManager()->setPageBuilder("error");
                                $this->contest->getPageBuilder()->build(array("error" => "Данный конкурс с открытым голосованием"));
                                exit;
                            }

                            $formBuilder = new AddOnlineVoteFormBuilder($sendText, "", "", $buttonText, false);

                            $formBuilder->registerField(new \FormField("", "hr", false, ""));
                            $formBuilder->registerField(new \FormField("", "header", false, "Претенденты"));

                            $scienceResultsSelectArr = array();
                            for ($i = 0; $i <= 10; $i++) {
                                $scienceResultsSelectArr[] = new \OptionField($i, $i);
                            }
                            $experienceSelectArr = array();
                            for ($i = 0; $i <= 10; $i++) {
                                $experienceSelectArr[] = new \OptionField($i, $i);
                            }
                            $interviewSelectArr = array();
                            $interviewSelectArr[] = new \OptionField("-1", "Нет");
                            for ($i = 0; $i <= 5; $i++) {
                                $interviewSelectArr[] = new \OptionField($i, $i);
                            }
                            $totalSelectArr = array();
                            for ($i = 0; $i <= 25; $i++) {
                                $totalSelectArr[] = new \OptionField($i, $i);
                            }

                            if (empty($contest)) {
                                $this->contest->getPageBuilderManager()->setPageBuilder("error");
                                $this->contest->getPageBuilder()->build(array("error" => "Не найден конкурс"));
                                exit;
                            }

                            $counter = 1;
                            foreach ($contest->getApplicants() as $applicant) {

                                $scienceResults = "0";
                                $experience = "0";
                                $total = "0";
                                $interview = "-1";
                                if (!empty($onlineVoteResult)) {
                                    $result = array_shift(array_filter(
                                        $onlineVoteResult,
                                        function (OnlineVoteResult $e) use (&$applicant) {
                                            return $e->getApplicant()->getId() == $applicant->getId();
                                        }
                                    ));

                                    if (!empty($result)) {
                                        $scienceResults = $result->getScienceResults();
                                        $experience = $result->getExperience();
                                        $total = $result->getTotal();
                                        $interview = $result->getInterview();
                                    }
                                }


                                $formBuilder->registerField(new \FormField("", "hr", false, ""));
                                $formBuilder->registerField(new \FormField("", "header", false, "Претендент №" . $counter));
                                $formBuilder->registerField(new \FormField("", "header-text", false, "Ф.И.О.: " . $applicant->getLastName() . " " . $applicant->getFirstName() . " " . $applicant->getThirdName()));
                                $formBuilder->registerField(new \FormField("", "header-text", false, "Документы: "));
                                $counterDocuments = 1;
                                foreach ($applicant->getDocuments() as $document) {
                                    $formBuilder->registerField(new \FormField("", "header-text", false, "<i class=\"fas fa-file-pdf text-danger\"></i> <a target=\"_blank\" href=\"/index.php?page_id=" . $_REQUEST['page_id'] . "&mode=getPdfFile&file=getDocuments&id=" . $counterDocuments . "&applicant_id=" . $applicant->getId() . "\" role=\"button\">Документ " . $counterDocuments . "</a>"));
                                    $counterDocuments++;
                                }
                                $formBuilder->registerField(new \FormField("", "form-row", false, ""));
                                $formBuilder->registerField(new \FormField($applicant->getId() . "__science_results", "select", false, "Основные научные результаты", "", "0", false, "", $scienceResults, $scienceResultsSelectArr, array(), "col-lg-3"));
                                $formBuilder->registerField(new \FormField($applicant->getId() . "__experience", "select", false, "Опыт и квалификация", "", "0", false, "", $experience, $experienceSelectArr, array(), "col-lg-3"));
                                $formBuilder->registerField(new \FormField($applicant->getId() . "__interview", "select", false, "Собеседование", "", "", false, "", $interview, $interviewSelectArr, array(), "col-lg-3"));
                                $totalField = new \FormField($applicant->getId() . "__total", "text", false, "Итоговая оценка", "", "0", false, "", $total, array(), array(), "col-lg-3");
                                $totalField->setReadOnly(true);
                                $formBuilder->registerField($totalField);
                                $formBuilder->registerField(new \FormField("", "form-row-end", false, ""));

                                $counter++;
                            }

                            $posError = $formBuilder->processPostBuild();

                            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "top.text.html");
                            $this->contest->getPageBuilderManager()->setPageBuilder("top");
                            $this->contest->getPageBuilder()->build(array("main_back" => true));


                            if ($currentUser->getStatus()->isAdmin()):?>
                            <div class="container-fluid">
                                <div class="row justify-content-between mb-3">
                                    <div>
                                        <div class="mr-3 mt-3">
                                            <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=contestsVoteList<?php if($contest->isOnlineVote()) echo '&onlineVote=1';?>"
                                               role="button">К списку конкурсов</a>
                                        </div>
                                    </div>
                                    <div class="row justify-content-end">
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
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

                            ?>
                            <script>
                                function setSelectSumToField(id) {
                                    let scienceResults = $('#' + id + '__science_results').val();
                                    let experience = $('#' + id + '__experience').val();
                                    let interview = $('#' + id + '__interview').val();
                                    if(interview<0) interview = 0;

                                    let total = parseInt(scienceResults)+parseInt(experience)+parseInt(interview);

                                    $('#' + id + '__total').val(total);
                                }
                            </script>
                            <?php

                            foreach ($contest->getApplicants() as $applicant) {
                                ?>
                                <script>
                                    $('#<?=$applicant->getId()?>__science_results').on('change', function (event) {
                                        setSelectSumToField(<?=$applicant->getId()?>);
                                    });
                                    $('#<?=$applicant->getId()?>__experience').on('change', function (event) {
                                        setSelectSumToField(<?=$applicant->getId()?>);
                                    });
                                    $('#<?=$applicant->getId()?>__interview').on('change', function (event) {
                                        setSelectSumToField(<?=$applicant->getId()?>);
                                    });
                                </script>
                                <?php
                            }

                            $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"] . "bottom.text.html");
                        } else {
                            $this->contest->getPageBuilderManager()->setPageBuilder("error");
                            $this->contest->getPageBuilder()->build();
                        }
                    } else {
                        $this->contest->getPageBuilderManager()->setPageBuilder("error");
                        $this->contest->getPageBuilder()->build(array("error" => "Голосование закончилось"));
                    }
                } else {
                    $this->contest->getPageBuilderManager()->setPageBuilder("error");
                    $this->contest->getPageBuilder()->build(array("error" => "Не найден конкурс"));
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