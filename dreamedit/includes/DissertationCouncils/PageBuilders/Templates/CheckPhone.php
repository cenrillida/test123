<?php

namespace DissertationCouncils\PageBuilders\Templates;

use DissertationCouncils\DissertationCouncils;
use DissertationCouncils\Exceptions\Exception;
use DissertationCouncils\FormBuilders\Templates\LoginFormBuilder;
use DissertationCouncils\FormBuilders\Templates\RegisterFormBuilder;
use DissertationCouncils\PageBuilders\PageBuilder;

class CheckPhone implements PageBuilder {

    /** @var DissertationCouncils */
    private $dissertationCouncils;
    /** @var \Pages */
    private $pages;

    /**
     * RegisterForm constructor.
     * @param DissertationCouncils $dissertationCouncils
     * @param \Pages $pages
     */
    public function __construct(DissertationCouncils $dissertationCouncils, $pages)
    {
        $this->dissertationCouncils = $dissertationCouncils;
        $this->pages = $pages;
    }

    public function build($params = array())
    {
        global $DB,$_CONFIG,$site_templater;

        $phone = $_GET['phone'];

        header("Content-type: application/json");

        $rows = array();

        try {
            $this->dissertationCouncils->getAuthorizationService()->checkPhone($phone);

            $rows['status'] = \Dreamedit::normJsonStr('OK');
            $rows['message'] = \Dreamedit::normJsonStr('OK');
        } catch (Exception $exception) {
            $rows['status'] = \Dreamedit::normJsonStr('Error');
            $rows['message'] = \Dreamedit::normJsonStr($exception->getMessage());
        }

        echo json_encode($rows);
    }

}