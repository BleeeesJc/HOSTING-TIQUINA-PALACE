<?php
// Definición de los parámetros de conexión
$host = "localhost";
$port = "5432";
$dbname = "hotelbdd";
$username = "postgres";
$password = "admin";
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$username;password=$password";

try {
    $conn = new PDO($dsn);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Asumiendo que los datos del producto son enviados como JSON en el cuerpo de la solicitud POST
    $data = json_decode(file_get_contents("php://input"), true);
    if (!$data) {
        throw new Exception("Datos no válidos");
    }
    // Insertar datos de cliente
    $sqlCliente = "INSERT INTO clientes (nombre, apellido, email, direccion, ciudad, codigo_postal, pais, telefono, peticiones) VALUES (:nombre,:apellido,:email,:direccion,:ciudad,:codigo_postal,:pais,:telefono,:peticiones)";
    $stmtCliente = $conn->prepare($sqlCliente);
    $stmtCliente->bindParam(':nombre', $data['nombre']);
    $stmtCliente->bindParam(':apellido', $data['apellido']);
    $stmtCliente->bindParam(':email', $data['email']);
    $stmtCliente->bindParam(':direccion', $data['direccion']);
    $stmtCliente->bindParam(':ciudad', $data['ciudad']);
    $stmtCliente->bindParam(':codigo_postal', $data['codigo_postal']);
    $stmtCliente->bindParam(':pais', $data['pais']);
    $stmtCliente->bindParam(':telefono', $data['telefono']);
    $stmtCliente->bindParam(':peticiones', $data['peticiones']);
    $stmtCliente->execute();
    $idCliente = $conn->lastInsertId();

    // Insertar datos de habitación
    $sqlHabitacion = "INSERT INTO habitaciones (tipo, precio) VALUES (:tipo, :precio)";
    $stmtHabitacion = $conn->prepare($sqlHabitacion);
    $stmtHabitacion->bindParam(':tipo', $data['tipoHabitacion']);
    $stmtHabitacion->bindParam(':precio', $data['precio']);
    $stmtHabitacion->execute();
    $idHabitacion = $conn->lastInsertId();

    // Concatenar y guardar servicios
    $descripcionServicios = "";
    $costosServicios = "";
    foreach ($data['servicios'] as $servicio) {
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
        $sqlServicios = "INSERT INTO servicios (descripcion, costos) VALUES (:descripcion, :costos)";
        $stmtServicios = $conn->prepare($sqlServicios);
        $stmtServicios->bindParam(':descripcion', $descripcionServicios);
        $stmtServicios->bindParam(':costos', $costosServicios);
        $stmtServicios->execute();
        $idServicios = $conn->lastInsertId();
    } else {
        $idServicios = NULL;
    }

    // Insertar datos de reserva
    $sqlReserva = "INSERT INTO reservas (id_cliente, id_habitaciones, id_servicios, fecha_entrada, fecha_salida, adultos, menores, precio, monto_total, tipo_pago,hora_llegada) VALUES (:id_cliente,:id_habitaciones,:id_servicios,:fecha_entrada,:fecha_salida,:adultos,:menores,:precio,:monto_total,:tipo_pago,:hora_llegada)";
    $stmtReserva = $conn->prepare($sqlReserva);
    $stmtReserva->bindParam(':id_cliente',$idCliente);
    $stmtReserva->bindParam(':id_habitaciones',$idHabitacion);
    $stmtReserva->bindParam(':id_servicios',$idServicios);
    $stmtReserva->bindParam(':fecha_entrada', $data['fechaEntrada']);
    $stmtReserva->bindParam(':fecha_salida', $data['fechaSalida']);
    $stmtReserva->bindParam(':adultos', $data['adultos']);
    $stmtReserva->bindParam(':menores', $data['ninos']);
    $stmtReserva->bindParam(':precio', $data['precio']);
    $stmtReserva->bindParam(':monto_total', $data['montoTotal']);
    $stmtReserva->bindParam(':tipo_pago', $data['tipoTarjeta']);
    $stmtReserva->bindParam(':hora_llegada', $data['horaLlegada']);
    $stmtReserva->execute();

    $conn->close();
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}