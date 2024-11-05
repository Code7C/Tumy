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
        /* Estilos generales */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #1c1c1c;
            color: white;
        }

        /* Barra superior */
        .navbar {
            background-color: #0c0c0c;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h1 {
            color: white;
            font-size: 24px;
            margin-right: 20px;
        }

        .navbar input[type="search"] {
            width: 400px;
            padding: 10px;
            border-radius: 5px;
            border: none;
            background-color: #2a2a2a;
            color: white;
        }

        .navbar input[type="search"]::placeholder {
            color: #ccc;
        }

        .navbar button {
            background-color: #ff5f00;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        /* Estilo para la barra de búsqueda */
        .search-container {
            position: relative;
        }

        #search-input {
            padding: 8px;
            border-radius: 5px;
            border: none;
            width: 300px;
            background-color: #444;
            color: white;
            cursor: pointer;
        }

        .search-box {
            display: none; /* Inicialmente oculto */
            position: absolute;
            top: 60px; /* Ajusta según la altura de la barra de navegación */
            left: 0;
            width: 300px;
            background-color: #2a2a2a;
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
            color: white;
        }

        .keyword {
            background-color: #ff5f00;
            color: white;
            padding: 5px;
            border-radius: 5px;
            margin: 5px 0;
            cursor: pointer;
        }

        .keyword:hover {
            background-color: #e55c00;
        }


        /* Barra lateral izquierda */
        .sidebar {
            position: fixed;
            top: 60px;
            left: 0;
            width: 20%;
            background-color: #111111;
            padding: 30px;
            height: 100vh;
        }

        .sidebar h1 {
            font-size: 22px;
            margin-bottom: 20px;
        }

        .sidebar p {
            font-size: 16px;
            color: #ccc;
            margin-top: 20px;
        }

        /* Contenido principal */
        .main-content {
            margin-left: 22%;
            margin-right: 22%;
            padding: 30px;
        }

        .post {
            background-color: #2a2a2a;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        .post-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .post-header h2 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .post-header p {
            font-size: 14px;
            color: #ccc;
        }

        .post-header button {
            background-color: #0066cc;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .post-content {
            margin-bottom: 20px;
            font-size: 16px;
        }

        .post-buttons {
            display: flex;
            gap: 15px;
        }

        .post-buttons button {
            background-color: #444;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .post-buttons button:hover {
            background-color: #555;
        }

        /* Barra lateral derecha */
        .right-sidebar {
            position: fixed;
            top: 60px;
            right: 0;
            width: 20%;
            background-color: #111111;
            height: 100vh;
            padding: 30px;
        }

        .right-sidebar h2 {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .right-sidebar .user-info {
            background-color: #2a2a2a;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
        }

        .right-sidebar .user-info p {
            font-size: 16px;
            color: #ccc;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <script>
        function toggleSearchBox() {
            const searchBox = document.getElementById("search-box");
            searchBox.style.display = searchBox.style.display === "block" ? "none" : "block";
            document.getElementById("search-term").focus(); // Enfoca el input de búsqueda
        }

        function filterResults() {
            const input = document.getElementById("search-term").value.toLowerCase();
            const keywords = document.querySelectorAll(".keyword");

            keywords.forEach(keyword => {
                if (keyword.innerText.toLowerCase().includes(input)) {
                    keyword.style.display = "block"; // Muestra las palabras clave que coinciden
                } else {
                    keyword.style.display = "none"; // Oculta las palabras clave que no coinciden
                }
            });
        }

        function selectKeyword(keyword) {
            document.getElementById("search-term").value = keyword; // Establece el valor del input
            toggleSearchBox(); // Cierra el recuadro de búsqueda
        }

        // Cierra el cuadro de búsqueda al hacer clic fuera de él
        window.onclick = function(event) {       
            if (!event.target.matches('#search-input')) {
                const searchBox = document.getElementById("search-box");
                searchBox.style.display = "none";
            }
        }
    </script>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <!-- Mostrar el perfil o el enlace a iniciar sesión según la sesión de empresa -->
                <?php if (isset($_SESSION['nombre_organizacion'])): ?>
                    <li><a href="perfil_empresa.php">Perfil (<?php echo $_SESSION['nombre_organizacion']; ?>)</a></li>
                    <li><a href="cerrar_sesion.php">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li><a href="iniciar_sesionempresa.php">Iniciar Sesión</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <div class="navbar">
        <h1>TUMY</h1>
        <!-- Barra de búsqueda con funcionalidad -->
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
                        <!-- Agrega más ubicaciones según sea necesario -->
                    </select>
                </div>
                <div class="keywords-container">
                    <label>Palabras clave:</label>
                    <div id="keywords">
                        
                        <div class="keyword" onclick="selectKeyword('Keyword 1')">Keyword 1</div>
                        <div class="keyword" onclick="selectKeyword('Keyword 2')">Keyword 2</div>
                        <div class="keyword" onclick="selectKeyword('Keyword 3')">Keyword 3</div>
                        <!-- Estas palabras clave deben ser generadas dinámicamente según las publicaciones -->
                    </div>
                </div>
            </div>
        </div>
        <button onclick="location.href='iniciar_sesion.html'">Iniciar sesión</button> <!-- Redirección al inicio de sesión -->
        </div>
        

        <!-- Barra lateral izquierda -->
        <div class="sidebar">
            <h1>Principal</h1>
            <a href="publicar_empresa.php">Publicar</a>
            <br>
            <a href="perfil_empresa.html">Perfil</a>
            <p>Popular</p>
        </div>

        <!-- Contenido principal -->
        <div class="main-content">
            <!-- Publicaciones -->
            <div class="post">
                <div class="post-header">
                    <div>
                        <h2>Organización</h2>
                        <p>Título del Voluntariado - Publicado el: [Fecha]</p>
                    </div>
                    <button>Ver</button>
                </div>
                <div class="post-content">
                    Desarrollo del voluntariado
                </div>
                <div class="post-buttons">
                    <button>Me gusta</button>
                    <button>Comentar</button>
                    <button>Compartir</button>
                </div>
            </div>

            <div class="post">
                <div class="post-header">
                    <div>
                        <h2>Organización</h2>
                        <p>Título del Voluntariado - Publicado el: [Fecha]</p>
                    </div>
                    <button>Ver</button>
                </div>
                <div class="post-content">
                    Desarrollo del voluntariado
                </div>
                <div class="post-buttons">
                    <button>Me gusta</button>
                    <button>Comentar</button>
                    <button>Compartir</button>
                </div>
            </div>
        </div>

        <!-- Barra lateral derecha -->
        <div class="right-sidebar">
            <h2>Organizaciones Populares</h2>
            <div class="user-info">
                <p>Usuario</p>
                <p>Ubicación</p>
                <p>Comentarios Recientes</p>
            </div>
        </div>
    </main>
</body>
</html>
