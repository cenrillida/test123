<?php

session_start();

if(!$_SESSION[authorize]) {
    header('Location: https://imemo.ru/energyeconomics/admin/index.php');
    exit;
}

$link = mysqli_connect("localhost","imemon", "phai5reRe3","imemon") or die("Error " . mysqli_error($link));
mysqli_set_charset($link, "utf8");

if(isset($_POST[show_comment])) {
    $result = $link->query("SELECT show1 FROM cer_comments WHERE id=".(int)$_POST[show_comment]);

    while($row=mysqli_fetch_array($result)) {
        if($row[show1])
            $link->query("UPDATE cer_comments SET show1=0 WHERE id=".(int)$_POST[show_comment]);
        else
            $link->query("UPDATE cer_comments SET show1=1 WHERE id=".(int)$_POST[show_comment]);
    }
}
if(isset($_POST[delete_comment])) {
    $link->query("DELETE FROM cer_comments WHERE id=".(int)$_POST[delete_comment]);
}

if(isset($_POST[base_demand])) {
    if($_POST[only_project]=="on")
        $only_project=1;
    else
        $only_project=0;
    if($_POST[year_stack]=="on")
        $year_stack=1;
    else
        $year_stack=0;
    $link->query("UPDATE cer_model_years SET base_demand='" . $_POST[base_demand]."',
    base_production='".$_POST[base_production]."',
    base_import='".$_POST[base_import]."',
    pess_demand='".$_POST[pess_demand]."',
    pess_production='".$_POST[pess_production]."',
    pess_import='".$_POST[pess_import]."',
    opt_demand='".$_POST[opt_demand]."',
    opt_production='".$_POST[opt_production]."',
    opt_import='".$_POST[opt_import]."',
    turk1='".$_POST[turk1]."',
    turk2='".$_POST[turk2]."',
    turk3='".$_POST[turk3]."',
    turk4='".$_POST[turk4]."',
    mianma='".$_POST[mianma]."',
    rus_sib='".$_POST[rus_sib]."',
    rus_alt='".$_POST[rus_alt]."',
    contracts_spg='".$_POST[contracts_spg]."',
    regas_project='".$_POST[regas_project]."',
    only_project=".$only_project.",
    year_stack=".$year_stack."
     WHERE year=".$_GET[year]);
}
if(isset($_POST[delete_year])) {
    $link->query("DELETE FROM cer_model_years WHERE year=".$_POST[delete_year]);
}
if(isset($_POST[insert_year])) {
    $link->query("INSERT INTO cer_model_years SET year=".(int)$_POST[insert_year]);
}
if(isset($_POST[insert_test])) {
    $link->query("INSERT INTO cer_surveys SET name='".$_POST[insert_test]."'");
}
if(isset($_POST[edit_test])) {
    $link->query("UPDATE cer_surveys SET name='".$_POST[edit_test]."' WHERE id=".(int)$_POST[edit_test_id]);
}
if(isset($_POST[edit_question])) {
    $link->query("UPDATE cer_surveys_questions SET name='".$_POST[edit_question]."' WHERE id=".(int)$_POST[edit_question_id]);
}
if(isset($_POST[edit_test_comments])) {
    $link->query("UPDATE cer_surveys_comments SET text='".$_POST[edit_test_comments]."' WHERE id=".(int)$_POST[edit_test_comments_id]);
}
if(isset($_POST[edit_test_comments_from])) {
    $link->query("UPDATE cer_surveys_comments SET `from`=".(int)$_POST[edit_test_comments_from]." WHERE id=".(int)$_POST[edit_test_comments_from_id]);
}
if(isset($_POST[edit_test_comments_to])) {
    $link->query("UPDATE cer_surveys_comments SET `to`=".(int)$_POST[edit_test_comments_to]." WHERE id=".(int)$_POST[edit_test_comments_to_id]);
}
if(isset($_POST[edit_answer])) {
    $link->query("UPDATE cer_surveys_answers SET name='".$_POST[edit_answer]."' WHERE id=".(int)$_POST[edit_answer_id]);
}
if(isset($_POST[edit_answer_result])) {
    $link->query("UPDATE cer_surveys_answers SET result='".$_POST[edit_answer_result]."' WHERE id=".(int)$_POST[edit_answer_result_id]);
}
if(isset($_POST[change_survey_type])) {
    $link->query("UPDATE cer_surveys SET type=".(int)$_POST[change_survey_type]." WHERE id=".(int)$_POST[change_survey_type_id]);
}
if(isset($_POST[model_settings_min])) {
    $link->query("UPDATE cer_model_settings SET `min`=".$_POST[model_settings_min].", `max`=".$_POST[model_settings_max]);
}
if(isset($_POST[model2_settings_min])) {
    $link->query("UPDATE cer_model2_settings SET `min`=".$_POST[model2_settings_min].", `max`=".$_POST[model2_settings_max]);
}
if(isset($_POST[model3_settings_min])) {
    $link->query("UPDATE cer_model3_settings SET `min`=".$_POST[model3_settings_min].", `max`=".$_POST[model3_settings_max]);
}
if(isset($_POST[model4_settings_min])) {
    $link->query("UPDATE cer_model4_settings SET `min`=".$_POST[model4_settings_min].", `max`=".$_POST[model4_settings_max]);
}
if(isset($_POST[delete_survey])) {
    $link->query("DELETE FROM cer_surveys WHERE id=".$_POST[delete_survey]);
    $result = $link->query("SELECT FROM cer_surveys_questions WHERE test_id=".$_POST[delete_survey]);
    while($row=mysqli_fetch_array($result)) {
        $link->query("DELETE FROM cer_surveys_answers WHERE question_id=".$row[id]);
    }
    $link->query("DELETE FROM cer_surveys_questions WHERE test_id=".$_POST[delete_survey]);
    $link->query("DELETE FROM cer_surveys_comments WHERE test_id=".$_POST[delete_survey]);
}
if(isset($_POST[insert_test_comments])) {
    $link->query("INSERT INTO cer_surveys_comments SET text='".$_POST[insert_test_comments]."', `from`=".(int)$_POST[insert_test_comments_from].", `to`=".(int)$_POST[insert_test_comments_to].", test_id=".$_POST[test_comments_id]);
}
if(isset($_POST[delete_test_comments])) {
    $link->query("DELETE FROM cer_surveys_comments WHERE id=".$_POST[delete_test_comments]);
}
if(isset($_POST[insert_test_question])) {
    $link->query("INSERT INTO cer_surveys_questions SET name='".$_POST[insert_test_question]."', test_id=".$_POST[test_id]);
}
if(isset($_POST[delete_question])) {
    $link->query("DELETE FROM cer_surveys_answers WHERE question_id=".$_POST[delete_question]);
    $link->query("DELETE FROM cer_surveys_questions WHERE id=".$_POST[delete_question]);
}
if(isset($_POST[insert_answer])) {
    $link->query("INSERT INTO cer_surveys_answers SET name='".$_POST[insert_answer]."', result='".$_POST[insert_answer_result]."', question_id=".$_POST[question_id]);
}
if(isset($_POST[delete_answer])) {
    $link->query("DELETE FROM cer_surveys_answers WHERE id=".$_POST[delete_answer]);
}
if(isset($_POST[set_answer_correct])) {
    $link->query("UPDATE cer_surveys_answers SET answer_correct=".(int)$_POST[set_answer_correct_type]." WHERE id=".(int)$_POST[set_answer_correct]);
}
if(isset($_FILES[info_window])) {
    $final_arr = array();
    $row=0;
    if (($handle = fopen($_FILES[info_window][tmp_name], "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            foreach($data as $key=>$value)
                $data[$key] = mb_convert_encoding($value,"UTF-8","cp1251");
            $final_arr[$row]=$data;
            $row++;
        }
        fclose($handle);
    }
    $result = $link->query("SELECT * FROM cer_infowindow");
    if($result->num_rows==0) {
        $stmt = $link->stmt_init();
        if ($stmt->prepare("INSERT INTO cer_infowindow SET `table`=?")) {
            /* привязываем переменные к параметрам */
            $stmt->bind_param("s", serialize($final_arr));

            /* выполняем запрос */
            $stmt->execute();

            $stmt->close();
        }
    }
    else {
        $stmt = $link->stmt_init();
        if ($stmt->prepare("UPDATE cer_infowindow SET `table`=?")) {
            /* привязываем переменные к параметрам */
            $stmt->bind_param("s", serialize($final_arr));

            /* выполняем запрос */
            $stmt->execute();

            $stmt->close();
        }
    }
}
if(isset($_FILES[oil_request])) {
    move_uploaded_file($_FILES[oil_request][tmp_name], "/home/imemon/html/energyeconomics/tables/oil_request.csv");
}
if(isset($_FILES[ctl_request])) {
    move_uploaded_file($_FILES[ctl_request][tmp_name], "/home/imemon/html/energyeconomics/tables/ctl_request.csv");
}
if(isset($_FILES[bio_oil])) {
    move_uploaded_file($_FILES[bio_oil][tmp_name], "/home/imemon/html/energyeconomics/tables/bio_oil.csv");
}
if(isset($_FILES[china_data])) {
    move_uploaded_file($_FILES[china_data][tmp_name], "/home/imemon/html/energyeconomics/tables/china_data.csv");
}
if(isset($_FILES[saudi_data])) {
    move_uploaded_file($_FILES[saudi_data][tmp_name], "/home/imemon/html/energyeconomics/tables/saudi_data.csv");
}
if(isset($_FILES[base])) {
    $row = 1;
    if (($handle = fopen($_FILES[base][tmp_name], "r")) !== FALSE) {
        $link->query("TRUNCATE cer_model_years_new_base");
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            //$num = count($data);
            if($row>1)
            {
                $result = $link->query("SELECT year FROM cer_model_years_new_base WHERE year=".$data[0]);
                if($result->num_rows==0)
                    $link->query("INSERT INTO cer_model_years_new_base SET year=".$data[0]);
                $link->query("UPDATE cer_model_years_new_base SET base_demand='".$data[1]."', base_production='".$data[2]."', base_50x50='".$data[4]."', base_import_tp='".$data[5]."', base_import_spg='".$data[6]."', base_import_contracts_spg='".$data[7]."', base_priority_tp='".$data[8]."', base_import_tp2='".$data[9]."', base_import_spg2='".$data[10]."', base_import_contracts_spg2='".$data[11]."', base_priority_spg='".$data[12]."', base_import_tp3='".$data[13]."', base_import_spg3='".$data[14]."', base_import_contracts_spg3='".$data[15]."', base_priority_tp2='".$data[16]."', base_import_tp4='".$data[17]."', base_import_spg4='".$data[18]."', base_import_contracts_spg4='".$data[19]."', base_priority_tp3='".$data[20]."', base_import_tp5='".$data[21]."', base_import_spg5='".$data[22]."', base_import_contracts_spg5='".$data[23]."', base_priority_tp4='".$data[24]."', base_import_tp6='".$data[25]."', base_import_spg6='".$data[26]."', base_import_contracts_spg6='".$data[27]."' WHERE year=".$data[0]);
            }
            $row++;
        }
        fclose($handle);
    }
}
if(isset($_FILES[base222])) {
    $row = 1;
    if (($handle = fopen($_FILES[base222][tmp_name], "r")) !== FALSE) {
        var_dump(1);
        $link->query("TRUNCATE cer_model_years_new_base222");
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            //$num = count($data);
            if($row>1)
            {
                $result = $link->query("SELECT year FROM cer_model_years_new_base222 WHERE year=".$data[0]);
                if($result->num_rows==0)
                    $link->query("INSERT INTO cer_model_years_new_base222 SET year=".$data[0]);
                $link->query("UPDATE cer_model_years_new_base222 SET base_demand='".$data[1]."', base_production='".$data[2]."', base_50x50='".$data[4]."', base_import_tp='".$data[5]."', base_import_spg='".$data[6]."', base_import_contracts_spg='".$data[7]."', base_priority_tp='".$data[8]."', base_import_tp2='".$data[9]."', base_import_spg2='".$data[10]."', base_import_contracts_spg2='".$data[11]."', base_priority_spg='".$data[12]."', base_import_tp3='".$data[13]."', base_import_spg3='".$data[14]."', base_import_contracts_spg3='".$data[15]."', base_priority_tp2='".$data[16]."', base_import_tp4='".$data[17]."', base_import_spg4='".$data[18]."', base_import_contracts_spg4='".$data[19]."', base_priority_tp3='".$data[20]."', base_import_tp5='".$data[21]."', base_import_spg5='".$data[22]."', base_import_contracts_spg5='".$data[23]."', base_priority_tp4='".$data[24]."', base_import_tp6='".$data[25]."', base_import_spg6='".$data[26]."', base_import_contracts_spg6='".$data[27]."' WHERE year=".$data[0]);
            }
            $row++;
        }
        fclose($handle);
    }
}
if(isset($_FILES[pess])) {
    $row = 1;
    if (($handle = fopen($_FILES[pess][tmp_name], "r")) !== FALSE) {
        $link->query("TRUNCATE cer_model_years_new_pess");
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            //$num = count($data);
            if($row>1)
            {
                $result = $link->query("SELECT year FROM cer_model_years_new_pess WHERE year=".$data[0]);
                if($result->num_rows==0)
                    $link->query("INSERT INTO cer_model_years_new_pess SET year=".$data[0]);
                $link->query("UPDATE cer_model_years_new_pess SET base_demand='".$data[1]."', base_production='".$data[2]."', base_50x50='".$data[4]."', base_import_tp='".$data[5]."', base_import_spg='".$data[6]."', base_import_contracts_spg='".$data[7]."', base_priority_tp='".$data[8]."', base_import_tp2='".$data[9]."', base_import_spg2='".$data[10]."', base_import_contracts_spg2='".$data[11]."', base_priority_spg='".$data[12]."', base_import_tp3='".$data[13]."', base_import_spg3='".$data[14]."', base_import_contracts_spg3='".$data[15]."', base_priority_tp2='".$data[16]."', base_import_tp4='".$data[17]."', base_import_spg4='".$data[18]."', base_import_contracts_spg4='".$data[19]."', base_priority_tp3='".$data[20]."', base_import_tp5='".$data[21]."', base_import_spg5='".$data[22]."', base_import_contracts_spg5='".$data[23]."', base_priority_tp4='".$data[24]."', base_import_tp6='".$data[25]."', base_import_spg6='".$data[26]."', base_import_contracts_spg6='".$data[27]."' WHERE year=".$data[0]);
            }
            $row++;
        }
        fclose($handle);
    }
}
if(isset($_FILES[opt])) {
    $row = 1;
    if (($handle = fopen($_FILES[opt][tmp_name], "r")) !== FALSE) {
        $link->query("TRUNCATE cer_model_years_new_opt");
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            //$num = count($data);
            if($row>1)
            {
                $result = $link->query("SELECT year FROM cer_model_years_new_opt WHERE year=".$data[0]);
                if($result->num_rows==0)
                    $link->query("INSERT INTO cer_model_years_new_opt SET year=".$data[0]);
                $link->query("UPDATE cer_model_years_new_opt SET base_demand='".$data[1]."', base_production='".$data[2]."', base_50x50='".$data[4]."', base_import_tp='".$data[5]."', base_import_spg='".$data[6]."', base_import_contracts_spg='".$data[7]."', base_priority_tp='".$data[8]."', base_import_tp2='".$data[9]."', base_import_spg2='".$data[10]."', base_import_contracts_spg2='".$data[11]."', base_priority_spg='".$data[12]."', base_import_tp3='".$data[13]."', base_import_spg3='".$data[14]."', base_import_contracts_spg3='".$data[15]."', base_priority_tp2='".$data[16]."', base_import_tp4='".$data[17]."', base_import_spg4='".$data[18]."', base_import_contracts_spg4='".$data[19]."', base_priority_tp3='".$data[20]."', base_import_tp5='".$data[21]."', base_import_spg5='".$data[22]."', base_import_contracts_spg5='".$data[23]."', base_priority_tp4='".$data[24]."', base_import_tp6='".$data[25]."', base_import_spg6='".$data[26]."', base_import_contracts_spg6='".$data[27]."' WHERE year=".$data[0]);
            }
            $row++;
        }
        fclose($handle);
    }
}
if(isset($_FILES[trub])) {
    $row = 1;
    if (($handle = fopen($_FILES[trub][tmp_name], "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            //$num = count($data);
            if($row>1)
            {
                $result = $link->query("SELECT year FROM cer_model_years WHERE year=".$data[0]);
                if($result->num_rows==0)
                    $link->query("INSERT INTO cer_model_years SET year=".$data[0]);
                $link->query("UPDATE cer_model_years SET turk1='".$data[1]."', turk2='".$data[2]."', turk3='".$data[3]."', turk4='".$data[4]."', mianma='".$data[5]."', rus_sib='".$data[6]."', rus_alt='".$data[7]."' WHERE year=".$data[0]);
            }
            $row++;
        }
        fclose($handle);
    }
}
if(isset($_FILES[spg])) {
    $row = 1;
    if (($handle = fopen($_FILES[spg][tmp_name], "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            //$num = count($data);
            if($row>1)
            {
                $result = $link->query("SELECT year FROM cer_model_years WHERE year=".$data[0]);
                if($result->num_rows==0)
                    $link->query("INSERT INTO cer_model_years SET year=".$data[0]);
                $link->query("UPDATE cer_model_years SET contracts_spg='".$data[1]."', regas_project='".$data[2]."' WHERE year=".$data[0]);
            }
            $row++;
        }
        fclose($handle);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Панель администратора ЦЭИ</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Центр энергетических исследований - Панель Администратора</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="index.php?logout=1">Выйти</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li<?php if($_GET[page]=="infowindow") echo " class=\"active\"";?>><a href="admin.php?page=infowindow">Инф. окно<?php if($_GET[page]=="infowindow"):?><span class="sr-only">(current)</span><? endif;?></a></li>
                <li<?php if($_GET[page]=="survey") echo " class=\"active\"";?>><a href="admin.php?page=survey">Тесты<?php if($_GET[page]=="survey"):?><span class="sr-only">(current)</span><? endif;?></a></li>
                <li<?php if($_GET[page]=="comments") echo " class=\"active\"";?>><a href="admin.php?page=comments">Комментарии<?php if($_GET[page]=="comments"):?><span class="sr-only">(current)</span><? endif;?></a></li>
                <li<?php if(empty($_GET[year]) && $_GET[page]!="comments" && $_GET[page]!="survey" && $_GET[page]!="infowindow" && empty($_GET[model])) echo " class=\"active\"";?>><a href="admin.php">Китай: модель импорта природного газа (июнь 2016 г.)<?php if(empty($_GET[year]) && $_GET[page]!="comments" && $_GET[page]!="survey" && $_GET[page]!="infowindow" && empty($_GET[model])):?><span class="sr-only">(current)</span><? endif;?></a></li>
                <li<?php if(empty($_GET[year]) && $_GET[page]!="comments" && $_GET[page]!="survey" && $_GET[page]!="infowindow" && $_GET[model]=="oilhigh") echo " class=\"active\"";?>><a href="admin.php?model=oilhigh">Пик спроса на нефть (июль 2016 г.)<?php if(empty($_GET[year]) && $_GET[page]!="comments" && $_GET[page]!="survey" && $_GET[page]!="infowindow" && $_GET[model]=="oilhigh"):?><span class="sr-only">(current)</span><? endif;?></a></li>
                <li<?php if(empty($_GET[year]) && $_GET[page]!="comments" && $_GET[page]!="survey" && $_GET[page]!="infowindow" && $_GET[model]=="chinaslow") echo " class=\"active\"";?>><a href="admin.php?model=chinaslow">Замедление темпов роста Китая<?php if(empty($_GET[year]) && $_GET[page]!="comments" && $_GET[page]!="survey" && $_GET[page]!="infowindow" && $_GET[model]=="chinaslow"):?><span class="sr-only">(current)</span><? endif;?></a></li>
                <li<?php if(empty($_GET[year]) && $_GET[page]!="comments" && $_GET[page]!="survey" && $_GET[page]!="infowindow" && $_GET[model]=="saudi") echo " class=\"active\"";?>><a href="admin.php?model=saudi">Модель по Саудовской Аравии<?php if(empty($_GET[year]) && $_GET[page]!="comments" && $_GET[page]!="survey" && $_GET[page]!="infowindow" && $_GET[model]=="saudi"):?><span class="sr-only">(current)</span><? endif;?></a></li>
            </ul>
            <!--<ul class="nav nav-sidebar">
                <?php $result = $link->query("SELECT year FROM cer_model_years GROUP BY year ORDER BY year");
                while($row=mysqli_fetch_array($result)) {?>
                    <li<?php if($_GET[year]==$row[year]) echo " class=\"active\"";?>><a href="admin.php?year=<?=$row[year]?>"><?=$row[year]?><?php if($_GET[year]==$row[year]):?><span class="sr-only">(current)</span><? endif;?></a></li>
                <?php }?>
            </ul>-->
            <!--<ul class="nav nav-sidebar">
                <li><a href="">Nav item</a></li>
                <li><a href="">Nav item again</a></li>
                <li><a href="">One more nav</a></li>
                <li><a href="">Another nav item</a></li>
                <li><a href="">More navigation</a></li>
            </ul>
            <ul class="nav nav-sidebar">
                <li><a href="">Nav item again</a></li>
                <li><a href="">One more nav</a></li>
                <li><a href="">Another nav item</a></li>
            </ul>-->
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header"><?php if(empty($_GET[year]) && $_GET[page]!="comments" && $_GET[page]!="survey" && $_GET[page]!="infowindow") echo "Модель"; else echo $_GET[year]; if($_GET[page]=="comments") echo "Комментарии"; if($_GET[page]=="survey") echo "Тесты"; if($_GET[page]=="infowindow") echo "Информационное окно";?></h1>

            <?php if(!empty($_GET[year]) && false): //Годы отключены
                $result = $link->query("SELECT * FROM cer_model_years WHERE year=".$_GET[year]." LIMIT 1");
                while($row=mysqli_fetch_array($result)) {?>
            <form method="post">
                <h2 class="sub-header">Базовый</h2>
                <div class="col-lg-4">
                    Спрос
                    <input type="text" id="base_demand" name="base_demand" class="form-control" value="<?=$row[base_demand]?>">
                </div>
                <div class="col-lg-4">
                    Добыча
                    <input type="text" name="base_production" class="form-control" value="<?=$row[base_production]?>">
                </div>
                <div class="col-lg-4">
                    <!--Импорт-->
                    <input type="hidden" name="base_import" class="form-control" value="<?=$row[base_import]?>">
                </div>
                <br><br><br>
                <h2 class="sub-header">Пессимистический</h2>
                <div class="col-lg-4">
                    Спрос
                    <input type="text" id="pess_demand" name="pess_demand" class="form-control" value="<?=$row[pess_demand]?>">
                </div>
                <div class="col-lg-4">
                    Добыча
                    <input type="text" name="pess_production" class="form-control" value="<?=$row[pess_production]?>">
                </div>
                <div class="col-lg-4">
                    <!--Импорт-->
                    <input type="hidden" name="pess_import" class="form-control" value="<?=$row[pess_import]?>">
                </div>
                <br><br><br>
                <h2 class="sub-header">Оптимистический</h2>
                <div class="col-lg-4">
                    Спрос
                    <input type="text" id="opt_demand" name="opt_demand" class="form-control" value="<?=$row[opt_demand]?>">
                </div>
                <div class="col-lg-4">
                    Добыча
                    <input type="text" name="opt_production" class="form-control" value="<?=$row[opt_production]?>">
                </div>
                <div class="col-lg-4">
                    <!--Импорт-->
                    <input type="hidden" name="opt_import" class="form-control" value="<?=$row[opt_import]?>">
                </div>
                <br><br><br>
                <h2 class="sub-header">Трубопровод</h2>
                <strong>Статические данные или год*коэффициент (пример 2015*1,36)</strong><br>
                Туркменистан 1 очередь
                <input type="text" id="turk1" name="turk1" class="form-control" value="<?=$row[turk1]?>">
                Туркменистан 2 очередь
                <input type="text" name="turk2" class="form-control" value="<?=$row[turk2]?>">
                Туркменистан 3 очередь
                <input type="text" name="turk3" class="form-control" value="<?=$row[turk3]?>">
                Туркменистан 4 очередь
                <input type="text" name="turk4" class="form-control" value="<?=$row[turk4]?>">
                Мьянма
                <input type="text" name="mianma" class="form-control" value="<?=$row[mianma]?>">
                Россия Сила Сибири
                <input type="text" name="rus_sib" class="form-control" value="<?=$row[rus_sib]?>">
                Россия Алтай
                <input type="text" name="rus_alt" class="form-control" value="<?=$row[rus_alt]?>">
                <br>
                <h2 class="sub-header">СПГ</h2>
                <div class="col-lg-6">
                    Контракты СПГ
                    <input type="text" name="contracts_spg" class="form-control" value="<?=$row[contracts_spg]?>">
                </div>
                <div class="col-lg-6">
                    Регазификационные мощности проектные
                    <input type="text" name="regas_project" class="form-control" value="<?=$row[regas_project]?>">
                </div>
                <br><br><br>
                <div class="col-lg-6">
                    Мощности в любом случае проектные
                    <input type="checkbox" name="only_project" class="form-control" <? if($row[only_project]) echo "checked";?>>
                </div>
                <div class="col-lg-6">
                    Год отсчёта
                    <input type="checkbox" name="year_stack" class="form-control" <? if($row[year_stack]) echo "checked";?>>
                </div>
                <br><br><br><br><br><br>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Сохранить</button>
            </form>
            <?php } endif; if(empty($_GET[year]) && $_GET[page]!="comments" && $_GET[page]!="survey" && $_GET[page]!="infowindow" && empty($_GET[model])):?>
                <div class="col-lg-12">
                    <h2 class="sub-header">Загрузить CSV</h2>
                    <div class="col-lg-4">
                        <form enctype="multipart/form-data" method="post">
                            <strong>Базовый</strong>
                            <input name="base<?php if($_GET[debug]==1) echo '222';?>" type="file" />
                            <br>
                            <input type="submit" value="Загрузить" />
                        </form>
                    </div>
                    <div class="col-lg-4">
                        <form enctype="multipart/form-data" method="post">
                            <strong>Пессимистический</strong>
                            <input name="pess" type="file" />
                            <br>
                            <input type="submit" value="Загрузить" />
                        </form>
                    </div>
                    <div class="col-lg-4">
                        <form enctype="multipart/form-data" method="post">
                            <strong>Оптимистический</strong>
                            <input name="opt" type="file" />
                            <br>
                            <input type="submit" value="Загрузить" />
                        </form>
                    </div>
                </div>
                <div class="col-lg-12">
                    <h2 class="sub-header">Настройки</h2>
                    <form method="post">
                        <?php
                        $result = $link->query("SELECT * FROM cer_model_settings LIMIT 1");
                        while($row=mysqli_fetch_array($result)) {?>
                        <div class="col-lg-4">
                            Минимум
                            <input type="text" id="model_settings_min" name="model_settings_min" class="form-control" value="<?=$row[min]?>">
                        </div>
                        <div class="col-lg-4">
                            Максимум
                            <input type="text" name="model_settings_max" class="form-control" value="<?=$row[max]?>">
                        </div>
                        <?}?>
                        <br><br><br><br><br><br>
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Сохранить</button>
                    </form>
                </div>
            <?php endif; if(empty($_GET[year]) && $_GET[page]!="comments" && $_GET[page]!="survey" && $_GET[page]!="infowindow" && $_GET[model]=="oilhigh"):?>
                <div class="col-lg-12">
                    <h2 class="sub-header">Скачать загруженные CSV</h2>
                    <div class="col-lg-4">
                        <a href="download.php?file=oil" target="_blank"><strong>Спрос на сырую нефть+конденсат</strong></a>
                    </div>
                    <div class="col-lg-4">
                        <a href="download.php?file=ctl" target="_blank"><strong>Спрос на CTL, GTL</strong></a>
                    </div>
                    <div class="col-lg-4">
                        <a href="download.php?file=bio" target="_blank"><strong>Биотоплива</strong></a>
                    </div>
                    <br>
                    <h2 class="sub-header">Загрузить CSV</h2>
                    <div class="col-lg-4">
                        <form enctype="multipart/form-data" method="post">
                            <strong>Спрос на сырую нефть+конденсат</strong>
                            <input name="oil_request" type="file" />
                            <br>
                            <input type="submit" value="Загрузить" />
                        </form>
                    </div>
                    <div class="col-lg-4">
                        <form enctype="multipart/form-data" method="post">
                            <strong>Спрос на CTL, GTL</strong>
                            <input name="ctl_request" type="file" />
                            <br>
                            <input type="submit" value="Загрузить" />
                        </form>
                    </div>
                    <div class="col-lg-4">
                        <form enctype="multipart/form-data" method="post">
                            <strong>Биотоплива</strong>
                            <input name="bio_oil" type="file" />
                            <br>
                            <input type="submit" value="Загрузить" />
                        </form>
                    </div>
                </div>
                <div class="col-lg-12">
                    <h2 class="sub-header">Настройки</h2>
                    <form method="post">
                        <?php
                        $result = $link->query("SELECT * FROM cer_model2_settings LIMIT 1");
                        while($row=mysqli_fetch_array($result)) {?>
                        <div class="col-lg-4">
                            Минимум
                            <input type="text" id="model2_settings_min" name="model2_settings_min" class="form-control" value="<?=$row[min]?>">
                        </div>
                        <div class="col-lg-4">
                            Максимум
                            <input type="text" name="model2_settings_max" class="form-control" value="<?=$row[max]?>">
                        </div>
                        <?}?>
                        <br><br><br><br><br><br>
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Сохранить</button>
                    </form>
                </div>
            <?php endif; if(empty($_GET[year]) && $_GET[page]!="comments" && $_GET[page]!="survey" && $_GET[page]!="infowindow" && $_GET[model]=="chinaslow"):?>
                <div class="col-lg-12">
                    <h2 class="sub-header">Скачать загруженные CSV</h2>
                    <div class="col-lg-4">
                        <a href="download.php?file=china_data" target="_blank"><strong>Данные</strong></a>
                    </div>
                    <br>
                    <h2 class="sub-header">Загрузить CSV</h2>
                    <div class="col-lg-4">
                        <form enctype="multipart/form-data" method="post">
                            <strong>Данные</strong>
                            <input name="china_data" type="file" />
                            <br>
                            <input type="submit" value="Загрузить" />
                        </form>
                    </div>
                </div>
                <div class="col-lg-12">
                    <h2 class="sub-header">Настройки</h2>
                    <form method="post">
                        <?php
                        $result = $link->query("SELECT * FROM cer_model3_settings LIMIT 1");
                        while($row=mysqli_fetch_array($result)) {?>
                        <div class="col-lg-4">
                            Минимум
                            <input type="text" id="model3_settings_min" name="model3_settings_min" class="form-control" value="<?=$row[min]?>">
                        </div>
                        <div class="col-lg-4">
                            Максимум
                            <input type="text" name="model3_settings_max" class="form-control" value="<?=$row[max]?>">
                        </div>
                        <?}?>
                        <br><br><br><br><br><br>
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Сохранить</button>
                    </form>
                </div>
            <?php endif; if(empty($_GET[year]) && $_GET[page]!="comments" && $_GET[page]!="survey" && $_GET[page]!="infowindow" && $_GET[model]=="saudi"):?>
                <div class="col-lg-12">
                    <h2 class="sub-header">Скачать загруженные CSV</h2>
                    <div class="col-lg-4">
                        <a href="download.php?file=saudi_data" target="_blank"><strong>Данные</strong></a>
                    </div>
                    <br>
                    <h2 class="sub-header">Загрузить CSV</h2>
                    <div class="col-lg-4">
                        <form enctype="multipart/form-data" method="post">
                            <strong>Данные</strong>
                            <input name="saudi_data" type="file" />
                            <br>
                            <input type="submit" value="Загрузить" />
                        </form>
                    </div>
                </div>
                <div class="col-lg-12">
                    <h2 class="sub-header">Настройки</h2>
                    <form method="post">
                        <?php
                        $result = $link->query("SELECT * FROM cer_model4_settings LIMIT 1");
                        while($row=mysqli_fetch_array($result)) {?>
                        <div class="col-lg-4">
                            Минимум
                            <input type="text" id="model4_settings_min" name="model4_settings_min" class="form-control" value="<?=$row[min]?>">
                        </div>
                        <div class="col-lg-4">
                            Максимум
                            <input type="text" name="model4_settings_max" class="form-control" value="<?=$row[max]?>">
                        </div>
                        <?}?>
                        <br><br><br><br><br><br>
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Сохранить</button>
                    </form>
                </div>
            <? endif; if($_GET[page]=="infowindow"):?>
                <div class="col-lg-12">
                    <h2 class="sub-header">Загрузить CSV</h2>
                    <div class="col-lg-12">
                        <form enctype="multipart/form-data" method="post">
                            <strong>Таблица</strong>
                            <input name="info_window" type="file" />
                            <br>
                            <input type="submit" value="Загрузить" />
                        </form>
                    </div>
                </div>
            <? endif;
            if($_GET[page]=="comments"):?>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <!-- Default panel contents -->
                        <div class="panel-heading"><a href="admin.php?page=comments">Все</a> | <a href="admin.php?page=comments&new=1">Только не одобренные</a></div>
                        <!-- Table -->
                        <div class="row first">
                            <div class="col-lg-1">
                                id
                            </div>
                            <div class="col-lg-2">
                                Страница
                            </div>
                            <div class="col-lg-2">
                                Имя
                            </div>
                            <div class="col-lg-3">
                                Текст
                            </div>
                            <div class="col-lg-2">
                                Одобрить
                            </div>
                            <div class="col-lg-2">
                                Удалить
                            </div>
                        </div>
                            <?php
                            $whereshow="";
                            if($_GET['new']==1)
                                $whereshow=" WHERE cc.show1=0";
                            $result = $link->query("SELECT cc.*,p.page_name FROM cer_comments AS cc INNER JOIN adm_pages AS p ON cc.page_id=p.page_id".$whereshow." ORDER BY id DESC");
                            while($row=mysqli_fetch_array($result)) {?>
                                <div class="row">
                                <div class="col-lg-1">
                                    <?=$row[id]?>
                                </div>
                                <div class="col-lg-2">
                                    <?=$row[page_name]?>
                                </div>
                                <div class="col-lg-2">
                                    <?=$row[nic]?>
                                </div>
                                <div class="col-lg-3">
                                    <?=$row[text]?>
                                </div>
                                <div class="col-lg-2">
                                    <form method="post">
                                            <input type="hidden" name="show_comment" value="<?=$row[id]?>">
                                            <button class="btn btn-lg btn-primary btn-block" type="submit"><? if($row[show1]) echo "Отключить"; else echo "Одобрить";?></button>
                                    </form>
                                </div>
                                <div class="col-lg-2">
                                    <form method="post">
                                        <input type="hidden" name="delete_comment" value="<?=$row[id]?>">
                                        <button class="btn btn-lg btn-primary btn-block" type="submit">Удалить</button>
                                    </form>
                                </div>
                                </div>
                            <?php }?>
                    </div>
                </div>
            <? endif;
            if($_GET[page]=="survey"):?>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <!-- Default panel contents -->
                        <div class="panel-heading"> <? if(!empty($_GET[test]) || !empty($_GET[test_comments])) echo '<a href="admin.php?page=survey">К списку тестов</a>';?> <? if(!empty($_GET[question])) echo ' | <a href="admin.php?page=survey&test='.$_GET[test].'">К списку вопросов</a>';?></div>
                        <!-- Table -->
                        <? if(empty($_GET[test]) && empty($_GET[question]) && empty($_GET[test_comments])): ?>
                        <div class="row first">
                            <div class="col-lg-1">
                                id
                            </div>
                            <div class="col-lg-5">
                                Имя
                            </div>
                            <div class="col-lg-2">
                                Комментарии
                            </div>
                            <div class="col-lg-2">
                                Тип
                            </div>
                            <div class="col-lg-2">
                                Удалить
                            </div>
                        </div>
                        <?php
                        $result = $link->query("SELECT * FROM cer_surveys ORDER BY id DESC");
                        while($row=mysqli_fetch_array($result)) {?>
                            <div class="row">
                                <div class="col-lg-1">
                                    <a href="admin.php?page=survey&test=<?=$row[id]?>"><?=$row[id]?></a>
                                </div>
                                <div class="col-lg-5">
                                    <div class="edit-area">
                                        <div class="edit-area-text">
                                            <?=$row[name]?>
                                        </div>
                                        <div class="edit-area-form" style="display: none;">
                                            <form method="post">
                                                <input type="text" class="form-control" name="edit_test" value="<?=htmlspecialchars($row[name])?>">
                                                <input type="hidden" name="edit_test_id" value="<?=$row[id]?>">
                                                <button class="btn btn-lg btn-primary btn-block" type="submit">Сохранить</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <a href="admin.php?page=survey&test_comments=<?=$row[id]?>">Комментарии</a>
                                </div>
                                <div class="col-lg-2">
                                    <form method="post">
                                        <input type="hidden" name="change_survey_type_id" value="<?=$row[id]?>">
                                        <input type="hidden" name="change_survey_type" value="<? if($row[type]) echo 0; else echo 1;?>">
                                        <button class="btn btn-lg btn-primary btn-block" type="submit"><? if($row[type]) echo "Динамический"; else echo "Постоянный";?></button>
                                    </form>
                                </div>
                                <div class="col-lg-2">
                                    <form method="post">
                                        <input type="hidden" name="delete_survey" value="<?=$row[id]?>">
                                        <button class="btn btn-lg btn-primary btn-block" type="submit">Удалить</button>
                                    </form>
                                </div>
                            </div>
                        <?php }?>
                        <div class="row">
                            <form method="post">
                                <div class="col-lg-1">
                                </div>
                                <div class="col-lg-5">
                                    <input type="text" class="form-control" name="insert_test">
                                </div>
                                <div class="col-lg-2">
                                </div>
                                <div class="col-lg-2">
                                    <button class="btn btn-lg btn-primary btn-block" type="submit">Добавить</button>
                                </div>
                            </form>
                        </div>
                        <?endif; ?>
                        <? if(empty($_GET[test]) && empty($_GET[question]) && !empty($_GET[test_comments])): ?>
                            <div class="row first">
                                <div class="col-lg-1">
                                    id
                                </div>
                                <div class="col-lg-2">
                                    От (процентов)
                                </div>
                                <div class="col-lg-2">
                                    До (процентов)
                                </div>
                                <div class="col-lg-5">
                                    Текст
                                </div>
                                <div class="col-lg-2">
                                    Удалить
                                </div>
                            </div>
                            <?php
                            $result = $link->query("SELECT * FROM cer_surveys_comments WHERE test_id=".$_GET[test_comments]." ORDER BY id ASC");
                            while($row=mysqli_fetch_array($result)) {?>
                                <div class="row">
                                    <div class="col-lg-1">
                                        <?=$row[id]?>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="edit-area">
                                            <div class="edit-area-text">
                                                <?=$row[from]?>
                                            </div>
                                            <div class="edit-area-form" style="display: none;">
                                                <form method="post">
                                                    <input type="text" class="form-control" name="edit_test_comments_from" value="<?=htmlspecialchars($row[from])?>">
                                                    <input type="hidden" name="edit_test_comments_from_id" value="<?=$row[id]?>">
                                                    <button class="btn btn-lg btn-primary btn-block" type="submit">Сохранить</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="edit-area">
                                            <div class="edit-area-text">
                                                <?=$row[to]?>
                                            </div>
                                            <div class="edit-area-form" style="display: none;">
                                                <form method="post">
                                                    <input type="text" class="form-control" name="edit_test_comments_to" value="<?=htmlspecialchars($row[to])?>">
                                                    <input type="hidden" name="edit_test_comments_to_id" value="<?=$row[id]?>">
                                                    <button class="btn btn-lg btn-primary btn-block" type="submit">Сохранить</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="edit-area">
                                            <div class="edit-area-text">
                                                <?=$row[text]?>
                                            </div>
                                            <div class="edit-area-form" style="display: none;">
                                                <form method="post">
                                                    <input type="text" class="form-control" name="edit_test_comments" value="<?=htmlspecialchars($row[text])?>">
                                                    <input type="hidden" name="edit_test_comments_id" value="<?=$row[id]?>">
                                                    <button class="btn btn-lg btn-primary btn-block" type="submit">Сохранить</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <form method="post">
                                            <input type="hidden" name="delete_test_comments" value="<?=$row[id]?>">
                                            <button class="btn btn-lg btn-primary btn-block" type="submit">Удалить</button>
                                        </form>
                                    </div>
                                </div>
                            <?php }?>
                            <div class="row">
                                <form method="post">
                                    <div class="col-lg-1">
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="text" class="form-control" name="insert_test_comments_from">
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="text" class="form-control" name="insert_test_comments_to">
                                    </div>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" name="insert_test_comments">
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="hidden" name="test_comments_id" value="<?=$_GET[test_comments]?>">
                                        <button class="btn btn-lg btn-primary btn-block" type="submit">Добавить</button>
                                    </div>
                                </form>
                            </div>
                        <? endif; ?>
                        <? if(!empty($_GET[test]) && empty($_GET[question]) && empty($_GET[test_comments])): ?>
                            <div class="row first">
                                <div class="col-lg-1">
                                    id
                                </div>
                                <div class="col-lg-9">
                                    Вопрос
                                </div>
                                <div class="col-lg-2">
                                    Удалить
                                </div>
                            </div>
                            <?php
                            $result = $link->query("SELECT * FROM cer_surveys_questions WHERE test_id=".$_GET[test]." ORDER BY id ASC");
                            while($row=mysqli_fetch_array($result)) {?>
                                <div class="row">
                                    <div class="col-lg-1">
                                        <a href="admin.php?page=survey&test=<?=$_GET[test]?>&question=<?=$row[id]?>"><?=$row[id]?></a>
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="edit-area">
                                            <div class="edit-area-text">
                                                <?=$row[name]?>
                                            </div>
                                            <div class="edit-area-form" style="display: none;">
                                                <form method="post">
                                                    <input type="text" class="form-control" name="edit_question" value="<?=htmlspecialchars($row[name])?>">
                                                    <input type="hidden" name="edit_question_id" value="<?=$row[id]?>">
                                                    <button class="btn btn-lg btn-primary btn-block" type="submit">Сохранить</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <form method="post">
                                            <input type="hidden" name="delete_question" value="<?=$row[id]?>">
                                            <button class="btn btn-lg btn-primary btn-block" type="submit">Удалить</button>
                                        </form>
                                    </div>
                                </div>
                            <?php }?>
                            <div class="row">
                                <form method="post">
                                    <div class="col-lg-1">
                                    </div>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" name="insert_test_question">
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="hidden" name="test_id" value="<?=$_GET[test]?>">
                                        <button class="btn btn-lg btn-primary btn-block" type="submit">Добавить</button>
                                    </div>
                                </form>
                            </div>
                        <? endif; ?>
                        <? if(!empty($_GET[test]) && !empty($_GET[question]) && empty($_GET[test_comments])): ?>
                            <div class="row first">
                                <div class="col-lg-1">
                                    id
                                </div>
                                <div class="col-lg-4">
                                    Ответ
                                </div>
                                <div class="col-lg-1">
                                    Правильный
                                </div>
                                <div class="col-lg-4">
                                    Сообщение, если выбран ответ
                                </div>
                                <div class="col-lg-2">
                                    Удалить
                                </div>
                            </div>
                            <?php
                            $result = $link->query("SELECT * FROM cer_surveys_answers WHERE question_id=".$_GET[question]." ORDER BY id ASC");
                            while($row=mysqli_fetch_array($result)) {?>
                                <div class="row">
                                    <div class="col-lg-1">
                                        <?=$row[id]?>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="edit-area">
                                            <div class="edit-area-text">
                                                <?=$row[name]?>
                                            </div>
                                            <div class="edit-area-form" style="display: none;">
                                                <form method="post">
                                                    <input type="text" class="form-control" name="edit_answer" value="<?=htmlspecialchars($row[name])?>">
                                                    <input type="hidden" name="edit_answer_id" value="<?=$row[id]?>">
                                                    <button class="btn btn-lg btn-primary btn-block" type="submit">Сохранить</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <form method="post">
                                            <input type="hidden" name="set_answer_correct" value="<?=$row[id]?>">
                                            <input type="hidden" name="set_answer_correct_type" value="<? if($row[answer_correct]) echo 0; else echo 1;?>">
                                            <button class="btn btn-lg btn-primary btn-block" type="submit"><? if($row[answer_correct]) echo "Да"; else echo "Нет";?></button>
                                        </form>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="edit-area">
                                            <div class="edit-area-text">
                                                <?=$row[result]?>
                                            </div>
                                            <div class="edit-area-form" style="display: none;">
                                                <form method="post">
                                                    <input type="text" class="form-control" name="edit_answer_result" value="<?=htmlspecialchars($row[result])?>">
                                                    <input type="hidden" name="edit_answer_result_id" value="<?=$row[id]?>">
                                                    <button class="btn btn-lg btn-primary btn-block" type="submit">Сохранить</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <form method="post">
                                            <input type="hidden" name="delete_answer" value="<?=$row[id]?>">
                                            <button class="btn btn-lg btn-primary btn-block" type="submit">Удалить</button>
                                        </form>
                                    </div>
                                </div>
                            <?php }?>
                            <div class="row">
                                <form method="post">
                                    <div class="col-lg-1">
                                    </div>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" name="insert_answer">
                                    </div>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" name="insert_answer_result">
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="hidden" name="question_id" value="<?=$_GET[question]?>">
                                        <button class="btn btn-lg btn-primary btn-block" type="submit">Добавить</button>
                                    </div>
                                </form>
                            </div>
                        <? endif; ?>
                    </div>
                </div>
            <? endif;?>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery.min.js"><\/script>')</script>
<script src="js/bootstrap.min.js"></script>
<!-- Just to make our placeholder images work. Don't actually copy the next line! -->
<script src="js/vendor/holder.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="js/ie10-viewport-bug-workaround.js"></script>
<script>
    $( "html" ).on( "click", function() {
        $('.edit-area-form').hide();
        $('.edit-area-text').show();
    });
    $( ".edit-area-text" ).on( "click", function() {
        event.stopPropagation();
        $( this ).parent().find('.edit-area-form').show();
        $(this).hide();
    });
    $( ".edit-area-form" ).on( "click", function() {
        event.stopPropagation();
    });
</script>
</body>
</html>
