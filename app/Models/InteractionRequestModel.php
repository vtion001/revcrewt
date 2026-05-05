<?php

namespace App\Models;

use CodeIgniter\Model;

class InteractionRequestModel extends Model
{
    protected $table = 'interaction_requests';
    protected $returnType = 'array';
    protected $allowedFields = [
        'employer_id', 'talent_id', 'type', 'subject', 'message',
        'proposed_salary', 'status', 'amount_paid', 'service_fee',
        'created_at', 'responded_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = false;

    public function sentByEmployer(int $employerId): array
    {
        return $this->select('interaction_requests.*, talent_profiles.headline as talent_headline, users.name as talent_name')
            ->join('users', 'users.id = interaction_requests.talent_id', 'left')
            ->join('talent_profiles', 'talent_profiles.user_id = interaction_requests.talent_id', 'left')
            ->where('employer_id', $employerId)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    public function receivedByTalent(int $talentId): array
    {
        return $this->select('interaction_requests.*, employer_profiles.org_name, users.name as employer_name')
            ->join('users', 'users.id = interaction_requests.employer_id', 'left')
            ->join('employer_profiles', 'employer_profiles.user_id = interaction_requests.employer_id', 'left')
            ->where('talent_id', $talentId)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    public function sentToTalent(int $employerId, int $talentId): array
    {
        return $this->where('employer_id', $employerId)
            ->where('talent_id', $talentId)
            ->whereIn('status', ['pending', 'accepted'])
            ->findAll();
    }

    public function countThisMonth(int $employerId): int
    {
        $startOfMonth = date('Y-m-01 00:00:00');
        return $this->where('employer_id', $employerId)
            ->where('created_at >=', $startOfMonth)
            ->countAllResults();
    }

    public function hasExistingOffer(int $employerId, int $talentId): bool
    {
        $count = $this->where('employer_id', $employerId)
            ->where('talent_id', $talentId)
            ->whereIn('status', ['pending', 'accepted'])
            ->countAllResults();
        return $count > 0;
    }

    public function sentTalentIds(int $employerId): array
    {
        $rows = $this->select('talent_id')
            ->where('employer_id', $employerId)
            ->whereIn('status', ['pending', 'accepted'])
            ->findAll();
        return array_column($rows, 'talent_id');
    }

    public function createOffer(int $employerId, int $talentId, array $data): int
    {
        $this->insert([
            'employer_id' => $employerId,
            'talent_id' => $talentId,
            'type' => $data['type'] ?? 'free_interview',
            'subject' => $data['subject'] ?? '',
            'message' => $data['message'] ?? '',
            'proposed_salary' => $data['proposed_salary'] ?? null,
            'status' => 'pending',
        ]);
        return (int) $this->insertID();
    }

    public function updateStatus(int $id, string $status): bool
    {
        return $this->update($id, [
            'status' => $status,
            'responded_at' => date('Y-m-d H:i:s'),
        ]) !== false;
    }
}
