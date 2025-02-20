<?
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
header("Content-Type: text/xml; charset=windows-1251");


//global $DB,$_CONFIG;
//////////////////////////////////////
// set these variables for your MySQL
$dbhost = 'host';	// usually localhost
$dbuser = 'imemo';	// database username
$dbpass = '3517';		// database password
$dbname = 'imemo';
//////////////////////////////////////
$month_name=array("",'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
$db = mysql_connect('localhost', 'imemon', 'phai5reRe3') or die ("<?xml version=\"1.0\" ?><response><content><![CDATA[<span class='error'>Database connection failed.</span>]]></content></response>");
mysql_select_db('imemon');

// подключаем клас дл€ работы с календарем
//include_once $_CONFIG["global"]["paths"]["admin_path"]."includes/class.Events.php";

if ($_GET['spisok']!="")
{
   $ilines_spisok=$_GET[spisok];

}
if ($_GET[month]!="")
   $mm=$_GET['month'];
else
   $mm=date('m');
if ($_GET[year] !="")
    $yy=$_GET['year'];
else
    $yy=date("Y");

$page_id=$_GET['result_id'];
if (empty($page_id)) $page_id=498;
//—читать список дат

   $il0=explode(",",trim($ilines_spisok));
        $str="(";
        foreach($il0 as $il)
        {
           $str.=" e.itype_id=".$il." OR ";
        }
        $str=substr($str,0,-4).")";



		$result = mysql_query(
			"SELECT DISTINCT day(c.icont_text) AS date_event
			FROM adm_ilines_content AS c
			INNER JOIN adm_ilines_element AS e
			      ON e.el_id=c.el_id AND ".$str.
			" INNER JOIN adm_ilines_content AS c2 ON c2.el_id=c.el_id AND c2.icont_var='status' AND c2.icont_text=1  ".
			" INNER JOIN adm_ilines_content AS nn ON nn.el_id=c.el_id AND nn.icont_var='title_en'  ".
            " LEFT OUTER JOIN  adm_ilines_content AS s2 ON s2.el_id=c.el_id AND s2.icont_var='status2' ".
			" WHERE (c.icont_var='date' OR c.icont_var='date2')
			 AND month(c.icont_text)=".$mm .
			" AND year(c.icont_text)=".$yy.
            	" AND (e.itype_id<> 15 OR s2.icont_text=1) ".
			" ORDER BY day(c.icont_text)");
        $sp=";;";
        while($row = mysql_fetch_array($result)) {
            $sp.=$row[date_event].";";
        }

//$sp="";
$xml = '<?xml version="1.0" encoding="windows-1251" ?><response><content><![CDATA[';

{
	$month = $_GET['month'];
	$year = $_GET['year'];

	if($month == '' && $year == '') {
		$time = time();
		$month = date('n',$time);
	    $year = date('Y',$time);
	}

	$date = getdate(mktime(0,0,0,$month,1,$year));
	$today = getdate();
	$hours = $today['hours'];
	$mins = $today['minutes'];
	$secs = $today['seconds'];

	if(strlen($hours)<2) $hours="0".$hours;
	if(strlen($mins)<2) $mins="0".$mins;
	if(strlen($secs)<2) $secs="0".$secs;

	$days=date("t",mktime(0,0,0,$month,1,$year));
	$start = $date['wday']+1;
	$nameen = $date['month'];
    $ll=$month;
    if (substr($ll,0,1)=="0")
       $ll=substr($month,1,1);
	$name = $month_name[$ll];  // ѕоставить мес€ц по-русски

	$year2 = $date['year'];
	if ($start==1) $start=8;
	$sss=$start;
	$offset = $days + $start - 1;

	if($month==12) {
		$next=1;
		$nexty=$year + 1;
	} else {
		$next=$month + 1;
		$nexty=$year;
	}

	if($month==1) {
		$prev=12;
		$prevy=$year - 1;
	} else {
		$prev=$month - 1;
		$prevy=$year;
	}

	if($offset <= 29) $weeks=29;
	elseif($offset > 36) $weeks = 41;
	else $weeks = 35;
	$days0=date("t",mktime(0,0,0,$month,1,$year2));

    $refmon="/en/index.php?page_id=".$page_id."&td1=".sprintf('%04d.%02d.%02d',$year2,$month,'01').
            "&td2=".sprintf('%04d.%02d.%02d', $year2, $month, $days0); //$year2.".".$month.".".$days0;
    $refyear="/en/index.php?page_id=".$page_id."&td1=".$year2.".01.01".
            "&td2=".$year2.".12.31";
	$xml .= "<table class='cal' cellpadding='0' cellspacing='01' >
			<tr>
				<td colspan='8' class='calhead'>
					<table>
					<tr>
						<td>
							<a href='javascript:navigate($prev,$prevy,\"\"
							,\"$dbhost\",\"$dbname\",\"$dbuser\",\"$dbpass\",\"$ilines_spisok\",\"$page_id\"
							)' style='border:none'><img src='/calendar/images/calLeft.gif' title='Previous Month' /></a>
							<a href='javascript:navigate(\"\",\"\",\"\",\"$dbhost\",\"$dbname\",\"$dbuser\",\"$dbpass\",\"$ilines_spisok\",\"$page_id\")'
									style='border:none'><img src='/calendar/images/calCenter.gif' title='Current Date' /></a>
							<a href='javascript:navigate($next,$nexty,\"\",\"$dbhost\",\"$dbname\",\"$dbuser\",\"$dbpass\",\"$ilines_spisok\",\"$page_id\")'
							        style='border:none'><img src='/calendar/images/calRight.gif' title='Next Month' /></a>
							<a href='javascript:void(0)' onClick='showJump(this)' style='border:none'>
							    <img src='/calendar/images/calDown.gif' title='Search Month, Year' /></a>
						</td>
						<td align='right'>
							<a title='News this Month' href=$refmon>&nbsp;$name&nbsp;</a>
							<a title='News this Year' href=$refyear>&nbsp;$year2&nbsp;</a>
						</td>
					</tr>
					</table>
				</td>
			</tr>
			<tr class='dayhead'>

				<td>Su</td>
				<td>Mn</td>
				<td>Tu</td>
				<td>Wd</td>
				<td>Th</td>
				<td>Fr</td>
				<td>Sa</td>
				
				<td>Weerly</td>

			</tr>";


    $days0=date("t",mktime(0,0,0,$prev,1,$prevy));
    $td10=$prevy.".".$prev.".01";
    $td20=$prevy.".".$prev.".".$days0;
    $td1n=$nexty.".".$next.".01";
    $td2n=$nexty.".".$next.".".$days0;

	$col=1;
	$cur=1;
	$next=0;
    $dat1=1;
    $week_event=false;

	for($i=1;$i<=$weeks;$i++) {
		if($next==3) $next=0;
		if($col==1) $xml.="\n<tr class='dayrow'>";


		$xml.="\t<td valign='top' onMouseOver=\"this.className='dayover'\" onMouseOut=\"this.className='dayout'\">";


		if($i <= ($days+($start-1)) && $i >= $start) {
			$xml.="<div class='day'><span ";

           if($col==1)
            {
              $dat1=$cur;
              $week_event=false;
			}
           if(($cur==$today[mday]) && ($nameen==$today[month]) && ($year2==$today[year]))
                  $xml.=" style='color:#e49d05;font-weight: bold;'";

            if (strpos($sp,";".$cur.";")!=0 || ($cur==1 && substr($sp,0,3)==";1;")) {
            	 $mmm=$month;

            	if ($cur<10) $ddd="0".$cur;
            	else $ddd=$cur;
                $td=$year.".".$mmm.".".$ddd;
			    $xml.="<div class='calevent'><b><a title='News for this Date' href='/en/index.php?page_id=".$page_id."&td1=".$td."&td2=".$td."'>";
                $xml.="$cur</b></a></span></div>";
                $week_event=true;
			}
            else
               $xml.="> $cur</span></div>";
			$xml.="\n\t</td>\n";

			$cur++;
			$col++;

		} else {
			$xml.="&nbsp;\n\t</td>\n";
			$col++;
		}

	    if($col==8) {
////

            $xml.="<td><div class='calevent'>";

            if ($week_event)
            {
                $td1=sprintf("%04d.%02d.%02d", $year, $month, $dat1);
                $td2=sprintf("%04d.%02d.%02d", $year, $month, ($cur-1));
                $xml.="<div class='calevent'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a title='News for this Weekly' href='/en/index.php?page_id=".$page_id."&td1=".$td1."&td2=".$td2."'><b>review</b></a></div>";
            }
            else
               $xml.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>review</b>&nbsp;&nbsp;&nbsp;&nbsp;";

           $xml.="</div></td>";
		    $xml.="\n</tr>\n";

		    $col=1;
	    }

	}

    if ($col<>1) {
        $xml.="<td>&nbsp;</td>";
        $xml.="<td><div class='calevent'>";
            if ($week_event)
            {
                $td1=sprintf("%04d.%02d.%02d", $year, $month, $dat1);
                $td2=sprintf("%04d.%02d.%02d", $year, $month, ($cur-1));
                $xml.="<div class='calevent'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a title='News for this Weekly href='/en/index.php?page_id=".$page_id."&td1=".$td1."&td2=".$td2."'><b>review</b></a></div>";
            }
            else
               $xml.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>review</b>&nbsp;";
            $xml.="</div></td>";
		    $xml.="\n</tr>\n";
		    $col=1;
	    }

	$xml.="</table>";
    $xml.="<div ><strong>Today: </strong>".date("d.m.Y")."</div>";
}

$xml .= "]]></content></response>";
echo $xml;

?>
