<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Proyectos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-4 bg-gray-50">
<h1 class="text-2xl font-bold mb-4">Proyectos</h1>
<a href="ProjectController.php?action=create" class="bg-blue-500 text-white px-4 py-2 rounded">Nuevo proyecto</a>
<table class="mt-4 w-full border-collapse border">
    <thead>
        <tr class="bg-gray-200">
            <th class="border p-2">ID</th>
            <th class="border p-2">Nombre</th>
            <th class="border p-2">Descripción</th>
            <th class="border p-2">Fechas</th>
            <th class="border p-2">Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($projects as $p): ?>
        <tr class="bg-white">
            <td class="border p-2 text-center"><?php echo $p['id']; ?></td>
            <td class="border p-2"><?php echo htmlspecialchars($p['name']); ?></td>
            <td class="border p-2"><?php echo htmlspecialchars($p['description']); ?></td>
            <td class="border p-2"><?php echo $p['start_date']; ?> - <?php echo $p['end_date']; ?></td>
            <td class="border p-2 space-x-2">
                <a href="ProjectController.php?action=edit&id=<?php echo $p['id']; ?>" class="text-blue-600">Editar</a>
                <a href="ProjectController.php?action=delete&id=<?php echo $p['id']; ?>" onclick="return confirm('¿Eliminar?');" class="text-red-600">Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<a href="../views/dashboard.php" class="inline-block mt-4 text-blue-600">Volver</a>
</body>
</html>
