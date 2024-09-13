<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ZonasComunesModel;

class ZonasComunes extends ResourceController
{
    protected $modelName = 'App\Models\ZonasComunesModel';
    protected $format    = 'json';

    public function index()
    {
        try {
            $zonas = $this->model->findAll();

            // Limpiar los datos para asegurar codificación UTF-8
            $zonas = array_map(function ($item) {
                return array_map('utf8_encode', $item);
            }, $zonas);

            if ($zonas) {
                return $this->respond($zonas);
            } else {
                return $this->failNotFound('No se encontraron zonas comunes');
            }
        } catch (\Exception $e) {
            return $this->failServerError('Error en la respuesta JSON: ' . $e->getMessage());
        }
    }
}
