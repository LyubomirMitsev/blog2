<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Post;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'description', 'user_id',
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
