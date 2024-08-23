<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PqrModel;
use CodeIgniter\HTTP\ResponseInterface;

class Pqr extends BaseController
{
    public function create()
    {
        $pqrModel = new PqrModel();

        $data = [
            'DETALLE' => $this->request->getVar('DETALLE'),
            'ESTADO_ID' => $this->request->getVar('ESTADO_ID'),
            'USUARIO_ID' => $this->request->getVar('USUARIO_ID'),
            'PQR_TIPO' => $this->request->getVar('PQR_TIPO'),
            'FECHA_SOLICITUD' => $this->request->getVar('FECHA_SOLICITUD'),
            'FECHA_RESPUESTA' => $this->request->getVar('FECHA_RESPUESTA'),
            'RESPUESTA' => $this->request->getVar('RESPUESTA'),
        ];

        // Verificar si los datos están bien formateados
        if (empty($data['DETALLE']) || empty($data['ESTADO_ID']) || empty($data['USUARIO_ID']) || empty($data['PQR_TIPO'])) {
            return $this->response->setJSON([
                'data' => '',
                'message' => 'Campos requeridos faltantes',
                'response' => ResponseInterface::HTTP_BAD_REQUEST
            ]);
        }

        $insertID = $pqrModel->insert($data);

        if ($insertID) {
            $dataResult = [
                "data" => $data,
                "message" => 'PQR Creado',
                "response" => ResponseInterface::HTTP_CREATED,
            ];
        } else {
            $dataResult = [
                "data" => '',
                "message" => 'Error al crear PQR',
                "response" => ResponseInterface::HTTP_CONFLICT,
            ];
        }

        return $this->response->setJSON($dataResult);
    }

    public function show($id)
    {
        $pqrModel = new PqrModel();
        $pqr = $pqrModel->find($id);

        if ($pqr) {
            $dataResult = [
                "data" => $pqr,
                "message" => 'PQR Encontrado',
                "response" => ResponseInterface::HTTP_OK,
            ];
        } else {
            $dataResult = [
                "data" => '',
                "message" => 'PQR no encontrado',
                "response" => ResponseInterface::HTTP_NOT_FOUND,
            ];
        }

        return $this->response->setJSON($dataResult);
    }


    public function update($id)
    {
        $pqrModel = new PqrModel();

        // Obtener el PQR actual
        $pqr = $pqrModel->find($id);

        // Verificar si el PQR existe
        if ($pqr) {
            $data = [
                'PQR_TIPO' => $this->request->getVar('PQR_TIPO') ?? $pqr['PQR_TIPO'],
                'ESTADO_ID' => $this->request->getVar('ESTADO_ID') ?? $pqr['ESTADO_ID'],
            ];

            // Verificar si los datos están bien formateados
            if (empty($data['PQR_TIPO']) || empty($data['ESTADO_ID'])) {
                return $this->response->setJSON([
                    'data' => '',
                    'message' => 'Campos requeridos faltantes',
                    'response' => ResponseInterface::HTTP_BAD_REQUEST
                ]);
            }

            // Actualizar el PQR en la base de datos
            if ($pqrModel->update($id, $data)) {
                $dataResult = [
                    "data" => $data,
                    "message" => 'PQR actualizado',
                    "response" => ResponseInterface::HTTP_OK,
                ];
            } else {
                $dataResult = [
                    "data" => '',
                    "message" => 'Error al actualizar PQR',
                    "response" => ResponseInterface::HTTP_INTERNAL_SERVER_ERROR,
                ];
            }
        } else {
            $dataResult = [
                "data" => '',
                "message" => 'PQR no encontrado',
                "response" => ResponseInterface::HTTP_NOT_FOUND,
            ];
        }

        return $this->response->setJSON($dataResult);
    }

    public function delete($id)
    {
        $pqrModel = new PqrModel();

        // Obtener el PQR actual
        $pqr = $pqrModel->find($id);

        // Verificar si el PQR existe
        if ($pqr) {
            // Eliminar el PQR de la base de datos
            if ($pqrModel->delete($id)) {
                $dataResult = [
                    "data" => $pqr,
                    "message" => 'PQR eliminado correctamente',
                    "response" => ResponseInterface::HTTP_OK,
                ];
            } else {
                $dataResult = [
                    "data" => '',
                    "message" => 'Error al eliminar PQR',
                    "response" => ResponseInterface::HTTP_INTERNAL_SERVER_ERROR,
                ];
            }
        } else {
            $dataResult = [
                "data" => '',
                "message" => 'PQR no encontrado',
                "response" => ResponseInterface::HTTP_NOT_FOUND,
            ];
        }

        return $this->response->setJSON($dataResult);
    }
}
