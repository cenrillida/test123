<?
/**
 * The PHP Image Editor user interface.
 * @author $Author: Wei Zhuo $
 * @author $Author: Paul Moers <mail@saulmade.nl> $ - watermarking and replace code + several small enhancements <http://fckplugins.saulmade.nl>
 * @version $Id: editor.php 26 2004-03-31 02:35:21Z Wei Zhuo $
 * @package ImageManager
 */

require_once('config.inc.php');
require_once('Classes/ImageManager.php');
require_once('Classes/ImageEditor.php');

$manager = new ImageManager($IMConfig);
$editor = new ImageEditor($manager, $IMConfig);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
<title>edit image</title>
<link href="assets/editor.css" rel="stylesheet" type="text/css" />	

<script type="text/javascript">
/*<![CDATA[*/

	window.resizeTo(673, 531);

	// find language object
	if(window.opener)
	{
		if (window.opener.I18N)
		{
			I18N = window.opener.I18N;
		}
		// direct edit
		else if (window.opener.ImageManager && window.opener.ImageManager.I18N)
		{
			I18N = window.opener.ImageManager.I18N;
		}
	}

	// language object not found?
	if (!this.I18N)
	{
		// Read it now - copy in next script block
		document.write('<script type="text/javascript" src="lang/' + window.opener._editor_lang + '.js"><\/script>');
	}

/*]]>*/
</script>

<script type="text/javascript">
/*<![CDATA[*/

	// now copy the language object of the included script - needed a seperate new script block to be able to do so
	if (!this.I18N)
	{
		I18N = this.ImageManager.I18N;
	}

/*]]>*/
</script>

<script type="text/javascript" src="assets/slider.js"></script>
<script type="text/javascript" src="assets/popup.js"></script>
<script type="text/javascript" src="assets/editor.js"></script>

</head>

