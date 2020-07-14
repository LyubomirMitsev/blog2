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

    /**
     * Get the category's's time of creation.
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
     * Get the category's time of last modification.
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
