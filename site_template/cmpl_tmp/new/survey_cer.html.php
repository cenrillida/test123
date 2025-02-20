<?
global $_CONFIG, $site_templater,$DB;
	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");
?>
<style>

    .survey-question {
        font-weight: bold;
    }
    .survey-results,
    .survey-form {
        display: none;
    }
    .survey-results-box {
        border-right: 1px solid #ccc;
        border-left: 1px solid #ccc;
    }
    .survey-result {
        text-align: center;
        /*background: #1E4979;*/
        background: #EF1D24;
        color: white;
        float: left;
    }
    .survey-result-res {
        text-align: left;
        float: left;
    }
    .survey-count {
        margin: 5px 5px;
    }
    /*button.survey-button, button.survey-button2, button.survey-button3 {*/
        /*width: 100px;*/
        /*height: 25px;*/
        /*!*background: #1E4979;*!*/
        /*background: #EF1D24;*/
        /*color: white;*/
    /*}*/
    .survey {
        border: 1px solid;
        padding: 5px;
        margin-bottom: 10px;
    }
</style>
	<script>
    jQuery(document).ready(function() {
        jQuery(".survey-button").click(function(event) {
            event.preventDefault();
            questions_arr.forEach(function(item, i, questions_arr) {
                info=jQuery('.survey[name='+item+']').find('input[name=survey]:checked').attr('id');
                if(info==undefined)
                    throw new Error("Ответы не на все вопросы");
            });
            questions_arr.forEach(function(item, i, questions_arr) {
                info=jQuery('.survey[name='+item+']').find('input[name=survey]:checked').attr('id');
                if(info!=undefined)
                    showResults(item,info);
            });
            /*info="";
            info=jQuery(this).parent().find('input[name=survey]:checked').attr('id');
            if(info!=undefined)
                showResults(jQuery(this).attr('id'),info);*/
        });
    });

    tests_arr=[];
    questions_arr=[];
    right_answers=0;
    all_answers=0;

    function showResults(survey_id,answer) {
                jQuery('.survey[name='+survey_id+']').find('.survey-form').hide();
                //jQuery('.survey[name='+survey_id+']').find('.survey-result1').;
                jQuery('#'+answer+survey_id).show();
                jQuery('#text_'+answer).show();
                if(jQuery('#text_'+answer).attr('right_answer')=='1')
                    right_answers++;
                else {
                    jQuery('#text_' + answer).css('color', 'red');
                    jQuery('#text_' + answer).css('font-weight', 'bold');
                }
                tests_arr[jQuery('.survey[name='+survey_id+']').attr('test')]--;
                jQuery('.survey-results[name=' + survey_id + ']').show();
                if(tests_arr[jQuery('.survey[name='+survey_id+']').attr('test')]<=0) {
                    //jQuery('.survey-results[right_answer=0]').css('color','red');
                    jQuery('.survey-results[right_answer=1]').css('color','green');
                    jQuery('.survey-results[right_answer=1]').css('font-weight','bold');
                    jQuery('.survey-results[right_answer=0]').show();
                    jQuery('.survey-results[right_answer=1]').show();
                    result_right = (right_answers/questions_arr.length)*100;
                    result_not_right = 100-result_right;
                    jQuery('.survey-results-text').html('<br><h2>Результаты:</h2><br>Правильных ответов ' + right_answers + '/' + questions_arr.length + ' ('+result_right+'%)');
                    jQuery('.survey-results-text').show();
                    jQuery('.survey-button').hide();
                    jQuery('.survey-results-comments').html('<br>'+comments_text(result_right));
                    jQuery('.survey-results-comments').show();
                }
    }

    jQuery(document).ready(function() {
        jQuery(".survey-button2").click(function(event) {
            event.preventDefault();
            info="";
            info=jQuery(this).parent().find('input[name=survey]:checked').attr('id');
            if(jQuery(this).parent().find('input[name=survey]:checked').attr('right_answer')==1)
                right_answers++;
            if(info!=undefined) {
                if(jQuery(this).parent().find('input[name=survey]:checked').attr('right_answer')!=1) {
                    jQuery('#' + info+jQuery(this).attr('id')).css('color', 'red');
                    jQuery('#' + info+jQuery(this).attr('id')).css('font-weight', 'bold');
                }
                showResults2(jQuery(this).attr('id'), info);
                if(jQuery(this).attr('last')==1)
                    jQuery('.survey-button3').text('Завершить');
                jQuery('.survey-button3').show();
            }
        });
        jQuery(".survey-button3").click(function(event) {
            event.preventDefault();
            jQuery('.survey[passed=1]').hide();
            if(jQuery('.survey[passed=0]').val()!=undefined)
                jQuery('.survey[passed=0]').first().show();
            else {
                jQuery('.survey[passed=1]').show();
                result_right = (right_answers/all_answers)*100;
                jQuery('.survey-results-text').html('<br><h2>Результаты:</h2><br>Правильных ответов ' + right_answers + '/' + all_answers + ' ('+result_right+'%)');
                jQuery('.survey-results-text').show();
                jQuery('.survey-results-comments').html('<br>'+comments_text(result_right));
                jQuery('.survey-results-comments').show();
            }
            jQuery(".survey-button3").hide();
        });
    });

    function showResults2(survey_id,answer) {
        jQuery('.survey[name='+survey_id+']').find('.survey-form').hide();
        //jQuery('.survey[name='+survey_id+']').find('.survey-result1').;
        jQuery('#'+answer+survey_id).show();
        jQuery('#'+answer+survey_id+"_comment").show();
        jQuery('.survey[name='+survey_id+']').find('.survey-results').show();
        jQuery('.survey[name='+survey_id+']').find('.survey-results').find('.answers_results').show();
        jQuery('.survey[name='+survey_id+']').attr('passed','1');
    }
