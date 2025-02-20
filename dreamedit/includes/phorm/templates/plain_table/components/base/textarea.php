<tr valign="top"<?php if($seo_field) echo ' class="seo_field" style="display: none"';?>><td nowrap>
<?php
	$prompt .= ":";
	$prompt = count($validate_errors) ? "<span class=\"error\">".$prompt."</span>" : $prompt;
	echo $prompt."\n";
	echo (isset($required) && $required)? "&nbsp;<span class=\"required\">*</span>": "";
?>
</td><td width="100%">
<?php
	echo "<textarea tag=\"".$name."\" name=\"".$name."\" id=\"".$name."\" cols=\"".$cols."\" rows=\"".$rows."\">".htmlspecialchars($value)."</textarea>\n";
	echo isset($buttons)? $buttons: "";

	if(!empty($help))
		echo "<p class=\"form_help\">".$help."</p>";
?>
</td></tr>
<?php if($_GET[debug2]==1): ?>
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
</script>
<?php endif;?>
