<?php

namespace TelegramBot\Models;

class KeyboardButton {

    /** @var string */
    private $text;
    /** @var bool */
    private $requestContact = null;
    /** @var bool */
    private $requestLocation = null;

    /**
     * InlineKeyboardButton constructor.
     * @param string $text
     * @param bool $requestContact
     * @param bool $requestLocation
     */
    public function __construct($text, $requestContact = null, $requestLocation = null)
    {
        $this->text = $text;
        $this->requestContact = $requestContact;
        $this->requestLocation = $requestLocation;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return bool
     */
    public function isRequestContact()
    {
        return $this->requestContact;
    }

    /**
     * @return bool
     */
    public function isRequestLocation()
    {
        return $this->requestLocation;
    }

}