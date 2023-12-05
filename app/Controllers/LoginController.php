<?php

namespace App\Controllers;

use App\Models\User;
use App\Traits\RestResponseTrait;
use Core\BaseAuthenticate as Authenticate;
use Core\BaseController;

class Login extends BaseController
{
    use Authenticate;
    use RestResponseTrait;
    protected $user;
    protected $response;
    protected $request;

    public function __construct(User $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    public function login()
    {
        \var_dump('aqui');
        exit;
        // $email = $this->request->email;
        // $password = $this->request->password;

        // $user = $this->user->findByEmail($email);

        // if (!$user) {
        //     return $this->response->json(['message' => 'User not found'], 404);
        // }

        // if (!$this->verifyPassword($password, $user['password'])) {
        //     return $this->response->json(['message' => 'Invalid password'], 401);
        // }

        // $token = $this->generateToken($user['id']);

        // return $this->response->json(['token' => $token], 200);
    }

    public function logout()
    {
        $this->request->session->destroy();

        return $this->response->json(['message' => 'Logout success'], 200);
    }

    public function verifyToken()
    {
        $token = $this->request->token;

        if (!$token) {
            return $this->response->json(['message' => 'Token not found'], 404);
        }

        $user = $this->verify($token);

        if (!$user) {
            return $this->response->json(['message' => 'Invalid token'], 401);
        }

        return $this->response->json(['user' => $user], 200);
    }

    public function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    public function verify(string $token): ?array
    {
        $token = explode('.', $token);
        $payload = json_decode(base64_decode($token[1]), true);
        $user = $this->user->getById($payload['id']);

        if (!$user) {
            return null;
        }

        return $user;
    }

    public function generateToken(int $id): string
    {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode(['id' => $id]);

        $base64UrlHeader = $this->base64UrlEncode($header);
        $base64UrlPayload = $this->base64UrlEncode($payload);

        $signature = hash_hmac('sha256', $base64UrlHeader.'.'.$base64UrlPayload, getenv('SECRET_KEY'), true);
        $base64UrlSignature = $this->base64UrlEncode($signature);
        $jwt = $base64UrlHeader.'.'.$base64UrlPayload.'.'.$base64UrlSignature;

        return $jwt;
    }

    private function base64UrlEncode($data): string
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }
}
