<?
include_once dirname(__FILE__)."/../../_include.php";
include_once "mod_fns.php";
global $DB;
$emails = $DB->select("SELECT * FROM newsletter_users");
?>

<div>
	<p><b>Количество подписок:</b> <?=count($emails)?></p>
	<?php foreach ($emails as $email): ?>
	<div style="color: darkgrey"><?=$email['email']?></div>
	<?php endforeach;?>
</div>