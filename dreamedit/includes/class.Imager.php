<?

// � ���� �� �����, �� �����-������ ����������� �� �����!
/*
function image_save($image, $category, $name = $image["name"])
{
	if(empty($image["name"]))
	{
		return translate("����������� �� ���������.");
	}

//	if($pic["size"] < 0  || $pic["size"] > MAX_SIZE)
	if($pic["size"] < 0)
	{
		 return translate("�������� ������ �����������.");
	}

	if(is_dir($category))
	{
		return translate("��������� ������� �� ������.");
	}

	$file_ext = pathinfo($image["name"]);
	$extensions = array("gif", "jpg", "jpeg", "png");
	if(!in_array($file_ext["extension"], $extensions))
	{
		return translate("���������������� ������ �����������.");
	}

	if(file_exists($category.$name))
	{
		return translate("����������� � ������ ������ ��� ����������.");
	}

	$upfile = $category.$name;
	
	if(!move_uploaded_file($image["tmp_name"], $upfile)) 
	{
		return translate("���������� ������� ������.");
	}

	return true;
}


function image_resize($image, $category = dirname($image), $width = 100, $height = 100, $prefix = "preview_")
{
	$size = getimagesize($image);

	if($size['mime'] == "image/gif")
		$im = imagecreatefromgif($image);
	if($size['mime'] == "image/jpeg" || $size['mime'] == "image/pjpeg")
		$im = imagecreatefromjpeg($image);
	if($size['mime'] == "image/png")
		$im = imagecreatefrompng($image);

	if(!($size[0] <= $width) || !($size[1] <= $height))	
	{
		$w = $width / $size[0];
		$h = $height / $size[1];
		$k = min($w, $h);
		$new_size = array($size[0] * $k, $size[1] * $k);
		
		$rzd = imagecreatetruecolor($new_size[0], $new_size[1]);
		imagecopyresampled($rzd, $im, 0, 0, 0, 0, $new_size[0], $new_size[1], $size[0], $size[1]);		
		imagejpeg($rzd, $category."/".$prefix.basename($image), 80);
		return;
	}
	imagejpeg($im, $category."/".$prefix.basename($image), 80);
}
*/
?>