<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>YouTube Properties</title>
	<meta http-equiv="Content-Type" content="text/html; charset=Windows-1251">
	<meta content="noindex, nofollow" name="robots">
	<script src="../../dialog/common/fck_dialog_common.js" type="text/javascript"></script>
	<script src="youtube.js" type="text/javascript"></script>
	<link href="../../dialog/common/fck_dialog_common.css" type="text/css" rel="stylesheet">
</head>




<body scroll="no" style="OVERFLOW: hidden">
<?

   $url=$_GET[backurl];

   if(!empty($url))
   {
	   $file = fopen ($url, "r");
	   $str = "";
		while (!feof ($file)){
		$str .= fread ($file, 512);
		}
		fclose ($file);
	    $filter=".flv";
 	  $pos = strpos($str,$filter) + 3;
 	  for($i=$pos;$i>$pos-1000;$i--)
 	  {
 	  	if($str[$i]=="\"")
 	  		break;
 	  }
 	  $flv = "Файл видео не найден";
      if($pos>3)
		$flv = substr($str,$i+1,($pos-$i));
    }


?>
	<div id="divInfo">
	      <table cellSpacing="1" cellPadding="1" width="100%" border="0">
    		<tr>
				<td>
					<fieldset>
					<legend><span fckLang="DlgYouTubeQuality">Источник видео (аудио)</span>:</legend>
					<table cellSpacing="0" cellPadding="0" border="0">
						<tr>
							<td nowrap>
								<input type="radio" id="radioWebTvNews" name="qlty" value="WebTVNews" checked onClick="showFind();">
								<span fckLang="DlgWebTVNews">На сайте</span>
							</td>
							<td>&nbsp;</td>
							<td>
								<input type="radio" id="radioYouTube" name="qlty" value="YouTube" onClick="hideFind();">
								<span fckLang="DlgYouTube">YouTube</span>
							</td>
						</tr>
					</table>
				</fieldset>
				</td>
			</tr>
			<tr>
				<td>

					<table cellSpacing="0" cellPadding="0" width="100%" border="0">
						<tr>
							<td width="100%"><span fckLang="DlgYouTubeURL">URL</span>
							</td>
						</tr>
						<tr>
							<td vAlign="top"><input id="txtUrl" style="WIDTH: 90%" type="text" value="<?echo "http://".$url; ?>">

							</td>
							<td>
								<div id="find1">
									<input type=button onClick="BrowseServer();" value="Найти видео (аудио)"></input>
								</div>

							</td>

						</tr>
						<tr>
	<!--						<td width="100%">
								<div id="find2">
									<input id="txtVideo" type='text'style="WIDTH: 100%" value ='<? echo $flv?>' ></input>
								</div>

							</td>
	-->
						</tr>  <tr><td>&nbsp;</td></tr>
						<tr>
							<td vAlign="top"><input id="imgUrl" style="WIDTH: 90%" type="text" value="<?echo $imgurl; ?>">

							</td>

							<td>
								<div id="find2">
									<input type=button onClick="BrowseServerImg();" value="Найти картинку"></input>
								</div>

							</td>

						</tr>
					</table>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<table cellSpacing="0" cellPadding="0" border="0">
						<tr>
							<td nowrap>
								<span fckLang="DlgYouTubeWidth">Width</span><br>
								<input id="txtWidth" onkeypress="return IsDigit(event);" type="text" size="3" value="512">
							</td>
							<td>&nbsp;</td>
							<td>
								<span fckLang="DlgYouTubeHeight">Height</span><br>
								<input id="txtHeight" onkeypress="return IsDigit(event);" type="text" size="3" value="288">
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>
