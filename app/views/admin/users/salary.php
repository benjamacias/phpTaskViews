<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sueldos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 w-screen h-screen overflow-x-hidden m-0 p-0">
<?php include __DIR__ . '/../../layout/header.php'; ?>
<h1 class="text-2xl font-bold mb-4">Calculadora de Sueldos</h1>
<table class="mt-4 w-full border-collapse border">
    <thead>
        <tr class="bg-gray-200">
            <th class="border p-2">Nombre</th>
            <th class="border p-2">Valor hora</th>
            <th class="border p-2">Horas asignadas</th>
            <th class="border p-2">Jubilación (%)</th>
            <th class="border p-2">Obra Social (%)</th>
            <th class="border p-2">Sindicato (%)</th>
            <th class="border p-2">Tags</th>

            <th class="border p-2">Sueldo Neto</th>
            <th class="border p-2">Acción</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($employees as $e): ?>
        <tr class="bg-white">
            <form action="AdminController.php?action=salary" method="POST" class="contents">
                <td class="border p-2"><?php echo htmlspecialchars($e['name']); ?></td>
                <td class="border p-2">
                    <input type="hidden" name="user_id" value="<?php echo $e['id']; ?>">
                    <input type="number" step="0.01" name="hourly_rate" value="<?php echo $e['hourly_rate']; ?>" class="border p-1 w-24 rounded">
                </td>
                <td class="border p-2 text-center"><?php echo $e['total_hours']; ?></td>
                <td class="border p-2">
                    <input type="number" step="0.01" name="retirement" value="<?php echo $e['retirement']; ?>" class="border p-1 w-20 rounded">
                </td>
                <td class="border p-2">
                    <input type="number" step="0.01" name="social_security" value="<?php echo $e['social_security']; ?>" class="border p-1 w-20 rounded">
                </td>
                <td class="border p-2">
                    <input type="number" step="0.01" name="union_fee" value="<?php echo $e['union_fee']; ?>" class="border p-1 w-20 rounded">
                </td>
                <td class="border p-2"><?php echo implode(', ', array_map(function($t){ return htmlspecialchars($t['name']); }, $e['tags'] ?? [])); ?></td>

                <td class="border p-2 text-right">$<?php echo number_format($e['salary'], 2); ?></td>
                <td class="border p-2 text-center">
                    <button type="submit" class="text-blue-600">Registrar</button>
                </td>
            </form>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<a href="AdminController.php?action=list" class="inline-block mt-4 text-blue-600">Volver</a>
</body>
</html>
