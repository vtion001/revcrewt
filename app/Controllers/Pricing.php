<?php
namespace App\Controllers;
class Pricing extends BaseController
{
    public function index(): string
    {
        $data['page'] = 'pricing';
        $data['page_title'] = 'Pricing — revcrewt';
        return view('partials/header', $data)
             . view('pricing-page')
             . view('partials/footer');
    }
}
