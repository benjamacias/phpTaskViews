<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: ../login.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tareas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-4 bg-gray-50">
<h1 class="text-2xl font-bold mb-4">Tareas</h1>
<a href="TaskController.php?action=create" class="bg-blue-500 text-white px-4 py-2 rounded">Nueva tarea</a>
<div class="grid grid-cols-3 gap-4 mt-4">
    <div data-status="enproceso" class="p-4 bg-gray-100 rounded">
        <h2 class="font-semibold mb-2">En proceso</h2>
        <?php foreach($tasks as $t): if($t['status']==='enproceso'): ?>
            <div class="task p-2 mb-2 bg-white rounded shadow" draggable="true" data-id="<?php echo $t['id']; ?>">
                <p class="font-medium"><?php echo htmlspecialchars($t['description']); ?></p>
                <p class="text-sm text-gray-600">
                    <?php
                        $u = array_filter($users, fn($usr) => $usr['id'] == $t['assigned_to']);
                        $u = array_shift($u);
                        echo htmlspecialchars($u['name'] ?? '');
                    ?>
                </p>
                <p class="text-sm">
                    <?php echo $t['due_date']; ?>
                    <?php if(strtotime($t['due_date']) < strtotime('+2 day')): ?>
                        <strong class="text-red-600">¡Pronto a vencer!</strong>
                    <?php endif; ?>
                </p>
                <a href="TaskController.php?action=edit&id=<?php echo $t['id']; ?>" class="text-blue-600 text-sm">Editar</a>
            </div>
        <?php endif; endforeach; ?>
    </div>
    <div data-status="completado" class="p-4 bg-gray-100 rounded">
        <h2 class="font-semibold mb-2">Completado</h2>
        <?php foreach($tasks as $t): if($t['status']==='completado'): ?>
            <div class="task p-2 mb-2 bg-white rounded shadow" draggable="true" data-id="<?php echo $t['id']; ?>">
                <p class="font-medium"><?php echo htmlspecialchars($t['description']); ?></p>
                <p class="text-sm text-gray-600">
                    <?php
                        $u = array_filter($users, fn($usr) => $usr['id'] == $t['assigned_to']);
                        $u = array_shift($u);
                        echo htmlspecialchars($u['name'] ?? '');
                    ?>
                </p>
                <p class="text-sm"><?php echo $t['due_date']; ?></p>
                <a href="TaskController.php?action=edit&id=<?php echo $t['id']; ?>" class="text-blue-600 text-sm">Editar</a>
            </div>
        <?php endif; endforeach; ?>
    </div>
    <div data-status="cancelado" class="p-4 bg-gray-100 rounded">
        <h2 class="font-semibold mb-2">Cancelado</h2>
        <?php foreach($tasks as $t): if($t['status']==='cancelado'): ?>
            <div class="task p-2 mb-2 bg-white rounded shadow" draggable="true" data-id="<?php echo $t['id']; ?>">
                <p class="font-medium"><?php echo htmlspecialchars($t['description']); ?></p>
                <p class="text-sm text-gray-600">
                    <?php
                        $u = array_filter($users, fn($usr) => $usr['id'] == $t['assigned_to']);
                        $u = array_shift($u);
                        echo htmlspecialchars($u['name'] ?? '');
                    ?>
                </p>
                <p class="text-sm"><?php echo $t['due_date']; ?></p>
              <a href="TaskController.php?action=edit&id=<?php echo $t['id']; ?>" class="text-blue-600 text-sm">Editar</a>
            </div>
        <?php endif; endforeach; ?>
    </div>
</div>
<a href="../views/dashboard.php" class="inline-block mt-4 text-blue-600">Volver</a>
<script>
const tasks = document.querySelectorAll('.task');
const columns = document.querySelectorAll('[data-status]');

tasks.forEach(task => {
  task.addEventListener('dragstart', e => {
    e.dataTransfer.setData('text/plain', task.dataset.id);
  });
});

columns.forEach(col => {
  col.addEventListener('dragover', e => e.preventDefault());
  col.addEventListener('drop', e => {
    e.preventDefault();
    const id = e.dataTransfer.getData('text/plain');
    const el = document.querySelector('.task[data-id="' + id + '"]');
    if (el && col !== el.parentNode) {
      col.appendChild(el);
      updateStatus(id, col.dataset.status);
    }
  });
});

function updateStatus(id, status){
  fetch('TaskController.php?action=updateStatus', {

    method: 'POST',
    headers: {'Content-Type':'application/x-www-form-urlencoded'},
    body: 'id=' + encodeURIComponent(id) + '&status=' + encodeURIComponent(status)
  });
}
</script>
</body>
</html>
