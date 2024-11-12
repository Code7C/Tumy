<?php
include 'db.php'; // Conectar a la base de datos
$empresa_id = $_GET['id'] ?? null;

if ($empresa_id) {
    $sql = "SELECT nombre_organizacion, representante_legal, ubicacion, email FROM empresas WHERE id = ?";
    $stmt = $cnx->prepare($sql);
    $stmt->bind_param("i", $empresa_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $empresa = $result->fetch_assoc();
    } else {
        echo "No se encontraron datos para la empresa.";
        exit();
    }

    $stmt->close();
} else {
    echo "ID de empresa no válido.";
    exit();
}

mysqli_close($cnx);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Empresa - <?php echo htmlspecialchars($empresa['nombre_organizacion']); ?></title>
    <style>
        /* Estilos similares a los del perfil de usuario */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f3f3f3;
            font-family: Arial, sans-serif;
        }
        .profile-card {
            width: 450px;
            background-color: rgba(202, 255, 191, 0.9);
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            font-family: Arial, sans-serif;
            margin-left: 100px;
        }
        .cover-photo {
            width: 100%;
            height: 120px;
            background-image: url("ft/portada.jpg");
            background-size: cover;
            background-position: center;
        }
        .profile-photo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid #fff;
            margin-top: -50px;
            background-color: white;
        }
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
    </style>
</head>
<body>

<div class="profile-card">
    <!-- Imagen de portada -->
    <div class="cover-photo"></div>

    <!-- Imagen de perfil -->
    <img src="ft/empresa_perfil.jpg" alt="Imagen de perfil" class="profile-photo">

    <!-- Información de la empresa -->
    <div class="profile-info">
        <h2><?php echo htmlspecialchars($empresa['nombre_organizacion']); ?></h2>
        <p><strong>Representante Legal:</strong> <?php echo htmlspecialchars($empresa['representante_legal']); ?></p>
        <p><strong>Ubicación:</strong> <?php echo htmlspecialchars($empresa['ubicacion']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($empresa['email']); ?></p>
    </div>
</div>

</body>
</html>
