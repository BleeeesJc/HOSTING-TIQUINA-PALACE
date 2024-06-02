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
    $sql = "INSERT INTO comentarios (nombre, asunto, correo, mensaje) VALUES (:nombre,:asunto,:correo,:mensaje)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombre', $data['nombre']);
    $stmt->bindParam(':asunto', $data['asunto']);
    $stmt->bindParam(':correo', $data['email']);
    $stmt->bindParam(':mensaje', $data['mensaje']);
    $stmt->execute();

    echo json_encode(['success' => 'Cliente registrado con éxito']);

    $conn->close();
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>