<body>
<div id="indicator">
<img src="img/spacer.gif" id="indicator_image" height="20" width="20" alt="" />
</div>
<div id="tools">
	<div id="tools_replace" style="display:none;">
		<div id="tool_inputs">
		<table>
		<tr>
			<td>
				<form action="editorFrame.php?img=<?=$_GET['img']?>&action=replace" target='editor' id="uploadForm" method="post" enctype="multipart/form-data">
					&nbsp;<input type="file" name="upload" id="upload"/>
					<input type="hidden" name="dir" id="dir" value="<?=dirname($img)?>" />
				</form>
			</td>
			<td>
				<img src="img/div.gif" height="30" width="2" class="div" alt="|" />
			</td>
		</tr>
		</table>
		</div>	
		<a href="javascript: doUpload(); document.getElementById('uploadForm').submit();" class="buttons" title="OK"><img src="img/btn_ok.gif" height="30" width="30" alt="OK" /></a>
	</div>	
	<div id="tools_watermark" style="display:none;">
		<div id="watermarkControls">
			<div id="tool_inputs">
				<label for="watermark_file">Watermark</label>: <select name="watermark_file" id="watermark_file" style="vertical-align: middle;" onchange="changeWatermark(this)"><!-- populated in editorFrame.php --></select>

				<label style="margin-left: 15px;">Opacity:</label>
				<table style="display: inline; vertical-align: middle;" cellpadding="0" cellspacing="0">
					<tr>
					<td>
						<div id="slidercasingwatermark" class="slidercasing"> 
					<div id="slidertrackwatermark" class="slidertrack" style="width:100px"><img src="img/spacer.gif" width="1" height="1" border="0" alt="track"></div>
				<div id="sliderbarwatermark" class="sliderbar" style="left:100px" onmousedown="captureStart('watermark');"><img src="img/spacer.gif" width="1" height="1" border="0" alt="track"></div>
				</div>	
					</td>
					</tr>
				</table>				
				<input type="text" id="sliderfieldwatermark" onchange="updateSlider(this.value, 'watermark')" style="width: 2em;" value="100"/>
				<table style="display: inline; vertical-align: bottom; margin: 0px 5px 0px 20px;" cellpadding="0" cellspacing="0">
					<tr>
					<td>
						<div style="cursor: pointer; cursor: hand; background-image: url(img/watermarkAlign.gif); vertical-align: middle; width: 24px; height: 24px; position: relative;">
							<div style="position: absolute; left: 1px; top: 1px; width: 4px; height: 4px; overflow: hidden;" onmouseover="this.style.backgroundColor='#BE3545'" onmouseout="this.style.backgroundColor='transparent'" onclick="moveWatermark(0, 0);"></div>
							<div style="position: absolute; left: 10px; top: 1px; width: 4px; height: 4px; overflow: hidden;" onmouseover="this.style.backgroundColor='#BE3545'" onmouseout="this.style.backgroundColor='transparent'" onclick="moveWatermark(0.5, 0);"></div>
							<div style="position: absolute; left: 19px; top: 1px; width: 4px; height: 4px; overflow: hidden;" onmouseover="this.style.backgroundColor='#BE3545'" onmouseout="this.style.backgroundColor='transparent'" onclick="moveWatermark(1, 0);"></div>
							<div style="position: absolute; left: 1px; top: 10px; width: 4px; height: 4px; overflow: hidden;" onmouseover="this.style.backgroundColor='#BE3545'" onmouseout="this.style.backgroundColor='transparent'" onclick="moveWatermark(0, 0.5);".5></div>
							<div style="position: absolute; left: 10px; top: 10px; width: 4px; height: 4px; overflow: hidden;" onmouseover="this.style.backgroundColor='#BE3545'" onmouseout="this.style.backgroundColor='transparent'" onclick="moveWatermark(0.5, 0.5);"></div>
							<div style="position: absolute; left: 19px; top: 10px; width: 4px; height: 4px; overflow: hidden;" onmouseover="this.style.backgroundColor='#BE3545'" onmouseout="this.style.backgroundColor='transparent'" onclick="moveWatermark(1, 0.5);"></div>
							<div style="position: absolute; left: 1px; top: 19px; width: 4px; height: 4px; overflow: hidden;" onmouseover="this.style.backgroundColor='#BE3545'" onmouseout="this.style.backgroundColor='transparent'" onclick="moveWatermark(0, 1);"></div>
							<div style="position: absolute; left: 10px; top: 19px; width: 4px; height: 4px; overflow: hidden;" onmouseover="this.style.backgroundColor='#BE3545'" onmouseout="this.style.backgroundColor='transparent'" onclick="moveWatermark(0.5, 1);"></div>
							<div style="position: absolute; left: 19px; top: 19px; width: 4px; height: 4px; overflow: hidden;" onmouseover="this.style.backgroundColor='#BE3545'" onmouseout="this.style.backgroundColor='transparent'" onclick="moveWatermark(1, 1);"></div>
						</div>
					</td>
					</tr>
				</table>		
				<table style="display: inline; vertical-align: bottom; margin: 0px 10px 0px 5px;" cellpadding="0" cellspacing="0">
					<tr>
					<td>
						<div style="cursor: pointer; cursor: hand; background-image: url(img/watermarkColor.gif); vertical-align: middle; width: 18px; height: 26px; position: relative;">
							<div style="position: absolute; left: 1px; top: 1px; width: 6px; height: 3px; overflow: hidden;" onclick="colorWatermarkBG('');"></div>
							<div style="position: absolute; left: 11px; top: 1px; width: 6px; height: 3px; overflow: hidden;" onclick="colorWatermarkBG('grid');"></div>
							<div style="position: absolute; left: 1px; top: 8px; width: 6px; height: 3px; overflow: hidden;" onmouseover="this.style.backgroundColor='#FFFFFF'" onmouseout="this.style.backgroundColor='transparent'" onclick="colorWatermarkBG('#FFFFFF');"></div>
							<div style="position: absolute; left: 11px; top: 8px; width: 6px; height: 3px; overflow: hidden;" onmouseover="this.style.backgroundColor='#000000'" onmouseout="this.style.backgroundColor='transparent'" onclick="colorWatermarkBG('#000000');"></div>
							<div style="position: absolute; left: 1px; top: 15px; width: 6px; height: 3px; overflow: hidden;" onmouseover="this.style.backgroundColor='#FF0000'" onmouseout="this.style.backgroundColor='transparent'" onclick="colorWatermarkBG('#FF0000');"></div>
							<div style="position: absolute; left: 11px; top: 15px; width: 6px; height: 3px; overflow: hidden;" onmouseover="this.style.backgroundColor='#00FF00'" onmouseout="this.style.backgroundColor='transparent'" onclick="colorWatermarkBG('#00FF00');"></div>
							<div style="position: absolute; left: 1px; top: 22px; width: 6px; height: 3px; overflow: hidden;" onmouseover="this.style.backgroundColor='#0000FF'" onmouseout="this.style.backgroundColor='transparent'" onclick="colorWatermarkBG('#0000FF');"></div>
							<div style="position: absolute; left: 11px; top: 22px; width: 6px; height: 3px; overflow: hidden;" onmouseover="this.style.backgroundColor='#FFFF00'" onmouseout="this.style.backgroundColor='transparent'" onclick="colorWatermarkBG('#FFFF00');"></div>
						</div>
					</td>
					</tr>
				</table>		
				<img src="img/div.gif" height="30" width="2" class="div" alt="|" />
			</div>	
			<a href="javascript: editor.doSubmit('watermark');" class="buttons" title="OK"><img src="img/btn_ok.gif" height="30" width="30" alt="OK" /></a>
		</div>	
		<div id="watermarkMessage" style="display: none;">
			<script>document.write("<div id=\"tool_inputs\" style=\"text-align: center; width: 90%; color: #474767;\"><label style=\" font-weight: bold; letter-spacing: 3px;\">" + i18n("Watermarking is disabled.") + "</label><br /><label>" + i18n("No watermarks were found or all watermarks are to big for the target image.") + "</label></div>");</script>
		</div>	
	</div>	
	<div id="tools_crop" style="display:none;">
		<div id="tool_inputs">
			<label for="cx">Start X:</label><input type="text" id="cx"  class="textInput" onchange="updateMarker('crop')"/>
			<label for="cy">Start Y:</label><input type="text" id="cy" class="textInput" onchange="updateMarker('crop')"/>
			<label for="cw">Width:</label><input type="text" id="cw" class="textInput" onchange="updateMarker('crop')"/>
			<label for="ch">Height:</label><input type="text" id="ch" class="textInput" onchange="updateMarker('crop')"/>
			<img src="img/div.gif" height="30" width="2" class="div" alt="|" />
		</div>	
		<a href="javascript: editor.doSubmit('crop');" class="buttons" title="OK"><img src="img/btn_ok.gif" height="30" width="30" alt="OK" /></a>
		<a href="javascript: editor.reset();" class="buttons" title="Cancel"><img src="img/btn_cancel.gif" height="30" width="30" alt="Cancel" /></a>		
	</div>	
	<div id="tools_scale" style="display:none;">
		<div id="tool_inputs">
			<label for="sw">Width:</label><input type="text" id="sw" class="textInput" onchange="checkConstrains('width')"/>
			<a href="javascript:toggleConstraints();" title="Lock"><img src="img/islocked2.gif" id="scaleConstImg" height="14" width="8" alt="Lock" class="div" /></a><label for="sh">Height:</label>
			<input type="text" id="sh" class="textInput" onchange="checkConstrains('height')"/>
			<input type="checkbox" id="constProp" value="1" checked="checked" onclick="toggleConstraints()"/>
			<label for="constProp">Constrain Proportions</label>
			<img src="img/div.gif" height="30" width="2" class="div" alt="|" />
		</div>	
		<a href="javascript: editor.doSubmit('scale');" class="buttons" title="OK"><img src="img/btn_ok.gif" height="30" width="30" alt="OK" /></a>
		<a href="javascript: editor.reset();" class="buttons" title="Cancel"><img src="img/btn_cancel.gif" height="30" width="30" alt="Cancel" /></a>		
	</div>	
	<div id="tools_rotate" style="display:none;">
		<div id="tool_inputs">
			<select id="flip" name="flip" style="margin-left: 10px; vertical-align: middle;">
              <option selected>Flip Image</option>
              <option>-----------------</option>
              <option value="hoz">Flip Horizontal</option>
              <option value="ver">Flip Virtical</option>
         </select>
			<select name="rotate" onchange="rotatePreset(this)" style="margin-left: 20px; vertical-align: middle;">
              <option selected>Rotate Image</option>
              <option>-----------------</option>

              <option value="180">Rotate 180 &deg;</option>
              <option value="90">Rotate 90 &deg; CW</option>
              <option value="-90">Rotate 90 &deg; CCW</option>
         </select>
			<label for="ra">Angle:</label><input type="text" id="ra" class="textInput" />
			<img src="img/div.gif" height="30" width="2" class="div" alt="|" />
		</div>	
		<a href="javascript: editor.doSubmit('rotate');" class="buttons" title="OK"><img src="img/btn_ok.gif" height="30" width="30" alt="OK" /></a>
	</div>		
	<div id="tools_measure" style="display:none;">
		<div id="tool_inputs">
			<label id="xLabel">X:<input type="text" class="measureStats" id="sx" disabled /></label>
			<label id="yLabel">Y:<input type="text" class="measureStats" id="sy" disabled /></label>
			<img src="img/div.gif" height="30" width="2" class="div" alt="|" />
			<label id="widthLabel">W:<input type="text" class="measureStats" id="mw" disabled /></label>
			<label id="heightLabel">H:<input type="text" class="measureStats" id="mh" disabled /></label>
			<img src="img/div.gif" height="30" width="2" class="div" alt="|" />
			<label id="angleLabel">A:<input type="text" class="measureStats" id="ma" disabled /></label>
			<label id="diagonalLabel">D:<input type="text" class="measureStats" id="md" disabled /></label>
			<img src="img/div.gif" height="30" width="2" class="div" alt="|" />
			<button type="button" onclick="editor.reset();" >Clear</button>

			<script>
				document.getElementById("xLabel").title = i18n("start x coordinate");
				document.getElementById("yLabel").title = i18n("start y coordinate");
				document.getElementById("widthLabel").title = i18n("width");
				document.getElementById("heightLabel").title = i18n("height");
				document.getElementById("angleLabel").title = i18n("angle");
				document.getElementById("diagonalLabel").title = i18n("diagonal length");
			</script>
		</div>	
	</div>
	<div id="tools_save" style="display:none;">

