<?

//Заголовок блока
$head=$DB->select("
SELECT h1.icont_text AS head
FROM adm_headers_content AS h1
INNER JOIN adm_headers_content AS h2 ON h2.el_id = h1.el_id
AND h2.icont_var = 'value'
AND h2.icont_text = 'photo'
WHERE h1.icont_var = 'text'
LIMIT 0 , 30
");
//print_r($_SERVER);
//echo "****".substr($_SERVER[SCRIPT_FILENAME],0,-10);
//$dirdir= "/home/www/2008/html";
$dirdir=substr($_SERVER[SCRIPT_FILENAME],0,-10);
$dir0="/cpg1410/albums/userpics/10001" ;
$dir=$dirdir.$dir0;
$file_list=scandir($dir);
$width0=150;
//print_r($file_list);
//foreach($file_list as $flist)

for ($i=1;$i<100;$i++)
{
  $ind=array_rand($file_list);
    $flist=$file_list[$ind];

   if (substr($flist,0,5) != "thumb")
      break;
}


$spego=false;
echo "<table border=0 cellspacing='0' cellpadding='0'>
   <tr valign='top'><td background='/img/publicbg.png' align='center'>

   <img src='/img/public.png'/>
   <table cellspacing='0' cellpadding='0' border='0' width=160>
   <tr valign=top><td align='left'>

  <br>
  <table width=100% border=0 bordercolor='white'><tr><td>";

   echo str_replace('<a','<a class=smi',$head[0][head]);

      if (substr($flist,0,1) != ".")
	{

                 $size = getimagesize($dir."/".$flist);
//                 $fsize= filesize($dir."/".$flist);
                 $width=substr($size[3],7,strpos(substr($size[3],7),'"'));
                 $height=substr($size[3],strpos($size[3],"height")+8,-1);


//                   $res00=$DB->select("SELECT pid,aid FROM coppermine.cpg1410_pictures ".
//                        " WHERE filepath='userpics/10001/' AND filename='".$flist."'");

          //        $res0 = mysql_fetch_array($res00);



                 if ($width >= $width0)
                 {
                     echo "<table border=1 bordercolor='#c6c5d0' cellspacing='0' cellpadding='0'><td>";

                     if (empty($_SESSION[lang]))
					 echo "<a href=".$dir0."/".$flist." target='_blank'";
?>
						onclick="window.open(this.href,this.target,'width=<?=($width+20)?>,height=<?=($height+26)?>,'+
						'location=no,toolbar=no,menubar=no,status=no');return false;">
<?

                     echo "<img src=".$dir0."/".$flist.
                        " width = '".$width0."px' height='".($height/($width/$width0))."px'".
                     " /></a>";
                     echo "</td></table>";

                 }


    }


   echo "

        </td></tr></table>
        <br><br>
       <a href='/cpg1410'><font  size=2 color=white><u>Смотрите наш фотоальбом</u></font></a>
       <br /><br />
        </td></tr>
        </table>
        </td></tr>
        </table>";

