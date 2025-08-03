<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Task.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Project.php';

if(!isset($_SESSION['user_id'])){
    header("Location: ../views/login.php");
    exit;
}

$db = (new Database())->getConnection();
$task = new Task($db);
$userModel = new User($db);
$projectModel = new Project($db);


$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $task->project_id = $_POST['project_id'];
            $task->description = $_POST['description'];
            $assignedUsers = $_POST['assigned_to'] ?? [];
            $task->assigned_to = $assignedUsers[0] ?? null;
            $task->due_date = $_POST['due_date'];
            $task->status = $_POST['status'] ?? 'pending'; // ✅ usar el estado del formulario
            $newId = $task->create();
            if($newId && $assignedUsers){
                $task->assignUsers($newId, $assignedUsers);
            }
            header("Location: TaskController.php?action=list");
            exit;
        }
        $projects = $projectModel->readAll();
        $users = $userModel->readAll();
        include __DIR__ . '/../views/tasks/create.php';
        break;


    case 'edit':
        $task->id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $task->project_id = $_POST['project_id'];
            $task->description = $_POST['description'];
            $assignedUsers = $_POST['assigned_to'] ?? [];
            $task->assigned_to = $assignedUsers[0] ?? null;
            $task->due_date = $_POST['due_date'];
            $task->status = $_POST['status'];
            $task->update();
            $task->clearUsers($task->id);
            if($assignedUsers){
                $task->assignUsers($task->id, $assignedUsers);
            }
            header("Location: TaskController.php?action=list");
            exit;
        }
        $data = $task->readOne();
        $assigned = $task->getUsers($task->id);
        $projects = $projectModel->readAll();
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
        $tasks = $task->readAllWithUsers();

        include __DIR__ . '/../views/tasks/list.php';
        break;
}
?>
