<?php
// Establecer la conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "rfid");

// Seleccionar la base de datos
mysqli_select_db($conexion, "rfid");

// Obtener los valores del formulario
$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

// Ejecutar la consulta
$resultado = mysqli_query($conexion, "SELECT * FROM ingreso WHERE usuario='$usuario' AND contraseña='$contrasena'");

// Verificar si la consulta devuelve algún resultado
if (mysqli_num_rows($resultado) > 0) {
  // El usuario y la contraseña son correctos, redirigir a otra página
  header("Location: monitoreo.php");
} else {
  // El usuario o la contraseña son incorrectos, mostrar un mensaje de error
  echo "Usuario o contraseña incorrectos";
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
