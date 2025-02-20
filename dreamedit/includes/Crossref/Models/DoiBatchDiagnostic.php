<?php

namespace Crossref\Models;

class DoiBatchDiagnostic {

    /**
     * @var string
     */
    private $submissionId;
    /**
     * @var string
     */
    private $batchId;
    /**
     * @var RecordDiagnostic[]
     */
    private $recordDiagnostics;
    /**
     * @var string
     */
    private $statusText;

    /**
     * DoiBatchDiagnostic constructor.
     * @param string $submissionId
     * @param string $batchId
     * @param RecordDiagnostic[] $recordDiagnostics
     * @param string $statusText
     */
    public function __construct($submissionId, $batchId, array $recordDiagnostics, $statusText)
    {
        $this->submissionId = $submissionId;
        $this->batchId = $batchId;
        $this->recordDiagnostics = $recordDiagnostics;
        $this->statusText = $statusText;
    }

    /**
     * @return string
     */
    public function getSubmissionId()
    {
        return $this->submissionId;
    }

    /**
     * @return string
     */
    public function getBatchId()
    {
        return $this->batchId;
    }

    /**
     * @return RecordDiagnostic[]
     */
    public function getRecordDiagnostics()
    {
        return $this->recordDiagnostics;
    }

    /**
     * @return string
     */
    public function getStatusText()
    {
        return $this->statusText;
    }

    /**
     * @return bool
     */
    public function isCompleted()
    {
        if($this->statusText=="completed") {
            return true;
        } else {
            return false;
        }
    }

}