<?php

namespace Rest\Models;

/**
 * Class Notification
 * @package Rest\Models
 */
class Notification {

    /**
     * @var int
     */
    public $id;
    /**
     * @var
     */
    public $date;
    /**
     * @var
     */
    public $endDate;
    /**
     * @var
     */
    public $content;
    /**
     * @var
     */
    public $ilineId;

    /**
     * Notification constructor.
     * @param int $id
     * @param $date
     * @param $endDate
     * @param $content
     * @param $ilineId
     */
    public function __construct($id, $date, $endDate, $content, $ilineId)
    {
        $this->id = $id;
        $this->date = $date;
        $this->endDate = $endDate;
        $this->content = $content;
        $this->ilineId = $ilineId;
    }

}