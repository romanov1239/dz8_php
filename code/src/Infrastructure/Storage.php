<?php

namespace Geekbrains\Application1\Infrastructure;

use Geekbrains\Application1\Application\Application;
use PDO;
use PDOException;

class Storage
{
    private PDO $connection;

    public function __construct ()
    {
        try {

            $this -> connection = new PDO(
                Application ::$config -> get ()['database']['DSN'],
                Application ::$config -> get ()['database']['USER'],
                Application ::$config -> get ()['database']['PASSWORD'],
                array (
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                )
            );
        } catch (PDOException $e) {
            die("Ошибка подключения к базе данных: " . $e -> getMessage ());
        }
    }

    public function get (): PDO
    {
        return $this -> connection;
    }
}
