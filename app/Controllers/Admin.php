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
        helper(['url', 'text', 'inflector']);
        
        if ($this->request->getMethod() === 'post') {
            $baslik = $this->request->getPost('baslik');
            $icerik = $this->request->getPost('icerik');
            
            if (empty($baslik) || empty($icerik)) {
                return redirect()->to(base_url('admin/ekle'))
                    ->with('error', 'Başlık ve içerik alanları zorunludur.');
            }
            
            require_once APPPATH . 'Config/mongodb.php';
            $mongodb = MongoDB_Connection::getInstance();
            
            // Başlık formatları
            $baslik_seo = $mongodb->createSlug($baslik); // URL için ana format
            $baslik_alt = url_title($baslik, '-', true); // Alternatif URL format
            $baslik_sistem = pascalize($baslik); // Sistem içi kullanım
            
            $data = [
                'baslik' => $baslik,
                'baslik_seo' => $baslik_seo, // createSlug ile oluşan asıl URL
                'baslik_alt' => $baslik_alt, // Yedek URL format
                'baslik_sistem' => $baslik_sistem, // Sistem içi kullanım
                'icerik' => $icerik,
                'zaman' => date('Y-m-d H:i:s')
            ];
            
            // Resim yükleme işlemi
            $resim = $this->request->getFile('resim');
            if ($resim && $resim->isValid() && !$resim->hasMoved()) {
                $newName = $resim->getRandomName();
                $resim->move(FCPATH . 'uploads', $newName);
                $data['resim'] = $newName;
            }
            
            try {
                $bulk = new \MongoDB\Driver\BulkWrite;
                $bulk->insert($data);
                
                $writeConcern = new \MongoDB\Driver\WriteConcern(\MongoDB\Driver\WriteConcern::MAJORITY, 1000);
                $result = $mongodb->getClient()->executeBulkWrite('chinaMythology.topics', $bulk, $writeConcern);
                
                if ($result->getInsertedCount() > 0) {
                    // Başarılı mesajı ve görüntüleme linki
                    $success_message = 'Konu başarıyla eklendi. ' . 
                                     anchor('detay/' . $baslik_seo, 'Konuyu görüntüle', ['class' => 'alert-link']) . 
                                     ' | ' . 
                                     anchor('admin/duzenle/' . $baslik_seo, 'Düzenle', ['class' => 'alert-link']);
                    
                    return redirect()->to(base_url('admin/panel'))
                        ->with('success', $success_message);
                }
            } catch (\Exception $e) {
                return redirect()->to(base_url('admin/ekle'))
                    ->with('error', 'Konu eklenirken bir hata oluştu: ' . $e->getMessage());
            }
        }
        
        return view('admin/ekle');
    }

    public function duzenle($slug = null) {
        $this->checkLogin();
        if (!$slug) {
            return redirect()->to(base_url('admin/panel'));
        }

        require_once APPPATH . 'Config/mongodb.php';
        $mongodb = MongoDB_Connection::getInstance();

        // Slug'a göre konuyu bul
        try {
            $filter = ['$or' => [
                ['_id' => ['$exists' => true]],  // Tüm dökümanlar
                ['baslik' => ['$exists' => true]]  // Başlığı olan tüm dökümanlar
            ]];
            $query = new \MongoDB\Driver\Query($filter);
            $cursor = $mongodb->getClient()->executeQuery('chinaMythology.topics', $query);
            $topics = $cursor->toArray();
            
            // Önce ID ile eşleşme kontrolü
            $topic = null;
            try {
                $objectId = new \MongoDB\BSON\ObjectId($slug);
                foreach ($topics as $t) {
                    if ($t->_id == $objectId) {
                        $topic = $t;
                        break;
                    }
                }
            } catch (\Exception $e) {
                // Eğer slug geçerli bir ObjectId değilse, başlık ile arama yap
                foreach ($topics as $t) {
                    if ($mongodb->createSlug($t->baslik) === $slug) {
                        $topic = $t;
                        break;
                    }
                }
            }
            
            if (!$topic) {
                return redirect()->to(base_url('admin/panel'))->with('error', 'Konu bulunamadı.');
            }
        } catch (\Exception $e) {
            return redirect()->to(base_url('admin/panel'))->with('error', 'Geçersiz ID veya slug.');
        }

        if ($this->request->getMethod() === 'post') {
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
                $bulk = new \MongoDB\Driver\BulkWrite;
                $bulk->update(
                    ['_id' => $topic->_id],
                    ['$set' => $updateData]
                );
                
                $writeConcern = new \MongoDB\Driver\WriteConcern(\MongoDB\Driver\WriteConcern::MAJORITY, 1000);
                $result = $mongodb->getClient()->executeBulkWrite('chinaMythology.topics', $bulk, $writeConcern);
                
                if ($result->getModifiedCount() > 0) {
                    return redirect()->to(base_url('admin/panel'))->with('success', 'Konu başarıyla güncellendi.');
                }
                
                return redirect()->to(current_url())->with('error', 'Konu güncellenirken bir hata oluştu.');
            } catch (\Exception $e) {
                return redirect()->to(current_url())->with('error', 'Konu güncellenirken bir hata oluştu: ' . $e->getMessage());
            }
        }
        
        // GET isteği - formu göster
        return view('admin/duzenle', ['topic' => $topic]);  // topic_id yerine direkt topic nesnesini gönder
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

    public function duzenleHakkimizda($id = null)
{
    $this->checkLogin();
    
    // HakkimizdaModel'i yükle
    $model = new \App\Models\HakkimizdaModel();
    
    if ($this->request->getMethod() === 'post') {
        $data = [
            'baslik' => $this->request->getPost('baslik'),
            'icerik' => $this->request->getPost('icerik')
        ];

        // Resim yükleme işlemi
        $resim = $this->request->getFile('resim');
        if ($resim && $resim->isValid() && !$resim->hasMoved()) {
            $newName = $resim->getRandomName();
            $resim->move(FCPATH . 'uploads', $newName);
            $data['resim'] = $newName;
        }

        if ($model->update($id, $data)) {
            return redirect()->to(base_url('admin/panel'))->with('success', 'Hakkımızda sayfası başarıyla güncellendi.');
        } else {
            return redirect()->to(base_url('admin/duzenleHakkimizda/' . $id))->with('error', 'Güncelleme sırasında bir hata oluştu.');
        }
    }

    // Mevcut veriyi getir
    $data['hakkimizda'] = $model->find($id);
    
    if (empty($data['hakkimizda'])) {
        return redirect()->to(base_url('admin/panel'))->with('error', 'Hakkımızda verisi bulunamadı.');
    }

    return view('admin/duzenleHakkimizda', $data);
}

    public function logout() {
        $this->session->remove(['isLoggedIn', 'username']);
        return redirect()->to(base_url('admin/login'));
    }
}
