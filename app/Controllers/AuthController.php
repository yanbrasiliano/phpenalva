<?php

namespace App\Controllers;

use App\Models\User;
use App\Traits\RestResponseTrait;
use Core\BaseAuthenticate;
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
    private BaseAuthenticate $auth;

    public function __construct()
    {
        $this->connection = new BaseDatabase();
        $this->model = new User($this->connection->getDatabase());
        $this->auth = new BaseAuthenticate($this->model);
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

        if (!$this->auth->verifyPassword($password, $user['password'])) {
            return $this->errorResponse('Invalid password', 401);
        }

        session_start();
        $_SESSION['user_id'] = $user['id'];

        $token = $this->auth->generateToken($user['id']);

        return $this->successResponse([
            'status' => 200,
            'message' => 'Login success',
            'token' => $token,
        ]);
    }

    public function logout()
    {
        session_start();

        $userId = $_SESSION['user_id'];

        session_destroy();

        return $this->successResponse([
            'status' => 200,
            'message' => 'Logout success',
            'user_id' => $userId,
        ]);
    }
}
