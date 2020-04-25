<?php

class Validator {
    public static function validMail(string $mail) : bool {
        $re = "/^[^!@#\$%\^&*()\-_=+,{}[\]?\s]*[a-z0-9]+@[a-z0-9]+\.[a-z0-9]+$/";
        return preg_match($re, $mail);
    }
}