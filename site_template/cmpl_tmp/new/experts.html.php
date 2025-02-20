<?
global $_CONFIG, $DB, $site_templater;

function expert_list_echo($rows,$counter_elements,$counter_all_elements,$margin_name,$margin_image,$fontWeight,$fontSize){
    ?>
    <div class="row justify-content-center">
    <?php
	foreach ($rows as $key => $value):
        if($_GET[debug]!=3) {
	    ?>
            <div class="box col-lg-2 col-md-3 col-sm-4" style="<?php if(!empty($value['border_color'])) echo 'border-color: '.$value['border_color'].'; '; if(!empty($value['empty_box']) && $value['empty_box']) echo 'border: 0; box-shadow: none; background-color: initial;';?>">
                <div class="img-block person-img-block text-center">
                    <img data-innerSelector=".tooltip-arrow, .test-tooltip" data-toggle="tooltip" data-placement="top" data-html="true" title="" data-original-title="<div<?php if(!empty($value['photo_width']) && $value['photo_width']<=75) echo ' style=\'top: 100px;\'';?> class='<?php if($counter_elements==4) $counter_elements=0; $counter_elements++; ?>' id='<?php $counter_all_elements++;?>'><?=str_replace("\"", "'", $value['in_box'])?></div>" class="test-tooltip-person-img" src="<?=$value['photo']?>"<?php if(!empty($value['photo_width'])) echo ' style="width: '.$value['photo_width'].'%";';?>/>
                    <div class="text-person-box" style="<?php if(!empty($margin_image)) echo 'padding-top: '.$margin_image.'; ';?>">
                        <div class="text-person-box-name" style="<?php if(!empty($fontSize)) echo 'font-size: '.$fontSize.'; ';?>">
                            <p style="margin-bottom: 0; <?php if(!empty($value['name_font'])) echo 'font-size: '.$value['name_font'].'px; '?><?php if(!empty($fontWeight)) echo 'font-weight: '.$fontWeight.'; ';?>"><?=$value['name']?></p>
                            <p style="<?php if(!empty($fontWeight)) echo 'font-weight: '.$fontWeight.'; ';?><?php if(!empty($margin_name)) echo 'margin-top: '.$margin_name.'px; '?>"><?=$value['lastname']?></p>
                        </div>
                        <p><?=$value['under_photo']?></p>
                    </div>

                </div>
            </div>
        <?php
	        continue;
        } else {
            ?>
            <div class="box col-lg-2 col-sm-3"
                 style="<?php if (!empty($value['border_color'])) echo 'border-color: ' . $value['border_color'] . '; ';
                 if (!empty($value['block_height'])) echo 'height: ' . $value['block_height'] . 'px; ';
                 if (!empty($value['empty_box']) && $value['empty_box']) echo 'border: 0; box-shadow: none; background-color: initial;'; ?>">
                <div style="position: absolute;">
                    <div<?php if (!empty($value['photo_width']) && $value['photo_width'] <= 75) echo ' style="top: 100px;"'; ?>
                            class="box-highleft-text box-highleft-text-<?php echo $counter_elements;
                            if ($counter_elements == 4) $counter_elements = 0;
                            $counter_elements++; ?>" id="text-box-highleft-id-<?php echo $counter_all_elements;
                    $counter_all_elements++; ?>"><?= $value['in_box'] ?></div>
                </div>
                <div class="img-block person-img-block text-center">
                    <img class="person-img"
                         src="<?= $value['photo'] ?>"<?php if (!empty($value['photo_width'])) echo ' style="width: ' . $value['photo_width'] . '%";'; ?>/>
                    <div class="text-person-box"
                         style="<?php if (!empty($margin_image)) echo 'padding-top: ' . $margin_image . '; '; ?>">
                        <div class="text-person-box-name"
                             style="<?php if (!empty($fontSize)) echo 'font-size: ' . $fontSize . '; '; ?>">
                            <p style="margin-bottom: 0; <?php if (!empty($value['name_font'])) echo 'font-size: ' . $value['name_font'] . 'px; ' ?><?php if (!empty($fontWeight)) echo 'font-weight: ' . $fontWeight . '; '; ?>"><?= $value['name'] ?></p>
                            <p style="<?php if (!empty($fontWeight)) echo 'font-weight: ' . $fontWeight . '; '; ?><?php if (!empty($margin_name)) echo 'margin-top: ' . $margin_name . 'px; ' ?>"><?= $value['lastname'] ?></p>
                        </div>
                        <p><?= $value['under_photo'] ?></p>
                    </div>

                </div>
            </div>
            <?
        }
	endforeach;
	?>
    </div>
    <?php
}

	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

	?>
