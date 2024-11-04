<?php
include 'db.php'; // Conectar a la base de datos

$sql = "
SELECT 
    p.titulo, 
    p.cuerpo, 
    p.fecha_publicacion, 
    p.palabras_claves,
    e.nombre_organizacion AS organizacion
FROM 
    publicaciones p
LEFT JOIN 
    empresas e ON p.empresa_id = e.id
ORDER BY 
    p.fecha_publicacion DESC
";
$result = $cnx->query($sql); // Ejecutar la consulta
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

        .navbar .nav-right {
            display: flex;
            align-items: center;
        }

        .navbar input[type="search"] {
            width: 300px;
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
            margin-left: 20px;
        }

        .navbar button:hover {
            background-color: #e65a00;
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
            background-color: #e65a00;
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

        .sidebar a {
            color: #ccc;
            text-decoration: none;
            font-size: 16px;
            margin-top: 20px;
            display: block;
        }

        .sidebar a:hover {
            color: white;
        }

        /* Contenido principal */
        .main-content {
            margin-left: 22%;
            margin-right: 22%;
            padding: 30px;
        }
        .post-tags {
            margin-top: 10px;
        }

        .tag {
            display: inline-block;
            background-color: #ff5f00;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            margin-right: 5px;
            font-size: 12px;
        }

        .tag:hover {
            background-color: #e65a00;
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

        .post-header button:hover {
            background-color: #005bb5;
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
    <header>
        <!-- Barra superior con título y búsqueda -->
        <div class="navbar">
            <h1>TUMY</h1>
            <div class="nav-right">
                <!-- Barra de búsqueda -->
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
                <button onclick="location.href='iniciar_sesion.html'">Iniciar sesión</button>
            </div>
        </div>
    </header>

    <!-- Barra lateral izquierda -->
    <div class="sidebar">
        <h1>Principal</h1>
        <a href="perfil.html">Perfil</a>
        <p>Popular</p>
    </div>

    <!-- Contenido principal -->
    <div class="main-content">
        <!-- Publicaciones -->
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="post">
                    <div class="post-header">
                        <div>
                            <h2><?php echo htmlspecialchars($row['organizacion']); ?></h2>
                            <p><?php echo htmlspecialchars($row['titulo']); ?> - Publicado el: <?php echo htmlspecialchars($row['fecha_publicacion']); ?></p>
                        </div>
                        <button>Ver</button>
                    </div>
                    <div class="post-content">
                        <?php echo htmlspecialchars($row['cuerpo']); ?>
                    </div>
                    <div class="post-tags">
                        <?php 
                        $palabras_claves = explode(',', $row['palabras_claves']); // Divide las palabras clave en un array
                        foreach ($palabras_claves as $clave): 
                            if (!empty(trim($clave))): // Evita etiquetas vacías
                        ?>
                            <span class="tag"><?php echo htmlspecialchars(trim($clave)); ?></span>
                        <?php 
                            endif;
                        endforeach; 
                        ?>
                    </div>
                    <div class="post-buttons">
                        <button>Me gusta</button>
                        <button>Comentar</button>
                        <button>Compartir</button>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No hay publicaciones disponibles.</p>
        <?php endif; ?>

        <?php $cnx->close(); // Cerrar la conexión ?>
    </div>

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
                    keyword.style.display = "block";
                } else {
                    keyword.style.display = "none";
                }
            });
        }

        function selectKeyword(keyword) {
            document.getElementById("search-term").value = keyword;
            toggleSearchBox();
        }

        window.onclick = function(event) {
            if (!event.target.matches('#search-input')) {
                const searchBox = document.getElementById("search-box");
                searchBox.style.display = "none";
            }
        }
    </script>
</body>
</html>