<? if($IMConfig['demo'] != true) { ?>

		<div id="tool_inputs">

	<? if($IMConfig['allow_newFileName'] == true) { ?>
			<label for="save_filename">Filename:</label><input type="text" id="save_filename" value="<? if($IMConfig['allow_overwrite'] == false){ echo $editor->getDefaultSaveFile(); }else{ echo basename($_GET['img']); } ?>" />
	<? }else{ ?>
			<input type="hidden" id="save_filename" value="<? echo basename($_GET['img']); ?>" />
	<? } ?>

	<?
	$pos = strrpos($_GET['img'], ".");
	$ext = substr($_GET['img'], $pos + 1);
	?>
			<select name="format" id="save_format" style="margin-left: 10px; vertical-align: middle; <? if($IMConfig['allow_newFileName'] != true && $ext != "jpg" && $ext != "jpeg") {echo "display: none;";} ?>" onchange="updateFormat(this)">
            <option value="" selected>Image Format</option>
            <option value="">---------------------</option>
            <option value="jpeg,85">JPEG High</option>
            <option value="jpeg,60">JPEG Medium</option>
            <option value="jpeg,35">JPEG Low</option>
			<? if($IMConfig['allow_newFileName'] == true){ ?>
            <option value="png">PNG</option>
			<?    if($editor->isGDGIFAble() != -1) { ?>
            <option value="gif">GIF</option>
			<?    } ?>
			<? } ?>
			</select>

			<label>Quality:</label>
			<table style="display: inline; vertical-align: middle;" cellpadding="0" cellspacing="0">
				<tr>
				<td>
					<div id="slidercasingsave" class="slidercasing"> 
				<div id="slidertracksave" class="slidertrack" style="width:100px"><img src="img/spacer.gif" width="1" height="1" border="0" alt="track"></div>
            <div id="sliderbarsave" class="sliderbar" style="left:85px" onmousedown="captureStart('save');"><img src="img/spacer.gif" width="1" height="1" border="0" alt="track"></div>
			</div>	
				</td>
				</tr>
			</table>				
			<input type="text" id="sliderfieldsave" onchange="updateSlider(this.value, 'save')" style="width: 2em;" value="85"/>
			<img src="img/div.gif" height="30" width="2" class="div" alt="|" />
		</div>	
		<a href="javascript: editor.doSubmit('save');" class="buttons" title="OK"><img src="img/btn_ok.gif" height="30" width="30" alt="OK" /></a>

	<? }else{ ?>

		<div id="tool_inputs" style="text-align: center; width: 90%; font-size: 150%; font-weight: bold; letter-spacing: 3px; color: #474767;">
			<label>Demo</label>
		</div>	

	<? } ?>

	</div>	
