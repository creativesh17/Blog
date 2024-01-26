<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Post;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PostController extends Controller {
    public function index() {
        $posts = Post::latest()->approved()->status()->paginate(6);
        return view('all-posts', compact('posts'));
    }

    public function details($slug) {
        $post = Post::where('post_slug',$slug)->approved()->status()->firstOrFail();
        $randomPosts = Post::approved()->status()->take(3)->inRandomOrder()->get();

        $blogKey = "blog_". $post->post_id;

        if(!Session::has($blogKey)) {
            $post->increment('view_count');
            Session::put($blogKey, 1);
        }
        return view('post', compact('post', 'randomPosts'));
    }

    public function postByCategory($slug) {
        $category = Category::where('cate_slug', $slug)->first();
        $posts = $category->posts()->approved()->status()->get();
        return view('category-posts', compact('category', 'posts'));
    }

    public function postByTag($slug) {
        $tag = Tag::where('tag_slug', $slug)->first();
        $posts = $tag->posts()->approved()->status()->get();
        return view('tag-posts', compact('tag', 'posts'));
    }
}
