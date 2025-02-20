<?

global $_CONFIG, $DB;


	?>
	<script>
	jQuery(document).ready(function() {
	    jQuery(".survey-button").click(function(event) {
	    	event.preventDefault();
	    	info="";
  			info=jQuery(this).parent().find('input[name=survey]:checked').attr('id');
  			lang="";
			jQuery.ajax({
				type: 'POST',
				url: '/survey.php',
				data: {action:'add_answer', info:info, lang:lang},
				dataType: 'json',
				success: function (data, textStatus) {
		      		if(data['info']==100) {
		      			alert('<? if($_SESSION[lang]!="/en") echo "Спасибо! Ваш голос учтен."; else echo "Thanks for vote!";?>');
		      			obj = Object();
		      			obj.expires=30000000;
		      			setCookie("survey"+data['id'],"true",obj);
		      			showResults(data['id']);
		      		}
		      		else if(data['info']==300) {
		      			alert('<? if($_SESSION[lang]!="/en") echo "Неверный ответ."; else echo "Invalid answer.";?>');
		      		} 
		      		else {
		      			alert('<? if($_SESSION[lang]!="/en") echo "Неизвестная ошибка."; else echo "Unknown error.";?>');
		      		}
				}
			});
	    });
	    testPassed();
	});

	function showResults(survey_id) {
  		jQuery.ajax({
				type: 'POST',
				url: '/survey.php',
				data: {action:'show_results', info:survey_id},
				dataType: 'json',
				success: function (data, textStatus) {
		      		//sssss=survey_id;
		      		all = parseInt(data[1][0]["cnt"])+parseInt(data[2][0]["cnt"])+parseInt(data[3][0]["cnt"])+parseInt(data[4][0]["cnt"])+parseInt(data[5][0]["cnt"]);
		      		jQuery('.survey[name='+survey_id+']').find('.survey-form').hide();
		      		if(all!=0) {
		      			per1=(parseInt(data[1][0]["cnt"])/all)*100;
		      			per1=per1.toFixed(1);
		      			per1res=100-parseFloat(per1);
		      			per1restext="\xa0- "+per1+"%";
		      			per1text="\xa0";
		      			if(per1res<88) {
		      				per1restext="\xa0";
		      				per1text=per1+"%";
		      			}
		      			per2=(parseInt(data[2][0]["cnt"])/all)*100;
		      			per2=per2.toFixed(1);
		      			per2res=100-parseFloat(per2);
		      			per2restext="\xa0- "+per2+"%";
		      			per2text="\xa0";
		      			if(per2res<88) {
		      				per2restext="\xa0";
		      				per2text=per2+"%";
		      			}
		      			per3=(parseInt(data[3][0]["cnt"])/all)*100;
		      			per3=per3.toFixed(1);
		      			per3res=100-parseFloat(per3);
		      			per3restext="\xa0- "+per3+"%";
		      			per3text="\xa0";
		      			if(per3res<88) {
		      				per3restext="\xa0";
		      				per3text=per3+"%";
		      			}
		      			per4=(parseInt(data[4][0]["cnt"])/all)*100;
		      			per4=per4.toFixed(1);
		      			per4res=100-parseFloat(per4);
		      			per4restext="\xa0- "+per4+"%";
		      			per4text="\xa0";
		      			if(per4res<88) {
		      				per4restext="\xa0";
		      				per4text=per4+"%";
		      			}
		      			per5=(parseInt(data[5][0]["cnt"])/all)*100;
		      			per5=per5.toFixed(1);
		      			per5res=100-parseFloat(per5);
		      			per5restext="\xa0- "+per5+"%";
		      			per5text="\xa0";
		      			if(per5res<88) {
		      				per5restext="\xa0";
		      				per5text=per5+"%";
		      			}
		      			jQuery('.survey[name='+survey_id+']').find('.survey-results-all').text(<? if($_SESSION[lang]!="/en") echo "'Результаты опроса (всего голосов - '+all+'):'"; else echo "'Results ('+all+' votes):'"; ?>);
		      			jQuery('.survey[name='+survey_id+']').find('.survey-result1').css("width", per1+"%");
		      			jQuery('.survey[name='+survey_id+']').find('.survey-result1-res').css("width", per1res+"%");
		      			jQuery('.survey[name='+survey_id+']').find('.survey-result1').text(per1text);
		      			jQuery('.survey[name='+survey_id+']').find('.survey-result1-res').text(per1restext);
		      			jQuery('.survey[name='+survey_id+']').find('.survey-count1').append(" ("+data[1][0]["cnt"]+")");
		      			jQuery('.survey[name='+survey_id+']').find('.survey-result2').css("width", per2+"%");
		      			jQuery('.survey[name='+survey_id+']').find('.survey-result2-res').css("width", per2res+"%");
		      			jQuery('.survey[name='+survey_id+']').find('.survey-result2').text(per2text);
		      			jQuery('.survey[name='+survey_id+']').find('.survey-result2-res').text(per2restext);
		      			jQuery('.survey[name='+survey_id+']').find('.survey-count2').append(" ("+data[2][0]["cnt"]+")");
		      			jQuery('.survey[name='+survey_id+']').find('.survey-result3').css("width", per3+"%");
		      			jQuery('.survey[name='+survey_id+']').find('.survey-result3-res').css("width", per3res+"%");
		      			jQuery('.survey[name='+survey_id+']').find('.survey-result3').text(per3text);
		      			jQuery('.survey[name='+survey_id+']').find('.survey-result3-res').text(per3restext);
		      			jQuery('.survey[name='+survey_id+']').find('.survey-count3').append(" ("+data[3][0]["cnt"]+")");
		      			jQuery('.survey[name='+survey_id+']').find('.survey-result4').css("width", per4+"%");
		      			jQuery('.survey[name='+survey_id+']').find('.survey-result4-res').css("width", per4res+"%");
		      			jQuery('.survey[name='+survey_id+']').find('.survey-result4').text(per4text);
		      			jQuery('.survey[name='+survey_id+']').find('.survey-result4-res').text(per4restext);
		      			jQuery('.survey[name='+survey_id+']').find('.survey-count4').append(" ("+data[4][0]["cnt"]+")");
		      			jQuery('.survey[name='+survey_id+']').find('.survey-result5').css("width", per5+"%");
		      			jQuery('.survey[name='+survey_id+']').find('.survey-result5-res').css("width", per5res+"%");
		      			jQuery('.survey[name='+survey_id+']').find('.survey-result5').text(per5text);
		      			jQuery('.survey[name='+survey_id+']').find('.survey-result5-res').text(per5restext);
		      			jQuery('.survey[name='+survey_id+']').find('.survey-count5').append(" ("+data[5][0]["cnt"]+")");
		      		}
		      		//jQuery('.survey[name='+survey_id+']').find('.survey-result1').;
		      		jQuery('.survey[name='+survey_id+']').hide();
		      		//jQuery('.survey[name='+survey_id+']').find('.survey-results').show();
				}
		});
	}

	function testPassed() {
		jQuery('.survey').each(function( index ) {
			info="";
  			info=jQuery( this ).attr("name");
  			if(getCookie("survey"+info)=="true")
  				showResults(info);
  			else {
  				jQuery( this ).find('.survey-form').show();
  			}
		});
	}

	function setCookie(name, value, options) {
	  options = options || {};

	  var expires = options.expires;

	  if (typeof expires == "number" && expires) {
	    var d = new Date();
	    d.setTime(d.getTime() + expires * 1000);
	    expires = options.expires = d;
	  }
	  if (expires && expires.toUTCString) {
	    options.expires = expires.toUTCString();
	  }

	  value = encodeURIComponent(value);

	  var updatedCookie = name + "=" + value;

	  for (var propName in options) {
	    updatedCookie += "; " + propName;
	    var propValue = options[propName];
	    if (propValue !== true) {
	      updatedCookie += "=" + propValue;
	    }
	  }

	  document.cookie = updatedCookie;
	}

	function getCookie(name) {
	  var matches = document.cookie.match(new RegExp(
	    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
	  ));
	  return matches ? decodeURIComponent(matches[1]) : undefined;
	}

	</script>
	<?php 
		$lang_suff=""; 
		$button_name="Ответить";
		$results_name="<div class=\"survey-results-all\"></div>";
		$noone_name="Никто не голосовал";
		if($_SESSION[lang]=="/en") {
			$lang_suff="_en";
			$button_name="OK";
			$noone_name="Nobody answered";
		}

		$rows=$DB->select("SELECT ae.el_id AS ARRAY_KEYS, question.icont_text AS question, answer1.icont_text AS answer1, answer2.icont_text AS answer2, answer3.icont_text AS answer3, answer4.icont_text AS answer4, answer5.icont_text AS answer5 FROM adm_ilines_element AS ae 
							INNER JOIN adm_ilines_content AS question ON ae.el_id=question.el_id AND question.icont_var='question".$lang_suff."'
							INNER JOIN adm_ilines_content AS answer1 ON ae.el_id=answer1.el_id AND answer1.icont_var='answer1".$lang_suff."'
							INNER JOIN adm_ilines_content AS answer2 ON ae.el_id=answer2.el_id AND answer2.icont_var='answer2".$lang_suff."'
							INNER JOIN adm_ilines_content AS answer3 ON ae.el_id=answer3.el_id AND answer3.icont_var='answer3".$lang_suff."'
							INNER JOIN adm_ilines_content AS answer4 ON ae.el_id=answer4.el_id AND answer4.icont_var='answer4".$lang_suff."'
							INNER JOIN adm_ilines_content AS answer5 ON ae.el_id=answer5.el_id AND answer5.icont_var='answer5".$lang_suff."'
							INNER JOIN adm_ilines_content AS date_from ON ae.el_id=date_from.el_id AND date_from.icont_var='date'
							INNER JOIN adm_ilines_content AS date_to ON ae.el_id=date_to.el_id AND date_to.icont_var='date2'
							INNER JOIN adm_ilines_content AS off ON ae.el_id=off.el_id AND off.icont_var='status".$lang_suff."'
							WHERE ae.itype_id=14 AND question.icont_text<>'' AND question.icont_text<>'<p>&nbsp;</p>' AND (off.icont_text=1) AND STR_TO_DATE(date_to.icont_text, '%Y.%m.%d %H:%i')>=NOW() AND STR_TO_DATE(date_from.icont_text, '%Y.%m.%d %H:%i')<NOW()");
		//var_dump($rows);

	?>
	<?php foreach ($rows as $key => $value): ?>
	<div class="survey" name="<?=$key?>">
		<div class="survey-question">
			<?=$value['question']?>
		</div>
		<form class="survey-form">
			<?php if (!empty($value['answer1']) && $value['answer1']!="<p>&nbsp;</p>" && $value['answer1']!="<p></p>"): ?>	
			<label><input type="radio" name="survey" id="answer_1_<?=$key?>" /> <?=str_replace("<p>", "", str_replace("</p>", "", $value['answer1']))?></label><br>
			<?php endif ?>
			<?php if (!empty($value['answer2']) && $value['answer2']!="<p>&nbsp;</p>" && $value['answer2']!="<p></p>"): ?>	
			<label><input type="radio" name="survey" id="answer_2_<?=$key?>" /> <?=str_replace("<p>", "", str_replace("</p>", "", $value['answer2']))?></label><br>
			<?php endif ?>
			<?php if (!empty($value['answer3']) && $value['answer3']!="<p>&nbsp;</p>" && $value['answer3']!="<p></p>"): ?>	
			<label><input type="radio" name="survey" id="answer_3_<?=$key?>" /> <?=str_replace("<p>", "", str_replace("</p>", "", $value['answer3']))?></label><br>
			<?php endif ?>
			<?php if (!empty($value['answer4']) && $value['answer4']!="<p>&nbsp;</p>" && $value['answer4']!="<p></p>"): ?>	
			<label><input type="radio" name="survey" id="answer_4_<?=$key?>" /> <?=str_replace("<p>", "", str_replace("</p>", "", $value['answer4']))?></label><br>
			<?php endif ?>
			<?php if (!empty($value['answer5']) && $value['answer5']!="<p>&nbsp;</p>" && $value['answer5']!="<p></p>"): ?>	
			<label><input type="radio" name="survey" id="answer_5_<?=$key?>" /> <?=str_replace("<p>", "", str_replace("</p>", "", $value['answer5']))?></label><br>
			<?php endif ?>
			<br>
			<button class="survey-button"><?=$button_name?></button>
		</form>
		<div class="survey-results">
			<?=$results_name?>
			<div class="survey-results-box">
			<?php if (!empty($value['answer1']) && $value['answer1']!="<p>&nbsp;</p>" && $value['answer1']!="<p></p>"): ?>	
				 <div class="survey-count1 survey-count"><?=str_replace("<p>", "", str_replace("</p>", "", $value['answer1']))?></div>
				<div class="survey-result1 survey-result">
					<?=$noone_name?>
				</div>
				<div class="survey-result1-res survey-result-res">
				</div>
			<?php endif ?>
			<?php if (!empty($value['answer2']) && $value['answer2']!="<p>&nbsp;</p>" && $value['answer2']!="<p></p>"): ?>	
				 <div class="survey-count2 survey-count"><?=str_replace("<p>", "", str_replace("</p>", "", $value['answer2']))?></div>
				<div class="survey-result2 survey-result">
					<?=$noone_name?>
				</div>
				<div class="survey-result2-res survey-result-res">
				</div>
			<?php endif ?>
			<?php if (!empty($value['answer3']) && $value['answer3']!="<p>&nbsp;</p>" && $value['answer3']!="<p></p>"): ?>	
				 <div class="survey-count3 survey-count"><?=str_replace("<p>", "", str_replace("</p>", "", $value['answer3']))?></div>
				<div class="survey-result3 survey-result">
					<?=$noone_name?>
				</div>
				<div class="survey-result3-res survey-result-res">
				</div>
			<?php endif ?>
			<?php if (!empty($value['answer4']) && $value['answer4']!="<p>&nbsp;</p>" && $value['answer4']!="<p></p>"): ?>	
				 <div class="survey-count4 survey-count"><?=str_replace("<p>", "", str_replace("</p>", "", $value['answer4']))?></div>
				<div class="survey-result4 survey-result">
					<?=$noone_name?>
				</div>
				<div class="survey-result4-res survey-result-res">
				</div>
			<?php endif ?>
			<?php if (!empty($value['answer5']) && $value['answer5']!="<p>&nbsp;</p>" && $value['answer5']!="<p></p>"): ?>	
				 <div class="survey-count5 survey-count"><?=str_replace("<p>", "", str_replace("</p>", "", $value['answer5']))?></div>
				<div class="survey-result5 survey-result">
					<?=$noone_name?>
				</div>
				<div class="survey-result5-res survey-result-res">
				</div>
			<?php endif ?>
			&nbsp;
			</div>
		</div>
	</div>
	<?php endforeach; 
	if ($_SESSION[lang]!='/en')
{
	?>
	<a target="_blank" href="/index.php?page_id=1105">Результаты опроса</a>
	
	
	<?
}
else
{
	?>

	<a target="_blank" href="/en/index.php?page_id=1105">Results</a>
	
	
	<?
}


?>