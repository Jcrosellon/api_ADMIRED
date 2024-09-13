<?php

namespace App\Controllers;

use App\Models\ReservasModel;
use CodeIgniter\RESTful\ResourceController;

class Reservas extends ResourceController
{
    protected $modelName = 'App\Models\ReservasModel';
    protected $format    = 'json';

    public function create()
    {
        $data = $this->request->getJSON(true); // Obtener como array

        // Verifica la codificación de los datos antes de insertarlos
        $data = array_map(function ($value) {
            return mb_convert_encoding($value, 'UTF-8', 'auto');
        }, $data);

        if ($this->model->insert($data)) {
            return $this->respondCreated(['status' => 'success']);
        } else {
            return $this->failServerError('No se pudo crear la reserva');
        }
    }
}
