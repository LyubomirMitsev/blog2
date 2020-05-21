<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use App\Events\UserSignUpEvent;

class UnregisteredUser extends Model
{
    use SoftDeletes, HasRoles;

    protected $fillable = [
        'email'
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => UserSignUpEvent::class,
    ];

    protected $guard_name = 'web';
}
