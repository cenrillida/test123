<?php

namespace Contest\PageBuilders\Templates;

use Contest\Contest;
use Contest\PageBuilders\PageBuilder;

class GetPdf implements PageBuilder {

    /** @var Contest */
    private $contest;
    /** @var \Pages */
    private $pages;

    /**
     * GetPdf constructor.
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
        if($this->contest->getAuthorizationService()->isAuthorized()) {
            $applicant = $this->contest->getApplicantService()->getApplicantById($_GET['applicant_id']);
            switch ($_GET['file']) {
                case "getDocuments":
                    $this->contest->getDocumentService()->getDocument("getDocuments",$_GET['id'],$applicant);
                    break;
                default:
                    echo "Ошибка доступа.";
            }
        } else {
            $this->contest->getPageBuilderManager()->setPageBuilder("error");
            $this->contest->getPageBuilder()->build();
        }
    }

}