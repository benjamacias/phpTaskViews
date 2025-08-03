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
    <title>Nuevo Proyecto</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-4 bg-gray-50">
<?php include __DIR__ . '/../layout/header.php'; ?>

<h1 class="text-2xl font-bold mb-4">Nuevo Proyecto</h1>
<form action="ProjectController.php?action=create" method="POST" class="space-y-4">
    <div>
        <label class="block mb-1">Nombre:</label>
        <input type="text" name="name" required class="border p-2 w-full rounded">
    </div>
    <div>
        <label class="block mb-1">Descripción:</label>
        <input type="text" name="description" required class="border p-2 w-full rounded">
    </div>
    <div>
        <label class="block mb-1">Fecha inicio:</label>
        <input type="date" name="start_date" required class="border p-2 w-full rounded">
    </div>
    <div>
        <label class="block mb-1">Fecha fin:</label>
        <input type="date" name="end_date" required class="border p-2 w-full rounded">
    </div>
    <div>
        <label class="block mb-1">Miembros:</label>
        <select name="members[]" multiple class="border p-2 w-full rounded h-32">
            <?php foreach($users as $u): ?>
                <option value="<?php echo $u['id']; ?>"><?php echo htmlspecialchars($u['name']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar</button>
</form>
<a href="ProjectController.php?action=list" class="inline-block mt-4 text-blue-600">Volver</a>
</body>
</html>
