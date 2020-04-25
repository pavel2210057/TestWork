<?php

class User {
    private mysqli $sql;

    public function __construct(array $config = null) {
        $db_config = $config ??
            require_once __DIR__ . "/../db/config.php";

        $this->sql = new mysqli(
            $db_config['host'],
            $db_config['user'],
            $db_config['pass'],
            $db_config['db']
        );
    }

    public function __destruct() {
        $this->sql->close();
    }

    public function addUser(array $data) : bool {
        if (isset($data['avatar'])) {
            try {
                $name = $data['avatar']['name'];

                $type = strtolower(substr($name, strripos($name, '.')));
                if (!preg_match("/^(.png|.jpg|.gif)$/", $type))
                    return false;

                $avatar_url = "/image/" . bin2hex(random_bytes(32)) . "$type";
                move_uploaded_file($data['avatar']['tmp_name'], "..$avatar_url");
            } catch (Exception $e) {}
        }

        $data_string = sprintf("'%s','%s','%s','%s','%s'",
            $data['name'],
            $data['surname'],
            $data['mail'],
            md5($data['pass']),
            $avatar_url ?? ''
        );

        $this->sql->query("
            INSERT INTO users(name, surname, mail, pass, avatar_url) VALUES ($data_string)
        ");
        return true;
    }

    public function updateUser(array $data) : void {
        $data_string = sprintf("name=%s,surname=%s,pass=%s,avatar=%s",
            $data['name'],
            $data['surname'],
            $data['pass'],
            $data['avatar']
        );
        $mail = $data['mail'];

        $this->sql->query("
            UPDATE users SET $data_string WHERE mail=$mail
        ");
    }

    public function deleteUserByMail(string $mail) : void {
        $this->sql->query("
            DELETE FROM users WHERE mail='$mail'
        ");
    }

    public function getUserByMail(string $mail) {
        return $this->sql->query(
            "SELECT * FROM users WHERE mail='$mail'"
        );
    }
}