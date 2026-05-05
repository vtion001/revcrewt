<?php

namespace App\Controllers;

use App\Models\TalentProfileModel;

class Profile extends BaseController
{
    public function updateTalent(): object
    {
        $userId = (int) session()->get('user_id');
        $role   = session()->get('role');

        if (!$userId || $role !== 'talent') {
            return $this->respondUnauthorized('Talent login required.');
        }

        $model = new TalentProfileModel();
        $profile = $model->findByUserId($userId);

        if (!$profile) {
            return $this->failNotFound('Profile not found.');
        }

        $data = [];
        $fields = [
            'headline', 'summary', 'location', 'phone',
            'experience_years', 'work_style', 'availability_status',
            'salary_min', 'salary_max',
        ];

        foreach ($fields as $field) {
            $val = $this->request->getVar($field);
            if ($val !== null) {
                $data[$field] = $val;
            }
        }

        $skills = $this->request->getVar('skills');
        if ($skills !== null) {
            $data['skills'] = is_array($skills) ? json_encode($skills) : $skills;
        }

        if (empty($data)) {
            return $this->respond(['status' => 'ok', 'message' => 'No changes.'], 200);
        }

        $data['updated_at'] = date('Y-m-d H:i:s');
        $model->update($profile['id'], $data);

        return $this->respond(['status' => 'ok', 'message' => 'Profile updated.'], 200);
    }
}
