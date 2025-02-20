
<?

// Работа с корзинкой

global $DB, $_CONFIG, $site_templater;

if(isset($_POST[Submit]) || (!empty($_POST[username]) && !empty($_POST[passwd])) )
{
    if($_POST[username]!="cer" || str_replace(" ","",$_POST[passwd])!="njG#42UBF%2") {
        if($_SESSION[lang]!='/en')
            echo "<p align='center'><strong>Ваш логин или пароль неверны. Попробуйте еще раз</strong></p>";
        else
            echo "<p align='center'><strong>Invalid login or password. Try again</strong></p>";
    }
    else
    {
        setcookie("userid_cei_edit",1, 0);
        $_COOKIE[userid_cei_edit]=1;
        $_REQUEST[userid_cei_edit]=1;
        setcookie("userid_cei_edit_secure","fjehF#frhf4*@H", 0);
        $_COOKIE[userid_cei_edit_secure]="fjehF#frhf4*@H";
        $_REQUEST[userid_cei_edit_secure]="fjehF#frhf4*@H";
    }
}



if($_COOKIE[userid_cei_edit_secure]!='fjehF#frhf4*@H' || $_COOKIE[userid_cei_edit]!=1)
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
    <form style="max-width: 500px;" class="text-center m-auto" id="form-login" name="login" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
        <div class="form-group">
            <label for="mod_login_username"> 		<?	echo $suff=="_EN" ? "Login"  : "Логин"	; ?> </label>
            <input id="mod_login_username" class="inputbox form-control" type="text" alt="Логин" name="username"/>
        </div>
        <div class="form-group">
            <label for="mod_login_password"> 		<?	echo $suff=="_EN" ? "Password"  : "Пароль"	; ?> </label>
            <input id="mod_login_password" class="inputbox form-control" type="password" alt="Пароль" name="passwd"/>
        </div>
        <a class='button_form imemo-button btn btn-lg imemo-button text-uppercase' name='submit' onclick="document.getElementById('form-login').submit()" href="#">
		<span>
			<span>		<?	echo $suff=="_EN" ? "Enter"  : "Войти"	; ?></span>
		</span>
        </a>
    </form>
    <?php

    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");

} else {
    global $DB;
    if(empty($_GET['operation'])) {
        Dreamedit::sendHeaderByCode(301);
        Dreamedit::sendLocationHeader("https://".$_SERVER["SERVER_NAME"]."/index.php?page_id=".$_REQUEST["page_id"]."&operation=showAll");
    }
    $manager = new CerSpecrubManager();

    if(($_GET['operation']=="add" || $_GET['operation']=="edit") && isset($_POST['cer_title'])) {
        include($_SERVER['DOCUMENT_ROOT'] . "/classes/upload/upload_class.php"); //classes is the map where the class file is stored (one above the root)
        $max_size = 10240 * 1024; // the max. size for uploading
        $img_upload = new file_upload;

        $img_upload->upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/files/Image/cerspecrub/"; // "files" is the folder for the uploaded files (you have to create this folder)
        $img_upload->extensions = array(".jpg", ".png"); // specify the allowed extensions here
        $img_upload->language = "ru"; // use this to switch the messages into an other language (translate first!!!)
        $img_upload->max_length_filename = 50; // change this value to fit your field length in your database (standard 100)
        $img_upload->rename_file = true;

        $img_upload->the_temp_file = $_FILES['cer_img']['tmp_name'];
        $img_upload->the_file = $_FILES['cer_img']['name'];
        $img_upload->http_error = $_FILES['cer_img']['error'];
        $img_upload->replace = "y";
        $img_upload->do_filename_check = "n"; // use this boolean to check for a valid filename
        $temp = "Загрузка ";
        if ($img_upload->upload())
            $img = $img_upload->file_copy;
        if(empty($img)) {
            $img = '';
        }
        $img_upload->the_temp_file = $_FILES['cer_img_en']['tmp_name'];
        $img_upload->the_file = $_FILES['cer_img_en']['name'];
        $img_upload->http_error = $_FILES['cer_img_en']['error'];
        if ($img_upload->upload())
            $img_en = $img_upload->file_copy;
        if(empty($img_en)) {
            $img_en = '';
        }

        $id = -1;
        if($_GET['operation']=="edit") {
            $id = (int)$_POST['cer_id'];
            if(empty($id)) {
                $id = -1;
            }
        }

        if($_POST['cer_status']=="on") {
            $status = 1;
        } else {
            $status = 0;
        }
        if($_POST['cer_status_en']=="on") {
            $status_en = 1;
        } else {
            $status_en = 0;
        }

        $newElement = new CerSpecrub(
            $id,
            $_POST['cer_title'],
            $_POST['cer_title_en'],
            str_replace("\n","<br>",str_replace("\r\n","<br>",$_POST['cer_fulltext'])),
            str_replace("\n","<br>",str_replace("\r\n","<br>",$_POST['cer_fulltext_en'])),
            str_replace("T"," ", $_POST['cer_date']),
            $_POST['cer_iframe'],
            $_POST['cer_iframe_en'],
            $img,
            $img_en,
            $status,
            $status_en);

        $result = $manager->updateDBWithElement($newElement);
        if($result=="OK") {
            Dreamedit::sendHeaderByCode(301);
            Dreamedit::sendLocationHeader("https://".$_SERVER["SERVER_NAME"]."/index.php?page_id=".$_REQUEST["page_id"]."&operation=showAll&result=ok");
        } else {
            $error = $result;
        }

    }

    if($_GET['operation']=="del") {
        $result = $manager->deleteFromDBByID((int)$_GET['id']);
        if($result=="OK") {
            Dreamedit::sendHeaderByCode(301);
            Dreamedit::sendLocationHeader("https://".$_SERVER["SERVER_NAME"]."/index.php?page_id=".$_REQUEST["page_id"]."&operation=showAll&result=ok");
        } else {
            $error = $result;
        }
    }


    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

    if(!empty($error)) {
        ?>
        <div class="cer-info-message" style="background-color: red">
            <?=$error?>
        </div>
        <?php
    }

    if($_GET['operation']=="showAll") {
        $elements = $manager->getAllElements();
        if($_GET['result']=="ok") {
            ?>
            <div class="cer-info-message" style="background-color: green">
                Успешно сохранено
            </div>
            <?php
        }
        ?>
        <a class="btn btn-lg imemo-button text-uppercase imemo-addcer-button my-3" id="addCerElement"
           href="/index.php?page_id=<?= $_REQUEST["page_id"] ?>&operation=add" role="button">Добавить новый элемент</a>
        <table class="table table-responsive">
            <thead class="thead-dark">
            <tr>
                <th class="text-center" scope="col" style="width: 50px;">ID</th>
                <th scope="col" style="width: 50%;">Название</th>
                <th scope="col" style="width: 250px;">Дата</th>
                <th scope="col" style="width: 50px;">Статус</th>
                <th scope="col" style="width: 50px;">Статус(En)</th>
                <th scope="col" style="width: 50px;">Статистика</th>
                <th scope="col" style="width: 50px;">Изменить</th>
                <th class="text-center" scope="col" style="width: 50px;">Удалить</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($elements as $element):?>
            <tr>
                <th class="text-center" scope="row"><?=$element->getId()?></th>
                <td><?=$element->getTitle()?></td>
                <td><?=$element->getDate()?></td>
                <td class="text-center<?php if($element->getStatus()) echo " text-success"; else echo " text-secondary";?>"><i class="fas fa-eye<?php if(!$element->getStatus()) echo "-slash";?>"></i></td>
                <td class="text-center<?php if($element->getStatusEn()) echo " text-success"; else echo " text-secondary";?>"><i class="fas fa-eye<?php if(!$element->getStatusEn()) echo "-slash";?>"></i></td>
                <td class="text-center"><a href="/index.php?page_id=<?= $_REQUEST["page_id"] ?>&operation=stat&id=<?=$element->getId()?>"><i class="fas fa-chart-area"></i></a></td>
                <td class="text-center"><a href="/index.php?page_id=<?= $_REQUEST["page_id"] ?>&operation=edit&id=<?=$element->getId()?>"><i
                            class="fas fa-edit"></i></a></td>
                <td class="text-center"><a class="text-danger"
                                           href="/index.php?page_id=<?= $_REQUEST["page_id"] ?>&operation=del&id=<?=$element->getId()?>"><i
                            class="fas fa-times"></i></a></td>
            </tr>
            <?php endforeach;?>
            </tbody>
        </table>
        <?php
    }
    if($_GET['operation']=="stat") {
        ?>
        <a class="btn btn-lg imemo-button text-uppercase imemo-addcer-button my-3" id="showAllCerElements"
           href="/index.php?page_id=<?= $_REQUEST["page_id"] ?>&operation=showAll" role="button">Вернуться к списку</a>
        <?php
        $manager->echoStat($manager->getElementByID((int)$_GET['id']));
        //$manager->echoForm($manager->getElementByID((int)$_GET['id']));
    }
    if($_GET['operation']=="edit") {
        ?>
        <a class="btn btn-lg imemo-button text-uppercase imemo-addcer-button my-3" id="showAllCerElements"
           href="/index.php?page_id=<?= $_REQUEST["page_id"] ?>&operation=showAll" role="button">Вернуться к списку</a>
        <?php
        $manager->echoForm($manager->getElementByID((int)$_GET['id']));
    }
    if($_GET['operation']=="add") {
        ?>
        <a class="btn btn-lg imemo-button text-uppercase imemo-addcer-button my-3" id="showAllCerElements"
           href="/index.php?page_id=<?= $_REQUEST["page_id"] ?>&operation=showAll" role="button">Вернуться к списку</a>

        <?php
        $manager->echoForm();
    }
    $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
}