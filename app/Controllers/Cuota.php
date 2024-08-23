<?php

namespace App\Controllers;

use App\Controllers\BaseController;
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

    public function index()
    {
        $cuotaModel = new CuotaModel();
        $cuota = $cuotaModel->findAll();

        $dataResult = [
            "data" => $cuota,
            "message" => 'Lista de cuotas',
            "response" => ResponseInterface::HTTP_OK,
        ];

        return $this->response->setJSON($dataResult);
    }



    public function show($id)
    {
        $cuotaModel = new CuotaModel();
        $cuota = $cuotaModel->find($id);

        if ($cuota) {
            $dataResult = [
                "data" => $cuota,
                "message" => 'Cuota Encontrado',
                "response" => ResponseInterface::HTTP_OK,
            ];
        } else {
            $dataResult = [
                "data" => '',
                "message" => 'Unidad no encontrado',
                "response" => ResponseInterface::HTTP_NOT_FOUND,
            ];
        }

        return $this->response->setJSON($dataResult);
    }

    public function update($id)
    {
        $cuotaModel = new CuotaModel();

        // Obtener la cuota actual
        $cuota = $cuotaModel->find($id);

        // Verificar si la cuota existe
        if ($cuota) {
            // Obtener los datos del cuerpo de la solicitud como JSON
            $data = $this->request->getJSON(true);

            // Verificar si al menos un dato fue proporcionado
            if (!empty($data)) {
                // Actualizar la cuota en la base de datos
                if ($cuotaModel->update($id, $data)) {
                    $dataResult = [
                        "data" => $data,
                        "message" => 'Unidad actualizada',
                        "response" => ResponseInterface::HTTP_OK,
                    ];
                } else {
                    $dataResult = [
                        "data" => '',
                        "message" => 'Error al actualizar unidad',
                        "response" => ResponseInterface::HTTP_INTERNAL_SERVER_ERROR,
                    ];
                }
            } else {
                $dataResult = [
                    "data" => '',
                    "message" => 'No data provided',
                    "response" => ResponseInterface::HTTP_BAD_REQUEST,
                ];
            }
        } else {
            $dataResult = [
                "data" => '',
                "message" => 'Unidad no encontrada',
                "response" => ResponseInterface::HTTP_NOT_FOUND,
            ];
        }

        return $this->response->setJSON($dataResult);
    }


    public function delete($id)
    {
        $cuotaModel = new CuotaModel();

        // Obtener el usuario actual
        $cuota = $cuotaModel->find($id);

        // Verificar si el usuario existe
        if ($cuota) {
            // Eliminar el usuario de la base de datos
            if ($cuotaModel->delete($id)) {
                $dataResult = [
                    "data" => $cuota,
                    "message" => 'Unidad eliminada correctamente',
                    "response" => ResponseInterface::HTTP_OK,
                ];
            } else {
                $dataResult = [
                    "data" => '',
                    "message" => 'Error al eliminar unidad',
                    "response" => ResponseInterface::HTTP_INTERNAL_SERVER_ERROR,
                ];
            }
        } else {
            $dataResult = [
                "data" => '',
                "message" => 'Unidad no encontrado',
                "response" => ResponseInterface::HTTP_NOT_FOUND,
            ];
        }

        return $this->response->setJSON($dataResult);
    }
}
