<?
echo "<br /><b>SAVE</b>";
//print_r($_POST);
 include_once substr($_CONFIG["global"]["paths"]['admin_path'],0,-10)."classes/guid/guid.php";
 if ($_POST['elogo']!="on")
 {
  $filenames=$_POST[pic1];
   $filenameb=$_POST[pic2];
   $filenamem=$_POST[pic3];
 }
else
{
   $filenames='e_book.jpg';
   $filenameb="";
   $filenamem="";

} 
   if (($filenames=="" || $filenameb=="" || $filenamem=="") && $_POST[ebook] == "on")
   {
   	  $filenames="ebooksmall.jpg";
      $filenameb="ebook.jpg";
   }

//print_r($_POST);

 if ($_POST['elogo']!="on")
 {
if ($_FILES[pic1][tmp_name]<> "")
{
  $guid=new guid();
  if (empty($filenames)) $filenames=str_replace("-","_",$guid->tostring())."_s.jpg";
  $filenames=str_replace("-","_",$guid->tostring())."_s.jpg";
  $uploaddir = $_CONFIG['global']['paths'][admin_path]."pfoto/";
echo "pic1".$filenames;
  $a=move_uploaded_file($_FILES['pic1']['tmp_name'], $uploaddir.$filenames) ;
  
  $_POST[pic1]=$filenames;
}

if ($_FILES[pic2][tmp_name]<>"")
{
  $guid=new guid();
  if (empty($filenameb)) $filenameb=str_replace("-","_",$guid->tostring())."_b.jpg";
$filenameb=str_replace("-","_",$guid->tostring())."_b.jpg";
  $uploaddir = $_CONFIG['global']['paths'][admin_path]."pfoto/";

  move_uploaded_file($_FILES['pic2']['tmp_name'], $uploaddir.$filenameb);
  $_POST[pic2]=$filenameb;
}

if ($_FILES[pic3][tmp_name]<>"")
{
  $guid=new guid();
  if (empty($filenamem)) $filenamem=str_replace("-","_",$guid->tostring())."_m.jpg";
$filenamem=str_replace("-","_",$guid->tostring())."_m.jpg";
  $uploaddir = $_CONFIG['global']['paths'][admin_path]."pfoto/";

  move_uploaded_file($_FILES['pic3']['tmp_name'], $uploaddir.$filenamem) ;
  $_POST[pic3]=$filenamem;
}
}
else
$_POST[pic1]='e_logo.jpg';
//echo

if(!empty($_POST['date_publ'])) {
    $dateTime = DateTime::createFromFormat('Y-m-d', $_POST['date_publ']);
    if(!empty($dateTime)) {
        $pdate = $dateTime->format("d.m.y");
    } else {
        $pdate = date('d.m.y');
    }
} else {
    $pdate = date('d.m.y');
}

if ($_POST[status]=='on') $_POST[status]=1;
else $_POST[status]=0;
if ($_POST[out_from_print]=='on') $_POST[out_from_print]=1;
else $_POST[out_from_print]=0;
if ($_POST[no_publ_ofp]=='on') $_POST[no_publ_ofp]=1;
else $_POST[no_publ_ofp]=0;
if ($_POST[dynkin_piar]=='on') $_POST[dynkin_piar]=1;
else $_POST[dynkin_piar]=0;
if ($_POST[r1]=='on' && !empty($_POST[rubric2])) $_POST[rubric2]="r".$_POST[rubric2];
if ($_POST[r2]=='on' && !empty($_POST[rubric2d])) $_POST[rubric2d]="r".$_POST[rubric2d];
if ($_POST[r3]=='on' && !empty($_POST[rubric2_3])) $_POST[rubric2_3]="r".$_POST[rubric2_3];
if ($_POST[r4]=='on' && !empty($_POST[rubric2_4])) $_POST[rubric2_4]="r".$_POST[rubric2_4];
if ($_POST[r5]=='on' && !empty($_POST[rubric2_5])) $_POST[rubric2_5]="r".$_POST[rubric2_5];

if ($_POST[vid_inion]=='on' && !empty($_POST[vid_inion])) $_POST[vid_inion]="1";
//if ($_POST[rinc]=='on' && !empty($_POST[rinc])) $_POST[rinc]="1";

