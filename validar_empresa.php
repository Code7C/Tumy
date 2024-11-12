<?php
session_start();
include "db.php"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consulta SQL para obtener la empresa con ese correo
    $sql = "SELECT id, nombre_organizacion, contrasena FROM empresas WHERE email = ?";
    $stmt = $cnx->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Verificar si se encontró una cuenta con el email proporcionado
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($empresa_id, $nombre_organizacion, $hashed_password);
        $stmt->fetch();

        // Verificar la contraseña usando password_verify()
        if (password_verify($password, $hashed_password)) {
            // Contraseña correcta, iniciar sesión
            $_SESSION['empresa_id'] = $empresa_id;
            $_SESSION['nombre_organizacion'] = $nombre_organizacion;

            // Redirigir a la página principal de la empresa
            header("Location: principal2.php");
            exit;
        } else {
            // Contraseña incorrecta
            echo "<h1>Error: Contraseña incorrecta</h1>";
            echo "<a href='iniciar_sesionempresa.php'>Volver</a>";
        }
    } else {
        // No se encontró la cuenta con el correo electrónico
        echo "<h1>Error: No se encontró una cuenta con ese correo electrónico</h1>";
        echo "<a href='iniciar_sesionempresa.php'>Volver</a>";
    }

    // Cerrar la conexión
    $stmt->close();
    $cnx->close();
}
?>

