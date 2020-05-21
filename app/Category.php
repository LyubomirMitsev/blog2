<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'description', 'user_id'
    ];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function posts() 
    {
        return $this->hasMany(Post::class);
    }
}
