<?php

namespace App\Models;

use App\Models\Post;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    public function friends()
{
    return $this->belongsToMany(self::class, 'friendships', 'user_id', 'friend_id')
        ->wherePivot('status', 'accepted');
}

    public function posts()
{
    return $this->hasMany(Post::class);
}
public function friendRequests()
{
    return $this->belongsToMany(self::class, 'friendships', 'friend_id', 'user_id')
        ->wherePivot('status', 'pending');
}
public function friendshipStatus($otherUserId)
{
    $friendship = \DB::table('friendships')
        ->where(function ($q) use ($otherUserId) {
            $q->where('user_id', $this->id)
              ->where('friend_id', $otherUserId);
        })
        ->orWhere(function ($q) use ($otherUserId) {
            $q->where('user_id', $otherUserId)
              ->where('friend_id', $this->id);
        })
        ->first();

    return $friendship?->status;
}

    public function comments()
{
    return $this->hasMany(Comment::class);
}


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public $incrementing = false;
    protected $keyType = 'string';
}
