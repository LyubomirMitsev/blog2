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

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        // 'saved' => PostSavedEvent::class,
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

    /**
     * Get the post's time of publishing.
     *
     * @param  string $value
     * @return string
     */
    public function getPublishedAtAttribute($time)
    {
        if($time !== null) 
        {
            $value = date_create($time);
            return date_format($value, 'd M Y, H:i:s');
        } else {
            return "In Draft";
        }
    }

    /**
     * Get the post's time of creation.
     *
     * @param  string $value
     * @return string
     */
    public function getCreatedAtAttribute($time)
    {
        $value = date_create($time);
        return date_format($value, 'd M Y, H:i:s');
    }

    /**
     * Get the post's time of last modification.
     *
     * @param  string $value
     * @return string
     */
    public function getUpdatedAtAttribute($time)
    {
        $value = date_create($time);
        return date_format($value, 'd M Y, H:i:s');
    }
}
