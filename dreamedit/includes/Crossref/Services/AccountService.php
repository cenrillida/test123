<?php

namespace Crossref\Services;

use Crossref\Crossref;

class AccountService
{

    /** @var Crossref */
    private $crossref;

    /**
     * AuthorizationService constructor.
     * @param Crossref $crossref
     */
    public function __construct(Crossref $crossref)
    {
        $this->crossref = $crossref;
    }

    public function setBuilderWithMode($mode)
    {
        if (empty($mode)) {
            $mode = "";
        }
        switch ($mode) {
            case "publsList":
                $this->crossref->getPageBuilderManager()->setPageBuilder("publsList");
                break;
            case "publCheckUpload":
                $this->crossref->getPageBuilderManager()->setPageBuilder("publCheckUpload");
                break;
            case "publCheck":
                $this->crossref->getPageBuilderManager()->setPageBuilder("publCheck");
                break;
            case "journalsList":
                $this->crossref->getPageBuilderManager()->setPageBuilder("journalsList");
                break;
            case "numberCheck":
                $this->crossref->getPageBuilderManager()->setPageBuilder("numberCheck");
                break;
            case "numberCheckUpload":
                $this->crossref->getPageBuilderManager()->setPageBuilder("numberCheckUpload");
                break;
            case "login":
                $this->crossref->getPageBuilderManager()->setPageBuilder("login");
                break;
            case "":
                $this->crossref->getPageBuilderManager()->setPageBuilder("admin");
                break;
            default:
                $this->crossref->getPageBuilderManager()->setPageBuilder("error");
        }
    }
}