<?

// Работа с корзинкой

global $DB, $_CONFIG, $site_templater;

if(!empty($_POST[username]) && !empty($_POST[passwd]) )
{
    if($_POST[username]!="meimo" || str_replace(" ","",$_POST[passwd])!="&H#F!73gfg3") {
        if($_SESSION[lang]!='/en')
            echo "<p align='center'><strong>Ваш логин или пароль неверны. Попробуйте еще раз</strong></p>";
        else
            echo "<p align='center'><strong>Invalid login or password. Try again</strong></p>";
    }
    else
    {
        setcookie("userid_meimo",1, 0);
        $_COOKIE[userid_meimo]=1;
        $_REQUEST[userid_meimo]=1;
        setcookie("userid_meimo_secure","38FH$*8h4", 0);
        $_COOKIE[userid_meimo_secure]="38FH$*8h4";
        $_REQUEST[userid_meimo_secure]="38FH$*8h4";
        $_SESSION['meimo_authorization']=1;
    }
}

if(!empty($_POST[mod_login_exit])) {
    $_SESSION['meimo_authorization']=0;
}




$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

// Если нет логина

if($_SESSION['meimo_authorization']!=1)
{
   echo "<div class='box5' id='login_in' style='padding-left:20px;background-color:white;'>";
   if($_SESSION[lang]!='/en')
    echo 'Авторизация:';
  else
    echo 'Auth:';
    if($_GET[debug]==2) {
        echo $_TPL_REPLACMENT["LOGIN_MEIMO"];
    } else {
        include($_TPL_REPLACMENT["LOGIN_MEIMO"]);
    }
   echo "</div>";
} else {
    if($_GET[debug]==2) {
        echo $_TPL_REPLACMENT["LOGIN_MEIMO"];
    } else {
        include($_TPL_REPLACMENT["LOGIN_MEIMO"]);
    }
}

$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
?>