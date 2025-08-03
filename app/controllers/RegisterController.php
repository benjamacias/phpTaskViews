<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/User.php';

$db = (new Database())->getConnection();
$user = new User($db);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $user->name = $_POST['name'];
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];
    $user->role = 'programmer';
    if($user->create()){
        $logged = $user->login();
        if($logged){
            $_SESSION['user_id'] = $logged['id'];
            $_SESSION['role'] = $logged['role'];
            header("Location: ../views/dashboard.php");
            exit;
        }
    }
    echo "Error al registrar";
}
?>
