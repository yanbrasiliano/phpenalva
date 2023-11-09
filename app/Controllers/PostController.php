<?php

namespace App\Controllers;

use App\Models\Post;
use Core\BaseController;
use Core\BaseDatabase;

class PostController extends BaseController
{
    public $model;
    public $connection;

    public function __construct()
    {
        $this->connection = new BaseDatabase();
    }

    public function index()
    {
        try {
            // Estabeleça a conexão com o banco de dados
            $conn = $this->connection->getDatabase();

            // Crie uma instância do modelo Post com a conexão PDO
            $this->model = new Post($conn);

            $posts = $this->model->getAll();

            print_r(json_encode(
                [
                    'status' => 200,
                    'data' => $posts]
            ));
        } catch (\PDOException $e) {
            // Manipule erros de conexão ou consulta
            $this->renderExceptionView($e->getCode() ?: 500, 'Error executing query: '.$e->getMessage());
        }
    }
}
