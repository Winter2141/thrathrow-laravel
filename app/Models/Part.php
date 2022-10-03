<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Part extends Model
{
    use UsesUuid;

    protected $fillable = ['name'];

    /**
     * @return BelongsToMany
     */
    public function beats(): BelongsToMany
    {
        return $this->belongsToMany(Beat::class);
    }
}
