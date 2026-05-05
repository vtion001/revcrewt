<?php

namespace App\Controllers;

use App\Models\WaitlistModel;
use App\Models\TalentProfileModel;
use CodeIgniter\API\ResponseTrait;

class Api extends BaseController
{
    use ResponseTrait;

    // ── POST /api/waitlist ──────────────────────────────────────────
    public function waitlist()
    {
        $name  = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $role  = $this->request->getPost('role');

        if (empty($name) || empty($email) || empty($role)) {
            return $this->failValidationErrors('Name, email, and role are required.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->failValidationErrors('Invalid email address.');
        }

        $model = new WaitlistModel();

        // Check duplicate
        $existing = $model->findByEmail($email);
        if ($existing) {
            return $this->respondUpdated(['message' => 'You are already on the list!']);
        }

        $id = $model->insert([
            'name'  => $name,
            'email' => $email,
            'role'  => $role,
            'status' => 'pending',
        ]);

        return $this->respondCreated([
            'message' => 'You are on the list!',
            'id'      => $id,
        ]);
    }

    // ── GET /api/waitlist/stats ─────────────────────────────────────
    public function waitlistStats()
    {
        $model = new WaitlistModel();
        return $this->respond($model->getStats());
    }

    // ── GET /api/talents ────────────────────────────────────────────
    public function talents()
    {
        $model = new TalentProfileModel();

        $filters = [
            'q'            => $this->request->getGet('q'),
            'availability' => $this->request->getGet('availability') 
                                ? explode(',', $this->request->getGet('availability')) 
                                : [],
            'experience'    => $this->request->getGet('experience') 
                                ? explode(',', $this->request->getGet('experience')) 
                                : [],
            'sort'         => $this->request->getGet('sort') ?? 'newest',
        ];

        $page   = (int) $this->request->getGet('page') ?: 1;
        $limit   = 12;
        $offset  = ($page - 1) * $limit;

        $talents = $model->withUser()->search($filters, $limit, $offset);
        $total   = $model->countFiltered($filters);
        $stats   = $model->getStats();

        // Decode skills JSON for each talent
        foreach ($talents as &$t) {
            if ($t['skills'] && is_string($t['skills'])) {
                $t['skills_array'] = json_decode($t['skills'], true) ?? [];
            } else {
                $t['skills_array'] = [];
            }
        }

        return $this->respond([
            'talents' => $talents,
            'stats'   => $stats,
            'pagination' => [
                'page'       => $page,
                'limit'      => $limit,
                'total'      => $total,
                'totalPages' => ceil($total / $limit),
            ],
        ]);
    }

    // ── GET /api/talents/:id ────────────────────────────────────────
    public function talent(int $id)
    {
        $model = new TalentProfileModel();
        $talent = $model->withUser()->find($id);

        if (!$talent) {
            return $this->failNotFound('Talent profile not found.');
        }

        if ($talent['skills'] && is_string($talent['skills'])) {
            $talent['skills_array'] = json_decode($talent['skills'], true) ?? [];
        } else {
            $talent['skills_array'] = [];
        }

        return $this->respond($talent);
    }
}
