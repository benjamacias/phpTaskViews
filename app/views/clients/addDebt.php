<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nueva Deuda</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 w-screen h-screen overflow-x-hidden m-0 p-0">
<?php include __DIR__ . '/../layout/header.php'; ?>
<h1 class="text-2xl font-bold mb-4">Nueva Deuda</h1>
<form method="POST" action="ClientController.php?action=addDebt&client_id=<?php echo $client_id; ?>" class="space-y-4">
    <input type="text" name="title" placeholder="Título" required class="border p-2 w-full rounded">
    <textarea name="description" placeholder="Descripción" required class="border p-2 w-full rounded"></textarea>
    <select name="project_id" class="border p-2 w-full rounded" required>
        <?php foreach($projects as $p): ?>
        <option value="<?php echo $p['id']; ?>"><?php echo htmlspecialchars($p['name']); ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar</button>
</form>
</body>
</html>
