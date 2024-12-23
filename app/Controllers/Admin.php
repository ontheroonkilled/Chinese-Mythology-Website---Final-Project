<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use MongoDB\Driver\Manager;
use MongoDB\Driver\Query;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Exception\Exception as MongoDBException;
use Config\MongoDB_Connection;

class Admin extends Controller {
    
    public function __construct() {
        helper(['url', 'form']);
        $this->session = \Config\Services::session();
    }

    public function createadmin() {
        if ($this->request->getMethod() === 'post') {
            $username = "yonetici";
            $password = password_hash("123", PASSWORD_DEFAULT);
            
            try {
                $mongodb = \Config\MongoDB_Connection::getInstance();
                $bulk = new \MongoDB\Driver\BulkWrite;
                
                // Yeni admin kullanıcısı dokümanı
                $document = [
                    'username' => $username,
                    'password' => $password,
                    'created_at' => new \MongoDB\BSON\UTCDateTime(time() * 1000)
                ];
                
                // Önce eski admin kullanıcısını sil
                $bulk->delete(['username' => $username]);
                
                // Yeni admin kullanıcısını ekle
                $bulk->insert($document);
                
                $writeConcern = new \MongoDB\Driver\WriteConcern(\MongoDB\Driver\WriteConcern::MAJORITY, 1000);
                $result = $mongodb->getClient()->executeBulkWrite('chinaMythology.users', $bulk, $writeConcern);
                
                if ($result->getInsertedCount() > 0) {
                    return view('admin/createadmin', ['message' => 'Admin kullanıcısı başarıyla oluşturuldu.']);
                }
            } catch (\MongoDB\Driver\Exception\Exception $e) {
                return view('admin/createadmin', ['error' => 'Hata: ' . $e->getMessage()]);
            }
        }
        
        return view('admin/createadmin');
    }

    public function login()
    {
        helper('mongodb');
        $message = "";

        if ($this->request->getMethod() === 'post') {
            $kullaniciAdi = $this->request->getPost('kullanici_adi');
            $sifre = $this->request->getPost('sifre');

            if (!empty($kullaniciAdi) && !empty($sifre)) {
                try {
                    $mongodb = get_mongodb_instance();
                    
                    // Kullanıcıyı bul
                    $filter = ['username' => $kullaniciAdi];
                    $query = new \MongoDB\Driver\Query($filter);
                    $cursor = $mongodb->executeQuery(get_mongodb_database() . '.users', $query);
                    $users = $cursor->toArray();

                    if (count($users) === 1) {
                        $user = $users[0];
                        if (password_verify($sifre, $user->password)) {
                            $this->session->set([
                                'isLoggedIn' => true,
                                'username' => $user->username
                            ]);
                            session()->setFlashdata('success', 'Hoş geldiniz, ' . htmlspecialchars($user->username));
                            return redirect()->to(base_url('/admin/panel'));
                        } else {
                            session()->setFlashdata('error', 'Hatalı şifre!');
                        }
                    } else {
                        session()->setFlashdata('error', 'Kullanıcı bulunamadı!');
                    }
                } catch (\MongoDB\Driver\Exception\Exception $e) {
                    session()->setFlashdata('error', 'Veritabanı hatası: ' . $e->getMessage());
                }
            } else {
                session()->setFlashdata('error', 'Lütfen kullanıcı adı ve şifre girin.');
            }
        }

        return view('admin/login', ['message' => $message]);
    }

    public function checkLogin() {
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
