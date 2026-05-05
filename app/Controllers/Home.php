<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data['isLoggedIn'] = (bool) session('user_id');
        $data['role']       = session('role') ?? '';
        $data['userName']   = session('name') ?? '';
        return view('welcome_message', $data);
    }
}
