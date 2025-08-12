<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Client.php';
require_once __DIR__ . '/../models/Debt.php';
require_once __DIR__ . '/../models/Project.php';

if(!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin','leader'])){
    header("Location: ../views/login.php");
    exit;
}

$db = (new Database())->getConnection();
$client = new Client($db);
$debt = new Debt($db);
$projectModel = new Project($db);

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'create':
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $client->name = $_POST['name'];
            $client->create();
            header("Location: ClientController.php?action=list");
            exit;
        }
        include __DIR__ . '/../views/clients/create.php';
        break;

    case 'view':
        $client->id = $_GET['id'];
        $data = $client->readOne();
        $debts = $debt->readByClient($client->id);
        include __DIR__ . '/../views/clients/view.php';
        break;

    case 'addDebt':
        $client_id = $_GET['client_id'];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $debt->client_id = $client_id;
            $debt->project_id = $_POST['project_id'];
            $debt->title = $_POST['title'];
            $debt->description = $_POST['description'];
            $debt->create();
            header("Location: ClientController.php?action=view&id=" . $client_id);
            exit;
        }
        $projects = $projectModel->readAll();
        include __DIR__ . '/../views/clients/addDebt.php';
        break;

    default:
        $clients = $client->readAll();
        include __DIR__ . '/../views/clients/list.php';
        break;
}
?>
