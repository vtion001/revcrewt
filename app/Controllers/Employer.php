<?php

namespace App\Controllers;

class Employer extends BaseController
{
    public function index(): string
    {
        $data['page'] = 'employer-discover';
        $data['page_title'] = 'Discover Talent — revcrewt';
        return view('employer-discover', $data);
    }

    public function talent(int $id): string
    {
        $data['page'] = 'employer-discover';
        $data['page_title'] = 'Talent Profile — revcrewt';
        $data['talent_id'] = $id;
        return view('employer-talent', $data);
    }
}
