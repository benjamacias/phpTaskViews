<?php
class Tag {
    private $conn;
    private $table_name = "tags";
    private $user_tag_table = "user_tags";

    public $id;
    public $name;
    public $operation; // deduction, increase, reimbursement
    public $mode;      // percent or static
    public $amount;
    public $auto_remove; // boolean

    public function __construct($db){
        $this->conn = $db;
    }

    public function create(){
        $query = "INSERT INTO " . $this->table_name . " (name, operation, mode, amount, auto_remove, active) VALUES (:name, :operation, :mode, :amount, :auto_remove, 1)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':operation', $this->operation);
        $stmt->bindParam(':mode', $this->mode);
        $stmt->bindParam(':amount', $this->amount);
        $stmt->bindParam(':auto_remove', $this->auto_remove);
        return $stmt->execute();
    }

    public function update(){
        $query = "UPDATE " . $this->table_name . " SET name=:name, operation=:operation, mode=:mode, amount=:amount, auto_remove=:auto_remove WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':operation', $this->operation);
        $stmt->bindParam(':mode', $this->mode);
        $stmt->bindParam(':amount', $this->amount);
        $stmt->bindParam(':auto_remove', $this->auto_remove);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    public function deactivate(){
        $query = "UPDATE " . $this->table_name . " SET active=0 WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    public function readAll(){
        $stmt = $this->conn->query("SELECT * FROM " . $this->table_name . " ORDER BY name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id){
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table_name . " WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function assignToUser($user_id, $tag_id){
        $query = "INSERT INTO " . $this->user_tag_table . " (user_id, tag_id) VALUES (:user_id, :tag_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':tag_id', $tag_id);
        return $stmt->execute();
    }

    public function removeFromUser($user_id, $tag_id){
        $query = "DELETE FROM " . $this->user_tag_table . " WHERE user_id=:user_id AND tag_id=:tag_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':tag_id', $tag_id);
        return $stmt->execute();
    }

    public function clearUserTags($user_id){
        $stmt = $this->conn->prepare("DELETE FROM " . $this->user_tag_table . " WHERE user_id=:user_id");
        $stmt->bindParam(':user_id', $user_id);
        return $stmt->execute();
    }

    public function getTagsByUser($user_id){
        $query = "SELECT t.* FROM " . $this->table_name . " t JOIN " . $this->user_tag_table . " ut ON t.id = ut.tag_id WHERE ut.user_id=:user_id AND t.active=1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
