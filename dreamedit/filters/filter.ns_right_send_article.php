<?php
if($_SESSION[lang]!="/en") {
    ?>
    <img hspace=6 src=/files/Image/send_art.jpg /><a href=/jour/<?=$_SESSION[jour_url]?>/index.php?page_id=959>Форма для отправки статьи</a>
<?php
} else {
    ?>
    <img hspace=6 src=/files/Image/send_art.jpg /><a href=/en/jour/<?=$_SESSION[jour_url]?>/index.php?page_id=959>Submit an Article</a>
<?php
}