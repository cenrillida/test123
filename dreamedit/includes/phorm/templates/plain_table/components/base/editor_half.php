<tr valign="top"><td nowrap>
<?php
	$prompt .= ":";
	$prompt = count($validate_errors) ? "<span class=\"error\">".$prompt."</span>" : $prompt;
	echo $prompt."\n";
	echo (isset($required) && $required)? "&nbsp;<span class=\"required\">*</span>": "";
?>
</td>
<?php if($_GET[debug] == 1): ?>
<td width="100%">
<?php
	$type = isset($type)? $type: "Default";

	$oFCKeditor = new FCKeditor($name);
	$oFCKeditor->Width = ($type == "Basic")? "400px": "100%";
	$oFCKeditor->Height = ($type == "Basic")? "200px": "200px";
	if(isset($config)) $oFCKeditor->Config["CustomConfigurationsPath"] = $config;
	$type == "Basic"? $oFCKeditor->ToolbarSet = "Basic": $oFCKeditor->ToolbarSet = "Default";
	$oFCKeditor->BasePath = "includes/FCKEditor/";

	$oFCKeditor->Value = $value;
	echo $oFCKeditor->CreateHTML();
	echo isset($buttons)? $buttons: "";

	if(!empty($help))
		echo "<p class=\"form_help\">".$help."</p>";
?>
</td><?php else: ?>
    <td width="100%">
        <?php
        echo "<textarea tag=\"".$name."\" name=\"".$name."\" id=\"".$name."\" cols=\"".$cols."\" rows=\"".$rows."\">".htmlspecialchars($value)."</textarea>\n";
        echo isset($buttons)? $buttons: "";

        if(!empty($help))
            echo "<p class=\"form_help\">".$help."</p>";
        ?>
    </td>
    <script>
        var editorElement = CKEDITOR.document.getById( '<?=$name?>' );
        CKEDITOR.replace( '<?=$name?>', {
            on: {
                paste: function(e) {
                    if (e.data.dataValue !== 'undefined')
                        e.data.dataValue = e.data.dataValue.replace(/(\<br ?\/?\>)+/gi, '<p>');
                }
            },
            filebrowserBrowseUrl: '/dreamedit/includes/ckeditor5-build-classic/ckfinder/ckfinder.html',
            filebrowserImageBrowseUrl: '/dreamedit/includes/ckeditor5-build-classic/ckfinder/ckfinder.html?Type=Images',
            filebrowserUploadUrl: '/dreamedit/includes/ckeditor5-build-classic/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            filebrowserImageUploadUrl: '/dreamedit/includes/ckeditor5-build-classic/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
            filebrowserWindowWidth : '1000',
            filebrowserWindowHeight : '700'
        } );
        CKEDITOR.add
        CKEDITOR.config.contentsCss = [ '/newsite/css/bootstrap.min.css', '/newsite/css/product.css?ver=<?php echo filemtime($_SERVER["DOCUMENT_ROOT"]."/newsite/css/product.css");?>', '/newsite/css/ck_additional.css?ver=<?php echo filemtime($_SERVER["DOCUMENT_ROOT"]."/newsite/css/ck_additional.css");?>','https://use.fontawesome.com/releases/v5.15.3/css/all.css'] ;
    </script>
<?php endif;?>
</tr>
