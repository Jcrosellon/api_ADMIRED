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
        $baseUrl = 'http://localhost/SENA/api_ADMIRED/subirImagenes/imagenes_zonas_comunes/'; // Ajusta esto según tu configuración

        if ($areas) {
            foreach ($areas as &$area) {
                $area['IMAGEN_URL'] = $baseUrl . basename($area['IMAGEN_URL']); // Asume que 'IMAGEN_URL' es el campo en la base de datos
            }
            return $this->respond($areas);
        } else {
            return $this->failNotFound('No se encontraron áreas comunes');
        }
    }

    public function show($id = null)
    {
        $area = $this->model->find($id);
        $baseUrl = 'http://localhost/SENA/api_ADMIRED/subirImagenes/imagenes_zonas_comunes/'; // Cambia esto si es necesario

        if ($area) {
            $area['IMAGEN_URL'] = $baseUrl . basename($area['IMAGEN_URL']); // Usa IMAGEN_URL
            return $this->respond($area);
        } else {
            return $this->failNotFound('Área común no encontrada');
        }
    }
}
