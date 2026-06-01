<?php

class Conexion {

    private $host = "localhost";
    private $dbname = "producto_db";
    private $user = "root";
    private $password = "";
    private static $conexion = null;

    public function conectar() {
        if(self::$conexion === null) {
            try {
                self::$conexion = new PDO(
                    "mysql:host=" . $this->host . ";dbname=" . $this->dbname,
                    $this->user,
                    $this->password,
                    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
                );

                self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }
        return self::$conexion;
    }

}

?>