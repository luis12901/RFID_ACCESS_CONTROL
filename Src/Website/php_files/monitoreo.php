<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Monitoreo</title>
    <style>
        table {
  border-collapse: collapse;
  width: 80%;
  margin: 50px auto;
  font-family: Arial, Helvetica, sans-serif;
  text-align: center;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
  border-radius: 10px;
}

table th, table td {
  border: 1px solid #ddd;
  padding: 12px;
}
th {

color: white;
}

table th {
  background-color: #4CAF50;
  font-weight: bold;
  text-align: center;
}

table tr:nth-child(even) {
  background-color: #f2f2f2;
}

table tr:hover {
  background-color: #e6e6e6;
}

@media (max-width: 768px) {
  table {
    width: 100%;
  }
  
  table th, table td {
    padding: 8px;
  }
}

        .barra-superior {
            background-color: #999;
            color: #fff;
            padding: 10px;
            text-align: center;
        }
        .titulo-y-botones {
            display: inline-block;
        }
        .boton {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
        }
        .boton:first-child {
            margin-left: 0;
        }
        .boton:last-child {
            float: right;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .centered {    
            width: 50%; /* ancho fijo */
            margin: 0 auto;
            margin-top: 40px;
            margin-bottom: 40px;
        }
    </style>
</head>
<body>
<div class="barra-superior">
    <div class="titulo-y-botones">
        <h1>Monitoreo</h1>
        <button class="boton" onclick="window.location.href='verUsuarios.php'">Usuarios Agregados</button>
        <button class="boton" onclick="window.location.href='alta_usuarios.php'">Alta Usuarios</button>
    </div>
    <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="text" name="nombre_usuario" placeholder="Buscar usuario...">
        <button type="submit">Buscar</button>
    </form>
</div>
<div class="centered">
    <?php
	// header("refresh: 1");
    $servername = "localhost"; // Nombre del servidor
    $username = "root"; // Usuario de la base de datos
    $password = ""; // Contraseña 
    $dbname = "rfid"; // Nombre de la base de datos

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar si la conexión es exitosa
    if ($conn->connect_error) {
        die("La conexión falló: " . $conn->connect_error);
    }

    // Construir consulta SQL
    $sql = "SELECT usuario, serialNumber, fecha, estado, tipo FROM registropersonaludg";
    if (isset($_GET["nombre_usuario"]) && $_GET["nombre_usuario"] != "") {
        $nombre_usuario = $_GET["nombre_usuario"];
        $sql .= " WHERE usuario LIKE '%$nombre_usuario%'";
    }

$result = $conn->query($sql);
date_default_timezone_set('America/Mexico_City');
// Verificar si se obtuvieron resultados
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Usuario</th><th>Serial Number</th><th>Fecha</th><th>Estado</th><th>Tipo</th></tr>";
    // Imprimir datos de cada fila
    while($row = $result->fetch_assoc()) {
       $fecha = date('m-d-Y H:i:s', $row["fecha"]);
        echo "<tr><td>" . $row["usuario"]. "</td><td>" . $row["serialNumber"]. "</td><td>" . $fecha. "</td><td>" . $row["estado"]. "</td><td>" . $row["tipo"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron resultados";
}
 
// Cerrar conexión
$conn->close();

?>


</div>

</body>
</html>
