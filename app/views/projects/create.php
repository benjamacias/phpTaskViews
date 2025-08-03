
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nuevo Proyecto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
</head>
<body class="bg-gray-50 w-screen h-screen overflow-x-hidden m-0 p-0">
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
        <select id="members" name="members[]" multiple class="border p-2 w-full rounded">
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
<script>
document.addEventListener("DOMContentLoaded", function(){
    new TomSelect("#members",{
        plugins: ['remove_button'],
        placeholder: "Selecciona uno o varios miembros"
    });
});
</script>