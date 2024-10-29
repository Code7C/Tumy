<?php
include 'db.php';

if (isset($_GET['provincia_id'])) {
    $provincia_id = $_GET['provincia_id'];
    
    $sql = "SELECT id, localidad FROM localidades WHERE provincia_id = ?";
    $stmt = $cnx->prepare($sql);
    $stmt->bind_param("i", $provincia_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $localidades = [];
    while ($row = $result->fetch_assoc()) {
        $localidades[] = $row;
    }

    echo json_encode($localidades);
    $stmt->close();
}
mysqli_close($cnx);
?>
