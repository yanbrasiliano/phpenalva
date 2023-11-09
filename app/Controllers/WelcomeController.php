<?php

namespace App\Controllers;

use Core\BaseController;

class WelcomeController extends BaseController
{
    public function index()
    {
        $this->setPageTitle('Home');
        $this->renderView('/System/layout');
    }

    public function contact()
    {
        $this->setPageTitle('Contact');
        $this->renderView('/Home/contact');
    }
}
