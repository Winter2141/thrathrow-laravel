<?php

namespace App\Models;

use App\Http\Resources\GenreResource;
use App\Http\Resources\ServiceResource;
use App\Traits\UsesUuid;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use JeroenG\Explorer\Application\Explored;
use Laravel\Scout\Searchable;

class User extends Authenticatable implements MustVerifyEmail, Explored
{
    use HasFactory, Notifiable;
    use SoftDeletes;
    use UsesUuid;
    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'stripe_connect_id',
        'completed_stripe_onboarding'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'completed_stripe_onboarding' => 'bool'
    ];

    /**
     * @return HasMany
     */
    public function beats(): HasMany
    {
        return $this->hasMany(Beat::class);
    }

    /**
     * @return HasMany
     */
    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    /**
     * @return BelongsToMany
     */
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'genre_user');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function requestedCommissions(): HasMany
    {
        return $this->hasMany(Commission::class, 'requested_by');
    }

    public function commissionRequests()
    {
        return $this->hasMany(Commission::class, 'requested_to');
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'about' => $this->about,
            'facebook_url' => $this->facebook_url,
            'twitter_url' => $this->twitter_url,
            'youtube_url' => $this->youtube_url,
            'soundcloud_url' => $this->soundcloud_url,
            'instagram_url' => $this->instagram_url,
            'genres' => GenreResource::collection($this->genres),
            'services' => ServiceResource::collection($this->services),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'profile_image_url' => $this->profile_image_url
        ];
    }

    public function shouldBeSearchable()
    {
        return is_null($this->deleted_at);
    }

    public function mappableAs(): array
    {
        return [
            'id' => 'keyword',
            'name' => 'text',
            'first_name' => 'text',
            'last_name' => 'text',
            'about' => 'text',
            'genres' => 'nested',
            'services' => 'nested',
            'created_at' => 'date',
            'updated_at' => 'date',
            'deleted_at' => 'date',
            'facebook_url' => 'text',
            'twitter_url' => 'text',
            'youtube_url' => 'text',
            'soundcloud_url' => 'text',
            'instagram_url' => 'text',
        ];
    }
}
