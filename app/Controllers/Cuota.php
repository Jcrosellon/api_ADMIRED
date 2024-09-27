<?php

namespace App\Controllers;

use App\Models\CuotaModel;
use CodeIgniter\HTTP\ResponseInterface;

class Cuota extends BaseController
{
    public function create()
    {
        $cuotaModel = new CuotaModel();
        $unidadResidencialId = $this->request->getVar('UNIDAD_RESIDENCIAL_ID');
        $estado = $this->request->getVar('ESTADO');

        // Registra los valores recibidos
        log_message('debug', 'UNIDAD_RESIDENCIAL_ID: ' . $unidadResidencialId);
        log_message('debug', 'ESTADO: ' . $estado);

        // Verifica si hay cuotas disponibles para la unidad residencial
        $cuotasDisponibles = $cuotaModel->where('UNIDAD_RESIDENCIAL_ID', $unidadResidencialId)
            ->where('ESTADO', $estado)
            ->findAll();

        // Registra las cuotas encontradas
        log_message('debug', 'Cuotas Disponibles: ' . print_r($cuotasDisponibles, true));

        if (empty($cuotasDisponibles)) {
            return $this->response->setJSON([
                'data' => '',
                'message' => 'No hay cuotas disponibles para esta unidad residencial.',
                'response' => ResponseInterface::HTTP_NOT_FOUND,
            ]);
        }

        // Si hay cuotas disponibles, continúa con la creación de una nueva cuota
        $data = [
            'FECHA_MES' => $this->request->getVar('FECHA_MES'),
            'ESTADO' => $this->request->getVar('ESTADO'),
            'VALOR' => $this->request->getVar('VALOR'),
            'NO_APTO' => $this->request->getVar('NO_APTO'),
            'FECHA_PAGO' => $this->request->getVar('FECHA_PAGO'),
            'UNIDAD_RESIDENCIAL_ID' => $unidadResidencialId
        ];

        log_message('debug', 'Datos a Insertar: ' . print_r($data, true));

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




    // Nuevo método para obtener la cuota por ID de unidad residencial
    public function showByUser($unidadResidencialId)
    {
        $cuotaModel = new CuotaModel();

        // Busca la cuota de administración de la unidad residencial por ID
        $cuota = $cuotaModel->where('UNIDAD_RESIDENCIAL_ID', $unidadResidencialId)->first();

        if ($cuota) {
            $dataResult = [
                "data" => $cuota,
                "message" => 'Cuota Encontrada',
                "response" => ResponseInterface::HTTP_OK,
            ];
        } else {
            $dataResult = [
                "data" => '',
                "message" => 'No hay cuota de administración para esta unidad residencial',
                "response" => ResponseInterface::HTTP_NOT_FOUND,
            ];
        }

        return $this->response->setJSON($dataResult);
    }

    public function show($id)
    {
        $cuotaModel = new CuotaModel();
        $cuota = $cuotaModel->find($id);

        if ($cuota) {
            return $this->response->setJSON([
                'data' => $cuota,
                'message' => 'Cuota encontrada',
                'response' => ResponseInterface::HTTP_OK,
            ]);
        } else {
            return $this->response->setJSON([
                'data' => '',
                'message' => 'No se encontró la cuota',
                'response' => ResponseInterface::HTTP_NOT_FOUND,
            ]);
        }
    }

    public function update($id)
    {
        $cuotaModel = new CuotaModel();

        // Verifica si la cuota existe
        $cuota = $cuotaModel->find($id);
        if (!$cuota) {
            return $this->response->setJSON([
                'data' => '',
                'message' => 'Cuota no encontrada',
                'response' => ResponseInterface::HTTP_NOT_FOUND,
            ]);
        }

        // Datos de la solicitud
        $data = [
            'FECHA_MES' => $this->request->getVar('FECHA_MES'),
            'ESTADO' => $this->request->getVar('ESTADO'),
            'VALOR' => $this->request->getVar('VALOR'),
            'NO_APTO' => $this->request->getVar('NO_APTO'),
            'FECHA_PAGO' => $this->request->getVar('FECHA_PAGO'),
            'UNIDAD_RESIDENCIAL_ID' => $this->request->getVar('UNIDAD_RESIDENCIAL_ID'),
        ];

        // Actualiza la cuota en la base de datos
        if ($cuotaModel->update($id, $data)) {
            return $this->response->setJSON([
                'data' => $data,
                'message' => 'Cuota actualizada exitosamente',
                'response' => ResponseInterface::HTTP_OK,
            ]);
        } else {
            return $this->response->setJSON([
                'data' => '',
                'message' => 'Error al actualizar la cuota',
                'response' => ResponseInterface::HTTP_CONFLICT,
            ]);
        }
    }

    public function delete($id)
    {
        $cuotaModel = new CuotaModel();

        // Verifica si la cuota existe
        $cuota = $cuotaModel->find($id);
        if (!$cuota) {
            return $this->response->setJSON([
                'data' => '',
                'message' => 'Cuota no encontrada',
                'response' => ResponseInterface::HTTP_NOT_FOUND,
            ]);
        }

        // Elimina la cuota de la base de datos
        if ($cuotaModel->delete($id)) {
            return $this->response->setJSON([
                'data' => '',
                'message' => 'Cuota eliminada exitosamente',
                'response' => ResponseInterface::HTTP_OK,
            ]);
        } else {
            return $this->response->setJSON([
                'data' => '',
                'message' => 'Error al eliminar la cuota',
                'response' => ResponseInterface::HTTP_CONFLICT,
            ]);
        }
    }
}
