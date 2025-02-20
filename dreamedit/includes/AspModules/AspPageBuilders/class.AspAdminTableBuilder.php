<?php

class AspAdminTablePageBuilder implements AspPageBuilder {
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
        $currentUser = $this->aspModule->getCurrentUser();

        if($this->aspModule->getAspStatusManager()->getStatusBy($currentUser->getStatus())->isAdminAllow()) {
            $dhtmlBuilder = new DhtmlxBuilder("/index.php?page_id=".$_REQUEST['page_id']."&mode=adminTableSource","/index.php?page_id=".$_REQUEST['page_id']."&mode=adminTableUpdate");

            $header = new DhtmlxHeader();
            $header->registerField(new DhtmlxText("<b>Таблица пользователей</b>","16"));
            $header->registerField(new DhtmlxText("ФИО"));
            $header->registerField(new DhtmlxContent("inputFilter"));
            $column = new DhtmlxColumn("","fio",$header,"","center");
            $dhtmlBuilder->registerColumn($column);

            $header = new DhtmlxHeader();
            $header->registerField(new DhtmlxText(""));
            $header->registerField(new DhtmlxText("Направление"));
            $header->registerField(new DhtmlxContent("selectFilter"));
            $column = new DhtmlxColumn("","field_of_study",$header,"","center");
            $dhtmlBuilder->registerColumn($column);

            $header = new DhtmlxHeader();
            $header->registerField(new DhtmlxText(""));
            $header->registerField(new DhtmlxText("Профиль"));
            $header->registerField(new DhtmlxContent("selectFilter"));
            $column = new DhtmlxColumn("","field_of_study_profile",$header,"","center");
            $dhtmlBuilder->registerColumn($column);

            $header = new DhtmlxHeader();
            $header->registerField(new DhtmlxText(""));
            $header->registerField(new DhtmlxText("Статус"));
            $header->registerField(new DhtmlxContent("selectFilter"));
            $column = new DhtmlxColumn("","status",$header,"","center");
            $dhtmlBuilder->registerColumn($column);

            $header = new DhtmlxHeader();
            $header->registerField(new DhtmlxText(""));
            $header->registerField(new DhtmlxText("Все данные"));
            $column = new DhtmlxColumn(50,"user_data_page",$header,"","center");
            $dhtmlBuilder->registerColumn($column);

            $header = new DhtmlxHeader();
            $header->registerField(new DhtmlxText(""));
            $header->registerField(new DhtmlxText("Изменить статус"));
            $column = new DhtmlxColumn(50,"change_status",$header,"","center");
            $dhtmlBuilder->registerColumn($column);

//            $header = new DhtmlxHeader();
//            $header->registerField(new DhtmlxText(""));
//            $header->registerField(new DhtmlxText("e-mail"));
//            $header->registerField(new DhtmlxContent("inputFilter"));
//            $column = new DhtmlxColumn(100,"email",$header,"","center");
//            $dhtmlBuilder->registerColumn($column);
//
//            $header = new DhtmlxHeader();
//            $header->registerField(new DhtmlxText(""));
//            $header->registerField(new DhtmlxText("Телефон"));
//            $header->registerField(new DhtmlxContent("inputFilter"));
//            $column = new DhtmlxColumn(100,"phone",$header,"","center");
//            $dhtmlBuilder->registerColumn($column);

            $header = new DhtmlxHeader();
            $header->registerField(new DhtmlxText(""));
            $header->registerField(new DhtmlxText("Дата отправки документов"));
            $column = new DhtmlxColumn(150,"pdf_last_upload_date",$header,"","center","time","","%Y-%m-%d %H:%i:%s");
            $dhtmlBuilder->registerColumn($column);

            $dhtmlBuilder->build();

        } else {
            echo "Ошибка доступа.";
        }
    }
}