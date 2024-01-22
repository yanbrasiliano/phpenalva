<?php

namespace App\Controllers;

use App\Traits\RestResponseTrait;
use Core\BaseController;

class WelcomeController extends BaseController
{
  use RestResponseTrait;

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

  public function apiIndex()
  {
    try {
      $this->successResponse([
        'status' => 200,
        'message' => 'Welcome to the API PHPenalva',
        'database' => $_ENV['DB_CONNECTION'],
        'database_host' => $_ENV['DB_HOST'],
      ]);
    } catch (\Exception $e) {
      $this->errorResponse($e->getMessage());
    }
  }
}
