<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\MongoDB_Connection;

class Admin extends Controller {
    
    public function __construct() {
        helper(['url', 'form']);
        $this->session = \Config\Services::session();
    }

    public function login() {
        if ($this->request->getMethod() === 'post') {
            $username = $this->request->getPost('kullanici_adi');
            $password = $this->request->getPost('sifre');

            // Basit kontrol
            if ($username === 'yonetici' && $password === '123') {
                $this->session->set([
                    'isLoggedIn' => true,
                    'username' => $username
                ]);
                return redirect()->to(base_url('admin/panel'));
            } else {
                return redirect()->to(base_url('admin/login'))->with('error', 'Kullanıcı adı veya şifre hatalı.');
            }
        }

        return view('admin/login');
    }

    private function checkLogin() {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to(base_url('admin/login'));
        }
    }

    public function panel() {
        $this->checkLogin();
        return view('admin/adminpanel');
    }

    public function ekle() {
        $this->checkLogin();
        if ($this->request->getMethod() === 'post') {
            // POST isteği - form gönderilmiş
            return view('admin/ekle');
        } else {
            // GET isteği - formu göster
            return view('admin/ekle');
        }
    }

    public function duzenle($id = null) {
        $this->checkLogin();
        if (!$id) {
            return redirect()->to(base_url('admin/panel'));
        }

        require_once APPPATH . 'Config/mongodb.php';
        $mongodb = MongoDB_Connection::getInstance();

        // ID'ye göre konuyu bul
        try {
            $topic = $mongodb->findOne('topics', ['_id' => new \MongoDB\BSON\ObjectId($id)]);
            
            if (!$topic) {
                return redirect()->to(base_url('admin/panel'))->with('error', 'Konu bulunamadı.');
            }
        } catch (\Exception $e) {
            return redirect()->to(base_url('admin/panel'))->with('error', 'Geçersiz ID.');
        }

        if ($this->request->getMethod() === 'post') {
            // POST isteği - form gönderilmiş
            $baslik = $this->request->getPost('baslik');
            $icerik = $this->request->getPost('icerik');
            
            $updateData = [
                'baslik' => $baslik,
                'icerik' => $icerik,
                'zaman' => date('Y-m-d H:i:s')
            ];
            
            // Resim yükleme işlemi
            $resim = $this->request->getFile('resim');
            if ($resim && $resim->isValid() && !$resim->hasMoved()) {
                $newName = $resim->getRandomName();
                $resim->move(FCPATH . 'uploads', $newName);
                $updateData['resim'] = $newName;
            }
            
            try {
                $filter = ['_id' => $topic->_id];
                if ($mongodb->update('topics', $filter, $updateData)) {
                    return redirect()->to(base_url('admin/panel'))->with('success', 'Konu başarıyla güncellendi.');
                } else {
                    return redirect()->to(base_url('admin/panel'))->with('error', 'Konu güncellenirken bir hata oluştu.');
                }
            } catch (\Exception $e) {
                return redirect()->to(base_url('admin/panel'))->with('error', 'Konu güncellenirken bir hata oluştu: ' . $e->getMessage());
            }
        } else {
            // GET isteği - formu göster
            return view('admin/duzenle', ['topic_id' => $id]);
        }
    }

    public function sil($id = null) {
        $this->checkLogin();
        if (!$id) {
            return redirect()->to(base_url('admin/panel'));
        }

        require_once APPPATH . 'Config/mongodb.php';
        $mongodb = MongoDB_Connection::getInstance();
        
        try {
            $filter = ['_id' => new \MongoDB\BSON\ObjectId($id)];
            if ($mongodb->delete('topics', $filter)) {
                // Başarılı silme işlemi
                return redirect()->to(base_url('admin/panel'))->with('success', 'Konu başarıyla silindi.');
            } else {
                // Silme işlemi başarısız
                return redirect()->to(base_url('admin/panel'))->with('error', 'Konu silinirken bir hata oluştu.');
            }
        } catch (\Exception $e) {
            return redirect()->to(base_url('admin/panel'))->with('error', 'Konu silinirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    public function logout() {
        $this->session->remove(['isLoggedIn', 'username']);
        return redirect()->to(base_url('admin/login'));
    }
}