</script>
<?
if(empty($_GET[test_id])) {
    $surveys = $DB->select("SELECT * FROM cer_surveys");
    echo "<h2>Выбор теста:</h2>";
    foreach($surveys as $survey) {
        ?>
        <p><a href="/index.php?page_id=<?=(int)$_REQUEST[page_id]?>&test_id=<?=$survey[id]?>"><i class="fas fa-dot-circle"></i> <?=$survey[name]?></a></p>
        <?
    }
}
else
{
    $tests_ids=0;
    ?>
    <p><a href="/index.php?page_id=<?=(int)$_REQUEST[page_id]?>">К списку тестов</a></p>
    <?
    $surveys = $DB->select("SELECT * FROM cer_surveys WHERE id=".(int)$_GET[test_id]);
    foreach($surveys as $survey) {
        if($survey[type]==1)
            $questions = $DB->select("SELECT * FROM cer_surveys_questions WHERE test_id=" . $survey[id]." ORDER BY RAND() LIMIT 8");
        else
            $questions = $DB->select("SELECT * FROM cer_surveys_questions WHERE test_id=" . $survey[id]);
        if(!empty($questions))
            echo '<br><h2>'.$survey[name].'</h2><br>';
        if($survey[type]==1)
        show_test($questions,$tests_ids,$survey[id]);
        else
            show_test2($questions,$survey[id]);
        $tests_ids++;
    }
}




/*while($survey = mysqli_fetch_array($surveys)) {
    $questions = $link->query("SELECT * FROM cer_surveys_questions WHERE test_id=" . $survey[id]." ORDER BY RAND() LIMIT 20");
    if($questions->num_rows>0)
        echo '<br><h2>'.$survey[name].'</h2><br>';
    show_test($questions,$tests_ids);
    $tests_ids++;
}
$surveys = $link->query("SELECT * FROM cer_surveys WHERE type=0");

while($survey = mysqli_fetch_array($surveys)) {
    $questions = $link->query("SELECT * FROM cer_surveys_questions WHERE test_id=" . $survey[id]);
    if($questions->num_rows>0)
        echo '<br><h2>'.$survey[name].'</h2><br>';
    show_test($questions,$tests_ids);
    $tests_ids++;
}*/


