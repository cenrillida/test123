<?
global $_CONFIG, $site_templater, $DB;
	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

//        error_reporting(E_ALL);
//        ini_set('display_errors', 1);

	?>
<style>

    .model-block {
        font-family: Arial;
        font-size: 12px;
    }

    @media (max-width: 767px) {
        .model-block {
            transform: scale(0.8) translateX(-15%);
        }
    }
    @media (max-width: 600px) {
        .model-block {
            transform: scale(0.6) translateX(-40%);
        }
    }
    @media (max-width: 475px) {
        .model-block {
            transform: scale(0.4) translateX(-85%);
        }
    }
    @media (max-width: 350px) {
        .model-block {
            transform: scale(0.3) translateX(-125%);
        }
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
    .model-title {
        width: 100%;
        text-align: center;
        display: inline-block;
        font-size: 22px;
        margin-top: 15px;
    }

</style>
<div class="row">
    <div class="col-12">
        <div style="float: left; padding-left: 15px;">
            Страна:
            <select id="scenario" class="form-control">
                <option>США</option>
                <option>Китай</option>
                <option>Япония</option>
                <option>Германия</option>
                <option>Великобритания</option>
                <option>Франция</option>
                <option>Италия</option>
                <option>Индия</option>
                <option>Канада</option>
                <option>Бразилия</option>
                <option>Южная Корея</option>
                <option>Испания</option>
                <option>Мексика</option>
                <option>Россия</option>
                <option>Австралия</option>
                <option>Мир (по рыночным курсам 2014 г.)</option>
            </select>
        </div>
        <div style="float: left; padding-left: 15px;">
            Сценарий:
            <select id="knr_select" class="form-control">
                <option>Пессимистический</option>
                <option selected>Базовый</option>
                <option>Оптимистический</option>
            </select>
        </div>
    </div>
</div>
<div id="hovertitle"></div>
<div class="model-block"></div>
<div class="infowindow">
    <table class="table table-responsive">
        <tr>
            <td></td>
            <td>2000-2015 факт</td>
            <td>2016-2020</td>
            <td>2021-2025</td>
            <td>2026-2030</td>
            <td>2031-2035</td>
            <td>2016-2035 весь период</td>
        </tr>
        <tr>
            <td>Среднегодовой темп роста ВВП</td>
            <td id="model3-table11"></td>
            <td id="model3-table12"></td>
            <td id="model3-table13"></td>
            <td id="model3-table14"></td>
            <td id="model3-table15"></td>
            <td id="model3-table16"></td>
        </tr>
        <tr>
            <td>Вклад занятости</td>
            <td id="model3-table21"></td>
            <td id="model3-table22"></td>
            <td id="model3-table23"></td>
            <td id="model3-table24"></td>
            <td id="model3-table25"></td>
            <td id="model3-table26"></td>
        </tr>
        <tr>
            <td>Вклад капитала</td>
            <td id="model3-table31"></td>
            <td id="model3-table32"></td>
            <td id="model3-table33"></td>
            <td id="model3-table34"></td>
            <td id="model3-table35"></td>
            <td id="model3-table36"></td>
        </tr>
        <tr>
            <td>Вклад совокупной производительности факторов производства</td>
            <td id="model3-table41"></td>
            <td id="model3-table42"></td>
            <td id="model3-table43"></td>
            <td id="model3-table44"></td>
            <td id="model3-table45"></td>
            <td id="model3-table46"></td>
        </tr>
    </table>
</div>
<script src="/newsite/js/d3.v3.min.js"></script>
<script>

    tp_rasp = 70;
    spg_rasp = 30;
    choosed_first = 'usa';
    choosed_second = 'base';
    final_text="";

    oil_request = [];

    oil_request['pess'] = [];
    oil_request['base'] = [];
    oil_request['opt'] = [];

    contries = ['usa', 'china', 'japan', 'germany', 'uk', 'france', 'italy', 'india', 'canada', 'brazil', 'korea', 'spain', 'mexico', 'russia', 'australia', 'world'];
    years_arr = ['2000-2015', '2016-2020', '2021-2025', '2026-2030', '2031-2035', '2016-2035'];

    for (var i = 0; i <= 3; i++) {
        oil_request['pess'][i] = [];
        oil_request['base'][i] = [];
        oil_request['opt'][i] = [];
        contries.forEach(function logArrayElements(element, index, array) {
            oil_request['pess'][i][element] = [];
            oil_request['base'][i][element] = [];
            oil_request['opt'][i][element] = [];
        });
    }

    <?php

    if (($handle = fopen("/home/imemon/html/energyeconomics/tables/china_data.csv", "r")) !== FALSE) {

    $current_scenario = "";
    $row = 1;
    $minus = 0;
    $years_arr = array('2000-2015', '2016-2020', '2021-2025', '2026-2030', '2031-2035', '2016-2035');
    $current_scenario = "pess";
    $contries = array(4 => 'usa', 'china', 'japan', 'germany', 'uk', 'france', 'italy', 'india', 'canada', 'brazil', 'korea', 'spain', 'mexico', 'russia', 'australia', 'world');
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
    //var_dump($data);
    if(!empty($contries[$row-$minus]))
    {
    for ($i=0; $i <= 5; $i++) {
    ?>
    oil_request['<?=$current_scenario?>'][0]['<?=$contries[$row-$minus]?>']['<?=$years_arr[$i]?>'] = '<?=mb_convert_encoding($data[1+$i],"cp1251",'utf-8')?>';
    oil_request['<?=$current_scenario?>'][1]['<?=$contries[$row-$minus]?>']['<?=$years_arr[$i]?>'] = '<?=mb_convert_encoding($data[8+$i],"cp1251",'utf-8')?>';
    oil_request['<?=$current_scenario?>'][2]['<?=$contries[$row-$minus]?>']['<?=$years_arr[$i]?>'] = '<?=mb_convert_encoding($data[15+$i],"cp1251",'utf-8')?>';
    oil_request['<?=$current_scenario?>'][3]['<?=$contries[$row-$minus]?>']['<?=$years_arr[$i]?>'] = '<?=mb_convert_encoding($data[22+$i],"cp1251",'utf-8')?>';
    <?
    }
    }
    if($row==20) {
        $minus=20;
        $current_scenario='base';
    }
    if($row==40) {
        $minus=40;
        $current_scenario='opt';
    }
    $row++;
    }
    fclose($handle);
    }
    ?>

    function model_table() {
        for (var i = 0; i <= 5; i++) {
            jQuery('#model3-table1'+(i+1)).empty();
            jQuery('#model3-table1'+(i+1)).append(oil_request[choosed_second][0][choosed_first][years_arr[i]]);
            jQuery('#model3-table2'+(i+1)).empty();
            jQuery('#model3-table2'+(i+1)).append(oil_request[choosed_second][2][choosed_first][years_arr[i]]);
            jQuery('#model3-table3'+(i+1)).empty();
            jQuery('#model3-table3'+(i+1)).append(oil_request[choosed_second][1][choosed_first][years_arr[i]]);
            jQuery('#model3-table4'+(i+1)).empty();
            jQuery('#model3-table4'+(i+1)).append(oil_request[choosed_second][3][choosed_first][years_arr[i]]);
        };
    }

    function base_sc() {
        var data = [];
        var data_dots = [];

        count = 0;

        for (var key in oil_request[choosed_second][0][choosed_first]) {
            if (key!=0) {
                data[count] = { "Year": key,
                    "Вклад занятости": oil_request[choosed_second][2][choosed_first][key],
                    "Вклад капитала": oil_request[choosed_second][1][choosed_first][key],
                    "Вклад совокупной производительности факторов производства": oil_request[choosed_second][3][choosed_first][key]};

                for (var prop in data[count]) {
                    data[count][prop] = data[count][prop].replace(',', '.');
                }
                data_dots[count] = { "Year": key,
                    "Среднегодовой темп роста ВВП": oil_request[choosed_second][0][choosed_first][key]};

                for (var prop in data_dots[count]) {
                    data_dots[count][prop] = data_dots[count][prop].replace(',', '.');
                }

                count++;
            }
            if(key==0) {
                final_text=oil_request[choosed_first][choosed_second][0]['oil_request'];
                continue;
            }
        }
        jQuery(".y.axis").find(".tick").empty();
        jQuery(".g").empty();
        //jQuery(".legend").empty();

        color.domain(d3.keys(data[0]).filter(function(key) { return key !== "Year"; }));
        color2.domain(d3.keys(data_dots[0]).filter(function(key) { return key !== "Year"; }));

        data.forEach(function(d) {
            var y0 = 0;
            d.ages = color.domain().map(function(name) { return {name: name, y0: y0, y1: y0 += +d[name], vals: parseFloat(d[name])}; });
            var minus_all=0;
            for(var i = 0; i<=2; i++) {
                if(d.ages[i].vals<0){
                    d.ages[i].y1 = minus_all;
                    d.ages[i].y0 = minus_all+d.ages[i].vals;
                    minus_all = d.ages[i].y0;
                } else {
                    d.ages[i].y1 -= minus_all;
                    d.ages[i].y0 -= minus_all;
                }
            }
            d.total = d.ages[d.ages.length - 1].y1;
        });

        /*data.sort(function(a, b) { return b.total - a.total; });*/

        x.domain(data.map(function(d) { return d.Year; }));

        data_dots.forEach(function(d) {
            var y0 = 0;
            d.ages = color2.domain().map(function(name) { return {name: name, y0: y0, y1: y0 += +d[name], vals: parseFloat(d[name])}; });
            d.total = d.ages[d.ages.length - 1].y1;
        });

        x.domain(data_dots.map(function(d) { return d.Year; }));
        //y.domain([0, d3.max(data, function(d) { return d.total; })]);
        <?php
        $row_maxing = $DB->selectRow("SELECT * FROM cer_model3_settings LIMIT 1");
        ?>
        y.domain([<?=$row_maxing[min]?>, <?=$row_maxing[max]?>]);


        svg.append("g")
            .attr("class", "y axis")
            .call(yAxis)
            .append("text");

        svg.append("g")
            .attr("class","g")
            .append("text")
            .attr("y", 55)
            .attr("x", 100)
            .style("font-size", "17px")
            .style("fill","red")
            .text(final_text);

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
            .attr("height", function(d) { return Math.abs(y(d.y0) - y(d.y1)); })
            .attr("data-tooltip", function(d) { return d.vals;})
            .attr("data-tooltip-name", function(d) { return d.name;})
            .attr("data-toggle", 'tooltip')
            .attr("data-placement", 'top')
            .attr('data-html', 'true')
            .attr("data-original-title", function(d) { return '<div>'+d.name+'</div><div>'+d.vals+'</div>';})
            .style("fill", function(d) { return color(d.name); });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });

        dots = svg.selectAll(".state")
            .data(data_dots)
            .enter().append("g")
            .attr("class", "g")
            .attr("transform", function(d) { return "translate(" + x(d.Year) + ",0)"; });

        dots.selectAll(".dot")
            .data(function(d) { return d.ages; })
            .enter().append("circle")
            .attr("class", "dot")
            .attr("r", 3.5)
            .attr("cx", 37)
            .attr("cy", function(d) {
                return y(d.y1); });

        dots.append("text")
            .attr("x", 30)
            .attr("y", function(d) { return y(d.ages[0].y1)-20; })
            .attr("dy", ".35em")
            .text(function(d) {
                return d.ages[0].vals; });

        svg.append("g")
            .attr("class", "g")
            .attr("transform", "translate(10,0)")
            .append("rect")
            .attr("width", 1000)
            .attr("y", 381)
            .attr("height", 1535)
            .style("fill", "rgb(255,255,255)");

        var margin = {top: 20, right: 20, bottom: 100, left: 70},
            width = 690 - margin.left - margin.right,
            height = 500 - margin.top - margin.bottom;

        svg.append("g")
            .attr("class", "x axis")
            .attr("transform", "translate(37," + (height+20) + ")")
            .call(xAxis)
            .selectAll("text")
            .style("text-anchor", "end")
            .attr("dx", "-.8em")
            .attr("dy", "-5");

        svg.append("g")
            .attr("class","g")
            .attr("transform", "translate(37," + (height+38) + ")")
            .append("text")
            .text("факт");

        svg.append("g")
            .attr("class","g")
            .attr("transform", "translate(417," + (height+38) + ")")
            .append("text")
            .text("весь период");

        jQuery('.legend').parent().append(jQuery('.legend'));

        svg.append("g")
            .attr("class","g")
            .append("circle")
            .attr("class", "dot")
            .attr("r", 3.5)
            .attr("cx", -32)
            .attr("cy", 528);

        svg.append("g")
            .attr("class","g")
            .append("text")
            .attr("x", -10)
            .attr("y", 532)
            .text("Среднегодовой темп роста ВВП");


        // jQuery(".g").find('rect').mousemove(function(e) {
        //     var hovertext = $(this).attr("data-tooltip-name")+"<br>"+$(this).attr("data-tooltip");
        //     if($(this).attr("data-tooltip-name")!=undefined) {
        //         jQuery("#hovertitle").html(hovertext).show();
        //         jQuery("#hovertitle").css('top', jQuery(this).offset().top).css('left', e.clientX+12);
        //     }
        // }).mouseout(function() {
        //     jQuery("#hovertitle").hide();
        // });
    }

    jQuery( document ).ready(function( $ ) {
        model_table();

        jQuery( "#scenario" ).change(function() {
            if(jQuery( "#scenario option:selected").text()=="США") {
                choosed_first = "usa";
            }
            if(jQuery( "#scenario option:selected").text()=="Китай") {
                choosed_first = "china";
            }
            if(jQuery( "#scenario option:selected").text()=="Япония") {
                choosed_first = "japan";
            }
            if(jQuery( "#scenario option:selected").text()=="Германия") {
                choosed_first = "germany";
            }
            if(jQuery( "#scenario option:selected").text()=="Великобритания") {
                choosed_first = "uk";
            }
            if(jQuery( "#scenario option:selected").text()=="Франция") {
                choosed_first = "france";
            }
            if(jQuery( "#scenario option:selected").text()=="Италия") {
                choosed_first = "italy";
            }
            if(jQuery( "#scenario option:selected").text()=="Индия") {
                choosed_first = "india";
            }
            if(jQuery( "#scenario option:selected").text()=="Канада") {
                choosed_first = "canada";
            }
            if(jQuery( "#scenario option:selected").text()=="Бразилия") {
                choosed_first = "brazil";
            }
            if(jQuery( "#scenario option:selected").text()=="Южная Корея") {
                choosed_first = "korea";
            }
            if(jQuery( "#scenario option:selected").text()=="Испания") {
                choosed_first = "spain";
            }
            if(jQuery( "#scenario option:selected").text()=="Мексика") {
                choosed_first = "mexico";
            }
            if(jQuery( "#scenario option:selected").text()=="Россия") {
                choosed_first = "russia";
            }
            if(jQuery( "#scenario option:selected").text()=="Австралия") {
                choosed_first = "australia";
            }
            if(jQuery( "#scenario option:selected").text()=="Мир (по рыночным курсам 2014 г.)") {
                choosed_first = "world";
            }

            base_sc();
            model_table();
        });
        jQuery( "#knr_select" ).change(function() {
            if(jQuery( "#knr_select option:selected").text()=="Оптимистический") {
                choosed_second = "opt";
            }
            if(jQuery( "#knr_select option:selected").text()=="Базовый") {
                choosed_second = "base";
            }
            if(jQuery( "#knr_select option:selected").text()=="Пессимистический") {
                choosed_second = "pess";
            }

            base_sc();
            model_table();

        });


        var margin = {top: 20, right: 20, bottom: 100, left: 70},
            width = 690 - margin.left - margin.right,
            height = 500 - margin.top - margin.bottom;

        x = d3.scale.ordinal()
            .rangeRoundBands([0, width], .1);

        y = d3.scale.linear()
            .range([height, 0]);
        //.rangeRound([height, 0]);

        color = d3.scale.ordinal()
            .range(["#b84644", "#4576b5", "#91b24f", "#42a2bf", "#d0743c", "#ff8c00"]);

        color2 = d3.scale.ordinal()
            .range(["#b84644", "#4576b5", "#91b24f", "#42a2bf", "#d0743c", "#ff8c00"]);

        xAxis = d3.svg.axis()
            .scale(x)
            .orient("bottom");

        yAxis = d3.svg.axis()
            .scale(y)
            .orient("left")
            .ticks(6)
            .tickFormat(d3.format(".2s")).tickSubdivide(5).tickSize(-width, -width, -width);

        svg = d3.select(".model-block").append("svg")
            .attr("width", width + margin.left + margin.right)
            .attr("height", 575)
            /*.call(d3.behavior.zoom().on("zoom", function () {
                svg.attr("transform", "translate(" + d3.event.translate + ")" + " scale(" + d3.event.scale + ")")
              }))*/
            .append("g")
            .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

        var data = [];
        var data_dots = [];

        count = 0;

        for (var key in oil_request[choosed_second][0][choosed_first]) {
            if (key!=0) {
                data[count] = { "Year": key,
                    "Вклад занятости": oil_request[choosed_second][2][choosed_first][key],
                    "Вклад капитала": oil_request[choosed_second][1][choosed_first][key],
                    "Вклад совокупной производительности факторов производства": oil_request[choosed_second][3][choosed_first][key]};

                for (var prop in data[count]) {
                    data[count][prop] = data[count][prop].replace(',', '.');
                }
                data_dots[count] = { "Year": key,
                    "Среднегодовой темп роста ВВП": oil_request[choosed_second][0][choosed_first][key]};

                for (var prop in data_dots[count]) {
                    data_dots[count][prop] = data_dots[count][prop].replace(',', '.');
                }

                count++;
            }
            if(key==0) {
                final_text=oil_request[choosed_first][choosed_second][0]['oil_request'];
                continue;
            }
        }



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
        color2.domain(d3.keys(data_dots[0]).filter(function(key) { return key !== "Year"; }));

        data.forEach(function(d) {
            var y0 = 0;
            d.ages = color.domain().map(function(name) { return {name: name, y0: y0, y1: y0 += +d[name], vals: parseFloat(d[name])}; });
            var minus_all=0;
            for(var i = 0; i<=2; i++) {
                if(d.ages[i].vals<0){
                    d.ages[i].y1 = minus_all;
                    d.ages[i].y0 = minus_all+d.ages[i].vals;
                    minus_all = d.ages[i].y0;
                } else {
                    d.ages[i].y1 -= minus_all;
                    d.ages[i].y0 -= minus_all;
                }
            }
            d.total = d.ages[d.ages.length - 1].y1;
        });

        /*data.sort(function(a, b) { return b.total - a.total; });*/

        x.domain(data.map(function(d) { return d.Year; }));

        data_dots.forEach(function(d) {
            var y0 = 0;
            d.ages = color2.domain().map(function(name) { return {name: name, y0: y0, y1: y0 += +d[name], vals: parseFloat(d[name])}; });
            d.total = d.ages[d.ages.length - 1].y1;
        });

        x.domain(data_dots.map(function(d) { return d.Year; }));
        //y.domain([0, d3.max(data, function(d) { return d.total; })]); //АВТОМАТИЧЕСКИЙ ПОДГОН ПОД ВЫСОТУ

        y.domain([<?=$row_maxing[min]?>, <?=$row_maxing[max]?>]);

        svg.append("g")
            .attr("class", "y axis")
            .call(yAxis)
            .append("text")
            .attr("transform", "rotate(-90)")
            .attr("y", -55)
            .attr("x", -150)
            .attr("dy", ".71em")
            .style("text-anchor", "end");
        //   .text("млн. барр. в день");

        svg.append("g")
            .attr("class","g")
            .append("text")
            .attr("y", 55)
            .attr("x", 100)
            .style("font-size", "17px")
            .style("fill","red")
            .text(final_text);

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
            .attr("height", function(d) { return Math.abs(y(d.y0) - y(d.y1)); })
            .attr("data-tooltip", function(d) { return d.vals;})
            .attr("data-tooltip-name", function(d) { return d.name;})
            .attr("data-toggle", 'tooltip')
            .attr("data-placement", 'top')
            .attr('data-html', 'true')
            .attr("data-original-title", function(d) { return '<div>'+d.name+'</div><div>'+d.vals+'</div>';})
            .style("fill", function(d) { return color(d.name); });

        dots = svg.selectAll(".state")
            .data(data_dots)
            .enter().append("g")
            .attr("class", "g")
            .attr("transform", function(d) { return "translate(" + x(d.Year) + ",0)"; });

        dots.selectAll(".dot")
            .data(function(d) { return d.ages; })
            .enter().append("circle")
            .attr("class", "dot")
            .attr("r", 3.5)
            .attr("cx", 37)
            .attr("cy", function(d) {
                return y(d.y1); });

        dots.append("text")
            .attr("x", 30)
            .attr("y", function(d) { return y(d.ages[0].y1)-20; })
            .attr("dy", ".35em")
            .text(function(d) {
                return d.ages[0].vals; });

        svg.append("g")
            .attr("class", "g")
            .attr("transform", "translate(10,0)")
            .append("rect")
            .attr("width", 1000)
            .attr("y", 381)
            .attr("height", 1535)
            .style("fill", "rgb(255,255,255)");

        svg.append("g")
            .attr("class", "x axis")
            .attr("transform", "translate(37," + (height+20) + ")")
            .call(xAxis)
            .selectAll("text")
            .style("text-anchor", "end")
            .attr("dx", "-.8em")
            .attr("dy", "-5");

        svg.append("g")
            .attr("class","g")
            .attr("transform", "translate(37," + (height+38) + ")")
            .append("text")
            .text("факт");

        svg.append("g")
            .attr("class","g")
            .attr("transform", "translate(417," + (height+38) + ")")
            .append("text")
            .text("весь период");

        var legend = svg.selectAll(".legend")
            .data(color.domain().slice())
            .enter().append("g")
            .attr("class", "legend")
            .attr("transform", function(d, i) {
                var height_offset=30;
                return "translate(-60," + height_offset*i + ")"; });

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

        svg.append("g")
            .attr("class","g")
            .append("circle")
            .attr("class", "dot")
            .attr("r", 3.5)
            .attr("cx", -32)
            .attr("cy", 528);

        svg.append("g")
            .attr("class","g")
            .append("text")
            .attr("x", -10)
            .attr("y", 532)
            .text("Среднегодовой темп роста ВВП");


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
        // jQuery(".g").find('rect').mousemove(function(e) {
        //     var hovertext = $(this).attr("data-tooltip-name")+"<br>"+$(this).attr("data-tooltip");
        //     if($(this).attr("data-tooltip-name")!=undefined) {
        //         jQuery("#hovertitle").html(hovertext).show();
        //         jQuery("#hovertitle").css('top', jQuery(this).offset().top).css('left', e.clientX+12);
        //     }
        // }).mouseout(function() {
        //     jQuery("#hovertitle").hide();
        // });


    });

</script>

<?php

if ($_SESSION[lang]!='/en') {
    echo $_TPL_REPLACMENT['CONTENT'];
} else {
    echo $_TPL_REPLACMENT['CONTENT_EN'];
}

	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");

?>
