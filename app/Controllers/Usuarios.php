<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Usuarios extends ResourceController
{
    protected $modelName = 'App\Models\UsuariosModel';
    protected $format = 'json';

    public function create()
    {
        $data = $this->request->getJSON(true);

        log_message('debug', 'Data received for creation: ' . print_r($data, true));

        if (!$data || empty($data)) {
            return $this->failValidationErrors(['No data provided']);
        }

        // Encriptar la contraseña
        if (isset($data['CONTRASENA'])) {
            $data['CONTRASENA'] = password_hash($data['CONTRASENA'], PASSWORD_DEFAULT);
        }

        if ($this->model->insert($data) === false) {
            return $this->failValidationErrors($this->model->errors());
        }

        return $this->respondCreated($data);
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);
        if ($data) {
            return $this->respond($data);
        }

        return $this->failNotFound('User not found');
    }

    public function update($id = null)
    {
        // Obtener los datos de la solicitud
        $data = $this->request->getJSON(true); // Cambiado a getJSON(true)

        log_message('debug', 'Data received for update: ' . print_r($data, true));

        if (!$data || empty($data)) {
            return $this->failValidationErrors('No data provided.');
        }

        // Encriptar la contraseña si está presente
        if (isset($data['CONTRASENA'])) {
            $data['CONTRASENA'] = password_hash($data['CONTRASENA'], PASSWORD_DEFAULT);
        }

        $updateData = [
            'NOMBRE' => $data['NOMBRE'] ?? null,
            'APELLIDO' => $data['APELLIDO'] ?? null,
            'EMAIL' => $data['EMAIL'] ?? null,
            'CONTRASENA' => isset($data['CONTRASENA']) ? $data['CONTRASENA'] : null,
            'TELEFONO' => $data['TELEFONO'] ?? null,
            'TORRE' => $data['TORRE'] ?? null,
            'APTO' => $data['APTO'] ?? null,
        ];

        $updateStatus = $this->model->update($id, $updateData);

        if ($updateStatus) {
            return $this->respondUpdated($updateData);
        } else {
            return $this->failServerError('Failed to update user.');
        }
    }




    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['id' => $id]);
        }

        return $this->failNotFound('User not found');
    }
}
