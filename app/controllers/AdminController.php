<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/User.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../views/login.php");
    exit;
}

$db = (new Database())->getConnection();
$user = new User($db);

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->name = $_POST['name'];
            $user->email = $_POST['email'];
            $user->password = $_POST['password'];
            $user->role = $_POST['role'];
            $user->create();
            header("Location: AdminController.php?action=list");
            exit;
        }
        include __DIR__ . '/../views/admin/users/create.php';
        break;

    default:
        $users = $user->readAll();
        include __DIR__ . '/../views/admin/users/list.php';
        break;
}
?>
