<?

header("Content-type: text/plain; charset=windows-1251");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
global $DB,$_CONFIG;
//echo "<br />GET ";
//print_r($_POST);
//print_r($_GET);

/*if (isset($a))
{
  for ($i=1; $i < 10000; $i++)
    {
        echo 'Это тестовая строка. ';
	    if (($i % 1000) == 0) flush();
	      }
	      }

	      if (count($_GET) > 0)
	      {
	        echo "\n\nПередано GET'ом\n"; print_r($_GET);
		}
*/

if ($_GET['chois']!=0) // надо записать
 {

    $conn = mysql_connect("localhost", $_GET['dbuser'], $_GET['dbpswd']) or die(mysql_error());
	mysql_select_db($_GET['dbname'], $conn) or die(mysql_error());

    $res00=mysql_query("SELECT * FROM poll WHERE poll_id=".$_GET[id_poll]);

    $res0 = mysql_fetch_array($res00);
$aa=0;
    if (empty($res0))
    {
    $aa="@@";
       $a= mysql_query("INSERT INTO poll VALUES(0,".$_GET[id_poll].",0,0,0,0,0,0,0,0,0,0,".
                "'".date(Ymd)."')") ;
    }
        $iii=$res0[$_GET[chois]+1]+1;
        $a=mysql_query("UPDATE poll SET choice".$_GET['chois'] . "=".$iii.
	  ", date='".date(Ymd)."'".
          " WHERE poll_id=".$_GET[id_poll]);



  }




echo "<?xml version=\"1.0\" encoding=\"windows-1251\" ?>
<poll><choices>";

$sum=0;
$res01=mysql_query("
    SELECT * FROM poll
    WHERE poll_id=".$_GET['id_poll']
    );
//
//    v1.icont_text AS ans1, v2.icont_text AS ans2,
//    v3.icont_text AS ans3, v4.icont_text AS ans4,
//    v5.icont_text AS ans5
//    FROM poll
//    INNER JOIN adm_polls_content as p ON p.el_id=poll.poll_id AND p.icont_var='title'
//    INNER JOIN adm_polls_content as v1 ON v1.el_id=poll.poll_id AND v1.icont_var='variant1'
//    INNER JOIN adm_polls_content as v2 ON v2.el_id=poll.poll_id AND v2.icont_var='variant2'
//    INNER JOIN adm_polls_content as v3 ON v3.el_id=poll.poll_id AND v3.icont_var='variant3'
//    INNER JOIN adm_polls_content as v4 ON v4.el_id=poll.poll_id AND v4.icont_var='variant4'
//    INNER JOIN adm_polls_content as v5 ON v5.el_id=poll.poll_id AND v5.icont_var='variant5'
//    WHERE poll_id=".$_GET['id_poll'].
//    " GROUP BY choise");
$res=mysql_fetch_array($res01);
$i=0;
/*    while($row = mysql_fetch_array($res))
    {
          if ($i==0) {
             for($ii=1;$ii<6;$ii++)
             {
                echo "<choice>" ;
                    echo "<text>".$ii."</text>";
                    echo "<percent>"."000"."</percent>";
                echo "</choice>\n";

             }

             $i=1;
	  }
	  echo "<choice>" ;
               echo "<text>***</text>";
               echo "<percent>".$row['choice.$ii']."</percent>";
          echo "</choice>\n";
          $in=$_GET[chois];
          $sum=$sum+$row['choice.$i'];
    }
*/
// Разобрали на записи

     for($i=1;$i<11;$i++)
     {
        echo "<choice>" ;
//            echo "<text>"."n".$i."</text>";
            echo "<text>".$res[poll_id]."</text>";
            echo "<percent>".$res[$i+1]."</percent>";
        echo "</choice>\n";
        $sum=$sum+$res[$i+1];
     }
     echo "</choices>";
     echo "<totalVoted>".$sum."</totalVoted>";
     echo "</poll>";

?>