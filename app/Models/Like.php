<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'likeable_id',
        'likeable_type',
    ];

    public function likeable()
    {
        return $this->morphTo();
    }
}
