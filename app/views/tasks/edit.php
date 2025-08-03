
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
    <title>Editar Tarea</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-4 bg-gray-50">
<?php include __DIR__ . '/../layout/header.php'; ?>
<h1 class="text-2xl font-bold mb-4">Editar Tarea</h1>
<form action="TaskController.php?action=edit&id=<?php echo $data['id']; ?>" method="POST" class="space-y-4">
    <div>
        <label class="block mb-1">Proyecto:</label>
        <select name="project_id" required class="border p-2 w-full rounded">
            <?php foreach($projects as $p): ?>
                <option value="<?php echo $p['id']; ?>" <?php echo $p['id']==$data['project_id']?'selected':''; ?>><?php echo htmlspecialchars($p['name']); ?></option>
            <?php endforeach; ?>
        </select>

<h1 class="text-2xl font-bold mb-4">Editar Tarea</h1>
<form action="TaskController.php?action=edit&id=<?php echo $data['id']; ?>" method="POST" class="space-y-4">
    <div>
        <label class="block mb-1">Proyecto ID:</label>
        <input type="number" name="project_id" value="<?php echo $data['project_id']; ?>" required class="border p-2 w-full rounded">
    </div>
    <div>
        <label class="block mb-1">Descripción:</label>
        <input type="text" name="description" value="<?php echo htmlspecialchars($data['description']); ?>" required class="border p-2 w-full rounded">
    </div>
    <div>
        <label class="block mb-1">Asignar a:</label>
        <select name="assigned_to[]" multiple class="border p-2 w-full rounded h-32">
            <?php foreach($users as $u): ?>
                <option value="<?php echo $u['id']; ?>" <?php echo in_array($u['id'],$assigned)?'selected':''; ?>><?php echo htmlspecialchars($u['name']); ?></option>

        <select name="assigned_to" class="border p-2 w-full rounded">
            <?php foreach($users as $u): ?>
                <option value="<?php echo $u['id']; ?>" <?php echo $u['id']==$data['assigned_to']?'selected':''; ?>><?php echo htmlspecialchars($u['name']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label class="block mb-1">Fecha límite:</label>
        <input type="date" name="due_date" value="<?php echo $data['due_date']; ?>" required class="border p-2 w-full rounded">
    </div>
    <div>
        <label class="block mb-1">Estado:</label>
        <select name="status" class="border p-2 w-full rounded">
            <option value="enproceso" <?php echo $data['status']=='enproceso'?'selected':''; ?>>En proceso</option>
            <option value="completado" <?php echo $data['status']=='completado'?'selected':''; ?>>Completado</option>
            <option value="cancelado" <?php echo $data['status']=='cancelado'?'selected':''; ?>>Cancelado</option>
        </select>
    </div>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar</button>
</form>
<a href="TaskController.php?action=list" class="inline-block mt-4 text-blue-600">Volver</a>
</body>
</html>
