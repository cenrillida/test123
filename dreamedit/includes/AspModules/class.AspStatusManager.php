<?php

class AspStatus {

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
     * AspStatus constructor.
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

class AspStatusManager {

    /** @var AspModule */
    private $aspModule;

    public function __construct($aspModule)
    {
        $this->aspModule = $aspModule;
    }

    /**
     * @return AspStatus
     */
    private function createStatusFromDB($row) {
        return new AspStatus(
            $row['id'],
            $row['status'],
            $row['step_text'],
            $row['next_status'],
            $row['add_data_permission'],
            $row['document_application_permission'],
            $row['document_upload_permission'],
            $row['edit_add_data_permission'],
            $row['edit_document_application_permission'],
            $row['admin_permission'],
            $row['document_send_permission'],
            $row['education_can_upload'],
            $row['can_apply_for_entry'],
            $row['can_apply_for_entry_send'],
            $row['can_edit_apply_for_entry']
        );
    }

    /**
     * @return AspStatus
     */
    public function getStatusBy($id) {
        global $DB;
        $statusArr = $DB->selectRow("SELECT * FROM asp_status WHERE id=?d",$id);

        if(!empty($statusArr)) {
            return $this->createStatusFromDB($statusArr);
        }
        return null;
    }

    /**
     * @return string
     */
    public function getStatusText($id) {
        global $DB;
        $statusArr = $DB->selectRow("SELECT * FROM asp_status WHERE id=?d",$id);

        if(!empty($statusArr)) {
            return $statusArr['status'];
        }
        return "Îøèáêà";
    }

    /**
     * @return AspStatus[]
     */
    public function getAllStatuses() {
        global $DB;
        $statusArr = $DB->select("SELECT * FROM asp_status");

        $statuses = array();
        foreach ($statusArr as $item) {
            $statuses[] = $this->createStatusFromDB($item);
        }
        return $statuses;
    }


}