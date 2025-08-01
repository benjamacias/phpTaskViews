<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}
echo "<h1>Bienvenido</h1>";
echo "<a href='../controllers/logout.php'>Cerrar sesión</a>";
?>
<div>
    <a href="create_project.php">Crear Proyecto</a>
    <a href="tasks.php">Ver Tareas</a>
</div>