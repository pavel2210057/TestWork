<?php
require_once __DIR__ . "/../base_scripts/Session.php";
require_once __DIR__ . "/../base_scripts/User.php";

if (!Session::check())
    header("Location: /");

$user = (new User())->getUserByMail($_COOKIE['mail'])->fetch_assoc();
?>
<!doctype html>
<html lang="en">
<head>
    <title>Page</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/css/app.css">
    <style type="text/css">
        #avatar {
            width: 50%;
        }
    </style>
</head>
<body>
    <h1 id="header"></h1>
    <div class="base-form">
        <?php if (isset($user['avatar_url'])): ?>
            <div class="base-form__item">
                <img id="avatar" src="<?= $user['avatar_url'] ?>">
            </div>
        <?php endif; ?>
        <div class="base-form__item">
            <span id="name-label" class="base-form__item-label"></span>
            <p><?=$user['name']?></p>
        </div>
        <div class="base-form__item">
            <span id="surname-label" class="base-form__item-label"></span>
            <p><?=$user['surname']?></p>
        </div>
        <div class="base-form__item">
            <span id="mail-label" class="base-form__item-label"></span>
            <p><?=$user['mail']?></p>
        </div>
        <div class="base-form__item">
            <span id="uid-label" class="base-form__item-label"></span>
            <p><?=$user['id']?></p>
        </div>
        <div class="base-form__item">
            <button id="logout-btn"></button>
        </div>
        <div class="base-form__item">
            <button id="remove-btn"></button>
        </div>
    </div>
    <div id="lang-btn-outer">
        <button id="lang-btn"></button>
    </div>
    <script type="text/javascript" src="/js/app.js"></script>
    <script type="text/javascript" src="/js/lang.js"></script>
    <script type="text/javascript">
        (function() {
            const lang = new GlobalLang("page", "lang");

            const bindActions = () => {
                document.querySelector("#logout-btn")
                    .addEventListener("click", () =>
                        App.uploadJSON("/scripts/logout.php")
                            .then(() => location.href = "register_form.php")
                    );
                document.querySelector("#remove-btn")
                    .addEventListener("click", () =>
                        App.uploadJSON("/scripts/remove.php", {
                            mail: "<?= $user['mail'] ?>"
                        })
                            .then(res => res.json())
                            .then(json => {
                                if (json['code'] === 0)
                                    location.href = "register_form.php";
                                else
                                    alert(json['message']);
                            })
                    );
            };

            (async function() {
                await App.init(lang, "#lang-btn");
                bindActions();
            })();
        })();
    </script>
</body>
</html>
