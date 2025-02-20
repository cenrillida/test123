<?php if($_GET['action']=="edit"):?>
<tr valign="top"><td>
<?php
	echo "<input id=\"".$name."\" type=\"button\" name=\"".$name."\" value=\"".$buttonText."\" />\n";

	if(!empty($help))
		echo "<p class=\"form_help\">".$help."</p>";
?>
</td><td><span id="tgram_result_<?=$name?>"></span> <img id="tgram_img_<?=$name?>" style="display: none" src="/dreamedit/skin/classic/images/ajax-loader.gif" alt=""></td></tr>
<script>
    $( "#<?=$name?>" ).on( "click", function(event) {
        event.preventDefault();
        jQuery.ajax({
            type: 'GET',
            url: '/dreamedit/ajax_tgram.php?id=<?=$_GET['id']?>',
            success: function (data) {
                $('#tgram_result_<?=$name?>').html(data);
            },
            failure: function() {
                $('#tgram_result_<?=$name?>').html("Неизвестная ошибка");
            },
            complete: function (data) {
                $('#tgram_img_<?=$name?>').hide();
            },
            beforeSend: function () {
                $('#tgram_result_<?=$name?>').html("");
                $('#tgram_img_<?=$name?>').show();
            }
        })
    });
</script>
<?php endif;?>