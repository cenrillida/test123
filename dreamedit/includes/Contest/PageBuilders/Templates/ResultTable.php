<?php

namespace Contest\PageBuilders\Templates;

use Contest\Contest;
use Contest\FormBuilders\Templates\AddContestFormBuilder;
use Contest\FormBuilders\Templates\AddOpenVoteResultFormBuilder;
use Contest\FormBuilders\Templates\AddUserFormBuilder;
use Contest\PageBuilders\PageBuilder;

class ResultTable implements PageBuilder {

    /** @var Contest */
    private $contest;
    /** @var \Pages */
    private $pages;

    /**
     * ResultTable constructor.
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

                $dhtmlBuilder = new \DhtmlxBuilder(
                        "/index.php?page_id=".$_REQUEST['page_id']."&mode=resultTableSource&contest_id=".$_GET['contest_id'],
                        "/index.php?page_id=".$_REQUEST['page_id']."&mode=resultTableSource&contest_id=".$_GET['contest_id'],
                    "Очистить результаты этого участника?"
                );

                $header = new \DhtmlxHeader();
                $header->registerField(new \DhtmlxText(""));
                $header->registerField(new \DhtmlxText("","","4", "center"));
                $header->registerField(new \DhtmlxText(""));
                $header->registerField(new \DhtmlxText(""));
                $header->registerField(new \DhtmlxText(""));
                $column = new \DhtmlxColumn(50,"del",$header,"","center");
                $dhtmlBuilder->registerColumn($column);

                $header = new \DhtmlxHeader();
                $header->registerField(new \DhtmlxText("<b>Сводный лист.</b> <a target='_blank' href='/index.php?page_id=".$_REQUEST['page_id']."&mode=resultList&contest_id=".$_GET['contest_id']."'>Выгрузка в Word</a>","32"));
                $header->registerField(new \DhtmlxText("Ф.И.О. члена Конкурсной комиссии","","3", "center"));
                $header->registerField(new \DhtmlxText(""));
                $header->registerField(new \DhtmlxText(""));
                $header->registerField(new \DhtmlxContent("inputFilter"));
                $column = new \DhtmlxColumn(200,"user_fio",$header,"","center");
                $dhtmlBuilder->registerColumn($column);

                $header = new \DhtmlxHeader();
                $header->registerField(new \DhtmlxText(""));
                $header->registerField(new \DhtmlxText("Отметка об участии","","3", "center"));
                $header->registerField(new \DhtmlxText(""));
                $header->registerField(new \DhtmlxText(""));
                $header->registerField(new \DhtmlxContent("selectFilter"));
                $column = new \DhtmlxColumn(50,"participate",$header,"","center");
                $dhtmlBuilder->registerColumn($column);

                $header = new \DhtmlxHeader();
                $header->registerField(new \DhtmlxText(""));
                $header->registerField(new \DhtmlxText("<div style='text-align: center'><img src='/images/word.svg' style='width: 25px; margin-top: 12px;' /></div>","","4", "center"));
                $header->registerField(new \DhtmlxText(""));
                $header->registerField(new \DhtmlxText(""));
                $header->registerField(new \DhtmlxText(""));
                $column = new \DhtmlxColumn(50,"user_result_list",$header,"","center");
                $dhtmlBuilder->registerColumn($column);

                $applicants = $contest->getApplicants();

                $counter = 1;
                foreach ($applicants as $applicant) {
                    $firstname = "";
                    if($applicant->getFirstName()!="") {
                        $firstname = substr($applicant->getFirstName(),0,1).".";
                    }
                    $thirdname = "";
                    if($applicant->getThirdName()!="") {
                        $thirdname = substr($applicant->getThirdName(),0,1).".";
                    }
                    $header = new \DhtmlxHeader();
                    $header->registerField(new \DhtmlxText(""));
                    if($counter==1) {
                        $header->registerField(new \DhtmlxText("Итоговая оценка члена конкурсной комиссии", count($contest->getApplicants())*4, "", "center"));
                    } else {
                        $header->registerField(new \DhtmlxText(""));
                    }

                    $header->registerField(new \DhtmlxText($applicant->getLastName()." ".$firstname." ".$thirdname, "4", "", "center"));
                    $header->registerField(new \DhtmlxText("Основные научные результаты","","","center"));
                    $column = new \DhtmlxColumn("", "applicant_".$counter."_science_results", $header, "", "center");
                    $dhtmlBuilder->registerColumn($column);

                    $header = new \DhtmlxHeader();
                    $header->registerField(new \DhtmlxText(""));
                    $header->registerField(new \DhtmlxText(""));
                    $header->registerField(new \DhtmlxText(""));
                    $header->registerField(new \DhtmlxText("Опыт и квалификация","","","center"));
                    $column = new \DhtmlxColumn("", "applicant_".$counter."_experience", $header, "", "center");
                    $dhtmlBuilder->registerColumn($column);

                    $header = new \DhtmlxHeader();
                    $header->registerField(new \DhtmlxText(""));
                    $header->registerField(new \DhtmlxText(""));
                    $header->registerField(new \DhtmlxText(""));
                    $header->registerField(new \DhtmlxText("Собеседование","","","center"));
                    $column = new \DhtmlxColumn("", "applicant_".$counter."_interview", $header, "", "center");
                    $dhtmlBuilder->registerColumn($column);

                    $header = new \DhtmlxHeader();
                    $header->registerField(new \DhtmlxText(""));
                    $header->registerField(new \DhtmlxText(""));
                    $header->registerField(new \DhtmlxText(""));
                    $header->registerField(new \DhtmlxText("Итоговая оценка","","","center"));
                    $column = new \DhtmlxColumn("", "applicant_".$counter."_total", $header, "", "center");
                    $dhtmlBuilder->registerColumn($column);

                    $counter++;
                }


                $dhtmlBuilder->build();
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