<?php

namespace App\Interfaces;

/**
 * Интерфейс соединений
 */
interface DBFactoryInterface
{
    public static function create();
}