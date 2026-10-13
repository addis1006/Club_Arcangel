<?php
// Datos de conexión a la base de datos (ajústalos según tu servidor local o hosting)
$servidor = "localhost";
$usuario = "root";       
$clave = "";           
$base_datos = "mi_sistema";

// Crear conexión
$conexion = new mysqli($servidor, $usuario, $clave, $base_datos);

// Verificar si hubo error en la conexión
if ($conexion->connect_error) {
    die("Error de conexión con la base de datos: " . $conexion->connect_error);
}

// Verificar si se enviaron los datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    // Encriptamos la contraseña para mantenerla segura
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Consulta SQL para insertar los datos
    $sql = "INSERT INTO registros (nombre, email, password) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sss", $nombre, $email, $password);

    if ($stmt->execute()) {
        echo "<h2 style='font-family:sans-serif; text-align:center; color:#123c70; margin-top:50px;'>¡Registro guardado con éxito en el sistema del Club Arcángel!</h2>";
        echo "<p style='text-align:center; font-family:sans-serif;'><a href='index.html'>Volver al formulario</a></p>";
    } else {
        echo "<h2 style='font-family:sans-serif; text-align:center; color:#a32e4e; margin-top:50px;'>Error al registrar: Este correo ya podría estar registrado.</h2>";
        echo "<p style='text-align:center; font-family:sans-serif;'><a href='index.html'>Intentar de nuevo</a></p>";
    }

    $stmt->close();
}

$conexion->close();
?>