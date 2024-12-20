<?php

namespace App\Controllers;

use Config\MongoDB_Connection;

class Pages extends BaseController
{
    public function index()
    {
        require_once APPPATH . 'Config/mongodb.php';
        $mongodb = MongoDB_Connection::getInstance();
        
        // Sayfalama için değişkenler
        $limit = 4; // Her sayfada gösterilecek konu sayısı
        $page = $this->request->getGet('sayfa') ?? 1;
        $skip = ($page - 1) * $limit;
        
        // Toplam konu sayısını al
        $total_topics = iterator_count($mongodb->find('topics'));
        $total_pages = ceil($total_topics / $limit);
        
        // Konuları getir
        $data['topics'] = $mongodb->find('topics', [], ['skip' => $skip, 'limit' => $limit]);
        $data['active_menu'] = 'home';
        $data['current_page'] = $page;
        $data['total_pages'] = $total_pages;
        
        return view('tema/header', $data)
             . view('sayfalar/home', $data)
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

    public function duzenle($id = null)
    {
        return view('admin/düzenle');
    }

    public function detay($baslik_url)
    {
        require_once APPPATH . 'Config/mongodb.php';
        $mongodb = MongoDB_Connection::getInstance();
        
        // Tüm konuları getir
        $topics = $mongodb->find('topics');
        $topic = null;
        
        // Başlığı eşleşen konuyu bul
        foreach ($topics as $t) {
            if ($mongodb->createSlug($t->baslik) === $baslik_url) {
                $topic = $t;
                break;
            }
        }
        
        if (!$topic) {
            return redirect()->to(base_url());
        }
        
        $data['topic'] = $topic;
        $data['active_menu'] = 'home';
        return view('tema/header', $data)
             . view('sayfalar/detay', $data)
             . view('tema/footer');
    }
}