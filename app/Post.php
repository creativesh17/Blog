<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {
    protected $primaryKey = 'post_id';

    public function author() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    public function categories() {
        return $this->belongsToMany('App\Category', 'category_post', 'post_id', 'cate_id')->withTimestamps();
    }

    public function tags() {
        return $this->belongsToMany('App\Tag', 'post_tag', 'post_id', 'tag_id')->withTimestamps();
    }

    public function favorite_to_users() {
        return $this->belongsToMany('App\User', 'post_user', 'post_id', 'user_id')->withTimestamps();
    }

    public function comments() {
        return $this->hasMany('App\comment', 'post_id', 'post_id');
    }

    public function scopeApproved($query) {
        return $query->where('post_approved', 1);
    }

    public function scopeStatus($query) {
        return $query->where('post_status', 1);
    }
}
