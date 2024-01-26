<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id', 'name', 'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role() {
        return $this->belongsTo('App\UserRole', 'role_id', 'role_id');
    }

    public function posts() {
        return $this->hasMany('App\Post');
    }

    public function favorite_posts() {
        return $this->belongsToMany('App\Post', 'post_user', 'user_id', 'post_id')->withTimestamps();
    }
   
    public function comments() {
        return $this->hasMany('App\User', 'id', 'id');
    }

    public function scopeAuthors($query) {
        return $query->where('role_id', 2);
    }
}
