<?php

namespace DissertationCouncils\Services;

use DissertationCouncils\DissertationCouncils;
use DissertationCouncils\Models\Status;

class StatusService {

    /** @var DissertationCouncils */

    private $dissertationCouncils;
    /**
     * StatusService constructor.
     * @param DissertationCouncils $dissertationCouncils
     */
    public function __construct(DissertationCouncils $dissertationCouncils)
    {
        $this->dissertationCouncils = $dissertationCouncils;
    }

    /**
     * @param mixed[] $row
     * @return Status
     */
    public function mapToStatus($row) {
        $status = new Status(
            $row['id'],
            $row['text'],
            $row['admin'],
            $row['can_vote']
        );
        return $status;
    }

    /**
     * @param Status $status
     * @return mixed[]
     */
    public function mapToArray($status) {
        $row = array(
            "id" => $status->getId(),
            "text" => $status->getText(),
            "admin" => (int)$status->isAdmin(),
            "can_vote" => (int)$status->isCanVote()
        );
        return $row;
    }

    /**
     * @param int $id
     * @return Status
     */
    public function getStatusBy($id) {
        global $DB;
        $statusArr = $DB->selectRow("SELECT * FROM dissertation_councils_user_status WHERE id=?d",$id);

        if(!empty($statusArr)) {
            return $this->mapToStatus($statusArr);
        }
        return null;
    }

}