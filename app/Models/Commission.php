<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commission extends Model
{
    use UsesUuid;
    use HasFactory;

    const STATUSES = ['pending', 'accepted', 'refused', 'inprogress', 'completed', 'declined'];

    protected $fillable = [
        'description',
        'reference_url',
        'budget',
        'status',
        'requested_to',
    ];

    public function commissionedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function commissionedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_to');
    }

    public function genres(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }
}
