<?php

namespace App\Http\Controllers\Admin;

use App\Tag;
use App\Post;
use App\User;
use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller {
    public function index() {
        $posts = Post::all();
        $popular_posts = Post::withCount('comments')
                             ->withCount('favorite_to_users')
                             ->orderBy('view_count', 'DESC')
                             ->orderBy('comments_count', 'DESC')
                             ->orderBy('favorite_to_users_count', 'DESC')
                             ->take(5)->get();

        $total_pending_posts = Post::where('post_approved', 0)->count();
        $all_views = Post::sum('view_count');
        $author_count = User::where('role_id', 2)->count();
        $new_authors_today = User::where('role_id', 2)
                                 ->whereDate('created_at', Carbon::today())->count();

        $active_authors = User::where('role_id', 2)
                              ->withCount('posts')
                              ->withCount('comments')
                              ->withCount('favorite_posts')
                              ->orderBy('posts_count', 'DESC')
                              ->orderBy('comments_count', 'DESC')
                              ->orderBy('favorite_posts_count', 'DESC')
                              ->take(10)->get();

        $category_count = Category::all()->count();
        $tag_count = Tag::all()->count();

        return view('admin.dashboard.dashboard', compact('posts', 'popular_posts', 'total_pending_posts', 'all_views', 'author_count', 'new_authors_today', 'active_authors', 'category_count', 'tag_count'));
    }

    public function access() {
        echo "You have no permission to visit the page!";
    }
}
