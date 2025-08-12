<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nuevo Cliente</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 w-screen h-screen overflow-x-hidden m-0 p-0">
<?php include __DIR__ . '/../layout/header.php'; ?>
<h1 class="text-2xl font-bold mb-4">Nuevo Cliente</h1>
<form method="POST" action="ClientController.php?action=create" class="space-y-4">
    <input type="text" name="name" placeholder="Nombre" required class="border p-2 w-full rounded">
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar</button>
</form>
</body>
</html>
