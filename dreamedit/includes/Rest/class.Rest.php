<?php

require_once "Models/Announcement.php";
require_once "Models/Notification.php";
require_once "Models/FirstNewsElement.php";
require_once "Models/Page.php";
require_once "Models/RestArray.php";
require_once "interface.RestMethod.php";
require_once "class.RestMethodsManager.php";

class Rest {

    /** @var RestMethodsManager */
    private $restMethodsManager;
    /** @var RestMethod */
    private $executor = null;

    public function __construct()
    {
        $this->restMethodsManager = new RestMethodsManager($this);
    }

    function execute($method, $params) {

        $this->restMethodsManager->setExecutorByMethod($method);

        if(!empty($this->executor)) {
            $result = new \Rest\Models\RestArray($this->executor->execute($params));
            return $result;
        } else {
            Dreamedit::sendHeaderByCode(400);
            exit;
        }
    }

    /**
     * @param RestMethod $executor
     */
    function setExecutor($executor) {
        $this->executor = $executor;
    }

}