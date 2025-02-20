<?php

abstract class DownloadService {

    protected function _httpencode($param, $value, $isUTF8)
    {
        // Encode HTTP header field parameter
        if($this->_isascii($value))
            return $param.'="'.$value.'"';
        if(!$isUTF8)
            $value = utf8_encode($value);
        if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE')!==false)
            return $param.'="'.rawurlencode($value).'"';
        else
            return $param."*=UTF-8''".rawurlencode($value);
    }

    protected function _isascii($s)
    {
        // Test if string is ASCII
        $nb = strlen($s);
        for($i=0;$i<$nb;$i++)
        {
            if(ord($s[$i])>127)
                return false;
        }
        return true;
    }

    protected function download($filename,$downloadName) {
        if (file_exists($filename)) {
            if (ob_get_level()) {
                ob_end_clean();
            }
//            header('Content-Type: application/x-download');
//            header('Content-Disposition: attachment; '.$this->_httpencode('filename',$txt,true));
//            header('Cache-Control: private, max-age=0, must-revalidate');
//            header('Pragma: public');
            header('Content-Description: File Transfer');
            header('Content-Type: application/x-download');
            header('Content-Disposition: attachment; '.$this->_httpencode('filename',$downloadName,true));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filename));
            readfile($filename);
            exit;
        } else {
            echo "404 Not found";
            exit;
        }
    }

    protected function getPhoto($filename) {
        if (file_exists($filename)) {
            if (ob_get_level()) {
                ob_end_clean();
            }
            $file_extension = strtolower(substr(strrchr($filename,"."),1));

            switch( $file_extension ) {
                case "gif": $ctype="image/gif"; break;
                case "png": $ctype="image/png"; break;
                case "jpeg":
                case "jpg": $ctype="image/jpeg"; break;
                case "svg": $ctype="image/svg+xml"; break;
                default:
                    exit;
            }

            header('Content-Type: '.$ctype);
            header('Content-Disposition: inline; filename=' . basename("photo.".$file_extension));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filename));
            readfile($filename);
            exit;
        } else {
            echo "404 Not found";
            exit;
        }
    }

    public function echoExcelHeader($downloadName) {
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; '.$this->_httpencode('filename',$downloadName,true));
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
    }

    public function echoWordHeader($downloadName) {
        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; '.$this->_httpencode('filename',$downloadName,true));
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
    }
}