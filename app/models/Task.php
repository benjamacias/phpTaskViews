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
    public $estimated_hours;

    public function __construct($db){
        $this->conn = $db;
    }

    public function create(){
        $query = "INSERT INTO " . $this->table_name . " (project_id, description, assigned_to, due_date, status, estimated_hours)
                  VALUES (:project_id, :description, :assigned_to, :due_date, :status, :estimated_hours)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":project_id", $this->project_id);
        $stmt->bindParam(":description", $this->description);
        if($this->assigned_to === null){
            $stmt->bindValue(":assigned_to", null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(":assigned_to", $this->assigned_to, PDO::PARAM_INT);
        }
        $stmt->bindParam(":due_date", $this->due_date);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":estimated_hours", $this->estimated_hours);
        if($stmt->execute()){
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function assignUsers($taskId, $userIds){
        $stmt = $this->conn->prepare("INSERT INTO task_users(task_id, user_id) VALUES(:tid, :uid)");
        foreach($userIds as $uid){
            $stmt->execute([':tid'=>$taskId, ':uid'=>$uid]);
        }
    }

    public function getUsers($taskId){
        $stmt = $this->conn->prepare("SELECT u.name FROM users u JOIN task_users tu ON u.id = tu.user_id WHERE tu.task_id = :tid");
        $stmt->execute([':tid'=>$taskId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function readAllWithUsers(){
        $query = "SELECT t.*, 
                        p.name AS project_name, 
                        GROUP_CONCAT(u.name SEPARATOR ', ') AS users
                FROM tasks t
                LEFT JOIN projects p ON t.project_id = p.id
                LEFT JOIN task_users tu ON t.id = tu.task_id
                LEFT JOIN users u ON tu.user_id = u.id
                GROUP BY t.id";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readByUser($user_id){
        $query = "SELECT t.*, p.name AS project_name FROM tasks t
                  JOIN task_users tu ON t.id = tu.task_id
                  JOIN projects p ON t.project_id = p.id
                  WHERE tu.user_id = :uid";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':uid', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // ✅ agregado
    }

    public function readOne(){
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table_name . " WHERE id=:id");
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update(){
        $query = "UPDATE " . $this->table_name . "
                  SET project_id=:project_id, description=:description, assigned_to=:assigned_to, due_date=:due_date, status=:status, estimated_hours=:estimated_hours
                  WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":project_id", $this->project_id);
        $stmt->bindParam(":description", $this->description);
        if($this->assigned_to === null){
            $stmt->bindValue(":assigned_to", null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(":assigned_to", $this->assigned_to, PDO::PARAM_INT);
        }
        $stmt->bindParam(":due_date", $this->due_date);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":estimated_hours", $this->estimated_hours);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }

    public function delete(){
        $stmt = $this->conn->prepare("DELETE FROM " . $this->table_name . " WHERE id=:id");
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }

    public function clearUsers($taskId){
        $stmt = $this->conn->prepare("DELETE FROM task_users WHERE task_id=:tid");
        $stmt->execute([':tid'=>$taskId]);
    }

    public function updateStatus($status){
        $stmt = $this->conn->prepare("UPDATE " . $this->table_name . " SET status=:status WHERE id=:id");
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }

    public function sumHoursByProject($projectId){
        $stmt = $this->conn->prepare("SELECT SUM(estimated_hours) as total FROM " . $this->table_name . " WHERE project_id=:pid");
        $stmt->execute([':pid'=>$projectId]);
        return (float)$stmt->fetchColumn();
    }

    public function sumHoursByUser($userId){
        $query = "SELECT SUM(t.estimated_hours) as total FROM tasks t JOIN task_users tu ON t.id = tu.task_id WHERE tu.user_id = :uid";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':uid'=>$userId]);
        return (float)$stmt->fetchColumn();
    }
}
?>
