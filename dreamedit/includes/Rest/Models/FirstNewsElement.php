<?php

namespace Rest\Models;

class FirstNewsElement {

    /** @var int */
    public $id;
    /** @var string */
    public $title;
    /** @var string */
    public $imageUrl;
    /** @var string */
    public $imageAlt;

    /**
     * FirstNewsElement constructor.
     * @param int $id
     * @param string $title
     * @param string $imageUrl
     * @param string $imageAlt
     */
    public function __construct($id, $title, $imageUrl, $imageAlt)
    {
        $this->id = $id;
        $this->title = $title;
        $this->imageUrl = $imageUrl;
        $this->imageAlt = $imageAlt;
    }

}