if ($_POST[formain]=='on') $_POST[formain]=1;

global $DB;

$_POST[eid] = isset($_POST[eid])? (int)$_POST[eid]: $DB->query("INSERT INTO publ SET id = 0");

if (empty($_POST['uri'])) {
    if (!empty($_POST['name_title'])) {
        $latName = Dreamedit::cyrToLat($_POST['name_title']);
    } elseif(!empty($_POST['name2'])) {
        $latName = Dreamedit::cyrToLat($_POST['name2']);
    } else {
        $latName = Dreamedit::cyrToLat($_POST['name']);
    }
    $latName = str_replace("(", "-", $latName);
    $latName = str_replace(")", "-", $latName);
    $latName = preg_replace("/[^a-zA-Z-\d ]/", "", $latName);
    $latName = preg_replace("/ +/", " ", $latName);

    $latName = ltrim(rtrim($latName));
    $latName = str_replace(" ", "-", $latName);
    $latName = preg_replace("/-+/", "-", $latName);
    $latName = ltrim(rtrim($latName,"-"),"-");
    $latName = mb_strtolower($latName);

    $latName = Dreamedit::cyrToLatExcl($latName);


} else {
    $latName = $_POST['uri'];
}
if(empty($latName)) {
    $latName = "publ";
}

while (true) {
    $used = $DB->select("SELECT * FROM publ WHERE uri=?",$latName);

    $sameId = false;
    foreach ($used as $value) {
        if($value[id] == $_POST[eid]) {
            $sameId = true;
        }
    }
    if (!empty($used) && !$sameId) {
        $latName .= "-" . $_POST[eid];
    } else {
        break;
    }
}

$_POST['uri'] = $latName;

$avt0=explode("<br>",trim($_POST['matrix']));
$i=0;

$affiliationsArray = array();
$rolesArray = array();


foreach($avt0 as $avt)
{
    if(!empty($_POST['affiliation_hidden'.$i])) {
        $affiliations = explode("{{{DELIMITER}}}",$_POST['affiliation_hidden'.$i]);
        $affiliationsArray[$i] = array();
        foreach ($affiliations as $affiliation) {
            if(!empty($affiliation)) {
                $affiliationsArray[$i][] = $affiliation;
            }
        }
    }
    if(!empty($_POST['role_hidden'.$i])) {
        $rolesArray[$i] = $_POST['role_hidden'.$i];
    } else {
        $rolesArray[$i] = 620;
    }
    $i++;
}

$affiliationsSerialized = serialize($affiliationsArray);
$rolesSerialized = serialize($rolesArray);


$request = "UPDATE publ SET 
`name`=?,
`year`=?,
`vid`=?,
`vid_inion`=?d,
`tip`=?,
`avtor`=?,
`people_linked`=?,
`rubric`=?,
`annots`=?,
`annots_en`=?,
`link`=?,
`link_en`=?,
`date`=?,
`keyword`=?,
`keyword_en`=?,
`izdat`=?,
`doi`=?,
`formain`=?d,
`name2`=?,
`name_title`=?,
`hide_autor`=?,
`picsmall`=?,
`picbig`=?,
`picmain`=?,
`status`=?d,
`out_from_print`=?d,
`dynkin_piar`=?d,
`no_publ_ofp`=?d,
`rubric`=?,
`rubric2`=?,
`rubric2d`=?,
`rubric2_3`=?,
`rubric2_4`=?,
`rubric2_5`=?,
`format`=?d,
`date_fact`=?,
`pages`=?,
`land`=?d,
`parent_id`=?d,
`page_beg`=?d,
`uri`=?,
`rinc`=?,
`people_affiliation_en`=?,
`people_role`=?
WHERE id=?d
";


