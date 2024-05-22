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

// Recoger datos del formulario
$nombre = $_POST['name'];
$asunto = $_POST['subject'];
$correo = $_POST['email'];
$mensaje = $_POST['message'];

// Preparar y vincular
$stmt = $conn->prepare("INSERT INTO comentarios (nombre, asunto, correo, mensaje) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $nombre, $asunto, $correo, $mensaje);

// Ejecutar
$stmt->execute();

// Cerrar conexión
$stmt->close();
$conn->close();
?>
