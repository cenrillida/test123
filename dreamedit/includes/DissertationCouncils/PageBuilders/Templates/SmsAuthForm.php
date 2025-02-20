<?php

namespace DissertationCouncils\PageBuilders\Templates;

use DissertationCouncils\DissertationCouncils;
use DissertationCouncils\FormBuilders\Templates\SmsAuthFormBuilder;
use DissertationCouncils\PageBuilders\PageBuilder;

class SmsAuthForm implements PageBuilder {

    /** @var DissertationCouncils */
    private $dissertationCouncils;
    /** @var \Pages */
    private $pages;

    /**
     * SmsAuthForm constructor.
     * @param DissertationCouncils $dissertationCouncils
     * @param \Pages $pages
     */
    public function __construct(DissertationCouncils $dissertationCouncils, $pages)
    {
        $this->dissertationCouncils = $dissertationCouncils;
        $this->pages = $pages;
    }

    public function build($params = array())
    {
        global $DB,$_CONFIG,$site_templater;

        if($_GET['logout']==1) {
            $this->dissertationCouncils->getAuthorizationService()->logout();
            \Dreamedit::sendHeaderByCode(301);
            \Dreamedit::sendLocationHeader("https://" . $_SERVER["SERVER_NAME"] . $_SESSION['lang']."/index.php?page_id=".$_REQUEST['page_id']);
            return;
        }

        if($this->dissertationCouncils->getAuthorizationService()->isAuthorized()) {
            \Dreamedit::sendHeaderByCode(301);
            \Dreamedit::sendLocationHeader("https://" . $_SERVER["SERVER_NAME"] . $_SESSION['lang']."/index.php?page_id=".$_REQUEST['page_id']);
            return;
        }

        if($_SESSION['lang']!="/en") {
            $formBuilder = new SmsAuthFormBuilder("Успешная авторизация.","","","Войти", false);

            $posError = $formBuilder->processPostBuild();

            if($posError=="1" && $this->dissertationCouncils->getAuthorizationService()->isAuthorized()) {
                $personalPageId = $this->pages->getFirstPageIdByTemplate("dissertation_councils_lk");
                if(!empty($personalPageId)) {
                    \Dreamedit::sendHeaderByCode(301);
                    \Dreamedit::sendLocationHeader("https://" . $_SERVER["SERVER_NAME"] . $_SESSION['lang']."/index.php?page_id=".$personalPageId);
                    return;
                }
            }

        }

        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."top.text.html");

        ?>
        <script type="module">
            // Import the functions you need from the SDKs you need
            import { initializeApp } from "https://www.gstatic.com/firebasejs/9.6.4/firebase-app.js";

            import { getAuth, signInWithEmailAndPassword, RecaptchaVerifier, signInWithPhoneNumber } from 'https://www.gstatic.com/firebasejs/9.6.4/firebase-auth.js'

            // https://firebase.google.com/docs/web/setup#available-libraries

            // Your web app's Firebase configuration
            const firebaseConfig = {
                apiKey: "AIzaSyDuK0PZSnjs8D5OvwjRdJtK0hEDF-BLebI",
                authDomain: "www.imemo.ru",
                projectId: "imemo-dissertation-councils",
                storageBucket: "imemo-dissertation-councils.appspot.com",
                messagingSenderId: "861331002696",
                appId: "1:861331002696:web:4a2d64c559d18f4c438f7d",
                languageCode: "ru"
            };

            // Initialize Firebase
            const app = initializeApp(firebaseConfig, "Диссертационные советы ИМЭМО РАН");
            let auth = getAuth(app);
            auth.languageCode = "ru";

