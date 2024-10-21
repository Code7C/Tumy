<?php
include 'db.php'; // Incluir archivo de conexión

// Comprobar si el método de solicitud es POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Registro de usuario
    if (isset($_POST['register_user'])) {
        $nombre = trim($_POST['nombre']);
        $apellido = trim($_POST['apellido']);
        $nombre_usuario = trim($_POST['nombre_usuario']);
        $ubicacion = trim($_POST['ubicacion']);
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $email = trim($_POST['email']);
        $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT); // Hash de la contraseña

        // Validar que el nombre de usuario y el email sean únicos
        $sql_check = "SELECT * FROM usuarios WHERE nombre_usuario = ? OR email = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("ss", $nombre_usuario, $email);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            echo "El nombre de usuario o el email ya están en uso.";
        } else {
            // Preparar la consulta para insertar el nuevo usuario
            $sql = "INSERT INTO usuarios (nombre, apellido, nombre_usuario, ubicacion, fecha_nacimiento, email, contrasena) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssss", $nombre, $apellido, $nombre_usuario, $ubicacion, $fecha_nacimiento, $email, $contrasena);

            if ($stmt->execute()) {
                echo "Registro de usuario exitoso.";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        }

        $stmt_check->close();
    }

    // Registro de empresa
    if (isset($_POST['register_empresa'])) {
        $nombre_organizacion = trim($_POST['nombre_organizacion']);
        $representante_legal = trim($_POST['representante_legal']);
        $ubicacion_empresa = trim($_POST['ubicacion']);
        $email_empresa = trim($_POST['email']);
        $contrasena_empresa = password_hash($_POST['contrasena'], PASSWORD_DEFAULT); // Hash de la contraseña

        // Validar que el email sea único
        $sql_check_empresa = "SELECT * FROM empresas WHERE email = ?";
        $stmt_check_empresa = $conn->prepare($sql_check_empresa);
        $stmt_check_empresa->bind_param("s", $email_empresa);
        $stmt_check_empresa->execute();
        $result_check_empresa = $stmt_check_empresa->get_result();

        if ($result_check_empresa->num_rows > 0) {
            echo "El email ya está en uso.";
        } else {
            // Preparar la consulta para insertar la nueva empresa
            $sql = "INSERT INTO empresas (nombre_organizacion, representante_legal, ubicacion, email, contrasena) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $nombre_organizacion, $representante_legal, $ubicacion_empresa, $email_empresa, $contrasena_empresa);

            if ($stmt->execute()) {
                echo "Registro de empresa exitoso.";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        }

        $stmt_check_empresa->close();
    }
}

// Cerrar la conexión
$conn->close();
?>
