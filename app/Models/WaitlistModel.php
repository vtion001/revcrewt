<?php

namespace App\Models;

use CodeIgniter\Model;

class WaitlistModel extends Model
{
    protected $table = 'waitlist';
    protected $returnType = 'array';
    protected $allowedFields = ['name', 'email', 'role', 'status', 'created_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function findByEmail(string $email): ?array
    {
        return $this->where('email', $email)->first();
    }

    public function getStats(): array
    {
        $total = $this->countAllResults();
        $jobseekers = $this->where('role', 'jobseeker')->countAllResults();
        $employers = $this->where('role', 'employer')->countAllResults();
        $both = $this->where('role', 'both')->countAllResults();
        return compact('total', 'jobseekers', 'employers', 'both');
    }
}
