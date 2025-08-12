<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="bg-gradient-to-r from-blue-700 to-blue-500 text-white px-6 py-4 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo / Inicio -->
        <div class="flex items-center space-x-4">
            <a href="/index.php" class="text-2xl font-extrabold tracking-wide hover:text-gray-200 transition">
                🚀 Gestor
            </a>
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="/app/views/dashboard.php" class="hover:text-gray-200 transition">Dashboard</a>
                <a href="/app/controllers/ProjectController.php?action=list" class="hover:text-gray-200 transition">Proyectos</a>
                <a href="/app/controllers/TaskController.php?action=list" class="hover:text-gray-200 transition">Tareas</a>
                <?php if(in_array($_SESSION['role'], ['admin','leader'])): ?>
                    <a href="/app/controllers/ClientController.php?action=list" class="hover:text-gray-200 transition">Clientes</a>
                <?php endif; ?>
                <?php if($_SESSION['role'] === 'admin'): ?>
                    <a href="/app/controllers/AdminController.php?action=list" class="hover:text-gray-200 transition">Usuarios</a>
                    <a href="/app/controllers/AdminController.php?action=salary" class="hover:text-gray-200 transition">Sueldos</a>
                    <a href="/app/controllers/AdminController.php?action=tags" class="hover:text-gray-200 transition">Tags</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <!-- User menu -->
        <div class="flex items-center space-x-4 relative">
            <?php if(isset($_SESSION['user_id'])): ?>
                <button id="userMenuBtn" class="flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 px-3 py-2 rounded-lg shadow transition">
                    <span>👤 <?php echo $_SESSION['role'] === 'admin' ? 'Admin' : 'Usuario'; ?></span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <!-- Dropdown -->
                <div id="userDropdown" class="absolute right-0 top-12 w-40 bg-white text-gray-700 rounded-lg shadow-lg hidden">
                    <a href="/app/views/dashboard.php" class="block px-4 py-2 hover:bg-gray-100">Perfil</a>
                    <a href="/app/controllers/logout.php" class="block px-4 py-2 hover:bg-gray-100">Cerrar sesión</a>
                </div>
            <?php else: ?>
                <a href="/login.php" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg shadow transition">Login</a>
                <a href="/register.php" class="bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded-lg shadow transition">Registro</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const btn = document.getElementById("userMenuBtn");
    const dropdown = document.getElementById("userDropdown");

    if (btn) {
        btn.addEventListener("click", () => {
            dropdown.classList.toggle("hidden");
        });

        // Cerrar si hace clic fuera del menú
        document.addEventListener("click", (event) => {
            if (!btn.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add("hidden");
            }
        });
    }
});
</script>
