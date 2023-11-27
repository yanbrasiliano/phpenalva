<?php

namespace App\Models;

use Core\BaseModel;

class Post extends BaseModel
{
    protected $table = 'posts';

    public function __construct(\PDO $pdo)
    {
        parent::__construct($pdo);
    }

    public function rules(): array
    {
        return [
            'description' => 'required|min:6|max:255',
        ];
    }
}
