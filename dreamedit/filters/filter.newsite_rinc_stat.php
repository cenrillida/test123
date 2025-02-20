<?php
global $DB;

?>
<div class="row">
    <div class="col-lg-6 col-xs-12 pb-3">
        <div class="row mb-3">
            <div class="col-12">
                <h2 class="pl-2 pr-2 border-bottom text-center text-uppercase"><?php if($_SESSION[lang]!="/en") echo "ИМЭМО в ринц"; else echo "IMEMO in RSCI";?></h2>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <div class="w-100 text-center p-3"><img src="/newsite/img/elibrary_logo.gif" alt=""/></div>
                <?php
                if($_SESSION[lang]!="/en") {
                    echo $_TPL_REPLACMENT["TEXT"];
                } else {
                    echo $_TPL_REPLACMENT["TEXT_EN"];
                }
                ?>
                <?php if(false):?>
                <table class="table table-hover table-bordered">
                    <tbody>
                    <tr>
                        <th scope="row"><?php if($_SESSION[lang]!="/en") echo "Число публикаций в РИНЦ"; else echo "Total number of organization publications in RINC";?></th>
                        <td>9032</td>
                    </tr>
                    <tr>
                        <th scope="row"><?php if($_SESSION[lang]!="/en") echo "Число цитирований публикаций в РИНЦ"; else echo "The total number of citations of organization publications";?></th>
                        <td>71316</td>
                    </tr>
                    <tr>
                        <th scope="row"><?php if($_SESSION[lang]!="/en") echo "Индекс Хирша по публикациям в РИНЦ"; else echo "h-index (Hirsch index)";?></th>
                        <td>105</td>
                    </tr>
                    </tbody>
                </table>
                <?php endif;?>
                <div class="text-center"><a href="http://elibrary.ru/org_profile.asp?id=5574" target="_blank"><?php if($_SESSION[lang]!="/en") echo "Подробнее см. на сайте"; else echo "More on";?> http://elibrary.ru</a></div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-xs-12 pb-3">
        <div class="row mb-3">
            <div class="col-12">
                <h2 class="pl-2 pr-2 border-bottom text-center text-uppercase"><?php if($_SESSION[lang]!="/en") echo "Статистика"; else echo "Statistics";?></h2>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <div class="text-center"><?php Statistic::theStatMain(true);?></div>
                <div class="text-center position-relative">
                    <iframe style="border: 0; background:transparent !important" width="142" height="142" src="/index.php?page_id=1985"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
