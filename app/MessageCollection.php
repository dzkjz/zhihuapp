<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;

class MessageCollection extends Collection
{
    public function markAsRead()
    {
        $this->each(function ($message) {
            $message->markAsRead();
        });
    }
}
