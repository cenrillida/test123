
<?

// Работа с корзинкой

global $DB, $_CONFIG, $site_templater;

if(isset($_POST[Submit]) || (!empty($_POST[username]) && !empty($_POST[passwd])) )
{
    if($_POST[username]!="meimo" || str_replace(" ","",$_POST[passwd])!="qf@F2faef") {
        if($_SESSION[lang]!='/en')
            echo "<p align='center'><strong>Ваш логин или пароль неверны. Попробуйте еще раз</strong></p>";
        else
            echo "<p align='center'><strong>Invalid login or password. Try again</strong></p>";
    }
    else
    {
        setcookie("userid_meimo_edit",1, 0);
        $_COOKIE[userid_meimo_edit]=1;
        $_REQUEST[userid_meimo_edit]=1;
        setcookie("userid_meimo_edit_secure","f2fsd!@sfsF3wd", 0);
        $_COOKIE[userid_meimo_edit_secure]="f2fsd!@sfsF3wd";
        $_REQUEST[userid_meimo_edit_secure]="f2fsd!@sfsF3wd";
    }
}



if($_COOKIE[userid_meimo_edit_secure]!='f2fsd!@sfsF3wd' || $_COOKIE[userid_meimo_edit]!=1)
{
$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

    if($_SESSION[lang]=="/en")
        $suff="_EN";
    else $suff="";

   ?>
    <script language="JavaScript">
        jQuery( document ).ready(function() {
            jQuery("input#mod_login_username").on({
                keydown: function (e) {
                    if (e.which === 32)
                        return false;
                },
                change: function () {
                    this.value = this.value.replace(/\s/g, "");
                }
            });
            jQuery("input#mod_login_password").on({
                keydown: function (e) {
                    if (e.which === 32)
                        return false;
                },
                change: function () {
                    this.value = this.value.replace(/\s/g, "");
                }
            });
        });
    </script>
    <form id="form-login" name="login" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
        <div class="clear">
            <input id="mod_login_username" class="inputbox" type="text" alt="Логин" name="username"/>
            <label for="mod_login_username"> 		<?	echo $suff=="_EN" ? "Login"  : "Логин"	; ?> </label>
        </div>
        <div class="clear">
            <input id="mod_login_password" class="inputbox" type="password" alt="Пароль" name="passwd"/>
            <label for="mod_login_password"> 		<?	echo $suff=="_EN" ? "Password"  : "Пароль"	; ?> </label>
        </div>
        <div class="clear">
            <div class="extra-indent-top1">
            </div>
        </div>

        <div class="clear extra-indent-link">
            <div >
                <!--	<span><input class="button_form" type="submit" value="Ввести" name="Submit"/></span>/-->
                <a class='button_form' name='submit' onclick="document.getElementById('form-login').submit()" href="#">
		<span>
			<span>		<?	echo $suff=="_EN" ? "Enter"  : "Войти"	; ?></span>
		</span>

                </a>

                <!--	<input class="button indent-button" type="submit" value="Ввести" name="Submit"/>/-->
            </div>
        </div>
    </form>
<?php

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");

} else {
    ?>

    <?php


    global $DB;
    $total = 0;
    $started = 0;
    $finished = 0;

//	$counters=$DB->select("SELECT COUNT(*) AS total, SUM(VT.vuz_id IS NOT NULL) AS started, SUM(VT.finished = 1) AS finished FROM `vuz` AS V LEFT OUTER JOIN vuz_total AS VT ON V.id = VT.vuz_id");
    $counters = $DB->select("SELECT count(*) AS total,SUM(date_rez <>'') AS count_rez,SUM(date_publ<>'') AS count_publ 
						 FROM article_send WHERE del='' AND journal=49");
    foreach ($counters as $counter) {
        $total = $counter["total"];
        $started = $counter["count_rez"];
        $finished = $counter["count_publ"];
    }
    ?>
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <script type="text/javascript" src="/js/dhtmlx6/codebase/suite.js?v=6"></script>
        <script src="/newsite/js/jquery-3.3.1.min.js"></script>
        <link rel="stylesheet" href="/js/dhtmlx6/codebase/suite.css">
        <style>
            html, body {
                width: 100%;
                height: 100%;
                margin: 0px;
                padding: 0px;
                background-color: #ebebeb;
                overflow: hidden;
            }

            #grid_container {
                height: 100%;
            }

            .del-button, .cell-button {
                text-align: center;
                margin-top: 5px;
            }

            .cell-button a {
                color: #8d8d8d;
                font-size: 14px;
            }

            .del-button a {
                color: red;
                font-size: 14px;
            }

            .dhx_grid-cell {
                font-size: 12px;
            }

            .dhx_grid-row .dhx_grid-cell:nth-child(2),
            .dhx_grid-row .dhx_grid-cell:nth-child(3),
            .dhx_grid-row .dhx_grid-cell:nth-child(4) {
                line-height: 20px !important;
            }

            .dhx_grid-row .dhx_grid-cell:nth-child(15),
            .dhx_grid-row .dhx_grid-cell:nth-child(16),
            .dhx_grid-row .dhx_grid-cell:nth-child(9),
            .dhx_grid-row .dhx_grid-cell:nth-child(10),
            .dhx_grid-row .dhx_grid-cell:nth-child(11),
            .dhx_grid-row .dhx_grid-cell:nth-child(12),
            .dhx_grid-row .dhx_grid-cell:nth-child(13),
            .dhx_grid-row .dhx_grid-cell:nth-child(14) {
                text-align: center !important;
            }

            .popup-content {
                display: none;
            }
        </style>
    </head>
    <body>
    <div id="grid_container"></div>
    <script>
        // creating dhtmlxGrid

        var grid = new dhx.Grid("grid_container", {
            header: [{text: "Удал."}],
            columns: [
                {
                    width: 40,
                    id: "del",
                    header: [{
                        text: "<?="<b>Журнал: Мировая экономика и международные отношения.</b> Статей <a href='#' onclick=doFilter('all')>всего</a>:  " . $total . ", на <a href='#' onclick=doFilter('rez')>рецензии: </a>" . $started . ", <a href='#' onclick=doFilter('publ')>опубликовано: </a>" . $finished . ".";?>",
                        colspan: 16
                    }, {text: "Удал."}],
                    type: "button",
                    icon: "dxi dxi-plus"
                },
                {
                    width: 400,
                    id: "name",
                    header: [{text: ""}, {text: "Название"}, {content: "inputFilter"}],
                    css: "cust"
                },
                {width: 160, id: "fio", header: [{text: ""}, {text: "ФИО"}, {content: "inputFilter"}]},
                {width: 200, id: "affl", header: [{text: ""}, {text: "Аффилиация"}, {content: "inputFilter"}]},
                {width: 150, id: "email", header: [{text: ""}, {text: "e-mail"}, {content: "inputFilter"}]},
                {width: 100, id: "telephone", header: [{text: ""}, {text: "Телефон"}, {content: "inputFilter"}]},
                {width: 40, id: "comment", header: [{text: ""}, {text: "Комм."}]},
                {width: 110, id: "rubric", header: [{text: ""}, {text: "Рубрика"}, {content: "selectFilter"}]},
                {width: 40, id: "file", header: [{text: ""}, {text: "<div style='text-align: center'><img src='/images/word.svg' style='width: 25px; margin-top: 12px;' /></div>"}]},
                {width: 80, id: "added", header: [{text: ""}, {text: "Поступила"}], type: "string"},
                {width: 500, id: "notes1", header: [{text: ""}, {text: "Примечания"}], editing: true}
            ],
            headerRowHeight: 50,
            fitToContainer: true,
            resizable: true,
            htmlEnable: true
        });
        grid.data.load("admin_table_source.json");

        var popup = new dhx.Popup({
            css: "dhx_widget--border-shadow",
            width: 400
        });

        function resizeFunc() {
            grid.config.width = 0;
            grid.config.height = 0;
            grid.paint();
        }

        grid.events.on("AfterEditEnd", function (value, row, column) {
            $.ajax({

                url: "update.html",
                //dataType: "json",
                method: "POST",
                data: {"value": value, "id": row.id, "column": column.id},
                success: function (data) {
                }
            });
        });

        function deleteLogin(id) {
            var answer = confirm("Вы действительно хотите удалить статью?");

            if (answer) {
                $.ajax({

                    url: "update.html",
                    //dataType: "json",
                    method: "POST",
                    data: {"delete": id},
                    success: function (data) {
                        grid.data.load("admin_table_source.json");
                    }
                });
            }

        }

        function doFilter(data) {
            if (data == "all") {
                grid.data.load("admin_table_source.json");
            }
            if (data == "rez") {
                grid.data.load("admin_table_source.json?rez=1");
            }
            if (data == "publ") {
                grid.data.load("admin_table_source.json?publ=1");
            }
        }

        window.onresize = resizeFunc;



        popup.attachHTML("<div style='padding: 16px; text-align: center'>Test</div>");

        function openComment(el) {
            event.preventDefault();
            //el.parent().find('.popup-content')[0].innerHTML
            popup.hide();
            popup.attachHTML("<div style='padding: 16px; width: 400px;'>" + el.parent().find('.popup-content')[0].innerHTML + "</div>");
            popup.show(el[0]);
        }

        $(window).scroll(function () {
            popup.hide();
        });

        grid.events.on("Scroll", function({top,left}){
            popup.hide();
        });

    </script>
    </body>
    </html>
    <?php
}