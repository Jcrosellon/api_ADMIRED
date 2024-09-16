<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PqrModel;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Config\Validation;

class Pqr extends BaseController
{
    public function create()
    {
        $pqrModel = new PqrModel();
        $validation = Services::validation();

        // Obtener datos del request
        $data = [
            'DETALLE' => $this->request->getVar('DETALLE'),
            'ESTADO_ID' => $this->request->getVar('ESTADO_ID'),
            'USUARIO_ID' => $this->request->getVar('USUARIO_ID'),
            'PQR_TIPO_ID' => (int) $this->request->getVar('PQR_TIPO_ID'),  // Convertir a entero
            'FECHA_SOLICITUD' => $this->request->getVar('FECHA_SOLICITUD'),
            'FECHA_RESPUESTA' => $this->request->getVar('FECHA_RESPUESTA'),
            'RESPUESTA' => $this->request->getVar('RESPUESTA'),
        ];

        // Aplicar reglas de validación
        $validation->setRules((new Validation())->pqr);

        if (!$validation->run($data)) {
            return $this->response->setJSON([
                'data' => '',
                'message' => 'Datos inválidos',
                'response' => ResponseInterface::HTTP_BAD_REQUEST,
                'errors' => $validation->getErrors()
            ]);
        }

        // Insertar datos
        $insertID = $pqrModel->insert($data);

        if ($insertID) {
            return $this->response->setJSON([
                "data" => $data,
                "message" => 'PQR Creado',
                "response" => ResponseInterface::HTTP_CREATED,
            ]);
        } else {
            return $this->response->setJSON([
                "data" => '',
                "message" => 'Error al crear PQR',
                "response" => ResponseInterface::HTTP_CONFLICT,
            ]);
        }
    }


    public function getTypes()
    {
        $pqrModel = new PqrModel();
        $types = $pqrModel->findAll(); // Ajusta esto si tienes un modelo separado para los tipos de PQR

        // Suponiendo que tienes una tabla separada para los tipos de PQR
        $pqrTipoModel = new \App\Models\PqrTipoModel();
        $types = $pqrTipoModel->findAll();

        return $this->response->setJSON([
            'data' => $types,
            'message' => 'Tipos de PQR obtenidos',
            'response' => ResponseInterface::HTTP_OK,
        ]);
    }
}
