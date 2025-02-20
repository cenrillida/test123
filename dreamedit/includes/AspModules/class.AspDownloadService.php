<?php

class AspDownloadService extends DownloadService {

    /** @var AspModule */
    private $aspModule;
    /** @var string */
    private $photoUploadPath;
    /** @var string */
    private $documentsUploadPath;

    public function __construct($aspModule)
    {
        //parent::__construct();
        $this->aspModule = $aspModule;
        $this->photoUploadPath = __DIR__."/Documents/Photo/";
        $this->documentsUploadPath = __DIR__."/Documents/Uploaded/";
    }

    /**
     * @return string
     */
    public function getPhotoUploadPath()
    {
        return $this->photoUploadPath;
    }

    /**
     * @return string
     */
    public function getDocumentsUploadPath()
    {
        return $this->documentsUploadPath;
    }

    public function getAspPhoto($photoName,$downloadName = "") {
        if($downloadName!="") {
            parent::download($this->photoUploadPath.$photoName,$downloadName);
        } else {
            parent::getPhoto($this->photoUploadPath.$photoName);
        }
    }

    public function getPdf($filename,$downloadName) {
        parent::download($this->documentsUploadPath.$filename,$downloadName);
    }

}