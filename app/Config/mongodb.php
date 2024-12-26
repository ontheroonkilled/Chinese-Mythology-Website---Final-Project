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

    public function insert($collection, $document) {
        try {
            $bulk = new BulkWrite();
            $bulk->insert($document);
            
            $writeConcern = new WriteConcern(WriteConcern::MAJORITY, 1000);
            $result = $this->client->executeBulkWrite($this->db . "." . $collection, $bulk, $writeConcern);
            return $result->getInsertedCount() > 0;
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
            $bulk = new \MongoDB\Driver\BulkWrite;
            $bulk->delete($filter);
            $result = $this->client->executeBulkWrite($this->db . '.' . $collection, $bulk);
            return $result->getDeletedCount() > 0;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getClient() {
        return $this->client;
    }

    public function createSlug($str, $delimiter = '-') {
        // Özel karakterleri değiştir
        $str = str_replace(['ı', 'ğ', 'ü', 'ş', 'ö', 'ç', 'İ', 'Ğ', 'Ü', 'Ş', 'Ö', 'Ç'], 
                          ['i', 'g', 'u', 's', 'o', 'c', 'i', 'g', 'u', 's', 'o', 'c'], $str);
        
        // Çince karakterleri kaldır ve sadece Latin karakterleri ve sayıları tut
        $str = preg_replace('/[^\p{Latin}\d\s-]/u', '', $str);
        
        // Boşlukları tire ile değiştir
        $str = preg_replace('/[\s-]+/', $delimiter, $str);
        
        // Başındaki ve sonundaki tireleri kaldır
        $str = trim($str, $delimiter);
        
        // Küçük harfe çevir
        return strtolower($str);
    }
}
