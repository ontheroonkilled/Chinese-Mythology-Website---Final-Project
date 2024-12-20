<?php

namespace Config;

use MongoDB\Driver\Manager;
use MongoDB\Driver\Exception\Exception as MongoDBException;
use MongoDB\Driver\WriteConcern;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Query;
use MongoDB\Driver\Command;

class MongoDB_Connection {
    private static $instance = null;
    private $client;
    private $db;

    private function __construct() {
        try {
            $this->client = new Manager("mongodb+srv://emircandoganay:J4nPHwHITifjYI2Q@mongodeneme.3hj3v.mongodb.net/?retryWrites=true&w=majority&appName=mongodeneme");
            $this->db = 'chinaMythology';
        } catch (MongoDBException $e) {
            die("MongoDB Bağlantı Hatası: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function createCollection($collectionName) {
        try {
            $command = new Command([
                'create' => $collectionName,
                'db' => $this->db,
                'collection' => $collectionName
            ]);
            $this->client->executeCommand($this->db, $command);
        } catch (MongoDBException $e) {
            die("Koleksiyon Hatası: " . $e->getMessage());
        }
    }

    public function createSlug($str) {
        $str = mb_strtolower($str, 'UTF-8');
        $str = str_replace(
            ['ı', 'ğ', 'ü', 'ş', 'ö', 'ç', ' '],
            ['i', 'g', 'u', 's', 'o', 'c', '-'],
            $str
        );
        $str = preg_replace('/[^a-z0-9\-]/', '', $str);
        $str = preg_replace('/-+/', '-', $str);
        return trim($str, '-');
    }

    public function unslugify($slug) {
        // Tireleri boşluk ile değiştir
        $str = str_replace('-', ' ', $slug);
        
        // Her kelimenin ilk harfini büyük yap
        $str = ucwords($str);
        
        return $str;
    }

    public function insert($collection, $document) {
        try {
            $bulk = new BulkWrite();
            $bulk->insert($document);
            
            $writeConcern = new WriteConcern(WriteConcern::MAJORITY, 1000);
            return $this->client->executeBulkWrite($this->db . "." . $collection, $bulk, $writeConcern);
        } catch (MongoDBException $e) {
            die("Ekleme Hatası: " . $e->getMessage());
        }
    }

    public function update($collection, $filter, $update) {
        try {
            $bulk = new BulkWrite();
            $bulk->update($filter, ['$set' => $update], ['multi' => false, 'upsert' => false]);
            
            $writeConcern = new WriteConcern(WriteConcern::MAJORITY, 1000);
            return $this->client->executeBulkWrite($this->db . "." . $collection, $bulk, $writeConcern);
        } catch (MongoDBException $e) {
            die("Güncelleme Hatası: " . $e->getMessage());
        }
    }

    public function find($collection, $filter = [], $options = []) {
        try {
            $query = new Query($filter, $options);
            return $this->client->executeQuery($this->db . "." . $collection, $query);
        } catch (MongoDBException $e) {
            die("Sorgu Hatası: " . $e->getMessage());
        }
    }

    public function findOne($collection, $filter = [], $options = []) {
        try {
            $query = new Query($filter, $options);
            $cursor = $this->client->executeQuery($this->db . "." . $collection, $query);
            $result = current($cursor->toArray());
            return $result ? $result : null;
        } catch (MongoDBException $e) {
            die("Sorgu Hatası: " . $e->getMessage());
        }
    }

    public function findBySlug($collection, $slug) {
        try {
            $query = new Query(['slug' => $slug]);
            $cursor = $this->client->executeQuery($this->db . "." . $collection, $query);
            $result = current($cursor->toArray());
            return $result ? $result : null;
        } catch (MongoDBException $e) {
            die("Sorgu Hatası: " . $e->getMessage());
        }
    }

    public function delete($collection, $filter) {
        try {
            $bulk = new BulkWrite();
            $bulk->delete($filter);
            
            $writeConcern = new WriteConcern(WriteConcern::MAJORITY, 1000);
            return $this->client->executeBulkWrite($this->db . "." . $collection, $bulk, $writeConcern);
        } catch (MongoDBException $e) {
            die("Silme Hatası: " . $e->getMessage());
        }
    }
}
