<?php

namespace App\Controllers;

use App\Models\HakkimizdaModel;

class Hakkimizda extends BaseController
{
    public function index()
    {
        $model = new HakkimizdaModel();
        $data['hakkimizda'] = $model->getHakkimizda();
        
        return view('sayfalar/hakkimizda', $data);
    }
}
