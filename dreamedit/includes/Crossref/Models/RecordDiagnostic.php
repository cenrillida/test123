<?php

namespace Crossref\Models;

class RecordDiagnostic {

    /**
     * @var bool
     */
    private $success;
    /**
     * @var string
     */
    private $doi;
    /**
     * @var string
     */
    private $msg;
    /**
     * @var string
     */
    private $status;

    /**
     * RecordDiagnostic constructor.
     * @param bool $success
     * @param string $doi
     * @param string $msg
     */
    public function __construct($success, $doi, $msg, $status)
    {
        $this->success = $success;
        $this->doi = $doi;
        $this->msg = $msg;
        $this->status = $status;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * @return string
     */
    public function getDoi()
    {
        return $this->doi;
    }

    /**
     * @return string
     */
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

}