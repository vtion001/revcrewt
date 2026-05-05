<?php
namespace App\Controllers;
class ForTalent extends BaseController
{
    public function index(): string
    {
        $data['page'] = 'for-talent';
        $data['page_title'] = 'For Talent — revcrewt';
        return view('partials/header', $data)
             . view('for-talent')
             . view('partials/footer');
    }
}
