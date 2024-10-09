<?php

namespace App\Controllers;

use App\Models\ReservasModel;
use CodeIgniter\RESTful\ResourceController;
use Config\Services;

class Reservas extends ResourceController
{
    protected $modelName = 'App\Models\ReservasModel';
    protected $format    = 'json';

    public function create()
    {
        $data = $this->request->getJSON(true);

        // Validar los datos de entrada
        if (!$this->validate($this->model->validationRules)) {
            $errors = $this->validator->getErrors();
            return $this->response->setJSON(['errors' => $errors])->setStatusCode(400);
        }

        // Verificar que la fecha de fin sea posterior a la de inicio
        if (new \DateTime($data['FECHA_FIN']) <= new \DateTime($data['FECHA_RESERVA'])) {
            return $this->response->setJSON(['errors' => ['FECHA_FIN' => 'La fecha de fin debe ser posterior a la fecha de inicio.']])->setStatusCode(400);
        }

        // Calcular la duración de la reserva
        $fechaInicio = new \DateTime($data['FECHA_RESERVA']);
        $fechaFin = new \DateTime($data['FECHA_FIN']);
        $intervalo = $fechaInicio->diff($fechaFin);

        // Verificar que la duración no exceda las 4 horas
        if ($intervalo->h > 4 || ($intervalo->h == 4 && $intervalo->i > 0)) {
            return $this->response->setJSON(['error' => 'La duración de la reserva no puede ser mayor a 4 horas.'])->setStatusCode(409);
        }

        // Verificar conflictos con otras reservas
        $conflicto = $this->model->where('ID_AREA_COMUN', $data['ID_AREA_COMUN'])
            ->where('FECHA_RESERVA <', $data['FECHA_FIN'])
            ->where('FECHA_FIN >', $data['FECHA_RESERVA'])
            ->first();

        if ($conflicto) {
            return $this->response->setJSON(['error' => 'Ya existe una reserva en este horario para el área común seleccionada.'])->setStatusCode(409);
        }

        // Convertir los valores a UTF-8
        $data = array_map(function ($value) {
            return mb_convert_encoding($value, 'UTF-8', 'auto');
        }, $data);

        // Asignar estado de reserva por defecto si no está definido
        if (!isset($data['ID_ESTADO_RESERVA'])) {
            $data['ID_ESTADO_RESERVA'] = 1; // Estado por defecto (Pendiente)
        }

        // Mapeo de estados
        $estados = [
            1 => 'Pendiente',
            2 => 'Aprobada',
            3 => 'Cancelada',
        ];

        // Insertar la reserva en la base de datos
        if ($this->model->insert($data)) {
            // Obtener el nombre del usuario
            $usuarioModel = new \App\Models\UsuariosModel();
            $usuario = $usuarioModel->find($data['ID_USUARIO']);
            $nombreUsuario = $usuario['nombre'] ?? 'Usuario desconocido';

            // Preparar los datos del correo
            $estadoReserva = $estados[$data['ID_ESTADO_RESERVA']] ?? 'Desconocido';
            $emailData = [
                "FECHA_RESERVA" => $data['FECHA_RESERVA'],
                "FECHA_FIN" => $data['FECHA_FIN'],
                "ID_AREA_COMUN" => $data['ID_AREA_COMUN'],
                "NOMBRE_USUARIO" => $nombreUsuario, // Nombre del usuario
                "OBSERVACION_ENTREGA" => $data['OBSERVACION_ENTREGA'] ?? '',
                "OBSERVACION_RECIBE" => $data['OBSERVACION_RECIBE'] ?? '',
                "VALOR" => $data['VALOR'],
                "ID_ESTADO_RESERVA" => $data['ID_ESTADO_RESERVA'], // Usar ID para estado
                "email_usuario" => $data['email_usuario']
            ];

            // Enviar correo de confirmación de reserva
            $this->sendEmail($data['email_usuario'], 'Confirmación de Reserva', $emailData);

            return $this->respondCreated(['status' => 'success']);
        } else {
            // Manejar errores en la inserción
            $error = $this->model->errors();
            log_message('error', 'Error al insertar la reserva: ' . print_r($error, true));
            return $this->failServerError('No se pudo crear la reserva');
        }
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON(true);

        if (!$this->model->find($id)) {
            return $this->failNotFound('Reserva no encontrada');
        }

        $validation = Services::validation();
        if (!$this->validate($validation->getRuleGroup('reservas'))) {
            $errors = $validation->getErrors();
            return $this->response->setJSON(['errors' => $errors])->setStatusCode(400);
        }

        $data = array_map(function ($value) {
            return mb_convert_encoding($value, 'UTF-8', 'auto');
        }, $data);

        if ($this->model->update($id, $data)) {
            // Enviar correo de actualización de estado
            $this->sendEmail($data['email_usuario'], 'Actualización de Reserva', [
                'FECHA_RESERVA' => $data['FECHA_RESERVA'] ?? 'No disponible',
                'FECHA_FIN' => $data['FECHA_FIN'] ?? 'No disponible',
                'NOMBRE_USUARIO' => 'Usuario desconocido', // Cambiar según necesites
                'OBSERVACION_ENTREGA' => $data['OBSERVACION_ENTREGA'] ?? 'No disponible',
                'OBSERVACION_RECIBE' => $data['OBSERVACION_RECIBE'] ?? 'No disponible',
                'VALOR' => $data['VALOR'] ?? 0,
                'ID_ESTADO_RESERVA' => $data['ID_ESTADO_RESERVA'] ?? 'No disponible',
                'email_usuario' => $data['email_usuario']
            ]);

            return $this->respondUpdated(['status' => 'success']);
        } else {
            $error = $this->model->errors();
            log_message('error', 'Error al actualizar la reserva: ' . print_r($error, true));
            return $this->failServerError('No se pudo actualizar la reserva');
        }
    }