function show_test($questions,$test_id,$survey_id) {
    global $DB;
    echo "<script>tests_arr[$test_id]=0;</script>";
    foreach($questions as $question) {?>
        <div class="survey" name="<?=$question[id]?>" test="<?=$test_id?>">
            <div class="survey-question">
                <p>&nbsp;<?=$question[name]?></p>		</div>
            <?
            $answers = $DB->select("SELECT * FROM cer_surveys_answers WHERE question_id=".$question[id]);
            foreach($answers as $answer) {
                ?>
                <div class="survey-results" <?if($answer[answer_correct]) echo 'right_answer="1"'; else echo 'right_answer="0";'?> id="text_answer_<?=$answer[id]?>_<?=$question[id]?>">
                    <?=$answer[name]?>
                </div>
            <? } ?>
            <form class="survey-form" style="display: block;">
                <?
                foreach($answers as $answer) {
                    ?>
                    <label><input type="radio" name="survey" id="answer_<?=$answer[id]?>_<?=$question[id]?>"> &nbsp;<?=$answer[name]?></label><br>
                <? }
                ?>
                <br>
                <!--<button class="survey-button" id="<?=$question[id]?>">Ответить</button>-->

            </form>
            <script>questions_arr[tests_arr[<?=$test_id?>]]=<?=$question[id]?>;tests_arr[<?=$test_id?>]++;</script>
        </div>
    <? }
    ?>
    <button class="survey-button btn btn-lg imemo-button text-uppercase">Проверить</button>
<div class="survey-results-text survey-results">
    <br>
    <h2>Результаты:</h2>

    <?

    foreach($questions as $question) {?>
            <div class="survey-results" name="<?=$question[id]?>">
                <div class="survey-question">
                    <p>&nbsp;<?=$question[name]?></p>		</div>
                <?
                $answers = $DB->select("SELECT * FROM cer_surveys_answers WHERE question_id=".$question[id]);
                foreach($answers as $answer) {
                    ?>
                    <div id="answer_<?=$answer[id]?>_<?=$question[id]?><?=$question[id]?>" style="display: none;"><?=$answer[result]?></div>
                <? }
                ?>
            </div>
    <? }

    $comments = $DB->select("SELECT * FROM cer_surveys_comments WHERE test_id=" . $survey_id);
    ?>
    <script>
        function comments_text(percent) {
            <?
                foreach($comments as $comment) {
                    ?>
            if(percent>=<?=$comment[from]?> && percent<=<?=$comment[to]?>)
                return '<?=htmlspecialchars($comment[text])?>';
            <?
        }
        ?>
            return '';
        }
    </script>
</div>
    <div class="survey-results-comments" style="display: none;">

    </div>
    <?
}    ?>

<?
function show_test2($questions,$survey_id) {
global $DB;
    $first=true;
$count_rows = count($questions);

foreach($questions as $question) {?>
    <script>all_answers++;</script>
<div class="survey"<?if($first) $first=false; else echo 'style="display: none;"'?> name="<?=$question[id]?>" passed="0">
    <div class="survey-question">
        <p>&nbsp;<?=$question[name]?></p>		</div>
    <form class="survey-form" style="display: block;">
        <?
        $answers = $DB->select("SELECT * FROM cer_surveys_answers WHERE question_id=?d",$question[id]);
        foreach($answers as $answer) {
            ?>
            <label><input type="radio" name="survey" id="answer_<?=$answer[id]?>_<?=$question[id]?>" <?if($answer[answer_correct]) echo 'right_answer="1"'; else echo 'right_answer="0";'?>> &nbsp;<?=$answer[name]?></label><br>
        <? }
        ?>
        <br>
        <button class="survey-button2 btn btn-lg imemo-button text-uppercase" id="<?=$question[id]?>" last="<? $count_rows--; if($count_rows==0) echo '1'; else echo '0'; ?>">Ответить</button>
    </form>
    <div class="survey-results">
        <?
        foreach($answers as $answer) {
            ?>
            <div id="answer_<?=$answer[id]?>_<?=$question[id]?><?=$question[id]?>" class="answers_results" style="display: none;<?if($answer[answer_correct]) echo 'color: green; font-weight: bold;';?>"><?=$answer[name]?></div>
        <? }
        foreach($answers as $answer) {
            ?>
            <div id="answer_<?=$answer[id]?>_<?=$question[id]?><?=$question[id]?>_comment" style="display: none;"><br><?=$answer[result]?></div>
        <? }
        ?>
    </div>
</div>

<? }
    $comments = $DB->select("SELECT * FROM cer_surveys_comments WHERE test_id=?d", $survey_id);
?>
        <script>
            function comments_text(percent) {
<?
    foreach($comments as $comment) {
        ?>
                if(percent>=<?=$comment[from]?> && percent<=<?=$comment[to]?>)
                return '<?=htmlspecialchars($comment[text])?>';
        <?
    }
    ?>
                return '';
                    }
        </script>
    <div class="survey-results-text" style="display: none;">

    </div>
    <div class="survey-results-comments" style="display: none;">

    </div>
    <button class="survey-button3 btn btn-lg imemo-button text-uppercase" style="display: none;">Дальше</button>
    <?
}

	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");

?>
