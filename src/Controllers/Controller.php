<?php

namespace App\Controllers;

class Controller
{
    protected $request;

    public function __construct()
    {
        $this->request = $_REQUEST; // todo логика создания и обработки реквестов
    }
}