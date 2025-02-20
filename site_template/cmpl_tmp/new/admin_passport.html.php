<?
global $_CONFIG, $site_templater, $DB;
//if(empty($_GET['ver']))
//	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top_full.text.html");
//if($_GET['ver']=="2")

	if(isset($_POST['login']) && isset($_POST['password'])) {
		if($_POST['login']=="baza" && $_POST['password']=="feqfuogeqgf4G#GF1")
			$_SESSION['passport_auth']=1;
	}

	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top_empty.html");
	if($_SESSION['passport_auth']==1) {

	$contries = $DB->select("SELECT contry
FROM  `passports` 
GROUP BY contry");
	foreach ($contries as $contry) {

		$contries_arr[] = mb_convert_encoding($contry['contry'], "utf-8", "windows-1251");
	}
	?>
    <div class="box" style="overflow: scroll;">
		<script type="text/javascript">
			function change_table() {
				jQuery('.oni-documents-table').find('tr').show();
				if(jQuery( "#con_select option:selected").text()!="Все") {
		                jQuery('.oni-documents-table').find('.con-td').each(function(index){ if(jQuery(this).html()!=jQuery( "#con_select option:selected").text()) jQuery(this).parent().hide();});
		            }
		         if(jQuery('#word_input').val()!="") {
		         	jQuery('.oni-documents-table').find('.clue-td').each(function(index){ if (jQuery(this).html().toLowerCase().indexOf(jQuery('#word_input').val().toLowerCase()) < 0) jQuery(this).parent().hide();});

				}
			}
			jQuery(document).ready(function() {
				jQuery( "#con_select" ).change(function() {
		            change_table();
		        });
		        jQuery( "#reg_select" ).change(function() {
		            change_table();
		        });
			    jQuery( "#org_select" ).change(function() {
		            change_table();
		        });
		        jQuery( "#year_from_select" ).change(function() {
		            change_table();
		        });
		        jQuery( "#year_to_select" ).change(function() {
		            change_table();
		        });
		        jQuery( "#word_input" ).keyup(function() {
				  	change_table();
				});
				jQuery( "#clue_words_select" ).change(function() {
				  	change_table();
				});

				jQuery(".buts").delegate(".buts1", "click", function(){
				     jQuery(this).parent().find(".buts_text").stop().slideToggle();
				     if(jQuery(this).parent().find(".buts1").text()=='Подробнее')
				     	jQuery(this).parent().find(".buts1").text('Скрыть');
				     else
				     	jQuery(this).parent().find(".buts1").text('Подробнее');
			   	});
			});
		</script>
		<form class="oni-documents-form" method="post">
			<div class="oni-documents-block">
				<b>Страна:</b><br>
				<select name="contry" id="con_select">
				    <option disabled>Выберите страну</option>
				    <option value="Все">Все</option>
				    <?php foreach ($contries_arr as $value) {
				    	echo "<option value=\"$value\">$value</option>";
				    } ?>
			   	</select>
			</div>
			<div class="oni-documents-block">
			   <b>Поиск по ФИО:</b><br>
				<input name="word" type="text" id="word_input" />
			</div>
		</form>
		<table class="oni-documents-table">
			<tr>
				<td>
					Страна
				</td>
				<td>
					ФИО
				</td>
				<td>
					Пол
				</td>
				<td>
					Дата рождения
				</td>
				<td>
					Место рождения
				</td>
				<td>
					Серия и номер
				</td>
				<td>
					Выдан
				</td>
				<td>
					Код подразделения
				</td>
				<td>
					Дата выдачи
				</td>
				<td>
					Телефон
				</td>
				<td>
					E-mail
				</td>
			</tr>
			<?php
			 	$passports = $DB->select("SELECT * FROM passports ORDER BY fio");
			 	foreach ($passports as $passport) {
			 		echo '<tr>';
			 		echo '<td class="con-td">'.mb_convert_encoding($passport['contry'], "utf-8", "windows-1251").'</td>';
			 		echo '<td class="clue-td">'.mb_convert_encoding($passport['fio'], "utf-8", "windows-1251").'</td>';
			 		echo '<td>'.mb_convert_encoding($passport['gender'], "utf-8", "windows-1251").'</td>';
			 		echo '<td>'.mb_convert_encoding($passport['birthdate'], "utf-8", "windows-1251").'</td>';
			 		echo '<td>'.mb_convert_encoding($passport['place'], "utf-8", "windows-1251").'</td>';
			 		echo '<td>'.mb_convert_encoding($passport['number'], "utf-8", "windows-1251").'</td>';
			 		echo '<td>'.mb_convert_encoding($passport['where'], "utf-8", "windows-1251").'</td>';
			 		echo '<td>'.mb_convert_encoding($passport['code'], "utf-8", "windows-1251").'</td>';
			 		echo '<td>'.mb_convert_encoding($passport['when'], "utf-8", "windows-1251").'</td>';
			 		echo '<td>'.mb_convert_encoding($passport['phone'], "utf-8", "windows-1251").'</td>';
			 		echo '<td>'.mb_convert_encoding($passport['email'], "utf-8", "windows-1251").'</td>';
			 		echo '</tr>';
			 	}

			?>
		</table>
	</div>
<?php
}
else
{
	?>
	<div class="box">
	<form method="post">
		<p>Логин</p>
		<input type="text" name="login">
		<p>Пароль</p>
		<input type="password" name="password"><br>
		<input type="submit">
	</form>
	</div>
	<?
}

//if(empty($_GET['ver']))
	//$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom_full.text.html");
	//if($_GET['ver']=="2")
	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom_empty.html");

?>