<?php
require_once __DIR__ . "/../base_scripts/Session.php";
if (Session::check())
    header("Location: /");
?>
<!doctype html>
<html lang="en">
<head>
    <title>Login</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    <h1 id="header"></h1>
    <div class="base-form">
        <div class="base-form__item">
            <label id="mail-input-label" class="base-form__item-label" for="mail-input"></label>
            <input id="mail-input" type="text">
        </div>
        <div class="base-form__item">
            <label id="pass-input-label" class="base-form__item-label" for="pass-input"></label>
            <input id="pass-input" type="password">
        </div>
        <div class="base-form__item">
            <button id="login-btn"></button>
        </div>
        <div class="base-form__item">
            <a id="register-form-btn" href="register_form.php"></a>
        </div>
    </div>
    <div id="lang-btn-outer">
        <button id="lang-btn"></button>
    </div>
    <script type="text/javascript" src="/js/app.js"></script>
    <script type="text/javascript" src="/js/lang.js"></script>
    <script type="text/javascript">
        (function () {
            const lang = GlobalLang("login_form", "lang");

            const login = async () =>
                App.uploadJSON("/scripts/login.php", {
                    mail: document.querySelector("#mail-input").value,
                    pass: document.querySelector("#pass-input").value
                });

            const bindActions = () => {
                document.querySelector("#login-btn")
                    .addEventListener("click", e => {
                        const mail = document.querySelector("#mail-input").value;
                        if (App.validMail(mail)) {
                            login()
                                .then(res => res.json())
                                .then(json => {
                                    if (json['code'] === 0)
                                        location.href = "page.php";
                                    else
                                        alert(json['message']);
                                });
                        } else
                            alert("Incorrect Mail");
                    });
            };

            (async function () {
                await App.init(lang, "#lang-btn");
                bindActions();
            })();
        })();
    </script>
</body>
</html>