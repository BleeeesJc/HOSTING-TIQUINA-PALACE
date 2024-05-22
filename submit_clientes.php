<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotelbdd";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Recopilar datos del formulario
$fechaEntrada = $_POST['Enter'];
$fechaSalida = $_POST['Leave'];
$adultos = $_POST['Adult'];
$ninos = $_POST['Child'];
$precio = $_POST['precioHabitacionPorNoche'];
$tipoTarjeta = $_POST['tipo'];
$montoTotal = $_POST['montoTotal'];
$horaLlegada = $_POST['hora_llegada']; // Hora de llegada agregada
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$direccion = $_POST['direccion'];
$ciudad = $_POST['ciudad'];
$codigo_postal = $_POST['codigo_postal'];
$pais = $_POST['pais'];
$telefono = $_POST['telefono'];
$peticiones = $_POST['peticiones'];
$tipoHabitacion = $_POST['room'];
$servicios = $_POST['service'];

// Insertar datos de cliente
$sqlCliente = "INSERT INTO clientes (nombre, apellido, email, direccion, ciudad, codigo_postal, pais, telefono, peticiones) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmtCliente = $conn->prepare($sqlCliente);
$stmtCliente->bind_param("sssssisis", $nombre, $apellido, $email, $direccion, $ciudad, $codigo_postal, $pais, $telefono, $peticiones);
$stmtCliente->execute();
$idCliente = $stmtCliente->insert_id;
$stmtCliente->close();

// Insertar datos de habitación
$sqlHabitacion = "INSERT INTO habitaciones (Tipo, Precio) VALUES (?, ?)";
$stmtHabitacion = $conn->prepare($sqlHabitacion);
$stmtHabitacion->bind_param("sd", $tipoHabitacion, $precio);
$stmtHabitacion->execute();
$idHabitacion = $stmtHabitacion->insert_id;
$stmtHabitacion->close();

// Concatenar y guardar servicios
$descripcionServicios = "";
$costosServicios = "";
foreach ($servicios as $servicio) {
    $costo = match($servicio) {
        'SPA' => 20,
        'DESA' => 15,
        'ALMU' => 15,
        'CENA' => 15,
        default => 0
    };
    if ($costo > 0) {
        $descripcionServicios .= $servicio . ',';
        $costosServicios .= $costo . ',';
    }
}
$descripcionServicios = rtrim($descripcionServicios, ',');
$costosServicios = rtrim($costosServicios, ',');

if (!empty($descripcionServicios)) {
    $sqlServicios = "INSERT INTO servicios (descripcion, costos) VALUES (?, ?)";
    $stmtServicios = $conn->prepare($sqlServicios);
    $stmtServicios->bind_param("ss", $descripcionServicios, $costosServicios);
    $stmtServicios->execute();
    $idServicios = $stmtServicios->insert_id;
    $stmtServicios->close();
} else {
    $idServicios = NULL;
}

// Insertar datos de reserva
$sqlReserva = "INSERT INTO reservas (id_cliente, id_habitaciones, id_servicios, fecha_entrada, fecha_salida, hora_llegada, adultos, menores, precio, monto_total, tipo_pago) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmtReserva = $conn->prepare($sqlReserva);
$stmtReserva->bind_param("iiisssiddss", $idCliente, $idHabitacion, $idServicios, $fechaEntrada, $fechaSalida, $horaLlegada, $adultos, $ninos, $precio, $montoTotal, $tipoTarjeta);
$stmtReserva->execute();
$stmtReserva->close();

$conn->close();
?>
