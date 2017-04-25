<?php

/**
 * Conn [ TIPO ]
 * Descricao 
 * @copyright (c) 2017, Cristiano Franca Empresa
 */
class Conn {

    private static $host = HOST;
    private static $user = USER;
    private static $pass = PASSWORD;
    private static $dbsa = DBSA;

    /** Construtor privado evita da classe ser instaciada */
    private function __construct() {
        
    }

    /** @var PDO */
    private static $connect = null;

    private static function conectar() {

        try {
            if (self::$connect == null) {
                $dns = "mysql:host=" . self::$host . ";dbname=" . self::$dbsa;
                $opt = [PDO::MYSQL_ATTR_INIT_COMMAND => 'set names utf8'];
                self::$connect = new PDO($dns, self::$user, self::$pass, $opt);
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        self::$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$connect;
    }

    public static function getConn() {
        return self::conectar();
    }

}
