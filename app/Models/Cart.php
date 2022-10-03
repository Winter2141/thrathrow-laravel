<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use UsesUuid;
    use SoftDeletes;

    const STATUS_OPEN = 1;
    const STATUS_LOCKED = 2;

    protected $fillable = ['user_id', 'status'];

    /**
     * @return BelongsToMany
     */
    public function beats()
    {
        return $this->belongsToMany(Beat::class)->withPivot(['price'])->withTimestamps();
    }
}
