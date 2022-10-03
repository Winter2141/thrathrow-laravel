<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use UsesUuid;
    use SoftDeletes;

    protected $fillable = [
        'provider_id',
        'provider_name',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
