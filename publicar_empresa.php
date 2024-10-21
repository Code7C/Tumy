<?php
include 'db.php'; // Incluye la conexión a la base de datos

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['publicar'])) {
    $titulo = $_POST['titulo'];
    $cuerpo = $_POST['cuerpo'];
    $palabras_claves = $_POST['palabras_claves'];
    $ubicacion = $_POST['ubicacion'];
    $horarios = $_POST['horarios'];

    // Suponiendo que tienes el ID de la empresa almacenado en una sesión
    session_start();
    $empresa_id = $_SESSION['empresa_id'];

    // Preparar la consulta de inserción
    $sql = "INSERT INTO publicaciones (empresa_id, titulo, cuerpo, palabras_claves, ubicacion, horarios) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $cnx->prepare($sql);
    $stmt->bind_param("isssss", $empresa_id, $titulo, $cuerpo, $palabras_claves, $ubicacion, $horarios);

    if ($stmt->execute()) {
        $mensaje = "Publicación subida con éxito.";
    } else {
        $mensaje = "Error al subir la publicación: " . $stmt->error;
    }

    $stmt->close();
}

$cnx->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicar para Empresa</title>
    <link rel="stylesheet" href="styles.css"> 
    <style>
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
            background: #3a3a3a; /* Fondo más claro para el contenedor */
            border-radius: 8px; /* Bordes redondeados */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5); /* Sombra para efecto de profundidad */
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
            border: 1px solid #555; /* Borde gris oscuro */
            border-radius: 4px; /* Bordes redondeados para los campos */
            font-size: 16px; /* Tamaño de fuente */
            background-color: #444; /* Fondo oscuro para los campos */
            color: #f4f4f4; /* Texto claro en los campos */
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
            background-color: #5cb85c; /* Color de fondo del botón */
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
    </style>

    </style>
</head>
<body>
    <div class="container">
        <h1>Publicar para Empresa</h1>
        <form action="" method="POST">
            <input type="text" name="titulo" placeholder="Título" required>
            <br>
            <textarea name="cuerpo" placeholder="Cuerpo de la publicación" required></textarea>
            <br>
            <input type="text" name="palabras_claves" placeholder="Palabras Claves (separadas por comas)">
            <br>
            <input type="text" name="ubicacion" placeholder="Ubicación" required>
            <br>
            <input type="text" name="horarios" placeholder="Horarios">
            <br>
            <button type="submit" name="publicar">Publicar</button>
            <br>
        </form>
        <?php if (isset($mensaje)) echo "<p>$mensaje</p>"; ?>
    </div>
</body>
</html>

