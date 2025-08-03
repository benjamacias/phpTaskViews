<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Gestor de Proyectos</title>
    <meta charset="utf-8">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-blue-100 h-screen flex items-center justify-center">
    
    <div class="bg-white shadow-xl rounded-2xl p-10 w-full max-w-lg text-center">
        <h1 class="text-4xl font-extrabold text-blue-600 mb-4">🚀 Bienvenido</h1>
        <p class="text-gray-600 text-lg mb-6">
            Administra tus proyectos y tareas de forma simple y eficiente.
        </p>

        <div class="flex flex-col space-y-4">
            <a href="login.php" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg font-medium shadow transition">
                Iniciar sesión
            </a>
            <a href="register.php" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-3 rounded-lg font-medium shadow transition">
                Registrarse
            </a>
        </div>
    </div>
</body>
</html>
