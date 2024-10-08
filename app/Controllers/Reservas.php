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

        // Validar datos
        if (!$this->validate($this->model->validationRules)) {
            $errors = $this->validator->getErrors();
            return $this->response->setJSON(['errors' => $errors])->setStatusCode(400);
        }

        // Comprobar si FECHA_FIN es mayor que FECHA_RESERVA
        if (new \DateTime($data['FECHA_FIN']) <= new \DateTime($data['FECHA_RESERVA'])) {
            return $this->response->setJSON(['errors' => ['FECHA_FIN' => 'La fecha de fin debe ser posterior a la fecha de inicio.']])->setStatusCode(400);
        }

        // Comprobar duración de la reserva
        $fechaInicio = new \DateTime($data['FECHA_RESERVA']);
        $fechaFin = new \DateTime($data['FECHA_FIN']);
        $intervalo = $fechaInicio->diff($fechaFin);

        // Validar que la duración sea máxima de 4 horas
        if ($intervalo->h > 4 || ($intervalo->h == 4 && $intervalo->i > 0)) {
            return $this->response->setJSON(['error' => 'La duración de la reserva no puede ser mayor a 4 horas.'])->setStatusCode(409);
        }

        // Verificar si ya hay reservas en ese rango
        $conflicto = $this->model->where('ID_AREA_COMUN', $data['ID_AREA_COMUN'])
            ->where('FECHA_RESERVA <', $data['FECHA_FIN'])  // Modificado
            ->where('FECHA_FIN >', $data['FECHA_RESERVA'])  // Modificado
            ->first();

        if ($conflicto) {
            return $this->response->setJSON(['error' => 'Ya existe una reserva en este horario para el área común seleccionada.'])->setStatusCode(409);
        }

        // Verifica la codificación de los datos antes de insertarlos
        $data = array_map(function ($value) {
            return mb_convert_encoding($value, 'UTF-8', 'auto');
        }, $data);

        // Asegúrate de incluir ID_ESTADO_RESERVA al insertar
        if (!isset($data['ID_ESTADO_RESERVA'])) {
            $data['ID_ESTADO_RESERVA'] = 1; // Valor predeterminado
        }

        if ($this->model->insert($data)) {
            return $this->respondCreated(['status' => 'success']);
        } else {
            $error = $this->model->errors();
            log_message('error', 'Error al insertar la reserva: ' . print_r($error, true));
            return $this->failServerError('No se pudo crear la reserva');
        }
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

    public function update($id = null)
    {
        $data = $this->request->getJSON(true);

        // Verifica si la reserva existe
        if (!$this->model->find($id)) {
            return $this->failNotFound('Reserva no encontrada');
        }

        // Validar datos
        $validation = Services::validation();
        if (!$this->validate($validation->getRuleGroup('reservas'))) {
            $errors = $validation->getErrors();
            return $this->response->setJSON(['errors' => $errors])->setStatusCode(400);
        }

        // Verifica la codificación de los datos antes de actualizarlos
        $data = array_map(function ($value) {
            return mb_convert_encoding($value, 'UTF-8', 'auto');
        }, $data);

        if ($this->model->update($id, $data)) {
            return $this->respondUpdated(['status' => 'success']);
        } else {
            // Agrega un mensaje de error para más detalles
            $error = $this->model->errors();
            log_message('error', 'Error al actualizar la reserva: ' . print_r($error, true));
            return $this->failServerError('No se pudo actualizar la reserva');
        }
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
