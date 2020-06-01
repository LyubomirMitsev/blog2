<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Events\PostSavedEvent;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'content', 'user_id', 'slug', 'published_at'
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'saved' => PostSavedEvent::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->where('comments.approved', '=', '1');
    }

    public function unapproved_comments()
    {
        return $this->hasMany(Comment::class)->where('comments.approved', '=', '0');
    }

    public function getRouteKeyName() 
    {
        return 'slug';
    }
}
