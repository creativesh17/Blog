<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AuthorController extends Controller {
    public function profile($username) {
        $author = User::where('username', $username)->firstOrFail();
        $posts = $author->posts()->approved()->status()->get();
        return view('profile', compact('author', 'posts'));
    }
}
