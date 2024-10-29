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
        body {
            font-family: Arial, sans-serif;
            background-color: #2c2c2c; /* Fondo oscuro */
            color: #f4f4f4; /* Color del texto en claro */
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 500px; /* Ancho máximo del contenedor */
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
            gap: 15px; /* Espaciado entre campos */
        }

        label {
            color: #f4f4f4;
            font-size: 14px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
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
        select:focus {
            border-color: #5cb85c; /* Color del borde al enfocar */
            outline: none; /* Sin contorno */
        }

        button {
            padding: 12px;
            border: none; /* Sin borde */
            border-radius: 4px; /* Bordes redondeados para el botón */
            background-color: #5cb85c; /* Color de fondo del botón */
            color: white; /* Color del texto del botón */
            font-size: 16px; /* Tamaño de fuente del botón */
            cursor: pointer; /* Cambia el cursor al pasar sobre el botón */
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #4cae4c; /* Color del botón al pasar el mouse */
        }

        .error-message {
            text-align: center; /* Centra el texto de los mensajes */
            color: red; /* Color del texto del mensaje de error */
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
        <h1>Registro de Empresa</h1>
        <form action="" method="POST">
            <label for="nombre_organizacion">Nombre de la Organización</label>
            <input type="text" name="nombre_organizacion" placeholder="Nombre de la Organización" required>

            <label for="representante_legal">Representante Legal</label>
            <input type="text" name="representante_legal" placeholder="Representante Legal" required>

            <label for="provincia">Provincia</label>
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

            <label for="localidad">Localidad</label>
            <select name="localidad" id="localidad" required>
                <option value="">Seleccione una localidad</option>
            </select>
            <input type="hidden" name="ubicacion" id="ubicacion">

            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Email" required>

            <label for="contrasena">Contraseña</label>
            <input type="password" name="contrasena" placeholder="Contraseña" required>

            <button type="submit" name="register_empresa">Registrarse</button>
        </form>
        <?php if (isset($mensaje_empresa)) echo "<p class='error-message'>$mensaje_empresa</p>"; ?>
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