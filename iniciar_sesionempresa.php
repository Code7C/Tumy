<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión Empresa</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #1c1c1c;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #2a2a2a;
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            width: 400px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.7);
        }

        .login-container h1 {
            margin-bottom: 30px;
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: none;
            background-color: #444;
            color: white;
        }

        .login-container button {
            background-color: #0066cc;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .login-container button:hover {
            background-color: #005bb5;
        }

        .login-container .register {
            display: block;
            color: #ccc;
            text-decoration: none;
            margin-top: 20px;
        }

        .login-container .register:hover {
            color: white;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Iniciar Sesión Empresa</h1>
        <form action="validar_empresa.php" method="POST">
            <input type="email" name="email" placeholder="Correo Electrónico de la Empresa" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <br>
            <button type="submit">Iniciar Sesión</button>
        </form>
        <a href="register_empresa.php" class="register">¿No tienes cuenta? Regístrate como Empresa</a>
    </div>
</body>
</html>
