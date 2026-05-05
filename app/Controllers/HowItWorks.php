<?php
namespace App\Controllers;
class HowItWorks extends BaseController
{
    public function index(): string
    {
        $data['page'] = 'how-it-works';
        $data['page_title'] = 'How It Works — revcrewt';
        return view('partials/header', $data)
             . view('how-it-works')
             . view('partials/footer');
    }
}
