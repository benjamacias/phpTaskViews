<?php
class SalaryRecord {
    private $conn;
    private $table_name = "salary_records";

    public $id;
    public $user_id;
    public $month;
    public $gross_salary;
    public $retirement;
    public $social_security;
    public $union_fee;
    public $net_salary;

    public function __construct($db){
        $this->conn = $db;
    }

    public function create(){
        $query = "INSERT INTO " . $this->table_name . " (user_id, month, gross_salary, retirement, social_security, union_fee, net_salary) VALUES (:user_id, :month, :gross_salary, :retirement, :social_security, :union_fee, :net_salary)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':month', $this->month);
        $stmt->bindParam(':gross_salary', $this->gross_salary);
        $stmt->bindParam(':retirement', $this->retirement);
        $stmt->bindParam(':social_security', $this->social_security);
        $stmt->bindParam(':union_fee', $this->union_fee);
        $stmt->bindParam(':net_salary', $this->net_salary);
        return $stmt->execute();
    }
}
?>
