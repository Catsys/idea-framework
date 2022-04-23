<?php

namespace App\Repositories;

use MongoDB\Client;
use MongoDB\Collection;

/**
 * Репо для работы со Stat для MongoDB
 */
class StatsRepositoryMongo implements \App\Interfaces\StatRepositoryInterface
{
    private Client $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * @inheritDoc
     */
    public function getGroupBySubId($id) : array {
        $collection = $this->getCollection();
        $rows = $collection->aggregate([
            [
                '$match' => ['id' => (string) $id]
            ],
            [
                '$group' => [
                    '_id' => '$subid',
                    'count' => [
                        '$sum' => 1
                    ]
                ]
            ]
        ]);
        $res = [];
        /** @var \MongoDB\Model\BSONDocument $item */
        foreach ($rows as $item) {
            $res[] = [
                'subid' => $item->_id,
                'count' => $item->count,
            ];
        }

        return $res;
    }

    /**
     * @inheritDoc
     */
    public function getGroupBySubIdAndDays($id) : array {
        $collection = $this->getCollection();

        $rows = $collection->aggregate([
            [
                '$match' => ['id' => (string) $id]
            ],
            [
              '$project' => [
                  'created' => ['$dateToString' => ['format' => '%Y-%m-%d', 'date' => '$created']],
                  'subid' => '$subid',
              ]
            ],
            [
                '$group' => [
                    '_id' => ['subid' => '$subid', 'created' => '$created'],
                    'count' => ['$sum' => 1],
                ]
            ],
            [
                '$sort' => [
                    '_id.created' => -1,
                    '_id.subid' => 1,
                ]
            ]

        ]);
        $res = [];
        /** @var \MongoDB\Model\BSONDocument $item */
        foreach ($rows as $item) {
            $res[] = [
                'created' => $item->_id->created,
                'subid' => $item->_id->subid,
                'count' => $item->count,
            ];
        }

        return $res;
    }


    private function getCollection() : Collection{
        return $this->db->selectCollection($_ENV['MONGO_DB'], 'stats');
    }
}