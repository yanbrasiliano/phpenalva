<?php

namespace App\Controllers;

use Core\BaseController;

class WelcomeController extends BaseController
{
    public function index()
    {
        $this->setPageTitle('Home'); // Defina o título da página aqui
        $this->renderView('layout');
    }
}
