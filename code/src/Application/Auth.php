<?php

namespace Geekbrains\Application1\Application;

class Auth {
    public static function getPasswordHash(string $rawPassword): string {
        return password_hash($_GET['pass_string'], PASSWORD_BCRYPT);
    }

    public function proceedAuth(string $login, string $password): bool{
        $sql = "SELECT id_user, user_name, user_lastname, password_hash FROM users WHERE login = :login";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute(['login' => $login]);
        $result = $handler->fetchAll();

        if(!empty($result) && password_verify($password, $result[0]['password_hash'])){
            $_SESSION['user_name'] = $result[0]['user_name'];
            $_SESSION['user_lastname'] = $result[0]['user_lastname'];
            $_SESSION['id_user'] = $result[0]['id_user'];

            return true;
        }
        else {
            return false;
        }
    }
    public function logout()
    {
        if(isset($_SESSION['csrf_token'])) {
            unset($_SESSION['csrf_token']);
        }

        if(isset($_COOKIE['csrf_token'])) {
            setcookie('csrf_token', '', time() - 42000, '/');
        }


        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            setcookie(session_name(), '', time() - 42000,
            );
        }

        session_destroy();
    }

}