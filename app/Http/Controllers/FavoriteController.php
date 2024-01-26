<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FavoriteController extends Controller {
    public function add($post) {
        $user = Auth::user();
        $isFavorite = $user->favorite_posts->where('post_id',$post)->count();

        if($isFavorite == 0) {
            $user->favorite_posts()->attach($post);
            Session::flash('success', 'Post successfully added to your favorite list.');
            return back();      
        }else {
            $user->favorite_posts()->detach($post);
            Session::flash('success', 'Post successfully removed from your favorite list.');
            return back();
        }
    }
}
