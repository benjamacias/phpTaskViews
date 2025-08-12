<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Task.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../views/login.php");
    exit;
}

$db = (new Database())->getConnection();
$user = new User($db);
$taskModel = new Task($db);

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->name = $_POST['name'];
            $user->email = $_POST['email'];
            $user->password = $_POST['password'];
            $user->role = $_POST['role'];
            $user->hourly_rate = $_POST['hourly_rate'];
            $user->create();
            header("Location: AdminController.php?action=list");
            exit;
        }
        include __DIR__ . '/../views/admin/users/create.php';
        break;

    case 'salary':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->id = $_POST['user_id'];
            $user->hourly_rate = $_POST['hourly_rate'];
            $user->updateHourlyRate();
        }
        $users = $user->readAll();
        $employees = [];
        foreach($users as $u){
            if($u['role'] !== 'admin'){
                $hours = $taskModel->sumHoursByUser($u['id']);
                $u['total_hours'] = $hours;
                $u['salary'] = $hours * (float)$u['hourly_rate'];
                $employees[] = $u;
            }
        }
        include __DIR__ . '/../views/admin/users/salary.php';
        break;

    default:
        $users = $user->readAll();
        include __DIR__ . '/../views/admin/users/list.php';
        break;
}
?>
