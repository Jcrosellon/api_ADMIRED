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
        $validation = Services::validation();
        if (! $this->validate($validation->getRuleGroup('reservas'))) {
            $errors = $validation->getErrors();
            return $this->response->setJSON(['errors' => $errors])->setStatusCode(400);
        }

        // Verifica la codificación de los datos antes de insertarlos
        $data = array_map(function ($value) {
            return mb_convert_encoding($value, 'UTF-8', 'auto');
        }, $data);

        if ($this->model->insert($data)) {
            return $this->respondCreated(['status' => 'success']);
        } else {
            // Agrega un mensaje de error para más detalles
            $error = $this->model->errors();
            log_message('error', 'Error al insertar la reserva: ' . print_r($error, true));
            return $this->failServerError('No se pudo crear la reserva');
        }
    }



    private function getValidationRules()
    {
        // Reemplaza este array con las reglas de validación de tu grupo 'reservas'
        return [
            'FECHA_RESERVA' => 'required|valid_date',
            'ID_AREA_COMUN' => 'required|integer',
            'ESTADO_RESERVA' => 'required|string',
            'ID_USUARIO' => 'required|integer',
            'OBSERVACION_ENTREGA' => 'permit_empty|string',
            'OBSERVACION_RECIBE' => 'permit_empty|string',
            'VALOR' => 'required|decimal',
        ];
    }

    public function show($id = null)
    {
        $reservasModel = new ReservasModel();

        // Verifica si la reserva existe
        $reserva = $reservasModel->find($id);

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
        if (! $this->validate($validation->getRuleGroup('reservas'))) {
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
