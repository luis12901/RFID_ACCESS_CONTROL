<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Obtener los datos enviados en el cuerpo de la petición HTTP
$data = json_decode(file_get_contents("php://input"), true);

// Establecer la zona horaria
date_default_timezone_set('America/Mexico_City');

// Obtener la fecha y hora actual
$fecha = new Datetime();
$timestamp = $fecha->getTimestamp();

// Conectar a la base de datos
$host = "localhost";
$user = "root";
$password = "";
$dbname = "rfid";

$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}



// Obtener el número de serie proporcionado por la ESP32 desde el mensaje JSON
$serialNumber = $_POST['serialNumber'];

// Consulta SQL para verificar si el serialNumber existe en la tabla personal_info
$sql_consulta = "SELECT * FROM alta WHERE serialNumber = ?";
$stmt_consulta = $conn->prepare($sql_consulta);
$stmt_consulta->bind_param("s", $data['serialNumber']);

// Ejecutar la consulta
$stmt_consulta->execute();

// Obtener el resultado de la consulta
$resultado_consulta = $stmt_consulta->get_result();
// como puedo saber la ip de mi esp32 ?
// Verificar si hay algún resultado
if ($resultado_consulta->num_rows > 0) { 

$nivel_aula = 2;

// Obtener el número de serie proporcionado por la ESP32 desde el mensaje JSON



$serialNumber = $data['serialNumber'];

// Realizar la consulta para obtener el valor de "nivel" de la tabla "personal"
$sql = "SELECT nivel FROM alta WHERE serialNumber = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $serialNumber);
$stmt->execute();

// Obtener el resultado de la consulta
$resultado = $stmt->get_result();
$registro = $resultado->fetch_assoc();


                $niveluser = $registro['nivel'];



    // Verificar si el nivel del usuario es menor o igual al nivel de la aula
    if ($niveluser <= $nivel_aula) {
        $acceso_nivel = true;
    } else {
        $acceso_nivel = false;
    }
 


            if($acceso_nivel == true){

    // Obtener el serialNumber enviado desde el ESP32
$serialNumber = $data['serialNumber'];

// Consultar el último registro con el serialNumber recibido
$sql = "SELECT tipo FROM registropersonaludg WHERE serialNumber = ? ORDER BY id DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $serialNumber);
$stmt->execute();
$resultado = $stmt->get_result();

// Verificar si la consulta devolvió algún resultado
if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $tipo = $fila['tipo'];
    // Verificar si el valor del último registro es "" o "ENTRADA"
    if ($tipo === "SALIDA") {
        $tipo_registro = true;
    } else {
        $tipo_registro = false;
    }
}
else {
    // Si no hay registros con el serialNumber recibido, asignar valor por defecto
    $tipo_registro = true;
}

    if($tipo_registro){
    
    $fila_consulta = $resultado_consulta->fetch_assoc();
    $usuario = $fila_consulta['usuario'];
    $estado_inicial = 'SIN PROCESAR';
    // Preparar la consulta SQL
    $sql = "INSERT INTO registropersonaludg (usuario, serialNumber, fecha, estado, tipo) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $tipo = "ENTRADA";
    $stmt->bind_param("sssss", $usuario, $data['serialNumber'], $timestamp, $estado_inicial, $tipo);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo json_encode(array("mensaje" => "Datos insertados correctamente."));
    } else {
        echo json_encode(array("mensaje" => "Error al insertar datos: " . $conn->error));
    }



    $data = array(
        'clave' => '1234',
        'estado' => 1,
        'acceso_nivel' => 1,
        'acceso' => 1,
        'nombre' => $usuario
    );
    
    $data_string = json_encode($data);
    
    $ch = curl_init('http://192.168.100.19');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string))
    );
    
    $result = curl_exec($ch);
    curl_close($ch);

        $sql_update = "UPDATE registropersonaludg SET estado='PROCESADO' WHERE estado='SIN PROCESAR'";
        if ($conn->query($sql_update) === TRUE) {
            echo "Se actualizó el estado en la tabla registropersonaludg.";
        } else {
            echo "Error al actualizar el estado en la tabla registropers    onaludg: " . $conn->error;
        }
  
    // Cerrar conexión
$conn->close();
    }
        /*  ACA SIMPLEMENTE SE DETERMINA QUE ES SALIDA, ASI QUE NO SE ACCIONA LA CERRADURA  */
    else{

        $fila_consulta = $resultado_consulta->fetch_assoc();
    $usuario = $fila_consulta['usuario'];
    $estado_inicial = 'SIN PROCESAR';
    // Preparar la consulta SQL
    $sql = "INSERT INTO registropersonaludg (usuario, serialNumber, fecha, estado, tipo) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $tipo = "SALIDA";
    $stmt->bind_param("sssss", $usuario, $data['serialNumber'], $timestamp, $estado_inicial, $tipo);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo json_encode(array("mensaje" => "Datos insertados correctamente."));
    } else {
        echo json_encode(array("mensaje" => "Error al insertar datos: " . $conn->error));
}
$data = array(

    'clave' => '1234',
    'estado' => 1,
    'acceso_nivel' => 1,
    'acceso' => 0,
    'nombre' => $usuario
);

$data_string = json_encode($data);

$ch = curl_init('http://192.168.100.19');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_string))
);

$result = curl_exec($ch);
    curl_close($ch);

        $sql_update = "UPDATE registropersonaludg SET estado='PROCESADO' WHERE estado='SIN PROCESAR'";
        if ($conn->query($sql_update) === TRUE) {
            echo "Se actualizó el estado en la tabla registropersonaludg.";
        } else {
            echo "Error al actualizar el estado en la tabla registropersonaludg: " . $conn->error;
        }
  
    // Cerrar conexión
$conn->close();

    }
    }
    else{

        $data = array(

            'clave' => '1234',
            'estado' => 1,
            'acceso_nivel' => 0,
            'acceso' => 0,
            'nombre' => $usuario
            
        );
        
        $data_string = json_encode($data);
        
        $ch = curl_init('http://192.168.100.19');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        
        $result = curl_exec($ch);
        curl_close($ch);
    // Cerrar conexión
    $conn->close();
    }
} 
                                    /* ACA TERMINA EL IF SI ES QUE EL SERIAL EXISTE EN LA BASE DE DATOS */
else {
    $data = array(

        'clave' => '1234',
        'estado' => 0,
        'acceso_nivel' => 0,
        'acceso' => 0,
        'nombre' => 'luis'
    );
    
    $data_string = json_encode($data);
    
    $ch = curl_init('http://192.168.100.19');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string))
    );
    
    $result = curl_exec($ch);
    curl_close($ch);
// Cerrar conexión
$conn->close();
}

?>