<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Events\CommentCreatedEvent;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'content', 'user_id', 'post_id'
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        //'created' => CommentCreatedEvent::class,
    ];

    /**
     * Get the comment's time of creation.
     *
     * @param  string $value
     * @return string
     */
    public function getCreatedAtAttribute($time)
    {
        $value = date_create($time);
        return date_format($value, 'd M Y, H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
