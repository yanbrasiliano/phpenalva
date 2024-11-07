<?php

namespace App\Controllers;

use App\Models\Post;
use App\Traits\RestResponseTrait;
use Core\BaseController;
use Core\BaseDatabase;
use Core\BaseValidator;

class PostController extends BaseController
{
  use RestResponseTrait;
  private Post $model;
  private BaseDatabase $connection;
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

      $conn = $this->connection->getDatabase();

      $this->model = new Post($conn);

      $this->view->posts = $this->model->getAll();

      $this->renderView('Posts/index');
    } catch (\PDOException $e) {
      $this->renderExceptionView($e->getCode() ?: 500, 'Error executing query: ' . $e->getMessage());
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
      $this->renderExceptionView($e->getCode() ?: 500, 'Error executing query: ' . $e->getMessage());
    }
  }

  public function store($request)
  {
    $conn = $this->connection->getDatabase();
    $this->model = new Post($conn);

    try {
      $data = [
        'description' => $request->get->description,
      ];

      $validatorErrors = BaseValidator::make($data, $this->model->rules());

      if (!empty($validatorErrors)) {
        return $this->errorResponse('Validation failed', 422, ['errors' => $validatorErrors]);
      }

      $this->model->save($data);

      return $this->successResponse([
        'status' => 200,
        'message' => 'Post created successfully',
      ]);
    } catch (\Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function update($id, $request)
  {
    $conn = $this->connection->getDatabase();
    $this->model = new Post($conn);

    if (!$this->model->exists($id)) {
      return $this->errorResponse('Data is not found in the database.', 404);
    }

    try {
      $data = [
        'id' => $id,
        'description' => $request->get->description,
      ];

      $validatorErrors = BaseValidator::make($data, $this->model->rules());

      if (!empty($validatorErrors)) {
        return $this->errorResponse('Validation failed', 422, ['errors' => $validatorErrors]);
      }

      $result = $this->model->update($data);

      return $result
        ? $this->successResponse([
          'status' => 200,
          'message' => 'Post updated successfully',
        ])
        : $this->errorResponse('Failed to update post', 500);
    } catch (\Exception $exception) {
      return $this->errorResponse($exception->getMessage());
    }
  }


  public function delete($id)
  {
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
