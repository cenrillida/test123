<?php

namespace AspModule\Services;

use AspModule\AspModule;
use AspModule\Models\Status;

class StatusService {

    /** @var AspModule */
    private $aspModule;

    public function __construct($aspModule)
    {
        $this->aspModule = $aspModule;
    }

    /**
     * @return Status
     */
    private function mapToStatus($row) {
        return new Status(
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
     * @return Status
     */
    public function getStatusBy($id) {
        global $DB;
        $statusArr = $DB->selectRow("SELECT * FROM asp_status WHERE id=?d",$id);

        if(!empty($statusArr)) {
            return $this->mapToStatus($statusArr);
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
     * @return Status[]
     */
    public function getAllStatuses() {
        global $DB;
        $statusArr = $DB->select("SELECT * FROM asp_status");

        $statuses = array();
        foreach ($statusArr as $item) {
            $statuses[] = $this->mapToStatus($item);
        }
        return $statuses;
    }

}