<style>

    .model-block {
        font-family: Arial;
        font-size: 10;
    }

    .axis path,
    .axis line {
        fill: none;
        stroke: #000;
        shape-rendering: crispEdges;
    }

    .bar {
        fill: steelblue;
    }

    .x.axis path {
        display: none;
    }

</style>
<div style="float: left;">
    Сценарии:
    <select id="scenario">
        <option>Базовый</option>
        <option>Пессимистический</option>
        <option>Оптимистический</option>
    </select>
</div>
<div style="float: left; padding-left: 15px;">
    Ввод трубопроводов:<br>
    Туркменистан:
    <select id="turk_select">
        <option>3 очередь</option>
        <option>4 очередь</option>
    </select><br>
    Россия:
    <select id="rus_select">
        <option>Сила сибири запускается</option>
        <option>Сила сибири не запускается</option>
    </select>
</div>
<div style="float: left;">
    Регазификационные мощности:<br>
    <? global $link;
    $result = $link->query("SELECT * FROM cer_model_years WHERE year=2014");
    while($row=mysqli_fetch_array($result)) {?>
    2020 - min <?=$row[regas_project]?>
    <?}?>
    <input type="text" id="regas_2020" value="100">

    <? $result = $link->query("SELECT * FROM cer_model_years WHERE year=2020");
    while($row=mysqli_fetch_array($result)) {?>
         max <?=$row[regas_project]?>
    <?}?>

    <br>
    <? $result = $link->query("SELECT * FROM cer_model_years WHERE year=2020");
    while($row=mysqli_fetch_array($result)) {?>
        2025 - min <?=$row[regas_project]?>
    <?}?>
    <input type="text" id="regas_2025"  value="115">

    <? $result = $link->query("SELECT * FROM cer_model_years WHERE year=2025");
    while($row=mysqli_fetch_array($result)) {?>
        max <?=str_replace(".",",", str_replace(",",".",$row[regas_project])*1.2)?>
    <?}?>

    <br>
    <? $result = $link->query("SELECT * FROM cer_model_years WHERE year=2030");
    while($row=mysqli_fetch_array($result)) {?>
        2030 - min <?=$row[regas_project]?>
    <?}?>
    <input type="text" id="regas_2030"  value="120">

    <? $result = $link->query("SELECT * FROM cer_model_years WHERE year=2030");
    while($row=mysqli_fetch_array($result)) {?>
        max <?=str_replace(".",",", str_replace(",",".",$row[regas_project])*1.2)?>
    <?}?>

    <br>
    <? $result = $link->query("SELECT * FROM cer_model_years WHERE year=2035");
    while($row=mysqli_fetch_array($result)) {?>
        2035 - min <?=$row[regas_project]?>
    <?}?>
    <input type="text" id="regas_2035"  value="130">

    <? $result = $link->query("SELECT * FROM cer_model_years WHERE year=2035");
    while($row=mysqli_fetch_array($result)) {?>
        max <?=str_replace(".",",", str_replace(",",".",$row[regas_project])*1.2)?>
    <?}?>

    <br>
</div>
<br>
<div style="float: left;">
    Распределение остатка:
    <div id="sl2"></div>
    <div id="info"></div>
    <div id="info2"></div><br>
