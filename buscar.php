<?php
include 'db.php'; // Conexión a la base de datos

// Obtener parámetros de búsqueda
$termino = isset($_GET['termino']) ? $_GET['termino'] : '';
$ubicacion = isset($_GET['ubicacion']) ? $_GET['ubicacion'] : '';

// Crear la consulta de búsqueda con SQL seguro
$sql = "SELECT 
            p.titulo, 
            p.cuerpo, 
            p.fecha_publicacion, 
            p.palabras_claves,
            e.nombre_organizacion AS organizacion 
        FROM 
            publicaciones p
        LEFT JOIN 
            empresas e ON p.empresa_id = e.id
        WHERE 
            (p.titulo LIKE ? OR p.cuerpo LIKE ? OR p.palabras_claves LIKE ?)";

// Añadir filtro por ubicación si se ha seleccionado
if (!empty($ubicacion)) {
    $sql .= " AND p.ubicacion = ?";
}

// Preparar la consulta
$stmt = $cnx->prepare($sql);

// Generar el patrón de búsqueda con comodines para SQL
$terminoBusqueda = "%" . $termino . "%";

// Vincular parámetros
if (!empty($ubicacion)) {
    $stmt->bind_param("ssss", $terminoBusqueda, $terminoBusqueda, $terminoBusqueda, $ubicacion);
} else {
    $stmt->bind_param("sss", $terminoBusqueda, $terminoBusqueda, $terminoBusqueda);
}

// Ejecutar la consulta
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda - TUMY</title>
    <style>
        /* Aquí puedes incluir los mismos estilos de index.php */
    </style>
</head>
<body>
    <!-- Barra superior con título y botón para regresar al índice -->
    <div class="navbar">
        <h1>Resultados de búsqueda</h1>
        <button onclick="location.href='index.php'">Volver al inicio</button>
    </div>

    <div class="main-content">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="post">
                    <div class="post-header">
                        <h2><?php echo htmlspecialchars($row['organizacion']); ?></h2>
                        <p><?php echo htmlspecialchars($row['titulo']); ?> - Publicado el: <?php echo htmlspecialchars($row['fecha_publicacion']); ?></p>
                    </div>
                    <div class="post-content">
                        <?php echo htmlspecialchars($row['cuerpo']); ?>
                    </div>
                    <div class="post-tags">
                        <?php 
                        $palabras_claves = explode(',', $row['palabras_claves']); 
                        foreach ($palabras_claves as $clave): 
                            if (!empty(trim($clave))):
                        ?>
                            <span class="tag"><?php echo htmlspecialchars(trim($clave)); ?></span>
                        <?php 
                            endif;
                        endforeach; 
                        ?>
                    </div>
                    <div class="post-buttons">
                        <button>Me gusta</button>
                        <button>Comentar</button>
                        <button>Compartir</button>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No se encuentran voluntariados con esa descripción en este momento.</p>
            <button onclick="location.href='index.php'">Volver al inicio</button>
        <?php endif; ?>

        <?php $stmt->close(); // Cerrar la consulta ?>
        <?php $cnx->close(); // Cerrar la conexión ?>
    </div>
</body>
</html>
