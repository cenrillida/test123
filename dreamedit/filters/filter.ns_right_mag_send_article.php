<?php
if($_SESSION[lang]!="/en") {
    ?>
    <i class="fab fa-wpforms"></i> <a href=/index.php?page_id=<?=$_TPL_REPLACMENT["SEND_ARTICLE_ID"]?>>����� ��� �������� ������</a>
    <?php
} else {
    ?>
    <i class="fab fa-wpforms"></i> <a href=/en/index.php?page_id=<?=$_TPL_REPLACMENT["SEND_ARTICLE_ID"]?>>Submit an Article</a>
    <?php
}