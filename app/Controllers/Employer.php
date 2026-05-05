<?php

namespace App\Controllers;

class Employer extends BaseController
{
    private function requireEmployer(): void
    {
        if (! session('user_id')) {
            redirect()->to('/auth/login')->send();
            exit;
        }
        if (session('role') !== 'employer') {
            redirect()->to('/talent/profile')->send();
            exit;
        }
    }

    public function index(): string
    {
        $this->requireEmployer();
        $data['page'] = 'employer-discover';
        $data['page_title'] = 'Discover Talent — revcrewt';
        $data['isLoggedIn'] = true;
        $data['role'] = 'employer';
        $data['userName'] = session('name') ?? '';
        return view('employer-discover', $data);
    }

    public function talent(int $id): string
    {
        $this->requireEmployer();
        $data['page'] = 'employer-discover';
        $data['page_title'] = 'Talent Profile — revcrewt';
        $data['talent_id'] = $id;
        $data['isLoggedIn'] = true;
        $data['role'] = 'employer';
        $data['userName'] = session('name') ?? '';
        return view('employer-talent', $data);
    }
}
