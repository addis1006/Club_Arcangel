<?php
$servidor = "localhost";
$usuario = "root";       
$clave = "";           
$base_datos = "mi_sistema";

$conexion = new mysqli($servidor, $usuario, $clave, $base_datos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'] ?? '';
    $clase = $_POST['clase'] ?? '';

    if (!empty($nombre) && !empty($clase)) {
        $sql = "INSERT INTO resultados_clases (nombre, clase_asignada) VALUES (?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ss", $nombre, $clase);

        if ($stmt->execute()) {
            echo "Guardado exitosamente";
        } else {
            echo "Error al guardar";
        }
        $stmt->close();
    }
}
$conexion->close();
?>