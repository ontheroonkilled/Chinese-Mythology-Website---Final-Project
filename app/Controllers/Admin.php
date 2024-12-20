<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Admin extends Controller {
    
    public function __construct() {
        helper(['url', 'form']);
    }

    public function panel() {
        return view('admin/adminpanel');
    }

    public function ekle() {
        if ($this->request->getMethod() === 'post') {
            // POST isteği - form gönderilmiş
            return view('admin/ekle');
        } else {
            // GET isteği - formu göster
            return view('admin/ekle');
        }
    }

    public function duzenle($id = null) {
        if (!$id) {
            return redirect()->to(base_url('admin/panel'));
        }

        if ($this->request->getMethod() === 'post') {
            // POST isteği - form gönderilmiş
            return view('admin/duzenle');
        } else {
            // GET isteği - formu göster
            return view('admin/duzenle');
        }
    }

    public function sil($id = null) {
        if (!$id) {
            return redirect()->to(base_url('admin/panel'));
        }

        require_once __DIR__ . '/../config/mongodb.php';
        $mongodb = MongoDB_Connection::getInstance();
        
        try {
            $filter = ['_id' => new \MongoDB\BSON\ObjectId($id)];
            $result = $mongodb->delete('topics', $filter);
            
            if ($result->getDeletedCount() > 0) {
                // Başarılı silme işlemi
                return redirect()->to(base_url('admin/panel'));
            }
        } catch (\Exception $e) {
            // Hata durumunda
            return redirect()->to(base_url('admin/panel'));
        }
    }
}
