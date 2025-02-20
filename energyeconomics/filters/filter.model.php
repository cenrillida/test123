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

</style>
<div style="float: left; padding-left: 15px;">
    Сценарии экономического роста:
    <select id="scenario">
        <option>Базовый</option>
        <option>Пессимистический</option>
        <option>Оптимистический</option>
    </select>
</div>
<div style="float: left; padding-left: 15px;">
    Сценарии политики КНР:
    <select id="knr_select">
        <option>50% трубопроводный газ и 50% СПГ</option>
        <option>Приоритет трубопроводного газа</option>
        <option>Приоритет СПГ</option>
    </select>
</div>
<div style="float: left; padding-left: 15px;">
    Ограничения на трубопроводы:<br>
    Туркменистан:
    <select id="turk_select">
        <option>4 очередь запускается</option>
        <option>4 очередь не запускается</option>
    </select><br>
    Россия:
    <select id="rus_select">
        <option>"Алтай" запускается</option>
        <option>"Алтай" не запускается</option>
    </select>
</div>
<div id="hovertitle"></div>
<div class="model-block"></div>
<script src="//d3js.org/d3.v3.min.js"></script>
<script>

    tp_rasp = 70;
    spg_rasp = 30;

    function base_sc() {
        var data = [];
        var regas = [];
        <? global $link;
        $result = $link->query("SELECT * FROM cer_model_years_new_base ORDER BY year");
        $count=0;
        while($row=mysqli_fetch_array($result)) {
        ?>
        var import_contacts_spg="";
        var import_tp="";
        var import_spg="";
        if(jQuery( "#knr_select option:selected").text()=="50% трубопроводный газ и 50% СПГ") {
            import_contacts_spg="<?=$row[base_import_contracts_spg]?>";
            import_tp="<?=$row[base_import_tp]?>";
            import_spg="<?=$row[base_import_spg]?>";
        }
        if(jQuery( "#knr_select option:selected").text()=="Приоритет трубопроводного газа") {
            if(jQuery( "#turk_select option:selected").text()=="4 очередь не запускается" && jQuery( "#rus_select option:selected").text()=="\"Алтай\" не запускается") {
                import_contacts_spg = "<?=$row[base_import_contracts_spg2]?>";
                import_tp = "<?=$row[base_import_tp2]?>";
                import_spg = "<?=$row[base_import_spg2]?>";
            }
            if(jQuery( "#turk_select option:selected").text()=="4 очередь запускается" && jQuery( "#rus_select option:selected").text()=="\"Алтай\" не запускается") {
                import_contacts_spg = "<?=$row[base_import_contracts_spg4]?>";
                import_tp = "<?=$row[base_import_tp4]?>";
                import_spg = "<?=$row[base_import_spg4]?>";
            }
            if(jQuery( "#turk_select option:selected").text()=="4 очередь не запускается" && jQuery( "#rus_select option:selected").text()=="\"Алтай\" запускается") {
                import_contacts_spg = "<?=$row[base_import_contracts_spg5]?>";
                import_tp = "<?=$row[base_import_tp5]?>";
                import_spg = "<?=$row[base_import_spg5]?>";
            }
            if(jQuery( "#turk_select option:selected").text()=="4 очередь запускается" && jQuery( "#rus_select option:selected").text()=="\"Алтай\" запускается") {
                import_contacts_spg = "<?=$row[base_import_contracts_spg6]?>";
                import_tp = "<?=$row[base_import_tp6]?>";
                import_spg = "<?=$row[base_import_spg6]?>";
            }
        }
        if(jQuery( "#knr_select option:selected").text()=="Приоритет СПГ") {
            import_contacts_spg="<?=$row[base_import_contracts_spg3]?>";
            import_tp="<?=$row[base_import_tp3]?>";
            import_spg="<?=$row[base_import_spg3]?>";
        }

        data[<?=$count?>] = { "Year": "<?=$row[year]?>",
            "Добыча": "<?=$row[base_production]?>",
            "Импорт по действующим контрактам СПГ": import_contacts_spg,
            "Импорт трубопроводного газа": import_tp,
            "Дополнительный импорт СПГ": import_spg};

        for (var prop in data[<?=$count?>]) {
            data[<?=$count?>][prop] = data[<?=$count?>][prop].replace(',', '.');
        }
        <?
         $count++;
        } ?>
        jQuery(".y.axis").find(".tick").empty();
        jQuery(".g").empty();

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
$result_maxing = $link->query("SELECT * FROM cer_model_settings LIMIT 1");
while($row_maxing=mysqli_fetch_array($result_maxing)) {?>
        y.domain([<?=$row_maxing[min]?>, <?=$row_maxing[max]?>]);
        <?
        }?>

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
            .attr("data-tooltip", function(d) { return d.vals;})
            .attr("data-tooltip-name", function(d) { return d.name;})
            .style("fill", function(d) { return color(d.name); });
        jQuery(".g").find('rect').mousemove(function(e) {
            var hovertext = $(this).attr("data-tooltip-name")+"<br>"+$(this).attr("data-tooltip");
            jQuery("#hovertitle").html(hovertext).show();
            jQuery("#hovertitle").css('top', jQuery(this).offset().top).css('left', e.clientX+12);
        }).mouseout(function() {
            jQuery("#hovertitle").hide();
        });
    }
    function pess_sc() {
        var data = [];
        var regas = [];

        <? global $link;
        $result = $link->query("SELECT * FROM cer_model_years_new_pess ORDER BY year");
        $count=0;
        while($row=mysqli_fetch_array($result)) {?>
        var import_contacts_spg="";
        var import_tp="";
        var import_spg="";
        if(jQuery( "#knr_select option:selected").text()=="50% трубопроводный газ и 50% СПГ") {
            import_contacts_spg="<?=$row[base_import_contracts_spg]?>";
            import_tp="<?=$row[base_import_tp]?>";
            import_spg="<?=$row[base_import_spg]?>";
        }
        if(jQuery( "#knr_select option:selected").text()=="Приоритет трубопроводного газа") {
            if(jQuery( "#turk_select option:selected").text()=="4 очередь не запускается" && jQuery( "#rus_select option:selected").text()=="\"Алтай\" не запускается") {
                import_contacts_spg = "<?=$row[base_import_contracts_spg2]?>";
                import_tp = "<?=$row[base_import_tp2]?>";
                import_spg = "<?=$row[base_import_spg2]?>";
            }
            if(jQuery( "#turk_select option:selected").text()=="4 очередь запускается" && jQuery( "#rus_select option:selected").text()=="\"Алтай\" не запускается") {
                import_contacts_spg = "<?=$row[base_import_contracts_spg4]?>";
                import_tp = "<?=$row[base_import_tp4]?>";
                import_spg = "<?=$row[base_import_spg4]?>";
            }
            if(jQuery( "#turk_select option:selected").text()=="4 очередь не запускается" && jQuery( "#rus_select option:selected").text()=="\"Алтай\" запускается") {
                import_contacts_spg = "<?=$row[base_import_contracts_spg5]?>";
                import_tp = "<?=$row[base_import_tp5]?>";
                import_spg = "<?=$row[base_import_spg5]?>";
            }
            if(jQuery( "#turk_select option:selected").text()=="4 очередь запускается" && jQuery( "#rus_select option:selected").text()=="\"Алтай\" запускается") {
                import_contacts_spg = "<?=$row[base_import_contracts_spg6]?>";
                import_tp = "<?=$row[base_import_tp6]?>";
                import_spg = "<?=$row[base_import_spg6]?>";
            }
        }
        if(jQuery( "#knr_select option:selected").text()=="Приоритет СПГ") {
            import_contacts_spg="<?=$row[base_import_contracts_spg3]?>";
            import_tp="<?=$row[base_import_tp3]?>";
            import_spg="<?=$row[base_import_spg3]?>";
        }

        data[<?=$count?>] = { "Year": "<?=$row[year]?>",
            "Добыча": "<?=$row[base_production]?>",
            "Импорт по действующим контрактам СПГ": import_contacts_spg,
            "Импорт трубопроводного газа": import_tp,
            "Дополнительный импорт СПГ": import_spg};

        for (var prop in data[<?=$count?>]) {
            data[<?=$count?>][prop] = data[<?=$count?>][prop].replace(',', '.');
        }
        <?
         $count++;
        } ?>
        jQuery(".y.axis").find(".tick").empty();
        jQuery(".g").empty();

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
$result_maxing = $link->query("SELECT * FROM cer_model_settings LIMIT 1");
while($row_maxing=mysqli_fetch_array($result_maxing)) {?>
        y.domain([<?=$row_maxing[min]?>, <?=$row_maxing[max]?>]);
        <?
        }?>

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
            .attr("data-tooltip", function(d) { return d.vals;})
            .attr("data-tooltip-name", function(d) { return d.name;})
            .style("fill", function(d) { return color(d.name); });
        jQuery(".g").find('rect').mousemove(function(e) {
            var hovertext = $(this).attr("data-tooltip-name")+"<br>"+$(this).attr("data-tooltip");
            jQuery("#hovertitle").html(hovertext).show();
            jQuery("#hovertitle").css('top', jQuery(this).offset().top).css('left', e.clientX+12);
        }).mouseout(function() {
            jQuery("#hovertitle").hide();
        });
    }
    function opt_sc() {
        var data = [];
        var regas = [];

        <? global $link;
        $result = $link->query("SELECT * FROM cer_model_years_new_opt ORDER BY year");
        $count=0;
        while($row=mysqli_fetch_array($result)) {?>
        var import_contacts_spg="";
        var import_tp="";
        var import_spg="";
        if(jQuery( "#knr_select option:selected").text()=="50% трубопроводный газ и 50% СПГ") {
            import_contacts_spg="<?=$row[base_import_contracts_spg]?>";
            import_tp="<?=$row[base_import_tp]?>";
            import_spg="<?=$row[base_import_spg]?>";
        }
        if(jQuery( "#knr_select option:selected").text()=="Приоритет трубопроводного газа") {
            if(jQuery( "#turk_select option:selected").text()=="4 очередь не запускается" && jQuery( "#rus_select option:selected").text()=="\"Алтай\" не запускается") {
                import_contacts_spg = "<?=$row[base_import_contracts_spg2]?>";
                import_tp = "<?=$row[base_import_tp2]?>";
                import_spg = "<?=$row[base_import_spg2]?>";
            }
            if(jQuery( "#turk_select option:selected").text()=="4 очередь запускается" && jQuery( "#rus_select option:selected").text()=="\"Алтай\" не запускается") {
                import_contacts_spg = "<?=$row[base_import_contracts_spg4]?>";
                import_tp = "<?=$row[base_import_tp4]?>";
                import_spg = "<?=$row[base_import_spg4]?>";
            }
            if(jQuery( "#turk_select option:selected").text()=="4 очередь не запускается" && jQuery( "#rus_select option:selected").text()=="\"Алтай\" запускается") {
                import_contacts_spg = "<?=$row[base_import_contracts_spg5]?>";
                import_tp = "<?=$row[base_import_tp5]?>";
                import_spg = "<?=$row[base_import_spg5]?>";
            }
            if(jQuery( "#turk_select option:selected").text()=="4 очередь запускается" && jQuery( "#rus_select option:selected").text()=="\"Алтай\" запускается") {
                import_contacts_spg = "<?=$row[base_import_contracts_spg6]?>";
                import_tp = "<?=$row[base_import_tp6]?>";
                import_spg = "<?=$row[base_import_spg6]?>";
            }
        }
        if(jQuery( "#knr_select option:selected").text()=="Приоритет СПГ") {
            import_contacts_spg="<?=$row[base_import_contracts_spg3]?>";
            import_tp="<?=$row[base_import_tp3]?>";
            import_spg="<?=$row[base_import_spg3]?>";
        }

        data[<?=$count?>] = { "Year": "<?=$row[year]?>",
            "Добыча": "<?=$row[base_production]?>",
            "Импорт по действующим контрактам СПГ": import_contacts_spg,
            "Импорт трубопроводного газа": import_tp,
            "Дополнительный импорт СПГ": import_spg};

        for (var prop in data[<?=$count?>]) {
            data[<?=$count?>][prop] = data[<?=$count?>][prop].replace(',', '.');
        }
        <?
         $count++;
        } ?>
        jQuery(".y.axis").find(".tick").empty();
        jQuery(".g").empty();

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
$result_maxing = $link->query("SELECT * FROM cer_model_settings LIMIT 1");
while($row_maxing=mysqli_fetch_array($result_maxing)) {?>
        y.domain([<?=$row_maxing[min]?>, <?=$row_maxing[max]?>]);
        <?
        }?>

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
            .attr("data-tooltip", function(d) { return d.vals;})
            .attr("data-tooltip-name", function(d) { return d.name;})
            .style("fill", function(d) { return color(d.name); });

        jQuery(".g").find('rect').mousemove(function(e) {
            var hovertext = $(this).attr("data-tooltip-name")+"<br>"+$(this).attr("data-tooltip");
            jQuery("#hovertitle").html(hovertext).show();
            jQuery("#hovertitle").css('top', jQuery(this).offset().top).css('left', e.clientX+12);
        }).mouseout(function() {
            jQuery("#hovertitle").hide();
        });
    }

    jQuery( document ).ready(function( $ ) {
        jQuery('#turk_select').prop('disabled', 'disabled');
        jQuery('#rus_select').prop('disabled', 'disabled');

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
        jQuery( "#knr_select" ).change(function() {
            if(jQuery( "#knr_select option:selected").text()=="Приоритет трубопроводного газа") {
                jQuery('#turk_select').prop('disabled', false);
                jQuery('#rus_select').prop('disabled', false);
            }
            else {
                jQuery('#turk_select').prop('disabled', 'disabled');
                jQuery('#rus_select').prop('disabled', 'disabled');
            }

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
        .range(["#4576b5", "#91b24f", "#755998", "#42a2bf", "#d0743c", "#ff8c00"]);

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
    $result = $link->query("SELECT * FROM cer_model_years_new_base ORDER BY year");
    $count=0;
    while($row=mysqli_fetch_array($result)) {?>


    data[<?=$count?>] = { "Year": "<?=$row[year]?>",
        "Добыча": "<?=$row[base_production]?>",
        "Импорт по действующим контрактам СПГ": "<?=$row[base_import_contracts_spg]?>",
        "Импорт трубопроводного газа": "<?=$row[base_import_tp]?>",
        "Дополнительный импорт СПГ": "<?=$row[base_import_spg]?>"};

    for (var prop in data[<?=$count?>]) {
        data[<?=$count?>][prop] = data[<?=$count?>][prop].replace(',', '.');
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
            d.ages = color.domain().map(function(name) { return {name: name, y0: y0, y1: y0 += +d[name], vals: (Math.round(d[name] * 100)/100)}; });
            d.total = d.ages[d.ages.length - 1].y1;
        });

        /*data.sort(function(a, b) { return b.total - a.total; });*/

        x.domain(data.map(function(d) { return d.Year; }));
        //y.domain([0, d3.max(data, function(d) { return d.total; })]); //АВТОМАТИЧЕСКИЙ ПОДГОН ПОД ВЫСОТУ
        <?php
    $result_maxing = $link->query("SELECT * FROM cer_model_settings LIMIT 1");
    while($row_maxing=mysqli_fetch_array($result_maxing)) {?>
            y.domain([<?=$row_maxing[min]?>, <?=$row_maxing[max]?>]);
        <?
        }?>
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
            .text("млрд. куб. м");

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
            jQuery("#hovertitle").html(hovertext).show();
            jQuery("#hovertitle").css('top', jQuery(this).offset().top).css('left', e.clientX+12);
        }).mouseout(function() {
            jQuery("#hovertitle").hide();
        });


    });

</script>