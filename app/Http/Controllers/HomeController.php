<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $categories = Category::where('cate_status', 1)->get();
        $posts = Post::with('author', 'categories', 'favorite_to_users')->approved()->status()->take(6)->get();
        return view('website.home', compact('categories', 'posts'));
    }
}
