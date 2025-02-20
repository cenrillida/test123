<?php if($_GET[debug]==1):?>
    <div class="title white"><h2>Подписаться на рассылку</h2></div>
    <div id="newsletter_message" style="color: white; text-align: center; padding: 8px 0; margin-bottom: 10px; display: none;"></div>
    <form style="text-align: center;" id="newsletter" action="/newsletter_request.php" method="get">
        <label><b>Введите Ваш e-mail</b><input style="width: 100%; padding: 5px; margin: 10px 0" id="newsletter_email" name="email" type="text"/></label>
        <input type="submit" value="Подписаться" style="    text-align: center;
    padding: 10px 20px;
    text-transform: uppercase;
    color: white;
    background-color: #27629c;
    border: 0;">
    </form>
    <script>
        jQuery( document ).ready(function() {
            jQuery('#newsletter').submit(function(event) {
                event.preventDefault();
                jQuery.ajax({
                    type: 'GET',
                    url: jQuery('#newsletter').attr('action')+'?email='+jQuery('#newsletter_email').val(),
                    success: function (data) {
                        if(data==='Вы уже подписаны' || data==='Неверный email адрес' || data==='Повторную заявку можно отправить через 5 минут') {
                            jQuery('#newsletter_message').css("background-color", "red");
                            jQuery('#newsletter_message').text(data);
                            jQuery('#newsletter_message').show();
                        }
                        if(data==='Вам было отправлено письмо для подтверждения подписки на рассылку.') {
                            jQuery('#newsletter_message').css("background-color", "green");
                            jQuery('#newsletter_message').text(data);
                            jQuery('#newsletter_message').show();
                        }
                    }
                })
            });
        });
    </script>
<?php endif;?>
