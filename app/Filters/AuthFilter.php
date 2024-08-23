<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $key = getenv("JWT_SECRET");

        if (!$key) {
            return $this->createErrorResponse('JWT Secret Key not set', 500);
        }

        $header = $request->getServer('HTTP_AUTHORIZATION'); // Ajuste aquí
        $token = $this->extractToken($header);

        if (is_null($token) || empty($token)) {
            return $this->createErrorResponse('Access denied', 401);
        }

        try {
            JWT::decode($token, new Key($key, 'HS256'));
        } catch (Exception $ex) {
            return $this->createErrorResponse('Access denied', 401);
        }
    }

    private function extractToken($header)
    {
        if (!empty($header)) {
            if (preg_match('/Bearer\s(\S+)/', $header, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }

    private function createErrorResponse($message, $statusCode)
    {
        $response = service('response');
        $response->setBody($message);
        $response->setStatusCode($statusCode);
        return $response;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No after filter logic required
    }
}
