<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Usuarios</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 w-screen h-screen overflow-x-hidden m-0 p-0">
<?php include __DIR__ . '/../../layout/header.php'; ?>
<h1 class="text-2xl font-bold mb-4">Usuarios</h1>
<a href="AdminController.php?action=create" class="bg-blue-500 text-white px-4 py-2 rounded">Nuevo usuario</a>
<table class="mt-4 w-full border-collapse border">
    <thead>
        <tr class="bg-gray-200">
            <th class="border p-2">ID</th>
            <th class="border p-2">Nombre</th>
            <th class="border p-2">Email</th>
            <th class="border p-2">Rol</th>
            <th class="border p-2">Valor hora</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($users as $u): ?>
        <tr class="bg-white">
            <td class="border p-2 text-center"><?php echo $u['id']; ?></td>
            <td class="border p-2"><?php echo htmlspecialchars($u['name']); ?></td>
            <td class="border p-2"><?php echo htmlspecialchars($u['email']); ?></td>
            <td class="border p-2"><?php echo htmlspecialchars($u['role']); ?></td>
            <td class="border p-2 text-right"><?php echo $u['hourly_rate']; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<a href="../views/dashboard.php" class="inline-block mt-4 text-blue-600">Volver</a>
</body>
</html>
