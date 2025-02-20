<?php

namespace AspModule\Services;

/**
 *
 */
class DocumentApplicationStatusService
{
    /**
     * @return bool
     */
    public function isOpenedStudy() {
        global $DB;

        $applicationOpened = $DB->selectRow("SELECT * FROM asp_config WHERE name = 'application_opened'");

        return (boolean)$applicationOpened['value'];
    }

    /**
     * @return string
     */
    public function getClosedTextStudy() {
        global $DB;

        $applicationClosedText = $DB->selectRow("SELECT * FROM asp_config WHERE name = 'application_closed_text'");

        return $applicationClosedText['value'];
    }

    /**
     * @return bool
     */
    public function isOpenedDissertation() {
        global $DB;

        $applicationOpened = $DB->selectRow("SELECT * FROM asp_config WHERE name = 'application_dissertation_opened'");

        return (boolean)$applicationOpened['value'];
    }

    /**
     * @return string
     */
    public function getClosedTextDissertation() {
        global $DB;

        $applicationClosedText = $DB->selectRow("SELECT * FROM asp_config WHERE name = 'application_dissertation_closed_text'");

        return $applicationClosedText['value'];
    }

    /**
     * @param mixed $data
     * @return bool
     */
    public function updateData($data) {
        global $DB;

        $DB->query(
            "UPDATE asp_config 
              SET `value`=?
              WHERE name='application_opened'",
            $data['application_opened']
        );
        $DB->query(
            "UPDATE asp_config 
              SET `value`=?
              WHERE name='application_closed_text'",
            $data['application_closed_text']
        );
        $DB->query(
            "UPDATE asp_config 
              SET `value`=?
              WHERE name='application_dissertation_opened'",
            $data['application_dissertation_opened']
        );
        $DB->query(
            "UPDATE asp_config 
              SET `value`=?
              WHERE name='application_dissertation_closed_text'",
            $data['application_dissertation_closed_text']
        );

        return true;
    }
}