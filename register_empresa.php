<?php
include 'db.php'; // Conectar a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si es el formulario de registro de empresa
    if (isset($_POST['register_empresa'])) {
        $nombre_organizacion = $_POST['nombre_organizacion'];
        $representante_legal = $_POST['representante_legal'];
        $localidad = $_POST['localidad']; // Se toma la localidad directamente del formulario
        $email = $_POST['email'];
        $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT); // Hashear la contraseña

        // Preparar la consulta SQL
        $sql = "INSERT INTO empresas (nombre_organizacion, representante_legal, localidad, email, contrasena) VALUES (?, ?, ?, ?, ?)";
        $stmt = $cnx->prepare($sql);
        $stmt->bind_param("sssss", $nombre_organizacion, $representante_legal, $localidad, $email, $contrasena);

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
</head>
<body>
    <div class="container">
        <h1>Registro de Empresa</h1>
        <form action="" method="POST">
            <label for="nombre_organizacion">Nombre de la Organización</label>
            <input type="text" name="nombre_organizacion" placeholder="Nombre de la Organización" required>

            <label for="representante_legal">Representante Legal</label>
            <input type="text" name="representante_legal" placeholder="Representante Legal" required>

            <label for="localidad">Localidad</label>
            <select name="localidad" id="localidad" required>
                <option value="">Seleccione una localidad</option>
                <?php
                $localidades = ["Achiras", "Agua de Oro", "Alcira Gigena", "Almafuerte", "Alpa Corral", "Alta Gracia",
                                "Amboy", "Anisacate", "Arias", "Arroyito", "Arroyo de los Patos", "Ascochinga", 
                                "Athos Pampa", "Ballesteros", "Balnearia", "Bell Ville", "Berrotarán", "Bialet Masse",
                                "Brinkmann", "Cabalango", "Calmayo", "Caminiaga", "Canals", "Cañada del Sauce", 
                                "Capilla del Monte", "Casa Grande", "Cavanagh", "Cerro Champaqui", "Cerro Colorado", 
                                "Charbonier", "Ciudad de Córdoba", "Colonia Caroya", "Copacabana", "Coronel Moldes", 
                                "Corral de Bustos", "Cosquín", "Cruz Alta", "Cruz Chica", "Cruz del Eje", "Cruz Grande",
                                "Cuesta Blanca", "D. Velez Sarsfield", "Dean Funes", "Del Campillo", "Despeñaderos", 
                                "Devoto", "El Durazno", "El Manzano", "El Tío", "Embalse", "Estancia Vieja", 
                                "Falda del Carmen", "General Baldissera", "General Cabrera", "General Deheza", 
                                "General Levalle", "Hernando", "Huerta Grande", "Huinca Renanco", "Icho Cruz", 
                                "Ifflinger", "Intiyaco", "Ischilín", "James Craik", "Jesús María", 
                                "José de la Quintana", "Jovita", "Juárez Celman", "Justiniano Posse", "La Bolsa", 
                                "Laboulaye", "La Calera", "La Carlota", "La Cesira", "La Cruz", "La Cumbre", 
                                "La Cumbrecita", "La Falda", "La Francia", "La Granja", "La Higuera", "La Paisanita", 
                                "La Para", "La Paz", "La Población", "La Rancherita", "Las Albahacas", "Las Caleras", 
                                "Las Calles", "Las Chacras", "La Serranita", "Las Jarillas", "Las Peñas", "Las Perdices",
                                "Las Rabonas", "Las Tapias", "Las Varillas", "Leones", "Loma Bola", "Los Cerrillos", 
                                "Los Cocos", "Los Cóndores", "Los Gigantes", "Los Hornillos", "Los Molinos", 
                                "Los Pozos", "Los Reartes", "Los Surgentes", "Loza Corral", "Luque", "Lutti", 
                                "Luyaba", "Marcos Juárez", "Marull", "Mayu Sumaj", "Mendiolaza", "Mina Clavero", 
                                "Miramar", "Molinari", "Monte Buey", "Monte Maíz", "Morteros", "Nono", "Oliva", 
                                "Oncativo", "Ongamira", "Panaholma", "Pilar", "Potrero de Garay", "Quilino", 
                                "Rio Ceballos", "Río Cuarto", "Río de los Sauces", "Río Primero", "Río Segundo", 
                                "Rio Tercero", "Sacanta", "Saldan", "Salsacate", "Salsipuedes", "Sampacho", 
                                "San Agustín", "San A. de Arredondo", "San Carlos Minas", "San Clemente", "San Esteban",
                                "San Francisco", "S. Francisco del Chañar", "San Javier", "San Jose de la Dormida", 
                                "San Lorenzo", "San Marcos Sierras", "San Miguel de los Ríos", "San Roque", 
                                "Santa Catalina", "Santa Cruz del Lago", "Santa María de Punilla", "Santa Mónica", 
                                "Santa Rosa", "Segunda Usina", "Serrano", "Sinsacate", "Tala Huasi", "Tancacha", 
                                "Tanti", "Ucacha", "Unquillo", "Valle Hermoso", "Vicuña Mackenna", "Villa Allende", 
                                "Villa Alpina", "Villa Amancay", "Villa Animi", "Villa Ascasubi", "Villa Berna", 
                                "Villa Carlos Paz", "Villa Cerro Azul", "Villa Ciudad de América", "Villa Ciudad Parque",
                                "Villa Cura Brochero", "Villa del Dique", "Villa del Rosario", "Villa del Totoral", 
                                "Villa de María", "Villa de Pocho", "Villa de Soto", "Villa de Tulumba", 
                                "Villa Dolores", "Villa El Chacay", "Villa General Belgrano", "Villa Giardino", 
                                "Villa Huidobro", "Villa La Merced", "Villa de Las Rosas", "Villa los Aromos", 
                                "Villa Maria", "Villa Parque Siquiman", "Villa Quillinzo", "Villa Rumipal", 
                                "Villa San Miguel", "Villa Silvina", "Villa Yacanto", "Yacanto"];

                foreach ($localidades as $localidad) {
                    echo "<option value='$localidad'>$localidad</option>";
                }
                ?>
            </select>

            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Email" required>

            <label for="contrasena">Contraseña</label>
            <input type="password" name="contrasena" placeholder="Contraseña" required>

            <button type="submit" name="register_empresa">Registrarse</button>
        </form>
    </div>
</body>
</html>
