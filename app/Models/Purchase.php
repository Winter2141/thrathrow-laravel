<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Purchase extends Model
{
    use HasFactory;
    use UsesUuid;

    protected $fillable = [
        'provider_id',
        'provider',
        'cart_id',
        'receipt_url',
        'price'
    ];

    /**
     * @return BelongsTo
     */
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany
     */
    public function beats(): BelongsToMany
    {
        return $this->belongsToMany(Beat::class)->withTimestamps();
    }
}
