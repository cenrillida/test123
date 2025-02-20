<?php

namespace Rest\Models;

class RestArray {

    public $items;

    function __construct($items) {
        $this->items = $items;
    }

}