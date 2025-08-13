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

$customResults = [];
$labels = [];
$data = [];
$viewType = 'table';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = trim($_POST['sql_query'] ?? '');
    $viewType = $_POST['view_type'] ?? 'table';

    if ($sql !== '') {
        if (!preg_match('/^\s*SELECT/i', $sql) || preg_match('/\b(INSERT|UPDATE|DELETE|DROP|ALTER|CREATE|REPLACE|TRUNCATE|MERGE|CALL)\b/i', $sql)) {
            $error = 'Solo se permiten consultas SELECT.';
        } else {
            try {
                $stmt = $db->query($sql);
                $customResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($viewType !== 'table' && !empty($customResults)) {
                    $columns = array_keys($customResults[0]);
                    if (count($columns) < 2) {
                        $error = 'La consulta debe incluir al menos dos columnas para graficar.';
                        $customResults = [];
                    } else {
                        $labels = array_column($customResults, $columns[0]);
                        $data = array_map('floatval', array_column($customResults, $columns[1]));
                    }
                }
            } catch (PDOException $e) {
                $error = 'Consulta inválida: ' . $e->getMessage();
            }
        }
    }
}
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

    <div class="mt-8">
        <h2 class="text-2xl font-semibold mb-4">Consulta personalizada</h2>
        <form method="post" class="mb-4">
            <textarea name="sql_query" rows="3" class="w-full p-2 border rounded" placeholder="Escribe una consulta SELECT"><?php echo htmlspecialchars($_POST['sql_query'] ?? ''); ?></textarea>
            <div class="flex items-center mt-2">
                <label class="mr-2">Visualización:</label>
                <select name="view_type" class="border p-2 rounded">
                    <option value="table" <?php echo $viewType === 'table' ? 'selected' : ''; ?>>Tabla</option>
                    <option value="bar" <?php echo $viewType === 'bar' ? 'selected' : ''; ?>>Barras</option>
                    <option value="line" <?php echo $viewType === 'line' ? 'selected' : ''; ?>>Líneas</option>
                </select>
                <button type="submit" class="ml-auto bg-blue-600 text-white px-4 py-2 rounded">Ejecutar</button>
            </div>
        </form>

        <?php if ($error): ?>
            <p class="text-red-500 mb-4"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <?php if ($customResults): ?>
            <?php if ($viewType === 'table'): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border">
                        <thead>
                            <tr>
                                <?php foreach (array_keys($customResults[0]) as $col): ?>
                                    <th class="px-4 py-2 border-b"><?php echo htmlspecialchars($col); ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($customResults as $row): ?>
                                <tr>
                                    <?php foreach ($row as $cell): ?>
                                        <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($cell); ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <canvas id="customChart"></canvas>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?php if ($customResults && $viewType !== 'table'): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('customChart').getContext('2d');
new Chart(ctx, {
    type: '<?php echo $viewType; ?>',
    data: {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
            label: 'Resultado',
            data: <?php echo json_encode($data); ?>,
            backgroundColor: 'rgba(59,130,246,0.5)',
            borderColor: 'rgba(59,130,246,1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
<?php endif; ?>
</body>
</html>
