<?php

use MongoDB\Driver\Manager;
use MongoDB\Driver\Exception\Exception as MongoDBException;
use MongoDB\Driver\WriteConcern;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Query;
use MongoDB\Driver\Command;

if (!function_exists('get_mongodb_instance')) {
    function get_mongodb_instance() {
        static $instance = null;
        
        if ($instance === null) {
            try {
                $instance = new Manager("mongodb+srv://emircandoganay:J4nPHwHITifjYI2Q@mongodeneme.3hj3v.mongodb.net/?retryWrites=true&w=majority&appName=mongodeneme");
            } catch (MongoDBException $e) {
                log_message('error', 'MongoDB Connection Error: ' . $e->getMessage());
                throw $e;
            }
        }
        
        return $instance;
    }
}

if (!function_exists('get_mongodb_database')) {
    function get_mongodb_database() {
        return 'chinaMythology';
    }
}
