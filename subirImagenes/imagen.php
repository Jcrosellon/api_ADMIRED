<?php
// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "base_proyecto");

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el archivo de imagen ha sido subido
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    // Ruta a la carpeta donde se almacenarán las imágenes
    $target_dir = "imagenes_zonas_comunes/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $image_url = "http://localhost/SENA/api_ADMIRED/subirImagenes/imagenes_zonas_comunes/" . basename($_FILES["image"]["name"]);

    // Verificar si la carpeta existe y es escribible
    if (!is_dir($target_dir)) {
        die("La carpeta de destino no existe.");
    }
    if (!is_writable($target_dir)) {
        die("La carpeta de destino no es escribible.");
    }

    // Mover la imagen a la carpeta del servidor
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $nombre = $_POST['nombre']; // Obtener el nombre desde el formulario
        $description = $_POST['description']; // Obtener la descripción
        $precio = $_POST['precio']; // Obtener el precio
        $disponibilidad = $_POST['disponibilidad']; // Obtener la disponibilidad (1 o 0)

        // Insertar la ruta de la imagen (URL) en la base de datos
        $sql = "INSERT INTO areas_comunes (NOMBRE, DESCRIPCION, IMAGEN_URL, PRECIO, DISPONIBILIDAD) 
                VALUES ('$nombre', '$description', '$image_url', '$precio', '$disponibilidad')";
        if ($conn->query($sql) === TRUE) {
            echo "Imagen subida correctamente";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error al mover la imagen: " . $_FILES['image']['error'];
    }
} else {
    echo "Error al subir la imagen: " . $_FILES['image']['error'];
}

$conn->close();
