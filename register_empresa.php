<?php
include 'db.php'; // Conectar a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si es el formulario de registro de empresa
    if (isset($_POST['register_empresa'])) {
        $nombre_organizacion = $_POST['nombre_organizacion'];
        $representante_legal = $_POST['representante_legal'];
        $ubicacion = $_POST['ubicacion'];
        $email = $_POST['email'];
        $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT); // Hashear la contraseña

        // Preparar la consulta SQL
        $sql = "INSERT INTO empresas (nombre_organizacion, representante_legal, ubicacion, email, contrasena) VALUES (?, ?, ?, ?, ?)";
        $stmt = $cnx->prepare($sql);
        $stmt->bind_param("sssss", $nombre_organizacion, $representante_legal, $ubicacion, $email, $contrasena);

        // Ejecutar la consulta y verificar si fue exitosa
        if ($stmt->execute()) {
            echo "Registro de empresa exitoso.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

mysqli_close($cnx); // Cerrar la conexión a la base de datos
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Empresa</title>
    <link rel="stylesheet" href="styles.css"> 
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
            background-image: url("ft/fond.jpg");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #0e0e0e;
            color: #fff;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #2c2c2c; /* Fondo oscuro */
            color: #f4f4f4; /* Color del texto en claro */
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 500px; /* Ancho máximo del contenedor */
            margin: auto; /* Centramos el contenedor */
            padding: 20px;
            background: rgba(202, 255, 191, 0.9); /* Fondo más claro para el contenedor */
            border-radius: 8px; /* Bordes redondeados */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.7); /* Sombra para efecto de profundidad */
        }

        h1 {
            text-align: center; /* Centra el texto del título */
            color: #ffffff; /* Color blanco para el título */
        }

        form {
            display: flex;
            flex-direction: column; /* Organiza los elementos en columnas */
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"] {
            margin-bottom: 15px; /* Espaciado entre campos */
            padding: 10px; /* Espaciado interno de los campos */
            border: none; /* Borde gris oscuro */
            border-radius: 4px; /* Bordes redondeados para los campos */
            font-size: 16px; /* Tamaño de fuente */
            background-color: white; /* Fondo oscuro para los campos */
            color: black; /* Texto claro en los campos */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="date"]:focus {
            border-color: #5cb85c; /* Color del borde al enfocar */
            outline: none; /* Sin contorno */
        }

        button {
            padding: 10px;
            border: none; /* Sin borde */
            border-radius: 4px; /* Bordes redondeados para el botón */
            background-color: #63BD6D; /* Color de fondo del botón */
            color: white; /* Color del texto del botón */
            font-size: 16px; /* Tamaño de fuente del botón */
            cursor: pointer; /* Cambia el cursor al pasar sobre el botón */
        }

        button:hover {
            background-color: #4cae4c; /* Color del botón al pasar el mouse */
        }

        p {
            text-align: center; /* Centra el texto de los mensajes */
            color: red; /* Color del texto del mensaje de error */
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



        .post-buttons button {
            background-color: #444;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.2s ease, transform 0.2s ease; /* Transición para el efecto */
        }

        .post-buttons button:hover {
            background-color: #555;
        }

        .button-clicked {
            background-color: #32CD32; /* Cambia el color temporalmente */
            transform: scale(1.1); /* Aumenta el tamaño temporalmente */
        }

    </style>
</head>
<body>

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


    <script>
            // Función para manejar el clic en los botones
                function handleButtonClick(button) {
                    // Añadir la clase .button-clicked
                    button.classList.add('button-clicked');

                    // Remover la clase después de un breve tiempo
                    setTimeout(function() {
                        button.classList.remove('button-clicked');
                    }, 200); // 200ms para un efecto rápido
                }
            </script>

    <div class="container">
        <h1>Registro de Empresa</h1>
        <form action="" method="POST">
            <input type="text" name="nombre_organizacion" placeholder="Nombre de la Organización" required>
            <input type="text" name="representante_legal" placeholder="Representante Legal" required>
            <input type="text" name="ubicacion" placeholder="Ubicación" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="contrasena" placeholder="Contraseña" required>
            <button type="submit" name="register_empresa" class="boton" onclick="handleButtonClick(this)" onclick="principal2">Registrarse</button>
        </form>
        <?php if (isset($mensaje_empresa)) echo "<p>$mensaje_empresa</p>"; ?>
    </div>
</body>
</html>
