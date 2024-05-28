<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UnidadesModel;
use CodeIgniter\HTTP\ResponseInterface;

class Unidades extends BaseController
{
    public function create()
    {
        $unidadesModel = new UnidadesModel();

        $data = [
            'NO_TORRE' => $this->request->getPost('NO_TORRE'),
            'NO_APARTAMENTO' => $this->request->getPost('NO_APARTAMENTO'),
            'NO_PAQUEADERO' => $this->request->getPost('NO_PAQUEADERO'),
            'NO_SALON_COMUNAL' => $this->request->getPost('NO_SALON_COMUNAL'),
        ];

        if ($unidadesModel->insert($data)) {
            $dataResult = [
                "data" => $data,
                "message" => 'Unidad Creada',
                "response" => ResponseInterface::HTTP_OK,
            ];
        } else {
            $dataResult = [
                "data" => '',
                "message" => 'Error al crear unidad',
                "response" => ResponseInterface::HTTP_CONFLICT,
            ];
        }

        return $this->response->setJSON($dataResult);
    }

    public function index()
{
    $unidadesModel = new UnidadesModel();
    $unidades = $unidadesModel->findAll();

    $dataResult = [
        "data" => $unidades,
        "message" => 'Lista de unidad',
        "response" => ResponseInterface::HTTP_OK,
    ];

    return $this->response->setJSON($dataResult);
}



    public function show($id)
    {
        $unidadesModel = new UnidadesModel();
        $unidades = $unidadesModel->find($id);

        if ($unidades) {
            $dataResult = [
                "data" => $unidades,
                "message" => 'Unidad Encontrado',
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
    $unidadesModel = new UnidadesModel();

    // Obtener el usuario actual
    $unidades = $unidadesModel->find($id);

    // Verificar si el usuario existe
    if ($unidades) {
        // Obtener los datos del formulario
        $data = [
            'NO_TORRE' => $this->request->getVar('NO_TORRE') ?? $unidades['NO_TORRE'],
            'NO_APARTAMENTO' => $this->request->getVar('NO_APARTAMENTO') ?? $unidades['NO_APARTAMENTO'],
            'NO_PAQUEADERO' => $this->request->getVar('NO_PAQUEADERO') ?? $unidades['NO_PAQUEADERO'],
            'NO_SALON_COMUNAL' => $this->request->getVar('NO_SALON_COMUNAL') ?? $unidades['NO_SALON_COMUNAL'],
        ];

        // Actualizar el usuario en la base de datos
        if ($unidadesModel->update($id, $data)) {
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
    $unidadesModel = new UnidadesModel();

    // Obtener el usuario actual
    $unidades = $unidadesModel->find($id);

    // Verificar si el usuario existe
    if ($unidades) {
        // Eliminar el usuario de la base de datos
        if ($unidadesModel->delete($id)) {
            $dataResult = [
                "data" => $unidades,
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
