<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        $data['active_menu'] = 'home';
        return view('tema/header', $data)
             . view('sayfalar/home')
             . view('tema/footer');
    }

    public function hakkimizda()
    {
        $data['active_menu'] = 'hakkimizda';
        return view('tema/header', $data)
             . view('sayfalar/hakkimizda')
             . view('tema/footer');
    }
    
    public function login()
    {
        if($this->request->getMethod() === 'post') {
            return redirect()->to(base_url('admin/panel'));
        }
        return view('admin/login');
    }

    public function panel()
    {
        return view('admin/adminpanel');
    }

    public function ekle()
    {
        return view('admin/ekle');
    }
}