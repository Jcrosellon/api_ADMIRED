<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use \Firebase\JWT\JWT;

class Login extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $userModel = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        // Buscar usuario por email
        $user = $userModel->where('email', $email)->first();

        if (is_null($user)) {
            // Si el usuario no existe, retornar un error
            return $this->respond(['error' => 'Invalid email or password.'], 401);
        }

        // Verificar la contraseña
        $pwd_verify = password_verify($password, $user['password']);

        if (!$pwd_verify) {
            // Si la contraseña es incorrecta, retornar un error
            return $this->respond(['error' => 'Invalid email or password.'], 401);
        }

        // Crear el payload para el token JWT
        $key = getenv("JWT_SECRET"); // Asegúrate de que tienes este valor configurado en tu entorno
        $iat = time(); // Tiempo actual
        $exp = $iat + 3600; // El token expira en 1 hora

        $payload = [
            "iss" => "Issuer of the JWT",  // Quién emite el token
            "aud" => "Audience that the JWT",  // Audiencia
            "sub" => "Subject of the JWT",  // Sujeto
            "iat" => $iat,  // Tiempo de emisión
            "exp" => $exp,  // Tiempo de expiración
            "email" => $user['email'],  // Email del usuario
        ];

        // Generar el token
        $token = JWT::encode($payload, $key, 'HS256');

        // Respuesta de éxito con el token
        $response = [
            'message' => 'Login Successful',
            'token' => $token
        ];

        return $this->respond($response, 200);
    }
}
