<?php
require_once __DIR__ . "/../base_scripts/Validator.php";
require_once __DIR__ . "/../base_scripts/Response.php";
require_once __DIR__ . "/../base_scripts/User.php";
require_once __DIR__ . "/../base_scripts/Session.php";

$mail = $_POST['mail'];
$pass = $_POST['pass'];
if (!($mail && $pass))
    die(Response::format(1, "Incorrect Data"));

if (!Validator::validMail($mail) ||
    !($user = (new User())->getUserByMail($mail))->num_rows
)
    die(Response::format(2, "Incorrect Mail"));

if ($user->fetch_assoc()['pass'] !== md5($pass))
    die(Response::format(3, "Incorrect Password"));

Session::start();
setcookie("mail", $mail, 0, '/');
die(Response::format(0, "OK"));