<?php

namespace App\Models;

class Stat {
    public string $id;
    public string $subid = '';
    public $created = 0;

    public function isValid() {
        return !empty($this->id);
    }

}