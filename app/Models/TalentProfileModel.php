<?php

namespace App\Models;

use CodeIgniter\Model;

class TalentProfileModel extends Model
{
    protected $table = 'talent_profiles';
    protected $returnType = 'array';
    protected $allowedFields = [
        'user_id', 'headline', 'summary', 'profile_photo', 'location', 'phone',
        'skills', 'experience_years', 'work_style', 'availability_status',
        'salary_min', 'salary_max', 'profile_completion', 'is_premium', 'verified_badge',
        'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function withUser()
    {
        return $this->select('talent_profiles.*, users.email')
            ->join('users', 'users.id = talent_profiles.user_id', 'left');
    }

    public function search(array $filters = [], int $limit = 20, int $offset = 0): array
    {
        $builder = $this->builder();

        if (!empty($filters['q'])) {
            $q = $filters['q'];
            $builder->groupStart()
                ->like('headline', $q)
                ->orLike('summary', $q)
                ->orLike('skills', $q)
                ->groupEnd();
        }

        if (!empty($filters['availability'])) {
            $builder->whereIn('availability_status', $filters['availability']);
        }

        if (!empty($filters['experience'])) {
            $exp = $filters['experience'];
            $conditions = [];
            if (in_array('junior', $exp)) $conditions[] = 'experience_years <= 2';
            if (in_array('mid', $exp)) $conditions[] = '(experience_years >= 3 AND experience_years <= 5)';
            if (in_array('senior', $exp)) $conditions[] = '(experience_years >= 6 AND experience_years <= 10)';
            if (in_array('lead', $exp)) $conditions[] = 'experience_years > 10';
            if ($conditions) {
                $builder->groupStart();
                foreach ($conditions as $i => $c) {
                    if ($i > 0) $builder->orWhere($c);
                    else $builder->where($c);
                }
                $builder->groupEnd();
            }
        }

        if (!empty($filters['sort'])) {
            switch ($filters['sort']) {
                case 'experience':
                    $builder->orderBy('experience_years', 'DESC');
                    break;
                case 'newest':
                default:
                    $builder->orderBy('created_at', 'DESC');
                    break;
            }
        } else {
            $builder->orderBy('created_at', 'DESC');
        }

        return $builder->limit($limit, $offset)->get()->getResultArray();
    }

    public function countFiltered(array $filters = []): int
    {
        $builder = $this->builder();
        if (!empty($filters['q'])) {
            $q = $filters['q'];
            $builder->groupStart()
                ->like('headline', $q)
                ->orLike('summary', $q)
                ->orLike('skills', $q)
                ->groupEnd();
        }
        if (!empty($filters['availability'])) {
            $builder->whereIn('availability_status', $filters['availability']);
        }
        return $builder->countAllResults();
    }

    public function getStats(): array
    {
        $total = $this->countAllResults();
        $openToWork = $this->where('availability_status', 'open')->countAllResults();
        $premium = $this->where('is_premium', 1)->countAllResults();
        return compact('total', 'openToWork', 'premium');
    }
}
