<?php

namespace App\Models;

use CodeIgniter\Model;

class HakkimizdaModel extends Model
{
    protected $table = 'hakkimizda';  // MySQL tablosunun adı
    protected $primaryKey = 'id';
    protected $allowedFields = ['baslik', 'icerik', 'resim'];
    protected $returnType = 'object';

    // Hakkımızda sayfası için tek bir kayıt getiren metod
    public function getHakkimizda()
    {
        return $this->select('baslik, icerik, resim')
                    ->first();
    }

    // Tüm kayıtları getiren metod (gerekirse)
    public function getAllContent()
    {
        return $this->select('baslik, icerik, resim')
                    ->findAll();
    }
}
