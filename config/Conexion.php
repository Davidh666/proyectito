<?php
class Conexion {
    private static $conexion = null;

    public function conectar() {
        if(self::$conexion === null) {
            try {
                $host = getenv('DB_HOST');
                $db   = getenv('DB_NAME');
                $port = getenv('DB_PORT');
                $user = getenv('DB_USER');
                $pass = getenv('DB_PASS');

                $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
                
                // Opciones para habilitar SSL (Requerido por Aiven)
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::MYSQL_ATTR_SSL_CA => '/etc/ssl/certs/ca-certificates.crt', 
                    PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false
                ];

                self::$conexion = new PDO($dsn, $user, $pass, $options);
            } catch(PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }
        return self::$conexion;
    }
}
?>