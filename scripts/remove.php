<?php
require_once __DIR__ . "/../base_scripts/User.php";
require_once __DIR__ . "/../base_scripts/Response.php";
require_once __DIR__ . "/../base_scripts/Session.php";

$mail = $_POST['mail'];
if (!$mail)
    die(Response::format(1, "Incorrect Mail"));

(new User())->deleteUserByMail($mail);
Session::finish();
die(Response::format(0, "OK"));