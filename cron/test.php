<?php

ini_set('display_errors','on');
header('content-type:text/plain');


include_once dirname(__FILE__)."/../dreamedit/includes/class.mailDomainSigner.php";

//$mail_text = 'Тест';


//$headers  = 'MIME-Version: 1.0' . "\r\n";
//$headers .= 'Content-type: text/html; charset=windows-1251' . "\r\n";
//$headers .= 'From: '.'=?WINDOWS-1251?B?'.base64_encode('ИМЭМО РАН').'?='.' <newsletter@imemo.ru>' . "\r\n";
//mail("alexqw1@yandex.ru", '=?WINDOWS-1251?B?'.base64_encode('Рассылка новостей').'?=', $mail_text."<br><a href=\"https://imemo.ru/newsletter_cancel.php?code=\">Отписаться от рассылки</a>",	$headers);


// Include Test Config File
include_once 'test.config.php';


// Mail Data
$from			= "<newsletter@imemo.ru>";
$to				= "<alexqw1@yandex.ru>";
$subject	= "Test PHP Mail Domain Signer";
$body			= "Congratulation...\r\n".
    "You had successfull signing your mail...\r\n";
// HEADERS
$headers = array();
$headers['from']		= "From: {$from}";
$headers['to']			= "To: {$to}";
$headers['subject']	= "Subject: {$subject}";
$headers['mimever'] = "MIME-Version: 1.0";
$headers['date'] 		= "Date: ".date('r');
$headers['mid']			= "Message-ID: <".sha1(microtime(true))."@{$domain_d}>";
$headers['ctype']		= "Content-Type: text/plain; charset=windows-1251";
$headers['cencod']	= "Content-Transfer-Encoding: quoted-printable";

// QP the Body
$body = quoted_printable_encode($body);

// Create mailDomainSigner Object
$mds = &new mailDomainSigner($domain_priv,$domain_d,$domain_s);

// Create DKIM-Signature Header
$dkim_sign = $mds->getDKIM(
    "from:to:subject:mime-version:date:message-id:content-type:content-transfer-encoding",
    array(
        $headers['from'],
        $headers['to'],
        $headers['subject'],
        $headers['mimever'],
        $headers['date'],
        $headers['mid'],
        $headers['ctype'],
        $headers['cencod']
    ),
    $body
);

// Create DomainKey-Signature Header
$domainkey_sign = $mds->getDomainKey(
    "from:to:subject:mime-version:date:message-id:content-type:content-transfer-encoding",
    array(
        $headers['from'],
        $headers['to'],
        $headers['subject'],
        $headers['mimever'],
        $headers['date'],
        $headers['mid'],
        $headers['ctype'],
        $headers['cencod']
    ),
    $body
);

// Create Email Data, First Headers was DKIM and DomainKey
$email_data = "{$dkim_sign}\r\n";
$email_data.= "{$domainkey_sign}\r\n";

// Include Other Headers
foreach($headers as $val){
    $email_data.= "{$val}\r\n";
}

// OK, Append the body now
$email_data.= "\r\n{$body}";


// What is the result? :D
//echo $email_data;
mail("", '', '', $email_data);


?>