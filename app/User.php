<?php

namespace App;

use Carbon\Carbon;
use App\Reply;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar_path'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email'
    ];

    protected $casts = [
        'confirmed' => 'boolean'
    ];

    public function isAdmin()
    {
        return in_array($this->name, ['Elijah', 'elijah']);
    }

    /**
     * Get the route key name for Laravel.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }


    /**
     * Fetch all threads that were created by the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function threads()
    {
        return $this->hasMany(Thread::class)->latest();
    }

    public function lastReply()
    {
        return $this->hasOne(Reply::class)->latest();
    }

    /**
     * Get all activity for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * Record that the user has read the given thread.
     *
     * @param Thread $thread
     */
     public function read($thread)
     {
         cache()->forever(
            $this->visitedThreadCacheKey($thread),
            Carbon::now()
        );
     }

     public function confirm()
     {
         $this->confirmed = true;
         $this->confirmation_token = null;

         $this->save();
     }
    /**
     * Get the cache key for when a user reads a thread.
     *
     * @param  Thread $thread
     * @return string
     */
    public function visitedThreadCacheKey($thread)
    {
        return sprintf("users.%s.visits.%s", $this->id, $thread->id);
    }

    public function getAvatarPathAttribute($avatar)
    {
        if ($avatar) {
            return env('APP_URL') . '/storage/' . $avatar;
        } else {
            return env('APP_URL') . '/images/avatars/default.png';
        }
    }
}
