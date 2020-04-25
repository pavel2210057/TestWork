<?php
require_once __DIR__ . "/../base_scripts/Validator.php";
require_once __DIR__ . "/../base_scripts/Response.php";
require_once __DIR__ . "/../base_scripts/User.php";
require_once __DIR__ . "/../base_scripts/Session.php";

/*проверка наличия обязательных полей*/
$name = $_POST['name'];
$surname = $_POST['surname'];
$mail = $_POST['mail'];
$pass = $_POST['pass'];
if (!($name && $surname && $mail && $pass))
    die(Response::format(1, "Incorrect Data"));

if (!Validator::validMail($mail))
    die(Response::format(2, "Incorrect Mail"));

$user = new User();
if ($user->getUserByMail($mail)->num_rows)
    die(Response::format(3, "Email was registered"));

if (!$user->addUser([
    'name' => $name,
    'surname' => $surname,
    'mail' => $mail,
    'pass' => $pass,
    'avatar' => $_FILES['avatar']
]))
    die(Response::format(4, "Incorrect Image Format"));
die(Response::format(0, "OK"));