<?
global $_CONFIG, $site_templater;
//if(empty($_GET['ver']))
//	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top_full.text.html");
//if($_GET['ver']=="2")
	/*if($_GET['debug']!=1) {
		echo mb_convert_encoding("Страница в разработке", "windows-1251", "utf-8");
		exit;
	}*/

	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top_empty.html");

//Создать новый .xlsx, туда перенести данные и сохранить в .xml, иначе будут пустые поля
	$test_xml = simplexml_load_file("files/card.xml");
	//$contries_arr = [];
	$year_min=10000;
	$year_max=0;
	$first=true;
	foreach ($test_xml->Worksheet[0]->Table->Row as $row) {
		if($first) {
			$first=false;
			continue;
		}
		$contry = (string)$row->Cell[3]->Data[0];
		if(!in_array($contry, $contries_arr) && !empty($contry))
			$contries_arr[] = $contry;
		$region = (string)$row->Cell[4]->Data[0];
		if(!in_array($region, $regions_arr) && !empty($region))
			$regions_arr[] = $region;
		$org = (string)$row->Cell[5]->Data[0];
		if(!in_array($org, $orgs_arr) && !empty($org))
			$orgs_arr[] = $org;

		$year = (int)$row->Cell[6]->Data[0];

		for ($i=10; $i <= 14; $i++) { 
			$words = (string)$row->Cell[$i]->Data[0];
			$words_temp_arr = explode(" ", $words);
			foreach ($words_temp_arr as $key => $value) {
				$wout_space_value = str_replace(" ", "", $value);
				$wout_space_value = mb_strtolower($wout_space_value, "utf-8");
				if(!in_array($wout_space_value, $words_arr) && !empty($wout_space_value))
					$words_arr[] = $wout_space_value;
			}
		}

		if($year!=0) {
			if($year_min>$year) 
				$year_min = $year;
			if($year_max<$year)
				$year_max = $year;
		}
	}
	if(!empty($words_arr))
		sort($words_arr);
	?>
    <div class="box" style="overflow: scroll;">
		<div class="title blue">
			<h2>
                <?php //echo @mb_convert_encoding($_TPL_REPLACMENT[BREADCRUMBS], "utf-8", "windows-1251");
                echo "<a href='/'>На главную</a>";
                ?>
				<span class="current"></span>
			</h2>
		</div>
		<script type="text/javascript">
			function change_table() {
				jQuery('.oni-documents-table').find('tr').show();
				jQuery('.oni-documents-table').find('.add-row').hide();
				jQuery(".buts1").text('Подробнее');
				if(jQuery( "#con_select option:selected").text()!="Все") {
		                jQuery('.oni-documents-table').find('.con-td').each(function(index){ if(jQuery(this).html()!=jQuery( "#con_select option:selected").text()) jQuery(this).parent().hide();});
		            }
		        if(jQuery( "#reg_select option:selected").text()!="Все") {
		                jQuery('.oni-documents-table').find('.reg-td').each(function(index){ if(jQuery(this).html()!=jQuery( "#reg_select option:selected").text()) jQuery(this).parent().hide();});
		            }
				if(jQuery( "#org_select option:selected").text()!="Все") {
		                jQuery('.oni-documents-table').find('.org-td').each(function(index){ if(jQuery(this).html()!=jQuery( "#org_select option:selected").text()) jQuery(this).parent().hide();});
		            }
		        if(jQuery( "#year_from_select option:selected").text()!="Все") {
		                jQuery('.oni-documents-table').find('.year-td').each(function(index){ if(jQuery(this).html()<jQuery( "#year_from_select option:selected").text()) jQuery(this).parent().hide();});
		            }
		        if(jQuery( "#year_to_select option:selected").text()!="Все") {
		                jQuery('.oni-documents-table').find('.year-td').each(function(index){ if(jQuery(this).html()>jQuery( "#year_to_select option:selected").text()) jQuery(this).parent().hide();});
		            }
		        if(jQuery( "#clue_words_select option:selected").text()!="Все") {
		                jQuery('.oni-documents-table').find('.clue-td').each(function(index){ if(jQuery(this).html().toLowerCase().indexOf(jQuery( "#clue_words_select option:selected").text().toLowerCase()) < 0) jQuery('#'+jQuery(this).closest('table').closest('tr').attr('id').substring(4)).hide();});
		            }
		         if(jQuery('#word_input').val()!="") {
		         	jQuery('.oni-documents-table').find('.clue-td').each(function(index){ if (jQuery(this).html().toLowerCase().indexOf(jQuery('#word_input').val().toLowerCase()) < 0 && jQuery(this).parent().find(".anot-text-td").html().toLowerCase().indexOf(jQuery('#word_input').val().toLowerCase()) < 0) jQuery('#'+jQuery(this).closest('table').closest('tr').attr('id').substring(4)).hide();});
					
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
				     jQuery('#add-'+jQuery(this).closest('tr').attr('id')).toggle();
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
			   <b>Регион:</b><br>
				<select name="region" id="reg_select">
				    <option disabled>Выберите регион</option>
				    <option value="Все">Все</option>
				    <?php foreach ($regions_arr as $value) {
				    	echo "<option value=\"$value\">$value</option>";
				    } ?>
			   </select>
			</div>
			<div class="oni-documents-block">
			   <b>Подготовившая организация:</b><br>
				<select name="org" id="org_select">
				    <option disabled>Выберите организацию</option>
				    <option value="Все">Все</option>
				    <?php foreach ($orgs_arr as $value) {
				    	echo "<option value=\"$value\">$value</option>";
				    } ?>
			   </select>
			</div>
			<div class="oni-documents-block">
			   <b>Год:</b><br>
				<select name="year_from" id="year_from_select">
				    <option disabled>От</option>
				    <option value="Все">Все</option>
				    <?php for ($i=$year_min; $i <= $year_max; $i++) { 
				    	echo "<option value=\"$i\">$i</option>";
				    }
				    ?>
			   </select>
			    - 
			   <select name="year_to" id="year_to_select">
				    <option disabled>До</option>
				    <option value="Все">Все</option>
				    <?php for ($i=$year_min; $i <= $year_max; $i++) { 
				    	echo "<option value=\"$i\">$i</option>";
				    }
				    ?>
			   </select>
			</div>
			<div class="oni-documents-block">
			   <b>Ключевое слово:</b><br>
				<select name="org" id="clue_words_select">
				    <option disabled>Выберите ключевое слово</option>
				    <option value="Все">Все</option>
				    <?php foreach ($words_arr as $value) {
				    	echo "<option value=\"$value\">$value</option>";
				    } ?>
			   </select>
			</div>
			<div class="oni-documents-block">
			   <b>Поиск по ключевому слову:</b><br>
				<input name="word" type="text" id="word_input" />
			</div>
		</form>
		<table class="oni-documents-table">
			<tr>
				<td>
					Страна
				</td>
				<td>
					Регион
				</td>
				<td>
					Подготовившая организация
				</td>
				<td>
					Год выхода
				</td>
				<td>
					Характер документа
				</td>
				<td>
					Горизонт
				</td>
				<td>
					Подробнее
				</td>
			</tr>
			<?php
				//var_dump($test_xml->Worksheet[0]->Table);
				$first=true;
				$rows_counter = 0;
				foreach ($test_xml->Worksheet[0]->Table->Row as $row) {
					if($first) {
						$first=false;
						continue;
					}
					if(!empty($row->Cell[0]->Data[0])) {
						$rows_counter++;
						echo "<tr id=\"tr-number-".$rows_counter."\">";
						$cell_number=0;
						$clue_words = "";
						foreach ($row->Cell as $cell) {
							if($cell_number>=17)
								break;

							if($cell_number>=10 && $cell_number<14) {
								if(!empty($cell->Data[0]))
									$clue_words.=$cell->Data[0]."; ";
								$cell_number++;
								continue;
							}
							if($cell_number==14) {
								if(!empty($cell->Data[0]))
									$clue_words.=$cell->Data[0]."; ";
								if($clue_words!="")
									$clue_words=substr($clue_words, count($clue_words)-1, -2);
								//echo "<td class=\"clue-td\">".$clue_words."</td>";
								$cell_number++;
								continue;
							}
							switch ($cell_number) {
								case 0:
									break;

								case 1:
									$name_original = $cell->Data[0];
									break;

								case 2:
									$name_rus = $cell->Data[0];
									break;

								case 3:
									echo "<td class=\"con-td\">".$cell->Data[0]."</td>";
									break;

								case 4:
									echo "<td class=\"reg-td\">".$cell->Data[0]."</td>";
									break;
									
								case 5:
									echo "<td class=\"org-td\">".$cell->Data[0]."</td>";
									break;

								case 6:
									echo "<td class=\"year-td\">".$cell->Data[0]."</td>";
									break;

								case 7:
									break;

								case 15:
									$link = $cell->Data[0];
									//echo "<td class=\"link-td\"><a href=\"".$cell->Data[0]."\">Ссылка</a></td>";
									break;

								case 16:
									?>
									<td>
										<div class="buts"><a class="buts1" onclick="return false;" href="#">Подробнее</a>
										</div>
									</td>
								</tr>
								<tr class="add-row" style="display: none;" id="add-tr-number-<?=$rows_counter?>">
									<td class="anot-td" colspan="7">		
								    	<table class="oni-documents-table">
								    		<tr>
								    			<td>
													Название документа на русском
												</td>
								    			<td>
													Название документа в оригинале
												</td>
												<td>
													Ключевые словосочетания
												</td>
												<td>
													Ссылка
												</td>
												<td>
													Аннотация
												</td>
								    		</tr>
								    		<tr>
								    			<td>
								    				<?=$name_rus?>
								    			</td>
								    			<td>
								    				<?=$name_original?>
								    			</td>
								    			<?php echo "<td class=\"clue-td\">".$clue_words."</td>"; ?>
								    			<?php echo "<td class=\"link-td\"><a href=\"".$link."\">Ссылка</a></td>"; ?>
								    			<td class="anot-text-td">
								    				<?php echo $cell->Data[0];?>
								    			</td>
								    		</tr>
								    	</table>
									</td>
									<?php
									break;

								default:
									echo "<td>".$cell->Data[0]."</td>";
									break;
							}
							$cell_number++;
						}
						echo "</tr>";
					}
				}
			?>
		</table>	
	</div>
<?php


//if(empty($_GET['ver']))
	//$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom_full.text.html");
	//if($_GET['ver']=="2")
	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom_empty.html");
?>