    private function sendEmail($to, $subject, $data)
    {
        // Verifica si $data es un array
        if (!is_array($data)) {
            log_message('error', 'El argumento data no es un array: ' . print_r($data, true));
            return; // O lanza una excepción según sea necesario
        }

        $email = Services::email();
        $email->setTo($to);
        $email->setFrom('joserosellonl@gmail.com', 'Admired');
        $email->setSubject($subject);

        // Cargar la plantilla de correo
        $message = view('email_template', [
            'fecha_reserva' => $data['FECHA_RESERVA'] ?? 'No disponible',
            'fecha_fin' => $data['FECHA_FIN'] ?? 'No disponible',
            'id_area_comun' => $data['ID_AREA_COMUN'] ?? 'No disponible',
            'nombre_usuario' => $data['NOMBRE_USUARIO'] ?? 'No disponible', // Usar NOMBRE_USUARIO
            'observacion_entrega' => $data['OBSERVACION_ENTREGA'] ?? 'No disponible',
            'observacion_recibe' => $data['OBSERVACION_RECIBE'] ?? 'No disponible',
            'valor' => $data['VALOR'] ?? 0,
            'estado_reserva' => $data['ID_ESTADO_RESERVA'] ?? 'No disponible',
        ]);

        // Establecer el mensaje como HTML
        $email->setMessage($message);
        $email->setMailType('html'); // Asegúrate de enviar como HTML

        if (!$email->send()) {
            log_message('error', 'Error al enviar el correo: ' . $email->printDebugger(['headers']));
        }
        return true; // Si se envió correctamente
    }

    public function show($id = null)
    {
        // Verifica si la reserva existe
        $reserva = $this->model->find($id);

        if (!$reserva) {
            return $this->failNotFound('Reserva no encontrada');
        }

        return $this->respond($reserva);
    }

    public function delete($id = null)
    {
        // Verifica si la reserva existe
        if (!$this->model->find($id)) {
            return $this->failNotFound('Reserva no encontrada');
        }

        if ($this->model->delete($id)) {
            return $this->respondDeleted(['status' => 'success']);
        } else {
            // Agrega un mensaje de error para más detalles
            log_message('error', 'Error al eliminar la reserva con ID: ' . $id);
            return $this->failServerError('No se pudo eliminar la reserva');
        }
    }
}
