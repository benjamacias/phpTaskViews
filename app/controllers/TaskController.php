<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Task.php';
require_once __DIR__ . '/../models/User.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../views/login.php");
    exit;
}

$db = (new Database())->getConnection();
$task = new Task($db);
$userModel = new User($db);

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $task->project_id = $_POST['project_id'];
            $task->description = $_POST['description'];
            $task->assigned_to = $_POST['assigned_to'];
            $task->due_date = $_POST['due_date'];
            $task->status = 'enproceso';
            $task->create();
            header("Location: TaskController.php?action=list");
            exit;
        }
        $users = $userModel->readAll();
        include __DIR__ . '/../views/tasks/create.php';
        break;

    case 'edit':
        $task->id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $task->project_id = $_POST['project_id'];
            $task->description = $_POST['description'];
            $task->assigned_to = $_POST['assigned_to'];
            $task->due_date = $_POST['due_date'];
            $task->status = $_POST['status'];
            $task->update();
            header("Location: TaskController.php?action=list");
            exit;
        }
        $data = $task->readOne();
        $users = $userModel->readAll();
        include __DIR__ . '/../views/tasks/edit.php';
        break;

    case 'delete':
        $task->id = $_GET['id'];
        $task->delete();
        header("Location: TaskController.php?action=list");
        exit;

    case 'updateStatus':
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $task->id = $_POST['id'];
            $newStatus = $_POST['status'];
            $task->updateStatus($newStatus);
            header('Content-Type: application/json');
            echo json_encode(['success'=>true]);
            exit;
        }
        break;

    default:
        $tasks = $task->readAll();
        $users = $userModel->readAll();
        include __DIR__ . '/../views/tasks/list.php';
        break;
}
?>
