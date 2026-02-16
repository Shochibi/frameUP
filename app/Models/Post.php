<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'file_path',
        'file_type',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class)
            ->whereNull('parent_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->morphMany(\App\Models\Like::class, 'likeable');
    }

    // Cek apakah user yang login sudah menyukai ini
    public function isLikedBy($user)
    {
        if (!$user) return false;
        return $this->likes()->where('user_id', $user->id)->exists();
    }
}
