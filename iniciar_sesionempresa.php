<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión Empresa</title>
    <style>

        /* Contenedor del video de fondo */
        .video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
            z-index: -1;
        }

        .video-background video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Barra lateral izquierda */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 90px;
            height: 100vh;
            background-color: rgba(17, 17, 17, 0.9);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
            z-index: 1; /* Asegura que esté por encima del video */
        }

        .sidebar a {
            color: #EEE1C6;
            text-decoration: none;
            margin: 50px 0;
            display: flex;
            align-items: center;
            flex-direction: column;
        }

        .sidebar a img {
            width: 30px;
            height: 30px;
            margin-bottom: 5px;
        }

        .sidebar a:hover {
            color: #63BD6D;
        }
        
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
            background-color:rgba(202, 255, 191, 0.9);
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
            background-color: white;
            color: black;
        }

        .login-container button {
            background-color: #63BD6D;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .login-container button:hover {
            background-color: #32CD32;
        }

        .login-container .register {
            display: block;
            color: black;
            text-decoration: none;
            margin-top: 20px;
        }

        .login-container .register:hover {
            color: white;
        }

        /* Estilo para el botón */
        .boton {
            display: inline-block;
            padding: 10px 25px;
            background-color: #63BD6D; /* Color de fondo del botón */
            color: white; /* Color del texto */
            text-decoration: none; /* Quitar subrayado */
            font-size: 1.2em;
            font-weight: bold;
            border-radius: 5px;
            margin-top: 20px;
            transition: background-color 0.3s ease; /* Animación para el hover */
        }

        .boton:hover {
            background-color: #32CD32; /* Cambia de color cuando se pasa el ratón */
        }


        

    </style>
</head>
<body>

    <!-- Video de fondo -->
    <div class="video-background">
        <video autoplay loop muted>
            <source src="ft/fd2.mp4" type="video/mp4">
            Tu navegador no soporta el video de fondo.
        </video>
    </div>

     <!-- Barra lateral izquierda -->
    <div class="sidebar">
        <a href="principal2.php"><img src="ft/hogar.png" alt="Inicio">Inicio</a>
        <a href="iniciar_sesion.html"><img src="ft/sesion.png" alt="Iniciar Sesión">Iniciar Sesión</a>
        <a href="perfil.php"><img src="ft/usuario.png" alt="Perfil">Perfil</a>
        <a href="proyectos.php"><img src="ft/ayudar.png" alt="Voluntariados">Voluntariados</a>
    </div>

    <div class="login-container">
        <h1>Iniciar Sesión Empresa</h1>
        <form action="validar_empresa.php" method="POST">
            <input type="email" name="email" placeholder="Correo Electrónico de la Empresa" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <br>
            <button type="submit" class="boton">Iniciar Sesión</button>
        </form>
        <a href="register_empresa.php" class="register">¿No tienes cuenta? Regístrate como Empresa</a>
    </div>
</body>
</html>
