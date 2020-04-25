<?php

class Session {
    static public function start() : void {
        session_start();
        $_SESSION['id'] = session_id();
    }

    static public function finish() : void {
        session_start();
        unset($_SESSION);
        session_destroy();
    }

    static public function check() : bool {
        session_start();
        return isset($_SESSION['id']);
    }
}