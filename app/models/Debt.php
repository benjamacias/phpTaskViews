<?php
class Debt {
    private $conn;
    private $table_name = "debts";

    public $id;
    public $client_id;
    public $project_id;
    public $title;
    public $description;

    public function __construct($db){
        $this->conn = $db;
    }

    public function create(){
        $query = "INSERT INTO " . $this->table_name . " (client_id, project_id, title, description) VALUES (:client_id, :project_id, :title, :description)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":client_id", $this->client_id);
        $stmt->bindParam(":project_id", $this->project_id);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        return $stmt->execute();
    }

    public function readByClient($client_id){
        $query = "SELECT d.*, p.name AS project_name FROM " . $this->table_name . " d LEFT JOIN projects p ON d.project_id = p.id WHERE d.client_id = :cid";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":cid", $client_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
