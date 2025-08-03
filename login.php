<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 w-screen h-screen overflow-x-hidden m-0 p-0">
<?php include __DIR__ . '/app/views/layout/header.php'; ?>
<div class="flex items-center justify-center h-screen">
    <form action="app/controllers/AuthController.php" method="POST" class="bg-white p-6 rounded shadow w-80 space-y-4">
        <h1 class="text-xl font-bold text-center">Iniciar sesi&oacute;n</h1>
        <input type="email" name="email" placeholder="Email" required class="border p-2 w-full rounded">
        <input type="password" name="password" placeholder="Contrase&ntilde;a" required class="border p-2 w-full rounded">
        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded">Ingresar</button>
        <a href="register.php" class="block text-center text-blue-600">Crear cuenta</a>
    </form>
</div>
</body>
</html>
