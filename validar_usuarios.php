<?php
session_start();
include "db.php"; // Incluir archivo de conexión a la base de datos

// Verificar que los datos fueron enviados por el método POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Buscar al usuario en la base de datos
    $sql = "SELECT id, nombre_usuario, contrasena FROM usuarios WHERE email = ?";
    $stmt = $cnx->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Si el usuario existe, verificar la contraseña
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($usuario_id, $nombre_usuario, $hashed_password);
        $stmt->fetch();

        // Verificar la contraseña
        if (password_verify($password, $hashed_password)) {
            $_SESSION['usuario_id'] = $usuario_id;
            $_SESSION['nombre_usuario'] = $nombre_usuario;

            // Redirigir a la página principal
            Header("Location: principal2.php");
            exit;
        } else {
            echo "<h1>Error: Contraseña incorrecta</h1>";
            echo "<a href='iniciar_sesion.html'>Volver</a>";
        }
    } else {
        echo "<h1>Error: No se encontró una cuenta con ese correo electrónico</h1>";
        echo "<a href='iniciar_sesion.html'>Volver</a>";
    }

    // Cerrar la conexión
    $stmt->close();
    $cnx->close();
}
?>
