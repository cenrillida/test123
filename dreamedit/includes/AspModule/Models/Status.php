<?php

namespace AspModule\Models;

class Status {

    /** @var int */
    private $id;
    /** @var string */
    private $text;
    /** @var string */
    private $stepText;
    /** @var int */
    private $nextStatus;
    /** @var bool */
    private $addDataAllow;
    /** @var bool */
    private $documentApplicationAllow;
    /** @var bool */
    private $documentUploadAllow;
    /** @var bool */
    private $editAddDataAllow;
    /** @var bool */
    private $editDocumentApplicationAllow;
    /** @var bool */
    private $adminAllow;
    /** @var bool */
    private $documentSendAllow;
    /** @var bool */
    private $educationCanUpload;
    /** @var bool */
    private $canApplyForEntry;
    /** @var bool */
    private $canApplyForEntrySend;
    /** @var bool */
    private $canEditApplyForEntry;

    /**
     * Status constructor.
     * @param int $id
     * @param string $text
     * @param string $stepText
     * @param int $nextStatus
     * @param bool $addDataAllow
     * @param bool $documentApplicationAllow
     * @param bool $documentUploadAllow
     * @param bool $editAddDataAllow
     * @param bool $editDocumentApplicationAllow
     * @param bool $adminAllow
     * @param bool $documentSendAllow
     * @param bool $educationCanUpload
     * @param bool $canApplyForEntry
     * @param bool $canApplyForEntrySend
     * @param bool $canEditApplyForEntry
     */
    public function __construct($id, $text, $stepText, $nextStatus, $addDataAllow, $documentApplicationAllow, $documentUploadAllow, $editAddDataAllow, $editDocumentApplicationAllow, $adminAllow, $documentSendAllow, $educationCanUpload, $canApplyForEntry, $canApplyForEntrySend, $canEditApplyForEntry)
    {
        $this->id = $id;
        $this->text = $text;
        $this->stepText = $stepText;
        $this->nextStatus = $nextStatus;
        $this->addDataAllow = $addDataAllow;
        $this->documentApplicationAllow = $documentApplicationAllow;
        $this->documentUploadAllow = $documentUploadAllow;
        $this->editAddDataAllow = $editAddDataAllow;
        $this->editDocumentApplicationAllow = $editDocumentApplicationAllow;
        $this->adminAllow = $adminAllow;
        $this->documentSendAllow = $documentSendAllow;
        $this->educationCanUpload = $educationCanUpload;
        $this->canApplyForEntry = $canApplyForEntry;
        $this->canApplyForEntrySend = $canApplyForEntrySend;
        $this->canEditApplyForEntry = $canEditApplyForEntry;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getStepText()
    {
        return $this->stepText;
    }

    /**
     * @return bool
     */
    public function isAddDataAllow()
    {
        return $this->addDataAllow;
    }

    /**
     * @return bool
     */
    public function isDocumentApplicationAllow()
    {
        return $this->documentApplicationAllow;
    }

    /**
     * @return int
     */
    public function getNextStatus()
    {
        return $this->nextStatus;
    }

    /**
     * @return bool
     */
    public function isDocumentUploadAllow()
    {
        return $this->documentUploadAllow;
    }

    /**
     * @return bool
     */
    public function isEditAddDataAllow()
    {
        return $this->editAddDataAllow;
    }

    /**
     * @return bool
     */
    public function isEditDocumentApplicationAllow()
    {
        return $this->editDocumentApplicationAllow;
    }

    /**
     * @return bool
     */
    public function isAdminAllow()
    {
        return $this->adminAllow;
    }

    /**
     * @return bool
     */
    public function isDocumentSendAllow()
    {
        return $this->documentSendAllow;
    }

    /**
     * @return bool
     */
    public function isEducationCanUpload()
    {
        return $this->educationCanUpload;
    }

    /**
     * @return bool
     */
    public function isCanApplyForEntry()
    {
        return $this->canApplyForEntry;
    }

    /**
     * @return bool
     */
    public function isCanApplyForEntrySend()
    {
        return $this->canApplyForEntrySend;
    }

    /**
     * @return bool
     */
    public function isCanEditApplyForEntry()
    {
        return $this->canEditApplyForEntry;
    }

}