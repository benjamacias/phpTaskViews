<?php
class Project {
    private $conn;
    private $table_name = "projects";

    public $id;
    public $name;
    public $description;
    public $leader_id;
    public $start_date;
    public $end_date;

    public function __construct($db){
        $this->conn = $db;
    }

    public function create(){
        $query = "INSERT INTO " . $this->table_name . " (name, description, leader_id, start_date, end_date)
                  VALUES (:name, :description, :leader_id, :start_date, :end_date)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":leader_id", $this->leader_id);
        $stmt->bindParam(":start_date", $this->start_date);
        $stmt->bindParam(":end_date", $this->end_date);
        if($stmt->execute()){
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function readAll(){
        $stmt = $this->conn->query("SELECT * FROM " . $this->table_name);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

public function readByUser($user_id){
    $query = "SELECT t.*, p.name AS project_name 
              FROM tasks t
              JOIN task_users tu ON t.id = tu.task_id
              JOIN projects p ON t.project_id = p.id
              WHERE tu.user_id = :uid
              ORDER BY t.due_date ASC";  // 🔑 Ordenar por fecha
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':uid', $user_id);
    $stmt->execute();
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
                  SET name=:name, description=:description, leader_id=:leader_id, start_date=:start_date, end_date=:end_date
                  WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":leader_id", $this->leader_id);
        $stmt->bindParam(":start_date", $this->start_date);
        $stmt->bindParam(":end_date", $this->end_date);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }

    public function delete(){
        $stmt = $this->conn->prepare("DELETE FROM " . $this->table_name . " WHERE id=:id");
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }

    public function assignUsers($projectId, $userIds){
        $stmt = $this->conn->prepare("INSERT INTO project_users(project_id, user_id) VALUES(:pid, :uid)");
        foreach($userIds as $uid){
            $stmt->execute([':pid'=>$projectId, ':uid'=>$uid]);
        }
    }

    public function getUsers($projectId){
        $stmt = $this->conn->prepare("SELECT user_id FROM project_users WHERE project_id=:pid");
        $stmt->execute([':pid'=>$projectId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function clearUsers($projectId){
        $stmt = $this->conn->prepare("DELETE FROM project_users WHERE project_id=:pid");
        $stmt->execute([':pid'=>$projectId]);
    }
}
?>
