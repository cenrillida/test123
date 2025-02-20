<?php

namespace Crossref\PageBuilders\Templates;

use Crossref\Crossref;
use Crossref\FormBuilders\Templates\NumberCheckFormBuilder;
use Crossref\FormBuilders\Templates\PublCheckFormBuilder;
use Crossref\PageBuilders\PageBuilder;

class PublCheck implements PageBuilder {

    /** @var Crossref */
    private $crossref;
    /** @var \Pages */
    private $pages;

    /**
     * PublCheck constructor.
     * @param Crossref $crossref
     * @param \Pages $pages
     */
    public function __construct(Crossref $crossref, $pages)
    {
        $this->crossref = $crossref;
        $this->pages = $pages;
    }

    public function build($params = array())
    {
        global $DB,$_CONFIG,$site_templater;

        $publInfo = $DB->selectRow("SELECT * FROM publ WHERE id=?d",$_GET['id']);

        $isbn = "";
        $issn = "";
        if($publInfo['tip']==441) {
            $isbn = preg_replace("/[^0-9]+/i", "",$publInfo['izdat']);
        }
        if($publInfo['tip']==442) {
            $issn = preg_replace("/[^0-9]+/i", "",$publInfo['izdat']);
        }

        $doi = "10.20542/".preg_replace("/[^-0-9]+/i", "",$publInfo['izdat']);
        $resource = "https://www.imemo.ru/index.php?page_id=645&id=".$publInfo['id'];

        $titleExploded = explode("/",$publInfo['name2']);
        $titleEn = $titleExploded[0];

        $publisher = "Primakov National Research Institute of World Economy and International Relations, Russian Academy of Sciences (IMEMO), 23, Profsoyuznaya Str., Moscow, 117997, Russian Federation";

        $year = (int)$publInfo['year'];
        if($year<2015) {
            $publisher = "Institute of World Economy and International Relations, Russian Academy of Sciences (IMEMO), 23, Profsoyuznaya Str., Moscow, 117997, Russian Federation";
        }

        $bookType = array(new \OptionField("edited_book","Edited book"),new \OptionField("monograph","Monograph"),new \OptionField("reference","Reference"),new \OptionField("other","Other"));

        $abstract = preg_replace("(<.+?>)","",$publInfo['annots_en']);
        $abstract = str_replace("&nbsp;"," ",$abstract);

        $publications = new \Publications();
        $people0=$publications->getCrossrefAutorsEn($publInfo['avtor']);
        $rolesLoad = $publications->getContributorRoles();

        $roles = array();

        foreach ($rolesLoad as $role) {
            $roles[$role['id']] = $role;
        }

        $rolesSelectArr = array();
        foreach ($roles as $role) {
            $rolesSelectArr[] = new \OptionField($role['role_crossref_name'],$role['role_name']);
        }

        $formBuilder = new PublCheckFormBuilder("Данные отправлены в Crossref.","",__DIR__."/Documents/","Отправить",false);

        $sentBefore = $this->crossref->getNumberCheckService()->getSentDataByElementIdAndModule($_GET['id'],'publ');

        $formBuilder->registerField(new \FormField("", "hr", false, ""));
        $formBuilder->registerField(new \FormField("", "header", false, "Технические данные"));
        $formBuilder->registerField(new \FormField("doi_batch_id", "text", false, "ID","","",false,"",time()."-".md5("publ-".time()."-".$_GET['id'])));
        $formBuilder->registerField(new \FormField("timestamp", "text", false, "Дата и время (формат ГодМесяцДеньЧасМинута)","","",false,"",date("YmdHi")));
        $formBuilder->registerField(new \FormField("depositor_name", "text", false, "Ник отправителя","","",false,"","primakov"));
        if(!empty($sentBefore[0]['data']) && $sentBefore[0]['data']['depositor_name']!="primakov") {
            $formBuilder->registerErrorField(new \FormFieldError("depositor_name","Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['depositor_name']));
        }
        $formBuilder->registerField(new \FormField("email_address", "text", false, "Email отправителя","","",false,"","mirina@imemo.ru"));
        if(!empty($sentBefore[0]['data']) && $sentBefore[0]['data']['email_address']!="mirina@imemo.ru") {
            $formBuilder->registerErrorField(new \FormFieldError("email_address","Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['email_address']));
        }
        $formBuilder->registerField(new \FormField("registrant", "text", false, "Тип отправки","","",false,"","WEB-FORM"));
        if(!empty($sentBefore[0]['data']) && $sentBefore[0]['data']['registrant']!="WEB-FORM") {
            $formBuilder->registerErrorField(new \FormFieldError("registrant","Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['registrant']));
        }

        $formBuilder->registerField(new \FormField("", "hr", false, ""));
        $formBuilder->registerField(new \FormField("", "header", false, "Публикация"));
        $formBuilder->registerField(new \FormField("title", "text", false, "Название","","",false,"",$titleEn));
        if(!empty($sentBefore[0]['data']) && $sentBefore[0]['data']['title']!=$titleEn) {
            $formBuilder->registerErrorField(new \FormFieldError("title","Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['title']));
        }
        $formBuilder->registerField(new \FormField("original_language_title", "text", false, "Название на языке оригинала","","",false,"",$publInfo['name_title']));
        if(!empty($sentBefore[0]['data']) && $sentBefore[0]['data']['original_language_title']!=$publInfo['name_title']) {
            $formBuilder->registerErrorField(new \FormFieldError("original_language_title","Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['original_language_title']));
        }
        $formBuilder->registerField(new \FormField("isbn", "text", false, "ISBN","","",false,"",$isbn));
        if(!empty($sentBefore[0]['data']) && $sentBefore[0]['data']['isbn']!=$isbn) {
            $formBuilder->registerErrorField(new \FormFieldError("isbn","Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['isbn']));
        }
        $formBuilder->registerField(new \FormField("issn", "text", false, "ISSN","","",false,"",$issn));
        if(!empty($sentBefore[0]['data']) && $sentBefore[0]['data']['issn']!=$issn) {
            $formBuilder->registerErrorField(new \FormFieldError("issn","Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['issn']));
        }
        $formBuilder->registerField(new \FormField("year", "text", false, "Год","","",false,"",$publInfo['year']));
        if(!empty($sentBefore[0]['data']) && $sentBefore[0]['data']['year']!=$publInfo['year']) {
            $formBuilder->registerErrorField(new \FormFieldError("year","Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['year']));
        }
        $formBuilder->registerField(new \FormField("publisher", "text", false, "Издатель","","",false,"",$publisher));
        if(!empty($sentBefore[0]['data']) && $sentBefore[0]['data']['publisher']!=$publisher) {
            $formBuilder->registerErrorField(new \FormFieldError("publisher","Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['publisher']));
        }
        $formBuilder->registerField(new \FormField("doi", "text", false, "DOI","","",false,"",$doi));
        if(!empty($sentBefore[0]['data']) && $sentBefore[0]['data']['doi']!=$doi) {
            $formBuilder->registerErrorField(new \FormFieldError("doi","Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['doi']));
        }
        $formBuilder->registerField(new \FormField("resource", "text", false, "Ссылка","","",false,"",$resource));
        if(!empty($sentBefore[0]['data']) && $sentBefore[0]['data']['resource']!=$resource) {
            $formBuilder->registerErrorField(new \FormFieldError("resource","Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['resource']));
        }
        $bookTypeStr = "other";
        if($publInfo['vid']==453) {
            $bookTypeStr = "edited_book";
        }
        if($publInfo['vid']==427) {
            $bookTypeStr = "monograph";
        }
        $bookType = $formBuilder->setSelectedOptionArr($bookType,$bookTypeStr);
        $formBuilder->registerField(new \FormField("book_type", "select", false, "Тип публикации", "","",false,"","",$bookType));
        if(!empty($sentBefore[0]['data']) && $sentBefore[0]['data']['book_type']!=$bookTypeStr) {
            $formBuilder->registerErrorField(new \FormFieldError("book_type","Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['book_type']));
        }
        $formBuilder->registerField(new \FormField("abstract", "textarea", false, "Аннотация","","", false,"",$abstract,array(),array(),"col-lg-12", array(),10));

        $formBuilder->registerField(new \FormField("", "hr", false, ""));
        $formBuilder->registerField(new \FormField("", "header", false, "Авторы"));

        $contributorsRolesArray = array();
        if(!empty($publInfo['people_role'])) {
            $contributorsRolesArray = unserialize($publInfo['people_role']);
        }
        $contributorsContent = array();
        $affiliationsArray = array();
        if(!empty($publInfo['people_affiliation_en'])) {
            $affiliationsArray = unserialize($publInfo['people_affiliation_en']);
        }
        $peopleCounter = 1;
        $addedPeopleCounter = 1;
        foreach($people0 as $people)
        {
            if (!empty($people['id']))
            {
                if(substr($people['fio'],0,8)!='Редакция' &&
                    substr($people['fio'],0,8)!=false)
                {
                    $contributorElement = array();
                    if($people['full_name_echo']==1) {
                        $contributorElement['given_name'] = substr(
                            mb_stristr($people['fioshort'], " "),
                            1
                        );
                    } else {
                        $contributorElement['given_name'] = substr(
                                mb_stristr($people['fioshort'], " "),
                                1,
                                1
                            ) . ".";
                    }
                    preg_match_all('@href="([^"]+orcid.org[^"]+)"@', $people['about'], $orcidLink);
                    $orcidLink = array_pop($orcidLink);

                    if(!empty($orcidLink[0])) {
                        $orcidLink = $orcidLink[0];
                        $orcidLink = str_replace("http://","https://",$orcidLink);
                    } else {
                        $orcidLink = "";
                    }
                    $contributorElement['orcid'] = $orcidLink;

                    $contributorElement['contributor_role'] = "author";

                    if(!empty($contributorsRolesArray[$peopleCounter-1])) {
                        $contributorElement['contributor_role'] = $roles[$contributorsRolesArray[$peopleCounter-1]]['role_crossref_name'];
                    }

                    if(!empty($sentBefore[0]['data']['contributors']['contributors'.$addedPeopleCounter]) && $sentBefore[0]['data']['contributors']['contributors'.$addedPeopleCounter]['contributor_role']!=$contributorElement['contributor_role']) {
                        $formBuilder->registerErrorField(new \FormFieldError("contributor_role".$addedPeopleCounter,"Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['contributors']['contributors'.$addedPeopleCounter]['contributor_role']));
                    }

                    if(!empty($sentBefore[0]['data']['contributors']['contributors'.$addedPeopleCounter]) && $sentBefore[0]['data']['contributors']['contributors'.$addedPeopleCounter]['given_name']!=$contributorElement['given_name']) {
                        $formBuilder->registerErrorField(new \FormFieldError("given_name".$addedPeopleCounter,"Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['contributors']['contributors'.$addedPeopleCounter]['given_name']));
                    }
                    $contributorElement['surname'] = mb_stristr($people['fioshort'], " ", true);
                    if(!empty($sentBefore[0]['data']['contributors']['contributors'.$addedPeopleCounter]) && $sentBefore[0]['data']['contributors']['contributors'.$addedPeopleCounter]['surname']!=$contributorElement['surname']) {
                        $formBuilder->registerErrorField(new \FormFieldError("surname".$addedPeopleCounter,"Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['contributors']['contributors'.$addedPeopleCounter]['surname']));
                    }
                    $contributorElement['affiliations'] = array();
                    $affiliationsCounter = 1;
                    foreach ($affiliationsArray[$peopleCounter-1] as $value) {
                        $contributorElement['affiliations'][] = array("affiliation_name" => $value);
                        if(!empty($sentBefore[0]['data']['contributors']['contributors'.$addedPeopleCounter]['affiliations']['affiliations'.$affiliationsCounter]) && $sentBefore[0]['data']['contributors']['contributors'.$addedPeopleCounter]['affiliations']['affiliations'.$affiliationsCounter]['affiliation_name']!=$value) {
                            $formBuilder->registerErrorField(new \FormFieldError("contributors".$articleCount.$addedPeopleCounter."affiliation_name".$affiliationsCounter,"Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['contributors']['contributors'.$addedPeopleCounter]['affiliations']['affiliations'.$affiliationsCounter]['affiliation_name']));
                        }
                        $affiliationsCounter++;
                    }
                    //$contributorElement['affiliations'] = array(array("affiliation_name" => "123"),array("affiliation_name" => "1234"));
                    $contributorsContent[] = $contributorElement;
                    $addedPeopleCounter++;
                }
            }
            $peopleCounter++;
        }

        $affiliationComplexFields = array();
        $affiliationComplexFields[] = new \FormField("", "form-row", false, "");
        $affiliationComplexFields[] = new \FormField("affiliation_name", "text", false, "Аффилиация","","", false,"","",array(),array(),"col-lg-12");
        $affiliationComplexFields[] = new \FormField("", "form-row-end", false, "");

        $contributorsComplexFields = array();
        $contributorsComplexFields[] = new \FormField("", "form-row", false, "");
        $contributorsComplexFields[] = new \FormField("given_name", "text", false, "Имя","","", false,"","",array(),array(),"col-lg-12");
        $contributorsComplexFields[] = new \FormField("surname", "text", false, "Фамилия","","", false,"","",array(),array(),"col-lg-12");
        $contributorsComplexFields[] = new \FormField("orcid", "text", false, "ORCID","","", false,"","",array(),array(),"col-lg-12");
        $contributorsComplexFields[] = new \FormField("contributor_role", "select", false, "Роль участника","","", false,"","",$rolesSelectArr,array(),"col-lg-12");
        $contributorsComplexFields[] = new \FormField("", "header-text", false, "Аффилиация: ", "","", false,"","",array(),array(),"col-lg-1");
        $contributorsComplexFields[] = new \FormField("affiliations", "complex-block", false, "Добавить аффилиацию","","", false,"","",array(),array(),"col-lg-11", $affiliationComplexFields);
        $contributorsComplexFields[] = new \FormField("", "form-row-end", false, "");


        $formBuilder->registerField(new \FormField("contributors", "complex-block", false, "Добавить персону","","", false,"",$contributorsContent,array(),array(),"", $contributorsComplexFields));


        $posError = $formBuilder->processPostBuild();


        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        if($this->crossref->getAuthorizationService()->isAuthorized()):
            $this->crossref->getPageBuilderManager()->setPageBuilder("top");
            $this->crossref->getPageBuilder()->build(array("main_back" => true));


            ?>

            <div class="container-fluid">
                <div class="row justify-content-start mb-3">
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=publsList"
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
        <?php endif;?>
        <?php
        if (!empty($posError)) {
            ?>
            <div class="alert alert-danger" role="alert">
                <?= $posError ?>
            </div>
            <?php
        }
        $formBuilder->build();
        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
    }

}