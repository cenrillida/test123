<style>

    .model-block {
        font-family: Arial;
        font-size: 12px;
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
<div style="float: left; padding-left: 15px;">
    Экономический рост в 2015-2035 гг.:
    <select id="scenario">
        <option>Пессимистический 2,7%</option>
        <option selected>Базовый 2,9%</option>
        <option>Оптимистический 3,2%</option>
    </select>
</div>
<div style="float: left; padding-left: 15px;">
    Средняя за период цена нефти Brent (долл. 2014 г.):
    <select id="knr_select">
        <option>59 долл. за барр.</option>
        <option selected>72 долл. за барр.</option>
        <option>100 долл. за барр.</option>
    </select>
</div>
<div class="model-title" style="font-weight: bold;">Пик спроса на нефть*</div>
<div id="hovertitle"></div>
<div class="model-block"></div>
<script src="//d3js.org/d3.v3.min.js"></script>
<script>

    tp_rasp = 70;
    spg_rasp = 30;
    choosed_first = 2;
    choosed_second = 2;
    final_text="";

    oil_request = [];

    oil_request[1] = [];
    oil_request[2] = [];
    oil_request[3] = [];

    oil_request[1][1] = [];
    oil_request[1][2] = [];
    oil_request[1][3] = [];
    oil_request[2][1] = [];
    oil_request[2][2] = [];
    oil_request[2][3] = [];
    oil_request[3][1] = [];
    oil_request[3][2] = [];
    oil_request[3][3] = [];

    <?php
         $row = 1;
    if (($handle = fopen("/home/imemon/html/energyeconomics/tables/oil_request.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            //$num = count($data);
            if($row>1)
            {
                ?>
                    oil_request[1][1][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>] = [];
                    oil_request[1][2][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>] = [];
                    oil_request[1][3][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>] = [];
                    oil_request[2][1][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>] = [];
                    oil_request[2][2][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>] = [];
                    oil_request[2][3][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>] = [];
                    oil_request[3][1][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>] = [];
                    oil_request[3][2][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>] = [];
                    oil_request[3][3][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>] = [];
                    oil_request[1][1][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>]['oil_request']='<?=mb_convert_encoding($data[1],"utf-8","windows-1251")?>';
                    oil_request[1][2][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>]['oil_request']='<?=mb_convert_encoding($data[5],"utf-8","windows-1251")?>';
                    oil_request[1][3][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>]['oil_request']='<?=mb_convert_encoding($data[4],"utf-8","windows-1251")?>';
                    oil_request[2][1][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>]['oil_request']='<?=mb_convert_encoding($data[7],"utf-8","windows-1251")?>';
                    oil_request[2][2][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>]['oil_request']='<?=mb_convert_encoding($data[2],"utf-8","windows-1251")?>';
                    oil_request[2][3][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>]['oil_request']='<?=mb_convert_encoding($data[6],"utf-8","windows-1251")?>';
                    oil_request[3][1][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>]['oil_request']='<?=mb_convert_encoding($data[9],"utf-8","windows-1251")?>';
                    oil_request[3][2][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>]['oil_request']='<?=mb_convert_encoding($data[8],"utf-8","windows-1251")?>';
                    oil_request[3][3][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>]['oil_request']='<?=mb_convert_encoding($data[3],"utf-8","windows-1251")?>';
                <?
            }            
            $row++;
        }
        fclose($handle);
    }
             $row = 1;
    if (($handle = fopen("/home/imemon/html/energyeconomics/tables/ctl_request.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            //$num = count($data);
            if($row>1)
            {
                ?>
                    oil_request[1][1][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>]['ctl_request']='<?=mb_convert_encoding($data[1],"utf-8","windows-1251")?>';
                    oil_request[1][2][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>]['ctl_request']='<?=mb_convert_encoding($data[5],"utf-8","windows-1251")?>';
                    oil_request[1][3][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>]['ctl_request']='<?=mb_convert_encoding($data[4],"utf-8","windows-1251")?>';
                    oil_request[2][1][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>]['ctl_request']='<?=mb_convert_encoding($data[7],"utf-8","windows-1251")?>';
                    oil_request[2][2][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>]['ctl_request']='<?=mb_convert_encoding($data[2],"utf-8","windows-1251")?>';
                    oil_request[2][3][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>]['ctl_request']='<?=mb_convert_encoding($data[6],"utf-8","windows-1251")?>';
                    oil_request[3][1][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>]['ctl_request']='<?=mb_convert_encoding($data[9],"utf-8","windows-1251")?>';
                    oil_request[3][2][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>]['ctl_request']='<?=mb_convert_encoding($data[8],"utf-8","windows-1251")?>';
                    oil_request[3][3][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>]['ctl_request']='<?=mb_convert_encoding($data[3],"utf-8","windows-1251")?>';
                <?
            }            
            $row++;
        }
        fclose($handle);
    }
             $row = 1;
    if (($handle = fopen("/home/imemon/html/energyeconomics/tables/bio_oil.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            //$num = count($data);
            if($row>1)
            {
                ?>
                    oil_request[1][1][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>]['bio_oil']='<?=mb_convert_encoding($data[1],"utf-8","windows-1251")?>';
                    oil_request[1][2][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>]['bio_oil']='<?=mb_convert_encoding($data[5],"utf-8","windows-1251")?>';
                    oil_request[1][3][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>]['bio_oil']='<?=mb_convert_encoding($data[4],"utf-8","windows-1251")?>';
                    oil_request[2][1][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>]['bio_oil']='<?=mb_convert_encoding($data[7],"utf-8","windows-1251")?>';
                    oil_request[2][2][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>]['bio_oil']='<?=mb_convert_encoding($data[2],"utf-8","windows-1251")?>';
                    oil_request[2][3][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>]['bio_oil']='<?=mb_convert_encoding($data[6],"utf-8","windows-1251")?>';
                    oil_request[3][1][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>]['bio_oil']='<?=mb_convert_encoding($data[9],"utf-8","windows-1251")?>';
                    oil_request[3][2][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>]['bio_oil']='<?=mb_convert_encoding($data[8],"utf-8","windows-1251")?>';
                    oil_request[3][3][<? if(!empty($data[0]) && is_numeric($data[0])) echo $data[0]; else echo '0';?>]['bio_oil']='<?=mb_convert_encoding($data[3],"utf-8","windows-1251")?>';
                <?
            }            
            $row++;
        }
        fclose($handle);
    }
    ?>

    function base_sc() {
        var data = [];
        count = 0;

        for (var key in oil_request[choosed_first][choosed_second]) {
            if (oil_request[choosed_first][choosed_second].hasOwnProperty(key) &&
                /^0$|^[1-9]\d*$/.test(key) &&
                key <= 4294967294 && key>=2016) {
                    data[count] = { "Year": key,
                    "Спрос на сырую нефть и конденсат": oil_request[choosed_first][choosed_second][key]['oil_request'],
                    "\"Газ в жидкость\" и \"уголь в жидкость\"": oil_request[choosed_first][choosed_second][key]['ctl_request'],
                    "Биотоплива": oil_request[choosed_first][choosed_second][key]['bio_oil']};

                for (var prop in data[count]) {
                    data[count][prop] = data[count][prop].replace(',', '.');
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

        data.forEach(function(d) {
            var y0 = 0;
            d.ages = color.domain().map(function(name) { return {name: name, y0: y0, y1: y0 += +d[name], vals: (Math.round(d[name] * 100)/100)}; });
            d.total = d.ages[d.ages.length - 1].y1;
        });

        /*data.sort(function(a, b) { return b.total - a.total; });*/

        x.domain(data.map(function(d) { return d.Year; }));
        //y.domain([0, d3.max(data, function(d) { return d.total; })]);
        <?php
$result_maxing = $link->query("SELECT * FROM cer_model2_settings LIMIT 1");
while($row_maxing=mysqli_fetch_array($result_maxing)) {?>
        y.domain([<?=$row_maxing[min]?>, <?=$row_maxing[max]?>]);
        <?
        }?>

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
            .style("font-weight","bold")
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
            .attr("height", function(d) { return y(d.y0) - y(d.y1); })
            .attr("data-tooltip", function(d) { return d.vals;})
            .attr("data-tooltip-name", function(d) { return d.name;})
            .style("fill", function(d) { return color(d.name); });

        svg.append("g")
            .attr("class", "g")
            .attr("transform", "translate(10,0)")
            .append("rect")
            .attr("width", 1000)
            .attr("y", 381)
            .attr("height", 1535)
            .style("fill", "rgb(255,255,255)");

        var margin = {top: 20, right: 20, bottom: 100, left: 70},
        width = 590 - margin.left - margin.right,
        height = 500 - margin.top - margin.bottom;

        svg.append("g")
            .attr("class", "x axis")
            .attr("transform", "translate(0," + height + ")")
            .call(xAxis)
            .selectAll("text")
            .style("text-anchor", "end")
            .attr("dx", "-.8em")
            .attr("dy", "-5")
            .attr("transform", "rotate(-90)" );

        jQuery('.legend').parent().append(jQuery('.legend'));


        jQuery(".g").find('rect').mousemove(function(e) {
            var hovertext = $(this).attr("data-tooltip-name")+"<br>"+$(this).attr("data-tooltip");
            if($(this).attr("data-tooltip-name")!=undefined) {
                jQuery("#hovertitle").html(hovertext).show();
                jQuery("#hovertitle").css('top', jQuery(this).offset().top).css('left', e.clientX+12);
            }
        }).mouseout(function() {
            jQuery("#hovertitle").hide();
        });
    }

    jQuery( document ).ready(function( $ ) {

        jQuery( "#scenario" ).change(function() {
            if(jQuery( "#scenario option:selected").text()=="Пессимистический 2,7%") {
                choosed_first = 1;
            }
            if(jQuery( "#scenario option:selected").text()=="Базовый 2,9%" ) {
                choosed_first = 2;
            }
            if(jQuery( "#scenario option:selected").text()=="Оптимистический 3,2%") {
                choosed_first = 3;
            }

            base_sc();
        });
        jQuery( "#knr_select" ).change(function() {
            if(jQuery( "#knr_select option:selected").text()=="59 долл. за барр.") {
                choosed_second = 1;
            }
            if(jQuery( "#knr_select option:selected").text()=="72 долл. за барр.") {
                choosed_second = 2;
            }
            if(jQuery( "#knr_select option:selected").text()=="100 долл. за барр.") {
                choosed_second = 3;
            }

            base_sc();

        });


    var margin = {top: 20, right: 20, bottom: 100, left: 70},
        width = 590 - margin.left - margin.right,
        height = 500 - margin.top - margin.bottom;

    x = d3.scale.ordinal()
        .rangeRoundBands([0, width], .1);

    y = d3.scale.linear()
        .rangeRound([height, 0]);

    color = d3.scale.ordinal()
        .range(["#4576b5", "#b84644", "#91b24f", "#42a2bf", "#d0743c", "#ff8c00"]);

    xAxis = d3.svg.axis()
        .scale(x)
        .orient("bottom");

    yAxis = d3.svg.axis()
        .scale(y)
        .orient("left")
        .ticks(6);
        //.tickFormat(d3.format(".3s"));

    svg = d3.select(".model-block").append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

    var data = [];

    count = 0;

    for (var key in oil_request[choosed_first][choosed_second]) {
        if (oil_request[choosed_first][choosed_second].hasOwnProperty(key) &&
            /^0$|^[1-9]\d*$/.test(key) &&
            key <= 4294967294 && key>=2016) {
                data[count] = { "Year": key,
                "Спрос на сырую нефть и конденсат": oil_request[choosed_first][choosed_second][key]['oil_request'],
                "\"Газ в жидкость\" и \"уголь в жидкость\"": oil_request[choosed_first][choosed_second][key]['ctl_request'],
                "Биотоплива": oil_request[choosed_first][choosed_second][key]['bio_oil']};

            for (var prop in data[count]) {
                data[count][prop] = data[count][prop].replace(',', '.');
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

        data.forEach(function(d) {
            var y0 = 0;
            d.ages = color.domain().map(function(name) { return {name: name, y0: y0, y1: y0 += +d[name], vals: (Math.round(d[name] * 100)/100)}; });
            d.total = d.ages[d.ages.length - 1].y1;
        });

        /*data.sort(function(a, b) { return b.total - a.total; });*/

        x.domain(data.map(function(d) { return d.Year; }));
        //y.domain([0, d3.max(data, function(d) { return d.total; })]); //АВТОМАТИЧЕСКИЙ ПОДГОН ПОД ВЫСОТУ
        <?php
    $result_maxing = $link->query("SELECT * FROM cer_model2_settings LIMIT 1");
    while($row_maxing=mysqli_fetch_array($result_maxing)) {?>
            y.domain([<?=$row_maxing[min]?>, <?=$row_maxing[max]?>]);
        <?
        }?>

        svg.append("g")
            .attr("class", "y axis")
            .call(yAxis)
            .append("text")
            .attr("transform", "rotate(-90)")
            .attr("y", -55)
            .attr("x", -150)
            .attr("dy", ".71em")
            .style("text-anchor", "end")
            .text("млн. барр. в день");

        svg.append("g")
            .attr("class","g")
            .append("text")
            .attr("y", 55)
            .attr("x", 100)
            .style("font-size", "17px")
            .style("fill","red")
            .style("font-weight","bold")
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
            .attr("height", function(d) { return y(d.y0) - y(d.y1); })
            .attr("data-tooltip", function(d) { return d.vals;})
            .attr("data-tooltip-name", function(d) { return d.name;})
            .style("fill", function(d) { return color(d.name); });

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
            .attr("transform", "translate(0," + height + ")")
            .call(xAxis)
            .selectAll("text")
            .style("text-anchor", "end")
            .attr("dx", "-.8em")
            .attr("dy", "-5")
            .attr("transform", "rotate(-90)" );

        var legend = svg.selectAll(".legend")
            .data(color.domain().slice())
            .enter().append("g")
            .attr("class", "legend")
            .attr("transform", function(d, i) {
                var height_offset=0;
                if(i==1 || i==3) {
                    height_offset = 30;
                    i--;
                }
                return "translate(" + ((i * 135)-60) + "," + height_offset + ")"; });

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
        jQuery(".g").find('rect').mousemove(function(e) {
            var hovertext = $(this).attr("data-tooltip-name")+"<br>"+$(this).attr("data-tooltip");
            if($(this).attr("data-tooltip-name")!=undefined) {
                jQuery("#hovertitle").html(hovertext).show();
                jQuery("#hovertitle").css('top', jQuery(this).offset().top).css('left', e.clientX+12);
            }
        }).mouseout(function() {
            jQuery("#hovertitle").hide();
        });


    });

</script>