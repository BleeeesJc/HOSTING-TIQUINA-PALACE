<?php
// Conectar a la base de datos
$servername = "localhost"; // o la IP del servidor de bases de datos
$username = "root";
$password = "";
$database = "hotelbdd";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Recuperar datos del formulario
$tipoHabitacion = $_POST['room'];
$precioHabitacionPorNoche = $_POST['precioHabitacionPorNoche'];

// Preparar y vincular
$stmt = $conn->prepare("INSERT INTO habitaciones (Tipo, Precio) VALUES (?, ?)");
$stmt->bind_param("sd", $tipoHabitacion, $precioHabitacionPorNoche);

// Ejecutar
if ($stmt->execute()) {
    echo "Reserva guardada correctamente.";
} else {
    echo "Error al guardar la reserva: " . $stmt->error;
}

// Cerrar conexión
$stmt->close();
$conn->close();
?>
