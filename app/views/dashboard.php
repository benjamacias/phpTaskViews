<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Task.php';

$db = (new Database())->getConnection();
$taskModel = new Task($db);

// Cantidad de tareas a mostrar (por defecto 1)
$limit = isset($_GET['limit']) && is_numeric($_GET['limit']) ? (int)$_GET['limit'] : 1;

$myTasks = $taskModel->readByUser($_SESSION['user_id']);

// Ordenar las tareas por fecha de vencimiento
usort($myTasks, function($a, $b) {
    return strtotime($a['due_date']) - strtotime($b['due_date']);
});

// Tomar solo las próximas N tareas
$tasksToShow = array_slice($myTasks, 0, $limit);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 w-screen h-screen overflow-x-hidden m-0 p-0">

<?php include __DIR__ . '/layout/header.php'; ?>
<h1 class="text-2xl font-bold mb-4">
    Bienvenido, <?php echo $_SESSION['role'] === 'admin' ? 'Administrador' : 'Usuario'; ?>
</h1>

<?php if(count($myTasks) > 0): ?>
    <div class="mb-4 p-4 bg-yellow-100 border-l-4 border-yellow-500 rounded">
        <p class="mb-2">Tienes <strong><?php echo count($myTasks); ?></strong> tareas asignadas.</p>
        <form method="GET" class="mb-3">
            <label for="limit" class="mr-2">Ver próximas</label>
            <select name="limit" id="limit" onchange="this.form.submit()" class="border p-1 rounded">
                <option value="1" <?php echo $limit==1?'selected':''; ?>>1</option>
                <option value="3" <?php echo $limit==3?'selected':''; ?>>3</option>
                <option value="5" <?php echo $limit==5?'selected':''; ?>>5</option>
            </select>
            tareas
        </form>

        <?php foreach($tasksToShow as $t): ?>
            <div class="mb-2 p-2 bg-white rounded shadow">
                <p class="font-semibold"><?php echo htmlspecialchars($t['description']); ?></p>
                <p class="text-sm text-gray-700">
                    Proyecto: <strong><?php echo htmlspecialchars($t['project_name']); ?></strong>
                </p>
                <p class="text-sm">
                    Fecha límite: 
                    <span class="text-red-600 font-bold"><?php echo $t['due_date']; ?></span>
                </p>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 rounded">
        No tienes tareas asignadas. 🎉
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
