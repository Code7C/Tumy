<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TUMY</title>
    <style>
        /* Estilos generales del cuerpo */
        body {
            background-image: url("ft/fond.jpg");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Contenedor principal */
        .container {
            width: 500px;
            max-width: 700px;
            height: 500px;
            background-color: rgba(11, 51, 11, 0.9);
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 40px;
            text-align: center;
        }

        /* Título */
        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        /* Sección de perfil */
        .profile-section {
            margin-top: 20px;
            position: relative;
        }

        .profile-section img {
            width: 100px;
            height: 100px;
            background-color: white;
            display: block;
            margin: 0 auto;
            border-radius: 50%;
            cursor: pointer;
        }

        .profile-info {
            background-color: white;
            height: auto;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            color: #222;
        }

        /* Sección de comentarios */
        .comments-section {
            margin-top: 20px;
            border-top: 1px solid #333;
            padding-top: 10px;
        }

        .comment {
            background-color: white;
            height: 15px;
            margin: 10px 0;
            border-radius: 5px;
        }

        /* Texto de encabezado */
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #cccccc;
            margin-bottom: 10px;
        }

        /* Ocultar el input de archivo */
        #profile-upload {
            display: none;
        }
    </style>
</head>
<body>

    <?php
    session_start(); // Iniciar sesión para obtener el nombre de usuario

    // Conectar a la base de datos
    $servername = "localhost"; // Cambia esto si es necesario
    $username = "root"; // Cambia esto según el nombre de usuario de tu base de datos
    $password = ""; // Cambia esto según la contraseña de tu base de datos
    $dbname = "tumy"; // Nombre de la base de datos

    // Crear la conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Obtener el nombre de usuario de la sesión
    $nombre_usuario = $_SESSION['nombre_usuario'] ?? null;

    if ($nombre_usuario) {
        // Obtener datos del usuario desde la base de datos
        $sql = "SELECT nombre_usuario, nombre, apellido, email, ubicacion FROM usuarios WHERE nombre_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nombre_usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc(); // Obtener datos del usuario
        } else {
            echo "No se encontraron datos para el usuario.";
        }

        $stmt->close();
    } else {
        echo "Por favor, inicie sesión.";
    }

    $conn->close();
    ?>

    <div class="container">
        <div class="title">TUMY</div>

        <!-- Sección de perfil -->
        <div class="profile-section">
            <div class="section-title">Perfil</div>
            <label for="profile-upload">
                <img id="profile-pic" src="/mnt/data/perfil.jpg" alt="Imagen de perfil" title="Haz clic para cambiar la foto">
            </label>
            <input type="file" id="profile-upload" accept="image/*" onchange="loadProfilePicture(event)">

            <!-- Información del usuario -->
            <div class="profile-info" style="background-color:rgba(11, 51, 11, 0.9);color:white;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                <p><strong>Usuario:</strong> <?php echo $user['nombre_usuario'] ?? 'No disponible'; ?></p>
                <p><strong>Nombre:</strong> <?php echo $user['nombre'] ?? 'No disponible'; ?></p>
                <p><strong>Apellido:</strong> <?php echo $user['apellido'] ?? 'No disponible'; ?></p>
                <p><strong>Email:</strong> <?php echo $user['email'] ?? 'No disponible'; ?></p>
                <p><strong>Ubicación:</strong> <?php echo $user['ubicacion'] ?? 'No disponible'; ?></p>
            </div>
        </div>

        <!-- Sección de comentarios -->
        <div class="comments-section">
            <div class="section-title">Comentarios</div>
            <div class="comment"></div>
            <div class="comment"></div>
        </div>
    </div>

    <script>
        // Cargar imagen desde LocalStorage al iniciar
        document.addEventListener("DOMContentLoaded", () => {
            const profilePic = document.getElementById('profile-pic');
            const savedImage = localStorage.getItem('profileImage');
            if (savedImage) {
                profilePic.src = savedImage;
            }
        });

        // Cargar imagen y guardar en LocalStorage
        function loadProfilePicture(event) {
            const profilePic = document.getElementById('profile-pic');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePic.src = e.target.result;
                    localStorage.setItem('profileImage', e.target.result); // Guardar imagen en LocalStorage
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>
