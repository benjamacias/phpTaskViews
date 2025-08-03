<?php
session_start();
if(isset($_SESSION['user_id'])){
    header("Location: app/views/dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Registro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
<?php include __DIR__ . '/app/views/layout/header.php'; ?>
<div class="flex items-center justify-center h-screen">
    <form action="app/controllers/RegisterController.php" method="POST" class="bg-white p-6 rounded shadow w-80 space-y-4">
        <h1 class="text-xl font-bold text-center">Registrarse</h1>
        <input type="text" name="name" placeholder="Nombre" required class="border p-2 w-full rounded">
        <input type="email" name="email" placeholder="Email" required class="border p-2 w-full rounded">
        <input type="password" name="password" placeholder="Contraseña" required class="border p-2 w-full rounded">
        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded">Crear cuenta</button>
    </form>
</div>
</body>
</html>
