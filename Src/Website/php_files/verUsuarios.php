<!DOCTYPE html>
<html>
<head>
	<title>Usuarios registrados</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f2f2f2;
		}
		h1 {
			color: #333;
			text-align: center;
			  margin: 0 auto;
			max-width: 80%;
 
		}
		table {
			margin: auto;
			width: 80%;
			border-collapse: collapse;
			background-color: #fff;
			border: 1px solid #333;
			border-radius: 5px;
			  margin: 50px auto 0;
		}
		th, td {
			padding: 10px;
			text-align: left;
			border-bottom: 1px solid #ddd;
		}
		th {
			background-color: #333;
			color: #fff;
		}
		a {
			color: #333;
			text-decoration: none;
			font-weight: bold;
		}
		a:hover {
			color: #fff;
			background-color: #333;
		}
        .delete-button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
			}
	.navbar {
  background-color: #999;
  color: #fff;
  display: flex;
  justify-content: space-between;
  align-items: center;
  height: 50px;
  padding: 0 20px;
  
}

.navbar a {
  color: #fff;
  text-decoration: none;
  font-weight: bold;
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

        
	</style>
</head>
<body>
	<div class="navbar">
    <h1>Usuarios registrados</h1>
    <button class="boton" onclick="window.location.href='alta_usuarios.php'">Alta usuarios</button>
	    <button class="boton" onclick="window.location.href='monitoreo.php'">Monitoreo Profes</button>
  </div>
	<table>
		<tr>
			<th>ID</th>
			<th>RFID</th>
			<th>Usuario</th>
			<th>Nivel</th>
            <th>Eliminar</th>
		</tr>
		<?php
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "rfid";

			// Crea la conexión
			$conn = new mysqli($servername, $username, $password, $dbname);

			// Verifica la conexión
			if ($conn->connect_error) {
			  die("Connection failed: " . $conn->connect_error);
			}

			// Obtiene los datos de la tabla "altausuario"
			$sql = "SELECT * FROM alta";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
			  // Muestra los datos en una tabla
			  while($row = $result->fetch_assoc()) {
			    echo "<tr><td>" . $row["ID"] . "</td><td>" . $row["serialNumber"] . "</td><td>" . $row["usuario"] . "</td><td>" . $row["nivel"] . "</td><td><form method='post' action='eliminar-usuario.php'><input type='hidden' name='ID' value='" . $row["ID"] . "'><button type='submit' class='delete-button'>Eliminar</button></form></td></tr>";
			  }
			} else {
			  echo "<tr><td colspan='5'>No se encontraron resultados</td></tr>";
			}
			$conn->close();
		?>
	</table>
	
</body>
</html>

