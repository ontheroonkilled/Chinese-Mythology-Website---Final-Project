<?php

class MongoDB_Connection {
    private static $instance = null;
    private $client;
    private $db;

    private function __construct() {
        try {
            $this->client = new MongoDB\Driver\Manager("mongodb+srv://emircandoganay:J4nPHwHITifjYI2Q@mongodeneme.3hj3v.mongodb.net/?retryWrites=true&w=majority&appName=mongodeneme");
            $this->db = 'chinaMythology';
        } catch (MongoDB\Driver\Exception\Exception $e) {
            die("MongoDB Bağlantı Hatası: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getCollection($collectionName) {
        try {
            $command = new MongoDB\Driver\Command(['listCollections' => 1]);
            $cursor = $this->client->executeCommand($this->db, $command);
            
            // Koleksiyon işlemleri için bulk write hazırlığı
            $bulk = new MongoDB\Driver\BulkWrite;
            
            return [
                'manager' => $this->client,
                'bulk' => $bulk,
                'db' => $this->db,
                'collection' => $collectionName
            ];
        } catch (MongoDB\Driver\Exception\Exception $e) {
            die("Koleksiyon Hatası: " . $e->getMessage());
        }
    }

    public function insert($collection, $document) {
        try {
            $bulk = new MongoDB\Driver\BulkWrite;
            $bulk->insert($document);
            
            $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
            return $this->client->executeBulkWrite($this->db . "." . $collection, $bulk, $writeConcern);
        } catch (MongoDB\Driver\Exception\Exception $e) {
            die("Ekleme Hatası: " . $e->getMessage());
        }
    }

    public function update($collection, $filter, $update) {
        try {
            $bulk = new MongoDB\Driver\BulkWrite;
            $bulk->update($filter, ['$set' => $update], ['multi' => false, 'upsert' => false]);
            
            $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
            return $this->client->executeBulkWrite($this->db . "." . $collection, $bulk, $writeConcern);
        } catch (MongoDB\Driver\Exception\Exception $e) {
            die("Güncelleme Hatası: " . $e->getMessage());
        }
    }

    public function find($collection, $filter = [], $options = []) {
        try {
            $query = new MongoDB\Driver\Query($filter, $options);
            return $this->client->executeQuery($this->db . "." . $collection, $query);
        } catch (MongoDB\Driver\Exception\Exception $e) {
            die("Sorgu Hatası: " . $e->getMessage());
        }
    }

    public function findOne($collection, $filter) {
        try {
            $query = new MongoDB\Driver\Query($filter, ['limit' => 1]);
            $cursor = $this->client->executeQuery($this->db . "." . $collection, $query);
            $result = current($cursor->toArray());
            return $result ? $result : null;
        } catch (MongoDB\Driver\Exception\Exception $e) {
            die("Sorgu Hatası: " . $e->getMessage());
        }
    }

    public function delete($collection, $filter) {
        try {
            $bulk = new MongoDB\Driver\BulkWrite;
            $bulk->delete($filter, ['limit' => 1]);
            
            $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
            return $this->client->executeBulkWrite($this->db . "." . $collection, $bulk, $writeConcern);
        } catch (MongoDB\Driver\Exception\Exception $e) {
            die("Silme Hatası: " . $e->getMessage());
        }
    }
}
