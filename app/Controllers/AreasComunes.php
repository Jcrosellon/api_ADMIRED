<?php

namespace App\Controllers;

use App\Models\AreasComunesModel;
use CodeIgniter\RESTful\ResourceController;

class AreasComunes extends ResourceController
{
    protected $modelName = 'App\Models\AreasComunesModel';
    protected $format    = 'json';

    public function index()
    {
        $areas = $this->model->findAll();

        if ($areas) {
            return $this->respond($areas);
        } else {
            return $this->failNotFound('No se encontraron áreas comunes');
        }
    }

    public function show($id = null)
    {
        $area = $this->model->find($id);
        if ($area) {
            return $this->respond($area);
        } else {
            return $this->failNotFound('Área común no encontrada');
        }
    }
}