            function registerCaptchaVerifier() {
                window.recaptchaVerifier = new RecaptchaVerifier('google-submit', {
                    'size': 'invisible',
                    'callback': (response) => {
                        let phoneNumber = '+' + $('#phone').val();
                        // reCAPTCHA solved, allow signInWithPhoneNumber.
                        $('#google-submit').attr('disabled', true);
                        $('#spinner-phone').show();
                        $('#phone').removeClass('is-invalid');

                        $.ajax({
                            method: "GET",
                            url: "/index.php?page_id=<?=$_REQUEST['page_id']?>",
                            data: { mode: 'checkPhone', phone: phoneNumber }
                        })
                            .done(function( msg ) {
                                if(msg.status === "OK") {
                                    signInWithPhoneNumber(auth, phoneNumber, window.recaptchaVerifier)
                                        .then((confirmationResult) => {
                                            console.log(confirmationResult);
                                            // SMS sent. Prompt user to type the code from the message, then sign the
                                            // user in with confirmationResult.confirm(code).
                                            window.confirmationResult = confirmationResult;

                                            $('#google-form').hide(300);
                                            $('#google-code-form').show(300);

                                            // ...
                                        }).catch((error) => {
                                        console.log(error);
                                        $('#google-submit').attr('disabled', false);
                                        $('#phone').addClass('is-invalid');
                                        $('#phoneFeedback').text('Неправильный номер');
                                        grecaptcha.reset(window.recaptchaWidgetId );
                                        // Error; SMS not sent
                                        // ...
                                    }).then(() => {
                                        $('#spinner-phone').hide();
                                    });
                                } else {
                                    $('#google-submit').attr('disabled', false);
                                    $('#phone').addClass('is-invalid');
                                    $('#phoneFeedback').text('Номер не зарегистрирован');
                                    $('#spinner-phone').hide();
                                    grecaptcha.reset(window.recaptchaWidgetId );
                                }
                            });
                    }
                }, auth);
                window.recaptchaVerifier.render().then(widgetId => {
                    window.recaptchaWidgetId = widgetId;
                });
            }

            $(document).ready(function() {
                // $('#phone').on('keydown', function (e) {
                //     if($(this).val()==='') {
                //         $(this).val('+7');
                //     }
                // });
                $('#google-form').on('submit', function(e){
                    e.preventDefault();
                    // validation code here
                });
                $('#google-code-form').on('submit', function(e){
                    e.preventDefault();

                    let phoneCode = $('#phone_code').val();
                    $('#google-code-submit').attr('disabled', true);
                    $('#spinner-code').show();
                    $('#phone_code').removeClass('is-invalid');
                    window.confirmationResult.confirm(phoneCode)
                        .then((result) => {
                            console.log('SUCCESS AUTH');
                            $('#token').val(result.user.accessToken);
                            $('#tokenForm').submit();
                        }).catch((error) => {
                            $('#google-code-submit').attr('disabled', false);
                            $('#phone_code').addClass('is-invalid');
                    }).then(() => {
                        $('#spinner-code').hide();
                    });
                });
                registerCaptchaVerifier();
            });

        </script>
        <div class="container-fluid">
            <div class="row justify-content-between mb-3">
                <div>
                </div>
                <div class="row justify-content-end">
                    <div class="mt-3 pl-2 pr-2">
                        <a class="btn btn-lg imemo-button text-uppercase" href="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=login"
                           role="button">Авторизация по e-mail</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-3"></div>

        <?php

        if(!empty($posError)) {
            ?>
            <div class="alert alert-danger" role="alert">
                <?=$posError?>
            </div>
            <?php
        }

        ?>

        <form id="google-form" name="feedform" enctype="multipart/form-data" method="post" action="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=<?=$_GET['mode']?>">
            <div class="form-group ">
                <label for="phone">Номер телефона<i class="text-danger">*</i></label>
                <div class="phone-plus-before">
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="" value="" aria-describedby="phoneFeedback" >
                    <div id="phoneFeedback" class="invalid-feedback">
                        Неправильный номер
                    </div>
                </div>
            </div>

            <div class="d-flex">
                <div class="d-flex">
                    <input id="google-submit" type="submit" name="Submit" value="Войти" class="btn btn-lg btn-primary imemo-button text-uppercase">
                </div>
                <div class="d-flex">
                    <div id="spinner-phone" class="spinner-border my-auto ml-3" role="status" style="display: none">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </form>

        <form style="display: none" id="google-code-form" name="feedform" enctype="multipart/form-data" method="post" action="/index.php?page_id=<?=$_REQUEST['page_id']?>&mode=smsAuth">
            <div class="form-group ">
                <label for="phone_code">Код<i class="text-danger">*</i></label>
                <input type="text" name="phone_code" id="phone_code" class="form-control" placeholder="" value="" aria-describedby="phoneCodeFeedback"/>
                <div id="phoneCodeFeedback" class="invalid-feedback">
                    Неправильный код
                </div>
            </div>

            <div class="d-flex">
                <div class="d-flex">
                    <input id="google-code-submit" type="submit" name="Submit" value="Войти" class="btn btn-lg btn-primary imemo-button text-uppercase">
                </div>
                <div class="d-flex">
                    <div id="spinner-code" class="spinner-border my-auto ml-3" role="status" style="display: none">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </form>

        <form id="tokenForm" enctype="multipart/form-data" method="post" action="/about/dissertation-councils/account?mode=<?=$_GET['mode']?>">
            <input type="hidden" id="token" name="token">
            <input type="hidden" name="Submit">
        </form>

        <?php

        $site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.text.html");
    }

}