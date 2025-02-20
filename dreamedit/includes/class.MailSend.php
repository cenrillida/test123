<?php


class MailSend {

    public static function get_text_with_no_reply_added($text, $send_charset) {
        return $text.iconv(
            "cp1251",
            $send_charset,
            "\r\n<br><br><i>Данное письмо сгенерировано автоматически. Ответ на него не требуется.</i>"
            );
    }

    public static function send_mime_mail($name_from, // имя отправителя
                            $email_from, // email отправителя
                            $name_to, // имя получателя
                            $email_to, // email получателя
                            $data_charset, // кодировка переданных данных
                            $send_charset, // кодировка письма
                            $subject, // тема письма
                            $body, // текст письма
                            $noReplyText = true // noreply добавить текст
    ) {
        $toText = self::mime_header_encode($name_to, $data_charset, $send_charset);
        $emails = explode(",",$email_to);
        $to = "";
        foreach ($emails as $k=>$email) {
            if($k>0) {
                $to.=",";
            }
            $to .= $toText . ' <' . $email . '>';
        }
        $subject = self::mime_header_encode($subject, $data_charset, $send_charset);
        $from =  self::mime_header_encode($name_from, $data_charset, $send_charset)
            .' <' . $email_from . '>';
        if($data_charset != $send_charset) {
            $body = iconv($data_charset, $send_charset, $body);
        }

        if($noReplyText) {
            $body = self::get_text_with_no_reply_added($body, $send_charset);
        }

        $headers = "From: $from\r\n";
        $headers .= "Content-type: text/html; charset=$send_charset\r\n";
        $headers .= "Mime-Version: 1.0\r\n";

        return mail($to, $subject, $body, $headers);
    }

    public static function send_mime_mail_attachment($name_from, // имя отправителя
                                       $email_from, // email отправителя
                                       $name_to, // имя получателя
                                       $email_to, // email получателя
                                       $data_charset, // кодировка переданных данных
                                       $send_charset, // кодировка письма
                                       $subject, // тема письма
                                       $message, // текст письма
                                       $filename,
                                       $filepath,
                                       $emailFilename,
                                       $noReplyText = true // noreply добавить текст
    ) {
        $toText = self::mime_header_encode($name_to, $data_charset, $send_charset);
        $emails = explode(",",$email_to);
        $to = "";
        foreach ($emails as $k=>$email) {
            if($k>0) {
                $to.=",";
            }
            $to .= $toText . ' <' . $email . '>';
        }
        $subject = self::mime_header_encode($subject, $data_charset, $send_charset);
        $emailFilename = self::mime_header_encode($emailFilename, $data_charset, $send_charset);
        $from =  self::mime_header_encode($name_from, $data_charset, $send_charset)
            .' <' . $email_from . '>';
        if($data_charset != $send_charset) {
            $message = iconv($data_charset, $send_charset, $message);
        }
        if($noReplyText) {
            $message = self::get_text_with_no_reply_added($message, $send_charset);
        }

        $file = $filepath . "/" . $filename;

        $content = file_get_contents($file);
        $content = chunk_split(base64_encode($content));

        // a random hash will be necessary to send mixed content
        $separator = md5(time());

        // carriage return type (RFC)
        $eol = "\r\n";

        // main header (multipart mandatory)
        $headers = "From: $from\r\n";
        $headers .= "MIME-Version: 1.0" . $eol;
        $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
        $headers .= "Content-Transfer-Encoding: 7bit" . $eol;
        $headers .= "This is a MIME encoded message." . $eol;

        // message
        $body = "--" . $separator . $eol;
        $body .= "Content-Type: text/html; charset=\"$send_charset\"" . $eol;
        $body .= "Content-Transfer-Encoding: 8bit" . $eol;
        $body .= $eol . $message . $eol . $eol;

        // attachment
        $body .= "--" . $separator . $eol;
        $body .= "Content-Type: application/octet-stream; name=\"" . $emailFilename . "\"" . $eol;
        $body .= "Content-Transfer-Encoding: base64" . $eol;
        $body .= "Content-Disposition: attachment" . $eol;
        $body .= $eol . $content . $eol . $eol;
        $body .= "--" . $separator . "--";

        //SEND Mail
        return mail($to, $subject, $body, $headers);

    }

    public static function send_mime_mail_attachments($name_from, // имя отправителя
                                                     $email_from, // email отправителя
                                                     $name_to, // имя получателя
                                                     $email_to, // email получателя
                                                     $data_charset, // кодировка переданных данных
                                                     $send_charset, // кодировка письма
                                                     $subject, // тема письма
                                                     $message, // текст письма
                                                     $files,
                                                     $filepath,
                                                     $noReplyText = true // noreply добавить текст
    ) {
        $toText = self::mime_header_encode($name_to, $data_charset, $send_charset);
        $emails = explode(",",$email_to);
        $to = "";
        foreach ($emails as $k=>$email) {
            if($k>0) {
                $to.=",";
            }
            $to .= $toText . ' <' . $email . '>';
        }
        $subject = self::mime_header_encode($subject, $data_charset, $send_charset);

        $from =  self::mime_header_encode($name_from, $data_charset, $send_charset)
            .' <' . $email_from . '>';
        if($data_charset != $send_charset) {
            $message = iconv($data_charset, $send_charset, $message);
        }
        if($noReplyText) {
            $message = self::get_text_with_no_reply_added($message, $send_charset);
        }


        // a random hash will be necessary to send mixed content
        $separator = md5(time());

        // carriage return type (RFC)
        $eol = "\r\n";

        // main header (multipart mandatory)
        $headers = "From: $from\r\n";
        $headers .= "MIME-Version: 1.0" . $eol;
        $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
        $headers .= "Content-Transfer-Encoding: 7bit" . $eol;
        $headers .= "This is a MIME encoded message." . $eol;

        // message
        $body = "--" . $separator . $eol;
        $body .= "Content-Type: text/html; charset=\"$send_charset\"" . $eol;
        $body .= "Content-Transfer-Encoding: 8bit" . $eol;
        $body .= $eol . $message . $eol . $eol;

        $body .= "--" . $separator . $eol;
        foreach ($files as $file) {
            $emailFilename = self::mime_header_encode($file['emailFileName'], $data_charset, $send_charset);
            $file = $filepath . "/" . $file['fileName'];

            $content = file_get_contents($file);
            $content = chunk_split(base64_encode($content));
            // attachment
            $body .= "Content-Type: application/octet-stream; name=\"" . $emailFilename . "\"" . $eol;
            $body .= "Content-Transfer-Encoding: base64" . $eol;
            $body .= "Content-Disposition: attachment" . $eol;
            $body .= $eol . $content . $eol . $eol;
            $body .= "--" . $separator . $eol;
        }

        //SEND Mail
        return mail($to, $subject, $body, $headers);

    }

    public static function mime_header_encode($str, $data_charset, $send_charset) {
        if($data_charset != $send_charset) {
            $str = iconv($data_charset, $send_charset, $str);
        }
        return '=?' . $send_charset . '?B?' . base64_encode($str) . '?=';
    }
}