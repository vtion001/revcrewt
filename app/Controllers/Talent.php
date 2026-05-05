<?php

namespace App\Controllers;

class Talent extends BaseController
{
    public function index(): string
    {
        $data['page'] = 'talent-profile';
        $data['page_title'] = 'My Profile — revcrewt';
        return view('talent-profile', $data);
    }
}
