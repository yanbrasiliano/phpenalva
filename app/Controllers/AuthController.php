<?php

namespace App\Controllers;

use App\Models\User;
use App\Traits\RestResponseTrait;
use Core\BaseController;
use Core\BaseDatabase;

class AuthController extends BaseController
{
    use RestResponseTrait;
    private User $model;
    private BaseDatabase $connection;
    public $view;
    protected $response;
    protected $request;

    public function index()
    {
        echo 'index';
    }

    public function __construct()
    {
        $this->connection = new BaseDatabase();
        $this->model = new User($this->connection->getDatabase());
    }

    public function login($request)
    {
        $conn = $this->connection->getDatabase();
        $this->model = new User($conn);
        $email = $request->get->email;
        $password = $request->get->password;

        $user = $this->model->findByEmail($email);

        if (!$user) {
            return $this->errorResponse('User not found', 404);
        }

        if (!$this->verifyPassword($password, $user['password'])) {
            return $this->errorResponse('Invalid password', 401);
        }

        $token = $this->generateToken($user['id']);

        return $this->successResponse([
                'status' => 200,
                'message' => 'Login success',
                'token' => $token,
            ]);
    }

    public function logout($request)
    {
        $request->session->destroy();

        return $this->successResponse([
                'status' => 200,
                'message' => 'Logout success',
        ]);
    }

    private function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }

    private function generateToken($id)
    {
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT',
        ];

        $header = json_encode($header);
        $header = base64_encode($header);

        $payload = [
            'id' => $id,
            'exp' => (new \DateTime())->modify('+1 day')->getTimestamp(),
            'iat' => (new \DateTime())->getTimestamp(),
        ];

        $payload = json_encode($payload);
        $payload = base64_encode($payload);

        $signature = hash_hmac('sha256', "$header.$payload", getenv('SECRET_KEY'), true);
        $signature = base64_encode($signature);

        $token = "$header.$payload.$signature";

        return $token;
    }
}
