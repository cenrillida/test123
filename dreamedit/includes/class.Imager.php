<?

// я пока не класс, но когда-нибудь обязательно им стану!
/*
function image_save($image, $category, $name = $image["name"])
{
	if(empty($image["name"]))
	{
		return translate("Изображение не загружено.");
	}

//	if($pic["size"] < 0  || $pic["size"] > MAX_SIZE)
	if($pic["size"] < 0)
	{
		 return translate("Неверный размер изображения.");
	}

	if(is_dir($category))
	{
		return translate("Указанный каталог не найден.");
	}

	$file_ext = pathinfo($image["name"]);
	$extensions = array("gif", "jpg", "jpeg", "png");
	if(!in_array($file_ext["extension"], $extensions))
	{
		return translate("Неподдерживаемый формат изображения.");
	}

	if(file_exists($category.$name))
	{
		return translate("Изображение с данным именем уже существует.");
	}

	$upfile = $category.$name;
	
	if(!move_uploaded_file($image["tmp_name"], $upfile)) 
	{
		return translate("Обнаружена попытка взлома.");
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