</div>
<div id="toolbar">
	<div id="buttons">

		<a href="javascript:toggle('replace')" id="icon_replace" title="Replace" <? if($IMConfig['allow_replace'] == false) { echo "style=\"display: none;\""; } ?> ><img src="img/replace.gif" height="20" width="20" alt="Replace" /><span>Replace</span></a>
		<a href="javascript:toggle('watermark')" id="icon_watermark" title="Watermark" <? if(empty($IMConfig['watermarks'])) { echo "style=\"display: none;\""; } ?> ><img src="img/watermark.gif" height="20" width="20" alt="Watermark" /><span>Watermark</span></a>
		<a href="javascript:toggle('crop')" id="icon_crop" title="Crop"><img src="img/crop.gif" height="20" width="20" alt="Crop" /><span>Crop</span></a>
		<a href="javascript:toggle('scale')" id="icon_scale" title="Resize"><img src="img/scale.gif" height="20" width="20" alt="Resize" /><span>Resize</span></a>
		<a href="javascript:toggle('rotate')" id="icon_rotate" title="Rotate"><img src="img/rotate.gif" height="20" width="20" alt="Rotate" /><span>Rotate</span></a>
		<a href="javascript:toggle('measure')" id="icon_measure" title="Measure"><img src="img/measure.gif" height="20" width="20" alt="Measure" /><span>Measure</span></a>
		<a href="javascript: toggleMarker();" title="Marker"><img id="markerImg" src="img/t_black.gif" height="20" width="20" alt="Marker" /><span>Marker</span></a>
		<a href="javascript:toggle('save')" id="icon_save" title="Save"><img src="img/save.gif" height="20" width="20" alt="Save" /><span>Save</span></a>
	</div>
</div>
<div id="contents">
<div id="messages" style="display: none;"><span id="message"></span><img SRC="img/dots.gif" width="22" height="12" alt="..." /></div>
<iframe src="editorFrame.php?img=<? if(isset($_GET['img'])) echo rawurlencode($_GET['img']); ?>" name="editor" id="editor" scrolling="auto" title="Image Editor" frameborder="0"></iframe>
</div>
<div id="bottom"></div>
</body>
</html>