<?php

class RestMethodsManager {

    /** @var Rest */
    private $rest;
    /** @var RestMethod[] */
    private $methodsList;

    public function __construct($rest)
    {
        $this->rest = $rest;
        $this->methodsList = array(
            "getAnnouncements" => new \Rest\Methods\GetAnnouncements(),
            "getFirstNews" => new \Rest\Methods\GetFirstNews(),
            "getPages" => new \Rest\Methods\GetPages(),
            "getNotifications" => new \Rest\Methods\GetNotifications()
        );
    }

    public function setExecutorByMethod($method) {
        if(!empty($this->methodsList[$method])) {
            $this->rest->setExecutor($this->methodsList[$method]);
        }
    }

}