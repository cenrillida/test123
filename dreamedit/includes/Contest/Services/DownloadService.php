<?php

namespace Contest\Services;

use Contest\Contest;

/**
 * Class DownloadService
 * @package Contest\Services
 */
class DownloadService extends \DownloadService {

    /**
     * @var Contest
     */
    private $contest;
    /**
     * @var string
     */
    private $signsUploadPath;
    /**
     * @var string
     */
    private $documentsUploadPath;
    /**
     * DownloadService constructor.
     * @param Contest $contest
     */
    public function __construct(Contest $contest)
    {
        $this->contest = $contest;
        $this->documentsUploadPath = __DIR__."/../Documents/Uploaded/";
        $this->signsUploadPath = __DIR__."/../Documents/Signs/";
    }
    /**
     * @return string
     */
    public function getDocumentsUploadPath()
    {
        return $this->documentsUploadPath;
    }

    /**
     * @param $filename
     * @param $downloadName
     */
    public function getPdf($filename, $downloadName) {
        parent::download($this->documentsUploadPath.$filename,$downloadName);
    }

    /**
     * @return string
     */
    public function getSignsUploadPath()
    {
        return $this->signsUploadPath;
    }

    public function getSign($photoName,$downloadName = "") {
        if($downloadName!="") {
            parent::download($this->signsUploadPath.$photoName,$downloadName);
        } else {
            parent::getPhoto($this->signsUploadPath.$photoName);
        }
    }

}