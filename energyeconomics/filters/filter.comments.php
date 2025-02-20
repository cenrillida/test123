<?php
global $link, $p_id;
if(isset($_POST[nic]))
{
    $stmt =  $link->stmt_init();
    $already=false;
    if ($stmt->prepare("SELECT * FROM cer_comments WHERE page_id=? AND email=? AND text=? AND date1=? AND nic=?")) {
        /* привязываем переменные к параметрам */
        $stmt->bind_param("issss", $p_id,$_POST[email], $_POST[full_text], date("d.m.Y"), $_POST[nic]);

        /* выполняем запрос */
        $stmt->execute();

        $stmt->store_result();
        if($stmt->num_rows>0)
            $already=true;

        $stmt->close();
    }
    if(!$already) {
        $stmt = $link->stmt_init();
        if ($stmt->prepare("INSERT INTO cer_comments SET page_id=?, email=?, text=?, date1=?, nic=?")) {
            /* привязываем переменные к параметрам */
            $stmt->bind_param("issss", $p_id, $_POST[email], $_POST[full_text], date("d.m.Y"), $_POST[nic]);

            /* выполняем запрос */
            $stmt->execute();

            $stmt->close();
        }
    }
}
?>
<script language="JavaScript">
    function swCmnt(name)
    {
        var a=document.getElementById(name).style;
        if (a.display=='none')
            a.display='block';
        else
            a.display='none';


    }

    function trim(string)
    {
        return string.replace(/(^\s+)|(\s+$)/g, "");
    }

    function empty( mixed_var ) {    // Determine whether a variable is empty
        //
        // +   original by: Philippe Baumann

        return ( mixed_var === "" || mixed_var === 0   || mixed_var === "0" || mixed_var === null  || mixed_var === false  ) ;
    }
    function check_email(email) {
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return filter.test(email);
    }


    function MyFBCheckCmnt(dig1,dig2) {


        if (trim(document.fbformcmt.nic.value)=="") {
            alert("Вы не ввели имя");
            return false;
        }


        if (trim(document.fbformcmt.full_text.value)=="" ) {
            alert("Вы не ввели текст комментария");
            return false;
        }
        var str="*"+trim(document.fbformcmt.full_text.value);
        j=str.indexOf('<a');
        if (j>0)
        {
            alert("В тексте комментария нельзя использовать ссылки");
            return false;
        }

        // Защита от  спама

        return(spam(dig1,dig2));

    }
    function spam(dig1,dig2)
    {
        var sum=document.getElementById('dig').value;
        if(dig1+dig2!=sum)
        {

            alert("Вы не прошли спам-контроль");
            return false
        }
    }
</script>
<?

$left_num = rand(0,100);
$right_num = rand(0,100);

?>
<br>
<div id="commentspost">
    <h2 class="title">Комментарии к этой странице</h2><p><a style="cursor:pointer;cursor:hand;" onclick="swCmnt('comment_write')">Оставить комментарий</a></p></div><div id="comment_write" style="display: none;">

    <form name="fbformcmt" enctype="multipart/form-data" method="post" onsubmit="return MyFBCheckCmnt(<?=$left_num?>,<?=$right_num?>)">
        <table>
            <tbody><tr><td><span value="">Ваше имя, псевдоним: * </span></td><td align="left">
                    <input type="edit" name="nic" maxlength="50" size="66" value=""></td></tr>   <tr><td><span value="">E-mail<br>(не публикуется):</span></td><td width="71%" align="left">
                    <input type="edit" name="email" maxlength="50" size="50" value="">&nbsp;<span class="red"></span></td></tr><tr><td colspan="2">Введите текст комментария (комментарий будет опубликован после одобрения модератором)*:</td></tr><tr></tr><tr><td colspan="2">
                    <textarea maxlength="3500" name="full_text" cols="68" rows="15"></textarea><span class="red">*</span></td></tr>   <tr><td valign="top" colspan="2">Защита от спама. <br>Пожалуйста, введите сумму двух чисел: <strong><?=$left_num?>+<?=$right_num?>=</strong>
                    <input type="edit" name="dig" id="dig" maxlength="50" size="5" onchange="spam(<?=$left_num?>,<?=$right_num?>)"><span class="red">*</span></td></tr><input type="hidden" value="<?=$left_num?>" name="dig1" id="dig1"><input type="hidden" value="<?=$right_num?>" name="dig2" id="dig2"></tbody></table>	<input type="submit" name="Submit_cmt" value="Отправить">
    </form></div>


<div id="comment_read">
    <br><strong>Комментарии к этой странице:</strong>

    <? 	$result = $link->query("SELECT * FROM cer_comments WHERE show1=1 AND page_id=".(int)$p_id." ORDER BY id");

    //display information:

    if($result->num_rows==0)
        echo "<br><br>Нет комментариев";

    while($row=mysqli_fetch_array($result)) {?>

    <br><br><b><?=$row[nic]?></b>&nbsp;&nbsp;&nbsp;<span class="date"><?=$row[date1]?></span>

    <br><?=$row[text]?><br clear="all">
    <? }?><br>&nbsp; <br>
</div>
