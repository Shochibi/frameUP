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

public function user() {
    return $this->belongsTo(User::class);
}


}
