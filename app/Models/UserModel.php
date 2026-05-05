<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $returnType = 'array';
    protected $allowedFields = [
        'name', 'email', 'password_hash', 'role', 'status', 'created_at', 'updated_at'
    ];
    protected $useTimestamps = false;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'email' => 'required|valid_email|is_unique[users.email]',
        'name'  => 'required|min_length[2]|max_length[255]',
        'role'  => 'required|in_list[talent,employer]',
    ];

    public function findByEmail(string $email)
    {
        return $this->where('email', $email)->first();
    }

    public function verifyCredentials(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);
        if (!$user) return null;
        if (!password_verify($password, $user['password_hash'])) return null;
        return $user;
    }

    public function withEmployerProfile()
    {
        return $this;
    }

    public function createUser(string $name, string $email, string $passwordHash, string $role = 'talent'): int
    {
        $this->skipValidation(true);
        $this->insert([
            'name' => $name,
            'email' => $email,
            'password_hash' => $passwordHash,
            'role' => $role,
            'status' => 'active',
        ]);
        return (int) $this->insertID();
    }

    public function updateLastLogin(int $userId): void
    {
        $this->update($userId, ['updated_at' => date('Y-m-d H:i:s')]);
    }
}
