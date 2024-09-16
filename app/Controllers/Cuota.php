<?php

namespace App\Controllers;

use App\Models\CuotaModel;
use CodeIgniter\HTTP\ResponseInterface;

class Cuota extends BaseController
{
    public function create()
    {
        $cuotaModel = new CuotaModel();
        $data = [
            'FECHA_MES' => $this->request->getPost('FECHA_MES'),
            'ESTADO' => $this->request->getPost('ESTADO'),
            'VALOR' => $this->request->getPost('VALOR'),
            'NO_APTO' => $this->request->getPost('NO_APTO'),
            'FECHA_PAGO' => $this->request->getPost('FECHA_PAGO'),
        ];

        // Validar datos
        $validation = \Config\Services::validation();
        if (!$validation->run($data, 'cuota')) {
            return $this->response->setJSON([
                'data' => '',
                'message' => 'Datos inválidos',
                'response' => ResponseInterface::HTTP_BAD_REQUEST,
                'errors' => $validation->getErrors()
            ]);
        }

        if ($cuotaModel->insert($data)) {
            $dataResult = [
                "data" => $data,
                "message" => 'Cuota Creada',
                "response" => ResponseInterface::HTTP_OK,
            ];
        } else {
            $dataResult = [
                "data" => '',
                "message" => 'Error al crear cuota',
                "response" => ResponseInterface::HTTP_CONFLICT,
            ];
        }

        return $this->response->setJSON($dataResult);
    }
}
