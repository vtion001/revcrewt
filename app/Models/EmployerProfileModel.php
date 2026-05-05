<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployerProfileModel extends Model
{
    protected $table = 'employer_profiles';
    protected $returnType = 'array';
    protected $allowedFields = ['user_id', 'org_name', 'org_logo', 'org_website', 'org_size', 'industry', 'work_environment', 'hiring_priorities', 'engagement_prefs', 'is_premium', 'featured_status', 'created_at', 'updated_at'];

    public function findByUserId(int $userId): ?array
    {
        return $this->where('user_id', $userId)->first();
    }

    public function firstOrCreate(int $userId): int
    {
        $existing = $this->findByUserId($userId);
        if ($existing) {
            return (int) $existing['id'];
        }
        $this->insert([
            'user_id' => $userId,
            'org_name' => '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        return (int) $this->insertID();
    }

    public function updateByUserId(int $userId, array $data): bool
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->where('user_id', $userId)->set($data)->update() !== false;
    }
}