<style>
    .tooltip-inner {
        background: #FFFFFF;
        color: rgba(0, 0, 0, 1);
        border: 1px solid rgba(0, 0, 0, 1);
        opacity: 1;
    }
    .tooltip.show {
        opacity: 1;
    }
    .box-highleft-text {
        position: absolute;
        padding: 15px;
        border: 1px solid #ab9a9a;
        background-color: #eeeeee;
        z-index: 1;
        top: 162px;
        width: 433px;
        margin-top: 44px;
        display: none;
        border-radius: 8px;
    }
    .box-highleft-text-1 {
        left: -15px;
    }
    .box-highleft-text-2 {
        left: -144px;
    }
    .box-highleft-text-3 {
        left: -144px;
    }
    .box-highleft-text-4 {
        left: -257px;
    }
    .person-img-block img {
        width: 100%;
        border-radius: 50%;
    }
    div.box-25 {
        float: left;
        width: 204px;
        margin: 3px;
        box-shadow: 0 0 2px;
        background-color: #ececec;
        text-align: center;
    }
    .box-25-classic {
        height: 400px;
    }
    .text-person-box {
        padding-top: 15px;
    }
    .box-highleft-text:after,
    .box-highleft-text:before {
        content: '';
        display: block;
        position: absolute;
        left: 90%;
        width: 0;
        height: 0;
        border-style: solid;
    }

    .box-highleft-text:after {
        top: -40px;
        border-color: transparent transparent #eee transparent;
        border-width: 20px;
        left: 361px;
    }

    .box-highleft-text:before {
        top: -42px;
        left: 360px;
        border-color: transparent transparent #333333 transparent;
        border-width: 21px;
    }

    .box-highleft-text-3:after, .box-highleft-text-2:after {
        left: 301px;
    }

    .box-highleft-text-3:before, .box-highleft-text-2:before {
        left: 300px;
    }

    .box-highleft-text-1:after {
        left: 176px;
    }

    .box-highleft-text-1:before {
        left: 175px;
    }
    .text-person-box-name {
        text-align: center;
        text-transform: uppercase;
        font-weight: bold;
        font-size: 15px;
    }
    img {
        -webkit-transition: all 1s ease-in-out;
        -o-transition: all 1s ease-in-out;
        transition: all 1s ease-in-out;
    }
    img[data-src] {
        filter: alpha(opacity=0);
        -moz-opacity: 0;
        -khtml-opacity: 0;
        opacity: 0;
    }
    .prim-cht-anim-img {
        position:absolute;
        left:0;
        -webkit-transition: opacity 1s ease-in-out;
        -moz-transition: opacity 1s ease-in-out;
        -o-transition: opacity 1s ease-in-out;
        transition: opacity 1s ease-in-out;
    }
    .prim-cht-anim-img.transparent {
        opacity:0;
    }
</style>

