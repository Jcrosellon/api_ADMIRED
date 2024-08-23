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
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $key = getenv("JWT_SECRET");

        if (!$key) {
            return $this->createErrorResponse('JWT Secret Key not set', 500);
        }

        $header = $request->getHeader("Authorization");
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

    /**
     * Extract token from the Authorization header.
     *
     * @param string|null $header
     *
     * @return string|null
     */
    private function extractToken($header)
    {
        if (!empty($header)) {
            if (preg_match('/Bearer\s(\S+)/', $header, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }

    /**
     * Create a response with an error message and status code.
     *
     * @param string $message
     * @param int $statusCode
     *
     * @return ResponseInterface
     */
    private function createErrorResponse($message, $statusCode)
    {
        $response = service('response');
        $response->setBody($message);
        $response->setStatusCode($statusCode);
        return $response;
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No after filter logic required
    }
}
