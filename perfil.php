<?php
include 'db.php'; // Include the database connection

// Assume the user ID is stored in a session or retrieved after login.
session_start();
$user_id = $_SESSION['user_id'] ?? null; // Replace with actual session variable

// Fetch user data if ID is available
if ($user_id) {
    $query = $cnx->prepare("SELECT nombre, apellido, nombre_usuario, email FROM usuarios WHERE id = ?");
    $query->bind_param("i", $user_id);
    $query->execute();
    $result = $query->get_result();
    $user = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TUMY - Perfil de Usuario</title>
    <style>
        /* Estilos generales */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f3f3f3;
            font-family: Arial, sans-serif;
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

        /* Iconos de redes sociales en la barra lateral */
        .social-links {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            color: #EEE1C6;
        }

        .social-links a {
            color: #EEE1C6;
            transition: color 0.3s;
        }

        .social-links a:hover {
            color: #63BD6D;
        }

        /* Contenedor principal de la tarjeta */
        .profile-card {
            width: 500px;
            background-color: rgba(202, 255, 191, 0.9);
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            text-align: center;
            font-family: Arial, sans-serif;
            margin-left: 150px;
        }

        /* Imagen de portada */
        .cover-photo {
            width: 100%;
            height: 120px;
            background-image: url("ft/portada.jpg");
            background-size: cover;
            background-position: center;
        }

        /* Imagen de perfil */
        .profile-photo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid #fff;
            margin-top: -50px;
            background-color: white;
        }

        /* Información del usuario */
        .profile-info {
            padding: 20px;
            color: #333;
        }

        .profile-info h2 {
            font-size: 22px;
            font-weight: bold;
            margin: 10px 0 5px;
        }

        .profile-info p {
            font-size: 14px;
            color: #777;
            margin: 0;
        }


        /* Sección de comentarios */
        .comments-section {
            padding: 20px;
            background-color: rgba(202, 255, 191, 0.9);
            margin-top: 15px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .comment {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
            color: #333;
        }

        .comment:last-child {
            border-bottom: none;
        }

        /* Ocultar el input de archivo */
        #profile-upload {
            display: none;
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

    

    

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TUMY - Perfil de Usuario</title>
    <style>
        /* Add your existing CSS styles here */
    </style>
</head>
<body>

    <!-- Existing HTML for profile layout, sidebar, and background video -->

    <div class="profile-card">
        <div class="cover-photo"></div>

        <label for="profile-upload">
            <img id="profile-pic" src="ft/perfil.jpg" alt="Imagen de perfil" class="profile-photo" title="Haz clic para cambiar la foto">
        </label>
        <input type="file" id="profile-upload" accept="image/*" onchange="loadProfilePicture(event)">

        <div class="profile-info">
            <h2><?php echo htmlspecialchars($user['nombre'] ?? 'Nombre no disponible'); ?> <?php echo htmlspecialchars($user['apellido'] ?? ''); ?></h2>
            <p><?php echo htmlspecialchars($user['nombre_usuario'] ?? 'Usuario no disponible'); ?></p>
            <p><?php echo htmlspecialchars($user['email'] ?? 'Email no disponible'); ?></p>
        </div>
    </div>

    <script>
        // JavaScript for profile picture upload (same as before)
    </script>

</body>
</html>


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
                    localStorage.setItem('profileImage', e.target.result);
                };
                reader.readAsDataURL(file);
            }
        }
    </script>

</body>
</html>
