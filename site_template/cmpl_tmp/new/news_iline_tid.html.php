<?php
global $DB,$_CONFIG, $site_templater;

$ilines = new Ilines();
$ievent = new Events();

if (empty($_TPL_REPLACMENT["COUNT"])) $_TPL_REPLACMENT["COUNT"]=20;

$rows = $ilines->getNewsByTids(array($_TPL_REPLACMENT['NEWS_LINE']),0,$_TPL_REPLACMENT["COUNT"]);

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

$langPostFix = "";
if($_SESSION['lang']=="/en") {
    $langPostFix = "_en";
}

foreach ($rows as $k => $v) {
    $dt = DateTime::createFromFormat("Y.m.d H:i",$v['date']);
    ?>
    <span class="date"><b><?=$dt->format("d.m.Y")?><?php if($_SESSION['lang']!="/en") echo ' ã.';?></b><br></span>
    <?php echo $v['full_text'.$langPostFix];?>
    <div class="mb-5"></div>
<?php
}

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");