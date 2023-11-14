<?php

namespace App\Controllers;

use App\Models\Post;
use App\Traits\RestResponseTrait;
use Core\BaseController;
use Core\BaseDatabase;

class PostController extends BaseController
{
    use RestResponseTrait;
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

    public function store()
    {
        $conn = $this->connection->getDatabase();
        $this->model = new Post($conn);
    }

    public function update($id)
    {
        $conn = $this->connection->getDatabase();
        $this->model = new Post($conn);
    }

    public function delete($id)
    {
        echo 'delete';
        $conn = $this->connection->getDatabase();
        $this->model = new Post($conn);

        try {
            $this->model->delete($id);

            return $this->successResponse([
                'status' => 200,
                'message' => 'Post deleted successfully',
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
