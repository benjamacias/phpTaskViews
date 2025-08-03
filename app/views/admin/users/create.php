<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nuevo Usuario</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 w-screen h-screen overflow-x-hidden m-0 p-0">
<?php include __DIR__ . '/../../layout/header.php'; ?>
<h1 class="text-2xl font-bold mb-4">Nuevo Usuario</h1>
<form action="AdminController.php?action=create" method="POST" class="space-y-4">
    <div>
        <label class="block mb-1">Nombre:</label>
        <input type="text" name="name" required class="border p-2 w-full rounded">
    </div>
    <div>
        <label class="block mb-1">Email:</label>
        <input type="email" name="email" required class="border p-2 w-full rounded">
    </div>
    <div>
        <label class="block mb-1">Contraseña:</label>
        <input type="password" name="password" required class="border p-2 w-full rounded">
    </div>
    <div>
        <label class="block mb-1">Rol:</label>
        <select name="role" class="border p-2 w-full rounded">
            <option value="admin">Administrador</option>
            <option value="programmer">Programador</option>
        </select>
    </div>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar</button>
</form>
<a href="AdminController.php?action=list" class="inline-block mt-4 text-blue-600">Volver</a>
</body>
</html>
