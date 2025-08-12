<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tags del usuario</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 w-screen h-screen overflow-x-hidden m-0 p-0">
<?php include __DIR__ . '/../../layout/header.php'; ?>
<h1 class="text-2xl font-bold mb-4">Tags de Usuario</h1>
<form action="AdminController.php?action=user_tags" method="POST" class="bg-white p-4 shadow rounded">
    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($userId); ?>">
    <?php foreach($tags as $t): ?>
        <div class="mb-2">
            <label>
                <input type="checkbox" name="tags[]" value="<?php echo $t['id']; ?>" <?php echo in_array($t['id'], $assignedIds) ? 'checked' : ''; ?>>
                <?php echo htmlspecialchars($t['name']); ?> (<?php echo $t['operation']; ?> <?php echo $t['mode']; ?>)
            </label>
        </div>
    <?php endforeach; ?>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar</button>
</form>
<a href="AdminController.php?action=list" class="inline-block mt-4 text-blue-600">Volver</a>
</body>
</html>
