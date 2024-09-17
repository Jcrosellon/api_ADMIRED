<?php

namespace App\Controllers;

use App\Models\CuotaModel;
use CodeIgniter\HTTP\ResponseInterface;

class Cuota extends BaseController
{
    public function create()
    {
        $cuotaModel = new CuotaModel();
        $userId = $this->request->getVar('USER_ID');

        // Verifica si hay cuotas disponibles para el usuario
        $cuotasDisponibles = $cuotaModel->where('ID_USUARIO', $userId)
            ->where('ESTADO', 'pendiente') // O el estado que consideres
            ->findAll();

        if (empty($cuotasDisponibles)) {
            return $this->response->setJSON([
                'data' => '',
                'message' => 'No hay cuotas disponibles para este usuario.',
                'response' => ResponseInterface::HTTP_NOT_FOUND,
            ]);
        }

        // Si hay cuotas disponibles, continua con la creación de una nueva cuota
        $data = [
            'FECHA_MES' => $this->request->getVar('FECHA_MES'),
            'ESTADO' => $this->request->getVar('ESTADO'),
            'VALOR' => $this->request->getVar('VALOR'),
            'NO_APTO' => $this->request->getVar('NO_APTO'),
            'FECHA_PAGO' => $this->request->getVar('FECHA_PAGO'),
            'ID_USUARIO' => $userId
        ];

        if ($cuotaModel->insert($data)) {
            return $this->response->setJSON([
                'data' => $data,
                'message' => 'Cuota creada exitosamente',
                'response' => ResponseInterface::HTTP_OK,
            ]);
        } else {
            return $this->response->setJSON([
                'data' => '',
                'message' => 'Error al crear la cuota',
                'response' => ResponseInterface::HTTP_CONFLICT,
            ]);
        }
    }



    // Nuevo método para obtener la cuota por ID de usuario
    public function showByUser($userId)
    {
        $cuotaModel = new CuotaModel();

        // Busca la cuota de administración del usuario por ID
        $cuota = $cuotaModel->where('UNIDAD_RESIDENCIAL_ID', $userId)->first();

        if ($cuota) {
            $dataResult = [
                "data" => $cuota,
                "message" => 'Cuota Encontrada',
                "response" => ResponseInterface::HTTP_OK,
            ];
        } else {
            $dataResult = [
                "data" => '',
                "message" => 'No hay cuota de administración para este usuario',
                "response" => ResponseInterface::HTTP_NOT_FOUND,
            ];
        }

        return $this->response->setJSON($dataResult);
    }
}
