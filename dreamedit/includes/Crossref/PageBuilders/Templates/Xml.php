<?php

namespace Crossref\PageBuilders\Templates;

use Crossref\Crossref;
use Crossref\PageBuilders\PageBuilder;

class Xml implements PageBuilder {

    /** @var Crossref */
    private $crossref;
    /** @var \Pages */
    private $pages;

    /**
     * Xml constructor.
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

        $xml = new \xml_output();

        if($params['xml_header']) {
            header("Content-Type: text/xml;charset=utf8");
        }

        $xml->startXML();
        $xml->elementStart('doi_batch',array(
            "xmlns" => "http://www.crossref.org/schema/4.4.2",
            "xmlns:xsi" => "http://www.w3.org/2001/XMLSchema-instance",
            "xmlns:jats" => "http://www.ncbi.nlm.nih.gov/JATS1",
            "version" => "4.4.2",
            "xsi:schemaLocation" =>
                "http://www.crossref.org/schema/4.4.2 http://www.crossref.org/schema/deposit/crossref4.4.2.xsd"
        ));
        $xml->elementStart('head');
        $xml->element(
            'doi_batch_id',
            null,
            mb_convert_encoding($params['content']['doi_batch_id'],"UTF-8","windows-1251")
        );
        $xml->element('timestamp',null,mb_convert_encoding($params['content']['timestamp'],"UTF-8","windows-1251"));
        $xml->elementStart('depositor');
        $xml->element('depositor_name',null,mb_convert_encoding($params['content']['depositor_name'],"UTF-8","windows-1251"));
        $xml->element('email_address',null,"mirina@imemo.ru");
        $xml->elementEnd('depositor');
        $xml->element('registrant',null,"WEB-FORM");
        $xml->elementEnd('head');
        $xml->elementStart('body');
        $xml->elementStart('journal');
        $xml->elementStart('journal_metadata');
        $xml->element('full_title',null,mb_convert_encoding($params['content']['full_title'],"UTF-8","windows-1251"));
        $xml->element('abbrev_title',null,mb_convert_encoding($params['content']['abbrev_title'],"UTF-8","windows-1251"));
        $issn = mb_convert_encoding($params['content']['issn'],"UTF-8","windows-1251");
        $issnElectronic = mb_convert_encoding($params['content']['issn_electronic'],"UTF-8","windows-1251");
        if(!empty($issn)) {
            $xml->element('issn',array("media_type" => "print"),$issn);
        }
        if(!empty($issnElectronic)) {
            $xml->element(
                'issn',
                array("media_type" => "electronic"),
                $issnElectronic
            );
        }
        $xml->elementEnd('journal_metadata');
        $xml->elementStart('journal_issue');
        if(!empty($issn)) {
            $xml->elementStart('publication_date', array("media_type" => "print"));
            $xml->element('year', null, mb_convert_encoding($params['content']['year'],"UTF-8","windows-1251"));
            $xml->elementEnd('publication_date');
        }
        if(!empty($issnElectronic)) {
            $xml->elementStart('publication_date', array("media_type" => "online"));
            $xml->element('year', null, mb_convert_encoding($params['content']['year'],"UTF-8","windows-1251"));
            $xml->elementEnd('publication_date');
        }
        $volume = mb_convert_encoding($params['content']['volume'],"UTF-8","windows-1251");
        if (!empty($volume)) {
            $xml->elementStart('journal_volume');
            $xml->element(
                'volume',
                null,
                $volume
            );
            $xml->elementEnd('journal_volume');
        }
        $xml->element('issue',null,mb_convert_encoding($params['content']['issue'],"UTF-8","windows-1251"));
        if(!empty($params['content']['doi_number'])) {
            $xml->elementStart('doi_data');
            $xml->element(
                'doi',
                null,
                mb_convert_encoding($params['content']['doi_number'],"UTF-8","windows-1251")
            );
            $xml->element('resource', null, mb_convert_encoding($params['content']['doi_number_link'],"UTF-8","windows-1251"));
            $xml->elementEnd('doi_data');
        }

        $xml->elementEnd('journal_issue');
        foreach($params['content']['articles_list'] as $k=>$row)
        {
            $xml->elementStart('journal_article', array("publication_type" => "full_text"));
            $xml->elementStart('titles');
            $xml->element('title',null,mb_convert_encoding($row['title'],"UTF-8","windows-1251"));
            $xml->element('original_language_title',null,mb_convert_encoding($row['original_language_title'],"UTF-8","windows-1251"));
            $xml->elementEnd('titles');
            if(!empty($row['contributors'])) {
                $xml->elementStart('contributors');

                $peopleCounter = 1;
                foreach ($row['contributors'] as $people) {
                    $sequence = "additional";
                    if ($peopleCounter == 1) {
                        $sequence = "first";
                    }
                    $xml->elementStart(
                        'person_name',
                        array('contributor_role' => 'author', 'sequence' => $sequence)
                    );
                    $xml->element(
                        'given_name',
                        null,
                        mb_convert_encoding($people['given_name'], "UTF-8", "windows-1251")
                    );
                    $xml->element(
                        'surname',
                        null,
                        mb_convert_encoding($people['surname'], "UTF-8", "windows-1251")
                    );
                    $affiliationCounter = 1;
                    foreach ($people['affiliations'] as $key => $affiliation) {
                        if ($affiliationCounter > 5)
                            break;
                        $xml->element(
                            'affiliation',
                            null,
                            mb_convert_encoding($affiliation['affiliation_name'], "UTF-8", "windows-1251")
                        );
                        $affiliationCounter++;
                    }
                    if (!empty($people['orcid'])) {
                        $xml->element(
                            'ORCID',
                            array("authenticated" => "true"),
                            mb_convert_encoding($people['orcid'], "UTF-8", "windows-1251")
                        );
                    }
                    $xml->elementEnd('person_name');
                    $peopleCounter++;
                }
                $xml->elementEnd('contributors');
            }

            $xml->elementStart('jats:abstract', array("xml:lang" => "en"));
            $xml->element(
                'jats:p',
                null,
                mb_convert_encoding(ltrim(rtrim(\Dreamedit::LineBreakToSpace($row['abstract']))),"UTF-8","windows-1251")
            );
            $xml->elementEnd('jats:abstract');

            if(!empty($issn)) {
                $xml->elementStart('publication_date', array("media_type" => "print"));
                $xml->element('year', null, mb_convert_encoding($params['content']['year'],"UTF-8","windows-1251"));
                $xml->elementEnd('publication_date');
            }
            if(!empty($issnElectronic)) {
                $xml->elementStart('publication_date', array("media_type" => "online"));
                $xml->element('year', null, mb_convert_encoding($params['content']['year'],"UTF-8","windows-1251"));
                $xml->elementEnd('publication_date');
            }
            $firstPage = mb_convert_encoding($row['first_page'],"UTF-8","windows-1251");
            $lastPage = mb_convert_encoding($row['last_page'],"UTF-8","windows-1251");
            if(!empty($firstPage) && !empty($lastPage)) {
                $xml->elementStart('pages');
                $xml->element('first_page', null, $firstPage);
                $xml->element('last_page', null, $lastPage);
                $xml->elementEnd('pages');
            }
            $xml->elementStart('doi_data');
            $xml->element(
                'doi',
                null,
                mb_convert_encoding($row['doi'],"UTF-8","windows-1251")
            );
            $xml->element('resource', null, mb_convert_encoding($row['resource'],"UTF-8","windows-1251"));
            $xml->elementEnd('doi_data');
            if(!empty($row['citations'])) {
                $xml->elementStart('citation_list');

                $citationCounter = 1;
                foreach ($row['citations'] as $citation) {
                    $xml->elementStart(
                        'citation',
                        array('key' => $citationCounter)
                    );
                    $xml->element(
                        'unstructured_citation',
                        null,
                        mb_convert_encoding($citation['citation'], "UTF-8", "windows-1251")
                    );
                    $xml->elementEnd('citation');
                    $citationCounter++;
                }
                $xml->elementEnd('citation_list');
            }
            $xml->elementEnd('journal_article');
        }
        $xml->elementEnd('journal');
        $xml->elementEnd('body');
        $xml->elementEnd('doi_batch');
        $xml->endXML();
    }

}