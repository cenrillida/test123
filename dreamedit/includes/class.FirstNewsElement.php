<?php

class FirstNewsElement {

    /** @var int */
    private $id;
    /** @var string */
    private $title;
    /** @var string */
    private $imageUrl;
    /** @var string */
    private $imageAlt;
    /** @var string */
    private $authorsImagesStr;
    /** @var string */
    private $authorsStr;

    /**
     * FirstNewsElement constructor.
     * @param int $id
     * @param string $title
     * @param string $imageUrl
     * @param string $imageAlt
     * @param string $authorsImagesStr
     * @param string $authorsStr
     */
    public function __construct($id, $title, $imageUrl, $imageAlt, $authorsImagesStr, $authorsStr)
    {
        $this->id = $id;
        $this->title = $title;
        $this->imageUrl = $imageUrl;
        $this->imageAlt = $imageAlt;
        $this->authorsImagesStr = $authorsImagesStr;
        $this->authorsStr = $authorsStr;
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @return string
     */
    public function getImageAlt()
    {
        return $this->imageAlt;
    }

    /**
     * @return string
     */
    public function getAuthorsImagesStr()
    {
        return $this->authorsImagesStr;
    }

    /**
     * @return string
     */
    public function getAuthorsStr()
    {
        return $this->authorsStr;
    }

}