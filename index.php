<?php
require_once __DIR__ . "/base_scripts/Session.php";

if (!Session::check())
    $location = "register_form";
else
    $location = "page";

header("Location: site/$location.php");