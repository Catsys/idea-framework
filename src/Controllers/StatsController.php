<?php

namespace App\Controllers;

use App\Repositories\StatsRepositoryMongo;

class StatsController extends Controller {

    /**
     * Создание записи
     * @param string id
     * @param string subid - необязательный
     *
     * @return null|string
     */
    public function create() {
        if (empty($this->request['id'])) {
            header("HTTP/1.1 400 Bad Request");
            return 'id is missing';
        }
        $mongodb = \App\Factories\MongoDBFactory::create();
        if (!$mongodb) {
            header("HTTP/1.1 500 internal server error");
            return null;
        }
        try {
            \App\Factories\StatFactoryMongo::create($mongodb, $this->request);
            header("HTTP/1.1 201 Created");
        }
        catch (\Exception $e) {
            var_dump($e->getMessage());
            header("HTTP/1.1 400 Bad Request");
        }

        return null;
    }

    /**
     * Получить статистику
     * @param string id
     * @param bool by_days - дополнительно разбить стату по дням
     *
     * @return array|string|null
     */
    public function getStat() {
        $id = $this->request['id'] ?? null;
        if (!$id) {
            header("HTTP/1.1 400 Bad Request");
            return 'id is missing';
        }
        $mongodb = \App\Factories\MongoDBFactory::create();
        if (!$mongodb) {
            header("HTTP/1.1 500 internal server error");
            return null;
        }

        $repo = new StatsRepositoryMongo($mongodb);
        if (!empty($this->request['by_days'])) {
            $data = $repo->getGroupBySubIdAndDays($id);
        }
        else {
            $data = $repo->getGroupBySubId($id);
        }

        return $data;

    }
}