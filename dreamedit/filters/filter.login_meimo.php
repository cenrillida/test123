<script language="JavaScript">
function exit (page,name, value, expires, path, domain, secure) {
  var curCookie = name + "=" + "undefined" +
  ((expires) ? "; expires=" + "Thu, 01-Jan-70 00:00:01 GMT" : "") +
  ((path) ? "; path=" + path : "") +
  ((domain) ? "; domain=" + domain : "") +
  ((secure) ? "; secure" : "");

  document.cookie = curCookie;

  var curCookie = "userid_meimo_secure" + "=" + "undefined" +
  ((expires) ? "; expires=" + "Thu, 01-Jan-70 00:00:01 GMT" : "") +
  ((path) ? "; path=" + path : "") +
  ((domain) ? "; domain=" + domain : "") +
  ((secure) ? "; secure" : "");

  document.cookie = curCookie;
  location.replace("https://www.imemo.ru<?=$_SESSION[lang]?>/jour/meimo/index.php?page_id="+page);
//  location.href='http://polis.isras.ru/index.php?page_id='+page;
  return false;

}
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
<?
global $DB,$_CONFIG, $site_templater;

if($_SESSION[lang]=="/en")
	$suff="_EN";
else $suff="";


echo "<a name='login'></a>";
//print_r($_POST);

if ( $_SESSION['meimo_authorization']==1)
{
    ?>
    <form id="form-login" name="login" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">

            <input id="mod_login_exit" type="hidden" value="1" name="mod_login_exit"/>


        <div class="clear extra-indent-link">
            <div >
                <!--	<span><input class="button_form" type="submit" value="Ввести" name="Submit"/></span>/-->
                <a class='button_form' name='submit' onclick="document.getElementById('form-login').submit()" href="#">
		<span>
			<span>		<?	echo $suff=="_EN" ? "Exit"  : "Выйти"	; ?></span>
		</span>

                </a>

                <!--	<input class="button indent-button" type="submit" value="Ввести" name="Submit"/>/-->
            </div>
        </div>
    </form>
    <?
}

else

{
?>
<form id="form-login" name="login" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<div class="clear">
	<input id="mod_login_username" class="inputbox" type="text" alt="Логин" name="username"/>
	<label for="mod_login_username"> 		<?	echo $suff=="_EN" ? "Login"  : "Логин"	; ?> </label>
</div>
<div class="clear">
	<input id="mod_login_password" class="inputbox" type="password" alt="Пароль" name="passwd"/>
	<label for="mod_login_password"> 		<?	echo $suff=="_EN" ? "Password"  : "Пароль"	; ?> </label>
</div>
<div class="clear">
	<div class="extra-indent-top1">
	</div>
</div>

<div class="clear extra-indent-link">
	<div >
<!--	<span><input class="button_form" type="submit" value="Ввести" name="Submit"/></span>/-->
		<a class='button_form' name='submit' onclick="document.getElementById('form-login').submit()" href="#">
		<span>
			<span>		<?	echo $suff=="_EN" ? "Enter"  : "Войти"	; ?></span>
		</span>

		</a>

	<!--	<input class="button indent-button" type="submit" value="Ввести" name="Submit"/>/-->
	</div>
</div>
</form>
<?
}
?>


