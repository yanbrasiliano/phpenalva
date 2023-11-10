<?php

namespace App\Controllers;

use App\Models\Post;
use Core\BaseController;
use Core\BaseDatabase;

class PostController extends BaseController
{
    public $model;
    public $connection;
    public $view;

    public function __construct()
    {
        $this->view = new \stdClass();
        $this->connection = new BaseDatabase();
    }

    public function index()
    {
        try {
            $this->setPageTitle('Posts');

            // Estabeleça a conexão com o banco de dados
            $conn = $this->connection->getDatabase();

            // Crie uma instância do modelo Post com a conexão PDO
            $this->model = new Post($conn);

            $this->view->posts = $this->model->getAll();

            $this->renderView('Posts/index');
        } catch (\PDOException $e) {
            // Manipule erros de conexão ou consulta
            $this->renderExceptionView($e->getCode() ?: 500, 'Error executing query: '.$e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $this->setPageTitle('Post Details');

            $conn = $this->connection->getDatabase();

            $this->model = new Post($conn);

            $this->view->post = $this->model->getById($id);

            $this->renderView('Posts/show');
        } catch (\PDOException $e) {
            $this->renderExceptionView($e->getCode() ?: 500, 'Error executing query: '.$e->getMessage());
        }
    }

    public function create()
    {
        echo 'create';
        try {
            // $this->setPageTitle('Create Post');

            // $conn = $this->connection->getDatabase();

            // $this->model = new Post($conn);

            // if ($request->method === 'POST') {
            //     $this->model->description = $request->post->description;

            //     $this->model->save();

            //     header('Location: /posts');
            //     exit;
            // }

            // $this->renderView('Posts/create');
        } catch (\PDOException $e) {
            $this->renderExceptionView($e->getCode() ?: 500, 'Error executing query: '.$e->getMessage());
        }
    }
}
