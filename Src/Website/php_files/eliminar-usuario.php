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

    // Verifica si se recibió un ID de usuario para eliminar
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // Elimina el usuario de la tabla "altausuario"
        $sql = "DELETE FROM altausuario2 WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            echo "El usuario ha sido eliminado exitosamente";

            // Espera 3 segundos antes de redirigir a la página anterior
            usleep(100000);
            header("Location: " . $_SERVER['HTTP_REFERER']);
        } else {
            echo "Error al eliminar el usuario: " . $conn->error;
        }
    } else {
        echo "No se recibió el ID del usuario a eliminar";
    }

    $conn->close();
?>
