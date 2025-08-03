
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nueva Tarea</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

</head>
<body class="p-4 bg-gray-50">
<?php include __DIR__ . '/../layout/header.php'; ?>
<h1 class="text-2xl font-bold mb-4">Nueva Tarea</h1>
<form action="TaskController.php?action=create" method="POST" class="space-y-4">
    <div>
        <label class="block mb-1">Proyecto:</label>
        <select name="project_id" required class="border p-2 w-full rounded">
            <?php foreach($projects as $p): ?>
                <option value="<?php echo $p['id']; ?>"><?php echo htmlspecialchars($p['name']); ?></option>
            <?php endforeach; ?>
        </select>

<form action="TaskController.php?action=create" method="POST" class="space-y-4">
    <div>
    </div>
    <div>
        <label class="block mb-1">Descripción:</label>
        <input type="text" name="description" required class="border p-2 w-full rounded">
    </div>
    <div>
        <label class="block mb-1">Asignar a:</label>
        <select id="members" name="assigned_to[]" multiple class="border p-2 w-full rounded">
            <?php foreach($users as $u): ?>
                <option value="<?php echo $u['id']; ?>"><?php echo htmlspecialchars($u['name']); ?></option>
            <?php endforeach; ?>
        </select>

    </div>
    <div>
        <label class="block mb-1">Fecha límite:</label>
        <input type="date" name="due_date" required class="border p-2 w-full rounded">

    </div>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar</button>
</form>
<a href="TaskController.php?action=list" class="inline-block mt-4 text-blue-600">Volver</a>
</body>
</html>
<script>
document.addEventListener("DOMContentLoaded", function(){
    new TomSelect("#members",{
        plugins: ['remove_button'],
        placeholder: "Selecciona uno o varios miembros"
    });
});
</script>
