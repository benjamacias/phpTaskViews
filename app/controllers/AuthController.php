<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/User.php';

$db = (new Database())->getConnection();
$user = new User($db);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];

    $loggedUser = $user->login();

    if($loggedUser){
        $_SESSION['user_id'] = $loggedUser['id'];
        $_SESSION['role'] = $loggedUser['role'];
        header("Location: ../views/dashboard.php");
        exit;
    } else {
        echo "Credenciales inválidas";
    }
}
?>