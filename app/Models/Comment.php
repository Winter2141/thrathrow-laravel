<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use UsesUuid;
    use HasFactory;

    protected $fillable = ['content', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function beat()
    {
        return $this->belongsTo(Beat::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function likers()
    {
        return $this->hasManyThrough(User::class, Like::class, 'comment_id', 'id');
    }
}
