<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class UserController extends ResourceController
{
    protected $modelName = 'App\Models\UserModel';
    protected $format = 'json';

    // Método para obtener el token de autorización
    private function getAuthToken() {
        $headers = $this->request->getServer('HTTP_AUTHORIZATION');
        if ($headers && strpos($headers, 'Bearer ') === 0) {
            return trim(substr($headers, 7));
        }
        return null;
    }

    // Método para validar el token de Firebase
    private function validateFirebaseToken($token) {
        $firebasePublicKey = 'YOUR_FIREBASE_PUBLIC_KEY'; // Asegúrate de obtener la clave pública de Firebase
        try {
            $decoded = JWT::decode($token, new Key($firebasePublicKey, 'RS256'));
            return $decoded;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function create() {
        $token = $this->getAuthToken();
        if (!$token || !$this->validateFirebaseToken($token)) {
            return $this->failUnauthorized('Invalid Firebase token');
        }

        $data = $this->request->getPost();
        if ($this->model->insert($data)) {
            return $this->respondCreated($data);
        }

        return $this->failValidationErrors($this->model->errors());
    }

    public function index() {
        $token = $this->getAuthToken();
        if (!$token || !$this->validateFirebaseToken($token)) {
            return $this->failUnauthorized('Invalid Firebase token');
        }

        $data = $this->model->findAll();
        return $this->respond($data);
    }

    public function show($id = null) {
        $token = $this->getAuthToken();
        if (!$token || !$this->validateFirebaseToken($token)) {
            return $this->failUnauthorized('Invalid Firebase token');
        }

        $data = $this->model->find($id);
        if ($data) {
            return $this->respond($data);
        }

        return $this->failNotFound('User not found');
    }

    public function update($id = null) {
        $token = $this->getAuthToken();
        if (!$token || !$this->validateFirebaseToken($token)) {
            return $this->failUnauthorized('Invalid Firebase token');
        }

        $data = $this->request->getRawInput();
        if ($this->model->update($id, $data)) {
            return $this->respond($data);
        }

        return $this->failValidationErrors($this->model->errors());
    }

    public function delete($id = null) {
        $token = $this->getAuthToken();
        if (!$token || !$this->validateFirebaseToken($token)) {
            return $this->failUnauthorized('Invalid Firebase token');
        }

        if ($this->model->delete($id)) {
            return $this->respondDeleted(['id' => $id]);
        }

        return $this->failNotFound('User not found');
    }
}
