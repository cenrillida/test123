<?php
global $DB,$_CONFIG, $site_templater;
?>
<html> 
	<head>
	<?php if($_GET[debug]!=1):?>
		<script src="/js/dhtmlx4/codebase/dhtmlx.js" type="text/javascript"></script>
       		<link rel="stylesheet" href="/js/dhtmlx4/codebase/dhtmlx.css" type="text/css"> 	
       	<?php else: ?>
       				<script src="/js/dhtmlx4/codebase/dhtmlx.js" type="text/javascript"></script>
       				<script src="/js/dhtmlx4/sources/dhtmlxGrid/codebase/dhtmlxgrid.js" type="text/javascript"></script>
       		<link rel="stylesheet" href="/js/dhtmlx4/codebase/dhtmlx.css" type="text/css"> 	
       	<?php endif;?>
		<style>
			html, body {
				width: 100%;
				height: 100%;
				margin: 0px;
				padding: 0px;
				background-color: #ebebeb;
				overflow: hidden;
			}
		</style>
	
	</head> 
	<body onload="doOnLoad()">
	<?php
		$total = 0; 
		$started = 0;
		$finished = 0;
		
	//	$counters=$DB->select("SELECT COUNT(*) AS total, SUM(VT.vuz_id IS NOT NULL) AS started, SUM(VT.finished = 1) AS finished FROM `vuz` AS V LEFT OUTER JOIN vuz_total AS VT ON V.id = VT.vuz_id");
		$counters=$DB->select("SELECT count(*) AS total,SUM(date_rez <>'') AS count_rez,SUM(date_publ<>'') AS count_publ 
						 FROM article_send WHERE del=''");
		foreach($counters as $counter)
		{
			$total = $counter["total"];
			$started = $counter["count_rez"];
			$finished = $counter["count_publ"];
		}
		$jour0=$DB->select("SELECT * FROM adm_magazine WHERE page_template=0 AND page_parent=0 ORDER BY page_name");
		$txt="<select name='jour' id='jour' onChange=OnCh(".$_REQUEST[page_id].",'jour','jour')>";
		
		$txt.= "<option value='1'></option>";
		foreach($jour0 as $jour)
		{
		   $txt.="<option value=".$jour[page_id].">".$jour[page_name]."</option>";
		}
		$txt.="</select>";
	?>
		<script>
				
				var grid;
	

				function post_to_url(path, params, method) {
					method = method || "post"; // Set method to post by default, if not specified.

					// The rest of this code assumes you are not using a library.
					// It can be made less wordy if you use one.
					var form = document.createElement("form");
					form.setAttribute("method", method);
					form.setAttribute("action", path);

					for(var key in params) {
						if(params.hasOwnProperty(key)) {
							var hiddenField = document.createElement("input");
							hiddenField.setAttribute("type", "hidden");
							hiddenField.setAttribute("name", key);
							hiddenField.setAttribute("value", params[key]);

							form.appendChild(hiddenField);
						 }
					}

					document.body.appendChild(form);
					form.submit();
				}

				
				function deleteLogin(id, name)
				{
					var answer = confirm ("Вы действительно хотите удалить статью " + name + "?");  

					if (answer)
					{
						var http = new XMLHttpRequest();
					
						var url = "update.xml";
						var params = "custom_act=delete&gr_id="+id;
						http.open("GET", url+"?"+params, true);
						http.onreadystatechange = function() {//Call a function when the state changes.
							if(http.readyState == 4 && http.status == 200) {
								/*var cell = grid.cellById(vuz_id, 19);
								cell.setValue("");*/
								window.location.reload();
							}
						}
						http.send(null);
					    
						//post_to_url('update.xml?custom_act=delete&gr_id='+vuz_id);
						//window.location.reload();    
					}
						
				}
				function daterez(id,type)
				{
					
						var http = new XMLHttpRequest();
					
						var url = "update.xml";
					//	var params = "custom_act=delete&gr_id="+vuz_id;
						http.open("GET", url+"?"+params, true);
						http.onreadystatechange = function() {//Call a function when the state changes.
							if(http.readyState == 4 && http.status == 200) {
								var cell = grid.cellById(vuz_id, 19);
								cell.setValue("");
							}
						
						http.send(null);
					
						//post_to_url('update.xml?custom_act=delete&gr_id='+vuz_id);
						//window.location.reload();    
					}
						
				}
		
				function getCoutersString()
				{
					return "Статей <a href='#' onclick=doFilter('all')>всего</a>:  <? echo $total; ?>, на <a href='#' onclick=doFilter('rez')>рецензии: </a><?  echo $started; ?>, "+
					"<a href='#' onclick=doFilter('publ')>опубликовано: </a><? echo $finished; ?>.";
				}

				function doFilter(filtertype)
				{
				 	switch(filtertype)
					{      
						case 'all':
							grid.filterBy(0, function(a) { return 1==1;});
							break
						case 'rez':
							grid.filterBy(9, function(a) { return a != '';});
							break
		                                case 'publ':
							grid.filterBy(12, function(a) { return a != '';});
 							break
					}
					return;
				}

                                function doOnLoad() {
			
				dhtmlXCalendarObject.prototype.langData["ru"] = {
    					dateformat: '%d.%m.%Y',
    					monthesFNames: ["Январь","Февраль","Март","Апрель","Май","Июнь",
                    					"Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь"],
    					monthesSNames: ["Янв","Фев","Мар","Апр","Май","Июн","Июл","Авг","Сен","Окт","Ноя","Дек"],
    					daysFNames: ["Воскресенье","Понедельник","Вторник","Среда","Четверг","Пятница","Суббота"],
    					daysSNames: ["Вс","Пн","Вт","Ср","Чт","Пт","Сб"],
    					weekstart: 1,
        				weekname: "н" 
				};	

				dhtmlXCalendarObject.prototype.lang = "ru";
				
                         	var main_layout = new dhtmlXLayoutObject({
					parent: document.body,
					pattern: "1C",
					cells: [{id: "a", text: "dhtmlxGrid"}]
					});				
				
				dhtmlx.image_path='/js/dhtmlx/dhtmlxGrid/codebase/imgs/';
				var cell_5 = main_layout.cells('a');
				cell_5.setText(getCoutersString() + "   "  + "Выбрать журнал: <? echo @$txt?>");
				 
				grid = cell_5.attachGrid(); 
				grid.setSkin("dhx_skyblue");
				
				grid.setIconsPath('/js/dhtmlx4/skins/skyblue/imgs/'); 
				grid.setImagePath('/js/dhtmlx4/skins/skyblue/imgs/');
				grid.setHeader("Удал.,Название,ФИО,Аффилиация,e-mail,Рубрика,Текст(doc),Поступила,Рецензия,,Примечания,Публикация,,Примечания");
				grid.setInitWidths("40,500,160,200,150,110,80,80,40,100,80,40,100");
				
				grid.setColAlign("center,left,left,left,left,left,center,center,center,center,center,center,center,center");
				grid.setColTypes("link,ro,ro,ro,ro,ro,ro,ro,dhxCalendar,ch,ed,dhxCalendar,ch,ed");
				grid.setColSorting("str,str,str,str,str,str,str,str,date,str,str,date,str,str");
				grid.attachHeader(",#text_filter,#text_filter,#text_filter,#text_filter,#select_filter,,,,,,,,");
				
		 
				grid.init(); 
				
				<?php if($_GET[debug]!=1):?>
					grid.loadXML("admin_table_source.xml");
		       	<?php else: ?>
		       		grid.load("admin_table_source.xml");
		       	<?php endif;?>
							
                
								
				var dp = new dataProcessor('update.xml');
				dp.init(grid);
				dp.setAutoUpdate(2000);
				/*dp.attachEvent("onBeforeUpdate", function(id, state, data){
				    
				    return true;
				});*/

				
				var row_id=0;
				for (var i=0; i<grid.getRowsNum(); i++){
					//alert(grid.getRowId(i));
					if(grid.getUserData(grid.getRowId(i),'inter_count') == '0') {  
						row_id = grid.getRowId(i); 
						grid.setRowTextStyle(row_id, "color:red;");
						break;
					}
				}   
				

                         }
				 function OnCh()
				{
				    var x=document.getElementById('jour').value;
					
					grid.clearAll();
					grid.loadXML("admin_table_source.xml?ex="+x);
				//	grid.refresh();
					
				} 
				function initgrid(param)
				{
				   
				}		 
				
				
		</script>
	</body>
</html>