//$request = "UPDATE publ SET ".
//		'name= "'. str_replace('"','\"',str_replace("'","\'",$_POST['name'])). '"'.", ".
//		"year='". $_POST['date']. "', ".
//		"vid='".$_POST['vid']. "', ".
//		"vid_inion='".$_POST['vid_inion']. "', ".
//		"tip='".$_POST['tip']. "', ".
//		"avtor='".$_POST['matrix']. "', ".
//        "people_linked='".$_POST['matrix2']. "', ".
//		"rubric='".$_POST['returns']. "', ".
//		'annots="'.str_replace('"','\"',str_replace("'","\'",$_POST['annots'])). '"'.", ".
//		'annots_en="'.str_replace('"','\"',str_replace("'","\'",$_POST['annots_en'])). '"'.", ".
//		"link='".$_POST['plink']. "', ".
//		"link_en='".$_POST['plink_en']. "', ".
//		"`date`='".$pdate. "', ".
//		"keyword='".$_POST['keyword']. "', ".
//		"keyword_en='".$_POST['keyword_en']. "', ".
//		"izdat='".$_POST['izdat']. "', ".
//		"doi='".$_POST['doi']. "', ".
//		"formain='".$_POST['formain']. "', ".
//		'name2="'.str_replace('"','\"',str_replace("'","\'",$_POST["name2"])).'"'.", ".
//		'name_title="'.str_replace('"','\"',str_replace("'","\'",$_POST["name_title"])).'"'.", ".
//		"`hide_autor`='".$_POST['hide_autor'] ."', ".
//		"picsmall='".$_POST['pic1']."', ".
//		"picbig='".$_POST['pic2']."',".
//		"picmain='".$_POST['pic3']."',".
//		"status='".$_POST['status']."',".
//		"out_from_print='".$_POST['out_from_print']."',".
//		"dynkin_piar='".$_POST['dynkin_piar']."',".
//        "no_publ_ofp='".$_POST['no_publ_ofp']."',".
//		"rubric='".$_POST['rubric']."',".
//		"rubric2='".$_POST['rubric2']."',".
//		"rubric2d='".$_POST['rubric2d']."',".
//		"rubric2_3='".$_POST['rubric2_3']."',".
//		"rubric2_4='".$_POST['rubric2_4']."',".
//		"rubric2_5='".$_POST['rubric2_5']."',".
//		"format=".$_POST['format'].",".
//		"date_fact='".$_POST['date_fact']."',".
//		"pages='".$_POST['pages']."',".
//		"land='".$_POST['land']."',".
//		"parent_id='".$_POST['parent_id']."',".
//		"page_beg='".$_POST['page_beg']."',".
//        "uri='".$_POST['uri']."',".
//		"rinc='".$_POST['rinc']."'".
//		" WHERE id=".$_POST[eid]
//		  ;

$DB->query($request,
    $_POST['name'],
    $_POST['date'],
    $_POST['vid'],
    $_POST['vid_inion'],
    $_POST['tip'],
    $_POST['matrix'],
    $_POST['matrix2'],
    $_POST['returns'],
    $_POST['annots'],
    $_POST['annots_en'],
    $_POST['plink'],
    $_POST['plink_en'],
    $pdate,
    $_POST['keyword'],
    $_POST['keyword_en'],
    $_POST['izdat'],
    $_POST['doi'],
    $_POST['formain'],
    $_POST["name2"],
    $_POST["name_title"],
    $_POST['hide_autor'],
    $_POST['pic1'],
    $_POST['pic2'],
    $_POST['pic3'],
    $_POST['status'],
    $_POST['out_from_print'],
    $_POST['dynkin_piar'],
    $_POST['no_publ_ofp'],
    $_POST['rubric'],
    $_POST['rubric2'],
    $_POST['rubric2d'],
    $_POST['rubric2_3'],
    $_POST['rubric2_4'],
    $_POST['rubric2_5'],
    $_POST['format'],
    $_POST['date_fact'],
    $_POST['pages'],
    $_POST['land'],
    $_POST['parent_id'],
    $_POST['page_beg'],
    $_POST['uri'],
    $_POST['rinc'],
    $affiliationsSerialized,
    $rolesSerialized,
    $_POST['eid']);

$cacheEngine = new CacheEngine();
$cacheEngine->reset();


?>

ѕубликаци€ сохранена. id= <? echo $_POST[eid] ?>

<br>
¬ы будете перенаправлены на главную страницу через 30 секунды

<meta http-equiv=refresh content="3; url=index.php?mod=public">

