<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Project.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Task.php';

$db = (new Database())->getConnection();
$project = new Project($db);
$userModel = new User($db);
$taskModel = new Task($db);

$action = $_GET['action'] ?? 'list';

if($_SESSION['role'] !== 'admin' && in_array($action, ['create','edit','delete'])){
    header('Location: ProjectController.php?action=list');
    exit;
}

switch ($action) {
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $project->name = $_POST['name'];
            $project->description = $_POST['description'];
            $project->start_date = $_POST['start_date'];
            $project->end_date = $_POST['end_date'];
            $project->leader_id = $_SESSION['user_id'];
            $newId = $project->create();
            $members = $_POST['members'] ?? [];
            if($newId && $members){
                $project->assignUsers($newId, $members);
            }
            header("Location: ProjectController.php?action=list");
            exit;
        }
        $users = $userModel->readAll();
        include __DIR__ . '/../views/projects/create.php';
        break;

    case 'edit':
        $project->id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $project->name = $_POST['name'];
            $project->description = $_POST['description'];
            $project->start_date = $_POST['start_date'];
            $project->end_date = $_POST['end_date'];
            $project->leader_id = $_SESSION['user_id'];
            $project->update();
            $members = $_POST['members'] ?? [];
            $project->clearUsers($project->id);
            if($members){
                $project->assignUsers($project->id, $members);
            }
            header("Location: ProjectController.php?action=list");
            exit;
        }
        $data = $project->readOne();
        $currentMembers = $project->getUsers($project->id);
        $users = $userModel->readAll();
        include __DIR__ . '/../views/projects/edit.php';
        break;

    case 'delete':
        $project->id = $_GET['id'];
        $project->delete();
        header("Location: ProjectController.php?action=list");
        exit;

    default:
        if($_SESSION['role'] === 'admin'){
            $projects = $project->readAll();
        } else {
            $projects = $project->readByUser($_SESSION['user_id']);
        }
        foreach($projects as &$p){
            $p['total_hours'] = $taskModel->sumHoursByProject($p['id']);
        }
        include __DIR__ . '/../views/projects/list.php';
        break;
}
?>
