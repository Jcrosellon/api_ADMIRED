<?php

namespace App\Controllers;

use App\Models\UnidadesResidencialesModel;

class UnidadesResidenciales extends BaseController
{
    protected $unidadesResidencialesModel;

    public function __construct()
    {
        $this->unidadesResidencialesModel = new UnidadesResidencialesModel();
    }

    public function getByUserId($userId)
    {
        // Suponiendo que tienes un método en tu modelo para obtener la unidad por ID del propietario
        $unidad = $this->unidadesResidencialesModel->getByUserId($userId);

        if ($unidad) {
            return $this->response->setJSON($unidad);
        } else {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Unidad residencial no encontrada']);
        }
    }
}
