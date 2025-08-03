<?php
class Database {
    private $host = "localhost";
    private $db_name = "task_manager";
    private $username = "root";
    private $password = ""; // o tu contraseña si la tiene
    private $port = "4044"; // 🔑 Agregar puerto
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>
