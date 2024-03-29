<?php

namespace App\Http\Controllers\Author;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CommentsController extends Controller {
    public function index() {
        $posts = Auth::user()->posts;
        return view('author.comments', compact('posts'));
    }

    public function delete($id) {
        // Comment::findOrFail($id);
        $comment = Comment::findOrFail($id);
        if($comment->post->author->id == Auth::id()) {
            $comment->delete();
            Session::flash('success', 'Comment Successfully Deleted!');
            return redirect()->back();

        }else {
            Session::flash('error', 'You are not authorized to delete this!');
            return redirect()->back();
        }
    }
}
