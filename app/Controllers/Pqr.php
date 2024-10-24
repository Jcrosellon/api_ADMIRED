<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PqrModel;
use App\Models\UserModel; // Modelo del usuario
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

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
            'PQR_TIPO_ID' => (int) $this->request->getVar('PQR_TIPO_ID'),
            'FECHA_SOLICITUD' => date('Y-m-d H:i:s'),
            'FECHA_RESPUESTA' => $this->request->getVar('FECHA_RESPUESTA'), // Opcional
            'RESPUESTA' => $this->request->getVar('RESPUESTA'), // Opcional
        ];

        // Aplicar reglas de validación
        $validation->setRules((new \Config\Validation())->pqr);

        if (!$validation->run($data)) {
            return $this->response->setJSON([
                'data' => '',
                'message' => 'Datos inválidos',
                'response' => ResponseInterface::HTTP_BAD_REQUEST,
                'errors' => $validation->getErrors() // Devuelve los errores de validación
            ]);
        }

        // Procesar archivos si existen
        if ($this->request->getFiles()) {
            $files = $this->request->getFiles();
            $uploadPaths = [];

            foreach ($files as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName(); // Genera un nombre aleatorio
                    $file->move(WRITEPATH . 'uploads', $newName); // Mueve el archivo a la carpeta de uploads
                    $uploadPaths[] = WRITEPATH . 'uploads/' . $newName; // Guardar la ruta
                }
            }

            // Guardar la ruta de los archivos subidos en los datos de PQR (opcional)
            if (!empty($uploadPaths)) {
                $data['ARCHIVOS'] = json_encode($uploadPaths); // Asume que tienes un campo ARCHIVOS en la tabla PQR
            }
        }

        // Insertar datos
        $insertID = $pqrModel->insert($data);
        log_message('info', 'Datos a insertar en PQR: ' . json_encode($data));
        if ($insertID) {
            log_message('info', 'Datos de PQR insertados correctamente: ' . json_encode($data));
            return $this->response->setJSON([
                "data" => $data,
                "message" => 'PQR creado exitosamente',
                "response" => ResponseInterface::HTTP_CREATED,
            ]);
        } else {
            log_message('error', 'Error al crear PQR: ' . json_encode($data));
            return $this->response->setJSON([
                "data" => '',
                "message" => 'Error al crear PQR',
                "response" => ResponseInterface::HTTP_CONFLICT,
            ]);
        }
    }


    public function show($id)
    {
        $pqrModel = new PqrModel();
        $pqr = $pqrModel->find($id);

        if ($pqr) {
            return $this->response->setJSON([
                "data" => $pqr,
                "message" => 'PQR encontrado',
                "response" => ResponseInterface::HTTP_OK,
            ]);
        } else {
            return $this->response->setJSON([
                "data" => '',
                "message" => 'PQR no encontrado',
                "response" => ResponseInterface::HTTP_NOT_FOUND,
            ]);
        }
    }


    public function update($id)
    {
        $pqrModel = new PqrModel();

        // Verificar si el PQR existe
        $pqr = $pqrModel->find($id);

        if ($pqr) {
            // Obtener los datos de la solicitud
            $data = [
                'DETALLE' => $this->request->getVar('DETALLE'),
                'ESTADO_ID' => $this->request->getVar('ESTADO_ID'),
                'USUARIO_ID' => $this->request->getVar('USUARIO_ID'),
                'PQR_TIPO_ID' => (int) $this->request->getVar('PQR_TIPO_ID'),
                'FECHA_SOLICITUD' => date('Y-m-d', strtotime($this->request->getVar('FECHA_SOLICITUD'))),
                'FECHA_RESPUESTA' => !empty($this->request->getVar('FECHA_RESPUESTA')) ? date('Y-m-d', strtotime($this->request->getVar('FECHA_RESPUESTA'))) : null,
                'RESPUESTA' => $this->request->getVar('RESPUESTA'),
            ];

            // Actualizar el PQR
            if ($pqrModel->update($id, $data)) {
                $this->sendResponseEmail($data); // Enviar el correo electrónico

                return $this->response->setJSON([
                    "data" => $data,
                    "message" => 'PQR actualizado correctamente',
                    "response" => ResponseInterface::HTTP_OK,
                ]);
            } else {
                return $this->response->setJSON([
                    "data" => '',
                    "message" => 'Error al actualizar el PQR',
                    "response" => ResponseInterface::HTTP_INTERNAL_SERVER_ERROR,
                ]);
            }
        } else {
            return $this->response->setJSON([
                "data" => '',
                "message" => 'PQR no encontrado',
                "response" => ResponseInterface::HTTP_NOT_FOUND,
            ]);
        }
    }

    public function delete($id)
    {
        $pqrModel = new PqrModel();

        // Verificar si el PQR existe
        $pqr = $pqrModel->find($id);

        if ($pqr) {
            // Intentar eliminar el PQR
            if ($pqrModel->delete($id)) {
                return $this->response->setJSON([
                    "data" => '',
                    "message" => 'PQR eliminado correctamente',
                    "response" => ResponseInterface::HTTP_OK,
                ]);
            } else {
                return $this->response->setJSON([
                    "data" => '',
                    "message" => 'Error al eliminar el PQR',
                    "response" => ResponseInterface::HTTP_INTERNAL_SERVER_ERROR,
                ]);
            }
        } else {
            return $this->response->setJSON([
                "data" => '',
                "message" => 'PQR no encontrado',
                "response" => ResponseInterface::HTTP_NOT_FOUND,
            ]);
        }
    }

    private function sendResponseEmail($data)
    {
        // Instancia del modelo de usuario para obtener el correo
        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($data['USUARIO_ID']);

        if ($user && isset($user['email'])) {
            // Inicializa el servicio de correo
            $email = \Config\Services::email();

            // Configura el correo
            $email->setFrom('joserosellonl@gmail.com', 'admired'); // Cambia esto por tu correo y el nombre del remitente
            $email->setTo($user['email']);
            $nombre = isset($user['NOMBRE']) ? $user['NOMBRE'] : 'Usuario'; // Asegúrate de que el campo sea el correcto
            $email->setSubject('Respuesta a su PQR');
            $email->setMessage("Hola {$nombre},\n\nHemos respondido a su PQR:\n\n{$data['DETALLE']}\n\nRespuesta:\n{$data['RESPUESTA']}\n\nGracias por contactarnos.");

            // Envia el correo
            if ($email->send()) {
                log_message('info', "Correo enviado correctamente a {$user['email']}");
            } else {
                log_message('error', "Error al enviar el correo: " . $email->printDebugger());
                // Puedes lanzar una excepción si quieres manejarlo más arriba en la pila
            }
        } else {
            log_message('warning', "No se encontró el usuario o el correo.");
        }
    }
}
