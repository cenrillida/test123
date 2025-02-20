<?php

namespace Crossref\PageBuilders\Templates;

use Crossref\Crossref;
use Crossref\PageBuilders\PageBuilder;

class XmlPubl implements PageBuilder {

    /** @var Crossref */
    private $crossref;
    /** @var \Pages */
    private $pages;

    /**
     * XmlPubl constructor.
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

        $xml->elementStart('book', array("book_type" => $params['content']['book_type']));
        $xml->elementStart('book_metadata');

        if(!empty($params['content']['contributors'] )) {
            $xml->elementStart('contributors');

            $peopleCounter = 1;
            foreach ($params['content']['contributors'] as $people) {
                $sequence = "additional";
                if ($peopleCounter == 1) {
                    $sequence = "first";
                }
                $xml->elementStart(
                    'person_name',
                    array('contributor_role' => $people['contributor_role'], 'sequence' => $sequence)
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

        $xml->elementStart('titles');
        $xml->element('title',null,mb_convert_encoding($params['content']['title'],"UTF-8","windows-1251"));
        $xml->element('original_language_title',null,mb_convert_encoding($params['content']['original_language_title'],"UTF-8","windows-1251"));
        $xml->elementEnd('titles');

        $xml->elementStart('jats:abstract', array("xml:lang" => "en"));
        $xml->element(
            'jats:p',
            null,
            mb_convert_encoding(ltrim(rtrim(\Dreamedit::LineBreakToSpace($params['content']['abstract']))),"UTF-8","windows-1251")
        );
        $xml->elementEnd('jats:abstract');

        $xml->elementStart('publication_date', array("media_type" => "print"));
        $xml->element('year', null, mb_convert_encoding($params['content']['year'],"UTF-8","windows-1251"));
        $xml->elementEnd('publication_date');

        $xml->element('isbn', null, mb_convert_encoding($params['content']['isbn'],"UTF-8","windows-1251"));

        $xml->elementStart('publisher');
        $xml->element('publisher_name', null, mb_convert_encoding($params['content']['publisher'],"UTF-8","windows-1251"));
        $xml->elementEnd('publisher');

        $xml->elementStart('doi_data');
        $xml->element(
            'doi',
            null,
            mb_convert_encoding($params['content']['doi'],"UTF-8","windows-1251")
        );
        $xml->element('resource', null, mb_convert_encoding($params['content']['resource'],"UTF-8","windows-1251"));
        $xml->elementEnd('doi_data');

        $xml->elementEnd('book_metadata');
        $xml->elementEnd('book');
        $xml->elementEnd('body');
        $xml->elementEnd('doi_batch');
        $xml->endXML();
    }

}