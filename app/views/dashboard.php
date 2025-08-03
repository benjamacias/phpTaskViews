<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Task.php';
$db = (new Database())->getConnection();
$taskModel = new Task($db);
$myTasks = $taskModel->readByUser($_SESSION['user_id']);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6 bg-gray-50">

<?php include __DIR__ . '/layout/header.php'; ?>
<h1 class="text-2xl font-bold mb-4">Bienvenido, <?php echo $_SESSION['role'] === 'admin' ? 'Administrador' : 'Usuario'; ?></h1>
<?php if(count($myTasks) > 0): ?>
    <div class="mb-4 p-2 bg-yellow-100 border-l-4 border-yellow-500">
        Tienes <?php echo count($myTasks); ?> tareas asignadas.
    </div>
<?php endif; ?>
<div class="mt-6 space-x-4">
    <a href="../controllers/ProjectController.php?action=list" class="bg-blue-500 text-white px-4 py-2 rounded">Proyectos</a>
    <a href="../controllers/TaskController.php?action=list" class="bg-blue-500 text-white px-4 py-2 rounded">Tareas</a>
    <?php if($_SESSION['role'] === 'admin'): ?>
        <a href="../controllers/AdminController.php?action=list" class="bg-blue-500 text-white px-4 py-2 rounded">Usuarios</a>
    <?php endif; ?>
</div>
</body>
</html>
