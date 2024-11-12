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
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<style type="text/css">
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


        /* Barra superior */
        .navbar {
            width: calc(81.7% - 90px);
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


                /* Contenido principal */
        .main-content {
            margin-left: 22%;
            margin-right: 22%;
            padding: 30px;
            margin: 150px auto 1000px auto; /* Separar del navbar y sidebar */
        }
        .post-tags {
            margin-top: 10px;
        }

        .tag {
            display: inline-block;
            background-color: rgba(202, 255, 191, 0.9);
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
            background-color: rgba(34, 34, 34, 0.8);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 100px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
            margin-right: 5%;
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
            background-color: #63BD6D;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .post-header button:hover {
            background-color: #32CD32;
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
            top: 0;
            right: 0;
            width: 190px;
            height: 100vh;
            background-color: rgba(17, 17, 17, 0.9);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
            z-index: 1; /* Asegura que esté por encima del video */
        }

        .right-sidebar h2 {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .right-sidebar .user-info {
            background-color: #63BD6D;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
        }

        .right-sidebar .user-info p {
            font-size: 16px;
            color: #EEE1C6;
            margin-bottom: 10px;
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
    </div>

    <!-- Barra lateral izquierda -->
    <div class="sidebar">
        <a href="principal2.php"><img src="ft/hogar.png">Inicio</a>
        <a href="iniciar_sesion.html"><img src="ft/sesion.png">Iniciar Sesion</a>
        <a href="perfil.php"><img src="ft/usuario.png">Perfil</a>
        <a href="proyectos.php"><img src="ft/ayudar.png" >Voluntariados</a>
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
                        <button class="boton">Ver</button>
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
                        <button class="boton">Me gusta</button>
                        <button class="boton">Comentar</button>
                        <button class="boton">Compartir</button>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No hay publicaciones disponibles.</p>
        <?php endif; ?>

        <?php $cnx->close(); // Cerrar la conexión ?>
    </div>

    <!-- Barra lateral derecha -->
    <div class="right-sidebar">
        <h1>Principal</h1>
        <p>Popular</p>
    </div>



</body>
</html>