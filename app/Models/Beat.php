<?php

namespace App\Models;

use App\Http\Resources\GenreResource;
use App\Http\Resources\ProducerResource;
use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use JeroenG\Explorer\Application\Explored;
use Laravel\Scout\Searchable;

class Beat extends Model implements Explored
{
    use HasFactory;
    use SoftDeletes;
    use UsesUuid;
    use Searchable;

    const STATUSES = [
        'DELETED' => 0,
        'INACTIVE' => 1,
        'UNPRINTED' => 2,
        'AVAILABLE' => 3,
        'PURCHASED' => 4
    ];

    protected $fillable = [
        'name',
        'description',
        'bpm',
        'is_free',
        'is_exclusive',
        'status',
        'price',
        'download_enabled',
        'purchase_enabled',
    ];

    protected $casts = [
        'is_free' => 'boolean',
        'is_exclusive' => 'boolean',
        'download_enabled' => 'boolean',
        'purchase_enabled' => 'boolean',
    ];

    /**
     * @return BelongsTo
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsToMany
     */
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class)->withTimestamps();
    }

    /**
     * @return BelongsToMany
     */
    public function purchases(): BelongsToMany
    {
        return $this->belongsToMany(Purchase::class)->withTimestamps();
    }

    /**
     * @return BelongsToMany
     */
    public function parts(): BelongsToMany
    {
        return $this->belongsToMany(Part::class)->withTimestamps();
    }

    /**
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
            'price' => $this->price,
            'bpm' => $this->bpm,
            'uploader' => [
                'id' => $this->uploader->id,
                'name' => $this->uploader->name,
            ],
            'genres' => GenreResource::collection($this->genres),
            'is_free' => $this->is_free,
            'is_exclusive' => $this->is_exclusive,
            'created_at' => $this->created_at,
            'artwork_url' => $this->artwork_url,
        ];
    }

    public function mappableAs(): array
    {
        return [
            'id' => 'keyword',
            'name' => 'text',
            'description' => 'text',
            'status' => 'integer',
            'price' => 'float',
            'bpm' => 'integer',
            'uploader' => [
                'id' => 'keyword',
                'name' => 'text',
            ],
            'genres' => [
                'id' => 'keyword',
                'name' => 'text',
            ],
            'is_free' => 'boolean',
            'is_exclusive' => 'boolean',
            'created_at' => 'date',
            'artwork_url' => 'text'
        ];
    }

    public function shouldBeSearchable()
    {
        return $this->status = Beat::STATUSES['AVAILABLE'];
    }
}
