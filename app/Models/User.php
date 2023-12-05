<?php

namespace App\Models;

use Core\BaseModel;

class User extends BaseModel
{
    protected $table = 'users';

    public function __construct(\PDO $pdo)
    {
        parent::__construct($pdo);
    }

    public function rules(): array
    {
        return
        [
        'name' => 'required|min:1|max:255',
        'email' => 'required|email',
        'password' => 'required|min:6|max:255',
        ];
    }

    public function findByEmail(string $email): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);

        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $user !== false ? $user : null;
    }
}
