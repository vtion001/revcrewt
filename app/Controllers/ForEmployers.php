<?php
namespace App\Controllers;
class ForEmployers extends BaseController
{
    public function index(): string
    {
        $data['page'] = 'for-employers';
        $data['page_title'] = 'For Employers — revcrewt';
        return view('partials/header', $data)
             . view('for-employers')
             . view('partials/footer');
    }
}
