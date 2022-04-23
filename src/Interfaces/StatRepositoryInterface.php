<?php

namespace App\Interfaces;

interface StatRepositoryInterface
{
    /**
     * Получить по ид список разбитый по subid
     * @param $id
     * @return array
     */
    public function getGroupBySubId($id) : array;

    /**
     * Получить по ид список разбитый по subid и по дням
     * @param $id
     * @return array
     */
    public function getGroupBySubIdAndDays($id) : array;
}