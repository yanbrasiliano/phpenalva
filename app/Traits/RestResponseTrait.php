<?php

namespace App\Traits;

trait RestResponseTrait
{
    private function jsonResponse(array $data, int $status = 200): void
    {
        header('Content-Type: application/json');
        http_response_code($status);

        echo json_encode(['data' => $data]);
    }

    public function successResponse(array $data, int $status = 200): void
    {
        $this->jsonResponse($data, $status);
    }

    public function errorResponse(string $message, int $status = 500, array $validationErrors = []): void
    {
        $errorData = ['error' => $message];

        if (!empty($validationErrors)) {
            $errorData['validation_errors'] = $validationErrors;
        }

        $this->jsonResponse($errorData, $status);
    }

    public function notFoundResponse(string $resource = 'Resource'): void
    {
        $this->jsonResponse(['error' => "$resource not found"], 404);
    }

    public function badResponse(string $message, int $status = 400): void
    {
        $this->jsonResponse(['error' => $message], $status);
    }
}
