<?php

namespace App\Controllers;

use App\Models\User;
use App\Traits\RestResponseTrait;
use Core\BaseController;
use Core\BaseDatabase;
use Core\BaseValidator;

class UserController extends BaseController
{
    use RestResponseTrait;
    private User $model;
    private BaseDatabase $connection;
    public $view;

    public function __construct()
    {
        $this->view = new \stdClass();
        $this->connection = new BaseDatabase();
    }

    public function store($request)
    {
        $conn = $this->connection->getDatabase();
        $this->model = new User($conn);

        try {
            $data = [
                'name' => $request->get->name,
                'email' => $request->get->email,
                'password' => password_hash($request->get->password, PASSWORD_DEFAULT),
            ];

            if ($this->model->findByEmail($data['email'])) {
                return $this->errorResponse('Email already exists', 422);
            }

            $validatorErrors = BaseValidator::make($data, $this->model->rules());

            if (!empty($validatorErrors)) {
                return $this->errorResponse('Validation failed', 422, ['errors' => $validatorErrors]);
            }

            $this->model->save($data);

            return $this->successResponse([
                'status' => 200,
                'message' => 'User created successfully',
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function delete($request)
    {
        $conn = $this->connection->getDatabase();
        $this->model = new User($conn);

        try {
            $data = [
                'id' => $request,
            ];

            if (!$this->model->getById($data['id'])) {
                return $this->errorResponse('User not found', 404);
            }

            $this->model->delete($data['id']);

            return $this->successResponse([
                'status' => 200,
                'message' => 'User deleted successfully',
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
