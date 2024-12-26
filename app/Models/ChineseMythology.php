<?php

namespace App\Models;

use CodeIgniter\Model;

class ChineseMythology extends Model
{
    protected $table = pascalize('chinese_mythology_topics');
    protected $primaryKey = '_id';
    protected $allowedFields = ['baslik', 'icerik', 'resim', 'zaman'];

    public function __construct()
    {
        parent::__construct();
        helper('inflector'); // pascalize fonksiyonu için gerekli
    }
}
