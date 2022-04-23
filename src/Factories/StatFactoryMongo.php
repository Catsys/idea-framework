<?php

namespace App\Factories;

use App\Interfaces\StatFactoryInterface;
use App\Models\Stat;

/**
 * Создаст объект Stat в Mongo и вернет экземпляр
 */
class StatFactoryMongo implements StatFactoryInterface
{

    /**
     * @param \MongoDB\Client $db
     * @param array $fields
     * @return Stat
     * @throws \Exception
     */
    public static function create($db, array $fields) : Stat
    {
        if (empty($fields['id'])) {
            throw new \Exception('id is missing');
        }
        $collection = $db->selectCollection($_ENV['MONGO_DB'], 'stats');

        $stat = new Stat();
        $stat->id = (string) $fields['id'];
        $stat->subid = (string) ($fields['subid'] ?? null);
        $stat->created = time();

        if (!$stat->isValid()) {
            throw new \Exception('validation error');
        }

        $collection->insertOne([
            'id' => $stat->id,
            'subid' => $stat->subid,
            'created' => new \MongoDB\BSON\UTCDateTime($stat->created * 1000),
        ]);

        return $stat;
    }
}