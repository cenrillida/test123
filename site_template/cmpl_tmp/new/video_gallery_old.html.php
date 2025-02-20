<?
global $_CONFIG, $site_templater;
	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top_full.text.html");

	?>
	<script language="javascript">  
	function doPopup(popupPath, par) { 
	var percent = encodeURIComponent('%');
	if(par)
	    popupPath += '&height=100' + percent + '&width=100' + percent; 
	pWnd=window.open(popupPath,'name',  
	'width=560,height=315,scrollbars=NO,left=350,top=100');
	}

	$(document).ready(function() {
	    $(".box").hover(
	  function() {
	    $( this ).find(".text-video-animated").slideDown(150);
	  }, function() {
	    $( this ).find(".text-video-animated").slideUp(150);
	  }
	);
	});
	</script>

	<?
	global $DB;
	$photogalaryid=10;
	//delete($arr_video_sidebar_dynkin);
	$arr_video_sidebar_dynkin=array();

	$result = $DB->select("SELECT itype_el_sort_type FROM adm_ilines_type WHERE itype_id=".$photogalaryid." LIMIT 1"); 

	$sort_t = $result[0];

	$result = $DB->select("SELECT ac.el_id FROM adm_ilines_element AS ae 
	    INNER JOIN adm_ilines_content AS ac ON ac.el_id=ae.el_id 
	    INNER JOIN adm_ilines_content AS st ON st.icont_var='status' AND st.el_id=ae.el_id
	    INNER JOIN adm_ilines_content AS dt ON dt.icont_var='date' AND dt.el_id=ae.el_id
	    WHERE ae.itype_id=".$photogalaryid." AND st.icont_text=1 GROUP BY el_id ORDER BY dt.icont_text ".$sort_t['itype_el_sort_type']); 

	$count_vg=0;

	//$arr;

	foreach ($result as $row) {
		$result_content = $DB->select("SELECT * FROM adm_ilines_content WHERE el_id=".$row['el_id']);
		foreach ($result_content as $row) {
		    $arr_video_sidebar_dynkin[$count_vg][$row['icont_var']]=$row['icont_text'];
		}
        $arr_video_sidebar_dynkin[$count_vg]["id"]=$row['el_id'];
		$count_vg++;
	}

	if($sort_t['itype_el_sort_type']=="DESC")
	usort($arr_video_sidebar_dynkin, "compare_desc"); 
	if($sort_t['itype_el_sort_type']=="ASC")
	usort($arr_video_sidebar_dynkin, "compare"); 
    echo "<div class='container-fluid'><div class='row'>";
	$first=true;
	if ($_SESSION[lang]!='/en')
	{
		for ($i=0; $i < $count_vg; $i++) { 
		    $params="?rel=0&autoplay=1";
		    if(!empty($arr_video_sidebar_dynkin[$i]['time_seconds'])) $params .= "&start=".$arr_video_sidebar_dynkin[$i]['time_seconds'];
		    $par="1";
		    if($arr_video_sidebar_dynkin[$i]['params'])
		    {
		        $params="";
		        $par="0";
		    }
		    $iDate=explode('.',substr($arr_video_sidebar_dynkin[$i]['date'],0,10));
		    if($first)
		    {
		    	?>
                <div class="col-12 pb-3">
                    <div class="row justify-content-center">
                        <div class="col-12 col-lg-6">
                            <div class="mx-auto p-3 text-left container-fluid shadow bg-white mb-3 position-relative h-100">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="img-block position-relative">
                                            <img src="<?=$arr_video_sidebar_dynkin[$i]['photo_stop']?>" alt="" class="w-100 box-img-100">
                                            <div class="video-iframe-button-div">
                                                <button class="btn btn-danger" type="button" onclick="javascript:doPopup('<?php if(substr($arr_video_sidebar_dynkin[$i]['youtube_url'],0,5)=="http:") {echo "http://"; $arr_video_sidebar_dynkin[$i]['youtube_url']=str_replace("http://","",$arr_video_sidebar_dynkin[$i]['youtube_url']);} else echo "//";?><?=$arr_video_sidebar_dynkin[$i]['youtube_url'].$params?>', <?=$par?>)"><i class="fas fa-video"></i> Смотреть</button>
                                            </div>
                                        </div>
                                        <?php if (!empty($arr_video_sidebar_dynkin[$i]['url'])): ?>
                                            <div class="text-video-classic text-video-100"><?=date('d.m.y', mktime(0,0,0,$iDate[1],$iDate[2],$iDate[0]))?> - <a target="_blank" href="<?=$arr_video_sidebar_dynkin[$i]['url']?>"><?=$arr_video_sidebar_dynkin[$i]['title']?></a></div>
                                        <?php else: ?>
                                            <div class="text-video-classic text-video-100"><?=date('d.m.y', mktime(0,0,0,$iDate[1],$iDate[2],$iDate[0]))?> - <?=$arr_video_sidebar_dynkin[$i]['title']?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
		    	<?php
		    	$first=false;
		    	continue;
		    }

		    ?>
            <div class="col-lg-3 col-md-6 col-xs-12 pb-3" id="<?=$arr_video_sidebar_dynkin[$i]['id']?>">
                <div class="mx-auto p-3 text-left container-fluid shadow bg-white mb-3 position-relative h-100">
                    <div class="row">
                        <div class="col-12">
                            <div class="img-block position-relative">
                                <img src="<?=$arr_video_sidebar_dynkin[$i]['photo_stop']?>" alt="" class="w-100 box-img-30">
                                <div class="video-iframe-button-div">
                                    <button class="btn btn-danger video-gallery-button-small" type="button" onclick="javascript:doPopup('<?php if(substr($arr_video_sidebar_dynkin[$i]['youtube_url'],0,5)=="http:") {echo "http://"; $arr_video_sidebar_dynkin[$i]['youtube_url']=str_replace("http://","",$arr_video_sidebar_dynkin[$i]['youtube_url']);} else echo "//";?><?=$arr_video_sidebar_dynkin[$i]['youtube_url'].$params?>', <?=$par?>)"><i class="fas fa-video"></i> Смотреть</button>
                                </div>
                            </div>
                            <?php if (!empty($arr_video_sidebar_dynkin[$i]['url'])): ?>
                                <div class="text-video-classic"><?=date('d.m.y', mktime(0,0,0,$iDate[1],$iDate[2],$iDate[0]))?> - <a target="_blank" href="<?=$arr_video_sidebar_dynkin[$i]['url']?>"><?=$arr_video_sidebar_dynkin[$i]['title']?></a></div>
                            <?php else: ?>
                                <div class="text-video-classic"><?=date('d.m.y', mktime(0,0,0,$iDate[1],$iDate[2],$iDate[0]))?> - <?=$arr_video_sidebar_dynkin[$i]['title']?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
		    <?php

		}
	}
	else
	{
		for ($i=0; $i < $count_vg; $i++) {
		    $params="?rel=0&autoplay=1";
            if(!empty($arr_video_sidebar_dynkin[$i]['time_seconds'])) $params .= "&start=".$arr_video_sidebar_dynkin[$i]['time_seconds'];
		    $par="1";
		    if($arr_video_sidebar_dynkin[$i]['params'])
		    {
		        $params="";
		        $par="0";
		    }
		    $iDate=explode('.',substr($arr_video_sidebar_dynkin[$i]['date'],0,10));
		    if(!empty($arr_video_sidebar_dynkin[$i]['title_en'])) {
		    	if(!empty($arr_video_sidebar_dynkin[$i]['url_en']))
		    		$titleVideo = '<a target="_blank" href="'.$arr_video_sidebar_dynkin[$i]['url_en'].'">'.$arr_video_sidebar_dynkin[$i]['title_en'].'</a>';
		    	else
		    		$titleVideo = $arr_video_sidebar_dynkin[$i]['title_en'];
		    }
		    else
		    {
		    	if(!empty($arr_video_sidebar_dynkin[$i]['url']))
		    		$titleVideo = '<a target="_blank" href="'.$arr_video_sidebar_dynkin[$i]['url'].'">Sorry. Only in Russian</a>';
		    	else
		    		$titleVideo = "Sorry. Only in Russian";
		    }
		    if($first)
		    {
		    	?>
                <div class="col-12 pb-3">
                    <div class="row justify-content-center">
                        <div class="col-12 col-lg-6">
                            <div class="mx-auto p-3 text-left container-fluid shadow bg-white mb-3 position-relative h-100">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="img-block position-relative">
                                            <img src="<?=$arr_video_sidebar_dynkin[$i]['photo_stop']?>" alt="" class="w-100 box-img-100">
                                            <div class="video-iframe-button-div">
                                                <button class="btn btn-danger" type="button" onclick="javascript:doPopup('<?php if(substr($arr_video_sidebar_dynkin[$i]['youtube_url'],0,5)=="http:") {echo "http://"; $arr_video_sidebar_dynkin[$i]['youtube_url']=str_replace("http://","",$arr_video_sidebar_dynkin[$i]['youtube_url']);} else echo "//";?><?=$arr_video_sidebar_dynkin[$i]['youtube_url'].$params?>', <?=$par?>)"><i class="fas fa-video"></i> Watch</button>
                                            </div>
                                        </div>
                                        <?php if (!empty($arr_video_sidebar_dynkin[$i]['url'])): ?>
                                            <div class="text-video-classic text-video-100"><?=date('d.m.y', mktime(0,0,0,$iDate[1],$iDate[2],$iDate[0]))?> - <a target="_blank" href="<?=$arr_video_sidebar_dynkin[$i]['url']?>"><?=$titleVideo?></a></div>
                                        <?php else: ?>
                                            <div class="text-video-classic text-video-100"><?=date('d.m.y', mktime(0,0,0,$iDate[1],$iDate[2],$iDate[0]))?> - <?=$titleVideo?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
		    	<?php
		    	$first=false;
		    	continue;
		    }

		    ?>
            <div class="col-lg-3 col-md-6 col-xs-12 pb-3" id="<?=$arr_video_sidebar_dynkin[$i]['id']?>">
                <div class="mx-auto p-3 text-left container-fluid shadow bg-white mb-3 position-relative h-100">
                    <div class="row">
                        <div class="col-12">
                            <div class="img-block position-relative">
                                <img src="<?=$arr_video_sidebar_dynkin[$i]['photo_stop']?>" alt="" class="w-100 box-img-30">
                                <div class="video-iframe-button-div">
                                    <button class="btn btn-danger video-gallery-button-small" type="button" onclick="javascript:doPopup('<?php if(substr($arr_video_sidebar_dynkin[$i]['youtube_url'],0,5)=="http:") {echo "http://"; $arr_video_sidebar_dynkin[$i]['youtube_url']=str_replace("http://","",$arr_video_sidebar_dynkin[$i]['youtube_url']);} else echo "//";?><?=$arr_video_sidebar_dynkin[$i]['youtube_url'].$params?>', <?=$par?>)"><i class="fas fa-video"></i> Watch</button>
                                </div>
                            </div>
                            <?php if (!empty($arr_video_sidebar_dynkin[$i]['url'])): ?>
                                <div class="text-video-classic"><?=date('d.m.y', mktime(0,0,0,$iDate[1],$iDate[2],$iDate[0]))?> - <a target="_blank" href="<?=$arr_video_sidebar_dynkin[$i]['url']?>"><?=$titleVideo?></a></div>
                            <?php else: ?>
                                <div class="text-video-classic"><?=date('d.m.y', mktime(0,0,0,$iDate[1],$iDate[2],$iDate[0]))?> - <?=$titleVideo?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
		    <?php

		}
	}
	echo "</div></div>";
?>
<?php if(!empty($_GET['scrollto'])):?>
    <script>
        $(document).ready(function() {
            $('html, body').animate({
                scrollTop: $('#<?=$_GET['scrollto']?>').offset().top-$('.site-header:eq(0)').height()-$('.site-header:eq(1)').height()
            }, 1);
        });
    </script>
<?php endif;?>
<?php
	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom_full.text.html");
?>