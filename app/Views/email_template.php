<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Reserva</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .container {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #007BFF;
        }

        .details {
            margin: 20px 0;
        }

        .details div {
            margin-bottom: 10px;
        }

        .footer {
            margin-top: 20px;
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Confirmación de Reserva</h1>
        <p>Estimado <?= $nombre_usuario ?? 'Usuario desconocido' ?>,</p>
        <p>Su reserva ha sido creada con éxito. A continuación, encontrará los detalles de su reserva:</p>

        <p><strong>Fecha de Inicio:</strong> <?= $fecha_reserva ?? 'No disponible' ?></p>
        <p><strong>Fecha de Fin:</strong> <?= $fecha_fin ?? 'No disponible' ?></p>
        <p><strong>Área Común:</strong> <?= $nombre_area_comun ?? 'No disponible' ?></p>
        <p><strong>Observación Entrega:</strong> <?= $observacion_entrega ?? 'No disponible' ?></p>
        <p><strong>Observación Recibe:</strong> <?= $observacion_recibe ?? 'No disponible' ?></p>
        <p><strong>Valor:</strong> <?= $valor ?? 0 ?></p>
        <p><strong>Estado de Reserva:</strong> <?= $estado_reserva ?? 'No disponible' ?></p>

        <p>Gracias por utilizar nuestro servicio.</p>
        <p>Atentamente,<br>El equipo de Admired</p>

    </div>
</body>

</html>