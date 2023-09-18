<!DOCTYPE html>
<html>
<head>
	<title>Alta de usuarios</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f2f2f2;
		}
		h1 {
			color: #333;
			text-align: center;
		}
		form {
			margin: auto;
			width: 50%;
			padding: 20px;
			background-color: #fff;
			border: 1px solid #333;
			border-radius: 5px;
			margin-top: 60px;
		}
		label, input {
			display: block;
			margin-bottom: 10px;
		}
		input[type="submit"] {
			background-color: #333;
			color: #fff;
			border: none;
			padding: 10px 20px;
			border-radius: 5px;
			cursor: pointer;
		}
		button1 {
	  background-color: #4CAF50;
	  color: white;
	  padding: 12px 20px;
	  border: none;
	  border-radius: 4px;
	  cursor: pointer;
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
		.centered1 {
			display: block;
			margin: 0 auto;
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
			display: block;
			margin: 0 auto;
		}
	</style>
</head>
<body>
	<body>
<div class="barra-superior">
  <div class="titulo-y-botones">
    <h1>Alta de usuarios</h1>
    <button class="boton" onclick="window.location.href='verUsuarios.php'">Usuarios Agregados</button>
    <button class="boton" onclick="window.location.href='monitoreo.php'">Monitoreo Profes</button>
	
  </div>
</div>

	<form method="post">
		<label for="usuario">Usuario:</label>
		<input type="text" id="usuario" name="usuario" required>
		<label for="serialNumber">serialNumber:</label>
		<input type="text" id="serialNumber" name="serialNumber" required>
		<label for="nivel">nivel:</label>
		<input type="text" id="nivel" name="nivel" required>

		<input type="submit" value="Agregar usuario">
	</form>

	
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
		//echo "<p>Connected successfully</p>";

		// Verifica si se enviaron datos del formulario
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
		    $usuario = $_POST["usuario"];
			$serialNumber = $_POST["serialNumber"];
			$nivel = $_POST["nivel"];

			// Inserta los datos en la tabla "usuarios"
			$sql = "INSERT INTO alta (usuario, serialNumber,nivel) VALUES ('$usuario','$serialNumber','$nivel')";
			if ($conn->query($sql) === TRUE) {
				 
			  echo "<p>Usuario agregado correctamente</p>";
			} else {
			  echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}

		$conn->close();
	?>


</body>
</html>

