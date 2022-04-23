<?php

namespace App\Interfaces;

use App\Models\Stat;

/**
 * Фабрика статсов. Наследуемся от нее.
 */
interface StatFactoryInterface
{
    public static function create($db, array $fields) : Stat;
}