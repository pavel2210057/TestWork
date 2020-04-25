<?php
require_once __DIR__ . "/../base_scripts/Session.php";
if (Session::check())
    header("Location: /");
?>
<!doctype html>
<html lang="en">
<head>
    <title>User Register</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
<h1 id="header"></h1>
<div class="base-form">
    <div class="base-form__item">
        <label id="name-input-label" for="name-input" class="base-form__item-label"></label>
        <input id="name-input" class="text-input" type="text">
    </div>
    <div class="base-form__item">
        <label id="surname-input-label" for="surname-input" class="base-form__item-label"></label>
        <input id="surname-input" class="text-input" type="text">
    </div>
    <div class="base-form__item">
        <label id="mail-input-label" for="mail-input" class="base-form__item-label"></label>
        <input id="mail-input" class="text-input" type="text">
    </div>
    <div class="base-form__item">
        <label id="pass-input-label" for="pass-input" class="base-form__item-label"></label>
        <input id="pass-input" class="text-input" type="password">
    </div>
    <div class="base-form__item">
        <label id="avatar-input-label" for="avatar-input" class="base-form__item-label"></label>
        <input id="avatar-input" class="file-input" type="file" accept="image/jpeg,image/png,image/gif">
    </div>
    <div class="base-form__item">
        <button id="register-btn"></button>
    </div>
    <div class="base-form__item">
        <a id="login-form-ref" href="login_form.php"></a>
    </div>
</div>
<div id="lang-btn-outer">
    <button id="lang-btn"></button>
</div>
<script type="text/javascript" src="/js/app.js"></script>
<script type="text/javascript" src="/js/lang.js"></script>
<script type="text/javascript">
    /*инициализация*/
    (function() {
        const lang = GlobalLang("register_form", "lang");

        const checkInput = (id, fail_message) => {
            const data = document.querySelector(id).value;
            if (!data.length) {
                alert(fail_message);
                return false;
            }
            return data;
        };

        const register = async () => {
            let name, surname, mail, pass;
            if (!((name = checkInput("#name-input", "Input Name")) &&
                (surname = checkInput("#surname-input", "Input Surname")) &&
                (mail = checkInput("#mail-input", "Input Mail")) &&
                (pass = checkInput("#pass-input", "Input Pass"))))
                return Promise.reject("incorrect Data");

            return App.uploadJSON("/scripts/register.php", {
                name: name,
                surname: surname,
                mail: mail,
                pass: pass,
                avatar: document.querySelector("#avatar-input").files[0]
            });
        };

        const bindActions = () => {
            document.querySelector("#register-btn")
                .addEventListener("click", () => {
                    const mail = document.querySelector("#mail-input").value;
                    if (App.validMail(mail))
                        register()
                            .then(res => res.json())
                            .then(json =>
                                alert(json['message'])
                            )
                            .catch(console.log);
                    else
                        alert("Incorrect Mail");
                })
        };

        (async function() {
            await App.init(lang, "#lang-btn");
            bindActions();
        })();
    })();
</script>
</body>
</html>