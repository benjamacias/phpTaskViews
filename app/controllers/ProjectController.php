<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Project.php';

$db = (new Database())->getConnection();
$project = new Project($db);

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $project->name = $_POST['name'];
            $project->description = $_POST['description'];
            $project->leader_id = $_SESSION['user_id'];
            $project->start_date = $_POST['start_date'];
            $project->end_date = $_POST['end_date'];
            $project->create();
            header("Location: ProjectController.php?action=list");
            exit;
        }
        include __DIR__ . '/../views/projects/create.php';
        break;

    case 'edit':
        $project->id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $project->name = $_POST['name'];
            $project->description = $_POST['description'];
            $project->leader_id = $_SESSION['user_id'];
            $project->start_date = $_POST['start_date'];
            $project->end_date = $_POST['end_date'];
            $project->update();
            header("Location: ProjectController.php?action=list");
            exit;
        }
        $data = $project->readOne();
        include __DIR__ . '/../views/projects/edit.php';
        break;

    case 'delete':
        $project->id = $_GET['id'];
        $project->delete();
        header("Location: ProjectController.php?action=list");
        exit;

    default:
        $projects = $project->readAll();
        include __DIR__ . '/../views/projects/list.php';
        break;
}
?>
