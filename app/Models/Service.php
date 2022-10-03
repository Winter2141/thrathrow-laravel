<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use UsesUuid;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
