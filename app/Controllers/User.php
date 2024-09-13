<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class User extends BaseController
{


    public function index()
    {
        $userModel = new UserModel();
        $users = $userModel->findAll();

        $dataResult = [
            "data" => $users,
            "message" => 'Lista de user',
            "response" => ResponseInterface::HTTP_OK,
        ];

        return $this->response->setJSON($dataResult);
    }



    public function show($id)
    {
        $userModel = new UserModel();
        $users = $userModel->find($id);

        if ($users) {
            $dataResult = [
                "data" => $users,
                "message" => 'User Encontrado',
                "response" => ResponseInterface::HTTP_OK,
            ];
        } else {
            $dataResult = [
                "data" => '',
                "message" => 'User no encontrado',
                "response" => ResponseInterface::HTTP_NOT_FOUND,
            ];
        }

        return $this->response->setJSON($dataResult);
    }

    public function update($id)
    {
        $userModel = new UserModel();

        // Obtener el usuario actual
        $users = $userModel->find($id);

        // Verificar si el usuario existe
        if ($users) {
            // Obtener los datos del formulario
            $data = [
                'email' => $this->request->getVar('email') ?? $users['email'],
                'password' => $this->request->getVar('password') ? password_hash($this->request->getVar('password'), PASSWORD_DEFAULT) : $users['password'],
            ];

            // Actualizar el usuario en la base de datos
            if ($userModel->update($id, $data)) {
                $dataResult = [
                    "data" => $data,
                    "message" => 'User actualizado',
                    "response" => ResponseInterface::HTTP_OK,
                ];
            } else {
                $dataResult = [
                    "data" => '',
                    "message" => 'Error al actualizar user',
                    "response" => ResponseInterface::HTTP_INTERNAL_SERVER_ERROR,
                ];
            }
        } else {
            $dataResult = [
                "data" => '',
                "message" => 'User no encontrado',
                "response" => ResponseInterface::HTTP_NOT_FOUND,
            ];
        }

        return $this->response->setJSON($dataResult);
    }

    public function delete($id)
    {
        $userModel = new UserModel();

        // Obtener el usuario actual
        $users = $userModel->find($id);

        // Verificar si el usuario existe
        if ($users) {
            // Eliminar el usuario de la base de datos
            if ($userModel->delete($id)) {
                $dataResult = [
                    "data" => $users,
                    "message" => 'User eliminado correctamente',
                    "response" => ResponseInterface::HTTP_OK,
                ];
            } else {
                $dataResult = [
                    "data" => '',
                    "message" => 'Error al eliminar user',
                    "response" => ResponseInterface::HTTP_INTERNAL_SERVER_ERROR,
                ];
            }
        } else {
            $dataResult = [
                "data" => '',
                "message" => 'User no encontrado',
                "response" => ResponseInterface::HTTP_NOT_FOUND,
            ];
        }

        return $this->response->setJSON($dataResult);
    }
}