</div>
<div class="model-block"></div>
<script src="//d3js.org/d3.v3.min.js"></script>
<script>

    tp_rasp = 70;
    spg_rasp = 30;

    function slider(elemId, sliderWidth, range1, range2, step) {
        var knobWidth = 17;				// ширина и высота бегунка
        var knobHeight = 21;			// изменяются в зависимости от используемых изображений
        var sliderHeight = 21;			// высота slider'а

        var offsX,tmp;					// вспомагательные переменные
        var d = document;
        var isIE = d.all || window.opera;	// определяем модель DOM
        var point = (sliderWidth-knobWidth-3)/(range2-range1);
        // point - количество пикселей на единицу значения

        var slider = d.createElement('DIV'); // создаем slider
        slider.id = elemId + '_slider';
        slider.className = 'slider';
        d.getElementById(elemId).appendChild(slider);

        var knob = d.createElement('DIV');	// создаем ползунок
        knob.id = elemId + '_knob';
        knob.className = 'knob';
        slider.appendChild(knob); // добавляем его в документ

        knob.style.left = 0;			// бегунок в нулевое значение
        knob.style.width = knobWidth+'px';
        knob.style.height = knobHeight+'px';
        slider.style.width = sliderWidth+'px';
        slider.style.height = sliderHeight+'px';

        var sliderOffset = slider.offsetLeft;			// sliderOffset - абсолютное смещение slider'а
        tmp = slider.offsetParent;		// от левого края в пикселях (в IE не работает)
        while(tmp.tagName != 'BODY') {
            sliderOffset += tmp.offsetLeft;		// тут его и находим
            tmp = tmp.offsetParent;
        }

        if(isIE)						// в зависимости от модели DOM
        {								// назначаем слушателей событий
            knob.onmousedown = startCoord;
            slider.onclick = sliderClick;
            knob.onmouseup = endCoord;
            slider.onmouseup = endCoord;
        }
        else {
            knob.addEventListener("mousedown", startCoord, true);
            slider.addEventListener("click", sliderClick, true);
            knob.addEventListener("mouseup", endCoord, true);
            slider.addEventListener("mouseup", endCoord, true);
        }


// далее подробно не описываю, кто захочет - разберется
//////////////////// функции установки/получения значения //////////////////////////

        function setValue(x)	// установка по пикселям
        {
            if(x < 0) knob.style.left = 0;
            else if(x > sliderWidth-knobWidth-3) knob.style.left = (sliderWidth-3-knobWidth)+'px';
            else {
                if(step == 0) knob.style.left = x+'px';
                else knob.style.left = Math.round(x/(step*point))*step*point+'px';
            }
            //d.getElementById('info').value = getValue();	// это вывод значения для примера
            jQuery('#info').html("ТП - " + getValue() + "%");
            var outside = 100-getValue();
            jQuery('#info2').html("СПГ - " + outside + "%");
        }
        function setValue2(x)	// установка по значению
        {
            if(x < range1 || x > range2) alert('Value is not included into a slider range!');
            else setValue((x-range1)*point);

            d.getElementById('info').value = getValue();
        }

        function getValue()
        {return Math.round(parseInt(knob.style.left)/point)+range1;}

//////////////////////////////// слушатели событий ////////////////////////////////////

        function sliderClick(e) {
            var x;
            if(isIE) {
                if(event.srcElement != slider) return; //IE onclick bug
                x = event.offsetX - Math.round(knobWidth/2);
            }
            else x = e.pageX-sliderOffset-knobWidth/2;
            setValue(x);
            tp_rasp = getValue();
            spg_rasp = 100-getValue();
            if(jQuery( "#scenario option:selected").text()=="Базовый")
                base_sc();
            if(jQuery( "#scenario option:selected").text()=="Пессимистический")
                pess_sc();
            if(jQuery( "#scenario option:selected").text()=="Оптимистический")
                opt_sc();
        }

        function startCoord(e) {
            if(isIE) {
                offsX = event.clientX - parseInt(knob.style.left);
                slider.onmousemove = mov;
            }
            else {
                slider.addEventListener("mousemove", mov, true);
            }
        }

        function mov(e)	{
            var x;
            if(isIE) x = event.clientX-offsX;
            else x = e.pageX-sliderOffset-knobWidth/2;
            setValue(x);
        }

        function endCoord()	{
            if(isIE) slider.onmousemove = null;
            else slider.removeEventListener("mousemove", mov, true);
        }

        // объявляем функции setValue2 и getValue как методы класса
        this.setValue = setValue2;
        this.getValue = getValue;
    } // конец класса

    var mysl2 = new slider('sl2', 400, 0, 100, 0);
    mysl2.setValue(70);

    function base_sc() {
        var data = [];
        var regas = [];
        <? global $link;
        $result = $link->query("SELECT * FROM cer_model_years ORDER BY year");
        $count=0;
        while($row=mysqli_fetch_array($result)) {
        ?>
        var stack_year = <? if($row[year]<=2020) echo '2020'; elseif($row[year]<=2025) echo '2025'; elseif($row[year]<=2030) echo '2030'; elseif($row[year]<=2035) echo '2035';?>;
        var stack_year_user_regas = jQuery('#regas_'+stack_year).val().replace(',', '.');

        if(stack_year==2020)
            if(parseFloat(jQuery( "#regas_2020").val().replace(',','.'))<69.90 || parseFloat(jQuery( "#regas_2020").val().replace(',','.'))>108.80)
                stack_year_user_regas = 100; 
        if(stack_year==2025)
            if(parseFloat(jQuery( "#regas_2025").val().replace(',','.'))<108.80 || parseFloat(jQuery( "#regas_2025").val().replace(',','.'))>130.56)
                stack_year_user_regas = 115; 
        if(stack_year==2030)
            if(parseFloat(jQuery( "#regas_2030").val().replace(',','.'))<108.80 || parseFloat(jQuery( "#regas_2030").val().replace(',','.'))>130.56)
                stack_year_user_regas = 120; 
        if(stack_year==2035)
            if(parseFloat(jQuery( "#regas_2035").val().replace(',','.'))<108.80 || parseFloat(jQuery( "#regas_2035").val().replace(',','.'))>130.56)
                stack_year_user_regas = 130; 

        if(<?=$row[year]?>!=2020 && <?=$row[year]?>!=2025 && <?=$row[year]?>!=2030 && <?=$row[year]?>!=2035)
            regas[<?=$count?>] = <? if($row[only_project]) echo str_replace(",",".",$row[regas_project]); else echo 'parseFloat(regas['.($count-1).'])+(parseFloat(stack_year_user_regas)-parseFloat(regas['.($count-1).']))/(parseFloat(stack_year)-'.($row[year]-1).')';?>;
        else
            regas[<?=$count?>] = stack_year_user_regas;
        var turk3 = <?=str_replace(",",".",$row[turk3])?>;
        var turk4 = <?=str_replace(",",".",$row[turk4])?>;
        var rus_sib = <?=str_replace(",",".",$row[rus_sib])?>;
        var import1 = parseFloat(<?=str_replace(",",".",$row[base_demand])?>)-parseFloat(<?=str_replace(",",".",$row[base_production])?>)-parseFloat(<?=str_replace(",",".",$row[turk1])?>)-parseFloat(<?=str_replace(",",".",$row[turk2])?>)-parseFloat(<?=str_replace(",",".",$row[mianma])?>)-parseFloat(<?=str_replace(",",".",$row[contracts_spg])?>);
        if(jQuery( "#turk_select option:selected").text()=="3 очередь") {
            import1 = import1-parseFloat(turk3);
        }
        if(jQuery( "#turk_select option:selected").text()=="4 очередь") {
            import1 = import1-(parseFloat(turk3)+parseFloat(turk4));
        }
        if(jQuery( "#rus_select option:selected").text()=="Сила сибири запускается") {
            import1 = import1-parseFloat(rus_sib);
        }
        if(import1<=0)
            import1=0;
        var importtp = import1*(tp_rasp/100);
        var importspg = import1*(spg_rasp/100);
        if(importspg>regas[<?=$count?>]) {
            importspg = <?=$row[regas_project]?>;
        }
        importtp = import1-parseFloat(importspg);

        data[<?=$count?>] = { "Year": "<?=$row[year]?>",
            "Добыча": "<?=$row[base_production]?>",
            "Контракты ТП": "<?=str_replace(",",".",$row[turk1])+str_replace(",",".",$row[turk2])+str_replace(",",".",$row[mianma])?>",
            "Контракты СПГ": "<?=$row[contracts_spg]?>",
            "Импорт ТП": importtp.toString(),
            "Импорт СПГ": importspg.toString()};

        for (var prop in data[<?=$count?>]) {
            data[<?=$count?>][prop] = data[<?=$count?>][prop].replace(',', '.');
            if(prop == 'Контракты ТП'){
                if(jQuery( "#turk_select option:selected").text()=="3 очередь") {
                    data[<?=$count?>][prop] = parseFloat(data[<?=$count?>][prop])+parseFloat(turk3);
                }
                if(jQuery( "#turk_select option:selected").text()=="4 очередь") {
                    data[<?=$count?>][prop] = parseFloat(data[<?=$count?>][prop])+parseFloat(turk3)+parseFloat(turk4);
                }
                if(jQuery( "#rus_select option:selected").text()=="Сила сибири запускается") {
                    data[<?=$count?>][prop] = parseFloat(data[<?=$count?>][prop])+parseFloat(rus_sib);
                }
            }
        }
        <?
         $count++;
        } ?>
        jQuery(".y.axis").find(".tick").empty();
        jQuery(".g").empty();

        color.domain(d3.keys(data[0]).filter(function(key) { return key !== "Year"; }));

        data.forEach(function(d) {
            var y0 = 0;
            d.ages = color.domain().map(function(name) { return {name: name, y0: y0, y1: y0 += +d[name]}; });
            d.total = d.ages[d.ages.length - 1].y1;
        });

        /*data.sort(function(a, b) { return b.total - a.total; });*/

        x.domain(data.map(function(d) { return d.Year; }));
        y.domain([0, d3.max(data, function(d) { return d.total; })]);

        svg.append("g")
            .attr("class", "y axis")
            .call(yAxis)
            .append("text");

        state = svg.selectAll(".state")
            .data(data)
            .enter().append("g")
            .attr("class", "g")
            .attr("transform", function(d) { return "translate(" + x(d.Year) + ",0)"; });

        state.selectAll("rect")
            .data(function(d) { return d.ages; })
            .enter().append("rect")
            .attr("width", x.rangeBand())
            .attr("y", function(d) { return y(d.y1); })
            .attr("height", function(d) { return y(d.y0) - y(d.y1); })
            .style("fill", function(d) { return color(d.name); });
    }
    function pess_sc() {
        var data = [];
        var regas = [];

        <? global $link;
        $result = $link->query("SELECT * FROM cer_model_years ORDER BY year");
        $count=0;
        while($row=mysqli_fetch_array($result)) {?>
        var stack_year = <? if($row[year]<=2020) echo '2020'; elseif($row[year]<=2025) echo '2025'; elseif($row[year]<=2030) echo '2030'; elseif($row[year]<=2035) echo '2035';?>;
        var stack_year_user_regas = jQuery('#regas_'+stack_year).val().replace(',', '.');

                if(stack_year==2020)
            if(parseFloat(jQuery( "#regas_2020").val().replace(',','.'))<69.90 || parseFloat(jQuery( "#regas_2020").val().replace(',','.'))>108.80)
                stack_year_user_regas = 100; 
        if(stack_year==2025)
            if(parseFloat(jQuery( "#regas_2025").val().replace(',','.'))<108.80 || parseFloat(jQuery( "#regas_2025").val().replace(',','.'))>130.56)
                stack_year_user_regas = 115; 
        if(stack_year==2030)
            if(parseFloat(jQuery( "#regas_2030").val().replace(',','.'))<108.80 || parseFloat(jQuery( "#regas_2030").val().replace(',','.'))>130.56)
                stack_year_user_regas = 120; 
        if(stack_year==2035)
            if(parseFloat(jQuery( "#regas_2035").val().replace(',','.'))<108.80 || parseFloat(jQuery( "#regas_2035").val().replace(',','.'))>130.56)
                stack_year_user_regas = 130; 

        if(<?=$row[year]?>!=2020 && <?=$row[year]?>!=2025 && <?=$row[year]?>!=2030 && <?=$row[year]?>!=2035)
            regas[<?=$count?>] = <? if($row[only_project]) echo str_replace(",",".",$row[regas_project]); else echo 'parseFloat(regas['.($count-1).'])+(parseFloat(stack_year_user_regas)-parseFloat(regas['.($count-1).']))/(parseFloat(stack_year)-'.($row[year]-1).')';?>;
        else
            regas[<?=$count?>] = stack_year_user_regas;
        var turk3 = <?=str_replace(",",".",$row[turk3])?>;
        var turk4 = <?=str_replace(",",".",$row[turk4])?>;
        var rus_sib = <?=str_replace(",",".",$row[rus_sib])?>;
        var import1 = parseFloat(<?=str_replace(",",".",$row[pess_demand])?>)-parseFloat(<?=str_replace(",",".",$row[pess_production])?>)-parseFloat(<?=str_replace(",",".",$row[turk1])?>)-parseFloat(<?=str_replace(",",".",$row[turk2])?>)-parseFloat(<?=str_replace(",",".",$row[mianma])?>)-parseFloat(<?=str_replace(",",".",$row[contracts_spg])?>);
        if(jQuery( "#turk_select option:selected").text()=="3 очередь") {
            import1 = import1-parseFloat(turk3);
        }
        if(jQuery( "#turk_select option:selected").text()=="4 очередь") {
            import1 = import1-(parseFloat(turk3)+parseFloat(turk4));
        }
        if(jQuery( "#rus_select option:selected").text()=="Сила сибири запускается") {
            import1 = import1-parseFloat(rus_sib);
        }
        if(import1<=0)
            import1=0;
        var importtp = import1*(tp_rasp/100);
        var importspg = import1*(spg_rasp/100);
        if(importspg>regas[<?=$count?>]) {
            importspg = <?=$row[regas_project]?>;
        }
        importtp = import1-parseFloat(importspg);

        data[<?=$count?>] = { "Year": "<?=$row[year]?>",
            "Добыча": "<?=$row[pess_production]?>",
            "Контракты ТП": "<?=str_replace(",",".",$row[turk1])+str_replace(",",".",$row[turk2])+str_replace(",",".",$row[mianma])?>",
            "Контракты СПГ": "<?=$row[contracts_spg]?>",
            "Импорт ТП": importtp.toString(),
            "Импорт СПГ": importspg.toString()};

        for (var prop in data[<?=$count?>]) {
            data[<?=$count?>][prop] = data[<?=$count?>][prop].replace(',', '.');
            if(prop == 'Контракты ТП'){
                if(jQuery( "#turk_select option:selected").text()=="3 очередь") {
                    data[<?=$count?>][prop] = parseFloat(data[<?=$count?>][prop])+parseFloat(turk3);
                }
                if(jQuery( "#turk_select option:selected").text()=="4 очередь") {
                    data[<?=$count?>][prop] = parseFloat(data[<?=$count?>][prop])+parseFloat(turk3)+parseFloat(turk4);
                }
                if(jQuery( "#rus_select option:selected").text()=="Сила сибири запускается") {
                    data[<?=$count?>][prop] = parseFloat(data[<?=$count?>][prop])+parseFloat(rus_sib);
                }
            }
        }
        <?
         $count++;
        } ?>
        jQuery(".y.axis").find(".tick").empty();
        jQuery(".g").empty();

        color.domain(d3.keys(data[0]).filter(function(key) { return key !== "Year"; }));

        data.forEach(function(d) {
            var y0 = 0;
            d.ages = color.domain().map(function(name) { return {name: name, y0: y0, y1: y0 += +d[name]}; });
            d.total = d.ages[d.ages.length - 1].y1;
        });

        /*data.sort(function(a, b) { return b.total - a.total; });*/

        x.domain(data.map(function(d) { return d.Year; }));
        y.domain([0, d3.max(data, function(d) { return d.total; })]);

        svg.append("g")
            .attr("class", "y axis")
            .call(yAxis)
            .append("text");

        state = svg.selectAll(".state")
            .data(data)
            .enter().append("g")
            .attr("class", "g")
            .attr("transform", function(d) { return "translate(" + x(d.Year) + ",0)"; });

        state.selectAll("rect")
            .data(function(d) { return d.ages; })
            .enter().append("rect")
            .attr("width", x.rangeBand())
            .attr("y", function(d) { return y(d.y1); })
            .attr("height", function(d) { return y(d.y0) - y(d.y1); })
            .style("fill", function(d) { return color(d.name); });
    }
    function opt_sc() {
        var data = [];
        var regas = [];

        <? global $link;
        $result = $link->query("SELECT * FROM cer_model_years ORDER BY year");
        $count=0;
        while($row=mysqli_fetch_array($result)) {?>
        var stack_year = <? if($row[year]<=2020) echo '2020'; elseif($row[year]<=2025) echo '2025'; elseif($row[year]<=2030) echo '2030'; elseif($row[year]<=2035) echo '2035';?>;
        var stack_year_user_regas = jQuery('#regas_'+stack_year).val().replace(',', '.');

        if(stack_year==2020)
            if(parseFloat(jQuery( "#regas_2020").val().replace(',','.'))<69.90 || parseFloat(jQuery( "#regas_2020").val().replace(',','.'))>108.80)
                stack_year_user_regas = 100; 
        if(stack_year==2025)
            if(parseFloat(jQuery( "#regas_2025").val().replace(',','.'))<108.80 || parseFloat(jQuery( "#regas_2025").val().replace(',','.'))>130.56)
                stack_year_user_regas = 115; 
        if(stack_year==2030)
            if(parseFloat(jQuery( "#regas_2030").val().replace(',','.'))<108.80 || parseFloat(jQuery( "#regas_2030").val().replace(',','.'))>130.56)
                stack_year_user_regas = 120; 
        if(stack_year==2035)
            if(parseFloat(jQuery( "#regas_2035").val().replace(',','.'))<108.80 || parseFloat(jQuery( "#regas_2035").val().replace(',','.'))>130.56)
                stack_year_user_regas = 130; 
        

        if(<?=$row[year]?>!=2020 && <?=$row[year]?>!=2025 && <?=$row[year]?>!=2030 && <?=$row[year]?>!=2035)
            regas[<?=$count?>] = <? if($row[only_project]) echo str_replace(",",".",$row[regas_project]); else echo 'parseFloat(regas['.($count-1).'])+(parseFloat(stack_year_user_regas)-parseFloat(regas['.($count-1).']))/(parseFloat(stack_year)-'.($row[year]-1).')';?>;
        else
            regas[<?=$count?>] = stack_year_user_regas;
        var turk3 = <?=str_replace(",",".",$row[turk3])?>;
        var turk4 = <?=str_replace(",",".",$row[turk4])?>;
        var rus_sib = <?=str_replace(",",".",$row[rus_sib])?>;
        var import1 = parseFloat(<?=str_replace(",",".",$row[opt_demand])?>)-parseFloat(<?=str_replace(",",".",$row[opt_production])?>)-parseFloat(<?=str_replace(",",".",$row[turk1])?>)-parseFloat(<?=str_replace(",",".",$row[turk2])?>)-parseFloat(<?=str_replace(",",".",$row[mianma])?>)-parseFloat(<?=str_replace(",",".",$row[contracts_spg])?>);
        if(jQuery( "#turk_select option:selected").text()=="3 очередь") {
            import1 = import1-parseFloat(turk3);
        }
        if(jQuery( "#turk_select option:selected").text()=="4 очередь") {
            import1 = import1-(parseFloat(turk3)+parseFloat(turk4));
        }
        if(jQuery( "#rus_select option:selected").text()=="Сила сибири запускается") {
            import1 = import1-parseFloat(rus_sib);
        }
        if(import1<=0)
            import1=0;
        var importtp = import1*(tp_rasp/100);
        var importspg = import1*(spg_rasp/100);
        if(importspg>regas[<?=$count?>]) {
            importspg = <?=$row[regas_project]?>;
        }
        importtp = import1-parseFloat(importspg);
        data[<?=$count?>] = { "Year": "<?=$row[year]?>",
            "Добыча": "<?=$row[opt_production]?>",
            "Контракты ТП": "<?=str_replace(",",".",$row[turk1])+str_replace(",",".",$row[turk2])+str_replace(",",".",$row[mianma])?>",
            "Контракты СПГ": "<?=$row[contracts_spg]?>",
            "Импорт ТП": importtp.toString(),
            "Импорт СПГ": importspg.toString()}

        for (var prop in data[<?=$count?>]) {
            data[<?=$count?>][prop] = data[<?=$count?>][prop].replace(',', '.');
            if(prop == 'Контракты ТП'){
                if(jQuery( "#turk_select option:selected").text()=="3 очередь") {
                    data[<?=$count?>][prop] = parseFloat(data[<?=$count?>][prop])+parseFloat(turk3);
                }
                if(jQuery( "#turk_select option:selected").text()=="4 очередь") {
                    data[<?=$count?>][prop] = parseFloat(data[<?=$count?>][prop])+parseFloat(turk3)+parseFloat(turk4);
                }
                if(jQuery( "#rus_select option:selected").text()=="Сила сибири запускается") {
                    data[<?=$count?>][prop] = parseFloat(data[<?=$count?>][prop])+parseFloat(rus_sib);
                }
            }
        }
        <?
         $count++;
        } ?>
        jQuery(".y.axis").find(".tick").empty();
        jQuery(".g").empty();

        color.domain(d3.keys(data[0]).filter(function(key) { return key !== "Year"; }));

        data.forEach(function(d) {
            var y0 = 0;
            d.ages = color.domain().map(function(name) { return {name: name, y0: y0, y1: y0 += +d[name]}; });
            d.total = d.ages[d.ages.length - 1].y1;
        });

        /*data.sort(function(a, b) { return b.total - a.total; });*/

        x.domain(data.map(function(d) { return d.Year; }));
        y.domain([0, d3.max(data, function(d) { return d.total; })]);

        svg.append("g")
            .attr("class", "y axis")
            .call(yAxis)
            .append("text");

        state = svg.selectAll(".state")
            .data(data)
            .enter().append("g")
            .attr("class", "g")
            .attr("transform", function(d) { return "translate(" + x(d.Year) + ",0)"; });

        state.selectAll("rect")
            .data(function(d) { return d.ages; })
            .enter().append("rect")
            .attr("width", x.rangeBand())
            .attr("y", function(d) { return y(d.y1); })
            .attr("height", function(d) { return y(d.y0) - y(d.y1); })
            .style("fill", function(d) { return color(d.name); });
    }

    jQuery( document ).ready(function( $ ) {

        jQuery( "#regas_2020" ).keyup(function() {
            if(parseFloat(jQuery( "#regas_2020").val().replace(',','.'))>=69.90 && parseFloat(jQuery( "#regas_2020").val().replace(',','.'))<=108.80) {
                if (jQuery("#scenario option:selected").text() == "Базовый")
                    base_sc();
                if (jQuery("#scenario option:selected").text() == "Пессимистический")
                    pess_sc();
                if (jQuery("#scenario option:selected").text() == "Оптимистический")
                    opt_sc();
            }
        });
        jQuery( "#regas_2025" ).keyup(function() {
            if(parseFloat(jQuery( "#regas_2025").val().replace(',','.'))>=108.80 && parseFloat(jQuery( "#regas_2025").val().replace(',','.'))<=130.56) {
                if (jQuery("#scenario option:selected").text() == "Базовый")
                    base_sc();
                if (jQuery("#scenario option:selected").text() == "Пессимистический")
                    pess_sc();
                if (jQuery("#scenario option:selected").text() == "Оптимистический")
                    opt_sc();
            }
        });
        jQuery( "#regas_2030" ).keyup(function() {
            if(parseFloat(jQuery( "#regas_2030").val().replace(',','.'))>=108.80 && parseFloat(jQuery( "#regas_2030").val().replace(',','.'))<=130.56) {
                if (jQuery("#scenario option:selected").text() == "Базовый")
                    base_sc();
                if (jQuery("#scenario option:selected").text() == "Пессимистический")
                    pess_sc();
                if (jQuery("#scenario option:selected").text() == "Оптимистический")
                    opt_sc();
            }
        });
        jQuery( "#regas_2035" ).keyup(function() {
            if(parseFloat(jQuery( "#regas_2035").val().replace(',','.'))>=108.80 && parseFloat(jQuery( "#regas_2035").val().replace(',','.'))<=130.56) {
                if (jQuery("#scenario option:selected").text() == "Базовый")
                    base_sc();
                if (jQuery("#scenario option:selected").text() == "Пессимистический")
                    pess_sc();
                if (jQuery("#scenario option:selected").text() == "Оптимистический")
                    opt_sc();
            }
        });

        jQuery( "#scenario" ).change(function() {
            if(jQuery( "#scenario option:selected").text()=="Базовый")
                base_sc();
            if(jQuery( "#scenario option:selected").text()=="Пессимистический")
                pess_sc();
            if(jQuery( "#scenario option:selected").text()=="Оптимистический")
                opt_sc();
        });
        jQuery( "#rus_select" ).change(function() {
            if(jQuery( "#scenario option:selected").text()=="Базовый")
                base_sc();
            if(jQuery( "#scenario option:selected").text()=="Пессимистический")
                pess_sc();
            if(jQuery( "#scenario option:selected").text()=="Оптимистический")
                opt_sc();
        });
        jQuery( "#turk_select" ).change(function() {
            if(jQuery( "#scenario option:selected").text()=="Базовый")
                base_sc();
            if(jQuery( "#scenario option:selected").text()=="Пессимистический")
                pess_sc();
            if(jQuery( "#scenario option:selected").text()=="Оптимистический")
                opt_sc();
        });


    var margin = {top: 20, right: 20, bottom: 100, left: 70},
        width = 590 - margin.left - margin.right,
        height = 500 - margin.top - margin.bottom;

    x = d3.scale.ordinal()
        .rangeRoundBands([0, width], .1);

    y = d3.scale.linear()
        .rangeRound([height, 0]);

    color = d3.scale.ordinal()
        .range(["#4576b5", "#b84644", "#91b24f", "#755998", "#42a2bf", "#d0743c", "#ff8c00"]);

    xAxis = d3.svg.axis()
        .scale(x)
        .orient("bottom");

    yAxis = d3.svg.axis()
        .scale(y)
        .orient("left")
        .tickFormat(d3.format(".2s"));

    svg = d3.select(".model-block").append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

    var data = [];
        var regas = [];

    <? global $link;
    $result = $link->query("SELECT * FROM cer_model_years ORDER BY year");
    $count=0;
    while($row=mysqli_fetch_array($result)) {?>
        var stack_year = <? if($row[year]<=2020) echo '2020'; elseif($row[year]<=2025) echo '2025'; elseif($row[year]<=2030) echo '2030'; elseif($row[year]<=2035) echo '2035';?>;
        var stack_year_user_regas = jQuery('#regas_'+stack_year).val().replace(',', '.');

                if(stack_year==2020)
            if(parseFloat(jQuery( "#regas_2020").val().replace(',','.'))<69.90 || parseFloat(jQuery( "#regas_2020").val().replace(',','.'))>108.80)
                stack_year_user_regas = 100; 
        if(stack_year==2025)
            if(parseFloat(jQuery( "#regas_2025").val().replace(',','.'))<108.80 || parseFloat(jQuery( "#regas_2025").val().replace(',','.'))>130.56)
                stack_year_user_regas = 115; 
        if(stack_year==2030)
            if(parseFloat(jQuery( "#regas_2030").val().replace(',','.'))<108.80 || parseFloat(jQuery( "#regas_2030").val().replace(',','.'))>130.56)
                stack_year_user_regas = 120; 
        if(stack_year==2035)
            if(parseFloat(jQuery( "#regas_2035").val().replace(',','.'))<108.80 || parseFloat(jQuery( "#regas_2035").val().replace(',','.'))>130.56)
                stack_year_user_regas = 130; 

        if(<?=$row[year]?>!=2020 && <?=$row[year]?>!=2025 && <?=$row[year]?>!=2030 && <?=$row[year]?>!=2035)
        regas[<?=$count?>] = <? if($row[only_project]) echo str_replace(",",".",$row[regas_project]); else echo 'parseFloat(regas['.($count-1).'])+(parseFloat(stack_year_user_regas)-parseFloat(regas['.($count-1).']))/(parseFloat(stack_year)-'.($row[year]-1).')';?>;
        else
        regas[<?=$count?>] = stack_year_user_regas;
        var turk3 = <?=str_replace(",",".",$row[turk3])?>;
        var turk4 = <?=str_replace(",",".",$row[turk4])?>;
        var rus_sib = <?=str_replace(",",".",$row[rus_sib])?>;
        var import1 = parseFloat(<?=str_replace(",",".",$row[base_demand])?>)-parseFloat(<?=str_replace(",",".",$row[base_production])?>)-parseFloat(<?=str_replace(",",".",$row[turk1])?>)-parseFloat(<?=str_replace(",",".",$row[turk2])?>)-parseFloat(<?=str_replace(",",".",$row[mianma])?>)-parseFloat(<?=str_replace(",",".",$row[contracts_spg])?>);
            import1 = import1-parseFloat(turk3);
            import1 = import1-parseFloat(rus_sib);
        if(import1<=0)
            import1=0;
        var importtp = import1*(tp_rasp/100);
        var importspg = import1*(spg_rasp/100);
        if(importspg>regas[<?=$count?>]) {
            importspg = <?=$row[regas_project]?>;
        }
        importtp = import1-parseFloat(importspg);
    data[<?=$count?>] = { "Year": "<?=$row[year]?>",
        "Добыча": "<?=$row[base_production]?>",
        "Контракты ТП": "<?=str_replace(",",".",$row[turk1])+str_replace(",",".",$row[turk2])+str_replace(",",".",$row[mianma])?>",
        "Контракты СПГ": "<?=$row[contracts_spg]?>",
        "Импорт ТП": importtp.toString(),
        "Импорт СПГ": importspg.toString()};

    for (var prop in data[<?=$count?>]) {
        data[<?=$count?>][prop] = data[<?=$count?>][prop].replace(',', '.');
        if(prop == 'Контракты ТП') {
            data[<?=$count?>][prop] = parseFloat(data[<?=$count?>][prop]) + parseFloat(turk3);
            data[<?=$count?>][prop] = parseFloat(data[<?=$count?>][prop]) + parseFloat(rus_sib);
        }
    }
    <?
     $count++;
    } ?>


    /*d3.csv("data2.csv", function(error, data) {
        if (error) throw error;*/

        /*data[10] = { "Year": "ex",
            "Under 5 Years": "40000000",
            "5 to 13 Years": "40000000",
            "14 to 17 Years": "4000000",
            "18 to 24 Years": "4000000",
            "25 to 44 Years": "4000000",
            "45 to 64 Years": "4000000",
            "65 Years and Over": "4000"};*/

        color.domain(d3.keys(data[0]).filter(function(key) { return key !== "Year"; }));

        data.forEach(function(d) {
            var y0 = 0;
            d.ages = color.domain().map(function(name) { return {name: name, y0: y0, y1: y0 += +d[name]}; });
            d.total = d.ages[d.ages.length - 1].y1;
        });

        /*data.sort(function(a, b) { return b.total - a.total; });*/

        x.domain(data.map(function(d) { return d.Year; }));
        y.domain([0, d3.max(data, function(d) { return d.total; })]);


        svg.append("g")
            .attr("class", "x axis")
            .attr("transform", "translate(0," + height + ")")
            .call(xAxis)
            .selectAll("text")
            .style("text-anchor", "end")
            .attr("dx", "-.8em")
            .attr("dy", "-5")
            .attr("transform", "rotate(-90)" );

        svg.append("g")
            .attr("class", "y axis")
            .call(yAxis)
            .append("text")
            .attr("transform", "rotate(-90)")
            .attr("y", -55)
            .attr("x", -150)
            .attr("dy", ".71em")
            .style("text-anchor", "end")
            .text("Млн. тонн");

        state = svg.selectAll(".state")
            .data(data)
            .enter().append("g")
            .attr("class", "g")
            .attr("transform", function(d) { return "translate(" + x(d.Year) + ",0)"; });

        state.selectAll("rect")
            .data(function(d) { return d.ages; })
            .enter().append("rect")
            .attr("width", x.rangeBand())
            .attr("y", function(d) { return y(d.y1); })
            .attr("height", function(d) { return y(d.y0) - y(d.y1); })
            .style("fill", function(d) { return color(d.name); });

        var legend = svg.selectAll(".legend")
            .data(color.domain().slice())
            .enter().append("g")
            .attr("class", "legend")
            .attr("transform", function(d, i) { return "translate(" + ((i * 115)-60) + ",0)"; });

        legend.append("text")
            .attr("x", 20+30)
            .attr("y", height+50+9)
            .attr("dy", ".35em")
            .text(function(d) { return d; });

    legend.append("rect")
        .attr("x", 20)
        .attr("y",height+50)
        .attr("width", 18)
        .attr("height", 18)
        .style("fill", color);


        /*legend.append("rect")
            .attr("x", width - 18)
            .attr("width", 18)
            .attr("height", 18)
            .style("fill", color);

        legend.append("text")
            .attr("x", width - 24)
            .attr("y", 9)
            .attr("dy", ".35em")
            .style("text-anchor", "end")
            .text(function(d) { return d; });*/

    /*});*/


    });

</script>