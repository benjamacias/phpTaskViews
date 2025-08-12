<?php
class Client {
    private $conn;
    private $table_name = "clients";

    public $id;
    public $name;

    public function __construct($db){
        $this->conn = $db;
    }

    public function create(){
        $stmt = $this->conn->prepare("INSERT INTO " . $this->table_name . " (name) VALUES (:name)");
        $stmt->bindParam(":name", $this->name);
        return $stmt->execute();
    }

    public function readAll(){
        $stmt = $this->conn->query("SELECT * FROM " . $this->table_name);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readOne(){
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table_name . " WHERE id=:id");
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
