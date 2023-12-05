<?php

namespace Core;

use App\Models\User;
use App\Traits\RestResponseTrait;

class BaseAuthenticate
{
    use RestResponseTrait;

    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function auth($request)
    {
        $email = $request['email'];
        $password = $request['password'];

        $user = $this->user->findByEmail($email);

        if (!$user) {
            $this->badResponse('User not found', 404);
            exit;
        }

        if (!password_verify($password, $user['password'])) {
            $this->badResponse('Invalid password', 400);
            exit;
        }
        if ($user && password_verify($password, $user['password'])) {
            $user = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role'],
                'token' => $this->generateToken($user['id']),
            ];
            $_SESSION['user'] = $user;
        }

        $this->successResponse($user, 200);
    }
}
