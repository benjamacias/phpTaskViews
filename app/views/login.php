<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
<form action="../controllers/AuthController.php" method="POST">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Contraseña" required><br>
    <button type="submit">Ingresar</button>
</form>
</body>
</html>