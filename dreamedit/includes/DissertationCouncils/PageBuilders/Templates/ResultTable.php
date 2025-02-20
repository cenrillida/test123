<?php

namespace DissertationCouncils\PageBuilders\Templates;

use DissertationCouncils\DissertationCouncils;
use DissertationCouncils\PageBuilders\PageBuilder;

class ResultTable implements PageBuilder {

    /** @var DissertationCouncils */
    private $dissertationCouncils;
    /** @var \Pages */
    private $pages;

    /**
     * ResultTable constructor.
     * @param DissertationCouncils $dissertationCouncils
     * @param \Pages $pages
     */
    public function __construct(DissertationCouncils $dissertationCouncils, $pages)
    {
        $this->dissertationCouncils = $dissertationCouncils;
        $this->pages = $pages;
    }

    public function build($params = array())
    {
        global $DB,$_CONFIG,$site_templater;

        $currentUser = $this->dissertationCouncils->getAuthorizationService()->getCurrentUser();

        if($currentUser->getStatus()->isAdmin() && !empty($_GET['vote_id']) && is_numeric($_GET['vote_id'])) {
            $vote = $this->dissertationCouncils->getVoteService()->getVoteById($_GET['vote_id']);
            if(!empty($vote)) {

                $dhtmlBuilder = new \DhtmlxBuilder(
                        "/index.php?page_id=".$_REQUEST['page_id']."&mode=resultTableSource&vote_id=".$_GET['vote_id'],
                        "/index.php?page_id=".$_REQUEST['page_id']."&mode=resultTableSource&vote_id=".$_GET['vote_id'],
                    "Очистить результаты этого участника?"
                );

                $header = new \DhtmlxHeader();
                $header->registerField(new \DhtmlxText(""));
                $header->registerField(new \DhtmlxText("","","2", "center"));
                $header->registerField(new \DhtmlxText(""));
                $column = new \DhtmlxColumn(50,"del",$header,"","center");
                $dhtmlBuilder->registerColumn($column);

                $header = new \DhtmlxHeader();
                $header->registerField(new \DhtmlxText("<b>Сводный лист.</b> <a target='_blank' href='/index.php?page_id=".$_REQUEST['page_id']."&mode=resultList&vote_id=".$_GET['contest_id']."'>Выгрузка в Word</a>","32"));
                $header->registerField(new \DhtmlxText("Ф.И.О. участника","","1", "center"));
                $header->registerField(new \DhtmlxContent("inputFilter"));
                $column = new \DhtmlxColumn(300,"user_fio",$header,"","center");
                $dhtmlBuilder->registerColumn($column);

                $header = new \DhtmlxHeader();
                $header->registerField(new \DhtmlxText(""));
                $header->registerField(new \DhtmlxText("Отметка об участии","","1", "center"));
                $header->registerField(new \DhtmlxContent("selectFilter"));
                $column = new \DhtmlxColumn(150,"participate",$header,"","center");
                $dhtmlBuilder->registerColumn($column);

                $header = new \DhtmlxHeader();
                $header->registerField(new \DhtmlxText(""));
                $header->registerField(new \DhtmlxText("<div style='text-align: center'><img src='/images/word.svg' style='width: 25px; margin-top: 12px;' /></div>","","2", "center"));
                $header->registerField(new \DhtmlxText(""));
                $column = new \DhtmlxColumn(50,"user_result_list",$header,"","center");
                $dhtmlBuilder->registerColumn($column);

                $header = new \DhtmlxHeader();
                $header->registerField(new \DhtmlxText(""));
                $header->registerField(new \DhtmlxText("Результат","","1", "center"));
                $header->registerField(new \DhtmlxContent("selectFilter"));
                $column = new \DhtmlxColumn("","result",$header,"","center");
                $dhtmlBuilder->registerColumn($column);


                $dhtmlBuilder->build();
            } else {
                $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("error");
                $this->dissertationCouncils->getPageBuilder()->build(array("error" => "Не найдено голосование"));
            }
        } else {
            $this->dissertationCouncils->getPageBuilderManager()->setPageBuilder("error");
            $this->dissertationCouncils->getPageBuilder()->build();
        }


    }

}