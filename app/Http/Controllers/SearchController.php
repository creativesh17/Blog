<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class SearchController extends Controller {
    public function search(Request $request) {
        $search = $request->search;
        $posts = Post::where('post_title', 'LIKE', "%$search%")->approved()->status()->get();
        return view('search', compact('posts', 'search'));
    }
}
