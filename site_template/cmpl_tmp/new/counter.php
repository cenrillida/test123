<?php
global $DB;
$visitor_ip = $_SERVER['REMOTE_ADDR'];
$date = date("Y-m-d");


$res = $DB->select("SELECT id FROM magazine_visits WHERE date='".$date."' AND magazine='".$_SESSION[jour_url]."'");



if (count($res) == 0)
{
    $DB->query("DELETE FROM magazine_ip_visits WHERE magazine='".$_SESSION[jour_url]."'");
    $DB->query("INSERT INTO magazine_ip_visits (address,magazine) VALUES('".$visitor_ip."', '".$_SESSION[jour_url]."')");
	//echo '<a style="display: none;" href="counter">'.$DB->error.'</a>';
    $DB->query("INSERT INTO magazine_visits SET date='".$date."', hosts=1, views=1, magazine='".$_SESSION[jour_url]."'");
}
else
{
    $current = $DB->select("SELECT id FROM magazine_ip_visits WHERE address='".$visitor_ip."' AND magazine='".$_SESSION[jour_url]."'");
    if (count($current) == 1)
    {
        $DB->query("UPDATE magazine_visits SET `views`=`views`+1 WHERE date='".$date."' AND magazine='".$_SESSION[jour_url]."'");
    }
    else
    {
        $DB->query("INSERT INTO magazine_ip_visits SET address='".$visitor_ip."', magazine='".$_SESSION[jour_url]."'");
        $DB->query("UPDATE magazine_visits SET `hosts`=`hosts`+1,`views`=`views`+1 WHERE date='".$date."' AND magazine='".$_SESSION[jour_url]."'");
    }
}

?>