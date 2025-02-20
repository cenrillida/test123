<?

set_time_limit(300);
ini_set('post_max_size','200M');
ini_set('upload_max_filesize','200M');

include_once dirname(__FILE__)."/../../_include.php";

global $phorm;

require_once dirname(__FILE__) . '/../../includes/PHPExcel/PHPExcel.php';
require_once dirname(__FILE__) . '/../../includes/ImageUploader.php';

//$objPHPExcel = PHPExcel_IOFactory::load($_FILES['xml_file']['tmp_name']);

$objReader = new PHPExcel_Reader_Excel2007();

$objReader->setReadDataOnly(true);

$objPHPExcel = $objReader->load($_FILES['xml_file']['tmp_name'][0]);

$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
//var_dump($sheetData);

$autoDates = array();

$needImageUploader = false;

foreach($phorm->data() as $k => $v) {
    if($v['auto_type']=='date') {
        if(!empty($v['value'])) {
            $autoDates[$v['field']] = DateTime::createFromFormat("Y.m.d H:i",$v['value']);
        } else {
            $autoDates[$v['field']] = new DateTime();
        }

    }
    if($v['auto_type']=='file' && !empty($v['value'])) {
        $needImageUploader = true;
    }
}

$imageUploader = new ImageUploader();
if($needImageUploader) {
    $imageUploader->prepareUpload();
}

$ilines = new Ilines();
$iType = $ilines->getTypeById($_REQUEST["id"]);


$count = 1;
$rowCount=0;
foreach ($sheetData as $row) {
    $rowCount++;
    if(!empty($_REQUEST['xml_first_line']) && $rowCount<$_REQUEST['xml_first_line']) {
        continue;
    }
    $continue = true;
    $customDates = array();
    $files = array();
    $imageContinue = false;
    foreach($phorm->data() as $k => $v) {
        if(!isset($v["field"]) || $v['auto_type']=='date' || !isset($v['value']))
            continue;

        if(!empty($row[$v['value']])) {
            $continue = false;
            if($v['auto_type']=='file' && !empty($v['value'])) {
               if(empty($files[$v['value']])) {
                   $files[$v['value']] = $imageUploader->upload($row[$v['value']], $count);
                   $count++;
               }
                if(empty($files[$v['value']])) {
                   if($needImageUploader) {
                       $imageContinue = true;
                   }
               }
            }
            if($v['auto_type']=='date_custom') {
                $customDates[$v['field']] = $v['value'];
            }
        }
    }
    if($continue || $imageContinue) {
        continue;
    }
    $lid = $DB->query("INSERT INTO ?_ilines_element SET itype_id = ?d, el_date = UNIX_TIMESTAMP()", $_REQUEST["id"]);

    $addedFields = array();
    foreach($phorm->data() as $k => $v)
    {
        if(!isset($v["field"]))
            continue;

        $value = convertIfNeed($row[$v['value']],"UTF-8");
        if(empty($addedFields[$v['field']]) || !$addedFields[$v['field']]) {
            if($v['auto_type']=='date' || $v['auto_type']=='date_custom') {
                if(empty($customDates[$v['field']])) {
                    $value = $autoDates[$v['field']]->format("Y.m.d H:i");

                    if($iType['itype_el_sort_type']=="DESC") {
                        $autoDates[$v['field']]->sub(new DateInterval("PT1M"));
                    } else {
                        $autoDates[$v['field']]->add(new DateInterval("PT1M"));
                    }
                }
            }
            if($v['auto_type']=='file') {
                if(!empty($files[$v['value']])) {
                    if($v['img_quality']=='low') {
                        $imgPath = $files[$v['value']]['low'];
                    } else {
                        $imgPath = $files[$v['value']]['high'];
                    }
                    $value = "<p><img src=\"{$imgPath}\"  alt=\"\" /></p>";
                }
            }
            if($v['auto_type']=='status') {
                if(empty($v['value'])) {
                    $value = 1;
                }
            }

            $addedFields[$v['field']] = true;
            $DB->query("INSERT INTO ?_ilines_content SET el_id = ?d, icont_var = ?, icont_text = ?", $lid, $v["field"], $value);
        }
    }
}
if($needImageUploader) {
    $imageUploader->endUpload();
}

$cacheEngine = new CacheEngine();
$cacheEngine->reset();
Dreamedit::sendLocationHeader("https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."index.php?mod=" . $_REQUEST["mod"]."&action=edit&id=".$_REQUEST['id']);

?>