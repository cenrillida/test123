<?

if($_SESSION["on_site_edit"]==1 && isset($_SESSION["admin"]) && !empty($_TPL_REPLACMENT['HEADER_ID_EDIT'])) {
    ?>
    <div class="position-relative">
    <div class="position-absolute" style="top: 5px; left: 5px; z-index: 2">
        <a target="_blank" href="/dreamedit/index.php?mod=headers&action=edit&type=l&id=<?=$_TPL_REPLACMENT['HEADER_ID_EDIT']?>"><i class="fas fa-edit text-danger bg-white p-1"></i></a>
    </div>


    <?php
}


if ($_SESSION[lang]!='/en') $suff='';else $suff='_EN';
echo $_TPL_REPLACMENT["TEXT".$suff];

if($_SESSION["on_site_edit"]==1 && isset($_SESSION["admin"]) && !empty($_TPL_REPLACMENT['HEADER_ID_EDIT'])) {
    ?>
    </div>
    <?php
}