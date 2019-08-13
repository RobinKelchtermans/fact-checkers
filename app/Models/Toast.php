<?php

namespace App\Models;

class Toast
{
    public function __construct($message, $type = "primary", $title = "Fact Checkers") {
        $this->title = $title;
        $this->type = $type;
        $this->message = $message;
    }
}
