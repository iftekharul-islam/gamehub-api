<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    public function game() {
        return $this->belongsTo(Game::class);
    }
}