<script type="text/javascript">
$( document ).ready(function() {
	/*jQuery( ".person-img" ).hover(
	  function() {
	    jQuery( this ).closest('.box').find('.box-highleft-text').show();
	  }, function() {
	    jQuery( this ).closest('.box').find('.box-highleft-text').hide();
	  }
	);
	 
	jQuery( ".person-img.fade" ).hover(function() {
	  jQuery( this ).fadeOut( 100 );
	  jQuery( this ).fadeIn( 500 );
	});*/


	$(".box-highleft-text").hover(function() {
        $(this).show(250);
    });
    $(".box-highleft-text").mouseleave(function() {
        $(this).hide(250);
    });
    $( ".person-img" ).hover(
        function() {
			jQuery( this ).closest('.box').find('.box-highleft-text').show(250);
        }, function() {
            var elem = jQuery( this ).closest('.box').find('.box-highleft-text').attr('id');
            setTimeout(function () {
            if ($('#' + elem + ':hover').length === 0)
                $('#' + elem).hide(250);
        },50);
        }
    );
});
</script>
	<?
	$lang_prefix = "";
	if($_SESSION[lang]=='/en')
		$lang_prefix= "_en";

		$rows = $DB->select("SELECT ic.el_id, name.icont_text AS 'name', lastname.icont_text AS 'lastname', photo.icont_text AS 'photo', under_photo.icont_text AS 'under_photo', in_box.icont_text AS 'in_box', border_color.icont_text AS 'border_color', photo_width.icont_text AS 'photo_width', block_height.icont_text AS 'block_height', empty_box.icont_text AS 'empty_box', name_font.icont_text AS 'name_font' FROM `adm_ilines_element` AS ie
INNER JOIN adm_ilines_content AS ic ON ic.el_id=ie.el_id
INNER JOIN adm_ilines_content AS name ON ic.el_id=name.el_id AND name.icont_var='name".$lang_prefix."'
INNER JOIN adm_ilines_content AS lastname ON ic.el_id=lastname.el_id AND lastname.icont_var='lastname".$lang_prefix."'
INNER JOIN adm_ilines_content AS photo ON ic.el_id=photo.el_id AND photo.icont_var='photo'
INNER JOIN adm_ilines_content AS under_photo ON ic.el_id=under_photo.el_id AND under_photo.icont_var='under_photo".$lang_prefix."'
INNER JOIN adm_ilines_content AS in_box ON ic.el_id=in_box.el_id AND in_box.icont_var='in_box".$lang_prefix."'
INNER JOIN adm_ilines_content AS status ON ic.el_id=status.el_id AND status.icont_var='status".$lang_prefix."'
INNER JOIN adm_ilines_content AS sort ON ic.el_id=sort.el_id AND sort.icont_var='sort'
LEFT JOIN adm_ilines_content AS border_color ON ic.el_id=border_color.el_id AND border_color.icont_var='border_color'
LEFT JOIN adm_ilines_content AS photo_width ON ic.el_id=photo_width.el_id AND photo_width.icont_var='photo_width'
LEFT JOIN adm_ilines_content AS block_height ON ic.el_id=block_height.el_id AND block_height.icont_var='block_height'
LEFT JOIN adm_ilines_content AS empty_box ON ic.el_id=empty_box.el_id AND empty_box.icont_var='empty_box'
LEFT JOIN adm_ilines_content AS name_font ON ic.el_id=name_font.el_id AND name_font.icont_var='name_font'
WHERE ie.itype_id=".$_TPL_REPLACMENT[EXPERTS_ID_TOP]." AND status.icont_text=1
GROUP BY ic.el_id
ORDER BY sort.icont_text ASC");
	$counter_elements = 1;
	$counter_all_elements = 1;
    echo '<div style="display: flex; justify-content: center">';
	expert_list_echo($rows,&$counter_elements,&$counter_all_elements,$_TPL_REPLACMENT[MARGIN_NAME],$_TPL_REPLACMENT[MARGIN_IMAGE],$_TPL_REPLACMENT[FONT_WEIGHT_NAME],$_TPL_REPLACMENT[FONT_SIZE_NAME]);
    echo '</div>';

	$rows = $DB->select("SELECT ic.el_id, name.icont_text AS 'name', lastname.icont_text AS 'lastname', photo.icont_text AS 'photo', under_photo.icont_text AS 'under_photo', in_box.icont_text AS 'in_box', border_color.icont_text AS 'border_color', photo_width.icont_text AS 'photo_width', block_height.icont_text AS 'block_height', empty_box.icont_text AS 'empty_box', name_font.icont_text AS 'name_font' FROM `adm_ilines_element` AS ie
INNER JOIN adm_ilines_content AS ic ON ic.el_id=ie.el_id
INNER JOIN adm_ilines_content AS name ON ic.el_id=name.el_id AND name.icont_var='name".$lang_prefix."'
INNER JOIN adm_ilines_content AS lastname ON ic.el_id=lastname.el_id AND lastname.icont_var='lastname".$lang_prefix."'
INNER JOIN adm_ilines_content AS photo ON ic.el_id=photo.el_id AND photo.icont_var='photo'
INNER JOIN adm_ilines_content AS under_photo ON ic.el_id=under_photo.el_id AND under_photo.icont_var='under_photo".$lang_prefix."'
INNER JOIN adm_ilines_content AS in_box ON ic.el_id=in_box.el_id AND in_box.icont_var='in_box".$lang_prefix."'
INNER JOIN adm_ilines_content AS status ON ic.el_id=status.el_id AND status.icont_var='status".$lang_prefix."'
INNER JOIN adm_ilines_content AS sort ON ic.el_id=sort.el_id AND sort.icont_var='sort'
LEFT JOIN adm_ilines_content AS border_color ON ic.el_id=border_color.el_id AND border_color.icont_var='border_color'
LEFT JOIN adm_ilines_content AS photo_width ON ic.el_id=photo_width.el_id AND photo_width.icont_var='photo_width'
LEFT JOIN adm_ilines_content AS block_height ON ic.el_id=block_height.el_id AND block_height.icont_var='block_height'
LEFT JOIN adm_ilines_content AS empty_box ON ic.el_id=empty_box.el_id AND empty_box.icont_var='empty_box'
LEFT JOIN adm_ilines_content AS name_font ON ic.el_id=name_font.el_id AND name_font.icont_var='name_font'
WHERE ie.itype_id=".$_TPL_REPLACMENT[EXPERTS_MODULE_ID]." AND status.icont_text=1
GROUP BY ic.el_id
ORDER BY lastname.icont_text ASC");

	expert_list_echo($rows,&$counter_elements,&$counter_all_elements,$_TPL_REPLACMENT[MARGIN_NAME],$_TPL_REPLACMENT[MARGIN_IMAGE],$_TPL_REPLACMENT[FONT_WEIGHT_NAME],$_TPL_REPLACMENT[FONT_SIZE_NAME]);

	if(!empty($_TPL_REPLACMENT[BORDER_HOVER])) {
	    ?>
        <style>
            .person-img-block img:hover {
                border: 3px <?=$_TPL_REPLACMENT[BORDER_HOVER]?> solid;
                transition: 0.2s;
            }
        </style>
        <?php
    }

	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>
