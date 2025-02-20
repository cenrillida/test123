<?php

namespace Rest\Models;

class Announcement {

    public $id;
    public $datetime;
    public $text;
    public $fullText;

    /**
     * Announcement constructor.
     * @param $id
     * @param $datetime
     * @param $text
     * @param $fullText
     */
    public function __construct($id, $datetime, $text, $fullText)
    {
        $this->id = $id;
        $this->datetime = $datetime;
        $this->text = $text;
        $this->fullText = $fullText;
    }


}