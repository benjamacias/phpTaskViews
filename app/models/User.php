<?php
class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $name;
    public $email;
    public $password;
    public $role;
    public $hourly_rate;

    public function __construct($db){
        $this->conn = $db;
    }

    public function create(){
        $query = "INSERT INTO " . $this->table_name . " (name, email, password, role, hourly_rate)
                  VALUES (:name, :email, :password, :role, :hourly_rate)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", password_hash($this->password, PASSWORD_BCRYPT));
        $stmt->bindParam(":role", $this->role);
        $stmt->bindParam(":hourly_rate", $this->hourly_rate);
        return $stmt->execute();
    }

    public function login(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user && password_verify($this->password, $user['password'])){
            return $user;
        }
        return false;
    }

    public function readAll(){
        $stmt = $this->conn->query("SELECT id, name, email, role, hourly_rate FROM " . $this->table_name);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateHourlyRate(){
        $query = "UPDATE " . $this->table_name . " SET hourly_rate=:hourly_rate WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':hourly_rate', $this->hourly_rate);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }
}
?>