<?php

namespace App\Controllers;

class Talent extends BaseController
{
    private function requireTalent(): void
    {
        if (! session('user_id')) {
            redirect()->to('/auth/login')->send();
            exit;
        }
        if (session('role') !== 'talent') {
            redirect()->to('/employer/discover')->send();
            exit;
        }
    }

    public function index(): string
    {
        $this->requireTalent();
        $data['page']       = 'talent-profile';
        $data['page_title'] = 'My Profile — revcrewt';
        $data['isLoggedIn'] = true;
        $data['role']       = 'talent';
        $data['userName']   = session('name') ?? '';
        return view('talent-profile', $data);
    }
}
