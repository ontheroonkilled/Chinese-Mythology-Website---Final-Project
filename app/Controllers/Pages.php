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
}