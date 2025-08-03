<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once './config/database.php';
$db = (new Database())->getConnection();

$userId = $_SESSION['user_id'];
// Contar proyectos
$stmt = $db->prepare("SELECT COUNT(*) FROM project_users WHERE user_id = ?");
$stmt->execute([$userId]);
$totalProjects = $stmt->fetchColumn();

// Contar tareas asignadas
$stmt = $db->prepare("SELECT COUNT(*) FROM task_users WHERE user_id = ?");
$stmt->execute([$userId]);
$totalTasks = $stmt->fetchColumn();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 w-screen h-screen overflow-x-hidden m-0 p-0">
<?php include __DIR__ . '/app/views/layout/header.php'; ?>
<div class="container mx-auto p-8">
    <h1 class="text-3xl font-bold mb-6">📊 Panel de Estadísticas</h1>
    <div class="grid grid-cols-2 gap-6">
        <div class="bg-white shadow rounded p-6 text-center">
            <h2 class="text-xl font-semibold">Proyectos asignados</h2>
            <p class="text-4xl text-blue-600 font-bold mt-4"><?php echo $totalProjects; ?></p>
        </div>
        <div class="bg-white shadow rounded p-6 text-center">
            <h2 class="text-xl font-semibold">Tareas asignadas</h2>
            <p class="text-4xl text-green-600 font-bold mt-4"><?php echo $totalTasks; ?></p>
        </div>
    </div>
</div>
</body>
</html>
