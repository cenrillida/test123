<?php

namespace AspModule\PageBuilders\Templates;

use AspModule\AspModule;
use AspModule\PageBuilders\PageBuilder;

class AdminTable implements PageBuilder {
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
        $currentUser = $this->aspModule->getCurrentUser();

        if($this->aspModule->getStatusService()->getStatusBy($currentUser->getStatus())->isAdminAllow()) {

            $applicationsYearParam = "";

            if(!empty($_GET['applications_year_id']) || $_GET['applications_year_id']==='0') {
                $applicationsYearParam = "&applications_year_id={$_GET['applications_year_id']}";
            }

            $dhtmlBuilder = new \DhtmlxBuilder("/index.php?page_id={$_REQUEST['page_id']}&mode=adminTableSource{$applicationsYearParam}","/index.php?page_id=".$_REQUEST['page_id']."&mode=adminTableUpdate", "Вы действительно хотите удалить пользователя?");

            $header = new \DhtmlxHeader();
            $header->registerField(new \DhtmlxText("<b>Таблица пользователей</b>","16"));
            $header->registerField(new \DhtmlxText("Удал."));
            //$header->registerField(new \DhtmlxContent("inputFilter"));
            $column = new \DhtmlxColumn(40,"del",$header,"","center", "button", "dxi dxi-plus");
            $dhtmlBuilder->registerColumn($column);

            $header = new \DhtmlxHeader();
            $header->registerField(new \DhtmlxText(""));
            $header->registerField(new \DhtmlxText("ФИО"));
            $header->registerField(new \DhtmlxContent("inputFilter"));
            $column = new \DhtmlxColumn("","fio",$header,"","center");
            $dhtmlBuilder->registerColumn($column);

            $header = new \DhtmlxHeader();
            $header->registerField(new \DhtmlxText(""));
            $header->registerField(new \DhtmlxText("Код"));
            $header->registerField(new \DhtmlxContent("inputFilter"));
            $column = new \DhtmlxColumn("","pension_certificate_or_special_code",$header,"","center");
            $dhtmlBuilder->registerColumn($column);

            $header = new \DhtmlxHeader();
            $header->registerField(new \DhtmlxText(""));
            $header->registerField(new \DhtmlxText("Документы поданы на"));
            $header->registerField(new \DhtmlxContent("selectFilter"));
            $column = new \DhtmlxColumn("","document_application_for",$header,"","center");
            $dhtmlBuilder->registerColumn($column);

            $header = new \DhtmlxHeader();
            $header->registerField(new \DhtmlxText(""));
            $header->registerField(new \DhtmlxText("Прием"));
            $header->registerField(new \DhtmlxContent("selectFilter"));
            $column = new \DhtmlxColumn(100,"application_year",$header,"","center");
            $dhtmlBuilder->registerColumn($column);

            $header = new \DhtmlxHeader();
            $header->registerField(new \DhtmlxText(""));
            $header->registerField(new \DhtmlxText("Группа научных специальностей"));
            $header->registerField(new \DhtmlxContent("selectFilter"));
            $column = new \DhtmlxColumn("","field_of_study",$header,"","center");
            $dhtmlBuilder->registerColumn($column);

            $header = new \DhtmlxHeader();
            $header->registerField(new \DhtmlxText(""));
            $header->registerField(new \DhtmlxText("Научная специальность"));
            $header->registerField(new \DhtmlxContent("selectFilter"));
            $column = new \DhtmlxColumn("","field_of_study_profile",$header,"","center");
            $dhtmlBuilder->registerColumn($column);

            $header = new \DhtmlxHeader();
            $header->registerField(new \DhtmlxText(""));
            $header->registerField(new \DhtmlxText("Статус"));
            $header->registerField(new \DhtmlxContent("selectFilter"));
            $column = new \DhtmlxColumn("","status",$header,"","center");
            $dhtmlBuilder->registerColumn($column);

            $header = new \DhtmlxHeader();
            $header->registerField(new \DhtmlxText(""));
            $header->registerField(new \DhtmlxText("Все данные"));
            $column = new \DhtmlxColumn(50,"user_data_page",$header,"","center");
            $dhtmlBuilder->registerColumn($column);

            $header = new \DhtmlxHeader();
            $header->registerField(new \DhtmlxText(""));
            $header->registerField(new \DhtmlxText("Изменить статус"));
            $column = new \DhtmlxColumn(50,"change_status",$header,"","center");
            $dhtmlBuilder->registerColumn($column);

//            $header = new \DhtmlxHeader();
//            $header->registerField(new \DhtmlxText(""));
//            $header->registerField(new \DhtmlxText("e-mail"));
//            $header->registerField(new \DhtmlxContent("inputFilter"));
//            $column = new \DhtmlxColumn(100,"email",$header,"","center");
//            $dhtmlBuilder->registerColumn($column);
//
//            $header = new \DhtmlxHeader();
//            $header->registerField(new \DhtmlxText(""));
//            $header->registerField(new \DhtmlxText("Телефон"));
//            $header->registerField(new \DhtmlxContent("inputFilter"));
//            $column = new \DhtmlxColumn(100,"phone",$header,"","center");
//            $dhtmlBuilder->registerColumn($column);

            $header = new \DhtmlxHeader();
            $header->registerField(new \DhtmlxText(""));
            $header->registerField(new \DhtmlxText("Дата отправки документов"));
            $column = new \DhtmlxColumn(150,"pdf_last_upload_date",$header,"","center","time","","%Y-%m-%d %H:%i:%s");
            $dhtmlBuilder->registerColumn($column);

            $dhtmlBuilder->build();

        } else {
            echo "Ошибка доступа.";
        }
    }
}