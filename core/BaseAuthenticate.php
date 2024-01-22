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

  public function generateToken($id)
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

  public function verifyPassword($password, $hash)
  {
    return password_verify($password, $hash);
  }

  public function check()
  {
    session_start();

    if (!isset($_SESSION['user_id'])) {
      return $this->errorResponse('Unauthorized', 401);
    }

    $user = $this->user->getById($_SESSION['user_id']);

    if (!$user) {
      return $this->errorResponse('Unauthorized', 401);
    }

    return $user;
  }
}
