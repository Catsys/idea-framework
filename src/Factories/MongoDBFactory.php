<?php

namespace App\Factories;

/**
 * Создает соединение
 */
class MongoDBFactory
{
    public static function create() {
        try {
            $db = new \MongoDB\Client("mongodb://".$_ENV['MONGO_DSN']);
            $db->listDatabases();
        }
        catch (\Exception $e) {
            return false;
            // logging logic
        }

        return $db;
    }
}