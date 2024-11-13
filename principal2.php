<?php
session_start(); // Iniciar la sesión
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TUMY</title>
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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

        /* Estilos de fondo y fuentes */
        body {
            font-family: Arial, sans-serif;
            color: white;
            display: flex;
            flex-direction: column;
            margin: 0;
            padding: 0;
        }


        /* Barra superior */
        .navbar {
            width: calc(100% - 90px);
            margin-left: 90px;
            padding: 30px;
            background-color: rgba(202, 255, 191, 0.9);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            top: 0;
            z-index: 1;
        }

        .navbar h1 {
            color: #333;
            font-size: 24px;
        }

        .navbar .search-container {
            position: relative;
        }

        .search-container input[type="text"] {
            width: 300px;
            padding: 8px;
            border-radius: 5px;
            border: none;
            background-color: #2a2a2a;
            color: white;
        }

        .navbar .session-links {
            display: flex;
            gap: 10px;
        }

        .boton {
            padding: 8px 15px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            color: #EEE1C6;
            background-color: #63BD6D;
        }

        .boton:hover {
            background-color: #32CD32;
        }

        /* Estilo para la barra de búsqueda */
        .search-container {
            position: relative;
        }

        #search-input {
            padding: 8px;
            border-radius: 5px;
            border: 2px;
            width: 300px;
            background-color: white;
            color: #EEE1C6;
            cursor: pointer;
        }

        .search-box {
            display: none; /* Inicialmente oculto */
            position: absolute;
            top: 60px; /* Ajusta según la altura de la barra de navegación */
            left: 0;
            width: 300px;
            background-color: #caffbf;
            border-radius: 5px;
            padding: 10px;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        #search-term {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: none;
            margin-bottom: 10px;
        }

        .location-container,
        .keywords-container {
            margin-bottom: 10px;
            color: #EEE1C6;
        }

        .keyword {
            background-color: #63BD6D;
            color: #EEE1C6;
            padding: 5px;
            border-radius: 5px;
            margin: 5px 0;
            cursor: pointer;
        }

        .keyword:hover {
            background-color: #63BD6D;
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

        
        /* Contenedor de tarjetas */
        .main-content {
            width: calc(100% - 150px);
            margin: 100px auto 20px auto; /* Separar del navbar y sidebar */
            padding: 40px;
            display: flex;
            flex-wrap: wrap;
            gap: 50px;
            z-index: 1;
        }

        /* Tarjetas de publicaciones */
        .post {
            width: 290px;
            background-color: rgba(34, 34, 34, 0.8);
            border-radius: 05px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            transition: transform 0.2s;
        }

        .post:hover {
            transform: scale(1.05);
        }

        .post img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .post-content {
            padding: 15px;
            color: #EEE1C6;
        }

        .post h2 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .post p {
            font-size: 14px;
            color: #999;
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

    <!-- Video de fondo -->
    <div class="video-background">
        <video autoplay loop muted>
            <source src="ft/fd2.mp4" type="video/mp4">
            Tu navegador no soporta el video de fondo.
        </video>
    </div>

    <!-- Barra lateral izquierda -->
    <div class="sidebar">
        <a href="principal2.php"><img src="ft/hogar.png" onclick="handleButtonClick(this)">Inicio</a>
        <a href="iniciar_sesion.html"><img src="ft/sesion.png">Iniciar Sesion</a>
        <a href="perfil.php"><img src="ft/usuario.png">Perfil</a>
        <a href="proyectos.php"><img src="ft/ayudar.png" >Voluntariados</a>
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

    <!-- Barra superior -->
    <div class="navbar">
        <h1>TUMY</h1>
        <div class="search-container">
            <input type="text" id="search-input" placeholder="Buscar en TUMY" onclick="toggleSearchBox()" readonly>
            
            <div id="search-box" class="search-box">
                <input type="text" id="search-term" placeholder="Escribe para buscar..." oninput="filterResults()">
                <div class="location-container">
                    <label for="location">Cambiar ubicación:</label>
                    <select id="location">
                        <option value="ubicacion1">Ubicación 1</option>
                        <option value="ubicacion2">Ubicación 2</option>
                        <option value="ubicacion3">Ubicación 3</option>
                    </select>
                </div>
                <div class="keywords-container">
                    <label>Palabras clave:</label>
                    <div id="keywords">
                        <div class="keyword" onclick="selectKeyword('Keyword 1')">Keyword 1</div>
                        <div class="keyword" onclick="selectKeyword('Keyword 2')">Keyword 2</div>
                        <div class="keyword" onclick="selectKeyword('Keyword 3')">Keyword 3</div>
                    </div>
                </div>
            </div>
        </div>

            

        <!-- Mostrar el perfil o el enlace a iniciar sesión según el tipo de sesión -->
                        <?php if (isset($_SESSION['nombre_usuario'])): ?>
                            <a href="perfil.php" class="boton" >Perfil (<?php echo $_SESSION['nombre_usuario']; ?>)</a><br>
                            <a href="cerrar_sesion.php" class="boton">Cerrar Sesión</a><br>
                        <?php elseif (isset($_SESSION['nombre_organizacion'])): ?>
                            <a href="perfil-empresa.php">Perfil (<?php echo $_SESSION['nombre_organizacion']; ?>)</a>
                            <a href="cerrar_sesion.php">Cerrar Sesión</a><br>
                        <?php else: ?>
                            <a href="iniciar_sesion.html" class="boton">Iniciar Sesión</a>
                        <?php endif; ?>

    </div>

    <!-- Contenido principal con tarjetas -->
    <div class="main-content">
        <!-- Ejemplo de tarjeta de publicación -->
        <div class="post">
            <div class="post-content">
                <h2>Proyecto 1</h2>
                <p>Descripción breve del proyecto de voluntariado.</p><br>
                <a href="proyectos.php" class="boton" onclick="handleButtonClick(this)">Ver más</a>
            </div>
        </div><br>

        <div class="post">
            <div class="post-content">
                <h2>Proyecto 2</h2>
                <p>Descripción breve del proyecto de voluntariado.</p><br>
                <a href="proyectos.php" class="boton" onclick="handleButtonClick(this)">Ver más</a>
            </div>
        </div>
    </div>

</body>
</html>
