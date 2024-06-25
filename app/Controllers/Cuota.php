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
        //var_dump($this->request->getPost("fecha"));
        $data = [
            'FECHA' => $this->request->getPost('FECHA'),
            'ESTADO' => $this->request->getPost('ESTADO'),
            'FECHA_LIMITE' => $this->request->getPost('FECHA_LIMITE'),
            'PRECIO' => $this->request->getPost('PRECIO'),
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
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: *");
        header("Access-Control-Allow-Headers: *");   
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

    // Obtener el usuario actual
    $cuota = $cuotaModel->find($id);

    // Verificar si el usuario existe
    if ($cuota) {
        // Obtener los datos del formulario
        $data = [
            'FECHA' => $this->request->getVar('FECHA') ?? $cuota['FECHA'],
            'ESTADO' => $this->request->getVar('ESTADO') ?? $cuota['ESTADO'],
            'FECHA_LIMITE' => $this->request->getVar('FECHA_LIMITE') ?? $cuota['FECHA_LIMITE'],
            'PRECIO' => $this->request->getVar('PRECIO') ?? $cuota['PRECIO'],
        ];

        // Actualizar el usuario en la base de datos
        if ($cuotaModel->update($id, $data)) {
            $dataResult = [
                "data" => $data,
                "message" => 'Unidad actualizado',
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
            "message" => 'Unidad no encontrado',
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
