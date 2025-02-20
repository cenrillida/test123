<?php

namespace Contest\Services;

use Contest\Contest;
use Contest\Models\Applicant;

/**
 * Class DocumentService
 * @package Contest\Services
 */
class DocumentService extends \DownloadService {

    /**
     * @var Contest
     */
    private $contest;
    /**
     * DocumentService constructor.
     * @param Contest $contest
     */
    public function __construct(Contest $contest)
    {
        $this->contest = $contest;
    }

    /**
     * @param Applicant $applicant
     * @param string $content
     */
    private function getFileNameWithContent($applicant, $content) {
        $thirdName = "";
        if($applicant->getThirdName()!="") {
            $thirdName = substr($applicant->getThirdName(),0,1).".";
        }
        return $applicant->getLastName()."_".substr($applicant->getFirstName(),0,1).".".$thirdName."_".$content;
    }

    /**
     * @param Applicant $applicant
     */
    public function getDocument($document, $id="", $applicant = null) {
        switch ($document) {
            case "getDocuments":
                if(!empty($id)) {
                    $documents = $applicant->getDocuments();
                    $documents = array_values($documents);
                    if(!empty($documents[$id-1]['document'])) {
                        $txt = mb_convert_encoding($this->getFileNameWithContent($applicant,"Документ_".$id.".pdf"), "UTF-8", "windows-1251");
                        $this->contest->getDownloadService()->getPdf($documents[$id-1]['document'],$txt);
                    } else {
                        echo "Ошибка доступа";
                    }
                } else {
                    echo "Ошибка доступа";
                    exit;
                }
                break;
            default:
                echo "Ошибка доступа";
                exit;
        }

    }

}