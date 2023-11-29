<?php

namespace App\Controllers;

use App\Traits\RestResponseTrait;
use Core\BaseAuthenticate as Authenticate;
use Core\BaseController;

class Login extends BaseController
{
    use Authenticate;
    use RestResponseTrait;

    public function login()
    {
        $this->auth($_POST);
    }
}
