<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tags</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 w-screen h-screen overflow-x-hidden m-0 p-0">
<?php include __DIR__ . '/../../layout/header.php'; ?>
<h1 class="text-2xl font-bold mb-4">Tags</h1>
<div class="flex space-x-8">
    <div class="w-1/2">
        <h2 class="text-xl font-semibold mb-2"><?php echo $editTag ? 'Editar Tag' : 'Nuevo Tag'; ?></h2>
        <form action="AdminController.php?action=tags" method="POST" class="bg-white p-4 shadow rounded">
            <?php if($editTag): ?>
                <input type="hidden" name="id" value="<?php echo $editTag['id']; ?>">
            <?php endif; ?>
            <div class="mb-2">
                <label class="block">Nombre</label>
                <input type="text" name="name" value="<?php echo $editTag['name'] ?? ''; ?>" class="border p-1 w-full rounded" required>
            </div>
            <div class="mb-2">
                <label class="block">Operación</label>
                <select name="operation" class="border p-1 w-full rounded">
                    <option value="deduction" <?php echo isset($editTag['operation']) && $editTag['operation']=='deduction' ? 'selected' : ''; ?>>Descuento</option>
                    <option value="increase" <?php echo isset($editTag['operation']) && $editTag['operation']=='increase' ? 'selected' : ''; ?>>Aumento</option>
                    <option value="reimbursement" <?php echo isset($editTag['operation']) && $editTag['operation']=='reimbursement' ? 'selected' : ''; ?>>Reintegro</option>
                </select>
            </div>
            <div class="mb-2">
                <label class="block">Tipo</label>
                <select name="mode" class="border p-1 w-full rounded">
                    <option value="percent" <?php echo isset($editTag['mode']) && $editTag['mode']=='percent' ? 'selected' : ''; ?>>Porcentual</option>
                    <option value="static" <?php echo isset($editTag['mode']) && $editTag['mode']=='static' ? 'selected' : ''; ?>>Estático</option>
                </select>
            </div>
            <div class="mb-2">
                <label class="block">Cantidad</label>
                <input type="number" step="0.01" name="amount" value="<?php echo $editTag['amount'] ?? '0'; ?>" class="border p-1 w-full rounded">
            </div>
            <div class="mb-4">
                <label><input type="checkbox" name="auto_remove" <?php echo isset($editTag['auto_remove']) && $editTag['auto_remove'] ? 'checked' : ''; ?>> Auto remover fin de mes</label>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar</button>
        </form>
    </div>
    <div class="w-1/2">
        <h2 class="text-xl font-semibold mb-2">Listado</h2>
        <table class="w-full border-collapse border bg-white shadow">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Nombre</th>
                    <th class="border p-2">Operación</th>
                    <th class="border p-2">Tipo</th>
                    <th class="border p-2">Cantidad</th>
                    <th class="border p-2">Auto remover</th>
                    <th class="border p-2">Acción</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($tags as $t): ?>
                <tr class="bg-white">
                    <td class="border p-2"><?php echo htmlspecialchars($t['name']); ?></td>
                    <td class="border p-2"><?php echo htmlspecialchars($t['operation']); ?></td>
                    <td class="border p-2"><?php echo htmlspecialchars($t['mode']); ?></td>
                    <td class="border p-2 text-right"><?php echo $t['amount']; ?></td>
                    <td class="border p-2 text-center"><?php echo $t['auto_remove'] ? 'Sí' : 'No'; ?></td>
                    <td class="border p-2 text-center">
                        <a href="AdminController.php?action=tags&edit=<?php echo $t['id']; ?>" class="text-blue-600 mr-2">Editar</a>
                        <?php if($t['active']): ?>
                            <a href="AdminController.php?action=tags&deactivate=<?php echo $t['id']; ?>" class="text-red-600">Baja</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<a href="AdminController.php?action=list" class="inline-block mt-4 text-blue-600">Volver</a>
</body>
</html>
