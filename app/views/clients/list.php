<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Clientes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 w-screen h-screen overflow-x-hidden m-0 p-0">
<?php include __DIR__ . '/../layout/header.php'; ?>
<h1 class="text-2xl font-bold mb-4">Clientes</h1>
<a href="ClientController.php?action=create" class="bg-blue-500 text-white px-4 py-2 rounded">Nuevo cliente</a>
<table class="mt-4 w-full border-collapse border">
    <thead>
        <tr class="bg-gray-200">
            <th class="border p-2">ID</th>
            <th class="border p-2">Nombre</th>
            <th class="border p-2">Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($clients as $c): ?>
        <tr class="bg-white">
            <td class="border p-2 text-center"><?php echo $c['id']; ?></td>
            <td class="border p-2"><?php echo htmlspecialchars($c['name']); ?></td>
            <td class="border p-2">
                <a href="ClientController.php?action=view&id=<?php echo $c['id']; ?>" class="text-blue-600">Ver</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
