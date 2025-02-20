<?php

namespace Crossref\Services;

use Crossref\Crossref;
use Crossref\Models\DoiBatchDiagnostic;
use Crossref\Models\RecordDiagnostic;

class NumberCheckService
{

    /** @var Crossref */
    private $crossref;

    /**
     * AuthorizationService constructor.
     * @param Crossref $crossref
     */
    public function __construct(Crossref $crossref)
    {
        $this->crossref = $crossref;
    }

    public function sendData($fields, $module)
    {
        global $DB;

        $DB->query("DELETE FROM crossref_sent WHERE element_id=?d AND `module`=?",$_GET['id'],$module);

        $data = serialize($fields);

        $DB->query(
            "INSERT INTO crossref_sent(`element_id`,`module`,`date_sent`,`data`) VALUES (?d,?,?,?)",
            $_GET['id'],
            $module,
            date("Y-m-d"),
            $data
        );
        if($module=='afjournal') {
            $this->crossref->getPageBuilderManager()->setPageBuilder("xml");
        }
        if($module=='journal') {
            $this->crossref->getPageBuilderManager()->setPageBuilder("xml");
        }
        if($module=='publ') {
            $this->crossref->getPageBuilderManager()->setPageBuilder("xmlPubl");
        }

        //header("Content-Type: text/html; charset=utf8");

        ob_start();
        $this->crossref->getPageBuilder()->build(array("content" => $fields));
        $xmlData = ob_get_clean();

        $url = "https://doi.crossref.org/servlet/deposit";

        $eol = "\r\n";
        $data = '';

        $mime_boundary=md5(time());

        $data .= '--' . $mime_boundary . $eol;
        $data .= 'Content-Disposition: form-data; name="login_id"' . $eol . $eol;
        $data .= "primakov" . $eol;
        $data .= '--' . $mime_boundary . $eol;
        $data .= 'Content-Disposition: form-data; name="login_passwd"' . $eol . $eol;
        $data .= "LYSXI3BSQ" . $eol;
        $data .= '--' . $mime_boundary . $eol;
        $data .= 'Content-Disposition: form-data; name="fname"; filename='.$fields['doi_batch_id'].'.xml' . $eol;
        $data .= 'Content-Type: text/xml' . $eol.$eol;
        $data .= $xmlData . $eol;
        $data .= "--" . $mime_boundary . "--" . $eol . $eol;

        $para = array('http' => array(
            'method' => 'POST',
            'header' => 'Content-Type: multipart/form-data; boundary=' . $mime_boundary . $eol,
            'content' => $data
        ));
        $context  = stream_context_create($para);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) {
            return false;
        }

//        var_dump($result);
//
//        exit;
        return true;
    }

    public function updateCheckedById($id, $value) {
        global $DB;
        $DB->query("UPDATE crossref_sent SET checked=?d WHERE id=?d", $value, $id);
    }

    public function getSentDataByElementIdAndModule($elementId, $module) {
        global $DB;

        $element = $DB->select(
            "SELECT * FROM crossref_sent WHERE element_id=?d AND `module`=? ORDER BY id DESC",
            $elementId,
            $module
        );

        foreach ($element as $k=>$value) {
            $element[$k]['data'] = unserialize($value['data']);
        }
        return $element;
    }

    /**
     * @return DoiBatchDiagnostic
     */
    public function getSentDataStatusByBatchId($batchId) {
        $xmlStr = file_get_contents(
            "https://doi.crossref.org/servlet/submissionDownload?usr=primakov&pwd=LYSXI3BSQ&file_name=$batchId.xml&type=result"
        );
        $xml = new \SimpleXMLElement($xmlStr);
        $jsonXml = json_encode($xml);
        $arrayXml = json_decode($jsonXml,TRUE);

        $recordDiagnostics = array();
        if(!empty($arrayXml['record_diagnostic']['@attributes'])) {
            $arrayXml['record_diagnostic'] = array($arrayXml['record_diagnostic']);
        }
        foreach ($arrayXml['record_diagnostic'] as $value) {
            if($value['@attributes']['status']=="Success") {
                $success = true;
            } else {
                $success = false;
            }
            $doi = "";
            $msg = "";
            if(!empty($value['doi'])) {
                $doi = $value['doi'];
            }
            if(!empty($value['msg'])) {
                $msg = $value['msg'];
            }
            $recordDiagnostics[] = new RecordDiagnostic($success,$doi,$msg, $value['@attributes']['status']);
        }
        return new DoiBatchDiagnostic(
            $arrayXml['submission_id'],
            $arrayXml['batch_id'],
            $recordDiagnostics,
            $arrayXml['@attributes']['status']
        );

    }
}