<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PqrTipoModel;
use CodeIgniter\HTTP\ResponseInterface;

class PqrTipo extends BaseController
{
    public function index()
    {
        $pqrTipoModel = new PqrTipoModel();
        $types = $pqrTipoModel->findAll();

        return $this->response->setJSON([
            'data' => $types,
            'message' => 'Tipos de PQR obtenidos',
            'response' => ResponseInterface::HTTP_OK,
        ]);
    }

    // Otros métodos como create, show, update, delete si es necesario
}
