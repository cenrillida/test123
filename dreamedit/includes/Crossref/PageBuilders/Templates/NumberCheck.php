<?php

namespace Crossref\PageBuilders\Templates;

use Crossref\Crossref;
use Crossref\FormBuilders\Templates\NumberCheckFormBuilder;
use Crossref\PageBuilders\PageBuilder;

class NumberCheck implements PageBuilder {

    /** @var Crossref */
    private $crossref;
    /** @var \Pages */
    private $pages;

    /**
     * NumberCheck constructor.
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
        global $DB,$DB_AFJOURNAL,$_CONFIG,$site_templater;

        $mz = new \MagazineNew();

        if($_GET['ap']!=1) {


            $rows=$mz->getMagazineNumberEn($_GET['id']);
            $rows=$mz->appendContentArticle($rows);

            $numberContent = $mz->getArticleById($_GET['id']);
            $numberContent[0]['content'] = $mz->getArticleContentByPageId($_GET['id']);
            $journalInfo = $this->pages->getContentByPageId($numberContent[0]['journal_new']);

            $vol_pos = strripos($numberContent[0]['page_name'], "т.");
            $comma = strripos($numberContent[0]['page_name'], ",");

            if ($comma !== false) {
                $issue = substr($numberContent[0]['page_name'], 0, $comma);
            } else {
                $issue = $numberContent[0]['page_name'];
            }
            $doiNumber = $numberContent[0]['content']['DOI_NUMBER'];
            if($journalInfo['CROSSREF_PDF']==1) {
                $linkRegex = array();

                preg_match_all("/<a\s+(?:[^>]*?\s+)?href=['\"]([^\"^']*)['\"][^>]*>([^<]+)<\/a>/i",$numberContent[0]['content']['FULL_TEXT'],$linkRegex);

                $link = $linkRegex[1][0];

                if(!empty($link)) {
                    $link = str_replace("https://www.imemo.ru","",$link);
                    $link = str_replace("http://www.imemo.ru","",$link);
                    $doiNumberLink = "https://www.imemo.ru".$link;
                } else {
                    $doiNumberLink = "https://www.imemo.ru/index.php?page_id=".$journalInfo["ARCHIVE_ID"]."&article_id=".$_GET['id'];
                }

            } else {
                $langPrefix = "";
                if($journalInfo['CROSSREF_EN']==1) {
                    $langPrefix = "/en";
                }
                $doiNumberLink = "https://www.imemo.ru".$langPrefix."/index.php?page_id=".$journalInfo["ARCHIVE_ID"]."&article_id=".$_GET['id'];
            }


            $sentBefore = $this->crossref->getNumberCheckService()->getSentDataByElementIdAndModule($_GET['id'],'journal');
        } else {
            $journalInfo = array(
              "PAGE_MENUNAME_EN" => "Analysis and Forecasting. IMEMO Journal",
                "CROSSREF_ABBREV" => "AFIJ",
                "CROSSREF_ISSN_ELECTRONIC" => "2713170X",
                "CROSSREF_ISSN_DOI" => "afij",
            );
            $numberAfjournal = $DB_AFJOURNAL->selectRow(
                    "SELECT ap.page_name AS number,y.page_name AS 'year' FROM adm_pages AS ap 
                      INNER JOIN adm_pages AS y ON y.page_id=ap.page_parent
                      WHERE ap.page_id=?d AND ap.page_template='number'",
                    $_GET['id']
            );
            $vol_pos = strripos($numberAfjournal['number'], "т.");
            $comma = strripos($numberAfjournal['number'], ",");

            if ($comma !== false) {
                $issue = substr($numberAfjournal['number'], 0, $comma);
            } else {
                $issue = $numberAfjournal['number'];
            }
            $numberContent = array(
              0 => array(
                      "year" => $numberAfjournal['year'],
                        "page_name" => $numberAfjournal['number']
              )
            );

            $articlesAfjournal = $DB_AFJOURNAL->select(
                    "SELECT 
                      ar.page_id,
                      ar.page_template,
                      ar.people_affiliation_en,
                      t.cv_text AS 'title',
                      te.cv_text AS 'title_en',
                      p.cv_text AS 'people',
                      pc.cv_text AS 'pages',
                      pdf.cv_text AS 'pdf_link',
                      doi.cv_text AS 'doi',
                      ane.cv_text AS 'annots_en',
                      cit.cv_text AS 'references_en'
                      FROM adm_pages AS ap 
                      INNER JOIN adm_pages AS r ON r.page_parent=ap.page_id
                      INNER JOIN adm_pages AS ar ON ar.page_parent=r.page_id
                      INNER JOIN adm_pages_content AS t ON t.page_id=ar.page_id AND t.cv_name='TITLE'
                      INNER JOIN adm_pages_content AS te ON te.page_id=ar.page_id AND te.cv_name='TITLE_EN'
                      INNER JOIN adm_pages_content AS p ON p.page_id=ar.page_id AND p.cv_name='PEOPLE'
                      INNER JOIN adm_pages_content AS pc ON pc.page_id=ar.page_id AND pc.cv_name='PAGES'
                      INNER JOIN adm_pages_content AS pdf ON pdf.page_id=ar.page_id AND pdf.cv_name='LINK_PDF'
                      INNER JOIN adm_pages_content AS doi ON doi.page_id=ar.page_id AND doi.cv_name='DOI'
                      INNER JOIN adm_pages_content AS ane ON ane.page_id=ar.page_id AND ane.cv_name='ANNOTS_EN'
                      INNER JOIN adm_pages_content AS cit ON cit.page_id=ar.page_id AND cit.cv_name='REFERENCES'
                      WHERE ap.page_id=?d AND r.page_template='rubric' AND ar.page_template='article' AND ap.page_template='number'
                      ORDER BY r.page_position ASC,ar.page_position ASC,t.cv_text ASC",
                    $_GET['id']
            );

            $rows = array();

            foreach ($articlesAfjournal as $item) {
                $articleArrayItem = array();
                $articleArrayItem['page_template'] = "jarticle";
                $articleArrayItem['people_affiliation_en'] = $item['people_affiliation_en'];
                $articleArrayItem['page_id'] = $item['page_id'];
                $articleArrayItem['name'] = $item['title'];
                $articleArrayItem['name_en'] = $item['title_en'];
                $articleArrayItem['doi'] = $item['doi'];
                $articleArrayItem['people'] = $item['people'];
                $articleArrayItem['pages'] = $item['pages'];
                $articleArrayItem['annots_en'] = $item['annots_en'];
                $articleArrayItem['afjournal_pdf'] = $item['pdf_link'];
                $articleArrayItem['references_en'] = $item['references_en'];
                $rows[] = $articleArrayItem;
            }

            $sentBefore = $this->crossref->getNumberCheckService()->getSentDataByElementIdAndModule($_GET['id'],'afjournal');
            $doiNumber = '';
            $doiNumberLink = '';
        }


        $issue = preg_replace("/\(.+\)/i","",$issue);
        $issue = str_replace(" ","",$issue);
        if(!is_numeric($issue)) {

            if(\RomanNumber::IsRomanNumber($issue)) {
                $issue = \RomanNumber::Roman2Int($issue);
            } else {
                $issue = preg_replace("/[^-0-9]+/i", "",$issue);
            }
        }
        $doiIssue = str_replace("-","/",$issue);

        $formBuilder = new NumberCheckFormBuilder("Данные отправлены в Crossref.","",__DIR__."/Documents/","Отправить", false);



        $formBuilder->registerField(new \FormField("", "hr", false, ""));
        $formBuilder->registerField(new \FormField("", "header", false, "Технические данные"));
        $formBuilder->registerField(new \FormField("doi_batch_id", "text", false, "ID","","",false,"",time()."-".md5($journalInfo['CROSSREF_ABBREV']."-".time()."-".$_GET['id'])));
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
        $formBuilder->registerField(new \FormField("", "header", false, "Журнал"));
        $formBuilder->registerField(new \FormField("full_title", "text", false, "Название","","",false,"",$journalInfo['PAGE_MENUNAME_EN']));
        if(!empty($sentBefore[0]['data']) && $sentBefore[0]['data']['full_title']!=$journalInfo['PAGE_MENUNAME_EN']) {
            $formBuilder->registerErrorField(new \FormFieldError("full_title","Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['full_title']));
        }
        $formBuilder->registerField(new \FormField("abbrev_title", "text", false, "Аббревиатура","","",false,"",$journalInfo['CROSSREF_ABBREV']));
        if(!empty($sentBefore[0]['data']) && $sentBefore[0]['data']['abbrev_title']!=$journalInfo['CROSSREF_ABBREV']) {
            $formBuilder->registerErrorField(new \FormFieldError("abbrev_title","Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['abbrev_title']));
        }
        $formBuilder->registerField(new \FormField("issn", "text", false, "ISSN печатный","","",false,"",$journalInfo['CROSSREF_ISSN']));
        if(!empty($sentBefore[0]['data']) && $sentBefore[0]['data']['issn']!=$journalInfo['CROSSREF_ISSN']) {
            $formBuilder->registerErrorField(new \FormFieldError("issn","Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['issn']));
        }
        $formBuilder->registerField(new \FormField("issn_electronic", "text", false, "ISSN электронный","","",false,"",$journalInfo['CROSSREF_ISSN_ELECTRONIC']));
        if(!empty($sentBefore[0]['data']) && $sentBefore[0]['data']['issn_electronic']!=$journalInfo['CROSSREF_ISSN_ELECTRONIC']) {
            $formBuilder->registerErrorField(new \FormFieldError("issn_electronic","Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['issn_electronic']));
        }

        $volString = "";
        $volume = "";
        if ($vol_pos !== false) {
            $volString = "-".substr($numberContent[0]['page_name'], $vol_pos+3);
            $volume = substr($numberContent[0]['page_name'], $vol_pos+3);
        }

        $formBuilder->registerField(new \FormField("", "hr", false, ""));
        $formBuilder->registerField(new \FormField("", "header", false, "Номер журнала"));
        $formBuilder->registerField(new \FormField("year", "text", false, "Год","","",false,"",$numberContent[0]['year']));
        if(!empty($sentBefore[0]['data']) && $sentBefore[0]['data']['year']!=$numberContent[0]['year']) {
            $formBuilder->registerErrorField(new \FormFieldError("year","Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['year']));
        }
        $formBuilder->registerField(new \FormField("volume", "text", false, "Том","","",false,"",$volume));
        if(!empty($sentBefore[0]['data']) && $sentBefore[0]['data']['volume']!=$volume) {
            $formBuilder->registerErrorField(new \FormFieldError("volume","Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['volume']));
        }
        $formBuilder->registerField(new \FormField("issue", "text", false, "Номер","","",false,"",$issue));
        if(!empty($sentBefore[0]['data']) && $sentBefore[0]['data']['issue']!=$issue) {
            $formBuilder->registerErrorField(new \FormFieldError("issue","Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['issue']));
        }
        $formBuilder->registerField(new \FormField("doi_number", "text", false, "DOI","","",false,"",$doiNumber));
        if(!empty($sentBefore[0]['data']) && $sentBefore[0]['data']['doi_number']!=$doiNumber) {
            $formBuilder->registerErrorField(new \FormFieldError("doi_number","Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['doi_number']));
        }
        $formBuilder->registerField(new \FormField("doi_number_link", "text", false, "Ссылка для DOI","","",false,"",$doiNumberLink));
        if(!empty($sentBefore[0]['data']) && $sentBefore[0]['data']['doi_number_link']!=$doiNumberLink) {
            $formBuilder->registerErrorField(new \FormFieldError("doi_number_link","Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['doi_number_link']));
        }

        $formBuilder->registerField(new \FormField("", "hr", false, ""));
        $formBuilder->registerField(new \FormField("", "header", false, "Статьи"));

        $articleContent = array();

//        var_dump($sentBefore);
//        exit;

        $articleCount = 1;
        foreach($rows as $k=>$row) {
            switch ($row['page_template']) {
                case 'jarticle':
                    if(empty($row['doi'])) {
                        continue;
                    }
                    $affiliationsArray = array();
                    if(!empty($row['people_affiliation_en'])) {
                        $affiliationsArray = unserialize($row['people_affiliation_en']);
                    }
                    //var_dump($affiliationsArray);
                    $articleElement = array();
                    $articleElement['title'] = $row['name_en'];
                    if(!empty($sentBefore[0]['data']['articles_list']['articles_list'.$articleCount]) && $sentBefore[0]['data']['articles_list']['articles_list'.$articleCount]['title']!=$row['name_en']) {
                        $formBuilder->registerErrorField(new \FormFieldError("title".$articleCount,"Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['articles_list']['articles_list'.$articleCount]['title']));
                    }
                    $articleElement['original_language_title'] = $row['name'];
                    if(!empty($sentBefore[0]['data']['articles_list']['articles_list'.$articleCount]) && $sentBefore[0]['data']['articles_list']['articles_list'.$articleCount]['original_language_title']!=$row['name']) {
                        $formBuilder->registerErrorField(new \FormFieldError("original_language_title".$articleCount,"Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['articles_list']['articles_list'.$articleCount]['original_language_title']));
                    }
                    $articleElement['abstract'] = preg_replace("(<.+?>)","",$row['annots_en']);
                    $articleElement['abstract'] = str_replace("&nbsp;"," ",$articleElement['abstract']);
//                    if(!empty($sentBefore[0]['data']['articles_list']['articles_list'.$articleCount]) && $sentBefore[0]['data']['articles_list']['articles_list'.$articleCount]['abstract']!=$articleElement['abstract']) {
//                        $formBuilder->registerErrorField(new \FormFieldError("abstract".$articleCount,"Данные отличаются."));
//                    }

                    $sources = $mz->extractSourcesFromArticle($row);
                    $articleElement['citations'] = array();

                    foreach ($sources as $source) {
                        $citationElement = array();
                        $citationElement['citation'] = $source;
                        $articleElement['citations'][] = $citationElement;
                    }

                    $people0=$mz->getAutorsEn($row['people']);
                    $peopleCounter = 1;
                    $addedPeopleCounter = 1;
                    $articleElement['contributors'] = array();
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
//                                preg_match_all('@href="([^"]+orcid.org[^"]+)"@', $people['about'], $orcidLink);
//                                $orcidLink = array_pop($orcidLink);

                                if(!empty($people['orcid'])) {
                                    $orcidLink = "https://orcid.org/".$people['orcid'];
                                } else {
                                    $orcidLink = "";
                                }
                                $contributorElement['orcid'] = $orcidLink;

                                if(!empty($sentBefore[0]['data']['articles_list']['articles_list'.$articleCount]['contributors']['contributors'.$addedPeopleCounter]) && $sentBefore[0]['data']['articles_list']['articles_list'.$articleCount]['contributors']['contributors'.$addedPeopleCounter]['given_name']!=$contributorElement['given_name']) {
                                    $formBuilder->registerErrorField(new \FormFieldError("articles_list".$articleCount."given_name".$addedPeopleCounter,"Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['articles_list']['articles_list'.$articleCount]['contributors']['contributors'.$addedPeopleCounter]['given_name']));
                                }
                                $contributorElement['surname'] = mb_stristr($people['fioshort'], " ", true);
                                if(!empty($sentBefore[0]['data']['articles_list']['articles_list'.$articleCount]['contributors']['contributors'.$addedPeopleCounter]) && $sentBefore[0]['data']['articles_list']['articles_list'.$articleCount]['contributors']['contributors'.$addedPeopleCounter]['surname']!=$contributorElement['surname']) {
                                    $formBuilder->registerErrorField(new \FormFieldError("articles_list".$articleCount."surname".$addedPeopleCounter,"Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['articles_list']['articles_list'.$articleCount]['contributors']['contributors'.$addedPeopleCounter]['surname']));
                                }
                                $contributorElement['affiliations'] = array();
                                $affiliationsCounter = 1;
                                foreach ($affiliationsArray[$peopleCounter-1] as $value) {
                                    $contributorElement['affiliations'][] = array("affiliation_name" => $value);
                                    if(!empty($sentBefore[0]['data']['articles_list']['articles_list'.$articleCount]['contributors']['contributors'.$addedPeopleCounter]['affiliations']['affiliations'.$affiliationsCounter]) && $sentBefore[0]['data']['articles_list']['articles_list'.$articleCount]['contributors']['contributors'.$addedPeopleCounter]['affiliations']['affiliations'.$affiliationsCounter]['affiliation_name']!=$value) {
                                        $formBuilder->registerErrorField(new \FormFieldError("articles_list".$articleCount."contributors".$articleCount.$addedPeopleCounter."affiliation_name".$affiliationsCounter,"Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['articles_list']['articles_list'.$articleCount]['contributors']['contributors'.$addedPeopleCounter]['affiliations']['affiliations'.$affiliationsCounter]['affiliation_name']));
                                    }
                                    $affiliationsCounter++;
                                }
                                //$contributorElement['affiliations'] = array(array("affiliation_name" => "123"),array("affiliation_name" => "1234"));
                                $articleElement['contributors'][] = $contributorElement;
                                $addedPeopleCounter++;
                            }
                        }
                        $peopleCounter++;
                    }
                    $articlePagesArray = explode("-",$row['pages']);
                    if(!empty($articlePagesArray[0]) && !empty($articlePagesArray[1])) {
                        $articleElement['first_page'] = $articlePagesArray[0];
                        if(!empty($sentBefore[0]['data']['articles_list']['articles_list'.$articleCount]) && $sentBefore[0]['data']['articles_list']['articles_list'.$articleCount]['first_page']!=$articlePagesArray[0]) {
                            $formBuilder->registerErrorField(new \FormFieldError("first_page".$articleCount,"Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['articles_list']['articles_list'.$articleCount]['first_page']));
                        }
                        $articleElement['last_page'] = $articlePagesArray[1];
                        if(!empty($sentBefore[0]['data']['articles_list']['articles_list'.$articleCount]) && $sentBefore[0]['data']['articles_list']['articles_list'.$articleCount]['last_page']!=$articlePagesArray[1]) {
                            $formBuilder->registerErrorField(new \FormFieldError("last_page".$articleCount,"Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['articles_list']['articles_list'.$articleCount]['last_page']));
                        }
                    }


                    if(isset($journalInfo['CROSSREF_ISSN_DOI']) && !empty($journalInfo['CROSSREF_ISSN_DOI'])) {
                        $issnForDoi = $journalInfo['CROSSREF_ISSN_DOI'];
                    } else {
                        $issnForDoi = substr($journalInfo['CROSSREF_ISSN'], 0, 4) .
                            "-" .
                            substr($journalInfo['CROSSREF_ISSN'], 4, 4);
                    }

                    $articleElement['doi'] = "10.20542/" .
                        $issnForDoi.
                        "-" .
                        $numberContent[0]['year'] .
                        $volString .
                        "-" .
                        $doiIssue .
                        "-" .
                        $row['pages'];

                    if(!empty($sentBefore[0]['data']['articles_list']['articles_list'.$articleCount]) && $sentBefore[0]['data']['articles_list']['articles_list'.$articleCount]['doi']!=$articleElement['doi']) {
                        $formBuilder->registerErrorField(new \FormFieldError("doi".$articleCount,"Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['articles_list']['articles_list'.$articleCount]['doi']));
                    }
                    if($_GET['ap']!=1) {
                        if($journalInfo['CROSSREF_PDF']==1) {
                            $linkRegex = array();

                            preg_match_all("/<a\s+(?:[^>]*?\s+)?href=['\"]([^\"^']*)['\"][^>]*>([^<]+)<\/a>/i",$row['link'],$linkRegex);

                            $link = $linkRegex[1][0];

                            if(!empty($link)) {
                                $link = str_replace("https://www.imemo.ru","",$link);
                                $link = str_replace("http://www.imemo.ru","",$link);
                                $articleElement['resource'] = "https://www.imemo.ru".$link;
                            } else {
                                $articleElement['resource'] = "https://www.imemo.ru/index.php?page_id=".$journalInfo["ARCHIVE_ID"]."&article_id=".$row['page_id'];
                            }

                        } else {
                            $langPrefix = "";
                            if($journalInfo['CROSSREF_EN']==1) {
                                $langPrefix = "/en";
                            }
                            $articleElement['resource'] = "https://www.imemo.ru".$langPrefix."/index.php?page_id=".$journalInfo["ARCHIVE_ID"]."&article_id=".$row['page_id'];
                        }
                    } else {
                        $linkRegex = array();

                        preg_match_all("/<a\s+(?:[^>]*?\s+)?href=['\"]([^\"^']*)['\"][^>]*>([^<]+)<\/a>/i",$row['afjournal_pdf'],$linkRegex);

                        $link = $linkRegex[1][0];

                        if(!empty($link)) {
                            $link = str_replace("https://www.afjournal.ru","",$link);
                            $link = str_replace("http://www.afjournal.ru","",$link);
                            $articleElement['resource'] = "https://www.afjournal.ru".$link;
                        } else {
                            $articleElement['resource'] = "https://www.afjournal.ru/index.php?page_id=".$row['page_id'];
                        }
                    }



                    if(!empty($sentBefore[0]['data']['articles_list']['articles_list'.$articleCount]) && $sentBefore[0]['data']['articles_list']['articles_list'.$articleCount]['resource']!=$articleElement['resource']) {
                        $formBuilder->registerErrorField(new \FormFieldError("resource".$articleCount,"Данные отличаются. Было отправлено ранее: ".$sentBefore[0]['data']['articles_list']['articles_list'.$articleCount]['resource']));
                    }
                    $articleContent[] = $articleElement;
                    $articleCount++;
                    break;
            }
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
        $contributorsComplexFields[] = new \FormField("", "header-text", false, "Аффилиация: ", "","", false,"","",array(),array(),"col-lg-1");
        $contributorsComplexFields[] = new \FormField("affiliations", "complex-block", false, "Добавить аффилиацию","","", false,"","",array(),array(),"col-lg-11", $affiliationComplexFields);
        $contributorsComplexFields[] = new \FormField("", "form-row-end", false, "");

        $citationComplexFields = array();
        $citationComplexFields[] = new \FormField("", "form-row", false, "");
        $citationComplexFields[] = new \FormField("citation", "text", false, "Источник","","", false,"","",array(),array(),"col-lg-12");
        $citationComplexFields[] = new \FormField("", "form-row-end", false, "");

        $articleComplexFields = array();
        $articleComplexFields[] = new \FormField("", "form-row", false, "");
        $articleComplexFields[] = new \FormField("title", "text", false, "Название","","", false,"","",array(),array(),"col-lg-12");
        $articleComplexFields[] = new \FormField("original_language_title", "text", false, "Название на языке оригинала","","", false,"","",array(),array(),"col-lg-12");
        $articleComplexFields[] = new \FormField("abstract", "textarea", false, "Аннотация","","", false,"","",array(),array(),"col-lg-12", array(),10);
        $articleComplexFields[] = new \FormField("", "header-text", false, "Авторы: ", "","", false,"","",array(),array(),"col-lg-1");
        $articleComplexFields[] = new \FormField("contributors", "complex-block", false, "Добавить автора","","", false,"","",array(),array(),"col-lg-11", $contributorsComplexFields);
        $articleComplexFields[] = new \FormField("", "header-text", false, "Страницы: ", "","", false,"","",array(),array(),"col-lg-12");
        $articleComplexFields[] = new \FormField("first_page", "text", false, "Первая страница","","", false,"","",array(),array(),"col-lg-12");
        $articleComplexFields[] = new \FormField("last_page", "text", false, "Последняя страница","","", false,"","",array(),array(),"col-lg-12");
        $articleComplexFields[] = new \FormField("", "header-text", false, "Ссылки: ", "","", false,"","",array(),array(),"col-lg-12");
        $articleComplexFields[] = new \FormField("doi", "text", false, "DOI","","", false,"","",array(),array(),"col-lg-12");
        $articleComplexFields[] = new \FormField("resource", "text", false, "Ссылка","","", false,"","",array(),array(),"col-lg-12");
        $articleComplexFields[] = new \FormField("", "header-text", false, "Список литературы: ", "","", false,"","",array(),array(),"col-lg-1");
        $articleComplexFields[] = new \FormField("citations", "complex-block", false, "Добавить источник","","", false,"","",array(),array(),"col-lg-11", $citationComplexFields);
        $articleComplexFields[] = new \FormField("", "form-row-end", false, "");



                $formBuilder->registerField(new \FormField("articles_list", "complex-block", false, "Добавить статью","","", false,"",$articleContent,array(),array(),"", $articleComplexFields));


        $posError = $formBuilder->processPostBuild();


        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        if($this->crossref->getAuthorizationService()->isAuthorized()):
            $this->crossref->getPageBuilderManager()->setPageBuilder("top");
            $this->crossref->getPageBuilder()->build(array("main_back" => true));


            ?>

            <div class="container-fluid">
                <div class="row justify-content-start mb-3">
                    <div class="mr-3 mt-3">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=journalsList"
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