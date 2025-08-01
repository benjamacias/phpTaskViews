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
    <title>Gestor de Proyectos</title>
    <meta charset="utf-8">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-50">
    <div class="text-center space-y-4">
        <h1 class="text-3xl font-bold">Bienvenido al Gestor de Proyectos</h1>
        <p class="text-gray-700">Sistema sencillo para administrar proyectos y tareas.</p>
        <a href="login.php" class="bg-blue-500 text-white px-4 py-2 rounded">Iniciar sesión</a>
        <a href="register.php" class="bg-gray-500 text-white px-4 py-2 rounded">Registrarse</a>
    </div>
</body>
</html>
