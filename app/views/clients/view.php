<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cliente</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 w-screen h-screen overflow-x-hidden m-0 p-0">
<?php include __DIR__ . '/../layout/header.php'; ?>
<h1 class="text-2xl font-bold mb-4">Cliente: <?php echo htmlspecialchars($data['name']); ?></h1>
<a href="ClientController.php?action=addDebt&client_id=<?php echo $data['id']; ?>" class="bg-blue-500 text-white px-4 py-2 rounded">Agregar Deuda</a>
<table class="mt-4 w-full border-collapse border">
    <thead>
        <tr class="bg-gray-200">
            <th class="border p-2">Título</th>
            <th class="border p-2">Descripción</th>
            <th class="border p-2">Proyecto</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($debts as $d): ?>
        <tr class="bg-white">
            <td class="border p-2"><?php echo htmlspecialchars($d['title']); ?></td>
            <td class="border p-2"><?php echo htmlspecialchars($d['description']); ?></td>
            <td class="border p-2"><?php echo htmlspecialchars($d['project_name']); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
