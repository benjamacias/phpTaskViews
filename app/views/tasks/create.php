<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: ../login.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nueva Tarea</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-4 bg-gray-50">
<h1 class="text-2xl font-bold mb-4">Nueva Tarea</h1>
<form action="../../controllers/TaskController.php?action=create" method="POST" class="space-y-4">
    <div>
        <label class="block mb-1">Proyecto ID:</label>
        <input type="number" name="project_id" required class="border p-2 w-full rounded">
    </div>
    <div>
        <label class="block mb-1">Descripción:</label>
        <input type="text" name="description" required class="border p-2 w-full rounded">
    </div>
    <div>
        <label class="block mb-1">Asignar a:</label>
        <select name="assigned_to" class="border p-2 w-full rounded">
            <?php foreach($users as $u): ?>
                <option value="<?php echo $u['id']; ?>"><?php echo htmlspecialchars($u['name']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label class="block mb-1">Fecha límite:</label>
        <input type="datetime-local" name="due_date" required class="border p-2 w-full rounded">
    </div>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar</button>
</form>
<a href="../../controllers/TaskController.php?action=list" class="inline-block mt-4 text-blue-600">Volver</a>
</body>
</html>
