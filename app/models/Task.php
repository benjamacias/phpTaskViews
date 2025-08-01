<?php
class Task {
    private $conn;
    private $table_name = "tasks";

    public $id;
    public $project_id;
    public $description;
    public $assigned_to;
    public $due_date;
    public $status;

    public function __construct($db){
        $this->conn = $db;
    }

    public function create(){
        $query = "INSERT INTO " . $this->table_name . " (project_id, description, assigned_to, due_date, status)
                  VALUES (:project_id, :description, :assigned_to, :due_date, :status)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":project_id", $this->project_id);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":assigned_to", $this->assigned_to);
        $stmt->bindParam(":due_date", $this->due_date);
        $stmt->bindParam(":status", $this->status);
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

    public function update(){
        $query = "UPDATE " . $this->table_name . "
                  SET project_id=:project_id, description=:description, assigned_to=:assigned_to, due_date=:due_date, status=:status
                  WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":project_id", $this->project_id);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":assigned_to", $this->assigned_to);
        $stmt->bindParam(":due_date", $this->due_date);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }

    public function delete(){
        $stmt = $this->conn->prepare("DELETE FROM " . $this->table_name . " WHERE id=:id");
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }

    public function updateStatus($status){
        $stmt = $this->conn->prepare("UPDATE " . $this->table_name . " SET status=:status WHERE id=:id");
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }
}
?>
