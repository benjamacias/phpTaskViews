<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="bg-gray-800 text-white p-4 flex justify-between">
    <div>
        <a href="/index.php" class="mr-4 font-bold">Inicio</a>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="/app/views/dashboard.php" class="mr-4">Dashboard</a>
            <a href="/app/controllers/ProjectController.php?action=list" class="mr-4">Proyectos</a>
            <a href="/app/controllers/TaskController.php?action=list" class="mr-4">Tareas</a>
            <?php if($_SESSION['role'] === 'admin'): ?>
                <a href="/app/controllers/AdminController.php?action=list" class="mr-4">Usuarios</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <div>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="/app/controllers/logout.php" class="mr-4">Salir</a>
        <?php else: ?>
            <a href="/login.php" class="mr-4">Login</a>
            <a href="/register.php" class="mr-4">Registro</a>
        <?php endif; ?>
    </div>
</nav>
