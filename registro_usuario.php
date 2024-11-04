<?php
include 'db.php'; // Conectar a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si es el formulario de registro de usuario
    if (isset($_POST['register_user'])) {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $nombre_usuario = $_POST['nombre_usuario'];
        $ubicacion = $_POST['ubicacion'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $email = $_POST['email'];
        $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT); // Hashear la contraseña

        // Preparar la consulta SQL
        $sql = "INSERT INTO usuarios (nombre, apellido, nombre_usuario, ubicacion, fecha_nacimiento, email, contrasena) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $cnx->prepare($sql);
        $stmt->bind_param("sssssss", $nombre, $apellido, $nombre_usuario, $ubicacion, $fecha_nacimiento, $email, $contrasena);

        // Ejecutar la consulta y verificar si fue exitosa
        if ($stmt->execute()) {
            echo "Registro de usuario exitoso.";
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
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="styles.css">
    <style>

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
            color:white; /* Color del texto en claro */
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 500px; /* Ancho máximo del contenedor */
            margin: auto; /* Centramos el contenedor */
            padding: 20px;
            background: #135124; /* Fondo más claro para el contenedor */
            border-radius: 8px; /* Bordes redondeados */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5); /* Sombra para efecto de profundidad */
        }

        h1 {
            text-align: center; /* Centra el texto del título */
            color:white; /* Color blanco para el título */
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
            background-color: #084309; /* Fondo oscuro para los campos */
            color:white; /* Texto claro en los campos */
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

        /* Estilo para el botón */
        .boton {
            display: inline-block;
            padding: 10px 25px;
            background-color: #177828; /* Color de fondo del botón */
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
    <script>
    function cargarLocalidades(provinciaId) {
        fetch('ubicaciones.php?provincia_id=' + provinciaId)
            .then(response => response.json())
            .then(data => {
                const localidadesSelect = document.getElementById('localidad');
                localidadesSelect.innerHTML = '<option value="">Seleccione una localidad</option>';
                data.forEach(localidad => {
                    localidadesSelect.innerHTML += `<option value="${localidad.localidad}">${localidad.localidad}</option>`;
                });
            });
    }
    </script>

</head>
<body>
    <div class="container">
        <h1>Registro de Usuario</h1>
        <form action="" method="POST">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="text" name="apellido" placeholder="Apellido" required>
            <input type="text" name="nombre_usuario" placeholder="Nombre de Usuario" required>
            <select name="provincia" id="provincia" required onchange="cargarLocalidades(this.value)">
                <option value="">Seleccione una provincia</option>
                    <?php
                        $sql = "SELECT id, provincia FROM provincias";
                        $result = $cnx->query($sql);
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['id']}'>{$row['provincia']}</option>";
                        }
                    ?>
            </select>
            <select name="localidad" id="localidad" required>
                <option value="">Seleccione una localidad</option>
            </select>
            <input type="hidden" name="ubicacion" id="ubicacion">
            <input type="date" name="fecha_nacimiento" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="contrasena" placeholder="Contraseña" required>
            <button type="submit" name="register_user" class="boton">Registrarse</button>
        </form>
        <?php if (isset($mensaje)) echo "<p>$mensaje</p>"; ?>
    </div>
    <script>
    document.querySelector("form").addEventListener("submit", function() {
        const provincia = document.getElementById("provincia").value;
        const localidad = document.getElementById("localidad").value;
        const ubicacion = `${provincia}, ${localidad}`;
        
        document.getElementById("ubicacion").value = ubicacion;
    });
    </script>

</body>
</html>
