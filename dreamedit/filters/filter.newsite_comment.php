
<script language="JavaScript">
function swCmnt2(name)
{
    var a=document.getElementById(name).style;
    if (a.display=='none')
	    a.display='block';
	else
	    a.display='none';


}

function trim2(string)
{
    return string.replace(/(^\s+)|(\s+$)/g, "");
}

function empty2( mixed_var ) {    // Determine whether a variable is empty
    //
    // +   original by: Philippe Baumann

    return ( mixed_var === "" || mixed_var === 0   || mixed_var === "0" || mixed_var === null  || mixed_var === false  ) ;
}
function check_email2(email) {
  var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return filter.test(email);
}


function MyFBCheckCmnt2(dig1,dig2) {


  if (trim2(document.fbformcmt.nic.value)=="") {
	alert("Вы не ввели имя");
	return false;
  }


  if (trim2(document.fbformcmt.full_text.value)=="" ) {
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

   return(spam2(dig1,dig2));

}
function spam2(dig1,dig2)
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
global $DB,$_CONFIG, $site_templater;
$_REQUEST[id]=(int)$DB->cleanuserinput($_REQUEST[id]);
$_REQUEST[page_id]=(int)$DB->cleanuserinput($_REQUEST[page_id]);


if (!empty($_REQUEST[page_id]))
{
$dig1=rand(1,10)*10;
$dig2=rand(0,10);

if (!empty($_REQUEST[id]))
   $str=' AND page_id2='.$_REQUEST[id];
else
   $str="";
$cmnt0=$DB->select("SELECT t.*,g.avatar,CONCAT(g.surname,' ',g.name,' ',g.fname) AS FIO FROM comment_txt AS t
                    LEFT OUTER JOIN comment_reg AS g ON g.id=t.user_id
                    WHERE t.page_id=".(int)$_REQUEST[page_id]." AND t.verdict=1 ".$str. " ORDER BY t.date ASC ");
// Запись

if(isset($_POST[Submit_cmt_newsite]))
{

var_dump(1);
	if (empty($_POST[nic]) || empty($_POST[full_text]) || ($_POST[dig]!=($_POST[dig1]+$_POST[dig2])))
	{
	   echo "<br />Данные не корректны</br />";

	}
	else
	{
	$d=$DB->select("SELECT id FROM comment_txt
	                 WHERE page_id=".(int)$_REQUEST[page_id]. " AND ".
	                 "user_name='".$_POST[nic]."' AND ".
	                 "text='".$_POST[full_text]."'"
	                );
//echo strlen($_POST[fio])."@@@".$_POST[email];
    if (count($d)==0 && strlen($_POST[nic])>3 && $_POST[email]!='sample@email.tst')
    {
//echo "@@";  
  $a=$DB->query("INSERT INTO comment_txt (id,page_id,user_name,text,date,page_id2,verdict,email)
	        VALUES(
	        0,".
      (int)$_REQUEST[page_id].",".
	        "'".$_POST[nic]."',".
	        "'".$_POST[full_text]."',".
	        "'".date('Y').'.'.date('m').".".date('d')."',".
	        "'".(int)$_GET[id]."',".
	        "0,".
	        "'".$_POST[email]."'".
	        " )"
	        );
    }
    }
}
if($_SESSION[lang]!="/en") {
    $comment_title_txt = "Комментарии";
    $comment_show_txt = "Показать";
    $comment_add_txt = "Добавить комментарий";
    $comment_no_txt = "Нет комментариев";
    $comment_thank_txt = "Спасибо. Ваш комментарий принят";
    $comment_name_txt = "Ваше имя";
    $comment_text_txt = "Комментарий (комментарий будет опубликован после одобрения модератором)";
    $comment_spam_txt = "Пожалуйста, введите сумму двух чисел";
    $comment_submit_txt = "Отправить комментарий";
    $comment_name_placeholder_txt = "Введите Ваше имя";
    $comment_email_placeholder_txt = "Введите e-mail";
} else {
    $comment_title_txt = "Comments";
    $comment_show_txt = "Show";
    $comment_add_txt = "Add comment";
    $comment_no_txt = "No comments";
    $comment_thank_txt = "Thank you. Your comment accepted.";
    $comment_name_txt = "Your name";
    $comment_text_txt = "Comment (will be added after moderation)";
    $comment_spam_txt = "Please, enter the sum of two numbers";
    $comment_submit_txt = "Send";
    $comment_name_placeholder_txt = "Enter your name";
    $comment_email_placeholder_txt = "Enter your e-mail";
}

?>

<div id="comments" class="comments-area">
    <div class="card">
        <div class="card-block">
            <div class="row align-items-center">
                <div class="col-lg-6 col-xs-12 text-lg-left text-center">
                    <h4 class="comments-title mb-0">
                        <?=$comment_title_txt?> (<?=count($cmnt0)?>)
                    </h4>
                </div>
                <div class="col-lg-6 col-xs-12 mt-3 mt-lg-0">
                    <div class="text-lg-right text-center">
                        <a class="btn btn-lg imemo-button text-uppercase imemo-comment-button" id="showComments" href="#" role="button"><?=$comment_show_txt?></a>
                    </div>
                </div>
            </div>
            <?php if(count($cmnt0)!=0):?>
            <div class="commentlist mt-3">
                <?php
                $cmt_count = 1;
                foreach($cmnt0 as $cmnt)
                {
                    ?>
                    <div class="comment even thread-even depth-1" id="li-comment-<?=$cmt_count?>">
                        <article id="comment-<?=$cmt_count?>" class="comment">
                            <header class="comment-meta comment-author vcard">
                                <img alt="" src="/images/user-4.png" srcset="/images/user-4.png" class="avatar avatar-44 photo" height="44" width="44"><cite style="margin: 0 10px;"><b class="fn<?php if($cmnt["admin"]==1) echo ' text-danger';?>"><?=$cmnt["user_name"]?></b> </cite><small class="text-muted"><time><?=substr($cmnt["date"],8,2).".".substr($cmnt["date"],5,2).".".substr($cmnt["date"],0,4)?></time></small>
                            </header><!-- .comment-meta -->
                            <section class="comment-content comment mt-3">
                                <p><?=str_replace("<p>","",str_replace("</p>","",$cmnt["text"]))?></p>
                            </section><!-- .comment-content -->
                        </article><!-- #comment-## -->
                        <hr class="my-4">
                    </div>
                    <?
                    $cmt_count++;



                }
                ?>
            </div><!-- .commentlist -->
            <?php else: ?>
            <div class="commentlist mt-3">
                <h4 class='title'><?=$comment_no_txt?></h4>
            </div>
            <?php endif;?>
        </div>
    </div>
    <?
    if(isset($_POST[Submit_cmt_newsite]))
    {
        if (count($d)==0 && strlen($_POST[nic])>3 && $_POST[email]!='sample@email.tst')
        {
            ?>
            <div class="card">
                <div class="card-block">
                    <div class="row">
                        <div class="col-xs-12 text-lg-left text-center">
                            <p><?=$comment_thank_txt?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?
        }
    }
    ?>
    <div class="card add-comment-section">
        <div class="card-block">
            <div id="respond" class="comment-respond">
                <h4 id="reply-title" class="comment-reply-title"><?=$comment_add_txt?> <small><a rel="nofollow" id="cancel-comment-reply-link" href="/2017/04/07/iphone7plus/#respond" style="display:none;" data-slimstat="5">Отменить ответ</a></small></h4>
                <form name="fbformcmt"
                      enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"
                      onSubmit="return MyFBCheckCmnt2(<?=$dig1?>,<?=$dig2?>)" class="comment-form">
                    <div class="form-group comment-form-comment">
                        <div class="form-group">
                            <label for="nic"><?=$comment_name_txt?> <span class='red'>*</span></label><br>
                            <input type='edit' name='nic' id="nic" maxlength='50' size='66' value='<?=$_POST[nic]?>' placeholder="<?=$comment_name_placeholder_txt?>"><br>
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail <span class='red'>*</span></label><br>
                            <input type='email' name='email' id="email" maxlength='50' size='50' value='<?=$_POST[email]?>' placeholder="<?=$comment_email_placeholder_txt?>"><br>
                        </div>
                        <div class="form-group">
                            <label for="full_text"><?=$comment_text_txt?> <span class='red'>*</span></label><br>
                            <textarea class="form-control" id="full_text" name="full_text" cols="45" rows="8" aria-required="true" value='<?=$_POST[full_text]?>'></textarea><br>
                        </div>
                        <div class="form-group">
                            <label for="dig"><?=$comment_spam_txt?>: <span class='red'>*</span> <strong><?=$dig1?>+<?=$dig2?> = </strong></label>
                            <input type='edit' name='dig' id="dig" maxlength='50' size='5'>
                        </div>
                        <input type='hidden' value='<?=$dig1?>' name='dig1' id='dig1'>
                        <input type='hidden' value='<?=$dig2?>' name='dig2' id='dig2'>
                    </div>
                    <p class="form-submit">
                        <input name="submit" type="submit" id="Submit_cmt_newsite" class="btn imemo-button" value="<?=$comment_submit_txt?>">
                    </p>
                </form>
            </div><!-- #respond -->
        </div>
    </div>
</div>

        <?


}
?>